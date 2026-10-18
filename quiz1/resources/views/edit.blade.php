<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('pengguna.update', $user->id) }}">
    @csrf
    @method('PUT')

    <label for="name">Nama:</label>
    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required><br>

    <label for="email">Email:</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required><br>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <button type="submit">Simpan perubahan</button>
</form>
<p><a href="{{ route('home') }}">Kembali</a></p>
</body>
</html>