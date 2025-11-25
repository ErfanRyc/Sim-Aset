<?php
session_start();

if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];
$ambil = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
$userData = mysqli_fetch_assoc($ambil);

if (!$userData) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = $userData['role'];
}

if (basename($_SERVER['PHP_SELF']) == 'user.php' && $_SESSION['role'] != 'Admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk Admin.');window.location='dashboard.php';</script>";
    exit;
}
?>
