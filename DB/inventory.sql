-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2018 at 02:09 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `inv_items`
--

CREATE TABLE `inv_items` (
  `item_id` int(11) NOT NULL,
  `item_sku` int(11) NOT NULL DEFAULT '0',
  `item_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_quantity` int(11) NOT NULL DEFAULT '0',
  `item_price` double NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inv_items`
--

INSERT INTO `inv_items` (`item_id`, `item_sku`, `item_name`, `item_quantity`, `item_price`, `added_at`) VALUES
(1, 1, 'T-Shirt', 47, 3.5, '2018-07-27 15:08:32'),
(3, 2, 'Shirt', 4, 6.5, '2018-07-27 15:11:50'),
(4, 3, 'Trouser', 20, 10, '2018-07-27 15:11:50'),
(6, 4, 'Dress', 28, 5, '2018-07-27 15:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `inv_transactions`
--

CREATE TABLE `inv_transactions` (
  `trans_id` int(11) NOT NULL,
  `trans_item_sku` int(11) NOT NULL,
  `trans_type_id` int(11) NOT NULL,
  `trans_quantity` int(11) NOT NULL DEFAULT '1',
  `trans_total_price` double NOT NULL,
  `trans_added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inv_transactions`
--

INSERT INTO `inv_transactions` (`trans_id`, `trans_item_sku`, `trans_type_id`, `trans_quantity`, `trans_total_price`, `trans_added_at`, `trans_added_by`) VALUES
(1, 4, 1, 2, 10, '2018-07-28 11:27:15', 1),
(2, 3, 1, 1, 10, '2018-07-28 11:27:15', 1),
(3, 1, 1, 2, 7, '2018-07-28 11:27:16', 1),
(4, 2, 1, 1, 6.5, '2018-07-28 11:27:16', 1),
(5, 2, 1, 5, 32.5, '2018-07-28 11:44:33', 1),
(6, 1, 1, 1, 3.5, '2018-07-28 11:44:33', 1),
(7, 3, 1, 28, 280, '2018-07-28 11:45:00', 1),
(8, 3, 1, 2, 20, '2018-07-28 12:04:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `item_sku` int(11) NOT NULL,
  `quantity` mediumint(8) UNSIGNED NOT NULL,
  `total_price` double NOT NULL,
  `inv_status` tinyint(4) NOT NULL DEFAULT '0',
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`id`, `item_sku`, `quantity`, `total_price`, `inv_status`, `added_time`) VALUES
(88, 1, 1, 3.5, 1, '2018-07-28 11:21:28'),
(89, 2, 1, 6.5, 1, '2018-07-28 11:21:28'),
(90, 3, 1, 10, 1, '2018-07-28 11:21:28'),
(91, 4, 1, 5, 1, '2018-07-28 11:21:28'),
(92, 4, 1, 5, 1, '2018-07-28 11:21:28'),
(93, 1, 1, 3.5, 1, '2018-07-28 12:17:06'),
(94, 2, 4, 26, 1, '2018-07-28 11:43:40'),
(95, 2, 1, 6.5, 1, '2018-07-28 11:43:40'),
(96, 1, 1, 3.5, 1, '2018-07-28 11:43:55'),
(97, 3, 28, 280, 1, '2018-07-28 11:44:55'),
(98, 3, 1, 10, 1, '2018-07-28 11:58:50'),
(99, 3, 1, 10, 1, '2018-07-28 12:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_types`
--

CREATE TABLE `transactions_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions_types`
--

INSERT INTO `transactions_types` (`type_id`, `type_name`, `added_at`) VALUES
(1, 'IN', '2018-07-28 08:39:23'),
(2, 'OUT', '2018-07-28 08:39:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inv_items`
--
ALTER TABLE `inv_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_name` (`item_name`),
  ADD UNIQUE KEY `item_sku` (`item_sku`);

--
-- Indexes for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `trans_item_id` (`trans_item_sku`),
  ADD KEY `trans_type_id` (`trans_type_id`),
  ADD KEY `trans_added_by` (`trans_added_by`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_sku` (`item_sku`);

--
-- Indexes for table `transactions_types`
--
ALTER TABLE `transactions_types`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inv_items`
--
ALTER TABLE `inv_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `transactions_types`
--
ALTER TABLE `transactions_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  ADD CONSTRAINT `inv_transactions_ibfk_1` FOREIGN KEY (`trans_item_sku`) REFERENCES `inv_items` (`item_sku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inv_transactions_ibfk_2` FOREIGN KEY (`trans_type_id`) REFERENCES `transactions_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`item_sku`) REFERENCES `inv_items` (`item_sku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
