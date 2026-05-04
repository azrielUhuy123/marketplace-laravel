<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {


        $cart = auth()->user()->cart;
        $items = $cart ? $cart->items()->with('product')->get() : [];

        return view('cart.index', compact('items'));
    }

    public function add($id)
    {


        $product = Product::findOrFail($id);

        $cart = auth()->user()->cart;

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => auth()->id()
            ]);
        }

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item && $item->quantity >= $product->stock) {
            return back()->with('error', 'Stock tidak cukup');
        }

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect('/cart')->with('success', 'Ditambahkan ke cart');
    }

    public function remove($id)
    {

        CartItem::where('id', $id)
            ->whereHas('cart', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail()
            ->delete();

        return redirect('/cart')->with('success', 'Item dihapus');
    }
}