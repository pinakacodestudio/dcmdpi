-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2022 at 12:02 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `annealing`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` bigint(20) NOT NULL,
  `company` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `usertype` tinyint(1) NOT NULL DEFAULT 0,
  `deviceid` varchar(255) NOT NULL,
  `activedevice` smallint(6) NOT NULL DEFAULT 0,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company`, `fullname`, `mobile`, `username`, `password`, `status`, `usertype`, `deviceid`, `activedevice`, `datetime`) VALUES
(1, 'Unique Industries', 'Admin User', '9898989898', 'admin', 'sv29121992', 1, 1, '', 0, '2018-10-08 03:42:49'),
(2, 'Jasmin', 'Developer User', '9979936669', 'test@dcmindustries.co.in', '123456', 1, 2, '34nxcqjwyp6h81a2qblel5fkx', 0, '2018-11-03 06:12:31'),
(3, 'Dcm Industries', 'Staff', '9879879870', 'staff@dcmindustries.co.in', '123456', 1, 2, '91kq0lbzq4n4dq6u2isju31d', 0, '2018-11-03 06:25:04');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `product` varchar(255) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `order_date` date NOT NULL,
  `dispatch_date` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer`, `email`, `mobile`, `product`, `quantity`, `order_date`, `dispatch_date`, `status`, `datetime`) VALUES
(5, 'TIMKEN INDIA LTD (ABC BEARING DIV.)', 'hgfhgfhfhf@gfgfg', '10', '25', 25, '2017-02-25', '2017-02-25', '1', '2020-03-14 04:45:39'),
(6, 'La Gajjar Machine Pvt.Ltd.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-03-30 03:54:13'),
(7, 'DCM Bearing Pvt.Ltd.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-03-30 03:54:28'),
(8, 'Sterling Bearing (Sureshbhai)', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-03-30 03:54:56'),
(9, 'Umiyaji Industries', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-03-30 03:55:09'),
(10, 'Precision Bearing Pvt.Ltd.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-04-06 03:55:16'),
(11, 'Manson', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-04-27 04:42:07'),
(12, 'Synnova Gears Pvt.Ltd.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-11-26 04:25:15'),
(13, 'KHS INNOVATION & ENGINEERING LLP', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-08-14 04:07:58'),
(14, 'Bansi(Rajubhai)', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-07-09 06:18:07'),
(15, 'ITAF', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-07-03 12:14:56'),
(16, 'JVR BEARING.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-08-10 07:48:12'),
(17, 'DCM INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-12-25 04:09:32'),
(18, 'GAGL', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-09-14 08:27:46'),
(19, 'JAPS', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-09-28 06:38:01'),
(20, 'URB Bearing', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2017-11-02 12:58:46'),
(21, 'SHARP INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-06-18 03:47:43'),
(22, 'POWER DRIVE', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-03-26 06:28:40'),
(23, 'KANSARA', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-07-26 08:07:46'),
(24, 'FKL', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-08-14 08:08:42'),
(25, 'SKILL INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-10-30 05:58:20'),
(26, 'SYNCHROTECH', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2018-12-31 04:28:29'),
(27, 'DELUX BEARING', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2019-01-29 08:50:09'),
(28, 'BON INTERNATIONAL', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2019-06-17 09:14:45'),
(29, 'TEXSPIN BEARING LTD', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2019-06-22 04:53:08'),
(30, 'YOGI HI TECH', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-11-13 04:15:05'),
(31, 'VAIDEHI RING PVT.LTD.', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-06-29 04:25:12'),
(32, 'ISOTECH INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-07-05 07:58:25'),
(33, 'SUPRA RUBBER INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-09-26 10:08:46'),
(34, 'MACHINE FAULT OR OTHER PROBLEM', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-09-26 10:18:58'),
(35, 'MARC', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-09-30 04:50:04'),
(36, 'MAN INDUSTRIES', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2020-10-07 11:04:40'),
(37, 'MACSON', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-02-04 10:59:02'),
(38, 'SONY CONSULTANT', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-02-26 05:35:59'),
(39, 'EXCEL', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-11-15 03:40:12'),
(40, 'PAPPUBHAI', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-11-15 12:27:34'),
(41, 'CRV', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-11-29 04:38:05'),
(42, 'BMI', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-12-05 04:06:59'),
(43, 'DEV', '', '', '', 0, '0000-00-00', '0000-00-00', '1', '2021-12-05 04:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_customer`
--

CREATE TABLE `dpi_customer` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(20) DEFAULT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `customer_email` varchar(30) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `contract_rate` float NOT NULL DEFAULT 0,
  `gstno` varchar(30) DEFAULT NULL,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_customer`
--

INSERT INTO `dpi_customer` (`id`, `customer_name`, `company_name`, `customer_mobile`, `customer_email`, `customer_address`, `contract_rate`, `gstno`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'KARTIK BHAI', 'EMPIRE RING FORGE', '7698500178', 'EMPIRERINGFORGE@GMAIL.COM', 'GUNDASARA', 4, '', 0, '2022-10-22 18:23:57', '2022-10-18 14:31:01'),
(2, 'VIVEKBHAI', 'DCM INDUSTRIES', '9427223892', 'DCM.PRECISION@GMAIL.COM', 'VERAVAL(S)', 4, '', 0, '2022-10-21 19:31:44', '2022-10-21 14:01:44'),
(3, 'VICKYBHAI', 'ARB BEARING LTD.(PLANT-1)', '9313292847', 'VICKY@ARB-BEARING.COM', 'HARYANA', 4.25, '', 0, '2022-10-21 19:34:37', '2022-10-21 14:04:37'),
(4, 'VICKYBHAI', 'ARB BEARING LTD.(PLANT-2)', '9313292847', 'VIKAS@ARB-BEARING.COM', 'HARYANA', 4.25, '', 0, '2022-10-21 19:35:39', '2022-10-21 14:05:39'),
(5, 'DIMPLEBHAI', 'DCM BEARING PVT LTD.', '9898597196', 'DCMBEARING@GMAIL.COM', 'VERAVAL(S)', 4, '', 0, '2022-10-21 19:37:27', '2022-10-21 14:07:27'),
(6, 'ASHVINBHAI', 'SHREE AMBICA FORGE', '9227777110', 'SHREEAMBICAFORGE@GMAIL.COM', 'VERAVAL(S)', 4, '', 0, '2022-10-21 19:41:26', '2022-10-21 14:11:26'),
(7, 'YASHWANTBHAI', 'DUHEE ALLOYS STEEL PROCESSOR', '9537888977', 'PPC.DUHEE@GMAIL.COM', 'METODA', 4.25, '', 0, '2022-10-21 19:43:26', '2022-10-21 14:13:26'),
(8, 'BANTIBHAI', 'COMET FORGE', '8799450047', 'COMETFORGE@GMAIL.COM', 'VERAVAL(S)', 4.25, '', 0, '2022-10-21 19:46:15', '2022-10-21 14:16:15'),
(9, 'BALABHAI', 'R.K.FORGE', '9898597196', 'NIKUNJPATEL9919@GMAIL.COM', 'SHAPAR(V)', 4.25, '', 0, '2022-10-22 18:36:03', '2022-10-22 12:58:57'),
(10, 'NIKUNJ', 'SKILL INDUSTRIES', '9227777110', '000@GMAIL.COM', 'VERAVAL(S)', 4, '', 0, '2022-10-22 18:37:49', '2022-10-22 13:07:49'),
(11, 'BALABHAI', 'ROYAL STEEL FORGE', '9898415195', '00@GMAIL.COM', 'SHAPAR(V)', 4.25, '', 0, '2022-10-22 18:47:48', '2022-10-22 13:17:48'),
(12, 'JAYESHBHAI', 'PRINCE FORGE', '9313292847', '0000@GMAIL.COM', 'VERAVAL(S)', 4.25, '', 0, '2022-10-23 14:21:57', '2022-10-22 14:25:13'),
(13, 'VIVEKBHAI', 'DCM FORGE', '9427223892', '00000@GMAIL.COM', 'VERAVAL(S)', 4, '', 0, '2022-10-22 20:03:11', '2022-10-22 14:33:11'),
(14, 'VICKYBHAI', 'MITUL ENGINEERS', '9313292847', '0@GMAIL.COM', 'RAJKOT', 4.25, '', 0, '2022-10-23 15:02:21', '2022-10-23 09:32:21'),
(15, 'VICKYBHAI', 'PATEL INDUSTRIES', '9313292847', '00.00@GMAIL.COM', 'RAJKOT', 4.25, '', 0, '2022-10-23 15:03:49', '2022-10-23 09:33:49'),
(16, 'VICKYBHAI', 'HARI KRUSHNA INDUSTRIES', '9313292847', '0000000@GMAIL.COM', 'RAJKOT', 4.25, '', 0, '2022-10-23 15:04:50', '2022-10-23 09:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_dispatch`
--

CREATE TABLE `dpi_dispatch` (
  `id` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `dispatch_date` varchar(30) DEFAULT NULL,
  `chalan_no` varchar(30) DEFAULT NULL,
  `batch_qty` int(11) NOT NULL,
  `weight_piece` decimal(10,3) DEFAULT 0.000,
  `total_weight` varchar(30) DEFAULT NULL,
  `dispatch_party` varchar(50) DEFAULT NULL,
  `rate_qty` float NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vehicleid` int(11) NOT NULL DEFAULT 0,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_dispatch`
--

INSERT INTO `dpi_dispatch` (`id`, `orderid`, `dispatch_date`, `chalan_no`, `batch_qty`, `weight_piece`, `total_weight`, `dispatch_party`, `rate_qty`, `total_amount`, `vehicleid`, `isdelete`, `updated_on`, `created_on`) VALUES
(2, 1, '2022-10-18', '1', 998, '1.235', '1232.530', '1', 4, '4930.12', 1, 0, '2022-10-23 10:07:44', '2022-10-22 13:58:20');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_furnace`
--

CREATE TABLE `dpi_furnace` (
  `id` int(11) NOT NULL,
  `bellid` varchar(30) DEFAULT NULL,
  `bell_description` text DEFAULT NULL,
  `bell_capacity` varchar(30) DEFAULT NULL,
  `processid` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_furnace`
--

INSERT INTO `dpi_furnace` (`id`, `bellid`, `bell_description`, `bell_capacity`, `processid`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'Bell 1', '', '4000', 4, 1, 0, '2018-11-15 16:18:53', '2018-10-21 10:03:46'),
(2, 'Bell 2', '', '4000', 2, 1, 0, '2018-10-21 15:33:56', '2018-10-21 10:03:56'),
(3, 'Bell 3', '', '4000', 0, 0, 0, '2019-01-24 15:04:24', '2018-10-21 10:04:08'),
(4, 'Bell 4', '', '4000', 0, 0, 0, '2018-10-21 15:34:36', '2018-10-21 10:04:36'),
(5, 'Bell 5', '', '4000', 7, 1, 0, '2018-10-21 15:34:50', '2018-10-21 10:04:50'),
(6, 'Bell 6', '', '4000', 3, 1, 0, '2018-10-21 15:35:01', '2018-10-21 10:05:01'),
(7, 'Bell 7', '', '4000', 0, 0, 0, '2018-10-21 15:35:17', '2018-10-21 10:05:17'),
(8, 'Bell 8', '', '4000', 2, 1, 0, '2018-10-21 15:35:31', '2018-10-21 10:05:31'),
(9, 'Bell 9', '', '7000', 0, 0, 0, '2018-10-21 15:35:49', '2018-10-21 10:05:49'),
(10, 'Bell 10', '', '7000', 0, 0, 0, '2018-10-21 15:36:04', '2018-10-21 10:06:04'),
(11, 'Bell 11', '', '7000', 0, 0, 0, '2019-01-20 15:07:37', '2018-10-21 10:06:19'),
(12, 'EXTRA', '', '150000', 0, 0, 0, '2018-10-22 11:04:44', '2018-10-22 05:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_invoice`
--

CREATE TABLE `dpi_invoice` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `customerid` int(11) NOT NULL DEFAULT 0,
  `invoice_date` varchar(30) DEFAULT NULL,
  `received_date` varchar(30) DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `cash_debit` varchar(15) DEFAULT NULL,
  `tax_invoice` varchar(15) DEFAULT NULL,
  `supply_of` varchar(30) DEFAULT NULL,
  `dispatch_through` varchar(50) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `case_bag` varchar(15) DEFAULT NULL,
  `sgst` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sgst_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cgst` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cgst_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `igst` decimal(10,2) NOT NULL DEFAULT 0.00,
  `igst_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_qty` int(11) NOT NULL DEFAULT 0,
  `total_weight` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `original_copy` tinyint(1) NOT NULL DEFAULT 0,
  `duplicate_copy` tinyint(1) NOT NULL DEFAULT 0,
  `extra_copy` tinyint(1) NOT NULL DEFAULT 0,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `dpi_messagebox`
--

CREATE TABLE `dpi_messagebox` (
  `id` int(11) NOT NULL,
  `disp_id` int(11) NOT NULL DEFAULT 0,
  `mobileno` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dpi_order`
--

CREATE TABLE `dpi_order` (
  `id` int(11) NOT NULL,
  `orderno` varchar(15) DEFAULT NULL,
  `orderid` int(11) NOT NULL DEFAULT 0,
  `received_date` varchar(30) DEFAULT NULL,
  `main_chalan_no` varchar(30) DEFAULT NULL,
  `chalan_date` varchar(30) DEFAULT NULL,
  `chalan_no` varchar(30) DEFAULT NULL,
  `from_forgine_party` varchar(50) DEFAULT NULL,
  `main_party` varchar(50) DEFAULT NULL,
  `item_no` varchar(30) DEFAULT NULL,
  `part_type` varchar(50) DEFAULT NULL,
  `po_no` bigint(20) DEFAULT 0,
  `batch_qty` varchar(30) DEFAULT NULL,
  `weight_piece` varchar(30) DEFAULT NULL,
  `total_weight` varchar(30) DEFAULT NULL,
  `qty_used` int(11) NOT NULL DEFAULT 0,
  `qty_ready` int(11) NOT NULL DEFAULT 0,
  `qty_dispatch` int(11) NOT NULL DEFAULT 0,
  `status` int(1) DEFAULT NULL,
  `billstatus` tinyint(1) NOT NULL DEFAULT 0,
  `invoiceid` int(11) NOT NULL DEFAULT 0,
  `jobwork_chalan` varchar(30) DEFAULT NULL,
  `jobwork_date` varchar(30) DEFAULT NULL,
  `jobwork_qty` int(11) NOT NULL DEFAULT 0,
  `jobwork_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text NOT NULL,
  `isdelete` int(1) DEFAULT 0,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_order`
--

INSERT INTO `dpi_order` (`id`, `orderno`, `orderid`, `received_date`, `main_chalan_no`, `chalan_date`, `chalan_no`, `from_forgine_party`, `main_party`, `item_no`, `part_type`, `po_no`, `batch_qty`, `weight_piece`, `total_weight`, `qty_used`, `qty_ready`, `qty_dispatch`, `status`, `billstatus`, `invoiceid`, `jobwork_chalan`, `jobwork_date`, `jobwork_qty`, `jobwork_amount`, `note`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'ORD-001', 1, '2022-10-13', '0', '2022-10-13', 'A-181', '1', '1', 'V59022 A+C', 'OR', 0, '998', '1.235', '1232.530', 0, 0, 998, 1, 0, 0, '12', '2022-10-23', 1498, '7400.12', '', 0, '2022-10-23 10:12:48', '2022-10-18 14:47:21'),
(2, 'ORD-002', 2, '2022-10-22', '00', '2022-10-22', 'A-194', '1', '1', '64450/64700', 'OR', 0, '253', '1.7470355731225', '442.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:23:23', '2022-10-22 12:53:23'),
(3, 'ORD-003', 3, '2022-10-22', 'EFRS/74', '2022-09-05', '38', '9', '5', 'CRPIR5188004', 'IR', 0, '2001', '0.640', '1280.640', 881, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:34:21', '2022-10-22 13:04:21'),
(4, 'ORD-004', 4, '2022-10-22', '00', '2022-10-22', '542', '6', '10', '22218', 'IR', 0, '1510', '1.360', '2053.600', 1510, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:40:37', '2022-10-22 13:10:37'),
(5, 'ORD-005', 5, '2022-10-22', '00', '2022-10-22', 'A-193', '1', '1', '37425', 'OR', 0, '1005', '0.8149253731343', '819.000', 1005, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:43:14', '2022-10-22 13:13:14'),
(6, 'ORD-006', 6, '2022-10-22', '00', '2022-10-22', '27', '11', '11', '32308', 'OR', 0, '1589', '0.580', '921.620', 1589, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:48:52', '2022-10-22 13:18:52'),
(7, 'ORD-007', 7, '2022-10-22', '0', '2022-10-22', 'A-195', '1', '1', '9278/9220', 'IR', 0, '261', '2.2605363984674', '590.000', 261, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:53:35', '2022-10-22 13:23:35'),
(8, 'ORD-008', 8, '2022-10-22', '00', '2022-10-22', 'A-195', '1', '1', '9278/9220', 'OR', 0, '253', '2.3202', '587.011', 253, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:55:14', '2022-10-22 13:25:14'),
(9, 'ORD-009', 9, '2022-10-22', '00', '2022-10-22', 'A-196', '1', '1', '64450/64700', 'IR', 0, '254', '2.0984251968503', '533.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 18:57:37', '2022-10-22 13:27:37'),
(10, 'ORD-010', 10, '2022-10-22', '00', '2022-10-22', '00', '6', '6', '22218', 'IR', 0, '500', '1.360', '680.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 1, '2022-10-23 14:18:06', '2022-10-22 14:20:07'),
(11, 'ORD-011', 11, '2022-10-22', '00', '2022-10-22', '0', '6', '6', '22218', 'IR', 0, '500', '1.360', '680.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 1, '2022-10-23 14:18:00', '2022-10-22 14:21:59'),
(12, 'ORD-012', 12, '2022-10-22', 'P2/445', '2022-10-01', '118', '12', '4', '482/72', 'IR', 0, '1578', '0.670', '1057.260', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-23 14:20:52', '2022-10-22 14:30:36'),
(13, 'ORD-013', 13, '2022-10-22', 'P2/445', '2022-10-01', '117', '12', '4', '462/53', 'IR', 0, '1428', '0.590', '842.520', 1428, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-23 14:20:20', '2022-10-22 14:31:48'),
(14, 'ORD-014', 14, '2022-10-22', '00', '2022-10-22', '00', '13', '2', '32217', 'OR', 0, '3200', '1.250', '4000.000', 1890, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-22 20:03:49', '2022-10-22 14:33:49'),
(15, 'ORD-015', 15, '2022-10-23', '00', '2022-10-23', 'A-197', '1', '1', '37425', 'IR', 0, '1000', '.897', '897.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-23 14:11:38', '2022-10-23 08:41:38'),
(16, 'ORD-016', 16, '2022-10-23', '00', '2022-10-23', 'A-198', '1', '1', '33113', 'IR', 0, '502', '0.675', '338.850', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-23 14:13:22', '2022-10-23 08:43:22'),
(17, 'ORD-017', 17, '2022-10-23', 'P2/445', '2022-10-01', '116', '12', '4', '33013', 'IR', 0, '1630', '0.5331288343558', '869.000', 0, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', 'PLANT 2', 0, '2022-10-23 15:06:36', '2022-10-23 09:36:36'),
(18, 'ORD-018', 18, '2022-10-23', '00', '2022-10-23', '00', '13', '2', '32217', 'OR', 0, '2800', '1.250', '3500.000', 1890, 0, 0, NULL, 0, 0, NULL, NULL, 0, '0.00', '', 0, '2022-10-29 09:53:51', '2022-10-23 10:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_order_inward`
--

CREATE TABLE `dpi_order_inward` (
  `id` int(11) NOT NULL,
  `orderid` int(11) NOT NULL DEFAULT 0,
  `received_date` varchar(30) DEFAULT NULL,
  `chalan_no` varchar(30) DEFAULT NULL,
  `batch_qty` varchar(30) DEFAULT NULL,
  `total_weight` varchar(30) DEFAULT NULL,
  `isdelete` int(1) DEFAULT 0,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `dpi_platform`
--

CREATE TABLE `dpi_platform` (
  `id` int(11) NOT NULL,
  `platformid` varchar(30) DEFAULT NULL,
  `platform_description` text DEFAULT NULL,
  `platform_capacity` varchar(30) DEFAULT NULL,
  `processid` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_platform`
--

INSERT INTO `dpi_platform` (`id`, `platformid`, `platform_description`, `platform_capacity`, `processid`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'Platform 01', '', '4000', 2, 1, 0, '2018-10-21 15:30:31', '2018-10-21 10:00:31'),
(2, 'Platform 02', '', '4000', 0, 0, 0, '2018-10-21 15:30:41', '2018-10-21 10:00:41'),
(3, 'Platform 03', '', '4000', 0, 0, 0, '2018-10-21 15:30:52', '2018-10-21 10:00:52'),
(4, 'Platform 04', '', '4000', 3, 1, 0, '2018-10-21 15:31:03', '2018-10-21 10:01:03'),
(5, 'Platform 05', '', '4000', 2, 1, 0, '2018-10-21 15:31:13', '2018-10-21 10:01:13'),
(6, 'Platform 06', '', '4000', 4, 1, 0, '2018-10-21 15:32:01', '2018-10-21 10:02:01'),
(7, 'Platform 07', '', '4000', 0, 0, 0, '2018-10-21 15:32:11', '2018-10-21 10:02:11'),
(8, 'Platform 08', '', '4000', 7, 1, 0, '2018-10-21 15:32:25', '2018-10-21 10:02:25'),
(9, 'Platform 09', '', '7000', 0, 0, 0, '2018-10-21 15:32:58', '2018-10-21 10:02:34'),
(10, 'Platform 10', '', '7000', 0, 0, 0, '2018-10-21 15:33:09', '2018-10-21 10:03:09'),
(11, 'Platform 11', '', '7000', 0, 0, 0, '2018-10-21 15:33:18', '2018-10-21 10:03:18'),
(12, 'EXTRA', '', '150000', 0, 0, 0, '2018-10-22 11:04:09', '2018-10-22 05:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_platform_material`
--

CREATE TABLE `dpi_platform_material` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `weight_piece` varchar(30) DEFAULT NULL,
  `total_weight` varchar(30) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0 - Inprocess / 1 - Completed',
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_platform_material`
--

INSERT INTO `dpi_platform_material` (`id`, `pid`, `orderid`, `qty`, `weight_piece`, `total_weight`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 1, 1, 998, '1.235', '1232.530', 1, 0, '2022-10-18 20:20:31', '2022-10-18 14:55:26'),
(2, 2, 14, 1890, '1.250', '2362.500', 0, 0, '2022-10-29 09:42:14', '2022-10-29 04:12:14'),
(3, 2, 3, 296, '0.640', '189.440', 0, 0, '2022-10-29 09:42:14', '2022-10-29 04:12:15'),
(4, 3, 4, 1510, '1.360', '2053.600', 0, 0, '2022-10-29 09:44:56', '2022-10-29 04:14:57'),
(5, 3, 5, 1005, '0.8149253731343', '819.000', 0, 0, '2022-10-29 09:44:56', '2022-10-29 04:14:57'),
(6, 4, 6, 1589, '0.580', '921.620', 0, 0, '2022-10-29 09:50:56', '2022-10-29 04:20:56'),
(7, 4, 13, 1428, '0.590', '842.520', 0, 0, '2022-10-29 09:50:56', '2022-10-29 04:20:56'),
(8, 4, 7, 261, '2.2605363984674', '590.000', 0, 0, '2022-10-29 09:50:56', '2022-10-29 04:20:57'),
(9, 4, 8, 253, '2.3202', '587.011', 0, 0, '2022-10-29 09:50:56', '2022-10-29 04:20:57'),
(10, 5, 18, 1890, '1.250', '2362.500', 0, 1, '2022-10-29 09:53:13', '2022-10-29 04:23:13'),
(11, 5, 3, 585, '0.640', '374.400', 0, 1, '2022-10-29 09:53:13', '2022-10-29 04:23:13'),
(12, 6, 14, 1310, '1.250', '1637.500', 0, 1, '2022-10-29 09:54:07', '2022-10-29 04:24:07'),
(13, 7, 18, 1890, '1.250', '2362.500', 0, 0, '2022-10-29 09:54:45', '2022-10-29 04:24:45'),
(14, 7, 3, 585, '0.640', '374.400', 0, 0, '2022-10-29 09:54:45', '2022-10-29 04:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_power_panel`
--

CREATE TABLE `dpi_power_panel` (
  `id` int(11) NOT NULL,
  `panelid` varchar(30) DEFAULT NULL,
  `panel_description` text DEFAULT NULL,
  `processid` int(11) NOT NULL DEFAULT 0,
  `status` int(1) DEFAULT 0,
  `isdelete` int(1) NOT NULL DEFAULT 0,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_power_panel`
--

INSERT INTO `dpi_power_panel` (`id`, `panelid`, `panel_description`, `processid`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'Panel 1', '', 2, 1, 0, '2022-10-29 09:48:13', '2018-10-22 05:26:01'),
(2, 'Panel 2', '', 4, 1, 0, '2018-10-22 10:56:10', '2018-10-22 05:26:10'),
(3, 'Panel 3', '', 7, 1, 0, '2018-10-22 10:56:17', '2018-10-22 05:26:17'),
(4, 'Panel 4', '', 0, 0, 0, '2018-10-22 10:56:23', '2018-10-22 05:26:23'),
(5, 'EXTRA', '', 0, 0, 0, '2018-10-22 11:05:00', '2018-10-22 05:35:00'),
(6, 'Panel 5', '', 2, 1, 0, '2022-07-28 19:35:19', '2022-07-28 14:05:19'),
(7, 'PANEL  1', '', 3, 1, 0, '2022-10-29 09:48:59', '2022-10-29 04:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_process`
--

CREATE TABLE `dpi_process` (
  `id` int(11) NOT NULL,
  `platformid` int(11) NOT NULL DEFAULT 0,
  `start_preparing` varchar(30) DEFAULT NULL,
  `end_removing` varchar(30) DEFAULT NULL,
  `furnaceid` int(11) DEFAULT 0,
  `attach_furnace` varchar(30) DEFAULT NULL,
  `dettach_furnace` varchar(30) DEFAULT NULL,
  `panelid` int(11) NOT NULL DEFAULT 0,
  `attach_panel` varchar(30) DEFAULT NULL,
  `dettach_panel` varchar(30) DEFAULT NULL,
  `platform_capacity` int(11) NOT NULL DEFAULT 0,
  `remaining_capacity` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_process`
--

INSERT INTO `dpi_process` (`id`, `platformid`, `start_preparing`, `end_removing`, `furnaceid`, `attach_furnace`, `dettach_furnace`, `panelid`, `attach_panel`, `dettach_panel`, `platform_capacity`, `remaining_capacity`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 6, '14/10/2022 09:00 AM', '22/10/2022 07:00 PM', 6, '14/10/2022 11:00 AM', '18/10/2022 08:23 PM', 2, '14/10/2022 11:10 AM', '15/10/2022 7:10 AM', 4000, 2767, 5, 0, '2022-10-23 10:02:09', '2022-10-18 14:50:31'),
(2, 1, '29/10/2022 08:41 AM', '', 8, '29/10/2022 09:10 AM', '', 6, '29/10/2022 09:20 AM', '30/10/2022 5:20 AM', 4000, 1448, 3, 0, '2022-10-29 09:43:20', '2022-10-29 04:12:14'),
(3, 4, '29/10/2022 08:45 AM', '', 6, '29/10/2022 09:10 AM', '', 7, '29/10/2022 09:20 AM', '30/10/2022 5:20 AM', 4000, 1127, 3, 0, '2022-10-29 09:49:23', '2022-10-29 04:14:56'),
(4, 6, '29/10/2022 08:45 AM', '', 1, '29/10/2022 09:10 AM', '', 2, '29/10/2022 09:20 AM', '30/10/2022 5:20 AM', 4000, 1059, 3, 0, '2022-10-29 09:51:44', '2022-10-29 04:20:56'),
(5, 8, '29/10/2022 08:45 AM', '', 0, '', '', 0, '', '', 4000, 1263, 1, 1, '2022-10-29 09:53:13', '2022-10-29 04:22:39'),
(6, 8, '29/10/2022 08:45 AM', '', 0, '', '', 0, '', '', 4000, 2363, 1, 1, '2022-10-29 09:54:07', '2022-10-29 04:23:38'),
(7, 8, '29/10/2022 08:45 AM', '', 5, '29/10/2022 09:10 AM', '', 3, '29/10/2022 09:20 AM', '30/10/2022 5:20 AM', 4000, 1263, 3, 0, '2022-10-29 09:55:39', '2022-10-29 04:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_stock_log`
--

CREATE TABLE `dpi_stock_log` (
  `id` bigint(20) NOT NULL,
  `orderid` int(11) NOT NULL DEFAULT 0,
  `subid` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `ucol` varchar(1) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dpi_stock_log`
--

INSERT INTO `dpi_stock_log` (`id`, `orderid`, `subid`, `qty`, `status`, `ucol`, `created_on`) VALUES
(1, 1, 1, 998, 1, NULL, '2022-10-18 14:47:21'),
(2, 1, 1, 998, 1, NULL, '2022-10-18 14:50:32'),
(3, 1, 1, 998, 1, NULL, '2022-10-18 14:55:26'),
(5, 2, 2, 253, 1, NULL, '2022-10-22 12:53:23'),
(6, 3, 3, 2001, 1, NULL, '2022-10-22 13:04:21'),
(7, 4, 4, 1510, 1, NULL, '2022-10-22 13:10:37'),
(8, 5, 5, 1005, 1, NULL, '2022-10-22 13:13:14'),
(9, 6, 6, 1589, 1, NULL, '2022-10-22 13:18:52'),
(10, 7, 7, 261, 1, NULL, '2022-10-22 13:23:35'),
(11, 8, 8, 253, 1, NULL, '2022-10-22 13:25:14'),
(12, 9, 9, 254, 1, NULL, '2022-10-22 13:27:37'),
(13, 1, 2, 998, 4, NULL, '2022-10-22 13:58:21'),
(14, 10, 10, 500, 1, NULL, '2022-10-22 14:20:08'),
(15, 11, 11, 500, 1, NULL, '2022-10-22 14:21:59'),
(16, 12, 12, 1578, 1, NULL, '2022-10-22 14:30:36'),
(17, 13, 13, 1428, 1, NULL, '2022-10-22 14:31:48'),
(18, 14, 14, 3200, 1, NULL, '2022-10-22 14:33:49'),
(19, 1, 1, 998, 1, NULL, '2022-10-23 04:32:10'),
(20, 15, 15, 1000, 1, NULL, '2022-10-23 08:41:38'),
(21, 16, 16, 502, 1, NULL, '2022-10-23 08:43:22'),
(22, 17, 17, 1630, 1, NULL, '2022-10-23 09:36:36'),
(23, 18, 18, 2800, 1, NULL, '2022-10-23 10:41:51'),
(24, 14, 2, 1890, 2, NULL, '2022-10-29 04:12:14'),
(25, 3, 3, 296, 2, NULL, '2022-10-29 04:12:15'),
(26, 4, 4, 1510, 2, NULL, '2022-10-29 04:14:57'),
(27, 5, 5, 1005, 2, NULL, '2022-10-29 04:14:57'),
(28, 6, 6, 1589, 2, NULL, '2022-10-29 04:20:56'),
(29, 13, 7, 1428, 2, NULL, '2022-10-29 04:20:56'),
(30, 7, 8, 261, 2, NULL, '2022-10-29 04:20:57'),
(31, 8, 9, 253, 2, NULL, '2022-10-29 04:20:57'),
(35, 18, 13, 1890, 2, NULL, '2022-10-29 04:24:45'),
(36, 3, 14, 585, 2, NULL, '2022-10-29 04:24:45');

--
-- Triggers `dpi_stock_log`
--
DELIMITER $$
CREATE TRIGGER `StockInsert` AFTER INSERT ON `dpi_stock_log` FOR EACH ROW UPDATE dpi_order set qty_used=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =2),qty_ready=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =3),qty_dispatch=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =4) where id=new.orderid
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `StockUpdate` AFTER UPDATE ON `dpi_stock_log` FOR EACH ROW UPDATE dpi_order set qty_used=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =2),qty_ready=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =3),qty_dispatch=(SELECT sum(qty) from dpi_stock_log where orderid=new.orderid and status =4) where id=new.orderid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dpi_userinfo`
--

CREATE TABLE `dpi_userinfo` (
  `id` int(11) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_mob` varchar(20) DEFAULT NULL,
  `user_fname` varchar(30) DEFAULT NULL,
  `user_lname` varchar(30) DEFAULT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `company_panno` varchar(20) DEFAULT NULL,
  `company_gstno` varchar(30) DEFAULT NULL,
  `user_blocked` int(11) NOT NULL DEFAULT 0 COMMENT '1 - Unblock / 0 - Block',
  `user_last_login` varchar(255) DEFAULT NULL,
  `user_session` varchar(100) DEFAULT NULL,
  `user_type` int(11) NOT NULL DEFAULT 2 COMMENT '1 - Superadmin / 2 - Executive',
  `isdelete` int(1) NOT NULL DEFAULT 0,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_userinfo`
--

INSERT INTO `dpi_userinfo` (`id`, `user_email`, `user_password`, `user_image`, `user_mob`, `user_fname`, `user_lname`, `user_fullname`, `company_name`, `company_address`, `company_logo`, `company_panno`, `company_gstno`, `user_blocked`, `user_last_login`, `user_session`, `user_type`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'admin@gmail.com', 'admin@123', 'uploads/LOGO.jpg', '8585848484', 'DPI', 'Ind', 'DCM PRECISION IND', 'DCM PRECISION INDUSTRIES', 'SURVEY NO. 175, PLOT NO. 1/2, NEAR MARSHAL TECHNO CAST, SIDC ROAD, VERAVAL (SHAPAR) DIST : RAJKOT – 360024', 'uploads/LOGO1.jpg', 'AAJFD8896L', '24AAJFD8896L1ZN', 1, NULL, NULL, 1, 0, '2018-11-25 19:12:55', '2018-10-22 03:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `dpi_user_roles`
--

CREATE TABLE `dpi_user_roles` (
  `id` int(11) NOT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `cdtime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `dpi_vehicle`
--

CREATE TABLE `dpi_vehicle` (
  `id` int(11) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `isdelete` int(1) NOT NULL,
  `updated_on` varchar(30) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `dpi_vehicle`
--

INSERT INTO `dpi_vehicle` (`id`, `driver_name`, `vehicle_type`, `vehicle_no`, `status`, `isdelete`, `updated_on`, `created_on`) VALUES
(1, 'RAJUBHAI', 'RIXA', 'GJ03AZ6483', 0, 0, '2018-11-16 18:40:14', '2018-11-10 07:56:50'),
(2, 'ARVINDBHAI', 'BOLERO', 'GJ03BT9816', 0, 0, '2018-11-16 18:26:05', '2018-11-10 08:57:23'),
(3, 'RANCHHODBHAI', 'RIXA', 'GJ03X1709', 0, 0, '2018-11-15 11:17:39', '2018-11-15 05:47:39'),
(4, 'VALLABHBHAI', 'RIXA', 'GJ03V3673', 0, 0, '2018-11-15 11:18:32', '2018-11-15 05:48:32'),
(5, 'UNIQUE IND', 'SELF', 'LATHE DEPT.', 0, 0, '2018-11-16 18:44:31', '2018-11-15 06:12:10'),
(6, 'NAVINBHAI', 'BOLERO', 'GJ03BT4396', 0, 0, '2018-11-16 18:48:25', '2018-11-16 13:18:04'),
(7, 'JAYESHBHAI', 'BOLERO', 'GJ27V8046', 0, 0, '2018-11-16 18:48:16', '2018-11-16 13:18:16'),
(8, 'AJAYBHAI', 'RIXA', 'GJ03BV6532', 0, 0, '2018-11-19 11:31:25', '2018-11-19 06:01:25'),
(9, 'VINUBHAI', 'RIXA', 'GJ03Y6490', 0, 0, '2018-11-24 09:55:56', '2018-11-24 04:25:56'),
(10, 'NAGJIBHAI', 'BOL', 'GJ03AX7787', 0, 0, '2018-11-24 09:58:21', '2018-11-24 04:28:21'),
(11, 'HAMABHAI', 'BOLERO', 'GJ03AZ9457', 0, 0, '2018-11-24 19:21:17', '2018-11-24 13:51:17'),
(12, 'DHARMENDRA', 'TEMPO', 'GJ11TT5747', 0, 0, '2020-03-03 10:34:06', '2020-03-03 05:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `joblist`
--

CREATE TABLE `joblist` (
  `id` bigint(20) NOT NULL,
  `jobno` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `id` bigint(20) NOT NULL,
  `machine` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id` bigint(20) NOT NULL,
  `operator` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `joining` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_1`
--

CREATE TABLE `production_1` (
  `id` bigint(20) NOT NULL,
  `productiondate` date NOT NULL,
  `machine` bigint(20) NOT NULL,
  `customer` bigint(20) NOT NULL,
  `operator` bigint(20) NOT NULL,
  `shift` varchar(10) NOT NULL,
  `part_count_start` int(11) NOT NULL,
  `part_count_end` int(11) NOT NULL,
  `job_no` varchar(50) NOT NULL,
  `setup` int(1) NOT NULL DEFAULT 0,
  `batch_no` varchar(50) NOT NULL,
  `job_cycle_time` int(11) NOT NULL,
  `required_product_q_per_hr` int(11) NOT NULL,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_2`
--

CREATE TABLE `production_2` (
  `id` bigint(20) NOT NULL,
  `production_1` bigint(20) NOT NULL,
  `time_1` int(11) NOT NULL,
  `q_after_1` int(11) NOT NULL,
  `time_2` int(11) NOT NULL,
  `q_after_2` int(11) NOT NULL,
  `time_3` int(11) NOT NULL,
  `q_after_3` int(11) NOT NULL,
  `time_4` int(11) NOT NULL,
  `q_after_4` int(11) NOT NULL,
  `time_5` int(11) NOT NULL,
  `q_after_5` int(11) NOT NULL,
  `time_6` int(11) NOT NULL,
  `q_after_6` int(11) NOT NULL,
  `time_7` int(11) NOT NULL,
  `q_after_7` int(11) NOT NULL,
  `time_8` int(11) NOT NULL,
  `q_after_8` int(11) NOT NULL,
  `time_9` int(11) NOT NULL,
  `q_after_9` int(11) NOT NULL,
  `time_10` int(11) NOT NULL,
  `q_after_10` int(11) NOT NULL,
  `time_11` int(11) NOT NULL,
  `q_after_11` int(11) NOT NULL,
  `time_12` int(11) NOT NULL,
  `q_after_12` int(11) NOT NULL,
  `total_q_before_rejection` int(11) NOT NULL,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_3`
--

CREATE TABLE `production_3` (
  `id` bigint(20) NOT NULL,
  `production_1` bigint(20) NOT NULL,
  `variation_nos` int(11) NOT NULL,
  `turning_rejection_nos` int(11) NOT NULL,
  `setting_rejection_nos` int(11) NOT NULL,
  `pre_machining_rejection_nos` int(11) NOT NULL,
  `forging_rejection_nos` int(11) NOT NULL,
  `total_q_after_rejection` int(11) NOT NULL,
  `expected_q` int(11) NOT NULL,
  `setting_hr` int(11) NOT NULL,
  `production_loss_increase_q` varchar(11) NOT NULL DEFAULT '0',
  `production_per` float NOT NULL,
  `datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `production_machine_breakdown`
--

CREATE TABLE `production_machine_breakdown` (
  `id` bigint(20) NOT NULL,
  `production_1` bigint(20) NOT NULL,
  `setting_hour` int(11) NOT NULL,
  `machine_fault_hour` int(11) NOT NULL,
  `recess_hour` int(11) NOT NULL,
  `maintanance_hour` int(11) NOT NULL,
  `no_operator_hour` int(11) NOT NULL,
  `no_load_hour` int(11) NOT NULL,
  `power_fail_hour` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `rework` int(11) NOT NULL DEFAULT 0,
  `total_breakdown_hours` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `c_id` int(11) NOT NULL,
  `pryority` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL,
  `pryority` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(255) DEFAULT NULL,
  `ind_name` varchar(255) DEFAULT NULL,
  `con_number` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `g_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL DEFAULT 0,
  `pryority` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '0',
  `content` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pro_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '0',
  `ranged` varchar(255) NOT NULL DEFAULT '0',
  `extra` varchar(255) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_customer`
--
ALTER TABLE `dpi_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_dispatch`
--
ALTER TABLE `dpi_dispatch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_furnace`
--
ALTER TABLE `dpi_furnace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_invoice`
--
ALTER TABLE `dpi_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_messagebox`
--
ALTER TABLE `dpi_messagebox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_order`
--
ALTER TABLE `dpi_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_order_inward`
--
ALTER TABLE `dpi_order_inward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_platform`
--
ALTER TABLE `dpi_platform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_platform_material`
--
ALTER TABLE `dpi_platform_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_power_panel`
--
ALTER TABLE `dpi_power_panel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_process`
--
ALTER TABLE `dpi_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_stock_log`
--
ALTER TABLE `dpi_stock_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_userinfo`
--
ALTER TABLE `dpi_userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dpi_user_roles`
--
ALTER TABLE `dpi_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `dpi_vehicle`
--
ALTER TABLE `dpi_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joblist`
--
ALTER TABLE `joblist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_1`
--
ALTER TABLE `production_1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_2`
--
ALTER TABLE `production_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_3`
--
ALTER TABLE `production_3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_machine_breakdown`
--
ALTER TABLE `production_machine_breakdown`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pro_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `dpi_customer`
--
ALTER TABLE `dpi_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dpi_dispatch`
--
ALTER TABLE `dpi_dispatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dpi_furnace`
--
ALTER TABLE `dpi_furnace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dpi_invoice`
--
ALTER TABLE `dpi_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dpi_messagebox`
--
ALTER TABLE `dpi_messagebox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dpi_order`
--
ALTER TABLE `dpi_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `dpi_order_inward`
--
ALTER TABLE `dpi_order_inward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dpi_platform`
--
ALTER TABLE `dpi_platform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dpi_platform_material`
--
ALTER TABLE `dpi_platform_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dpi_power_panel`
--
ALTER TABLE `dpi_power_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dpi_process`
--
ALTER TABLE `dpi_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dpi_stock_log`
--
ALTER TABLE `dpi_stock_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dpi_userinfo`
--
ALTER TABLE `dpi_userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dpi_vehicle`
--
ALTER TABLE `dpi_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `joblist`
--
ALTER TABLE `joblist`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_1`
--
ALTER TABLE `production_1`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_2`
--
ALTER TABLE `production_2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_3`
--
ALTER TABLE `production_3`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_machine_breakdown`
--
ALTER TABLE `production_machine_breakdown`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
