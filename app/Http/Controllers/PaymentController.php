<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profit;
use App\Models\ProfitDistribution;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function showPaymentForm(Order $order)
    {
        // التأكد من أن المستخدم يملك الطلب
        if ($order->customer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بعرض هذا الطلب.');
        }

        $order->load(['product', 'supplier']);
        
        return view('payments.show', compact('order'));
    }

    public function showNewOrderPayment(Order $order)
    {
        // التأكد من أن المستخدم يملك الطلب
        if ($order->customer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بعرض هذا الطلب.');
        }

        // التأكد من أن الطلب في حالة انتظار الدفع
        if ($order->status !== 'pending_payment') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'هذا الطلب لا يحتاج إلى دفع.');
        }

        $order->load(['product', 'supplier']);
        
        return view('payments.new-order', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        // التأكد من أن المستخدم يملك الطلب
        if ($order->customer_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بعرض هذا الطلب.');
        }

        $request->validate([
            'payment_method' => 'required|in:visa,bank_transfer,cash',
            'transaction_id' => 'nullable|string|max:100',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

        // إنشاء أو تحديث الدفع
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $request->payment_method,
                'amount' => $order->total_amount,
                'status' => 'pending', // جميع طرق الدفع تتطلب تأكيد الإدارة
                'transaction_id' => $request->transaction_id,
                'notes' => $request->notes,
                'paid_at' => null, // سيتم تحديثه عند التأكيد
            ]
        );

        // رفع صورة الإيصال إذا تم توفيرها
        if ($request->hasFile('receipt_image')) {
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $payment->update(['receipt_image' => $path]);
        }

        // إذا كان الطلب في حالة انتظار الدفع، قم بتحديث حالته
        if ($order->status === 'pending_payment') {
            $order->update([
                'status' => 'pending',
                'payment_status' => 'paid', // تم الدفع لكن في انتظار التأكيد
                'payment_method' => $request->payment_method,
            ]);
            
            $message = 'تم إتمام الدفع بنجاح! الطلب في انتظار تأكيد الإدارة.';
            if ($request->payment_method === 'bank_transfer') {
                $message .= ' يرجى إرفاق إيصال التحويل البنكي.';
            }
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', $message);
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'تم تسجيل الدفع بنجاح! في انتظار تأكيد الإدارة.');
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        // التأكد من أن المستخدم إداري
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بتأكيد الدفع.');
        }

        $request->validate([
            'status' => 'required|in:verified,failed',
            'notes' => 'nullable|string|max:1000',
        ]);

        $payment->update([
            'status' => $request->status,
            'verified_at' => $request->status === 'verified' ? now() : null,
            'verified_by' => Auth::id(),
            'notes' => $request->notes,
            'paid_at' => $request->status === 'verified' ? now() : null,
        ]);

        // تحديث حالة الطلب بناءً على نتيجة التأكيد
        if ($request->status === 'verified') {
            // إذا تم التأكيد، قم بإنشاء سجل الربح وتحديث حالة الطلب
            $this->createProfitRecord($payment->order);
            
            // تحديث حالة الطلب إلى مؤكد
            $payment->order->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);
            
            $message = 'تم تأكيد الدفع بنجاح! تم تحديث حالة الطلب إلى مؤكد.';
        } else {
            // إذا تم الرفض، قم بتحديث حالة الطلب
            $payment->order->update([
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);
            
            $message = 'تم رفض الدفع. تم إعادة الطلب إلى حالة الانتظار.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function showReceipt(Payment $payment)
    {
        if (!$payment->receipt_image) {
            abort(404, 'لا يوجد إيصال لهذا الدفع.');
        }

        return response()->file(storage_path('app/public/' . $payment->receipt_image));
    }

    public function distributeProfits()
    {
        // التأكد من أن المستخدم إداري
        if (Auth::user()->role !== 'admin') {
            abort(403, 'غير مصرح لك بتوزيع الأرباح.');
        }

        $pendingProfits = Profit::where('status', 'pending')->get();

        foreach ($pendingProfits as $profit) {
            $this->distributeProfit($profit);
        }

        return redirect()->back()->with('success', 'تم توزيع الأرباح بنجاح!');
    }

    private function createProfitRecord(Order $order)
    {
        // حساب الأرباح والعمولات
        $supplierPrice = $order->product->price_per_box * $order->quantity;
        $profitMargin = Profit::calculateProfitMargin($supplierPrice);
        $customerPrice = $order->total_amount;
        $adminCommission = Profit::calculateAdminCommission($profitMargin);
        $deliveryCommission = Profit::calculateDeliveryCommission($profitMargin);

        // إنشاء سجل الربح
        Profit::create([
            'order_id' => $order->id,
            'supplier_price' => $supplierPrice,
            'customer_price' => $customerPrice,
            'profit_margin' => $profitMargin,
            'admin_commission' => $adminCommission,
            'delivery_commission' => $deliveryCommission,
            'status' => 'pending',
        ]);
    }

    private function distributeProfit(Profit $profit)
    {
        // الحصول على الإداريين ومندوبي التوصيل
        $admins = User::where('role', 'admin')->get();
        $deliveryMen = User::where('role', 'delivery')->get();

        // توزيع عمولة الإدارة
        if ($admins->count() > 0) {
            $adminShare = $profit->admin_commission / $admins->count();
            foreach ($admins as $admin) {
                $bankAccount = $admin->bankAccounts()->where('is_active', true)->first();
                
                ProfitDistribution::create([
                    'profit_id' => $profit->id,
                    'user_id' => $admin->id,
                    'user_type' => 'admin',
                    'amount' => $adminShare,
                    'bank_account_id' => $bankAccount ? $bankAccount->id : null,
                    'status' => 'pending',
                ]);
            }
        }

        // توزيع عمولة التوصيل (إذا كان هناك مندوب توصيل معين)
        if ($profit->order->delivery_man_id) {
            $deliveryMan = User::find($profit->order->delivery_man_id);
            if ($deliveryMan) {
                $bankAccount = $deliveryMan->bankAccounts()->where('is_active', true)->first();
                
                ProfitDistribution::create([
                    'profit_id' => $profit->id,
                    'user_id' => $deliveryMan->id,
                    'user_type' => 'delivery_man',
                    'amount' => $profit->delivery_commission,
                    'bank_account_id' => $bankAccount ? $bankAccount->id : null,
                    'status' => 'pending',
                ]);
            }
        }

        // تحديث حالة الربح
        $profit->update([
            'status' => 'distributed',
            'distributed_at' => now(),
        ]);
    }
} 