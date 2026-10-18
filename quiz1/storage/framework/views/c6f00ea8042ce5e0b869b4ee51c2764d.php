<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST" action="<?php echo e(route('pengguna.update', $user->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <label for="name">Nama:</label>
    <input id="name" type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required><br>

    <label for="email">Email:</label>
    <input id="email" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required><br>

    <?php if($errors->any()): ?>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>

    <button type="submit">Simpan perubahan</button>
</form>
<p><a href="<?php echo e(route('home')); ?>">Kembali</a></p>
</body>
</html><?php /**PATH D:\project\jonagay-main\resources\views/edit.blade.php ENDPATH**/ ?>