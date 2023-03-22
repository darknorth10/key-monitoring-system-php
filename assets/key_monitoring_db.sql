-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2023 at 12:41 AM
-- Server version: 5.7.40-log
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `key_monitoring_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barrowers_tbl`
--

CREATE TABLE `barrowers_tbl` (
  `barrower_id` int(4) NOT NULL,
  `stud_employee_no` varchar(15) COLLATE latin1_general_cs NOT NULL,
  `firstname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `lastname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `barrowers_type` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `course` varchar(45) COLLATE latin1_general_cs DEFAULT NULL,
  `section` varchar(45) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `room_tbl`
--

CREATE TABLE `room_tbl` (
  `room_id` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `room_category` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `floor` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `room_status` varchar(35) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `transaction_id` int(4) NOT NULL,
  `barrowers_id` int(5) NOT NULL,
  `fullname` varchar(125) COLLATE latin1_general_cs NOT NULL,
  `barrowers_type` varchar(35) COLLATE latin1_general_cs NOT NULL,
  `room_no` varchar(35) COLLATE latin1_general_cs NOT NULL,
  `date_time_barrowed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_time_returned` datetime DEFAULT NULL,
  `transaction_status` varchar(35) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(3) NOT NULL,
  `first_name` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `last_name` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `username` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `user_type` varchar(30) COLLATE latin1_general_cs NOT NULL,
  `status` varchar(15) COLLATE latin1_general_cs NOT NULL,
  `student_id` varchar(15) COLLATE latin1_general_cs DEFAULT NULL,
  `teacher_id` varchar(15) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `student_id`, `teacher_id`) VALUES
(1, 'John', 'Doe', 'admin', 'admin', 'admin', 'active', NULL, 'B123-123'),
(4, 'Jane', 'Doe', 'user1', 'tempopass123', 'student assistant', 'active', 'G123-123', NULL),
(5, 'Wilm', 'Head', 'user2', 'tempopass123', 'admin', 'active', 'B132-32', 'B132-32'),
(6, 'Creek', 'Pooge', 'user3', 'asd', 'student assistant', 'active', 'B132-38', 'B132-38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barrowers_tbl`
--
ALTER TABLE `barrowers_tbl`
  ADD PRIMARY KEY (`barrower_id`);

--
-- Indexes for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barrowers_tbl`
--
ALTER TABLE `barrowers_tbl`
  MODIFY `barrower_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `transaction_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
