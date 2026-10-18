<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Bengkel</title>
</head>

<body>

    <h1>Sistem Informasi Bengkel Motor</h1>
    <p>Selamat datang, <?php echo e(session('u')); ?></p>
    <?php if(session('success')): ?>
        <p><?php echo e(session('success')); ?></p>
    <?php endif; ?>
    <a href="/tkry">
        <button>Tambah</button>
</a>

    <p><a href="<?php echo e(route('karyawan.index')); ?>">Lihat data karyawan</a></p>
    <p><a href="<?php echo e(route('servis.buat')); ?>">Catat servis baru</a></p>
    <p><a href="<?php echo e(route('suku-cadang.buat')); ?>">Tambah suku cadang</a></p>
    <p>
        <a href="<?php echo e(route('laporan.export', 'print')); ?>" target="_blank" rel="noopener">Cetak laporan</a>
        <a href="<?php echo e(route('laporan.export', 'excel')); ?>">Export Excel</a>
        <a href="<?php echo e(route('laporan.export', 'word')); ?>">Export Word</a>
    </p>
    <h2>Data user</h2>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->email); ?></td>
                <td>
                    <a href="<?php echo e(route('pengguna.edit', $user->id)); ?>">Edit</a>
                    <form action="<?php echo e(route('pengguna.hapus', $user->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4">Belum ada user.</td>
            </tr>
        <?php endif; ?>
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
        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($order->received_at); ?></td>
                <td><?php echo e($order->customer_name); ?></td>
                <td><?php echo e($order->customer_phone); ?></td>
                <td><?php echo e($order->motorcycle); ?></td>
                <td><?php echo e($order->license_plate); ?></td>
                <td><?php echo e($order->complaint); ?></td>
                <td><?php echo e($order->service_action ?: '-'); ?></td>
                <td><?php echo e($order->mechanic ?: '-'); ?></td>
                <td><?php echo e(number_format($order->cost, 0, ',', '.')); ?></td>
                <td><?php echo e($order->status); ?></td>
                <td>
                    <a href="<?php echo e(route('servis.edit', $order->id)); ?>">Edit</a>
                    <form action="<?php echo e(route('servis.hapus', $order->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="12">Belum ada data servis.</td>
            </tr>
        <?php endif; ?>
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
        <?php $__empty_1 = true; $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($part->code); ?></td>
                <td><?php echo e($part->name); ?></td>
                <td><?php echo e($part->category ?: '-'); ?></td>
                <td><?php echo e($part->stock); ?></td>
                <td><?php echo e($part->minimum_stock); ?></td>
                <td><?php echo e($part->unit); ?></td>
                <td><?php echo e(number_format($part->price, 0, ',', '.')); ?></td>
                <td><?php echo e($part->stock <= $part->minimum_stock ? 'Stok menipis' : 'Tersedia'); ?></td>
                <td>
                    <a href="<?php echo e(route('suku-cadang.edit', $part->id)); ?>">Edit</a>
                    <form action="<?php echo e(route('suku-cadang.hapus', $part->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="10">Belum ada data suku cadang.</td>
            </tr>
        <?php endif; ?>
    </table>

    <p><a href="/logout">Logout</a></p>

</body>

</html>
<?php /**PATH D:\project\jonagay-main\resources\views/home.blade.php ENDPATH**/ ?>