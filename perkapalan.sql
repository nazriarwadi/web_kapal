-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2025 at 08:26 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perkapalan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `profesi_id` bigint UNSIGNED NOT NULL,
  `regu_id` bigint UNSIGNED NOT NULL,
  `hadir` bigint NOT NULL DEFAULT '0',
  `izin` bigint NOT NULL DEFAULT '0',
  `lembur` bigint NOT NULL DEFAULT '0',
  `tanggal_absensi` date DEFAULT NULL COMMENT 'Tanggal absensi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `anggota_id`, `profesi_id`, `regu_id`, `hadir`, `izin`, `lembur`, `tanggal_absensi`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 1, 1, 0, 0, '2025-02-06', '2025-02-06 10:22:14', '2025-02-06 10:22:14'),
(4, 4, 4, 1, 1, 0, 0, '2025-02-06', '2025-02-06 10:22:14', '2025-02-06 10:22:14'),
(5, 5, 4, 1, 0, 1, 0, '2025-02-06', '2025-02-06 10:28:42', '2025-02-06 10:28:42'),
(6, 2, 2, 4, 0, 0, 1, '2025-02-06', '2025-02-06 10:52:18', '2025-02-06 10:52:18'),
(7, 9, 3, 2, 1, 0, 0, '2025-02-07', '2025-02-06 11:06:24', '2025-02-06 11:06:24'),
(8, 6, 4, 1, 1, 0, 0, '2025-02-07', '2025-02-06 11:09:53', '2025-02-06 11:09:53'),
(9, 1, 1, 1, 1, 0, 0, '2025-02-07', '2025-02-06 19:44:37', '2025-02-06 19:44:37'),
(10, 1, 1, 1, 0, 0, 1, '2025-02-08', '2025-02-07 18:58:30', '2025-02-07 18:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `banned_until` datetime DEFAULT NULL,
  `regu_id` bigint UNSIGNED NOT NULL,
  `profesi_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama`, `no_telp`, `email`, `password`, `is_banned`, `banned_until`, `regu_id`, `profesi_id`, `created_at`, `updated_at`) VALUES
(1, 'Nazri Arwadi', '12345678900', 'wadi@gmail.com', '$2y$12$hDTPlTi6U5x0d0QwofNK.u6hzMjKUI64z/1Agea/PFF/WguaZZgRG', 0, NULL, 1, 1, '2025-01-25 22:52:56', '2025-02-08 09:45:57'),
(2, 'Aldino Pandawa', '0987654321', 'dino@gmail.com', '$2y$12$xJI9qv8Tmaf/eQCkA68gAeaFMU2jP0XFks/9bP90VKtzeJ8iEzsE2', 0, NULL, 4, 2, '2025-01-26 02:14:29', '2025-02-05 08:29:13'),
(4, 'Ramadhan Abelio', '1234567890', 'rusunawa@polbeng.web.id', '$2y$12$Z1SuRLmzPoUBEaYUI8DtpuSz0iAJdbO2J5dYEI9vsVVBhLWESqxE2', 0, NULL, 1, 4, '2025-02-05 08:29:56', '2025-02-05 08:29:56'),
(5, 'Bambang Pamukas', '0987654321', 'admin@gmail.com', '$2y$12$IQl5U3/u4dAOZeldrcBGoORbIcapTk/eheCa51U6EWDMPs948i4fm', 0, NULL, 1, 4, '2025-02-05 23:53:16', '2025-02-05 23:53:16'),
(6, 'Junaidi', '49284928492', 'junaidi@gmail.com', '$2y$12$vCA1KJG0Hofz4nxirqrnt.I0S5GIfvuCwR../28q/8UHML7M/TIAG', 0, NULL, 1, 4, '2025-02-05 23:54:13', '2025-02-05 23:54:13'),
(7, 'Sandi', '0983494902325', 'sandi@gmail.com', '$2y$12$Gf9ECrdaeRBpoKQ6YlnmaeJPvgw2lB2J0i1IVn4ORqEYm.z1iaxx.', 0, NULL, 1, 2, '2025-02-05 23:54:58', '2025-02-05 23:54:58'),
(8, 'Gunawan', '084092483092', 'Gunawan@gmail.com', '$2y$12$S.L9TM3OBuGWr/F5TxuYfu2hDl2A1NRlzOb04Fqkh0F4QfsR.wlRu', 0, NULL, 1, 1, '2025-02-05 23:55:45', '2025-02-05 23:55:45'),
(9, 'Hanip', '90820205943', 'hanip@gmail.com', '$2y$12$YBLc0Z4Afv7cdS/5vt.PreHip0Ddc85G8sNSwstbdJO3.BmRRpa6y', 0, NULL, 2, 3, '2025-02-05 23:57:24', '2025-02-05 23:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('1491eb716b32b4e4bff239eb268665e0', 'i:2;', 1739067764),
('1491eb716b32b4e4bff239eb268665e0:timer', 'i:1739067764;', 1739067764),
('38a065a9fa3d426ccbf3b077ab4600a3', 'i:1;', 1738217351),
('38a065a9fa3d426ccbf3b077ab4600a3:timer', 'i:1738217351;', 1738217351),
('6be8285e84cfdfb4cec98b98a84b72d9', 'i:2;', 1738083389),
('6be8285e84cfdfb4cec98b98a84b72d9:timer', 'i:1738083389;', 1738083389),
('a75f3f172bfb296f2e10cbfc6dfc1883', 'i:3;', 1737947961),
('a75f3f172bfb296f2e10cbfc6dfc1883:timer', 'i:1737947961;', 1737947961),
('c292784d7ee3c8fbb161ad875f31fcdc', 'i:1;', 1738127454),
('c292784d7ee3c8fbb161ad875f31fcdc:timer', 'i:1738127454;', 1738127454),
('c34fe5ec95ef2dc462d044baba5327e9', 'i:1;', 1738080239),
('c34fe5ec95ef2dc462d044baba5327e9:timer', 'i:1738080239;', 1738080239),
('f1f70ec40aaa556905d4a030501c0ba4', 'i:1;', 1739067735),
('f1f70ec40aaa556905d4a030501c0ba4:timer', 'i:1739067735;', 1739067735);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bawaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kebarangkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_sampai` timestamp NOT NULL,
  `status` enum('Selesai dikerjakan','Sedang dikerjakan','Belum dikerjakan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum dikerjakan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id`, `gambar`, `bawaan`, `kebarangkatan`, `jam_sampai`, `status`, `created_at`, `updated_at`) VALUES
(2, 'image_informasi/kYSCSS36WMcdA0VLWNlygDh4RjIY2PaUSNdHMk7E.jpg', 'Emas', 'Rumbai', '2025-01-31 15:35:00', 'Belum dikerjakan', '2025-01-26 02:07:29', '2025-01-28 21:59:41'),
(4, 'image_informasi/5NGIkx8UcYLUgA3bCCeDnp2j7frnjDfQpahKTzaB.png', 'Tongkang', 'Bengkalis', '2025-01-31 05:00:00', 'Belum dikerjakan', '2025-01-28 22:00:35', '2025-01-28 22:00:35'),
(13, 'image_informasi/tTSf1Xn1mjBWvJFIsNLg6He5hVQQGFNwu5Pqc34D.png', 'Batu Bara', 'Sungai Pakning', '2025-02-05 05:00:00', 'Sedang dikerjakan', '2025-02-04 22:26:47', '2025-02-05 00:52:04'),
(22, 'image_informasi/jWJSiXzHxXiEOkKVInesQkF74WGIRo1AOEx9gads.png', 'Kucing', 'Malam', '2025-02-08 05:00:00', 'Belum dikerjakan', '2025-02-08 04:00:54', '2025-02-08 04:00:54'),
(23, 'image_informasi/jrOWTc6GI1Z4vs50RovdmZoPvgjs0c66ySVFJY24.jpg', 'Honda', 'Malam', '2025-02-10 05:00:00', 'Sedang dikerjakan', '2025-02-08 04:02:27', '2025-02-08 04:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `informasi_regu`
--

CREATE TABLE `informasi_regu` (
  `id` bigint UNSIGNED NOT NULL,
  `informasi_id` bigint UNSIGNED NOT NULL,
  `regu_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informasi_regu`
--

INSERT INTO `informasi_regu` (`id`, `informasi_id`, `regu_id`, `created_at`, `updated_at`) VALUES
(6, 2, 1, NULL, NULL),
(7, 2, 2, NULL, NULL),
(8, 2, 3, NULL, NULL),
(9, 4, 1, NULL, NULL),
(10, 4, 4, NULL, NULL),
(22, 13, 4, NULL, NULL),
(34, 13, 1, NULL, NULL),
(35, 13, 3, NULL, NULL),
(39, 22, 5, NULL, NULL),
(40, 22, 4, NULL, NULL),
(41, 22, 3, NULL, NULL),
(42, 23, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(22, '2025_01_25_044641_create_regu_table', 2),
(23, '2025_01_25_044910_create_profesi_table', 2),
(24, '2025_01_25_045006_create_anggota_table', 2),
(25, '2025_01_25_045102_create_absensi_table', 2),
(26, '2025_01_25_045258_create_slip_gaji_table', 2),
(27, '2025_01_25_045433_create_informasi_table', 2),
(29, '2025_01_26_161859_create_personal_access_tokens_table', 3),
(32, '2025_01_27_024251_create_personal_access_tokens_table', 4),
(33, '2025_01_31_032413_create_informasi_regu_table', 4),
(34, '2025_02_05_041808_remove_regu_id_from_informasi', 5),
(35, '2025_02_05_073615_add_status_to_informasi_table', 6),
(36, '2025_02_05_080141_add_ban_fields_to_anggota_table', 7),
(37, '2025_02_06_170418_add_tanggal_absensi_to_absensi_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 'App\\Models\\Anggota', 1, 'auth_token', '5d9ea54afe1951972524cbc05aff86b5d9a46b040b3e1b9194af763f520d0c15', '[\"*\"]', '2025-02-07 20:19:19', '2025-02-14 19:55:26', '2025-02-07 19:55:26', '2025-02-07 20:19:19'),
(2, 'App\\Models\\Anggota', 1, 'auth_token', '19aa0d8f99f8214bc432c31c9fe6f116e89a690dc3ce4bcaeff94bfee6721b30', '[\"*\"]', '2025-02-07 20:29:06', '2025-02-14 20:25:41', '2025-02-07 20:25:41', '2025-02-07 20:29:06'),
(3, 'App\\Models\\Anggota', 1, 'auth_token', 'b3ec9b5712122344f8cd4069cf20ac54ef0578061148d1f5d68804a24336287d', '[\"*\"]', '2025-02-08 07:11:01', '2025-02-14 20:32:21', '2025-02-07 20:32:21', '2025-02-08 07:11:01'),
(4, 'App\\Models\\Anggota', 1, 'auth_token', 'bdfaa5f834cf31470ce0044802215b0573e1a4b8b84b4d586d5ff65697fbe9b4', '[\"*\"]', '2025-02-08 10:39:45', '2025-02-14 20:55:06', '2025-02-07 20:55:06', '2025-02-08 10:39:45'),
(5, 'App\\Models\\Anggota', 1, 'auth_token', 'fe9266e2c69742fc8574b0dd64ea08840f7619972891213d691fd80d8d31d88f', '[\"*\"]', NULL, '2025-02-15 06:34:08', '2025-02-08 06:34:08', '2025-02-08 06:34:08'),
(6, 'App\\Models\\Anggota', 1, 'auth_token', 'b8eef721370624e8a8f17d268e5c21e95564276be7d3d2cc132df2e22ad64b61', '[\"*\"]', '2025-02-08 09:44:14', '2025-02-15 07:20:12', '2025-02-08 07:20:12', '2025-02-08 09:44:14'),
(7, 'App\\Models\\Anggota', 1, 'auth_token', 'a0eeff648df3337890f988eb2f2a41a0312572de611f22c39028efc307dbf84c', '[\"*\"]', '2025-02-08 19:21:15', '2025-02-15 09:46:09', '2025-02-08 09:46:09', '2025-02-08 19:21:15'),
(8, 'App\\Models\\Anggota', 1, 'auth_token', '3dcd7cb515f492399d13b77780fd64b060e01db59fcd584d869a9217ee255200', '[\"*\"]', NULL, '2025-02-15 19:21:50', '2025-02-08 19:21:50', '2025-02-08 19:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `profesi`
--

CREATE TABLE `profesi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_profesi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profesi`
--

INSERT INTO `profesi` (`id`, `nama_profesi`, `created_at`, `updated_at`) VALUES
(1, 'Operator', '2025-01-25 22:21:09', '2025-01-25 22:21:09'),
(2, 'Paylot', '2025-01-25 22:21:09', '2025-01-25 22:21:09'),
(3, 'Tongkang', '2025-01-25 22:21:09', '2025-01-25 22:21:09'),
(4, 'Palka', '2025-01-25 22:21:09', '2025-01-25 22:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `regu`
--

CREATE TABLE `regu` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_regu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regu`
--

INSERT INTO `regu` (`id`, `nama_regu`, `created_at`, `updated_at`) VALUES
(1, 'Regu 1', '2025-01-25 22:21:13', '2025-01-25 22:21:13'),
(2, 'Regu 2', '2025-01-25 22:21:13', '2025-01-25 22:21:13'),
(3, 'Regu 3', '2025-01-25 22:21:13', '2025-01-25 22:21:13'),
(4, 'Regu 4', '2025-01-25 22:21:13', '2025-01-25 22:21:13'),
(5, 'Regu 5', '2025-01-25 22:21:13', '2025-01-25 22:21:13'),
(6, 'Regu 6', '2025-02-10 01:24:06', '2025-02-10 01:24:06'),
(7, 'Regu 7', '2025-02-10 01:24:06', '2025-02-10 01:24:06'),
(8, 'Regu 8', '2025-02-10 01:24:06', '2025-02-10 01:24:06'),
(9, 'Regu 9', '2025-02-10 01:24:06', '2025-02-10 01:24:06'),
(10, 'Regu 10', '2025-02-10 01:24:06', '2025-02-10 01:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Bl27ZhplCvFIyIkW6NYtZIKX6nEt0JGjL8VMjWXY', 1, '192.168.229.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaFJPdkQ2MFdpc3A4YW9TNllZV1hIZE1VUmdYVXZ3TkV0Wmd4SU00TCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xOTIuMTY4LjIyOS4xMTk6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1739066653),
('kOvep6N5UU9y1ILWaGZKtZ64HLyEbtsgg3XUuQR1', 1, '192.168.229.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicU5DazRCdjRFZzY0VWRCWm53TnNwWHRzUVV4a2tnbGdqT3NvZXluWSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovLzE5Mi4xNjguMjI5LjExOTo4MDAwL2FuZ2dvdGEiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovLzE5Mi4xNjguMjI5LjExOTo4MDAwL2FuZ2dvdGEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1739033157),
('mjd1Z9nvS6l5Xpuwrw5Z3LTm3vNF7I4ilXIkMyph', 1, '192.168.229.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmgwQTZDMXlnbnhIQWJuSVhxT0ZQVVQyVXE3UkF2dHNsUGlQZ3pKOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xOTIuMTY4LjIyOS4xMTk6ODAwMC9hbmdnb3RhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1739024398);

-- --------------------------------------------------------

--
-- Table structure for table `slip_gaji`
--

CREATE TABLE `slip_gaji` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` bigint UNSIGNED NOT NULL,
  `profesi_id` bigint UNSIGNED NOT NULL,
  `regu_id` bigint UNSIGNED NOT NULL,
  `hadir` int NOT NULL,
  `izin` int NOT NULL,
  `lembur` int NOT NULL,
  `gaji` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slip_gaji`
--

INSERT INTO `slip_gaji` (`id`, `anggota_id`, `profesi_id`, `regu_id`, `hadir`, `izin`, `lembur`, `gaji`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 4, 1, 0, '25000000.00', '2025-01-26 06:56:52', '2025-01-28 21:58:39'),
(3, 2, 2, 4, 0, 2, 3, '30000000.00', '2025-01-26 07:11:07', '2025-01-26 08:56:05'),
(5, 1, 1, 1, 4, 1, 0, '30000000.00', '2025-01-28 21:58:22', '2025-01-28 21:58:22'),
(6, 1, 1, 1, 2, 0, 1, '1000000.00', '2025-02-07 19:43:55', '2025-02-07 19:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
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
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$rnCfinALkEWJ4Ei/sU1fYuqeLSgrIaO1V8iy.Y8EcohyazioPSPHq', NULL, '2025-01-24 19:52:41', '2025-01-24 19:52:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_anggota_id_foreign` (`anggota_id`),
  ADD KEY `absensi_profesi_id_foreign` (`profesi_id`),
  ADD KEY `absensi_regu_id_foreign` (`regu_id`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggota_email_unique` (`email`),
  ADD KEY `anggota_regu_id_foreign` (`regu_id`),
  ADD KEY `anggota_profesi_id_foreign` (`profesi_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informasi_regu`
--
ALTER TABLE `informasi_regu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informasi_regu_informasi_id_foreign` (`informasi_id`),
  ADD KEY `informasi_regu_regu_id_foreign` (`regu_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `profesi`
--
ALTER TABLE `profesi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regu`
--
ALTER TABLE `regu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slip_gaji_anggota_id_foreign` (`anggota_id`),
  ADD KEY `slip_gaji_profesi_id_foreign` (`profesi_id`),
  ADD KEY `slip_gaji_regu_id_foreign` (`regu_id`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `informasi_regu`
--
ALTER TABLE `informasi_regu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `profesi`
--
ALTER TABLE `profesi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `regu`
--
ALTER TABLE `regu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_profesi_id_foreign` FOREIGN KEY (`profesi_id`) REFERENCES `profesi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_profesi_id_foreign` FOREIGN KEY (`profesi_id`) REFERENCES `profesi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `anggota_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `informasi_regu`
--
ALTER TABLE `informasi_regu`
  ADD CONSTRAINT `informasi_regu_informasi_id_foreign` FOREIGN KEY (`informasi_id`) REFERENCES `informasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `informasi_regu_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD CONSTRAINT `slip_gaji_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `slip_gaji_profesi_id_foreign` FOREIGN KEY (`profesi_id`) REFERENCES `profesi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `slip_gaji_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
