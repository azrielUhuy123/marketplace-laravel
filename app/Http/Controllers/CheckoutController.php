<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function index()
    {


        $cart = auth()->user()->cart;
        $items = $cart ? $cart->items()->with('product.store')->get() : [];

        return view('checkout.index', compact('items'));
    }

    public function process(CheckoutService $checkoutService)
    {

        try {
            $checkoutService->process(auth()->user());

            return redirect('/')->with('success', 'Checkout berhasil');

        } catch (\Exception $e) {

            return redirect('/cart')->with('error', $e->getMessage());
        }
    }
}