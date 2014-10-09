-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-09-2014 a las 05:54:04
-- Versión del servidor: 5.5.25-log
-- Versión de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `objetivos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GroupTypeID` int(10) unsigned NOT NULL,
  `JoinAuthOption` int(10) unsigned NOT NULL,
  `InviteAuthOption` int(10) unsigned NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `GroupTypeID` (`GroupTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `GroupName`, `GroupTypeID`, `JoinAuthOption`, `InviteAuthOption`, `Active`, `created_at`, `updated_at`) VALUES
(1, 'Olivas Orduño', 1, 2, 2, 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(2, 'Los García', 1, 2, 2, 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(3, 'Olivas Orduño', 4, 2, 2, 1, '2014-09-14 05:00:00', '0000-00-00 00:00:00'),
(4, 'Los García', 4, 2, 2, 1, '2014-09-14 05:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grouptypes`
--

CREATE TABLE `grouptypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `grouptypes`
--

INSERT INTO `grouptypes` (`id`, `GroupType`, `Active`, `created_at`, `updated_at`) VALUES
(1, 'Family', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(2, 'Community', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(3, 'Group', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(4, 'FamilyFriends', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_person`
--

CREATE TABLE `group_person` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `GroupId_idx` (`group_id`),
  KEY `UserId_idx` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `group_person`
--

INSERT INTO `group_person` (`id`, `group_id`, `person_id`, `admin`) VALUES
(6, 1, 32, 1),
(7, 1, 33, 1),
(8, 2, 34, 1),
(9, 3, 32, 1),
(10, 3, 33, 1),
(11, 4, 34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people`
--

CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mothersname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `cellphone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `user_id`, `role_id`, `photo`, `name`, `lastname`, `mothersname`, `date_of_birth`, `sex`, `cellphone`, `created_at`, `updated_at`) VALUES
(32, 1, 1, '', 'Carlos Daniel', 'Olivas', 'Barba', '0000-00-00', 1, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(33, 3, 2, '', 'Dorlhy', 'Orduño', 'Padilla', '1980-10-01', 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 4, 1, '', 'Daniel', 'Garcia', 'Valente', '1974-01-01', 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_code`, `confirmed`, `created_at`, `updated_at`) VALUES
(1, 'user1', 'user1@gmail.com', '$2y$10$OnhctX.vscpeAmv9.bHf/uyZMrxbC1ivCSfHN2TU01AQX4zEsR7.a', 'bfcde059ff2b2da7b92941736ce6e908', 1, '2014-05-25 23:45:50', '2014-05-25 23:45:50'),
(2, 'user2', 'user2@gmail.com', '$2y$10$wrLNiKN9dL3iaxsr5zJk8eqrA9wWMtJIGOGhNKJxst62/RlRV7m/i', '0b148ab1a4f8ca8dc0856a4a62858e4e', 1, '2014-05-26 00:00:35', '2014-05-26 00:00:35'),
(3, 'user3', 'user3@gmail.com', '$2y$10$KHgiSk3UYQOKXALy14q9Iu9WWvooQO1ETwwjRLuUyhN9U/nGiINau', 'e802c429c734cdd38f9f5f412d9fbebe', 1, '2014-09-22 00:30:44', '2014-09-22 00:30:44'),
(4, 'user4', 'user4@gmail.com', '$2y$10$72vRk6X4maFmkBrv1KXzLeW7Kj/nUmk07yx7/ZnUOU39OnalQxPGW', 'ab5946ae86d4d649c42030c9963fdd33', 1, '2014-09-22 01:04:42', '2014-09-22 01:04:42');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `Groups.GroupTypeID_GroupTypes.Id` FOREIGN KEY (`GroupTypeID`) REFERENCES `grouptypes` (`id`);

--
-- Filtros para la tabla `group_person`
--
ALTER TABLE `group_person`
  ADD CONSTRAINT `FK_GroupMembers_PersonId` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `GroupId` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
