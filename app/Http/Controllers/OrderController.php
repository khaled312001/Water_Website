<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['product', 'supplier'])->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $products = Product::where('status', 'available')->with('supplier')->get();
        $selectedProductId = $request->query('product_id');
        return view('orders.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string|max:500',
            'delivery_notes' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();
        
        // التأكد من أن المستخدم مسجل دخول
        if (!$user) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول لإنشاء طلب.');
        }
        
        // حساب السعر مع هامش الربح 20%
        $supplier_price = $product->price_per_box * $request->quantity;
        $profit_margin = $supplier_price * 0.20; // 20% هامش ربح
        $customer_price = $supplier_price + $profit_margin;
        
        $delivery_fee = 0; // يمكن تعديل هذا حسب منطق التوصيل
        $total_amount = $customer_price + $delivery_fee;
        
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'customer_id' => $user->id,
            'product_id' => $request->product_id,
            'supplier_id' => $product->supplier_id,
            'quantity' => $request->quantity,
            'unit_price' => $product->price_per_box,
            'subtotal' => $customer_price,
            'delivery_fee' => $delivery_fee,
            'commission' => $profit_margin,
            'total_amount' => $total_amount,
            'delivery_address' => $request->delivery_address,
            'delivery_city' => $user->city ?? 'مكة المكرمة',
            'customer_phone' => $user->phone,
            'customer_name' => $user->name,
            'notes' => $request->delivery_notes,
            'status' => 'pending_payment', // حالة جديدة: في انتظار الدفع
            'payment_status' => 'pending',
            'payment_method' => null, // سيتم تحديده عند الدفع
        ]);

        // توجيه المستخدم إلى صفحة الدفع بدلاً من صفحة الطلب
        return redirect()->route('payments.new-order', $order->id)
            ->with('info', 'تم إنشاء الطلب بنجاح! يرجى إتمام عملية الدفع لتأكيد الطلب. رقم الطلب: ' . $order->order_number);
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        
        // Ensure user can only view their own orders or is admin
        if ($order->customer_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'غير مصرح لك بعرض هذا الطلب. هذا الطلب يخص مستخدم آخر.');
        }

        $order->load(['product', 'supplier', 'deliveryMan']);
        
        return view('orders.show', compact('order'));
    }

    public function track(Order $order)
    {
        $user = Auth::user();
        
        // Ensure user can only track their own orders or is admin
        if ($order->customer_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'غير مصرح لك بتتبع هذا الطلب.');
        }

        $order->load(['product', 'supplier', 'deliveryMan']);
        
        return view('orders.track', compact('order'));
    }
}
