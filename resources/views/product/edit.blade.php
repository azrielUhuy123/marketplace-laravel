<h2>Edit Produk</h2>

<form method="POST" action="/product/{{ $product->id }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $product->name }}"><br><br>

    <input type="number" name="price" value="{{ $product->price }}"><br><br>

    <input type="number" name="stock" value="{{ $product->stock }}"><br><br>

    <textarea name="description">{{ $product->description }}</textarea><br><br>

    <button type="submit">Update</button>
</form>