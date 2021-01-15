-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2021 at 01:39 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes_reminder`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_servis`
--

CREATE TABLE `detail_servis` (
  `idServis` int(11) NOT NULL,
  `tglServisTerakhir` date DEFAULT NULL,
  `tglServisSelanjutnya` date DEFAULT NULL,
  `noRangka` varchar(250) DEFAULT NULL,
  `kilometer` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_servis`
--

INSERT INTO `detail_servis` (`idServis`, `tglServisTerakhir`, `tglServisSelanjutnya`, `noRangka`, `kilometer`) VALUES
(1, '2021-01-22', '2021-07-22', 'UXX123456789UXXH1234', '30000'),
(2, '2021-01-15', '2021-07-15', 'UW23454676656453WW', '45000');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `noRangka` varchar(250) NOT NULL,
  `noMesin` varchar(250) DEFAULT NULL,
  `noPolisi` varchar(250) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`noRangka`, `noMesin`, `noPolisi`, `deliveryDate`, `id`) VALUES
('UW23454676656453WW', 'UXXH234546766564534X', 'PA 1515 DF', '2020-12-01', 2),
('UXX123456789UXXH1234', 'UXX123456789UXX', 'PA 1235 DF', '2020-11-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `telepon` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `telepon`) VALUES
(1, 'John Doe', 'Jln. Yabansai No 2 Perumnas 1 Waena', ' +6282238463056'),
(2, 'Rebecca Simone', 'Jln. Scranton No 2 Perumnas 1 Waena', ' +6285244449300');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `idRiwayatBooking` int(11) NOT NULL,
  `noRangka` varchar(250) DEFAULT NULL,
  `tanggalServis` date DEFAULT NULL,
  `kilometer` int(11) DEFAULT NULL,
  `namaBooking` varchar(250) DEFAULT NULL,
  `noTeleponBooking` varchar(250) DEFAULT NULL,
  `jamBooking` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `done` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`idRiwayatBooking`, `noRangka`, `tanggalServis`, `kilometer`, `namaBooking`, `noTeleponBooking`, `jamBooking`, `status`, `done`) VALUES
(1, 'UXX123456789UXXH1234', '2021-01-22', 30000, 'Jericho Siahaya', ' +6282238463056', '13:41', 2, 1),
(6, 'UW23454676656453WW', '2021-01-15', 45000, 'Rebecca Simone', ' +6285244449300', '20:11', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_servis`
--
ALTER TABLE `detail_servis`
  ADD PRIMARY KEY (`idServis`),
  ADD KEY `noRangka` (`noRangka`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`noRangka`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`idRiwayatBooking`),
  ADD KEY `noRangka` (`noRangka`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_servis`
--
ALTER TABLE `detail_servis`
  MODIFY `idServis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `idRiwayatBooking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_servis`
--
ALTER TABLE `detail_servis`
  ADD CONSTRAINT `detail_servis_ibfk_1` FOREIGN KEY (`noRangka`) REFERENCES `mobil` (`noRangka`);

--
-- Constraints for table `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `mobil_ibfk_1` FOREIGN KEY (`id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD CONSTRAINT `riwayat_ibfk_1` FOREIGN KEY (`noRangka`) REFERENCES `mobil` (`noRangka`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
