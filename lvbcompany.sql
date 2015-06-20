-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2015 at 08:19 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lvbcompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
`company_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_description` text,
  `company_image` varchar(255) DEFAULT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `company_description`, `company_image`, `record_status`) VALUES
(2, 'Bus 10/10', 'Bus 10/10 Description', 'uploads/company_2.jpg', 4),
(3, 'Thăng Long', 'Thăng Long Description', 'uploads/company_3.jpg', 4),
(4, 'Demo', 'Demo', 'uploads/no-thumbnail.png', 4),
(5, 'Đông Anh Company', 'Đông Anh Company Description', 'uploads/company_5.jpg', 4),
(6, 'Hoàng Hà', 'Hoàng Hà Description', 'uploads/company_6.jpg', 4),
(7, 'Tiến Nhật', 'Tiến Nhật Description', 'uploads/company_7.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE IF NOT EXISTS `drivers` (
`driver_id` int(10) unsigned NOT NULL,
  `company_id` int(11) NOT NULL,
  `driver_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `driver_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `driver_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `driver_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `company_id`, `driver_name`, `driver_address`, `driver_image`, `driver_phone`, `record_status`) VALUES
(1, 3, 'Huy Tran', 'Nam Dinh', 'uploads/driver_1.jpg', '0962623143', 4),
(2, 3, 'Lê Tùng', 'Hà Nội', 'uploads/driver_2.jpg', '0962623133', 4),
(3, 2, 'Vũ Thịnh', 'Quảng Ninh', 'uploads/driver_3.jpg', '0962623111', 4),
(4, 2, 'Trần Duy', 'Hồ Chí Minh', 'uploads/driver_4.jpg', '0962623458', 4),
(5, 4, 'Hồ sao', 'Hồ sao Address', 'uploads/driver_5.jpg', '0962623144', 4),
(6, 3, 'Demo Driver', 'Demo Driver Address', 'uploads/driver_6.jpg', '01526489268', 4),
(7, 2, 'Demo Driver 2', 'Demo Driver 2 Address', 'uploads/driver_7.jpg', '1874684621412', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lines`
--

CREATE TABLE IF NOT EXISTS `lines` (
`line_id` int(11) NOT NULL,
  `vehicletype_id` int(11) NOT NULL,
  `line_name` varchar(255) DEFAULT NULL,
  `line_description` text,
  `line_start_time` time DEFAULT NULL,
  `line_end_time` time DEFAULT NULL,
  `line_image` varchar(255) DEFAULT NULL,
  `record_status` int(11) DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lines`
--

INSERT INTO `lines` (`line_id`, `vehicletype_id`, `line_name`, `line_description`, `line_start_time`, `line_end_time`, `line_image`, `record_status`) VALUES
(7, 2, 'Hà Nội - Nam Định', 'Hà Nội - Nam Định Description', '16:30:00', '19:30:00', 'uploads/line_7.jpg', 4),
(8, 3, 'Nam Định - Hải Phòng', 'Nam Định - Hải Phòng Description', '13:30:00', '17:30:00', 'uploads/line_8.jpg', 4),
(9, 1, 'Demo', 'Demo', '18:45:00', '18:45:00', 'uploads/no-thumbnail.png', 4),
(10, 4, 'Huế - Đà Nẵng', 'Huế - Đà Nẵng Description', '00:15:00', '04:15:00', 'uploads/line_10.jpg', 4),
(11, 2, 'Nha Trang - Vũng Tàu', 'Nha Trang - Vũng Tàu Description', '13:15:00', '14:15:00', 'uploads/line_11.jpg', 4),
(12, 3, 'Ninh Bình - Hà Nội', 'Ninh Bình - Hà Nội Description', '00:15:00', '05:15:00', 'uploads/line_12.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
`station_id` int(255) unsigned NOT NULL,
  `line_id` int(11) DEFAULT NULL,
  `station_name` varchar(255) DEFAULT NULL,
  `station_description` text,
  `station_image` varchar(255) DEFAULT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`station_id`, `line_id`, `station_name`, `station_description`, `station_image`, `record_status`) VALUES
(4, 7, 'Ga 001', 'Ga 001 Description', 'uploads/station_4.jpg', 4),
(5, 8, 'Demo', 'Demo', 'uploads/station_5.jpg', 4),
(6, 9, 'Ga 003', 'Ga 003 Description', 'uploads/station_6.jpg', 4),
(7, 12, 'Ga 004', 'Ga 004 Description', 'uploads/station_7.jpg', 4),
(8, 11, 'Ga 005', 'Ga 005 Description', 'uploads/station_8.jpg', 4),
(9, 10, 'Ga 007', 'Ga 007 Description', 'uploads/station_9.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_first_name` varchar(32) NOT NULL,
  `user_last_name` varchar(32) NOT NULL,
  `user_phone` varchar(12) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_auth_key` varchar(255) NOT NULL,
  `user_access_token` varchar(255) NOT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_first_name`, `user_last_name`, `user_phone`, `user_password`, `user_auth_key`, `user_access_token`, `record_status`) VALUES
(4, 'callmehuyv@gmail.com', 'Call me', 'Huy V', '0962623140', '$2y$13$fMivyhVnsW5U6up/RqJfbedn48TC7L8c0xaKKfVdVHZtFP8JRHDqy', '2LjMY2I3amL0TQp72Upj9f49nPnUecds', '', 4),
(6, 'vbaothu@gmail.com', 'Huy', 'Tran', '0962623143', '$2y$13$Do46ehpQD4ciM7kcc2xZLeu8nt2.4CNeLu97g.k5SNS3HMPqlEXZC', 'hDv5ECDDmxNKXK3JciQfQKOCQebntEhZ', '', 4),
(7, 'admin@admin.com', 'Admin', 'Mr', '0962623143', '$2y$13$PDmIF1/OC21ZcjqdoXKO8.CeuFfvT17Su8pg3Uetu71avocs398vO', 'UtRRb8S0j4pln4eFQccGucrqxi_eIq7G', '', 4),
(8, 'huymourinho@gmail.com', 'Huy', 'Mourinho', '0123456789', '$2y$13$gPaL1noCn9iXuUlSSRCVFORcIBzaHH5UNrN7AP/GhIpNov/eSCqPq', 'mnP4ijUEGDWAtKafNuaZyf-qqKuPgIbD', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
`vehicle_id` int(11) NOT NULL,
  `vehicle_number` varchar(64) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `line_id` int(11) DEFAULT NULL,
  `vehicletype_id` int(255) DEFAULT NULL,
  `driver_id` int(10) unsigned NOT NULL,
  `vehicle_image` varchar(255) DEFAULT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_number`, `company_id`, `line_id`, `vehicletype_id`, `driver_id`, `vehicle_image`, `record_status`) VALUES
(3, '18N-12374', 2, 7, 1, 3, 'uploads/vehicle_3.jpg', 4),
(4, '28M-12345', 2, 7, 1, 1, 'uploads/vehicle_4.jpg', 4),
(5, '30-A 12674', 5, 9, 1, 5, 'uploads/vehicle_5.jpg', 4),
(6, '30-B 124512', 6, 12, 3, 2, 'uploads/vehicle_6.jpg', 4),
(7, '22-A 12674', 3, 11, 4, 4, 'uploads/vehicle_7.jpg', 4),
(8, '07-C 12674', 4, 10, 3, 7, 'uploads/vehicle_8.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `vehicletypes`
--

CREATE TABLE IF NOT EXISTS `vehicletypes` (
`vehicletype_id` int(11) NOT NULL,
  `vehicletype_name` varchar(255) DEFAULT NULL,
  `vehicletype_description` text,
  `vehicletype_image` varchar(255) DEFAULT NULL,
  `record_status` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicletypes`
--

INSERT INTO `vehicletypes` (`vehicletype_id`, `vehicletype_name`, `vehicletype_description`, `vehicletype_image`, `record_status`) VALUES
(1, 'Trams', 'Trams Description', 'uploads/vehicletype_1.jpg', 4),
(2, 'Autobuses', 'Autobuses Description', 'uploads/vehicletype_2.jpg', 4),
(3, 'Nightliner', 'Nightliner Description', 'uploads/vehicletype_3.jpg', 4),
(4, 'Regional Bus', 'Regional Bus Description', 'uploads/vehicletype_4.jpg', 4),
(5, 'Demo', 'Demo', 'uploads/vehicletype_5.jpg', 4),
(6, 'Demo 2', 'Demo 2 Description', 'uploads/vehicletype_6.jpg', 4),
(7, 'Demo 3', 'Demo 3 Description', 'uploads/vehicletype_7.jpg', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
 ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
 ADD PRIMARY KEY (`driver_id`), ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `lines`
--
ALTER TABLE `lines`
 ADD PRIMARY KEY (`line_id`), ADD KEY `vehicletype_id` (`vehicletype_id`), ADD KEY `vehicletype_id_2` (`vehicletype_id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
 ADD PRIMARY KEY (`station_id`), ADD KEY `line_id` (`line_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
 ADD PRIMARY KEY (`vehicle_id`), ADD KEY `company_id` (`company_id`), ADD KEY `line_id` (`line_id`), ADD KEY `vehicle_type_id` (`vehicletype_id`), ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `vehicletypes`
--
ALTER TABLE `vehicletypes`
 ADD PRIMARY KEY (`vehicletype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
MODIFY `driver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `lines`
--
ALTER TABLE `lines`
MODIFY `line_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
MODIFY `station_id` int(255) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vehicletypes`
--
ALTER TABLE `vehicletypes`
MODIFY `vehicletype_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lines`
--
ALTER TABLE `lines`
ADD CONSTRAINT `lines_ibfk_1` FOREIGN KEY (`vehicletype_id`) REFERENCES `vehicletypes` (`vehicletype_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stations`
--
ALTER TABLE `stations`
ADD CONSTRAINT `stations_ibfk_1` FOREIGN KEY (`line_id`) REFERENCES `lines` (`line_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`line_id`) REFERENCES `lines` (`line_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `vehicles_ibfk_4` FOREIGN KEY (`vehicletype_id`) REFERENCES `vehicletypes` (`vehicletype_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
