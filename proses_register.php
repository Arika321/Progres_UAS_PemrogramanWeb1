<?php
include "config/database.php";

$nama = $_POST['nama_lengkap'];
$email = $_POST['email'];
$password = md5($_POST['password']);

mysqli_query($conn,
    "INSERT INTO users(nama_lengkap,email,password)
     VALUES('$nama','$email','$password')"
);

echo "<script>alert('Registrasi berhasil');location='login.php';</script>";
