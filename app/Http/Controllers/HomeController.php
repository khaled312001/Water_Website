<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->with('supplier')
            ->take(6)
            ->get();

        $topSuppliers = Supplier::where('status', 'active')
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        $stats = [
            'total_products' => Product::where('status', 'available')->count(),
            'total_suppliers' => Supplier::where('status', 'active')->count(),
            'total_orders' => Order::where('status', 'delivered')->count(),
        ];

        return view('home', compact('featuredProducts', 'topSuppliers', 'stats'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|in:' . implode(',', array_keys(Contact::getSubjectOptions())),
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'رقم الهاتف مطلوب',
            'subject.required' => 'الموضوع مطلوب',
            'subject.in' => 'الموضوع غير صحيح',
            'message.required' => 'الرسالة مطلوبة',
            'message.max' => 'الرسالة طويلة جداً (الحد الأقصى 2000 حرف)',
        ]);

        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
            ]);

            return back()->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.');
        }
    }

    public function customerDashboard()
    {
        $user = auth()->user();
        
        $stats = [
            'total_orders' => Order::where('customer_id', $user->id)->count(),
            'completed_orders' => Order::where('customer_id', $user->id)->where('status', 'delivered')->count(),
            'pending_orders' => Order::where('customer_id', $user->id)->whereIn('status', ['pending', 'processing', 'shipped'])->count(),
            'total_spent' => Order::where('customer_id', $user->id)->where('status', 'delivered')->sum('total_amount'),
            'recent_orders' => Order::where('customer_id', $user->id)->whereMonth('created_at', now()->month)->count(),
            'completion_rate' => Order::where('customer_id', $user->id)->count() > 0 
                ? round((Order::where('customer_id', $user->id)->where('status', 'delivered')->count() / Order::where('customer_id', $user->id)->count()) * 100, 1)
                : 0,
        ];

        $recentOrders = Order::where('customer_id', $user->id)
            ->with(['product', 'supplier'])
            ->latest()
            ->take(5)
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->with('supplier')
            ->take(4)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders', 'featuredProducts'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::where('status', 'active')
            ->with('user')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('suppliers', compact('suppliers'));
    }

    public function supplierDetails($id)
    {
        $supplier = Supplier::with(['user', 'products' => function($query) {
            $query->where('status', 'available')->where('stock_quantity', '>', 0);
        }])->findOrFail($id);

        return view('supplier-details', compact('supplier'));
    }
}
