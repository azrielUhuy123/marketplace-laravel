<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function create()
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        return view('store.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403);
        }

        if (auth()->user()->store) {
            return redirect('/')->with('error', 'Kamu sudah punya toko');
        }

        $request->validate([
            'store_name' => 'required',
            'description' => 'nullable'
        ]);

        Store::create([
            'user_id' => auth()->id(),
            'store_name' => $request->store_name,
            'description' => $request->description
        ]);

        return redirect('/')->with('success', 'Store berhasil dibuat');
    }
}