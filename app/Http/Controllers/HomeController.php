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

    // Export Methods for Customer Dashboard
    public function exportCustomerDashboard()
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
            ->take(10)
            ->get();

        $allOrders = Order::where('customer_id', $user->id)
            ->with(['product', 'supplier', 'deliveryMan'])
            ->latest()
            ->get();

        $filename = 'customer_dashboard_' . $user->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($stats, $recentOrders, $allOrders, $user) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Customer Information
            fputcsv($file, ['معلومات العميل']);
            fputcsv($file, ['الاسم', $user->name]);
            fputcsv($file, ['البريد الإلكتروني', $user->email]);
            fputcsv($file, ['رقم الهاتف', $user->phone ?? 'غير محدد']);
            fputcsv($file, ['العنوان', $user->address ?? 'غير محدد']);
            fputcsv($file, ['المدينة', $user->city ?? 'غير محدد']);
            fputcsv($file, ['تاريخ التسجيل', $user->created_at->format('Y-m-d')]);
            fputcsv($file, []); // Empty row
            
            // Dashboard Statistics
            fputcsv($file, ['إحصائيات لوحة التحكم']);
            fputcsv($file, ['إجمالي الطلبات', $stats['total_orders']]);
            fputcsv($file, ['الطلبات المكتملة', $stats['completed_orders']]);
            fputcsv($file, ['الطلبات قيد الانتظار', $stats['pending_orders']]);
            fputcsv($file, ['إجمالي الإنفاق', $stats['total_spent']]);
            fputcsv($file, ['الطلبات هذا الشهر', $stats['recent_orders']]);
            fputcsv($file, ['معدل الإنجاز', $stats['completion_rate'] . '%']);
            fputcsv($file, []); // Empty row
            
            // Recent Orders
            fputcsv($file, ['الطلبات الحديثة']);
            fputcsv($file, ['رقم الطلب', 'اسم المنتج', 'اسم المورد', 'الكمية', 'المبلغ الإجمالي', 'الحالة', 'تاريخ الطلب']);
            
            foreach ($recentOrders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->product->name ?? 'غير محدد',
                    $order->supplier->user->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // All Orders
            fputcsv($file, ['جميع الطلبات']);
            fputcsv($file, ['رقم الطلب', 'اسم المنتج', 'اسم المورد', 'مندوب التوصيل', 'الكمية', 'المبلغ الإجمالي', 'رسوم التوصيل', 'عنوان التوصيل', 'الحالة', 'تاريخ الطلب', 'وقت التوصيل الفعلي']);
            
            foreach ($allOrders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->product->name ?? 'غير محدد',
                    $order->supplier->user->name ?? 'غير محدد',
                    $order->deliveryMan->user->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->delivery_fee ?? 0,
                    $order->delivery_address ?? 'غير محدد',
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->actual_delivery_time ? $order->actual_delivery_time->format('Y-m-d H:i:s') : 'لم يتم التوصيل'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCustomerOrders()
    {
        $user = auth()->user();
        
        $orders = Order::where('customer_id', $user->id)
            ->with(['product', 'supplier', 'deliveryMan'])
            ->latest()
            ->get();

        $filename = 'customer_orders_' . $user->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'رقم الطلب',
                'اسم المنتج',
                'العلامة التجارية',
                'الحجم',
                'اسم المورد',
                'مندوب التوصيل',
                'الكمية',
                'المبلغ الإجمالي',
                'رسوم التوصيل',
                'عنوان التوصيل',
                'حالة الطلب',
                'تاريخ الطلب',
                'وقت التوصيل الفعلي'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->product->name ?? 'غير محدد',
                    $order->product->brand ?? 'غير محدد',
                    $order->product->size ?? 'غير محدد',
                    $order->supplier->user->name ?? 'غير محدد',
                    $order->deliveryMan->user->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->delivery_fee ?? 0,
                    $order->delivery_address ?? 'غير محدد',
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->actual_delivery_time ? $order->actual_delivery_time->format('Y-m-d H:i:s') : 'لم يتم التوصيل'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCustomerProfile()
    {
        $user = auth()->user();

        $filename = 'customer_profile_' . $user->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($user) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Personal Information
            fputcsv($file, ['المعلومات الشخصية']);
            fputcsv($file, ['الاسم الكامل', $user->name]);
            fputcsv($file, ['البريد الإلكتروني', $user->email]);
            fputcsv($file, ['رقم الهاتف', $user->phone ?? 'غير محدد']);
            fputcsv($file, ['العنوان', $user->address ?? 'غير محدد']);
            fputcsv($file, ['المدينة', $user->city ?? 'غير محدد']);
            fputcsv($file, ['تاريخ التسجيل', $user->created_at->format('Y-m-d')]);
            fputcsv($file, ['آخر تسجيل دخول', $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'لم يسجل دخول']);
            fputcsv($file, []); // Empty row
            
            // Order Statistics
            fputcsv($file, ['إحصائيات الطلبات']);
            fputcsv($file, ['إجمالي الطلبات', Order::where('customer_id', $user->id)->count()]);
            fputcsv($file, ['الطلبات المكتملة', Order::where('customer_id', $user->id)->where('status', 'delivered')->count()]);
            fputcsv($file, ['الطلبات قيد الانتظار', Order::where('customer_id', $user->id)->whereIn('status', ['pending', 'processing', 'shipped'])->count()]);
            fputcsv($file, ['إجمالي الإنفاق', Order::where('customer_id', $user->id)->where('status', 'delivered')->sum('total_amount')]);
            fputcsv($file, ['متوسط قيمة الطلب', Order::where('customer_id', $user->id)->where('status', 'delivered')->avg('total_amount') ?? 0]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
