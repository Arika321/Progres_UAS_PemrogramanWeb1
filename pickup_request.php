<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_sampah = mysqli_real_escape_string($conn, $_POST['jenis_sampah']);
    $berat_estimasi = mysqli_real_escape_string($conn, $_POST['berat_estimasi']);
    $tanggal_pickup = mysqli_real_escape_string($conn, $_POST['tanggal_pickup']);
    $waktu_pickup = mysqli_real_escape_string($conn, $_POST['waktu_pickup']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    
    $query = "INSERT INTO pickup_requests (user_id, alamat, jenis_sampah, berat_estimasi, tanggal_pickup, waktu_pickup, catatan, status) 
              VALUES ('$user_id', '$alamat', '$jenis_sampah', '$berat_estimasi', '$tanggal_pickup', '$waktu_pickup', '$catatan', 'pending')";
    
    if (mysqli_query($conn, $query)) {
        $success = "Permintaan penjemputan berhasil dibuat!";
    } else {
        $error = "Gagal membuat permintaan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Penjemputan | CleanTrash</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Request Penjemputan Sampah</h1>
            <p>Isi form di bawah untuk menjadwalkan penjemputan sampah</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" class="pickup-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="alamat" rows="3" required placeholder="Masukkan alamat lengkap untuk penjemputan"></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Sampah *</label>
                        <select name="jenis_sampah" required>
                            <option value="">Pilih Jenis Sampah</option>
                            <option value="organik">Organik (Sisa Makanan, Daun)</option>
                            <option value="anorganik">Anorganik (Plastik, Kertas, Kaleng)</option>
                            <option value="b3">B3 (Baterai, Lampu, Obat)</option>
                            <option value="campuran">Campuran</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Estimasi Berat (kg) *</label>
                        <input type="number" name="berat_estimasi" step="0.1" required placeholder="Contoh: 5.5">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Penjemputan *</label>
                        <input type="date" name="tanggal_pickup" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Waktu Penjemputan *</label>
                        <input type="time" name="waktu_pickup" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan" rows="3" placeholder="Tambahkan catatan jika perlu (opsional)"></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                    <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    <?php include '../templates/footer.php'; ?>
</body>
</html>

<style>
.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 32px;
    color: #333;
    margin-bottom: 10px;
}

.page-header p {
    color: #666;
}

.form-container {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.pickup-form .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #4CAF50;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.btn {
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: all 0.3s;
}

.btn-primary {
    background: #4CAF50;
    color: white;
}

.btn-primary:hover {
    background: #45a049;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.alert-error {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>