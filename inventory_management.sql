-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2023 at 03:45 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_10_103703_create_raw_materials_table', 1),
(6, '2023_03_11_114801_create_permission_tables', 1),
(7, '2023_03_11_143842_create_raw_material_requests_table', 1),
(8, '2023_03_11_153604_create_raw_mat_req_confirmations_table', 1),
(9, '2023_03_13_081826_create_production_materials_table', 1),
(10, '2023_03_13_082033_create_production_material_requests_table', 1),
(11, '2023_03_13_082229_create_production_mat_req_confirmations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'permission-list', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(2, 'permission-create', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(3, 'permission-edit', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(4, 'permission-delete', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(5, 'role-list', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(6, 'role-create', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(7, 'role-edit', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(8, 'role-delete', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(9, 'material-list', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(10, 'material-create', 'web', '2023-03-13 03:10:13', '2023-03-13 03:10:13'),
(11, 'material-edit', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(12, 'material-delete', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(13, 'user-list', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(14, 'user-create', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(15, 'user-edit', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(16, 'user-delete', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(17, 'raw-req-list', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(18, 'raw-req-create', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(19, 'raw-req-edit', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(20, 'raw-req-delete', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(21, 'raw-req-confirm', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(22, 'production-req-list', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(23, 'production-req-create', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(24, 'production-req-edit', 'web', '2023-03-13 03:14:53', '2023-03-13 03:14:53'),
(25, 'production-req-delete', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06'),
(26, 'production-req-confirm', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06'),
(27, 'production-create', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06'),
(28, 'production-list', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06'),
(29, 'production-edit', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06'),
(30, 'production-delete', 'web', '2023-03-13 03:17:06', '2023-03-13 03:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_materials`
--

CREATE TABLE `production_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `pac_size` tinyint(3) UNSIGNED NOT NULL COMMENT '1 => 1 ltr, 2 => 2 ltr, 5 => 5 ltr, etc.',
  `material_quantity` mediumint(8) UNSIGNED NOT NULL COMMENT 'quantity in piece',
  `req_handler_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_materials`
--

INSERT INTO `production_materials` (`id`, `material_name`, `raw_material_id`, `pac_size`, `material_quantity`, `req_handler_role`, `created_at`, `updated_at`) VALUES
(2, 'Soyabean Oil', 3, 5, 0, 'Production Request Handler', '2023-03-13 08:11:15', '2023-03-13 08:11:15'),
(3, 'Soyabean Oil', 3, 1, 77, 'Production Request Handler', '2023-03-13 08:43:20', '2023-03-13 14:41:32'),
(4, 'Soyabean Oil', 3, 2, 0, 'Production Request Handler', '2023-03-13 12:08:31', '2023-03-13 12:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `production_material_requests`
--

CREATE TABLE `production_material_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `production_material_id` bigint(20) UNSIGNED NOT NULL,
  `production_material_quantity` mediumint(8) UNSIGNED NOT NULL COMMENT 'quantity in piece',
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_material_requests`
--

INSERT INTO `production_material_requests` (`id`, `production_material_id`, `production_material_quantity`, `requested_by`, `cancelled_by`, `created_at`, `updated_at`) VALUES
(6, 3, 10, 1, NULL, '2023-03-13 13:08:18', '2023-03-13 13:08:18'),
(7, 3, 15, 1, 5, '2023-03-13 13:08:36', '2023-03-13 14:23:09'),
(8, 3, 11, 1, NULL, '2023-03-13 13:08:43', '2023-03-13 13:08:43'),
(9, 3, 10, 1, NULL, '2023-03-13 14:21:35', '2023-03-13 14:21:35'),
(10, 3, 10, 1, 4, '2023-03-13 14:21:41', '2023-03-13 14:22:18'),
(11, 3, 12, 1, NULL, '2023-03-13 14:21:47', '2023-03-13 14:21:47'),
(12, 3, 14, 1, NULL, '2023-03-13 14:21:52', '2023-03-13 14:21:52'),
(13, 3, 15, 1, NULL, '2023-03-13 14:21:57', '2023-03-13 14:21:57'),
(14, 3, 16, 1, NULL, '2023-03-13 14:22:02', '2023-03-13 14:22:02'),
(15, 3, 10, 1, 5, '2023-03-13 14:37:46', '2023-03-13 14:41:48'),
(16, 3, 11, 1, 5, '2023-03-13 14:37:52', '2023-03-13 14:43:19'),
(17, 3, 12, 1, NULL, '2023-03-13 14:37:57', '2023-03-13 14:37:57'),
(18, 3, 13, 1, NULL, '2023-03-13 14:38:03', '2023-03-13 14:38:03'),
(19, 3, 14, 1, 5, '2023-03-13 14:38:08', '2023-03-13 14:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `production_mat_req_confirmations`
--

CREATE TABLE `production_mat_req_confirmations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prod_mat_req_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `confirmed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_mat_req_confirmations`
--

INSERT INTO `production_mat_req_confirmations` (`id`, `prod_mat_req_id`, `user_id`, `status`, `confirmed_at`) VALUES
(4, 6, 4, '1', '2023-03-13 14:19:18'),
(5, 6, 5, '1', '2023-03-13 14:18:13'),
(6, 7, 4, '2', NULL),
(7, 7, 5, '2', NULL),
(8, 8, 4, '1', '2023-03-13 14:22:14'),
(9, 8, 5, '1', '2023-03-13 14:25:25'),
(10, 9, 4, '1', '2023-03-13 14:22:16'),
(11, 9, 5, '1', '2023-03-13 14:27:30'),
(12, 10, 4, '2', NULL),
(13, 10, 5, '2', NULL),
(14, 11, 4, '1', '2023-03-13 14:22:20'),
(15, 11, 5, '1', '2023-03-13 14:33:18'),
(16, 12, 4, '1', '2023-03-13 14:22:22'),
(17, 12, 5, '1', '2023-03-13 14:33:43'),
(18, 13, 4, '1', '2023-03-13 14:22:24'),
(19, 13, 5, '1', '2023-03-13 14:36:42'),
(20, 14, 4, '1', '2023-03-13 14:22:26'),
(21, 14, 5, '1', '2023-03-13 14:41:32'),
(22, 15, 4, '2', NULL),
(23, 15, 5, '2', NULL),
(24, 16, 4, '2', NULL),
(25, 16, 5, '2', NULL),
(26, 17, 4, '0', NULL),
(27, 17, 5, '1', '2023-03-13 14:41:28'),
(28, 18, 4, '0', NULL),
(29, 18, 5, '0', NULL),
(30, 19, 4, '2', NULL),
(31, 19, 5, '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_quantity` decimal(10,2) UNSIGNED NOT NULL,
  `quantity_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `req_handler_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `material_name`, `material_type`, `material_quantity`, `quantity_unit`, `req_handler_role`, `created_at`, `updated_at`) VALUES
(1, 'Bottle', '1ltr', '24.00', 'piece', 'Raw Request Handler', '2023-03-13 03:19:45', '2023-03-13 14:41:32'),
(2, 'Bottle', '2ltr', '50.00', 'piece', 'Raw Request Handler', '2023-03-13 03:19:45', '2023-03-13 07:40:30'),
(3, 'Oil', 'soyabean', '29.50', 'kg', 'Raw Request Handler', '2023-03-13 03:19:45', '2023-03-13 14:41:32'),
(4, 'Label', '1ltr', '4.00', 'piece', 'Raw Request Handler', '2023-03-13 12:53:13', '2023-03-13 14:41:32'),
(5, 'Cap', '1ltr', '4.00', 'piece', 'Raw Request Handler', '2023-03-13 12:53:13', '2023-03-13 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `raw_material_requests`
--

CREATE TABLE `raw_material_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_quantity` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_material_requests`
--

INSERT INTO `raw_material_requests` (`id`, `raw_material_id`, `raw_material_quantity`, `requested_by`, `cancelled_by`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 1, NULL, '2023-03-13 03:19:53', '2023-03-13 03:19:53'),
(2, 3, 50, 1, NULL, '2023-03-13 03:20:01', '2023-03-13 03:20:01'),
(3, 2, 50, 1, NULL, '2023-03-13 03:20:26', '2023-03-13 03:20:26'),
(4, 3, 20, 1, NULL, '2023-03-13 03:20:32', '2023-03-13 03:20:32'),
(5, 1, 20, 1, NULL, '2023-03-13 13:04:08', '2023-03-13 13:04:08'),
(6, 5, 20, 1, NULL, '2023-03-13 13:04:47', '2023-03-13 13:04:47'),
(7, 4, 20, 1, NULL, '2023-03-13 13:04:56', '2023-03-13 13:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `raw_mat_req_confirmations`
--

CREATE TABLE `raw_mat_req_confirmations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `raw_material_request_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=>pending, 1=>confirmed, 3=cancelled',
  `confirmed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raw_mat_req_confirmations`
--

INSERT INTO `raw_mat_req_confirmations` (`id`, `raw_material_request_id`, `user_id`, `status`, `confirmed_at`) VALUES
(1, 1, 2, '1', '2023-03-13 07:39:52'),
(2, 2, 2, '1', '2023-03-13 07:39:54'),
(3, 3, 2, '1', '2023-03-13 07:39:56'),
(4, 3, 3, '1', '2023-03-13 07:40:30'),
(5, 4, 2, '1', '2023-03-13 07:39:59'),
(6, 4, 3, '1', '2023-03-13 07:40:32'),
(7, 5, 2, '1', '2023-03-13 13:05:23'),
(8, 5, 3, '1', '2023-03-13 13:05:50'),
(9, 6, 2, '1', '2023-03-13 13:05:25'),
(10, 6, 3, '1', '2023-03-13 13:05:52'),
(11, 7, 2, '1', '2023-03-13 13:05:26'),
(12, 7, 3, '1', '2023-03-13 13:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'User', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(2, 'Super Admin', 'web', '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(3, 'Raw Request Handler', 'web', '2023-03-13 03:17:41', '2023-03-13 03:17:41'),
(4, 'Production Request Handler', 'web', '2023-03-13 03:17:50', '2023-03-13 03:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 3),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 4),
(27, 2),
(28, 2),
(29, 2),
(30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Naymur Rahman', 'naymur@example.com', NULL, '$2y$10$6C1b5pdGU8T6Ms7p9IPm4O1vRxvd/YN/1xbTIBvWj3nIRR6aS6EQS', NULL, '2023-03-13 03:10:14', '2023-03-13 03:10:14'),
(2, 'Alauddin Alo', 'alo@example.com', NULL, '$2y$10$H1Vmw9n9HJA/7CyJ1ij6s./UsH51QXUfvJm/SxwA0fYX3iPaENvcG', NULL, '2023-03-13 03:18:28', '2023-03-13 03:18:28'),
(3, 'Kamrul Hasan', 'kamrul@example.com', NULL, '$2y$10$66LiqFTf3FQbPq5h2yOAEuXfo.0XzsL/6TIjCvWHJUFoaj9IpyLii', NULL, '2023-03-13 03:20:16', '2023-03-13 03:20:16'),
(4, 'Habibullah', 'habib@example.com', NULL, '$2y$10$Rs8mIEi3krE6hlfXmoJZCeSy7s4tg3ZsnEepI3Qnt2.DdFdYcWC/i', NULL, '2023-03-13 11:04:54', '2023-03-13 11:04:54'),
(5, 'Amzad Hossen', 'amzad@example.com', NULL, '$2y$10$cYSktnccKuuc9Z2XfYVcI.VnJ2lfbbUL9CR1guACMfp4JdqMSlate', NULL, '2023-03-13 11:46:17', '2023-03-13 11:46:17');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `production_materials`
--
ALTER TABLE `production_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_materials_raw_material_id_foreign` (`raw_material_id`);

--
-- Indexes for table `production_material_requests`
--
ALTER TABLE `production_material_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_material_requests_production_material_id_foreign` (`production_material_id`),
  ADD KEY `production_material_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `production_material_requests_cancelled_by_foreign` (`cancelled_by`);

--
-- Indexes for table `production_mat_req_confirmations`
--
ALTER TABLE `production_mat_req_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `production_mat_req_confirmations_prod_mat_req_id_foreign` (`prod_mat_req_id`),
  ADD KEY `production_mat_req_confirmations_user_id_foreign` (`user_id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_material_requests_raw_material_id_foreign` (`raw_material_id`),
  ADD KEY `raw_material_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `raw_material_requests_cancelled_by_foreign` (`cancelled_by`);

--
-- Indexes for table `raw_mat_req_confirmations`
--
ALTER TABLE `raw_mat_req_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_mat_req_confirmations_raw_material_request_id_foreign` (`raw_material_request_id`),
  ADD KEY `raw_mat_req_confirmations_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_materials`
--
ALTER TABLE `production_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `production_material_requests`
--
ALTER TABLE `production_material_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `production_mat_req_confirmations`
--
ALTER TABLE `production_mat_req_confirmations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `raw_mat_req_confirmations`
--
ALTER TABLE `raw_mat_req_confirmations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_materials`
--
ALTER TABLE `production_materials`
  ADD CONSTRAINT `production_materials_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_material_requests`
--
ALTER TABLE `production_material_requests`
  ADD CONSTRAINT `production_material_requests_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_material_requests_production_material_id_foreign` FOREIGN KEY (`production_material_id`) REFERENCES `production_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_material_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_mat_req_confirmations`
--
ALTER TABLE `production_mat_req_confirmations`
  ADD CONSTRAINT `production_mat_req_confirmations_prod_mat_req_id_foreign` FOREIGN KEY (`prod_mat_req_id`) REFERENCES `production_material_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `production_mat_req_confirmations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_material_requests`
--
ALTER TABLE `raw_material_requests`
  ADD CONSTRAINT `raw_material_requests_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `raw_material_requests_raw_material_id_foreign` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `raw_material_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `raw_mat_req_confirmations`
--
ALTER TABLE `raw_mat_req_confirmations`
  ADD CONSTRAINT `raw_mat_req_confirmations_raw_material_request_id_foreign` FOREIGN KEY (`raw_material_request_id`) REFERENCES `raw_material_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `raw_mat_req_confirmations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
