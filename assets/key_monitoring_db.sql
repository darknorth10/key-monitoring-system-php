-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 12:26 AM
-- Server version: 8.0.25
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
CREATE DATABASE IF NOT EXISTS `key_monitoring_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs;
USE `key_monitoring_db`;

-- --------------------------------------------------------

--
-- Table structure for table `audit_tbl`
--

CREATE TABLE `audit_tbl` (
  `audit_id` int NOT NULL,
  `user` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `action` varchar(120) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `date_occured` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `audit_tbl`
--

INSERT INTO `audit_tbl` (`audit_id`, `user`, `action`, `date_occured`) VALUES
(1, 'admin', 'admin has logged in.', '2023-04-18 21:50:12'),
(2, 'admin', 'A Room has been added', '2023-04-18 21:50:44'),
(3, 'admin', 'Room 403 has been updated', '2023-04-18 21:50:51'),
(4, 'admin', 'Room 403 has been updated', '2023-04-18 21:50:55'),
(5, 'admin', 'A user has been added', '2023-04-18 21:51:28'),
(6, 'admin', 'A user has been added', '2023-04-18 21:52:16'),
(7, 'admin', 'Room 112 has been borrowed by borrower T2021-123.', '2023-04-18 21:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `borrowers_tbl`
--

CREATE TABLE `borrowers_tbl` (
  `stud_employee_no` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `firstname` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `lastname` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `course` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `eligibility` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `borrowers_tbl`
--

INSERT INTO `borrowers_tbl` (`stud_employee_no`, `firstname`, `lastname`, `course`, `eligibility`) VALUES
('B132-3102', 'Creek', 'sas', 'BSBA - MM', 'eligible'),
('B132-34', 'Johnnye', 'Doeee', 'BSBA - FM', 'eligible'),
('B132-34689', 'Johnny', 'Weiz', 'BSBA - MM', 'eligible'),
('B2020-09123', 'John', 'Heare', 'BSBA - MM', 'ineligible'),
('T2010-2134', 'Johnny', 'Heist', 'BSIS', 'eligible'),
('T2021-123', 'Jane', 'Doe', 'BSA', 'ineligible');

-- --------------------------------------------------------

--
-- Table structure for table `course_tbl`
--

CREATE TABLE `course_tbl` (
  `course_id` int NOT NULL,
  `course` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL
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
-- Table structure for table `non_faculty_borrower`
--

CREATE TABLE `non_faculty_borrower` (
  `ID` varchar(20) COLLATE latin1_general_cs NOT NULL,
  `firstname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `lastname` varchar(45) COLLATE latin1_general_cs NOT NULL,
  `borrower_type` varchar(25) COLLATE latin1_general_cs NOT NULL,
  `course` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `year_sectiom` varchar(10) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `room_tbl`
--

CREATE TABLE `room_tbl` (
  `room_no` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `room_category` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `floor` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `room_status` varchar(35) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `room_tbl`
--

INSERT INTO `room_tbl` (`room_no`, `room_category`, `floor`, `room_status`) VALUES
('112', 'Laboratory', '1st', 'Unavailable'),
('211', 'Laboratory', '2nd', 'Available'),
('333', 'Laboratory', '3rd', 'Unavailable'),
('114', 'Laboratory', '1st', 'Available'),
('222', 'Lecture', '2nd', 'Available'),
('311', 'Lecture', '3rd', 'Available'),
('217', 'Laboratory', '2nd', 'Available'),
('123', 'Lecture', '1st', 'Available'),
('345', 'Lecture', '3rd', 'Unavailable'),
('403', 'Lecture', '4th', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_tbl`
--

CREATE TABLE `transaction_tbl` (
  `transaction_no` int NOT NULL,
  `borrowers_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `room_no` varchar(35) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `date_time_barrowed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_time_returned` datetime DEFAULT NULL,
  `transaction_status` varchar(35) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `non_faculty` varchar(10) COLLATE latin1_general_cs DEFAULT 'false',
  `fullname` varchar(45) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `transaction_tbl`
--

INSERT INTO `transaction_tbl` (`transaction_no`, `borrowers_id`, `room_no`, `date_time_barrowed`, `date_time_returned`, `transaction_status`, `non_faculty`, `fullname`) VALUES
(1, 'T2021-123', '112', '2023-04-18 21:53:01', NULL, 'borrowed', 'false', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int NOT NULL,
  `first_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `last_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `user_type` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `status` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `student_teacher_id` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `student_teacher_id`) VALUES
(1, 'John', 'Doe', 'admin', 'admin', 'admin', 'active', NULL),
(14, 'Staff', 'Staff', 'staff', '123', 'staff', 'active', 'S123-123'),
(15, 'admin2', 'admin2', 'admin2', '123', 'admin', 'active', 'T2023-1324');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_tbl`
--
ALTER TABLE `audit_tbl`
  ADD PRIMARY KEY (`audit_id`);

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
-- Indexes for table `non_faculty_borrower`
--
ALTER TABLE `non_faculty_borrower`
  ADD PRIMARY KEY (`ID`);

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
-- AUTO_INCREMENT for table `audit_tbl`
--
ALTER TABLE `audit_tbl`
  MODIFY `audit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_tbl`
--
ALTER TABLE `course_tbl`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction_tbl`
--
ALTER TABLE `transaction_tbl`
  MODIFY `transaction_no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
