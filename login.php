<?php
session_start();
if(isset($_SESSION['login'])){
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | CleanTrash</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="background">
    <div class="trash-shape green"></div>
    <div class="trash-shape yellow"></div>
    <div class="trash-shape blue"></div>
</div>

<div class="auth-card">
    <div class="logo">
        ♻
    </div>
    <h2>CleanTrash</h2>
    <p>Masuk untuk menjaga lingkungan 🌱</p>

    <form action="proses_login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <span>Belum punya akun? <a href="register.php">Daftar</a></span>
</div>

</body>
</html>
