<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanTrash - Aplikasi Manajemen Sampah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }
        
        .logo-large {
            font-size: 100px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        h1 {
            font-size: 56px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .tagline {
            font-size: 24px;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 15px 40px;
            font-size: 18px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-weight: bold;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
        
        .features {
            padding: 100px 20px;
            background: #f5f7fa;
        }
        
        .features h2 {
            text-align: center;
            font-size: 42px;
            margin-bottom: 60px;
            color: #333;
        }
        
        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }
        
        .feature-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .stats {
            padding: 80px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            text-align: center;
        }
        
        .stat-item h3 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .stat-item p {
            font-size: 18px;
            opacity: 0.9;
        }
        
        footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }
        
        footer p {
            margin: 5px 0;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 36px;
            }
            
            .tagline {
                font-size: 18px;
            }
            
            .logo-large {
                font-size: 60px;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="logo-large">🌿</div>
            <h1>CleanTrash</h1>
            <p class="tagline">Solusi Cerdas Manajemen Sampah untuk Lingkungan yang Lebih Bersih</p>
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">Masuk Sekarang</a>
                <a href="register.php" class="btn btn-secondary">Daftar Gratis</a>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features">
        <h2>✨ Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚛</div>
                <h3>Penjemputan Mudah</h3>
                <p>Jadwalkan penjemputan sampah dengan mudah melalui aplikasi. Pilih tanggal dan waktu sesuai kebutuhan Anda.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Jadwal Teratur</h3>
                <p>Lihat jadwal pengangkutan sampah di area Anda. Tidak perlu khawatir melewatkan jadwal pengangkutan.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Tracking Real-time</h3>
                <p>Pantau status permintaan Anda secara real-time. Dari pending hingga selesai, semua tercatat dengan baik.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📝</div>
                <h3>Laporan Masalah</h3>
                <p>Temukan masalah sampah? Laporkan dengan mudah lengkap dengan foto dan lokasi yang detail.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📄</div>
                <h3>Export Data</h3>
                <p>Export riwayat Anda dalam format PDF atau Excel untuk dokumentasi dan analisis lebih lanjut.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🌱</div>
                <h3>Ramah Lingkungan</h3>
                <p>Kontribusi Anda untuk lingkungan tercatat dalam bentuk CO₂ yang berhasil diselamatkan.</p>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>5,000+</h3>
                <p>Pengguna Aktif</p>
            </div>
            <div class="stat-item">
                <h3>15,000+</h3>
                <p>Penjemputan Selesai</p>
            </div>
            <div class="stat-item">
                <h3>50 Ton+</h3>
                <p>Sampah Terkumpul</p>
            </div>
            <div class="stat-item">
                <h3>25 Ton</h3>
                <p>CO₂ Terselamatkan</p>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date('Y'); ?> CleanTrash by NPM_NAMA_KELAS_UAS/WEB1</p>
        <p>Bandung, Indonesia | Universitas Teknologi Bandung</p>
        <p style="margin-top: 20px;">Departemen Bisnis Digital</p>
    </footer>
</body>
</html>