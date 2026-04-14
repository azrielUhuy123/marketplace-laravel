<h2>Buat Toko</h2>

<form method="POST" action="/store">
    @csrf

    <input type="text" name="store_name" placeholder="Nama toko">
    <br><br>

    <textarea name="description" placeholder="Deskripsi"></textarea>
    <br><br>

    <button type="submit">Submit</button>
</form>