-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2015 at 07:13 AM
-- Server version: 5.5.38-log
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `s4h`
--

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
`id` int(10) unsigned NOT NULL,
  `countrie_id` int(10) NOT NULL,
  `zipcode_id` int(10) NOT NULL,
  `suburb_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `numberint` varchar(50) NOT NULL,
  `numberext` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `countrie_id`, `zipcode_id`, `suburb_id`, `name`, `street`, `numberint`, `numberext`, `phone`, `photo`, `created_at`, `updated_at`) VALUES
(13, 1, 15073, 63907, '', '', '', '', '', '', '2015-01-13 05:46:34', '2015-01-13 05:46:34'),
(14, 1, 20732, 86235, 'Los Peluche', 'Corales', '', '1', '(111) 111-1111', '', '2015-01-13 05:46:48', '2015-01-13 05:47:54'),
(15, 1, 20732, 86235, 'Los Dávalos', '111', '', '1', '(111) 111-1111', '', '2015-01-13 05:54:38', '2015-01-13 05:55:41'),
(16, 1, 20732, 86217, 'Maragon', '1', '', '1', '(111) 111-1111', '', '2015-01-13 06:01:35', '2015-01-13 06:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
`id` int(10) unsigned NOT NULL,
  `fileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `fileName`, `fileURL`, `fileType`, `user_id`, `created_at`, `updated_at`) VALUES
(25, 'default.jpg', 'https://s3.amazonaws.com/soft4h/default.jpg', 'image/jpeg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'defaultfamily.png', 'https://s3.amazonaws.com/soft4h/defaultfamily.png', 'image/png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, '10600554_819092671466368_6796286882243604048_n.jpg', 'https://s3.amazonaws.com/soft4h/1d5766389f53ec8f9de0741e81438fd7245f48cd.jpg', 'image/jpeg', 22, '2014-10-29 01:23:47', '2014-10-29 01:23:47'),
(32, 'af2e16c218830d82a96563745a634af1cf68f74b.JPG', 'https://s3.amazonaws.com/soft4h/a1add7a9e4355c4d9b52b08184b718148663c49f.JPG', 'image/jpeg', 22, '2014-10-29 01:25:29', '2014-10-29 01:25:29'),
(33, 'my_avatar.jpg', 'https://s3.amazonaws.com/soft4h/320466ebed7528a9730181b16cf563a1d0e9cc3e.jpg', 'image/jpeg', 31, '2014-12-27 19:07:31', '2014-12-27 19:07:31'),
(34, '1 (2).jpg', 'https://s3.amazonaws.com/soft4h/c4c5893541ac2b13aa404eb903832608a190880d.jpg', 'image/jpeg', 31, '2014-12-27 21:07:32', '2014-12-27 21:07:32'),
(35, '1146452_10152477667241662_2351698806313482010_n.jpg', 'https://s3.amazonaws.com/soft4h/96f31b09ba2ef68ebf04f719dc0464e4703d4bac.jpg', 'image/jpeg', 31, '2014-12-29 00:29:05', '2014-12-29 00:29:05'),
(36, '5cd7f5cf8678570173cbc0993053601bb3f1ef19.jpg', 'https://s3.amazonaws.com/soft4h/0b2e3e0707936f8d05bab3af800c5585e37d9e3b.jpg', 'image/jpeg', 31, '2014-12-29 00:31:58', '2014-12-29 00:31:58'),
(37, '1 (2).jpg', 'https://s3.amazonaws.com/soft4h/93e096398906bef09a21a063a13b78e0638d6fba.jpg', 'image/jpeg', 31, '2014-12-29 00:32:18', '2014-12-29 00:32:18'),
(38, '1146452_10152477667241662_2351698806313482010_n.jpg', 'https://s3.amazonaws.com/soft4h/a43b89a30331a53cb454de0f83339a6ed1a120a8.jpg', 'image/jpeg', 31, '2014-12-29 00:33:21', '2014-12-29 00:33:21'),
(39, 'ludovico.jpg', 'https://s3.amazonaws.com/soft4h/95a542e01e13c288dd42242a6bc49b4be29a81d7.jpg', 'image/jpeg', 36, '2015-01-13 05:11:49', '2015-01-13 05:11:49'),
(40, 'ludo.jpg', 'https://s3.amazonaws.com/soft4h/3d4339d7c24eeebfa3a33d0b7fd9de3698a77ac5.jpg', 'image/jpeg', 36, '2015-01-13 05:14:16', '2015-01-13 05:14:16'),
(41, 'ludo.jpg', 'https://s3.amazonaws.com/soft4h/bb46c8d7520b3a7df4cf3c7c965f2102308e1bdc.jpg', 'image/jpeg', 43, '2015-01-13 05:48:08', '2015-01-13 05:48:08'),
(42, 'federica.jpg', 'https://s3.amazonaws.com/soft4h/675c06c25fb68afb80c194ba84a558828ddcc91c.jpg', 'image/jpeg', 43, '2015-01-13 05:49:03', '2015-01-13 05:49:03'),
(43, 'ludoviquito.jpg', 'https://s3.amazonaws.com/soft4h/aa1f20ac2d722180a252755a47194834dcb8fd50.jpg', 'image/jpeg', 43, '2015-01-13 05:51:07', '2015-01-13 05:51:07'),
(44, 'bibi.jpg', 'https://s3.amazonaws.com/soft4h/444fefab35931db38a8c3ed71ea863be485a0bae.jpg', 'image/jpeg', 43, '2015-01-13 05:52:25', '2015-01-13 05:52:25'),
(45, 'Junior.png', 'https://s3.amazonaws.com/soft4h/eff54cdf9c51a0af851fa97470fae31bfe923d4e.png', 'image/png', 43, '2015-01-13 05:53:21', '2015-01-13 05:53:21'),
(46, 'federica.jpg', 'https://s3.amazonaws.com/soft4h/2989cb431a3a4128a7b2b5ce16550d7a6e2c5c59.jpg', 'image/jpeg', 43, '2015-01-13 05:54:00', '2015-01-13 05:54:00'),
(47, 'lauro.jpeg', 'https://s3.amazonaws.com/soft4h/f6a457b9c29007a8d9df139924de715fdb8a367e.jpeg', 'image/jpeg', 48, '2015-01-13 05:57:20', '2015-01-13 05:57:20'),
(48, 'camerino.jpg', 'https://s3.amazonaws.com/soft4h/e1c26f1fe1a6fe20485329ed77b58fb0f335fdd8.jpg', 'image/jpeg', 50, '2015-01-13 06:04:34', '2015-01-13 06:04:34'),
(49, 'matilde.jpg', 'https://s3.amazonaws.com/soft4h/ef7d2438c092f180a946e9957c39bb5721fbfbad.jpg', 'image/jpeg', 50, '2015-01-13 06:07:48', '2015-01-13 06:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
`id` int(10) unsigned NOT NULL,
  `GroupName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GroupTypeID` int(10) unsigned NOT NULL,
  `JoinAuthOption` int(10) unsigned NOT NULL,
  `InviteAuthOption` int(10) unsigned NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `family_id` int(10) unsigned DEFAULT NULL,
  `person_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `GroupName`, `GroupTypeID`, `JoinAuthOption`, `InviteAuthOption`, `Active`, `file_id`, `family_id`, `person_id`, `created_at`, `updated_at`) VALUES
(100, '', 1, 2, 2, 1, 26, 13, NULL, '2015-01-13 05:46:34', '2015-01-13 05:46:34'),
(101, 'Family 13 friends.', 4, 2, 2, 1, 26, 13, NULL, '2015-01-13 05:46:34', '2015-01-13 05:46:34'),
(102, 'Family 13 relatives.', 5, 2, 2, 1, 26, 13, NULL, '2015-01-13 05:46:34', '2015-01-13 05:46:34'),
(103, 'Family 13 favorites.', 6, 2, 2, 1, 26, 13, NULL, '2015-01-13 05:46:34', '2015-01-13 05:46:34'),
(104, '', 1, 2, 2, 1, 26, 14, NULL, '2015-01-13 05:46:48', '2015-01-13 05:46:48'),
(105, 'Family 14 friends.', 4, 2, 2, 1, 26, 14, NULL, '2015-01-13 05:46:49', '2015-01-13 05:46:49'),
(106, 'Family 14 relatives.', 5, 2, 2, 1, 26, 14, NULL, '2015-01-13 05:46:49', '2015-01-13 05:46:49'),
(107, 'Family 14 favorites.', 6, 2, 2, 1, 26, 14, NULL, '2015-01-13 05:46:49', '2015-01-13 05:46:49'),
(108, '', 1, 2, 2, 1, 26, 15, NULL, '2015-01-13 05:54:38', '2015-01-13 05:54:38'),
(109, 'Family 15 friends.', 4, 2, 2, 1, 26, 15, NULL, '2015-01-13 05:54:39', '2015-01-13 05:54:39'),
(110, 'Family 15 relatives.', 5, 2, 2, 1, 26, 15, NULL, '2015-01-13 05:54:39', '2015-01-13 05:54:39'),
(111, 'Family 15 favorites.', 6, 2, 2, 1, 26, 15, NULL, '2015-01-13 05:54:39', '2015-01-13 05:54:39'),
(112, '', 1, 2, 2, 1, 26, 16, NULL, '2015-01-13 06:01:35', '2015-01-13 06:01:35'),
(113, 'Family 16 friends.', 4, 2, 2, 1, 26, 16, NULL, '2015-01-13 06:01:35', '2015-01-13 06:01:35'),
(114, 'Family 16 relatives.', 5, 2, 2, 1, 26, 16, NULL, '2015-01-13 06:01:35', '2015-01-13 06:01:35'),
(115, 'Family 16 favorites.', 6, 2, 2, 1, 26, 16, NULL, '2015-01-13 06:01:35', '2015-01-13 06:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `grouptypes`
--

CREATE TABLE `grouptypes` (
`id` int(10) unsigned NOT NULL,
  `GroupType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `grouptypes`
--

INSERT INTO `grouptypes` (`id`, `GroupType`, `Active`, `created_at`, `updated_at`) VALUES
(1, 'Home', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(2, 'Community', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(3, 'Group', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(4, 'Friends', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Relatives', 1, '2014-11-22 02:54:00', '2014-11-22 02:54:00'),
(6, 'Favorites', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `group_group`
--

CREATE TABLE `group_group` (
`id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `member_group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_group`
--

INSERT INTO `group_group` (`id`, `group_id`, `member_group_id`) VALUES
(23, 113, 109),
(24, 109, 113),
(25, 109, 105),
(26, 105, 109),
(27, 113, 105),
(28, 105, 113);

-- --------------------------------------------------------

--
-- Table structure for table `group_person`
--

CREATE TABLE `group_person` (
`id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_person`
--

INSERT INTO `group_person` (`id`, `group_id`, `person_id`, `admin`, `role_id`) VALUES
(56, 100, 103, 1, 1),
(57, 104, 104, 1, 1),
(58, 104, 105, 0, 2),
(59, 104, 106, 0, 3),
(60, 104, 107, 0, 3),
(61, 104, 108, 0, 3),
(62, 108, 109, 1, 1),
(63, 108, 110, 0, 2),
(64, 112, 111, 1, 1),
(65, 112, 112, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

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
-- Table structure for table `people`
--

CREATE TABLE `people` (
`id` int(10) unsigned NOT NULL,
  `family_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mothersname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `profile` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `family_id`, `file_id`, `name`, `lastname`, `mothersname`, `birthdate`, `gender`, `phone`, `email`, `created_at`, `updated_at`, `profile`) VALUES
(103, 13, 25, '', '', '', '1900-01-01', 0, '', '', '2015-01-13 05:46:34', '2015-01-13 05:46:34', 1),
(104, 14, 41, 'Ludovico', 'P. Luche', '', '1975-01-12', 1, '013221870571', 'u1@u.com', '2015-01-13 05:46:48', '2015-01-13 05:48:08', 1),
(105, 14, 46, 'Federica', 'Dávalos', 'P. Luche', '1978-01-12', 0, '', '', '2015-01-13 05:49:02', '2015-01-13 05:54:00', 3),
(106, 14, 43, 'Ludoviquito', 'P. Luche', '', '2005-01-12', 1, '', '8154b4b248ba31e@localhost.com', '2015-01-13 05:51:04', '2015-01-13 05:51:07', 3),
(107, 14, 44, 'Bibi', 'P. Luche', '', '2000-01-12', 0, '', '8254b4b296ac3bf@localhost.com', '2015-01-13 05:52:22', '2015-01-13 05:52:25', 3),
(108, 14, 45, 'Junior', 'P. Luche', '', '1978-01-12', 1, '', '1554b4b2ce983b9@localhost.com', '2015-01-13 05:53:18', '2015-01-13 05:53:21', 3),
(109, 15, 47, 'Lauro', 'Dávalos', '', '1960-01-12', 1, '(111) 111-1111', 'u2@u.com', '2015-01-13 05:54:38', '2015-01-13 05:57:20', 1),
(110, 15, 25, 'Francisca', 'De Dávalos', '', '1960-01-13', 0, '', '3654b4b48fc2595@localhost.com', '2015-01-13 06:00:47', '2015-01-13 06:00:47', 3),
(111, 16, 48, 'Don Camerino', 'MAragón', '', '1970-01-13', 1, '(111) 111-1111', 'u3@u.com', '2015-01-13 06:01:35', '2015-01-13 06:04:34', 1),
(112, 16, 49, 'Lucrecia', 'Davalos', '', '1975-01-13', 0, '', '', '2015-01-13 06:07:21', '2015-01-13 06:07:48', 3);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
`id` int(10) unsigned NOT NULL,
  `grouptype_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `grouptype_id`, `name`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'Papá', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'Mamá', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'Hijo/a', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sharedetails`
--

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

CREATE TABLE `share_types` (
`id` int(10) unsigned NOT NULL,
  `sharetype` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(45) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `share_types`
--

INSERT INTO `share_types` (`id`, `sharetype`, `created_at`, `updated_at`) VALUES
(1, 'give', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'take', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'respond', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'receive', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `person_id` int(10) unsigned NOT NULL,
  `groupId` int(10) unsigned DEFAULT '1',
  `created_by_admon` tinyint(1) NOT NULL DEFAULT '0',
  `username_confirmation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `plain_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_code`, `confirmed`, `person_id`, `groupId`, `created_by_admon`, `username_confirmation`, `created_at`, `updated_at`, `plain_password`) VALUES
(43, 'u1@u.com', 'u1@u.com', '$2y$10$HF6hDRZwV8fkYN.8hU0NMe0sH9UKL5xmhEQnwolgx3I6QXb6LxY7e', 'bb3b56a103d1f1e7380b0ef373dbe017', 0, 104, 1, 0, 'u1@u.com', '2015-01-13 05:46:49', '2015-01-13 05:48:06', '$2y$10$HF6hDRZwV8fkYN.8hU0NMe0sH9UKL5xmhEQnwolgx3I6QXb6LxY7e'),
(44, '4254b4b2f656f2f@localhost.com', '4254b4b2f656f2f@localhost.com', '$2y$10$hjff677iJPSiLojtg6dX7ORXkxQpNfSZAYxzCvTm4AVMP00E91IkO', '8cd4f3e20068cb2b889a99cb97d2d352', 0, 105, 1, 1, '4254b4b2f656f2f@localhost.com', '2015-01-13 05:49:02', '2015-01-13 05:53:58', '1754b4b2f656f41'),
(45, '8154b4b248ba31e@localhost.com', '8154b4b248ba31e@localhost.com', '$2y$10$MsM1qQM91y.iOu5RZqTbI.gYZpES.NQXU2Q5kWj/xztvSuB9TgiUO', '26ca8e004cb78c43dbab800e48308536', 0, 106, 1, 1, '8154b4b248ba31e@localhost.com', '2015-01-13 05:51:05', '2015-01-13 05:51:05', '8154b4b248ba32f'),
(46, '8254b4b296ac3bf@localhost.com', '8254b4b296ac3bf@localhost.com', '$2y$10$2eEKMZI4Kv4S0Y05CKBqZ.AKSfdphGqKtfOl.qmWM5y6DEp8Qar2q', '5023dce3775d0cbadd79082022e55b3c', 0, 107, 1, 1, '8254b4b296ac3bf@localhost.com', '2015-01-13 05:52:23', '2015-01-13 05:52:23', '3154b4b296ac3d0'),
(47, '1554b4b2ce983b9@localhost.com', '1554b4b2ce983b9@localhost.com', '$2y$10$QsvAj3l09EgRdh3f5bhF5uRchpKDqP0WZvpMdrnim371I7UEkBH0K', '3bc9a2b43d88c835b1055e705674513b', 0, 108, 1, 1, '1554b4b2ce983b9@localhost.com', '2015-01-13 05:53:19', '2015-01-13 05:53:19', '4754b4b2ce983c9'),
(48, 'u2@u.com', 'u2@u.com', '$2y$10$t/rzopd4eqU80Z2IHQAfK.dxQx2D50de1O.1ZaeD4ZL659tk3PGly', '214a187bc7c7de1feed3067b161331d5', 0, 109, 1, 0, 'u2@u.com', '2015-01-13 05:54:39', '2015-01-13 05:57:18', '$2y$10$t/rzopd4eqU80Z2IHQAfK.dxQx2D50de1O.1ZaeD4ZL659tk3PGly'),
(49, '3654b4b48fc2595@localhost.com', '3654b4b48fc2595@localhost.com', '$2y$10$9p4uvHeyo8knptoq05Z5G.iF0v7S8j44Uti3qfxgr/63seNLukhay', 'c37478cd269ffc00cb4126faa234754b', 0, 110, 1, 1, '3654b4b48fc2595@localhost.com', '2015-01-13 06:00:48', '2015-01-13 06:00:48', '8154b4b48fc25c6'),
(50, 'u3@u.com', 'u3@u.com', '$2y$10$Md2.KCi05fFhUxktqGB2AeYPjT1RzMqzxpRUdQkwIY2IZv7y2omIO', '31adb7a3c9da0c7e0fe138d2aac8fc52', 0, 111, 1, 0, 'u3@u.com', '2015-01-13 06:01:35', '2015-01-13 06:04:32', '$2y$10$Md2.KCi05fFhUxktqGB2AeYPjT1RzMqzxpRUdQkwIY2IZv7y2omIO'),
(51, '9454b4b632f0a7d@localhost.com', '9454b4b632f0a7d@localhost.com', '$2y$10$qre2w7VjLdXFKA7ZImWAa.TnDKrhgb6ehUR85qq1f0zdGXw11wKd6', '649ab8079e21023d7d497f10cf76354b', 0, 112, 1, 1, '9454b4b632f0a7d@localhost.com', '2015-01-13 06:07:22', '2015-01-13 06:07:47', '9454b4b632f0a99');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `families`
--
ALTER TABLE `families`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`), ADD KEY `GroupTypeID` (`GroupTypeID`), ADD KEY `FK_groups.file_id_files.id_idx` (`file_id`), ADD KEY `Groups.GroupTypeID_GroupTypes.Id_idx` (`person_id`), ADD KEY `FK_groups.family_id__families.id_idx` (`family_id`);

--
-- Indexes for table `grouptypes`
--
ALTER TABLE `grouptypes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_group`
--
ALTER TABLE `group_group`
 ADD PRIMARY KEY (`id`), ADD KEY `group_group_group_id_idx` (`group_id`), ADD KEY `group_group_member_group_id_idx` (`member_group_id`);

--
-- Indexes for table `group_person`
--
ALTER TABLE `group_person`
 ADD PRIMARY KEY (`id`), ADD KEY `GroupId_idx` (`group_id`), ADD KEY `FK_GroupMembers_PersonId_idx` (`role_id`), ADD KEY `FK_group_person.person_id__people.id_idx` (`person_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_notifications.person_id$people.id_idx` (`person_id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_people.file_id_files.id_idx` (`file_id`), ADD KEY `FK_people.file_id_files.id_idx1` (`family_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `roles_name_unique` (`name`), ADD KEY `FK_roles.grouptype_id_grouptypes.id_idx` (`grouptype_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_users.person_id__people.id_idx` (`person_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `grouptypes`
--
ALTER TABLE `grouptypes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `group_group`
--
ALTER TABLE `group_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `group_person`
--
ALTER TABLE `group_person`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
ADD CONSTRAINT `FK_groups.family_id__families.id` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_groups.file_id_files.id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_groups.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `Groups.GroupTypeID_GroupTypes.Id` FOREIGN KEY (`GroupTypeID`) REFERENCES `grouptypes` (`id`);

--
-- Constraints for table `group_group`
--
ALTER TABLE `group_group`
ADD CONSTRAINT `group_group_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
ADD CONSTRAINT `group_group_member_group_id` FOREIGN KEY (`member_group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `group_person`
--
ALTER TABLE `group_person`
ADD CONSTRAINT `FK_groups.id__group_person.id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
ADD CONSTRAINT `FK_group_person.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
ADD CONSTRAINT `FK_group_person.role_id_Roles.Id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
ADD CONSTRAINT `FK_notifications.person_id$people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `people`
--
ALTER TABLE `people`
ADD CONSTRAINT `FK_people.file_id_files.id` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
ADD CONSTRAINT `FK_roles.grouptype_id_grouptypes.id` FOREIGN KEY (`grouptype_id`) REFERENCES `grouptypes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `FK_users.person_id__people.id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`);
