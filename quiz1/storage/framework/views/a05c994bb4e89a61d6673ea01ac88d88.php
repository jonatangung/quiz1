<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
</head>

<body>
    <h1>Data Karyawan</h1>
    <?php if(session('success')): ?>
        <p><?php echo e(session('success')); ?></p>
    <?php endif; ?>
    <p><a href="<?php echo e(route('home')); ?>">Kembali ke dashboard</a></p>

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
            <?php $__empty_1 = true; $__currentLoopData = $karyawan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pegawai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($pegawai->id_kry); ?></td>
                    <td><?php echo e($pegawai->id_user); ?></td>
                    <td><?php echo e($pegawai->nama_kry); ?></td>
                    <td><?php echo e($pegawai->alamat_kry); ?></td>
                    <td><?php echo e($pegawai->jk_kry); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">Belum ada data karyawan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>
<?php /**PATH D:\project\jonagay-main\resources\views/karyawan.blade.php ENDPATH**/ ?>