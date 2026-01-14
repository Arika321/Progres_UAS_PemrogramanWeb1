<?php
session_start();
include "../config/database.php";

/* ================= REGISTER ================= */
if (isset($_POST['register'])) {

    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $pass1 = $_POST['password'];
    $pass2 = $_POST['password2'];

    if (empty($nama) || empty($email) || empty($pass1)) {
        $_SESSION['error'] = "Semua field wajib diisi";
        header("Location: ../views/auth/register.php");
        exit;
    }

    if ($pass1 !== $pass2) {
        $_SESSION['error'] = "Password tidak sama";
        header("Location: ../views/auth/register.php");
        exit;
    }

    $password = password_hash($pass1, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES (
        null,'$nama','$email','$password',NOW()
    )");

    header("Location: ../views/auth/login.php");
    exit;
}

/* ================= LOGIN ================= */
if (isset($_POST['login'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['user']  = $user;

        header("Location: ../views/dashboard/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Login gagal";
        header("Location: ../views/auth/login.php");
        exit;
    }
}
