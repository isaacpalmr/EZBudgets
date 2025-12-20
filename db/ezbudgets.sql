-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 05:17 AM
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
(2, 1, 'Super COol Budget', NULL, NULL, NULL, 0, '2025-11-18 16:11:42', '2025-11-18 16:11:42', NULL, NULL),
(3, 5, 'Super cool', NULL, NULL, NULL, 0, '2025-11-19 12:33:30', '2025-11-19 12:33:30', NULL, NULL),
(5, 5, 'Super neat Budget', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:44:02', '2025-11-19 18:44:02', '2025-11-18', '2028-09-14'),
(6, 5, 'Super neat Budget', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:44:37', '2025-11-19 18:44:37', '2025-11-18', '2028-09-14'),
(7, 1, 'yupyupyup', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 18:55:14', '2025-11-19 23:55:20', '2025-11-04', '2027-12-05'),
(8, 1, 'Awesome', 'National Science Foundation', NULL, NULL, 0, '2025-11-19 23:34:34', '2025-11-19 23:40:34', '2025-11-12', '2027-11-17'),
(32, 0, 'New Budget', '', NULL, NULL, 0, '2025-12-10 22:26:41', '2025-12-10 22:26:51', '2025-12-10', '2025-12-10'),
(33, 0, 'New Budget', '', NULL, NULL, 0, '2025-12-10 23:04:13', '2025-12-10 23:18:44', '2025-12-10', '2025-12-10'),
(34, 0, 'New Budget', '', NULL, NULL, 0, '2025-12-10 23:22:27', '2025-12-10 23:23:23', '2025-12-10', '2025-12-10'),
(35, 1, 'New Budget', NULL, NULL, NULL, 0, '2025-12-10 23:31:01', '2025-12-10 23:31:01', NULL, NULL),
(36, 8, 'New Budget', 'National Science Foundation', NULL, NULL, 0, '2025-12-11 01:25:16', '2025-12-11 01:25:29', '2025-12-11', '2025-12-11'),
(37, 8, 'New Budget', '', NULL, NULL, 0, '2025-12-11 01:31:48', '2025-12-11 01:31:56', '2025-12-11', '2025-12-11'),
(38, 8, 'New Budget', '', NULL, NULL, 0, '2025-12-11 01:44:36', '2025-12-11 01:44:40', '2025-12-11', '2025-12-11'),
(41, 7, 'Awesome Budget', 'National Science Foundation', NULL, NULL, 0, '2025-12-11 12:59:19', '2025-12-11 13:01:37', '2025-12-17', '2030-12-11'),
(42, 6, 'New Budget', 'National Science Foundation', NULL, NULL, 0, '2025-12-19 00:07:29', '2025-12-19 00:09:38', '2025-12-19', '2028-12-19');

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
(278, 32, '', '', 0, 0.00),
(279, 33, 'Materials & Supplies', '1', 32, 43.00),
(282, 41, 'Equipment', 'Tractor', 10, 5800.00),
(283, 42, 'Materials & Supplies', 'Yup', 4, 14.00);

-- --------------------------------------------------------

--
-- Table structure for table `budget_personnel`
--

CREATE TABLE `budget_personnel` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `personnel_type` enum('staff','gra','ugrad','post-doc') DEFAULT NULL,
  `personnel_id` int(11) NOT NULL,
  `percent_effort` int(11) DEFAULT NULL,
  `stipend_requested` tinyint(1) DEFAULT 0,
  `tuition_requested` tinyint(1) DEFAULT 0,
  `html_table_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_personnel`
--

INSERT INTO `budget_personnel` (`id`, `budget_id`, `personnel_type`, `personnel_id`, `percent_effort`, `stipend_requested`, `tuition_requested`, `html_table_id`) VALUES
(142, 32, 'staff', 0, 0, 0, 0, 'pi-table'),
(146, 33, 'staff', 0, 0, 0, 0, 'pi-table'),
(147, 33, 'gra', 0, 0, 1, 1, 'gras'),
(148, 33, 'ugrad', 0, 0, 0, 0, 'ugrads'),
(150, 34, 'staff', 0, 0, 0, 0, 'pi-table'),
(154, 36, 'staff', 1, 0, 0, 0, 'pi-table'),
(156, 37, 'staff', 0, 0, 0, 0, 'pi-table'),
(157, 38, 'staff', 0, 0, 0, 0, 'pi-table'),
(174, 41, 'staff', 3, 7, 0, 0, 'pi-table'),
(175, 41, 'staff', 1, 6, 0, 0, 'pi-table'),
(176, 41, 'staff', 4, 8, 0, 0, 'pi-table'),
(177, 41, 'staff', 5, 10, 0, 0, 'pro-staff'),
(178, 41, 'post-doc', 1, 8, 0, 0, 'post-docs'),
(179, 41, 'gra', 5, 0, 0, 1, 'gras'),
(180, 41, 'ugrad', 3, 12, 1, 1, 'ugrads'),
(201, 42, 'staff', 3, 100, 0, 0, 'pi-table'),
(202, 42, 'staff', 5, 100, 0, 0, 'pro-staff'),
(203, 42, 'post-doc', 3, 100, 0, 0, 'post-docs'),
(204, 42, 'gra', 5, 50, 1, 1, 'gras'),
(205, 42, 'ugrad', 1, 50, 1, 1, 'ugrads');

-- --------------------------------------------------------

--
-- Table structure for table `budget_subawards`
--

CREATE TABLE `budget_subawards` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `subbudget_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_subawards`
--

INSERT INTO `budget_subawards` (`id`, `budget_id`, `subbudget_id`) VALUES
(52, 32, 59),
(54, 33, 64),
(55, 33, 65),
(57, 34, 66),
(62, 36, 67),
(63, 36, 68),
(65, 37, 69),
(66, 38, 70),
(70, 41, 72),
(71, 42, 73);

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
(135, 33, 'Domestic', 0, 0),
(138, 41, 'Domestic', 7, 3),
(139, 42, 'International', 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `fa_rate`
--

CREATE TABLE `fa_rate` (
  `year` year(4) NOT NULL,
  `fa_rate` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fa_rate`
--

INSERT INTO `fa_rate` (`year`, `fa_rate`) VALUES
('2020', 0.50),
('2021', 0.50),
('2022', 0.50),
('2023', 0.50),
('2024', 0.50),
('2025', 0.50),
('2026', 0.50),
('2027', 0.50),
('2028', 0.50),
('2029', 0.50),
('2030', 0.50);

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
  `max_fte` decimal(4,2) NOT NULL DEFAULT 1.00,
  `stipend_per_academic_year` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_doctoral_researchers`
--

INSERT INTO `post_doctoral_researchers` (`postdoc_id`, `name`, `field`, `max_fte`, `stipend_per_academic_year`) VALUES
(1, 'Dr. Hannah Lee', 'Biochemistry', 1.00, 55000.00),
(2, 'Dr. Rajesh Kumar', 'Physics', 1.00, 60000.00),
(3, 'Dr. Emily Chen', 'Computer Science', 1.00, 58000.00);

-- --------------------------------------------------------

--
-- Table structure for table `subbudgets`
--

CREATE TABLE `subbudgets` (
  `subbudget_id` int(11) NOT NULL,
  `prime_budget_id` int(11) NOT NULL,
  `subaward_institution` varchar(255) NOT NULL DEFAULT '',
  `total_cost` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subbudgets`
--

INSERT INTO `subbudgets` (`subbudget_id`, `prime_budget_id`, `subaward_institution`, `total_cost`) VALUES
(59, 32, 'testing', 0.00),
(60, 33, '', 0.00),
(61, 33, '', 0.00),
(62, 33, '', 0.00),
(63, 33, '', 0.00),
(64, 33, 'test', 0.00),
(65, 33, '', 0.00),
(66, 34, '', 0.00),
(67, 36, 'WSU', 25966.00),
(68, 36, 'BSU', 10662.00),
(69, 37, 'WSU', 2132.00),
(70, 38, '', 2132.00),
(72, 41, 'WSU', 106626.00),
(73, 42, 'WSU', 228693.00);

-- --------------------------------------------------------

--
-- Table structure for table `subbudget_items`
--

CREATE TABLE `subbudget_items` (
  `id` int(11) NOT NULL DEFAULT 0,
  `subbudget_id` int(11) NOT NULL,
  `item_type` enum('Equipment','Materials & Supplies','Publication Costs','Computer Services','Software','Facility Useage Fees','Conference Registration','Other') NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_cost` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subbudget_items`
--

INSERT INTO `subbudget_items` (`id`, `subbudget_id`, `item_type`, `name`, `quantity`, `unit_cost`) VALUES
(0, 59, '', '', 0, 0.00),
(0, 73, 'Facility Useage Fees', 'Nope', 4, 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `subbudget_personnel`
--

CREATE TABLE `subbudget_personnel` (
  `id` int(11) NOT NULL,
  `subbudget_id` int(11) NOT NULL,
  `personnel_type` enum('staff','gra','ugrad','post-doc') DEFAULT NULL,
  `personnel_id` int(11) NOT NULL,
  `percent_effort` int(11) DEFAULT NULL,
  `stipend_requested` tinyint(1) DEFAULT 0,
  `tuition_requested` tinyint(1) DEFAULT 0,
  `html_table_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subbudget_personnel`
--

INSERT INTO `subbudget_personnel` (`id`, `subbudget_id`, `personnel_type`, `personnel_id`, `percent_effort`, `stipend_requested`, `tuition_requested`, `html_table_id`) VALUES
(59, 59, 'staff', 0, 0, 0, 0, 'pi-table'),
(60, 64, 'staff', 0, 0, 0, 0, 'pi-table'),
(61, 66, 'staff', 0, 0, 0, 0, 'pi-table'),
(62, 67, 'staff', 1, 8, 0, 0, 'pi-table'),
(63, 68, 'staff', 3, 5, 0, 0, 'pi-table'),
(64, 69, 'staff', 3, 1, 0, 0, 'pi-table'),
(65, 70, 'staff', 3, 1, 0, 0, 'pi-table'),
(67, 72, 'staff', 3, 10, 0, 0, 'pi-table'),
(68, 73, 'staff', 3, 11, 0, 0, 'pi-table'),
(69, 73, 'staff', 4, 11, 0, 0, 'pro-staff'),
(70, 73, 'post-doc', 1, 13, 0, 0, 'post-docs'),
(71, 73, 'gra', 5, 9, 1, 0, 'gras'),
(72, 73, 'ugrad', 5, 0, 0, 1, 'ugrads');

-- --------------------------------------------------------

--
-- Table structure for table `subbudget_travels`
--

CREATE TABLE `subbudget_travels` (
  `travel_id` int(11) NOT NULL DEFAULT 0,
  `subbudget_id` int(11) NOT NULL,
  `travel_type` enum('Domestic','International') NOT NULL,
  `num_nights` int(11) NOT NULL DEFAULT 0,
  `num_travelers` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subbudget_travels`
--

INSERT INTO `subbudget_travels` (`travel_id`, `subbudget_id`, `travel_type`, `num_nights`, `num_travelers`) VALUES
(0, 73, 'Domestic', 7, 4);

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
(1, 'username', 'test', 'test', 'test@gmail.com', '$2y$10$h0D0saGePZ.mKePPD3rHEuTdTuPVti5Kv0kSI/fyzfa8GXzD1Qzrq', '2025-12-10 23:25:34', '2025-12-10 23:25:34'),
(4, 'username1', 'test', 'test', 'test2@gmail.com', '$2y$10$smi6Q3Pq5IBDUtQtWt/TCOPjrwKPa/rGdy.MZUvLUFUJRuhxx4vry', '2025-12-10 23:25:54', '2025-12-10 23:25:54'),
(6, 'super', 'super', 'super', 'super', '$2y$10$HGIX8s92xxDERYp7x9.pueoEBw4UQzhnAZ5V4cSRp7yxV0l3h5YBK', '2025-12-11 01:45:16', '2025-12-11 01:45:16'),
(7, 'lightningluster', 'Tristan', 'Talbott', 'talb5116@vandals.uidaho.edu', '$2y$10$4pfqtInmJ1SJF3gc88BnLe7R1Oz5Q5Zy/oRgN7m1qwxg5HlS4A5RK', '2025-12-11 12:58:52', '2025-12-11 12:58:52');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_id` (`budget_id`);

--
-- Indexes for table `budget_subawards`
--
ALTER TABLE `budget_subawards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subaward_id` (`subbudget_id`),
  ADD KEY `fk_budget_subawards` (`budget_id`);

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
-- Indexes for table `subbudgets`
--
ALTER TABLE `subbudgets`
  ADD PRIMARY KEY (`subbudget_id`);

--
-- Indexes for table `subbudget_items`
--
ALTER TABLE `subbudget_items`
  ADD KEY `fk_subbudget_items` (`subbudget_id`);

--
-- Indexes for table `subbudget_personnel`
--
ALTER TABLE `subbudget_personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subbudget_id` (`subbudget_id`);

--
-- Indexes for table `subbudget_travels`
--
ALTER TABLE `subbudget_travels`
  ADD KEY `fk_subbudget_travels` (`subbudget_id`);

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
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `budget_items`
--
ALTER TABLE `budget_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `budget_subawards`
--
ALTER TABLE `budget_subawards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `budget_travels`
--
ALTER TABLE `budget_travels`
  MODIFY `travel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `graduate_research_assistants`
--
ALTER TABLE `graduate_research_assistants`
  MODIFY `gra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post_doctoral_researchers`
--
ALTER TABLE `post_doctoral_researchers`
  MODIFY `postdoc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subbudgets`
--
ALTER TABLE `subbudgets`
  MODIFY `subbudget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `subbudget_personnel`
--
ALTER TABLE `subbudget_personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tuition_schedule`
--
ALTER TABLE `tuition_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `undergraduate_research_assistants`
--
ALTER TABLE `undergraduate_research_assistants`
  MODIFY `ugra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `university_employee`
--
ALTER TABLE `university_employee`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_items`
--
ALTER TABLE `budget_items`
  ADD CONSTRAINT `budget_items_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budget_items` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_personnel`
--
ALTER TABLE `budget_personnel`
  ADD CONSTRAINT `fk_budget_personnel` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_subawards`
--
ALTER TABLE `budget_subawards`
  ADD CONSTRAINT `fk_budget_subawards` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budget_subawards_subbudget` FOREIGN KEY (`subbudget_id`) REFERENCES `subbudgets` (`subbudget_id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_travels`
--
ALTER TABLE `budget_travels`
  ADD CONSTRAINT `fk_budget_travels` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_budget_travels_budget` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`budget_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subbudget_items`
--
ALTER TABLE `subbudget_items`
  ADD CONSTRAINT `fk_subbudget_items` FOREIGN KEY (`subbudget_id`) REFERENCES `subbudgets` (`subbudget_id`) ON DELETE CASCADE;

--
-- Constraints for table `subbudget_personnel`
--
ALTER TABLE `subbudget_personnel`
  ADD CONSTRAINT `fk_subbudget_personnel` FOREIGN KEY (`subbudget_id`) REFERENCES `subbudgets` (`subbudget_id`) ON DELETE CASCADE;

--
-- Constraints for table `subbudget_travels`
--
ALTER TABLE `subbudget_travels`
  ADD CONSTRAINT `fk_subbudget_travels` FOREIGN KEY (`subbudget_id`) REFERENCES `subbudgets` (`subbudget_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
