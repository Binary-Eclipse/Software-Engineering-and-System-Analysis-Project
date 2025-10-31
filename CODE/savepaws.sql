-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 10:29 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


/*Donation*/

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `reason` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 04:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `rescue_reports`
--

CREATE TABLE `rescue_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `animal_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescue_reports`
--

INSERT INTO `rescue_reports` (`id`, `name`, `email`, `animal_type`, `description`, `image`, `location_link`, `created_at`) VALUES
(1, 'fgdfg', 'fdgdfg@fgfsdgd', 'dog', 'sdfgsfvcfsdf', NULL, '', '2025-10-31 08:03:13'),
(2, 'hfghfgfghfg', 'fghfgh@fghfgh', 'cat', 'dfgdfgxcgxdfg', 'uploads/1761897974_doc.jpg', 'https://www.google.com/maps?q=23.7292323,90.4207752', '2025-10-31 08:06:14'),
(3, 'asdasd', 'asds@sdfdf', 'dog', 'asdasdas', NULL, '', '2025-10-31 09:13:44'),
(4, 'dgffrdeg', 'dfgfdg@jhkftge', 'dog', 'dfgfdgdfgfg', NULL, '23.7292323,90.4207752', '2025-10-31 09:20:04'),
(5, 'dgffrdegdfgfd', 'dfgfdg@jhkftge', 'dog', 'dfgfdgdfgfg', NULL, '23.7292323,90.4207752', '2025-10-31 09:20:50'),
(6, 'dfgfd', 'dfgdf@dfgd', 'cat', 'fgfdgdfg', NULL, '23.7292323,90.4207752', '2025-10-31 09:21:03'),
(7, 'cbvcv', 'cxvcxv@fdgfd', 'dog', 'sgsdfdfsdf', NULL, '23.7292323,90.4207752', '2025-10-31 09:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rescue_reports`
--
ALTER TABLE `rescue_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 04:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `date_incident` date NOT NULL,
  `type_incident` varchar(100) NOT NULL,
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
(1, '2025-10-30', 'Physical Harm', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdfsd', 'sdfsdf', 'sdfsdfsd@fddfg', '2025-10-31 09:14:09'),
(2, '2025-11-06', 'Abandonment', 'vhfghfgh', 'fghfgh', 'hgfgfh', 'ghfgh', 'fghfghfghf', 'gfhgh', 'fghfgh@fgsd', '2025-10-31 09:23:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abuse_reports`
--
ALTER TABLE `abuse_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
