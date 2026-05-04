<!DOCTYPE html>
<html>
<head>
    <title>Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Marketplace</h1>

    <div>
        <a href="/" class="mr-3">Home</a>

        @auth
            @if(auth()->user()->role == 'seller')
                <a href="/product" class="mr-3">Product</a>
                <a href="/order" class="mr-3">Order</a>
                @if(!auth()->user()->store)
                    <a href="/store/create">Create Store</a>
                @endif
            @endif

            @if(auth()->user()->role == 'customer')
                <a href="/cart" class="mr-3">Cart</a>
                <a href="/checkout" class="mr-3">Checkout</a>
                <a href="/order">Order</a>
            @endif

            @if(auth()->user()->role == 'logistic')
                <a href="/order">Order</a>
            @endif
        @endauth
    </div>

    <div>
        @auth
            <span class="mr-3 text-sm">
                {{ auth()->user()->name }} ({{ auth()->user()->role }})
            </span>

            <form method="POST" action="/logout" class="inline">
                @csrf
                <button class="bg-red-500 text-white px-3 py-1 rounded">
                    Logout
                </button>
            </form>
        @else
            <a href="/login" class="mr-3">Login</a>
            <a href="/register">Register</a>
        @endauth
    </div>
</div>

<div class="p-6">
    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 p-2 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>