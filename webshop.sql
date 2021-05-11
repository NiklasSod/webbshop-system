-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2021 at 09:49 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(55) NOT NULL,
  `LastName` varchar(55) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `RegisterDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(55) NOT NULL,
  `LastName` varchar(55) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `RegisterDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `RegisterDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `orderStatus` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(11,0) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(55) NOT NULL,
  `rarity` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `amount`, `description`, `price`, `image`, `category`, `rarity`) VALUES
(1, 'Hofri Ghostforge', 5, 'Spirits you control get +1/+1 and have trample and haste.\r\nWhenever another nontoken creature you control dies, exile it. If you do, create a token that\'s a copy of that creature, except it\'s a Spirit in addition to its other types and it has \"When this creature leaves the battlefield, return the exiled card to its owner\'s graveyard.\"', '41', 'https://www.svenskamagic.com/kortbilder/strixhaven:schoolofmages/hofrighostforge.hq.jpg?v=1617398328', 'Legendary Creature', 'Mythic Rare'),
(2, 'Make Your Mark', 62, 'Target creature gets +1/+0 until end of turn. When that creature dies this turn, create a 3/2 red and white Spirit creature token.', '3', 'https://www.svenskamagic.com/kortbilder/strixhaven:schoolofmages/makeyourmark.hq.jpg?v=1617398312', 'Instant', 'Common'),
(3, 'Humiliate', 32, 'Target opponent reveals their hand. You choose a nonland card from it. That player discards that card. Put a +1/+1 counter on a creature you control.', '5', 'https://www.svenskamagic.com/kortbilder/strixhaven:schoolofmages/humiliate.hq.jpg?v=1617527130', 'Sorcery', 'Uncommon'),
(4, 'Infuse with Vitality', 5, 'Until end of turn, target creature gains deathtouch and \"When this creature dies, return it to the battlefield tapped under its owner\'s control.\"\r\nYou gain 2 life.', '3', 'https://www.svenskamagic.com/kortbilder/strixhaven:schoolofmages/infusewithvitality.hq.jpg?v=1617527105', 'Instant', 'Common');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order.customer` (`customerId`),
  ADD KEY `order.products` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order.customer` FOREIGN KEY (`customerId`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `order.products` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
