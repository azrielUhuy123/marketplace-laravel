@extends('layouts.app')

@section('content')

<h2>Cart</h2>

<ul>
@foreach($items as $item)
    <li>
        {{ $item->product->name }} 
        ({{ $item->quantity }}) 
        - {{ $item->product->price }}

        <form action="/cart/remove/{{ $item->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>

<form method="GET" action="/checkout">
    <button type="submit">Checkout</button>
</form>

@endsection