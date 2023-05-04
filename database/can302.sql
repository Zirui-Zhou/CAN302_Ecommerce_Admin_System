-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-05-04 09:00:03
-- 服务器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `can302_ass1`
--
CREATE DATABASE IF NOT EXISTS `can302_ass1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `can302_ass1`;

-- --------------------------------------------------------

--
-- 表的结构 `address`
--

CREATE TABLE `address` (
  `id` varchar(36) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `addressee` varchar(128) NOT NULL,
  `address` varchar(516) NOT NULL,
  `country` varchar(8) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `address`
--

INSERT INTO `address` (`id`, `phone`, `user_id`, `addressee`, `address`, `country`, `is_default`) VALUES
('2d5cb519-5f26-41e0-a2d4-8cc0bce05318', '199-9999-9999', '7af919cb-5959-4aed-ae72-cad49130c3b9', 'ZiruiZhou', 'The University of Manchester Oxford Rd Manchester M13 9PL UK', 'GB', 0),
('72827408-156c-43bc-8a79-1da659aa5aa7', '199-9999-9999', '7af919cb-5959-4aed-ae72-cad49130c3b9', 'ZiruiZhou', 'Xi\'an Jiaotong-Liverpool University 111 Ren\'ai Road Suzhou Industrial Park Suzhou Jiangsu Province P. R. China', 'CN', 1);

-- --------------------------------------------------------

--
-- 表的结构 `address_country`
--

CREATE TABLE `address_country` (
  `code` varchar(8) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `address_country`
--

INSERT INTO `address_country` (`code`, `name`) VALUES
('CN', 'China'),
('GB', 'United Kingdom');

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE `category` (
  `id` varchar(36) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
('5d7813ee-ec02-49a0-9387-2cb85a442242', 'Game', 'Game'),
('add4de52-2bec-404c-a904-6df1ccd4358a', 'Mobile Phone', 'Mobile Phone'),
('cedd5ea4-ae76-460b-a0f3-99cb4eea6989', 'Laptop', 'Laptop');

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `id` varchar(36) NOT NULL,
  `state` int(11) NOT NULL,
  `address_id` varchar(36) NOT NULL,
  `payment_id` varchar(36) NOT NULL,
  `payment_amount` int(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL,
  `user_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `state`, `address_id`, `payment_id`, `payment_amount`, `remark`, `payment_time`, `user_id`) VALUES
('5fabb406-b5f9-4f92-aa75-96081dddeeb4', 3, '2d5cb519-5f26-41e0-a2d4-8cc0bce05318', 'cb5a52f4-c1bb-4758-ada1-77c3c8886b6c', 14000, 'Thank you. 123', '2023-04-12 23:06:28', '7af919cb-5959-4aed-ae72-cad49130c3b9'),
('cedd5ea4-ae76-460b-a0f3-99cb4eea6989', 2, '72827408-156c-43bc-8a79-1da659aa5aa7', 'bcd0ae5c-1fbb-4524-b93d-09e99a97389a', 5000, 'Thank you Very Much.', '2023-04-15 23:06:30', '7af919cb-5959-4aed-ae72-cad49130c3b9');

-- --------------------------------------------------------

--
-- 表的结构 `order_product_list`
--

CREATE TABLE `order_product_list` (
  `order_id` varchar(36) NOT NULL,
  `number` int(11) NOT NULL,
  `product_id` varchar(36) NOT NULL,
  `id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order_product_list`
--

INSERT INTO `order_product_list` (`order_id`, `number`, `product_id`, `id`) VALUES
('cedd5ea4-ae76-460b-a0f3-99cb4eea6989', 1, '132099be-c264-4ec1-b68f-d8401418565a', '5daf8b1e-8603-4b4a-9cc6-8a039f07e964'),
('5fabb406-b5f9-4f92-aa75-96081dddeeb4', 4, '0d70a825-5cfb-4f5c-9473-99896270b18c', 'dd029c09-ac04-4f9b-b3d6-44474eb50b79'),
('5fabb406-b5f9-4f92-aa75-96081dddeeb4', 3, '0b0a321c-eb50-4ef4-81c5-378cea6594a0', 'e65f6fc8-cccc-4e34-b725-6527b77d4f21');

-- --------------------------------------------------------

--
-- 表的结构 `order_state`
--

CREATE TABLE `order_state` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`badge`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order_state`
--

INSERT INTO `order_state` (`id`, `name`, `badge`) VALUES
(1, 'On Delivery', '{\n  \"text\": \"On Delivery\",\n  \"style\": \"text-bg-primary\",\n  \"icon\": \"bi bi-truck\"\n}'),
(2, 'Signed', '{\n  \"text\": \"Signed\",\n  \"style\": \"text-bg-success\",\n  \"icon\": \"bi bi-check2-square\"\n}'),
(3, 'Wait for Payment', '{\n  \"text\": \"Wait for Payment\",\n  \"style\": \"text-bg-secondary\",\n  \"icon\": \"bi bi-clock\"\n}'),
(4, 'Cancelled', '{\n  \"text\": \"Cancelled\",\n  \"style\": \"text-bg-danger\",\n  \"icon\": \"bi bi-x-circle\"\n}');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `id` varchar(36) NOT NULL,
  `platform` int(11) NOT NULL,
  `account` varchar(128) NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `user_id` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`id`, `platform`, `account`, `is_default`, `user_id`) VALUES
('bcd0ae5c-1fbb-4524-b93d-09e99a97389a', 3, 'ZiruiZhou1', 0, '7af919cb-5959-4aed-ae72-cad49130c3b9'),
('c2abed31-33f2-4961-bf70-8e494d2f917b', 2, 'ZiruiZhou2', 0, '7af919cb-5959-4aed-ae72-cad49130c3b9'),
('cb5a52f4-c1bb-4758-ada1-77c3c8886b6c', 1, 'ZiruiZhou3', 1, '7af919cb-5959-4aed-ae72-cad49130c3b9');

-- --------------------------------------------------------

--
-- 表的结构 `payment_platform`
--

CREATE TABLE `payment_platform` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(16) DEFAULT NULL,
  `icon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `payment_platform`
--

INSERT INTO `payment_platform` (`id`, `name`, `type`, `icon`) VALUES
(1, 'Alipay', 'Online', '{\n  \"icon\": \"bi bi-alipay\",\n  \"color\": \"#1677FF\"\n}'),
(2, 'WeChat Pay', 'Online', '{\n  \"icon\": \"bi bi-wechat\",\n  \"color\": \"#09B83E\"\n}'),
(3, 'PayPal', 'Online', '{\n  \"icon\": \"bi bi-paypal\",\n  \"color\": \"#253B80\"\n}');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` varchar(36) NOT NULL,
  `category` varchar(36) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` int(11) NOT NULL,
  `price_unit` varchar(16) NOT NULL,
  `state` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `category`, `name`, `price`, `price_unit`, `state`, `stock`, `image_url`) VALUES
('0b0a321c-eb50-4ef4-81c5-378cea6594a0', 'cedd5ea4-ae76-460b-a0f3-99cb4eea6989', 'MacBook Pro', 10000, 'CNY', 2, 200, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mbp-spacegray-select-202206?wid=640&hei=595&fmt=jpeg&qlt=95&.v=1664497359481'),
('0d70a825-5cfb-4f5c-9473-99896270b18c', 'add4de52-2bec-404c-a904-6df1ccd4358a', 'iPhone 13', 4000, 'CNY', 1, 123, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-13-finish-select-202207-6-1inch-pink?wid=2560&hei=1440&fmt=p-jpg&qlt=80&.v=1657641867367'),
('132099be-c264-4ec1-b68f-d8401418565a', 'add4de52-2bec-404c-a904-6df1ccd4358a', 'iPhone 14', 5000, 'CNY', 1, 100, 'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-14-finish-select-202209-6-1inch-purple?wid=2560&hei=1440&fmt=p-jpg&qlt=80&.v=1661027205808');

-- --------------------------------------------------------

--
-- 表的结构 `product_state`
--

CREATE TABLE `product_state` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`badge`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `product_state`
--

INSERT INTO `product_state` (`id`, `name`, `badge`) VALUES
(1, 'On Sale', '{\n  \"text\": \"On Sale\",\n  \"style\": \"text-bg-success\",\n  \"icon\": \"bi bi-check-lg\"\n}'),
(2, 'Not Available', '{\n  \"text\": \"Not Available\",\n  \"style\": \"text-bg-danger\",\n  \"icon\": \"bi bi-x-lg\"\n}');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `role` int(11) NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `salt`, `role`, `state`) VALUES
('5e69c176-0a7b-4b9a-abda-6f0ceeb6681e', 'Chongxi Yu', '4c853f70cf1be810422a2e5c405e1558', '819df2c5c94c5735c597da14cd393f42', 2, 1),
('7af919cb-5959-4aed-ae72-cad49130c3b9', 'Zirui Zhou', '53d38eaf969fa6f65f2b09a44ee757ca', '2454572bf855cc3cd29bfb5caa92bfd3', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE `user_info` (
  `id` varchar(36) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`id`, `email`, `birthday`, `phone`) VALUES
('5e69c176-0a7b-4b9a-abda-6f0ceeb6681e', 'chongxi.yu18@student.xjtlu.edu.cn', '2001-04-03', '16666666666'),
('7af919cb-5959-4aed-ae72-cad49130c3b9', 'zirui.zhou19@student.xjtlu.edu.cn', '2001-06-12', '19999999999');

-- --------------------------------------------------------

--
-- 表的结构 `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`badge`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `badge`) VALUES
(1, 'administrator', '{\n  \"text\": \"Admin\",\n  \"style\": \"text-bg-warning\",\n  \"icon\": \"bi bi-person-fill-gear\"\n}'),
(2, 'client', '{\n  \"text\": \"Client\",\n  \"style\": \"text-bg-primary\",\n  \"icon\": \"bi bi-person-fill\"\n}');

-- --------------------------------------------------------

--
-- 表的结构 `user_state`
--

CREATE TABLE `user_state` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `badge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`badge`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user_state`
--

INSERT INTO `user_state` (`id`, `name`, `badge`) VALUES
(1, 'offline', '{\n  \"text\": \"Offline\",\n  \"style\": \"text-bg-secondary\",\n  \"icon\": \"bi bi-wifi-off\"\n}'),
(2, 'online', '{\n  \"text\": \"Online\",\n  \"style\": \"text-bg-success\",\n  \"icon\": \"bi bi-wifi\"\n}');

--
-- 转储表的索引
--

--
-- 表的索引 `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `address_pk2` (`id`),
  ADD KEY `address_user_id_fk` (`user_id`),
  ADD KEY `address_address_country_code_fk` (`country`);

--
-- 表的索引 `address_country`
--
ALTER TABLE `address_country`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `address_country_pk2` (`code`);

--
-- 表的索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_pk2` (`id`);

--
-- 表的索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_pk2` (`id`),
  ADD KEY `order_address_id_fk` (`address_id`),
  ADD KEY `order_order_state_id_fk` (`state`),
  ADD KEY `order_payment_id_fk` (`payment_id`),
  ADD KEY `order_user_id_fk` (`user_id`);

--
-- 表的索引 `order_product_list`
--
ALTER TABLE `order_product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_list_order_id_fk` (`order_id`),
  ADD KEY `order_product_list_product_id_fk` (`product_id`);

--
-- 表的索引 `order_state`
--
ALTER TABLE `order_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_state_pk2` (`id`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_pk2` (`id`),
  ADD KEY `payment_payment_platform_id_fk` (`platform`),
  ADD KEY `payment_user_id_fk` (`user_id`);

--
-- 表的索引 `payment_platform`
--
ALTER TABLE `payment_platform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_platform_pk2` (`id`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_pk2` (`id`),
  ADD KEY `product_product_state_id_fk` (`state`),
  ADD KEY `product_pk` (`category`);

--
-- 表的索引 `product_state`
--
ALTER TABLE `product_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_state_pk2` (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_pk2` (`id`),
  ADD KEY `user_user_role_id_fk` (`role`),
  ADD KEY `user_user_state_id_fk` (`state`);

--
-- 表的索引 `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_info_pk2` (`id`);

--
-- 表的索引 `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role_pk2` (`id`);

--
-- 表的索引 `user_state`
--
ALTER TABLE `user_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_state_pk2` (`id`);

--
-- 限制导出的表
--

--
-- 限制表 `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_address_country_code_fk` FOREIGN KEY (`country`) REFERENCES `address_country` (`code`),
  ADD CONSTRAINT `address_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_address_id_fk` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `order_order_state_id_fk` FOREIGN KEY (`state`) REFERENCES `order_state` (`id`),
  ADD CONSTRAINT `order_payment_id_fk` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`),
  ADD CONSTRAINT `order_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `order_product_list`
--
ALTER TABLE `order_product_list`
  ADD CONSTRAINT `order_product_list_order_id_fk` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_product_list_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_payment_platform_id_fk` FOREIGN KEY (`platform`) REFERENCES `payment_platform` (`id`),
  ADD CONSTRAINT `payment_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category_id_fk` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_product_state_id_fk` FOREIGN KEY (`state`) REFERENCES `product_state` (`id`);

--
-- 限制表 `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_user_role_id_fk` FOREIGN KEY (`role`) REFERENCES `user_role` (`id`),
  ADD CONSTRAINT `user_user_state_id_fk` FOREIGN KEY (`state`) REFERENCES `user_state` (`id`);

--
-- 限制表 `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_user_id_fk` FOREIGN KEY (`id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
