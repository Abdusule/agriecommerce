-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 07:36 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', '$2y$10$ZuI83Qamwfb4y/wPjRYHo.EoLlfvC6J9qXU42y4k8M42QG3LiOcKS', '2023-09-07 05:26:37', '2023-09-07 05:26:37', 'admin'),
(2, 'Latimax4all@gmail.com', '$2y$10$0qp/oo5LB6lGbsr8.iY4Q.LOlJZfhgNKLseUK9x2oc8.RffCuonK.', '2024-11-23 21:59:54', '2024-11-23 22:07:16', 'subadmin');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Fruits', 'Different kinds of fruit items', 0, 'active', '2024-12-18 09:09:55', '2024-12-18 09:09:55'),
(14, 'Grains', 'Different kinds of grains items', 0, 'active', '2024-12-18 11:44:49', '2024-12-18 11:44:49'),
(15, 'Vegetables', 'Different kinds of vegetables items', 0, 'active', '2024-12-18 13:01:33', '2024-12-18 13:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`description`)),
  `address` text NOT NULL,
  `status` text NOT NULL DEFAULT 'Pending',
  `payment_proof_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(200) NOT NULL,
  `product_id` int(200) DEFAULT NULL,
  `quantity` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `quantity`, `user_id`, `invoice_id`, `order_date`, `status`) VALUES
(1, 4, 4, 3, NULL, '2024-12-19 11:44:13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `unit_of_measure` varchar(50) DEFAULT NULL,
  `quantity_in_stock` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `added_by` text NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `price`, `weight`, `unit_of_measure`, `quantity_in_stock`, `image_url`, `status`, `added_by`, `created_at`, `updated_at`) VALUES
(4, 'Mango', 'Mango', 12, 300.00, 12.00, 'pcs', 20, 'product-4.jpg', 'active', 'admin', '2024-12-18 14:44:04', '2024-12-18 14:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `smtp_user` text NOT NULL,
  `smtp_host` text NOT NULL,
  `smtp_password` text NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `site_name` text NOT NULL,
  `site_email` text NOT NULL,
  `livechat` text NOT NULL,
  `phone` text NOT NULL,
  `call_phone` text NOT NULL,
  `website` text NOT NULL,
  `address` text NOT NULL,
  `owner` text DEFAULT NULL,
  `account_name` text NOT NULL,
  `bank_name` text NOT NULL,
  `account_number` text NOT NULL,
  `shipping_fee` int(11) NOT NULL,
  `mail_register` text NOT NULL,
  `mail_password_reset` text NOT NULL,
  `mail_account_disabled` text NOT NULL,
  `mail_general` text NOT NULL,
  `theme` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `smtp_user`, `smtp_host`, `smtp_password`, `symbol`, `site_name`, `site_email`, `livechat`, `phone`, `call_phone`, `website`, `address`, `owner`, `account_name`, `bank_name`, `account_number`, `shipping_fee`, `mail_register`, `mail_password_reset`, `mail_account_disabled`, `mail_general`, `theme`) VALUES
(1, 'info@bukcomputing.com.ng', 'mail.bukcomputing.com.ng', '@bukcomputing.com.ng', '₦', 'Zamani-Agro', 'info@bukcomputing.com.ng', '', '+2349012345678', '+2349063883519', 'http://localhost/agricecommerce', '285 Fulton St, New York, NY 10007, USA', 'Mr Celebrity', 'United Bank of Nigeria', 'Zamani Agro Bank', '1234567890', 3000, '<h1>Welcome to Website</h1>\n\n<p>Hello, {{username}},</p>\n\n<p>Thank you for signing up for our service. We&#39;re thrilled to have you on board!</p>\n\n<p>Your account details are as follows:</p>\n\n<ul>\n	<li>Email: {{email}}</li>\n	<li>Username: {{username}}</li>\n</ul>\n\n<p>Click the button below to verify your account:</p>\n\n<p><a href=\"{{verificationUrl}}\">Verify Account</a></p>\n\n<p>If you have any questions, feel free to contact us at support@example.com.</p>\n\n<p>&copy; {{currentYear}} Our Service. All rights reserved.</p>\n', '<h1>Welcome to Website</h1>\r\n\r\n<p>Hello, {{username}},</p>\r\n\r\n<p>Thank you for signing up for our service. We&#39;re thrilled to have you on board!</p>\r\n\r\n<p>Your account details are as follows:</p>\r\n\r\n<ul>\r\n	<li>Email: {{email}}</li>\r\n	<li>Username: {{username}}</li>\r\n</ul>\r\n\r\n<p>Click the button below to verify your account:</p>\r\n\r\n<p><a href=\"{{verificationUrl}}\">Verify Account</a></p>\r\n\r\n<p>If you have any questions, feel free to contact us at support@example.com.</p>\r\n\r\n<p>&copy; {{currentYear}} Our Service. All rights reserved.</p>\r\n', '<h1>Welcome to Website</h1>\r\n\r\n<p>Hello, {{username}},</p>\r\n\r\n<p>Thank you for signing up for our service. We&#39;re thrilled to have you on board!</p>\r\n\r\n<p>Your account details are as follows:</p>\r\n\r\n<ul>\r\n	<li>Email: {{email}}</li>\r\n	<li>Username: {{username}}</li>\r\n</ul>\r\n\r\n<p>Click the button below to verify your account:</p>\r\n\r\n<p><a href=\"{{verificationUrl}}\">Verify Account</a></p>\r\n\r\n<p>If you have any questions, feel free to contact us at support@example.com.</p>\r\n\r\n<p>&copy; {{currentYear}} Our Service. All rights reserved.</p>\r\n', '<h1>Welcome to Website</h1>\r\n\r\n<p>Hello, {{username}},</p>\r\n\r\n<p>Thank you for signing up for our service. We&#39;re thrilled to have you on board!</p>\r\n\r\n<p>Your account details are as follows:</p>\r\n\r\n<ul>\r\n	<li>Email: {{email}}</li>\r\n	<li>Username: {{username}}</li>\r\n</ul>\r\n\r\n<p>Click the button below to verify your account:</p>\r\n\r\n<p><a href=\"{{verificationUrl}}\">Verify Account</a></p>\r\n\r\n<p>If you have any questions, feel free to contact us at support@example.com.</p>\r\n\r\n<p>&copy; {{currentYear}} Our Service. All rights reserved.</p>\r\n', 'darkrose');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `fullname` text NOT NULL,
  `gender` text NOT NULL,
  `image` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `status` text NOT NULL,
  `theme` enum('light','dark') NOT NULL DEFAULT 'light',
  `token` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `gender`, `image`, `address`, `phone`, `state`, `country`, `status`, `theme`, `token`, `created_at`) VALUES
(3, 'sulesulaimanabdu1@gmail.com', '$2y$10$/DXcS5iBxhPbH5/8YSitmud9UIFUZKGRsrvNb6Gsb5Mtd4TNpkJBe', 'Sule Sulaiman Abdu', 'male', '3.jpg', 'NO.1110 Dorayi Babba Layin Liman Saminu Ibrahim', '+2349012345678', 'Kano', 'Nigeria', 'active', 'light', NULL, '2024-12-18 14:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `fullname` text NOT NULL,
  `gender` text NOT NULL,
  `image` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `status` text NOT NULL,
  `theme` enum('light','dark') NOT NULL DEFAULT 'light',
  `farm_location` text NOT NULL,
  `token` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `email`, `password`, `fullname`, `gender`, `image`, `address`, `phone`, `state`, `country`, `status`, `theme`, `farm_location`, `token`, `created_at`) VALUES
(5, 'ladidi@gmail.com', '$2y$10$ppTdvxKhfhU3GXOkhxpUDORHt.JmeeDwol38b9gy0sUWrm2rpZyUa', 'Ladidi Sule', 'male', '5.jpg', 'Rijiyar Lemo', '09076543254', 'Kano', 'Nigeria', 'active', 'light', 'Rijiyar Lemo', NULL, '2024-12-18 18:28:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_invoice_fk` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`),
  ADD KEY `invoice_order_fk` (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `user_invoice_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `invoice_order_fk` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `product_order_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `user_order_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
