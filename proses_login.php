<?php
session_start();
include "config/database.php";

$email = $_POST['email'];
$password = md5($_POST['password']);

$query = mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email' AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if($data){
    $_SESSION['login'] = true;
    $_SESSION['nama']  = $data['nama_lengkap'];
    header("Location: dashboard.php");
}else{
    echo "<script>alert('Email atau password salah');location='login.php';</script>";
}
