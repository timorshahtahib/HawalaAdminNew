-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 12:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asiapanel`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `bank_balance`
-- (See below for the actual view)
--
CREATE TABLE `bank_balance` (
`id` bigint(20)
,`account_name` varchar(50)
,`currencyname` varchar(20)
,`total_rasid` double(21,4)
,`total_bord` double(21,4)
,`blance` double(21,4)
);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `sign` varchar(10) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `sign`, `status`, `created_at`, `updated_at`) VALUES
(1, 'افغانی', 'af', 1, '2023-11-21 07:13:13', '2023-12-04 07:04:25'),
(2, 'تومان', 'ir', 1, '2023-11-21 07:13:33', '2023-12-04 07:14:38'),
(3, 'دالر', '$', 1, '2023-11-21 07:27:32', '2023-12-14 02:36:51'),
(10, 'کالدار', '#', 1, '2023-12-24 06:22:18', '2023-12-24 06:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `cu_number` varchar(15) NOT NULL DEFAULT 'testnumber',
  `phone` varchar(15) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `type` enum('customer') DEFAULT 'customer',
  `acount_currency` bigint(2) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `status` int(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `last_name`, `cu_number`, `phone`, `username`, `password`, `image`, `address`, `token`, `type`, `acount_currency`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(90, 'Ahmad', 'ewriwe', 'testnumber', '345233253535', 'ahmad1', 'eruweiuewiru', NULL, 'rttrretiueiu', NULL, 'customer', 1, 'ueriweurieuwrireowu', 1, '2023-11-29 02:49:56', '2023-11-29 02:49:56'),
(102, 'Naser', 'Ahmadi', 'testnumber', '4780494848', 'naser', 'oirtoirte', NULL, 'lkfgdlklfd;gk', NULL, 'customer', NULL, 'fdlgkl;dfgkjfdl;', 0, '2023-12-03 12:24:48', '2023-12-05 02:10:34'),
(103, 'Tahir', 'ahmadj', 'testnumber', '4578878477988', 'sdasda', 'eredsfdsf', NULL, 'dfssfd', NULL, 'customer', NULL, 'fsddfsfds', 1, '2023-12-10 06:41:47', '2023-12-10 06:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_account`
--

CREATE TABLE `finance_account` (
  `id` bigint(20) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `type` enum('asset','equity','liablity') NOT NULL,
  `currency` bigint(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `account` enum('bank','income','expense') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_account`
--

INSERT INTO `finance_account` (`id`, `account_name`, `type`, `currency`, `description`, `user_id`, `status`, `account`, `created_at`, `updated_at`) VALUES
(1, 'دخل افغانی', 'asset', 1, 'دخل افغانی', 90, 1, 'bank', '2023-12-02 12:58:58', '2023-12-02 12:58:58'),
(17, 'خرجی چاشت', 'liablity', 1, 'خرجی چاشت', 2, 1, 'expense', '2023-12-09 13:31:19', '2023-12-09 13:31:19'),
(18, 'کرایه دفتر', 'liablity', 1, 'کرایه دفتر', 2, 1, 'expense', '2023-12-09 13:32:13', '2023-12-09 13:32:13'),
(19, 'تمدید هاست', 'liablity', 3, 'تمدید هاست', 2, 1, 'expense', '2023-12-09 13:33:42', '2023-12-09 13:33:42'),
(20, 'دخل تومن', 'asset', 2, 'بانک صادرات', 3, 1, 'bank', '2023-12-09 13:38:38', '2023-12-09 13:38:38'),
(21, 'دخل دالر', 'asset', 3, 'دخل دالر', 3, 1, 'bank', '2023-12-09 13:39:13', '2023-12-09 13:39:13'),
(22, 'بیل برق', 'liablity', 1, 'پول برق', 2, 1, 'expense', '2023-12-09 13:32:13', '2023-12-09 13:32:13'),
(23, 'عزیزی بانک', 'asset', 1, 'عزیزی بانک', 1, 1, 'bank', '2023-12-13 11:05:09', '2023-12-13 11:05:09'),
(24, 'رسید وبرد مشتزیان  افغانی', 'liablity', 1, 'رسید وبرد مشتزیان  افغانی', 1, 1, 'income', '2023-12-14 10:28:10', '2023-12-14 10:28:10'),
(25, 'معاملات', 'liablity', 1, NULL, 1, 1, 'income', '2024-01-06 11:36:54', '2024-01-06 11:36:54');

-- --------------------------------------------------------

--
-- Table structure for table `income_expense`
--

CREATE TABLE `income_expense` (
  `id` bigint(20) NOT NULL,
  `type` enum('expense','income') NOT NULL,
  `amount` float(10,4) NOT NULL,
  `currency` bigint(20) DEFAULT NULL,
  `amount_equal` float(10,4) DEFAULT NULL,
  `currency_equal` bigint(20) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `finance_acount_id` bigint(20) NOT NULL,
  `bank_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `ref_type` varchar(50) NOT NULL,
  `state` enum('pending','payed','unpaid') NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `desc` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income_expense`
--

INSERT INTO `income_expense` (`id`, `type`, `amount`, `currency`, `amount_equal`, `currency_equal`, `date`, `transaction_id`, `finance_acount_id`, `bank_id`, `user_id`, `ref_type`, `state`, `status`, `desc`, `created_at`, `updated_at`) VALUES
(20, 'expense', 2000.0000, 1, NULL, NULL, '2024-01-15', 81, 22, 1, 1, 'expense', 'payed', 1, 'test', '2023-12-24 13:22:41', '2023-12-24 08:52:41'),
(21, 'expense', 300.0000, 1, NULL, NULL, '1402/10/11', 82, 18, 1, 1, 'expense', 'payed', 1, 'test', '2023-12-24 13:26:59', '2023-12-24 08:56:59'),
(22, 'expense', 200.0000, 1, NULL, NULL, '1402/10/13', 88, 22, 1, 1, 'expense', 'payed', 1, 'fghjkl;', '2024-01-04 11:07:18', '2024-01-04 06:37:18'),
(23, 'expense', 2999.0000, 1, NULL, NULL, '1402/10/11', 90, 22, 23, 1, 'expense', 'payed', 1, 'test for test', '2024-01-05 17:21:59', '2024-01-05 12:51:59'),
(24, 'expense', 300.0000, 1, NULL, NULL, '1402/10/11', 91, 17, 1, 1, 'expense', 'payed', 1, 'launch', '2024-01-05 17:22:47', '2024-01-05 12:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `transaction_id` bigint(20) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `action_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `state` enum('done','pending','rejected') NOT NULL,
  `order_number` varchar(20) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `system` enum('web','app') NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `network_id` bigint(20) NOT NULL,
  `sub_category_id` bigint(20) DEFAULT NULL,
  `qtt` float NOT NULL,
  `amount` float NOT NULL,
  `final_amount` float NOT NULL,
  `profit_percentage` float(10,4) NOT NULL,
  `profit_amount` float NOT NULL,
  `currency` bigint(20) NOT NULL,
  `buy_currency_id` bigint(20) NOT NULL,
  `currency_rate` float(10,4) NOT NULL,
  `buy_price` float(10,4) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `reject_disc` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `transaction_id`, `order_date`, `action_date`, `state`, `order_number`, `ip_address`, `system`, `phone_number`, `network_id`, `sub_category_id`, `qtt`, `amount`, `final_amount`, `profit_percentage`, `profit_amount`, `currency`, `buy_currency_id`, `currency_rate`, `buy_price`, `user_id`, `product_id`, `supplier_id`, `reject_disc`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2023-12-03 11:44:33', '2023-12-03 11:44:33', '', '4', '192:168.1.1', 'web', '79854678', 5, 3, 34.9, 120.3, 43, 32.0000, 4, 55, 3, 2.0000, 2.0000, 6, 6, 4, 'rttretegfdgdfgdfg', 1, '2023-12-03 11:44:33', '2023-12-03 11:44:33'),
(2, 1, 2, '2023-12-03 12:59:36', '2023-12-03 12:59:36', 'done', '2', '192.168.13.5', 'app', '7894568', 24, NULL, 12.4, 5665, 700.398, 54.0000, 35, 555, 5, 3.0000, 5.0000, 6, 6, 4, 'ttyryttry', 1, '2023-12-03 12:59:36', '2023-12-03 12:59:36'),
(3, 1, 3, '2023-12-03 11:44:33', '2023-12-03 11:44:33', '', '4', '192:168.1.1', 'web', '79854678', 5, 3, 34.9, 120.3, 43, 32.0000, 4, 55, 3, 2.0000, 2.0000, 6, 6, 4, 'rttretegfdgdfgdfg', 1, '2023-12-03 11:44:33', '2023-12-03 11:44:33'),
(4, 4, 5, '2023-12-04 03:28:27', '2023-12-04 03:28:27', 'done', '88', '192.168.54.2', 'web', '78956347', 2, 4, 34, 300, 135, 4.6000, 45, 67, 5, 4.0000, 300.0000, 8, 9, 3, NULL, 1, '2023-12-03 22:58:27', '2023-12-03 22:58:27'),
(5, 4, 5, '2023-12-04 03:31:51', '2023-12-04 03:31:51', 'done', '88', '192.168.54.2', 'web', '79845676', 2, 4, 34, 300, 135, 4.6000, 45, 67, 5, 4.0000, 300.0000, 8, 9, 3, NULL, 1, '2023-12-03 23:01:51', '2023-12-03 23:01:51'),
(6, 4, 5, '2023-12-04 05:32:03', '2023-12-04 05:32:03', 'rejected', '88', '192.168.54.2', 'web', '7972154560', 2, 4, 10, 300, 135, 4.6000, 45, 67, 5, 4.0000, 300.0000, 8, 9, 3, NULL, 1, '2023-12-04 01:02:03', '2023-12-04 05:44:01'),
(7, 4, 5, '2023-12-04 06:31:11', '2023-12-04 06:31:11', 'rejected', '88', '192.168.54.2', 'app', '796624044', 2, 4, 1, 300, 135, 4.6000, 45, 67, 5, 4.0000, 300.0000, 8, 9, 3, NULL, 1, '2023-12-04 02:01:11', '2023-12-04 05:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint(20) NOT NULL,
  `rasid_bord` enum('rasid','bord') NOT NULL,
  `check_number` varchar(30) NOT NULL,
  `transaction_type` varchar(20) NOT NULL,
  `amount` float(14,4) NOT NULL,
  `currency` bigint(20) NOT NULL,
  `amount_equal` float(14,4) DEFAULT NULL,
  `currency_equal` bigint(20) DEFAULT NULL,
  `currency_rate` float(10,4) NOT NULL DEFAULT 1.0000,
  `ref_id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `finance_acount_id` bigint(20) NOT NULL,
  `bank_acount_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `date` varchar(30) NOT NULL,
  `desc` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `rasid_bord`, `check_number`, `transaction_type`, `amount`, `currency`, `amount_equal`, `currency_equal`, `currency_rate`, `ref_id`, `order_id`, `finance_acount_id`, `bank_acount_id`, `user_id`, `date`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(151, 'rasid', 'Hawala-60', 'exchange', 100.0000, 3, NULL, 3, 70.0000, 0, 152, 25, 21, 0, '1402/10/18', 'hgf', 1, '2024-01-06 12:46:41', '2024-01-06 08:16:41'),
(152, 'bord', 'Hawala-61', 'exchange', 7100.0000, 1, 7100.0000, 1, 70.0000, 0, 151, 25, 1, 0, '1402/10/18', 'hgf', 1, '2024-01-06 12:46:41', '2024-01-06 08:16:41'),
(153, 'rasid', 'Hawala-62', 'exchange', 290.0000, 3, NULL, 3, 1.0000, 0, 154, 25, 21, 0, '1402/10/25', 'sdasasddas', 1, '2024-01-06 13:29:59', '2024-01-06 08:59:59'),
(154, 'bord', 'Hawala-63', 'exchange', 21000.0000, 1, 21000.0000, 1, 1.0000, 0, 153, 25, 1, 0, '1402/10/25', 'sdasasddas', 1, '2024-01-06 13:29:59', '2024-01-06 08:59:59'),
(155, 'rasid', 'Hawala-64', 'exchange', 200.0000, 3, NULL, 3, 1.0000, 0, 156, 25, 21, 0, '1402/10/17', 'test for test', 1, '2024-01-07 06:43:21', '2024-01-07 02:13:21'),
(156, 'bord', 'Hawala-65', 'exchange', 1400.0000, 1, 1400.0000, 1, 1.0000, 0, 155, 25, 1, 0, '1402/10/17', 'test for test', 1, '2024-01-07 06:43:21', '2024-01-07 02:13:21'),
(157, 'rasid', 'Hawala-66', 'exchange', 30.0000, 3, NULL, 3, 1.0000, 0, 158, 25, 21, 0, '1402/10/17', 'dssadsdasd', 1, '2024-01-07 08:29:04', '2024-01-07 03:59:04'),
(158, 'bord', 'Hawala-67', 'exchange', 2000000.0000, 2, 2000000.0000, 2, 1.0000, 0, 157, 25, 20, 0, '1402/10/17', 'dssadsdasd', 1, '2024-01-07 08:29:04', '2024-01-07 03:59:04'),
(159, 'rasid', 'Hawala-68', 'exchange', 2000000.0000, 2, NULL, 2, 1.0000, 0, 160, 25, 20, 0, '1402/10/17', 'fsdfsdsdsfdsdf', 1, '2024-01-07 11:22:14', '2024-01-07 06:52:14'),
(160, 'bord', 'Hawala-69', 'exchange', 2800.0000, 1, 2800.0000, 1, 1.0000, 0, 159, 25, 1, 0, '1402/10/17', 'fsdfsdsdsfdsdf', 1, '2024-01-07 11:22:14', '2024-01-07 06:52:14'),
(161, 'rasid', 'Hawala-70', 'exchange', 10000.0000, 1, NULL, 1, 1.0000, 0, 162, 25, 1, 0, '1402/10/17', 'buying dollar', 1, '2024-01-07 13:03:43', '2024-01-07 08:33:43'),
(162, 'bord', 'Hawala-71', 'exchange', 120.0000, 3, 120.0000, 3, 1.0000, 0, 161, 25, 21, 0, '1402/10/17', 'buying dollar', 1, '2024-01-07 13:03:43', '2024-01-07 08:33:43'),
(163, 'rasid', 'Hawala-72', 'exchange', 120.0000, 3, NULL, 3, 1.0000, 0, 164, 25, 21, 0, '1402/10/19', NULL, 1, '2024-01-07 13:21:37', '2024-01-07 08:51:37'),
(164, 'bord', 'Hawala-73', 'exchange', 8000.0000, 1, 8000.0000, 1, 1.0000, 0, 163, 25, 1, 0, '1402/10/19', NULL, 1, '2024-01-07 13:21:37', '2024-01-07 08:51:37'),
(165, 'rasid', 'Hawala-74', 'exchange', 2000.0000, 2, NULL, 2, 2.0000, 0, 166, 25, 20, 0, '1402/10/18', 'jmnbv', 1, '2024-01-07 13:26:15', '2024-01-07 08:56:15'),
(166, 'bord', 'Hawala-75', 'exchange', 2800.0000, 1, 2800.0000, 1, 2.0000, 0, 165, 25, 23, 0, '1402/10/18', 'jmnbv', 1, '2024-01-07 13:26:15', '2024-01-07 08:56:15'),
(167, 'rasid', 'Hawala-76', 'exchange', 2000.0000, 2, NULL, 2, 2.0000, 0, 168, 25, 20, 0, '1402/10/18', 'jmnbv', 1, '2024-01-07 13:26:15', '2024-01-07 08:56:15'),
(168, 'bord', 'Hawala-77', 'exchange', 2800.0000, 1, 666.0000, NULL, 3.3330, 0, 167, 25, 23, 0, '2000-10-1', 'updated successfully', 1, '2024-01-07 13:26:15', '2024-01-08 09:44:34'),
(169, 'rasid', 'Hawala-78', 'exchange', 50.0000, 3, NULL, 3, 2.4000, 0, 170, 25, 21, 0, '1402/10/18', 'sdsfdsdfsfd', 1, '2024-01-08 07:55:07', '2024-01-08 03:25:07'),
(170, 'bord', 'Hawala-79', 'exchange', 3500.0000, 1, 3500.0000, 1, 2.4000, 0, 169, 25, 1, 0, '1402/10/18', 'sdsfdsdfsfd', 1, '2024-01-08 07:55:07', '2024-01-08 03:25:07'),
(171, 'rasid', 'Hawala-80', 'exchange', 569.0000, 2, NULL, 2, 1.3300, 0, 172, 25, 20, 0, '1402/10/07', 'erewrrwewer', 1, '2024-01-08 07:57:54', '2024-01-09 05:51:15'),
(172, 'bord', 'Hawala-81', 'exchange', 1500.0000, 1, 1400.0000, 1, 1.3300, 0, 171, 25, 1, 0, '1402/10/07', 'erewrrwewer', 1, '2024-01-08 07:57:54', '2024-01-09 05:51:15'),
(177, 'rasid', 'Hawala-82', 'exchange', 100.0000, 3, NULL, 3, 0.0000, 0, 178, 25, 21, 0, '1402/10/19', 'sdsads', 1, '2024-01-09 08:44:54', '2024-01-09 05:56:59'),
(178, 'bord', 'Hawala-83', 'exchange', 7000.0000, 1, 7000.0000, 1, 0.0000, 0, 177, 25, 1, 0, '1402/10/19', 'sdsads', 1, '2024-01-09 08:44:54', '2024-01-09 05:56:59'),
(179, 'rasid', 'Hawala-84', 'exchange', 200.0000, 3, NULL, 3, 70.0000, 0, 180, 25, 21, 0, '1402/10/19', 'فروخته شد', 1, '2024-01-09 11:00:58', '2024-01-09 06:30:58'),
(180, 'bord', 'Hawala-85', 'exchange', 14000.0000, 1, 14000.0000, 1, 70.0000, 0, 179, 25, 1, 0, '1402/10/19', 'فروخته شد', 1, '2024-01-09 11:00:58', '2024-01-09 06:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad', 'ahmad@gmail.com', NULL, '1234', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure for view `bank_balance`
--
DROP TABLE IF EXISTS `bank_balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bank_balance`  AS SELECT `b`.`id` AS `id`, `b`.`account_name` AS `account_name`, `c`.`name` AS `currencyname`, sum(case when `t`.`rasid_bord` = 'rasid' then `t`.`amount` else 0 end) AS `total_rasid`, sum(case when `t`.`rasid_bord` = 'bord' then `t`.`amount` else 0 end) AS `total_bord`, sum(case when `t`.`rasid_bord` = 'rasid' then `t`.`amount` else 0 end) - sum(case when `t`.`rasid_bord` = 'bord' then `t`.`amount` else 0 end) AS `blance` FROM ((`finance_account` `b` join `currency` `c` on(`b`.`currency` = `c`.`id`)) left join `transaction` `t` on(`b`.`id` = `t`.`bank_acount_id`)) WHERE `b`.`account` = 'bank' GROUP BY `b`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `name` (`name`),
  ADD KEY `cu_number` (`cu_number`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `finance_account`
--
ALTER TABLE `finance_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_expense`
--
ALTER TABLE `income_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `check_number` (`check_number`),
  ADD KEY `rasid_bord` (`rasid_bord`),
  ADD KEY `transaction_type` (`transaction_type`),
  ADD KEY `currency` (`currency`);

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
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_account`
--
ALTER TABLE `finance_account`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `income_expense`
--
ALTER TABLE `income_expense`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
