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

    public function create()
    {
        $products = Product::where('status', 'available')->with('supplier')->get();
        return view('orders.create', compact('products'));
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
        
        $subtotal = $product->price_per_box * $request->quantity;
        $delivery_fee = 0; // يمكن تعديل هذا حسب منطق التوصيل
        $commission = 0; // يمكن تعديل هذا حسب منطق العمولة
        $total_amount = $subtotal + $delivery_fee + $commission;
        
        $order = Order::create([
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'customer_id' => $user->id,
            'product_id' => $request->product_id,
            'supplier_id' => $product->supplier_id,
            'quantity' => $request->quantity,
            'unit_price' => $product->price_per_box,
            'subtotal' => $subtotal,
            'delivery_fee' => $delivery_fee,
            'commission' => $commission,
            'total_amount' => $total_amount,
            'delivery_address' => $request->delivery_address,
            'delivery_city' => $user->city ?? 'مكة المكرمة',
            'customer_phone' => $user->phone,
            'customer_name' => $user->name,
            'notes' => $request->delivery_notes,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'تم إنشاء الطلب بنجاح!');
    }

    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->customer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بعرض هذا الطلب.');
        }

        $order->load(['product', 'supplier', 'deliveryMan']);
        
        return view('orders.show', compact('order'));
    }

    public function track(Order $order)
    {
        // Ensure user can only track their own orders
        if ($order->customer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بتتبع هذا الطلب.');
        }

        $order->load(['product', 'supplier', 'deliveryMan']);
        
        return view('orders.track', compact('order'));
    }
}
