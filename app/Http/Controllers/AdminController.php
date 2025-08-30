<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\DeliveryMan;
use App\Models\Review;

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
        return 'Supplier dashboard method works!';
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
}
