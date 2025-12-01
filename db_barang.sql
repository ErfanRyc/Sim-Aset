-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2025 at 07:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `addsatuan`
--

CREATE TABLE `addsatuan` (
  `id_satuan` int NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addsatuan`
--

INSERT INTO `addsatuan` (`id_satuan`, `satuan`) VALUES
(18, 'Botol'),
(11, 'Box'),
(1, 'Buah'),
(4, 'Buku'),
(12, 'Dus'),
(10, 'Kotak'),
(8, 'Lusin'),
(3, 'Pack'),
(6, 'Pasang'),
(2, 'Pcs'),
(9, 'Rim'),
(7, 'Roll'),
(13, 'Set'),
(14, 'Tabung'),
(5, 'Unit');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `namabarang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tahun` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `namabarang`, `tahun`) VALUES
(1, 'Lenovo Ideapad', 2021),
(2, 'iPhone 15', 2022),
(3, 'Samsung S24', 2024),
(4, 'TV Samsung', 2024),
(5, 'Flashdisk', 2023),
(6, 'TV Samsung', 2025);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` int NOT NULL,
  `id_detail` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlahkeluar` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `id_detail`, `tanggal`, `jumlahkeluar`, `keterangan`) VALUES
(2, 2, '2025-11-05', 25, 'IT'),
(3, 1, '2025-11-05', 25, 'IT'),
(5, 4, '2022-12-17', 5, 'Gudang'),
(6, 5, '2025-11-17', 50, 'IT'),
(7, 2, '2025-11-17', 50, 'IT'),
(8, 4, '2025-11-20', 5, 'Sosmed'),
(9, 2, '2025-11-20', 10, 'Sosmed'),
(10, 6, '2025-11-22', 50, '-');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int NOT NULL,
  `id_detail` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlahmasuk` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `id_detail`, `tanggal`, `jumlahmasuk`, `keterangan`) VALUES
(2, 2, '2025-11-05', 50, 'Toko'),
(3, 1, '2025-11-05', 25, 'Toko'),
(5, 4, '2025-11-12', 15, 'Toko Samsung'),
(6, 4, '2025-11-12', 20, 'Toko Samsung'),
(7, 4, '2024-01-01', 50, 'Toko Samsung'),
(8, 5, '2024-06-18', 100, 'Toko'),
(9, 2, '2025-11-17', 25, 'Toko'),
(10, 6, '2025-11-22', 50, 'Toko Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_detail` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_satuan` int NOT NULL,
  `sisa` int DEFAULT NULL,
  `hargasatuan` int NOT NULL,
  `nilaipersediaan` int NOT NULL,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_detail`, `id_barang`, `id_satuan`, `sisa`, `hargasatuan`, `nilaipersediaan`, `keterangan`) VALUES
(1, 1, 5, 50, 15000000, 750000000, 'Gudang'),
(2, 2, 5, 40, 15000000, 600000000, 'Gudang'),
(3, 3, 5, 100, 20000000, 2000000000, 'Gudang'),
(4, 4, 5, 175, 5000000, 875000000, 'Gudang'),
(5, 5, 1, 100, 120000, 12000000, 'Gudang'),
(6, 6, 5, 100, 5000000, 500000000, 'Toko Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `role` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `role`, `username`, `email`, `password`) VALUES
(1, 'Admin', 'Erfan', 'erfan@gmail.com', '$2y$10$Y/qCMwGruBMlZjHmNQvS2e3tZ/UiLMeEnndIaOEge1DlVuLszQENS'),
(3, 'User', 'Ari', 'ari@gmail.com', '$2y$10$m/615uHtmPK5TMdAX7Tu2uMdCoQ/QhHrJ9jScKrVJDu0Tt6z4z02S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addsatuan`
--
ALTER TABLE `addsatuan`
  ADD PRIMARY KEY (`id_satuan`),
  ADD UNIQUE KEY `satuan` (`satuan`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indexes for table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addsatuan`
--
ALTER TABLE `addsatuan`
  MODIFY `id_satuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
