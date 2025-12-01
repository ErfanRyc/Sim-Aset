-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2025 at 01:03 AM
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
(1, ' Conector RJ45 ', 2025),
(2, ' Kubus Apung ', 2025),
(3, ' Kubus Apung ', 2024),
(4, ' Distance Disc ', 2025),
(5, ' Distance Disc / Kubus Apung ', 2024),
(6, ' Connecting Screw ', 2025),
(7, ' Connecting Screw / Kubus Apung ', 2024),
(8, ' Short Connecting Pin ', 2025),
(9, ' Short Connecting Pin / Kubus Apung ', 2024),
(10, ' Jaring Truk Sampah ', 2024),
(11, ' Jaring Truk Sampah ', 2025),
(12, ' Masker N95 ', 2025),
(13, ' Baterai AAA ', 2025),
(14, ' Baterai AAA ', 2024),
(15, ' Baterai AA ', 2025),
(16, ' Baterai AA ', 2024),
(17, ' Tali Tambang Plastik ', 2024),
(18, ' MCB Kapasitas 40A/ 6 Ka, 230/240V (1 Phase) ', 2024),
(19, ' Thinner HG Bahan / Material campuran pengencer cat dasar, cepat kering ', 2024),
(20, ' Double Tape Uk. 1inc ', 2025),
(21, ' Lakban 2 inch ', 2025),
(22, ' Lakban 2 inch ', 2024),
(23, ' Lakban Opp Bening ', 2025),
(24, ' Lem Cair ', 2025),
(25, ' Spidol White Board Marker G12 ', 2025),
(26, ' Bold Liner Pro isi 12 ', 2025),
(27, ' Ballpoint 1.0 ', 2025),
(28, ' Pensil 2B ', 2025),
(29, ' Spidol White Board BG12 ', 2025),
(30, ' Kertas Post It 653 ', 2025),
(31, ' Kertas Post It 657 ', 2025),
(32, ' Post It Tab 5 Warna ', 2025),
(33, ' Gunting Sedang, Stainless ', 2025),
(34, ' Buku Folio 100 lembar ', 2024),
(35, ' Buku Folio 100 lembar ', 2025),
(36, ' Buku Folio 500 lembar ', 2025),
(37, ' Cutter L-500 ', 2025),
(38, ' Isi Cutter ', 2024),
(39, ' Isi Cutter L-500 Cutter  Bkade L-150 ', 2025),
(40, ' Isi Staples Kecil No. 10 ', 2024),
(41, ' Isi Staples Kecil No. 10 ', 2025),
(42, ' Isi Staples Kecil No.3 Max ', 2024),
(43, ' Isi Staples Kecil No.3 Max ', 2025),
(44, ' Kertas A3 80 Gram ', 2025),
(45, ' Kertas A4 80 Gram ', 2025),
(46, ' Kertas F4 80 Gram ', 2025),
(47, ' Box File 4010 ', 2025),
(48, ' Map Buffalo 5002 ', 2025),
(49, ' Map Ordner uk. Folio ', 2025),
(50, ' Map Snellhecter Plastik ', 2025),
(51, ' Ordner Plastik 1465 ', 2025),
(52, ' Stop Map Folio 5001 ', 2025),
(53, ' Penggaris Besi 30Cm ', 2025),
(54, ' Penghapus/Korektor Kertas Bukan Cair ', 2025),
(55, ' Binder Clip No.260 ', 2025),
(56, ' Binder Clip No.200 ', 2025),
(57, ' Binder Clip No.155 ', 2025),
(58, ' Binder Clip No.155 ', 2024),
(59, ' Binder Clip No.105 ', 2025),
(60, ' Binder Clip No.107 ', 2025),
(61, ' Paper Clip No. 3 ', 2025),
(62, ' Paper Clip No. 5 ', 2025),
(63, ' Staples No. 10  ', 2025),
(64, ' Staples No. 50 ', 2025),
(65, ' Staples No. 50 ', 2024),
(66, ' Ink Stamp ', 2024),
(67, ' Tinta Stampel  ', 2025),
(68, ' Cdrw ', 2024),
(69, ' Odner Plastik ', 2024),
(70, ' Pita Printer  ', 2023),
(71, ' Tinta Printer Epson Black 001 ', 2024),
(72, ' Tinta Printer Epson Black 001 ', 2025),
(73, ' Tinta Printer Epson 003 ', 2024),
(74, ' Tinta Printer Epson L 15150 A3+Ecotank ', 2024),
(75, ' Tinta Printer Brother BT5000 Cyan ', 2024),
(76, ' Tinta Printer Brother BT5000 Cyan ', 2025),
(77, ' Tinta Printer Brother BT5000 Magenta ', 2024),
(78, ' Tinta Printer Brother BT5000 Magenta ', 2025),
(79, ' Tinta Printer Brother BT5000 Yellow ', 2024),
(80, ' Tinta Printer Brother BT5000 Yellow ', 2025),
(81, ' Tinta Printer Brother BTD 50BK Black ', 2024),
(82, ' Tinta Printer Brother BTD 50BK Black ', 2025),
(83, ' Tinta Printer Epson 664 Hitam ', 2024),
(84, ' Tinta Printer Epson 664 Hitam ', 2025),
(85, ' Tinta Printer Epson 664 Blue ', 2024),
(86, ' Tinta Printer Epson 664 Blue ', 2025),
(87, ' Tinta Printer Epson 664 Yellow ', 2024),
(88, ' Tinta Printer Epson 664 Magenta ', 2024),
(89, ' Materai ', 2025),
(90, ' Lembar Pengantar ', 2025),
(91, ' Lembar Pengantar ', 2025),
(92, ' Blanko Cetakan ', 2025),
(93, ' Blanko Cetakan ', 2025),
(94, ' Lembar Disposisi ', 2025),
(95, ' Lembar Disposisi ', 2025),
(96, ' Map Dinas Berlogo', 2025),
(97, ' Map Dinas Berlogo ', 2025),
(98, ' Tinta Printer L15150 ', 2025),
(99, ' T664 Magenta 70ML Ink Bottle ', 2025),
(100, ' T664 Yellow 70ML Ink Bottle ', 2025),
(101, ' Tinta Printer Epson 003 Original  ', 2025),
(102, ' Lampu Listrik', 2025),
(103, ' Tong Sampah Beroda 660L ', 2025),
(104, ' Tong Sampah Beroda 120L ', 2025),
(105, ' Keranjang Kontainer ', 2024),
(106, ' Keranjang Kontainer ', 2025),
(107, ' Karung Plastik ', 2025),
(108, ' Terpal Sampah Besar ', 2024),
(109, ' Terpal Sampah Besar ', 2025),
(110, ' Terpal Sampah Kecil ', 2024),
(111, ' Terpal Sampah Kecil ', 2025),
(112, ' Sarung Tangan ', 2025),
(113, ' Pisau Potong Rumput ', 2024),
(114, ' Chainsaw/Rantai ', 2024),
(115, ' Tangga Lipat Teleskopic ', 2024),
(116, ' Tali Karmantel ', 2024),
(117, ' Golok ', 2024),
(118, ' Sabit ', 2024),
(119, ' Serokan Sampah Bergagang ', 2024),
(120, ' Box Arsip ', 2025),
(121, ' Box Arsip ', 2025),
(122, ' Senter Kejut ', 2024),
(123, ' Sepatu Karang ', 2025),
(124, ' Sepatu Karang ', 2024),
(125, ' Safety Shoes ', 2025),
(126, ' Safety Shoes Kings ', 2024),
(127, 'Sepatu Boot Bahan PVC, Warna Oranye ', 2025),
(128, ' Face Shield + Visor ', 2024),
(129, ' Topi ', 2025),
(130, ' Topi ', 2024),
(131, ' Safety Body Harnes ', 2024),
(132, ' Kaos Lapangan Berkerah, Bahan Kombinasi Katun dan Polyster ', 2024),
(133, ' Rompi Lapangan Orange ', 2024),
(134, ' Celana Panjang ', 2025),
(135, ' Celana Panjang ', 2024),
(136, ' Jas Hujan ', 2025),
(137, ' Jas Hujan ', 2024),
(138, ' Carabiner ', 2024);

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

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

CREATE TABLE `detail` (
  `id_detail` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_satuan` int NOT NULL,
  `sisa` int DEFAULT NULL,
  `hargasatuan` bigint NOT NULL,
  `nilaipersediaan` bigint DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`id_detail`, `id_barang`, `id_satuan`, `sisa`, `hargasatuan`, `nilaipersediaan`, `keterangan`) VALUES
(1, 1, 3, 2, 2147850, 4295700, 'Gudang Intirub'),
(2, 2, 2, 12561, 1525140, 19157283540, 'Gudang KM18'),
(3, 3, 2, 0, 1332000, 0, ''),
(4, 4, 2, 19938, 166500, 3319677000, 'Gudang KM18'),
(5, 5, 2, 0, 149850, 0, ''),
(6, 6, 2, 20889, 344100, 7187904900, 'Gudang KM18'),
(7, 7, 2, 0, 305250, 0, ''),
(8, 8, 2, 2814, 310800, 874591200, 'Gudang KM18'),
(9, 9, 2, 0, 283050, 0, ''),
(10, 10, 1, 0, 949050, 0, ''),
(11, 11, 1, 0, 543900, 0, ''),
(12, 12, 11, 0, 359640, 0, ''),
(13, 13, 1, 300, 7770, 2331000, 'Gudang Intirub'),
(14, 14, 1, 0, 8200, 0, ''),
(15, 15, 1, 2, 10700, 21400, 'Gudang Intirub'),
(16, 16, 1, 300, 8325, 2497500, 'Gudang Intirub'),
(17, 17, 7, 0, 610500, 0, ''),
(18, 18, 1, 0, 95460, 0, ''),
(19, 19, 1, 0, 29970, 0, ''),
(20, 20, 2, 10, 7800, 78000, 'Gudang Intirub'),
(21, 21, 7, 0, 14000, 0, 'Gudang Intirub'),
(22, 22, 0, 0, 16289, 0, ''),
(23, 23, 7, 0, 16000, 0, ''),
(24, 24, 2, 30, 4000, 120000, 'Gudang Intirub'),
(25, 25, 2, 4, 10000, 40000, 'Gudang Intirub'),
(26, 26, 12, 0, 205000, 0, ''),
(27, 27, 3, 1, 64100, 64100, 'Gudang Intirub'),
(28, 28, 8, 0, 45000, 0, ''),
(29, 29, 2, 6, 12100, 72600, 'Gudang Intirub'),
(30, 30, 1, 94, 11200, 1052800, 'Gudang Intirub'),
(31, 31, 1, 23, 29300, 673900, 'Gudang Intirub'),
(32, 32, 13, 17, 56000, 952000, 'Gudang Intirub'),
(33, 33, 1, 2, 18500, 37000, 'Gudang Intirub'),
(34, 34, 2, 0, 16567, 0, ''),
(35, 35, 2, 14, 16600, 232400, 'Gudang Intirub'),
(36, 36, 2, 11, 98200, 1080200, 'Gudang Intirub'),
(37, 37, 1, 7, 18400, 128800, 'Gudang Intirub'),
(38, 38, 3, 0, 155137, 0, ''),
(39, 39, 3, 7, 135000, 945000, 'Gudang Intirub'),
(40, 40, 3, 0, 30013, 0, ''),
(41, 41, 3, 4, 36000, 144000, 'Gudang Intirub'),
(42, 42, 3, 0, 128707, 0, ''),
(43, 43, 3, 0, 129000, 0, 'Gudang Intirub'),
(44, 44, 9, 8, 129000, 1032000, 'Gudang Intirub'),
(45, 45, 9, 1293, 57000, 73701000, 'Gudang Intirub'),
(46, 46, 9, 779, 68700, 53517300, 'Gudang Intirub'),
(47, 47, 2, 0, 40000, 0, 'Gudang Intirub'),
(48, 48, 11, 4, 103000, 412000, 'Gudang Intirub'),
(49, 49, 8, 0, 360500, 0, ''),
(50, 50, 8, 4, 77500, 310000, 'Gudang Intirub'),
(51, 51, 2, 0, 39500, 0, ''),
(52, 52, 12, 2, 119000, 238000, 'Gudang Intirub'),
(53, 53, 2, 5, 9000, 45000, 'Gudang Intirub'),
(54, 54, 1, 0, 33000, 0, 'Gudang Intirub'),
(55, 55, 10, 0, 17000, 0, ''),
(56, 56, 3, 5, 157000, 785000, 'Gudang Intirub'),
(57, 57, 3, 35, 103000, 3605000, 'Gudang Intirub'),
(58, 58, 3, 0, 111084, 0, ''),
(59, 59, 3, 73, 56200, 4102600, 'Gudang Intirub'),
(60, 60, 3, 89, 47500, 4227500, 'Gudang Intirub'),
(61, 61, 10, 19, 3000, 57000, 'Gudang Intirub'),
(62, 62, 10, 0, 6100, 0, ''),
(63, 63, 2, 1, 18000, 18000, 'Gudang Intirub'),
(64, 64, 2, 10, 79000, 790000, 'Gudang Intirub'),
(65, 65, 2, 0, 106027, 0, ''),
(66, 66, 2, 0, 55923, 0, ''),
(67, 67, 2, 23, 55500, 1276500, 'Gudang Intirub'),
(68, 68, 14, 0, 374653, 0, ''),
(69, 69, 2, 0, 35523, 0, ''),
(70, 70, 1, 0, 151680, 0, ''),
(71, 71, 1, 131, 169000, 22139000, 'Gudang Intirub'),
(72, 72, 1, 300, 173715, 52114500, 'Gudang Intirub'),
(73, 73, 1, 388, 129000, 50052000, 'Gudang Intirub'),
(74, 74, 1, 91, 307000, 27937000, 'Gudang Intirub'),
(75, 75, 1, 50, 119000, 5950000, 'Gudang Intirub'),
(76, 76, 1, 100, 119880, 11988000, 'Gudang Intirub'),
(77, 77, 1, 52, 119000, 6188000, 'Gudang Intirub'),
(78, 78, 1, 100, 119880, 11988000, 'Gudang Intirub'),
(79, 79, 1, 56, 119000, 6664000, 'Gudang Intirub'),
(80, 80, 1, 100, 119880, 11988000, 'Gudang Intirub'),
(81, 81, 1, 118, 109000, 12862000, 'Gudang Intirub'),
(82, 82, 1, 300, 113220, 33966000, 'Gudang Intirub'),
(83, 83, 1, 15, 119000, 1785000, 'Gudang Intirub'),
(84, 84, 1, 50, 97347, 4867350, 'Gudang Intirub'),
(85, 85, 1, 24, 99000, 2376000, 'Gudang Intirub'),
(86, 86, 1, 25, 99900, 2497500, 'Gudang Intirub'),
(87, 87, 1, 23, 99000, 2277000, 'Gudang Intirub'),
(88, 88, 1, 21, 99000, 2079000, 'Gudang Intirub'),
(89, 89, 1, 1265, 10000, 12650000, 'Gudang Intirub'),
(90, 90, 4, 1, 28050, 28050, 'Gudang Intirub'),
(91, 91, 4, 199, 28000, 5571950, 'Gudang Intirub'),
(92, 92, 4, 0, 69540, 0, 'Gudang Intirub'),
(93, 93, 4, 2625, 69000, 181124528, 'Gudang Intirub'),
(94, 94, 4, 1, 32801, 32801, 'Gudang Intirub'),
(95, 95, 4, 199, 32699, 6507199, 'Gudang Intirub'),
(96, 96, 1, 1, 7170, 7170, 'Gudang Intirub'),
(97, 97, 1, 499, 7000, 3492830, 'Gudang Intirub'),
(98, 98, 1, 100, 306360, 30636000, 'Gudang Intirub'),
(99, 99, 5, 25, 99900, 2497500, 'Gudang Intirub'),
(100, 100, 5, 25, 99900, 2497500, 'Gudang Intirub'),
(101, 101, 1, 700, 109890, 76923000, 'Gudang Intirub'),
(102, 102, 5, 0, 15817500, 0, ''),
(103, 103, 1, 0, 4835160, 0, ''),
(104, 104, 1, 0, 910000, 0, ''),
(105, 105, 1, 0, 228105, 0, ''),
(106, 106, 1, 0, 233100, 0, ''),
(107, 107, 1, 184000, 3552, 653568000, 'Gudang Intirub'),
(108, 108, 1, 0, 825840, 0, ''),
(109, 109, 1, 0, 832500, 0, ''),
(110, 110, 1, 0, 431790, 0, ''),
(111, 111, 1, 0, 451770, 0, ''),
(112, 112, 6, 554, 97680, 54114720, 'Sudah terdistribusikan semua'),
(113, 113, 1, 0, 296925, 0, ''),
(114, 114, 1, 0, 421800, 0, ''),
(115, 115, 5, 0, 1998000, 0, ''),
(116, 116, 7, 0, 5716500, 0, ''),
(117, 117, 1, 0, 144300, 0, ''),
(118, 118, 1, 0, 89910, 0, ''),
(119, 119, 5, 0, 420135, 0, ''),
(120, 120, 2, 375, 79401, 29775195, 'Gudang Intirub'),
(121, 121, 2, 0, 79141, 0, ''),
(122, 122, 1, 108, 1249860, 134984880, 'Gudang Intirub'),
(123, 123, 6, 300, 1481850, 444555000, 'Sudah terdistribusikan semua'),
(124, 124, 6, 0, 1182150, 0, ''),
(125, 125, 6, 55, 510156, 28058580, 'Sudah terdistribusikan semua'),
(126, 126, 6, 0, 537795, 0, ''),
(127, 127, 6, 3196, 186480, 595990080, 'Sudah terdistribusikan semua'),
(128, 128, 1, 0, 149295, 0, ''),
(129, 129, 1, 6392, 78810, 503753520, 'Sudah terdistribusikan semua'),
(130, 130, 1, 0, 89022, 0, ''),
(131, 131, 1, 0, 388500, 0, ''),
(132, 132, 1, 0, 190809, 0, ''),
(133, 133, 5, 0, 171273, 0, ''),
(134, 134, 1, 1036, 229770, 238041720, 'Sudah terdistribusikan semua'),
(135, 135, 1, 0, 254190, 0, ''),
(136, 136, 1, 518, 509490, 263915820, 'Sudah terdistribusikan semua'),
(137, 137, 1, 0, 379065, 0, ''),
(138, 138, 1, 0, 1054500, 0, '');

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
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
