-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 08:32 AM
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
-- Database: `interviewsupportsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `A_ID` varchar(150) NOT NULL,
  `I_Email` varchar(150) NOT NULL,
  `A_Description` varchar(150) NOT NULL,
  `A_Link` varchar(100) NOT NULL,
  `Deadline` datetime NOT NULL,
  `Job_Title` varchar(100) NOT NULL,
  `Qualifications` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`A_ID`),
  KEY `I_Email` (`I_Email`),
  CONSTRAINT `advertisement_ibfk_1` FOREIGN KEY (`I_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `C_Email` varchar(150) NOT NULL,
  `C_password` varchar(50) NOT NULL,
  `Mobile_No` int(11) NOT NULL,
  `NIC_No` varchar(15) NOT NULL,
  `Civil_Status` varchar(10) NOT NULL,
  `DOB` datetime NOT NULL,
  `District` varchar(50) NOT NULL,
  `Reason` varchar(150) NOT NULL,
  `status` tinyint(1) DEFAULT NULL, -- Changed from single quotes to backticks
  `reset_token` varchar(255) NULL,
  PRIMARY KEY (`C_Email`),
  CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`C_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interviewer`
--

CREATE TABLE `interviewer` (
  `I_Email` varchar(150) NOT NULL,
  `I_password` varchar(150) NOT NULL,
  `status` tinyint(1) DEFAULT NULL, -- Changed from single quotes to backticks
  `reset_token` varchar(255) NULL,
  PRIMARY KEY (`I_Email`),
  CONSTRAINT `interviewer_ibfk_1` FOREIGN KEY (`I_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `I_Email` varchar(150) NOT NULL,
  `Process_Date` datetime NOT NULL,
  `Process_Time` datetime NOT NULL,
  KEY `I_Email` (`I_Email`),
  CONSTRAINT `process_ibfk_1` FOREIGN KEY (`I_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `Resume_ID` varchar(150) NOT NULL,
  `C_Email` varchar(150) NOT NULL,
  `Job_Title` varchar(100) NOT NULL,
  `R_Link` blob DEFAULT NULL,
  `Flag` int(11) DEFAULT NULL,
  `Structured_Resume` blob DEFAULT NULL,
  `Ip_Score` int(11) DEFAULT NULL,
  `Ego_Score` int(11) DEFAULT NULL,
  `Questions` blob DEFAULT NULL,
  PRIMARY KEY (`Resume_ID`),
  KEY `C_Email` (`C_Email`),
  CONSTRAINT `resumes_ibfk_1` FOREIGN KEY (`C_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `C_Email` varchar(150) NOT NULL,
  `Upload_Date` datetime NOT NULL,
  `Upload_Time` datetime NOT NULL,
  KEY `C_Email` (`C_Email`),
  CONSTRAINT `upload_ibfk_1` FOREIGN KEY (`C_Email`) REFERENCES `user` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Email` varchar(150) NOT NULL,
  `First_Name` varchar(150) NOT NULL,
  `Last_Name` varchar(150) NOT NULL,
  `status` tinyint(1) DEFAULT NULL, -- Changed from single quotes to backticks
  `reset_token` varchar(255) NULL,
