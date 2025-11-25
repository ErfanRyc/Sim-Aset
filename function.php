<?php

$conn = mysqli_connect("localhost", "root", "", "db_barang");

// TAMBAH USER
if(isset($_POST['addnewuser'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $role = $_POST['role'];

    if($password !== $confirmpassword){
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok!');window.location='user.php';</script>";
        exit;
    }

    if (!in_array($role, ['Admin', 'User'])) {
        echo "<script>alert('Role tidak valid!');window.location='user.php';</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $tambah = mysqli_query($conn, "INSERT INTO user (username, email, password, role)
                                   VALUES ('$username', '$email', '$hashed_password', '$role')");

    if($tambah){
        echo "<script>alert('User berhasil ditambahkan!');window.location='user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user!');window.location='user.php';</script>";
    }
}

// EDIT USER
if(isset($_POST['edituser'])){
    $idu = $_POST['idu'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!in_array($role, ['Admin', 'User'])) {
        echo "<script>alert('Role tidak valid!');window.location='user.php';</script>";
        exit;
    }

    if(empty($password)){
        $query = "UPDATE user SET username='$username', email='$email', role='$role' WHERE id_user='$idu'";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET username='$username', email='$email', password='$hashed_password', role='$role' WHERE id_user='$idu'";
    }

    $update = mysqli_query($conn, $query);

    if($update){
        echo "<script>alert('User berhasil diperbarui!');window.location='user.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui user!');window.location='user.php';</script>";
    }
}

// HAPUS USER
if(isset($_POST['hapususer'])){
    $idu = $_POST['idu'];

    $hapususer = mysqli_query($conn, "DELETE from user where id_user='$idu'");

    if ($hapususer){
        echo "<script>alert('User berhasil dihapus!'); window.location='user.php';</script>";
    }else{
        echo 'Gagal';
        header('location:user.php');
        exit;
    }
    
}

// TAMBAH SATUAN
if(isset($_POST['tambahsatuan'])){
    $satuan = $_POST['addsatuan'];

    $tambah_satuan = mysqli_query($conn, "INSERT INTO addsatuan (satuan) VALUES ('$satuan')");

    if ($tambah_satuan) {
        echo "<script>alert('Satuan berhasil ditambahkan!'); window.location='satuan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan satuan!'); window.location='satuan.php';</script>";
    }
}

// EDIT SATUAN
if(isset($_POST['editsatuan'])){
    $ids = $_POST['ids'];
    $satuan = $_POST['satuan'];

    $update_satuan = mysqli_query($conn, "UPDATE addsatuan SET 
                                        satuan= '$satuan'
                                        WHERE id_satuan = '$ids'");

    if ($update_satuan) {
        echo "<script>alert('Satuan berhasil diedit!'); window.location='satuan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengedit satuan!'); window.location='satuan.php';</script>";
    }
}

// HAPUS SATUAN
if (isset($_POST['hapussatuan'])) {
    $ids = $_POST['ids']; 

    $hapussatuan = mysqli_query($conn, "DELETE FROM addsatuan WHERE id_satuan = '$ids'");

    if ($hapussatuan) {
        echo "<script>alert('Satuan berhasil dihapus!'); window.location='satuan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus satuan!'); window.location='satuan.php';</script>";
    }
}

// TAMBAH BARANG
if (isset($_POST['addnew'])) {
    $namabarang = $_POST ['namabarang'];
    $tahun = $_POST ['tahun'];
    $sisa = $_POST ['sisa'];
    $satuannya = $_POST ['satuannya'];
    $hargasatuan = $_POST ['hargasatuan'];
    $keterangan = $_POST ['keterangan'];

    $nilaipersediaan = $sisa * $hargasatuan;

    $addbarang = mysqli_query($conn, "
        INSERT into barang (namabarang, tahun)
        VALUES ('$namabarang', '$tahun')");
    
    if($addbarang){
        $id_barang = mysqli_insert_id($conn);
 
        $adddetail = mysqli_query($conn, "
        INSERT into detail (id_barang, id_satuan, sisa, hargasatuan, nilaipersediaan, keterangan)
        VALUES ('$id_barang', '$satuannya', '$sisa', '$hargasatuan', '$nilaipersediaan', '$keterangan')
    ");

    if ($adddetail) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data detail');</script>";
        }
    } else {
        echo "<script>alert('Gagal menambahkan data barang');</script>";
    }
}

// EDIT DAFTAR BARANG
if(isset($_POST['updatebarang'])){
        $idb = $_POST['idb'];
        $idd = $_POST['idd'];
        $namabarang = $_POST['namabarang'];
        $tahun = $_POST['tahun'];
        $sisa = $_POST['sisa'];
        $satuan = $_POST['satuan'];
        $hargasatuan = $_POST['hargasatuan'];
        $keterangan = $_POST['keterangan'];

        $nilaipersediaan = $sisa * $hargasatuan;


        $update_barang = mysqli_query($conn, "UPDATE barang SET 
                                            namabarang= '$namabarang',
                                            tahun = '$tahun'
                                            WHERE id_barang = '$idb'");

        if (!$update_barang) {
            echo "<script>alert('Gagal mengedit data!'); window.location='index.php';</script>";
        }
    
        $update_detail = mysqli_query($conn, "UPDATE detail SET 
                                            id_satuan = '$satuan', 
                                            sisa = '$sisa', 
                                            hargasatuan = '$hargasatuan', 
                                            nilaipersediaan = '$nilaipersediaan',
                                            keterangan = '$keterangan'
                                            WHERE id_detail = '$idd'");

        if (!$update_detail) {
            echo "<script>alert('Gagal mengedit data!'); window.location='index.php';</script>";
        }

        if ($update_barang && $update_detail) {
            echo "<script>alert('Data berhasil diedit!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal mengedit data!'); window.location='index.php';</script>";
        }
}

// HAPUS DAFTAR BARANG 
if (isset($_POST['hapusbarang'])) {
    $idd = $_POST['idd']; 

    $ambilidbarang = mysqli_query($conn, "SELECT id_barang FROM detail WHERE id_detail = '$idd'");
    $dataidb = mysqli_fetch_array($ambilidbarang);
    $idb = $dataidb['id_barang'];

    $hapusdetail = mysqli_query($conn, "DELETE FROM detail WHERE id_detail = '$idd'");

    $hapusbarang = mysqli_query($conn, "DELETE FROM barang WHERE id_barang = '$idb'");

    if ($hapusdetail && $hapusbarang) {
        echo "<script>alert('Barang dan detail berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}


// INPUT BARANG MASUK
if (isset($_POST['barangmasuk'])) {

    $id_detail = $_POST['id_detail'];
    $tanggal = $_POST['tanggal'];
    $jumlahmasuk = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    if (empty($id_detail) || $jumlahmasuk <= 0) {
        echo "<script>alert('Data tidak valid. Barang tidak ditemukan dan pastikan jumlah > 0.'); window.location='masuk.php';</script>";
        exit();
    }

    $cekdetail = mysqli_query($conn, "SELECT * FROM detail WHERE id_detail='$id_detail'");
    if (mysqli_num_rows($cekdetail) === 0) {
        echo "<script>alert('Detail barang tidak ditemukan. Pastikan barang sudah terdaftar di daftar barang.'); window.location='masuk.php';</script>";
        exit();
    }

    $insert = mysqli_query($conn, "
        INSERT INTO barang_masuk (id_detail, tanggal, jumlahmasuk, keterangan)
        VALUES ('$id_detail', '$tanggal', '$jumlahmasuk', '$keterangan')
    ");

    if ($insert) {
        $ambildetail = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
        $data = mysqli_fetch_assoc($ambildetail);
        $sisa_lama = $data['sisa'];
        $harga_satuan = $data['hargasatuan'];

        $sisa_baru = $sisa_lama + $jumlahmasuk;
        $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

        $updatestok = mysqli_query($conn, "
            UPDATE detail 
            SET sisa = '$sisa_baru', nilaipersediaan = '$nilai_persediaan_baru'
            WHERE id_detail='$id_detail'
        ");

        if ($updatestok) {
            echo "<script>alert('Barang masuk berhasil dicatat dan nilai persediaan diperbarui!'); window.location='masuk.php';</script>";
        } else {
            echo "<script>alert('Barang masuk berhasil dicatat, tetapi gagal memperbarui stok/nilai persediaan.'); window.location='masuk.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mencatat barang masuk. Periksa kembali data Anda.'); window.location='masuk.php';</script>";
    }
}

// EDIT BARANG MASUK
if (isset($_POST['editbarangmasuk'])) {

    $id_masuk = $_POST['idm'];
    $id_detail = $_POST['idd'];
    $tanggal = $_POST['tanggal'];
    $jumlahbaru = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $ambil_data_lama = mysqli_query($conn, "SELECT jumlahmasuk FROM barang_masuk WHERE id_masuk='$id_masuk'");
    $data_lama = mysqli_fetch_assoc($ambil_data_lama);
    $jumlahlama = $data_lama['jumlahmasuk'];

    $selisih = $jumlahbaru - $jumlahlama;

    $update_masuk = mysqli_query($conn, "
        UPDATE barang_masuk 
        SET jumlahmasuk='$jumlahbaru', tanggal='$tanggal', keterangan='$keterangan'
        WHERE id_masuk='$id_masuk'
    ");

    if ($update_masuk) {
        $ambildetail = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
        $data = mysqli_fetch_assoc($ambildetail);
        $sisa_lama = $data['sisa'];
        $harga_satuan = $data['hargasatuan'];

        $sisa_baru = $sisa_lama + $selisih;
        $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

        $update_stok = mysqli_query($conn, "
            UPDATE detail 
            SET sisa='$sisa_baru', nilaipersediaan='$nilai_persediaan_baru'
            WHERE id_detail='$id_detail'
        ");

        if ($update_stok) {
            echo "<script>alert('Data barang masuk berhasil diubah!'); window.location='masuk.php';</script>";
        } else {
            echo "<script>alert('Data masuk terupdate, tapi stok gagal diperbarui.'); window.location='masuk.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mengedit data barang masuk.'); window.location='masuk.php';</script>";
    }
}

// HAPUS BARANG MASUK
if (isset($_POST['hapusbarangmasuk'])) {

    $id_masuk = $_POST['idm'];
    $id_detail = $_POST['idd'];

    $ambil_jumlah = mysqli_query($conn, "SELECT jumlahmasuk FROM barang_masuk WHERE id_masuk='$id_masuk'");
    $data = mysqli_fetch_assoc($ambil_jumlah);

    if (!$data) {
        echo "<script>alert('Data barang masuk tidak ditemukan!'); window.location='masuk.php';</script>";
        exit();
    }

    $jumlahhapus = $data['jumlahmasuk'];

    $ambil_stok = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
    $stok = mysqli_fetch_assoc($ambil_stok);

    if (!$stok) {
        echo "<script>alert('Detail barang tidak ditemukan!'); window.location='masuk.php';</script>";
        exit();
    }

    $sisa_lama = $stok['sisa'];
    $harga_satuan = $stok['hargasatuan'];

    $sisa_baru = $sisa_lama - $jumlahhapus;
    if ($sisa_baru < 0) $sisa_baru = 0; 

    $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

    $update_stok = mysqli_query($conn, "
        UPDATE detail 
        SET sisa='$sisa_baru', nilaipersediaan='$nilai_persediaan_baru'
        WHERE id_detail='$id_detail'
    ");

    if ($update_stok) {
        $hapus = mysqli_query($conn, "DELETE FROM barang_masuk WHERE id_masuk='$id_masuk'");

        if ($hapus) {
            echo "<script>alert('Data barang masuk berhasil dihapus dan stok diperbarui!'); window.location='masuk.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data barang masuk.'); window.location='masuk.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal memperbarui stok setelah penghapusan.'); window.location='masuk.php';</script>";
    }
}



// INPUT BARANG KELUAR
if (isset($_POST['barangkeluar'])) {
    $id_detail = $_POST['id_detail'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $ambil = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
    $data = mysqli_fetch_assoc($ambil);
    $sisa_sekarang = $data['sisa'];
    $harga_satuan = $data['hargasatuan'];

    if ($jumlah > $sisa_sekarang) {
        echo "<script>alert('Jumlah keluar melebihi stok tersedia!'); window.location='keluar.php';</script>";
        exit;
    }

    $sisa_baru = $sisa_sekarang - $jumlah;
    $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

    $addtokeluar = mysqli_query($conn, "
        INSERT INTO barang_keluar (id_detail, tanggal, jumlahkeluar, keterangan) 
        VALUES ('$id_detail', '$tanggal', '$jumlah', '$keterangan')
    ");

    if ($addtokeluar) {
        $update_detail = mysqli_query($conn, "
            UPDATE detail 
            SET sisa='$sisa_baru', nilaipersediaan='$nilai_persediaan_baru'
            WHERE id_detail='$id_detail'
        ");

        if ($update_detail) {
            echo "<script>alert('Data barang keluar berhasil ditambahkan!'); window.location='keluar.php';</script>";
        } else {
            echo "<script>alert('Data keluar tersimpan, tapi stok gagal diperbarui.'); window.location='keluar.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal menambahkan barang keluar.'); window.location='keluar.php';</script>";
    }
}


// UPDATE BARANG KELUAR
if (isset($_POST['editbarangkeluar'])) {
    $id_keluar = $_POST['idk'];
    $id_detail = $_POST['idd'];
    $tanggal = $_POST['tanggal'];
    $jumlahbaru = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $ambil_data_lama = mysqli_query($conn, "SELECT jumlahkeluar FROM barang_keluar WHERE id_keluar='$id_keluar'");
    $data_lama = mysqli_fetch_assoc($ambil_data_lama);
    $jumlahlama = $data_lama['jumlahkeluar'];

    $selisih = $jumlahbaru - $jumlahlama;

    $ambil_detail = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
    $data_detail = mysqli_fetch_assoc($ambil_detail);
    $sisa_lama = $data_detail['sisa'];
    $harga_satuan = $data_detail['hargasatuan'];

    $sisa_baru = $sisa_lama - $selisih;
    if ($sisa_baru < 0) {
        echo "<script>alert('Stok tidak mencukupi untuk pembaruan data!'); window.location='keluar.php';</script>";
        exit;
    }

    $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

    $update_keluar = mysqli_query($conn, "
        UPDATE barang_keluar 
        SET jumlahkeluar='$jumlahbaru', tanggal='$tanggal', keterangan='$keterangan'
        WHERE id_keluar='$id_keluar'
    ");

    if ($update_keluar) {
        $update_detail = mysqli_query($conn, "
            UPDATE detail 
            SET sisa='$sisa_baru', nilaipersediaan='$nilai_persediaan_baru'
            WHERE id_detail='$id_detail'
        ");

        if ($update_detail) {
            echo "<script>alert('Data barang keluar berhasil diubah!'); window.location='keluar.php';</script>";
        } else {
            echo "<script>alert('Data keluar terupdate, tapi stok gagal diperbarui.'); window.location='keluar.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal mengedit data barang keluar.'); window.location='keluar.php';</script>";
    }
}



// HAPUS BARANG KELUAR
if (isset($_POST['hapusbarangkeluar'])) {
    $id_keluar = $_POST['idk'];
    $id_detail = $_POST['idd'];

    $ambil = mysqli_query($conn, "SELECT jumlahkeluar FROM barang_keluar WHERE id_keluar='$id_keluar'");
    $data = mysqli_fetch_assoc($ambil);
    $jumlah_keluar = $data['jumlahkeluar'];

    $ambil_detail = mysqli_query($conn, "SELECT sisa, hargasatuan FROM detail WHERE id_detail='$id_detail'");
    $data_detail = mysqli_fetch_assoc($ambil_detail);
    $sisa_lama = $data_detail['sisa'];
    $harga_satuan = $data_detail['hargasatuan'];

    $sisa_baru = $sisa_lama + $jumlah_keluar;
    $nilai_persediaan_baru = $sisa_baru * $harga_satuan;

    $hapusdata = mysqli_query($conn, "DELETE FROM barang_keluar WHERE id_keluar='$id_keluar'");

    if ($hapusdata) {
        $update_detail = mysqli_query($conn, "
            UPDATE detail 
            SET sisa='$sisa_baru', nilaipersediaan='$nilai_persediaan_baru'
            WHERE id_detail='$id_detail'
        ");

        if ($update_detail) {
            echo "<script>alert('Data barang keluar berhasil dihapus dan stok diperbarui!'); window.location='keluar.php';</script>";
        } else {
            echo "<script>alert('Data keluar dihapus, tapi stok gagal diperbarui.'); window.location='keluar.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus data barang keluar.'); window.location='keluar.php';</script>";
    }
}