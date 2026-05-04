<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipment;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'seller') {
            $orders = Order::where('store_id', $user->store->id)->get();
        } elseif ($user->role === 'logistic') {
            $orders = Order::has('shipment')->get();
        } else {
            $orders = Order::where('user_id', $user->id)->get();
        }

        return view('order.index', compact('orders'));
    }

    public function process($id)
    {
        $user = auth()->user();

        if ($user->role !== 'seller') {
            abort(403);
        }

        $order = Order::where('id', $id)
            ->where('store_id', $user->store->id)
            ->firstOrFail();

        // VALIDASI STATUS
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak valid');
        }

        $order->update([
            'status' => 'processed'
        ]);

        return back()->with('success', 'Order diproses');
    }

    public function ship($id)
    {
        $user = auth()->user();

        if ($user->role !== 'logistic') {
            abort(403);
        }

        $order = Order::findOrFail($id);

        // VALIDASI STATUS
        if ($order->status !== 'processed') {
            return back()->with('error', 'Order belum diproses');
        }

        // CEGAH DUPLIKASI
        if ($order->shipment) {
            return back()->with('error', 'Sudah dikirim');
        }

        Shipment::create([
            'order_id' => $order->id,
            'logistic_id' => $user->id,
            'status' => 'shipped'
        ]);

        return back()->with('success', 'Barang dikirim');
    }

    public function deliver($id)
    {
        $user = auth()->user();

        if ($user->role !== 'customer') {
            abort(403);
        }

        $shipment = Shipment::where('order_id', $id)
            ->whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->firstOrFail();

        // VALIDASI STATUS
        if ($shipment->status !== 'shipped') {
            return back()->with('error', 'Belum dikirim');
        }

        $shipment->update([
            'status' => 'delivered'
        ]);

        $shipment->order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Barang diterima');
    }
}