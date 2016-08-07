-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2015 at 10:51 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b00595739`
--

-- --------------------------------------------------------

--
-- Table structure for table `venuetable`
--

CREATE TABLE IF NOT EXISTS `venuetable` (
`Venue_Id` int(11) NOT NULL,
  `v_id` varchar(500) NOT NULL,
  `VName` varchar(250) NOT NULL,
  `v_address` varchar(250) NOT NULL,
  `Vimage` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `direction_id` varchar(500) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `venuetable`
--

INSERT INTO `venuetable` (`Venue_Id`, `v_id`, `VName`, `v_address`, `Vimage`, `user_id`, `direction_id`) VALUES
(107, '4e8628a0775bb844cfa18b60', 'The Hudson Bar', '10-12 Gresham Street,  Belfast,  BT1 1JN', 'https://irs2.4sqi.net/img/general/400x200/1453818_r5Ryktab5wLBlQPyIaKuKmPsYbIWZxcLGYmS4rR5H7k.jpg', 3, '4e8628a0775bb844cfa18b60'),
(109, '4c90fd172626a1cdf7662e6b', 'Filthy McNasty''s', '45 Dublin Rd,  Belfast,  BT2 7HD', 'https://irs3.4sqi.net/img/general/400x200/24337449_jZtk8A59jcaRAQzLwAAcaLwuRH_x6Zt7adIVMc2TITw.jpg', 3, '4c90fd172626a1cdf7662e6b'),
(110, '4e47cca6c65bd6ffbea384d4', 'Townland of Tyanee', 'Kilrea Road (Old Tyanee Road)', '', 3, '4e47cca6c65bd6ffbea384d4'),
(111, '5304af4311d213ede66803a0', 'Creative Gardens at Galgorm Castle', 'Antrim,  200 Galgorm Rd,  Antrim,  BT42 1HL', 'https://irs1.4sqi.net/img/general/400x200/813854_F2VgXmR_GVCnK_y_4QFw6gFP65GaSzsYy8o3jfWqz78.jpg', 3, '5304af4311d213ede66803a0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `venuetable`
--
ALTER TABLE `venuetable`
 ADD PRIMARY KEY (`Venue_Id`), ADD KEY `user_id` (`user_id`), ADD KEY `direction_id` (`direction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `venuetable`
--
ALTER TABLE `venuetable`
MODIFY `Venue_Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=112;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `venuetable`
--
ALTER TABLE `venuetable`
ADD CONSTRAINT `venuetable_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
ADD CONSTRAINT `venuetable_ibfk_2` FOREIGN KEY (`direction_id`) REFERENCES `directions` (`direction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
