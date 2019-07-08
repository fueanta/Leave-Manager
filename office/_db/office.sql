-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2019 at 05:54 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `office`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` text NOT NULL,
  `delegate_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `declined_by` varchar(255) NOT NULL DEFAULT 'Not Declined',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `employee_id`, `supervisor_id`, `leave_id`, `from_date`, `to_date`, `reason`, `delegate_id`, `status`, `declined_by`, `created_at`) VALUES
(56, 6, 83, 1, '2019-07-03', '2019-07-03', 'HAHA No Reason', 83, 'Reclaimed', 'Not Declined', '2019-07-03 05:30:01'),
(57, 83, 6, 3, '2019-07-03', '2019-07-03', 'Chuti den plss!', 6, 'Accepted', 'Not Declined', '2019-07-03 05:31:07'),
(58, 83, 6, 1, '2019-07-04', '2019-07-04', 'Emni', 6, 'Accepted', 'Not Declined', '2019-07-04 04:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `created_at`) VALUES
(-1, 'Default', 'Default', '2019-01-29 09:17:41'),
(1, 'E.B Solutions LTD', 'Largest online contents provider.', '2019-01-30 07:27:06'),
(2, 'HydroKleen Bangladesh Ltd. ', 'Ac Cleaning & Servicing ', '2019-04-25 10:38:46'),
(3, 'BANGLADHOL', 'Studio', '2019-04-25 10:39:40'),
(4, 'Geo Connect Aviation', '', '2019-04-25 10:43:24'),
(5, 'E.B. Solutions Group ', '', '2019-05-19 07:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`) VALUES
(-1, 'Default', 'Default', '2019-01-29 09:16:52'),
(1, 'Development', 'Responsible for generating codes and building softwares.', '2019-01-30 07:28:11'),
(2, 'Business/ Marketing ', 'Make relation with customers.', '2019-03-20 11:49:15'),
(3, 'HR & compliance ', 'Deals with recruitment, people management and defining organization policies.', '2019-04-01 12:00:27'),
(4, 'Technical (Operations)', '', '2019-05-14 08:14:26'),
(5, 'Content ', '', '2019-05-14 08:15:10'),
(6, 'Design & Animation ', '', '2019-05-14 08:16:00'),
(7, 'IT ', '', '2019-05-14 08:16:11'),
(8, 'Accounts & Finance ', '', '2019-05-14 08:17:11'),
(9, 'Admin ', '', '2019-05-14 08:19:03'),
(10, 'Content (BANGLADHOL)', '', '2019-05-14 08:20:32'),
(11, 'Ticketing (Geo Connect Aviation)', '', '2019-05-14 08:24:36'),
(12, 'Visa (Geo Connect Aviation)', '', '2019-05-14 08:24:57'),
(13, 'Hotel & Reservation (Geo Connect Aviation) ', '', '2019-05-14 08:26:19'),
(14, 'Service & Support (HydroKleen) ', '', '2019-05-14 08:27:02'),
(15, 'Accounts & Finance (HydroKleen)', '', '2019-05-15 06:15:38'),
(16, 'Accounts & Finance (Geo Connect Aviation)', '', '2019-05-15 06:16:18'),
(17, 'Design & Animation (Geo Connect Aviation)', '', '2019-05-15 06:16:49'),
(18, 'Admin (Geo Connect Aviation)', '', '2019-05-19 06:27:16'),
(19, 'Technical (R&D)', '', '2019-05-26 09:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `application_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'Other',
  `company_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `gender`, `company_id`, `department_id`, `designation`, `supervisor_id`, `mobile`, `emergency_contact`, `blood_group`, `status`, `created_at`) VALUES
(-1, 'Default', 'Other', -1, -1, 'Default', -1, 'Default', 'Default', 'Default', 'Active', '2019-01-29'),
(6, 'EBS-1001', 'Male', 1, 1, 'Software Engineer', 83, '01796391677', '01937088318', 'A+', 'Active', '2018-12-01'),
(83, 'EBS-404', 'Female', 1, 2, 'Assistant Manager', 6, '01521334465', '', '', 'Active', '2019-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `eligible_after` int(11) NOT NULL DEFAULT 0,
  `document_required_after` int(11) NOT NULL DEFAULT 0,
  `annual_balance` int(11) NOT NULL DEFAULT 10,
  `renewal_period` varchar(255) NOT NULL DEFAULT 'Yearly',
  `gender_dependency` varchar(255) NOT NULL DEFAULT 'Not Applicable',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `name`, `description`, `eligible_after`, `document_required_after`, `annual_balance`, `renewal_period`, `gender_dependency`, `created_at`) VALUES
(1, 'Sick', 'Post', 0, 2, 14, 'Yearly', 'Not Applicable', '2019-01-30 11:18:45'),
(2, 'Maternity', 'Pre', 6, 0, 112, 'Never', 'Female', '2019-01-30 11:19:25'),
(3, 'Annual', 'Pre', 12, 0, 15, 'Yearly', 'Not Applicable', '2019-02-06 07:20:29'),
(4, 'Paternity', 'Post', 3, 3, 5, 'Never', 'Male', '2019-05-14 08:12:04'),
(5, 'Wedding', 'Pre', 3, 0, 7, 'Never', 'Not Applicable', '2019-05-14 08:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `reclaims`
--

CREATE TABLE `reclaims` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reclaims`
--

INSERT INTO `reclaims` (`id`, `application_id`, `supervisor_id`, `from_date`, `to_date`, `status`, `created_at`) VALUES
(7, 56, 83, '2019-07-03', '2019-07-03', 'Accepted', '2019-07-03 05:31:59'),
(8, 57, 6, '2019-07-04', '2019-07-05', 'Accepted', '2019-07-03 05:32:27'),
(9, 57, 6, '2019-07-03', '2019-07-03', 'Pending', '2019-07-04 05:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ref_type` varchar(255) NOT NULL,
  `ref_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`, `created_at`) VALUES
(-1, 'Admin', 'user1@ebs.com', 'e10adc3949ba59abbe56e057f20f883e', 'HR', '2019-01-29 09:02:36'),
(6, 'Mutasim Billah Bin Ahmad', 'ahmad-mutasim@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 'HR', '2019-04-21 07:28:45'),
(83, 'Tasnim Ahmad', 'fueanta@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 'Employee', '2019-07-03 05:07:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reclaims`
--
ALTER TABLE `reclaims`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reclaims`
--
ALTER TABLE `reclaims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
