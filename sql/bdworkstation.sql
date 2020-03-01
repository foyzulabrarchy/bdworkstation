-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 11:08 AM
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
-- Database: `bdworkstation`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer_table`
--

CREATE TABLE `answer_table` (
  `id` int(100) NOT NULL,
  `question_id` int(100) NOT NULL,
  `answer` varchar(500) COLLATE utf8_bin NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `answer_table`
--

INSERT INTO `answer_table` (`id`, `question_id`, `answer`, `is_active`) VALUES
(9, 1, 'what', 0);

-- --------------------------------------------------------

--
-- Table structure for table `area_table`
--

CREATE TABLE `area_table` (
  `area_id` int(15) NOT NULL,
  `area_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area_table`
--

INSERT INTO `area_table` (`area_id`, `area_name`) VALUES
(1, 'Bandar, Chittagong'),
(2, 'Kotwali, Chittagong'),
(3, 'Chawkbazar, Chittagong'),
(4, 'Panchlaish, Chittagong'),
(5, 'Akbar Shah, Chittagong'),
(6, 'Bayazid Bostami, Chittagong'),
(7, 'Halishahar, Chittagong'),
(8, 'Pahartali, Chittagong'),
(9, 'Sadarghat, Chittagong'),
(10, 'AK Khan, Chittagong'),
(11, 'Muradpur, Chittagong');

-- --------------------------------------------------------

--
-- Table structure for table `avg_user_rating`
--

CREATE TABLE `avg_user_rating` (
  `user_id` int(100) NOT NULL,
  `user_rating` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `avg_user_rating`
--

INSERT INTO `avg_user_rating` (`user_id`, `user_rating`) VALUES
(1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `avg_worker_rating`
--

CREATE TABLE `avg_worker_rating` (
  `worker_id` int(100) NOT NULL,
  `worker_rating` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `avg_worker_rating`
--

INSERT INTO `avg_worker_rating` (`worker_id`, `worker_rating`) VALUES
(2, 40),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(13, 40),
(14, 0),
(15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(14) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Appliance Repair'),
(2, 'Shifting'),
(3, 'Gadgets Repair'),
(4, 'Business Support'),
(5, 'Beauty Services'),
(6, 'Laundry Home Service'),
(7, 'Food'),
(8, 'Cleaning & Pest Control'),
(9, 'Car Rental'),
(10, 'Car Wash & Repair'),
(11, 'Electric'),
(12, 'Home and Office Renovation'),
(13, 'Trip and Travels'),
(14, 'Sanitary');

-- --------------------------------------------------------

--
-- Table structure for table `hire_table`
--

CREATE TABLE `hire_table` (
  `hire_id` int(15) NOT NULL,
  `job_id` int(15) NOT NULL,
  `proposal_id` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hire_table`
--

INSERT INTO `hire_table` (`hire_id`, `job_id`, `proposal_id`) VALUES
(1, 2, 1),
(2, 1, 2),
(3, 6, 3),
(4, 7, 4),
(5, 5, 5),
(6, 8, 6),
(7, 4, 7),
(8, 31, 8),
(10, 32, 10);

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

CREATE TABLE `job_status` (
  `id` int(100) NOT NULL,
  `job_id` int(11) NOT NULL,
  `is_canceled` int(1) NOT NULL DEFAULT '0',
  `in_progress` int(1) NOT NULL DEFAULT '0',
  `is_started` int(1) NOT NULL DEFAULT '0',
  `user_complete` int(1) NOT NULL DEFAULT '0',
  `worker_complete` int(1) NOT NULL DEFAULT '0',
  `is_done` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `job_status`
--

INSERT INTO `job_status` (`id`, `job_id`, `is_canceled`, `in_progress`, `is_started`, `user_complete`, `worker_complete`, `is_done`) VALUES
(1, 1, 0, 1, 1, 1, 1, 1),
(2, 2, 0, 1, 1, 1, 1, 1),
(3, 3, 1, 0, 0, 0, 0, 0),
(4, 4, 0, 1, 1, 1, 1, 1),
(5, 5, 0, 1, 1, 1, 1, 1),
(6, 6, 0, 1, 1, 1, 1, 1),
(7, 7, 0, 1, 1, 1, 1, 1),
(8, 8, 0, 1, 1, 1, 1, 1),
(9, 9, 1, 0, 0, 0, 0, 0),
(10, 10, 1, 0, 0, 0, 0, 0),
(11, 11, 1, 0, 0, 0, 0, 0),
(12, 12, 1, 0, 0, 0, 0, 0),
(13, 13, 1, 0, 0, 0, 0, 0),
(14, 14, 1, 0, 0, 0, 0, 0),
(15, 15, 1, 0, 0, 0, 0, 0),
(16, 16, 1, 0, 0, 0, 0, 0),
(17, 17, 1, 0, 0, 0, 0, 0),
(18, 18, 1, 0, 0, 0, 0, 0),
(19, 19, 1, 0, 0, 0, 0, 0),
(20, 20, 1, 0, 0, 0, 0, 0),
(21, 21, 1, 0, 0, 0, 0, 0),
(22, 22, 1, 0, 0, 0, 0, 0),
(23, 23, 1, 0, 0, 0, 0, 0),
(24, 24, 1, 0, 0, 0, 0, 0),
(25, 25, 1, 0, 0, 0, 0, 0),
(26, 26, 1, 0, 0, 0, 0, 0),
(27, 27, 1, 0, 0, 0, 0, 0),
(28, 28, 1, 0, 0, 0, 0, 0),
(29, 29, 1, 0, 0, 0, 0, 0),
(30, 30, 1, 0, 0, 0, 0, 0),
(31, 31, 0, 1, 1, 1, 1, 1),
(32, 32, 0, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_table`
--

CREATE TABLE `job_table` (
  `job_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `service_id` int(15) DEFAULT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `job_address` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `job_area` int(15) NOT NULL,
  `job_time` varchar(255) DEFAULT NULL,
  `user_id` int(15) DEFAULT NULL,
  `post_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `job_image` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_table`
--

INSERT INTO `job_table` (`job_id`, `category_id`, `sub_category_id`, `service_id`, `job_title`, `job_description`, `job_address`, `job_area`, `job_time`, `user_id`, `post_time`, `job_image`) VALUES
(1, 9, 63, 0, 'Need a normal Car', 'I will go to Oxygen from Cheragi Pahar', 'Momin Road', 2, '02-September-2019 08:00:20', 1, '2019-08-31 22:14:56', ''),
(2, 9, 64, 0, 'Need a SUV', 'Ami Anowara jabo.', 'Anderkilla', 2, '03-September-2019 11:30:54', 1, '2019-08-31 22:36:21', ''),
(3, 11, 72, 428, 'Need an electrician', 'Amr Fan ghure na.', 'Chawkbazar', 3, '02-September-2019 04:30:19', 1, '2019-08-31 22:40:36', ''),
(4, 9, 63, 0, 'owviowiov', 'wevev', 'wevwf', 2, '31-August-2019 11:35:19', 1, '2019-08-31 23:35:23', ''),
(5, 9, 63, 0, 'owviowiov', 'wevev', 'wevwf', 2, '31-August-2019 11:35:19', 1, '2019-08-31 23:36:59', ''),
(6, 9, 63, 0, 'OKK', 'www', 'qww', 4, '31-August-2019 11:38:11', 1, '2019-08-31 23:38:14', ''),
(7, 9, 63, 0, 'drive', 'qwd', '21e1', 1, '02-September-2019 11:34:52', 1, '2019-09-02 23:34:54', ''),
(8, 3, 22, 300, 'Mobile', 'wefwe', 'OKK', 1, '07-September-2019 03:22:49', 1, '2019-09-07 15:22:51', ''),
(9, 3, 24, 304, 'kolla', 'wefwefwe', 'wwefwe', 7, '07-September-2019 05:55:12', 1, '2019-09-07 17:55:13', ''),
(10, 9, 64, 0, 'Car', 'okk\r\n', 'okk', 3, '08-September-2019 10:03:26', 1, '2019-09-08 22:03:35', ''),
(11, 9, 64, 0, 'ijioj', 'huhuh\r\n', 'joooi', 5, '08-September-2019 10:05:24', 1, '2019-09-08 22:05:28', ''),
(12, 9, 63, 0, 'uhuhi', 'oohio', 'ooioji', 9, '08-September-2019 10:06:10', 1, '2019-09-08 22:06:13', ''),
(13, 9, 64, 0, 'uuhuhio', 'iohup', 'jbiuho', 9, '08-September-2019 10:12:24', 1, '2019-09-08 22:12:27', ''),
(14, 9, 63, 0, 'oiouibyyugi', 'kiibui', 'iuuhuih', 9, '08-September-2019 10:13:35', 1, '2019-09-08 22:13:38', ''),
(15, 9, 64, 0, 'iohh', '\r\noio', 'jouon', 3, '08-September-2019 11:05:03', 1, '2019-09-08 23:05:05', ''),
(16, 8, 56, 0, 'hu', 'uih', 'iiuh89h', 8, '08-September-2019 11:13:04', 1, '2019-09-08 23:13:07', ''),
(17, 9, 64, 0, 'iohih', 'uiuhoi', 'uhuij', 9, '08-September-2019 11:15:01', 1, '2019-09-08 23:15:03', ''),
(18, 9, 64, 0, 'iohih', 'uiuhoi', 'uhuij', 9, '08-September-2019 11:15:01', 1, '2019-09-08 23:15:44', ''),
(19, 9, 64, 0, 'iohih', 'uiuhoi', 'uhuij', 9, '08-September-2019 11:15:01', 1, '2019-09-08 23:18:15', ''),
(20, 9, 64, 0, 'iohih', 'uiuhoi', 'uhuij', 9, '08-September-2019 11:15:01', 1, '2019-09-08 23:19:09', ''),
(21, 9, 63, 0, 'powioj', 'biuo', 'iojioj', 8, '08-September-2019 11:20:26', 1, '2019-09-08 23:20:29', ''),
(22, 9, 63, 0, 'loij', 'oio', 'klnio', 2, '08-September-2019 11:21:05', 1, '2019-09-08 23:21:08', ''),
(23, 9, 64, 0, 'ijij', 'jkbui', 'lpopoj', 10, '08-September-2019 11:22:01', 1, '2019-09-08 23:22:03', ''),
(24, 9, 64, 0, 'jbiu', 'iui', 'pj[ol', 5, '08-September-2019 11:22:41', 1, '2019-09-08 23:22:43', ''),
(25, 9, 63, 0, 'sms 1', 'wehfuwehf', 'sofwe ', 4, '08-September-2019 11:25:31', 1, '2019-09-08 23:25:34', ''),
(26, 9, 64, 0, 'weuifhwehf', 'iossefi', 'ioww', 8, '08-September-2019 11:26:08', 1, '2019-09-08 23:26:11', ''),
(27, 9, 63, 0, 'pjwefje', 'iwejfij', 'uuh', 10, '08-September-2019 11:26:45', 1, '2019-09-08 23:26:47', ''),
(28, 4, 32, 333, 'acc', 'qcqw', 'qwc', 8, '09-September-2019 07:16:15', 1, '2019-09-09 19:16:16', ''),
(29, 2, 15, 0, 'adw', 'wd', 'awdaxd', 8, '10-September-2019 04:07:04', 1, '2019-09-10 16:07:07', ''),
(30, 3, 24, 304, 'whuih', 'ioijo', 'lno', 2, '10-September-2019 04:11:48', 1, '2019-09-10 16:11:51', ''),
(31, 3, 24, 304, 'we', 'wvwe', 'swvv', 7, '11-September-2019 12:24:32', 1, '2019-09-11 00:24:34', ''),
(32, 9, 63, 0, 'New Job Car', 'awdd', '22qfwfwdqw', 9, '18-September-2019 12:35:11', 1, '2019-09-18 12:35:18', '');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_package`
--

CREATE TABLE `promotion_package` (
  `id` int(15) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_price` int(15) NOT NULL,
  `package_validation_in_days` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promotion_package`
--

INSERT INTO `promotion_package` (`id`, `package_name`, `package_price`, `package_validation_in_days`) VALUES
(1, 'weekly', 70, 7),
(2, 'Monthly', 250, 30),
(3, 'Half Yearly', 1500, 180),
(4, 'Yearly', 3000, 365);

-- --------------------------------------------------------

--
-- Table structure for table `proposal_table`
--

CREATE TABLE `proposal_table` (
  `proposal_id` int(15) NOT NULL,
  `job_id` int(15) NOT NULL,
  `worker_id` int(15) NOT NULL,
  `proposal_price` int(15) NOT NULL,
  `Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_cancel` int(1) NOT NULL DEFAULT '0',
  `worker_cancel` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_table`
--

INSERT INTO `proposal_table` (`proposal_id`, `job_id`, `worker_id`, `proposal_price`, `Time`, `user_cancel`, `worker_cancel`) VALUES
(1, 2, 2, 5000, '2019-08-31 22:40:55', 0, 0),
(2, 1, 2, 100, '2019-08-31 23:29:45', 0, 0),
(3, 6, 2, 300, '2019-08-31 23:39:04', 0, 0),
(4, 7, 2, 100, '2019-09-03 00:11:50', 0, 0),
(5, 5, 2, 500, '2019-09-07 01:26:17', 0, 0),
(6, 8, 13, 500, '2019-09-07 15:24:01', 0, 0),
(7, 4, 2, 500, '2019-09-07 17:38:55', 0, 0),
(8, 31, 13, 500, '2019-09-11 00:25:28', 0, 0),
(9, 30, 2, 5000, '2019-09-18 12:36:31', 0, 0),
(10, 32, 2, 5600, '2019-09-18 12:38:07', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

CREATE TABLE `question_table` (
  `id` int(100) NOT NULL,
  `job_id` int(100) NOT NULL,
  `question` varchar(500) COLLATE utf8_bin NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `question_table`
--

INSERT INTO `question_table` (`id`, `job_id`, `question`, `is_active`) VALUES
(1, 1, 'Ques 1\r\n', 1),
(2, 4, 'Qustion 1 Ask', 1),
(3, 4, 'Qustion 1 Ask', 1),
(4, 4, 'Question two', 1),
(5, 3, 'OKK ', 1),
(6, 4, 'wdwq', 1),
(7, 4, 'wf24', 0),
(8, 4, 'r2r3r2', 1),
(9, 4, 'qwfwf', 1),
(10, 4, 'wfwefwef', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_table`
--

CREATE TABLE `service_table` (
  `service_id` int(15) NOT NULL,
  `sub_category_id` int(15) NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_table`
--

INSERT INTO `service_table` (`service_id`, `sub_category_id`, `service_name`) VALUES
(236, 1, 'AC Check Up'),
(237, 1, 'AC Basic Servicing'),
(238, 1, 'AC GAS Charge'),
(239, 1, 'AC Master Service'),
(240, 1, 'AC Water Drop Solution'),
(241, 1, 'AC Installation'),
(242, 1, 'AC Shifting'),
(243, 1, 'AC Compressor Fitting With Gas Charge'),
(244, 1, 'AC Dismantling'),
(245, 1, 'AC Capacitor Replacement'),
(246, 1, 'AC Circuit Repairing'),
(247, 2, '20 Gallon ( 90 liters )'),
(248, 2, '10 Gallon ( 45 liters )'),
(249, 2, '15 Gallon ( 65 liters )'),
(250, 3, 'LCD/LED TV Servicing'),
(251, 4, 'Refrigerator Servicing'),
(252, 4, 'Refrigerator Gas Charge'),
(253, 4, 'Refrigerator Check Up'),
(254, 5, 'Washing Machine Servicing'),
(255, 5, 'Washing Machine Check Up'),
(256, 6, 'Microwave Oven Servicing'),
(257, 6, 'Microwave Oven Check Up'),
(258, 7, 'Kitchen Hood Maintenance'),
(259, 8, 'IPS Service'),
(260, 8, 'IPS Servicing'),
(261, 9, 'Water Purifier Servicing'),
(262, 10, 'Gas Stove/Burner Installation'),
(263, 10, 'Gas Stove Gas Leak Repair'),
(264, 10, 'Gas Stove Component Change'),
(265, 10, 'Gas Stove/Burner Cleaning'),
(266, 10, 'New Gas Pipe Installation'),
(267, 11, 'Kitchen Hood Cleaning'),
(268, 12, 'Treadmill Installation'),
(269, 12, 'Treadmill Servicing'),
(270, 13, 'Geyser Check Up'),
(271, 13, 'Geyser Servicing'),
(272, 13, 'Geyser Installation'),
(273, 14, 'Generator 18 Point Health Checkup Service'),
(274, 14, 'Generator Radiator Servicing'),
(275, 15, 'Shifting For Bachelor'),
(276, 15, '2 Bedroom, Hall & Kitchen'),
(277, 15, '3 Bedroom, Hall & Kitchen'),
(278, 15, '4 Bedroom, Hall & Kitchen'),
(279, 16, '3-10 Seater Office Shifting'),
(280, 16, '10-25 Seater Office Shifting'),
(281, 16, '25-50 Seater Office Shifting'),
(282, 16, '50-100 Seater Office Shifting'),
(283, 17, 'Home Shifting Service'),
(284, 17, 'Office Shifting Service'),
(285, 18, 'Covered Van'),
(286, 18, 'Open Truck'),
(287, 19, 'Sofa Shifting'),
(288, 19, 'Table Shifting'),
(289, 19, 'Divan Shifting'),
(290, 19, 'Almari Shifting'),
(291, 19, 'Dressing Table Shifting'),
(292, 19, 'Mattress Shifting'),
(293, 19, 'Refrigerator Shifting'),
(294, 20, 'Movers for Shifting'),
(295, 20, 'Technician for Shifting'),
(296, 20, 'Carpenter for Shifting'),
(297, 20, 'Package Service'),
(298, 21, 'Consultant for Home Shifting'),
(299, 22, 'Desktop Software Installation / Up-gradation Service'),
(300, 22, 'Desktop Hardware Related Services'),
(301, 23, 'Laptop/Note Book Software Related Solutions'),
(302, 23, 'Laptop/Notebook Hardware Related Solutions'),
(303, 23, 'MAC-BOOK/Branded Laptop servicing'),
(304, 24, 'LED/LCD Monitor Services'),
(305, 25, 'CCTV Camera Installation'),
(306, 25, 'CCTV Camera Repair/Replacement'),
(307, 25, 'CCTV Camera Software Services'),
(308, 26, 'Access Control Installation'),
(309, 26, 'Access Control Repairing'),
(310, 26, 'Access Control Software Installation / Up-gradation'),
(311, 27, 'LAN Cabling Services'),
(312, 28, 'Xiaomi'),
(313, 28, 'Samsung'),
(314, 28, 'Huawei'),
(315, 28, 'Apple'),
(316, 28, 'Nokia'),
(317, 28, 'Oppo'),
(318, 29, 'Trademark (TM) Registration Assistance'),
(319, 29, 'Sole Proprietorship Registration'),
(320, 29, 'Income TAX'),
(321, 29, 'Registration as Limited Company'),
(322, 29, 'TIN Registration Assistance'),
(323, 29, 'VAT Registration Assistance'),
(324, 29, 'Trade License Making Assistance'),
(325, 29, 'Copyright Registration Assistance'),
(326, 29, 'Agreement/Deed Notary Service'),
(327, 29, 'Legal Consultancy'),
(328, 30, 'Uniform'),
(329, 30, 'T-Shirt 10 piece'),
(330, 30, 'T-Shirt 30 piece'),
(331, 31, 'Domain & Hosting'),
(332, 32, 'Standard Website Development'),
(333, 32, 'Premium Website Development'),
(334, 33, 'Logo Design'),
(335, 33, 'Web Banner'),
(336, 33, 'Communication Material Set'),
(337, 33, 'T - Shirt Design'),
(338, 33, 'Flyer Design'),
(339, 33, 'Brochure Design'),
(340, 33, 'Package & Label Design'),
(341, 34, 'ERP Solution'),
(342, 34, 'Application Development'),
(343, 34, 'Accounting Software'),
(344, 34, 'Banking Software'),
(345, 34, 'Mobile Application'),
(346, 34, 'ERP Solution'),
(347, 34, 'Application Development'),
(348, 34, 'Accounting Software'),
(349, 34, 'Banking Software'),
(350, 34, 'Mobile Application'),
(351, 35, 'Company Profile Video (CPD)'),
(352, 35, 'Online Video Commercial (OVC)'),
(353, 35, 'Promotional Video (Package)'),
(354, 36, 'Facebook Post Boost - 1 Week'),
(355, 37, 'Brochure'),
(356, 37, 'Shopping Bag'),
(357, 37, 'Business Card'),
(358, 37, 'ID Card'),
(359, 37, 'Money Receipt'),
(360, 37, 'X Banner - Standard Size'),
(361, 37, 'Digital Banner Print'),
(362, 37, 'Leaflet 4 Color Bothside Print'),
(363, 37, 'Leaflet 4 Color Oneside Print'),
(364, 37, 'Sticker'),
(365, 37, 'Order-Book'),
(366, 37, 'Catalog/ Menu Printing'),
(367, 46, 'Men\'s Wear'),
(368, 46, 'Household & Accessories'),
(369, 46, 'Kids Wear'),
(370, 46, 'Women\'s Wear'),
(371, 65, 'Car Exterior Wash + Interior Cleaning at Home'),
(372, 65, 'Car Wash At Workshop'),
(373, 65, 'Car Exterior Wash at Home'),
(374, 65, 'Car Interior Cleaning'),
(375, 65, 'Full Car Interior & Exterior Wash + Waxing and Polishing Package'),
(376, 65, 'Car Exterior Wash + Waxing and Polishing'),
(377, 66, 'Car Servicing'),
(378, 66, 'Air Filter Replacement'),
(379, 66, 'Oil Filter Replacement'),
(380, 66, 'Car AC Filter Servicing'),
(381, 67, 'Engine Oil Change'),
(382, 67, 'Spark Plugs Cleaning/Change'),
(383, 67, 'Wheel Rotation (Per Wheel)'),
(384, 67, 'Tyre Leak Repair'),
(385, 67, 'Fuel Filter Replacement'),
(386, 67, 'Brake Pads Servicing'),
(387, 67, 'Brake Fluids Replacement'),
(388, 67, 'Gear Oil Flash'),
(389, 67, 'Wheel Alignment and Balancing'),
(390, 67, 'Engine Replacement'),
(391, 67, 'Gear Box Replacement'),
(392, 67, 'Torque Converter'),
(393, 67, 'Car Radiator Servicing'),
(394, 67, 'Car AC Servicing'),
(395, 68, 'Battery Replacement'),
(396, 68, 'Electrical System Servicing'),
(397, 68, 'Wiper Servicing'),
(398, 69, 'Metal Bumper Works'),
(399, 69, 'Looking Glass Servicing'),
(400, 69, 'Headlight Bobbing'),
(401, 69, 'Car Denting & Painting'),
(402, 70, 'Live Car Tracking with Voice Monitoring'),
(403, 70, 'Live Car Tracking with Remotely Engine On/Off'),
(404, 70, 'Live Car Tracking and Alerts'),
(405, 70, 'Live Car Tracking with Real Time Fuel Monitoring'),
(406, 70, 'Real Time Tracking with Video Monitoring (Indoor/Outdoor)'),
(407, 70, 'Ready to Go Tracker (Plug and Play, No Installation)'),
(408, 70, 'Motor Bike Live Tracking'),
(409, 70, 'GPS Tracker with Car Charger'),
(410, 71, 'Water Meter Servicing'),
(411, 71, 'Water Tap Servicing'),
(412, 71, 'Kitchen Sink Servicing'),
(413, 71, 'Wash Basin Servicing'),
(414, 71, 'Bathtub Servicing'),
(415, 71, 'Plumbing Check Up'),
(416, 72, 'Exhaust Fan Servicing'),
(417, 72, 'Tube Light/ Bulb Servicing'),
(418, 72, 'Doorbell Servicing'),
(419, 72, 'Main Circuit Breaker (MCB) Servicing'),
(420, 72, 'Switch Servicing'),
(421, 72, 'Water Motor/Pump Servicing'),
(422, 72, 'Cable Laying Service'),
(423, 72, 'Wall Television Mounting'),
(424, 72, 'Point to Point Wiring Service'),
(425, 72, 'Switch Board Servicing'),
(426, 72, 'Main Distribution Board Servicing'),
(427, 72, 'Power Distribution Board (PDB) Meter Servicing'),
(428, 72, 'Electrical Check Up'),
(429, 72, 'Electrical Socket Servicing'),
(430, 72, 'Electrical Cable Fitting'),
(431, 72, 'Wall Groove Cutting'),
(432, 72, 'SDB Board Servicing'),
(433, 72, 'Cutout/Fuse Servicing'),
(434, 73, 'Work Station Design'),
(435, 73, 'Tiles Work'),
(436, 73, 'Wall Construction'),
(437, 73, 'Cabinet Design'),
(438, 73, 'False Ceiling Design'),
(439, 74, 'Lock Repair & Installation Service'),
(440, 75, 'Sofa Cover repair'),
(441, 76, 'Free Consultancy for Interior Design'),
(442, 77, 'Plastic Paint reject'),
(443, 77, 'Wallpaper Pasting'),
(444, 77, 'Enamel Paint'),
(445, 77, 'Plastic paint'),
(446, 77, 'Texture/Design Paint'),
(447, 77, 'Distemper Paint'),
(448, 77, 'Damp Proof Paint'),
(449, 78, 'Lacquer Varnish'),
(450, 78, 'High Polish (Varnish)'),
(451, 78, 'Spray Paint for Wood Furniture'),
(452, 79, 'Plywood Furniture'),
(453, 79, 'Veneer Board Furniture'),
(454, 79, 'Furniture & Door Repair'),
(455, 79, 'New Furniture & Door'),
(456, 80, 'Solid Shutter'),
(457, 80, 'Grill Shutter'),
(458, 80, 'Collapsible Gate'),
(459, 80, 'Grill Works'),
(460, 80, 'Steel Furniture'),
(461, 81, 'Sliding Glass Door'),
(462, 81, 'Thai Glass Partition'),
(463, 81, 'Thai Furniture Services'),
(464, 81, 'Thai Glass Services'),
(465, 83, 'Premium Sedan'),
(466, 83, 'Premium SUV'),
(467, 84, 'Travel Agency support'),
(468, 85, 'Airport Pick or Drop - Within Dhaka'),
(469, 86, 'Tourist Bus Rental Service'),
(470, 88, 'Ambulance Service');

-- --------------------------------------------------------

--
-- Table structure for table `sms_package`
--

CREATE TABLE `sms_package` (
  `id` int(15) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `package_price` int(15) NOT NULL,
  `package_validation_in_month` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_package`
--

INSERT INTO `sms_package` (`id`, `package_name`, `package_price`, `package_validation_in_month`) VALUES
(2, 'Monthly', 100, 1),
(3, 'Half Yearly', 500, 6),
(4, 'Yearly', 900, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_table`
--

CREATE TABLE `sub_category_table` (
  `sub_category_id` int(15) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `category_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category_table`
--

INSERT INTO `sub_category_table` (`sub_category_id`, `sub_category_name`, `category_id`) VALUES
(1, 'AC Service & Repair', 1),
(2, 'Buy Geyser with Free Installation', 1),
(3, 'TV (LCD/LED) servicing', 1),
(4, 'Refrigerator Servicing', 1),
(5, 'Washing Machine Repair', 1),
(6, 'Microwave Oven Repair', 1),
(7, 'Kitchen Hood Services', 1),
(8, 'IPS Service', 1),
(9, 'Water Purifier Servicing', 1),
(10, 'Gas Stove/Burner Repair', 1),
(11, 'Kitchen Hood Cleaning', 1),
(12, 'Treadmill Repair & Installation', 1),
(13, 'Electric Geyser Services', 1),
(14, 'Generator Services', 1),
(15, 'Moving Homes', 2),
(16, 'Moving Offices', 2),
(17, 'Premium Shifting Service', 2),
(18, 'Transport For Shifting', 2),
(19, 'Furniture Shifting', 2),
(20, 'Packing Service', 2),
(21, 'Consultant For Shifting', 2),
(22, 'Desktop Services', 3),
(23, 'Laptop Servicing', 3),
(24, 'Display Services', 3),
(25, 'CCTV Camera Services & Repair', 3),
(26, 'Access Control Services', 3),
(27, 'Internet Networking Services', 3),
(28, 'Smartphone Repair', 3),
(29, 'Legal & General Consultancy', 4),
(30, 'Uniform and Dress', 4),
(31, 'Domain & Hosting', 4),
(32, 'Web Designer & Developer', 4),
(33, 'Graphics Designer', 4),
(34, 'Software Solution', 4),
(35, 'Video Making', 4),
(36, 'Facebook Marketing', 4),
(37, 'Press- Printing', 4),
(39, 'Best Deal for Beauty', 5),
(40, 'Groom Up Packages', 5),
(41, 'Body Therapy & Wellness', 5),
(42, 'Valentine\'s Packages', 5),
(43, 'Beauty Salon Services', 5),
(44, 'Makeup and Hairstyle', 5),
(45, 'Wedding and Mehendi', 5),
(46, 'General Laundry Services', 6),
(47, 'Daily Lunch Meal', 7),
(48, 'Frozen Foods', 7),
(49, 'Best Deal for Milk (Free Delivery)', 7),
(50, 'Dairy Milk and Ghee', 7),
(51, 'Catering', 7),
(52, 'Frozen Fish', 7),
(53, 'Honey', 7),
(54, 'Achar', 7),
(55, 'On Demand Cleaner', 8),
(56, 'Best Deal for Cleaning', 8),
(57, 'Professional Home Cleaning', 8),
(58, 'Pest Control Service', 8),
(59, 'Home Basic Cleaning', 8),
(60, 'Office/Industrial Cleaning', 8),
(61, 'Tank Cleaning Services', 8),
(62, 'Fridge Cleaning', 8),
(63, 'Inside City', 9),
(64, 'Outside City', 9),
(65, 'Best Deal for Car Wash & Polish', 10),
(66, 'Basic Car Servicing', 10),
(67, 'Car Mechanical Works', 10),
(68, 'Car Electrical Works', 10),
(69, 'Car Dent & Paint and Decoration Work', 10),
(70, 'Vehicle Tracking Service', 10),
(71, 'Plumbing & Sanitary Services', 14),
(72, 'Electrical Services', 11),
(73, 'Interior Design', 12),
(74, 'Key Making & Repair', 12),
(75, 'Furniture Cover Repair', 12),
(76, 'Interior Design Consultancy', 12),
(77, 'Wall Painting & wallpaper', 12),
(78, 'Furniture Paint', 12),
(79, 'Wooden Furniture & Door works', 12),
(80, 'Steel Works', 12),
(81, 'Glass & Thai Work', 12),
(83, 'Luxury Cars', 13),
(84, 'Travel Agency', 13),
(85, 'Airport Pick or Drop', 13),
(86, 'Tourist Bus', 13),
(88, 'Ambulance Service', 13);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `worker_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT '0',
  `transaction_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `transaction_type`, `worker_id`, `package_id`, `payment_method`, `is_approved`, `transaction_time`) VALUES
(13, 's_bdworkstation_5d849595df56c', 'SMS_CREDIT', 2, 4, 'ABBANKIB-AB Bank', 1, '2019-09-20 14:44:41'),
(14, 'p_bdworkstation_5d849694112f5', 'PROMOTION_CREDIT', 2, 1, 'BKASH-BKash', 1, '2019-09-20 14:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_table`
--

CREATE TABLE `user_notification_table` (
  `id` int(100) NOT NULL,
  `not_type` varchar(100) COLLATE utf8_bin NOT NULL,
  `for_user` int(100) NOT NULL,
  `job_id` int(100) NOT NULL,
  `not_read` int(1) NOT NULL DEFAULT '0',
  `not_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_notification_table`
--

INSERT INTO `user_notification_table` (`id`, `not_type`, `for_user`, `job_id`, `not_read`, `not_time`) VALUES
(1, 'proposal', 1, 2, 1, '2019-08-31 22:40:55'),
(2, 'proposal', 1, 1, 1, '2019-08-31 23:29:45'),
(3, 'proposal', 1, 6, 1, '2019-08-31 23:39:04'),
(4, 'proposal', 1, 7, 1, '2019-09-03 00:11:50'),
(5, 'proposal', 1, 5, 1, '2019-09-07 01:26:17'),
(6, 'askQuestion', 1, 4, 1, '2019-09-07 14:29:33'),
(7, 'askQuestion', 1, 4, 1, '2019-09-07 14:30:28'),
(8, 'askQuestion', 1, 3, 1, '2019-09-07 14:36:33'),
(9, 'proposal', 1, 8, 1, '2019-09-07 15:24:01'),
(10, 'proposal', 1, 4, 1, '2019-09-07 17:38:55'),
(11, 'askQuestion', 1, 4, 1, '2019-09-07 17:39:44'),
(12, 'askQuestion', 1, 4, 1, '2019-09-07 17:39:50'),
(13, 'askQuestion', 1, 4, 1, '2019-09-07 17:39:55'),
(14, 'askQuestion', 1, 4, 1, '2019-09-07 17:40:10'),
(15, 'askQuestion', 1, 4, 1, '2019-09-07 17:41:30'),
(16, 'proposal', 1, 31, 1, '2019-09-11 00:25:28'),
(17, 'proposal', 1, 30, 1, '2019-09-18 12:36:32'),
(18, 'proposal', 1, 32, 1, '2019-09-18 12:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_report_table`
--

CREATE TABLE `user_report_table` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `report_type` varchar(100) COLLATE utf8_bin NOT NULL,
  `report_description` varchar(300) COLLATE utf8_bin NOT NULL,
  `from_worker` int(100) NOT NULL,
  `action` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_review_table`
--

CREATE TABLE `user_review_table` (
  `user_review_id` int(15) NOT NULL,
  `job_id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `from_worker_review` int(15) NOT NULL,
  `review_description` varchar(200) DEFAULT NULL,
  `from_worker_id` int(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_review_table`
--

INSERT INTO `user_review_table` (`user_review_id`, `job_id`, `user_id`, `from_worker_review`, `review_description`, `from_worker_id`) VALUES
(1, 2, 1, 30, 'sdwe', 2),
(3, 1, 1, 50, 'wefwef', 2),
(4, 7, 1, 50, 'okk', 2),
(5, 6, 1, 40, 'I give you 4 star Rating', 2),
(6, 31, 1, 40, 'glade to work with you', 13),
(7, 8, 1, 40, '', 13),
(8, 32, 1, 50, 'Great to work with you', 2),
(9, 5, 1, 50, 'ddd', 2),
(10, 4, 1, 50, 'efweff', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `area` int(15) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `is_verified` int(1) DEFAULT '0',
  `is_activated` int(1) NOT NULL DEFAULT '0',
  `profile_live_date` datetime DEFAULT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `first_name`, `last_name`, `password`, `phone_number`, `address`, `area`, `image`, `is_verified`, `is_activated`, `profile_live_date`, `is_deleted`) VALUES
(1, 'M. Irfanul Kalam', 'Chowdhury', '$2y$10$LhoGx0d74UNqs53JwHma5.TkJBWL0Sz.Fp.cn81u/W.foBrqZhLde', '+8801718339135', '42/43 Equity Central, Momin Road, Chittagong', 2, '5d6a99e7a0cd32.28341297.jpeg', 1, 0, NULL, 0),
(2, 'Galib', 'Anan', '$2y$10$GGdFa2DrYDlSF7UWzIA5W.LiZPcI7PWC0k5Vf1dxxWIswP5aO9xk.', '+8801715086156', 'Wasa', 8, '5d7511c6815ef1.86352176.jpg', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_verification_file`
--

CREATE TABLE `user_verification_file` (
  `id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `verification_file_front` varchar(200) NOT NULL,
  `verification_file_back` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_verification_file`
--

INSERT INTO `user_verification_file` (`id`, `user_id`, `file_type`, `verification_file_front`, `verification_file_back`) VALUES
(1, 1, 'NID', '5d6d189f9382b0.90420067.png', '5d6d189f938352.83651604.png');

-- --------------------------------------------------------

--
-- Table structure for table `worker_notification_table`
--

CREATE TABLE `worker_notification_table` (
  `id` int(100) NOT NULL,
  `not_type` varchar(100) COLLATE utf8_bin NOT NULL,
  `for_worker` int(100) NOT NULL,
  `job_id` int(100) NOT NULL,
  `not_read` int(1) NOT NULL DEFAULT '0',
  `not_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `worker_notification_table`
--

INSERT INTO `worker_notification_table` (`id`, `not_type`, `for_worker`, `job_id`, `not_read`, `not_time`) VALUES
(1, 'hire', 2, 2, 1, '2019-08-31 22:43:36'),
(2, 'hire', 2, 1, 1, '2019-08-31 23:30:45'),
(3, 'job', 2, 5, 1, '2019-08-31 23:36:59'),
(4, 'job', 2, 6, 1, '2019-08-31 23:38:15'),
(5, 'hire', 2, 6, 1, '2019-08-31 23:59:22'),
(6, 'job', 2, 7, 1, '2019-09-02 23:34:54'),
(7, 'hire', 2, 7, 1, '2019-09-03 00:55:27'),
(8, 'hire', 2, 5, 1, '2019-09-07 01:26:31'),
(9, 'hire', 13, 8, 1, '2019-09-07 15:24:22'),
(10, 'hire', 2, 4, 1, '2019-09-07 17:39:15'),
(11, 'job', 13, 9, 0, '2019-09-07 17:55:13'),
(12, 'job', 2, 10, 1, '2019-09-08 22:03:36'),
(13, 'job', 2, 11, 1, '2019-09-08 22:05:29'),
(14, 'job', 2, 12, 1, '2019-09-08 22:06:13'),
(15, 'job', 2, 13, 1, '2019-09-08 22:12:28'),
(16, 'job', 2, 14, 1, '2019-09-08 22:13:38'),
(17, 'job', 2, 15, 1, '2019-09-08 23:05:06'),
(18, 'job', 2, 20, 1, '2019-09-08 23:19:09'),
(19, 'job', 2, 21, 1, '2019-09-08 23:20:29'),
(20, 'job', 2, 22, 1, '2019-09-08 23:21:08'),
(21, 'job', 2, 23, 1, '2019-09-08 23:22:03'),
(22, 'job', 2, 24, 1, '2019-09-08 23:22:43'),
(23, 'job', 2, 25, 1, '2019-09-08 23:25:35'),
(24, 'job', 2, 26, 1, '2019-09-08 23:26:12'),
(25, 'job', 2, 27, 1, '2019-09-08 23:26:47'),
(26, 'job', 13, 30, 0, '2019-09-10 16:11:51'),
(27, 'job', 13, 31, 1, '2019-09-11 00:24:34'),
(28, 'hire', 13, 31, 0, '2019-09-11 00:25:35'),
(29, 'job', 2, 32, 1, '2019-09-18 12:35:19'),
(30, 'hire', 2, 32, 1, '2019-09-18 12:48:29'),
(31, 'hireCancel', 2, 32, 1, '2019-09-18 12:56:17'),
(32, 'hire', 2, 32, 1, '2019-09-18 12:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `worker_promotion`
--

CREATE TABLE `worker_promotion` (
  `id` int(15) NOT NULL,
  `worker_id` int(15) NOT NULL,
  `package_id` int(15) NOT NULL,
  `buy_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_promotion`
--

INSERT INTO `worker_promotion` (`id`, `worker_id`, `package_id`, `buy_date`, `end_date`) VALUES
(3, 2, 1, '2019-09-20 14:48:55', '2019-09-27 14:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `worker_report_table`
--

CREATE TABLE `worker_report_table` (
  `id` int(100) NOT NULL,
  `worker_id` int(100) NOT NULL,
  `report_type` varchar(100) COLLATE utf8_bin NOT NULL,
  `report_description` varchar(300) COLLATE utf8_bin NOT NULL,
  `from_user` int(100) NOT NULL,
  `action` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `worker_report_table`
--

INSERT INTO `worker_report_table` (`id`, `worker_id`, `report_type`, `report_description`, `from_user`, `action`) VALUES
(1, 2, 'offensiveContent', 'oooo', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `worker_review_table`
--

CREATE TABLE `worker_review_table` (
  `worker_review_id` int(15) NOT NULL,
  `job_id` int(15) NOT NULL,
  `worker_id` int(15) NOT NULL,
  `from_user_review` int(15) NOT NULL,
  `review_description` varchar(200) DEFAULT NULL,
  `from_user_id` int(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_review_table`
--

INSERT INTO `worker_review_table` (`worker_review_id`, `job_id`, `worker_id`, `from_user_review`, `review_description`, `from_user_id`) VALUES
(1, 2, 2, 40, 'q1', 1),
(3, 1, 2, 50, 'q2', 1),
(4, 7, 2, 40, 'q3', 1),
(5, 6, 2, 20, 'I give 2 star okk???', 1),
(6, 31, 13, 30, 'Good job bro', 1),
(7, 8, 13, 50, 'dvw', 1),
(8, 32, 2, 40, 'Nice Work', 1),
(9, 5, 2, 40, 'q3', 1),
(10, 4, 2, 50, 'f223', 1);

-- --------------------------------------------------------

--
-- Table structure for table `worker_settings_change_time`
--

CREATE TABLE `worker_settings_change_time` (
  `id` int(15) NOT NULL,
  `worker_id` int(15) NOT NULL,
  `number_of_changes` int(15) DEFAULT '0',
  `last_changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_settings_change_time`
--

INSERT INTO `worker_settings_change_time` (`id`, `worker_id`, `number_of_changes`, `last_changed`) VALUES
(1, 2, 4, '2019-09-03 01:44:04'),
(2, 3, 0, '2019-09-07 14:46:45'),
(3, 4, 0, '2019-09-07 14:55:13'),
(4, 5, 0, '2019-09-07 14:57:36'),
(5, 6, 0, '2019-09-07 15:02:15'),
(6, 7, 0, '2019-09-07 15:08:25'),
(7, 8, 0, '2019-09-07 15:09:51'),
(8, 9, 0, '2019-09-07 15:12:52'),
(9, 10, 0, '2019-09-07 15:14:22'),
(10, 11, 0, '2019-09-07 15:16:24'),
(11, 12, 0, '2019-09-07 15:19:43'),
(12, 13, 0, '2019-09-07 15:21:22'),
(13, 14, 0, '2019-09-07 23:32:10'),
(14, 15, 0, '2019-09-10 15:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `worker_sms_credit`
--

CREATE TABLE `worker_sms_credit` (
  `id` int(15) NOT NULL,
  `worker_id` int(15) NOT NULL,
  `package_id` int(15) NOT NULL,
  `buy_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_sms_credit`
--

INSERT INTO `worker_sms_credit` (`id`, `worker_id`, `package_id`, `buy_date`, `end_date`) VALUES
(5, 2, 4, '2019-09-20 14:44:41', '2020-09-20 14:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `worker_table`
--

CREATE TABLE `worker_table` (
  `worker_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(14) NOT NULL,
  `address` varchar(255) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` varchar(200) NOT NULL,
  `is_promoted` int(1) NOT NULL DEFAULT '0',
  `is_verified` int(1) NOT NULL DEFAULT '0',
  `is_activated` int(1) NOT NULL DEFAULT '0',
  `profile_live_date` datetime DEFAULT NULL,
  `is_deleted` int(1) NOT NULL,
  `is_sms_on` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `worker_table`
--

INSERT INTO `worker_table` (`worker_id`, `first_name`, `last_name`, `phone_number`, `address`, `area`, `image`, `password`, `category_id`, `sub_category_id`, `is_promoted`, `is_verified`, `is_activated`, `profile_live_date`, `is_deleted`, `is_sms_on`) VALUES
(2, 'Irfan', 'Sifat', '+8801818451726', 'Momin Road', '2', '5d6a9f43e707b3.16818996.jpg', '$2y$10$yGBYRgPnrJWZpUS6Oi7yFuzdGMcoq1s.GuJUhT3ppoIDLor4OhkqC', 9, 'a:2:{i:0;s:2:\"64\";i:1;s:2:\"63\";}', 1, 1, 0, NULL, 0, 1),
(13, 'Yamin', 'Sobhan', '+8801906657376', 'Kamal Gate', '2', '5d7376921006e4.02602506.png', '$2y$10$F4tFZoP1gJZpomOJaWcs2epMNkdDTbE6EDG6XI6m7vTbQWv5rSF0.', 3, 'a:3:{i:0;s:2:\"22\";i:1;s:2:\"25\";i:2;s:2:\"27\";}', 0, 1, 0, NULL, 0, 0),
(14, 'Goru', 'FazLuL', '+8801767943101', 'Molla Bazar', '11', '5d73e99a813536.08239973.png', '$2y$10$PN7xyb5l2FR6dLL4pTJdTO1ZGIdi0n8JsMLGGQSFzKOKHdP.zb6ka', 8, 'a:3:{i:0;s:2:\"55\";i:1;s:2:\"57\";i:2;s:2:\"61\";}', 0, 0, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `worker_verification_file`
--

CREATE TABLE `worker_verification_file` (
  `id` int(100) NOT NULL,
  `worker_id` int(100) NOT NULL,
  `file_type` varchar(100) COLLATE utf8_bin NOT NULL,
  `verification_file_front` varchar(200) COLLATE utf8_bin NOT NULL,
  `verification_file_back` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `worker_verification_file`
--

INSERT INTO `worker_verification_file` (`id`, `worker_id`, `file_type`, `verification_file_front`, `verification_file_back`) VALUES
(2, 2, 'NID', '5d6d19d720c007.38453754.png', '5d6d19d720c075.70284345.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_table`
--
ALTER TABLE `answer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_table`
--
ALTER TABLE `area_table`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `hire_table`
--
ALTER TABLE `hire_table`
  ADD PRIMARY KEY (`hire_id`);

--
-- Indexes for table `job_status`
--
ALTER TABLE `job_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_table`
--
ALTER TABLE `job_table`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `promotion_package`
--
ALTER TABLE `promotion_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposal_table`
--
ALTER TABLE `proposal_table`
  ADD PRIMARY KEY (`proposal_id`);

--
-- Indexes for table `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_table`
--
ALTER TABLE `service_table`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `sms_package`
--
ALTER TABLE `sms_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category_table`
--
ALTER TABLE `sub_category_table`
  ADD PRIMARY KEY (`sub_category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification_table`
--
ALTER TABLE `user_notification_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_report_table`
--
ALTER TABLE `user_report_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_review_table`
--
ALTER TABLE `user_review_table`
  ADD PRIMARY KEY (`user_review_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_verification_file`
--
ALTER TABLE `user_verification_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_notification_table`
--
ALTER TABLE `worker_notification_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_promotion`
--
ALTER TABLE `worker_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_report_table`
--
ALTER TABLE `worker_report_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_review_table`
--
ALTER TABLE `worker_review_table`
  ADD PRIMARY KEY (`worker_review_id`);

--
-- Indexes for table `worker_settings_change_time`
--
ALTER TABLE `worker_settings_change_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_sms_credit`
--
ALTER TABLE `worker_sms_credit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_table`
--
ALTER TABLE `worker_table`
  ADD PRIMARY KEY (`worker_id`);

--
-- Indexes for table `worker_verification_file`
--
ALTER TABLE `worker_verification_file`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_table`
--
ALTER TABLE `answer_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `area_table`
--
ALTER TABLE `area_table`
  MODIFY `area_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hire_table`
--
ALTER TABLE `hire_table`
  MODIFY `hire_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_status`
--
ALTER TABLE `job_status`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `job_table`
--
ALTER TABLE `job_table`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `promotion_package`
--
ALTER TABLE `promotion_package`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proposal_table`
--
ALTER TABLE `proposal_table`
  MODIFY `proposal_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `question_table`
--
ALTER TABLE `question_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_table`
--
ALTER TABLE `service_table`
  MODIFY `service_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=471;

--
-- AUTO_INCREMENT for table `sms_package`
--
ALTER TABLE `sms_package`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_category_table`
--
ALTER TABLE `sub_category_table`
  MODIFY `sub_category_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_notification_table`
--
ALTER TABLE `user_notification_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_report_table`
--
ALTER TABLE `user_report_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_review_table`
--
ALTER TABLE `user_review_table`
  MODIFY `user_review_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_verification_file`
--
ALTER TABLE `user_verification_file`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `worker_notification_table`
--
ALTER TABLE `worker_notification_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `worker_promotion`
--
ALTER TABLE `worker_promotion`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `worker_report_table`
--
ALTER TABLE `worker_report_table`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `worker_review_table`
--
ALTER TABLE `worker_review_table`
  MODIFY `worker_review_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `worker_settings_change_time`
--
ALTER TABLE `worker_settings_change_time`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `worker_sms_credit`
--
ALTER TABLE `worker_sms_credit`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `worker_table`
--
ALTER TABLE `worker_table`
  MODIFY `worker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `worker_verification_file`
--
ALTER TABLE `worker_verification_file`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
