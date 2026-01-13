<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $delete_query = "DELETE FROM pickup_requests WHERE id='$id' AND user_id='" . $_SESSION['user_id'] . "'";
    
    if (mysqli_query($conn, $delete_query)) {
        $success = "Data berhasil dihapus!";
    } else {
        $error = "Gagal menghapus data!";
    }
}

// Handle Update Status (Cancel)
if (isset($_GET['cancel'])) {
    $id = mysqli_real_escape_string($conn, $_GET['cancel']);
    $update_query = "UPDATE pickup_requests SET status='dibatalkan' WHERE id='$id' AND user_id='" . $_SESSION['user_id'] . "'";
    
    if (mysqli_query($conn, $update_query)) {
        $success = "Permintaan berhasil dibatalkan!";
    } else {
        $error = "Gagal membatalkan permintaan!";
    }
}

// Ambil semua riwayat
$riwayat_query = mysqli_query($conn, 
    "SELECT * FROM pickup_requests WHERE user_id='" . $_SESSION['user_id'] . "' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjemputan | CleanTrash</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>📊 Riwayat Penjemputan</h1>
            <p>Lihat semua riwayat permintaan penjemputan sampah Anda</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="riwayat-container">
            <?php if (mysqli_num_rows($riwayat_query) > 0): ?>
                <?php while ($riwayat = mysqli_fetch_assoc($riwayat_query)): ?>
                    <div class="riwayat-card">
                        <div class="riwayat-header">
                            <div class="riwayat-date">
                                <h3><?php echo date('d F Y', strtotime($riwayat['tanggal_pickup'])); ?></h3>
                                <p><?php echo date('H:i', strtotime($riwayat['waktu_pickup'])); ?> WIB</p>
                            </div>
                            <span class="status-badge status-<?php echo $riwayat['status']; ?>">
                                <?php echo ucfirst($riwayat['status']); ?>
                            </span>
                        </div>
                        
                        <div class="riwayat-body">
                            <div class="info-row">
                                <span class="label">🗑️ Jenis Sampah:</span>
                                <span class="value"><?php echo ucfirst($riwayat['jenis_sampah']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="label">⚖️ Berat Estimasi:</span>
                                <span class="value"><?php echo $riwayat['berat_estimasi']; ?> kg</span>
                            </div>
                            <div class="info-row">
                                <span class="label">📍 Alamat:</span>
                                <span class="value"><?php echo $riwayat['alamat']; ?></span>
                            </div>
                            <?php if ($riwayat['catatan']): ?>
                                <div class="info-row">
                                    <span class="label">📝 Catatan:</span>
                                    <span class="value"><?php echo $riwayat['catatan']; ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="label">🕐 Dibuat:</span>
                                <span class="value"><?php echo date('d/m/Y H:i', strtotime($riwayat['created_at'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="riwayat-actions">
                            <?php if ($riwayat['status'] == 'pending'): ?>
                                <a href="edit_pickup.php?id=<?php echo $riwayat['id']; ?>" class="btn-edit">
                                    ✏️ Edit
                                </a>
                                <a href="?cancel=<?php echo $riwayat['id']; ?>" 
                                   class="btn-cancel"
                                   onclick="return confirm('Yakin ingin membatalkan permintaan ini?')">
                                    ❌ Batalkan
                                </a>
                            <?php endif; ?>
                            
                            <a href="?delete=<?php echo $riwayat['id']; ?>" 
                               class="btn-delete"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                🗑️ Hapus
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>Belum Ada Riwayat</h3>
                    <p>Anda belum memiliki riwayat penjemputan sampah</p>
                    <a href="pickup_request.php" class="btn-primary">Buat Permintaan Baru</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include '../templates/footer.php'; ?>
</body>
</html>

<style>
.riwayat-container {
    display: grid;
    gap: 20px;
}

.riwayat-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s;
}

.riwayat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

.riwayat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.riwayat-date h3 {
    margin-bottom: 5px;
    font-size: 20px;
}

.riwayat-date p {
    opacity: 0.9;
    font-size: 14px;
}

.riwayat-body {
    padding: 25px;
}

.info-row {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: 500;
    color: #666;
    min-width: 150px;
}

.info-row .value {
    color: #333;
    flex: 1;
}

.riwayat-actions {
    padding: 20px;
    background: #f8f9fa;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-edit, .btn-cancel, .btn-delete {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #2196F3;
    color: white;
}

.btn-edit:hover {
    background: #1976D2;
}

.btn-cancel {
    background: #FF9800;
    color: white;
}

.btn-cancel:hover {
    background: #F57C00;
}

.btn-delete {
    background: #f44336;
    color: white;
}

.btn-delete:hover {
    background: #d32f2f;
}

.empty-state {
    background: white;
    padding: 60px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
}

.empty-state p {
    color: #666;
    margin-bottom: 30px;
}

.btn-primary {
    display: inline-block;
    padding: 12px 30px;
    background: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: #45a049;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .riwayat-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .info-row {
        flex-direction: column;
        gap: 5px;
    }
    
    .info-row .label {
        min-width: auto;
    }
    
    .riwayat-actions {
        flex-direction: column;
    }
    
    .btn-edit, .btn-cancel, .btn-delete {
        width: 100%;
    }
}
</style>