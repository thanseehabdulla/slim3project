-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2016 at 05:41 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beforelive_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_order`
--

CREATE TABLE `item_order` (
  `id` bigint(20) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_desc` text,
  `order_qty` int(11) NOT NULL,
  `order_amount` float NOT NULL,
  `order_date` varchar(100) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `dealer_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) DEFAULT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_order`
--

INSERT INTO `item_order` (`id`, `order_number`, `order_desc`, `order_qty`, `order_amount`, `order_date`, `product_id`, `dealer_id`, `agent_id`, `client_id`, `isactive`, `created`, `updated`) VALUES
(5, '12', 'desc', 3, 12000, '2016-05-05', 0, 2, 32, 1, 1, '2016-11-30 06:01:35', '2016-11-30 06:01:35'),
(6, '77', 'hh', 7, 25000, '', 0, 0, 32, 0, 1, '2016-11-30 06:13:28', '2016-11-30 06:13:28'),
(20, 'g', 'g', 2, 3, '3', 3, 3, 32, 3, 1, '2016-12-07 11:51:58', '2016-12-07 11:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE `payment_transaction` (
  `id` bigint(20) NOT NULL,
  `payment_amount` float NOT NULL,
  `payment_date` datetime NOT NULL,
  `type_id` bigint(20) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`id`, `payment_amount`, `payment_date`, `type_id`, `payment_status`, `order_id`, `isactive`, `created`, `updated`) VALUES
(45, 26000, '2016-11-10 00:00:00', 1, 1, 5, 1, '2016-11-30 06:20:18', '2016-11-30 06:20:18'),
(46, 85000, '2016-11-30 11:50:52', 3, 1, 5, 1, '2016-11-30 06:20:50', '2016-11-30 06:20:50'),
(47, 22222, '2016-12-07 11:40:27', 2, 1, 1, 1, '2016-12-07 06:10:25', '2016-12-07 06:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` bigint(20) NOT NULL,
  `type_name` varchar(250) NOT NULL,
  `type_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `type_name`, `type_desc`) VALUES
(1, 'cheque', ''),
(2, 'cash', ''),
(3, 'DD', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` float NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_price`, `isactive`, `created`, `updated`) VALUES
(1, 'Rice', 500, 1, '2016-11-30 04:13:34', '2016-11-30 04:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_pass` varchar(250) NOT NULL,
  `user_mobile` varchar(15) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `type_id` bigint(20) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dealer_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_pass`, `user_mobile`, `user_email`, `user_address`, `type_id`, `isactive`, `created`, `updated`, `dealer_id`) VALUES
(27, 'admin', 'admin', '', 'admin', '', 3, 1, '2016-11-30 04:15:29', '2016-11-30 04:15:14', NULL),
(32, 'a', '123', '11111111', 'agent@gmail.com', 'a', 1, 1, '2016-11-30 05:57:29', '2016-11-30 05:57:29', NULL),
(33, 'b', '123', '2222222', 'b@gmail.com', 'b', 1, 1, '2016-11-30 05:57:29', '2016-11-30 05:57:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` bigint(20) NOT NULL,
  `type_name` varchar(250) NOT NULL,
  `type_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type_name`, `type_desc`) VALUES
(0, 'dealer', 'Dealer'),
(1, 'agent', 'Agent'),
(2, 'client', 'Client/Customer'),
(3, 'admin', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_order`
--
ALTER TABLE `item_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_order`
--
ALTER TABLE `item_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
