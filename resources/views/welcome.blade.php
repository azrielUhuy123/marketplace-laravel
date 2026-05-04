@extends('layouts.app')

@section('content')

<h2>Selamat Datang di Marketplace</h2>

@guest
    <p>Ini halaman utama (guest)</p>

@endguest

<h2 class="text-2xl font-bold mb-4">Marketplace</h2>

@guest
    <p class="mb-4">Silakan login untuk bertransaksi</p>
@endguest

@auth
    <p class="mb-4">
        Selamat datang, <b>{{ auth()->user()->name }}</b>
    </p>
@endauth

<h3 class="text-xl font-semibold mb-4">Produk</h3>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

@foreach($products as $product)
    <div class="bg-white p-4 rounded shadow">
        <h4 class="font-bold text-lg">{{ $product->name }}</h4>

        <p class="text-gray-600">
            Rp {{ number_format($product->price) }}
        </p>

        <p class="text-sm">Stock: {{ $product->stock }}</p>

        @auth
            @if(auth()->user()->role == 'customer')
                <form method="POST" action="/cart/add/{{ $product->id }}">
                    @csrf
                    <button class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">
                        + Cart
                    </button>
                </form>
            @endif
        @endauth
    </div>
@endforeach

</div>

@endsection