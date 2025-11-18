-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 08:29 AM
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
-- Database: `ezbudgets`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_fringe_rates`
--

CREATE TABLE `employee_fringe_rates` (
  `staff_id` int(11) NOT NULL,
  `staff_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fa_rate`
--

CREATE TABLE `fa_rate` (
  `year` year(4) NOT NULL,
  `fa_rate` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fringe_rate`
--

CREATE TABLE `fringe_rate` (
  `staff_title` varchar(50) NOT NULL,
  `fringe_rate` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fringe_rate`
--

INSERT INTO `fringe_rate` (`staff_title`, `fringe_rate`) VALUES
('Admin Staff', 25.75),
('Faculty', 28.50),
('Grad Student', 15.00),
('Post Doc', 30.10),
('Research Staff', 32.00);

-- --------------------------------------------------------

--
-- Table structure for table `semesters_attended`
--

CREATE TABLE `semesters_attended` (
  `student_id` int(11) NOT NULL,
  `semester_year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester_tuition`
--

CREATE TABLE `semester_tuition` (
  `semester_year` varchar(20) NOT NULL,
  `tuition_increase_projection` decimal(5,2) DEFAULT NULL,
  `in_state_tuition` decimal(10,2) DEFAULT NULL,
  `out_of_state_tuition` decimal(10,2) DEFAULT NULL,
  `fees` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `degree` varchar(50) DEFAULT NULL,
  `max_fte` decimal(4,2) NOT NULL,
  `stipend_per_year` decimal(10,2) DEFAULT NULL,
  `residency` enum('In-State','Out-of-State') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `travel_profile`
--

CREATE TABLE `travel_profile` (
  `travel_type` varchar(50) NOT NULL,
  `airfare` decimal(10,2) NOT NULL,
  `max_lodging_days` int(11) NOT NULL,
  `per_diem` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university_employee`
--

CREATE TABLE `university_employee` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `job` varchar(100) DEFAULT NULL,
  `staff_title` varchar(50) DEFAULT NULL,
  `is_pi_eligible` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_employee`
--

INSERT INTO `university_employee` (`staff_id`, `name`, `hourly_rate`, `job`, `staff_title`, `is_pi_eligible`) VALUES
(1, 'Dr. Evelyn Reed', 120.50, 'Professor of Physics', 'Faculty', 1),
(2, 'Dr. Aris Thorne', 45.20, 'Postdoctoral Researcher', 'Post Doc', 0),
(3, 'Marcus Cole', 75.00, 'Lab Manager', 'Research Staff', 0),
(4, 'Jenna Ortega', 28.75, 'Department Coordinator', 'Admin Staff', 0),
(5, 'Samuel Chen', 52.00, 'Data Scientist', 'Research Staff', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_fringe_rates`
--
ALTER TABLE `employee_fringe_rates`
  ADD PRIMARY KEY (`staff_id`,`staff_title`),
  ADD KEY `staff_title` (`staff_title`);

--
-- Indexes for table `fa_rate`
--
ALTER TABLE `fa_rate`
  ADD PRIMARY KEY (`year`);

--
-- Indexes for table `fringe_rate`
--
ALTER TABLE `fringe_rate`
  ADD PRIMARY KEY (`staff_title`);

--
-- Indexes for table `semesters_attended`
--
ALTER TABLE `semesters_attended`
  ADD PRIMARY KEY (`student_id`,`semester_year`),
  ADD KEY `semester_year` (`semester_year`);

--
-- Indexes for table `semester_tuition`
--
ALTER TABLE `semester_tuition`
  ADD PRIMARY KEY (`semester_year`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `travel_profile`
--
ALTER TABLE `travel_profile`
  ADD PRIMARY KEY (`travel_type`);

--
-- Indexes for table `university_employee`
--
ALTER TABLE `university_employee`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `staff_title` (`staff_title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `university_employee`
--
ALTER TABLE `university_employee`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_fringe_rates`
--
ALTER TABLE `employee_fringe_rates`
  ADD CONSTRAINT `employee_fringe_rates_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `university_employee` (`staff_id`),
  ADD CONSTRAINT `employee_fringe_rates_ibfk_2` FOREIGN KEY (`staff_title`) REFERENCES `fringe_rate` (`staff_title`);

--
-- Constraints for table `semesters_attended`
--
ALTER TABLE `semesters_attended`
  ADD CONSTRAINT `semesters_attended_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `semesters_attended_ibfk_2` FOREIGN KEY (`semester_year`) REFERENCES `semester_tuition` (`semester_year`);

--
-- Constraints for table `university_employee`
--
ALTER TABLE `university_employee`
  ADD CONSTRAINT `university_employee_ibfk_1` FOREIGN KEY (`staff_title`) REFERENCES `fringe_rate` (`staff_title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
