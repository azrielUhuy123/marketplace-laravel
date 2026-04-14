<!DOCTYPE html>
<html>
<head>
    <title>Marketplace</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        a {
            text-decoration: none;
            margin-right: 10px;
        }

        h2 {
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            margin-top: 5px;
            padding: 5px 10px;
        }

        hr {
            margin: 20px 0;
        }
    </style>

    <h2>Marketplace System</h2>

    <hr>

    <!-- NAVBAR -->
    <a href="/">Home</a> |

    @auth

        @if(auth()->user()->role == 'seller')
            <a href="/product">Product</a> |
            <a href="/order">Order</a> |
            <a href="/store/create">Create Store</a>
        @endif

        @if(auth()->user()->role == 'customer')
            <a href="/cart">Cart</a> |
            <a href="/checkout">Checkout</a> |
            <a href="/order">Order</a>
        @endif

        @if(auth()->user()->role == 'logistic')
            <a href="/order">Order</a>
        @endif

    @endauth

    <hr>

    @auth
        <p>
            Login sebagai: {{ auth()->user()->name }} 
            ({{ auth()->user()->role }})
        </p>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="/login">Login</a> |
        <a href="/register">Register</a>
    @endauth

    <hr>
    <hr>

    <!-- MESSAGE -->
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <!-- CONTENT -->
    @yield('content')

    </body>
</html>