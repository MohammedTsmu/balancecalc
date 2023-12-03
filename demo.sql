-- CREATE DATABSE => balancecalc
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 08:25 AM
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
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `price` decimal(12,3) DEFAULT NULL,
  `publish_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `type`, `category`, `price`, `publish_date`) VALUES
(328, 'ZAIN', 2, 2.100, '2023-12-01'),
(329, 'ZAIN', 5, 5.250, '2023-12-01'),
(330, 'ZAIN', 10, 10.350, '2023-12-01'),
(331, 'ZAIN', 15, 15.000, '2023-12-02'),
(332, 'ZAIN', 25, 25.000, '2023-12-02'),
(333, 'ZAIN', 35, 35.000, '2023-12-02'),
(334, 'ASIA', 2, 2.000, '2023-12-02'),
(335, 'ASIA', 5, 5.000, '2023-12-02'),
(336, 'ASIA', 10, 10.350, '2023-12-02'),
(337, 'ASIA', 15, 15.440, '2023-12-02'),
(338, 'ASIA', 25, 25.000, '2023-12-02'),
(339, 'ASIA', 35, 35.000, '2023-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_datetime` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1079;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
