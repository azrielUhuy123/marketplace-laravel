<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class CheckoutController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        $cart = auth()->user()->cart;
        $items = $cart ? $cart->items()->with('product.store')->get() : [];

        return view('checkout.index', compact('items'));
    }

    public function process()
    {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Cart kosong');
        }

        $items = $cart->items()->with('product.store')->get();

        foreach ($items as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->with('error', 'Stock tidak cukup');
            }
        }

        $checkout = Checkout::create([
            'user_id' => $user->id,
            'total_price' => 0,
            'status' => 'pending'
        ]);

        $grouped = $items->groupBy(fn($item) => $item->product->store_id);

        $totalCheckout = 0;

        foreach ($grouped as $storeId => $groupItems) {

            $totalOrder = 0;

            $order = Order::create([
                'checkout_id' => $checkout->id,
                'user_id' => $user->id,
                'store_id' => $storeId,
                'total_price' => 0,
                'status' => 'pending'
            ]);

            foreach ($groupItems as $item) {

                $price = $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price
                ]);

                $item->product->decrement('stock', $item->quantity);

                $totalOrder += $price * $item->quantity;
            }

            $order->update(['total_price' => $totalOrder]);
            $totalCheckout += $totalOrder;
        }

        $checkout->update(['total_price' => $totalCheckout]);

        Payment::create([
            'checkout_id' => $checkout->id,
            'status' => 'pending'
        ]);

        $cart->items()->delete();

        return redirect('/')->with('success', 'Checkout berhasil');
    }
}