-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2016 at 08:42 AM
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
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `TeamID` int(11) DEFAULT NULL,
  `Position` enum('ADMIN','AGENT','ACCOUNTANT') NOT NULL,
  `ContactNumber` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountID`, `FirstName`, `LastName`, `TeamID`, `Position`, `ContactNumber`, `Email`, `IsTeamLeader`) VALUES
(1, 'Darren', 'Liu', NULL, 'AGENT', 753, 'dfg@sdf.com', 0),
(2, 'Kevin', 'Guo', NULL, 'AGENT', 96521, 'rtg@dcfvh.com', 0),
(3, 'Peter', 'Ray', NULL, 'AGENT', 85, 'dfg@rgh.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `MLS` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Status` enum('OPEN','CLOSED') NOT NULL,
  `Total` double NOT NULL,
  `Images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `caseservices`
--

CREATE TABLE `caseservices` (
  `CaseID` int(11) NOT NULL,
  `ServiceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `FilePath` varchar(255) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileType` enum('IMAGE','TXT','DOC','PDF') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FilePath`, `FileName`, `FileType`) VALUES
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475645973_largepMPr27a80002b7f31260.jpg', 'IMAGE'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475645987_largepMPr27a80002b7f31260.jpg', 'IMAGE'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475646219_largepMPr27a80002b7f31260.jpg', 'IMAGE'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475646305_largepMPr27a80002b7f31260.jpg', 'IMAGE'),
('wp-content/themes/NuStream/Upload/Supplier/73/', '1475732027_largepMPr27a80002b7f31260.jpg', 'IMAGE');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `OwnerID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `LandSize` double NOT NULL,
  `HouseSize` double NOT NULL,
  `PropertyType` enum('CONDO','HOUSE','SEMI','TOWNHOUSE') NOT NULL,
  `ListingPrice` double NOT NULL,
  `OwnerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceProviderID` int(11) NOT NULL,
  `EstimateCose` double NOT NULL,
  `RealCost` double NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `InvoiceApprovement` enum('NEW','PENDING','APPROVED') NOT NULL,
  `Status` enum('OPEN','DONE') NOT NULL,
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
  `FirstContactNumber` int(11) NOT NULL,
  `SecondContactName` varchar(255) NOT NULL,
  `SecondContactNumber` int(11) NOT NULL,
  `SupportLocation` varchar(255) NOT NULL,
  `HSTNumber` int(11) NOT NULL,
  `PaymentTerm` enum('MONTHLY','SEMIMONTHLY','OTHER') NOT NULL,
  `FilePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `SupplierType`, `PriceUnit`, `PricePerUnit`, `FirstContactName`, `FirstContactNumber`, `SecondContactName`, `SecondContactNumber`, `SupportLocation`, `HSTNumber`, `PaymentTerm`, `FilePath`) VALUES
(5, 'LLK', 'INSPECTION', 'BYSIZE', 234, 'Shuyang Liu', 7654, 'Shuyang Liu', 9876, 'fgh', 1234, 'MONTHLY', ''),
(6, 'G', 'STAGING', 'BYCASE', 85, 'jk', 45, 'io', 15, 'bn', 95, 'OTHER', ''),
(7, 'HG', 'STAGING', 'BYHOUR', 962, 'DFG', 24, 'UH', 3217, 'HGJ', 852, 'SEMIMONTHLY', ''),
(8, 'jhgf', 'STAGING', 'BYSIZE', 952, 'nbv', 65, 'fdn', 53, 'fghj', 965, 'MONTHLY', ''),
(9, 'jhgf', 'STAGING', 'BYSIZE', 952, 'nbv', 65, 'fdn', 53, 'fghj', 965, 'MONTHLY', ''),
(10, 'dfghj', 'STAGING', 'BYSIZE', 7452, 'fghjk', 96521, 'ghnm', 952, 'ghj', 751, 'MONTHLY', ''),
(11, 'dfg', 'STAGING', 'BYSIZE', 456, 'fgh', 6789, 'gh', 2345, 'dfg', 456, 'MONTHLY', ''),
(73, '', '', '', 0, '', 0, '', 0, '', 0, '', 'wp-content/themes/NuStream/Upload/Supplier/73/');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `TeamID` int(11) NOT NULL,
  `TeamName` varchar(255) NOT NULL,
  `TeamLeaderID` int(11) NOT NULL,
  `TeamLeaderName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`TeamID`, `TeamName`, `TeamLeaderID`, `TeamLeaderName`) VALUES
(7, 'First Team', 2, 'Kevin Guo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountID`),
  ADD UNIQUE KEY `AccountID` (`AccountID`);

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
  ADD UNIQUE KEY `TeamID` (`TeamID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
