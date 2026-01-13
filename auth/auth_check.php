<?php
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu!";
    header("Location: ../login.php");
    exit();
}
?>