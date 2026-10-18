<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Servis Bengkel</title>
</head>
<body>
    <h1>Laporan Servis Bengkel</h1>
    <table border="1">
        <thead>
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
            </tr>
        </thead>
        <tbody>
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
                </tr>
            @empty
                <tr>
                    <td colspan="11">Belum ada data servis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($format === 'print')
        <script>
            window.addEventListener('load', () => window.print());
        </script>
    @endif
</body>
</html>
