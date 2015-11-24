-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2015 at 03:34 PM
-- Server version: 5.6.19-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `balin`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) unsigned NOT NULL,
  `owner_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_deleted_at_owner_id_owner_type_index` (`deleted_at`,`owner_id`,`owner_type`),
  KEY `addresses_owner_id_index` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `owner_id`, `owner_type`, `phone`, `address`, `zipcode`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'App\\Models\\Supplier', '09684283542', '8974 Brent Mountains\nDorthaborough, NV 53588', '54747', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(2, 2, 'App\\Models\\Supplier', '512.842.6239x3606', '38508 Douglas Shore Suite 642\nWest Marjoryton, DE 56509-2927', '32000-9167', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(3, 3, 'App\\Models\\Supplier', '+07(3)5454099886', '571 Sean Valley Suite 076\nNorth Barton, MS 01571', '74530', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(4, 4, 'App\\Models\\Supplier', '1-919-562-5932x7164', '12939 Abbott Union\nKuvalismouth, LA 02938-1507', '40489-4750', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(5, 5, 'App\\Models\\Supplier', '013-369-0382x05102', '9865 Rogelio Manors\nErdmanmouth, MT 74832', '83932', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(6, 6, 'App\\Models\\Supplier', '1-927-144-4461x4939', '1164 O''Kon Forge\nBrekkeview, KY 02792', '17809-5252', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(7, 1, 'App\\Models\\Courier', '(775)567-8376x347', '1962 Devin Avenue Apt. 600\nNorth Assunta, MA 98102', '33697-3170', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(8, 2, 'App\\Models\\Courier', '07035045834', '471 Auer Light Apt. 421\nNew Gerry, AR 00251', '11441-9342', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(9, 0, '', '032468701144', 'Ruko Puri Niaga', '65135', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(10, 0, '', '058965540', 'Ruko Puri Niaga', '65135', '2015-11-24 00:24:23', '2015-11-24 00:24:23', NULL),
(11, 0, '', '5689845400', 'Ruko Puri Niaga', '65135', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(12, 0, '', '265962000', 'Ruko Puri Niaga', '65135', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auditors`
--

CREATE TABLE IF NOT EXISTS `auditors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `table_id` int(10) unsigned NOT NULL,
  `table_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ondate` datetime NOT NULL,
  `event` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auditors_deleted_at_type_ondate_index` (`deleted_at`,`type`,`ondate`),
  KEY `auditors_user_id_index` (`user_id`),
  KEY `auditors_table_id_index` (`table_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54 ;

--
-- Dumping data for table `auditors`
--

INSERT INTO `auditors` (`id`, `user_id`, `table_id`, `table_type`, `ondate`, `event`, `type`, `action`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 15, 'App\\Models\\StoreSetting', '2015-11-24 06:17:26', 'Perubahan Policy  expired cart menjadi  + 1 day', 'policy_changed', '', '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(2, 0, 16, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  expired paid menjadi  - 2 days', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(3, 0, 17, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  expired shipped menjadi + 5 days', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(4, 0, 18, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  expired point menjadi + 1 year', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(5, 0, 19, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  referral royalty menjadi 10000', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(6, 0, 20, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  invitation royalty menjadi 50000', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(7, 0, 21, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  limit unique number menjadi 100', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(8, 0, 22, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  expired link duration menjadi + 2 hours', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(9, 0, 23, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  first quota menjadi 10', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(10, 0, 24, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  downline purchase bonus menjadi 10000', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(11, 0, 25, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  downline purchase bonus expired menjadi  + 3 months', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(12, 0, 26, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  downline purchase quota bonus menjadi 1', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(13, 0, 27, 'App\\Models\\StoreSetting', '2015-11-24 06:17:27', 'Perubahan Policy  voucher point expired menjadi + 3 months', 'policy_changed', '', '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(14, 0, 1, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(15, 0, 1, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Penambahan quota sebesar 10 voucher balbal5u', 'quota_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(16, 0, 2, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(17, 0, 2, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Penambahan quota sebesar 10 voucher stastau0', 'quota_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(18, 0, 3, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(19, 0, 3, 'App\\Models\\Voucher', '2015-11-24 06:17:28', 'Penambahan quota sebesar 10 voucher manmancy', 'quota_added', '', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(20, 0, 1, 'App\\Models\\Price', '2015-11-24 06:17:31', 'Perubahan harga produk Hem Batik Semi Sutera menjadi 249000', 'price_changed', '', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(21, 0, 2, 'App\\Models\\Price', '2015-11-24 06:17:32', 'Perubahan harga produk Abstract Pattern Mixed Kawung Slimfit Shirt menjadi 249000', 'price_changed', '', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(22, 0, 3, 'App\\Models\\Price', '2015-11-24 06:17:33', 'Perubahan harga produk Hem Batik Cumikan Pelangi menjadi 249000', 'price_changed', '', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(23, 0, 4, 'App\\Models\\Price', '2015-11-24 06:17:34', 'Perubahan harga produk Hem Batik Ikan Moorish menjadi 249000', 'price_changed', '', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(24, 0, 5, 'App\\Models\\Price', '2015-11-24 06:17:34', 'Perubahan harga produk Hem Pendek Motif Mina Ginaris menjadi 249000', 'price_changed', '', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(25, 0, 6, 'App\\Models\\Price', '2015-11-24 06:17:35', 'Perubahan harga produk Hem Pdk Pa Koi Nandang Roso 53 menjadi 249000', 'price_changed', '', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(26, 0, 7, 'App\\Models\\Price', '2015-11-24 06:17:36', 'Perubahan harga produk Hem Pdk Pa Sekar Jamur 20 menjadi 249000', 'price_changed', '', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(27, 0, 8, 'App\\Models\\Price', '2015-11-24 06:17:36', 'Perubahan harga produk Hem Pdk Ctn Silk Sisik Manggar  menjadi 249000', 'price_changed', '', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(28, 0, 9, 'App\\Models\\Price', '2015-11-24 06:17:37', 'Perubahan harga produk Hem Pendek Pa Sekar Jagat  menjadi 249000', 'price_changed', '', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(29, 3, 4, 'App\\Models\\Voucher', '2015-11-24 06:43:51', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:43:51', '2015-11-23 23:43:51', NULL),
(30, 3, 4, 'App\\Models\\Voucher', '2015-11-24 06:43:51', 'Penambahan quota sebesar 10 voucher gopbalpa', 'quota_added', '', '2015-11-23 23:43:51', '2015-11-23 23:43:51', NULL),
(31, 3, 5, 'App\\Models\\Voucher', '2015-11-24 06:44:26', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:44:26', '2015-11-23 23:44:26', NULL),
(32, 3, 5, 'App\\Models\\Voucher', '2015-11-24 06:44:26', 'Penambahan quota sebesar 10 voucher chemooqg', 'quota_added', '', '2015-11-23 23:44:26', '2015-11-23 23:44:26', NULL),
(33, 3, 6, 'App\\Models\\Voucher', '2015-11-24 06:44:53', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:44:53', '2015-11-23 23:44:53', NULL),
(34, 3, 6, 'App\\Models\\Voucher', '2015-11-24 06:44:53', 'Penambahan quota sebesar 10 voucher budpurjt', 'quota_added', '', '2015-11-23 23:44:53', '2015-11-23 23:44:53', NULL),
(35, 3, 7, 'App\\Models\\Voucher', '2015-11-24 06:45:16', 'Pembuatan Voucher referral sebesar 0', 'voucher_added', '', '2015-11-23 23:45:16', '2015-11-23 23:45:16', NULL),
(36, 3, 7, 'App\\Models\\Voucher', '2015-11-24 06:45:16', 'Penambahan quota sebesar 10 voucher agimahat', 'quota_added', '', '2015-11-23 23:45:16', '2015-11-23 23:45:16', NULL),
(37, 3, 8, 'App\\Models\\Voucher', '2015-11-24 06:47:57', 'Pembuatan Voucher free shipping cost sebesar 0', 'voucher_added', '', '2015-11-23 23:47:57', '2015-11-23 23:47:57', NULL),
(38, 3, 9, 'App\\Models\\Voucher', '2015-11-24 06:49:26', 'Pembuatan Voucher free shipping cost sebesar 0', 'voucher_added', '', '2015-11-23 23:49:26', '2015-11-23 23:49:26', NULL),
(39, 3, 8, 'App\\Models\\Voucher', '2015-11-24 06:53:00', 'Penambahan quota sebesar 10 voucher premier1', 'quota_added', '', '2015-11-23 23:53:00', '2015-11-23 23:53:00', NULL),
(40, 3, 1, 'App\\Models\\PointLog', '2015-11-24 07:08:46', 'Penambahan point sebesar 10000 untuk Chelsy Mooy', 'point_added', '', '2015-11-24 00:08:46', '2015-11-24 00:08:46', NULL),
(41, 5, 4, 'App\\Models\\Voucher', '2015-11-24 07:14:13', 'Penambahan quota sebesar -1 voucher gopbalpa', 'quota_added', '', '2015-11-24 00:14:13', '2015-11-24 00:14:13', NULL),
(42, 6, 4, 'App\\Models\\Voucher', '2015-11-24 07:14:41', 'Penambahan quota sebesar -1 voucher gopbalpa', 'quota_added', '', '2015-11-24 00:14:41', '2015-11-24 00:14:41', NULL),
(43, 4, 1, 'App\\Models\\Voucher', '2015-11-24 07:15:10', 'Penambahan quota sebesar -1 voucher balbal5u', 'quota_added', '', '2015-11-24 00:15:10', '2015-11-24 00:15:10', NULL),
(44, 6, 8, 'App\\Models\\Voucher', '2015-11-24 07:19:47', 'Penambahan quota sebesar -1 voucher premier1', 'quota_added', '', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(45, 7, 10, 'App\\Models\\Transaction', '2015-11-24 07:22:39', 'Abandoned Cart', 'abandoned_cart', '', '2015-11-24 00:22:39', '2015-11-24 00:22:39', NULL),
(46, 5, 8, 'App\\Models\\Voucher', '2015-11-24 07:27:07', 'Penambahan quota sebesar -1 voucher premier1', 'quota_added', '', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(47, 2, 9, 'App\\Models\\Transaction', '2015-11-24 07:28:56', 'Pembatalan Pesanan. Selisih waktu checkout hingga pembatalan : 2 hari', 'transaction_canceled', '', '2015-11-24 00:28:56', '2015-11-24 00:28:56', NULL),
(48, 6, 8, 'App\\Models\\Voucher', '2015-11-24 07:30:02', 'Penambahan quota sebesar -1 voucher premier1', 'quota_added', '', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL),
(49, 2, 4, 'App\\Models\\Voucher', '2015-11-24 07:31:35', 'Penambahan quota sebesar 1 voucher gopbalpa', 'quota_added', '', '2015-11-24 00:31:35', '2015-11-24 00:31:35', NULL),
(50, 2, 13, 'App\\Models\\Transaction', '2015-11-24 07:31:39', 'Validasi Pembayaran. Selisih waktu bayar dan validasi : 0 hari', 'transaction_paid', '', '2015-11-24 00:31:39', '2015-11-24 00:31:39', NULL),
(51, 2, 4, 'App\\Models\\Voucher', '2015-11-24 07:32:30', 'Penambahan quota sebesar 1 voucher gopbalpa', 'quota_added', '', '2015-11-24 00:32:30', '2015-11-24 00:32:30', NULL),
(52, 2, 12, 'App\\Models\\Transaction', '2015-11-24 07:32:34', 'Validasi Pembayaran. Selisih waktu bayar dan validasi : 0 hari', 'transaction_paid', '', '2015-11-24 00:32:34', '2015-11-24 00:32:34', NULL),
(53, 2, 13, 'App\\Models\\Transaction', '2015-11-24 07:33:31', 'Pengiriman Barang. Selisih waktu validasi pembayaran dan pengiriman : 0 hari', 'transaction_shipping', '', '2015-11-24 00:33:31', '2015-11-24 00:33:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_deleted_at_path_name_index` (`deleted_at`,`path`,`name`),
  KEY `categories_category_id_index` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `type`, `path`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'category', '1', 'Balin Cap Basic', '2015-11-23 23:17:29', '2015-11-23 23:17:29', NULL),
(2, 0, 'category', '2', 'Balin Cap Premium', '2015-11-23 23:17:29', '2015-11-23 23:17:29', NULL),
(3, 0, 'category', '3', 'Balin Tulis Premium', '2015-11-23 23:17:29', '2015-11-23 23:17:29', NULL),
(4, 0, 'tag', '4', 'Lengan', '2015-11-23 23:17:29', '2015-11-23 23:17:29', NULL),
(5, 4, 'tag', '4,5', 'Pendek', '2015-11-23 23:17:29', '2015-11-23 23:39:48', NULL),
(6, 0, 'tag', '6', 'Warna', '2015-11-23 23:17:29', '2015-11-23 23:17:29', NULL),
(7, 6, 'tag', '6,7', 'Merah', '2015-11-23 23:17:29', '2015-11-23 23:41:17', NULL),
(8, 6, 'tag', '6,8', 'Putih', '2015-11-23 23:17:29', '2015-11-23 23:41:23', NULL),
(9, 6, 'tag', '6,9', 'Turqoise', '2015-11-23 23:17:29', '2015-11-23 23:41:27', NULL),
(10, 6, 'tag', '6,10', 'Abu Abu', '2015-11-23 23:17:29', '2015-11-23 23:40:49', NULL),
(11, 6, 'tag', '6,11', 'Biru', '2015-11-23 23:17:29', '2015-11-23 23:40:53', NULL),
(12, 6, 'tag', '6,12', 'Cream', '2015-11-23 23:17:30', '2015-11-23 23:40:57', NULL),
(13, 6, 'tag', '6,13', 'Pink', '2015-11-23 23:17:30', '2015-11-23 23:41:02', NULL),
(14, 6, 'tag', '6,14', 'Hitam', '2015-11-23 23:17:30', '2015-11-23 23:41:06', NULL),
(15, 6, 'tag', '6,15', 'Kuning', '2015-11-23 23:17:30', '2015-11-23 23:41:10', NULL),
(16, 6, 'tag', '6,16', 'Cokelat', '2015-11-23 23:17:30', '2015-11-23 23:41:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories_products`
--

CREATE TABLE IF NOT EXISTS `categories_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_products_category_id_index` (`category_id`),
  KEY `categories_products_product_id_index` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

--
-- Dumping data for table `categories_products`
--

INSERT INTO `categories_products` (`id`, `category_id`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 7, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 8, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 9, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 5, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 7, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 10, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 11, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 3, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 5, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(13, 7, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(14, 11, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(15, 2, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 5, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 7, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 8, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(19, 11, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(20, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(21, 5, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(22, 8, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(23, 9, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(24, 11, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(25, 3, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(26, 5, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(27, 9, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(28, 12, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(29, 13, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(30, 1, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(31, 5, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(32, 14, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(33, 15, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(34, 1, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(35, 5, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(36, 12, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(37, 14, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(38, 16, 8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(39, 1, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(40, 5, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(41, 8, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(42, 14, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(43, 16, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE IF NOT EXISTS `couriers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Balin Expedisi', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(2, 'JNE', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imageable_id` int(10) unsigned NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_xs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_sm` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_md` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_lg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `images_deleted_at_imageable_id_imageable_type_is_default_index` (`deleted_at`,`imageable_id`,`imageable_type`,`is_default`),
  KEY `images_imageable_id_index` (`imageable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=66 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `imageable_id`, `imageable_type`, `thumbnail`, `image_xs`, `image_sm`, `image_md`, `image_lg`, `is_default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 1, '2015-11-22 23:17:26', '2015-11-23 23:17:26', NULL),
(2, 13, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 1, '2015-11-21 23:17:26', '2015-11-23 23:17:26', NULL),
(3, 14, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 1, '2015-11-20 23:17:26', '2015-11-23 23:17:26', NULL),
(4, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-a-large.jpg', 1, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(5, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-b-large.jpg', 0, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(6, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-c-large.jpg', 0, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(7, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-d-large.jpg', 0, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(8, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-e-large.jpg', 0, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(9, 1, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/1-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/1-f-large.jpg', 0, '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(10, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-a-large.jpg', 1, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(11, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-b-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(12, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-c-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(13, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-d-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(14, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-e-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(15, 2, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/2-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/2-f-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(16, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-a-large.jpg', 1, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(17, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-b-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(18, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-c-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(19, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-d-large.jpg', 0, '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(20, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-e-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(21, 3, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/3-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/3-f-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(22, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-a-large.jpg', 1, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(23, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-b-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(24, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-c-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(25, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-d-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(26, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-e-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(27, 4, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/4-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/4-f-large.jpg', 0, '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(28, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-a-large.jpg', 1, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(29, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-b-large.jpg', 0, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(30, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-c-large.jpg', 0, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(31, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-d-large.jpg', 0, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(32, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-e-large.jpg', 0, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(33, 5, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/5-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/5-f-large.jpg', 0, '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(34, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-a-large.jpg', 1, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(35, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-b-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(36, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-c-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(37, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-d-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(38, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-e-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(39, 6, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/6-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/6-f-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(40, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-a-large.jpg', 1, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(41, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-b-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(42, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-c-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(43, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-d-large.jpg', 0, '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(44, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-e-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(45, 7, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/7-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/7-f-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(46, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-a-large.jpg', 1, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(47, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-b-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(48, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-c-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(49, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-d-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(50, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-e-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(51, 8, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/8-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/8-f-large.jpg', 0, '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(52, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-a.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-a-large.jpg', 1, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(53, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-b.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-b-large.jpg', 0, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(54, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-c.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-c-large.jpg', 0, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(55, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-d.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-d-large.jpg', 0, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(56, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-e.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-e-large.jpg', 0, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(57, 9, 'App\\Models\\Product', 'http://localhost:8000/Balin/web/balin/softlaunch/9-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-f.jpg', 'http://localhost:8000/Balin/web/balin/softlaunch/9-f-large.jpg', 0, '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(58, 1, 'App\\Models\\Courier', 'http://localhost:8000/Balin/web/image/logo.png', 'http://localhost:8000/Balin/web/image/logo.png', 'http://localhost:8000/Balin/web/image/logo.png', 'http://localhost:8000/Balin/web/image/logo.png', 'http://localhost:8000/Balin/web/image/logo.png', 0, '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(59, 2, 'App\\Models\\Courier', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg', 0, '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(60, 14, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 1, '2015-11-24 00:08:05', '2015-11-24 00:08:05', NULL),
(61, 12, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 1, '2015-11-24 00:08:20', '2015-11-24 00:08:20', NULL),
(62, 13, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 1, '2015-11-24 00:08:34', '2015-11-24 00:08:34', NULL),
(63, 14, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg', 1, '2015-11-24 00:09:45', '2015-11-24 00:09:45', NULL),
(64, 12, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 1, '2015-11-24 00:09:56', '2015-11-24 00:09:56', NULL),
(65, 13, 'App\\Models\\StoreSetting', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 1, '2015-11-24 00:10:03', '2015-11-24 00:10:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_06_19_034756_create_auditor_table', 1),
('2015_06_19_034756_create_courier_table', 1),
('2015_06_19_034756_create_image_table', 1),
('2015_06_19_034756_create_point_log_table', 1),
('2015_06_19_034756_create_product_lable_table', 1),
('2015_06_19_034756_create_product_table', 1),
('2015_06_19_034756_create_quota_log_table', 1),
('2015_06_19_034756_create_shipment_log_table', 1),
('2015_06_19_034756_create_shipment_table', 1),
('2015_06_19_034756_create_transaction_detail_table', 1),
('2015_06_19_034756_create_transaction_log_table', 1),
('2015_06_19_034756_create_transaction_table', 1),
('2015_06_19_034756_create_voucher_table', 1),
('2015_09_26_034215_create_category_table', 1),
('2015_09_30_085652_create_category_product_table', 1),
('2015_10_03_152911_create_price_table', 1),
('2015_10_04_143646_create_payment_table', 1),
('2015_10_04_143646_create_shipping_cost_table', 1),
('2015_10_04_143646_create_store_setting_table', 1),
('2015_10_04_143646_create_supplier_table', 1),
('2015_10_04_143646_create_user_table', 1),
('2015_10_30_094623_create_address_table', 1),
('2015_11_05_062056_create_varian_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ondate` date NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_deleted_at_ondate_amount_index` (`deleted_at`,`ondate`,`amount`),
  KEY `payments_transaction_id_index` (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `transaction_id`, `method`, `destination`, `account_name`, `account_number`, `ondate`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13, 'Bank Transfer', 'BCA', 'Budi Purnomo', '4564100036', '2015-11-24', 138996, '2015-11-24 00:31:35', '2015-11-24 00:31:35', NULL),
(2, 12, 'Bank Transfer', 'BCA', 'Chelsy Mooy', '0356812000', '2015-11-24', 337997, '2015-11-24 00:32:30', '2015-11-24 00:32:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `point_logs`
--

CREATE TABLE IF NOT EXISTS `point_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `point_log_id` int(10) unsigned NOT NULL,
  `reference_id` int(11) NOT NULL,
  `reference_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `expired_at` datetime NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `point_logs_deleted_at_user_id_expired_at_index` (`deleted_at`,`user_id`,`expired_at`),
  KEY `point_logs_user_id_index` (`user_id`),
  KEY `point_logs_point_log_id_index` (`point_log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `point_logs`
--

INSERT INTO `point_logs` (`id`, `user_id`, `point_log_id`, `reference_id`, `reference_type`, `amount`, `expired_at`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 0, 0, '', 10000, '2016-02-24 07:08:46', 'Welcome Gift dari BALIN', '2015-11-24 00:08:46', '2015-11-24 00:08:46', NULL),
(2, 7, 0, 0, '', 10000, '2016-02-24 07:11:18', 'Welcome Gift dari BALIN', '2015-11-24 00:11:18', '2015-11-24 00:11:18', NULL),
(3, 6, 0, 0, '', 10000, '2016-02-24 07:11:39', 'Welcome Gift dari BALIN', '2015-11-24 00:11:39', '2015-11-24 00:11:39', NULL),
(4, 5, 0, 4, 'App\\Models\\User', 50000, '2016-02-24 07:14:13', 'Direferensikan Gopego Fans Balin', '2015-11-24 00:14:13', '2015-11-24 00:14:13', NULL),
(5, 4, 0, 4, 'App\\Models\\PointLog', 10000, '2016-02-24 07:14:13', 'Mereferensikan Chelsy Mooy', '2015-11-24 00:14:13', '2015-11-24 00:14:13', NULL),
(6, 6, 0, 4, 'App\\Models\\User', 50000, '2016-02-24 07:14:41', 'Direferensikan Gopego Fans Balin', '2015-11-24 00:14:41', '2015-11-24 00:14:41', NULL),
(7, 4, 0, 6, 'App\\Models\\PointLog', 10000, '2016-02-24 07:14:41', 'Mereferensikan Budi Purnomo', '2015-11-24 00:14:41', '2015-11-24 00:14:41', NULL),
(8, 4, 0, 1, 'App\\Models\\User', 50000, '2016-02-24 07:15:10', 'Direferensikan BALIN', '2015-11-24 00:15:10', '2015-11-24 00:15:10', NULL),
(9, 1, 0, 8, 'App\\Models\\PointLog', 10000, '2016-02-24 07:15:10', 'Mereferensikan Gopego Fans Balin', '2015-11-24 00:15:10', '2015-11-24 00:15:10', NULL),
(10, 6, 3, 9, 'App\\Models\\Transaction', -10000, '2016-02-24 07:11:39', 'Pembayaran Belanja #s1511240001', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(11, 6, 6, 9, 'App\\Models\\Transaction', -50000, '2016-02-24 07:14:41', 'Pembayaran Belanja #s1511240001', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(12, 7, 2, 11, 'App\\Models\\Transaction', -10000, '2016-02-24 07:11:18', 'Pembayaran Belanja #s1511240003', '2015-11-24 00:24:24', '2015-11-24 00:24:24', NULL),
(13, 5, 1, 12, 'App\\Models\\Transaction', -10000, '2016-02-24 07:08:46', 'Pembayaran Belanja #s1511240004', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(14, 5, 4, 12, 'App\\Models\\Transaction', -50000, '2016-02-24 07:14:13', 'Pembayaran Belanja #s1511240004', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(15, 6, 10, 9, 'App\\Models\\Transaction', 10000, '2016-02-24 07:11:39', 'Revert Belanja #s1511240001', '2015-11-24 00:28:49', '2015-11-24 00:28:49', NULL),
(16, 6, 11, 9, 'App\\Models\\Transaction', 50000, '2016-02-24 07:14:41', 'Revert Belanja #s1511240001', '2015-11-24 00:28:49', '2015-11-24 00:28:49', NULL),
(17, 6, 15, 13, 'App\\Models\\Transaction', -10000, '2016-02-24 07:11:39', 'Pembayaran Belanja #s1511240005', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL),
(18, 6, 16, 13, 'App\\Models\\Transaction', -50000, '2016-02-24 07:14:41', 'Pembayaran Belanja #s1511240005', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL),
(19, 4, 0, 13, 'App\\Models\\Transaction', 10000, '2016-02-24 07:30:02', 'Bonus belanja Budi Purnomo', '2015-11-24 00:31:35', '2015-11-24 00:31:35', NULL),
(20, 4, 0, 12, 'App\\Models\\Transaction', 10000, '2016-02-24 07:27:07', 'Bonus belanja Chelsy Mooy', '2015-11-24 00:32:30', '2015-11-24 00:32:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `price` double NOT NULL,
  `promo_price` double NOT NULL,
  `started_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prices_deleted_at_product_id_started_at_index` (`deleted_at`,`product_id`,`started_at`),
  KEY `prices_product_id_index` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `product_id`, `price`, `promo_price`, `started_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 299000, 249000, '2015-11-24 06:17:33', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(2, 2, 299000, 249000, '2015-11-24 06:17:34', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(3, 3, 299000, 249000, '2015-11-24 06:17:35', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(4, 4, 299000, 249000, '2015-11-24 06:17:36', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(5, 5, 299000, 249000, '2015-11-24 06:17:36', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(6, 6, 299000, 249000, '2015-11-24 06:17:37', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(7, 7, 299000, 249000, '2015-11-24 06:17:38', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(8, 8, 299000, 249000, '2015-11-24 06:17:38', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(9, 9, 299000, 249000, '2015-11-24 06:17:39', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_upc_unique` (`upc`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_deleted_at_name_slug_index` (`deleted_at`,`name`,`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `upc`, `slug`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hem Batik Semi Sutera', '63453845', 'hem-batik-semi-sutera', '{"description":"Tambah koleksi gaya modern preppy dengan kemeja classy dari Waskito. Hem Batik Semi Sutera tampil berbeda melalui detail dual tone dan motif batik print pilihan.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(2, 'Abstract Pattern Mixed Kawung Slimfit Shirt', '14320211', 'abstract-pattern-mixed-kawung-slimfit-shirt', '{"description":"Stay fabulous with Bateeq. Abstract Pattern Mixed Kawung Slimfit Shirt memadukan motif batik dengan desain klasik serta warna tegas. Koleksi yang siap menemani acara-acara spesial.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(3, 'Hem Batik Cumikan Pelangi', '84064433', 'hem-batik-cumikan-pelangi', '{"description":"Tetap terlihat modern dengan koleksi kemeja batik klasik dari Arjuna Weda. Hem Batik Cumikan Pelangi hadir dengan desain simpel serta kombinasi motif batik print khas nusantara. Pilihan tepat untuk momen spesial.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(4, 'Hem Batik Ikan Moorish', '23746208', 'hem-batik-ikan-moorish', '{"description":"Koleksi kemeja batik yang terkesan kuno dihadirkan lebih modern dan dinamis pada koleksi Arjuna Weda. Hem Batik Ikan Moorish menghadirkan batik print kontemporer dalam nuansa warna cool tone.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(5, 'Hem Pendek Motif Mina Ginaris', '03922518', 'hem-pendek-motif-mina-ginaris', '{"description":"Etnik dan maskulin dengan koleksi batik dari Danar Hadi. Hem Pendek Motif Mina Ginaris memadukan motif batik modern dan nuansa kontras pada hem line. Koleksi yang tepat digunakan saat momen spesial.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(6, 'Hem Pdk Pa Koi Nandang Roso 53', '76993121', 'hem-pdk-pa-koi-nandang-roso-53', '{"description":"Tambah koleksi batik dengan keluaran terbaru dari BATIK SEMAR. Hem Pdk Sekar Jamur 20 hadir dengan kombinasi desain klasik dan motif batik print dalam pilihan warna gelap. Effortlessly masculine!","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(7, 'Hem Pdk Pa Sekar Jamur 20', '84368764', 'hem-pdk-pa-sekar-jamur-20', '{"description":"Tambah koleksi batik dengan keluaran terbaru dari BATIK SEMAR. Hem Pdk Pa Koi Nandang Roso 53 hadir dengan kombinasi desain klasik dan motif batik print dalam pilihan warna solid. Effortlessly masculine!","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(8, 'Hem Pdk Ctn Silk Sisik Manggar ', '08025069', 'hem-pdk-ctn-silk-sisik-manggar', '{"description":"Tampil effortless stylish dengan koleksi BATIK SEMAR. Hem Pdk Ctn Silk Sisik Manggar Asri 53 menghadirkan kesan maskulin lewat potongan klasik dan motif batik yang modern. Simply fit for your special occasion.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(9, 'Hem Pendek Pa Sekar Jagat ', '03588509', 'hem-pendek-pa-sekar-jagat', '{"description":"Kemeja batik print dari BATIK SEMAR. Hem Pendek Pa Sekar Jagat Plataran menampilkan kombinasi warna classy dan potongan timeless straight.","fit":"<img src=\\"http:\\/\\/www.shirtdetective.com\\/wp-content\\/uploads\\/2014\\/04\\/marks-spencer-shirt-size.jpg\\" class=\\"img-responsive\\" <\\/img>"}', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_lables`
--

CREATE TABLE IF NOT EXISTS `product_lables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `lable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `started_at` datetime NOT NULL,
  `ended_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_lables_deleted_at_lable_started_at_index` (`deleted_at`,`lable`,`started_at`),
  KEY `product_lables_product_id_index` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `product_lables`
--

INSERT INTO `product_lables` (`id`, `product_id`, `lable`, `value`, `started_at`, `ended_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'hot item', '{"class":"tag-label","color":"red"}', '2015-11-24 06:17:31', '0000-00-00 00:00:00', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(2, 1, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:31', '0000-00-00 00:00:00', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(3, 2, 'new item', '{"class":"square-label","color":"red"}', '2015-11-24 06:17:32', '0000-00-00 00:00:00', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(4, 2, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:32', '0000-00-00 00:00:00', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(5, 3, 'best seller', '{"class":"square-label","color":"red"}', '2015-11-24 06:17:33', '0000-00-00 00:00:00', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(6, 3, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:33', '0000-00-00 00:00:00', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(7, 4, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:34', '0000-00-00 00:00:00', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(8, 4, 'hot item', '{"class":"tag-label","color":"red"}', '2015-11-24 06:17:34', '0000-00-00 00:00:00', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(9, 5, 'new item', '{"class":"square-label","color":"red"}', '2015-11-24 06:17:34', '0000-00-00 00:00:00', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(10, 6, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:35', '0000-00-00 00:00:00', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(11, 7, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:36', '0000-00-00 00:00:00', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL),
(12, 9, 'hot item', '{"class":"tag-label","color":"red"}', '2015-11-24 06:17:37', '0000-00-00 00:00:00', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(13, 9, 'sale', '{"class":"circle-label","color":"red"}', '2015-11-24 06:17:37', '0000-00-00 00:00:00', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quota_logs`
--

CREATE TABLE IF NOT EXISTS `quota_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voucher_id` int(10) unsigned NOT NULL,
  `amount` double NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quota_logs_voucher_id_index` (`voucher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `quota_logs`
--

INSERT INTO `quota_logs` (`id`, `voucher_id`, `amount`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 10, 'Hadiah registrasi', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(2, 2, 10, 'Hadiah registrasi', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(3, 3, 10, 'Hadiah registrasi', '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(4, 4, 10, 'Hadiah registrasi', '2015-11-23 23:43:51', '2015-11-23 23:43:51', NULL),
(5, 5, 10, 'Hadiah registrasi', '2015-11-23 23:44:26', '2015-11-23 23:44:26', NULL),
(6, 6, 10, 'Hadiah registrasi', '2015-11-23 23:44:53', '2015-11-23 23:44:53', NULL),
(7, 7, 10, 'Hadiah registrasi', '2015-11-23 23:45:16', '2015-11-23 23:45:16', NULL),
(8, 8, 10, 'Premier Free Ongkir', '2015-11-23 23:52:59', '2015-11-23 23:52:59', NULL),
(9, 4, -1, 'Mereferensikan Chelsy Mooy', '2015-11-24 00:14:13', '2015-11-24 00:14:13', NULL),
(10, 4, -1, 'Mereferensikan Budi Purnomo', '2015-11-24 00:14:41', '2015-11-24 00:14:41', NULL),
(11, 1, -1, 'Mereferensikan Gopego Fans Balin', '2015-11-24 00:15:10', '2015-11-24 00:15:10', NULL),
(12, 8, -1, 'Penggunaan voucher untuk transaksi #s1511240001', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(13, 8, -1, 'Penggunaan voucher untuk transaksi #s1511240004', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(14, 8, -1, 'Penggunaan voucher untuk transaksi #s1511240005', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL),
(15, 4, 1, 'Bonus belanja Budi Purnomo nomor nota #s1511240005', '2015-11-24 00:31:35', '2015-11-24 00:31:35', NULL),
(16, 4, 1, 'Bonus belanja Chelsy Mooy nomor nota #s1511240004', '2015-11-24 00:32:30', '2015-11-24 00:32:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE IF NOT EXISTS `shipments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courier_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `address_id` int(10) unsigned NOT NULL,
  `receipt_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipments_deleted_at_transaction_id_address_id_index` (`deleted_at`,`transaction_id`,`address_id`),
  KEY `shipments_courier_id_index` (`courier_id`),
  KEY `shipments_transaction_id_index` (`transaction_id`),
  KEY `shipments_address_id_index` (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `courier_id`, `transaction_id`, `address_id`, `receipt_number`, `receiver_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 9, 9, NULL, 'Budi Purnomo', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(2, 1, 11, 10, NULL, 'Agil Mahendra', '2015-11-24 00:24:23', '2015-11-24 00:24:23', NULL),
(3, 1, 12, 11, NULL, 'Chelsy Mooy', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(4, 1, 13, 12, '123456789', 'Budi Purnomo', '2015-11-24 00:30:02', '2015-11-24 00:33:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_logs`
--

CREATE TABLE IF NOT EXISTS `shipment_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` int(10) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `changed_at` datetime NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_logs_deleted_at_changed_at_status_index` (`deleted_at`,`changed_at`,`status`),
  KEY `shipment_logs_shipment_id_index` (`shipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_costs`
--

CREATE TABLE IF NOT EXISTS `shipping_costs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `courier_id` int(10) unsigned NOT NULL,
  `start_postal_code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `end_postal_code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cost` double NOT NULL,
  `started_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_costs_deleted_at_started_at_start_postal_code_index` (`deleted_at`,`started_at`,`start_postal_code`),
  KEY `shipping_costs_courier_id_index` (`courier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shipping_costs`
--

INSERT INTO `shipping_costs` (`id`, `courier_id`, `start_postal_code`, `end_postal_code`, `cost`, `started_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '60000', '70000', 20000, '2015-11-24 06:19:38', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(2, 2, '60000', '70000', 20000, '2015-11-24 06:20:38', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Arjuna Weda', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(2, 'Bateeq', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(3, 'Batik Semar', '2015-11-23 23:17:37', '2015-11-23 23:17:37', NULL),
(4, 'Balin Tailor', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(5, 'Balin Supplier Chain', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL),
(6, 'Pak Suprapto', '2015-11-23 23:17:38', '2015-11-23 23:17:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_store_settings`
--

CREATE TABLE IF NOT EXISTS `tmp_store_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `started_at` datetime NOT NULL,
  `ended_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tmp_store_settings_deleted_at_type_started_at_index` (`deleted_at`,`type`,`started_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `tmp_store_settings`
--

INSERT INTO `tmp_store_settings` (`id`, `type`, `value`, `started_at`, `ended_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'url', 'http://balin.id', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(2, 'logo', 'http://balin.id/logo.png', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(3, 'facebook_url', 'http://www.facebook.com/balin.id', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(4, 'twitter_url', 'http://www.twitter.com/balin.id', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(5, 'email', 'cs@balin.id', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(6, 'phone', '0888 8888 8888', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(7, 'address', 'Ruko Puri Niaga A10 - Araya Kota Malang', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(8, 'about_us', '<h1>About Us</h1><br/>\n														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget mauris a arcu maximus malesuada ultrices iaculis ipsum. Curabitur consectetur, sem non rhoncus vulputate, nibh ex iaculis sem, a fermentum purus metus ut diam. Nulla suscipit magna vel fermentum dictum. Pellentesque interdum blandit purus, vitae tempor risus molestie quis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas volutpat nisl a luctus fermentum. Duis purus tellus, facilisis in nisi quis, condimentum consectetur ipsum. Integer neque felis, mollis at molestie ac, sagittis eu urna. Nulla hendrerit facilisis porttitor. Vestibulum vel ultrices eros. Duis auctor quam quis sem porta, id dictum libero finibus. Aenean ut fringilla est, at lacinia tellus. Sed pharetra felis et velit eleifend, et consectetur nibh placerat. Vestibulum in volutpat est.</p>\n														<p>Pellentesque rhoncus magna nec porttitor hendrerit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vulputate, magna eget tristique pellentesque, lorem justo efficitur nisl, at gravida risus diam quis nisl. Phasellus eros massa, ornare non accumsan at, mattis ut velit. Fusce sed tortor sit amet augue rhoncus sodales. Sed a ante non velit interdum vehicula ac sit amet elit. Curabitur eu sagittis massa. Pellentesque eget molestie mi, ut scelerisque diam. Phasellus commodo egestas sem sit amet euismod. Proin vulputate consectetur suscipit. </p>', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(9, 'why_join', '<h1>Why Join</h1><br/>\n														<p>Pellentesque quis sagittis mi, ac tempus nulla. Cras ut enim ut neque hendrerit faucibus. Praesent fringilla dignissim augue quis faucibus. Curabitur dapibus nulla maximus elementum volutpat. Nam faucibus tristique hendrerit. Nulla facilisi. Vivamus nisl nibh, blandit malesuada egestas ut, congue at enim. Proin non semper velit. Vivamus sit amet aliquam velit, eget pretium lectus. Nullam aliquet dignissim mauris a semper. Fusce sollicitudin hendrerit convallis. Sed sed posuere justo. Proin eleifend nisl vel urna sagittis euismod. Pellentesque consequat elementum est, vehicula vestibulum magna. Pellentesque commodo ultrices iaculis.</p>\n														<p>Donec ut volutpat mi. Donec blandit, metus congue lobortis laoreet, tortor mauris varius urna, sed imperdiet arcu urna non elit. Suspendisse consequat dapibus sapien id sollicitudin. Nam id lacus nec mi malesuada luctus. Vestibulum aliquet sapien nec est dapibus, in lobortis nunc accumsan. Sed congue accumsan urna in maximus. Nunc lorem nulla, fringilla ac blandit quis, euismod posuere tortor. Donec ut congue tellus. Nunc tempus maximus arcu ac euismod. Maecenas tempus varius leo, egestas interdum lectus vestibulum at. Ut placerat consequat nisl in luctus. Nullam congue, quam quis malesuada tempus, eros nulla sagittis nulla, ut porttitor orci purus scelerisque erat. Mauris euismod est convallis scelerisque ultricies. Aenean eget velit tellus.</p>', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(10, 'term_and_condition', '<h1>Term and Condition</h1><br/>\n														<p>Aliquam sit amet lectus aliquet, tincidunt lectus pulvinar, iaculis ligula. Pellentesque malesuada mi nec urna tincidunt, in suscipit leo varius. Vivamus ac velit ultrices, mattis mauris a, pellentesque lacus. Sed consequat lorem et condimentum varius. Sed orci nisi, dictum sed lorem sed, accumsan pharetra nisl. Pellentesque viverra lacus id vestibulum elementum. Cras rutrum ex sed neque varius, ac elementum nulla blandit. Nullam vel vestibulum urna.</p>\n														<p>Vivamus ultricies eleifend aliquet. Sed vel arcu vel mi feugiat dictum. Integer eget sem augue. Pellentesque sit amet lorem vulputate, congue turpis non, dignissim leo. Nullam mattis erat tortor, a lobortis lectus accumsan imperdiet. Cras sit amet pretium velit, id eleifend lorem. Phasellus leo neque, sollicitudin ac nisi et, rhoncus pretium metus. </p>', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(11, 'bank_information', '<p>BCA</p>\n														<p>No.Rek 088 88 88</p>\n														<p>A.N. BALINDOTID</p>\n														', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(12, 'slider', '{"title":{"title_active":"1","slider_title_location":"Top-Left","slider_title":"PRODUK TERLARIS KAMI"},"content":{"content_active":"1","slider_content_location":"Center-Left","slider_content":"BERSERAT RAPAT <br>DAN TIDAK MUDAH PANAS"},"button":{"button_active":"1","slider_button_location":"Bottom-Left","slider_button":"TAMBAHKAN DIKERANJANG","slider_button_url":"http:\\/\\/localhost:8000\\/products"}}', '2015-11-24 06:57:00', '2016-11-24 06:17:00', '2015-11-23 23:17:26', '2015-11-24 00:09:56', NULL),
(13, 'slider', '{"title":{"title_active":"1","slider_title_location":"Top-Right","slider_title":"PRODUK BATIK UNGGULAN"},"content":{"content_active":"1","slider_content_location":"Center-Right","slider_content":"BATIK BERKUALITAS BAGUS"},"button":{"button_active":"1","slider_button_location":"Bottom-Right","slider_button":"LIHAT PRODUK KAMI","slider_button_url":"http:\\/\\/localhost:8000\\/products"}}', '2015-11-24 07:01:00', '2016-11-24 06:17:00', '2015-11-23 23:17:26', '2015-11-24 00:10:03', NULL),
(14, 'slider', '{"title":{"title_active":"1","slider_title_location":"Top-Left","slider_title":"BATIK TULIS"},"content":{"content_active":"1","slider_content_location":"Center-Left","slider_content":"DESAIN SIMPLE...<br>MINIMALIS...ELEGAN..."},"button":{"button_active":"1","slider_button_location":"Bottom-Left","slider_button":"BATIK PREMIUM","slider_button_url":"http:\\/\\/localhost:8000\\/products"}}', '2015-11-24 06:17:00', '2016-11-24 06:17:00', '2015-11-23 23:17:26', '2015-11-24 00:09:45', NULL),
(15, 'expired_cart', ' + 1 day', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(16, 'expired_paid', ' - 2 days', '2015-11-23 06:17:26', NULL, '2015-11-23 23:17:26', '2015-11-23 23:17:26', NULL),
(17, 'expired_shipped', '+ 5 days', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(18, 'expired_point', '+ 1 year', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(19, 'referral_royalty', '10000', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(20, 'invitation_royalty', '50000', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(21, 'limit_unique_number', '100', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(22, 'expired_link_duration', '+ 2 hours', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(23, 'first_quota', '10', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(24, 'downline_purchase_bonus', '10000', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(25, 'downline_purchase_bonus_expired', ' + 3 months', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(26, 'downline_purchase_quota_bonus', '1', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(27, 'voucher_point_expired', '+ 3 months', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(28, 'welcome_gift', '10000', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(29, 'critical_stock', '2', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL),
(30, 'min_margin', '50000', '2015-11-23 06:17:27', NULL, '2015-11-23 23:17:27', '2015-11-23 23:17:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_vouchers`
--

CREATE TABLE IF NOT EXISTS `tmp_vouchers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tmp_vouchers_deleted_at_code_started_at_index` (`deleted_at`,`code`,`started_at`),
  KEY `tmp_vouchers_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tmp_vouchers`
--

INSERT INTO `tmp_vouchers` (`id`, `user_id`, `code`, `type`, `value`, `started_at`, `expired_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'balbal5u', 'referral', '0', NULL, NULL, '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(2, 2, 'stastau0', 'referral', '0', NULL, NULL, '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(3, 3, 'manmancy', 'referral', '0', NULL, NULL, '2015-11-23 23:17:28', '2015-11-23 23:17:28', NULL),
(4, 4, 'gopbalpa', 'referral', '0', NULL, NULL, '2015-11-23 23:43:51', '2015-11-23 23:43:51', NULL),
(5, 5, 'chemooqg', 'referral', '0', NULL, NULL, '2015-11-23 23:44:26', '2015-11-23 23:44:26', NULL),
(6, 6, 'budpurjt', 'referral', '0', NULL, NULL, '2015-11-23 23:44:53', '2015-11-23 23:44:53', NULL),
(7, 7, 'agimahat', 'referral', '0', NULL, NULL, '2015-11-23 23:45:16', '2015-11-23 23:45:16', NULL),
(8, NULL, 'premier1', 'free_shipping_cost', '0', '2015-11-24 00:00:00', '2015-11-25 00:00:00', '2015-11-23 23:47:57', '2015-11-23 23:47:57', NULL),
(9, NULL, 'balinhoho', 'free_shipping_cost', '0', '2015-12-24 00:00:00', '2015-12-26 00:00:00', '2015-11-23 23:49:26', '2015-11-23 23:49:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL,
  `voucher_id` int(10) unsigned NOT NULL,
  `ref_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('sell','buy') COLLATE utf8_unicode_ci NOT NULL,
  `transact_at` datetime NOT NULL,
  `unique_number` int(11) NOT NULL,
  `shipping_cost` double NOT NULL,
  `voucher_discount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_deleted_at_type_user_id_index` (`deleted_at`,`type`,`user_id`),
  KEY `transactions_deleted_at_type_transact_at_index` (`deleted_at`,`type`,`transact_at`),
  KEY `transactions_user_id_index` (`user_id`),
  KEY `transactions_supplier_id_index` (`supplier_id`),
  KEY `transactions_voucher_id_index` (`voucher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `supplier_id`, `voucher_id`, `ref_number`, `type`, `transact_at`, `unique_number`, `shipping_cost`, `voucher_discount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 2, 0, 'b1511240001', 'buy', '2015-11-24 06:25:00', 0, 0, 0, '2015-11-23 23:25:00', '2015-11-23 23:25:00', NULL),
(2, 0, 1, 0, 'b1511240002', 'buy', '2015-11-24 06:26:40', 0, 0, 0, '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(3, 0, 1, 0, 'b1511240003', 'buy', '2015-11-24 06:27:45', 0, 0, 0, '2015-11-23 23:27:45', '2015-11-23 23:27:45', NULL),
(4, 0, 1, 0, 'b1511240004', 'buy', '2015-11-24 06:28:19', 0, 0, 0, '2015-11-23 23:28:19', '2015-11-23 23:28:19', NULL),
(5, 0, 3, 0, 'b1511240005', 'buy', '2015-11-24 06:31:30', 0, 0, 0, '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(6, 0, 2, 0, 'b1511240006', 'buy', '2015-11-24 06:32:01', 0, 0, 0, '2015-11-23 23:32:01', '2015-11-23 23:32:01', NULL),
(7, 0, 4, 0, 'b1511240007', 'buy', '2015-11-24 06:33:14', 0, 0, 0, '2015-11-23 23:33:14', '2015-11-23 23:33:14', NULL),
(8, 0, 4, 0, 'b1511240008', 'buy', '2015-11-24 06:33:47', 0, 0, 0, '2015-11-23 23:33:47', '2015-11-23 23:33:47', NULL),
(9, 6, 0, 8, 's1511240001', 'sell', '2015-11-22 07:19:47', 1, 20000, 20000, '2015-11-24 00:16:53', '2015-11-24 00:19:47', NULL),
(10, 7, 0, 0, 's1511240002', 'sell', '2015-11-24 07:21:52', 2, 0, 0, '2015-11-24 00:21:52', '2015-11-24 00:21:52', NULL),
(11, 7, 0, 0, 's1511240003', 'sell', '2015-11-22 07:24:23', 2, 20000, 0, '2015-11-24 00:22:39', '2015-11-24 00:24:23', NULL),
(12, 5, 0, 8, 's1511240004', 'sell', '2015-11-24 07:27:07', 3, 20000, 20000, '2015-11-24 00:25:33', '2015-11-24 00:27:07', NULL),
(13, 6, 0, 8, 's1511240005', 'sell', '2015-11-24 07:30:02', 4, 20000, 20000, '2015-11-24 00:29:37', '2015-11-24 00:30:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `varian_id` int(10) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_deleted_at_varian_id_transaction_id_index` (`deleted_at`,`varian_id`,`transaction_id`),
  KEY `transaction_details_transaction_id_index` (`transaction_id`),
  KEY `transaction_details_varian_id_index` (`varian_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `varian_id`, `quantity`, `price`, `discount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 17, 5, 149000, 0, '2015-11-23 23:25:00', '2015-11-23 23:25:00', NULL),
(2, 1, 16, 5, 149000, 0, '2015-11-23 23:25:00', '2015-11-23 23:25:00', NULL),
(3, 2, 1, 3, 149000, 0, '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(4, 2, 2, 4, 149000, 0, '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(5, 2, 4, 3, 149000, 0, '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(6, 2, 5, 3, 149000, 0, '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(7, 3, 7, 4, 189000, 50000, '2015-11-23 23:27:45', '2015-11-23 23:27:45', NULL),
(8, 3, 8, 4, 189000, 50000, '2015-11-23 23:27:45', '2015-11-23 23:27:45', NULL),
(9, 4, 9, 3, 149000, 0, '2015-11-23 23:28:19', '2015-11-23 23:28:19', NULL),
(10, 5, 3, 3, 149000, 0, '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(11, 5, 13, 3, 149000, 0, '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(12, 5, 14, 3, 149000, 0, '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(13, 5, 15, 3, 149000, 0, '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(14, 6, 6, 3, 149000, 0, '2015-11-23 23:32:01', '2015-11-23 23:32:01', NULL),
(15, 7, 10, 1, 149000, 0, '2015-11-23 23:33:14', '2015-11-23 23:33:14', NULL),
(16, 7, 12, 5, 169000, 50000, '2015-11-23 23:33:14', '2015-11-23 23:33:14', NULL),
(17, 8, 10, 2, 149000, 0, '2015-11-23 23:33:47', '2015-11-23 23:33:47', NULL),
(18, 9, 5, 1, 249000, 50000, '2015-11-24 00:16:53', '2015-11-24 00:16:53', NULL),
(19, 10, 7, 1, 249000, 50000, '2015-11-24 00:21:52', '2015-11-24 00:21:52', NULL),
(20, 10, 10, 1, 249000, 50000, '2015-11-24 00:21:55', '2015-11-24 00:21:55', NULL),
(21, 11, 1, 1, 249000, 50000, '2015-11-24 00:22:39', '2015-11-24 00:23:40', '2015-11-24 00:23:40'),
(22, 11, 2, 0, 249000, 50000, '2015-11-24 00:22:39', '2015-11-24 00:23:49', '2015-11-24 00:23:49'),
(23, 11, 3, 0, 249000, 50000, '2015-11-24 00:22:40', '2015-11-24 00:23:52', '2015-11-24 00:23:52'),
(24, 11, 1, 1, 249000, 50000, '2015-11-24 00:23:59', '2015-11-24 00:23:59', NULL),
(25, 12, 12, 2, 249000, 50000, '2015-11-24 00:25:33', '2015-11-24 00:25:33', NULL),
(26, 12, 1, 1, 249000, 50000, '2015-11-24 00:25:33', '2015-11-24 00:25:53', '2015-11-24 00:25:53'),
(27, 12, 2, 1, 249000, 50000, '2015-11-24 00:25:33', '2015-11-24 00:25:57', '2015-11-24 00:25:57'),
(28, 12, 3, 0, 249000, 50000, '2015-11-24 00:25:33', '2015-11-24 00:26:04', '2015-11-24 00:26:04'),
(29, 13, 5, 1, 249000, 50000, '2015-11-24 00:29:37', '2015-11-24 00:29:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE IF NOT EXISTS `transaction_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `changed_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_logs_deleted_at_changed_at_status_index` (`deleted_at`,`changed_at`,`status`),
  KEY `transaction_logs_transaction_id_index` (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `transaction_id`, `status`, `changed_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'delivered', '2015-11-24 06:25:00', '2015-11-23 23:25:00', '2015-11-23 23:25:00', NULL),
(2, 2, 'delivered', '2015-11-24 06:26:40', '2015-11-23 23:26:40', '2015-11-23 23:26:40', NULL),
(3, 3, 'delivered', '2015-11-24 06:27:45', '2015-11-23 23:27:45', '2015-11-23 23:27:45', NULL),
(4, 4, 'delivered', '2015-11-24 06:28:19', '2015-11-23 23:28:19', '2015-11-23 23:28:19', NULL),
(5, 5, 'delivered', '2015-11-24 06:31:30', '2015-11-23 23:31:30', '2015-11-23 23:31:30', NULL),
(6, 6, 'delivered', '2015-11-24 06:32:01', '2015-11-23 23:32:01', '2015-11-23 23:32:01', NULL),
(7, 7, 'delivered', '2015-11-24 06:33:14', '2015-11-23 23:33:14', '2015-11-23 23:33:14', NULL),
(8, 8, 'delivered', '2015-11-24 06:33:47', '2015-11-23 23:33:47', '2015-11-23 23:33:47', NULL),
(9, 9, 'cart', '2015-11-24 07:16:53', '2015-11-24 00:16:53', '2015-11-24 00:16:53', NULL),
(10, 9, 'wait', '2015-11-24 07:19:47', '2015-11-24 00:19:47', '2015-11-24 00:19:47', NULL),
(11, 10, 'cart', '2015-11-24 07:21:52', '2015-11-24 00:21:52', '2015-11-24 00:21:52', NULL),
(12, 11, 'cart', '2015-11-24 07:22:39', '2015-11-24 00:22:39', '2015-11-24 00:22:39', NULL),
(13, 10, 'abandoned', '2015-11-24 07:22:39', '2015-11-24 00:22:39', '2015-11-24 00:22:39', NULL),
(14, 11, 'wait', '2015-11-24 07:24:23', '2015-11-24 00:24:23', '2015-11-24 00:24:23', NULL),
(15, 12, 'cart', '2015-11-24 07:25:33', '2015-11-24 00:25:33', '2015-11-24 00:25:33', NULL),
(16, 12, 'wait', '2015-11-24 07:27:07', '2015-11-24 00:27:07', '2015-11-24 00:27:07', NULL),
(17, 9, 'canceled', '2015-11-24 07:28:49', '2015-11-24 00:28:49', '2015-11-24 00:28:49', NULL),
(18, 13, 'cart', '2015-11-24 07:29:37', '2015-11-24 00:29:37', '2015-11-24 00:29:37', NULL),
(19, 13, 'wait', '2015-11-24 07:30:02', '2015-11-24 00:30:02', '2015-11-24 00:30:02', NULL),
(20, 13, 'paid', '2015-11-24 07:31:35', '2015-11-24 00:31:35', '2015-11-24 00:31:35', NULL),
(21, 12, 'paid', '2015-11-24 07:32:30', '2015-11-24 00:32:30', '2015-11-24 00:32:30', NULL),
(22, 13, 'shipping', '2015-11-24 07:33:28', '2015-11-24 00:33:28', '2015-11-24 00:33:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `sso_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sso_media` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sso_data` text COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `activation_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reset_password_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` datetime DEFAULT NULL,
  `last_logged_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_deleted_at_email_index` (`deleted_at`,`email`),
  KEY `users_deleted_at_name_index` (`deleted_at`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `sso_id`, `sso_media`, `sso_data`, `gender`, `date_of_birth`, `activation_link`, `reset_password_link`, `expired_at`, `last_logged_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BALIN', 'cs@balin.id', '$2y$10$TyTKDFWf43/rkVMLbkyr6OHs2H/JzoGFpDJt1R0rb.blUiJ3n.WgW', 'admin', 0, '', '', '', 'male', '0000-00-00', '0ca591dcc1352234f9b8de9c49568eb9', '', NULL, NULL, 'bgvtsAtkbAiCY3Ox9Lir2enugB28p9cphVxoR3dlbHwjc0wxuMTIAMTz6rrf', '2015-11-23 23:17:28', '2015-11-24 00:10:12', NULL),
(2, 'Staff', 'staff@balin.id', '$2y$10$04pJ3el.8aslzn2v2Vgwd.Sh8D3r8Zx6WHiLvluSh7yfF1NamJk4e', 'staff', 0, '', '', '', 'female', '0000-00-00', '64b02821282f70edece982ff228d650b', '', NULL, NULL, '6VJ7cRl50UazzXBCKC7B1FIORQhOmXdbG89TfdDrnepA7TsxVEb0Nyw7ySv0', '2015-11-23 23:17:28', '2015-11-24 00:34:18', NULL),
(3, 'Manager', 'manager@balin.id', '$2y$10$FkqODS0BxOX/8bB/54H/r.9h0cupWY6MuG9Ni91BFZXhbuj5LYAv6', 'store_manager', 0, '', '', '', 'female', '0000-00-00', '0373ab2cced1de3464ffde99715969ad', '', NULL, NULL, '1u7zQKBC85RygN784gXZDjh1uQwzP7i4WEYwBOkvZtdls4icAxOlkVI6Xs0J', '2015-11-23 23:17:28', '2015-11-24 00:08:49', NULL),
(4, 'Gopego Fans Balin', 'gopego550@gmail.com', '$2y$10$TyTKDFWf43/rkVMLbkyr6OHs2H/JzoGFpDJt1R0rb.blUiJ3n.WgW', 'customer', 0, '', '', '', 'male', '1995-05-05', '82b44f2593635d617748bce46c10f651', '', NULL, '2015-11-24 07:15:15', 'U7LgIlFgUaQUbMQOjzlSI2a5ttGqfjFbnWFpMlLboICgpo4C4G97m4nxeP2Z', '2015-11-23 23:43:51', '2015-11-24 00:15:15', NULL),
(5, 'Chelsy Mooy', 'chelsymooy1108@gmail.com', '$2y$10$TyTKDFWf43/rkVMLbkyr6OHs2H/JzoGFpDJt1R0rb.blUiJ3n.WgW', 'customer', 1, '', '', '', 'female', '1993-08-11', '', '', NULL, '2015-11-24 07:27:30', 'JPxiGaWeiB4jE6LS6vf0JHxcrpKr8oklAXKLLYasIofSSkYEkrZnuuEGcXlD', '2015-11-23 23:44:26', '2015-11-24 00:27:30', NULL),
(6, 'Budi Purnomo', 'budi-purnomo@outlook.com', '$2y$10$TyTKDFWf43/rkVMLbkyr6OHs2H/JzoGFpDJt1R0rb.blUiJ3n.WgW', 'customer', 1, '', '', '', 'male', '1992-06-22', '', '', NULL, '2015-11-24 07:30:20', 'RggVE4FQZ18nJC0XGYHAkxE3Qh3zUGTERQQXQSyFbqtkXYLbujt7zfvgL1gM', '2015-11-23 23:44:53', '2015-11-24 00:30:20', NULL),
(7, 'Agil Mahendra', 'agil.mahendra@gmail.com', '$2y$10$TyTKDFWf43/rkVMLbkyr6OHs2H/JzoGFpDJt1R0rb.blUiJ3n.WgW', 'customer', 1, '', '', '', 'male', '1990-11-22', '', '', NULL, '2015-11-24 07:24:52', 'qO2HdnBogXuJV7WBHMXJapkaPhYApi35gGsnFMQwg1Kngx8iCSnNREy3Aa0k', '2015-11-23 23:45:16', '2015-11-24 00:24:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `varians`
--

CREATE TABLE IF NOT EXISTS `varians` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `varians_deleted_at_product_id_index` (`deleted_at`,`product_id`),
  KEY `varians_product_id_index` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `varians`
--

INSERT INTO `varians` (`id`, `product_id`, `sku`, `size`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '6345384515', '15', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(2, 1, '6345384515.5', '15.5', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(3, 1, '6345384516', '16', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(4, 2, '1432021115', '15', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(5, 2, '1432021115.5', '15.5', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(6, 2, '1432021116', '16', '2015-11-23 23:17:31', '2015-11-23 23:17:31', NULL),
(7, 3, '8406443315', '15', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(8, 3, '8406443315.5', '15.5', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(9, 3, '8406443316', '16', '2015-11-23 23:17:32', '2015-11-23 23:17:32', NULL),
(10, 4, '2374620815', '15', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(11, 4, '2374620815.5', '15.5', '2015-11-23 23:17:33', '2015-11-23 23:17:33', NULL),
(12, 5, '0392251816', '16', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(13, 6, '7699312115', '15', '2015-11-23 23:17:34', '2015-11-23 23:17:34', NULL),
(14, 7, '8436876415', '15', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(15, 7, '8436876415.5', '15.5', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(16, 7, '8436876416', '16', '2015-11-23 23:17:35', '2015-11-23 23:17:35', NULL),
(17, 9, '0358850916', '16', '2015-11-23 23:17:36', '2015-11-23 23:17:36', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
