<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_barang");

// TAMBAH BARANG
if(isset($_POST['addnew'])){
    $namabarang = $_POST ['namabarang'];
    $deskripsi = $_POST ['deskripsi'];
    $stock = $_POST ['stock'];

    $addtotable = mysqli_query($conn,"insert into barang (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");

    if ($addtotable){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
    
}

// BARANG MASUK
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST ['barangnya'];
    $pengirim = $_POST ['pengirim'];
    $penerima = $_POST ['penerima'];
    $qty = $_POST ['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from barang where id_barang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $menambahstock = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn,"insert into barang_masuk (id_barang, pengirim, penerima, qty) values('$barangnya','$pengirim','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update barang set stock = '$menambahstock' where id_barang='$barangnya'");

    if ($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    }else{
        echo 'Gagal';
        header('location:masuk.php');
    }
}

// BARANG KELUAR
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST ['barangnya'];
    $pengirim = $_POST ['pengirim'];
    $penerima = $_POST ['penerima'];
    $qty = $_POST ['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from barang where id_barang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $mengurangistock = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn,"insert into barang_keluar (id_barang, pengirim, penerima, qty) values('$barangnya','$pengirim','$penerima','$qty')");
    $updatestockkeluar = mysqli_query($conn, "update barang set stock = '$mengurangistock' where id_barang='$barangnya'");

    if ($addtokeluar&&$updatestockkeluar){
        header('location:keluar.php');
    }else{
        echo 'Gagal';
        header('location:keluar.php');
    }
}

// UPDATE BARANG
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "update barang set namabarang='$namabarang', deskripsi='$deskripsi' where id_barang='$idb'");
    if($update){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
    
}

// HAPUS BARANG
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from barang where id_barang='$idb'");
    if($hapus){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}

// UPDATE BARANG MASUK
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from barang where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from barang_masuk where id_masuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangi = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn,"update barang set stock= '$kurangi' where id_barang='$idb'");
        $updatenya = mysqli_query($conn,"update barang_masuk set qty='$qty', pengirim='$pengirim', penerima='$penerima' where id_masuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
                exit();
            } else {
                header('location:masuk.php?status=Gagal');
                exit();
            }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangi = $stockskrng - $selisih;

        $kurangistocknya = mysqli_query($conn,"update barang set stock= '$kurangi' where id_barang='$idb'");
        $updatenya = mysqli_query($conn,"update barang_masuk set qty='$qty', pengirim='$pengirim', penerima='$penerima' where id_masuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('location:masuk.php');
            } else {
                header('location:masuk.php?status=Gagal');
            }
    }
    
}

// HAPUS BARANG MASUK
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from barang where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"update barang set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from barang_masuk where id_masuk='$idm'");

            if($update&&$hapusdata){
                header('location:masuk.php');
            } else {
                header('location:masuk.php?status=Gagal');
            }
}

// UPDATE BARANG KELUAR
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $pengirim = $_POST['pengirim'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from barang where id_barang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrng = mysqli_query($conn, "select * from barang_keluar where id_keluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrng);
    $qtyskrng = $qtynya['qty'];

    if($qty>$qtyskrng){
        $selisih = $qty-$qtyskrng;
        $kurangi = $stockskrng - $selisih;

        $kurangistocknya = mysqli_query($conn,"update barang set stock= '$kurangi' where id_barang='$idb'");
        $updatenya = mysqli_query($conn,"update barang_keluar set qty='$qty', pengirim='$pengirim', penerima='$penerima' where id_keluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
                exit();
            } else {
                header('location:keluar.php?status=Gagal');
                exit();
            }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangi = $stockskrng + $selisih;

        $kurangistocknya = mysqli_query($conn,"update barang set stock= '$kurangi' where id_barang='$idb'");
        $updatenya = mysqli_query($conn,"update barang_keluar set qty='$qty', pengirim='$pengirim', penerima='$penerima' where id_keluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('location:keluar.php');
            } else {
                header('location:keluar.php?status=Gagal');
            }
    }
    
}

// HAPUS BARANG KELUAR
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from barang where id_barang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn,"update barang set stock='$selisih' where id_barang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from barang_keluar where id_keluar='$idk'");

            if($update&&$hapusdata){
                header('location:keluar.php');
            } else {
                header('location:keluar.php?status=Gagal');
            }
}