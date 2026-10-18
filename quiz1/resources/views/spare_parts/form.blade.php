<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $part ? 'Ubah suku cadang' : 'Tambah suku cadang' }}</title>
</head>
<body>
    <h1>{{ $part ? 'Ubah suku cadang' : 'Tambah suku cadang' }}</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ $part ? route('suku-cadang.update', $part->id) : route('suku-cadang.simpan') }}" method="POST">
        @csrf
        @if ($part)
            @method('PUT')
        @endif

        <p>
            <label for="code">Kode suku cadang</label><br>
            <input id="code" type="text" name="code" value="{{ old('code', $part->code ?? '') }}" maxlength="40" required>
        </p>
        <p>
            <label for="name">Nama barang</label><br>
            <input id="name" type="text" name="name" value="{{ old('name', $part->name ?? '') }}" maxlength="150" required>
        </p>
        <p>
            <label for="category">Kategori</label><br>
            <input id="category" type="text" name="category" value="{{ old('category', $part->category ?? '') }}" maxlength="100">
        </p>
        <p>
            <label for="unit">Satuan (contoh: pcs, botol)</label><br>
            <input id="unit" type="text" name="unit" value="{{ old('unit', $part->unit ?? '') }}" maxlength="30" required>
        </p>
        <p>
            <label for="stock">Jumlah stok</label><br>
            <input id="stock" type="number" name="stock" value="{{ old('stock', $part->stock ?? 0) }}" min="0" required>
        </p>
        <p>
            <label for="minimum_stock">Batas stok minimum</label><br>
            <input id="minimum_stock" type="number" name="minimum_stock" value="{{ old('minimum_stock', $part->minimum_stock ?? 0) }}" min="0" required>
        </p>
        <p>
            <label for="price">Harga satuan (rupiah)</label><br>
            <input id="price" type="number" name="price" value="{{ old('price', $part->price ?? 0) }}" min="0" step="0.01" required>
        </p>
        <button type="submit">{{ $part ? 'Simpan perubahan' : 'Simpan suku cadang' }}</button>
    </form>

    <p><a href="/home">Kembali ke dashboard</a></p>
</body>
</html>
