<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Ambil data riwayat user
$user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_lengkap'];

$query = mysqli_query($conn, 
    "SELECT * FROM pickup_requests WHERE user_id='$user_id' ORDER BY created_at DESC");

// Set header untuk PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Riwayat_CleanTrash_' . date('Y-m-d') . '.pdf"');

// Buat PDF menggunakan HTML to PDF (simplified version)
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Penjemputan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
            margin: 0;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-diproses { background: #cfe2ff; color: #084298; }
        .status-selesai { background: #d1e7dd; color: #0f5132; }
        .status-dibatalkan { background: #f8d7da; color: #842029; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌿 CleanTrash</h1>
        <h2>Laporan Riwayat Penjemputan Sampah</h2>
    </div>
    
    <div class="info">
        <p><strong>Nama:</strong> <?php echo $nama_user; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Tanggal Cetak:</strong> <?php echo date('d F Y H:i'); ?> WIB</p>
        <p><strong>Total Data:</strong> <?php echo mysqli_num_rows($query); ?> permintaan</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis Sampah</th>
                <th>Berat (kg)</th>
                <th>Alamat</th>
                <th>Status</th>
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
                    <td><?php echo ucfirst($data['jenis_sampah']); ?></td>
                    <td><?php echo $data['berat_estimasi']; ?></td>
                    <td><?php echo substr($data['alamat'], 0, 50); ?>...</td>
                    <td>
                        <span class="status status-<?php echo $data['status']; ?>">
                            <?php echo ucfirst($data['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Berat Sampah</th>
                <th colspan="3"><?php echo number_format($total_berat, 2); ?> kg</th>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem CleanTrash</p>
        <p>&copy; <?php echo date('Y'); ?> CleanTrash - Universitas Teknologi Bandung</p>
    </div>
</body>
</html>

<script>
// Auto print PDF saat halaman dibuka
window.onload = function() {
    window.print();
}
</script>