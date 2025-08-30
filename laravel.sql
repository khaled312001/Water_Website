-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 07:25 PM
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
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','read','replied','closed') NOT NULL DEFAULT 'pending',
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'أحمد محمد العتيبي', 'ahmed.alotaibi@example.com', '0501234567', 'استفسار عن المنتجات', 'أريد معرفة المزيد عن منتجات المياه المتوفرة في الموقع', 'read', NULL, NULL, '2025-08-25 11:56:10', '2025-08-30 11:56:10'),
(2, 'فاطمة أحمد الزهراني', 'fatima.zahrani@example.com', '0501234568', 'شكوى في التوصيل', 'كان هناك تأخير في توصيل الطلب، أريد معرفة السبب', 'pending', NULL, NULL, '2025-08-27 11:56:10', '2025-08-30 11:56:10'),
(3, 'علي حسن المطيري', 'ali.mutairi@example.com', '0501234569', 'اقتراح تحسين', 'أقترح إضافة المزيد من أنواع المياه المعدنية', 'read', NULL, NULL, '2025-08-23 11:56:10', '2025-08-30 11:56:10'),
(4, 'خديجة سعد القحطاني', 'khadija.qhtani@example.com', '0501234570', 'طلب انضمام كمورد', 'أريد الانضمام كموزع للمياه في حي العزيزية', 'pending', NULL, NULL, '2025-08-29 11:56:10', '2025-08-30 11:56:10'),
(5, 'محمد خالد الحربي', 'mohammed.harbi@example.com', '0501234571', 'مشكلة في الحساب', 'لا أستطيع تسجيل الدخول إلى حسابي', 'read', NULL, NULL, '2025-08-28 11:56:10', '2025-08-30 11:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `national_id` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `emergency_phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'مكة المكرمة',
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('available','busy','offline','suspended') NOT NULL DEFAULT 'offline',
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_deliveries` int(11) NOT NULL DEFAULT 0,
  `total_earnings` decimal(10,2) NOT NULL DEFAULT 0.00,
  `current_lat` decimal(10,8) DEFAULT NULL,
  `current_lng` decimal(11,8) DEFAULT NULL,
  `last_active` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_men`
--

INSERT INTO `delivery_men` (`id`, `user_id`, `national_id`, `vehicle_type`, `vehicle_number`, `license_number`, `emergency_contact`, `emergency_phone`, `address`, `city`, `profile_image`, `status`, `rating`, `total_deliveries`, `total_earnings`, `current_lat`, `current_lng`, `last_active`, `created_at`, `updated_at`) VALUES
(1, 7, '1234567890', 'سيارة صغيرة', 'مكة 1234', 'DL123456789', 'أحمد يوسف', '0501234583', 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', NULL, 'available', 4.90, 350, 8500.00, 21.46946646, 39.91888079, '2025-08-30 17:10:57', '2025-08-30 11:55:36', '2025-08-30 17:10:57'),
(2, 8, '0987654321', 'دراجة نارية', 'مكة 5678', 'DL987654321', 'محمد عبدالرحمن', '0501234584', 'حي الشوقية، مكة المكرمة', 'مكة المكرمة', NULL, 'available', 4.70, 280, 7200.00, NULL, NULL, NULL, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(3, 9, '1122334455', 'سيارة صغيرة', 'مكة 9012', 'DL112233445', 'علي سعد', '0501234585', 'حي المسفلة، مكة المكرمة', 'مكة المكرمة', NULL, 'available', 4.80, 320, 7800.00, NULL, NULL, NULL, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(4, 10, '2233445566', 'دراجة نارية', 'مكة 3456', 'DL223344556', 'فهد محمد', '0501234586', 'حي العتيبية، مكة المكرمة', 'مكة المكرمة', NULL, 'available', 4.60, 240, 6500.00, NULL, NULL, NULL, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(5, 11, '3344556677', 'سيارة صغيرة', 'مكة 7890', 'DL334455667', 'سلطان عبدالله', '0501234587', 'حي المنصور، مكة المكرمة', 'مكة المكرمة', NULL, 'available', 4.90, 380, 9200.00, NULL, NULL, NULL, '2025-08-30 11:55:36', '2025-08-30 11:55:36');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_27_184849_create_suppliers_table', 1),
(5, '2025_08_27_184851_create_delivery_men_table', 1),
(6, '2025_08_27_184856_create_products_table', 1),
(7, '2025_08_27_185050_create_orders_table', 1),
(8, '2025_08_27_185141_create_reviews_table', 1),
(9, '2025_08_30_133050_create_contacts_table', 1),
(10, '2025_01_15_000000_create_payments_table', 2),
(11, '2025_08_30_160749_add_pending_payment_status_to_orders_table', 3),
(12, '2025_08_30_160809_update_payment_method_enum_in_orders_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_address` text NOT NULL,
  `delivery_city` varchar(255) NOT NULL DEFAULT 'مكة المكرمة',
  `customer_phone` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','pending_payment','confirmed','preparing','assigned','picked_up','delivered','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash','bank_transfer','visa','card','online') DEFAULT NULL,
  `estimated_delivery_time` timestamp NULL DEFAULT NULL,
  `actual_delivery_time` timestamp NULL DEFAULT NULL,
  `delivery_lat` decimal(10,8) DEFAULT NULL,
  `delivery_lng` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `supplier_id`, `delivery_man_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `delivery_fee`, `commission`, `total_amount`, `delivery_address`, `delivery_city`, `customer_phone`, `customer_name`, `notes`, `status`, `payment_status`, `payment_method`, `estimated_delivery_time`, `actual_delivery_time`, `delivery_lat`, `delivery_lng`, `created_at`, `updated_at`) VALUES
(1, 'ORD-000001', 15, 2, 2, 13, 1, 10.00, 10.00, 13.00, 1.00, 23.00, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-06 11:55:36', '2025-06-06 11:55:36'),
(2, 'ORD-000002', 12, 5, 2, 10, 2, 2.25, 4.50, 19.00, 0.45, 23.50, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-08-01 11:55:36', '2025-08-01 11:55:36'),
(3, 'ORD-000003', 14, 2, 3, 3, 2, 2.75, 5.50, 11.00, 0.55, 16.50, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-25 11:55:36', '2025-07-25 11:55:36'),
(4, 'ORD-000004', 16, 4, 5, 8, 3, 2.80, 8.40, 21.00, 0.84, 29.40, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', 'يرجى التوصيل في الصباح', 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-27 11:55:36', '2025-07-27 11:55:36'),
(5, 'ORD-000005', 12, 5, 5, 10, 5, 2.25, 11.25, 20.00, 1.13, 31.25, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', 'يرجى التوصيل في الصباح', 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-06-07 11:55:36', '2025-06-07 11:55:36'),
(6, 'ORD-000006', 14, 1, 5, 1, 1, 2.50, 2.50, 25.00, 0.25, 27.50, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-31 11:55:36', '2025-07-31 11:55:36'),
(7, 'ORD-000007', 13, 1, 1, 1, 1, 2.50, 2.50, 24.00, 0.25, 26.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-08-16 11:55:36', '2025-08-30 16:59:23'),
(8, 'ORD-000008', 13, 4, 2, 7, 2, 3.25, 6.50, 25.00, 0.65, 31.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-07 11:55:36', '2025-07-07 11:55:36'),
(9, 'ORD-000009', 14, 5, 5, 10, 2, 2.25, 4.50, 10.00, 0.45, 14.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'confirmed', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-06-23 11:55:36', '2025-06-23 11:55:36'),
(10, 'ORD-000010', 13, 3, 4, 14, 1, 2.25, 2.25, 25.00, 0.23, 27.25, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'confirmed', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-07-23 11:55:36', '2025-07-23 11:55:36'),
(11, 'ORD-000011', 12, 5, 2, 10, 2, 2.25, 4.50, 22.00, 0.45, 26.50, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-09 11:55:36', '2025-06-09 11:55:36'),
(12, 'ORD-000012', 14, 3, 5, 14, 1, 2.25, 2.25, 21.00, 0.23, 23.25, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-08-21 11:55:36', '2025-08-21 11:55:36'),
(13, 'ORD-000013', 13, 3, 2, 5, 1, 4.25, 4.25, 25.00, 0.43, 29.25, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'cancelled', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-08-02 11:55:36', '2025-08-02 11:55:36'),
(14, 'ORD-000014', 15, 1, 5, 2, 4, 5.00, 20.00, 10.00, 2.00, 30.00, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', 'يرجى التوصيل في الصباح', 'delivered', 'paid', 'online', NULL, NULL, NULL, NULL, '2025-06-04 11:55:36', '2025-06-04 11:55:36'),
(15, 'ORD-000015', 15, 4, 1, 15, 5, 3.50, 17.50, 10.00, 1.75, 27.50, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'preparing', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-06-06 11:55:36', '2025-06-06 11:55:36'),
(16, 'ORD-000016', 14, 5, 2, 9, 4, 3.50, 14.00, 16.00, 1.40, 30.00, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'confirmed', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-24 11:55:36', '2025-06-24 11:55:36'),
(17, 'ORD-000017', 14, 5, 2, 10, 3, 2.25, 6.75, 17.00, 0.68, 23.75, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-08-24 11:55:36', '2025-08-24 11:55:36'),
(18, 'ORD-000018', 12, 5, 3, 10, 4, 2.25, 9.00, 22.00, 0.90, 31.00, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'pending', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-06-21 11:55:36', '2025-06-21 11:55:36'),
(19, 'ORD-000019', 15, 1, 2, 1, 1, 2.50, 2.50, 24.00, 0.25, 26.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-08-23 11:55:36', '2025-08-23 11:55:36'),
(20, 'ORD-000020', 14, 1, 4, 1, 5, 2.50, 12.50, 20.00, 1.25, 32.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'cancelled', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-24 11:55:36', '2025-07-24 11:55:36'),
(21, 'ORD-000021', 13, 4, 3, 15, 5, 3.50, 17.50, 25.00, 1.75, 42.50, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'delivered', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-07-18 11:55:36', '2025-07-18 11:55:36'),
(22, 'ORD-000022', 13, 3, 4, 6, 5, 2.50, 12.50, 22.00, 1.25, 34.50, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'pending', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-06-26 11:55:36', '2025-06-26 11:55:36'),
(23, 'ORD-000023', 13, 5, 1, 9, 2, 3.50, 7.00, 25.00, 0.70, 32.00, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'confirmed', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-19 11:55:36', '2025-06-19 11:55:36'),
(24, 'ORD-000024', 14, 5, 1, 9, 2, 3.50, 7.00, 13.00, 0.70, 20.00, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'cancelled', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-08-01 11:55:36', '2025-08-01 11:55:36'),
(25, 'ORD-000025', 14, 5, 5, 11, 5, 4.75, 23.75, 17.00, 2.38, 40.75, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-13 11:55:36', '2025-07-13 11:55:36'),
(26, 'ORD-000026', 14, 5, 5, 9, 3, 3.50, 10.50, 18.00, 1.05, 28.50, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-07-21 11:55:36', '2025-07-21 11:55:36'),
(27, 'ORD-000027', 13, 4, 1, 15, 2, 3.50, 7.00, 23.00, 0.70, 30.00, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-06-24 11:55:36', '2025-06-24 11:55:36'),
(28, 'ORD-000028', 12, 4, 1, 7, 4, 3.25, 13.00, 15.00, 1.30, 28.00, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-07-10 11:55:37', '2025-08-30 17:00:11'),
(29, 'ORD-000029', 13, 3, 5, 6, 1, 2.50, 2.50, 22.00, 0.25, 24.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-07-27 11:55:37', '2025-07-27 11:55:37'),
(30, 'ORD-000030', 15, 4, 4, 8, 3, 2.80, 8.40, 18.00, 0.84, 26.40, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', 'يرجى التوصيل في الصباح', 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-08-28 11:55:37', '2025-08-28 11:55:37'),
(31, 'ORD-000031', 15, 2, 4, 4, 4, 2.90, 11.60, 21.00, 1.16, 32.60, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', 'يرجى التوصيل في الصباح', 'pending', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-07-07 11:55:37', '2025-07-07 11:55:37'),
(32, 'ORD-000032', 14, 4, 2, 7, 3, 3.25, 9.75, 22.00, 0.98, 31.75, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'assigned', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-08-12 11:55:37', '2025-08-12 11:55:37'),
(33, 'ORD-000033', 14, 1, 3, 12, 1, 3.25, 3.25, 10.00, 0.33, 13.25, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-07-02 11:55:37', '2025-07-02 11:55:37'),
(34, 'ORD-000034', 12, 2, 2, 13, 1, 10.00, 10.00, 20.00, 1.00, 30.00, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-06-22 11:55:37', '2025-06-22 11:55:37'),
(35, 'ORD-000035', 13, 1, 1, 2, 4, 5.00, 20.00, 13.00, 2.00, 33.00, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-08-12 11:55:37', '2025-08-12 11:55:37'),
(36, 'ORD-000036', 12, 1, 1, 2, 5, 5.00, 25.00, 14.00, 2.50, 39.00, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'card', NULL, NULL, NULL, NULL, '2025-06-28 11:55:37', '2025-06-28 11:55:37'),
(37, 'ORD-000037', 14, 2, 3, 4, 2, 2.90, 5.80, 17.00, 0.58, 22.80, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'cancelled', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-07-25 11:55:37', '2025-07-25 11:55:37'),
(38, 'ORD-000038', 15, 4, 5, 15, 1, 3.50, 3.50, 10.00, 0.35, 13.50, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-25 11:55:37', '2025-06-25 11:55:37'),
(39, 'ORD-000039', 12, 5, 5, 11, 4, 4.75, 19.00, 17.00, 1.90, 36.00, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'preparing', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-07-28 11:55:37', '2025-07-28 11:55:37'),
(40, 'ORD-000040', 13, 1, 1, 1, 1, 2.50, 2.50, 11.00, 0.25, 13.50, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-06-28 11:55:37', '2025-08-30 17:03:02'),
(41, 'ORD-000041', 13, 1, 2, 2, 5, 5.00, 25.00, 25.00, 2.50, 50.00, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'confirmed', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-19 11:55:37', '2025-07-19 11:55:37'),
(42, 'ORD-000042', 14, 5, 4, 9, 3, 3.50, 10.50, 12.00, 1.05, 22.50, 'حي المنصور، شارع الشوقية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-06-29 11:55:37', '2025-06-29 11:55:37'),
(43, 'ORD-000043', 14, 5, 3, 9, 2, 3.50, 7.00, 19.00, 0.70, 26.00, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'delivered', 'paid', 'card', NULL, NULL, NULL, NULL, '2025-06-25 11:55:37', '2025-06-25 11:55:37'),
(44, 'ORD-000044', 13, 3, 5, 5, 4, 4.25, 17.00, 23.00, 1.70, 40.00, 'حي العتيبية، شارع العتيبية، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'assigned', 'pending', 'card', NULL, NULL, NULL, NULL, '2025-07-05 11:55:37', '2025-07-05 11:55:37'),
(45, 'ORD-000045', 16, 5, 5, 9, 5, 3.50, 17.50, 10.00, 1.75, 27.50, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'pending', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-07-03 11:55:37', '2025-07-03 11:55:37'),
(46, 'ORD-000046', 14, 4, 2, 15, 4, 3.50, 14.00, 13.00, 1.40, 27.00, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'cancelled', 'pending', 'online', NULL, NULL, NULL, NULL, '2025-08-28 11:55:37', '2025-08-28 11:55:37'),
(47, 'ORD-000047', 16, 3, 1, 5, 2, 4.25, 8.50, 20.00, 0.85, 28.50, 'حي الشوقية، شارع العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', 'يرجى التوصيل في الصباح', 'delivered', 'pending', 'cash', NULL, '2025-08-30 16:59:52', NULL, NULL, '2025-08-22 11:55:37', '2025-08-30 16:59:52'),
(48, 'ORD-000048', 13, 2, 4, 13, 1, 10.00, 10.00, 13.00, 1.00, 23.00, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', 'يرجى التوصيل في الصباح', 'picked_up', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-07-17 11:55:37', '2025-07-17 11:55:37'),
(49, 'ORD-000049', 14, 5, 4, 9, 5, 3.50, 17.50, 12.00, 1.75, 29.50, 'حي المسفلة، شارع المنصور، مكة المكرمة', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', 'يرجى التوصيل في الصباح', 'delivered', 'paid', 'card', NULL, NULL, NULL, NULL, '2025-08-01 11:55:37', '2025-08-01 11:55:37'),
(50, 'ORD-000050', 16, 4, 2, 7, 4, 3.25, 13.00, 20.00, 1.30, 33.00, 'حي العزيزية، شارع الملك عبدالله، مكة المكرمة', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-07-20 11:55:37', '2025-07-20 11:55:37'),
(51, 'ORD-1756569296-8121', 12, 1, NULL, 1, 3, 45.00, 162.00, 0.00, 27.00, 162.00, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 12:54:56', '2025-08-30 12:54:56'),
(52, 'ORD-1756569413-9246', 12, 1, NULL, 1, 3, 45.00, 162.00, 0.00, 27.00, 162.00, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 12:56:53', '2025-08-30 12:56:53'),
(53, 'ORD-1756569556-2251', 12, 1, NULL, 1, 1, 45.00, 54.00, 0.00, 9.00, 54.00, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 12:59:16', '2025-08-30 12:59:16'),
(54, 'ORD-1756569579-5379', 12, 1, NULL, 1, 1, 45.00, 54.00, 0.00, 9.00, 54.00, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'pending', 'pending', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 12:59:39', '2025-08-30 12:59:39'),
(55, 'ORD-1756570126-5446', 12, 3, 1, 5, 3, 65.00, 234.00, 0.00, 39.00, 234.00, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'pending', 'cash', NULL, '2025-08-30 16:59:17', NULL, NULL, '2025-08-30 13:08:46', '2025-08-30 16:59:17'),
(56, 'ORD-7616', 12, 2, 2, 9, 2, 3.50, 7.00, 20.00, 11.00, 27.00, 'عنوان تجريبي 1', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 08:29:00', NULL, NULL, '2025-08-30 12:00:00', '2025-08-30 17:02:30'),
(57, 'ORD-1291', 12, 5, 5, 8, 4, 2.80, 11.20, 12.00, 12.00, 23.20, 'عنوان تجريبي 2', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 15:27:00', NULL, NULL, '2025-08-30 07:00:00', '2025-08-30 17:02:30'),
(58, 'ORD-7364', 14, 1, 5, 11, 3, 4.75, 14.25, 21.00, 14.00, 35.25, 'عنوان تجريبي 3', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 09:07:00', NULL, NULL, '2025-08-30 09:00:00', '2025-08-30 17:02:30'),
(59, 'ORD-5840', 15, 1, 2, 15, 4, 3.50, 14.00, 18.00, 5.00, 32.00, 'عنوان تجريبي 4', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 12:25:00', NULL, NULL, '2025-08-30 11:00:00', '2025-08-30 17:02:30'),
(60, 'ORD-3446', 16, 1, 2, 10, 1, 2.25, 2.25, 28.00, 10.00, 30.25, 'عنوان تجريبي 5', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 13:00:00', NULL, NULL, '2025-08-30 09:00:00', '2025-08-30 17:02:30'),
(61, 'ORD-0606', 14, 2, 1, 15, 3, 3.50, 10.50, 20.00, 7.00, 30.50, 'عنوان تجريبي 6', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-22 17:58:30', NULL, NULL, '2025-08-10 17:02:30', '2025-08-30 17:02:30'),
(62, 'ORD-5503', 14, 4, 5, 5, 1, 4.25, 4.25, 21.00, 10.00, 25.25, 'عنوان تجريبي 7', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-20 18:33:30', NULL, NULL, '2025-08-21 17:02:30', '2025-08-30 17:02:30'),
(63, 'ORD-4880', 15, 3, 2, 7, 2, 3.25, 6.50, 13.00, 13.00, 19.50, 'عنوان تجريبي 8', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-19 18:01:30', NULL, NULL, '2025-08-01 17:02:30', '2025-08-30 17:02:30'),
(64, 'ORD-1734', 15, 2, 5, 9, 5, 3.50, 17.50, 23.00, 15.00, 40.50, 'عنوان تجريبي 9', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-18 18:01:30', NULL, NULL, '2025-08-24 17:02:30', '2025-08-30 17:02:30'),
(65, 'ORD-6294', 16, 1, 4, 13, 2, 10.00, 20.00, 12.00, 6.00, 32.00, 'عنوان تجريبي 10', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-08 18:07:30', NULL, NULL, '2025-08-28 17:02:30', '2025-08-30 17:02:30'),
(66, 'ORD-4287', 16, 2, 1, 4, 5, 2.90, 14.50, 25.00, 15.00, 39.50, 'عنوان تجريبي 11', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-13 18:49:30', NULL, NULL, '2025-08-26 17:02:30', '2025-08-30 17:02:30'),
(67, 'ORD-9534', 16, 4, 1, 1, 3, 2.50, 7.50, 20.00, 8.00, 27.50, 'عنوان تجريبي 12', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-22 17:41:30', NULL, NULL, '2025-08-23 17:02:30', '2025-08-30 17:02:30'),
(68, 'ORD-6257', 12, 2, 5, 3, 4, 2.75, 11.00, 15.00, 13.00, 26.00, 'عنوان تجريبي 13', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-14 17:55:30', NULL, NULL, '2025-08-06 17:02:30', '2025-08-30 17:02:30'),
(69, 'ORD-9959', 16, 5, 3, 4, 4, 2.90, 11.60, 24.00, 6.00, 35.60, 'عنوان تجريبي 14', 'مكة المكرمة', '0501234582', 'محمد خالد الحربي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-18 18:49:30', NULL, NULL, '2025-08-12 17:02:30', '2025-08-30 17:02:30'),
(70, 'ORD-7121', 15, 4, 4, 5, 1, 4.25, 4.25, 15.00, 12.00, 19.25, 'عنوان تجريبي 15', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-10 18:57:30', NULL, NULL, '2025-08-02 17:02:30', '2025-08-30 17:02:30'),
(71, 'ORD-5493', 12, 3, 5, 5, 3, 4.25, 12.75, 16.00, 12.00, 28.75, 'عنوان تجريبي 16', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-15 18:12:30', NULL, NULL, '2025-08-07 17:02:30', '2025-08-30 17:02:30'),
(72, 'ORD-2398', 15, 2, 2, 8, 2, 2.80, 5.60, 29.00, 5.00, 34.60, 'عنوان تجريبي 17', 'مكة المكرمة', '0501234581', 'خديجة سعد القحطاني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-02 17:32:30', NULL, NULL, '2025-08-19 17:02:30', '2025-08-30 17:02:30'),
(73, 'ORD-1788', 12, 1, 2, 13, 1, 10.00, 10.00, 21.00, 9.00, 31.00, 'عنوان تجريبي 18', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-17 18:25:30', NULL, NULL, '2025-08-25 17:02:30', '2025-08-30 17:02:30'),
(74, 'ORD-1477', 14, 4, 3, 11, 4, 4.75, 19.00, 24.00, 10.00, 43.00, 'عنوان تجريبي 19', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-19 18:29:30', NULL, NULL, '2025-08-26 17:02:30', '2025-08-30 17:02:30'),
(75, 'ORD-0973', 13, 4, 4, 8, 1, 2.80, 2.80, 16.00, 14.00, 18.80, 'عنوان تجريبي 20', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-28 17:33:30', NULL, NULL, '2025-08-08 17:02:30', '2025-08-30 17:02:30'),
(76, 'ORD-9870', 12, 3, 1, 8, 1, 2.80, 2.80, 17.00, 6.00, 19.80, 'عنوان تجريبي 21', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, '2025-08-30 17:05:14', NULL, NULL, '2025-08-30 17:02:30', '2025-08-30 17:05:14'),
(77, 'ORD-1619', 13, 4, 1, 9, 1, 3.50, 3.50, 24.00, 12.00, 27.50, 'عنوان تجريبي 22', 'مكة المكرمة', '0501234579', 'فاطمة محمد الزهراني', NULL, 'assigned', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 17:02:30', '2025-08-30 17:02:30'),
(78, 'ORD-6952', 14, 3, 2, 3, 4, 2.75, 11.00, 12.00, 6.00, 23.00, 'عنوان تجريبي 23', 'مكة المكرمة', '0501234580', 'علي أحمد المطيري', NULL, 'assigned', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 17:02:30', '2025-08-30 17:02:30'),
(79, 'ORD-1756573411-7129', 12, 3, 1, 6, 1, 48.00, 57.60, 0.00, 9.60, 57.60, 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', '0501234578', 'أحمد علي العتيبي', NULL, 'delivered', 'paid', 'cash', NULL, NULL, NULL, NULL, '2025-08-30 17:03:31', '2025-08-30 17:19:21');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('visa','bank_transfer','cash') NOT NULL DEFAULT 'cash',
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','failed','verified') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `amount`, `status`, `transaction_id`, `receipt_image`, `notes`, `paid_at`, `verified_at`, `verified_by`, `created_at`, `updated_at`) VALUES
(1, 54, 'cash', 54.00, 'paid', NULL, NULL, NULL, '2025-08-30 13:03:16', NULL, NULL, '2025-08-30 13:03:16', '2025-08-30 13:03:16'),
(2, 55, 'cash', 234.00, 'paid', NULL, NULL, NULL, '2025-08-30 13:09:18', NULL, NULL, '2025-08-30 13:09:18', '2025-08-30 13:09:18'),
(3, 79, 'cash', 57.60, 'verified', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-30 17:03:41', '2025-08-30 17:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity_per_box` int(11) NOT NULL,
  `price_per_box` decimal(10,2) NOT NULL,
  `price_per_bottle` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `type` enum('mineral','distilled','spring','alkaline') NOT NULL DEFAULT 'mineral',
  `status` enum('available','out_of_stock','discontinued') NOT NULL DEFAULT 'available',
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_sales` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `supplier_id`, `name`, `description`, `brand`, `size`, `quantity_per_box`, `price_per_box`, `price_per_bottle`, `image`, `barcode`, `type`, `status`, `stock_quantity`, `rating`, `total_sales`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'مياه زمزم المعدنية', 'مياه زمزم الطبيعية من بئر زمزم المبارك، مياه نقية وطبيعية 100%', 'زمزم', '500 مل', 24, 45.00, 2.50, 'products/zamzam-water-500ml.jpg', '6281000001234', 'mineral', 'available', 500, 4.90, 1200, 1, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(2, 1, 'مياه زمزم الكبيرة', 'مياه زمزم في عبوات كبيرة مناسبة للعائلات والمطاعم', 'زمزم', '1.5 لتر', 12, 60.00, 5.00, 'products/zamzam-water-1.5l.jpg', '6281000001235', 'mineral', 'available', 300, 4.80, 800, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(3, 2, 'مياه نوفا المعدنية', 'مياه نوفا الطبيعية من جبال مكة المكرمة، غنية بالمعادن الطبيعية', 'نوفا', '600 مل', 20, 50.00, 2.75, 'products/nova-water-600ml.jpg', '6281000001236', 'mineral', 'available', 400, 4.70, 950, 1, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(4, 2, 'مياه نوفا المقطرة', 'مياه نوفا المقطرة النقية، مثالية للاستخدام في الأجهزة الطبية', 'نوفا', '500 مل', 24, 55.00, 2.90, 'products/nova-distilled-500ml.jpg', '6281000001237', 'distilled', 'available', 200, 4.60, 450, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(5, 3, 'مياه القلعة القلوية', 'مياه القلعة القلوية الفاخرة، تساعد في توازن حموضة الجسم', 'القلعة', '750 مل', 16, 65.00, 4.25, 'products/alkaline-water-750ml.jpg', '6281000001238', 'alkaline', 'available', 250, 4.80, 600, 1, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(6, 3, 'مياه القلعة العادية', 'مياه القلعة الطبيعية من ينابيع مكة المكرمة', 'القلعة', '500 مل', 24, 48.00, 2.50, 'products/alkaline-water-500ml.jpg', '6281000001239', 'mineral', 'available', 350, 4.50, 750, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(7, 4, 'مياه العتيبية المقطرة', 'مياه العتيبية المقطرة النقية، مناسبة للاستخدام في البطاريات والأجهزة', 'العتيبية', '1 لتر', 18, 58.00, 3.25, 'products/atibiya-distilled-1l.jpg', '6281000001240', 'distilled', 'available', 180, 4.40, 320, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(8, 4, 'مياه العتيبية المعدنية', 'مياه العتيبية المعدنية الطبيعية من جبال مكة', 'العتيبية', '600 مل', 20, 52.00, 2.80, 'products/atibiya-mineral-600ml.jpg', '6281000001241', 'mineral', 'available', 280, 4.30, 420, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(9, 5, 'مياه المنصور الفاخرة', 'مياه المنصور الفاخرة من ينابيع مكة المكرمة، مياه نقية وطبيعية', 'المنصور', '500 مل', 24, 70.00, 3.50, 'products/mansour-premium-500ml.jpg', '6281000001242', 'mineral', 'available', 150, 4.90, 280, 1, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(10, 5, 'مياه المنصور العادية', 'مياه المنصور العادية، جودة عالية بسعر مناسب', 'المنصور', '500 مل', 24, 45.00, 2.25, 'products/mansour-regular-500ml.jpg', '6281000001243', 'mineral', 'available', 400, 4.60, 850, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(11, 5, 'مياه المنصور القلوية', 'مياه المنصور القلوية، تساعد في تحسين صحة الجسم', 'المنصور', '750 مل', 16, 75.00, 4.75, 'products/mansour-alkaline-750ml.jpg', '6281000001244', 'alkaline', 'available', 120, 4.80, 180, 1, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(12, 1, 'مياه زمزم للرياضيين', 'مياه زمزم مخصصة للرياضيين، غنية بالأملاح المعدنية', 'زمزم', '1 لتر', 18, 55.00, 3.25, 'products/zamzam-sports-1l.jpg', '6281000001245', 'mineral', 'available', 200, 4.70, 350, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(13, 2, 'مياه نوفا للعائلات', 'مياه نوفا في عبوات كبيرة مناسبة للعائلات', 'نوفا', '2 لتر', 8, 80.00, 10.00, 'products/nova-family-2l.jpg', '6281000001246', 'mineral', 'available', 100, 4.50, 150, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(14, 3, 'مياه القلعة للضيافة', 'مياه القلعة في عبوات أنيقة مناسبة للضيافة', 'القلعة', '330 مل', 30, 60.00, 2.25, 'products/alkaline-hospitality-330ml.jpg', '6281000001247', 'mineral', 'available', 150, 4.60, 220, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(15, 4, 'مياه العتيبية للاستخدام الطبي', 'مياه العتيبية المقطرة للاستخدام في الأجهزة الطبية', 'العتيبية', '500 مل', 24, 65.00, 3.50, 'products/atibiya-medical-500ml.jpg', '6281000001248', 'distilled', 'available', 80, 4.80, 120, 0, '2025-08-30 11:55:36', '2025-08-30 11:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_price` decimal(10,2) NOT NULL,
  `customer_price` decimal(10,2) NOT NULL,
  `profit_margin` decimal(10,2) NOT NULL,
  `admin_commission` decimal(10,2) NOT NULL,
  `delivery_commission` decimal(10,2) NOT NULL,
  `status` enum('pending','distributed','cancelled') NOT NULL DEFAULT 'pending',
  `distributed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`id`, `order_id`, `supplier_price`, `customer_price`, `profit_margin`, `admin_commission`, `delivery_commission`, `status`, `distributed_at`, `created_at`, `updated_at`) VALUES
(1, 54, 45.00, 54.00, 9.00, 5.40, 3.60, 'pending', NULL, '2025-08-30 13:03:16', '2025-08-30 13:03:16'),
(2, 55, 195.00, 234.00, 39.00, 23.40, 15.60, 'pending', NULL, '2025-08-30 13:09:18', '2025-08-30 13:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `profit_distributions`
--

CREATE TABLE `profit_distributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profit_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` enum('admin','delivery_man') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','transferred','failed') NOT NULL DEFAULT 'pending',
  `transferred_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_man_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `type` enum('product','supplier','delivery') NOT NULL DEFAULT 'product',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `order_id`, `product_id`, `supplier_id`, `delivery_man_id`, `rating`, `comment`, `type`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 13, 43, 1, NULL, NULL, 4, 'مياه العتيبية المقطرة مناسبة للأجهزة الطبية', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(2, 16, 26, 1, NULL, NULL, 5, 'أفضل مياه شربت في حياتي، أنصح الجميع بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(3, 16, 16, 2, NULL, NULL, 5, 'مياه القلعة القلوية مفيدة جداً للصحة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(4, 14, 42, 2, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(5, 13, 13, 2, NULL, NULL, 4, 'مياه العتيبية للاستخدام الطبي عالية الجودة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(6, 16, 41, 3, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(7, 15, 18, 3, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(8, 15, 2, 3, NULL, NULL, 4, 'مياه العتيبية المقطرة مناسبة للأجهزة الطبية', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(9, 13, 28, 4, NULL, NULL, 4, 'جودة عالية وسعر معقول، أنصح بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(10, 15, 24, 4, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(11, 15, 4, 5, NULL, NULL, 4, 'جودة عالية وسعر معقول، أنصح بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(12, 16, 34, 5, NULL, NULL, 5, 'مياه القلعة القلوية مفيدة جداً للصحة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(13, 12, 48, 5, NULL, NULL, 5, 'مياه القلعة للضيافة أنيقة ومميزة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(14, 16, 9, 5, NULL, NULL, 5, 'مياه المنصور الفاخرة تستحق كل ريال', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(15, 15, 23, 6, NULL, NULL, 4, 'مياه العتيبية للاستخدام الطبي عالية الجودة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(16, 16, 23, 6, NULL, NULL, 5, 'مياه زمزم المباركة، أشعر بالبركة عند شربها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(17, 12, 1, 7, NULL, NULL, 4, 'مياه نقية وطازجة، أوصي بها للعائلات', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(18, 13, 29, 7, NULL, NULL, 5, 'مياه المنصور الفاخرة تستحق كل ريال', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(19, 15, 31, 8, NULL, NULL, 5, 'أفضل مياه شربت في حياتي، أنصح الجميع بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(20, 14, 41, 8, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(21, 14, 16, 8, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(22, 13, 7, 9, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(23, 12, 50, 9, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(24, 16, 15, 10, NULL, NULL, 4, 'مياه جيدة، سعر مناسب وجودة عالية', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(25, 16, 5, 10, NULL, NULL, 5, 'مياه القلعة القلوية مفيدة جداً للصحة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(26, 16, 43, 10, NULL, NULL, 4, 'مياه العتيبية للاستخدام الطبي عالية الجودة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(27, 16, 7, 11, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(28, 12, 16, 11, NULL, NULL, 5, 'مياه القلعة للضيافة أنيقة ومميزة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(29, 15, 37, 11, NULL, NULL, 5, 'مياه القلعة القلوية مفيدة جداً للصحة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(30, 15, 45, 11, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(31, 15, 11, 12, NULL, NULL, 5, 'مياه المنصور الفاخرة تستحق كل ريال', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(32, 13, 39, 12, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(33, 12, 43, 12, NULL, NULL, 5, 'مياه القلعة القلوية مفيدة جداً للصحة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(34, 14, 15, 12, NULL, NULL, 4, 'جودة عالية وسعر معقول، أنصح بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(35, 15, 23, 13, NULL, NULL, 5, 'مياه المنصور الفاخرة تستحق كل ريال', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(36, 16, 8, 13, NULL, NULL, 4, 'مياه طبيعية من ينابيع مكة، ممتازة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(37, 15, 25, 13, NULL, NULL, 5, 'أفضل مياه شربت في حياتي، أنصح الجميع بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(38, 14, 11, 13, NULL, NULL, 5, 'مياه زمزم ممتازة جداً، طعمها طبيعي ونقية 100%', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(39, 14, 39, 14, NULL, NULL, 5, 'أفضل مياه شربت في حياتي، أنصح الجميع بها', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(40, 12, 13, 14, NULL, NULL, 4, 'مياه نوفا للعائلات اقتصادية ومفيدة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(41, 14, 1, 14, NULL, NULL, 4, 'مياه العتيبية المقطرة مناسبة للأجهزة الطبية', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(42, 12, 39, 15, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(43, 12, 39, 15, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(44, 15, 37, 15, NULL, NULL, 4, 'مياه جيدة، سعر مناسب وجودة عالية', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37'),
(45, 15, 30, 15, NULL, NULL, 5, 'مياه زمزم للرياضيين ممتازة، تعطي طاقة', 'product', 1, '2025-08-30 11:55:37', '2025-08-30 11:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iDrX0puXFCCo4kN50y3uY1WJHSvCsh0MpdVpkjzG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU21rbTdrN2l3eVYyVXQ3NnBTeTFVZEJHbDNHMWJmdHFZM3hvQnpSaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1756574501),
('LP3tRSNXbH4BXemSEfqopOWwLp9BUmQa0WRJf4Ii', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV1pmUEx3UnNDbjhJN256c3dKbDVZMk9nNFZuT1NsWmxsYm1Kd2pJbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcmRlcnMvY3JlYXRlP3Byb2R1Y3RfaWQ9MSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyO30=', 1756574375);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `commercial_license` varchar(255) NOT NULL,
  `tax_number` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'مكة المكرمة',
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `user_id`, `company_name`, `commercial_license`, `tax_number`, `contact_person`, `phone`, `email`, `address`, `city`, `logo`, `description`, `status`, `rating`, `total_orders`, `created_at`, `updated_at`) VALUES
(1, 2, 'مؤسسة مياه العزيزية للتموين', 'CR123456789', '300123456789', 'عبدالله محمد الزهراني', '0501234568', 'supplier1@makkah-water.com', 'شارع الملك عبدالله، حي العزيزية، مكة المكرمة', 'مكة المكرمة', NULL, 'أكبر مورد للمياه العذبة في حي العزيزية، نخدم أهالي مكة منذ أكثر من 15 عام', 'active', 4.80, 250, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(2, 3, 'شركة مياه الشوقية المحدودة', 'CR987654321', '300987654321', 'فاطمة أحمد الغامدي', '0501234569', 'supplier2@makkah-water.com', 'شارع العزيزية، حي الشوقية، مكة المكرمة', 'مكة المكرمة', NULL, 'مؤسسة رائدة في مجال توزيع المياه المعدنية والطبيعية في حي الشوقية', 'active', 4.60, 180, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(3, 4, 'مؤسسة مياه المسفلة التجارية', 'CR456789123', '300456789123', 'علي حسن المطيري', '0501234570', 'supplier3@makkah-water.com', 'شارع المنصور، حي المسفلة، مكة المكرمة', 'مكة المكرمة', NULL, 'شركة متخصصة في المياه المعدنية والقلوية، نخدم حي المسفلة منذ 10 سنوات', 'active', 4.70, 120, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(4, 5, 'شركة مياه العتيبية للاستثمار', 'CR789123456', '300789123456', 'محمد سعد القحطاني', '0501234571', 'supplier4@makkah-water.com', 'شارع العتيبية، حي العتيبية، مكة المكرمة', 'مكة المكرمة', NULL, 'مؤسسة حديثة متخصصة في المياه المقطرة والمعدنية، نخدم حي العتيبية', 'active', 4.50, 90, '2025-08-30 11:55:36', '2025-08-30 11:55:36'),
(5, 6, 'مؤسسة مياه المنصور العالمية', 'CR321654987', '300321654987', 'خالد عبدالرحمن الحربي', '0501234572', 'supplier5@makkah-water.com', 'شارع الشوقية، حي الشوقية، مكة المكرمة', 'مكة المكرمة', NULL, 'شركة عالمية متخصصة في المياه الفاخرة والطبيعية، نخدم جميع أحياء مكة', 'active', 4.90, 300, '2025-08-30 11:55:36', '2025-08-30 11:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer','supplier','delivery') NOT NULL DEFAULT 'customer',
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'مكة المكرمة',
  `profile_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `address`, `city`, `profile_image`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'أحمد محمد العتيبي', 'admin@makkah-water.com', '0501234567', NULL, '$2y$12$WpWUiw17lGu1/zhIRaoqvuQy1T6hZ7asHuNBtbhWTI9DzoEQUYT0O', 'admin', 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', 'profile-images/admin-ahmed.jpg', 1, NULL, '2025-08-30 11:55:23', '2025-08-30 11:55:23'),
(2, 'عبدالله محمد الزهراني', 'supplier1@makkah-water.com', '0501234568', NULL, '$2y$12$wdEINDUrgpSee2j00UftgeuDSFIrC/Nm/SQNM80ggO/jDO9T9yRKG', 'supplier', 'شارع الملك عبدالله، حي العزيزية، مكة المكرمة', 'مكة المكرمة', 'profile-images/supplier-abdullah.jpg', 1, NULL, '2025-08-30 11:55:23', '2025-08-30 11:55:23'),
(3, 'فاطمة أحمد الغامدي', 'supplier2@makkah-water.com', '0501234569', NULL, '$2y$12$P21j4ptvXUsKIr6yzHbOce.m6IwYwRT.B6JdoPaEH7TX9UdDEzDlW', 'supplier', 'شارع العزيزية، حي الشوقية، مكة المكرمة', 'مكة المكرمة', 'profile-images/supplier-fatima.jpg', 1, NULL, '2025-08-30 11:55:24', '2025-08-30 11:55:24'),
(4, 'علي حسن المطيري', 'supplier3@makkah-water.com', '0501234570', NULL, '$2y$12$6gDVn4taXXjvg5gpYrqyq.LOhYb38e..IdQHuA4zILlwk1IRdWLMq', 'supplier', 'شارع المنصور، حي المسفلة، مكة المكرمة', 'مكة المكرمة', 'profile-images/supplier-ali.jpg', 1, NULL, '2025-08-30 11:55:25', '2025-08-30 11:55:25'),
(5, 'محمد سعد القحطاني', 'supplier4@makkah-water.com', '0501234571', NULL, '$2y$12$awOdvYXma.ps.2Tgvxqd4.hLD5XOqANVYG/E7WI8bP7IbVhtY9e9K', 'supplier', 'شارع العتيبية، حي العتيبية، مكة المكرمة', 'مكة المكرمة', 'profile-images/supplier-mohammed.jpg', 1, NULL, '2025-08-30 11:55:25', '2025-08-30 11:55:25'),
(6, 'خالد عبدالرحمن الحربي', 'supplier5@makkah-water.com', '0501234572', NULL, '$2y$12$9Qo7KwHQbXWZr6.FSmoaoumAid8RBoOm5cN3cRl/jF6T7lywYBaqy', 'supplier', 'شارع الشوقية، حي الشوقية، مكة المكرمة', 'مكة المكرمة', 'profile-images/supplier-khalid.jpg', 1, NULL, '2025-08-30 11:55:26', '2025-08-30 11:55:26'),
(7, 'يوسف محمد العتيبي', 'delivery1@makkah-water.com', '0501234573', NULL, '$2y$12$9Boi5dwnp6DQ3bLexPQUW.86kiuwIf3/V0LnVZx2v0AcYTDE/qsrq', 'delivery', 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', 'profile-images/delivery-yousef.jpg', 1, NULL, '2025-08-30 11:55:27', '2025-08-30 11:55:27'),
(8, 'عبدالرحمن أحمد الزهراني', 'delivery2@makkah-water.com', '0501234574', NULL, '$2y$12$El0hYDXdeSgtmgJ1RYuP3.A/gYQSm0eBfn2EwSiCdtUHiSlnjmqPi', 'delivery', 'حي الشوقية، مكة المكرمة', 'مكة المكرمة', 'profile-images/delivery-abdulrahman.jpg', 1, NULL, '2025-08-30 11:55:28', '2025-08-30 11:55:28'),
(9, 'سعد علي المطيري', 'delivery3@makkah-water.com', '0501234575', NULL, '$2y$12$.fh2FfWpc63n8Tnws0frCuG3Bxm2duutVEzSxEqoOjSAm5puL2yfe', 'delivery', 'حي المسفلة، مكة المكرمة', 'مكة المكرمة', 'profile-images/delivery-saad.jpg', 1, NULL, '2025-08-30 11:55:30', '2025-08-30 11:55:30'),
(10, 'فهد محمد القحطاني', 'delivery4@makkah-water.com', '0501234576', NULL, '$2y$12$5ocPBpCig4NieB0DcrO17.16NmztSRsnmvlDVSaJ6yZxgkNh45hBW', 'delivery', 'حي العتيبية، مكة المكرمة', 'مكة المكرمة', 'profile-images/delivery-fahad.jpg', 1, NULL, '2025-08-30 11:55:31', '2025-08-30 11:55:31'),
(11, 'سلطان عبدالله الحربي', 'delivery5@makkah-water.com', '0501234577', NULL, '$2y$12$IN7eRhgut3N9.7OGhnVgAOzj5qRw15RkJOtL9eSMrblytOlfM7hV6', 'delivery', 'حي المنصور، مكة المكرمة', 'مكة المكرمة', 'profile-images/delivery-sultan.jpg', 1, NULL, '2025-08-30 11:55:32', '2025-08-30 11:55:32'),
(12, 'أحمد علي العتيبي', 'customer1@makkah-water.com', '0501234578', NULL, '$2y$12$dDUzFpr7I9IbWQXvLI0FTuvFTrMUx9zcR566Fuz7uIsVAnexp3yue', 'customer', 'حي العزيزية، مكة المكرمة', 'مكة المكرمة', 'profile-images/customer-ahmed.jpg', 1, NULL, '2025-08-30 11:55:33', '2025-08-30 11:55:33'),
(13, 'فاطمة محمد الزهراني', 'customer2@makkah-water.com', '0501234579', NULL, '$2y$12$vpud7CWKDpr6JOrFxKYjg.RenyU9BnDkBGAzad22OftTPQaV1K92G', 'customer', 'حي الشوقية، مكة المكرمة', 'مكة المكرمة', 'profile-images/customer-fatima.jpg', 1, NULL, '2025-08-30 11:55:34', '2025-08-30 11:55:34'),
(14, 'علي أحمد المطيري', 'customer3@makkah-water.com', '0501234580', NULL, '$2y$12$JtDY.4mUzTJKuRSKL.dxWul5h/q2iFhvo9QoY9Q2OIo/yA8Amb6MC', 'customer', 'حي المسفلة، مكة المكرمة', 'مكة المكرمة', 'profile-images/customer-ali.jpg', 1, NULL, '2025-08-30 11:55:34', '2025-08-30 11:55:34'),
(15, 'خديجة سعد القحطاني', 'customer4@makkah-water.com', '0501234581', NULL, '$2y$12$JKPT/J1TLojA3gNo8EtWquX09eRwJVOgs1JU3OjyiFF553fiWDcYO', 'customer', 'حي العتيبية، مكة المكرمة', 'مكة المكرمة', 'profile-images/customer-khadija.jpg', 1, NULL, '2025-08-30 11:55:35', '2025-08-30 11:55:35'),
(16, 'محمد خالد الحربي', 'customer5@makkah-water.com', '0501234582', NULL, '$2y$12$aaES1ANSAc5mv6i.1kHM2u9jnk.MMJKL5t0a6Gqr8J6VuBanyZKwS', 'customer', 'حي المنصور، مكة المكرمة', 'مكة المكرمة', 'profile-images/customer-mohammed.jpg', 1, NULL, '2025-08-30 11:55:36', '2025-08-30 11:55:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_user_id_foreign` (`user_id`);

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
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_men_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_supplier_id_foreign` (`supplier_id`),
  ADD KEY `orders_delivery_man_id_foreign` (`delivery_man_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profits_order_id_foreign` (`order_id`);

--
-- Indexes for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profit_distributions_profit_id_foreign` (`profit_id`),
  ADD KEY `profit_distributions_user_id_foreign` (`user_id`),
  ADD KEY `profit_distributions_bank_account_id_foreign` (`bank_account_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_supplier_id_foreign` (`supplier_id`),
  ADD KEY `reviews_delivery_man_id_foreign` (`delivery_man_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD CONSTRAINT `delivery_men_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_delivery_man_id_foreign` FOREIGN KEY (`delivery_man_id`) REFERENCES `delivery_men` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profits`
--
ALTER TABLE `profits`
  ADD CONSTRAINT `profits_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profit_distributions`
--
ALTER TABLE `profit_distributions`
  ADD CONSTRAINT `profit_distributions_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profit_distributions_profit_id_foreign` FOREIGN KEY (`profit_id`) REFERENCES `profits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `profit_distributions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_delivery_man_id_foreign` FOREIGN KEY (`delivery_man_id`) REFERENCES `delivery_men` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
