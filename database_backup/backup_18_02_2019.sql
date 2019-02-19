-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 18, 2019 at 05:05 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gis for waste management system`
--
CREATE DATABASE IF NOT EXISTS `gis for waste management system` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gis for waste management system`;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `Surname` varchar(120) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collectorslogin`
--

DROP TABLE IF EXISTS `collectorslogin`;
CREATE TABLE IF NOT EXISTS `collectorslogin` (
  `CollectorsID` varchar(100) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commercial`
--

DROP TABLE IF EXISTS `commercial`;
CREATE TABLE IF NOT EXISTS `commercial` (
  `RegNo` varchar(100) NOT NULL,
  `TAN` int(10) DEFAULT NULL,
  `Name` varchar(150) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `PhoneNumber` int(8) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT '0',
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

DROP TABLE IF EXISTS `contractors`;
CREATE TABLE IF NOT EXISTS `contractors` (
  `RegNo` varchar(100) NOT NULL,
  `TAN` int(10) DEFAULT NULL,
  `Name` varchar(150) DEFAULT NULL,
  `CompanyName` varchar(200) DEFAULT NULL,
  `Type` varchar(18) DEFAULT NULL,
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Phone` int(12) DEFAULT NULL,
  PRIMARY KEY (`RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `districtcouncil`
--

DROP TABLE IF EXISTS `districtcouncil`;
CREATE TABLE IF NOT EXISTS `districtcouncil` (
  `DCID` varchar(100) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`DCID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `districtcouncil`
--

INSERT INTO `districtcouncil` (`DCID`, `Name`, `Address`, `LocationCoordinate`) VALUES
('DCOF', 'Flacq District Council', 'FLACQ', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `EmployeeNumber` varchar(100) NOT NULL,
  `EmployeeFirstName` varchar(180) NOT NULL,
  `EmployeeLastName` varchar(180) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`EmployeeNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeNumber`, `EmployeeFirstName`, `EmployeeLastName`, `Password`) VALUES
('admin-1996', 'kailash', 'chooramun', 'test'),
('admin-2-1996', 'rouwaidah', 'abdoolsamee', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `generatorslogin`
--

DROP TABLE IF EXISTS `generatorslogin`;
CREATE TABLE IF NOT EXISTS `generatorslogin` (
  `GeneratorID` varchar(100) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Category` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `generatorslogin`
--

INSERT INTO `generatorslogin` (`GeneratorID`, `Password`, `Category`) VALUES
('c011196', '62e4c14eec059e894561a115d027584f4daeded5', 'resident'),
('r290596', '9b915eb1e05dcccf7a973c353fc79237c12c84e1', 'resident'),
('t0000', '86ac2432203ee42346a0bacd58c757766a051c1a', 'resident'),
('t20000', '86ac2432203ee42346a0bacd58c757766a051c1a', 'resident');

-- --------------------------------------------------------

--
-- Table structure for table `industrial`
--

DROP TABLE IF EXISTS `industrial`;
CREATE TABLE IF NOT EXISTS `industrial` (
  `RegNo` varchar(100) NOT NULL,
  `TAN` int(10) DEFAULT NULL,
  `Name` varchar(150) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT '0',
  `Phone` int(12) DEFAULT NULL,
  PRIMARY KEY (`RegNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `municipality`
--

DROP TABLE IF EXISTS `municipality`;
CREATE TABLE IF NOT EXISTS `municipality` (
  `MID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scavenger`
--

DROP TABLE IF EXISTS `scavenger`;
CREATE TABLE IF NOT EXISTS `scavenger` (
  `ScavengerID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `Surname` varchar(200) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `Team` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ScavengerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region`
--

DROP TABLE IF EXISTS `tbl_region`;
CREATE TABLE IF NOT EXISTS `tbl_region` (
  `regionID` int(11) NOT NULL AUTO_INCREMENT,
  `coordinates` varchar(4000) DEFAULT NULL,
  `regionName` varchar(200) DEFAULT NULL,
  `CollectorsID` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`regionID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_region`
--

INSERT INTO `tbl_region` (`regionID`, `coordinates`, `regionName`, `CollectorsID`) VALUES
(1, '[[-20.110102423009007,57.74208068847657],[-20.15200771738265,57.64526367187501],[-20.164899392816174,57.63015747070313],[-20.205501205844214,57.66448974609376],[-20.233207476797766,57.630844116210945],[-20.27057090367651,57.67135620117188],[-20.325955283210043,57.65350341796876],[-20.323379704799503,57.685089111328125],[-20.331106311366867,57.710494995117195],[-20.322735803496375,57.73590087890626],[-20.308569296896167,57.757186889648445],[-20.31114512181744,57.779159545898445],[-20.29633354334086,57.77297973632813],[-20.280876473273572,57.77503967285157],[-20.291181357943515,57.784652709960945],[-20.277011964924107,57.78945922851563],[-20.262197124246534,57.79632568359376],[-20.248669295425177,57.79357910156251],[-20.238361587286963,57.78259277343751],[-20.233207476797766,57.80319213867188],[-20.19454620322373,57.77229309082032],[-20.168122145270342,57.76954650878906],[-20.166188501786795,57.74757385253907],[-20.1571645153353,57.73315429687501],[-20.146206116089946,57.74002075195313],[-20.130734125783057,57.751693725585945]]', 'Flacq', 'DCOF');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_residents`
--

DROP TABLE IF EXISTS `tbl_residents`;
CREATE TABLE IF NOT EXISTS `tbl_residents` (
  `NIC` varchar(20) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Tan` varchar(20) DEFAULT '',
  `Address` varchar(200) NOT NULL,
  `PhoneNumber` int(15) NOT NULL,
  `LocationCoordinate` varchar(150) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '0',
  `country` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `zoneID` int(11) DEFAULT NULL,
  PRIMARY KEY (`NIC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_residents`
--

INSERT INTO `tbl_residents` (`NIC`, `Name`, `Tan`, `Address`, `PhoneNumber`, `LocationCoordinate`, `Email`, `Active`, `country`, `region`, `zoneID`) VALUES
('c011196', 'chooramun kailash', '', 'St Remy, Ave Des Rosiers', 57956377, '-20.19096149460747,57.71931409835816', 'kailash_chooramun@hotmail.com', 1, 'mauritius', 'central flacq', NULL),
('r290596', 'rouwaidah abdoolsamee', '', 'st ursule, seeraully road flacq', 51234567, '-20.199839999999938,57.71706000000006', 'rouwaidah.abdoolsamee@gmail.com', 1, 'mauritius', 'central flacq', NULL),
('t0000', 'test point', '', 'nouvelle decouverte', 52325648, '-20.187819772046257,57.58878707885742', 'test@point.com', 1, 'mauritius', 'nouvelle devouverte', NULL),
('t20000', 'test two', '', 'St Remy, Ave Des Rosiers', 52365214, '-20.190840660295738,57.7193570137024', 'test2@second.com', 1, 'mauritius', 'central flacq', NULL),
('afe454', 'aefe8', '', 'St Remy, Ave Des Rosiers', 874556, '-20.20797805732157,57.75326013565064', 'hello@dlrw.com', 0, 'Mauritius', 'Flacq', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_waste_gen`
--

DROP TABLE IF EXISTS `tbl_waste_gen`;
CREATE TABLE IF NOT EXISTS `tbl_waste_gen` (
  `wgID` int(11) NOT NULL AUTO_INCREMENT,
  `Domestic` int(11) DEFAULT '0',
  `Plastic` int(11) DEFAULT '0',
  `Paper` int(11) DEFAULT '0',
  `Other` int(11) DEFAULT '0',
  `getDate` date DEFAULT NULL,
  `getTime` time DEFAULT NULL,
  `generatorID` varchar(20) DEFAULT NULL,
  `DomesticCollection` varchar(100) DEFAULT 'pending',
  `PlasticCollection` varchar(100) DEFAULT 'pending',
  `PaperCollection` varchar(100) DEFAULT 'pending',
  `OtherCollection` varchar(100) DEFAULT 'pending',
  PRIMARY KEY (`wgID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_waste_gen`
--

INSERT INTO `tbl_waste_gen` (`wgID`, `Domestic`, `Plastic`, `Paper`, `Other`, `getDate`, `getTime`, `generatorID`, `DomesticCollection`, `PlasticCollection`, `PaperCollection`, `OtherCollection`) VALUES
(8, 2, 0, 0, 0, '2019-02-16', '06:54:18', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(9, 4, 0, 0, 0, '2019-02-16', '07:45:31', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(10, 20, 0, 0, 0, '2019-02-16', '07:52:40', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(11, 10, 0, 0, 0, '2019-02-16', '09:02:11', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(12, 20, 0, 0, 0, '2019-02-16', '09:16:07', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(13, 15, 0, 0, 0, '2019-02-16', '09:16:12', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(14, 10, 0, 0, 0, '2019-02-16', '09:30:52', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(15, 50, 0, 0, 0, '2019-02-16', '09:35:01', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(16, 60, 0, 0, 0, '2019-02-16', '09:48:34', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(17, 60, 5, 15, 10, '2019-02-16', '10:03:39', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(18, 60, 10, 0, 0, '2019-02-16', '10:06:32', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(19, 60, 10, 10, 0, '2019-02-16', '10:08:01', 'c011196', 'pending', 'pending', 'pending', 'pending'),
(20, 60, 10, 10, 10, '2019-02-16', '10:09:20', 'c011196', 'pending', 'pending', 'pending', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zones`
--

DROP TABLE IF EXISTS `tbl_zones`;
CREATE TABLE IF NOT EXISTS `tbl_zones` (
  `zoneID` int(11) NOT NULL AUTO_INCREMENT,
  `coordinates` varchar(4000) DEFAULT NULL,
  `regionID` int(11) DEFAULT NULL,
  PRIMARY KEY (`zoneID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_zones`
--

INSERT INTO `tbl_zones` (`zoneID`, `coordinates`, `regionID`) VALUES
(1, '[[-20.165785656378,57.643804550171],[-20.160387427544,57.661056518555],[-20.168847255397,57.6771068573],[-20.190679547734,57.676677703857],[-20.201151517643,57.67650604248],[-20.200426557796,57.667150497437],[-20.186973912841,57.656335830688]]', 1),
(2, '[[-20.151604835369,57.673845291138],[-20.161837716324,57.686719894409],[-20.154424987633,57.699165344238],[-20.143708138045,57.700281143188],[-20.138953811401,57.68440246582]]', 1),
(3, '[[-20.136616885948,57.710666656494],[-20.152249446092,57.718992233276],[-20.143224653809,57.736930847168],[-20.132587622057,57.727060317993]]', 1),
(4, '[[-20.165543948633,57.724571228027],[-20.186490562663,57.733669281006],[-20.179079005548,57.754783630371],[-20.163771413729,57.741565704346]]', 1),
(5, '[[-20.185040503133,57.701053619385],[-20.222415504502,57.702255249023],[-20.229986070955,57.730407714844],[-20.209206399939,57.745513916016],[-20.195673959663,57.74808883667],[-20.188101724094,57.729034423828],[-20.176662117256,57.720794677734]]', 1),
(6, '[[-20.216777609241,57.669296264648],[-20.217421950469,57.688694000244],[-20.199218283884,57.695388793945],[-20.202923627505,57.665176391602]]', 1),
(7, '[[-20.211622783354,57.749118804932],[-20.195190636474,57.750148773193],[-20.192451776747,57.766628265381],[-20.219838206308,57.785511016846],[-20.232402131595,57.777442932129],[-20.248991400284,57.759075164795],[-20.234334953072,57.734355926514]]', 1),
(8, '[[-20.211783874247,57.663803100586],[-20.221932264344,57.666893005371],[-20.222737663774,57.694702148438],[-20.258815277547,57.700710296631],[-20.261552968651,57.672901153564],[-20.250440863882,57.661743164063],[-20.252051363126,57.652645111084],[-20.233851749956,57.634620666504],[-20.227408898222,57.638740539551],[-20.210817326384,57.658824920654]]', 1),
(9, '[[-20.231274641303,57.698822021484],[-20.261875046783,57.703971862793],[-20.252212412131,57.754440307617],[-20.231918922471,57.721481323242]]', 1),
(10, '[[-20.169088958024,57.681312561035],[-20.198734971695,57.679252624512],[-20.195835067059,57.698135375977],[-20.182945948881,57.698822021484],[-20.172311623923,57.724571228027],[-20.163287991625,57.722511291504],[-20.161676573792,57.734870910645],[-20.156197628695,57.729377746582],[-20.148462319983,57.736930847168],[-20.153619235042,57.721481323242],[-20.154263837448,57.71427154541],[-20.141693610523,57.710838317871],[-20.143305234619,57.702255249023],[-20.153941536577,57.701225280762]]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

DROP TABLE IF EXISTS `trucks`;
CREATE TABLE IF NOT EXISTS `trucks` (
  `PlateNumber` varchar(18) NOT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  `OwnerID` varchar(100) DEFAULT NULL,
  `FuelConsumption` int(5) DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `Team` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`PlateNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wastes`
--

DROP TABLE IF EXISTS `wastes`;
CREATE TABLE IF NOT EXISTS `wastes` (
  `WasteGenID` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`WasteGenID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wastes`
--

INSERT INTO `wastes` (`WasteGenID`, `level`) VALUES
(19, 80),
(20, 20),
(21, 40),
(22, 233),
(23, 13),
(24, 80),
(25, 33);

-- --------------------------------------------------------

--
-- Table structure for table `waste_collect`
--

DROP TABLE IF EXISTS `waste_collect`;
CREATE TABLE IF NOT EXISTS `waste_collect` (
  `WCID` int(11) NOT NULL AUTO_INCREMENT,
  `CollectorsID` int(11) NOT NULL,
  `TypeOfWaste` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`WCID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
