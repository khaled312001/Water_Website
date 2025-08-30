<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\DeliveryMan;
use App\Models\Review;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_suppliers' => Supplier::count(),
            'total_delivery_men' => DeliveryMan::count(),
            'total_reviews' => Review::count(),
            'total_revenue' => Order::sum('total_amount'),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'new_orders_today' => Order::whereDate('created_at', today())->count(),
            'active_suppliers' => Supplier::where('status', 'active')->count(),
            'revenue_this_month' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
        ];

        $recentOrders = Order::with(['customer', 'product'])->latest()->take(5)->get();
        $notifications = collect([]); // Empty collection for now

        return view('admin.dashboard', compact('stats', 'recentOrders', 'notifications'));
    }

    // Users Management
    public function users(Request $request)
    {
        $query = User::with(['supplier', 'deliveryMan']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $users = $query->paginate(15)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:admin,customer,supplier,delivery',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function showUser($id)
    {
        $user = User::with(['supplier', 'deliveryMan', 'orders', 'reviews'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'role' => 'required|in:admin,customer,supplier,delivery',
            'is_active' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح');
    }

    // Suppliers Management
    public function suppliers(Request $request)
    {
        $query = Supplier::with('user');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $suppliers = $query->paginate(15)->withQueryString();
        return view('admin.suppliers', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('admin.suppliers.create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'commercial_license' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('admin.suppliers')->with('success', 'تم إنشاء المورد بنجاح');
    }

    public function showSupplier($id)
    {
        $supplier = Supplier::with(['user', 'products', 'orders'])->findOrFail($id);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::with('user')->findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $request->validate([
            'company_name' => 'required|string|max:255',
            'commercial_license' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,pending,inactive',
        ]);

        $supplier->update($request->all());
        return redirect()->route('admin.suppliers')->with('success', 'تم تحديث المورد بنجاح');
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.suppliers')->with('success', 'تم حذف المورد بنجاح');
    }

    // Delivery Men Management
    public function deliveryMen(Request $request)
    {
        $query = DeliveryMan::with('user');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('vehicle_type', 'like', "%{$search}%")
                  ->orWhere('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('emergency_contact', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $deliveryMen = $query->paginate(15)->withQueryString();
        return view('admin.delivery-men', compact('deliveryMen'));
    }

    public function createDeliveryMan()
    {
        return view('admin.delivery-men.create');
    }

    public function storeDeliveryMan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'national_id' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:100',
            'vehicle_number' => 'required|string|max:100',
            'license_number' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
        ]);

        DeliveryMan::create($request->all());
        return redirect()->route('admin.delivery-men')->with('success', 'تم إنشاء مندوب التوصيل بنجاح');
    }

    public function showDeliveryMan($id)
    {
        $deliveryMan = DeliveryMan::with(['user', 'orders'])->findOrFail($id);
        return view('admin.delivery-men.show', compact('deliveryMan'));
    }

    public function editDeliveryMan($id)
    {
        $deliveryMan = DeliveryMan::with('user')->findOrFail($id);
        return view('admin.delivery-men.edit', compact('deliveryMan'));
    }

    public function updateDeliveryMan(Request $request, $id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);
        
        $request->validate([
            'national_id' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:100',
            'vehicle_number' => 'required|string|max:100',
            'license_number' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'status' => 'required|in:available,busy,offline',
        ]);

        $deliveryMan->update($request->all());
        return redirect()->route('admin.delivery-men')->with('success', 'تم تحديث مندوب التوصيل بنجاح');
    }

    public function deleteDeliveryMan($id)
    {
        $deliveryMan = DeliveryMan::findOrFail($id);
        $deliveryMan->delete();
        return redirect()->route('admin.delivery-men')->with('success', 'تم حذف مندوب التوصيل بنجاح');
    }

    // Orders Management
    public function orders(Request $request)
    {
        $query = Order::with(['customer', 'supplier', 'deliveryMan']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('delivery_address', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['customer', 'supplier', 'deliveryMan', 'product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function editOrder($id)
    {
        $order = Order::with(['customer', 'supplier', 'deliveryMan', 'product'])->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,assigned,picked_up,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->all());
        return redirect()->route('admin.orders')->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'تم حذف الطلب بنجاح');
    }

    // Products Management
    public function products(Request $request)
    {
        $query = Product::with('supplier');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by supplier
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $products = $query->paginate(15)->withQueryString();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('suppliers'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'is_active' => 'boolean',
        ]);

        Product::create($request->all());
        return redirect()->route('admin.products')->with('success', 'تم إنشاء المنتج بنجاح');
    }

    public function showProduct($id)
    {
        $product = Product::with(['supplier', 'reviews'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product', 'suppliers'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'is_active' => 'boolean',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.products')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'تم حذف المنتج بنجاح');
    }

    // Reviews Management
    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%");
            });
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        $reviews = $query->paginate(15)->withQueryString();
        return view('admin.reviews', compact('reviews'));
    }

    public function showReview($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function editReview($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.reviews.edit', compact('review'));
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->all());
        return redirect()->route('admin.reviews')->with('success', 'تم تحديث التقييم بنجاح');
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews')->with('success', 'تم حذف التقييم بنجاح');
    }

    public function reports()
    {
        // Basic reporting functionality
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $topProducts = Product::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('monthlyOrders', 'topProducts'));
    }

    // Supplier dashboard methods
    public function supplierDashboard()
    {
        try {
            $supplier = auth()->user()->supplier;
            
            if (!$supplier) {
                return response('Supplier not found', 404);
            }
            
            $stats = [
                'total_products' => Product::where('supplier_id', $supplier->id)->count(),
                'total_orders' => Order::where('supplier_id', $supplier->id)->count(),
                'total_earnings' => Order::where('supplier_id', $supplier->id)->sum('total_amount'),
                'new_orders' => Order::where('supplier_id', $supplier->id)->where('status', 'pending')->count(),
                'completed_orders' => Order::where('supplier_id', $supplier->id)->where('status', 'delivered')->count(),
                'active_products' => Product::where('supplier_id', $supplier->id)->where('status', 'available')->count(),
            ];

            $recentOrders = Order::where('supplier_id', $supplier->id)
                ->with(['customer', 'product'])
                ->latest()
                ->take(5)
                ->get();

            return view('supplier.dashboard', compact('stats', 'recentOrders'));
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }

    public function supplierProducts()
    {
        $supplier = auth()->user()->supplier;
        $products = Product::where('supplier_id', $supplier->id)->paginate(15);
        return view('supplier.products', compact('products'));
    }

    public function supplierOrders()
    {
        $supplier = auth()->user()->supplier;
        $orders = Order::where('supplier_id', $supplier->id)
            ->with(['customer', 'deliveryMan'])
            ->paginate(15);
        return view('supplier.orders', compact('orders'));
    }

    public function supplierEarnings()
    {
        $supplier = auth()->user()->supplier;
        $earnings = Order::where('supplier_id', $supplier->id)
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as daily_earnings')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(30);

        return view('supplier.earnings', compact('earnings'));
    }

    // Supplier Product Management Methods
    public function supplierCreateProduct()
    {
        return view('supplier.products.create');
    }

    public function supplierStoreProduct(Request $request)
    {
        $supplier = auth()->user()->supplier;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'quantity_per_box' => 'required|integer|min:1',
            'price_per_box' => 'required|numeric|min:0',
            'price_per_bottle' => 'required|numeric|min:0',
            'type' => 'required|in:mineral,distilled,spring,alkaline',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['supplier_id'] = $supplier->id;
        $data['status'] = 'available';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('supplier.products')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function supplierShowProduct($id)
    {
        $supplier = auth()->user()->supplier;
        $product = Product::where('supplier_id', $supplier->id)->findOrFail($id);
        
        return view('supplier.products.show', compact('product'));
    }

    public function supplierEditProduct($id)
    {
        $supplier = auth()->user()->supplier;
        $product = Product::where('supplier_id', $supplier->id)->findOrFail($id);
        
        return view('supplier.products.edit', compact('product'));
    }

    public function supplierUpdateProduct(Request $request, $id)
    {
        $supplier = auth()->user()->supplier;
        $product = Product::where('supplier_id', $supplier->id)->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'quantity_per_box' => 'required|integer|min:1',
            'price_per_box' => 'required|numeric|min:0',
            'price_per_bottle' => 'required|numeric|min:0',
            'type' => 'required|in:mineral,distilled,spring,alkaline',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('supplier.products')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function supplierDeleteProduct($id)
    {
        $supplier = auth()->user()->supplier;
        $product = Product::where('supplier_id', $supplier->id)->findOrFail($id);
        
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('supplier.products')->with('success', 'تم حذف المنتج بنجاح');
    }

    // Export Methods for Admin Dashboard
    public function exportDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_suppliers' => Supplier::count(),
            'total_delivery_men' => DeliveryMan::count(),
            'total_reviews' => Review::count(),
            'total_revenue' => Order::sum('total_amount'),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'new_orders_today' => Order::whereDate('created_at', today())->count(),
            'active_suppliers' => Supplier::where('status', 'active')->count(),
            'revenue_this_month' => Order::whereMonth('created_at', now()->month)->sum('total_amount'),
        ];

        $recentOrders = Order::with(['customer', 'product'])->latest()->take(10)->get();
        $recentUsers = User::latest()->take(10)->get();
        $recentSuppliers = Supplier::with('user')->latest()->take(10)->get();

        $filename = 'admin_dashboard_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($stats, $recentOrders, $recentUsers, $recentSuppliers) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Dashboard Statistics
            fputcsv($file, ['إحصائيات لوحة التحكم']);
            fputcsv($file, ['إجمالي المستخدمين', $stats['total_users']]);
            fputcsv($file, ['إجمالي الطلبات', $stats['total_orders']]);
            fputcsv($file, ['إجمالي المنتجات', $stats['total_products']]);
            fputcsv($file, ['إجمالي الموردين', $stats['total_suppliers']]);
            fputcsv($file, ['إجمالي مندوبي التوصيل', $stats['total_delivery_men']]);
            fputcsv($file, ['إجمالي التقييمات', $stats['total_reviews']]);
            fputcsv($file, ['إجمالي الإيرادات', $stats['total_revenue']]);
            fputcsv($file, ['المستخدمين الجدد هذا الشهر', $stats['new_users_this_month']]);
            fputcsv($file, ['الطلبات الجديدة اليوم', $stats['new_orders_today']]);
            fputcsv($file, ['الموردين النشطين', $stats['active_suppliers']]);
            fputcsv($file, ['الإيرادات هذا الشهر', $stats['revenue_this_month']]);
            fputcsv($file, []); // Empty row
            
            // Recent Orders
            fputcsv($file, ['الطلبات الحديثة']);
            fputcsv($file, ['رقم الطلب', 'اسم العميل', 'اسم المنتج', 'الكمية', 'المبلغ الإجمالي', 'الحالة', 'تاريخ الطلب']);
            
            foreach ($recentOrders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->customer->name ?? 'غير محدد',
                    $order->product->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Recent Users
            fputcsv($file, ['المستخدمين الجدد']);
            fputcsv($file, ['الاسم', 'البريد الإلكتروني', 'رقم الهاتف', 'الدور', 'تاريخ التسجيل']);
            
            foreach ($recentUsers as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->phone ?? 'غير محدد',
                    $user->role,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Recent Suppliers
            fputcsv($file, ['الموردين الجدد']);
            fputcsv($file, ['اسم المورد', 'البريد الإلكتروني', 'رقم الهاتف', 'الحالة', 'تاريخ التسجيل']);
            
            foreach ($recentSuppliers as $supplier) {
                fputcsv($file, [
                    $supplier->user->name ?? 'غير محدد',
                    $supplier->user->email ?? 'غير محدد',
                    $supplier->user->phone ?? 'غير محدد',
                    $supplier->status ?? 'غير محدد',
                    $supplier->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportUsers()
    {
        $users = User::with(['supplier', 'deliveryMan'])->get();

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'الاسم',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'الدور',
                'العنوان',
                'المدينة',
                'الحالة',
                'تاريخ التسجيل',
                'آخر تسجيل دخول'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->phone ?? 'غير محدد',
                    $user->role,
                    $user->address ?? 'غير محدد',
                    $user->city ?? 'غير محدد',
                    $user->is_active ? 'نشط' : 'غير نشط',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'لم يسجل دخول'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportOrders()
    {
        $orders = Order::with(['customer', 'product', 'supplier', 'deliveryMan'])->get();

        $filename = 'orders_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'اسم العميل',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'اسم المنتج',
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
                    $order->customer->name ?? 'غير محدد',
                    $order->customer->email ?? 'غير محدد',
                    $order->customer->phone ?? 'غير محدد',
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

    public function exportProducts()
    {
        $products = Product::with('supplier.user')->get();

        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'اسم المنتج',
                'الوصف',
                'العلامة التجارية',
                'الحجم',
                'الكمية في الصندوق',
                'السعر لكل صندوق',
                'السعر لكل زجاجة',
                'النوع',
                'الكمية المتوفرة',
                'اسم المورد',
                'الحالة',
                'تاريخ الإضافة'
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->description,
                    $product->brand,
                    $product->size,
                    $product->quantity_per_box,
                    $product->price_per_box,
                    $product->price_per_bottle,
                    $product->type,
                    $product->stock_quantity,
                    $product->supplier->user->name ?? 'غير محدد',
                    $product->status,
                    $product->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSuppliers()
    {
        $suppliers = Supplier::with('user')->get();

        $filename = 'suppliers_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($suppliers) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'اسم المورد',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'العنوان',
                'المدينة',
                'الرقم الوطني',
                'رقم السجل التجاري',
                'الحالة',
                'التقييم',
                'عدد المنتجات',
                'تاريخ التسجيل'
            ]);

            foreach ($suppliers as $supplier) {
                fputcsv($file, [
                    $supplier->user->name ?? 'غير محدد',
                    $supplier->user->email ?? 'غير محدد',
                    $supplier->user->phone ?? 'غير محدد',
                    $supplier->user->address ?? 'غير محدد',
                    $supplier->user->city ?? 'غير محدد',
                    $supplier->national_id ?? 'غير محدد',
                    $supplier->commercial_record ?? 'غير محدد',
                    $supplier->status ?? 'غير محدد',
                    $supplier->rating ?? 'غير محدد',
                    $supplier->products_count ?? 0,
                    $supplier->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportDeliveryMen()
    {
        $deliveryMen = DeliveryMan::with('user')->get();

        $filename = 'delivery_men_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($deliveryMen) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'اسم مندوب التوصيل',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'الرقم الوطني',
                'نوع المركبة',
                'رقم المركبة',
                'رقم الرخصة',
                'جهة اتصال الطوارئ',
                'رقم الطوارئ',
                'الحالة',
                'التقييم',
                'إجمالي التوصيلات',
                'إجمالي الأرباح',
                'تاريخ التسجيل'
            ]);

            foreach ($deliveryMen as $deliveryMan) {
                fputcsv($file, [
                    $deliveryMan->user->name ?? 'غير محدد',
                    $deliveryMan->user->email ?? 'غير محدد',
                    $deliveryMan->user->phone ?? 'غير محدد',
                    $deliveryMan->national_id ?? 'غير محدد',
                    $deliveryMan->vehicle_type ?? 'غير محدد',
                    $deliveryMan->vehicle_number ?? 'غير محدد',
                    $deliveryMan->license_number ?? 'غير محدد',
                    $deliveryMan->emergency_contact ?? 'غير محدد',
                    $deliveryMan->emergency_phone ?? 'غير محدد',
                    $deliveryMan->status ?? 'غير محدد',
                    $deliveryMan->rating ?? 'غير محدد',
                    $deliveryMan->total_deliveries ?? 0,
                    $deliveryMan->total_earnings ?? 0,
                    $deliveryMan->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportReviews()
    {
        $reviews = Review::with(['user', 'product'])->get();

        $filename = 'reviews_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reviews) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'اسم المستخدم',
                'اسم المنتج',
                'التقييم',
                'التعليق',
                'الحالة',
                'تاريخ التقييم'
            ]);

            foreach ($reviews as $review) {
                fputcsv($file, [
                    $review->user->name ?? 'غير محدد',
                    $review->product->name ?? 'غير محدد',
                    $review->rating,
                    $review->comment ?? 'لا يوجد تعليق',
                    $review->status ?? 'غير محدد',
                    $review->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export Methods for Supplier Dashboard
    public function exportSupplierDashboard()
    {
        $supplier = auth()->user()->supplier;
        
        if (!$supplier) {
            return redirect()->back()->with('error', 'Supplier profile not found.');
        }

        $stats = [
            'total_products' => Product::where('supplier_id', $supplier->id)->count(),
            'total_orders' => Order::where('supplier_id', $supplier->id)->count(),
            'total_earnings' => Order::where('supplier_id', $supplier->id)->sum('total_amount'),
            'pending_orders' => Order::where('supplier_id', $supplier->id)->whereIn('status', ['pending', 'confirmed'])->count(),
            'completed_orders' => Order::where('supplier_id', $supplier->id)->where('status', 'delivered')->count(),
            'monthly_earnings' => Order::where('supplier_id', $supplier->id)->whereMonth('created_at', Carbon::now()->month)->sum('total_amount'),
        ];

        $recentOrders = Order::where('supplier_id', $supplier->id)
            ->with(['customer', 'product', 'deliveryMan'])
            ->latest()
            ->take(10)
            ->get();

        $products = Product::where('supplier_id', $supplier->id)->get();

        $filename = 'supplier_dashboard_' . $supplier->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($stats, $recentOrders, $products, $supplier) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Supplier Information
            fputcsv($file, ['معلومات المورد']);
            fputcsv($file, ['اسم المورد', auth()->user()->name]);
            fputcsv($file, ['البريد الإلكتروني', auth()->user()->email]);
            fputcsv($file, ['رقم الهاتف', auth()->user()->phone ?? 'غير محدد']);
            fputcsv($file, ['الرقم الوطني', $supplier->national_id ?? 'غير محدد']);
            fputcsv($file, ['رقم السجل التجاري', $supplier->commercial_record ?? 'غير محدد']);
            fputcsv($file, ['الحالة', $supplier->status ?? 'غير محدد']);
            fputcsv($file, []); // Empty row
            
            // Dashboard Statistics
            fputcsv($file, ['إحصائيات لوحة التحكم']);
            fputcsv($file, ['إجمالي المنتجات', $stats['total_products']]);
            fputcsv($file, ['إجمالي الطلبات', $stats['total_orders']]);
            fputcsv($file, ['إجمالي الأرباح', $stats['total_earnings']]);
            fputcsv($file, ['الطلبات قيد الانتظار', $stats['pending_orders']]);
            fputcsv($file, ['الطلبات المكتملة', $stats['completed_orders']]);
            fputcsv($file, ['أرباح هذا الشهر', $stats['monthly_earnings']]);
            fputcsv($file, []); // Empty row
            
            // Recent Orders
            fputcsv($file, ['الطلبات الحديثة']);
            fputcsv($file, ['رقم الطلب', 'اسم العميل', 'اسم المنتج', 'الكمية', 'المبلغ الإجمالي', 'مندوب التوصيل', 'الحالة', 'تاريخ الطلب']);
            
            foreach ($recentOrders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->customer->name ?? 'غير محدد',
                    $order->product->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->deliveryMan->user->name ?? 'غير محدد',
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Products
            fputcsv($file, ['المنتجات']);
            fputcsv($file, ['اسم المنتج', 'العلامة التجارية', 'الحجم', 'السعر لكل صندوق', 'السعر لكل زجاجة', 'الكمية المتوفرة', 'الحالة']);
            
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->brand,
                    $product->size,
                    $product->price_per_box,
                    $product->price_per_bottle,
                    $product->stock_quantity,
                    $product->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSupplierProducts()
    {
        $supplier = auth()->user()->supplier;
        
        if (!$supplier) {
            return redirect()->back()->with('error', 'Supplier profile not found.');
        }

        $products = Product::where('supplier_id', $supplier->id)->get();

        $filename = 'supplier_products_' . $supplier->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'اسم المنتج',
                'الوصف',
                'العلامة التجارية',
                'الحجم',
                'الكمية في الصندوق',
                'السعر لكل صندوق',
                'السعر لكل زجاجة',
                'النوع',
                'الكمية المتوفرة',
                'الحالة',
                'تاريخ الإضافة',
                'آخر تحديث'
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->description,
                    $product->brand,
                    $product->size,
                    $product->quantity_per_box,
                    $product->price_per_box,
                    $product->price_per_bottle,
                    $product->type,
                    $product->stock_quantity,
                    $product->status,
                    $product->created_at->format('Y-m-d H:i:s'),
                    $product->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSupplierOrders()
    {
        $supplier = auth()->user()->supplier;
        
        if (!$supplier) {
            return redirect()->back()->with('error', 'Supplier profile not found.');
        }

        $orders = Order::where('supplier_id', $supplier->id)
            ->with(['customer', 'product', 'deliveryMan'])
            ->get();

        $filename = 'supplier_orders_' . $supplier->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'اسم العميل',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'اسم المنتج',
                'الكمية',
                'المبلغ الإجمالي',
                'رسوم التوصيل',
                'عنوان التوصيل',
                'مندوب التوصيل',
                'حالة الطلب',
                'تاريخ الطلب',
                'وقت التوصيل الفعلي'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->customer->name ?? 'غير محدد',
                    $order->customer->email ?? 'غير محدد',
                    $order->customer->phone ?? 'غير محدد',
                    $order->product->name ?? 'غير محدد',
                    $order->quantity ?? 1,
                    $order->total_amount ?? 0,
                    $order->delivery_fee ?? 0,
                    $order->delivery_address ?? 'غير محدد',
                    $order->deliveryMan->user->name ?? 'غير محدد',
                    $order->status_text ?? $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->actual_delivery_time ? $order->actual_delivery_time->format('Y-m-d H:i:s') : 'لم يتم التوصيل'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSupplierEarnings()
    {
        $supplier = auth()->user()->supplier;
        
        if (!$supplier) {
            return redirect()->back()->with('error', 'Supplier profile not found.');
        }

        // Get earnings data
        $todayEarnings = Order::where('supplier_id', $supplier->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        $weekEarnings = Order::where('supplier_id', $supplier->id)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_amount');

        $monthEarnings = Order::where('supplier_id', $supplier->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        $earningsHistory = Order::where('supplier_id', $supplier->id)
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total_earnings, COUNT(*) as orders_count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        $filename = 'supplier_earnings_' . $supplier->id . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($todayEarnings, $weekEarnings, $monthEarnings, $earningsHistory) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Summary Section
            fputcsv($file, ['ملخص الأرباح']);
            fputcsv($file, ['أرباح اليوم', $todayEarnings]);
            fputcsv($file, ['أرباح الأسبوع', $weekEarnings]);
            fputcsv($file, ['أرباح الشهر', $monthEarnings]);
            fputcsv($file, []); // Empty row
            
            // History Section
            fputcsv($file, ['تاريخ', 'إجمالي الأرباح', 'عدد الطلبات', 'متوسط الطلب']);
            
            foreach ($earningsHistory as $earning) {
                $avgOrder = $earning->orders_count > 0 ? $earning->total_earnings / $earning->orders_count : 0;
                fputcsv($file, [
                    $earning->date,
                    $earning->total_earnings,
                    $earning->orders_count,
                    number_format($avgOrder, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
