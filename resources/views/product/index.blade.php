@extends('layouts.app')

@section('content')

<h2>Daftar Produk</h2>

<a href="/product/create">Tambah Produk</a>

<ul>
@foreach($products as $product)
    <li>
        {{ $product->name }} - {{ $product->price }}

        <a href="/product/{{ $product->id }}/edit">Edit</a>

        <form action="/product/{{ $product->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>

@endsection