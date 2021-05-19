-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2021 at 02:05 AM
-- Server version: 5.6.48
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airkomcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `call_type`
--

DROP TABLE IF EXISTS `call_type`;
CREATE TABLE IF NOT EXISTS `call_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `call_type`
--

INSERT INTO `call_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Cold Call', 1, 1, '2021-05-17 17:22:32'),
(2, 'Prospect', 1, 1, '2021-05-17 17:22:48'),
(3, 'OEM', 1, 1, '2021-05-17 17:22:55'),
(4, 'Consultant', 1, 1, '2021-05-17 17:23:05'),
(5, 'Order', 1, 1, '2021-05-17 17:23:24'),
(6, 'Payment', 1, 1, '2021-05-17 17:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `contacted_type`
--

DROP TABLE IF EXISTS `contacted_type`;
CREATE TABLE IF NOT EXISTS `contacted_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacted_type`
--

INSERT INTO `contacted_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Phone', 1, 1, '2021-05-17 15:56:24'),
(2, 'Email', 1, 1, '2021-05-17 16:45:59'),
(3, 'Whatsapp', 1, 1, '2021-05-17 16:46:08'),
(4, 'Visit', 1, 1, '2021-05-17 16:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `designation`, `company`, `city`, `address`, `telephone`, `email`, `website`, `created_by`, `date_created`) VALUES
(3, 'Aladdin Mckay', 'Voluptatem Do et po', 'Holt Spears Co', 'Harum magnam unde an', 'Consequatur et paria', '9876543210', 'gogok@mailinator.com', 'https://www.topatutun.org.au', 1, '2021-05-18 15:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `dcr`
--

DROP TABLE IF EXISTS `dcr`;
CREATE TABLE IF NOT EXISTS `dcr` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `visit_date` date NOT NULL,
  `start_period` date NOT NULL,
  `end_period` date NOT NULL,
  `dcr_no` int(10) NOT NULL,
  `travel_type` int(10) NOT NULL,
  `call_type` int(10) NOT NULL,
  `call_count` int(10) NOT NULL DEFAULT '1',
  `contact_id` int(10) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quanitity` int(10) NOT NULL,
  `order_value` decimal(10,2) NOT NULL,
  `sales_stage` int(11) NOT NULL,
  `next_action` int(10) NOT NULL,
  `remarks` text NOT NULL,
  `Bike_km_reading_start` int(10) NOT NULL,
  `bike_km_reading_end` int(10) NOT NULL,
  `distance_travelled` int(10) NOT NULL,
  `amount_one` decimal(10,2) NOT NULL,
  `travel_mode` int(10) NOT NULL,
  `amount_two` decimal(10,2) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dcr`
--

INSERT INTO `dcr` (`id`, `visit_date`, `start_period`, `end_period`, `dcr_no`, `travel_type`, `call_type`, `call_count`, `contact_id`, `product_series`, `product_model`, `product_id`, `quanitity`, `order_value`, `sales_stage`, `next_action`, `remarks`, `Bike_km_reading_start`, `bike_km_reading_end`, `distance_travelled`, `amount_one`, `travel_mode`, `amount_two`, `created_by`, `date_created`) VALUES
(1, '2021-05-07', '2021-05-07', '2021-05-13', 5678, 2, 2, 1, 3, 7, 42, 4, 63, '25000.00', 7, 3, 'Dolorem ad sint ut r', 8, 80, 72, '180.00', 1, '6789.00', 1, '2021-05-18 17:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `lead_source`
--

DROP TABLE IF EXISTS `lead_source`;
CREATE TABLE IF NOT EXISTS `lead_source` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_source`
--

INSERT INTO `lead_source` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Direct', 1, 1, '2021-05-18 19:06:44'),
(2, 'Reseller', 1, 1, '2021-05-18 19:06:53'),
(3, 'Contractor', 1, 1, '2021-05-18 19:07:03'),
(4, 'Consultant', 1, 1, '2021-05-18 19:07:14'),
(5, 'OEM', 1, 1, '2021-05-18 19:08:33'),
(6, 'Other', 1, 1, '2021-05-18 19:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `lead_stage`
--

DROP TABLE IF EXISTS `lead_stage`;
CREATE TABLE IF NOT EXISTS `lead_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_stage`
--

INSERT INTO `lead_stage` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Early', 1, 1, '2021-05-17 16:54:09'),
(2, 'Active', 1, 1, '2021-05-17 16:54:16'),
(3, 'Close', 1, 1, '2021-05-17 16:54:22'),
(4, 'Offline', 1, 1, '2021-05-17 16:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` text NOT NULL,
  `action_name` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `property_id` int(2) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `action`, `action_name`, `user`, `property_id`, `date_created`) VALUES
(1, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-16 19:25:21'),
(2, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-16 19:26:33'),
(3, 'SystemUserType Added', '', 'admin@airkomgroup.com', 0, '2021-05-16 20:17:27'),
(4, 'SystemUserType Edited', 'aa', 'admin@airkomgroup.com', 0, '2021-05-16 20:18:20'),
(5, 'SystemUserType Added', 'Executives', 'admin@airkomgroup.com', 0, '2021-05-17 09:20:05'),
(6, 'ContactedType Added', 'Phone', 'admin@airkomgroup.com', 0, '2021-05-17 15:56:24'),
(7, 'ContactedType Added', 'Email', 'admin@airkomgroup.com', 0, '2021-05-17 16:45:59'),
(8, 'ContactedType Added', 'Whatsapp', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:08'),
(9, 'ContactedType Added', 'Visit', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:15'),
(10, 'ContactedType Edited', 'Emails', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:21'),
(11, 'ContactedType Edited', 'Email', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:28'),
(12, 'LeadStage Added', 'Early', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:09'),
(13, 'LeadStage Added', 'Active', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:16'),
(14, 'LeadStage Added', 'Close', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:22'),
(15, 'LeadStage Added', 'Offline', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:29'),
(16, 'MarketSegment Edited', 'Analytical Equipment', 'admin@airkomgroup.com', 0, '2021-05-17 17:02:59'),
(17, 'NextAction Edited', 'Budget Approval', 'admin@airkomgroup.com', 0, '2021-05-17 17:04:43'),
(18, 'Probability Added', '25', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:14'),
(19, 'Probability Added', '50', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:20'),
(20, 'Probability Added', '75', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:27'),
(21, 'Probability Added', '90', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:33'),
(22, 'Probability Added', '100', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:41'),
(23, 'Products Edited', '1 kVA', 'admin@airkomgroup.com', 0, '2021-05-17 17:10:05'),
(24, 'TravelMode Added', 'Bus', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:30'),
(25, 'TravelMode Added', 'Taxi', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:36'),
(26, 'TravelMode Added', 'Auto', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:45'),
(27, 'TravelMode Added', 'Others', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:51'),
(28, 'TravelType Added', 'Local', 'admin@airkomgroup.com', 0, '2021-05-17 17:14:42'),
(29, 'TravelType Added', 'Outstation', 'admin@airkomgroup.com', 0, '2021-05-17 17:14:50'),
(30, 'CallType Added', 'Cold Call', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:32'),
(31, 'CallType Added', 'Prospect', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:48'),
(32, 'CallType Added', 'OEM', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:55'),
(33, 'CallType Added', 'Consultants', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:05'),
(34, 'CallType Edited', 'Consultant', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:16'),
(35, 'CallType Added', 'Order', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:24'),
(36, 'CallType Added', 'Payment', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:32'),
(37, 'Contact Added', 'Bertha Stark', 'admin@airkomgroup.com', 0, '2021-05-18 15:42:16'),
(38, 'Contact Edited', 'Bertha Starks', 'admin@airkomgroup.com', 0, '2021-05-18 15:52:28'),
(39, 'Contact Deleted', 'Bertha Starks', 'admin@airkomgroup.com', 0, '2021-05-18 15:55:50'),
(40, 'Contact Added', 'Deanna Whitney', 'admin@airkomgroup.com', 0, '2021-05-18 15:56:10'),
(41, 'Contact Deleted', 'Deanna Whitney', 'admin@airkomgroup.com', 0, '2021-05-18 15:56:15'),
(42, 'Contact Added', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-18 15:57:35'),
(43, 'CallType Added', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:09:15'),
(44, 'CallType Deleted', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:09:19'),
(45, 'CallType Added', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:01'),
(46, 'CallType Deleted', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:06'),
(47, 'CallType Added', 'aaaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:24'),
(48, 'Call Type Deleted', 'aaaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:33'),
(49, 'TravelType Added', 'Xander Washington', 'admin@airkomgroup.com', 0, '2021-05-18 16:18:35'),
(50, 'Travel Type Deleted', 'Xander Washington', 'admin@airkomgroup.com', 0, '2021-05-18 16:18:40'),
(51, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-18 17:23:19'),
(52, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-18 17:23:25'),
(53, 'DCR Added', 'Voluptatem amet su', 'admin@airkomgroup.com', 0, '2021-05-18 17:43:02'),
(54, 'DCR Edited', '0', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:04'),
(55, 'DCR Edited', '0', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:20'),
(56, 'DCR Edited', '5678', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:37'),
(57, 'DCR Edited', '5678', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:47'),
(58, 'DCR Deleted', '0', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:24'),
(59, 'DCR Added', 'Molestias autem aute', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:52'),
(60, 'DCR Deleted', '0', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:56'),
(61, 'LeadSource Added', 'Early', 'admin@airkomgroup.com', 0, '2021-05-18 19:06:44'),
(62, 'LeadSource Added', 'Active', 'admin@airkomgroup.com', 0, '2021-05-18 19:06:53'),
(63, 'LeadSource Added', 'Close', 'admin@airkomgroup.com', 0, '2021-05-18 19:07:03'),
(64, 'LeadSource Added', 'Offline', 'admin@airkomgroup.com', 0, '2021-05-18 19:07:14'),
(65, 'LeadSource Added', 'OEM', 'admin@airkomgroup.com', 0, '2021-05-18 19:08:33'),
(66, 'LeadSource Added', 'Other', 'admin@airkomgroup.com', 0, '2021-05-18 19:08:42'),
(67, 'SPT Added', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:19:57'),
(68, 'SPT Edited', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:39:27'),
(69, 'SPT Edited', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:39:37'),
(70, 'SPT Deleted', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:40:27'),
(71, 'SPT Added', 'Tad Nash', 'admin@airkomgroup.com', 0, '2021-05-18 19:41:05'),
(72, 'Market Segment Deleted', 'Manufacturing - Others (Specifiy)', 'admin@airkomgroup.com', 0, '2021-05-18 19:57:17'),
(73, 'Roadmap Added', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 19:57:41'),
(74, 'Roadmap Edited', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 20:07:06'),
(75, 'Roadmap Deleted', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 20:07:55'),
(76, 'Roadmap Added', 'Camilla Hardin', 'admin@airkomgroup.com', 0, '2021-05-18 20:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `market_segment`
--

DROP TABLE IF EXISTS `market_segment`;
CREATE TABLE IF NOT EXISTS `market_segment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market_segment`
--

INSERT INTO `market_segment` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Analytical Equipment', 1, 1, '2021-05-17 22:26:20'),
(2, 'Banking/Finance/Insurance', 1, 1, '2021-05-17 22:26:20'),
(3, 'CNC', 1, 1, '2021-05-17 22:26:20'),
(4, 'Consultant', 1, 1, '2021-05-17 22:26:20'),
(5, 'Dealer', 1, 1, '2021-05-17 22:26:20'),
(6, 'Defence', 1, 1, '2021-05-17 22:26:20'),
(7, 'Electrical Contractor', 1, 1, '2021-05-17 22:26:20'),
(8, 'Food Industry', 1, 1, '2021-05-17 22:26:20'),
(9, 'Govt- Public Sector', 1, 1, '2021-05-17 22:26:20'),
(10, 'Hospital', 1, 1, '2021-05-17 22:26:20'),
(11, 'Hospitality / Bangalow', 1, 1, '2021-05-17 22:26:20'),
(12, 'IT Networking', 1, 1, '2021-05-17 22:26:20'),
(13, 'Manufacturing - Corporate', 1, 1, '2021-05-17 22:26:20'),
(15, 'Medical', 1, 1, '2021-05-17 22:26:20'),
(16, 'Multiplex', 1, 1, '2021-05-17 22:26:20'),
(17, 'Pharmaceutical', 1, 1, '2021-05-17 22:26:20'),
(18, 'Printing', 1, 1, '2021-05-17 22:26:20'),
(19, 'Railway', 1, 1, '2021-05-17 22:26:20'),
(20, 'Real Estate', 1, 1, '2021-05-17 22:26:20'),
(21, 'Reseller', 1, 1, '2021-05-17 22:26:20'),
(22, 'Retail Chain', 1, 1, '2021-05-17 22:26:20'),
(23, 'Textile', 1, 1, '2021-05-17 22:26:20'),
(24, 'Warehouse / Cold Storage', 1, 1, '2021-05-17 22:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `next_action`
--

DROP TABLE IF EXISTS `next_action`;
CREATE TABLE IF NOT EXISTS `next_action` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `next_action`
--

INSERT INTO `next_action` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Lead Verification', 1, 1, '2021-05-17 22:34:33'),
(2, 'First Stage Meeting', 1, 1, '2021-05-17 22:34:33'),
(3, 'Technical Meeting', 1, 1, '2021-05-17 22:34:33'),
(4, 'Commercial Meeting', 1, 1, '2021-05-17 22:34:33'),
(5, 'Budget Approval', 1, 1, '2021-05-17 22:34:33'),
(6, 'Close Deal', 1, 1, '2021-05-17 22:34:33'),
(7, 'Verbal Approval', 1, 1, '2021-05-17 22:34:33'),
(8, 'PO Collection', 1, 1, '2021-05-17 22:34:33'),
(9, 'Contract Signed', 1, 1, '2021-05-17 22:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `description`, `date_created`) VALUES
(2, 'permission.manage', 'Manage permissions', '2017-08-03 09:14:52'),
(3, 'role.manage', 'Manage roles', '2017-08-03 09:14:52'),
(4, 'profile.any.view', 'View anyone\'s profile', '2017-08-03 09:14:52'),
(5, 'profile.own.view', 'View own profile', '2017-08-03 09:14:52'),
(21, 'settings.manage', 'Manage Settings', '2017-12-16 06:23:21'),
(22, 'masters.manage', 'Manage Masters', '2017-12-16 06:23:40'),
(29, 'password.manage', 'Manage Password', '2018-04-26 15:37:46'),
(31, 'logs.manage', 'Manage Logs', '2018-05-16 15:51:42'),
(40, 'dashboard.manage', 'Manage Dashboard', '2018-06-05 16:38:29'),
(48, 'user.manage', 'Manage Users', '2020-05-11 01:35:12'),
(49, 'spt.manage', 'Manage SPT Forms', '2021-05-17 23:47:44'),
(50, 'dcr.manage', 'Manage DCR Forms', '2021-05-17 23:48:00'),
(51, 'roadmap.manage', 'Manage RoadMaps', '2021-05-17 23:48:23'),
(52, 'reports.manage', 'Manage Reports', '2021-05-17 23:48:38'),
(53, 'contacts.manage', 'Manage Contacts', '2021-05-18 00:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `probability`
--

DROP TABLE IF EXISTS `probability`;
CREATE TABLE IF NOT EXISTS `probability` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `probability`
--

INSERT INTO `probability` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, '25', 1, 1, '2021-05-17 17:08:14'),
(2, '50', 1, 1, '2021-05-17 17:08:20'),
(3, '75', 1, 1, '2021-05-17 17:08:27'),
(4, '90', 1, 1, '2021-05-17 17:08:33'),
(5, '100', 1, 1, '2021-05-17 17:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, '1 kVA', 1, 1, '2021-05-17 22:39:55'),
(2, '3 kVA', 1, 1, '2021-05-17 22:39:55'),
(3, '5 kVA', 1, 1, '2021-05-17 22:39:55'),
(4, '6 kVA', 1, 1, '2021-05-17 22:39:55'),
(5, '8 kVA', 1, 1, '2021-05-17 22:39:55'),
(6, '10 kVA', 1, 1, '2021-05-17 22:39:55'),
(7, '12 kVA', 1, 1, '2021-05-17 22:39:55'),
(8, '15 kVA', 1, 1, '2021-05-17 22:39:55'),
(9, '20 kVA', 1, 1, '2021-05-17 22:39:55'),
(10, '25 kVA', 1, 1, '2021-05-17 22:39:55'),
(11, '30 kVA', 1, 1, '2021-05-17 22:39:55'),
(12, '35 kVA', 1, 1, '2021-05-17 22:39:55'),
(13, '40 kVA', 1, 1, '2021-05-17 22:39:55'),
(14, '45 kVA', 1, 1, '2021-05-17 22:39:55'),
(15, '50 kVA', 1, 1, '2021-05-17 22:39:55'),
(16, '55 kVA', 1, 1, '2021-05-17 22:39:55'),
(17, '60 kVA', 1, 1, '2021-05-17 22:39:55'),
(18, '70 kVA', 1, 1, '2021-05-17 22:39:55'),
(19, '75 kVA', 1, 1, '2021-05-17 22:39:55'),
(20, '90 kVA', 1, 1, '2021-05-17 22:39:55'),
(21, '100 kVA', 1, 1, '2021-05-17 22:39:55'),
(22, '110 kVA', 1, 1, '2021-05-17 22:39:55'),
(23, '125 kVA', 1, 1, '2021-05-17 22:39:55'),
(24, '150 kVA', 1, 1, '2021-05-17 22:39:55'),
(25, '200 kVA', 1, 1, '2021-05-17 22:39:55'),
(26, '250 kVA', 1, 1, '2021-05-17 22:39:55'),
(27, '300 kVA', 1, 1, '2021-05-17 22:39:55'),
(28, '400 kVA', 1, 1, '2021-05-17 22:39:55'),
(29, '500 kVA', 1, 1, '2021-05-17 22:39:55'),
(30, '600 kVA', 1, 1, '2021-05-17 22:39:55'),
(31, '750 kVA', 1, 1, '2021-05-17 22:39:55'),
(32, '1000 kVA', 1, 1, '2021-05-17 22:39:55'),
(33, '1250 kVA', 1, 1, '2021-05-17 22:39:55'),
(34, '1500 kVA', 1, 1, '2021-05-17 22:39:55'),
(35, '1600 kVA', 1, 1, '2021-05-17 22:39:55'),
(36, '1750 kVA', 1, 1, '2021-05-17 22:39:55'),
(37, '2000 kVA', 1, 1, '2021-05-17 22:39:55'),
(38, '2200 kVA', 1, 1, '2021-05-17 22:39:55'),
(39, '2500 kVA', 1, 1, '2021-05-17 22:39:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_models`
--

DROP TABLE IF EXISTS `product_models`;
CREATE TABLE IF NOT EXISTS `product_models` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_models`
--

INSERT INTO `product_models` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'AT1:1', 1, 1, '2021-05-17 22:40:47'),
(2, 'AT3:1', 1, 1, '2021-05-17 22:40:47'),
(3, 'AT3:3', 1, 1, '2021-05-17 22:40:47'),
(4, 'HFT1:1', 1, 1, '2021-05-17 22:40:47'),
(5, 'HX1:1', 1, 1, '2021-05-17 22:40:47'),
(6, 'HX3:1', 1, 1, '2021-05-17 22:40:47'),
(7, 'HX3:3', 1, 1, '2021-05-17 22:40:47'),
(8, 'HXNS', 1, 1, '2021-05-17 22:40:47'),
(9, 'IT1:1', 1, 1, '2021-05-17 22:40:47'),
(10, 'IT3:1', 1, 1, '2021-05-17 22:40:47'),
(11, 'IT3:3', 1, 1, '2021-05-17 22:40:47'),
(12, 'IX1:1', 1, 1, '2021-05-17 22:40:47'),
(13, 'IX3:1', 1, 1, '2021-05-17 22:40:47'),
(14, 'IX3:3', 1, 1, '2021-05-17 22:40:47'),
(15, 'IXNS', 1, 1, '2021-05-17 22:40:47'),
(16, 'LIFTUPS1:1', 1, 1, '2021-05-17 22:40:47'),
(17, 'LIFTUPS3:3', 1, 1, '2021-05-17 22:40:47'),
(18, 'Off-grid', 1, 1, '2021-05-17 22:40:47'),
(19, 'On-grid ', 1, 1, '2021-05-17 22:40:47'),
(20, 'SI1:1', 1, 1, '2021-05-17 22:40:47'),
(21, 'SI3:1', 1, 1, '2021-05-17 22:40:47'),
(22, 'SI3:3', 1, 1, '2021-05-17 22:40:47'),
(23, 'SIPCU1:1', 1, 1, '2021-05-17 22:40:47'),
(24, 'SIPCU3:1', 1, 1, '2021-05-17 22:40:47'),
(25, 'SIPCU3:3', 1, 1, '2021-05-17 22:40:47'),
(26, 'SP7070', 1, 1, '2021-05-17 22:40:47'),
(27, 'SPNS', 1, 1, '2021-05-17 22:40:47'),
(28, 'SPWR', 1, 1, '2021-05-17 22:40:47'),
(29, 'TPAC1080', 1, 1, '2021-05-17 22:40:47'),
(30, 'TPAC1080', 1, 1, '2021-05-17 22:40:47'),
(31, 'TPAC4080', 1, 1, '2021-05-17 22:40:47'),
(32, 'TPAC4080', 1, 1, '2021-05-17 22:40:47'),
(33, 'TPAC5070', 1, 1, '2021-05-17 22:40:47'),
(34, 'TPAC5070', 1, 1, '2021-05-17 22:40:47'),
(35, 'TPAC6060', 1, 1, '2021-05-17 22:40:47'),
(36, 'TPAC6060', 1, 1, '2021-05-17 22:40:47'),
(37, 'TPAC8080', 1, 1, '2021-05-17 22:40:47'),
(38, 'TPAC8080', 1, 1, '2021-05-17 22:40:47'),
(39, 'TPACNS', 1, 1, '2021-05-17 22:40:47'),
(40, 'TPACNS', 1, 1, '2021-05-17 22:40:47'),
(41, 'TPACXWR', 1, 1, '2021-05-17 22:40:47'),
(42, 'TPACXWR', 1, 1, '2021-05-17 22:40:47'),
(43, 'TPAR', 1, 1, '2021-05-17 22:40:47'),
(44, 'TPAR', 1, 1, '2021-05-17 22:40:47'),
(45, 'TPOC1080', 1, 1, '2021-05-17 22:40:47'),
(46, 'TPOC4080', 1, 1, '2021-05-17 22:40:47'),
(47, 'TPOC5070', 1, 1, '2021-05-17 22:40:47'),
(48, 'TPOC6060', 1, 1, '2021-05-17 22:40:47'),
(49, 'TPOC8080', 1, 1, '2021-05-17 22:40:47'),
(50, 'TPOCNS', 1, 1, '2021-05-17 22:40:47'),
(51, 'TPOCXWR', 1, 1, '2021-05-17 22:40:47'),
(52, 'TPOR', 1, 1, '2021-05-17 22:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_series`
--

DROP TABLE IF EXISTS `product_series`;
CREATE TABLE IF NOT EXISTS `product_series` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_series`
--

INSERT INTO `product_series` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'SCVS', 1, 1, '2021-05-17 22:41:38'),
(2, 'AVR', 1, 1, '2021-05-17 22:41:38'),
(3, 'UPS', 1, 1, '2021-05-17 22:41:38'),
(4, 'IT', 1, 1, '2021-05-17 22:41:38'),
(5, 'AT', 1, 1, '2021-05-17 22:41:38'),
(6, 'Solar Inverter', 1, 1, '2021-05-17 22:41:38'),
(7, 'SolarRTS', 1, 1, '2021-05-17 22:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `roadmap`
--

DROP TABLE IF EXISTS `roadmap`;
CREATE TABLE IF NOT EXISTS `roadmap` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `week` varchar(255) NOT NULL,
  `market_segment` int(10) NOT NULL,
  `prospect_name` varchar(255) NOT NULL,
  `prospect_city` varchar(255) NOT NULL,
  `propspect_machine` varchar(255) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `product` int(10) NOT NULL,
  `next_action` int(10) NOT NULL,
  `expected_quanitity` int(10) NOT NULL,
  `expected_potential_order_value` int(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roadmap`
--

INSERT INTO `roadmap` (`id`, `week`, `market_segment`, `prospect_name`, `prospect_city`, `propspect_machine`, `product_series`, `product_model`, `product`, `next_action`, `expected_quanitity`, `expected_potential_order_value`, `created_by`, `date_created`) VALUES
(2, '2', 5, 'Camilla Hardin', 'Voluptate adipisicin', 'Excepteur aut est do', 7, 15, 26, 4, 58, 50000, 1, '2021-05-18 20:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `date_created`) VALUES
(1, 'Administrator', 'A person who manages users, roles, etc.', '2017-08-03 09:14:52'),
(2, 'User', 'Users Only', '2018-04-13 17:34:20'),
(3, 'Executives', 'Executives Roles', '2021-05-17 14:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_hierarchy`
--

DROP TABLE IF EXISTS `role_hierarchy`;
CREATE TABLE IF NOT EXISTS `role_hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_role_id` int(11) NOT NULL,
  `child_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_role_id` (`parent_role_id`),
  UNIQUE KEY `child_role_id` (`child_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_id` (`permission_id`),
  KEY `permission_id_2` (`permission_id`),
  KEY `role_id` (`role_id`),
  KEY `permission_id_3` (`permission_id`),
  KEY `role_id_2` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1102 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(248, 2, 29),
(1081, 1, 53),
(1082, 1, 40),
(1083, 1, 50),
(1084, 1, 31),
(1085, 1, 22),
(1086, 1, 29),
(1087, 1, 2),
(1088, 1, 4),
(1089, 1, 5),
(1090, 1, 52),
(1091, 1, 51),
(1092, 1, 3),
(1093, 1, 21),
(1094, 1, 49),
(1095, 1, 48),
(1096, 3, 53),
(1097, 3, 40),
(1098, 3, 50),
(1099, 3, 5),
(1100, 3, 51),
(1101, 3, 49);

-- --------------------------------------------------------

--
-- Table structure for table `sales_stage`
--

DROP TABLE IF EXISTS `sales_stage`;
CREATE TABLE IF NOT EXISTS `sales_stage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_stage`
--

INSERT INTO `sales_stage` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Recent Lead', 1, 1, '2021-05-17 22:43:04'),
(2, 'Initial Contact', 1, 1, '2021-05-17 22:43:04'),
(3, 'Product Analysis', 1, 1, '2021-05-17 22:43:04'),
(4, 'Solution Development', 1, 1, '2021-05-17 22:43:04'),
(5, 'Offer Discussion', 1, 1, '2021-05-17 22:43:04'),
(6, 'Negotiation', 1, 1, '2021-05-17 22:43:04'),
(7, 'Contract Signing', 1, 1, '2021-05-17 22:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_brief` text NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_keywords` text NOT NULL,
  `page_description` text NOT NULL,
  `distance_travel_percentage` decimal(10,2) NOT NULL,
  `name_emailer` varchar(255) DEFAULT NULL,
  `email_emailer` varchar(255) DEFAULT NULL,
  `sms_enabled` int(10) DEFAULT NULL,
  `sms_api` varchar(255) DEFAULT NULL,
  `sendgrid_api` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_brief`, `contact`, `email`, `page_title`, `page_keywords`, `page_description`, `distance_travel_percentage`, `name_emailer`, `email_emailer`, `sms_enabled`, `sms_api`, `sendgrid_api`, `created_by`, `date_created`) VALUES
(1, 'Airkom Group', 'Airkom Electronics Pvt. Ltd (AEPL) is a young and rapidly growing company & it is a part of the AIRKOM GROUP. It has its Head Office & Factory at Mahape, Navi Mumbai. AIRKOM was incorporated in 1987. Started under the entrepreneurship of a young electronics engineer, AIRKOM today boasts of a multimillion turnovers. ', '+91  9323863400 ', 'enquiry@airkom.com', 'Airkom Group', 'Electronics, Compressors, Wipro Waters', '-', '2.50', 'Airkom group', 'admin@airkomgroup.com', 1, 'http://103.233.79.246//submitsms.jsp?user=Atat777&key=c85d97574fXX&mobile={mobile}&message={message}&senderid=infosm&accusage=1', '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', '1', '2017-11-21 07:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `spt`
--

DROP TABLE IF EXISTS `spt`;
CREATE TABLE IF NOT EXISTS `spt` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stage` int(10) NOT NULL,
  `propect_name` varchar(255) NOT NULL,
  `lead_source` int(10) NOT NULL,
  `executive` int(10) NOT NULL,
  `offer_no` varchar(255) NOT NULL,
  `sales_stage` int(10) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `actual_product` int(10) NOT NULL,
  `forecasted_booking_value` decimal(10,2) NOT NULL,
  `quanitity` int(10) NOT NULL,
  `expected_close_date` date NOT NULL,
  `expected_month` int(10) NOT NULL,
  `close_probability` int(11) NOT NULL,
  `next_action` int(10) NOT NULL,
  `last_contacted_date` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `contacted_type` int(10) NOT NULL,
  `contact_id` int(10) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spt`
--

INSERT INTO `spt` (`id`, `stage`, `propect_name`, `lead_source`, `executive`, `offer_no`, `sales_stage`, `product_series`, `product_model`, `actual_product`, `forecasted_booking_value`, `quanitity`, `expected_close_date`, `expected_month`, `close_probability`, `next_action`, `last_contacted_date`, `remarks`, `contacted_type`, `contact_id`, `created_by`, `date_created`) VALUES
(2, 2, 'Tad Nash', 2, 5, '465377', 3, 1, 13, 11, '25000.00', 41, '2021-05-19', 7, 2, 2, '2021-05-19', 'He is Interested', 3, 3, 1, '2021-05-18 19:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `system_user_type`
--

DROP TABLE IF EXISTS `system_user_type`;
CREATE TABLE IF NOT EXISTS `system_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `confidential` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_user_type`
--

INSERT INTO `system_user_type` (`id`, `name`, `status`, `confidential`, `created_by`, `date_created`) VALUES
(1, 'Administrator', 0, 1, 1, '2017-12-08 12:24:13'),
(2, 'User', 1, 1, 1, '2017-12-08 12:23:18'),
(3, 'Executives', 1, 0, 1, '2021-05-17 09:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `travel_mode`
--

DROP TABLE IF EXISTS `travel_mode`;
CREATE TABLE IF NOT EXISTS `travel_mode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_mode`
--

INSERT INTO `travel_mode` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Bus', 1, 1, '2021-05-17 17:13:30'),
(2, 'Taxi', 1, 1, '2021-05-17 17:13:36'),
(3, 'Auto', 1, 1, '2021-05-17 17:13:45'),
(4, 'Others', 1, 1, '2021-05-17 17:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `travel_type`
--

DROP TABLE IF EXISTS `travel_type`;
CREATE TABLE IF NOT EXISTS `travel_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_type`
--

INSERT INTO `travel_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Local', 1, 1, '2021-05-17 17:14:42'),
(2, 'Outstation', 1, 1, '2021-05-17 17:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `full_name` varchar(512) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `pwd_reset_token` varchar(32) DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_idx` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `full_name`, `password`, `status`, `contact_no`, `user_type`, `profile_pic`, `date_created`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
(1, 'admin@airkomgroup.com', 'Administrator -', '$2y$10$xDR3ovnlXF.hApOxOO05Bu/it8VxkKJHRflYEQSyYMsB7WZPSYaY2', 1, '9876543210', '1', '35b953eca69b0e192c42c0d3dac37563.png', '2017-08-03 09:14:52', NULL, NULL),
(2, 'prasanna@airkomgroup.com', 'Prasanna M', '$2y$10$NPp81p9.raRAPRi4xpG06uTk7OQTjhbmM8TiAp4ssBQKQYkO0Fu56', 1, '9876543210', '1', '', '2021-05-17 20:15:30', NULL, NULL),
(3, 'vishnu@airkomgroup.com', 'Vishnu -', '$2y$10$HKHruBTrfHX0kMEDlwG2tev9mE6V6lLkpz0geF166swUjOw2JdXd.', 1, '9876543210', '3', '', '2021-05-17 20:48:46', NULL, NULL),
(4, 'kamal@airkomgroup.com', 'Kamal -', '$2y$10$ggEgLLeJ8JvP6edKBInOyeQKH5bz2ZKnFdMDjzYiIVjPBvWqZkmNu', 1, '9876543210', '3', '', '2021-05-17 20:51:24', NULL, NULL),
(5, 'nitin@airkomgroup.com', 'Nitin -', '$2y$10$ynt83mJKk5LyUtCkj5XtIuA3gxy6BZsbsq7pFUtb7NzSoKLCTfcju', 1, '9876543210', '3', '', '2021-05-17 20:52:02', NULL, NULL),
(6, 'vega@airkomgroup.com', 'Vega -', '$2y$10$JeN4kNNBkHomSp4xmKtYb.ceNwv68488hp08yqBgVULGp6YBNPS5m', 1, '9876543210', '3', '', '2021-05-17 20:52:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `user_type` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `alternate_number` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text,
  `pincode` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `remark` text,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `user_type`, `first_name`, `last_name`, `email`, `contact`, `alternate_number`, `state`, `city`, `address`, `pincode`, `birth_date`, `anniversary_date`, `remark`, `date_created`) VALUES
(1, 1, 1, 'Administrator', '-', 'admin@airkomgroup.com', '9876543210', '-', 'Maharastra', 'Mumbai', 'Chembur', '400043', '2021-05-11', '2021-05-10', '', '2021-05-09 20:17:24'),
(2, 2, 1, 'Prasanna', 'M', 'prasanna@airkomgroup.com', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-17 14:45:30'),
(3, 3, 3, 'Vishnu', '-', 'vishnu@airkomgroup.com', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-17 15:18:46'),
(4, 4, 3, 'Kamal', '-', 'kamal@airkomgroup.com', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-17 15:21:24'),
(5, 5, 3, 'Nitin', '-', 'nitin@airkomgroup.com', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-17 15:22:02'),
(6, 6, 3, 'Vega', '-', 'vega@airkomgroup.com', '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-17 15:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1),
(6, 3, 3),
(7, 3, 4),
(8, 3, 5),
(9, 3, 6),
(10, 1, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  ADD CONSTRAINT `role_role_child_role_id_fk` FOREIGN KEY (`child_role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_role_parent_role_id_fk` FOREIGN KEY (`parent_role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_fk` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  ADD CONSTRAINT `role_permission_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
