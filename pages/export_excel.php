<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Ambil data riwayat user
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_lengkap'];

$query = mysqli_query($conn, 
    "SELECT * FROM pickup_requests WHERE user_id='$user_id' ORDER BY created_at DESC");

// Set header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Riwayat_CleanTrash_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Penjemputan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .header-section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <h2>CleanTrash - Laporan Riwayat Penjemputan Sampah</h2>
        <p><strong>Nama:</strong> <?php echo $nama_user; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Tanggal Export:</strong> <?php echo date('d F Y H:i'); ?> WIB</p>
        <p><strong>Total Data:</strong> <?php echo mysqli_num_rows($query); ?> permintaan</p>
        <br>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Penjemputan</th>
                <th>Waktu</th>
                <th>Jenis Sampah</th>
                <th>Berat (kg)</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_berat = 0;
            while ($data = mysqli_fetch_assoc($query)): 
                $total_berat += $data['berat_estimasi'];
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($data['tanggal_pickup'])); ?></td>
                    <td><?php echo date('H:i', strtotime($data['waktu_pickup'])); ?></td>
                    <td><?php echo ucfirst($data['jenis_sampah']); ?></td>
                    <td><?php echo $data['berat_estimasi']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo ucfirst($data['status']); ?></td>
                    <td><?php echo $data['catatan'] ? $data['catatan'] : '-'; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($data['created_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Berat Sampah</th>
                <th><?php echo number_format($total_berat, 2); ?> kg</th>
                <th colspan="4"></th>
            </tr>
        </tfoot>
    </table>
    
    <br><br>
    <p style="font-size: 12px; color: #666;">
        Dokumen ini dihasilkan secara otomatis oleh sistem CleanTrash<br>
        © <?php echo date('Y'); ?> CleanTrash - Universitas Teknologi Bandung
    </p>
</body>
</html>