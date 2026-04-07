-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 04:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezbuslk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` varchar(255) NOT NULL,
  `paymentID` int(11) NOT NULL,
  `feedbackID` int(11) DEFAULT NULL,
  `customerID` int(11) NOT NULL,
  `bookedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'active',
  `additional` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `paymentID`, `feedbackID`, `customerID`, `bookedDate`, `status`, `additional`) VALUES
('b_6627e2590fab5', 27, NULL, 27, '2024-04-23 22:01:21', 'active', NULL),
('b_6627e2ee64ff3', 28, NULL, 28, '2024-04-23 22:03:50', 'active', NULL),
('b_6628024a0d4e6', 29, NULL, 29, '2024-04-24 00:17:38', 'active', NULL),
('b_6628c879ce993', 30, NULL, 30, '2024-04-24 14:23:13', 'active', NULL),
('b_6629e3e22b56e', 31, NULL, 31, '2024-04-25 10:32:26', 'active', NULL),
('b_6629f14bb2923', 32, NULL, 32, '2024-04-25 11:29:39', 'active', NULL),
('b_662a7ad9df253', 33, NULL, 33, '2024-04-25 21:16:33', 'active', NULL),
('b_662a7bb619bb9', 34, NULL, 34, '2024-04-25 21:20:14', 'active', NULL),
('b_662a83b8e41ae', 35, NULL, 35, '2024-04-25 21:54:24', 'active', NULL),
('b_662a898aeff2e', 36, NULL, 36, '2024-04-25 22:19:14', 'active', NULL),
('b_662a89b85e111', 37, NULL, 37, '2024-04-25 22:20:00', 'active', NULL),
('b_662a89fbe1ab1', 38, NULL, 38, '2024-04-25 22:21:07', 'active', NULL),
('b_662a92fa90796', 39, NULL, 39, '2024-04-25 22:59:30', 'active', NULL),
('b_662b073e91d53', 40, NULL, 40, '2024-04-26 07:15:34', 'active', NULL),
('b_662b089d9b61a', 41, NULL, 41, '2024-04-26 07:21:25', 'active', NULL),
('b_662b0ed926e22', 44, NULL, 44, '2024-04-26 07:48:01', 'active', NULL),
('b_662b19759bc48', 45, NULL, 45, '2024-04-26 08:33:17', 'active', NULL),
('b_662b19b2efe6b', 46, NULL, 46, '2024-04-26 08:34:18', 'active', NULL),
('b_662b1ab77331e', 47, NULL, 47, '2024-04-26 08:38:39', 'active', NULL),
('b_662b2e5e01fe4', 48, NULL, 48, '2024-04-26 10:02:30', 'active', NULL),
('b_662bb399f3d62', 49, NULL, 49, '2024-04-26 19:30:58', 'active', NULL),
('b_663204921a57e', 50, NULL, 50, '2024-05-01 14:30:02', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `busID` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `model` varchar(100) NOT NULL,
  `regNo` varchar(20) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `image` text DEFAULT NULL,
  `rating` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`busID`, `type`, `model`, `regNo`, `capacity`, `status`, `image`, `rating`) VALUES
('NA1220', 'Non AC', 'Ashok Leyland', 'NA 1220', 54, 'active', 'IMG-662b2d036e49f9.56483855.jpg', NULL),
('NB6502', 'Non AC', 'Ashok Leyland', 'NB 6502', 64, 'active', 'IMG-6629f2a83bcee4.31415699.jpg', NULL),
('NC0909', 'Non AC', 'Ashok Leyland', 'NC 0909', 54, 'active', 'IMG-662a888d8faf14.31841318.png', NULL),
('NC2322', 'Non AC', 'Ashok Leyland', 'NC 2322', 54, 'active', 'IMG-660f8504ca4d11.98690628.jpg', NULL),
('NC3973', 'Non AC', 'Ashok Leyland', 'NC 3973', 68, 'active', 'IMG-6628f76402b429.57115357.jpg', NULL),
('NC6700', 'Non AC', 'Ashok Leyland', 'NC 6700', 54, 'active', 'IMG-662b27d5ab8c12.01367380.jpg', NULL),
('ND0212', 'Non AC', 'Ashok Leyland', 'ND 0212', 54, 'active', 'IMG-663203880203e9.01132399.jpg', NULL),
('ND0223', 'Non AC', 'Ashok Leyland', 'ND 0223', 54, 'active', 'IMG-66012188cbda36.96176450.jpg', NULL),
('ND0954', 'Non AC', 'Ashok Leyland', 'ND 0954', 54, 'active', 'IMG-6629ef91dc2e76.86645183.png', NULL),
('ND1111', 'Non AC', 'Ashok Leyland', 'ND 1111', 54, 'active', 'IMG-6610081e961409.24616704.png', NULL),
('ND1220', 'Non AC', 'Ashok Leyland', 'ND 1220', 54, 'deactive', 'IMG-66012365783347.13251297.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bus_booking`
--

CREATE TABLE `bus_booking` (
  `inquiryID` int(11) NOT NULL,
  `busID` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nic` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNo` varchar(255) NOT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `addedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_booking`
--

INSERT INTO `bus_booking` (`inquiryID`, `busID`, `name`, `nic`, `email`, `contactNo`, `startDate`, `endDate`, `addedDate`, `status`) VALUES
(2, 'NC3973', 'Ashane Lakshitha', '200234409977', 'ashane@gmail.com', '0776522211', '2024-04-26', '2024-04-27', '2024-04-25 09:54:54', 'confirmed'),
(3, 'NC3973', 'Diberdan', '200234561122', 'diberdan@gmail.com', '0776542293', '2024-04-26', '2024-04-29', '2024-04-25 11:36:16', 'confirmed'),
(4, 'NB6502', 'Ashane Lakshitha', '200245672211', 'ashaneicbt@gmail.com', '0776542211', '2024-04-27', '2024-04-30', '2024-04-26 07:51:36', 'confirmed'),
(6, 'NB6502', 'Ashane Lakshitha', '200232122222', 'ashaneicbt@gmail.com', '0776542211', '2024-04-29', '2024-04-30', '2024-04-26 10:05:39', 'confirmed'),
(7, 'NC3973', 'Ashane Lakshitha', '200232212211', 'ashaneicbt@gmail.com', '0776545211', '2024-05-01', '2024-05-16', '2024-05-01 14:33:28', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contactID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `nic`, `email`, `phoneNo`, `name`) VALUES
(18, '200323212222', 'saman@gmail.com', '0776252121', 'Saman Perera'),
(19, '200212111111', 'ashane@gmail.com', '0772121111', 'Ashane Lakshitha'),
(20, '121', 'dadaeed@gmail.com', '0776542232', 'dwebduyh'),
(21, '200343213322', 'saman@gmail.com', '0776543221', 'Saman'),
(22, '200223212222', 'ashane@gmail.com', '0776521111', 'Ashane Lakshitha'),
(23, '200622112222', 'ashane@gmail.com', '0776522211', 'Ashane Lakshitha'),
(24, '200234522222', 'ashane@gmail.com', '0776542222', 'Ashane Lakshitha'),
(25, '202232222111', 'ashane@gmail.com', '0776542222', 'Ashane Lakshitha'),
(26, '202222222222', 'ashane@gmail.com', '0776542222', 'Ashane Lakshitha'),
(27, '200232122222', 'ashane@gmaiil.com', '0776542222', 'Ashane Lakshitha'),
(28, '200212322222', 'ashane@gmail.com', '0775432222', 'Ashane Lakshitha'),
(29, '202222222222', 'tharuka@gmail.com', '0776555566', 'Tharuka P'),
(30, '202234522222', 'saman@gmail.com', '0776542211', 'Saman Perera'),
(31, '234567890', 'tharu@gmail.com', '0776544455', 'Tharuka'),
(32, '200223212222', 'tharuka@gmail.com', '0776543222', 'Tharuka Premasiri'),
(33, '200232219988', 'ashane@gmail.com', '0776532211', 'Ashane Lakshitha'),
(34, '200232219988', 'ashane@gmail.com', '0776532211', 'Ashane Lakshitha'),
(35, '200234212211', 'alarangallla@gmail.com', '0883212211', 'Ashane Lakshitha'),
(36, '200721121111', 'ashane@gmail.com', '0776521222', 'Ashane Lakshitha'),
(37, '200721121111', 'ashane@gmail.com', '0776521222', 'Ashane Lakshitha'),
(38, '200212232222', 'ashane@gmail.com', '0772211222', 'Ashane Lakshitha'),
(39, '200232122211', 'ashane@gmail.com', '0773212211', 'Ashane Lakshitha'),
(40, '200235505542', 'ashane@gmail.com', '0776542122', 'Ashane Lakshitha'),
(41, '200245672211', 'ashane@gmail.com', '0776542211', 'Ashane Lakshitha'),
(42, '200255677211', 'ashaneicbt@gmail.com', '0775432244', 'Ashane Lakshitha'),
(43, '200432122222', 'ashaneicbt@gmail.com', '0776542111', 'Ashane Lakshitha'),
(44, '200235503322', 'ashaneicbt@gmail.com', '0776542111', 'Ashane Lakshitha'),
(45, '200562112211', 'ashaneicbt@gmail.com', '0776212111', 'Sharneeshan'),
(46, '200562112211', 'ashaneicbt@gmail.com', '0776212111', 'Sharneeshan'),
(47, '200254327211', 'ashaneicbt@gmail.com', '0775421122', 'Ashane Lakshitha'),
(48, '200234532122', 'ashaneicbt@gmail.com', '0776532211', 'Ashane Lakshitha'),
(49, '200235502294', 'ashaneicbt@gmail.com', '0776521122', 'Ashane Lakshitha'),
(50, '200234221122', 'ashaneicbt@gmail.com', '0776652211', 'Ashane Lakshitha');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` int(11) NOT NULL,
  `feedback` text DEFAULT NULL,
  `rating` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `paymentDate` datetime NOT NULL DEFAULT current_timestamp(),
  `totalPayment` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `paymentDate`, `totalPayment`) VALUES
(17, '2024-03-28 16:57:18', 900),
(18, '2024-03-28 17:01:07', 1300),
(19, '2024-04-05 10:31:52', 250),
(20, '2024-04-22 20:43:58', 900),
(21, '2024-04-23 09:13:06', 900),
(22, '2024-04-23 20:20:49', 900),
(23, '2024-04-23 21:00:56', 900),
(24, '2024-04-23 21:05:30', 900),
(25, '2024-04-23 21:12:06', 900),
(26, '2024-04-23 21:18:14', 900),
(27, '2024-04-23 22:01:21', 900),
(28, '2024-04-23 22:03:50', 900),
(29, '2024-04-24 00:17:38', 1300),
(30, '2024-04-24 14:23:13', 1300),
(31, '2024-04-25 10:32:26', 900),
(32, '2024-04-25 11:29:39', 4600),
(33, '2024-04-25 21:16:33', 0),
(34, '2024-04-25 21:20:14', 0),
(35, '2024-04-25 21:54:24', 3100),
(36, '2024-04-25 22:19:14', 1900),
(37, '2024-04-25 22:20:00', 1900),
(38, '2024-04-25 22:21:07', 1900),
(39, '2024-04-25 22:59:30', 1900),
(40, '2024-04-26 07:15:34', 1900),
(41, '2024-04-26 07:21:25', 1900),
(42, '2024-04-26 07:42:44', 2800),
(43, '2024-04-26 07:45:26', 2800),
(44, '2024-04-26 07:48:01', 2800),
(45, '2024-04-26 08:33:17', 3100),
(46, '2024-04-26 08:34:18', 3100),
(47, '2024-04-26 08:38:39', 3100),
(48, '2024-04-26 10:02:30', 1700),
(49, '2024-04-26 19:30:58', 1700),
(50, '2024-05-01 14:30:02', 2800);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeID` varchar(100) NOT NULL,
  `routeNo` varchar(20) NOT NULL,
  `origin` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`routeID`, `routeNo`, `origin`, `destination`, `status`) VALUES
('01CK', '01', 'Colombo', 'Kandy', 'active'),
('02CM', '02', 'Colombo', 'Matara', 'active'),
('05CK', '05', 'Colombo', 'Kurunegala', 'deactive'),
('32CK', '32', 'Colombo', 'Katharagama', 'active'),
('87CJ', '87', 'Colombo', 'Jaffna', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `route_stop`
--

CREATE TABLE `route_stop` (
  `stopID` varchar(100) NOT NULL,
  `routeID` varchar(100) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route_stop`
--

INSERT INTO `route_stop` (`stopID`, `routeID`, `order`) VALUES
('ALU', '02CM', 5),
('AMB', '05CK', 6),
('ANU', '87CJ', 4),
('BAM', '02CM', 2),
('BAM', '32CK', 2),
('COL', '01CK', 1),
('COL', '02CM', 1),
('COL', '05CK', 1),
('COL', '32CK', 1),
('COL', '87CJ', 1),
('GAL', '02CM', 6),
('GAL', '32CK', 5),
('GAM', '01CK', 2),
('GAM', '05CK', 2),
('JF', '87CJ', 6),
('KAD', '01CK', 3),
('KAD', '05CK', 3),
('KAL', '02CM', 4),
('KAL', '32CK', 4),
('KAN', '01CK', 9),
('KAT', '32CK', 8),
('KDG', '01CK', 7),
('KOG', '02CM', 7),
('KOG', '32CK', 6),
('KUR', '05CK', 7),
('MAT', '02CM', 8),
('MAT', '32CK', 7),
('MAW', '01CK', 6),
('NEG', '87CJ', 2),
('NIT', '01CK', 4),
('NIT', '05CK', 4),
('PAN', '02CM', 3),
('PAN', '32CK', 3),
('PER', '01CK', 8),
('PUT', '87CJ', 3),
('VAV', '87CJ', 5),
('WAR', '01CK', 5),
('WAR', '05CK', 5);

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seatID` int(11) NOT NULL,
  `tripID` varchar(100) NOT NULL,
  `tempBookingID` int(11) DEFAULT NULL,
  `bookingID` varchar(255) DEFAULT NULL,
  `seatNo` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seatID`, `tripID`, `tempBookingID`, `bookingID`, `seatNo`, `status`) VALUES
(531766, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_6629f14bb2923', 18, 'booked'),
(531767, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_6629f14bb2923', 19, 'booked'),
(531768, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_6629f14bb2923', 20, 'booked'),
(531933, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662a83b8e41ae', 36, 'booked'),
(531934, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662a83b8e41ae', 37, 'booked'),
(531975, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662a89fbe1ab1', 23, 'booked'),
(531976, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662a89fbe1ab1', 24, 'booked'),
(531987, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662a92fa90796', 31, 'booked'),
(531988, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662a92fa90796', 32, 'booked'),
(532022, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b073e91d53', 49, 'booked'),
(532023, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b073e91d53', 50, 'booked'),
(532029, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b089d9b61a', 41, 'booked'),
(532030, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b089d9b61a', 42, 'booked'),
(532049, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b0ed926e22', 52, 'booked'),
(532050, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b0ed926e22', 53, 'booked'),
(532051, '32CK-05001800-NC0909-240503DEP', NULL, 'b_662b0ed926e22', 54, 'booked'),
(532052, '87CJ-09001800-ND0954-240427DEP', 129, NULL, 52, 'booked'),
(532053, '87CJ-09001800-ND0954-240427DEP', 129, NULL, 53, 'booked'),
(532056, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b19759bc48', 49, 'booked'),
(532057, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b19759bc48', 50, 'booked'),
(532058, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b19b2efe6b', 49, 'booked'),
(532059, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b19b2efe6b', 50, 'booked'),
(532062, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b1ab77331e', 41, 'booked'),
(532063, '87CJ-09001800-ND0954-240427DEP', NULL, 'b_662b1ab77331e', 42, 'booked'),
(532083, '02CM-08001730-ND0212-240503DEP', 139, NULL, 16, 'booked'),
(532084, '02CM-08001730-ND0212-240503DEP', 139, NULL, 17, 'booked'),
(532088, '02CM-08001730-ND0212-240503DEP', NULL, 'b_663204921a57e', 23, 'booked'),
(532089, '02CM-08001730-ND0212-240503DEP', NULL, 'b_663204921a57e', 24, 'booked'),
(532090, '02CM-08001730-ND0212-240503DEP', NULL, 'b_663204921a57e', 25, 'booked');

-- --------------------------------------------------------

--
-- Table structure for table `special_bus`
--

CREATE TABLE `special_bus` (
  `busID` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_bus`
--

INSERT INTO `special_bus` (`busID`, `userID`, `name`, `rate`, `description`) VALUES
('NB6502', 7, 'Duburu Lamissi', NULL, 'Bus facilities include comfortable seating arrangements, air conditioning for climate control, onboard restroom facilities for convenience during long journeys, overhead storage compartments for luggage, onboard entertainment systems like TV screens or Wi-Fi for passenger entertainment, and sometimes food and beverage services for refreshment.'),
('NC3973', 4, 'Dam Rejina', 4.5, 'Bus facilities include comfortable seating arrangements, air conditioning for climate control, onboard restroom facilities for convenience during long journeys, overhead storage compartments for luggage, onboard entertainment systems like TV screens or Wi-Fi for passenger entertainment, and sometimes food and beverage services for refreshment.');

-- --------------------------------------------------------

--
-- Table structure for table `standard_bus`
--

CREATE TABLE `standard_bus` (
  `busID` varchar(100) NOT NULL,
  `routeID` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `class` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standard_bus`
--

INSERT INTO `standard_bus` (`busID`, `routeID`, `userID`, `class`) VALUES
('NC0909', '32CK', 8, 'Semi Luxury'),
('NC6700', '32CK', 4, 'Semi Luxury'),
('ND0212', '02CM', 9, 'Semi Luxury'),
('ND0223', '01CK', 1, 'Normal'),
('ND0954', '87CJ', 7, 'Semi Luxury'),
('ND1111', '05CK', 1, 'Semi Luxury');

-- --------------------------------------------------------

--
-- Table structure for table `stop`
--

CREATE TABLE `stop` (
  `stopID` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stop`
--

INSERT INTO `stop` (`stopID`, `city`) VALUES
('ALA', 'Alawwa'),
('ALU', 'Aluthgama'),
('AMB', 'Ambepussa'),
('ANU', 'Anuradhapura'),
('BAM', 'Bambalapitiya'),
('COL', 'Colombo'),
('GAL', 'Galle'),
('GAM', 'Gampaha'),
('HOR', 'Horana'),
('JF', 'Jaffna'),
('KAD', 'Kadawatha'),
('KAL', 'Kalutara'),
('KAN', 'Kandy'),
('KAT', 'Katharagama'),
('KDG', 'Kadugannawa'),
('KEG', 'Kegalle'),
('KOG', 'Koggala'),
('KUR', 'Kurunegala'),
('MAT', 'Matara'),
('MAW', 'Mawanella'),
('NEG', 'Negombo'),
('NIT', 'Nittambuwa'),
('PAN', 'Panadura'),
('PER', 'Peradeniya'),
('PIL', 'Piliyandala'),
('PUT', 'Puththalam'),
('VAV', 'Vavuniya'),
('WAR', 'Warakapola');

-- --------------------------------------------------------

--
-- Table structure for table `temp_booking`
--

CREATE TABLE `temp_booking` (
  `tempBookingID` int(11) NOT NULL,
  `tripID` varchar(100) NOT NULL,
  `noOfSeats` int(11) NOT NULL,
  `bookedTime` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_booking`
--

INSERT INTO `temp_booking` (`tempBookingID`, `tripID`, `noOfSeats`, `bookedTime`) VALUES
(129, '87CJ-09001800-ND0954-240427DEP', 2, '08:32:16'),
(139, '02CM-08001730-ND0212-240503DEP', 2, '14:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `tripID` varchar(100) NOT NULL,
  `busID` varchar(100) NOT NULL,
  `routeID` varchar(100) NOT NULL,
  `turnID` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `turnType` varchar(20) NOT NULL,
  `closingTime` time NOT NULL,
  `avaSeats` int(11) NOT NULL DEFAULT 49,
  `status` varchar(20) DEFAULT 'status',
  `longitude` geometry DEFAULT NULL,
  `latitude` geometry DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`tripID`, `busID`, `routeID`, `turnID`, `date`, `turnType`, `closingTime`, `avaSeats`, `status`, `longitude`, `latitude`) VALUES
('01CK-09001400-ND0223-240427DEP', 'ND0223', '01CK', '01CK-09001400', '2024-04-27', 'depart', '08:00:00', 54, 'active', NULL, NULL),
('02CM-08001730-ND0212-240503DEP', 'ND0212', '02CM', '02CM-08001730', '2024-05-03', 'depart', '07:00:00', 44, 'active', NULL, NULL),
('05CK-09001500-ND1111-240503DEP', 'ND1111', '05CK', '05CK-09001500', '2024-05-03', 'depart', '08:00:00', 54, 'active', NULL, NULL),
('32CK-05001800-NC0909-240503DEP', 'NC0909', '32CK', '32CK-05001800', '2024-05-03', 'depart', '04:00:00', 38, 'active', NULL, NULL),
('32CK-11002230-NC6700-240427ARR', 'NC6700', '32CK', '32CK-11002230', '2024-04-27', 'arrive', '21:30:00', 49, '', NULL, NULL),
('32CK-11002230-NC6700-240503DEP', 'NC6700', '32CK', '32CK-11002230', '2024-05-03', 'depart', '10:00:00', 49, 'active', NULL, NULL),
('87CJ-09001800-ND0954-240427DEP', 'ND0954', '87CJ', '87CJ-09001800', '2024-04-27', 'depart', '08:00:00', 38, 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trip_booking`
--

CREATE TABLE `trip_booking` (
  `bookingID` varchar(255) NOT NULL,
  `tripID` varchar(100) NOT NULL,
  `pickup` varchar(100) NOT NULL,
  `dropPoint` varchar(100) NOT NULL,
  `noOfSeats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip_booking`
--

INSERT INTO `trip_booking` (`bookingID`, `tripID`, `pickup`, `dropPoint`, `noOfSeats`) VALUES
('b_6629f14bb2923', '87CJ-09001800-ND0954-240427DEP', 'Colombo', 'Jaffna', 3),
('b_662a83b8e41ae', '87CJ-09001800-ND0954-240427DEP', 'Colombo', 'Jaffna', 2),
('b_662a89fbe1ab1', '32CK-05001800-NC0909-240503DEP', 'Colombo', 'Katharagama', 2),
('b_662a92fa90796', '32CK-05001800-NC0909-240503DEP', 'Colombo', 'Katharagama', 2),
('b_662b073e91d53', '32CK-05001800-NC0909-240503DEP', 'Colombo', 'Katharagama', 2),
('b_662b089d9b61a', '32CK-05001800-NC0909-240503DEP', 'Colombo', 'Katharagama', 2),
('b_662b0ed926e22', '32CK-05001800-NC0909-240503DEP', 'Colombo', 'Katharagama', 3),
('b_662b19759bc48', '87CJ-09001800-ND0954-240427DEP', 'Colombo', 'Jaffna', 2),
('b_662b19b2efe6b', '87CJ-09001800-ND0954-240427DEP', 'Colombo', 'Jaffna', 2),
('b_662b1ab77331e', '87CJ-09001800-ND0954-240427DEP', 'Colombo', 'Jaffna', 2),
('b_663204921a57e', '02CM-08001730-ND0212-240503DEP', 'Colombo', 'Galle', 3);

-- --------------------------------------------------------

--
-- Table structure for table `trip_stop`
--

CREATE TABLE `trip_stop` (
  `tripID` varchar(100) NOT NULL,
  `stopID` varchar(100) NOT NULL,
  `pointType` varchar(20) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip_stop`
--

INSERT INTO `trip_stop` (`tripID`, `stopID`, `pointType`, `order_id`) VALUES
('01CK-09001400-ND0223-240427DEP', 'COL', 'start', 0),
('01CK-09001400-ND0223-240427DEP', 'GAM', 'start', 1),
('01CK-09001400-ND0223-240427DEP', 'KAD', 'start', 2),
('01CK-09001400-ND0223-240427DEP', 'KAN', 'end', 8),
('01CK-09001400-ND0223-240427DEP', 'KDG', 'end', 6),
('01CK-09001400-ND0223-240427DEP', 'MAW', 'end', 5),
('01CK-09001400-ND0223-240427DEP', 'NIT', 'start', 3),
('01CK-09001400-ND0223-240427DEP', 'PER', 'end', 7),
('01CK-09001400-ND0223-240427DEP', 'WAR', 'start', 4),
('02CM-08001730-ND0212-240503DEP', 'ALU', 'end', 4),
('02CM-08001730-ND0212-240503DEP', 'BAM', 'start', 1),
('02CM-08001730-ND0212-240503DEP', 'COL', 'start', 0),
('02CM-08001730-ND0212-240503DEP', 'GAL', 'end', 5),
('02CM-08001730-ND0212-240503DEP', 'KAL', 'start', 3),
('02CM-08001730-ND0212-240503DEP', 'KOG', 'end', 6),
('02CM-08001730-ND0212-240503DEP', 'MAT', 'end', 7),
('02CM-08001730-ND0212-240503DEP', 'PAN', 'start', 2),
('05CK-09001500-ND1111-240503DEP', 'AMB', 'end', 5),
('05CK-09001500-ND1111-240503DEP', 'COL', 'start', 0),
('05CK-09001500-ND1111-240503DEP', 'GAM', 'start', 1),
('05CK-09001500-ND1111-240503DEP', 'KAD', 'start', 2),
('05CK-09001500-ND1111-240503DEP', 'KUR', 'end', 6),
('05CK-09001500-ND1111-240503DEP', 'NIT', 'start', 3),
('05CK-09001500-ND1111-240503DEP', 'WAR', 'end', 4),
('32CK-05001800-NC0909-240503DEP', 'BAM', 'start', 1),
('32CK-05001800-NC0909-240503DEP', 'COL', 'start', 0),
('32CK-05001800-NC0909-240503DEP', 'GAL', 'end', 4),
('32CK-05001800-NC0909-240503DEP', 'KAL', 'end', 3),
('32CK-05001800-NC0909-240503DEP', 'KAT', 'end', 7),
('32CK-05001800-NC0909-240503DEP', 'KOG', 'end', 5),
('32CK-05001800-NC0909-240503DEP', 'MAT', 'end', 6),
('32CK-05001800-NC0909-240503DEP', 'PAN', 'end', 2),
('32CK-11002230-NC6700-240427ARR', 'BAM', 'end', 1),
('32CK-11002230-NC6700-240427ARR', 'COL', 'end', 0),
('32CK-11002230-NC6700-240427ARR', 'GAL', 'start', 4),
('32CK-11002230-NC6700-240427ARR', 'KAL', 'end', 3),
('32CK-11002230-NC6700-240427ARR', 'KAT', 'start', 7),
('32CK-11002230-NC6700-240427ARR', 'KOG', 'start', 5),
('32CK-11002230-NC6700-240427ARR', 'MAT', 'start', 6),
('32CK-11002230-NC6700-240427ARR', 'PAN', 'end', 2),
('32CK-11002230-NC6700-240503DEP', 'BAM', 'start', 1),
('32CK-11002230-NC6700-240503DEP', 'COL', 'start', 0),
('32CK-11002230-NC6700-240503DEP', 'GAL', 'end', 4),
('32CK-11002230-NC6700-240503DEP', 'KAL', 'start', 3),
('32CK-11002230-NC6700-240503DEP', 'KAT', 'end', 7),
('32CK-11002230-NC6700-240503DEP', 'KOG', 'end', 5),
('32CK-11002230-NC6700-240503DEP', 'MAT', 'end', 6),
('32CK-11002230-NC6700-240503DEP', 'PAN', 'start', 2),
('87CJ-09001800-ND0954-240427DEP', 'ANU', 'end', 3),
('87CJ-09001800-ND0954-240427DEP', 'COL', 'start', 0),
('87CJ-09001800-ND0954-240427DEP', 'JF', 'end', 5),
('87CJ-09001800-ND0954-240427DEP', 'NEG', 'start', 1),
('87CJ-09001800-ND0954-240427DEP', 'PUT', 'start', 2),
('87CJ-09001800-ND0954-240427DEP', 'VAV', 'end', 4);

-- --------------------------------------------------------

--
-- Table structure for table `turn`
--

CREATE TABLE `turn` (
  `turnID` varchar(100) NOT NULL,
  `routeID` varchar(100) NOT NULL,
  `depTimeOri` time NOT NULL,
  `depTimeDes` time NOT NULL,
  `duration` time NOT NULL,
  `via` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `fare` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `turn`
--

INSERT INTO `turn` (`turnID`, `routeID`, `depTimeOri`, `depTimeDes`, `duration`, `via`, `status`, `fare`) VALUES
('01CK-09001400', '01CK', '09:00:00', '14:00:00', '03:00:00', 'Warakapola', 'deactive', 400),
('01CK-10001500', '01CK', '10:00:00', '15:00:00', '03:00:00', 'Warakapola', 'active', 300),
('02CM-08001730', '02CM', '08:00:00', '17:30:00', '07:00:00', 'Aluthgama', 'active', 900),
('05CK-09001500', '05CK', '09:00:00', '15:00:00', '03:30:00', 'Ambepussa', 'deactive', 400),
('32CK-05001800', '32CK', '05:00:00', '18:00:00', '10:00:00', 'Aluthgama', 'active', 900),
('32CK-11002230', '32CK', '11:00:00', '22:30:00', '10:00:00', 'Galle', 'active', 1000),
('87CJ-09001800', '87CJ', '09:00:00', '18:00:00', '07:30:00', 'Anuradhapura', 'active', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'operator',
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `type`, `email`, `password`, `name`, `status`) VALUES
(1, 'operator', '01cknd0223@gmail.com', '$2y$10$hzvL.WnEoHVWjKaBVXbib..96dDcUZ7g6uLSESgweY0..ue9aKKqi', 'Samana', 'active'),
(4, 'operator', 'randeep@gmail.com', '$2y$10$4E7nJKwYDmceFOBgwyLNGuQwQCth6zfP7zKLeyLvPv5LIr9rGYsw6', 'Randeep', 'active'),
(6, 'admin', 'admin@gmail.com', '$2y$10$q/ApFKtiQRENapAYXnSk4.6IHeYetG1GsRaN50V2/BdlCNidSebse', 'Admin', 'active'),
(7, 'operator', '87jaffnabus@gmai.com', '$2y$10$.4h5b92PVT9KNeeX2JDbsOwxam7hNN23h1QQtXgF3e5B2/7rFGONW', 'Jaffna', 'active'),
(8, 'operator', '32ck@gmail.com', '$2y$10$CA4KNkeSzE3JTtp6H4dapevw1aK98Ej9vBUv9OlyCXzTQteB85ngS', 'ColomboKatharagama', 'active'),
(9, 'operator', '1220cm@gmail.com', '$2y$10$eXivkAezq5gtETFeW8ymuOMn9TamJL/3VehxoxNnaKAMvHBjcWRAi', 'ColomboMatara1220', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `fk_paymentid1` (`paymentID`),
  ADD KEY `fk_feedbackid1` (`feedbackID`),
  ADD KEY `fk_customerid1` (`customerID`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`busID`);

--
-- Indexes for table `bus_booking`
--
ALTER TABLE `bus_booking`
  ADD PRIMARY KEY (`inquiryID`),
  ADD KEY `fk_busid1` (`busID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`routeID`);

--
-- Indexes for table `route_stop`
--
ALTER TABLE `route_stop`
  ADD PRIMARY KEY (`stopID`,`routeID`),
  ADD KEY `fk_routeid3` (`routeID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seatID`),
  ADD KEY `fk_tempbookingid2` (`tempBookingID`),
  ADD KEY `fk_tripid8` (`tripID`),
  ADD KEY `fk_bookingid2` (`bookingID`);

--
-- Indexes for table `special_bus`
--
ALTER TABLE `special_bus`
  ADD PRIMARY KEY (`busID`),
  ADD KEY `fk_userID2` (`userID`);

--
-- Indexes for table `standard_bus`
--
ALTER TABLE `standard_bus`
  ADD PRIMARY KEY (`busID`),
  ADD KEY `fk_routeid1` (`routeID`),
  ADD KEY `fk_userid7` (`userID`);

--
-- Indexes for table `stop`
--
ALTER TABLE `stop`
  ADD PRIMARY KEY (`stopID`);

--
-- Indexes for table `temp_booking`
--
ALTER TABLE `temp_booking`
  ADD PRIMARY KEY (`tempBookingID`),
  ADD KEY `fk_trpid7` (`tripID`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`tripID`),
  ADD KEY `fk_turnid1` (`turnID`),
  ADD KEY `fk_busid6` (`busID`),
  ADD KEY `fk_routeid6` (`routeID`);

--
-- Indexes for table `trip_booking`
--
ALTER TABLE `trip_booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `fk_tripid1` (`tripID`);

--
-- Indexes for table `trip_stop`
--
ALTER TABLE `trip_stop`
  ADD PRIMARY KEY (`tripID`,`stopID`),
  ADD KEY `fk_stopid3` (`stopID`);

--
-- Indexes for table `turn`
--
ALTER TABLE `turn`
  ADD PRIMARY KEY (`turnID`),
  ADD KEY `fk_busid4` (`routeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_booking`
--
ALTER TABLE `bus_booking`
  MODIFY `inquiryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contactID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=532091;

--
-- AUTO_INCREMENT for table `temp_booking`
--
ALTER TABLE `temp_booking`
  MODIFY `tempBookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_customerid1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_feedbackid1` FOREIGN KEY (`feedbackID`) REFERENCES `feedback` (`feedbackID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paymentid1` FOREIGN KEY (`paymentID`) REFERENCES `payment` (`paymentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bus_booking`
--
ALTER TABLE `bus_booking`
  ADD CONSTRAINT `fk_busid1` FOREIGN KEY (`busID`) REFERENCES `special_bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `route_stop`
--
ALTER TABLE `route_stop`
  ADD CONSTRAINT `fk_routeid3` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stopid1` FOREIGN KEY (`stopID`) REFERENCES `stop` (`stopID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `fk_bookingid2` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tempbookingid2` FOREIGN KEY (`tempBookingID`) REFERENCES `temp_booking` (`tempBookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tripid8` FOREIGN KEY (`tripID`) REFERENCES `trip` (`tripID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `special_bus`
--
ALTER TABLE `special_bus`
  ADD CONSTRAINT `fk_busid2` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userID2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `standard_bus`
--
ALTER TABLE `standard_bus`
  ADD CONSTRAINT `fk_busid3` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_routeid1` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_userid7` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temp_booking`
--
ALTER TABLE `temp_booking`
  ADD CONSTRAINT `fk_trpid7` FOREIGN KEY (`tripID`) REFERENCES `trip` (`tripID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `fk_busid6` FOREIGN KEY (`busID`) REFERENCES `standard_bus` (`busID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_routeid6` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_turnid1` FOREIGN KEY (`turnID`) REFERENCES `turn` (`turnID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trip_booking`
--
ALTER TABLE `trip_booking`
  ADD CONSTRAINT `fk_bookingid3` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tripid1` FOREIGN KEY (`tripID`) REFERENCES `trip` (`tripID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trip_stop`
--
ALTER TABLE `trip_stop`
  ADD CONSTRAINT `fk_stopid3` FOREIGN KEY (`stopID`) REFERENCES `stop` (`stopID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tripid7` FOREIGN KEY (`tripID`) REFERENCES `trip` (`tripID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `turn`
--
ALTER TABLE `turn`
  ADD CONSTRAINT `fk_busid4` FOREIGN KEY (`routeID`) REFERENCES `route` (`routeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
