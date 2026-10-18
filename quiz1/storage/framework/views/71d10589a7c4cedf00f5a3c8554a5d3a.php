<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER KARYAWAN</title>
</head>
<body>
    <h1> Register </h1>
    <?php if($errors->any()): ?>
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php endif; ?>
<form action="/aksi_tkry" method="POST">
    <?php echo csrf_field(); ?>
        Username:
        <input type="text" name="u"><br>
        Password:
        <input type="password" name="p"><br>
        Email:
        <input type="text" name="e"><br>
        Level:
        <select name="l">
            <option value="1"> Admin </option>
            <option value="2"> Karyawan </option>
            <option value="3"> Pelanggan </option>
</select><br>

        Nama Karyawan:
        <input type="text" name="nama"><br>
        Alamat Karyawan:
        <input type="text" name="alamat"><br>
        Jenis Kelamin:
        <input type="radio" name="jk" value="L"> Laki-Laki
        <input type="radio" name="jk" value="P"> Perempuan<br>
        <button type="submit"> Simpan</button>
</form>

</body>
</html><?php /**PATH D:\project\jonagay-main\resources\views//tkry.blade.php ENDPATH**/ ?>