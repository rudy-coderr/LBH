-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 03:08 PM
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
-- Database: `bh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `first_name`, `last_name`, `contact_number`, `email`, `address`) VALUES
(2, 13, 'new', 'new', '09786456433', 'new@gmail.com', 'Buhi'),
(3, 28, 'Vincent', 'Cortez', '09454352332', 'vincentcortez@gmail.com', 'Iriga');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `appointment_date` datetime NOT NULL,
  `status` enum('Pending','Approved','Cancelled','Complete','For follow up') DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `appointment_type` enum('Prenatal Checkup','In Labor','Postnatal Checkup') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `staff_id`, `appointment_date`, `status`, `notes`, `appointment_type`) VALUES
(42, 14, 13, '2025-04-28 05:10:00', NULL, 'Check Up my tummy', 'Prenatal Checkup'),
(43, 15, 13, '2025-04-28 21:44:00', 'Approved', 'Papatuli', 'In Labor'),
(44, 14, 13, '2025-04-30 21:44:00', 'Approved', 'Mag papatuli kaming dalawa ni baby', 'Postnatal Checkup'),
(45, 16, 13, '2025-04-30 00:36:00', 'Approved', 'papahilot ng kiffy', 'In Labor'),
(46, 14, 16, '2025-05-20 09:07:00', 'Approved', 'wala lang', 'In Labor'),
(47, 14, NULL, '2025-05-15 21:06:00', '', 'wala lang', 'Postnatal Checkup');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Unpaid') NOT NULL DEFAULT 'Unpaid',
  `payment_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `patient_id`, `amount`, `payment_status`, `payment_date`, `notes`) VALUES
(1, 14, 100.50, 'Unpaid', NULL, 'Paid kana boss'),
(6, 14, 44.99, 'Paid', '2025-05-18 10:27:42', 'lala magbayad kana');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_records`
--

CREATE TABLE `delivery_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `delivery_date` datetime NOT NULL,
  `delivery_type` enum('Normal','Cesarean','Assisted') NOT NULL,
  `complications` text DEFAULT NULL,
  `baby_weight` decimal(5,2) DEFAULT NULL,
  `baby_sex` enum('Male','Female','Other') DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL,
  `expiry_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `medicine_name`, `category`, `quantity`, `expiry_date`, `price`) VALUES
(10, 'tryy', 'pain-reliever', 20, '2025-03-13', 44.99),
(11, 'new', 'antibiotic', 32, '2025-03-07', 46.00);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_dispense`
--

CREATE TABLE `medicine_dispense` (
  `dispense_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `dispense_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_dispense`
--

INSERT INTO `medicine_dispense` (`dispense_id`, `patient_id`, `medicine_id`, `quantity`, `price`, `total`, `dispense_date`) VALUES
(1, 17, 10, 2, 44.99, 89.98, '2025-05-18 10:07:31'),
(2, 14, 11, 2, 46.00, 92.00, '2025-05-18 10:08:34'),
(3, 17, 10, 5, 44.99, 224.95, '2025-05-18 10:09:07'),
(4, 16, 10, 6, 44.99, 269.94, '2025-05-18 10:16:56'),
(5, 14, 10, 1, 44.99, 44.99, '2025-05-18 10:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `user_id`, `full_name`, `age`, `contact_number`, `address`) VALUES
(14, 25, 'Lander Gultiano', 67, '09453464537', 'Balatannnn'),
(15, 26, 'Justine Velasquez', 34, '09454352332', 'baao'),
(16, 27, 'Lexi Lore', 45, '09543242143', 'Iriga '),
(17, 31, 'Jade Lopez', 34, '09454356754', 'Buhi');

-- --------------------------------------------------------

--
-- Table structure for table `postnatal_records`
--

CREATE TABLE `postnatal_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `visit_date` datetime NOT NULL,
  `baby_weight` decimal(5,2) DEFAULT NULL,
  `breastfeeding_status` enum('Yes','No','Partially') NOT NULL,
  `mental_health_check` enum('Good','Fair','Poor') NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenatal_records`
--

CREATE TABLE `prenatal_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `visit_date` datetime NOT NULL,
  `gestational_age` varchar(50) NOT NULL,
  `blood_pressure` varchar(20) NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prenatal_records`
--

INSERT INTO `prenatal_records` (`record_id`, `patient_id`, `appointment_id`, `staff_id`, `visit_date`, `gestational_age`, `blood_pressure`, `weight`, `remarks`) VALUES
(21, 14, 42, 13, '2025-04-28 06:38:34', '45 days', 'normal', 56.00, 'hngfhjgfvh');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `position` enum('Doctor','Nurse','Midwife','Receptionist') NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_hired` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `user_id`, `first_name`, `last_name`, `position`, `contact_number`, `email`, `address`, `date_hired`) VALUES
(13, 15, 'Rudy', 'Boringot', 'Midwife', '09388911483', 'rudy16boringot@gmail.com', 'San Rafael Buhi Camarines Sur', '2025-04-03'),
(15, 29, 'try', 'try', 'Midwife', '09563532432', 'try@gmail.com', 'try', '2025-05-17'),
(16, 30, 'Jerald', 'Ricabuerta', 'Midwife', '09435435743', 'jerald@gmail.com', 'Buhi Camarines Sur', '2025-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Staff','Patient') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(13, 'new', 'new', 'Admin'),
(15, 'rudz', 'rudz', 'Staff'),
(25, 'lander', '$2y$10$ygospNt3tbv71u0fxkzXyOEiMlZyYqFg19TPxa3pgnu1Bd6kvuuB2', 'Patient'),
(26, 'justine', '$2y$10$OSkmfQXjjldNQD3Ja5P3JutcfN.2gVZBwvOzAzJOhO5c0SBEUZU56', 'Patient'),
(27, 'lexi', '$2y$10$vuDGO201c5t2JGtGRzLxjuMPdOlCZaKyssVls8FnG0pPJJayMsgYW', 'Patient'),
(28, 'vincent', '$2y$10$n6JQoNX486ArJH.2vbPYdO4jHhdAhvalZtt2owIHfLSLfi3fTTeF6', 'Admin'),
(29, 'try', '$2y$10$XU01FpiWmXxOYI5Q14uOW./BPswW47qbxuKDGIyKFFwkFPDPUP6r.', 'Staff'),
(30, 'jerald', '$2y$10$ExJ.aDrbzgyUjxCMtKO3e.MgDj0nCt7QToEq9pYC2NvYyPhfb/rmC', 'Staff'),
(31, 'Jade', '$2y$10$kVQl2NJOcu6b6/mfGqttBOUFB5nVAwLQYR7fum9RpLM.A78s2r55a', 'Patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `fk_admin_user` (`user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `delivery_records`
--
ALTER TABLE `delivery_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `appointment_id_2` (`appointment_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `medicine_dispense`
--
ALTER TABLE `medicine_dispense`
  ADD PRIMARY KEY (`dispense_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `fk_patients_users` (`user_id`);

--
-- Indexes for table `postnatal_records`
--
ALTER TABLE `postnatal_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `prenatal_records`
--
ALTER TABLE `prenatal_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `prenatal_records_ibfk_3` (`appointment_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_records`
--
ALTER TABLE `delivery_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `medicine_dispense`
--
ALTER TABLE `medicine_dispense`
  MODIFY `dispense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `postnatal_records`
--
ALTER TABLE `postnatal_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prenatal_records`
--
ALTER TABLE `prenatal_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `delivery_records`
--
ALTER TABLE `delivery_records`
  ADD CONSTRAINT `delivery_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `delivery_records_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `fk_delivery_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patients_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postnatal_records`
--
ALTER TABLE `postnatal_records`
  ADD CONSTRAINT `fk_postnatal_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `postnatal_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `postnatal_records_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `prenatal_records`
--
ALTER TABLE `prenatal_records`
  ADD CONSTRAINT `prenatal_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `prenatal_records_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`),
  ADD CONSTRAINT `prenatal_records_ibfk_3` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
