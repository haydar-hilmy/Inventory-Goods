-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 05:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `harga_masuk` float NOT NULL,
  `harga_keluar` float NOT NULL,
  `stock` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master`
--

CREATE TABLE `master` (
  `id` int(11) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master`
--

INSERT INTO `master` (`id`, `nama_pengguna`, `kata_sandi`, `email`, `jabatan`) VALUES
(1, 'admin', '1111', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_transaksi_masuk`
--

CREATE TABLE `sub_transaksi_masuk` (
  `id_t_masuk` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keluar`
--

CREATE TABLE `transaksi_keluar` (
  `id` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `harga_keluar` float NOT NULL,
  `jumlah` float NOT NULL,
  `total_harga` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transaksi_keluar`
--
DELIMITER $$
CREATE TRIGGER `kurangi_jumlah_transaksi_masuk` AFTER INSERT ON `transaksi_keluar` FOR EACH ROW BEGIN
    DECLARE jumlah_transaksi INT;
    DECLARE stok_tersedia INT;
    DECLARE transaksi_id INT;
    
    SET jumlah_transaksi = NEW.jumlah;

    -- Loop untuk mengurangi jumlah di transaksi_masuk
    my_loop: WHILE jumlah_transaksi > 0 DO
        -- Ambil ID dan jumlah dari transaksi_masuk tertua yang memiliki jumlah > 0
        SELECT id_t_masuk, jumlah INTO transaksi_id, stok_tersedia
        FROM sub_transaksi_masuk
        WHERE jumlah > 0
        ORDER BY id_t_masuk
        LIMIT 1;

        -- Jika tidak ada stok yang tersedia, keluar dari loop
        IF transaksi_id IS NULL THEN
            LEAVE my_loop;
        END IF;

        -- Jika stok yang tersedia lebih kecil dari jumlah transaksi_keluar
        IF stok_tersedia <= jumlah_transaksi THEN
            -- Kurangi stok yang tersedia dari jumlah_transaksi
            SET jumlah_transaksi = jumlah_transaksi - stok_tersedia;

            -- Update stok yang tersedia menjadi 0
            UPDATE sub_transaksi_masuk
            SET jumlah = 0
            WHERE id_t_masuk = transaksi_id;
        ELSE
            -- Kurangi jumlah_transaksi dari stok yang tersedia
            UPDATE sub_transaksi_masuk
            SET jumlah = jumlah - jumlah_transaksi
            WHERE id_t_masuk = transaksi_id;

            -- Keluar dari loop
            SET jumlah_transaksi = 0;
        END IF;
    END WHILE;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_stok_barang` AFTER INSERT ON `transaksi_keluar` FOR EACH ROW BEGIN
    DECLARE id_barang INT;
    DECLARE jumlah_transaksi INT;

    -- Ambil ID barang dan jumlah transaksi yang baru ditambahkan
    SELECT NEW.id_barang, NEW.jumlah INTO id_barang, jumlah_transaksi;

    -- Kurang jumlah di tabel transaksi masuk
    UPDATE barang
    SET stock = stock - jumlah_transaksi
    WHERE id = id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_masuk`
--

CREATE TABLE `transaksi_masuk` (
  `id` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `harga_masuk` float NOT NULL,
  `jumlah` float NOT NULL,
  `total_harga` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transaksi_masuk`
--
DELIMITER $$
CREATE TRIGGER `duplicate_to_sub_transaksi_masuk` AFTER INSERT ON `transaksi_masuk` FOR EACH ROW BEGIN
    INSERT INTO sub_transaksi_masuk (id_t_masuk, tgl_masuk, id_barang, jumlah)
    VALUES (NEW.id, NEW.tgl_masuk, NEW.id_barang, NEW.jumlah);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_id_supplier` BEFORE INSERT ON `transaksi_masuk` FOR EACH ROW BEGIN
    DECLARE v_id_barang INT(11);
    SELECT id INTO v_id_barang
    FROM supplier
    WHERE nama_supplier = NEW.nama_supplier;
    SET NEW.id_supplier = v_id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok_barang` AFTER INSERT ON `transaksi_masuk` FOR EACH ROW BEGIN
    DECLARE id_barang INT;
    DECLARE jumlah_transaksi INT;

    -- Ambil ID barang dan jumlah transaksi yang baru ditambahkan
    SELECT NEW.id_barang, NEW.jumlah INTO id_barang, jumlah_transaksi;

    -- Update stok barang di tabel barang
    UPDATE barang
    SET stock = stock + jumlah_transaksi
    WHERE id = id_barang;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master`
--
ALTER TABLE `master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master`
--
ALTER TABLE `master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
