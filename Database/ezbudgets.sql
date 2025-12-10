-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 09:09 AM
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
(1, 1, 'THIS IS A TEST BUDGET', 'National Science Foundation', NULL, NULL, 0, '2025-11-18 16:10:44', '2025-11-19 19:00:51', '2025-11-04', '2027-12-08'),
(2, 1, 'Super COol Budget', NULL, NULL, NULL, 0, '2025-11-18 16:11:42', '2025-11-18 16:11:42', NULL, NULL),
(3, 5, 'Super cool', NULL, NULL, NULL, 0, '2025-11-19 12:33:30', '2025-11-19 12:33:30', NULL, NULL),
(5, 5, 'Super neat Budget', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:44:02', '2025-11-19 18:44:02', '2025-11-18', '2028-09-14'),
(6, 5, 'Super neat Budget', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:44:37', '2025-11-19 18:44:37', '2025-11-18', '2028-09-14'),
(7, 1, 'yupyupyup', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:55:14', '2025-11-19 23:55:20', '2025-11-04', '2027-12-05'),
(8, 1, 'Awesome', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 23:34:34', '2025-11-19 23:40:34', '2025-11-12', '2027-11-17'),
(18, 0, 'New Budget', NULL, NULL, NULL, 0, '2025-12-09 19:34:46', '2025-12-09 19:34:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `budget_items`
--

CREATE TABLE `budget_items` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `item_type` enum('Equipment','Materials & Supplies','Publication Costs','Computer Services','Software','Facility Useage Fees','Conference Registration','Other') NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_cost` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_items`
--

INSERT INTO `budget_items` (`id`, `budget_id`, `item_type`, `name`, `quantity`, `unit_cost`) VALUES
(31, 1, 'Facility Useage Fees', 'dfsdfsdsdfd', 3, 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `budget_personnel`
--

CREATE TABLE `budget_personnel` (
  `bp_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `personnel_type` enum('PI','staff','postdoc','student','grad_assistant','undergrad_assistant') DEFAULT NULL,
  `personnel_id` int(11) NOT NULL,
  `percent_effort` int(11) DEFAULT NULL,
  `stipend_requested` tinyint(1) DEFAULT 0,
  `stipend_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_personnel`
--

INSERT INTO `budget_personnel` (`bp_id`, `budget_id`, `personnel_type`, `personnel_id`, `percent_effort`, `stipend_requested`, `stipend_amount`) VALUES
(17, 6, 'PI', 4, 4, 0, 0.00),
(18, 6, 'staff', 3, 3, 0, 0.00),
(19, 6, 'postdoc', 2, 5, 1, 60000.00),
(20, 6, 'grad_assistant', 1, 0, 0, 32000.00),
(21, 6, 'undergrad_assistant', 3, 1, 1, 4800.00),
(54, 8, 'PI', 1, 30, 0, 0.00),
(55, 8, 'PI', 3, 2, 0, 0.00),
(56, 8, 'PI', 5, 1, 0, 0.00),
(57, 8, 'PI', 4, 8, 0, 0.00),
(58, 8, 'staff', 3, 100, 0, 0.00),
(59, 7, 'PI', 3, 1, 0, 0.00),
(60, 7, 'staff', 3, 1, 0, 0.00),
(61, 7, 'postdoc', 1, 1, 1, 55000.00),
(62, 7, 'grad_assistant', 5, 0, 0, 25000.00),
(63, 7, 'undergrad_assistant', 5, 0, 1, 5100.00),
(396, 1, 'PI', 1, 2, 0, 0.00),
(397, 1, 'PI', 3, 6, 0, 0.00),
(398, 1, 'PI', 5, 1, 0, 0.00),
(399, 1, 'staff', 3, 1, 0, 0.00),
(400, 1, 'postdoc', 1, 0, 0, 55000.00),
(401, 1, 'grad_assistant', 4, 50, 1, 31000.00),
(402, 1, 'undergrad_assistant', 1, 0, 0, 5000.00),
(514, 12, 'PI', 1, 0, 0, 0.00),
(515, 14, 'PI', 4, 0, 0, 0.00),
(582, 9, 'PI', 3, 2, 0, 0.00),
(583, 9, 'PI', 1, 2, 0, 0.00),
(584, 9, 'PI', 5, 0, 0, 0.00),
(585, 9, 'staff', 4, 2, 0, 0.00),
(586, 9, 'postdoc', 1, 1, 1, 0.00),
(587, 9, 'postdoc', 3, 2, 1, 0.00),
(588, 9, 'grad_assistant', 1, 1, 1, 0.00),
(589, 9, 'grad_assistant', 5, 2, 1, 0.00),
(590, 9, 'undergrad_assistant', 1, 1, 1, 0.00),
(591, 9, 'undergrad_assistant', 3, 2, 1, 0.00),
(596, 16, 'PI', 0, 34, 0, 0.00),
(597, 16, 'PI', 0, 87, 0, 0.00),
(598, 16, 'postdoc', 2, 0, 1, 0.00),
(599, 16, 'postdoc', 1, 0, 1, 0.00),
(600, 16, 'grad_assistant', 1, 0, 0, 0.00),
(601, 16, 'grad_assistant', 5, 0, 0, 0.00),
(602, 16, 'grad_assistant', 2, 0, 0, 0.00),
(603, 16, 'grad_assistant', 3, 0, 0, 0.00),
(604, 16, 'grad_assistant', 4, 0, 0, 0.00),
(605, 16, 'undergrad_assistant', 3, 0, 1, 0.00),
(606, 16, 'undergrad_assistant', 2, 0, 1, 0.00),
(607, 16, 'undergrad_assistant', 4, 0, 1, 0.00),
(610, 10, 'PI', 1, 3, 0, 0.00),
(611, 10, 'staff', 4, 65, 0, 0.00),
(612, 10, 'staff', 3, 65, 0, 0.00),
(613, 13, 'PI', 3, 0, 0, 0.00),
(614, 13, 'PI', 4, 0, 0, 0.00),
(615, 13, 'staff', 5, 0, 0, 0.00),
(616, 13, 'postdoc', 1, 0, 0, 55000.00);

-- --------------------------------------------------------

--
-- Table structure for table `budget_travels`
--

CREATE TABLE `budget_travels` (
  `travel_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `travel_type` enum('Domestic','International') NOT NULL,
  `num_nights` int(11) NOT NULL DEFAULT 0,
  `num_travelers` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_travels`
--

INSERT INTO `budget_travels` (`travel_id`, `budget_id`, `travel_type`, `num_nights`, `num_travelers`) VALUES
(47, 1, 'Domestic', 1, 2),
(48, 1, 'International', 1, 2);

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
-- Table structure for table `travel_profiles`
--

CREATE TABLE `travel_profiles` (
  `travel_type` varchar(50) NOT NULL,
  `airfare` decimal(10,2) NOT NULL,
  `max_lodging_days` int(11) NOT NULL,
  `per_diem` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_profiles`
--

INSERT INTO `travel_profiles` (`travel_type`, `airfare`, `max_lodging_days`, `per_diem`) VALUES
('Domestic', 450.00, 7, 59.00),
('International', 1500.00, 14, 85.00);

-- --------------------------------------------------------

--
-- Table structure for table `tuition_schedule`
--

CREATE TABLE `tuition_schedule` (
  `id` int(11) NOT NULL,
  `semester` enum('fall','spring','summer') NOT NULL,
  `student_level` enum('undergrad','masters','phd') NOT NULL,
  `residency` enum('In-State','Out-of-State') NOT NULL,
  `base_tuition` decimal(12,2) NOT NULL,
  `mandatory_fees` decimal(12,2) NOT NULL,
  `tuition_increase_pct` decimal(5,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tuition_schedule`
--

INSERT INTO `tuition_schedule` (`id`, `semester`, `student_level`, `residency`, `base_tuition`, `mandatory_fees`, `tuition_increase_pct`) VALUES
(1, 'fall', 'masters', 'In-State', 7850.00, 620.00, 0.0300),
(2, 'fall', 'masters', 'Out-of-State', 14600.00, 620.00, 0.0300),
(3, 'fall', 'phd', 'In-State', 7600.00, 580.00, 0.0300),
(4, 'fall', 'phd', 'Out-of-State', 14350.00, 580.00, 0.0300),
(5, 'fall', 'undergrad', 'In-State', 5200.00, 510.00, 0.0250),
(6, 'fall', 'undergrad', 'Out-of-State', 14600.00, 510.00, 0.0250),
(7, 'spring', 'masters', 'In-State', 7850.00, 620.00, 0.0300),
(8, 'spring', 'masters', 'Out-of-State', 14600.00, 620.00, 0.0300),
(9, 'spring', 'phd', 'In-State', 7600.00, 580.00, 0.0300),
(10, 'spring', 'phd', 'Out-of-State', 14350.00, 580.00, 0.0300),
(11, 'spring', 'undergrad', 'In-State', 5200.00, 510.00, 0.0250),
(12, 'spring', 'undergrad', 'Out-of-State', 14600.00, 510.00, 0.0250),
(13, 'summer', 'masters', 'In-State', 3000.00, 450.00, 0.0300),
(14, 'summer', 'masters', 'Out-of-State', 6000.00, 450.00, 0.0300),
(15, 'summer', 'phd', 'In-State', 2800.00, 430.00, 0.0300),
(16, 'summer', 'phd', 'Out-of-State', 5600.00, 430.00, 0.0300),
(17, 'summer', 'undergrad', 'In-State', 2600.00, 400.00, 0.0250),
(18, 'summer', 'undergrad', 'Out-of-State', 5200.00, 400.00, 0.0250);

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
  `salary` decimal(12,2) NOT NULL,
  `job` varchar(100) DEFAULT NULL,
  `staff_title` varchar(50) DEFAULT NULL,
  `is_pi_eligible` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_employee`
--

INSERT INTO `university_employee` (`staff_id`, `name`, `salary`, `job`, `staff_title`, `is_pi_eligible`) VALUES
(1, 'Dr. Evelyn Reed', 250640.00, 'Professor of Physics', 'Faculty', 1),
(3, 'Marcus Cole', 156000.00, 'Lab Manager', 'Research Staff', 0),
(4, 'Jenna Ortega', 59800.00, 'Department Coordinator', 'Admin Staff', 0),
(5, 'Samuel Chen', 108160.00, 'Data Scientist', 'Research Staff', 0);

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
(0, 'username', 'Isaac', 'Palmer', 'test@gmail.com', '$2y$10$ZCz1.AER6CZfD8stwiG10uUKEbYMUuuY5Hv3QCVSozslSFmmx/vBy', '2025-11-20 09:24:54', '2025-11-20 09:24:54'),
(1, 'super', 'super', 'super', '', '$2y$10$3zLLaD6hC8JJGcOBX2NCsOKwSRtRz831V6mdpkmOv9Vl.p9haPyOW', '2025-11-18 13:22:19', '2025-11-18 13:22:19'),
(5, 'john', 'john', 'john', 'john', '$2y$10$W8OCFhxs7Ny1KneBs8afbeCslYQQJMFQyHuWtD3ujFG2A5UZDdA8a', '2025-11-18 13:29:20', '2025-11-18 13:29:20'),
(6, 'sdf', 'sdf', 'sdf', 'sdf', '$2y$10$Iz.IwKJuDiJ2JE3jFadKd.s.rtlV8L3dtylapimF5BMVl6/MwlzzC', '2025-11-19 23:28:38', '2025-11-19 23:28:38');

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
-- Indexes for table `budget_items`
--
ALTER TABLE `budget_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_id` (`budget_id`);

--
-- Indexes for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  ADD PRIMARY KEY (`bp_id`),
  ADD KEY `budget_id` (`budget_id`);

--
-- Indexes for table `budget_travels`
--
ALTER TABLE `budget_travels`
  ADD PRIMARY KEY (`travel_id`),
  ADD KEY `fk_budget_travels_budget` (`budget_id`);

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
-- Indexes for table `travel_profiles`
--
ALTER TABLE `travel_profiles`
  ADD PRIMARY KEY (`travel_type`);

--
-- Indexes for table `tuition_schedule`
--
ALTER TABLE `tuition_schedule`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `budget_items`
--
ALTER TABLE `budget_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  MODIFY `bp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=617;

--
-- AUTO_INCREMENT for table `budget_travels`
--
ALTER TABLE `budget_travels`
  MODIFY `travel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

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
-- AUTO_INCREMENT for table `tuition_schedule`
--
ALTER TABLE `tuition_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_items`
--
ALTER TABLE `budget_items`
  ADD CONSTRAINT `budget_items_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_travels`
--
ALTER TABLE `budget_travels`
  ADD CONSTRAINT `fk_budget_travels_budget` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
