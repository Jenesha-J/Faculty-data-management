-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 05:16 PM
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
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `conference_name` varchar(255) NOT NULL,
  `type` enum('National','International') NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `contribution_type` enum('Oral Presentation','Poster','Workshop','Other') NOT NULL,
  `abstract` text NOT NULL,
  `co_authors` text DEFAULT NULL,
  `student_ids` text DEFAULT NULL,
  `student_names` text DEFAULT NULL,
  `certification_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conferences`
--

INSERT INTO `conferences` (`id`, `faculty_id`, `conference_name`, `type`, `city`, `country`, `start_date`, `end_date`, `title`, `contribution_type`, `abstract`, `co_authors`, `student_ids`, `student_names`, `certification_link`) VALUES
(9, 10, 'IEE Conference', 'National', 'Chennai', 'India', '2024-09-02', '0000-00-00', 'Cloud Data management', 'Oral Presentation', 'Cloud data management encompasses the processes and technologies used to store, manage, and analyze data in cloud environments. As organizations increasingly migrate to cloud-based solutions, effective data management becomes crucial for ensuring data integrity, accessibility, and security.', 'Dr.A.Karthik', '2111099,2111111', 'Mathesh M\r\nSam.J', 'https://drive.google.com/file/d/1-UtrlD3Lvd-z4v0RP9DwhGuVi7YoMGpz/view');

-- --------------------------------------------------------

--
-- Table structure for table `consultancy`
--

CREATE TABLE `consultancy` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `consultancy_type` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `worth` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultancy`
--

INSERT INTO `consultancy` (`id`, `faculty_id`, `consultancy_type`, `company_name`, `year`, `worth`) VALUES
(1, 10, 'Management Consultancy', 'DFE', 2012, 100000.00),
(2, 10, 'Management Consultancy', 'QWE', 2024, 100500.00),
(3, 10, 'Management Consultancy', 'whu', 2024, 100500.00);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '12345678',
  `department` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_name`, `email`, `password`, `department`, `phone`, `profile_image`, `date_of_joining`, `qualification`, `reset_token`, `token_expiry`) VALUES
(1, 'Jenesha J', '2111054@nec.edu.in', 'Jenesha#24', 'ECE', '9500333828', 'JENESHA_PHOTO.jpg', NULL, NULL, '23e83671ca0d9219eff571f92d82f1a500bfbffc2c107074ee622c2a11115cbac29b6a77a96cd375753b8111b81f719921ca', NULL),
(2, 'Mathi', '2111115@nec.edu.in', 'MAthi@01', 'ECE', '8897923752', 'WhatsApp Image 2024-06-02 at 11.00.11_69f46ac3.jpg', NULL, NULL, NULL, NULL),
(6, 'Iswarya', '2111053@nec.edu.in', 'Ishu#123', 'IT', '1230456789', 'Ishu PIc.jpg', NULL, NULL, NULL, NULL),
(10, 'Seethalakshmi A', '2111064@nec.edu.in', 'Seetha!001', 'ECE', '1239874508', 'pro-seetha.jpg', '2024-09-05', 'B.E', NULL, NULL),
(11, 'Sara M', '2111113@nec.edu.in', 'Sara@13', 'AIDS', '5469871235', 'WhatsApp Image 2024-09-27 at 13.40.50_351fb85d.jpg', '2024-09-30', 'M.E', '1931ef5f122386d1a6218d7e6d5d17d112fc08766de40647b38d7d578d76ab1d4dc03c71514d880f97e9f62aedec9f2db421', '2024-10-04 15:02:05'),
(12, 'Mithran H', '110011@nec.edu.in', 'Mithran))8', 'CSE', '1234567895', 'men.jpg', '2024-09-19', 'B.E', NULL, NULL),
(13, 'Latha K', 'abc123@gmail.com', 'abc!12', 'S&H', '1245367895', 'JENEFA.jpg', '2024-10-31', 'PHd', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `journal_name` varchar(255) NOT NULL,
  `publication_date` date NOT NULL,
  `scopus_sci` enum('Scopus','Sci') NOT NULL,
  `paper_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`id`, `faculty_id`, `journal_name`, `publication_date`, `scopus_sci`, `paper_link`) VALUES
(1, 10, 'ABC', '2024-09-10', 'Scopus', 'https://drive.google.com/file/d/1-UtrlD3Lvd-z4v0RP9DwhGuVi7YoMGpz/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_upgrade`
--

CREATE TABLE `knowledge_upgrade` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_upgrade`
--

INSERT INTO `knowledge_upgrade` (`id`, `faculty_id`, `category`, `date`, `description`, `certificate`) VALUES
(9, 1, 'FDP', '2024-09-12', 'Intern', 'https://drive.google.com/file/d/16tXfZFOQ-T4Wu0agw4P7V-a6JhY9W5HB/view?usp=drive_link'),
(10, 1, 'FDP', '2024-09-12', 'Intern', 'https://drive.google.com/file/d/16tXfZFOQ-T4Wu0agw4P7V-a6JhY9W5HB/view?usp=drive_link'),
(12, 6, 'Industrial Knowledge', '2024-09-07', 'Mistral Internship', 'https://drive.google.com/file/d/1LDJPCqFjg1DwIz6-eamoWWYGktyWWTVc/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_upgrade_fdp`
--

CREATE TABLE `knowledge_upgrade_fdp` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_upgrade_fdp`
--

INSERT INTO `knowledge_upgrade_fdp` (`id`, `faculty_id`, `program_name`, `duration`, `start_date`, `end_date`, `certificate`) VALUES
(1, 10, 'Faculty Devp Pro', 1, '2024-09-11', '0000-00-00', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link'),
(2, 10, 'Faculty', 2, '2024-09-05', '2024-09-07', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link'),
(3, 10, 'Faculty', 2, '2024-09-13', '2024-09-15', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link'),
(8, 10, 'sowhd', 5, '2024-09-01', '2024-09-06', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_upgrade_industrial`
--

CREATE TABLE `knowledge_upgrade_industrial` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_upgrade_industrial`
--

INSERT INTO `knowledge_upgrade_industrial` (`id`, `faculty_id`, `company_name`, `duration`, `start_date`, `end_date`, `description`, `certificate`) VALUES
(1, 10, 'ABC', 1, '2024-08-01', '2024-09-08', 'Happy ending......', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view'),
(2, 10, 'DFE', 1, '2023-02-20', '2024-09-04', ' cdlcnap;c', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_upgrade_nptel`
--

CREATE TABLE `knowledge_upgrade_nptel` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `institution_name` varchar(255) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_upgrade_nptel`
--

INSERT INTO `knowledge_upgrade_nptel` (`id`, `faculty_id`, `course_name`, `instructor_name`, `institution_name`, `duration`, `start_date`, `end_date`, `certificate`) VALUES
(1, 10, 'Python', 'Mr.T.Ramesh', 'IIT Madras', '12', '2024-06-01', '2024-08-01', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link'),
(2, 10, 'Python', 'Mr.T.suresh', 'IIT Madras', '12', '2024-09-10', '2024-09-21', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_upgrade_workshop`
--

CREATE TABLE `knowledge_upgrade_workshop` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `workshop_name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knowledge_upgrade_workshop`
--

INSERT INTO `knowledge_upgrade_workshop` (`id`, `faculty_id`, `workshop_name`, `duration`, `start_date`, `end_date`, `certificate`, `description`) VALUES
(3, 10, 'Training', 3, '2024-09-06', '2024-09-07', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link', 'dcnadoc'),
(4, 1, 'Training', 5, '2024-09-26', '2024-09-06', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view?usp=drive_link', 'cknc'),
(5, 10, 'PCB', 1, '2024-10-18', '0000-00-00', 'https://drive.google.com/file/d/1nW9YbQ3y09tQnNUVZ1EtjiWBUduo2u8R/view', 'Fabrication of PCB,Eagle CAD');

-- --------------------------------------------------------

--
-- Table structure for table `patents`
--

CREATE TABLE `patents` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `year_of_publication` year(4) NOT NULL,
  `status` enum('Granted','Pending','Rejected') NOT NULL,
  `report_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patents`
--

INSERT INTO `patents` (`id`, `faculty_id`, `product_name`, `description`, `year_of_publication`, `status`, `report_link`) VALUES
(2, 10, 'Solar Tracking', 'Solar tracking involves using a mechanism to move solar panels so they follow the sun&#039;s path across the sky, which can significantly increase energy production compared to fixed installations.', '2024', 'Pending', 'https://drive.google.com/drive/folders/1-luZtJs7rrYlDb4HO0cv67MsfWKpPyIs');

-- --------------------------------------------------------

--
-- Table structure for table `recognition`
--

CREATE TABLE `recognition` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `award_name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recognition`
--

INSERT INTO `recognition` (`id`, `faculty_id`, `award_name`, `date`, `description`, `photo`) VALUES
(4, 1, 'Excellent researcher', '2024-09-20', 'An award for excellence in research', 'https://drive.google.com/file/d/1TeDi6OD3tKFWw4v8BjQe4Vv0W6VY_iei/view?usp=drive_link'),
(5, 1, 'Best Volunteer', '2024-03-06', 'Awarded as the best volunteer of the year', 'https://drive.google.com/file/d/1TeDi6OD3tKFWw4v8BjQe4Vv0W6VY_iei/view?usp=drive_link'),
(6, 10, 'Best Volunteer', '2024-09-26', 'Rotaract Club', 'https://drive.google.com/file/d/1-UtrlD3Lvd-z4v0RP9DwhGuVi7YoMGpz/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `research`
--

CREATE TABLE `research` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `research`
--

INSERT INTO `research` (`id`, `faculty_id`, `category`, `title`, `date`, `description`, `file_upload`) VALUES
(1, 1, 'Conference', 'Hackathon', '2024-09-01', 'Smart city safe city (SOS)', 'https://drive.google.com/file/d/1ln9mY_s_ijzk4wTn94fUDOJj96qAHnNF/view?usp=drive_link');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `consultancy`
--
ALTER TABLE `consultancy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `knowledge_upgrade`
--
ALTER TABLE `knowledge_upgrade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `knowledge_upgrade_fdp`
--
ALTER TABLE `knowledge_upgrade_fdp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `knowledge_upgrade_industrial`
--
ALTER TABLE `knowledge_upgrade_industrial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `knowledge_upgrade_nptel`
--
ALTER TABLE `knowledge_upgrade_nptel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `knowledge_upgrade_workshop`
--
ALTER TABLE `knowledge_upgrade_workshop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `patents`
--
ALTER TABLE `patents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `recognition`
--
ALTER TABLE `recognition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `research`
--
ALTER TABLE `research`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `consultancy`
--
ALTER TABLE `consultancy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `knowledge_upgrade`
--
ALTER TABLE `knowledge_upgrade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `knowledge_upgrade_fdp`
--
ALTER TABLE `knowledge_upgrade_fdp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `knowledge_upgrade_industrial`
--
ALTER TABLE `knowledge_upgrade_industrial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `knowledge_upgrade_nptel`
--
ALTER TABLE `knowledge_upgrade_nptel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `knowledge_upgrade_workshop`
--
ALTER TABLE `knowledge_upgrade_workshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patents`
--
ALTER TABLE `patents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recognition`
--
ALTER TABLE `recognition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `research`
--
ALTER TABLE `research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conferences`
--
ALTER TABLE `conferences`
  ADD CONSTRAINT `conferences_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultancy`
--
ALTER TABLE `consultancy`
  ADD CONSTRAINT `consultancy_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_upgrade`
--
ALTER TABLE `knowledge_upgrade`
  ADD CONSTRAINT `knowledge_upgrade_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `knowledge_upgrade_fdp`
--
ALTER TABLE `knowledge_upgrade_fdp`
  ADD CONSTRAINT `knowledge_upgrade_fdp_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_upgrade_industrial`
--
ALTER TABLE `knowledge_upgrade_industrial`
  ADD CONSTRAINT `knowledge_upgrade_industrial_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_upgrade_nptel`
--
ALTER TABLE `knowledge_upgrade_nptel`
  ADD CONSTRAINT `knowledge_upgrade_nptel_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knowledge_upgrade_workshop`
--
ALTER TABLE `knowledge_upgrade_workshop`
  ADD CONSTRAINT `knowledge_upgrade_workshop_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patents`
--
ALTER TABLE `patents`
  ADD CONSTRAINT `patents_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recognition`
--
ALTER TABLE `recognition`
  ADD CONSTRAINT `recognition_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);

--
-- Constraints for table `research`
--
ALTER TABLE `research`
  ADD CONSTRAINT `research_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
