-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 03:06 AM
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
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `budget_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `budget_name` varchar(150) NOT NULL,
  `funding_source` varchar(150) DEFAULT NULL,
  `default_fa_year` int(11) DEFAULT NULL,
  `default_tuition_year` varchar(20) DEFAULT NULL,
  `travel_is_international` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`budget_id`, `user_id`, `budget_name`, `funding_source`, `default_fa_year`, `default_tuition_year`, `travel_is_international`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(1, 1, 'John', NULL, NULL, NULL, 0, '2025-11-18 16:10:44', '2025-11-19 14:12:31', '2025-11-19', '2030-01-12'),
(2, 1, 'Super COol Budget', NULL, NULL, NULL, 0, '2025-11-18 16:11:42', '2025-11-18 16:11:42', NULL, NULL),
(3, 5, 'Super cool', NULL, NULL, NULL, 0, '2025-11-19 12:33:30', '2025-11-19 12:33:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `budget_personnel`
--

CREATE TABLE `budget_personnel` (
  `bp_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `personnel_type` enum('PI','staff','postdoc','student') NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `percent_effort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_personnel`
--

INSERT INTO `budget_personnel` (`bp_id`, `budget_id`, `personnel_type`, `personnel_id`, `percent_effort`) VALUES
(14, 1, 'staff', 1, 5),
(15, 1, 'staff', 4, 3),
(16, 1, 'staff', 2, 10);

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
('Admin Staff', 36.70),
('Faculty', 29.50),
('Grad Student', 3.20),
('Post Doc', 36.70),
('Research Staff', 36.70),
('Undergrad Student', 3.20);

-- --------------------------------------------------------

--
-- Table structure for table `graduate_research_assistants`
--

CREATE TABLE `graduate_research_assistants` (
  `gra_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `program` varchar(100) DEFAULT NULL,
  `residency` enum('In-State','Out-of-State') NOT NULL,
  `max_fte` decimal(4,2) NOT NULL DEFAULT 0.50,
  `stipend_per_academic_year` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graduate_research_assistants`
--

INSERT INTO `graduate_research_assistants` (`gra_id`, `name`, `program`, `residency`, `max_fte`, `stipend_per_academic_year`) VALUES
(1, 'Alicia Gomez', 'PhD Computer Science', 'In-State', 0.50, 32000.00),
(2, 'Victor Huang', 'MS Data Science', 'Out-of-State', 0.50, 28000.00),
(3, 'Sarah Lindholm', 'PhD Mechanical Engineering', 'In-State', 0.50, 34500.00),
(4, 'Marcus Patel', 'PhD Electrical Engineering', 'Out-of-State', 0.50, 31000.00),
(5, 'Emily Rhodes', 'MS Bioinformatics', 'In-State', 0.50, 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `post_doctoral_researchers`
--

CREATE TABLE `post_doctoral_researchers` (
  `postdoc_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `field` varchar(100) DEFAULT NULL,
  `appointment_type` enum('Full-Time','Part-Time') NOT NULL DEFAULT 'Full-Time',
  `max_fte` decimal(4,2) NOT NULL DEFAULT 1.00,
  `stipend_per_academic_year` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_doctoral_researchers`
--

INSERT INTO `post_doctoral_researchers` (`postdoc_id`, `name`, `field`, `appointment_type`, `max_fte`, `stipend_per_academic_year`) VALUES
(1, 'Dr. Hannah Lee', 'Biochemistry', 'Full-Time', 1.00, 55000.00),
(2, 'Dr. Rajesh Kumar', 'Physics', 'Full-Time', 1.00, 60000.00),
(3, 'Dr. Emily Chen', 'Computer Science', 'Full-Time', 1.00, 58000.00);

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
-- Table structure for table `undergraduate_research_assistants`
--

CREATE TABLE `undergraduate_research_assistants` (
  `ugra_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `major` varchar(100) DEFAULT NULL,
  `residency` enum('In-State','Out-of-State') NOT NULL,
  `max_fte` decimal(4,2) NOT NULL DEFAULT 0.25,
  `stipend_per_academic_year` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `undergraduate_research_assistants`
--

INSERT INTO `undergraduate_research_assistants` (`ugra_id`, `name`, `major`, `residency`, `max_fte`, `stipend_per_academic_year`) VALUES
(1, 'Alex Johnson', 'Biology', 'In-State', 0.25, 5000.00),
(2, 'Maya Rodriguez', 'Computer Science', 'Out-of-State', 0.25, 5500.00),
(3, 'Ethan Kim', 'Chemistry', 'In-State', 0.25, 4800.00),
(4, 'Sofia Martinez', 'Mechanical Engineering', 'Out-of-State', 0.25, 5200.00),
(5, 'Liam Patel', 'Neuroscience', 'In-State', 0.25, 5100.00);

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
(3, 'Marcus Cole', 75.00, 'Lab Manager', 'Research Staff', 0),
(4, 'Jenna Ortega', 28.75, 'Department Coordinator', 'Admin Staff', 0),
(5, 'Samuel Chen', 52.00, 'Data Scientist', 'Research Staff', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'super', 'super', 'super', '', '$2y$10$3zLLaD6hC8JJGcOBX2NCsOKwSRtRz831V6mdpkmOv9Vl.p9haPyOW', '2025-11-18 13:22:19', '2025-11-18 13:22:19'),
(5, 'john', 'john', 'john', 'john', '$2y$10$W8OCFhxs7Ny1KneBs8afbeCslYQQJMFQyHuWtD3ujFG2A5UZDdA8a', '2025-11-18 13:29:20', '2025-11-18 13:29:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`budget_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  ADD PRIMARY KEY (`bp_id`),
  ADD KEY `budget_id` (`budget_id`);

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
-- Indexes for table `graduate_research_assistants`
--
ALTER TABLE `graduate_research_assistants`
  ADD PRIMARY KEY (`gra_id`);

--
-- Indexes for table `post_doctoral_researchers`
--
ALTER TABLE `post_doctoral_researchers`
  ADD PRIMARY KEY (`postdoc_id`);

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
-- Indexes for table `undergraduate_research_assistants`
--
ALTER TABLE `undergraduate_research_assistants`
  ADD PRIMARY KEY (`ugra_id`);

--
-- Indexes for table `university_employee`
--
ALTER TABLE `university_employee`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `staff_title` (`staff_title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  MODIFY `bp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `graduate_research_assistants`
--
ALTER TABLE `graduate_research_assistants`
  MODIFY `gra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_doctoral_researchers`
--
ALTER TABLE `post_doctoral_researchers`
  MODIFY `postdoc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `undergraduate_research_assistants`
--
ALTER TABLE `undergraduate_research_assistants`
  MODIFY `ugra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `university_employee`
--
ALTER TABLE `university_employee`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  ADD CONSTRAINT `budget_personnel_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE;

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
