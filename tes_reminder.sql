-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2021 at 03:22 PM
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
  `noRangka` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_servis`
--

INSERT INTO `detail_servis` (`idServis`, `tglServisTerakhir`, `tglServisSelanjutnya`, `noRangka`) VALUES
(1, '2021-01-01', '2021-01-07', '214253MH6775D'),
(2, '2021-01-04', '2021-03-01', '214253MH6975D'),
(3, '2021-01-05', '2021-01-06', 'WDNGQK9MVJ');

-- --------------------------------------------------------

--
-- Table structure for table `detail_servis_tes`
--

CREATE TABLE `detail_servis_tes` (
  `idServis` int(11) NOT NULL,
  `tglServisTerakhir` date DEFAULT NULL,
  `tglServisSelanjutnya` date DEFAULT NULL,
  `noRangka` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `noRangka` varchar(250) NOT NULL,
  `noPolisi` varchar(250) DEFAULT NULL,
  `tglBeli` date DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`noRangka`, `noPolisi`, `tglBeli`, `id`) VALUES
('214253MH6775D', 'PA1516GR', '2015-05-03', 1),
('214253MH6975D', 'PA2525DA', '2017-05-03', 2),
('WDNGQK9MVJ', 'PA 1515 DF', '2021-01-04', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `telepon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `telepon`) VALUES
(1, 'Paul Molive', 'Jln. Yabansai, No 3 Perumnas 1 Waena', 2147483647),
(2, 'Jericho ', 'Jln. Yabansai No 2 Perumnas 1 Waena', 2147483647),
(3, 'John Doe', 'Jayapura', 2147483647);

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
-- Indexes for table `detail_servis_tes`
--
ALTER TABLE `detail_servis_tes`
  ADD PRIMARY KEY (`idServis`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_servis`
--
ALTER TABLE `detail_servis`
  MODIFY `idServis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
