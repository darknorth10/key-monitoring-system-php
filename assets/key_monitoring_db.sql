-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 01:42 AM
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
-- Table structure for table `borrowers_tbl`
--

CREATE TABLE `borrowers_tbl` (
  `stud_employee_no` varchar(15) COLLATE latin1_general_cs NOT NULL,
  `firstname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `lastname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `borrowers_type` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `course` varchar(45) COLLATE latin1_general_cs DEFAULT NULL,
  `section` varchar(45) COLLATE latin1_general_cs DEFAULT NULL,
  `eligibility` varchar(10) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `borrowers_tbl`
--

INSERT INTO `borrowers_tbl` (`stud_employee_no`, `firstname`, `lastname`, `borrowers_type`, `course`, `section`, `eligibility`) VALUES
('B132-3102', 'Creek', 'Soap', 'faculty', 'BSBA - MM', NULL, 'eligible'),
('B132-34', 'Johnnye', 'Doeee', 'faculty', 'BSBA - FM', NULL, 'eligible'),
('B132-34689', 'Johnny', 'Weiz', 'student', 'BSBA - MM', '1-1', 'eligible'),
('B2020-09123', 'John', 'Head', 'student', 'BSBA - HRM', '3-2', 'eligible'),
('T2010-2134', 'Johnny', 'Heist', 'faculty', 'BSA', NULL, 'eligible'),
('T2021-123', 'Jane', 'Doe', 'faculty', 'BSA', NULL, 'ineligible');

-- --------------------------------------------------------

--
-- Table structure for table `course_tbl`
--

CREATE TABLE `course_tbl` (
  `course_id` int(4) NOT NULL,
  `course` varchar(50) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `course_tbl`
--

INSERT INTO `course_tbl` (`course_id`, `course`) VALUES
(1, 'BSA'),
(2, 'BSIT'),
(4, 'BSIS'),
(5, 'BSBA - FM'),
(6, 'BSBA - MM'),
(7, 'BSOA'),
(8, 'BSBA - HRM');

-- --------------------------------------------------------

--
-- Table structure for table `room_tbl`
--

CREATE TABLE `room_tbl` (
  `room_no` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `room_category` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `floor` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `room_status` varchar(35) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `room_tbl`
--

INSERT INTO `room_tbl` (`room_no`, `room_category`, `floor`, `room_status`) VALUES
('112', 'Laboratory', '1st', 'Available'),
('211', 'Laboratory', '2nd', 'Available'),
('333', 'Laboratory', '3rd', 'Unavailable'),
('114', 'Laboratory', '1st', 'Available'),
('222', 'Lecture', '2nd', 'Unavailable'),
('311', 'Lecture', '3rd', 'Unavailable'),
('217', 'Laboratory', '2nd', 'Available'),
('123', 'Lecture', '1st', 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `transaction_no` int(4) NOT NULL,
  `borrowers_id` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `room_no` varchar(35) COLLATE latin1_general_cs NOT NULL,
  `date_time_barrowed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_time_returned` datetime DEFAULT NULL,
  `transaction_status` varchar(35) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `transaction_tbl`
--

INSERT INTO `transaction_tbl` (`transaction_no`, `borrowers_id`, `room_no`, `date_time_barrowed`, `date_time_returned`, `transaction_status`) VALUES
(1, 'B132-3102', '112', '2023-04-01 23:19:59', '2023-04-01 23:20:27', 'returned'),
(2, 'B132-34', '211', '2023-04-01 23:20:09', '2023-04-01 23:20:30', 'returned'),
(3, 'B2020-09123', '114', '2023-04-01 23:20:19', '2023-04-01 23:20:32', 'returned'),
(4, 'B132-3102', '112', '2023-04-01 23:23:42', '2023-04-01 23:24:10', 'returned'),
(5, 'B132-34', '211', '2023-04-01 23:23:50', '2023-04-01 23:24:14', 'returned'),
(6, 'B2020-09123', '114', '2023-04-01 23:24:02', '2023-04-01 23:24:16', 'returned'),
(7, 'B132-34', '114', '2023-04-01 23:25:33', '2023-04-01 23:25:39', 'returned'),
(8, 'B2020-09123', '217', '2023-04-01 23:26:49', '2023-04-01 23:26:59', 'returned'),
(9, 'B132-34689', '211', '2023-04-01 23:54:10', '2023-04-01 23:55:41', 'returned'),
(10, 'T2021-123', '123', '2023-04-01 23:54:51', NULL, 'borrowed');

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
  `student_teacher_id` varchar(15) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `student_teacher_id`) VALUES
(1, 'John', 'Doe', 'admin', 'admin', 'admin', 'active', NULL),
(4, 'Jane', 'Doe', 'user1', 'tempopass123', 'admin', 'active', 'G123-123'),
(5, 'Wilm', 'Head', 'user2', 'asd', 'student assistant', 'active', 'B132-32'),
(6, 'Creek', 'Pooge', 'user3', 'asd', 'student assistant', 'active', 'B132-38'),
(7, 'chicho', 'dog', 'chichodog123', '123', 'student assistant', 'active', 'H123-123'),
(8, 'asasa', 'aa', 'asaasas', '123', 'admin', 'active', 'B132-36'),
(9, 'Dome', 'sasa', 'asisstant', '123', 'admin', 'active', 'B123-12345'),
(10, 'Johnny', 'Doeeee', 'darknorth', '123', 'student assistant', 'inactive', 'B132-39'),
(11, 'asasasa', 'sample', 'greecia', '123', 'student assistant', 'active', 'B132-3856');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowers_tbl`
--
ALTER TABLE `borrowers_tbl`
  ADD PRIMARY KEY (`stud_employee_no`);

--
-- Indexes for table `course_tbl`
--
ALTER TABLE `course_tbl`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  ADD PRIMARY KEY (`transaction_no`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_tbl`
--
ALTER TABLE `course_tbl`
  MODIFY `course_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `transaction_no` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
