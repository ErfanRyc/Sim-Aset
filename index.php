<?php
require_once 'function.php';
require_once 'cek.php';

if (!isset($_SESSION['log'])) {
    header('location:login.php');
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$ambildatabase = mysqli_query($conn,"SELECT 
                                        b.id_barang,
                                        b.tahun,
                                        d.id_detail,
                                        b.namabarang,
                                        d.hargasatuan,
                                        d.id_satuan,
                                        s.satuan,
                                        d.sisa,
                                        d.nilaipersediaan,
                                        d.keterangan
                                    FROM detail d
                                    JOIN barang b ON d.id_barang = b.id_barang
                                    JOIN addsatuan s ON d.id_satuan = s.id_satuan
                                    ORDER BY b.namabarang ASC");
$data_barang = [];
while ($row = mysqli_fetch_assoc($ambildatabase)) {
    $data_barang[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Stok Barang</title>
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
                <h1 class="mt-4"><i class="fas fa-warehouse mr-3"></i>Daftar Barang</h1>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Barang</button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown">
                                <i class="fas fa-file-export"></i> Cetak Data
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="exportDropdown">
                                <a class="dropdown-item" href="export.php?type=excel"><i class="fas fa-file-excel text-success"></i> Excel</a>
                                <a class="dropdown-item" href="export.php?type=pdf" target="_blank"><i class="fas fa-file-pdf text-danger"></i> PDF</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Nilai Akhir Persediaan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; foreach($data_barang as $item): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($item['namabarang']); ?></td>
                                        <td><?= htmlspecialchars($item['tahun']); ?></td>
                                        <td><?= htmlspecialchars($item['sisa']); ?></td>
                                        <td><?= htmlspecialchars($item['satuan']); ?></td>
                                        <td><?= "Rp. " . number_format((float)$item['hargasatuan'], 0, ',', '.'); ?></td>
                                        <td><?= "Rp. " . number_format((float)$item['nilaipersediaan'], 0, ',', '.'); ?></td>
                                        <td><?= htmlspecialchars($item['keterangan']); ?></td>
                                        <td class="d-flex justify-content-center" style="gap: 2px">
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail<?= $item['id_detail']; ?>">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $item['id_detail']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $item['id_detail']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- MODAL Tambah Barang -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h4>Tambah Barang Baru</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <form method="post">
                <div class="modal-body">
                    <label>Nama Barang</label>
                    <input type="text" name="namabarang" placeholder="Nama barang" class="form-control" required><br>
                    <label>Tahun</label>
                    <input type="number" name="tahun" placeholder="Tahun" class="form-control" required><br>
                    <label>Stok</label>
                    <input type="number" name="sisa" placeholder= "Stok"class="form-control" required><br>
                    <label>Satuan</label>
                    <select name="satuannya" class="form-control" required>
                        <option disabled selected>-- Pilih Satuan --</option>
                        <?php
                        $ambildatasatuan = mysqli_query($conn,"SELECT * from addsatuan");
                        while($s = mysqli_fetch_assoc($ambildatasatuan)){
                            echo "<option value='{$s['id_satuan']}'>{$s['satuan']}</option>";
                        }
                        ?>
                    </select><br>
                    <label>Harga Satuan</label>
                    <input type="text" id="hargasatuan_display" class="form-control" placeholder="Masukkan harga (Rp)" oninput="formatRupiahInput(this)">
                    <input type="hidden" name="hargasatuan" id="hargasatuan_hidden">
                    <br><label>Keterangan</label>
                    <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" required><br>
                    <button type="submit" class="btn btn-primary" name="addnew">Tambahkan</button>
                </div>
            </form>
            <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
        </div>
    </div>
</div>

<!-- MODAL: Detail, Edit, Hapus (Looping semua barang) -->
<?php foreach($data_barang as $item): ?>
    <!-- Modal Histori -->
    <div class="modal fade" id="detail<?= $item['id_detail']; ?>" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header text-black">
                    <h5 class="modal-title">Histori Barang : <?= htmlspecialchars($item['namabarang']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h6 class="text-success">Barang Masuk</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-success text-white">
                                <tr><th>Tanggal</th><th>Jumlah Masuk</th><th>Keterangan</th></tr>
                            </thead>
                            <tbody>
                            <?php
                            $masuk = mysqli_query($conn,"SELECT tanggal,jumlahmasuk,keterangan FROM barang_masuk WHERE id_detail='{$item['id_detail']}' ORDER BY tanggal DESC");
                            if(mysqli_num_rows($masuk)>0){
                                while($m=mysqli_fetch_assoc($masuk)){
                                    echo "<tr><td>{$m['tanggal']}</td><td>{$m['jumlahmasuk']}</td><td>{$m['keterangan']}</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada data masuk</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <h6 class="text-danger mt-3">Barang Keluar</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-danger text-white">
                                <tr><th>Tanggal</th><th>Jumlah Keluar</th><th>Keterangan</th></tr>
                            </thead>
                            <tbody>
                            <?php
                            $keluar = mysqli_query($conn,"SELECT tanggal,jumlahkeluar,keterangan FROM barang_keluar WHERE id_detail='{$item['id_detail']}' ORDER BY tanggal DESC");
                            if(mysqli_num_rows($keluar)>0){
                                while($k=mysqli_fetch_assoc($keluar)){
                                    echo "<tr><td>{$k['tanggal']}</td><td>{$k['jumlahkeluar']}</td><td>{$k['keterangan']}</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada data keluar</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="edit<?= $item['id_detail']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-black"><h4>Edit Barang</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                <form method="post">
                    <div class="modal-body">
                        <label>Nama Barang</label>
                        <input type="text" name="namabarang" class="form-control" value="<?= $item['namabarang']; ?>" required><br>
                        <label>Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="<?= $item['tahun']; ?>" required><br>
                        <label>Stok</label>
                        <input type="text" name="sisa" class="form-control" value="<?= $item['sisa']; ?>" required><br>
                        <label>Satuan</label>
                        <select name="satuan" class="form-control" required>
                            <?php
                            $satuan_db = mysqli_query($conn,"SELECT * FROM addsatuan");
                            while($s=mysqli_fetch_assoc($satuan_db)){
                                $sel = ($s['id_satuan']==$item['id_satuan'])?'selected':'';
                                echo "<option value='{$s['id_satuan']}' $sel>{$s['satuan']}</option>";
                            }
                            ?>
                        </select><br>
                        <label>Harga Satuan</label>
                        <input type="text" id="hargasatuan_display_<?= $item['id_detail']; ?>" class="form-control" value="<?= number_format($item['hargasatuan'],0,',','.'); ?>" oninput="formatRupiahInput(this,'hargasatuan_hidden_<?= $item['id_detail']; ?>')">
                        <input type="hidden" name="hargasatuan" id="hargasatuan_hidden_<?= $item['id_detail']; ?>" value="<?= $item['hargasatuan']; ?>"><br>
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="<?= $item['keterangan']; ?>" required><br>
                        <input type="hidden" name="idb" value="<?= $item['id_barang']; ?>">
                        <input type="hidden" name="idd" value="<?= $item['id_detail']; ?>">
                        <button type="submit" class="btn btn-primary" name="updatebarang">Edit</button>
                    </div>
                </form>
                <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="hapus<?= $item['id_detail']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white"><h4>Hapus Barang</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                <form method="post">
                    <div class="modal-body">
                        Apakah anda yakin untuk menghapus <?= $item['namabarang']; ?>?
                        <input type="hidden" name="idb" value="<?= $item['id_barang']; ?>">
                        <input type="hidden" name="idd" value="<?= $item['id_detail']; ?>"><br><br>
                        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                    </div>
                </form>
                <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>

<script>
function formatRupiahInput(input, hiddenId='hargasatuan_hidden') {
    let angka = input.value.replace(/[^,\d]/g, '');
    let split = angka.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    input.value = 'Rp ' + rupiah;

    document.getElementById(hiddenId).value = angka;
}
</script>
</body>
</html>
