-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2025 at 03:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banque`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `account_type` enum('courant','epargne') NOT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `account_type`, `balance`, `created_at`, `updated_at`) VALUES
(1, 3, 'courant', '100.00', '2025-01-06 15:59:59', '2025-01-06 15:59:59'),
(2, 3, 'epargne', '500.00', '2025-01-07 08:21:40', '2025-01-07 08:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `transaction_type` enum('depot','retrait','transfert') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `beneficiary_account_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` varchar(100) NOT NULL DEFAULT 'user',
  `status` varchar(255) DEFAULT NULL,
  `civility` enum('M.','Mme') DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_pic`, `created_at`, `updated_at`, `role`, `status`, `civility`, `firstname`, `lastname`, `birthdate`, `nationality`, `phone`, `address`, `postal_code`, `city`) VALUES
(1, 'admin', 'admin@banque.com', 'admin', NULL, '2025-01-06 10:38:02', '2025-01-08 11:02:58', 'admin', NULL, 'M.', 'simo', 'zouhairi', '2001-01-01', 'Française', '64654564', '654654', '654', '64654654cdsqsqsdqsd'),
(3, 'yass', 'ayoub@gmail.com', '$2y$10$6GG7IRsGZPFzPiw0ftfll.Sn.Ht/Qzk9bFI7jle92/IcxHzyHFyNe', NULL, '2025-01-06 13:25:09', '2025-01-07 22:39:27', 'user', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'dqsdsqdqsd', 'admin@example.comww', '$2y$10$46LuZA5e9ZF9FuKwnvR5MOxmsCrAXmI0oRJURoNQsSvylQWaVGwxG', NULL, '2025-01-07 10:25:11', '2025-01-08 14:12:51', 'user', 'inactive', 'M.', 'hmeeeedasa', 'ahmedwwwwssdddxxxx', '2000-10-10', 'Autre', '0505050505000', '05050 zsuzujz ', '10200', 'rbatssss'),
(6, 'dqsdqsd', 'ww@ww.ww', '$2y$10$4utseyYvW4d5LayNtTF.NO1ypUsRzN5QmEcvoMRe3Qrbf3VB43dSq', NULL, '2025-01-07 10:26:44', '2025-01-07 10:26:44', 'user', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'wqs', 'admwwin@example.com', '$2y$10$QPJWM7FqMY4R3mD/NYWMFOBVb6LFEqtergpBzzselmjZ10odfyi4m', NULL, '2025-01-07 10:26:51', '2025-01-07 10:27:10', 'user', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'sqsqsd', 'admixwxn@example.com', '$2y$10$gLPeK2tZEeR8gq6Crxh1FOJRaQ4eOLI0LveHXkK5ldU3WbsaHKNt2', NULL, '2025-01-07 10:26:56', '2025-01-07 10:27:11', 'user', 'inactive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'qksjjs', 'jkhkjsqhdjkqsdh@dqsdqsd.sd', '$2y$10$hEQlP39EboYHn1K3BBMNl.nwScNZZFBQENkCsSlAmSiWepL9lNHki', NULL, '2025-01-07 22:31:51', '2025-01-07 22:31:51', 'user', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'simo@simo.com', 'simo@simo.com', '$2y$10$TZOxniLFE5.wmTuYwc2RZuPXDxhEU/8HUCUIxe4nZooXI4yhhfBfG', NULL, '2025-01-08 14:14:25', '2025-01-08 14:15:05', 'user', 'active', 'M.', 'simo', 'simo', '2000-01-01', 'Française', '0505050505', '050505', '0505', '0505'),
(11, 'ayoub@ayoub.com', 'ayoub@ayoub.com', '$2y$10$qPHeqe2IYrrIX6ZVLnZR8.OWSAGMsYsHMnYmeyLL9UG1P1jdWhP5a', NULL, '2025-01-08 14:27:52', '2025-01-08 14:27:52', 'user', 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `beneficiary_account_id` (`beneficiary_account_id`);

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
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`beneficiary_account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
