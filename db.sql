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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;
-- 
-- Volcado de datos para la tabla `groups`
-- 
INSERT INTO `groups` (`id`, `GroupName`, `GroupTypeID`, `JoinAuthOption`, `InviteAuthOption`, `Active`, `created_at`, `updated_at`) VALUES
(1, 'Los simpsons', 1, 2, 2, 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00'),
(2, 'Los Van Houten', 1, 2, 2, 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;
-- 
-- Volcado de datos para la tabla `grouptypes`
-- 
INSERT INTO `grouptypes` (`id`, `GroupType`, `Active`, `created_at`, `updated_at`) VALUES
(1, 'Family', 1, '2014-09-15 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;
-- 
-- Volcado de datos para la tabla `group_person`
-- 
INSERT INTO `group_person` (`id`, `group_id`, `person_id`, `admin`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),

(6, 2, 6, 1),
(7, 2, 7, 1),
(8, 2, 8, 1);
-- --------------------------------------------------------
-- 
-- Estructura de tabla para la tabla `people`
-- 
CREATE TABLE `people` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) DEFAULT NULL,
`role_id` int(11) NOT NULL DEFAULT '1',
`file_id` int(11),
`email` varchar(255),
`photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`mothersname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`birthdate` date NOT NULL,
`gender` tinyint(1) NOT NULL DEFAULT '0',
`phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;
-- 
-- Volcado de datos para la tabla `people`
-- 
INSERT INTO `people` (`id`, `user_id`, `role_id`, `photo`, `name`, `lastname`, `mothersname`, `birthdate`, `gender`, `phone`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, '', 'Homero', 'Simpson', 'Bouvier', '0000-00-00', 1, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(2, NULL, 2, '', 'Marge', 'Bouvier', '', '0000-00-00', 2, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(3, NULL, 3, '', 'Bart', 'Simpson', '', '0000-00-00', 1, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(4, NULL, 3, '', 'Lisa', 'Simpson', 'Bouvier', '0000-00-00', 2, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(5, NULL, 3, '', 'Maggie', 'Simpson', 'Bouvier', '0000-00-00', 2, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),

(6, NULL, 1, '', 'Kirk', 'Van Houten', '', '0000-00-00', 1, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(7, NULL, 2, '', 'Luann', 'Van Houten', '', '0000-00-00', 2, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00'),
(8, NULL, 3, '', 'Milhouse', 'Van Houten', '', '0000-00-00', 1, '', '2014-09-17 00:00:00', '2014-09-17 00:00:00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;
-- 
-- Volcado de datos para la tabla `users`
-- 
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