<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
</head>

<body>
    <h1>Data Karyawan</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <p><a href="{{ route('home') }}">Kembali ke dashboard</a></p>

    <table border="1">
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>ID User</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($karyawan as $pegawai)
                <tr>
                    <td>{{ $pegawai->id_kry }}</td>
                    <td>{{ $pegawai->id_user }}</td>
                    <td>{{ $pegawai->nama_kry }}</td>
                    <td>{{ $pegawai->alamat_kry }}</td>
                    <td>{{ $pegawai->jk_kry }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada data karyawan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
