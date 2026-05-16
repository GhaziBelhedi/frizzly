<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productQuery = Product::query();
        $orderQuery   = Order::with('product');

        if ($request->filled('search')) {
            $s = $request->search;
            $productQuery->where(fn($q) => $q->where('title', 'like', "%$s%")->orWhere('category', 'like', "%$s%"));
            $orderQuery->where(fn($q) => $q->where('customer_name', 'like', "%$s%")->orWhere('customer_email', 'like', "%$s%"));
        }

        if ($request->filled('status'))  $orderQuery->where('status', $request->status);
        if ($request->filled('payment')) $orderQuery->where('payment_status', $request->payment);

        $products = $productQuery->latest()->paginate(12)->withQueryString();
        $orders   = $orderQuery->latest()->paginate(15)->withQueryString();

        $productStats = [
            'total'    => Product::count(),
            'active'   => Product::where('active', true)->count(),
            'lowStock' => Product::where('stock', '<', 5)->count(),
        ];

        $orderStats = [
            'total'    => Order::count(),
            'pending'  => Order::where('status', 'pending')->count(),
            'revenue'  => Order::where('payment_status', 'paid')->sum('total'),
        ];

        return view('admin.products.index', compact(
            'products', 'orders', 'productStats', 'orderStats'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:100',
            'image'       => 'nullable|image|max:5120',
            'active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return back()->with('success', 'Produit ajouté avec succès.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|string|max:100',
            'image'       => 'nullable|image|max:5120',
            'active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['active'] = $request->boolean('active');
        $product->update($data);
        return back()->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return back()->with('success', 'Produit supprimé.');
    }

    public function updateOrder(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'         => 'required|in:pending,confirmed,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed,refunded',
        ]);

        $order->update(array_filter($data, fn($v) => $v !== null));
        return back()->with('success', 'Commande mise à jour.');
    }
}
