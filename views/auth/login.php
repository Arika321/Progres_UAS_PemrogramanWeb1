<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login | CleanTrash</title>
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>
<body>

<div class="auth-card">
    <div class="logo">
        <div class="icon">🌱🗑️</div>
        <h2>CleanTrash</h2>
        <p>Selamat datang, silakan masuk</p>
    </div>

    <form action="../../controllers/AuthController.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Masuk</button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="register.php">Daftar</a>
    </div>
</div>

</body>
</html>
