<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Bengkel</title>
</head>

<body>

    <h1>Sistem Informasi Bengkel Motor</h1>
    <p>Selamat datang, {{ session('u') }}</p>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <a href="/tkry">
        <button>Tambah</button>
</a>

    <p><a href="{{ route('karyawan.index') }}">Lihat data karyawan</a></p>
    <p><a href="{{ route('servis.buat') }}">Catat servis baru</a></p>
    <p><a href="{{ route('suku-cadang.buat') }}">Tambah suku cadang</a></p>
    <p>
        <a href="{{ route('laporan.export', 'print') }}" target="_blank" rel="noopener">Cetak laporan</a>
        <a href="{{ route('laporan.export', 'excel') }}">Export Excel</a>
        <a href="{{ route('laporan.export', 'word') }}">Export Word</a>
    </p>
    <h2>Data user</h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        @forelse ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('pengguna.edit', $user->id) }}">Edit</a>
                    <form action="{{ route('pengguna.hapus', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Belum ada user.</td>
            </tr>
        @endforelse
    </table>

    <h2>Daftar pekerjaan servis</h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Tanggal masuk</th>
            <th>Pelanggan</th>
            <th>Telepon</th>
            <th>Motor</th>
            <th>Nomor polisi</th>
            <th>Keluhan</th>
            <th>Tindakan servis</th>
            <th>Mekanik</th>
            <th>Biaya (Rp)</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->received_at }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_phone }}</td>
                <td>{{ $order->motorcycle }}</td>
                <td>{{ $order->license_plate }}</td>
                <td>{{ $order->complaint }}</td>
                <td>{{ $order->service_action ?: '-' }}</td>
                <td>{{ $order->mechanic ?: '-' }}</td>
                <td>{{ number_format($order->cost, 0, ',', '.') }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('servis.edit', $order->id) }}">Edit</a>
                    <form action="{{ route('servis.hapus', $order->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12">Belum ada data servis.</td>
            </tr>
        @endforelse
    </table>

    <h2>Persediaan suku cadang</h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Nama barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Stok minimum</th>
            <th>Satuan</th>
            <th>Harga (Rp)</th>
            <th>Keterangan stok</th>
            <th>Aksi</th>
        </tr>
        @forelse ($parts as $part)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $part->code }}</td>
                <td>{{ $part->name }}</td>
                <td>{{ $part->category ?: '-' }}</td>
                <td>{{ $part->stock }}</td>
                <td>{{ $part->minimum_stock }}</td>
                <td>{{ $part->unit }}</td>
                <td>{{ number_format($part->price, 0, ',', '.') }}</td>
                <td>{{ $part->stock <= $part->minimum_stock ? 'Stok menipis' : 'Tersedia' }}</td>
                <td>
                    <a href="{{ route('suku-cadang.edit', $part->id) }}">Edit</a>
                    <form action="{{ route('suku-cadang.hapus', $part->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10">Belum ada data suku cadang.</td>
            </tr>
        @endforelse
    </table>

    <p><a href="/logout">Logout</a></p>

</body>

</html>
