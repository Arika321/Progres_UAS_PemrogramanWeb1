<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | CleanTrash</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<!-- Background -->
<div class="bg-shape green"></div>
<div class="bg-shape blue"></div>
<div class="bg-shape yellow"></div>

<!-- Sidebar -->
<div class="sidebar">
    <h2>♻ CleanTrash</h2>
    <a class="active">Dashboard</a>
    <a>Pickup Sampah</a>
    <a>Riwayat</a>
    <a>Statistik</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
    <h1>Halo, <?= $_SESSION['nama']; ?> 👋</h1>
    <p class="subtitle">Mari bersama menjaga kebersihan lingkungan</p>

    <!-- Cards -->
    <div class="cards">
        <div class="card green">
            <h3>🌱 Poin Terkumpul</h3>
            <p>150</p>
        </div>
        <div class="card blue">
            <h3>🚛 Pickup Aktif</h3>
            <p>2</p>
        </div>
        <div class="card orange">
            <h3>🧾 Laporan</h3>
            <p>1</p>
        </div>
        <div class="card purple">
            <h3>🎯 Target Bulan Ini</h3>
            <p>75%</p>
        </div>
    </div>

    <!-- Section -->
    <div class="section">
        <h2>📌 Riwayat Penyetoran Sampah</h2>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>12-01-2026</td>
                <td>Organik</td>
                <td>5 Kg</td>
                <td><span class="status done">Selesai</span></td>
            </tr>
            <tr>
                <td>09-01-2026</td>
                <td>Anorganik</td>
                <td>3 Kg</td>
                <td><span class="status process">Diproses</span></td>
            </tr>
        </table>
    </div>

    <!-- Info Section -->
    <div class="info">
        <div class="info-card">
            <h3>📍 Lokasi Setor Terdekat</h3>
            <p>TPS Cihampelas</p>
        </div>
        <div class="info-card">
            <h3>🔔 Notifikasi</h3>
            <p>Pickup besok pukul 09.00</p>
        </div>
    </div>
</div>

</body>
</html>
