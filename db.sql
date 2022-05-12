-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2017 at 04:11 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db`
--
CREATE DATABASE IF NOT EXISTS `db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `Booking_Number` int(10) NOT NULL AUTO_INCREMENT,
  `Customer_ID` int(11) NOT NULL,
  `Passenger_Name` varchar(30) NOT NULL,
  `Passenger_Phone` varchar(15) NOT NULL,
  `Unit_Number` varchar(10) DEFAULT NULL,
  `Street_Number` varchar(10) NOT NULL,
  `Street_Name` varchar(50) DEFAULT NULL,
  `Suburb` varchar(50) NOT NULL,
  `Destination_Suburb` varchar(50) NOT NULL,
  `Pickup_Date` date NOT NULL,
  `Pickup_Time` time NOT NULL,
  `Booking_DT` datetime NOT NULL,
  `Booking_status` varchar(30) NOT NULL,
  PRIMARY KEY (`Booking_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `Customer_No` int(11) NOT NULL AUTO_INCREMENT,
  `Customer_Name` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  PRIMARY KEY (`Customer_No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_No`, `Customer_Name`, `Password`, `Email`, `Phone`) VALUES
(0, 'admin', '12345', 'admin@cabsonline.com', '9058586576');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
