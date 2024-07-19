-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 05:15 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dblaundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `kain`
--

CREATE TABLE `kain` (
  `id_kain` int(11) NOT NULL,
  `nama_kain` varchar(30) NOT NULL,
  `deskripsi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kain`
--

INSERT INTO `kain` (`id_kain`, `nama_kain`, `deskripsi`) VALUES
(5, 'celana baju jaket', 'celana jeans'),
(6, 'baju', 'baju lengan panjang');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL,
  `nama_layanan` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `durasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `deskripsi`, `harga`, `durasi`) VALUES
(13, 'setrika sekaligus lipat', 'setrika dan lipat', '10000', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `alamat` varchar(30) NOT NULL,
  `no_telpon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `email`, `alamat`, `no_telpon`) VALUES
(9, 'widiastuti', 'septi@gmail', 'jl indraloka', '0857182'),
(10, 'Al amin', 'alamin@gmail.com', 'jl riau', '08089708');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `metode_bayar` varchar(255) NOT NULL,
  `tanggal_bayar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pesan`, `id_pelanggan`, `jumlah_bayar`, `metode_bayar`, `tanggal_bayar`) VALUES
(8, 20, 9, '10000', 'tf', '2020-01-01'),
(9, 20, 10, '2000', 'cash', '2020-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_jasa`
--

CREATE TABLE `pesan_jasa` (
  `id_pesan` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_kain` int(11) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `tanggal_ambil` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status_pesan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesan_jasa`
--

INSERT INTO `pesan_jasa` (`id_pesan`, `id_petugas`, `id_pelanggan`, `id_layanan`, `id_kain`, `tanggal_pesan`, `tanggal_ambil`, `jumlah`, `status_pesan`) VALUES
(20, 9, 9, 13, 5, '2020-01-01', '2020-01-01', 1, 'proses'),
(21, 9, 10, 13, 6, '2020-04-04', '2020-04-04', 20, 'proses');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(30) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `no_telpon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `jabatan`, `no_telpon`) VALUES
(8, 'amin', 'pemilik', '08571728282'),
(9, 'sanii', 'karyawan', '089567383'),
(10, 'budiman', 'karyawan', '089999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kain`
--
ALTER TABLE `kain`
  ADD PRIMARY KEY (`id_kain`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesan` (`id_pesan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `pesan_jasa`
--
ALTER TABLE `pesan_jasa`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_layanan` (`id_layanan`),
  ADD KEY `id_kain` (`id_kain`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kain`
--
ALTER TABLE `kain`
  MODIFY `id_kain` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pesan_jasa`
--
ALTER TABLE `pesan_jasa`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pesan`) REFERENCES `pesan_jasa` (`id_pesan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON UPDATE CASCADE;

--
-- Constraints for table `pesan_jasa`
--
ALTER TABLE `pesan_jasa`
  ADD CONSTRAINT `pesan_jasa_ibfk_1` FOREIGN KEY (`id_kain`) REFERENCES `kain` (`id_kain`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesan_jasa_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesan_jasa_ibfk_3` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesan_jasa_ibfk_4` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
