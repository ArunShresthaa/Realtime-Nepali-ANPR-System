-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 10:46 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anpr`
--

-- --------------------------------------------------------

--
-- Table structure for table `bolo`
--

CREATE TABLE `bolo` (
  `id` int(10) NOT NULL,
  `record_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bolo`
--

INSERT INTO `bolo` (`id`, `record_id`) VALUES
(24, 27);

-- --------------------------------------------------------

--
-- Table structure for table `camera`
--

CREATE TABLE `camera` (
  `id` int(10) NOT NULL,
  `location` text NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `device_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `camera`
--

INSERT INTO `camera` (`id`, `location`, `latitude`, `longitude`, `device_id`) VALUES
(8, 'Koteshwor', 27.67846282528881, 85.34954050290398, '9140c9505c9f16a7af5dab5c26bfde84eca5c11a50ce34b8566c60c3b13a4bdf'),
(9, 'New Thimi', 27.66579340443894, 85.38475724232883, '9a14950974858fc1a2fcb7cc418b57ab8d870794403611c20e54fba1a411d514'),
(10, 'Lalitpur', 27.658739665354418, 85.32436738185605, '38e82b950ecbdafe6a55116ddc7d4783911c0eaac3aa9d51c6ca78003d3f393e'),
(11, 'Khwopa College of Engineering', 27.671146629115125, 85.4392380883667, '59c414eaa6cd5571203f8f63008ada3a85b3898b87defc3b2bbf3414fce9b305');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `Id` int(10) NOT NULL,
  `password` text NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`Id`, `password`, `userID`) VALUES
(2, '21232f297a57a5a743894a0e4a801fc3', 2),
(3, 'ee11cbb19052e40b07aac0ca060c23ee', 3);

-- --------------------------------------------------------

--
-- Table structure for table `hitlogs`
--

CREATE TABLE `hitlogs` (
  `id` int(10) NOT NULL,
  `record_id` int(10) NOT NULL,
  `camera_id` int(10) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read') NOT NULL,
  `is_new` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hitlogs`
--

INSERT INTO `hitlogs` (`id`, `record_id`, `camera_id`, `created_at`, `status`, `is_new`) VALUES
(52, 24, 8, '2024-03-07 21:31:12', 'unread', 'no'),
(53, 24, 9, '2024-03-07 21:35:48', 'unread', 'no'),
(54, 24, 10, '2024-03-07 21:36:39', 'unread', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`id`, `name`) VALUES
(6, 'Criminal Offence'),
(5, 'DUI'),
(4, 'International Criminal'),
(1, 'Murder'),
(2, 'Robbery');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `Id` int(10) NOT NULL,
  `plate_no` varchar(30) NOT NULL,
  `reason` text NOT NULL,
  `vehicle_type` varchar(30) NOT NULL,
  `vehicle_ownership` varchar(30) NOT NULL,
  `province` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `location` text NOT NULL,
  `description` text NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`Id`, `plate_no`, `reason`, `vehicle_type`, `vehicle_ownership`, `province`, `district`, `location`, `description`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'ABC123', 'Traffic Violation', 'Car', 'Personal', 'Example Province', 'Example District', 'Example Location', 'Description of the incident', 'Additional remarks', '2024-01-13 10:30:00', '2024-01-13 10:30:00'),
(2, 'XYZ789', 'Parking Violation', 'Motorcycle', 'Rental', 'Another Province', 'Another District', 'Another Location', 'Another incident description', 'More remarks', '2024-01-13 11:45:00', '2024-01-13 11:45:00'),
(3, 'JKL456', 'Speeding', 'Truck', 'Company', 'Yet Another Province', 'Yet Another District', 'Yet Another Location', 'Yet Another incident description', 'Even more remarks', '2024-01-13 12:15:00', '2024-01-13 12:15:00'),
(4, 'AAAAA', 'International Criminal', 'bike', 'private', 'bagmati', 'dang', 'Thimi', 'Red', 'On the FLy', '2024-01-14 09:36:21', '2024-01-14 09:37:34'),
(6, '', 'International Criminal', 'bike', 'private', 'bagmati', 'dang', 'Thimi', 'Red', 'On the FLy', '2024-01-14 09:38:42', NULL),
(7, 'arunplate', 'Robbery', 'car', 'private', 'bagmati', 'bhaktapur', 'Thimi', 'blue', 'robbed RBB', '2024-01-14 11:34:22', NULL),
(8, 'ba21ba4874', 'Murder', 'bike', 'private', 'bagmati', 'bhaktapur', 'Thimi', 'Red', 'BOLO', '2024-02-06 15:41:13', '2024-02-07 11:07:16'),
(9, 'ba21ba4874', 'Robbery', 'car', 'private', 'bagmati', 'kathmandu', 'New Road', 'Robbed Rastriya Barijya Bank', 'Shoot at Sight Order', '2024-02-07 18:04:28', '2024-02-14 12:50:21'),
(10, '9993399', 'Robbery', 'car', 'private', 'sudurpashchim', 'mugu', 'Pipal Bot', 'Black Car', 'Suspect Armed', '2024-02-10 22:35:46', '2024-02-10 23:10:16'),
(11, 'ba4cha4662', 'Criminal Offence', 'car', 'private', 'koshi', 'dailekh', 'fdsf', 'fdsfd', 'fdfsd', '2024-02-14 14:52:59', NULL),
(12, 'ba63pa6158', 'DUI', 'bus', 'private', 'madesh', 'dang', 'fdfd', 'fdsfds', 'fsdfdf', '2024-02-14 14:57:42', NULL),
(13, 'ba13cha1824', 'Criminal Offence', 'bike', 'public', 'madesh', 'chitwan', 'gfdgfg', 'gfdgfg', 'gfdgf', '2024-02-14 15:00:41', NULL),
(14, 'ba28pa9603', 'Criminal Offence', 'bike', 'public', 'koshi', 'chitwan', 'gfdgf', 'gfdgf', 'gfdgf', '2024-02-14 15:04:07', NULL),
(15, 'ba13cha4782', 'DUI', 'car', 'private', 'madesh', 'bhojpur', 'gfdgfdg', 'gfdgf', 'gfdgf', '2024-02-14 15:07:43', NULL),
(16, 'ba9cha3670', 'DUI', 'bike', 'private', 'madesh', 'dailekh', 'fsfd', 'fdfd', 'fdfd', '2024-02-14 15:09:42', NULL),
(17, 'ba9cha911010', 'Criminal Offence', 'car', 'public', 'madesh', 'chitwan', 'fdsfd', 'fdsfd', 'fdsfdf', '2024-02-14 15:11:18', NULL),
(18, '4ba63168', 'DUI', 'car', 'private', 'koshi', 'chitwan', 'z', 'z', 'z', '2024-02-14 15:17:11', NULL),
(19, 'ba17cha854', 'Criminal Offence', 'car', 'public', 'madesh', 'achham', 'fdsf', 'fsdf', 'fdsfd', '2024-02-15 01:21:13', NULL),
(20, 'ba5cha5599', 'Criminal Offence', 'bike', 'private', 'madesh', 'arghakhanchi', 'fsdf', 'fdsfd', 'fdsfd', '2024-02-15 01:24:19', NULL),
(21, 'ba7cha347', 'DUI', 'bike', 'public', 'koshi', 'arghakhanchi', 'fsfdf', 'fdsfd', 'fsfdf', '2024-02-15 01:28:16', NULL),
(22, 'ba1cha3793', 'Criminal Offence', 'car', 'public', 'madesh', 'arghakhanchi', 'fdsfd', 'fdsf', 'fsfds', '2024-02-15 01:35:52', NULL),
(23, 'ba16cha7155', 'Criminal Offence', 'car', 'private', 'koshi', 'achham', 'gfgf', 'gfdgfdg', 'gdfgfg', '2024-02-15 01:39:09', NULL),
(24, 'ba15cha5564', 'International Criminal', 'bike', 'government', 'bagmati', 'arghakhanchi', 'fsfd', 'fdsfdf', 'fsdfdf', '2024-02-15 01:44:47', NULL),
(25, 'ba12cha8376', 'Murder', 'car', 'private', 'bagmati', 'bhaktapur', 'New Thimi', 'Red Car', 'Suspect Armed', '2024-02-15 02:08:05', '2024-03-07 21:15:30'),
(26, 'ba9cha1482', 'Criminal Offence', 'bike', 'public', 'koshi', 'baglung', 'Thimi', 'gfdgf', 'robbed RBB', '2024-02-15 02:21:47', NULL),
(27, 'ba21cha2670', 'Robbery', 'car', 'private', 'bagmati', 'bhaktapur', 'New Thimi', 'Orange Car', 'Suspect Armed', '2024-03-07 21:30:17', NULL),
(28, 'ba12cha3890', 'Murder', 'bike', 'private', 'bagmati', 'bhaktapur', 'Liwali', 'Silver Car with slight blue tail light', 'Suspect is armed, red alert level 3', '2024-03-09 21:14:36', '2024-03-09 21:28:12'),
(29, 'ba13cha3952', 'Robbery', 'car', 'private', 'bagmati', 'bhaktapur', 'Lokanthali', 'blue', 'robbed RBB', '2024-03-09 22:15:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(10) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `address`, `contact`, `created_at`) VALUES
(2, 'admin', 'Arun', 'Shrestha', 'admin@mail.com', 'New Thimi, Bhaktapur', '9800000000', '2024-02-14 11:23:00'),
(3, 'user', 'Arun', 'Shrestha', 'user@mail.com', 'New Thimi, Bhaktapur', '9700000000', '2024-02-14 11:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bolo`
--
ALTER TABLE `bolo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `record_id` (`record_id`);

--
-- Indexes for table `camera`
--
ALTER TABLE `camera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lattitude` (`latitude`),
  ADD UNIQUE KEY `longitude` (`longitude`),
  ADD UNIQUE KEY `device_id` (`device_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- Indexes for table `hitlogs`
--
ALTER TABLE `hitlogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `camera_id` (`camera_id`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bolo`
--
ALTER TABLE `bolo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `camera`
--
ALTER TABLE `camera`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hitlogs`
--
ALTER TABLE `hitlogs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bolo`
--
ALTER TABLE `bolo`
  ADD CONSTRAINT `bolo_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`Id`);

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `credentials_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`Id`);

--
-- Constraints for table `hitlogs`
--
ALTER TABLE `hitlogs`
  ADD CONSTRAINT `hitlogs_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `bolo` (`id`),
  ADD CONSTRAINT `hitlogs_ibfk_2` FOREIGN KEY (`camera_id`) REFERENCES `camera` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
