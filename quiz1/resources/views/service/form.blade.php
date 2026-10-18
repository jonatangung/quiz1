<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $order ? 'Ubah data servis' : 'Catat servis baru' }}</title>
</head>
<body>
    <h1>{{ $order ? 'Ubah data servis' : 'Catat servis baru' }}</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ $order ? route('servis.update', $order->id) : route('servis.simpan') }}" method="POST">
        @csrf
        @if ($order)
            @method('PUT')
        @endif

        <p>
            <label for="customer_name">Nama pelanggan</label><br>
            <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name ?? '') }}" maxlength="120" required>
        </p>
        <p>
            <label for="customer_phone">Nomor telepon</label><br>
            <input id="customer_phone" type="text" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone ?? '') }}" maxlength="30" required>
        </p>
        <p>
            <label for="motorcycle">Merek dan tipe motor</label><br>
            <input id="motorcycle" type="text" name="motorcycle" value="{{ old('motorcycle', $order->motorcycle ?? '') }}" maxlength="120" required>
        </p>
        <p>
            <label for="license_plate">Nomor polisi</label><br>
            <input id="license_plate" type="text" name="license_plate" value="{{ old('license_plate', $order->license_plate ?? '') }}" maxlength="20" required>
        </p>
        <p>
            <label for="complaint">Keluhan pelanggan</label><br>
            <textarea id="complaint" name="complaint" required>{{ old('complaint', $order->complaint ?? '') }}</textarea>
        </p>
        <p>
            <label for="service_action">Tindakan servis</label><br>
            <textarea id="service_action" name="service_action">{{ old('service_action', $order->service_action ?? '') }}</textarea>
        </p>
        <p>
            <label for="mechanic">Nama mekanik</label><br>
            <input id="mechanic" type="text" name="mechanic" value="{{ old('mechanic', $order->mechanic ?? '') }}" maxlength="120">
        </p>
        <p>
            <label for="cost">Biaya servis (rupiah)</label><br>
            <input id="cost" type="number" name="cost" value="{{ old('cost', $order->cost ?? 0) }}" min="0" required>
        </p>
        <p>
            <label for="status">Status pengerjaan</label><br>
            <select id="status" name="status" required>
                @foreach (['Menunggu', 'Dikerjakan', 'Selesai', 'Diambil'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $order->status ?? 'Menunggu') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </p>
        <p>
            <label for="received_at">Tanggal masuk</label><br>
            <input id="received_at" type="date" name="received_at" value="{{ old('received_at', $order->received_at ?? now()->toDateString()) }}" required>
        </p>
        <button type="submit">{{ $order ? 'Simpan perubahan' : 'Simpan servis' }}</button>
    </form>

    <p><a href="/home">Kembali ke daftar servis</a></p>
</body>
</html>
