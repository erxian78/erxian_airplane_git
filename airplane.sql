-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 12, 2019 at 04:39 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airplane`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticket_status`
--

DROP TABLE IF EXISTS `ticket_status`;
CREATE TABLE `ticket_status` (
  `status` char(50) NOT NULL,
  `row` int(50) NOT NULL,
  `column` int(50) NOT NULL,
  `user_id` int(50) DEFAULT NULL,
  `id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket_status`
--

INSERT INTO `ticket_status` (`status`, `row`, `column`, `user_id`, `id`) VALUES
('free', 1, 1, NULL, 1893),
('free', 1, 2, NULL, 1894),
('free', 1, 3, NULL, 1895),
('free', 1, 4, NULL, 1896),
('free', 1, 5, NULL, 1897),
('free', 1, 6, NULL, 1898),
('free', 2, 1, NULL, 1899),
('purchase', 2, 2, 34, 1900),
('free', 2, 3, NULL, 1901),
('free', 2, 4, NULL, 1902),
('free', 2, 5, NULL, 1903),
('free', 2, 6, NULL, 1904),
('free', 3, 1, NULL, 1905),
('purchase', 3, 2, 34, 1906),
('free', 3, 3, NULL, 1907),
('free', 3, 4, NULL, 1908),
('free', 3, 5, NULL, 1909),
('free', 3, 6, NULL, 1910),
('reserved', 4, 1, 33, 1911),
('purchase', 4, 2, 34, 1912),
('free', 4, 3, NULL, 1913),
('reserved', 4, 4, 33, 1914),
('free', 4, 5, NULL, 1915),
('reserved', 4, 6, 34, 1916),
('free', 5, 1, NULL, 1917),
('free', 5, 2, NULL, 1918),
('free', 5, 3, NULL, 1919),
('free', 5, 4, NULL, 1920),
('free', 5, 5, NULL, 1921),
('free', 5, 6, NULL, 1922),
('free', 6, 1, NULL, 1923),
('free', 6, 2, NULL, 1924),
('free', 6, 3, NULL, 1925),
('free', 6, 4, NULL, 1926),
('free', 6, 5, NULL, 1927),
('free', 6, 6, NULL, 1928),
('free', 7, 1, NULL, 1929),
('free', 7, 2, NULL, 1930),
('free', 7, 3, NULL, 1931),
('free', 7, 4, NULL, 1932),
('free', 7, 5, NULL, 1933),
('free', 7, 6, NULL, 1934),
('free', 8, 1, NULL, 1935),
('free', 8, 2, NULL, 1936),
('free', 8, 3, NULL, 1937),
('free', 8, 4, NULL, 1938),
('free', 8, 5, NULL, 1939),
('free', 8, 6, NULL, 1940),
('free', 9, 1, NULL, 1941),
('free', 9, 2, NULL, 1942),
('free', 9, 3, NULL, 1943),
('free', 9, 4, NULL, 1944),
('free', 9, 5, NULL, 1945),
('free', 9, 6, NULL, 1946),
('free', 10, 1, NULL, 1947),
('free', 10, 2, NULL, 1948),
('free', 10, 3, NULL, 1949),
('free', 10, 4, NULL, 1950),
('free', 10, 5, NULL, 1951),
('free', 10, 6, NULL, 1952);

-- --------------------------------------------------------

--
-- Table structure for table `user_name_pwd`
--

DROP TABLE IF EXISTS `user_name_pwd`;
CREATE TABLE `user_name_pwd` (
  `user_name` char(250) NOT NULL,
  `password` char(50) NOT NULL,
  `id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_name_pwd`
--

INSERT INTO `user_name_pwd` (`user_name`, `password`, `id`) VALUES
('u1@p.it', 'ec6ef230f1828039ee794566b9c58adc', 33),
('u2@p.it', '1d665b9b1467944c128a5575119d1cfd', 34);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ticket_status`
--
ALTER TABLE `ticket_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_name_pwd`
--
ALTER TABLE `user_name_pwd`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ticket_status`
--
ALTER TABLE `ticket_status`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1953;

--
-- AUTO_INCREMENT for table `user_name_pwd`
--
ALTER TABLE `user_name_pwd`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
