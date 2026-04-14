<h2>Tambah Produk</h2>

<form method="POST" action="/product">
    @csrf

    <input type="text" name="name" placeholder="Nama Produk"><br><br>

    <input type="number" name="price" placeholder="Harga"><br><br>

    <input type="number" name="stock" placeholder="Stock"><br><br>

    <textarea name="description" placeholder="Deskripsi"></textarea><br><br>

    <button type="submit">Simpan</button>
</form>