<?php
require 'function.php';
require 'cek.php';

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
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>User</title>
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
                        <h1 class="mt-4"><i class="fa fa-user mr-3"></i>User</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahuser">
                                    Tambah User
                                </button>
                                                                    <!-- Modal Tambah User -->
                                        <div class="modal fade" id="tambahuser">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h4 class="modal-title">Tambah User Baru</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form method="post">
                                                <div class="modal-body">
                                                <label for="username">Nama User</label>
                                                <input type="text" name="username" placeholder="Username" class="form-control" required><br>

                                                <label for="email">Email</label>
                                                <input type="email" name="email" placeholder="Masukkan email" class="form-control" required><br>

                                                <label for="password">Password</label>
                                                <input type="password" name="password" placeholder="Masukkan password" class="form-control" required><br>
                                                
                                                <label for="confirmpassword">Konfirmasi Password</label>
                                                <input type="password" name="confirmpassword" placeholder="Konfirmasi password" class="form-control" required><br>

                                                <label for="role">Role / Hak Akses</label>
                                                <select name="role" class="form-control" required>
                                                    <option value="">-- Pilih Role --</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="User">User</option>
                                                </select><br>

                                                <button type="submit" class="btn btn-primary" name="addnewuser">Simpan</button>
                                                </div>
                                            </form>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Role</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambildatabase = mysqli_query($conn,"select * from user");
                                            $i = 1;
                                            while ($data= mysqli_fetch_array($ambildatabase)){
                                                
                                                $role = $data['role'];
                                                $username = $data['username'];
                                                $email = $data['email'];
                                                $idu = $data['id_user'];
                                                ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$role;?></td>
                                                <td><?=$username;?></td>
                                                <td><?=$email;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idu;?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?=$idu;?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                                                                    <!-- Modal Edit User -->
                                                                                       
                                                <div class="modal fade" id="edit<?= $idu; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header bg-warning text-black">
                                                                <h4 class="modal-title">Edit User</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <form method="post">
                                                                <div class="modal-body">
                                                                    <label for="username">Nama User</label>
                                                                    <input type="text" name="username" value="<?= htmlspecialchars($username); ?>" class="form-control" required><br>

                                                                    <label for="email">Email</label>
                                                                    <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" class="form-control" required><br>

                                                                    <label for="role">Role / Hak Akses</label>
                                                                    <select name="role" class="form-control" required>
                                                                        <option value="">-- Pilih Role --</option>
                                                                        <option value="Admin" <?= ($role == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                                                        <option value="User" <?= ($role == 'User') ? 'selected' : ''; ?>>User</option>
                                                                    </select><br>

                                                                    <label for="password">Password (opsional)</label>
                                                                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="form-control"><br>

                                                                    <input type="hidden" name="idu" value="<?= $idu; ?>">

                                                                    <button type="submit" class="btn btn-primary" name="edituser">Simpan Perubahan</button>
                                                                </div>
                                                            </form>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                                                                <!-- Header Hapus User -->
                                                <div class="modal fade" id="hapus<?=$idu;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                    
                                                            <!-- Modal Header -->
                                                            <div class="modal-header bg-danger text-white">
                                                                <h4 class="modal-title">Hapus User</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <form method="post">
                                                            <div class="modal-body">
                                                                Apakah anda yakin untuk menghapus user <?=$username;?>?
                                                                <input type="hidden" name="idu" value="<?=$idu;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class=" btn btn-danger" name="hapususer">Hapus</button>
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
</html>