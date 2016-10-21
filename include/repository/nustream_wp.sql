-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2016 at 09:20 PM
-- Server version: 5.6.30-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nustream_wp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `AccountID` int(11) NOT NULL AUTO_INCREMENT,
  `Password` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `TeamID` varchar(255) NOT NULL,
  `AccountPosition` enum('ADMIN','AGENT','ACCOUNTANT','SUPERUSER') NOT NULL,
  `ContactNumber` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `IsTeamLeader` tinyint(1) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`AccountID`),
  UNIQUE KEY `AccountID` (`AccountID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountID`, `Password`, `FirstName`, `LastName`, `TeamID`, `AccountPosition`, `ContactNumber`, `Email`, `IsTeamLeader`, `IsActivate`) VALUES
(1, '8cfa204204895ba965dc0baf48a1d8a5', 'Darren', 'Liu', '7', 'AGENT', '7536890', 'dfg@sdf.com', 0, 1),
(2, '', 'Kevin', 'Guo', '7', 'AGENT', '96521', 'rtg@dcfvh.com', 1, 1),
(3, '', 'Peter', 'Ray', '0', 'AGENT', '85', 'dfg@rgh.com', 0, 1),
(41, '827ccb0eea8a706c4c34a16891f84e7b', 'Shuyang', 'Liu', '7', 'ADMIN', '16478953986', 'gulang15b@gmail.com', 0, 1),
(57, '827ccb0eea8a706c4c34a16891f84e7b', 'Darren', 'Liu', '19', 'AGENT', '6478953986', 'gulang15a@gmail.com', 1, 1),
(58, '827ccb0eea8a706c4c34a16891f84e7b', 'John', 'Rai', '19', 'ACCOUNTANT', '6478953986', 'gulang15@gmail.com', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE IF NOT EXISTS `cases` (
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
  `FinalPrice` double NOT NULL,
  `CommissionRate` double NOT NULL,
  `Images` varchar(255) NOT NULL,
  `StagingID` int(11) NOT NULL,
  `TouchUpID` int(11) NOT NULL,
  `CleanUpID` int(11) NOT NULL,
  `YardWorkID` int(11) NOT NULL,
  `InspectionID` int(11) NOT NULL,
  `StorageID` int(11) NOT NULL,
  `RelocateHomeID` int(11) NOT NULL,
  `PhotographyID` int(11) NOT NULL,
  PRIMARY KEY (`MLS`),
  UNIQUE KEY `MLS` (`MLS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`MLS`, `StaffID`, `CoStaffID`, `Address`, `LandSize`, `HouseSize`, `PropertyType`, `ListingPrice`, `OwnerName`, `ContactNumber`, `StartDate`, `CaseStatus`, `FinalPrice`, `CommissionRate`, `Images`, `StagingID`, `TouchUpID`, `CleanUpID`, `YardWorkID`, `InspectionID`, `StorageID`, `RelocateHomeID`, `PhotographyID`) VALUES
('2345', 57, 57, 'sdfgh', 2345, 2345, 'CONDO', 2345, 'dfgv', '3456', '2016-10-17 04:53:27', 'OPEN', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0),
('456', 57, 57, 'fg', 456, 456, 'CONDO', 345, 'fgh', '645', '2016-10-13 02:47:29', 'OPEN', 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0),
('6543', 57, 3, 'dfg', 765, 3456, 'CONDO', 545600, 'sdf', '654', '2016-10-21 03:00:06', 'OPEN', 2450, 2.2, '', 82, 86, 84, 88, 87, 89, 85, 83);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `FilePath` varchar(255) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileStatus` enum('New','Pending','Approved') NOT NULL,
  UNIQUE KEY `FileName` (`FileName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FilePath`, `FileName`, `FileStatus`) VALUES
('/wp-content/themes/NuStream/Upload/case/6543/Staging/Before/LivingRoom/', '/wp-content/themes/NuStream/Upload/case/6543/Staging/Before/LivingRoom/14770144785.JPG', 'New'),
('/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/', '/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/14770144218.png', 'New'),
('/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/', '/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/14770146358.png', 'New'),
('/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/', '/wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/14770146548.png', 'New'),
('/wp-content/themes/NuStream/Upload/case6543/Staging/Invoice/', '/wp-content/themes/NuStream/Upload/case6543/Staging/Invoice/14770145198.png', 'New'),
('wp-content/themes/NuStream/Upload/case/6543/Staging/Before/LivingRoom/', 'wp-content/themes/NuStream/Upload/case/6543/Staging/Before/LivingRoom/14770163325.JPG', 'New'),
('wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/', 'wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/14770148138.png', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `ServiceID` int(11) NOT NULL AUTO_INCREMENT,
  `ServiceSupplierID` int(11) NOT NULL,
  `SupplierType` enum('STAGING','PHOTOGRAPHY','CLEANUP','RELOCATEHOME','TOUCHUP','INSPECTION','YARDWORK','STORAGE') NOT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RealCost` double NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `InvoiceStatus` enum('NEW','PENDING','APPROVED') NOT NULL,
  `InvoicePath` varchar(255) NOT NULL,
  `ImagePath` varchar(255) NOT NULL,
  `IsActivate` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ServiceID`),
  UNIQUE KEY `ServiceID` (`ServiceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceSupplierID`, `SupplierType`, `StartDate`, `RealCost`, `InvoiceID`, `InvoiceStatus`, `InvoicePath`, `ImagePath`, `IsActivate`) VALUES
(82, 10, 'STAGING', '0000-00-00 00:00:00', 1200, 0, 'NEW', 'wp-content/themes/NuStream/Upload/case/6543/Staging/Invoice/', 'wp-content/themes/NuStream/Upload/case/6543/Staging/', 1),
(83, 0, 'PHOTOGRAPHY', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(84, 0, 'CLEANUP', '0000-00-00 00:00:00', 0, 0, 'NEW', 'wp-content/themes/NuStream/Upload/case/6543/CleanUp/Invoice/', 'wp-content/themes/NuStream/Upload/case/6543/CleanUp/', 0),
(85, 0, 'RELOCATEHOME', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(86, 5, 'TOUCHUP', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 1),
(87, 0, 'INSPECTION', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(88, 0, 'YARDWORK', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0),
(89, 0, 'STORAGE', '0000-00-00 00:00:00', 0, 0, 'NEW', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
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
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SupplierID`),
  UNIQUE KEY `SupplierID` (`SupplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

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

CREATE TABLE IF NOT EXISTS `teams` (
  `TeamID` int(11) NOT NULL AUTO_INCREMENT,
  `TeamLeaderID` int(11) NOT NULL,
  `TeamLeaderName` varchar(255) NOT NULL,
  PRIMARY KEY (`TeamID`),
  UNIQUE KEY `TeamID` (`TeamID`),
  UNIQUE KEY `TeamLeaderID` (`TeamLeaderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`TeamID`, `TeamLeaderID`, `TeamLeaderName`) VALUES
(7, 2, 'Kevin Guo'),
(17, 54, 'Shuyang Liu'),
(18, 56, 'Shuyang Liu'),
(19, 57, 'Darren Liu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
