<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register | CleanTrash</title>
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>
<body>

<div class="auth-card">
    <div class="logo">
        <div class="icon">🌱🗑️</div>
        <h2>CleanTrash</h2>
        <p>Daftarkan Akunmu</p>
    </div>

    <form action="../../controllers/AuthController.php" method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password2" placeholder="Verifikasi Password" required>

        <button type="submit" name="register">Daftar</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>
