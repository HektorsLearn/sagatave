-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2022 at 01:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sagatave`
--

-- --------------------------------------------------------

--
-- Table structure for table `lapas`
--

CREATE TABLE `lapas` (
  `id` int(6) UNSIGNED NOT NULL,
  `nosaukums` varchar(255) NOT NULL,
  `taka` varchar(255) NOT NULL,
  `saturs` text DEFAULT NULL,
  `laiks` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `npk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lapas`
--

INSERT INTO `lapas` (`id`, `nosaukums`, `taka`, `saturs`, `laiks`, `npk`) VALUES
(3, 'Sākums', 'sakums', 'Šis ir mājaslaas sākums', '2022-07-21 20:25:05', 2),
(71, 'Kontakti', 'kontakti', 'Henrijs Zaķis', '2022-07-19 19:01:06', 2),
(72, 'Galerija', 'galerijas', 'Galerijadsadas', '2022-07-21 20:25:05', 1),
(108, 'Mcalfa', 'mc', 'Mcalfa', '2022-07-19 19:02:10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lietotaji`
--

CREATE TABLE `lietotaji` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `vards` varchar(11) NOT NULL,
  `uzvards` varchar(11) NOT NULL,
  `access` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `laiks` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lietotaji`
--

INSERT INTO `lietotaji` (`id`, `username`, `password`, `vards`, `uzvards`, `access`, `active`, `laiks`) VALUES
(13, 'henrijs024', 'Zakis123', 'Henrijs', 'Zaķis', 'admin', 1, '2022-07-22 17:07:31'),
(68, 'Zane', 'Francis', 'Zane', 'Grūbe', 'public', 0, '2022-07-22 17:01:34'),
(83, 'Francis', 'Zakis123', 'Francis', 'Grūbe', 'public', 0, '2022-07-22 17:18:39'),
(84, 'henrijs0231', 'henrijs024', '', '', 'public', 1, '2022-07-21 20:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `zinas`
--

CREATE TABLE `zinas` (
  `id` int(11) UNSIGNED NOT NULL,
  `saturs` text NOT NULL,
  `autors` varchar(255) NOT NULL,
  `laiks` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zinas`
--

INSERT INTO `zinas` (`id`, `saturs`, `autors`, `laiks`) VALUES
(1, 'zzzzzz', 'henrijs024', '2022-07-19 23:36:31'),
(8, 'Garšīga mitrā', 'henrijs024', '2022-07-20 15:55:06'),
(11, 'Man garšo mitrā barība', 'Zane', '2022-07-20 16:12:28'),
(12, 'Francis ir palaidnis', 'henrijs024', '2022-07-21 19:22:29'),
(14, 'fsfhjdhjbsfdbhjsfd', 'henrijs024', '2022-07-22 18:57:36'),
(15, 'Alus ir garšīgs', 'henrijs024', '2022-07-22 20:18:53'),
(16, 'Dod man mitro barību', 'Francis', '2022-07-22 20:19:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lapas`
--
ALTER TABLE `lapas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lietotaji`
--
ALTER TABLE `lietotaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zinas`
--
ALTER TABLE `zinas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lapas`
--
ALTER TABLE `lapas`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `lietotaji`
--
ALTER TABLE `lietotaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `zinas`
--
ALTER TABLE `zinas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
