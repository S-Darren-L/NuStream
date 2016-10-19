-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2016 at 08:16 AM
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
(1, '8cfa204204895ba965dc0baf48a1d8a5', 'Darren', 'Liu', '7', 'AGENT', '7536890', 'dfg@sdf.com', 0, 1),
(2, '', 'Kevin', 'Guo', '7', 'AGENT', '96521', 'rtg@dcfvh.com', 1, 1),
(3, '', 'Peter', 'Ray', '0', 'AGENT', '85', 'dfg@rgh.com', 0, 1),
(41, '13a2d47aef854249e46feb3d954a54c1', 'Shuyang', 'Liu', '7', 'ADMIN', '16478953986', 'gulang15@gmail.com', 0, 1),
(57, '827ccb0eea8a706c4c34a16891f84e7b', 'Darren', 'Liu', '19', 'AGENT', '6478953986', 'gulang15a@gmail.com', 1, 1);

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
  `FinialPrice` double NOT NULL,
  `CommissionRate` double NOT NULL,
  `Images` varchar(255) NOT NULL,
  `StagingID` int(11) NOT NULL,
  `TouchUpID` int(11) NOT NULL,
  `CleanUpID` int(11) NOT NULL,
  `YardWorkID` int(11) NOT NULL,
  `InspectionID` int(11) NOT NULL,
  `StorageID` int(11) NOT NULL,
  `RelocateHomeID` int(11) NOT NULL,
  `PhotographyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`MLS`, `StaffID`, `CoStaffID`, `Address`, `LandSize`, `HouseSize`, `PropertyType`, `ListingPrice`, `OwnerName`, `ContactNumber`, `StartDate`, `CaseStatus`, `FinialPrice`, `CommissionRate`, `Images`, `StagingID`, `TouchUpID`, `CleanUpID`, `YardWorkID`, `InspectionID`, `StorageID`, `RelocateHomeID`, `PhotographyID`) VALUES
('2345', 57, 57, 'sdfgh', 2345, 2345, 'CONDO', 2345, 'dfgv', '3456', '2016-10-17 04:53:27', 'OPEN', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0),
('456', 57, 57, 'fg', 456, 456, 'CONDO', 345, 'fgh', '645', '2016-10-13 02:47:29', 'OPEN', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0),
('6543', 57, 3, 'dfg', 765, 3456, 'CONDO', 545600, 'sdf', '654', '2016-10-19 01:19:20', 'FIRMDEAL', 0, 2.2, '', 82, 86, 84, 88, 87, 89, 85, 83);

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
('wp-content/themes/NuStream/Upload///', '1476031283_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload///', '1476742417_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload///', '1476742579_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/', '1476743005_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/', '1476743104_largepMPr27a80002b7f31260.jpg', 'IMAGE', 'New'),
('wp-content/themes/NuStream/Upload/', '1476743146_a.pdf', 'IMAGE', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceSupplierID` int(11) NOT NULL,
  `SupplierType` enum('STAGING','PHOTOGRAPHY','CLEANUP','RELOCATEHOME','TOUCHUP','INSPECTION','YARDWORK','STORAGE') NOT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RealCost` double NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `InvoiceStatus` enum('NEW','PENDING','APPROVED') NOT NULL,
  `BeforeImagePath` varchar(255) NOT NULL,
  `AfterImagePath` varchar(255) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceSupplierID`, `SupplierType`, `StartDate`, `RealCost`, `InvoiceID`, `InvoiceStatus`, `BeforeImagePath`, `AfterImagePath`, `IsActivate`) VALUES
(82, 1, 'STAGING', '0000-00-00 00:00:00', 1500, 0, 'NEW', '', '', 1),
(83, 0, 'PHOTOGRAPHY', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(84, 0, 'CLEANUP', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(85, 0, 'RELOCATEHOME', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(86, 74, 'TOUCHUP', '0000-00-00 00:00:00', 1200, 0, 'PENDING', '', '', 1),
(87, 0, 'INSPECTION', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(88, 0, 'YARDWORK', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(89, 0, 'STORAGE', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(255) NOT NULL,
  `SupplierType` enum('STAGING','PHOTOGRAPHY','CLEANUP','RELOCATEHOME','TOUCHUP','INSPECTION','YARDWORK','STORAGE') NOT NULL,
  `PriceUnit` enum('BYSIZE','BYHOUR','BYHOUSETYPE','BYCASE','BYSIZE1000') NOT NULL,
  `PricePerUnit` double NOT NULL DEFAULT '0',
  `PricePer1000Unit` double NOT NULL DEFAULT '0',
  `MinimumPrice` double NOT NULL DEFAULT '0',
  `PricePerCase` double NOT NULL DEFAULT '0',
  `PricePerCondo` double NOT NULL DEFAULT '0',
  `PricePerHouse` double NOT NULL DEFAULT '0',
  `PricePerSemi` double NOT NULL DEFAULT '0',
  `PricePerTownhouse` double NOT NULL DEFAULT '0',
  `FirstContactName` varchar(255) NOT NULL,
  `FirstContactNumber` varchar(255) NOT NULL,
  `SecondContactName` varchar(255) NOT NULL,
  `SecondContactNumber` varchar(255) NOT NULL,
  `SupportLocation` varchar(255) NOT NULL,
  `HSTNumber` varchar(255) NOT NULL,
  `PaymentTerm` enum('MONTHLY','SEMIMONTHLY','OTHER') NOT NULL,
  `OtherPaymentTerm` varchar(255) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '1',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `SupplierType`, `PriceUnit`, `PricePerUnit`, `PricePer1000Unit`, `MinimumPrice`, `PricePerCase`, `PricePerCondo`, `PricePerHouse`, `PricePerSemi`, `PricePerTownhouse`, `FirstContactName`, `FirstContactNumber`, `SecondContactName`, `SecondContactNumber`, `SupportLocation`, `HSTNumber`, `PaymentTerm`, `OtherPaymentTerm`, `FilePath`, `IsActivate`, `isDefault`) VALUES
(1, 'Default Staging', 'STAGING', 'BYSIZE', 0.7, 0, 1000, 0, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(2, 'Default Photography', 'PHOTOGRAPHY', 'BYHOUSETYPE', 0, 0, 0, 0, 1100, 1800, 1500, 1300, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(3, 'Default Clean Up', 'CLEANUP', 'BYSIZE1000', 0, 0.7, 900, 0, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(4, 'Default Relocate Home', 'RELOCATEHOME', 'BYCASE', 0, 0, 0, 950, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(5, 'Default Touch Up', 'TOUCHUP', 'BYCASE', 0, 0, 0, 1250, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(6, 'Default Inspection', 'INSPECTION', 'BYHOUSETYPE', 0, 0, 0, 0, 700, 1600, 1400, 1000, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(7, 'Default Yard Work', 'YARDWORK', 'BYCASE', 1, 0, 0, 1450, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(8, 'Default Stroage', 'STORAGE', 'BYCASE', 0, 0, 0, 800, 0, 0, 0, 0, '', '', '', '', '', '', 'MONTHLY', '', '', 1, 1),
(9, 'jhgf', 'STAGING', 'BYSIZE', 1, 0, 1000, 0, 0, 0, 0, 0, 'nbv', '65', 'fdn', '53', 'fghj', '965', 'SEMIMONTHLY', '', '', 1, 0),
(10, 'dfghj', 'STAGING', 'BYSIZE', 7452, 0, 0, 0, 0, 0, 0, 0, 'fghjk', '96521', 'ghnm', '952', 'ghj', '751', 'MONTHLY', '', '', 1, 0),
(11, 'dfg', 'STAGING', 'BYSIZE', 456, 0, 0, 0, 0, 0, 0, 0, 'fgh', '6789', 'gh', '2345', 'dfg', '456', 'MONTHLY', '', '', 1, 0),
(73, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, '', '0', '', '0', '', '0', '', '', 'wp-content/themes/NuStream/Upload/Supplier/73/', 1, 0),
(74, 'Lghjk', 'TOUCHUP', 'BYHOUR', 85, 0, 0, 0, 0, 0, 0, 0, 'ghj', '52', 'nhjk', '4', '', '54521456', 'SEMIMONTHLY', '', '', 1, 0),
(75, 'sdfg', 'INSPECTION', 'BYCASE', 52, 0, 0, 0, 0, 0, 0, 0, 'sdfg', '85', 'Sdf', '52', '', '85', 'OTHER', 'cvg', '', 1, 0),
(76, 'sdf', 'STAGING', 'BYSIZE', 6, 0, 0, 0, 0, 0, 0, 0, 'bv', '632', 'bvc', '32', '', '5663', 'MONTHLY', '', '', 1, 0);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`),
  ADD UNIQUE KEY `ServiceID` (`ServiceID`);

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
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
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
