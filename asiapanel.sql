-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2024 at 02:53 PM
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
(1, 'افغانی', 'AFN', 1, '2023-11-21 07:13:13', '2024-01-15 06:51:43'),
(2, 'تومان', 'IRR', 1, '2023-11-21 07:13:33', '2023-12-04 07:14:38'),
(3, 'دالر', '$', 1, '2023-11-21 07:27:32', '2023-12-14 02:36:51'),
(10, 'کالدار', '₨', 1, '2023-12-24 06:22:18', '2023-12-24 06:22:18'),
(11, 'لیره', '₺', 1, '2024-01-17 08:06:20', '2024-01-17 08:06:20'),
(12, 'یورو', 'Є', 1, '2024-01-20 01:57:59', '2024-01-22 16:27:35'),
(13, 'yuhan', '@', 0, '2024-01-21 01:02:48', '2024-01-22 16:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
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

INSERT INTO `customer` (`id`, `name`, `cu_number`, `phone`, `username`, `password`, `image`, `address`, `token`, `type`, `acount_currency`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(141, 'نوید', 'testnumber', '0793240', 'navid@gmail.com', '123456', NULL, 'هرات', NULL, 'customer', NULL, 'هرات', 1, '2024-01-25 07:00:01', '2024-01-25 07:00:01'),
(144, 'داکتر حمید', 'testnumber', '079944868', 'ahmad@gmail.com', '1234', NULL, 'هرات', NULL, 'customer', NULL, 'درب ملگ', 1, '2024-01-28 07:20:29', '2024-01-28 07:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
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
(25, 'معاملات', 'liablity', 1, NULL, 1, 1, 'income', '2024-01-06 11:36:54', '2024-01-06 11:36:54'),
(26, 'انتقالات بین بانکی', 'asset', 1, NULL, 0, 1, 'income', '2024-01-10 12:14:56', '2024-01-10 12:14:56'),
(27, 'کالدار', 'asset', 10, NULL, 1, 1, 'bank', '2024-01-15 09:52:56', '2024-01-15 09:52:56'),
(28, 'دالر 2', 'asset', 3, 'up to 2', 1, 1, 'bank', '2024-01-15 09:54:51', '2024-01-20 01:56:59'),
(31, 'یورو', 'asset', 12, 'یورووو', 1, 0, 'bank', '2024-01-20 07:29:45', '2024-01-20 03:00:40'),
(32, 'test', 'asset', 11, 'fffsdsdffsd', 1, 1, 'income', '2024-01-20 07:30:59', '2024-01-20 07:30:59'),
(33, '44test44', 'equity', 3, 'rewrwer', 1, 1, 'income', '2024-01-20 07:31:56', '2024-01-20 03:02:32'),
(34, 'کالدار1', 'equity', 10, '2Pakistan', 1, 0, 'bank', '2024-01-21 02:48:50', '2024-01-20 22:21:07'),
(35, 'معاش کارمندان', 'asset', 1, 'معاش کارمندان444', 1, 1, 'bank', '2024-01-21 02:58:12', '2024-01-20 22:32:12');

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
(48, 'expense', 3000.0000, 1, NULL, NULL, '1402/11/11', 49, 22, 1, 1, 'expense', 'payed', 1, 'bill bargh', '2024-01-22 20:06:36', '2024-01-22 15:36:36'),
(49, 'expense', 8000.0000, 1, NULL, NULL, '1402/11/11', 50, 18, 1, 1, 'expense', 'payed', 1, 'carry of office', '2024-01-22 20:07:26', '2024-01-22 15:37:26'),
(50, 'expense', 60.0000, 1, NULL, NULL, '1402/11/03', 51, 17, 1, 1, 'expense', 'payed', 1, 'jjjjj', '2024-01-22 20:17:26', '2024-01-22 15:47:26'),
(51, 'expense', 30.0000, 3, NULL, NULL, '1402/11/03', 52, 19, 21, 1, 'expense', 'payed', 1, 'update', '2024-01-22 20:18:08', '2024-01-22 15:48:26'),
(52, 'expense', 700.0000, 1, NULL, NULL, '1402/11/10', 53, 22, 1, 1, 'expense', 'payed', 1, 'bill', '2024-01-22 20:22:02', '2024-01-22 15:52:02'),
(53, 'expense', 700.0000, 1, NULL, NULL, '1402/11/17', 54, 18, 1, 1, 'expense', 'payed', 1, 'kjjkhjkljlh', '2024-01-22 20:23:18', '2024-01-22 15:53:18'),
(54, 'expense', 700.0000, 1, NULL, NULL, '1402/11/17', 55, 17, 1, 1, 'expense', 'payed', 1, 'khjhkklhkjh', '2024-01-22 20:24:46', '2024-01-22 15:54:46'),
(55, 'expense', 60.0000, 3, NULL, NULL, '1402/11/10', 56, 19, 21, 1, 'expense', 'payed', 0, 'kjhkhkjl', '2024-01-22 20:27:20', '2024-01-22 16:45:42'),
(56, 'expense', 600.0000, 1, NULL, NULL, '1402/11/10', 57, 22, 1, 1, 'expense', 'payed', 0, 'lkjlkj;', '2024-01-22 20:29:03', '2024-01-22 16:13:52'),
(57, 'expense', 66.0000, 3, NULL, NULL, '1402/11/23', 58, 19, 21, 1, 'expense', 'payed', 0, 'jhjkjh', '2024-01-22 20:30:16', '2024-01-22 16:10:33'),
(58, 'expense', 55.0000, 3, NULL, NULL, '1402/11/10', 59, 19, 21, 1, 'expense', 'payed', 0, 'klkkj', '2024-01-22 20:35:04', '2024-01-22 16:08:29'),
(59, 'expense', 400.0000, 1, NULL, NULL, '1402/11/03', 60, 22, 1, 1, 'expense', 'payed', 0, '6666', '2024-01-22 20:37:53', '2024-01-22 16:08:20'),
(60, 'expense', 66.0000, 1, NULL, NULL, '1402/11/29', 61, 18, 1, 1, 'expense', 'payed', 0, 'mjhkjjhhkjhl', '2024-01-22 21:00:03', '2024-01-22 16:44:18'),
(61, 'expense', 77.0000, 3, NULL, NULL, '1402/11/03', 62, 19, 21, 1, 'expense', 'payed', 0, 'تاتانتت', '2024-01-22 21:01:16', '2024-01-22 16:43:17'),
(62, 'expense', 666.0000, 1, NULL, NULL, '1402/11/03', 63, 18, 1, 1, 'expense', 'payed', 1, '66666', '2024-01-22 21:15:57', '2024-01-22 16:46:10'),
(63, 'expense', 1000.0000, 1, NULL, NULL, '1402/11/05', 113, 22, 1, 1, 'expense', 'payed', 1, 'بیل', '2024-01-25 11:32:37', '2024-01-25 07:02:37'),
(64, 'expense', 200.0000, 3, NULL, NULL, '1402/11/07', 9, 19, 21, 1, 'expense', 'payed', 1, 'gfddfgf', '2024-01-27 12:21:36', '2024-01-27 07:51:36');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(38, '2014_10_12_000000_create_users_table', 2),
(39, '2014_10_12_100000_create_password_resets_table', 2),
(40, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(41, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(42, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(43, '2016_06_01_000004_create_oauth_clients_table', 2),
(44, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
(45, '2019_08_19_000000_create_failed_jobs_table', 2),
(46, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(47, '2024_02_05_125009_y', 2),
(48, '2024_02_05_131917_y', 2),
(49, '2024_02_05_132021_y', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0686f1e746570c24d8c54a989b76a636235d64f25e5f475cf3c1feb13a59d2d997642a2e1f618e5f', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:51:21', '2024-02-10 08:51:21', '2024-08-10 13:21:21'),
('1738edb3a72d7c2acbf73a44101ad9fa47d1d8ee3c05f2e13ba326910ba8520946c3533c3df5c623', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:16:28', '2024-02-10 08:16:54', '2024-08-10 12:46:28'),
('1f8402c2741d56f18d069d56a79aaa887723e0ada50dc5f3631e02b230a9cca9a6c5d6fb0dadd44f', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:51:43', '2024-02-10 08:52:46', '2024-08-10 13:21:43'),
('309d54ac776fd8016bfb2d512a4c2fd69b4e0a8b2c9af233cc4dc54138650eb9e33fdf38e5e86615', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 05:53:23', '2024-02-10 05:53:35', '2024-08-10 10:23:23'),
('33fb7b0dbf17c76e0c2d95c97f44366e768bdaabd381bb2add9bc0c9d183629eae7570afc583d204', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 05:51:20', '2024-02-10 05:51:52', '2024-08-10 10:21:20'),
('35372cc2931cf636570a8470a00588c3da0545b98a71294f8daf140501f4632787d89460fa5652b9', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 06:10:55', '2024-02-10 06:10:55', '2024-08-10 10:40:55'),
('41c59346c1d1d683f8ba3d87df8fc1275ae71eab42b22188f87a6db9ba42d8d4fe1d294cceed4d53', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:24:52', '2024-02-10 08:25:03', '2024-08-10 12:54:52'),
('50e12df0db1bd18fd502af2d972f92e957bf27ab6f0e51438720ff1185b579475e725a1ca6030dfc', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 09:20:32', '2024-02-10 09:20:32', '2024-08-10 13:50:32'),
('7c898baa9daa4bbe3fa3d218ab0c4cb6ad358bfe9b23d09b2c0a8f4476f178c739b4f0c3c17c5b89', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:32:36', '2024-02-10 08:32:36', '2024-08-10 13:02:36'),
('88f3a67a7cc9068ac5f1a7f93e0f3c5fb86daa38a1dd6a2119860959e852b29885df10e4114bb56a', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:13:26', '2024-02-10 08:13:26', '2024-08-10 12:43:26'),
('acbadc944753e1046280351439c5993ec9cfb922472595b09c1f7db63f2c5b708277d35889c619b6', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:18:15', '2024-02-10 08:18:27', '2024-08-10 12:48:15'),
('b493739ce56926b31636f7f434daf4adff97cb6ad49de2271161df1f7dafb09f9ff8d960b70e9c89', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:27:57', '2024-02-10 08:28:14', '2024-08-10 12:57:57'),
('c42376ebee736aa1d0c8409db0f945fedbd688cb4f836f0bc6d9269861df15f48785f3338e9ed21c', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:38:28', '2024-02-10 08:38:28', '2024-08-10 13:08:28'),
('cbe7a9eaac6508cf44f04e8b76653963c97f24ec31f50c21537b50e96c1e3b3f2e9098bb18cd7fe1', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 09:00:21', '2024-02-10 09:00:54', '2024-08-10 13:30:21'),
('cd0c3a421b0de4ce52d9d95d4e325e3e652a770da3785bc7f0a1febc4ab7b240096fd78da0175f2c', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:12:49', '2024-02-10 08:13:02', '2024-08-10 12:42:49'),
('e8dfc8e740cf22ce3d0506f3cea21e37d21ef417820465818582f407c2dff266117d4a8fd689b5ef', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:54:59', '2024-02-10 08:54:59', '2024-08-10 13:24:59'),
('e99656c44de3d48f8ba1bc933d50c1ada9a6a8d008829405eff19c0e011e5a304c19efca8e7ea323', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 0, '2024-02-10 08:11:10', '2024-02-10 08:11:11', '2024-08-10 12:41:10'),
('f3480d2ff50940e17d0f98347c29b62902f9e6a7320bf53bf4566d5be730cfd059598a480249fb9b', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:22:18', '2024-02-10 08:22:31', '2024-08-10 12:52:18'),
('ffd2a0e8fb4166f0a849fbe1bb86cb58cd03b6e8ad78ccf305dd40526fa963de423dccb0d1384e60', 1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', 'myToken', '[]', 1, '2024-02-10 08:56:04', '2024-02-10 08:56:23', '2024-08-10 13:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('9b4d0742-ab58-4d1c-8553-94c00fe45ca8', NULL, 'Skote Personal Access Client', 'IEhZugx8UrY5e4tJkDdgfrHAriRahmy09UFEO7kp', NULL, 'http://localhost', 1, 0, 0, '2024-02-10 03:19:25', '2024-02-10 03:19:25'),
('9b4d0742-b235-40c6-a72c-58cf01a9fc79', NULL, 'Asia Password Grant Client', 'c5qPJOCGLLROGDGroDy5JCIaW9FQKVNLRDw8IetR', 'users', 'http://localhost', 0, 1, 0, '2024-02-10 03:19:25', '2024-02-10 03:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '9b4d0742-ab58-4d1c-8553-94c00fe45ca8', '2024-02-10 03:19:25', '2024-02-10 03:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
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
  `ref_tra` bigint(20) DEFAULT NULL,
  `or_tra` bigint(20) DEFAULT NULL,
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

INSERT INTO `transaction` (`id`, `rasid_bord`, `check_number`, `transaction_type`, `amount`, `currency`, `amount_equal`, `currency_equal`, `currency_rate`, `ref_id`, `ref_tra`, `or_tra`, `order_id`, `finance_acount_id`, `bank_acount_id`, `user_id`, `date`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(11, 'rasid', 'Hawala-1', 'rasid_bord', 7000.0000, 1, 7000.0000, 1, 1.0000, 144, NULL, NULL, NULL, 24, 1, 1, '1402/11/08', 'رسید به دفتر', 1, '2024-01-28 11:51:16', '2024-01-28 11:51:16'),
(12, 'bord', 'Hawala-2', 'rasid_bord', 500.0000, 3, 500.0000, 3, 1.0000, 141, NULL, NULL, NULL, 24, 21, 1, '1402/11/09', 'دالر  برده', 1, '2024-01-28 11:51:46', '2024-01-28 11:51:46'),
(13, 'bord', 'Hawala-3', 'rasid_bord', 700.0000, 3, 700.0000, 3, 1.0000, 144, NULL, NULL, NULL, 24, NULL, 1, '1402/11/16', 'برد دالر', 1, '2024-01-28 11:52:11', '2024-01-28 07:23:34'),
(14, 'rasid', 'Hawala-4', 'rasid_bord', 1000.0000, 3, 1000.0000, 3, 1.0000, 141, NULL, NULL, NULL, 24, 21, 1, '1402/11/08', 'از درک مشتر ی ت بهدذیذیبذ', 1, '2024-01-28 11:54:56', '2024-01-28 11:54:56'),
(15, 'rasid', 'Hawala-5', 'rasid_bord', 2000.0000, 3, 140000.0000, 1, 1.0000, 141, NULL, NULL, NULL, 24, 21, 1, '1402/11/08', 'dollar', 1, '2024-01-28 12:36:49', '2024-01-28 12:36:49'),
(16, 'bord', 'Hawala-6', 'rasid_bord', 50.0000, 3, 59999.0000, 1, 74.0000, 141, NULL, NULL, NULL, 24, 21, 1, '1402/11/08', 'fsdfs', 1, '2024-01-28 13:57:19', '2024-01-28 13:57:19'),
(17, 'rasid', 'Hawala-7', 'exchange', 200.0000, 3, 15000.0000, 1, 74.0000, 0, 18, 1, NULL, 25, 21, 0, '1402/11/18', 'دالر خرید شد', 1, '2024-02-07 05:53:38', '2024-02-07 01:23:38'),
(18, 'bord', 'Hawala-8', 'exchange', 15000.0000, 1, 200.0000, 3, 74.0000, 0, 17, NULL, NULL, 25, 1, 0, '1402/11/18', 'دالر خرید شد', 1, '2024-02-07 05:53:38', '2024-02-07 01:23:38'),
(19, 'bord', 'Hawala-9', 'exchange', 200000.0000, 10, 100000.0000, 1, 443.0000, 0, 20, 1, NULL, 25, 27, 0, '1402/11/18', 'کالدار فروخته شد', 1, '2024-02-07 05:57:37', '2024-02-07 01:27:37'),
(20, 'rasid', 'Hawala-10', 'exchange', 100000.0000, 1, 200000.0000, 10, 443.0000, 0, 19, NULL, NULL, 25, 1, 0, '1402/11/18', 'کالدار فروخته شد', 1, '2024-02-07 05:57:37', '2024-02-07 01:27:37'),
(21, 'bord', 'Hawala-11', 'transfer', 200.0000, 3, NULL, NULL, 1.0000, 0, 22, 1, NULL, 26, 21, 0, '1402/11/11', 'دالر انتقال یافت', 1, '2024-02-07 05:58:19', '2024-02-07 01:28:19'),
(22, 'rasid', 'Hawala-12', 'transfer', 200.0000, 3, NULL, NULL, 1.0000, 0, 21, NULL, NULL, 26, 21, 0, '1402/11/11', 'دالر انتقال یافت', 1, '2024-02-07 05:58:19', '2024-02-07 01:28:19'),
(23, 'bord', 'Hawala-13', 'commission', 50.0000, 1, NULL, NULL, 1.0000, 0, 22, NULL, NULL, 26, 1, 0, '1402/11/11', 'دالر انتقال یافت', 1, '2024-02-07 05:58:19', '2024-02-07 01:28:19'),
(24, 'bord', 'Hawala-14', 'transfer', 20000000.0000, 2, NULL, NULL, 1.0000, 0, 25, 1, NULL, 26, 20, 0, '1402/11/19', 'تومن انتفال یافت', 1, '2024-02-08 16:22:52', '2024-02-08 11:52:52'),
(25, 'rasid', 'Hawala-15', 'transfer', 20000000.0000, 2, NULL, NULL, 1.0000, 0, 24, NULL, NULL, 26, 20, 0, '1402/11/19', 'تومن انتفال یافت', 1, '2024-02-08 16:22:52', '2024-02-08 11:52:52'),
(26, 'bord', 'Hawala-16', 'commission', 500.0000, 1, NULL, NULL, 1.0000, 0, 25, NULL, NULL, 26, 1, 0, '1402/11/19', 'تومن انتفال یافت', 1, '2024-02-08 16:22:52', '2024-02-08 11:52:52'),
(27, 'bord', 'Hawala-17', 'transfer', 200.0000, 10, NULL, NULL, 1.0000, 0, 28, 1, NULL, 26, 27, 0, '1402/11/19', 'کالدار انتقال یافت', 1, '2024-02-08 16:24:21', '2024-02-08 11:54:21'),
(28, 'rasid', 'Hawala-18', 'transfer', 200.0000, 10, NULL, NULL, 1.0000, 0, 27, NULL, NULL, 26, 27, 0, '1402/11/19', 'کالدار انتقال یافت', 1, '2024-02-08 16:24:21', '2024-02-08 11:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad', 'ahmad@gmail.com', NULL, '$2y$10$sQbXrrE5TLrL.8seZjTXOO6JLlRxhA5bm1Gjhl/0SWdZ.xfP5n6M.', NULL, '2024-02-10 04:03:09', '2024-02-10 04:03:09');

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
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_account`
--
ALTER TABLE `finance_account`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `income_expense`
--
ALTER TABLE `income_expense`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
