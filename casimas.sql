-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 4 月 22 日 13:47
-- サーバのバージョン： 10.4.17-MariaDB
-- PHP のバージョン: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `casimas`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `activations`
--

CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, '44jYPo3z3opH7V9TbQXzl0mjYk9GIAB9', 1, '2021-04-11 18:23:39', '2021-04-11 18:23:39', '2021-04-11 18:23:39'),
(2, 2, 'SU2381WeqQiq8G4TLUoPQ6SiSIjSCB4W', 1, '2021-04-14 00:26:23', '2021-04-14 00:26:23', '2021-04-14 00:26:23');

-- --------------------------------------------------------

--
-- テーブルの構造 `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_content` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `category`
--

INSERT INTO `category` (`category_id`, `category_content`) VALUES
(1, '[出品者身長]150cm~159cm'),
(2, '[出品者身長]160cm~169cm'),
(3, '[出品者身長]170cm~179cm'),
(4, 'other item');

-- --------------------------------------------------------

--
-- テーブルの構造 `item`
--

CREATE TABLE `item` (
  `item_id` int(128) NOT NULL,
  `seller_id` int(128) NOT NULL,
  `category_id` int(128) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_introductoin` text NOT NULL,
  `brand` varchar(200) NOT NULL,
  `purchase_judg` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `item`
--

INSERT INTO `item` (`item_id`, `seller_id`, `category_id`, `item_name`, `item_introductoin`, `brand`, `purchase_judg`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 1, 1, 'テスト', 'てすとてすと', 'テストテストテスト', 'false', '2021-04-17 00:34:29', '2021-04-17 00:34:29', 0),
(2, 1, 4, 'テスト2', 'てすとてすと2', 'テストテストテスト2', 'true', '2021-04-17 00:35:03', '2021-04-17 00:35:03', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `persistences`
--

CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 'lcWX7WAk6sM8HoIPBzwHFuN36w9OBnKO', '2021-04-11 18:25:35', '2021-04-11 18:25:35'),
(2, 1, 'BgMbpafLrSh6UYkggkwdFhYLTul9iI0F', '2021-04-11 19:06:02', '2021-04-11 19:06:02'),
(3, 1, 'Dx2hicIM87OmNxgACp2pk3RmKUk4eAq4', '2021-04-12 02:36:29', '2021-04-12 02:36:29'),
(4, 1, 'LzpU1lZKcj0dAeTYrWvAmqoQ4aGQQczw', '2021-04-12 03:02:20', '2021-04-12 03:02:20'),
(5, 1, 'Adaj3mpjU7fSdqGxr6Q6dqp2EjO06r7Y', '2021-04-12 06:33:51', '2021-04-12 06:33:51'),
(6, 1, 'AWZb1aC69soejDRkuS2qZwIyOk2QxVXn', '2021-04-13 20:07:36', '2021-04-13 20:07:36'),
(7, 2, 'VcEgK9Mgsn0vo5hbismwenEZz60lMPTl', '2021-04-14 00:29:00', '2021-04-14 00:29:00'),
(8, 1, 'QPZNXQ1Uzt1GNVo3VdKzYt05gWBijeVq', '2021-04-14 00:32:05', '2021-04-14 00:32:05'),
(9, 2, 'BjqDuCdvs0pAt9FDFTQlqb2lCSIhj6eT', '2021-04-14 00:32:35', '2021-04-14 00:32:35'),
(10, 2, 'AsAM1V9Xp80JnJjMsPyVsuj9id8LJQRz', '2021-04-14 00:34:01', '2021-04-14 00:34:01'),
(11, 1, 'S49W89OHY6loX3Cuo74laBlkVdcc5ZKl', '2021-04-14 00:34:30', '2021-04-14 00:34:30'),
(12, 1, 'H4w5atPsubCHJmbjeH9QEdUfp3YX146g', '2021-04-14 06:39:24', '2021-04-14 06:39:24'),
(13, 1, 'x21ZxElPhnfMW7GpzOVxxXo87IyQX27I', '2021-04-14 22:05:00', '2021-04-14 22:05:00'),
(14, 1, 'BXnsxX7bZ5eBPtJzAOxS9daxKFb240Oy', '2021-04-14 23:22:44', '2021-04-14 23:22:44'),
(15, 1, 's5Gu489M0AjC0Y67f0mwS7kE27F8mSl2', '2021-04-15 03:14:54', '2021-04-15 03:14:54'),
(16, 1, 'Ps0GmRvgNm7G3mYtQ4s3X1YlUEAFVJ8m', '2021-04-15 03:28:54', '2021-04-15 03:28:54'),
(17, 1, '6EOif1mmAAN29rnSH2gaLgNJ5r6npYKm', '2021-04-15 18:42:20', '2021-04-15 18:42:20'),
(18, 1, '3iz9KKlVkwh8Vx42eYjilczUMffJC1zf', '2021-04-15 18:46:24', '2021-04-15 18:46:24'),
(19, 1, 'xDyWhw0BROrytydfTmbrSOe6UG6x75Ka', '2021-04-15 18:47:29', '2021-04-15 18:47:29'),
(20, 1, '2VPdePBvglDewtQkYmTrOL7MWfem9veQ', '2021-04-15 18:48:48', '2021-04-15 18:48:48'),
(21, 1, 'n0vbz84WiQDIoT1VYGaSxBMlbkPVBa5y', '2021-04-15 18:49:51', '2021-04-15 18:49:51'),
(22, 1, 'UJN2nbwGdSdgVZF8XA8Sq5b1T7s6ON0z', '2021-04-16 02:09:25', '2021-04-16 02:09:25'),
(23, 1, 'eyeXBYdStQnCpyMKEqy2lY4BLqBtri3z', '2021-04-16 06:49:50', '2021-04-16 06:49:50'),
(24, 1, 'TVbLCIo7H5yT9TnMXR4id8OuBQuR5DRP', '2021-04-16 18:26:29', '2021-04-16 18:26:29'),
(25, 1, 'Ssjh2lYcZjWitYnmIAqlwQHsfpMaym8l', '2021-04-17 00:11:11', '2021-04-17 00:11:11'),
(26, 1, 'S6AFZq04ASVuVf5Oi66TeaWld5uth2Bg', '2021-04-17 01:37:37', '2021-04-17 01:37:37'),
(27, 1, 'sYo1a4U9PO06sTXNlPNzTXqXSzBGX92h', '2021-04-17 16:04:16', '2021-04-17 16:04:16'),
(28, 1, 'EwYjQaXOyIQpllHwW35aXWuiqJiRuvJy', '2021-04-17 16:45:53', '2021-04-17 16:45:53'),
(29, 1, '7xkzCA8jAGszAzfsohkBGSsrYN8zn8tf', '2021-04-19 02:07:21', '2021-04-19 02:07:21'),
(30, 1, 'LMM6DjGuzEOQyXpedqoGOSBixGsmwtzM', '2021-04-20 00:48:26', '2021-04-20 00:48:26'),
(31, 1, 'OBn5y9nci1fml6ykvo03fDdp1jl7umcd', '2021-04-20 02:17:53', '2021-04-20 02:17:53'),
(32, 1, 'b2PsfGPAGv3GRGnOnALa6ZVTGzV35BKV', '2021-04-21 00:58:31', '2021-04-21 00:58:31');

-- --------------------------------------------------------

--
-- テーブルの構造 `photo`
--

CREATE TABLE `photo` (
  `photo_id` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `photo1` varchar(128) NOT NULL,
  `photo2` varchar(128) DEFAULT NULL,
  `photo3` varchar(128) DEFAULT NULL,
  `photo4` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `photo`
--

INSERT INTO `photo` (`photo_id`, `item_id`, `photo1`, `photo2`, `photo3`, `photo4`) VALUES
(1, 1, 'item_img/20210416173429PkZ56coB71VnMIwY.jpg', NULL, NULL, NULL),
(2, 2, 'item_img/202104161735038D3z5FurOLxdfjB1.jpg', 'item_img/20210416173503hC1Xx2ioAzuN5OyI.jpg', 'item_img/20210416173503kNXbiCYQvK7ql6f8.jpg', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `price`
--

CREATE TABLE `price` (
  `price_id` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `price_1m` varchar(128) NOT NULL,
  `price_1w` varchar(128) NOT NULL,
  `price_purchase` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `price`
--

INSERT INTO `price` (`price_id`, `item_id`, `price_1m`, `price_1w`, `price_purchase`) VALUES
(1, 1, '456', '123', NULL),
(2, 2, '4567', '1234', '100000');

-- --------------------------------------------------------

--
-- テーブルの構造 `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `rental_state`
--

CREATE TABLE `rental_state` (
  `rental_state_id` int(12) NOT NULL,
  `userid` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `transaction_id` int(12) NOT NULL,
  `return_date` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `rental_state`
--

INSERT INTO `rental_state` (`rental_state_id`, `userid`, `item_id`, `transaction_id`, `return_date`) VALUES
(1, 1, 1, 1, '2021/04/28'),
(2, 1, 2, 2, '2021/04/28'),
(3, 1, 1, 3, '2021/05/21');

-- --------------------------------------------------------

--
-- テーブルの構造 `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `seller_info`
--

CREATE TABLE `seller_info` (
  `seller_id` int(100) NOT NULL,
  `bank` varchar(128) NOT NULL,
  `bank_branch` varchar(128) NOT NULL,
  `account_type` varchar(128) NOT NULL,
  `account_number` varchar(128) NOT NULL,
  `account_holder` varchar(128) NOT NULL,
  `height` varchar(128) NOT NULL,
  `sales` int(128) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `seller_info`
--

INSERT INTO `seller_info` (`seller_id`, `bank`, `bank_branch`, `account_type`, `account_number`, `account_holder`, `height`, `sales`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', '普通', '0000', 'testuser1', '177', NULL, '2021-04-12 10:23:39', '2021-04-12 10:23:39');

-- --------------------------------------------------------

--
-- テーブルの構造 `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(12) NOT NULL,
  `userid` int(12) NOT NULL,
  `seller_id` int(12) NOT NULL,
  `item_id` int(12) NOT NULL,
  `plan` varchar(128) NOT NULL,
  `transaction_price` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `userid`, `seller_id`, `item_id`, `plan`, `transaction_price`, `created_at`) VALUES
(1, 1, 1, 1, '1w', '123', '2021-04-21 18:44:20'),
(2, 1, 1, 2, '1w', '1234', '2021-04-21 19:07:23'),
(3, 1, 1, 1, '1m', '456', '2021-04-21 23:02:50');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'test@example.com', '$2y$10$e05mNsgW2PwGs1Ndrx1z8ehmRnEiNUA23zYEqiXcW43LcG40w0BOm', NULL, '2021-04-21 00:58:31', 'test', 'user1', '2021-04-11 18:23:39', '2021-04-21 00:58:31'),
(2, 'test2@example.com', '$2y$10$LteZMuyElvYaJe6WgZyQee.km/NgzAhfYAbFGZ/860iMFFBAVKU5S', NULL, '2021-04-14 00:34:01', 'test', 'user2', '2021-04-14 00:26:23', '2021-04-14 00:34:01');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_data`
--

CREATE TABLE `user_data` (
  `userid` int(10) NOT NULL,
  `gender` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `birthday` varchar(128) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `introduction` text NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `user_data`
--

INSERT INTO `user_data` (`userid`, `gender`, `address`, `phone`, `birthday`, `nickname`, `introduction`, `profile_img`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '男性', 'test-2-2-301', '12345678901', '1991年09月13日', 'テストテスト', 'てすとてすとてすと', 'user_img/20210421120633vBi5ocHPgNQMLy6u.png', '2021-04-12 10:23:39', '2021-04-12 10:23:39', 0),
(2, '女性', 'test', '123456', '1985年06月06日', 'testuser2', 'testtest', NULL, '2021-04-14 16:26:23', '2021-04-14 16:26:23', 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- テーブルのインデックス `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- テーブルのインデックス `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- テーブルのインデックス `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photo_id`);

--
-- テーブルのインデックス `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`price_id`);

--
-- テーブルのインデックス `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `rental_state`
--
ALTER TABLE `rental_state`
  ADD PRIMARY KEY (`rental_state_id`);

--
-- テーブルのインデックス `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- テーブルのインデックス `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- テーブルのインデックス `seller_info`
--
ALTER TABLE `seller_info`
  ADD PRIMARY KEY (`seller_id`);

--
-- テーブルのインデックス `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- テーブルのインデックス `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- テーブルのインデックス `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`userid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- テーブルの AUTO_INCREMENT `photo`
--
ALTER TABLE `photo`
  MODIFY `photo_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `price`
--
ALTER TABLE `price`
  MODIFY `price_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `rental_state`
--
ALTER TABLE `rental_state`
  MODIFY `rental_state_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `user_data`
--
ALTER TABLE `user_data`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
