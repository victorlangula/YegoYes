-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2017 at 11:19 AM
-- Server version: 5.5.57-cll
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yegoyes_build`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(10) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `app_type_id` int(10) UNSIGNED NOT NULL,
  `theme` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `layout` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `header_text` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `local_domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `timezone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UTC',
  `robots` text COLLATE utf8_unicode_ci,
  `color1` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color2` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color3` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color4` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color5` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color6` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color7` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_overlay` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_header_background` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_header_text` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_file_size` int(11) DEFAULT NULL,
  `header_content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_updated_at` timestamp NULL DEFAULT NULL,
  `background_smarthpones_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_smarthpones_file_size` int(11) DEFAULT NULL,
  `background_smarthpones_content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_smarthpones_updated_at` timestamp NULL DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`id`, `status`, `user_id`, `campaign_id`, `app_type_id`, `theme`, `layout`, `icon`, `name`, `header_text`, `local_domain`, `domain`, `language`, `timezone`, `robots`, `color1`, `color2`, `color3`, `color4`, `color5`, `color6`, `color7`, `color_overlay`, `color_header_background`, `color_header_text`, `header_file_name`, `header_file_size`, `header_content_type`, `header_updated_at`, `background_smarthpones_file_name`, `background_smarthpones_file_size`, `background_smarthpones_content_type`, `background_smarthpones_updated_at`, `expires`, `active`, `settings`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 1, 1, 'hexagon', 'tabs-top', NULL, 'LangulaShop', NULL, '40CK-08C5-59M6-L42L', '', 'en', 'Africa/Dar_es_Salaam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1x1.gif', 43, 'image/gif', '2016-12-15 15:25:13', NULL, 1, '{\"social\":{\"email\":\"1\",\"twitter\":\"1\",\"facebook\":\"1\",\"googleplus\":\"1\",\"linkedin\":\"1\",\"pinterest\":\"1\"},\"social_size\":\"12\",\"social_icons_only\":\"1\",\"social_show_count\":\"0\",\"head_tag\":\"\",\"end_of_body_tag\":\"\",\"css\":\"\",\"js\":\"\"}', '2016-12-15 15:05:18', '2017-01-04 19:43:57', NULL, 1, 1),
(2, 1, 2, 2, 8, 'city-bokeh', 'tabs-bottom', NULL, 'Lost and found', NULL, '4Y2N-9055-5C37-73S3', NULL, 'en', 'GMT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2016-12-31 05:18:30', '2016-12-31 05:23:46', NULL, 2, 2),
(4, 1, 1, 1, 4, 'water-splash', 'tabs-top', NULL, 'Unititled Shop', NULL, '408O-7701-JJEB-Q103', NULL, 'en', 'Africa/Nairobi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1x1.gif', 43, 'image/gif', '2017-01-03 11:16:05', NULL, 1, NULL, '2017-01-03 11:06:01', '2017-01-03 11:16:05', NULL, 1, 1),
(5, 1, 1, 1, 1, 'hexagon', 'tabs-top', NULL, 'MwandusShop', NULL, '0O39-743K-70PY-78XJ', '', 'en', 'Africa/Dar_es_Salaam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1x1.gif', 43, 'image/gif', '2016-12-15 15:25:13', NULL, 1, '{\"social\":{\"email\":\"1\",\"twitter\":\"1\",\"facebook\":\"1\",\"googleplus\":\"1\",\"linkedin\":\"1\",\"pinterest\":\"1\"},\"social_size\":\"12\",\"social_icons_only\":\"1\",\"social_show_count\":\"0\",\"head_tag\":\"\",\"end_of_body_tag\":\"\",\"css\":\"\",\"js\":\"\",\"pg_id\":\"\"}', '2017-01-04 20:07:30', '2017-01-04 20:07:30', NULL, 1, 1),
(6, 1, 3, 1, 1, 'black-office', 'tabs-top', NULL, 'mercyShop', NULL, 'pGrnGDWa2d', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 3, 3),
(7, 1, 4, 1, 1, 'black-office', 'tabs-top', NULL, 'rkoolatvShop', NULL, 'BooW3LvrgV', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 4, 4),
(8, 1, 5, 1, 1, 'black-office', 'tabs-top', NULL, 'vslShop', NULL, 'Yvwi7ejZ8A', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 5, 5),
(9, 1, 6, 1, 1, 'black-office', 'tabs-top', NULL, 'yegouserShop', NULL, 'CZcBykDR8C', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 6, 6),
(10, 1, 1, 1, 8, 'other', 'tabs-bottom', NULL, 'NewVeeShop', NULL, '4K15-Y1F0-MR9M-0397', NULL, 'en', 'Africa/Nairobi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2017-06-11 17:58:50', '2017-06-11 17:58:50', NULL, 1, 1),
(11, 1, 7, 1, 1, 'black-office', 'tabs-top', NULL, 'haidirShop', NULL, 'JmCXcajXfJ', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 7, 7),
(12, 1, 8, 1, 1, 'black-office', 'tabs-top', NULL, 'testShop', NULL, 'JVHZRx90ol', NULL, 'en', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `app_pages`
--

CREATE TABLE `app_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_id` bigint(20) UNSIGNED NOT NULL,
  `widget` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `theme_variation` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `lft` bigint(20) DEFAULT NULL,
  `rgt` bigint(20) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` text COLLATE utf8_unicode_ci,
  `meta_desc` text COLLATE utf8_unicode_ci,
  `meta_robots` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `hidden_parent` tinyint(1) NOT NULL DEFAULT '0',
  `secured` tinyint(1) NOT NULL DEFAULT '0',
  `secured_parent` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci,
  `content_published` mediumtext COLLATE utf8_unicode_ci,
  `settings` text COLLATE utf8_unicode_ci,
  `header_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_file_size` int(11) DEFAULT NULL,
  `header_content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_updated_at` timestamp NULL DEFAULT NULL,
  `background_smarthpones_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_smarthpones_file_size` int(11) DEFAULT NULL,
  `background_smarthpones_content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_smarthpones_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_pages`
--

INSERT INTO `app_pages` (`id`, `app_id`, `widget`, `theme_variation`, `parent_id`, `lft`, `rgt`, `depth`, `name`, `meta_title`, `meta_desc`, `meta_robots`, `slug`, `icon`, `link`, `hidden`, `hidden_parent`, `secured`, `secured_parent`, `content`, `content_published`, `settings`, `header_file_name`, `header_file_size`, `header_content_type`, `header_updated_at`, `background_smarthpones_file_name`, `background_smarthpones_file_size`, `background_smarthpones_content_type`, `background_smarthpones_updated_at`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(2, 1, 'e-commerce', NULL, NULL, 1, 2, 0, 'Products', NULL, NULL, NULL, 'products', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-15 15:06:35', '2016-12-15 15:07:02', NULL, NULL, NULL),
(3, 1, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact Us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-15 15:19:33', '2016-12-15 15:19:33', NULL, NULL, NULL),
(4, 1, 'map', NULL, NULL, 5, 6, 0, 'Map', NULL, NULL, NULL, 'map', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-15 15:22:45', '2016-12-15 15:22:45', NULL, NULL, NULL),
(5, 2, 'about-us', NULL, NULL, 7, 8, 0, 'About Us', NULL, NULL, NULL, 'about-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-31 05:19:14', '2016-12-31 05:19:14', NULL, NULL, NULL),
(6, 2, 'home-screen', NULL, NULL, 9, 10, 0, 'Home', NULL, NULL, NULL, 'home', NULL, NULL, 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-31 05:21:30', '2016-12-31 05:24:20', NULL, NULL, NULL),
(7, 4, 'e-commerce', NULL, NULL, 13, 14, 0, 'Foods', NULL, NULL, NULL, 'foods', 'ion-android-cart', NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-03 11:06:41', '2017-01-03 11:18:42', NULL, NULL, NULL),
(8, 4, 'home-screen', NULL, NULL, 11, 12, 0, 'Home', NULL, NULL, NULL, 'home', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-03 11:17:00', '2017-01-03 11:18:42', NULL, NULL, NULL),
(9, 4, 'contact-us', NULL, NULL, 15, 16, 0, 'Contact Us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-03 11:18:54', '2017-01-03 11:18:54', NULL, NULL, NULL),
(10, 5, 'e-commerce', NULL, NULL, 17, 18, 0, 'Products', NULL, NULL, NULL, 'products', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-04 20:07:30', '2017-01-04 20:07:30', NULL, NULL, NULL),
(11, 5, 'contact-us', NULL, NULL, 19, 20, 0, 'Contact Us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-04 20:07:30', '2017-01-04 20:07:30', NULL, NULL, NULL),
(12, 5, 'map', NULL, NULL, 21, 22, 0, 'Map', NULL, NULL, NULL, 'map', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-04 20:07:30', '2017-01-04 20:07:30', NULL, NULL, NULL),
(13, 6, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-11 08:39:12', '2017-01-11 08:39:12', NULL, 3, 3),
(14, 6, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-11 08:39:12', '2017-01-11 08:39:12', NULL, 3, 3),
(15, 7, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-12 16:21:26', '2017-01-12 16:21:26', NULL, 4, 4),
(16, 7, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-12 16:21:26', '2017-01-12 16:21:26', NULL, 4, 4),
(17, 8, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-15 12:48:00', '2017-01-15 12:48:00', NULL, 5, 5),
(18, 8, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-15 12:48:00', '2017-01-15 12:48:00', NULL, 5, 5),
(19, 2, 'e-commerce', NULL, NULL, 23, 24, 0, 'E-Commerce', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-15 13:15:45', '2017-01-15 13:15:45', NULL, NULL, NULL),
(20, 9, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-04 08:20:50', '2017-05-04 08:20:50', NULL, 6, 6),
(21, 9, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-04 08:20:50', '2017-05-04 08:20:50', NULL, 6, 6),
(22, 11, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 03:09:59', '2017-09-20 03:09:59', NULL, 7, 7),
(23, 11, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 03:09:59', '2017-09-20 03:09:59', NULL, 7, 7),
(24, 12, 'e-commerce', NULL, NULL, 1, 2, 0, 'Shop', NULL, NULL, NULL, 'e-commerce', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-20 06:34:32', '2017-10-20 06:34:32', NULL, 8, 8),
(25, 12, 'contact-us', NULL, NULL, 3, 4, 0, 'Contact us', NULL, NULL, NULL, 'contact-us', NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-20 06:34:32', '2017-10-20 06:34:32', NULL, 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `app_types`
--

CREATE TABLE `app_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `app_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_types`
--

INSERT INTO `app_types` (`id`, `sort`, `name`, `icon`, `app_icon`, `active`) VALUES
(1, 10, 'business', 'fa-shopping-cart', 'store', 1),
(2, 20, 'music', 'fa-headphones', 'mixpanel', 1),
(3, 30, 'events', 'fa-calendar', 'calendar', 1),
(4, 40, 'restaurants', 'fa-cutlery', 'cutlery', 1),
(5, 50, 'blog', 'fa-comments', 'pen', 1),
(6, 60, 'education', 'fa-graduation-cap', 'mortarboard', 1),
(7, 70, 'photography', 'fa-camera-retro', 'diaphragm', 1),
(8, 80, 'other', 'fa-leaf', 'leaf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_user_data`
--

CREATE TABLE `app_user_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sort` bigint(20) DEFAULT NULL,
  `app_id` bigint(20) UNSIGNED NOT NULL,
  `app_page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_widget_data`
--

CREATE TABLE `app_widget_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sort` bigint(20) DEFAULT NULL,
  `app_page_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `app_widget_data`
--

INSERT INTO `app_widget_data` (`id`, `sort`, `app_page_id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, 'currency', 'USD', '2016-12-15 15:07:58', '2017-01-24 10:55:22'),
(2, NULL, 2, 'flat_rate', '1', '2016-12-15 15:07:58', '2017-01-28 12:34:12'),
(3, NULL, 2, 'quantity_rate', '1', '2016-12-15 15:07:58', '2017-01-28 12:34:12'),
(4, NULL, 2, 'total_rate', '0.01', '2016-12-15 15:07:58', '2017-01-28 12:34:29'),
(5, NULL, 2, 'tax_rate', '0.01', '2016-12-15 15:07:58', '2017-01-28 12:34:12'),
(6, NULL, 2, 'tax_shipping', '1', '2016-12-15 15:07:58', '2016-12-15 15:07:58'),
(7, NULL, 2, 'payment_provider', 'PayPal', '2016-12-15 15:07:58', '2016-12-15 15:07:58'),
(8, NULL, 2, 'payment_provider_email', 'victor.langula-facilitator@gmail.com', '2016-12-15 15:07:58', '2017-01-28 11:23:58'),
(9, NULL, 2, 'sandbox', '1', '2016-12-15 15:07:58', '2017-01-24 10:55:22'),
(10, NULL, 2, 'products', '{\"photo\":[\"\\/build\\/uploads\\/user\\/R4\\/iphone.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/samsung-galaxy-s7-hands-on-sean-okane18_2040.0.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/Tecno-Phantom-5-Specifications-Review-and-Price-in-Kenya.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/15802186_1621697158126889_3695853425888591872_n.jpg\"],\"title\":[\"iPhone 7\",\"Galaxy S7\",\"Tecno Phantom 5\",\"Mpya\"],\"desc\":[\"iPhone 7 Plus mpya kabisa na iko kwenye hali nzuri\",\"Samsung Galaxy S7 mpya kabisa. Ipo Dar\",\"Tecno Phontom 5 imetumika lakini iko poa sana.\",\"\"],\"price\":[\"700\",\"799\",\"559\",\"2\"],\"active\":[\"1\",\"1\",\"1\",\"1\"]}', '2016-12-15 15:18:25', '2017-01-28 11:38:15'),
(11, NULL, 3, 'image', '', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(12, NULL, 3, 'box_image', '1', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(13, NULL, 3, 'title', 'Contact us', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(14, NULL, 3, 'content', 'We are here to answer any questions you may have about our services. Reach out to us and we\'ll respond as soon as we can.', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(15, NULL, 3, 'files', '', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(16, NULL, 3, 'phone_number', '', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(17, NULL, 3, 'phone_number_btn', 'Call us directly', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(18, NULL, 3, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-android-home\"],\"title\":[\"Phone\",\"Email\",\"Address\"],\"value\":[\"255 653 183020\",\"info@langula.com\",\"P.O Box 36138 Dar\"]}', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(19, NULL, 3, 'social_share_text', 'Contacts', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(20, NULL, 3, 'social_share', '0', '2016-12-15 15:22:11', '2016-12-15 15:22:11'),
(21, NULL, 4, 'address', 'Kigamboni', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(22, NULL, 4, 'longitude', '39.3154352', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(23, NULL, 4, 'latitude', '-6.828002', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(24, NULL, 4, 'zoom', '9', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(25, NULL, 4, 'open_marker', '1', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(26, NULL, 4, 'marker', '', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(27, NULL, 4, 'files', '', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(28, NULL, 4, 'icon', '', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(29, NULL, 4, 'custom_icon', '', '2016-12-15 15:23:34', '2016-12-15 15:23:34'),
(30, NULL, 5, 'image', '', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(31, NULL, 5, 'box_image', '1', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(32, NULL, 5, 'title', 'Lost and found', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(33, NULL, 5, 'content', '<p>This is a brief description about us. <h4>Why choose us</h4>Lost and foundnoffers a great service to report lost items and get the community to help on searching and report back.</p><p><br></p><p><br></p>', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(34, NULL, 5, 'files', '', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(35, NULL, 5, 'list', '{\"icon\":[\"ion-social-twitter\",\"ion-social-facebook\",\"ion-social-linkedin\"],\"url\":[\"https:\\/\\/twitter.com\\/\",\"https:\\/\\/www.facebook.com\\/\",\"https:\\/\\/www.linkedin.com\"],\"label\":[\"Twitter profile\",\"Facebook page\",\"LinkedIn profile\"]}', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(36, NULL, 5, 'social_share_text', '', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(37, NULL, 5, 'social_share', '0', '2016-12-31 05:21:05', '2016-12-31 05:21:05'),
(38, NULL, 6, 'image', '', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(39, NULL, 6, 'box_image', '1', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(40, NULL, 6, 'columns', '2', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(41, NULL, 6, 'icon_size', 'm', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(42, NULL, 6, 'color', 'calm', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(43, NULL, 6, 'bg_color', 'dark', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(44, NULL, 6, 'shadow', 'light', '2016-12-31 05:22:26', '2016-12-31 05:22:26'),
(45, NULL, 7, 'currency', 'USD', '2017-01-03 11:07:48', '2017-01-03 11:11:43'),
(46, NULL, 7, 'flat_rate', '0', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(47, NULL, 7, 'quantity_rate', '0', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(48, NULL, 7, 'total_rate', '0.00', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(49, NULL, 7, 'tax_rate', '0.00', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(50, NULL, 7, 'tax_shipping', '0', '2017-01-03 11:07:48', '2017-01-03 11:11:43'),
(51, NULL, 7, 'payment_provider', 'PayPal', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(52, NULL, 7, 'payment_provider_email', 'victor.langula@gmail.com', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(53, NULL, 7, 'sandbox', '0', '2017-01-03 11:07:48', '2017-01-03 11:07:48'),
(54, NULL, 7, 'products', '{\"photo\":[\"\\/build\\/uploads\\/user\\/R4\\/iphone.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/Tecno-Phantom-5-Specifications-Review-and-Price-in-Kenya.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/samsung-galaxy-s7-hands-on-sean-okane18_2040.0.jpg\"],\"title\":[\"Simu\",\"Simoma\",\"Kichehe\"],\"desc\":[\"\",\"\",\"\"],\"price\":[\"500\",\"2501\",\"25600\"],\"active\":[\"1\",\"1\",\"1\"]}', '2017-01-03 11:08:16', '2017-01-03 11:10:35'),
(55, NULL, 8, 'image', '', '2017-01-03 11:17:43', '2017-01-03 11:18:21'),
(62, NULL, 9, 'image', '', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(56, NULL, 8, 'box_image', '1', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(57, NULL, 8, 'columns', '3', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(58, NULL, 8, 'icon_size', 'l', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(59, NULL, 8, 'color', 'light', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(60, NULL, 8, 'bg_color', 'light', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(61, NULL, 8, 'shadow', 'none', '2017-01-03 11:17:43', '2017-01-03 11:17:43'),
(63, NULL, 9, 'box_image', '1', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(64, NULL, 9, 'title', 'Contact us', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(65, NULL, 9, 'content', 'We are here to answer any questions you may have about our services. Reach out to us and we\'ll respond as soon as we can.', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(66, NULL, 9, 'files', '', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(67, NULL, 9, 'phone_number', '', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(68, NULL, 9, 'phone_number_btn', 'Call us directly', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(69, NULL, 9, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\",\"ion-android-home\"],\"title\":[\"Phone\",\"Email\",\"Website\",\"Address\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\",\"795 Folsom Ave, Suite 600\"]}', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(70, NULL, 9, 'social_share_text', '', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(71, NULL, 9, 'social_share', '0', '2017-01-03 11:19:04', '2017-01-03 11:19:04'),
(72, NULL, 10, 'currency', 'USD', '2017-01-04 20:07:30', '2017-02-02 20:50:49'),
(73, NULL, 10, 'flat_rate', '0', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(74, NULL, 10, 'quantity_rate', '0', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(75, NULL, 10, 'total_rate', '0.00', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(76, NULL, 10, 'tax_rate', '0.00', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(77, NULL, 10, 'tax_shipping', '1', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(78, NULL, 10, 'payment_provider', 'PayPal', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(79, NULL, 10, 'payment_provider_email', 'victor.langula@gmail.com', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(80, NULL, 10, 'sandbox', '1', '2017-01-04 20:07:30', '2017-02-02 20:50:49'),
(81, NULL, 10, 'products', '{\"photo\":[\"\\/build\\/uploads\\/user\\/R4\\/iphone.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/samsung-galaxy-s7-hands-on-sean-okane18_2040.0.jpg\",\"\\/build\\/uploads\\/user\\/R4\\/Tecno-Phantom-5-Specifications-Review-and-Price-in-Kenya.jpg\"],\"title\":[\"iPhone 7\",\"Galaxy S7\",\"Tecno Phantom 5\"],\"desc\":[\"iPhone 7 Plus mpya kabisa na iko kwenye hali nzuri\",\"Samsung Galaxy S7 mpya kabisa. Ipo Dar\",\"Tecno Phontom 5 imetumika lakini iko poa sana.\"],\"price\":[\"7\",\"1\",\"3\"],\"active\":[\"1\",\"1\",\"1\"]}', '2017-01-04 20:07:30', '2017-02-02 20:51:10'),
(82, NULL, 11, 'image', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(83, NULL, 11, 'box_image', '1', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(84, NULL, 11, 'title', 'Contact us', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(85, NULL, 11, 'content', 'We are here to answer any questions you may have about our services. Reach out to us and we\'ll respond as soon as we can.', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(86, NULL, 11, 'files', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(87, NULL, 11, 'phone_number', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(88, NULL, 11, 'phone_number_btn', 'Call us directly', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(89, NULL, 11, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-android-home\"],\"title\":[\"Phone\",\"Email\",\"Address\"],\"value\":[\"255 653 183020\",\"info@langula.com\",\"P.O Box 36138 Dar\"]}', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(90, NULL, 11, 'social_share_text', 'Contacts', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(91, NULL, 11, 'social_share', '0', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(92, NULL, 12, 'address', 'Kigamboni', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(93, NULL, 12, 'longitude', '39.3154352', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(94, NULL, 12, 'latitude', '-6.828002', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(95, NULL, 12, 'zoom', '9', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(96, NULL, 12, 'open_marker', '1', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(97, NULL, 12, 'marker', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(98, NULL, 12, 'files', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(99, NULL, 12, 'icon', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(100, NULL, 12, 'custom_icon', '', '2017-01-04 20:07:30', '2017-01-04 20:07:30'),
(101, NULL, 13, 'currency', 'TZS', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(102, NULL, 13, 'flat_rate', '0', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(103, NULL, 13, 'quantity_rate', '0', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(104, NULL, 13, 'tax_rate', '0.00', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(105, NULL, 13, 'tax_shipping', '0.00', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(106, NULL, 13, 'payment_provider', 'Paypal', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(107, NULL, 13, 'payment_provider_email', 'victor.langula@gmail.com', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(108, NULL, 13, 'sandbox', '0', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(109, NULL, 14, 'image_box', '1', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(110, NULL, 14, 'title', 'Contact us', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(111, NULL, 14, 'content', 'We are here to answer any questions.', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(112, NULL, 14, 'phone_number_btn', 'Call us directly', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(113, NULL, 14, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-01-11 08:39:12', '2017-01-11 08:39:12'),
(114, NULL, 15, 'currency', 'TZS', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(115, NULL, 15, 'flat_rate', '0', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(116, NULL, 15, 'quantity_rate', '0', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(117, NULL, 15, 'tax_rate', '0.00', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(118, NULL, 15, 'tax_shipping', '0.00', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(119, NULL, 15, 'payment_provider', 'Paypal', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(120, NULL, 15, 'payment_provider_email', 'victor.langula@gmail.com', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(121, NULL, 15, 'sandbox', '0', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(122, NULL, 16, 'image_box', '1', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(123, NULL, 16, 'title', 'Contact us', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(124, NULL, 16, 'content', 'We are here to answer any questions.', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(125, NULL, 16, 'phone_number_btn', 'Call us directly', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(126, NULL, 16, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-01-12 16:21:26', '2017-01-12 16:21:26'),
(127, NULL, 17, 'currency', 'USD', '2017-01-15 12:48:00', '2017-01-15 12:54:44'),
(128, NULL, 17, 'flat_rate', '0', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(129, NULL, 17, 'quantity_rate', '0', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(130, NULL, 17, 'tax_rate', '0.00', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(131, NULL, 17, 'tax_shipping', '1', '2017-01-15 12:48:00', '2017-01-15 12:54:44'),
(132, NULL, 17, 'payment_provider', 'PayPal', '2017-01-15 12:48:00', '2017-01-15 12:54:44'),
(133, NULL, 17, 'payment_provider_email', 'victor.langula@gmail.com', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(134, NULL, 17, 'sandbox', '0', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(135, NULL, 18, 'image_box', '1', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(136, NULL, 18, 'title', 'Contact us', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(137, NULL, 18, 'content', 'We are here to answer any questions.', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(138, NULL, 18, 'phone_number_btn', 'Call us directly', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(139, NULL, 18, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-01-15 12:48:00', '2017-01-15 12:48:00'),
(140, NULL, 17, 'products', '{\"photo\":[\"\\/build\\/uploads\\/user\\/je\\/komando.png\"],\"title\":[\"Title\"],\"desc\":[\"Desasdaf \"],\"price\":[\"500\"],\"active\":[\"1\"]}', '2017-01-15 12:54:44', '2017-01-15 12:54:44'),
(141, NULL, 17, 'total_rate', '0.00', '2017-01-15 12:54:44', '2017-01-15 12:54:44'),
(142, NULL, 20, 'currency', 'TZS', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(143, NULL, 20, 'flat_rate', '0', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(144, NULL, 20, 'quantity_rate', '0', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(145, NULL, 20, 'tax_rate', '0.00', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(146, NULL, 20, 'tax_shipping', '0.00', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(147, NULL, 20, 'payment_provider', 'Paypal', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(148, NULL, 20, 'payment_provider_email', 'victor.langula@gmail.com', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(149, NULL, 20, 'sandbox', '0', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(150, NULL, 21, 'image_box', '1', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(151, NULL, 21, 'title', 'Contact us', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(152, NULL, 21, 'content', 'We are here to answer any questions.', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(153, NULL, 21, 'phone_number_btn', 'Call us directly', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(154, NULL, 21, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-05-04 08:20:50', '2017-05-04 08:20:50'),
(155, NULL, 22, 'currency', 'TZS', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(156, NULL, 22, 'flat_rate', '0', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(157, NULL, 22, 'quantity_rate', '0', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(158, NULL, 22, 'tax_rate', '0.00', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(159, NULL, 22, 'tax_shipping', '0.00', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(160, NULL, 22, 'payment_provider', 'Paypal', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(161, NULL, 22, 'payment_provider_email', 'victor.langula@gmail.com', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(162, NULL, 22, 'sandbox', '0', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(163, NULL, 23, 'image_box', '1', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(164, NULL, 23, 'title', 'Contact us', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(165, NULL, 23, 'content', 'We are here to answer any questions.', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(166, NULL, 23, 'phone_number_btn', 'Call us directly', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(167, NULL, 23, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-09-20 03:09:59', '2017-09-20 03:09:59'),
(168, NULL, 24, 'currency', 'TZS', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(169, NULL, 24, 'flat_rate', '0', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(170, NULL, 24, 'quantity_rate', '0', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(171, NULL, 24, 'tax_rate', '0.00', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(172, NULL, 24, 'tax_shipping', '0.00', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(173, NULL, 24, 'payment_provider', 'Paypal', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(174, NULL, 24, 'payment_provider_email', 'victor.langula@gmail.com', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(175, NULL, 24, 'sandbox', '0', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(176, NULL, 25, 'image_box', '1', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(177, NULL, 25, 'title', 'Contact us', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(178, NULL, 25, 'content', 'We are here to answer any questions.', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(179, NULL, 25, 'phone_number_btn', 'Call us directly', '2017-10-20 06:34:32', '2017-10-20 06:34:32'),
(180, NULL, 25, 'list', '{\"icon\":[\"ion-ios-telephone\",\"ion-android-mail\",\"ion-ios-world\"],\"title\":[\"Phone\",\"Email\",\"Website\"],\"value\":[\"(123) 456-7890\",\"info@example.com\",\"http:\\/\\/www.example.com\"]}', '2017-10-20 06:34:32', '2017-10-20 06:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(7, 4, 2),
(5, 5, 2),
(8, 6, 2),
(9, 7, 2),
(10, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `settings` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `user_id`, `name`, `date_start`, `date_end`, `language`, `timezone`, `active`, `settings`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'Shop', NULL, NULL, NULL, NULL, 1, NULL, '2016-12-15 15:05:18', '2016-12-15 15:05:18', NULL, 1, 1),
(2, 2, 'App', NULL, NULL, NULL, NULL, 1, NULL, '2016-12-31 05:16:00', '2016-12-31 05:16:00', NULL, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` text COLLATE utf8_unicode_ci NOT NULL,
  `match` text COLLATE utf8_unicode_ci NOT NULL,
  `expire` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `key`, `match`, `expire`, `active`) VALUES
(1, '40CK-08C5-59M6-L42L', '', 0, 1),
(2, '4Y2N-9055-5C37-73S3', '', 0, 1),
(3, '408O-7701-JJEB-Q103', '', 0, 1),
(4, '0O39-743K-70PY-78XJ', '', 0, 1),
(5, 'pGrnGDWa2d', '', 0, 1),
(6, 'BooW3LvrgV', '', 0, 1),
(7, 'Yvwi7ejZ8A', '', 0, 1),
(8, 'CZcBykDR8C', '', 0, 1),
(9, '4K15-Y1F0-MR9M-0397', '', 0, 1),
(10, 'JmCXcajXfJ', '', 0, 1),
(11, 'JVHZRx90ol', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `parent_id`, `type`, `subject`, `desc`, `ip`, `os`, `client`, `device`, `brand`, `model`, `created_at`) VALUES
(1, 1, NULL, 'user', 'Login', 'System Owner [info@example.com] logged in', '169.255.184.138', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2016-12-15 14:40:54'),
(2, 1, NULL, 'campaign', 'Campaign', 'Victor Langula [victor.langula@gmail.com] created campaign (Shop)', '169.255.184.138', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2016-12-15 15:05:18'),
(3, 1, NULL, 'campaign', 'Campaign', 'Victor Langula [victor.langula@gmail.com] created campaign (Shop)', '169.255.184.138', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2016-12-15 15:05:18'),
(4, 1, NULL, 'app', 'Business', 'Victor Langula [victor.langula@gmail.com] created app (LangulaShop)', '169.255.184.138', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2016-12-15 15:05:18'),
(5, 1, NULL, 'user', 'Login', 'Victor Langula [victor.langula@gmail.com] logged in', '196.249.96.34', 'Android', 'Chrome Mobile 55.0', 'Smartphone', 'TB', '-C8', '2016-12-20 16:25:49'),
(6, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '197.187.26.39', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2016-12-20 18:51:59'),
(7, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '41.188.151.148', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2016-12-21 09:05:41'),
(8, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '197.187.59.39', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2016-12-23 13:38:26'),
(9, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged out', '197.187.59.39', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2016-12-23 13:38:42'),
(10, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '197.152.217.192', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2016-12-31 05:04:44'),
(11, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '41.222.180.191', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2016-12-31 05:13:40'),
(12, 2, NULL, 'campaign', 'Campaign', 'rkoola [rkoola@gmail.com] created campaign (App)', '41.222.180.191', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2016-12-31 05:16:00'),
(13, 2, NULL, 'campaign', 'Campaign', 'rkoola [rkoola@gmail.com] created campaign (App)', '41.222.180.191', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2016-12-31 05:16:00'),
(14, 2, NULL, 'app', 'Other', 'rkoola [rkoola@gmail.com] created app (Lost and found)', '41.222.180.191', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2016-12-31 05:18:30'),
(15, 1, NULL, 'user', 'Account', 'Victor Langula [victor.langula@gmail.com] changed avatar', '169.255.184.154', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-02 05:43:08'),
(16, 1, NULL, 'user', 'Account', 'Victor Langula [victor.langula@gmail.com] deleted avatar', '169.255.184.154', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-02 05:43:26'),
(17, 1, NULL, 'app', 'Restaurants', 'Victor Langula [victor.langula@gmail.com] created app (Unititled Shop)', '196.249.98.9', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-03 11:06:01'),
(18, 1, NULL, 'app', 'Business', 'Victor Langula [victor.langula@gmail.com] created app (MwandusShop)', '169.255.184.182', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-04 20:07:30'),
(19, 1, NULL, 'app', 'Business', 'Victor Langula [victor.langula@gmail.com] created app (MwandusShop)', '169.255.184.182', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-04 20:07:30'),
(20, 1, NULL, 'app', 'Business', 'Victor Langula [victor.langula@gmail.com] created app (MwandusShop)', '169.255.184.182', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-04 20:07:30'),
(21, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '41.13.108.96', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2017-01-08 09:45:26'),
(22, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged out', '41.13.108.96', 'Android', 'Chrome 44.0', 'Tablet', 'SA', 'SM-T715', '2017-01-08 09:45:40'),
(23, 3, NULL, 'user', 'Login', 'mercy [mercy.pdenis@gmail.com] logged in', '196.249.98.109', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-11 08:40:15'),
(24, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged in', '197.186.120.146', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2017-01-12 16:12:30'),
(25, 2, NULL, 'user', 'Login', 'rkoola [rkoola@gmail.com] logged out', '197.186.120.146', 'iOS', 'Mobile Safari 9.0', 'Smartphone', 'AP', 'iPhone', '2017-01-12 16:22:23'),
(26, 5, NULL, 'user', 'Login', 'vsl [victorslangula@desiamore.com] logged in', '197.187.252.102', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-15 12:50:17'),
(27, 5, NULL, 'user', 'Login', 'vsl [victorslangula@desiamore.com] logged out', '197.187.252.102', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-15 13:10:19'),
(28, 1, NULL, 'user', 'Login', 'Victor Langula [victor.langula@gmail.com] logged in', '197.187.252.102', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-15 13:13:12'),
(29, 5, NULL, 'user', 'Login', 'vsl [victorslangula@desiamore.com] logged in', '169.255.184.247', 'Windows', 'Chrome 55.0', 'Desktop', NULL, NULL, '2017-01-24 05:55:12'),
(30, 1, NULL, 'app', 'Other', 'Victor Langula [victor.langula@gmail.com] created app (NewVeeShop)', '169.255.184.154', 'Windows', 'Chrome 58.0', 'Desktop', NULL, NULL, '2017-06-11 17:58:50'),
(31, 1, NULL, 'user', 'Login', 'Victor Langula [victor.langula@gmail.com] logged in', '41.221.54.70', 'Windows', 'Chrome 58.0', 'Desktop', NULL, NULL, '2017-06-18 13:58:54'),
(32, 7, NULL, 'user', 'Login', 'haidir [haidir.fb@gmail.com] logged in', '202.67.38.14', 'Windows', 'Chrome 60.0', 'Desktop', NULL, NULL, '2017-09-20 03:11:42'),
(33, 1, NULL, 'user', 'Login', 'Victor Langula [victor.langula@gmail.com] logged in', '196.249.98.208', 'Windows', 'Chrome 61.0', 'Desktop', NULL, NULL, '2017-09-28 15:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_id` int(10) UNSIGNED DEFAULT NULL,
  `to_id` int(10) UNSIGNED DEFAULT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '1',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `settings` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_07_16_191110_confide_setup_users_table', 1),
('2014_07_16_191120_entrust_setup_tables', 1),
('2014_07_16_191130_create_campaigns_table', 1),
('2014_07_16_191150_create_apps_table', 1),
('2014_07_16_191160_create_app_pages_table', 1),
('2014_07_16_191190_create_app_widget_data_table', 1),
('2014_07_16_191195_create_app_user_data_table', 1),
('2014_07_16_191210_create_settings_table', 1),
('2014_07_16_191220_create_messages_table', 1),
('2014_08_04_195400_create_log_table', 1),
('2014_10_01_184634_create_keys_table', 1),
('2015_04_02_122036_create_oauth_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth`
--

CREATE TABLE `oauth` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `uuid` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token_secret` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth1_token_identifier` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth1_token_secret` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth2_access_token` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth2_refresh_token` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oauth2_expires` timestamp NULL DEFAULT NULL,
  `settings` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reminders`
--

CREATE TABLE `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'system_management', 'System Management', '2016-12-15 14:18:35', '2016-12-15 14:18:35'),
(2, 'user_management', 'User Management', '2016-12-15 14:18:35', '2016-12-15 14:18:35'),
(3, 'general_management', 'General Management', '2016-12-15 14:18:35', '2016-12-15 14:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 2, 2),
(5, 3, 2),
(6, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `settings` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `sort`, `name`, `hidden`, `settings`) VALUES
(1, 10, 'Basic', 0, '{\"max_apps\":\"1\",\"support\":\"-\",\"domain\":\"1\",\"download\":\"0\",\"widgets\":[\"about-us\",\"e-commerce\",\"email-us\",\"home-screen\"],\"monthly\":\"3000\",\"annual\":\"2916.6667\",\"currency\":\"TZS\",\"featured\":\"0\"}'),
(2, 20, 'Standard', 0, '{\"max_apps\":\"2\",\"support\":\"Phone Call, Free Training\",\"domain\":\"1\",\"download\":\"0\",\"widgets\":[\"about-us\",\"contact-us\",\"e-commerce\",\"home-screen\",\"map\"],\"monthly\":\"5000\",\"annual\":\"4916.6667\",\"currency\":\"TZS\",\"featured\":\"1\"}'),
(4, 40, 'Professional', 0, '{\"max_apps\":\"5\",\"support\":\"Email Support, Call Support, Free Training\",\"domain\":\"1\",\"download\":\"0\",\"widgets\":[\"about-us\",\"call-us\",\"contact-us\",\"content\",\"e-commerce\",\"facebook\",\"home-screen\"],\"monthly\":\"8500\",\"annual\":\"8250\",\"currency\":\"TZS\",\"featured\":\"0\"}');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', '2016-12-15 14:18:35', '2016-12-15 14:18:35'),
(2, 'Admin', '2016-12-15 14:18:35', '2016-12-15 14:18:35'),
(3, 'Manager', '2016-12-15 14:18:35', '2016-12-15 14:18:35'),
(4, 'User', '2016-12-15 14:18:35', '2016-12-15 14:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`user_id`, `name`, `value`) VALUES
(0, 'page_title', 'YegoYes Shops'),
(0, 'page_description', 'Create online shops without coding'),
(0, 'invoice_number', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `remote_id` bigint(20) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `plan_id` int(10) UNSIGNED DEFAULT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `theme` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `timezone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UTC',
  `logins` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `settings` text COLLATE utf8_unicode_ci,
  `expires` datetime DEFAULT NULL,
  `expire_notifications` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `avatar_file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_file_size` int(11) DEFAULT NULL,
  `avatar_content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `remote_id`, `parent_id`, `plan_id`, `username`, `email`, `password`, `confirmation_code`, `remember_token`, `confirmed`, `first_name`, `last_name`, `website`, `twitter`, `facebook`, `provider`, `theme`, `language`, `timezone`, `logins`, `last_login`, `settings`, `expires`, `expire_notifications`, `avatar_file_name`, `avatar_file_size`, `avatar_content_type`, `avatar_updated_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 4, 'admin', 'victor.langula@gmail.com', '$2y$10$3WlYxf22U5wlTUEAcsvrrOAJ.0QZ72dYhLwJuGW8GM9p/XnKZLrVC', 'seeded', 'ynGEKvpYfGzEwwaykVLfP2jXIc45XPnMRKvdKToQdZWsNx0SNpOjJcnbN5WL', 1, 'Victor', 'Langula', NULL, NULL, NULL, NULL, NULL, 'en', 'Africa/Nairobi', 5, '2017-09-28 16:15:14', '{\"invoices\":1}', NULL, 0, NULL, NULL, NULL, NULL, '2016-12-15 14:18:35', '2017-09-28 15:15:14', NULL),
(2, NULL, NULL, 1, 'rkoola', 'rkoola@gmail.com', '$2y$10$vjBlQSPDtn7WftQ7HjLOqe7pI9jdRw2FKt4viUqKccBpZm7MS2FhC', '624efe547253d04ad3afac3a3694814a', '3bqIYOI5I3cmNNRDpGqqNWCvhLhG06rBQkpUVWlJ0piudn4r0wqpwDr2CXFX', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 7, '2017-01-12 16:12:30', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2016-12-20 18:21:19', '2017-01-12 16:22:23', NULL),
(3, NULL, NULL, 1, 'mercy', 'mercy.pdenis@gmail.com', '$2y$10$N44IBZFxGZaLbihWfFFMreRBB1c7By28csE69pBdMCwHi5hKJLbUi', '5dee2219e19ca3e13fd55dbacdd53e5a', 'ZpcgccUICQfg1Ag1XfCwBBBuuLBUJcUGPksJmYi1IlohDhBZ45atBAZ946RB', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 1, '2017-01-11 08:40:15', '{\"invoices\":1}', NULL, 0, NULL, NULL, NULL, NULL, '2017-01-11 08:39:12', '2017-01-28 13:41:04', NULL),
(4, NULL, NULL, 1, 'nocommentstv', 'rkoola@yegogroup.com', '$2y$10$nN2gGTXDjZMh2FnORcoQzenGqOJSn3bxWoT2/ysDEt5th2KRx/Rf.', '4c1b04ee18f14f580f46f3880b7ebe3b', NULL, 1, '', '', NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2017-01-12 16:21:26', '2017-01-15 13:21:17', NULL),
(5, NULL, NULL, 1, 'vsl', 'victorslangula@desiamore.com', '$2y$10$dY7W7/KOmCY2WRYWrcWe8eXXn72/5fPbrCy4lkaWXxHIez02UbAXe', '7518d06703714f882870850f659f1448', 'MsF1pxUK9tcjCkmGSVkns1JZ6q6DiXTQKgjRdxJKKHdZnwbGdT1VfL0ReBF8', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 2, '2017-01-24 05:55:12', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2017-01-15 12:48:00', '2017-01-24 05:55:12', NULL),
(6, NULL, NULL, 1, 'yegouser', 'yegouser@yegopesa.com', '$2y$10$K.VpKhiE8cCfpefgAVP6GOu/.AicIWSYKWU6chAcH4kkFBNDBs86y', '23169ffe8f25c8f7b620a0c7cbe07d17', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2017-05-04 08:20:50', '2017-05-04 08:20:50', NULL),
(7, NULL, NULL, 1, 'haidir', 'haidir.fb@gmail.com', '$2y$10$R2p5oqa/TjjISc/7C2PxVeCX21QVsNPafl79JI9B6CWi4JXkuIng2', '7727335bced3ce4ca4631a306fae788c', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 1, '2017-09-20 04:11:41', NULL, NULL, 0, NULL, NULL, NULL, NULL, '2017-09-20 03:09:58', '2017-09-20 03:11:41', NULL),
(8, NULL, NULL, 1, 'test', 'test@test.com', '$2y$10$O0uMngz3RnVAQZtHaMA15us924NRqkD8FpYV4yAScwt4PadH2xXee', 'b5b7c6fc742164c47fa716a633116e45', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 'UTC', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '2017-10-20 06:34:32', '2017-10-20 06:34:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apps_user_id_foreign` (`user_id`),
  ADD KEY `apps_campaign_id_foreign` (`campaign_id`),
  ADD KEY `apps_app_type_id_foreign` (`app_type_id`);

--
-- Indexes for table `app_pages`
--
ALTER TABLE `app_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_pages_app_id_foreign` (`app_id`),
  ADD KEY `app_pages_parent_id_index` (`parent_id`),
  ADD KEY `app_pages_lft_index` (`lft`),
  ADD KEY `app_pages_rgt_index` (`rgt`);

--
-- Indexes for table `app_types`
--
ALTER TABLE `app_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_user_data`
--
ALTER TABLE `app_user_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_user_data_app_id_foreign` (`app_id`),
  ADD KEY `app_user_data_app_page_id_foreign` (`app_page_id`);

--
-- Indexes for table `app_widget_data`
--
ALTER TABLE `app_widget_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_widget_data_app_page_id_foreign` (`app_page_id`);

--
-- Indexes for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_roles_user_id_foreign` (`user_id`),
  ADD KEY `assigned_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaigns_user_id_foreign` (`user_id`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_user_id_foreign` (`user_id`),
  ADD KEY `logs_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_from_id_foreign` (`from_id`),
  ADD KEY `messages_to_id_foreign` (`to_id`);

--
-- Indexes for table `oauth`
--
ALTER TABLE `oauth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD KEY `settings_name_index` (`name`),
  ADD KEY `settings_value_index` (`value`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_parent_id_foreign` (`parent_id`),
  ADD KEY `users_plan_id_foreign` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `app_pages`
--
ALTER TABLE `app_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `app_types`
--
ALTER TABLE `app_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `app_user_data`
--
ALTER TABLE `app_user_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_widget_data`
--
ALTER TABLE `app_widget_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth`
--
ALTER TABLE `oauth`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
