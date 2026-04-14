@extends('layouts.app')

@section('content')

<h2>Order</h2>

<ul>
@foreach($orders as $order)
    <li>
        Order #{{ $order->id }} - {{ $order->status }}

        @if(auth()->user()->role == 'seller' && $order->status == 'pending')
            <form method="POST" action="/order/{{ $order->id }}/process">
                @csrf
                <button type="submit">Proses</button>
            </form>
        @endif

        @if(auth()->user()->role == 'logistic' && $order->status == 'processed')
            <form method="POST" action="/order/{{ $order->id }}/ship">
                @csrf
                <button type="submit">Kirim</button>
            </form>
        @endif

        @if(auth()->user()->role == 'customer' && $order->status == 'processed')
            <form method="POST" action="/order/{{ $order->id }}/deliver">
                @csrf
                <button type="submit">Terima</button>
            </form>
        @endif
    </li>
@endforeach
</ul>

@endsection