<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
    <h2>LOGIN</h2>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    @if (session('login_error'))
        <p>{{ session('login_error') }}</p>
    @endif
    <form method="POST" action="/login">
        @csrf
        <label for="name">Nama:</label>
        <input type="text" name="u" required><br>

        <label for="password">Password:</label>
        <input type="password" name="p"  required><br>


        <button type="submit">Login</button>

    </form>
</body>
</html>