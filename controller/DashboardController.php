<?php
session_start();
include "../config/database.php";

// Proteksi login
if (!isset($_SESSION['login'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Total berat sampah
$total = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT SUM(berat) AS total_kg FROM penyetoran_sampah WHERE user_id='$user_id'")
);

// Riwayat setor
$riwayat = mysqli_query($conn,
    "SELECT * FROM penyetoran_sampah
     WHERE user_id='$user_id'
     ORDER BY created_at DESC
     LIMIT 5"
);
