<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->with('supplier');

        // فلترة حسب النوع
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // فلترة حسب المورد
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // فلترة حسب السعر
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_per_box', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_per_box', '<=', $request->max_price);
        }

        // البحث
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        $suppliers = Supplier::where('status', 'active')->get();

        return view('products.index', compact('products', 'suppliers'));
    }

    public function show($id)
    {
        $product = Product::with(['supplier', 'reviews.user'])
            ->where('status', 'available')
            ->findOrFail($id);

        $relatedProducts = Product::where('supplier_id', $product->supplier_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('brand', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->with('supplier')
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }
}
