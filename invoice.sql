-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 07:55 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `frame_image`
--

CREATE TABLE `frame_image` (
  `frame_image_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frame_image`
--

INSERT INTO `frame_image` (`frame_image_id`, `url`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, '1725382725_d4110a704b7c09245fed.png', 'Double door window', 1, '2024-09-03 16:22:40', '2024-09-03 16:22:40'),
(3, '1725382763_315cbaf0984b5dbdf8c7.jpg', 'single door', 1, '2024-09-03 16:59:23', '2024-09-03 16:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `header` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `name`, `header`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Simple', '-', 1, '2024-08-13 17:36:57', '2024-08-13 17:36:57'),
(2, 'with location', 'location', 1, '2024-08-13 17:40:24', '2024-08-13 17:40:24'),
(3, 'with image + location', 'image,location', 1, '2024-08-13 17:40:43', '2024-08-13 17:40:43'),
(4, 'With image', 'image', 1, '2024-08-19 15:21:21', '2024-08-19 15:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `name`, `code`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Ground Floor Window', 'GFW1', '2024-08-09 00:28:07', '2024-08-09 00:28:07', 1),
(3, 'First Floor Window', 'FFW1', '2024-08-09 00:30:59', '2024-08-09 00:30:59', 1),
(4, 'Third floor', 'TF1', '2024-08-28 15:54:38', '2024-08-28 15:54:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `party_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `name`, `party_id`, `invoice_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 'chhapi showroom 12', 1, 1, '2024-08-19 14:17:20', '2024-08-19 14:17:20', 1),
(2, 'patan 1', 1, 2, '2024-08-27 16:03:10', '2024-08-27 16:03:10', 1),
(3, 'fahad ka personal', 1, 1, '2024-08-27 16:04:15', '2024-08-27 16:04:15', 1),
(12, 'basu wala', 1, 1, '2024-08-28 15:55:49', '2024-08-28 15:55:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `party_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `contact` bigint(20) NOT NULL,
  `email` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`party_id`, `name`, `address`, `contact`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fahad Jadiya', 'Basu , kaloni vas , vadgam', 7203070468, 'fahadjdy12@gmail.com', 1, '2024-08-06 16:06:42', '2024-08-06 16:06:42'),
(24, 'Iliyas Jadiya', 'Basu , kaloni vas , vadgam', 9820185566, 'iliyasjdy12@gmail.com', 0, '2024-08-07 15:38:14', '2024-08-07 15:38:14'),
(26, 'Mustak Bago', 'Basu', 7894561237, 'mustak@gmail.com', 1, '2024-08-07 15:55:43', '2024-08-07 15:55:43'),
(29, 'Saddam Badhra', 'Chhapi', 9858956325, 'saddambadhra@gmail.com', 1, '2024-08-21 16:02:43', '2024-08-21 16:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `price_id` int(11) NOT NULL,
  `from_sqft` int(4) NOT NULL,
  `to_sqft` int(4) NOT NULL,
  `price` float(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`price_id`, `from_sqft`, `to_sqft`, `price`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 9, 350.00, '2024-08-13 16:56:32', '2024-08-13 16:56:32', 1),
(2, 10, 12, 500.00, '2024-08-13 17:08:02', '2024-08-13 17:08:02', 1),
(3, 13, 16, 650.00, '2024-08-13 17:08:44', '2024-08-13 17:08:44', 1),
(4, 17, 20, 700.00, '2024-08-13 17:08:57', '2024-08-13 17:08:57', 1),
(6, 21, 25, 1150.00, '2024-08-21 16:04:23', '2024-08-21 16:04:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `code`, `created_at`, `updated_at`, `status`) VALUES
(11, 'vivo x90', 'P1', '2024-08-08 23:58:18', '2024-08-08 23:58:18', 0),
(14, 'vivo x60', 'P2', '2024-08-09 00:02:10', '2024-08-09 00:02:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` bigint(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `terms_condition` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `name`, `contact`, `email`, `logo`, `terms_condition`, `address`) VALUES
(1, 'Fine Aliuminium System', 9824528608, 'saddam.badhra1@gmail.com', '1723485220_b53f80deb0082487734d.png', '1. Good sold will not be return\r\n2. 50% advance must befor start work', 'Golen Plaza Complex, Behind Madhvi, Chhapi Highway,Chhapi, Gujarat-385210');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `frame_image_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `product_id` varchar(255) NOT NULL,
  `extra_product` varchar(255) NOT NULL,
  `size1` float(15,2) NOT NULL COMMENT 'height',
  `size2` float(15,2) NOT NULL COMMENT 'width',
  `price` int(11) NOT NULL,
  `qty` int(11) UNSIGNED NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `orders_id`, `frame_image_id`, `location_id`, `product_id`, `extra_product`, `size1`, `size2`, `price`, `qty`, `total_price`, `created_at`, `updated_at`, `status`) VALUES
(9, 1, 3, 3, '11', 'extra', 15.00, 4.00, 450, 6, 2700, '2024-08-19 14:29:57', '2024-08-19 14:29:57', 1),
(15, 2, 2, 3, '14,11', 'www', 2.00, 4.00, 120, 1, 120, '2024-08-27 16:03:10', '2024-08-27 16:03:10', 1),
(16, 3, 2, 1, '14,11', 'fdfd', 4.00, 5.00, 435, 1, 435, '2024-08-27 16:04:15', '2024-08-27 16:04:15', 1),
(17, 3, 3, 1, '14', 'dsfsdf', 4.00, 4.00, 360, 1, 360, '2024-08-27 16:04:15', '2024-08-27 16:04:15', 1),
(20, 12, 2, 4, '14', '', 4.00, 3.00, 350, 1, 350, '2024-08-28 15:55:49', '2024-08-28 15:55:49', 1),
(21, 12, 3, 3, '14,11', 'test', 3.00, 6.00, 450, 1, 450, '2024-08-29 16:08:44', '2024-08-29 16:08:44', 1),
(22, 15, 2, 3, '1', 'test', 2.00, 2.00, 150, 1, 150, '2024-09-02 15:23:14', '2024-09-02 15:23:14', 1),
(23, 14, 2, 3, '1', 'd', 2.00, 3.00, 450, 1, 450, '2024-09-02 15:28:12', '2024-09-02 15:28:12', 1),
(24, 30, 2, 1, '14', 'fdf', 23.00, 3.00, 4, 3, 12, '2024-09-03 17:16:02', '2024-09-03 17:16:02', 1),
(25, 30, 2, 1, '14,11', 'test', 2.00, 2.00, 21, 2, 42, '2024-09-03 17:26:31', '2024-09-03 17:26:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `status`, `created_at`) VALUES
(2, 'fahad', '123', 'fahadajdy12@gmail.com', 1, '2023-03-31 10:37:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `frame_image`
--
ALTER TABLE `frame_image`
  ADD PRIMARY KEY (`frame_image_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`party_id`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `frame_image`
--
ALTER TABLE `frame_image`
  MODIFY `frame_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `party_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
