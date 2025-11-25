    <?php
    require 'function.php';
    require 'cek.php';

    if (!isset($_SESSION['log'])) {
        header('location:login.php');
        exit;
    }

    $username = $_SESSION['username'];
    $role = $_SESSION['role']; 

    $total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];

    $total_masuk = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT IFNULL(SUM(jumlahmasuk), 0) as total FROM barang_masuk 
        WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
    "))['total'];

    $total_keluar = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT IFNULL(SUM(jumlahkeluar), 0) as total FROM barang_keluar 
        WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
    "))['total'];

    $total_nilai = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT IFNULL(SUM(nilaipersediaan), 0) as total FROM detail
    "))['total'];

    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>Dashboard</title>
            <link href="css/styles.css" rel="stylesheet" />
            <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        </head>
        <body class="sb-nav-fixed">
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                    <img src="assets/img/logo_DLH_2.jpg" alt="Logo" style="height: 30px; margin-right: 8px; border-radius: 50%;">
                    <span style="font-family: 'Arial Rounded MT Bold', 'Segoe UI', sans-serif; font-weight: light; font-size: 20px; color: #fff; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                        UPSBA DLH
                    </span>
                </a>
                <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            </nav>

            <div id="layoutSidenav">
                <?php include 'sidenav.php'; ?>
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid">
                            <h1 class="mt-4"><i class="fas fa-home"></i> Dashboard</h1>

                            <div class="row">
                                <!-- Total Barang -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary text-white mb-4">
                                        <div class="card-body">
                                            <h4><?= number_format($total_barang); ?></h4>
                                            <p>Total Jenis Barang</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php">Lihat Barang</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Barang Masuk -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body">
                                            <h4><?= number_format($total_masuk); ?></h4>
                                            <p>Barang Masuk (Bulan Ini)</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="masuk.php">Lihat Barang Masuk</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Barang Keluar -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-warning text-white mb-4">
                                        <div class="card-body">
                                            <h4><?= number_format($total_keluar); ?></h4>
                                            <p>Barang Keluar (Bulan Ini)</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="keluar.php">Lihat Barang Keluar</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Nilai Persediaan -->
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">
                                            <h4>Rp <?= number_format($total_nilai, 0, ',', '.'); ?></h4>
                                            <p>Total Nilai Persediaan</p>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="index.php">Detail Barang</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="js/scripts.js"></script>
        </body>
    </html>
