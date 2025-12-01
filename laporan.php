<?php
require 'function.php';
require 'cek.php';

$allowed_types = ['', 'masuk', 'keluar'];
$tipe = isset($_GET['tipe']) && in_array($_GET['tipe'], $allowed_types) 
        ? $_GET['tipe'] 
        : '';


$bulan = !empty($_GET['bulan']) ? (int)$_GET['bulan'] : '';
$tahun = !empty($_GET['tahun']) ? (int)$_GET['tahun'] : '';

if ($tipe === 'masuk') {
    $queryFinal = "SELECT 
                       bm.tanggal, 
                       b.namabarang, 
                       s.satuan, 
                       bm.jumlahmasuk,
                       bm.keterangan AS keterangan_masuk
                   FROM barang_masuk bm
                   JOIN detail d ON bm.id_detail = d.id_detail
                   JOIN barang b ON d.id_barang = b.id_barang
                   JOIN addsatuan s ON d.id_satuan = s.id_satuan";

    $where = [];
    if ($bulan) $where[] = "MONTH(bm.tanggal) = $bulan";
    if ($tahun) $where[] = "YEAR(bm.tanggal) = $tahun";

    if (!empty($where)) {
        $queryFinal .= " WHERE " . implode(" AND ", $where);
    }

    $queryFinal .= " ORDER BY tanggal DESC";
    $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk'];
    $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk'];

} elseif ($tipe === 'keluar') {
    $queryFinal = "SELECT 
                       bk.tanggal, 
                       b.namabarang, 
                       s.satuan, 
                       bk.jumlahkeluar AS jumlah_keluar,
                       bk.keterangan AS keterangan_keluar
                   FROM barang_keluar bk
                   JOIN detail d ON bk.id_detail = d.id_detail
                   JOIN barang b ON d.id_barang = b.id_barang
                   JOIN addsatuan s ON d.id_satuan = s.id_satuan";

    $where = [];
    if ($bulan) $where[] = "MONTH(bk.tanggal) = $bulan";
    if ($tahun) $where[] = "YEAR(bk.tanggal) = $tahun";

    if (!empty($where)) {
        $queryFinal .= " WHERE " . implode(" AND ", $where);
    }

    $queryFinal .= " ORDER BY tanggal DESC";
    $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Keluar', 'Keterangan Keluar'];
    $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlah_keluar', 'keterangan_keluar'];

} else { 
    $queryMasuk = "SELECT 
                       bm.tanggal, 
                       b.namabarang, 
                       s.satuan, 
                       bm.jumlahmasuk,
                       bm.keterangan AS keterangan_masuk,
                       NULL AS jumlah_keluar,
                       NULL AS keterangan_keluar
                   FROM barang_masuk bm
                   JOIN detail d ON bm.id_detail = d.id_detail
                   JOIN barang b ON d.id_barang = b.id_barang
                   JOIN addsatuan s ON d.id_satuan = s.id_satuan";

    $queryKeluar = "SELECT 
                        bk.tanggal, 
                        b.namabarang, 
                        s.satuan, 
                        NULL AS jumlahmasuk,
                        NULL AS keterangan_masuk,
                        bk.jumlahkeluar AS jumlah_keluar,
                        bk.keterangan AS keterangan_keluar
                    FROM barang_keluar bk
                    JOIN detail d ON bk.id_detail = d.id_detail
                    JOIN barang b ON d.id_barang = b.id_barang
                    JOIN addsatuan s ON d.id_satuan = s.id_satuan";

    $where = [];
    if ($bulan) $where[] = "MONTH(tanggal) = $bulan";
    if ($tahun) $where[] = "YEAR(tanggal) = $tahun";

    if (!empty($where)) {
        $whereStr = " WHERE " . implode(" AND ", $where);
        $queryMasuk .= $whereStr;
        $queryKeluar .= $whereStr;
    }

    $queryFinal = $queryMasuk . " UNION ALL " . $queryKeluar;
    $queryFinal .= " ORDER BY tanggal DESC";
    $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk', 'Jumlah Keluar', 'Keterangan Keluar'];
    $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk', 'jumlah_keluar', 'keterangan_keluar'];
}

$result = mysqli_query($conn, $queryFinal);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Laporan Barang</title>
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
                <h1 class="mt-4"><i class="fas fa-file-alt mr-3"></i>Laporan Barang</h1>

                <form method="get" class="mb-3 d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex flex-wrap align-items-end">
                        <input type="hidden" name="page" value="laporan">
                        <div class="mr-2 mb-2">
                            <label>Bulan</label>
                            <select name="bulan" class="form-control">
                                <option value="">Semua</option>
                                <?php for($m=1;$m<=12;$m++): ?>
                                    <option value="<?= $m ?>" <?= ($bulan == $m) ? 'selected' : '' ?>>
                                        <?= date('F', mktime(0,0,0,$m,1)) ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mr-2 mb-2">
                            <label>Tahun</label>
                            <select name="tahun" class="form-control">
                                <option value="">Semua</option>
                                <?php
                                $tahunSekarang = date('Y');
                                for($t=$tahunSekarang; $t >= $tahunSekarang-5; $t--): ?>
                                    <option value="<?= $t ?>" <?= ($tahun == $t) ? 'selected' : '' ?>>
                                        <?= $t ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mr-2 mb-2">
                            <label>Transaksi</label>
                            <select name="tipe" class="form-control">
                                <option value="" <?= ($tipe === '') ? 'selected' : '' ?>>Semua</option>
                                <option value="masuk" <?= ($tipe === 'masuk') ? 'selected' : '' ?>>Masuk</option>
                                <option value="keluar" <?= ($tipe === 'keluar') ? 'selected' : '' ?>>Keluar</option>
                            </select>
                        </div>
                        <div class="ml-2 mb-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>

                    <div class="mb-2">
                        <?php
                        $qs = http_build_query([
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'tipe' => $tipe,
                            'page' => 'laporan'
                        ]);
                        ?>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Cetak Data
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="export.php?type=excel&<?= $qs ?>">
                                    <i class="fas fa-file-excel text-success"></i> Excel
                                </a>
                                <a class="dropdown-item" href="export.php?type=pdf&<?= $qs ?>" target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card mb-4">
                    <div class="card-body p-0">
                        <table id="dataTable" class="table table-bordered table-hover text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <?php foreach ($columns as $col): ?>
                                        <th><?= $col ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <?php foreach ($data_keys as $key): ?>
                                                <td><?= htmlspecialchars($row[$key] ?? '-') ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= count($columns) ?>" class="text-center text-muted">Tidak ada data sesuai filter.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</body>
</html>