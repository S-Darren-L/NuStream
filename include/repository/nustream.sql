-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2016 at 05:36 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nustream`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountID` int(11) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `TeamID` varchar(255) NOT NULL,
  `AccountPosition` enum('ADMIN','AGENT','ACCOUNTANT','SUPERUSER') NOT NULL,
  `ContactNumber` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountID`, `Password`, `FirstName`, `LastName`, `TeamID`, `AccountPosition`, `ContactNumber`, `Email`, `IsTeamLeader`, `IsActivate`) VALUES
(1, '', 'Darren', 'Liu', '7', 'AGENT', '75368', 'dfg@sdf.com', 0, 1),
(2, '', 'Kevin', 'Guo', '7', 'AGENT', '96521', 'rtg@dcfvh.com', 1, 1),
(3, '', 'Peter', 'Ray', '0', 'AGENT', '85', 'dfg@rgh.com', 0, 1),
(41, '13a2d47aef854249e46feb3d954a54c1', 'Shuyang', 'Liu', '7', 'ADMIN', '16478953986', 'gulang15@gmail.com', 0, 1),
(57, '307487ad13756cabf44dc5784d40f77d', 'Darren', 'Liu', '19', 'AGENT', '6478953986', 'gulang15a@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `MLS` varchar(255) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `CoStaffID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `LandSize` double NOT NULL,
  `HouseSize` double NOT NULL,
  `PropertyType` enum('CONDO','HOUSE','SEMI','TOWNHOUSE') NOT NULL,
  `ListingPrice` double NOT NULL,
  `OwnerName` varchar(255) NOT NULL,
  `ContactNumber` varchar(255) NOT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CaseStatus` enum('OPEN','FIRMDEAL','CLOSED') NOT NULL,
  `Total` double NOT NULL,
  `Images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`MLS`, `StaffID`, `CoStaffID`, `Address`, `LandSize`, `HouseSize`, `PropertyType`, `ListingPrice`, `OwnerName`, `ContactNumber`, `StartDate`, `CaseStatus`, `Total`, `Images`) VALUES
('456', 57, 57, 'fg', 456, 456, 'CONDO', 345, 'fgh', '645', '2016-10-13 02:47:29', 'OPEN', 0, ''),
('56', 57, 57, 'cghj', 789, 5, 'CONDO', 678, 'fgh', '56', '2016-10-13 02:56:29', 'OPEN', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `caseservices`
--

CREATE TABLE `caseservices` (
  `MLS` varchar(255) NOT NULL,
  `ServiceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `FilePath` varchar(255) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileType` enum('IMAGE','TXT','DOC','PDF') NOT NULL,
  `FileStatus` enum('New','Pending','Approved') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FilePath`, `FileName`, `FileType`, `FileStatus`) VALUES
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475645973_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475645987_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475646219_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475646305_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475732027_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload///', '1476031283_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceSupplierID` int(11) NOT NULL,
  `SupplierType` enum('STAGING','PHOTOGRAPHY','CLEANUP','RELOCATEHOME','TOUCHUP','INSPECTION','YARDWORK','STORAGE') NOT NULL,
  `EstimateCose` double NOT NULL,
  `RealCost` double NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `InvoiceStatus` enum('NEW','PENDING','APPROVED') NOT NULL,
  `BeforeImage` varchar(255) NOT NULL,
  `AfterImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(255) NOT NULL,
  `SupplierType` enum('STAGING','PHOTOGRAPHY','CLEANUP','RELOCATEHOME','TOUCHUP','INSPECTION','YARDWORK','STORAGE') NOT NULL,
  `PriceUnit` enum('BYSIZE','BYHOUR','BYHOUSETYPE','BYCASE') NOT NULL,
  `PricePerUnit` double NOT NULL,
  `FirstContactName` varchar(255) NOT NULL,
  `FirstContactNumber` varchar(255) NOT NULL,
  `SecondContactName` varchar(255) NOT NULL,
  `SecondContactNumber` varchar(255) NOT NULL,
  `SupportLocation` varchar(255) NOT NULL,
  `HSTNumber` varchar(255) NOT NULL,
  `PaymentTerm` enum('MONTHLY','SEMIMONTHLY','OTHER') NOT NULL,
  `OtherPaymentTerm` varchar(255) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `SupplierType`, `PriceUnit`, `PricePerUnit`, `FirstContactName`, `FirstContactNumber`, `SecondContactName`, `SecondContactNumber`, `SupportLocation`, `HSTNumber`, `PaymentTerm`, `OtherPaymentTerm`, `FilePath`, `IsActivate`) VALUES
(5, 'LLK', 'INSPECTION', 'BYSIZE', 234, 'Shuyang Liu', '7654', 'Shuyang Liu', '9876', 'fgh', '1234', 'MONTHLY', '', '', 1),
(7, 'HG', 'STAGING', 'BYSIZE', 962, 'DFG', '24', 'UH', '3217', '', '852', 'MONTHLY', '', '', 1),
(8, 'jhgf', 'STAGING', 'BYSIZE', 952, 'nbv', '65', 'fdn', '53', 'fghj', '965', 'MONTHLY', '', '', 1),
(9, 'jhgf', 'STAGING', 'BYSIZE', 952, 'nbv', '65', 'fdn', '53', 'fghj', '965', 'MONTHLY', '', '', 1),
(10, 'dfghj', 'STAGING', 'BYSIZE', 7452, 'fghjk', '96521', 'ghnm', '952', 'ghj', '751', 'MONTHLY', '', '', 1),
(11, 'dfg', 'STAGING', 'BYSIZE', 456, 'fgh', '6789', 'gh', '2345', 'dfg', '456', 'MONTHLY', '', '', 1),
(73, '', '', '', 0, '', '0', '', '0', '', '0', '', '', 'wp-content/themes/NuStream/Upload/Supplier/73/', 1),
(74, 'Lghjk', 'TOUCHUP', 'BYHOUR', 85, 'ghj', '52', 'nhjk', '4', '', '54521456', 'SEMIMONTHLY', '', '', 1),
(75, 'sdfg', 'INSPECTION', 'BYCASE', 52, 'sdfg', '85', 'Sdf', '52', '', '85', 'OTHER', 'cvg', '', 1),
(76, 'sdf', 'STAGING', 'BYSIZE', 6, 'bv', '632', 'bvc', '32', '', '5663', 'MONTHLY', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `TeamID` int(11) NOT NULL,
  `TeamLeaderID` int(11) NOT NULL,
  `TeamLeaderName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`TeamID`, `TeamLeaderID`, `TeamLeaderName`) VALUES
(7, 2, 'Kevin Guo'),
(17, 54, 'Shuyang Liu'),
(18, 56, 'Shuyang Liu'),
(19, 57, 'Darren Liu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountID`),
  ADD UNIQUE KEY `AccountID` (`AccountID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`MLS`),
  ADD UNIQUE KEY `MLS` (`MLS`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD UNIQUE KEY `FileName` (`FileName`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`SupplierID`),
  ADD UNIQUE KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`TeamID`),
  ADD UNIQUE KEY `TeamID` (`TeamID`),
  ADD UNIQUE KEY `TeamLeaderID` (`TeamLeaderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
