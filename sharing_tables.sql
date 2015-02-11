-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2015 at 01:33 AM
-- Server version: 5.5.38-log
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s4h`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `read` bit(1) NOT NULL DEFAULT b'0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sharedetails`
--

DROP TABLE IF EXISTS `sharedetails`;
CREATE TABLE `sharedetails` (
`id` int(10) unsigned NOT NULL,
  `share_id` int(10) unsigned NOT NULL,
  `status` int(11) DEFAULT NULL,
  `person_id` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sharedetail_shareoption`
--

DROP TABLE IF EXISTS `sharedetail_shareoption`;
CREATE TABLE `sharedetail_shareoption` (
`id` int(10) unsigned NOT NULL,
  `sharedetail_id` int(10) unsigned NOT NULL,
  `shareoption_id` int(10) unsigned NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shareoptions`
--

DROP TABLE IF EXISTS `shareoptions`;
CREATE TABLE `shareoptions` (
`id` int(10) unsigned NOT NULL,
  `share_id` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `option` varchar(512) NOT NULL,
  `html` varchar(512) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
`id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `sharetype_id` int(10) unsigned NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `element_id` int(11) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `share_types`
--

DROP TABLE IF EXISTS `share_types`;
CREATE TABLE `share_types` (
`id` int(10) unsigned NOT NULL,
  `sharetype` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(45) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_notifications.person_id$people.id_idx` (`person_id`);

--
-- Indexes for table `sharedetails`
--
ALTER TABLE `sharedetails`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_sharedetails.share_id__shares.id_idx` (`share_id`);

--
-- Indexes for table `sharedetail_shareoption`
--
ALTER TABLE `sharedetail_shareoption`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_sharedetail_id_idx` (`sharedetail_id`), ADD KEY `FK_shareoption_id_idx` (`shareoption_id`);

--
-- Indexes for table `shareoptions`
--
ALTER TABLE `shareoptions`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_shareoptions.shareoption_id__shares.id_idx` (`share_id`);

--
-- Indexes for table `shares`
--
ALTER TABLE `shares`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_share.sharetype_id__sharetype.id_idx` (`sharetype_id`), ADD KEY `FK_share.person_id__people.id_idx` (`person_id`);

--
-- Indexes for table `share_types`
--
ALTER TABLE `share_types`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sharedetails`
--
ALTER TABLE `sharedetails`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sharedetail_shareoption`
--
ALTER TABLE `sharedetail_shareoption`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `shareoptions`
--
ALTER TABLE `shareoptions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `shares`
--
ALTER TABLE `shares`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `share_types`
--
ALTER TABLE `share_types`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
ADD CONSTRAINT `FK_notifications.person_id$people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sharedetails`
--
ALTER TABLE `sharedetails`
ADD CONSTRAINT `FK_sharedetails.share_id__shares.id` FOREIGN KEY (`share_id`) REFERENCES `shares` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sharedetail_shareoption`
--
ALTER TABLE `sharedetail_shareoption`
ADD CONSTRAINT `FK_sharedetail_id` FOREIGN KEY (`sharedetail_id`) REFERENCES `sharedetails` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_shareoption_id` FOREIGN KEY (`shareoption_id`) REFERENCES `shareoptions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shareoptions`
--
ALTER TABLE `shareoptions`
ADD CONSTRAINT `FK_shareoptions.shareoption_id__shares.id` FOREIGN KEY (`share_id`) REFERENCES `shares` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shares`
--
ALTER TABLE `shares`
ADD CONSTRAINT `FK_share.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_share.sharetype_id__sharetype.id` FOREIGN KEY (`sharetype_id`) REFERENCES `share_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
