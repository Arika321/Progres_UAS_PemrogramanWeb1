<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | CleanTrash</title>
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
    <h2>Daftar Akun</h2>
    <p>Bersama kita jaga bumi 🌍</p>

    <form action="proses_register.php" method="POST">
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <span>Sudah punya akun? <a href="login.php">Login</a></span>
</div>

</body>
</html>
