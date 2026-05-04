<?php

namespace App\Services;

use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function process($user)
    {
        return DB::transaction(function () use ($user) {

            $cart = $user->cart;

            if (!$cart || $cart->items->isEmpty()) {
                throw new \Exception('Cart kosong');
            }

            $items = $cart->items()->get();

            $lockedProducts = [];

            foreach ($items as $item) {

                $product = Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($item->quantity > $product->stock) {
                    throw new \Exception("Stock tidak cukup untuk {$product->name}");
                }

                $product->decrement('stock', $item->quantity);

                $lockedProducts[$product->id] = $product;
            }

            $checkout = Checkout::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'status' => 'pending'
            ]);

            $grouped = collect($items)->groupBy(function ($item) use ($lockedProducts) {
                return $lockedProducts[$item->product_id]->store_id;
            });

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

                    $product = $lockedProducts[$item->product_id];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                        'price' => $product->price
                    ]);

                    $totalOrder += $product->price * $item->quantity;
                }

                $order->update([
                    'total_price' => $totalOrder
                ]);

                $totalCheckout += $totalOrder;
            }

            $checkout->update([
                'total_price' => $totalCheckout
            ]);

            Payment::create([
                'checkout_id' => $checkout->id,
                'status' => 'pending'
            ]);

            $cart->items()->delete();

            return $checkout;
        });
    }
}