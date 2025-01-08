-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2025 at 08:38 AM
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
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_pic`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'admin', 'admin@banque.com', 'admin', NULL, '2025-01-06 10:38:02', '2025-01-06 10:38:02', 'admin', 'active'),
(3, 'ayoub', 'ayoub@gmail.com', '$2y$10$6GG7IRsGZPFzPiw0ftfll.Sn.Ht/Qzk9bFI7jle92/IcxHzyHFyNe', NULL, '2025-01-06 13:25:09', '2025-01-06 13:25:09', 'user', 'active');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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



-- hadi bach nzido rows dial infos dial user

USE banque;
ALTER TABLE users
ADD COLUMN civility ENUM('M.', 'Mme') DEFAULT NULL,
ADD COLUMN firstname VARCHAR(100) DEFAULT NULL,
ADD COLUMN lastname VARCHAR(100) DEFAULT NULL,
ADD COLUMN birthdate DATE DEFAULT NULL,
ADD COLUMN nationality VARCHAR(100) DEFAULT NULL,
ADD COLUMN phone VARCHAR(20) DEFAULT NULL,
ADD COLUMN address VARCHAR(255) DEFAULT NULL,
ADD COLUMN postal_code VARCHAR(10) DEFAULT NULL,
ADD COLUMN city VARCHAR(100) DEFAULT NULL;

ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT '';
