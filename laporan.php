<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    // Handle foto upload
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "laporan_" . time() . "." . $file_extension;
        $target_file = $target_dir . $foto;
        
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    }
    
    $query = "INSERT INTO laporan (user_id, judul, deskripsi, lokasi, foto, status) 
              VALUES ('$user_id', '$judul', '$deskripsi', '$lokasi', '$foto', 'pending')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Laporan berhasil dibuat! Tim kami akan meninjau laporan Anda.";
    } else {
        $error = "Gagal membuat laporan: " . mysqli_error($conn);
    }
}

// Ambil laporan user
$laporan_query = mysqli_query($conn, 
    "SELECT * FROM laporan WHERE user_id='" . $_SESSION['user_id'] . "' ORDER BY created_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | CleanTrash</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>📝 Buat Laporan Masalah Sampah</h1>
            <p>Laporkan masalah sampah di lingkungan Anda</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="content-grid">
            <!-- Form Laporan -->
            <div class="form-container">
                <h2>Formulir Laporan</h2>
                <form method="POST" enctype="multipart/form-data" class="laporan-form">
                    <div class="form-group">
                        <label>Judul Laporan *</label>
                        <input type="text" name="judul" required 
                               placeholder="Contoh: Tumpukan sampah di Jalan Merdeka">
                    </div>
                    
                    <div class="form-group">
                        <label>Deskripsi Masalah *</label>
                        <textarea name="deskripsi" rows="5" required 
                                  placeholder="Jelaskan masalah secara detail..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Lokasi *</label>
                        <input type="text" name="lokasi" required 
                               placeholder="Alamat lengkap lokasi masalah">
                    </div>
                    
                    <div class="form-group">
                        <label>Foto (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="file-input">
                        <small>Format: JPG, PNG, max 5MB</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">📤 Kirim Laporan</button>
                </form>
            </div>
            
            <!-- Riwayat Laporan -->
            <div class="laporan-list">
                <h2>Laporan Saya</h2>
                <?php if (mysqli_num_rows($laporan_query) > 0): ?>
                    <?php while ($laporan = mysqli_fetch_assoc($laporan_query)): ?>
                        <div class="laporan-item">
                            <div class="laporan-item-header">
                                <h3><?php echo $laporan['judul']; ?></h3>
                                <span class="status-badge status-<?php echo $laporan['status']; ?>">
                                    <?php echo ucfirst($laporan['status']); ?>
                                </span>
                            </div>
                            <p class="laporan-desc"><?php echo substr($laporan['deskripsi'], 0, 100); ?>...</p>
                            <div class="laporan-meta">
                                <span>📍 <?php echo $laporan['lokasi']; ?></span>
                                <span>🕐 <?php echo date('d/m/Y H:i', strtotime($laporan['created_at'])); ?></span>
                            </div>
                            <?php if ($laporan['foto']): ?>
                                <img src="../assets/uploads/<?php echo $laporan['foto']; ?>" 
                                     alt="Foto Laporan" class="laporan-foto">
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-message">
                        <p>Anda belum memiliki laporan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include '../templates/footer.php'; ?>
</body>
</html>

<style>
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.form-container, .laporan-list {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.form-container h2, .laporan-list h2 {
    margin-bottom: 25px;
    color: #333;
    font-size: 22px;
}

.laporan-form .form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #4CAF50;
}

.file-input {
    padding: 8px !important;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: #666;
    font-size: 13px;
}

.laporan-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 15px;
}

.laporan-item-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 10px;
}

.laporan-item h3 {
    font-size: 16px;
    color: #333;
    margin: 0;
}

.laporan-desc {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
    line-height: 1.5;
}

.laporan-meta {
    display: flex;
    gap: 15px;
    font-size: 13px;
    color: #999;
}

.laporan-foto {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-top: 10px;
}

.empty-message {
    text-align: center;
    padding: 40px;
    color: #999;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-ditinjau {
    background: #cfe2ff;
    color: #084298;
}

.status-selesai {
    background: #d1e7dd;
    color: #0f5132;
}

@media (max-width: 968px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}
</style>