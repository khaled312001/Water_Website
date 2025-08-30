<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Order;
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
