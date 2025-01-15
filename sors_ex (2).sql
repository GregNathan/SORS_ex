-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 04:57 AM
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
-- Database: `sors_ex`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ImportDynamicFile` (IN `FilePath` VARCHAR(255), IN `FileName` VARCHAR(100))   BEGIN
    -- Construct the dynamic SQL query
    SET @query = CONCAT('LOAD DATA INFILE ''', FilePath, '/', FileName, ''' 
                         INTO TABLE your_table_name 
                         FIELDS TERMINATED BY '','' 
                         LINES TERMINATED BY ''\n'' 
                         IGNORE 1 ROWS');

    -- For debugging, you can see the constructed query
    SELECT @query;  -- This will output the constructed query for verification

    -- Execute the constructed query directly
    -- Note: You cannot use PREPARE for LOAD DATA INFILE
    -- Instead, you can run the constructed query directly in your application code
    -- or use a different method to execute it.
    
    -- Execute the constructed query
    -- Since LOAD DATA INFILE cannot be executed as a prepared statement,
    -- you will need to run this command directly in your application code.
    -- MySQL does not support executing LOAD DATA INFILE directly from a variable.
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `fname`, `lname`) VALUES
(1, 'elias', '$2y$10$H7obJEdmLzqqcPy7wQWhsOLUvrgzC8f1Y1or2Gxaza5z1PT0tvLy6', 'Elias', 'Abdurrahman');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `grade`, `section`) VALUES
(1, 7, 2),
(2, 1, 1),
(3, 3, 3),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `files_final`
--

CREATE TABLE `files_final` (
  `file_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filesize` int(11) DEFAULT 0,
  `filetype` varchar(50) DEFAULT NULL,
  `approved_by` varchar(100) NOT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewtype` enum('file','folder') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files_final`
--

INSERT INTO `files_final` (`file_id`, `name`, `filesize`, `filetype`, `approved_by`, `approval_date`, `viewtype`, `file_path`, `uploaded_by`) VALUES
(2, 'Grade 10 Ar.Pan. 1st Q.pdf', 2007241, 'pdf', 'elias', '2025-01-11 06:17:56', 'file', 'F2', 'elias'),
(3, 'AP', 0, 'container', 'elias', '2025-01-11 06:17:59', 'folder', 'F2', 'elias'),
(4, 'testfile.html', 4900, 'html', 'elias', '2025-01-11 07:13:18', 'file', 'AP', 'elias'),
(5, 'marcelo-h-del-pilar-dasalan-at-tocsohan.pdf', 35647, 'pdf', 'elias', '2025-01-11 07:13:23', 'file', 'AP', 'elias'),
(6, 'audio (5) (enhanced).mp3', 7296716, 'mp3', 'Greg', '2025-01-12 09:15:59', 'file', 'Math', 'Greg'),
(7, '@ Alfred.png', 503580, 'png', 'Greg', '2025-01-12 09:16:01', 'file', 'Math', 'Greg'),
(8, 'Math', 0, 'container', 'Greg', '2025-01-12 09:16:03', 'folder', 'F2', 'Greg');

-- --------------------------------------------------------

--
-- Table structure for table `files_pending`
--

CREATE TABLE `files_pending` (
  `file_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(50) NOT NULL,
  `uploaded_by` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewtype` enum('file','folder') NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files_pending2`
--

CREATE TABLE `files_pending2` (
  `folder_id` int(11) NOT NULL,
  `foldername` varchar(255) NOT NULL,
  `uploaded_by` varchar(100) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewtype` enum('file','folder') NOT NULL DEFAULT 'folder',
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `grade` varchar(31) NOT NULL,
  `grade_code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `grade`, `grade_code`) VALUES
(1, '1', 'G'),
(2, '2', 'G'),
(3, '1', 'KG'),
(4, '2', 'KG'),
(7, '3', 'G');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_full_name` varchar(100) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `sender_full_name`, `sender_email`, `message`, `date_time`) VALUES
(1, 'John doe', 'es@gmail.com', 'Hello, world', '2023-02-17 23:39:15'),
(2, 'John doe', 'es@gmail.com', 'Hi', '2023-02-17 23:49:19'),
(3, 'John doe', 'es@gmail.com', 'Hey, ', '2023-02-17 23:49:36'),
(4, 'Greg Nathaniel M. Cañabano', 'gregnathaniel12@gmail.com', 'GYAAAT', '2025-01-03 14:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `registrar_office`
--

CREATE TABLE `registrar_office` (
  `r_user_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(31) NOT NULL,
  `lname` varchar(31) NOT NULL,
  `address` varchar(31) NOT NULL,
  `employee_number` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(31) NOT NULL,
  `qualification` varchar(31) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar_office`
--

INSERT INTO `registrar_office` (`r_user_id`, `username`, `password`, `fname`, `lname`, `address`, `employee_number`, `date_of_birth`, `phone_number`, `qualification`, `gender`, `email_address`, `date_of_joined`) VALUES
(1, 'james', '$2y$10$t0SCfeXNcyiO9hdzNTKKB.j2xlE2yt8Hm2.0AWJR5kSE469JIkHKG', 'James', 'William', 'West Virginia', 843583, '2022-10-04', '+12328324092', 'diploma', 'Male', 'james@j.com', '2022-10-23 01:03:25'),
(2, 'oliver2', '$2y$10$7XhzOu.3OgHPFv7hKjvfUu3waU.8j6xTASj4yIWMfo...k/p8yvvS', 'Oliver2', 'Noah', 'California,  Los angeles', 6546, '1999-06-11', '09457396789', 'BSc, BA', 'Male', 'ov@ab.com', '2022-11-12 23:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(6, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `current_year` int(11) NOT NULL,
  `current_semester` varchar(11) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `slogan` varchar(300) NOT NULL,
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `current_year`, `current_semester`, `school_name`, `slogan`, `about`) VALUES
(1, 2023, 'II', 'Y School', 'Lux et Veritas Light and Truth', 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `grade` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `address` varchar(31) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joined` timestamp NULL DEFAULT current_timestamp(),
  `parent_fname` varchar(127) NOT NULL,
  `parent_lname` varchar(127) NOT NULL,
  `parent_phone_number` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `username`, `password`, `fname`, `lname`, `grade`, `section`, `address`, `gender`, `email_address`, `date_of_birth`, `date_of_joined`, `parent_fname`, `parent_lname`, `parent_phone_number`) VALUES
(1, 'john', '$2y$10$xmtROY8efWeORYiuQDE3SO.eZwscao20QNuLky1Qlr88zDzNNq4gm', 'John', 'Doe', 1, 1, 'California,  Los angeles', 'Male', 'abas55@ab.com', '2012-09-12', '2019-12-11 14:16:44', 'Doe', 'Mark', '09393'),
(3, 'abas', '$2y$10$KLFheMWgpLfoiqMuW2LQxOPficlBiSIJ9.wE2qr5yJUbAQ.5VURoO', 'Abas', 'A.', 2, 1, 'Berlin', 'Male', 'abas@ab.com', '2002-12-03', '2021-12-01 14:16:51', 'dsf', 'dfds', '7979'),
(4, 'jo', '$2y$10$pYyVlWg9jxkT0u/4LrCMS.ztMaOvgyol1hgNt.jqcFEqUC7yZLIYe', 'John3', 'Doe', 1, 1, 'California,  Los angeles', 'Female', 'jo@jo.com', '2013-06-13', '2022-09-10 13:48:49', 'Doe', 'Mark', '074932040'),
(5, 'jo2', '$2y$10$lRQ58lbak05rW7.be8ok4OaWJcb9znRp9ra.qXqnQku.iDrA9N8vy', 'Jhon', 'Doe', 1, 1, 'UK', 'Male', 'jo@jo.com', '1990-02-15', '2023-02-12 18:11:26', 'Doe', 'Do', '0943568654'),
(6, 'Greg', '$2y$10$NZTQsY/OxP4tgMV7yaCw0eMKJsurKvyrF6DrWkbPkE8R3qomadGsq', 'Greg', 'Canabano', 2, 1, 'Maslog/Sibulan/Negros Oriental', 'Male', 'gregnathaniel12@gmail.com', '2009-12-05', '2024-12-26 08:43:06', 'George', 'Alfred', '09189756789'),
(7, 'Johny', '$2y$10$kVXS7x5ztg/RWYinRrcVk.6.DGMqDPZf1hFzf/egLGuYH8Cb76ghW', 'John', 'Edward', 1, 1, 'Sibulan/Negros Oriental', 'Male', 'Eds@gmail.com', '0000-00-00', '2024-12-27 14:16:07', 'Johna', 'Alfred', '09189756799'),
(8, 'Sannie', '$2y$10$z0I8hylzXh.kfNOexS/IeeyqX9Q25Ap6Fv.VyT1zm8nCtZst70YEG', 'San', 'Choi', 1, 1, 'Maslog/Sibulan/Negros Oriental', 'Male', 'isi@gmail.com', '2009-12-09', '2025-01-03 04:38:14', 'yaya', 'ka', 'mamamo');

-- --------------------------------------------------------

--
-- Table structure for table `student_score`
--

CREATE TABLE `student_score` (
  `id` int(11) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `results` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_score`
--

INSERT INTO `student_score` (`id`, `semester`, `year`, `student_id`, `teacher_id`, `subject_id`, `results`) VALUES
(1, 'II', 2021, 1, 1, 1, '10 15,15 20,10 10,10 20,30 35'),
(2, 'II', 2023, 1, 1, 4, '15 20,4 5'),
(3, 'I', 2022, 1, 1, 5, '10 20,50 50');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(31) NOT NULL,
  `subject_code` varchar(31) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject`, `subject_code`, `grade`) VALUES
(1, 'English', 'En', 1),
(2, 'Physics', 'Phy', 2),
(3, 'Biology', 'Bio-01', 1),
(4, 'Math', 'Math-01', 1),
(5, 'Chemistry', 'ch-01', 1),
(6, 'Programming', 'pro-01', 1),
(7, 'Java', 'java-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `class` varchar(31) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(127) NOT NULL,
  `subjects` varchar(31) NOT NULL,
  `address` varchar(31) NOT NULL,
  `employee_number` int(11) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone_number` varchar(31) NOT NULL,
  `qualification` varchar(127) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `username`, `password`, `class`, `fname`, `lname`, `subjects`, `address`, `employee_number`, `date_of_birth`, `phone_number`, `qualification`, `gender`, `email_address`, `date_of_joined`) VALUES
(1, 'oliver', '$2y$10$JruTW/rNZ6CVO4nxYWCrn.GJpiIKMACEPYrK00S7Dk/fkbJIdYau2', '1234', 'Oliver', 'Noah', '1245', 'California,  Los angeles', 6546, '2022-09-12', '0945739', 'BSc', 'Male', 'ol@ab.com', '2022-09-09 05:23:45'),
(5, 'abas', '$2y$10$cMSKcHEJcg3K6wbVcxcXGuksgU39i70aEQVKN7ZHrzqTH9oAc3y5m', '123', 'Abas', 'A.', '12', 'Berlin', 1929, '2003-09-16', '09457396789', 'BSc,', 'Male', 'abas55@ab.com', '2022-09-09 06:42:31'),
(8, 'Rickus', '$2y$10$d9Z5cn1wm17Q0PKe1uiYdOBglWFNXT5wKPHzASheQFgRL0dr0OWM.', '1', 'Rick', 'Diamano', '3', 'Maslog/Sibulan/Negros Oriental', 7779, '1999-04-09', '09187659899', 'I am good at what I do', 'Male', 'Ricks34@gmail.com', '2024-12-26 16:24:28'),
(9, 'Isis', '$2y$10$9eC3HegdTvMxTbJhpAZ2.uonuDq.NU2juUItJ5bM4JA8z5JveGVp.', '1', 'Isi', 'James', '1', 'Maslog/Sibulan/Negros Oriental', 12321, '2001-06-06', '09187659888', 'Mazzulah', 'Male', 'isi@gmail.com', '2024-12-28 15:06:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `files_final`
--
ALTER TABLE `files_final`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `files_pending`
--
ALTER TABLE `files_pending`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `files_pending2`
--
ALTER TABLE `files_pending2`
  ADD PRIMARY KEY (`folder_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `registrar_office`
--
ALTER TABLE `registrar_office`
  ADD PRIMARY KEY (`r_user_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `student_score`
--
ALTER TABLE `student_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `files_final`
--
ALTER TABLE `files_final`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `files_pending`
--
ALTER TABLE `files_pending`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `files_pending2`
--
ALTER TABLE `files_pending2`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registrar_office`
--
ALTER TABLE `registrar_office`
  MODIFY `r_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_score`
--
ALTER TABLE `student_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
