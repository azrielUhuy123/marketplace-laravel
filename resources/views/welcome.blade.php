@extends('layouts.app')

@section('content')

<h2>Selamat Datang di Marketplace</h2>

@guest
    <p>Ini halaman utama (guest)</p>

    <a href="/login">Login</a> |
    <a href="/register">Register</a>
@endguest

@auth
    <p>
        Selamat datang, <b>{{ auth()->user()->name }}</b><br>
        Role: <b>{{ auth()->user()->role }}</b>
    </p>
@endauth

<hr>

<h3>Daftar Produk</h3>

@if(isset($products) && count($products) > 0)

<ul>
@foreach($products as $product)
    <li>
        <h4>{{ $product->name }}</h4>
        <p>Harga: Rp {{ number_format($product->price) }}</p>
        <p>Stock: {{ $product->stock }}</p>

        @auth
            @if(auth()->user()->role == 'customer')
                <form method="POST" action="/cart/add/{{ $product->id }}">
                    @csrf
                    <button type="submit">Tambah ke Cart</button>
                </form>
            @endif
        @endauth
    </li>
@endforeach
</ul>

@else
<p>Belum ada produk</p>
@endif

@endsection