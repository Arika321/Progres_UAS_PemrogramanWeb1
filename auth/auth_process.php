<?php
session_start();
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    
    if ($action == 'register') {
        // Proses Register
        $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validasi
        if (empty($nama_lengkap) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Semua field harus diisi!";
            header("Location: ../register.php");
            exit();
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = "Password tidak cocok!";
            header("Location: ../register.php");
            exit();
        }
        
        // Cek email sudah ada atau belum
        $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $_SESSION['error'] = "Email sudah terdaftar!";
            header("Location: ../register.php");
            exit();
        }
        
        // Hash password
        $hashed_password = md5($password);
        
        // Insert ke database
        $query = "INSERT INTO users (nama_lengkap, email, password, role) 
                  VALUES ('$nama_lengkap', '$email', '$hashed_password', 'user')";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = "Registrasi gagal: " . mysqli_error($conn);
            header("Location: ../register.php");
        }
        exit();
        
    } elseif ($action == 'login') {
        // Proses Login
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect ke dashboard
            header("Location: ../pages/dashboard.php");
        } else {
            $_SESSION['error'] = "Email atau password salah!";
            header("Location: ../login.php");
        }
        exit();
    }
}
?>