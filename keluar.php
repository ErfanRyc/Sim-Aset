<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">DLH</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                                User
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-arrow-right"></i></div> 
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-arrow-left"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4"><i class="fas fa-arrow-left mr-3"></i>Barang Keluar</h1>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                              <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Input Barang
                            </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Pengirim</th>
                                                <th>Penerima</th>
                                                <th>Jumlah Keluar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambildatabase = mysqli_query($conn,"select * from barang_keluar bk, barang b where b.id_barang = bk.id_barang ");
                                            while ($data = mysqli_fetch_array($ambildatabase)){
                                                $idb = $data['id_barang'];
                                                $idk = $data['id_keluar'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];
                                                $pengirim = $data['pengirim'];
                                                $penerima = $data['penerima'];
                                                $jumlahkeluar = $data['qty'];
                                                $deskripsi = $data['deskripsi'];
                                            ?>
                                            <tr>
                                                <td><?=$tanggal?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$pengirim;?></td>
                                                <td><?=$jumlahkeluar;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idk;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?=$idk;?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                                                                            <!-- Header Edit Barang Keluar -->
                                                <div class="modal fade" id="edit<?=$idk;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                    
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit Barang</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="pengirim" value="<?=$pengirim;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control" required>
                                                                <br>
                                                                <input type="number" name="qty" value="<?=$jumlahkeluar;?>" class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                <button type="submit" class=" btn btn-primary" name="updatebarangkeluar">Ubah</button>
                                                            </div>
                                                            </form>
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                                                                <!-- Header Hapus Barang Keluar -->
                                                <div class="modal fade" id="hapus<?=$idk;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                    
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Hapus Barang</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <form method="post">
                                                            <div class="modal-body">
                                                                Apakah anda yakin untuk menghapus <?=$deskripsi, " ", $namabarang;?>?
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="kty" value="<?=$jumlahkeluar;?>">
                                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class=" btn btn-danger" name="hapusbarangkeluar">Hapus</button>
                                                            </div>
                                                            </form>
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            };
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang Keluar</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
             <form method="post">
            <div class="modal-body">
            
            <select name="barangnya" class="form-control">
                <?php
                    $ambilsemuadata = mysqli_query($conn,"select * from barang");
                    while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                        $namabarangnya = $fetcharray['namabarang'];
                        $idbarangnya = $fetcharray['id_barang'];
                    
                ?>
                
                <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>

                <?php
                    } 
                ?>
            </select>
            <br>
            <input type="text" name="pengirim" placeholder="Pengirim Barang" class="form-control" required>
            <br>
            <input type="text" name="penerima" placeholder="Penerima Barang" class="form-control" required>
            <br>
            <input type="number" name="qty" placeholder="Jumlah Barang" class="form-control" required>
            <br>
            <button type="submit" class=" btn btn-primary" name="barangkeluar">Tambahkan</button>
            </div>
            </form>
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
            
        </div>
        </div>
    </div>
</html>
