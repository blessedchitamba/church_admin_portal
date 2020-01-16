-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2020 at 01:47 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group_i_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `category`) VALUES
(1, 'Tithes'),
(2, 'Partnerships'),
(3, 'First Fruits'),
(4, 'Special Seeds'),
(5, 'Leaders'),
(6, 'Church Attendance'),
(7, 'Cell Groups'),
(8, 'Member Register'),
(9, 'Cell Reports'),
(10, 'Ministry Material Purchases');

-- --------------------------------------------------------

--
-- Table structure for table `cell_groups`
--

CREATE TABLE `cell_groups` (
  `cellID` int(10) UNSIGNED NOT NULL,
  `cell_name` varchar(255) NOT NULL,
  `cell_leader` int(10) UNSIGNED NOT NULL,
  `Location/Res` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cell_reports`
--

CREATE TABLE `cell_reports` (
  `cellID` int(10) UNSIGNED NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Total Attendance` int(10) NOT NULL,
  `First Timers` int(10) NOT NULL,
  `New Converts` int(10) NOT NULL,
  `Offering` decimal(10,2) NOT NULL,
  `Church Attendance` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `church_attendance`
--

CREATE TABLE `church_attendance` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `first_fruits`
--

CREATE TABLE `first_fruits` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Amount(ZAR)` decimal(10,2) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `first_fruits`
--

INSERT INTO `first_fruits` (`memberID`, `Amount(ZAR)`, `Date`) VALUES
(3, '4000.00', '2020-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `leaders`
--

CREATE TABLE `leaders` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaders`
--

INSERT INTO `leaders` (`memberID`, `department`, `position`) VALUES
(1, 'PFCC', 'Officer'),
(2, 'Finance and Treasury', 'Officer');

-- --------------------------------------------------------

--
-- Table structure for table `member_register`
--

CREATE TABLE `member_register` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` int(10) DEFAULT NULL,
  `university` varchar(50) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `year_of_study` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_register`
--

INSERT INTO `member_register` (`memberID`, `name`, `surname`, `email`, `phone_number`, `university`, `degree`, `year_of_study`) VALUES
(1, 'Blessed', 'Chitamba', 'test@gmail.com', 785526040, 'UCT', 'Computer Science', '4th'),
(2, 'Linda', 'Ndlovu', 'linda@gmail.com', 783652387, 'UCT', 'Health Science', 'Masters'),
(3, 'Mandisa', 'Ndlovu', 'mandisa@gmail.com', 655984221, 'UWC', 'Law', '4th');

-- --------------------------------------------------------

--
-- Table structure for table `mm_purchases`
--

CREATE TABLE `mm_purchases` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Amount(ZAR)` decimal(10,2) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Name of material` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `officeID` int(10) UNSIGNED NOT NULL,
  `office` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`officeID`, `office`) VALUES
(1, 'Finance and Treasury'),
(2, 'Partnership'),
(3, 'PFCC'),
(4, 'First Timers'),
(5, 'Church Attendance'),
(6, 'Pastor'),
(7, 'Admin'),
(8, 'LMAM');

-- --------------------------------------------------------

--
-- Table structure for table `partnerships`
--

CREATE TABLE `partnerships` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Amount(ZAR)` decimal(10,2) NOT NULL,
  `Partnership Arm` varchar(255) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `categoryID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`memberID`, `categoryID`) VALUES
(1, 5),
(1, 7),
(1, 8),
(1, 9),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(3, 8),
(3, 6),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `special_seeds`
--

CREATE TABLE `special_seeds` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Amount(ZAR)` decimal(10,2) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `special_seeds`
--

INSERT INTO `special_seeds` (`memberID`, `Amount(ZAR)`, `Date`, `Reason`) VALUES
(1, '500.00', '2020-01-11', 'Giving thanks for my tuition!');

-- --------------------------------------------------------

--
-- Table structure for table `table_names`
--

CREATE TABLE `table_names` (
  `tb_name` varchar(255) NOT NULL,
  `user_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_names`
--

INSERT INTO `table_names` (`tb_name`, `user_input`) VALUES
('cell_groups', 'Cell Groups'),
('cell_reports', 'Cell Reports'),
('church_attendance', 'Church Attendance'),
('first_fruits', 'First Fruits'),
('leaders', 'Leaders'),
('member_register', 'Member Register'),
('mm_purchases', 'Ministry Material Purchases'),
('offices', 'Offices'),
('partnerships', 'Partnerships'),
('special_seeds', 'Special Seeds'),
('tithes', 'Tithes');

-- --------------------------------------------------------

--
-- Table structure for table `tithes`
--

CREATE TABLE `tithes` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `Amount(ZAR)` decimal(10,2) UNSIGNED ZEROFILL NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tithes`
--

INSERT INTO `tithes` (`memberID`, `Amount(ZAR)`, `Date`) VALUES
(1, '00000600.00', '0000-00-00'),
(1, '00000600.00', '0000-00-00'),
(2, '00003000.00', '2020-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `memberID` int(10) UNSIGNED NOT NULL,
  `hashedPass` varchar(255) NOT NULL,
  `officeID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`memberID`, `hashedPass`, `officeID`) VALUES
(1, '$2y$10$euWpd0NPGyj5hcZLdSJLmeJNP78D68OGAielYGSvnrg8sqMWRt2yW', 3),
(2, '$2y$10$V9gIZJXmi5fvkU4w7fqwU./N.QAErQlug0qoYKLMMGzhTBmueJ8sS', 1),
(3, '$2y$10$MRM9WcH3ksu2/9HGRICLiejj3pWSOXn.fK91LWK6h3TK4en4QDy4G', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `cell_groups`
--
ALTER TABLE `cell_groups`
  ADD PRIMARY KEY (`cellID`),
  ADD KEY `cell_leader` (`cell_leader`);

--
-- Indexes for table `cell_reports`
--
ALTER TABLE `cell_reports`
  ADD KEY `cellID` (`cellID`);

--
-- Indexes for table `church_attendance`
--
ALTER TABLE `church_attendance`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `first_fruits`
--
ALTER TABLE `first_fruits`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `leaders`
--
ALTER TABLE `leaders`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `member_register`
--
ALTER TABLE `member_register`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `mm_purchases`
--
ALTER TABLE `mm_purchases`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`officeID`);

--
-- Indexes for table `partnerships`
--
ALTER TABLE `partnerships`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `privileges_ibfk_1` (`memberID`);

--
-- Indexes for table `special_seeds`
--
ALTER TABLE `special_seeds`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `tithes`
--
ALTER TABLE `tithes`
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD KEY `member` (`memberID`),
  ADD KEY `office` (`officeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cell_groups`
--
ALTER TABLE `cell_groups`
  MODIFY `cellID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_register`
--
ALTER TABLE `member_register`
  MODIFY `memberID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `officeID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cell_groups`
--
ALTER TABLE `cell_groups`
  ADD CONSTRAINT `cell_groups_ibfk_1` FOREIGN KEY (`cell_leader`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cell_reports`
--
ALTER TABLE `cell_reports`
  ADD CONSTRAINT `cell_reports_ibfk_1` FOREIGN KEY (`cellID`) REFERENCES `cell_groups` (`cellID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `church_attendance`
--
ALTER TABLE `church_attendance`
  ADD CONSTRAINT `church_attendance_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `first_fruits`
--
ALTER TABLE `first_fruits`
  ADD CONSTRAINT `first_fruits_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaders`
--
ALTER TABLE `leaders`
  ADD CONSTRAINT `leaders_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mm_purchases`
--
ALTER TABLE `mm_purchases`
  ADD CONSTRAINT `mm_purchases_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partnerships`
--
ALTER TABLE `partnerships`
  ADD CONSTRAINT `partnerships_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `special_seeds`
--
ALTER TABLE `special_seeds`
  ADD CONSTRAINT `special_seeds_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tithes`
--
ALTER TABLE `tithes`
  ADD CONSTRAINT `tithes_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `member` FOREIGN KEY (`memberID`) REFERENCES `member_register` (`memberID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `office` FOREIGN KEY (`officeID`) REFERENCES `offices` (`officeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
