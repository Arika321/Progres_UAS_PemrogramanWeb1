<?php
session_start();
include "../config/database.php";

if (isset($_POST['jemput'])) {

    $user_id = $_SESSION['user']['id'];
    $jenis   = $_POST['jenis_sampah'];
    $berat   = $_POST['berat'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    $path = "../uploads/sampah/" . $foto;
    move_uploaded_file($tmp, $path);

    mysqli_query($conn, "INSERT INTO penyetoran_sampah
      (user_id, jenis_sampah, berat, foto)
      VALUES ('$user_id','$jenis','$berat','$foto')");

    header("Location: ../views/driver/mencari.php");
}
