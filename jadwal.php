<?php
session_start();
require_once '../config/config.php';
require_once '../auth/auth_check.php';

// Ambil semua jadwal pengangkutan
$jadwal_query = mysqli_query($conn, "SELECT * FROM jadwal_pengangkutan WHERE status='aktif' ORDER BY 
    FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), waktu_mulai");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pengangkutan | CleanTrash</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>📅 Jadwal Pengangkutan Sampah</h1>
            <p>Lihat jadwal pengangkutan sampah di area Anda</p>
        </div>
        
        <div class="info-box">
            <h3>ℹ️ Informasi Penting</h3>
            <ul>
                <li>Pastikan sampah sudah dipilah sesuai jenisnya</li>
                <li>Letakkan sampah di depan rumah sebelum waktu pengangkutan</li>
                <li>Gunakan kantong/wadah yang sesuai untuk setiap jenis sampah</li>
            </ul>
        </div>
        
        <div class="jadwal-container">
            <?php 
            $current_hari = '';
            while ($jadwal = mysqli_fetch_assoc($jadwal_query)): 
                if ($current_hari != $jadwal['hari']):
                    if ($current_hari != '') echo '</div>'; // Close previous day
                    $current_hari = $jadwal['hari'];
            ?>
                <div class="jadwal-day">
                    <h2 class="day-header"><?php echo $jadwal['hari']; ?></h2>
            <?php endif; ?>
                    
                    <div class="jadwal-card">
                        <div class="jadwal-icon">
                            <?php 
                            switch($jadwal['jenis_sampah']) {
                                case 'Organik': echo '🍃'; break;
                                case 'Anorganik': echo '♻️'; break;
                                case 'B3': echo '⚠️'; break;
                                default: echo '🗑️';
                            }
                            ?>
                        </div>
                        <div class="jadwal-info">
                            <h3><?php echo $jadwal['area']; ?></h3>
                            <p class="jadwal-type">
                                <strong><?php echo $jadwal['jenis_sampah']; ?></strong>
                            </p>
                            <p class="jadwal-time">
                                ⏰ <?php echo date('H:i', strtotime($jadwal['waktu_mulai'])); ?> - 
                                <?php echo date('H:i', strtotime($jadwal['waktu_selesai'])); ?> WIB
                            </p>
                        </div>
                    </div>
            
            <?php endwhile; ?>
            <?php if ($current_hari != '') echo '</div>'; // Close last day ?>
        </div>
        
        <div class="legend-box">
            <h3>Keterangan Jenis Sampah:</h3>
            <div class="legend-grid">
                <div class="legend-item">
                    <span class="legend-icon">🍃</span>
                    <div>
                        <strong>Organik</strong>
                        <p>Sisa makanan, daun, ranting</p>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-icon">♻️</span>
                    <div>
                        <strong>Anorganik</strong>
                        <p>Plastik, kertas, kaleng, kaca</p>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-icon">⚠️</span>
                    <div>
                        <strong>B3 (Berbahaya)</strong>
                        <p>Baterai, lampu, obat kadaluarsa</p>
                    </div>
                </div>
                <div class="legend-item">
                    <span class="legend-icon">🗑️</span>
                    <div>
                        <strong>Campuran</strong>
                        <p>Berbagai jenis sampah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../templates/footer.php'; ?>
</body>
</html>

<style>
.info-box {
    background: #e3f2fd;
    border-left: 4px solid #2196F3;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.info-box h3 {
    margin-bottom: 15px;
    color: #1976D2;
}

.info-box ul {
    margin-left: 20px;
}

.info-box li {
    margin-bottom: 8px;
    color: #333;
}

.jadwal-container {
    margin-bottom: 30px;
}

.jadwal-day {
    margin-bottom: 30px;
}

.day-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-size: 24px;
}

.jadwal-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 15px;
    transition: transform 0.3s;
}

.jadwal-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

.jadwal-icon {
    font-size: 48px;
}

.jadwal-info {
    flex: 1;
}

.jadwal-info h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 8px;
}

.jadwal-type {
    color: #4CAF50;
    font-size: 16px;
    margin-bottom: 5px;
}

.jadwal-time {
    color: #666;
    font-size: 14px;
}

.legend-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.legend-box h3 {
    margin-bottom: 20px;
    color: #333;
}

.legend-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.legend-icon {
    font-size: 36px;
}

.legend-item strong {
    display: block;
    color: #333;
    margin-bottom: 5px;
}

.legend-item p {
    font-size: 13px;
    color: #666;
    margin: 0;
}

@media (max-width: 768px) {
    .jadwal-card {
        flex-direction: column;
        text-align: center;
    }
    
    .legend-grid {
        grid-template-columns: 1fr;
    }
}
</style>