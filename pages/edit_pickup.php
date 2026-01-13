<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Ambil ID dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data pickup
$query = mysqli_query($conn, "SELECT * FROM pickup_requests WHERE id='$id' AND user_id='" . $_SESSION['user_id'] . "'");

if (mysqli_num_rows($query) == 0) {
    header("Location: riwayat.php");
    exit();
}

$data = mysqli_fetch_assoc($query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_sampah = mysqli_real_escape_string($conn, $_POST['jenis_sampah']);
    $berat_estimasi = mysqli_real_escape_string($conn, $_POST['berat_estimasi']);
    $tanggal_pickup = mysqli_real_escape_string($conn, $_POST['tanggal_pickup']);
    $waktu_pickup = mysqli_real_escape_string($conn, $_POST['waktu_pickup']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    
    $update_query = "UPDATE pickup_requests SET 
                     alamat='$alamat',
                     jenis_sampah='$jenis_sampah',
                     berat_estimasi='$berat_estimasi',
                     tanggal_pickup='$tanggal_pickup',
                     waktu_pickup='$waktu_pickup',
                     catatan='$catatan'
                     WHERE id='$id' AND user_id='" . $_SESSION['user_id'] . "'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Data berhasil diperbarui!";
        header("Location: riwayat.php");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penjemputan | CleanTrash</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>✏️ Edit Permintaan Penjemputan</h1>
            <p>Perbarui informasi permintaan penjemputan sampah</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" class="pickup-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Jenis Sampah *</label>
                        <select name="jenis_sampah" required>
                            <option value="organik" <?php echo ($data['jenis_sampah'] == 'organik') ? 'selected' : ''; ?>>Organik</option>
                            <option value="anorganik" <?php echo ($data['jenis_sampah'] == 'anorganik') ? 'selected' : ''; ?>>Anorganik</option>
                            <option value="b3" <?php echo ($data['jenis_sampah'] == 'b3') ? 'selected' : ''; ?>>B3</option>
                            <option value="campuran" <?php echo ($data['jenis_sampah'] == 'campuran') ? 'selected' : ''; ?>>Campuran</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Estimasi Berat (kg) *</label>
                        <input type="number" name="berat_estimasi" step="0.1" required 
                               value="<?php echo $data['berat_estimasi']; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Penjemputan *</label>
                        <input type="date" name="tanggal_pickup" required 
                               value="<?php echo $data['tanggal_pickup']; ?>"
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Waktu Penjemputan *</label>
                        <input type="time" name="waktu_pickup" required 
                               value="<?php echo $data['waktu_pickup']; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan" rows="3"><?php echo $data['catatan']; ?></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="riwayat.php" class="btn btn-secondary">Batal</a>
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

.alert-error {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>