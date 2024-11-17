-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2023 at 04:54 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobikhata_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `business_cards`
--

CREATE TABLE `business_cards` (
  `id` bigint UNSIGNED NOT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_cards`
--

INSERT INTO `business_cards` (`id`, `business_name`, `phone_number`, `email`, `business_address`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Sudipta0010 Malaker0010', NULL, 'malakersudipta007@gmail.com', NULL, 1, '2023-06-25 11:11:21', '2023-08-15 10:35:40'),
(2, NULL, '+8801795247777', NULL, NULL, 2, '2023-06-25 13:21:09', '2023-06-25 13:21:09'),
(3, 'Sudipta0012 Malaker0012', NULL, 'malakersudipta0011@gmail.com', NULL, 3, '2023-08-15 10:40:03', '2023-08-15 10:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_06_17_041929_create_business_cards_table', 1),
(6, '2023_06_18_063048_create_transactions_table', 1),
(7, '2023_06_25_161210_create_transaction_details_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\User', 2, '+8801795247777', '34df08d70e33f2beef1d5a96e5bf0054a4e606d94b8c33d41ce2578bbca459d9', '[\"*\"]', '2023-06-25 13:21:29', NULL, '2023-06-25 13:21:09', '2023-06-25 13:21:29'),
(7, 'App\\Models\\User', 2, '+8801795247777', '4f9175e0f708a7411c164f1b67531e315e6cb9597ce6d526890112f8276c8a88', '[\"*\"]', NULL, NULL, '2023-08-15 07:35:52', '2023-08-15 07:35:52'),
(14, 'App\\Models\\User', 3, 'malakersudipta0011@gmail.com', 'ac913c978b15b6f9e44a4d7d7f5c0c1564e7243e7463a72b196f085d08446040', '[\"*\"]', NULL, NULL, '2023-08-15 10:40:03', '2023-08-15 10:40:03'),
(15, 'App\\Models\\User', 3, 'malakersudipta0011@gmail.com', '3b9da44ae1fd1de0f8b0c1ec9bbbb413537a80561e235482fa60bbc1cc1f69bb', '[\"*\"]', NULL, NULL, '2023-08-15 10:41:20', '2023-08-15 10:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `take_money` int DEFAULT '0',
  `return_take_money` int DEFAULT '0',
  `give_money` int DEFAULT '0',
  `received_give_money` int DEFAULT '0',
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_name`, `take_money`, `return_take_money`, `give_money`, `received_give_money`, `phone_number`, `note`, `date`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Anta Malaker', 40000, 40000, 0, 0, '+8801795242983', NULL, '2023-06-18', 1, '2023-06-25 11:13:55', '2023-06-25 11:43:59'),
(3, 'Pranta Malaker', 50000, 30000, 0, 0, '+8801795242983', NULL, '2023-06-18', 1, '2023-06-25 11:44:37', '2023-06-25 11:59:58'),
(4, 'Robin Malaker', 0, 0, 3000, 2000, '+8801795242999', 'note', '2023-06-19', 1, '2023-06-25 11:50:43', '2023-06-25 12:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint UNSIGNED NOT NULL,
  `take_money` int DEFAULT '0',
  `return_take_money` int DEFAULT '0',
  `give_money` int DEFAULT '0',
  `received_give_money` int DEFAULT '0',
  `date` date NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `take_money`, `return_take_money`, `give_money`, `received_give_money`, `date`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 40000, 0, 0, 0, '2023-06-18', 2, '2023-06-25 11:13:55', '2023-06-25 11:13:55'),
(2, 0, 10000, 0, 0, '2023-06-25', 2, '2023-06-25 11:36:27', '2023-06-25 11:36:27'),
(4, 0, 10000, 0, 0, '2023-06-25', 2, '2023-06-25 11:39:36', '2023-06-25 11:39:36'),
(5, 0, 10000, 0, 0, '2023-06-25', 2, '2023-06-25 11:42:19', '2023-06-25 11:42:19'),
(6, 0, 10000, 0, 0, '2023-06-25', 2, '2023-06-25 11:43:59', '2023-06-25 11:43:59'),
(7, 50000, 0, 0, 0, '2023-06-18', 3, '2023-06-25 11:44:37', '2023-06-25 11:44:37'),
(8, 0, 10000, 0, 0, '2023-06-25', 3, '2023-06-25 11:44:59', '2023-06-25 11:44:59'),
(9, 0, 10000, 0, 0, '2023-06-25', 3, '2023-06-25 11:45:52', '2023-06-25 11:45:52'),
(10, 0, 0, 3000, 0, '2023-06-19', 4, '2023-06-25 11:50:43', '2023-06-25 11:50:43'),
(11, 0, 10000, 0, 0, '2023-06-25', 3, '2023-06-25 11:59:58', '2023-06-25 11:59:58'),
(12, 0, 0, 0, 1000, '2023-06-25', 4, '2023-06-25 12:01:47', '2023-06-25 12:01:47'),
(13, 0, 0, 0, 1000, '2023-06-25', 4, '2023-06-25 12:02:10', '2023-06-25 12:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sudipta0010', 'Malaker0010', 'malakersudipta007@gmail.com', NULL, NULL, '$2y$10$Fg2ccmwfeH/htj01x72cO.OWc1FmNKPwRUp0ya58kq4ugaSt0t6Gi', NULL, '2023-06-25 11:11:21', '2023-08-15 10:35:39'),
(2, NULL, NULL, NULL, '+8801795247777', NULL, NULL, NULL, '2023-06-25 13:21:09', '2023-06-25 13:21:09'),
(3, 'Sudipta0012', 'Malaker0012', 'malakersudipta0011@gmail.com', NULL, NULL, '$2y$10$UF3E1ysb4VvvWgUbpjF.jeLBAolTaX.uhQO6U7ClGwkn4k7DPdbDu', NULL, '2023-08-15 10:40:03', '2023-08-15 10:41:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business_cards`
--
ALTER TABLE `business_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_cards_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business_cards`
--
ALTER TABLE `business_cards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business_cards`
--
ALTER TABLE `business_cards`
  ADD CONSTRAINT `business_cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
