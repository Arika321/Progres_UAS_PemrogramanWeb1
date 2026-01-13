<header class="main-header">
    <div class="header-container">
        <div class="logo-section">
            <img src="../assets/img/trash_icon.png" alt="CleanTrash" class="header-logo">
            <span class="site-name">CleanTrash</span>
        </div>
        
        <nav class="main-nav">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="pickup_request.php" class="nav-link">Penjemputan</a>
            <a href="jadwal.php" class="nav-link">Jadwal</a>
            <a href="laporan.php" class="nav-link">Laporan</a>
            <a href="riwayat.php" class="nav-link">Riwayat</a>
        </nav>
        
        <div class="user-section">
            <span class="user-name"><?php echo $_SESSION['nama_lengkap']; ?></span>
            <a href="logout.php" class="btn-logout">Keluar</a>
        </div>
    </div>
</header>

<style>
.main-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    margin-bottom: 20px;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo-section {
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-logo {
    width: 40px;
    height: 40px;
}

.site-name {
    font-size: 24px;
    font-weight: bold;
    color: #4CAF50;
}

.main-nav {
    display: flex;
    gap: 25px;
}

.nav-link {
    text-decoration: none;
    color: #666;
    font-weight: 500;
    transition: color 0.3s;
}

.nav-link:hover {
    color: #4CAF50;
}

.user-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-name {
    color: #333;
    font-weight: 500;
}

.btn-logout {
    padding: 8px 20px;
    background: #dc3545;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-logout:hover {
    background: #c82333;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        gap: 15px;
    }
    
    .main-nav {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>