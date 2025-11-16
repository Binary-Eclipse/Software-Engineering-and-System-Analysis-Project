-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 05:23 PM
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
-- Database: `savepaws`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuse_reports`
--

CREATE TABLE `abuse_reports` (
  `id` int(11) NOT NULL,
  `date_incident` varchar(20) NOT NULL,
  `type_incident` varchar(50) NOT NULL,
  `incident_address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `detailed_description` text NOT NULL,
  `reporter_name` varchar(100) DEFAULT NULL,
  `reporter_email` varchar(100) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abuse_reports`
--

INSERT INTO `abuse_reports` (`id`, `date_incident`, `type_incident`, `incident_address`, `city`, `state`, `zip_code`, `detailed_description`, `reporter_name`, `reporter_email`, `submitted_at`) VALUES
(1, '2025-11-03', 'Neglect', 'Vatara,Notunbaza', 'Dhaka', 'dgaga', '1212', 'rtrerreerferfefr', 'Helal Uddin Patwary', 't@gmail.com', '2025-11-09 13:30:35'),
(2, '2025-11-06', 'Physical Harm', 'Vatara,Notunbaza', 'Dhaka', 'dhaka', '1212', 'ggggf', 'Helal Uddin Patwary', 't@gmail.com', '2025-11-09 23:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `application_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adopter_name` varchar(150) NOT NULL,
  `adopter_email` varchar(100) NOT NULL,
  `adopter_address` text NOT NULL,
  `adopter_nid` varchar(20) NOT NULL,
  `adopter_contact` varchar(20) NOT NULL,
  `agree_care` tinyint(1) NOT NULL DEFAULT 0,
  `agree_visit` tinyint(1) NOT NULL DEFAULT 0,
  `agree_return` tinyint(1) NOT NULL DEFAULT 0,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`application_id`, `pet_id`, `adopter_name`, `adopter_email`, `adopter_address`, `adopter_nid`, `adopter_contact`, `agree_care`, `agree_visit`, `agree_return`, `application_date`) VALUES
(1, 2, 'Helal Uddin Patwary', 'f@gmail.com', 'Vatara,Notunbaza', '4555', '56565655556', 1, 1, 1, '2025-11-09 14:09:39'),
(2, 2, 'rock', 'n@gmail.com', 'Lat: 23.7984, Lon: 90.4237', '454545t54', '56565655556', 1, 1, 1, '2025-11-09 14:26:36'),
(3, 2, 'nobita', 'f@gmail.com', 'Vatara,Notunbaza', '56y6756', '56565655556', 1, 1, 1, '2025-11-09 14:43:21'),
(4, 2, 'hh', 'f@gmail.com', 'https://maps.google.com/?q=23.798411,90.424900', '454545t54', '56565655556', 1, 1, 1, '2025-11-09 23:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `clinic_id` int(11) NOT NULL,
  `clinic_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `main_doctor` varchar(100) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `days_open` varchar(50) NOT NULL COMMENT 'e.g., Sun Mon Tu Wed Thu Fri Sat',
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_appointments`
--

CREATE TABLE `doctor_appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_name` varchar(150) NOT NULL,
  `doctor_specialty` varchar(150) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `patient_name` varchar(150) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `owner_email` varchar(100) DEFAULT NULL,
  `owner_nid` varchar(20) DEFAULT NULL,
  `reason_for_visit` text NOT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_appointments`
--

INSERT INTO `doctor_appointments` (`appointment_id`, `doctor_name`, `doctor_specialty`, `appointment_date`, `appointment_time`, `patient_name`, `contact_number`, `owner_email`, `owner_nid`, `reason_for_visit`, `submission_time`) VALUES
(1, 'Dr. Urmi', 'Cardiology & Internal Medicine', '2025-11-11', '09:00:00', '565', '098', 'admin@app.com', '6775', 'tt', '2025-11-09 18:30:36'),
(2, 'Dr. Urmi', 'Cardiology & Internal Medicine', '2025-11-13', '15:00:00', 'jj', 'g', 'shakilpatwarycs@gmail.com', '566', 't', '2025-11-09 23:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `donated_pets`
--

CREATE TABLE `donated_pets` (
  `donation_id` int(11) NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `owner_name` varchar(150) NOT NULL,
  `owner_email` varchar(100) NOT NULL,
  `owner_phone` varchar(20) NOT NULL,
  `rehoming_reason` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donated_pets`
--

INSERT INTO `donated_pets` (`donation_id`, `pet_name`, `species`, `breed`, `age`, `gender`, `description`, `owner_name`, `owner_email`, `owner_phone`, `rehoming_reason`, `photo_path`, `submission_date`) VALUES
(1, 'ss', 'Dog', 'ff', '6', 'Male', 'dd', 'ff', 'ff@gmail.com', 'ff', 'ddf', 'uploads_donated_petpet_690f10c12bb38.png', '2025-11-08 09:43:29'),
(2, 'ss', 'Dog', 'hh', '6', 'Male', 'jk', 'Helal Uddin Patwary', 'a@gmail.com', 'ff', 'hhhh', 'uploads_donated_petpet_690f13b2d94f6.png', '2025-11-08 09:56:02'),
(3, 'hh', 'Cat', 'hh', 'ff', 'Male', 'fg', 'Helal Uddin Patwary', 'a@gmail.com', '0978777', 'tytytyt', 'uploads_donated_petpet_69108e68b2895.png', '2025-11-09 12:51:52'),
(4, 'ss', 'Rabbit', 'hh', '6', 'Male', 'gfg', 'Helal Uddin Patwary', 'a@gmail.com', 'ff', 'gf', 'uploads_donated_petpet_69109c3c6a18f.png', '2025-11-09 13:50:52'),
(5, 'ss', 'Rabbit', 'hh', '6', 'Male', '67767', 'Helal Uddin Patwary', 'a@gmail.com', '0978777', '7uy', 'uploads_donated_petpet_6910a18aa4173.jpg', '2025-11-09 14:13:30'),
(6, 'cutie', 'Dog', 'cvcvc', '23', 'Male', 'adds', 'joy', 'joy@gmail.com', '0978777', 'fafd', 'uploads_donated_petpet_6910a1fa5584e.png', '2025-11-09 14:15:22'),
(7, 'ss', 'Dog', 'hh', '6', 'Male', 'dggffgg', 'Helal Uddin Patwary', 'ff@gmail.com', 'ff', 'gfgggfgf', 'uploads_donated_petpet_6910a31ec0cbb.png', '2025-11-09 14:20:14'),
(8, 'ss', 'Other', 'hggdd', '6', 'Male', 'ggfdfgvfrffr', 'rock', 'r@gmail.com', '0867654343', 'ffvv v', 'uploads_donated_petpet_6910a4eae7a47.png', '2025-11-09 14:27:54'),
(9, 'manush', 'Dog', 'ff', '23', 'Male', 'dfdd', 'Helal Uddin Patwary', 'ff@gmail.com', '0978777', 'now', 'uploads_donated_petpet_6910a8d60ebf9.png', '2025-11-09 14:44:38'),
(10, 'ss', 'Dog', 'hh', 'ff', 'Male', 'k', 'Helal Uddin Patwary', 'a@gmail.com', '0978777', 'jhhbjh', 'uploads_donated_petpet_69111ea72c824.avif', '2025-11-09 23:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(11) NOT NULL,
  `donor_email` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(20) NOT NULL,
  `reason` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `cardholder_name` varchar(255) DEFAULT NULL,
  `card_number_last_four` varchar(4) DEFAULT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `donor_email`, `amount`, `type`, `reason`, `payment_method`, `transaction_id`, `cardholder_name`, `card_number_last_four`, `donation_date`) VALUES
(1, '', 100.00, 'Monthly', 'rtrtgrt', 'Card', 'SP17626991956017', 'SHkail', '8445', '2025-11-09 14:39:55'),
(2, '', 1000.00, 'Monthly', 'buo', 'Bank', 'SP17626995225389', 'Helal', NULL, '2025-11-09 14:45:22'),
(3, '', 100.00, 'Monthly', '333', 'Card', 'SP17627224257352', '33', '23', '2025-11-09 21:07:05'),
(4, '', 100.00, 'One Time', 'ggg', 'Card', 'SP17627241886266', 'gg', NULL, '2025-11-09 21:36:28'),
(5, 'ornob@gmail.com', 500.00, 'Monthly', 'uu', 'Card', 'SP17627255321037', 'Card Payment', NULL, '2025-11-09 21:58:52'),
(6, 'ornob@gmail.com', 1000.00, 'One Time', 'ffff', 'Card', 'SP17627275991806', 'Card Payment', NULL, '2025-11-09 22:33:19'),
(7, 'ornob@gmail.com', 500.00, 'One Time', 'hh', 'Card', 'SP17627295843282', 'Card Payment', NULL, '2025-11-09 23:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `first_aid_requests`
--

CREATE TABLE `first_aid_requests` (
  `request_id` int(11) NOT NULL,
  `pet_type` varchar(50) NOT NULL,
  `pet_name` varchar(100) DEFAULT NULL,
  `urgency_level` varchar(50) NOT NULL,
  `owner_full_name` varchar(150) NOT NULL,
  `owner_phone_number` varchar(20) NOT NULL,
  `owner_email` varchar(100) DEFAULT NULL,
  `situation_description` text NOT NULL,
  `symptoms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`symptoms`)),
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `injury_photo_path` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`injury_photo_path`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `first_aid_requests`
--

INSERT INTO `first_aid_requests` (`request_id`, `pet_type`, `pet_name`, `urgency_level`, `owner_full_name`, `owner_phone_number`, `owner_email`, `situation_description`, `symptoms`, `submission_time`, `injury_photo_path`) VALUES
(1, 'Cat', 'hh', 'Critical', 'Helal Uddin Patwary', '555', 'r@gmail.com', 'ghg', '[\"Pain\\/Distress\"]', '2025-11-09 23:08:52', '[\"upload_first_aid_image\\/firstaid_69111f04ccdff.png\"]');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 50.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'Processing',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `shipping_address`, `total_amount`, `shipping_cost`, `payment_method`, `order_status`, `order_date`) VALUES
(1, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'card', 'Processing', '2025-11-08 10:13:00'),
(2, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'card', 'Processing', '2025-11-08 10:13:04'),
(3, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'card', 'Processing', '2025-11-08 10:13:21'),
(4, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'card', 'Processing', '2025-11-08 10:13:27'),
(5, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'card', 'Processing', '2025-11-08 10:13:34'),
(6, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'mobile', 'Processing', '2025-11-08 10:13:45'),
(7, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 1000.00, 50.00, 'mobile', 'Processing', '2025-11-08 10:14:36'),
(8, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:17:24'),
(9, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:20:19'),
(10, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:20:40'),
(11, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:20:44'),
(12, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:21:15'),
(13, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:22:18'),
(14, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:22:21'),
(15, 'Helal Uddin Patwary', 'admin@library.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 10:26:26'),
(16, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 16:59:56'),
(17, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 17:00:00'),
(18, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 17:00:04'),
(19, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 17:00:26'),
(20, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-08 17:00:38'),
(21, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 11050.00, 50.00, 'card', 'Processing', '2025-11-09 13:27:18'),
(22, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 20:40:49'),
(23, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 1850.00, 50.00, 'card', 'Processing', '2025-11-09 21:06:40'),
(24, 'ornob', 'ornob@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 21:17:51'),
(25, 'Helal Uddin Patwary', 'ornob@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 21:41:41'),
(26, 'Helal Uddin Patwary', 'shakilpatwarycs@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 21:59:31'),
(27, 'Helal Uddin Patwary', 'ornob@gmail.com', 'Vatara,Notunbaza', 2550.00, 50.00, 'card', 'Processing', '2025-11-09 22:00:09'),
(28, 'Helal Uddin Patwary', 'ornob@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 22:01:45'),
(29, 'Helal Uddin Patwary', 'ornob@gmail.com', 'Vatara,Notunbaza', 1550.00, 50.00, 'card', 'Processing', '2025-11-09 22:11:31'),
(30, 'ornob', 'ornob@gmail.com', 'Vatara,Notunbaza', 5550.00, 50.00, 'card', 'Processing', '2025-11-09 22:19:59'),
(31, 'ornob', 'ornob@gmail.com', 'Vatara,Notunbaza', 2550.00, 50.00, 'card', 'Processing', '2025-11-09 22:32:57'),
(32, 'Helal Uddin Patwary', 'a@gmail.com', 'Vatara,Notunbaza', 2550.00, 50.00, 'card', 'Processing', '2025-11-09 23:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`) VALUES
(1, 1, 9, 'Chewable Dog Treats', 950.00, 1),
(2, 2, 9, 'Chewable Dog Treats', 950.00, 1),
(3, 3, 9, 'Chewable Dog Treats', 950.00, 1),
(4, 4, 9, 'Chewable Dog Treats', 950.00, 1),
(5, 5, 9, 'Chewable Dog Treats', 950.00, 1),
(6, 6, 9, 'Chewable Dog Treats', 950.00, 1),
(7, 7, 9, 'Chewable Dog Treats', 950.00, 1),
(8, 8, 1, 'Pedigree Dog Food', 5500.00, 1),
(9, 9, 1, 'Pedigree Dog Food', 5500.00, 1),
(10, 10, 3, 'Whiskas Cat Food', 5500.00, 1),
(11, 11, 3, 'Whiskas Cat Food', 5500.00, 1),
(12, 12, 3, 'Whiskas Cat Food', 5500.00, 1),
(13, 13, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(14, 14, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(15, 15, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(16, 16, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(17, 17, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(18, 18, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(19, 19, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(20, 20, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(21, 21, 2, 'Nature Recipe Dog Food', 5500.00, 2),
(22, 22, 3, 'Whiskas Cat Food', 5500.00, 1),
(23, 23, 10, 'Stylish Dog Sweater', 1800.00, 1),
(24, 24, 3, 'Whiskas Cat Food', 5500.00, 1),
(25, 25, 2, 'Nature Recipe Dog Food', 5500.00, 1),
(26, 26, 3, 'Whiskas Cat Food', 5500.00, 1),
(27, 27, 6, 'Cozy Pet Bed', 2500.00, 1),
(28, 28, 7, 'Petslife Bird Food', 5500.00, 1),
(29, 29, 8, 'Flea & Tick Medicine', 1500.00, 1),
(30, 30, 7, 'Petslife Bird Food', 5500.00, 1),
(31, 31, 6, 'Cozy Pet Bed', 2500.00, 1),
(32, 32, 6, 'Cozy Pet Bed', 2500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rescue_reports`
--

CREATE TABLE `rescue_reports` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `animal_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescue_reports`
--

INSERT INTO `rescue_reports` (`id`, `name`, `email`, `animal_type`, `description`, `image`, `location`, `created_at`) VALUES
(1, 'Helal Uddin Patwary', 'nurulhuda912334@gmail.com', 'cat', 'gg', 'uploads/1762694958_6910972e14aaa.jpg', 'https://maps.google.com/?q=23.7984146,90.4237213', '2025-11-09 13:29:18'),
(2, 'Helal Uddin Patwary', 'a@gmail.com', 'cat', 'ghhhgh', 'uploads/1762729671_69111ec77ba53.jpg', 'https://maps.google.com/?q=23.7984114,90.4248998', '2025-11-09 23:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `request_id` int(11) NOT NULL,
  `selected_services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`selected_services`)),
  `client_name` varchar(150) NOT NULL,
  `pet_names` varchar(255) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_phone` varchar(20) NOT NULL,
  `pet_type` varchar(50) NOT NULL,
  `pet_breed` varchar(100) DEFAULT NULL,
  `service_location` varchar(255) NOT NULL,
  `help_description` text DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`request_id`, `selected_services`, `client_name`, `pet_names`, `client_email`, `client_phone`, `pet_type`, `pet_breed`, `service_location`, `help_description`, `submission_time`) VALUES
(1, '[\"vaccination\"]', 'Helal Uddin Patwary', 'ggg', 'q@gmail.com', '67', 'Dog', 'hh', 'rtt', 'gg', '2025-11-09 23:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact_number`, `password`, `registration_date`) VALUES
(1, 'Helal Uddin Patwary', 'n@gmail.com', '123', '$2y$10$R3c8B7HKAjAJ14Z6N7xWY.MVAHCEddSPkYAn8ntrET00peN7GL2a.', '2025-11-08 10:32:22'),
(2, 'Helal Uddin', 'new@gmail.com', '01987762332', '$2y$10$58Ah3t7A0mjokk2IXmE.7OR5UOW0PcrlUBHfDoEmplAibmonNv74K', '2025-11-08 16:26:39'),
(3, 'Helal Uddin Patwary', 'am@gmail.com', '8976', '$2y$10$NvhEKnPL5NHfwGhwSyLUV.hbQ2bsHI6heNlmqVfBVgCqhNBaubVaS', '2025-11-08 17:45:35'),
(11, 'nn', 'b@gmail.com', '01987762332', '$2y$10$jvCsYeA7TCndERkulnwT5.CtAQdLTzQ0mZxa/Hn/LH0WmbrMgWsCq', '2025-11-09 19:22:30'),
(12, 'Helal Uddin Patwary', 'bb@gmail.com', '01987762332', '$2y$10$S113Djrv3ZhJXlf5jYDS1edoEqC.DhzaRZOerCYkwY47FNKgskxJW', '2025-11-09 19:27:48'),
(13, 'Helal Uddin Patwary', 'x@gmail.com', '01987762332', '$2y$10$Zj2xkMS1eJLRHMpi3Xo1N.D9aWhq2Bfyx7NRBDTXiuynCrB8Zb3OC', '2025-11-09 19:46:32'),
(14, 'ornob ahmed', 'ornob@gmail.com', '9999999', '$2y$10$/9VOV.xoT5wRnY3brNathOi20zDIeBeBL/XXEv9cIOHq.Vyklv0KG', '2025-11-09 21:16:38'),
(15, 'Helal Uddin Patwary', '23@gmail.com', '8976', '$2y$10$kRocHKx10l7pLKx3Wt3DkO0bMJakl/ZiVoZZasFR76FZxyNrl1bbO', '2025-11-10 00:45:45'),
(16, 'tutul', 'tutul@gmail.com', '999999999999', '$2y$10$1fFLMyMo8G3JejdK7gQur.0qnOI4qfaaIYR9fph8nk5fpqKMJ2JU2', '2025-11-16 15:40:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `doctor_appointments`
--
ALTER TABLE `doctor_appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `donated_pets`
--
ALTER TABLE `donated_pets`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `first_aid_requests`
--
ALTER TABLE `first_aid_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `clinic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_appointments`
--
ALTER TABLE `doctor_appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donated_pets`
--
ALTER TABLE `donated_pets`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `first_aid_requests`
--
ALTER TABLE `first_aid_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
