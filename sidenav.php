<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'User';
?>


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>Dashboard
                </a>

                <?php if ($role === 'Admin'): ?>
                <a class="nav-link" href="user.php">
                    <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>User
                </a>
                <?php endif; ?>

                <?php if ($role === 'Admin'): ?>
                <a class="nav-link" href="satuan.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></i></div>Satuan
                </a>
                <?php endif; ?>

                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>Daftar  Barang
                </a>

                <a class="nav-link" href="masuk.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-right"></i></div>Barang Masuk
                </a>

                <a class="nav-link" href="keluar.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-left"></i></div>Barang Keluar
                </a>

                <a class="nav-link" href="laporan.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>Laporan Barang
                </a>
                
                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>Logout
                </a>
            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small" style="font-size: 14px;">Login Sebagai:</div>
            <div style="font-size: 18px;">
                <?= htmlspecialchars($username); ?> (<?= htmlspecialchars($role); ?>)
            </div>
        </div>
    </nav>
</div>
