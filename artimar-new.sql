-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2025 at 02:17 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artimar-new`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 = InActive, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `image`, `address`, `remember_token`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '1234567890', '2025-11-26 18:31:02', '$2y$12$aCxYUGK5Rn7AauAeFnnOPeKyjbzuixba653AuS4BHsw.2/tZkkoKa', 'admin_images/XdQyY2iorNtRc4b5c8JszGWWvLfeje6oakiRtpGv.png', '123 Admin Street', NULL, 1, '2025-11-26 18:31:02', '2025-11-26 18:36:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backsplash_prices`
--

DROP TABLE IF EXISTS `backsplash_prices`;
CREATE TABLE IF NOT EXISTS `backsplash_prices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `price_lm_guest` decimal(12,2) NOT NULL DEFAULT '0.00',
  `finished_side_price_lm_guest` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_lm_business` decimal(12,2) NOT NULL DEFAULT '0.00',
  `finished_side_price_lm_business` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_height_mm` int DEFAULT NULL,
  `max_height_mm` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backsplash_prices_material_type_id_foreign` (`material_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backsplash_shapes`
--

DROP TABLE IF EXISTS `backsplash_shapes`;
CREATE TABLE IF NOT EXISTS `backsplash_shapes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimension_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sort_order` int NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `backsplash_shapes`
--

INSERT INTO `backsplash_shapes` (`id`, `name`, `image`, `dimension_fields`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Accordion Image', '1764330074_69298a5aaba6f.png', '[\"25,25\"]', 1, 1, '2025-11-28 06:11:14', '2025-11-28 06:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `backsplash_shape_sides`
--

DROP TABLE IF EXISTS `backsplash_shape_sides`;
CREATE TABLE IF NOT EXISTS `backsplash_shape_sides` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `backsplash_shape_id` bigint UNSIGNED NOT NULL,
  `side_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_finishable` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` tinyint NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backsplash_shape_sides_backsplash_shape_id_foreign` (`backsplash_shape_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 = InActive, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE IF NOT EXISTS `colors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_group_id` bigint UNSIGNED DEFAULT NULL,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colors_material_type_id_foreign` (`material_type_id`),
  KEY `colors_material_group_id_foreign` (`material_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `material_group_id`, `material_type_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Black Pearl', 8, 5, 1, '2025-12-04 14:33:55', '2025-12-04 14:33:55'),
(6, 'Carrara White', 9, 6, 1, '2025-12-04 14:34:12', '2025-12-04 14:34:12'),
(7, 'Red', 10, 7, 1, '2025-12-04 14:34:37', '2025-12-04 14:34:37'),
(8, 'White', 8, 8, 1, '2025-12-05 17:57:49', '2025-12-05 17:57:49'),
(9, 'Black', 8, 9, 1, '2025-12-05 17:58:03', '2025-12-05 17:58:03'),
(10, 'Blue', 9, 10, 1, '2025-12-05 17:58:22', '2025-12-05 17:58:22'),
(11, 'Green', 9, 11, 1, '2025-12-05 17:59:20', '2025-12-05 17:59:20'),
(12, 'Purple', 9, 13, 1, '2025-12-05 17:59:39', '2025-12-05 17:59:39'),
(13, 'Yellow', 9, 12, 1, '2025-12-05 17:59:58', '2025-12-05 17:59:58'),
(14, 'Orange', 9, 14, 1, '2025-12-05 18:00:22', '2025-12-05 18:00:22'),
(15, 'Black & White', 10, 15, 1, '2025-12-05 18:01:02', '2025-12-05 18:01:02'),
(16, 'Redis Blue', 10, 16, 1, '2025-12-05 18:01:23', '2025-12-05 18:01:23'),
(17, 'Brown', 10, 17, 1, '2025-12-05 18:01:51', '2025-12-05 18:01:51'),
(18, 'Black & Brown', 10, 7, 1, '2025-12-05 18:02:32', '2025-12-05 18:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `cutout_material_thickness_prices`
--

DROP TABLE IF EXISTS `cutout_material_thickness_prices`;
CREATE TABLE IF NOT EXISTS `cutout_material_thickness_prices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cut_out_id` bigint UNSIGNED NOT NULL,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `thickness_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_guest` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price_business` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cutout_material_thickness_prices_cut_out_id_foreign` (`cut_out_id`),
  KEY `cutout_material_thickness_prices_material_type_id_foreign` (`material_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cut_outs`
--

DROP TABLE IF EXISTS `cut_outs`;
CREATE TABLE IF NOT EXISTS `cut_outs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cut_outs_category_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cut_outs_cut_outs_category_id_foreign` (`cut_outs_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cut_outs`
--

INSERT INTO `cut_outs` (`id`, `name`, `price`, `user_price`, `cut_outs_category_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Accordion Imagev', 19.99, 5.00, 1, NULL, 1, '2025-12-02 07:40:12', '2025-12-02 07:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `cut_outs_categories`
--

DROP TABLE IF EXISTS `cut_outs_categories`;
CREATE TABLE IF NOT EXISTS `cut_outs_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cut_outs_categories`
--

INSERT INTO `cut_outs_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Accordion Image', 1, '2025-12-02 07:39:43', '2025-12-02 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `cut_outs_images`
--

DROP TABLE IF EXISTS `cut_outs_images`;
CREATE TABLE IF NOT EXISTS `cut_outs_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cut_out_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cut_outs_images_cut_out_id_foreign` (`cut_out_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cut_outs_images`
--

INSERT INTO `cut_outs_images` (`id`, `cut_out_id`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '1764681012_692ee53499042.jpg', 1, '2025-12-02 07:40:12', '2025-12-02 07:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `edge_profiles`
--

DROP TABLE IF EXISTS `edge_profiles`;
CREATE TABLE IF NOT EXISTS `edge_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `edge_profiles`
--

INSERT INTO `edge_profiles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Accordion Image', 1, '2025-11-27 09:07:21', '2025-11-27 09:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `edge_profile_thickness_rules`
--

DROP TABLE IF EXISTS `edge_profile_thickness_rules`;
CREATE TABLE IF NOT EXISTS `edge_profile_thickness_rules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `edge_profile_id` bigint UNSIGNED NOT NULL,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `thickness_id` bigint UNSIGNED NOT NULL,
  `is_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `price_per_lm_guest` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_per_lm_business` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `edge_profile_thickness_rules_edge_profile_id_foreign` (`edge_profile_id`),
  KEY `edge_profile_thickness_rules_material_type_id_foreign` (`material_type_id`),
  KEY `edge_profile_thickness_rules_thickness_id_foreign` (`thickness_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finishes`
--

DROP TABLE IF EXISTS `finishes`;
CREATE TABLE IF NOT EXISTS `finishes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `finish_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_group_id` bigint UNSIGNED NOT NULL,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finishes_material_group_id_foreign` (`material_group_id`),
  KEY `finishes_material_type_id_foreign` (`material_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `finishes`
--

INSERT INTO `finishes` (`id`, `finish_name`, `material_group_id`, `material_type_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Honed', 8, 5, 1, '2025-12-04 17:43:02', '2025-12-04 17:43:02'),
(2, 'Satin', 9, 6, 1, '2025-12-04 17:43:18', '2025-12-04 17:43:18'),
(3, 'Polished', 10, 7, 1, '2025-12-04 17:43:38', '2025-12-04 17:43:38'),
(4, 'Letano', 8, 5, 1, '2025-12-05 18:03:34', '2025-12-05 18:03:34'),
(5, 'Anticato', 8, 8, 1, '2025-12-05 18:04:03', '2025-12-05 18:04:11'),
(6, 'Polished', 8, 5, 1, '2025-12-05 18:04:33', '2025-12-05 18:04:33'),
(7, 'Polished', 8, 8, 1, '2025-12-05 18:04:55', '2025-12-05 18:04:55'),
(8, 'Honed', 8, 9, 1, '2025-12-05 18:05:22', '2025-12-05 18:05:29'),
(9, 'Satin', 9, 10, 1, '2025-12-05 18:05:49', '2025-12-05 18:05:49'),
(10, 'Lux', 9, 11, 1, '2025-12-05 18:06:05', '2025-12-05 18:06:05'),
(11, 'Fiammato', 9, 6, 1, '2025-12-05 18:06:21', '2025-12-05 18:06:21'),
(12, 'Silk', 9, 13, 1, '2025-12-05 18:07:12', '2025-12-05 18:07:12'),
(13, 'Riverwashed', 9, 12, 1, '2025-12-05 18:07:27', '2025-12-05 18:07:27'),
(14, 'Satin', 9, 14, 1, '2025-12-05 18:07:45', '2025-12-05 18:07:45'),
(15, 'Polished', 10, 15, 1, '2025-12-05 18:08:03', '2025-12-05 18:08:03'),
(16, 'Polished', 10, 16, 1, '2025-12-05 18:08:14', '2025-12-05 18:08:14'),
(17, 'Polished', 10, 17, 1, '2025-12-05 18:08:22', '2025-12-05 18:08:22'),
(18, 'Polished', 10, 7, 1, '2025-12-05 18:08:32', '2025-12-05 18:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_color_edge_exceptions`
--

DROP TABLE IF EXISTS `material_color_edge_exceptions`;
CREATE TABLE IF NOT EXISTS `material_color_edge_exceptions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED NOT NULL,
  `edge_profile_id` bigint UNSIGNED NOT NULL,
  `thickness_id` bigint UNSIGNED NOT NULL,
  `is_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `override_price_per_lm` decimal(12,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_color_edge_exceptions_material_type_id_foreign` (`material_type_id`),
  KEY `material_color_edge_exceptions_color_id_foreign` (`color_id`),
  KEY `material_color_edge_exceptions_edge_profile_id_foreign` (`edge_profile_id`),
  KEY `material_color_edge_exceptions_thickness_id_foreign` (`thickness_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_groups`
--

DROP TABLE IF EXISTS `material_groups`;
CREATE TABLE IF NOT EXISTS `material_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `material_groups_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_groups`
--

INSERT INTO `material_groups` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(8, 'Natural stone', 1, '2025-12-04 14:31:15', '2025-12-04 14:31:15'),
(9, 'Ceramics', 1, '2025-12-04 14:31:27', '2025-12-04 14:31:27'),
(10, 'Quartz', 1, '2025-12-04 14:31:38', '2025-12-04 14:31:38');

-- --------------------------------------------------------

--
-- Table structure for table `material_layout_categories`
--

DROP TABLE IF EXISTS `material_layout_categories`;
CREATE TABLE IF NOT EXISTS `material_layout_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_layout_categories`
--

INSERT INTO `material_layout_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Category-B', 1, '2025-11-27 06:13:35', '2025-12-04 21:10:20'),
(3, 'Category-A', 1, '2025-12-04 21:10:07', '2025-12-04 21:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `material_layout_groups`
--

DROP TABLE IF EXISTS `material_layout_groups`;
CREATE TABLE IF NOT EXISTS `material_layout_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_category_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_layout_groups_layout_category_id_foreign` (`layout_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_layout_groups`
--

INSERT INTO `material_layout_groups` (`id`, `name`, `layout_category_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Unique Traders', 2, 1, '2025-11-27 06:48:58', '2025-11-27 06:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `material_layout_shapes`
--

DROP TABLE IF EXISTS `material_layout_shapes`;
CREATE TABLE IF NOT EXISTS `material_layout_shapes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_group_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimension_sides` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_layout_shapes_layout_group_id_foreign` (`layout_group_id`)
) ;

--
-- Dumping data for table `material_layout_shapes`
--

INSERT INTO `material_layout_shapes` (`id`, `name`, `layout_group_id`, `image`, `dimension_sides`, `status`, `created_at`, `updated_at`) VALUES
(1, 'hello india', 2, '1764245954_692841c2cbffb.png', '[{\"name\":\"Side A\",\"min\":\"15\",\"max\":\"25\"}]', 0, '2025-11-27 06:49:14', '2025-11-28 01:58:03'),
(2, 'Accordion Image', 2, '1764314335_69294cdfd4291.png', '[{\"name\":\"Side A\",\"min\":\"10\",\"max\":\"15\"}]', 1, '2025-11-28 01:48:55', '2025-11-28 01:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

DROP TABLE IF EXISTS `material_types`;
CREATE TABLE IF NOT EXISTS `material_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material_group_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_types_material_group_id_foreign` (`material_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `name`, `image`, `material_group_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Granite', '1764837145_69314719a2c53.jpg', 8, 1, '2025-12-04 14:32:25', '2025-12-04 14:32:25'),
(6, 'Laminam', '1764837171_6931473372a2d.jpg', 9, 1, '2025-12-04 14:32:51', '2025-12-04 14:32:51'),
(7, 'Unistone', '1764837192_6931474838e64.jpg', 10, 1, '2025-12-04 14:33:12', '2025-12-04 14:33:12'),
(8, 'Marble', '1764935471_6932c72f996f6.jpg', 8, 1, '2025-12-05 17:51:11', '2025-12-05 17:51:11'),
(9, 'Quartzite', '1764935497_6932c7490b5cf.jpg', 8, 1, '2025-12-05 17:51:37', '2025-12-05 17:51:37'),
(10, 'Arton', '1764935542_6932c776591ca.jpg', 9, 1, '2025-12-05 17:52:22', '2025-12-05 17:52:22'),
(11, 'Dekton', '1764935564_6932c78c28e9c.jpg', 9, 1, '2025-12-05 17:52:44', '2025-12-05 17:52:44'),
(12, 'Neolith', '1764935583_6932c79f5a271.jpg', 9, 1, '2025-12-05 17:53:03', '2025-12-05 17:53:03'),
(13, 'Marazzi', '1764935605_6932c7b5cab7b.jpg', 9, 1, '2025-12-05 17:53:25', '2025-12-05 17:53:25'),
(14, 'Uniceramica', '1764935630_6932c7ce87948.jpg', 9, 1, '2025-12-05 17:53:50', '2025-12-05 17:53:50'),
(15, 'Articom', '1764935652_6932c7e44d0b5.jpg', 10, 1, '2025-12-05 17:54:12', '2025-12-05 17:54:12'),
(16, 'Caesarstone', '1764935674_6932c7faacca4.jpg', 10, 1, '2025-12-05 17:54:34', '2025-12-05 17:54:34'),
(17, 'Silestone', '1764935725_6932c82d424a3.jpg', 10, 1, '2025-12-05 17:55:25', '2025-12-05 17:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_15_101248_create_admins_table', 1),
(5, '2025_09_17_110022_add_more_fields_to_users_table', 1),
(6, '2025_09_24_084158_create_banners_table', 1),
(7, '2025_09_24_111206_create_settings_table', 1),
(8, '2025_11_26_124201_create_material_groups_table', 2),
(9, '2025_11_26_132759_create_material_types_table', 3),
(10, '2025_11_26_141308_create_colors_table', 4),
(13, '2025_11_27_081903_add_material_group_id_to_colors_table', 7),
(17, '2025_11_06_133124_create_material_layout_categories_table', 10),
(18, '2025_11_27_111651_create_material_layout_groups_table', 11),
(19, '2025_11_27_114932_create_material_layout_shapes_table', 12),
(20, '2025_11_27_131523_create_edge_profiles_table', 13),
(23, '2025_11_28_070849_add_dimension_sides_to_material_layout_shapes_table', 16),
(24, '2025_11_27_134131_create_edge_profile_thickness_rules_table', 17),
(25, '2025_11_27_150124_create_material_color_edge_exceptions_table', 18),
(26, '2025_11_28_103208_create_backsplash_shapes_table', 19),
(27, '2025_11_28_114611_create_backsplash_shape_sides_table', 20),
(28, '2025_11_28_123414_create_backsplash_prices_table', 21),
(29, '2025_11_29_082759_create_sink_cutout_types_table', 22),
(30, '2025_11_06_144623_create_sink_categories_table', 23),
(31, '2025_09_29_151312_create_sinks_table', 24),
(32, '2025_09_29_152109_create_sink_images_table', 25),
(33, '2025_11_07_083117_create_cut_outs_categories_table', 26),
(34, '2025_10_01_083155_create_cut_outs_table', 27),
(35, '2025_10_01_083207_create_cut_outs_images_table', 27),
(36, '2025_10_16_090437_create_promo_codes_table', 28),
(38, '2025_12_02_113002_create_cutout_material_thickness_prices_table', 29),
(39, '2025_12_03_073216_add_image_to_material_types_table', 30),
(40, '2025_12_03_102437_add_material_group_and_type_to_finishes_table', 31),
(41, '2025_12_03_105526_add_material_columns_to_thicknesses_table', 32),
(42, '2025_11_26_150623_create_finishes_table', 33),
(43, '2025_11_27_072057_create_thicknesses_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

DROP TABLE IF EXISTS `promo_codes`;
CREATE TABLE IF NOT EXISTS `promo_codes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` enum('percent','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promo_codes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VPWto2tOiHSNkCpdaM5qibnsYrVPc26RrpJYQTLW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YToxNTp7czo2OiJfdG9rZW4iO3M6NDA6ImZrd0czVWlBSzBWa01NV1ZGdmQyd0d1YmpmbEhaVW1RVm5zbEJrNkciO3M6NjoibG9jYWxlIjtzOjI6ImVuIjtzOjIwOiJzZWxlY3RlZF9tYXRlcmlhbF9pZCI7TjtzOjE4OiJzZWxlY3RlZF9sYXlvdXRfaWQiO047czoxMDoiZGltZW5zaW9ucyI7TjtzOjE0OiJlZGdlX2ZpbmlzaGluZyI7TjtzOjk6ImJhY2tfd2FsbCI7TjtzOjE0OiJzaW5rX3NlbGVjdGlvbiI7TjtzOjE2OiJjdXRvdXRfc2VsZWN0aW9uIjtOO3M6MTI6InVzZXJfZGV0YWlscyI7TjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMjoiZmxvd19zdGFydGVkIjtiOjE7czoyNToic2VsZWN0ZWRfbWF0ZXJpYWxfdHlwZV9pZCI7czoxOiI1Ijt9', 1764943971);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sinks`
--

DROP TABLE IF EXISTS `sinks`;
CREATE TABLE IF NOT EXISTS `sinks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sink_categorie_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `user_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `internal_dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depth` int DEFAULT NULL,
  `radius` int DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sinks_sink_categorie_id_foreign` (`sink_categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sink_categories`
--

DROP TABLE IF EXISTS `sink_categories`;
CREATE TABLE IF NOT EXISTS `sink_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sink_categories`
--

INSERT INTO `sink_categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Checking', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sink_cutout_types`
--

DROP TABLE IF EXISTS `sink_cutout_types`;
CREATE TABLE IF NOT EXISTS `sink_cutout_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sink_images`
--

DROP TABLE IF EXISTS `sink_images`;
CREATE TABLE IF NOT EXISTS `sink_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sink_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sink_images_sink_id_foreign` (`sink_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thicknesses`
--

DROP TABLE IF EXISTS `thicknesses`;
CREATE TABLE IF NOT EXISTS `thicknesses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_group_id` bigint UNSIGNED NOT NULL,
  `material_type_id` bigint UNSIGNED NOT NULL,
  `thickness_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_massive` tinyint(1) NOT NULL DEFAULT '0',
  `can_be_laminated` tinyint(1) NOT NULL DEFAULT '0',
  `laminate_min` int DEFAULT NULL,
  `laminate_max` int DEFAULT NULL,
  `bussiness_price_m2` decimal(12,2) NOT NULL DEFAULT '0.00',
  `guest_price_m2` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thicknesses_material_group_id_foreign` (`material_group_id`),
  KEY `thicknesses_material_type_id_foreign` (`material_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thicknesses`
--

INSERT INTO `thicknesses` (`id`, `material_group_id`, `material_type_id`, `thickness_value`, `is_massive`, `can_be_laminated`, `laminate_min`, `laminate_max`, `bussiness_price_m2`, `guest_price_m2`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 5, '12mm', 0, 0, NULL, NULL, 22.84, 25.84, 1, '2025-12-04 17:46:11', '2025-12-05 18:11:13'),
(2, 9, 6, '15mm', 0, 0, NULL, NULL, 40.07, 45.07, 1, '2025-12-04 17:46:29', '2025-12-05 18:13:27'),
(3, 10, 7, '12mm', 0, 0, NULL, NULL, 86.05, 90.05, 1, '2025-12-04 17:46:47', '2025-12-05 18:13:01'),
(4, 8, 9, '20mm', 0, 0, NULL, NULL, 81.53, 85.53, 1, '2025-12-05 18:12:07', '2025-12-05 18:12:07'),
(5, 8, 8, '6mm', 0, 0, NULL, NULL, 125.05, 130.05, 1, '2025-12-05 18:12:41', '2025-12-05 18:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 = InActive, 1 = Active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `business_name`, `vat_number`, `email`, `mobile`, `photo`, `address`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', NULL, NULL, 'test@example.com', NULL, NULL, NULL, 1, '2025-11-26 18:31:01', '$2y$12$rUHKwn4jTVd5ZMpFuDOkCeyG.JMECz5/EU6o/psePaQzPIep.BDUO', 'qhPdVs4exg', '2025-11-26 18:31:02', '2025-11-26 18:31:02');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backsplash_prices`
--
ALTER TABLE `backsplash_prices`
  ADD CONSTRAINT `backsplash_prices_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `backsplash_shape_sides`
--
ALTER TABLE `backsplash_shape_sides`
  ADD CONSTRAINT `backsplash_shape_sides_backsplash_shape_id_foreign` FOREIGN KEY (`backsplash_shape_id`) REFERENCES `backsplash_shapes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_material_group_id_foreign` FOREIGN KEY (`material_group_id`) REFERENCES `material_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `colors_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cutout_material_thickness_prices`
--
ALTER TABLE `cutout_material_thickness_prices`
  ADD CONSTRAINT `cutout_material_thickness_prices_cut_out_id_foreign` FOREIGN KEY (`cut_out_id`) REFERENCES `cut_outs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cutout_material_thickness_prices_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cut_outs`
--
ALTER TABLE `cut_outs`
  ADD CONSTRAINT `cut_outs_cut_outs_category_id_foreign` FOREIGN KEY (`cut_outs_category_id`) REFERENCES `cut_outs_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cut_outs_images`
--
ALTER TABLE `cut_outs_images`
  ADD CONSTRAINT `cut_outs_images_cut_out_id_foreign` FOREIGN KEY (`cut_out_id`) REFERENCES `cut_outs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `edge_profile_thickness_rules`
--
ALTER TABLE `edge_profile_thickness_rules`
  ADD CONSTRAINT `edge_profile_thickness_rules_edge_profile_id_foreign` FOREIGN KEY (`edge_profile_id`) REFERENCES `edge_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `edge_profile_thickness_rules_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `edge_profile_thickness_rules_thickness_id_foreign` FOREIGN KEY (`thickness_id`) REFERENCES `thicknesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_color_edge_exceptions`
--
ALTER TABLE `material_color_edge_exceptions`
  ADD CONSTRAINT `material_color_edge_exceptions_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_color_edge_exceptions_edge_profile_id_foreign` FOREIGN KEY (`edge_profile_id`) REFERENCES `edge_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_color_edge_exceptions_material_type_id_foreign` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `material_color_edge_exceptions_thickness_id_foreign` FOREIGN KEY (`thickness_id`) REFERENCES `thicknesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_layout_groups`
--
ALTER TABLE `material_layout_groups`
  ADD CONSTRAINT `material_layout_groups_layout_category_id_foreign` FOREIGN KEY (`layout_category_id`) REFERENCES `material_layout_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_layout_shapes`
--
ALTER TABLE `material_layout_shapes`
  ADD CONSTRAINT `material_layout_shapes_layout_group_id_foreign` FOREIGN KEY (`layout_group_id`) REFERENCES `material_layout_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_types`
--
ALTER TABLE `material_types`
  ADD CONSTRAINT `material_types_material_group_id_foreign` FOREIGN KEY (`material_group_id`) REFERENCES `material_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sinks`
--
ALTER TABLE `sinks`
  ADD CONSTRAINT `sinks_sink_categorie_id_foreign` FOREIGN KEY (`sink_categorie_id`) REFERENCES `sink_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sink_images`
--
ALTER TABLE `sink_images`
  ADD CONSTRAINT `sink_images_sink_id_foreign` FOREIGN KEY (`sink_id`) REFERENCES `sinks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
