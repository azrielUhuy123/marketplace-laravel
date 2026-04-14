@extends('layouts.app')

@section('content')

<h2>Checkout</h2>

<ul>
@foreach($items as $item)
    <li>
        {{ $item->product->name }} 
        ({{ $item->quantity }}) 
        - {{ $item->product->price }}
    </li>
@endforeach
</ul>

<form method="POST" action="/checkout">
    @csrf
    <button type="submit">Proses Checkout</button>
</form>

@endsection