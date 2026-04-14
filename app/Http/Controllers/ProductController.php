<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        $store = auth()->user()->store;
        $products = $store ? $store->products : [];

        return view('product.index', compact('products'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        if (!auth()->user()->store) {
            return redirect('/store/create')->with('error', 'Buat toko dulu');
        }

        return view('product.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable',
        ]);

        $store = auth()->user()->store;

        Product::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return redirect('/product')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        $product = Product::where('id', $id)
            ->where('store_id', auth()->user()->store->id)
            ->firstOrFail();

        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        $product = Product::where('id', $id)
            ->where('store_id', auth()->user()->store->id)
            ->firstOrFail();

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return redirect('/product')->with('success', 'Produk diupdate');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        $product = Product::where('id', $id)
            ->where('store_id', auth()->user()->store->id)
            ->firstOrFail();

        $product->delete();

        return redirect('/product')->with('success', 'Produk dihapus');
    }
}