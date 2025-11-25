<?php
require_once 'function.php';
require_once 'cek.php';

if (!isset($_SESSION['log'])) {
    header('location:login.php');
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Barang Masuk</title>
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
                <h1 class="mt-4"><i class="fas fa-arrow-right mr-3"></i>Barang Masuk</h1>

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Tombol Tambah Barang Masuk (kiri) -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-plus"></i> Tambah Barang Masuk
                        </button>
                    </div>


                    <!-- Modal Tambah Barang Masuk -->
                    <div class="modal fade" id="modalTambah">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h4 class="modal-title">Tambah Barang Masuk</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <label for="id_detail">Nama Barang</label>
                                        <div class="mb-3">
                                            <input type="text" 
                                                class="form-control" 
                                                id="barang_search" 
                                                placeholder="Ketik nama barang..." 
                                                autocomplete="off">
                                            <input type="hidden" name="id_detail" id="id_detail" required>
                                            <div id="suggestions" style="
                                                display: none; 
                                                position: absolute; 
                                                width: 100%; 
                                                background: white; 
                                                border: 1px solid #ddd; 
                                                border-top: none; 
                                                max-height: 100px; 
                                                overflow-y: auto; 
                                                z-index: 1000;
                                                margin-top: -1px;
                                            "></div>
                                        </div>
                                        <label for="tanggal">Tanggal Masuk</label>
                                        <input type="date" name="tanggal" value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                        <br>
                                        <label for="jumlah">Jumlah Masuk</label>
                                        <input type="number" name="jumlah" placeholder="Jumlah Masuk" class="form-control" required>
                                        <br>
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" name="keterangan" placeholder="Keterangan" class="form-control">
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="barangmasuk">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="table-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Masuk</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ambildata = mysqli_query($conn, "
                                    SELECT 
                                        bm.id_masuk,
                                        bm.id_detail,
                                        bm.tanggal,
                                        b.namabarang,
                                        b.tahun,
                                        bm.jumlahmasuk,
                                        s.satuan,
                                        bm.keterangan
                                    FROM barang_masuk bm
                                    JOIN detail d ON bm.id_detail = d.id_detail
                                    JOIN barang b ON d.id_barang = b.id_barang
                                    JOIN addsatuan s ON d.id_satuan = s.id_satuan
                                    ORDER BY bm.tanggal DESC
                                ");

                                if (!$ambildata || mysqli_num_rows($ambildata) == 0) {
                                    echo '<tr><td colspan="7" class="text-center">Belum ada data barang masuk.</td></tr>';
                                } else {
                                    while ($data = mysqli_fetch_assoc($ambildata)) {
                                        $idm = $data['id_masuk'];
                                        $idd = $data['id_detail'];
                                ?>
                                    <tr>
                                        <td><?= date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                                        <td><?= htmlspecialchars($data['namabarang']); ?></td>
                                        <td><?= htmlspecialchars($data['tahun']); ?></td>
                                        <td><?= htmlspecialchars($data['jumlahmasuk']); ?></td>
                                        <td><?= htmlspecialchars($data['satuan']); ?></td>
                                        <td><?= htmlspecialchars($data['keterangan']); ?></td>
                                        <td class="d-flex justify-content-center" style="gap: 8px">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $idm; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $idm; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit<?= $idm; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning text-black">
                                                    <h4 class="modal-title">Edit Barang Masuk</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <label for="tanggal">Tanggal Masuk</label>
                                                        <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" class="form-control" required><br>
                                                        <label for="jumlah">Jumlah Masuk</label>
                                                        <input type="number" name="jumlah" value="<?= $data['jumlahmasuk']; ?>" class="form-control" required><br>
                                                        <label for="keterangan">Keterangan</label>
                                                        <input type="text" name="keterangan" value="<?= $data['keterangan']; ?>" class="form-control"><br>
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                        <input type="hidden" name="idd" value="<?= $idd; ?>">
                                                        <button type="submit" class="btn btn-primary" name="editbarangmasuk">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="hapus<?= $idm; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h4 class="modal-title">Hapus Barang Masuk</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus transaksi masuk untuk 
                                                        <b><?= htmlspecialchars($data['namabarang']); ?></b>?
                                                        <br><br>
                                                        <input type="hidden" name="idm" value="<?= $idm; ?>">
                                                        <input type="hidden" name="idd" value="<?= $data['id_detail']; ?>">
                                                        <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil data barang dari PHP ke JavaScript
    const barangData = [
        <?php
        $barang = mysqli_query($conn, "
            SELECT d.id_detail, b.namabarang, b.tahun
            FROM detail d
            JOIN barang b ON d.id_barang = b.id_barang
            ORDER BY b.namabarang ASC
        ");
        
        $items = [];
        while ($b = mysqli_fetch_assoc($barang)) {
            $items[] = '{
                id_detail: ' . $b['id_detail'] . ',
                namabarang: "' . addslashes($b['namabarang']) . '",
                tahun: "' . $b['tahun'] . '"
            }';
        }
        
        echo implode(",\n        ", $items);
        ?>
    ];

    // Ambil elemen
    const input = document.getElementById('barang_search');
    const hiddenInput = document.getElementById('id_detail');
    const suggestions = document.getElementById('suggestions');

    // Saat user mengetik
    input.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        suggestions.innerHTML = '';
        
        if (query.length < 2) {
            suggestions.style.display = 'none';
            return;
        }

        const filtered = barangData.filter(item =>
            item.namabarang.toLowerCase().includes(query) ||
            item.tahun.includes(query)
        );

        if (filtered.length === 0) {
            suggestions.style.display = 'none';
            return;
        }

        filtered.forEach(item => {
            const a = document.createElement('a');
            a.href = '#';
            a.textContent = item.namabarang + ' (' + item.tahun + ')';
            a.style.display = 'block';
            a.style.padding = '8px 12px';
            a.style.cursor = 'pointer';
            a.style.textDecoration = 'none';
            a.style.color = '#333';

            a.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = item.namabarang + ' (' + item.tahun + ')';
                hiddenInput.value = item.id_detail;
                suggestions.style.display = 'none';
            });

            suggestions.appendChild(a);
        });

        suggestions.style.display = 'block';
    });

    // Tutup saran jika klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.matches('#barang_search') && !e.target.closest('#suggestions')) {
            suggestions.style.display = 'none';
        }
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
