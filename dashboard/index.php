<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<h1>Dashboard CleanTrash</h1>
<p>Halo, <?= $_SESSION['user']['nama']; ?> 👋</p>

<ul>
    <li>Total Poin: 0</li>
    <li>Target Sampah: 0 Kg</li>
    <li>Lokasi Terdekat</li>
</ul>

<a href="logout.php">Logout</a>
