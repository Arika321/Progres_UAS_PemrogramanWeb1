<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard | CleanTrash</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<div class="header">
    <h2>CleanTrash</h2>
    <div>
        Halo, <b><?= $_SESSION['user']['nama']; ?></b> |
        <a href="../auth/logout.php">Keluar</a>
    </div>
</div>

<div class="container">

    <!-- RINGKASAN -->
    <div class="cards">
        <div class="card">
            <h4>Poin Terkumpul</h4>
            <p>0 Poin</p>
        </div>

        <div class="card">
            <h4>Target Sampah</h4>
            <p>10 Kg / Bulan</p>
        </div>

        <div class="card">
            <h4>Lokasi Terdekat</h4>
            <p>TPS Bersih Sejahtera</p>
        </div>

        <div class="card">
            <h4>Riwayat Setor</h4>
            <p>0 Kali</p>
        </div>
    </div>

    <!-- BUTTON SETOR -->
    <a href="setor.php" class="btn">♻️ Setor Sampah Sekarang</a>

    <!-- MENU -->
    <div class="menu">
        <div class="menu-item">
            <a href="riwayat.php">📍 Riwayat Penyetoran</a>
        </div>
        <div class="menu-item">
            <a href="target.php">🎯 Target Sampah</a>
        </div>
        <div class="menu-item">
            <a href="laporan.php">📊 Laporan</a>
        </div>
        <div class="menu-item">
            <a href="akun.php">👤 Akun Saya</a>
        </div>
    </div>

</div>

</body>
</html>
