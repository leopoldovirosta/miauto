-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-08-2017 a las 23:43:25
-- Versión del servidor: 5.5.54-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `miauto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE IF NOT EXISTS `entradas` (
  `alias` char(15) COLLATE utf8_spanish_ci NOT NULL,
  `pagURL` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `numVisitas` mediumint(9) NOT NULL,
  `ultAcceso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`alias`,`ultAcceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`alias`, `pagURL`, `numVisitas`, `ultAcceso`) VALUES
('jesus', 'ver_usuario.php', 1, '2017-04-24 06:14:46'),
('jesus', 'registro_modelo.php', 2, '2017-04-24 06:15:25'),
('jesus', 'index.php', 2, '2017-04-24 06:15:28'),
('jesus', 'registro_mi_auto.php', 3, '2017-04-24 06:15:51'),
('jesus', 'registro_repostaje_previo.php', 1, '2017-04-24 06:16:03'),
('jesus', 'registro_repostaje.php', 6, '2017-04-24 06:22:06'),
('jesus', 'ver_mi_auto.php', 1, '2017-04-24 06:22:19'),
('jesus', 'ver_repostajes.php', 4, '2017-04-24 06:23:01'),
('jesus', 'ver_mi_repostaje.php', 4, '2017-04-24 06:23:08'),
('jesus', 'ver_repostajes_previo.php', 7, '2017-04-24 06:23:09'),
('jesus', 'ver_mis_autos.php', 5, '2017-04-24 06:23:12'),
('leo', 'buscar.php', 3, '2017-02-23 23:37:47'),
('leo', 'registro_mi_autoOLD.php', 3, '2017-04-04 22:16:26'),
('leo', 'ver_modelos.php', 161, '2017-04-16 02:49:50'),
('leo', 'ver_usuarios.php', 40, '2017-04-18 14:15:08'),
('leo', 'ver_usuario.php', 92, '2017-04-24 14:11:34'),
('leo', 'registro_modelo.php', 75, '2017-05-08 06:18:44'),
('leo', 'registro_mi_auto.php', 75, '2017-05-08 06:19:29'),
('leo', 'ver_modelo.php', 257, '2017-05-10 16:50:06'),
('leo', 'ver_mis_autos.php', 184, '2017-06-12 10:36:00'),
('leo', 'ver_mi_auto.php', 416, '2017-06-12 10:36:05'),
('leo', 'ver_mi_repostaje.php', 250, '2017-07-13 21:36:19'),
('leo', 'index.php', 269, '2017-07-21 23:50:50'),
('leo', 'registro_repostaje_previo.php', 24, '2017-07-21 23:50:57'),
('leo', 'registro_repostaje.php', 193, '2017-07-21 23:51:29'),
('leo', 'ver_repostajes_previo.php', 189, '2017-07-21 23:51:30'),
('leo', 'ver_repostajes.php', 519, '2017-07-21 23:51:39'),
('maria', 'ver_usuarios.php', 2, '2017-04-15 19:59:06'),
('maria', 'index.php', 1, '2017-04-15 19:59:07'),
('sergio', 'ver_usuario.php', 1, '2017-04-15 19:55:47'),
('sergio', 'index.php', 1, '2017-04-15 19:55:55'),
('test', 'ver_usuario.php', 1, '2017-04-22 22:08:03'),
('test', 'registro_modelo.php', 1, '2017-04-23 23:18:20'),
('test', 'ver_mi_repostaje.php', 47, '2017-04-23 23:19:10'),
('test', 'registro_repostaje_previo.php', 8, '2017-04-23 23:19:20'),
('test', 'registro_mi_auto.php', 5, '2017-05-03 22:14:52'),
('test', 'ver_mi_auto.php', 6, '2017-05-03 22:14:58'),
('test', 'ver_modelo.php', 5, '2017-05-03 22:15:06'),
('test', 'registro_repostaje.php', 65, '2017-05-03 22:15:53'),
('test', 'ver_repostajes_previo.php', 42, '2017-05-03 22:15:54'),
('test', 'ver_repostajes.php', 42, '2017-05-03 22:15:58'),
('test', 'index.php', 13, '2017-05-09 06:04:35'),
('test', 'ver_mis_autos.php', 15, '2017-05-09 06:04:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE IF NOT EXISTS `modelos` (
  `id_modelo` int(5) NOT NULL AUTO_INCREMENT,
  `nombre_modelo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `motorizacion` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `combustible` enum('Gasolina','Diesel','Hibrido') COLLATE utf8_spanish_ci NOT NULL,
  `potencia` int(3) unsigned DEFAULT NULL,
  `consumo_extraurbano` decimal(5,2) DEFAULT NULL,
  `consumo_mixto` decimal(5,2) DEFAULT NULL,
  `consumo_urbano` decimal(5,2) DEFAULT NULL,
  `emision_co2` int(3) unsigned DEFAULT NULL,
  `deposito` int(3) unsigned DEFAULT NULL,
  `cilindrada` int(4) unsigned DEFAULT NULL,
  `velocidades` int(1) unsigned DEFAULT NULL,
  `cambio` enum('Automatico','Manual') COLLATE utf8_spanish_ci NOT NULL,
  `fabricante` char(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id_modelo`, `nombre_modelo`, `motorizacion`, `combustible`, `potencia`, `consumo_extraurbano`, `consumo_mixto`, `consumo_urbano`, `emision_co2`, `deposito`, `cilindrada`, `velocidades`, `cambio`, `fabricante`, `imagen`) VALUES
(1, 'ZX Advantage Break', '1.4i', 'Gasolina', 75, 7.00, 8.00, 6.00, 123, 50, 1400, 5, 'Manual', 'cit', 'zx.jpeg'),
(3, 'Z4', '35is sDrive Automatic', 'Gasolina', 340, 12.00, 9.00, 7.00, 101, 56, 2979, 5, 'Manual', 'bmw', 'bmw_z4.jpg'),
(4, 'A6 Avant', '3.4 i V8 32V', 'Gasolina', 320, 12.00, 14.00, 16.00, 166, 88, 3405, 6, 'Manual', 'aud', 'audi_a6.jpg'),
(5, '159', '2.4 JTDM Q-Tronic', 'Gasolina', 200, 12.00, 8.00, 6.00, 156, 70, 2387, 5, 'Automatico', 'alf', 'alfa159.jpg'),
(6, 'Accord', '2.4 i-VTEC Automatic', 'Gasolina', 201, 12.00, 9.00, 7.00, 126, 65, 2354, 5, 'Automatico', 'hon', 'honda_accord.jpg'),
(7, 'Atos', '1.1i', 'Gasolina', 59, 7.00, 6.00, 5.00, 78, 35, 1086, 5, 'Manual', 'hyu', 'hyundai-atos.jpg'),
(8, 'V-class', 'V 250 BlueTEC G-Tronic', 'Diesel', 190, 7.00, 6.00, 5.00, 57, 89, 2143, 5, 'Automatico', 'mer', 'vclass.jpeg'),
(9, 'Tucson', '1200', 'Diesel', 65, 6.80, 7.10, 8.10, 99, 45, 0, 5, 'Automatico', 'hyu', 'hyundai_Tucson.jpg'),
(10, '206', 'iu injection', 'Gasolina', 65, 6.80, 7.10, 8.10, 99, 45, 1154, 5, 'Automatico', 'peu', 'peugeot_206.jpg'),
(11, 'El Dorado', 'Super gasolina', 'Gasolina', 200, 10.00, 15.00, 20.00, 199, 69, 3589, 5, 'Automatico', 'cad', 'cadillac.jpeg'),
(12, '124 Spider', '1.4 Turbo MultiAir', 'Gasolina', 170, 5.10, 6.40, 8.50, 148, 45, 1368, 6, 'Manual', 'aba', 'abarth_124_spider.jpeg'),
(13, 'Vantage Coupe Sportshift 3p', 'V8 ', 'Gasolina', 380, 10.60, 15.00, 22.50, 406, 77, 4280, 6, 'Automatico', 'ast', 'aston_martin_vantage.jpg'),
(15, '100', '2.6i', 'Gasolina', 150, 13.00, 8.00, 10.00, 154, 78, 2580, 5, 'Manual', 'aud', 'audi100.jpeg'),
(16, 'Clase A', '160 Elegance', 'Gasolina', 102, 5.70, 7.20, 9.90, 137, 54, 1598, 5, 'Manual', 'mer', 'mercedes_claseAelegance.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repostajes`
--

CREATE TABLE IF NOT EXISTS `repostajes` (
  `id_repostaje` int(10) NOT NULL AUTO_INCREMENT,
  `id_vehiculo` int(5) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `odometro` int(6) unsigned DEFAULT NULL,
  `odometro_final` int(6) NOT NULL,
  `combustible` enum('Diesel','Gasolina 95','Gasolina 98') COLLATE utf8_spanish_ci DEFAULT NULL,
  `cantidad` decimal(6,2) unsigned DEFAULT NULL,
  `precio_total` decimal(6,2) DEFAULT NULL,
  `precio_litro` decimal(5,2) DEFAULT NULL,
  `observaciones` text COLLATE utf8_spanish_ci,
  `estacion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consumo` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id_repostaje`),
  KEY `id_vehiculo` (`id_vehiculo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=105 ;

--
-- Volcado de datos para la tabla `repostajes`
--

INSERT INTO `repostajes` (`id_repostaje`, `id_vehiculo`, `fecha`, `odometro`, `odometro_final`, `combustible`, `cantidad`, `precio_total`, `precio_litro`, `observaciones`, `estacion`, `consumo`) VALUES
(7, 1, '2011-01-24', 72876, 73387, 'Gasolina 95', 42.75, 51.59, 1.20, '', 'Alcampo', 8.37),
(26, 14, '2017-04-23', 67986, 68586, 'Gasolina 95', 45.00, 0.00, 0.00, '', '', 7.50),
(30, 14, '2017-04-24', 68586, 69000, 'Gasolina 95', 56.00, 68.00, 1.18, 'Deposito lleno', 'Lobete', 13.53),
(31, 16, '2017-04-14', NULL, 120000, 'Gasolina 95', 1.00, 0.00, 0.00, '', '', 0.00),
(32, 17, '2017-05-04', 0, 12345, '', 0.00, 0.00, 0.00, '', '', 0.00),
(33, 17, '2017-05-03', 12345, 12987, 'Diesel', 44.00, 60.00, 1.16, 'Deposito lleno', 'La Estrella', 6.85),
(34, 1, '2011-02-05', 73387, 73648, 'Gasolina 95', 21.00, 25.03, 1.19, '', 'Alcampo', 8.05),
(35, 1, '2011-02-19', 73648, 74152, 'Gasolina 95', 41.26, 49.18, 1.19, '', 'Alcampo', 8.19),
(36, 1, '2011-03-03', 74152, 74457, 'Gasolina 95', 25.35, 31.23, 1.23, '', 'Alcampo', 8.31),
(37, 1, '2011-03-18', 74457, 74883, 'Gasolina 95', 35.50, 44.09, 1.24, '', 'Alcampo', 8.33),
(38, 1, '2011-04-08', 74883, 75382, 'Gasolina 95', 37.32, 47.80, 1.28, '', 'Alcampo', 7.48),
(39, 1, '2011-04-20', 75382, 75969, 'Gasolina 95', 40.41, 51.97, 1.28, '', 'Alcampo', 6.88),
(40, 1, '2011-04-30', 75969, 76299, 'Gasolina 95', 25.37, 32.75, 1.29, '', 'Alcampo', 7.69),
(41, 1, '2011-05-13', 76299, 76698, 'Gasolina 95', 28.65, 37.31, 1.30, '', 'Alcampo', 7.18),
(42, 1, '2011-05-25', 76698, 77278, 'Gasolina 95', 40.24, 49.98, 1.24, '', 'Alcampo', 6.94),
(43, 1, '2011-06-04', 77278, 77694, 'Gasolina 95', 29.81, 37.91, 1.27, '', 'Alcampo', 7.17),
(44, 1, '2011-06-26', 77694, 78149, 'Gasolina 95', 33.42, 41.17, 1.23, '', 'Alcampo', 7.35),
(45, 1, '2011-07-30', 78149, 78689, 'Gasolina 95', 38.33, 49.14, 1.28, '', 'Alcampo', 7.10),
(46, 1, '2011-09-09', 78689, 79179, 'Gasolina 95', 38.45, 49.14, 1.28, '', 'Alcampo', 7.85),
(47, 1, '2011-09-30', 79179, 79715, 'Gasolina 95', 39.99, 50.51, 1.26, '', 'Alcampo', 7.46),
(48, 1, '2011-10-26', 79715, 80192, 'Gasolina 95', 39.62, 50.00, 1.26, '', 'Alcampo', 8.31),
(49, 1, '2011-11-22', 80192, 80703, 'Gasolina 95', 40.65, 50.00, 1.23, '', 'Alcampo', 7.95),
(50, 1, '2011-12-19', 80703, 81291, 'Gasolina 95', 41.98, 52.31, 1.25, '', 'Alcampo', 7.14),
(51, 1, '2012-01-12', 81291, 81842, 'Gasolina 95', 42.27, 55.50, 1.31, '', 'Alcampo', 7.67),
(52, 1, '2012-02-19', 81842, 82424, 'Gasolina 95', 36.87, 50.00, 1.36, '', 'Alcampo', 6.34),
(53, 1, '2012-03-13', 82424, 82713, 'Gasolina 95', 26.68, 37.01, 1.39, '', 'Alcampo', 9.23),
(54, 1, '2012-03-30', 82713, 83297, 'Gasolina 95', 42.91, 61.70, 1.44, '', 'Alcampo', 7.35),
(55, 1, '2012-05-05', 83297, 83809, 'Gasolina 95', 36.05, 50.00, 1.39, '', 'Alcampo', 7.04),
(56, 1, '2012-05-24', 83809, 84381, 'Gasolina 95', 39.98, 53.85, 1.35, '', 'Alcampo', 6.99),
(57, 1, '2012-06-10', 84381, 84936, 'Gasolina 95', 36.75, 48.66, 1.32, '', 'Alcampo', 6.62),
(58, 1, '2012-06-24', 84936, 85556, 'Gasolina 95', 38.67, 50.00, 1.29, '', 'Alcampo', 6.24),
(59, 1, '2012-07-06', 85556, 85939, 'Gasolina 95', 26.13, 33.50, 1.28, '', 'Alcampo', 6.82),
(60, 1, '2012-07-10', 85939, 86597, 'Gasolina 95', 39.38, 53.01, 1.35, '', 'Alcampo', 5.98),
(61, 1, '2012-07-15', 86597, 87245, 'Gasolina 95', 40.33, 54.28, 1.35, '', 'Alcampo', 6.22),
(62, 1, '2012-07-31', 87245, 87861, 'Gasolina 95', 39.51, 53.85, 1.36, '', 'Alcampo', 6.41),
(63, 1, '2012-08-11', 87861, 88233, 'Gasolina 95', 21.03, 29.29, 1.39, '', 'Alcampo', 5.65),
(64, 1, '2012-08-15', 88233, 88792, 'Gasolina 95', 14.36, 20.00, 1.39, '', 'Alcampo', 2.57),
(65, 1, '2012-09-02', 88792, 89043, 'Gasolina 95', 3.47, 5.00, 1.44, '', 'Alcampo', 1.38),
(66, 1, '2014-11-12', 89043, 89098, 'Gasolina 95', 49.25, 59.75, 1.21, '', 'Alcampo', 89.55),
(67, 1, '2015-01-03', 89098, 89646, 'Gasolina 95', 39.22, 40.00, 1.02, '', 'Alcampo', 7.16),
(68, 1, '2015-02-01', 89646, 90131, 'Gasolina 95', 32.64, 37.00, 1.13, '', 'Las Gaunas', 6.73),
(69, 1, '2015-03-08', 90131, 90622, 'Gasolina 95', 34.43, 43.00, 1.25, '', 'Briones Cepsa', 7.01),
(70, 1, '2015-04-03', 90622, 91055, 'Gasolina 98', 30.46, 42.00, 1.38, '', 'Las Gaunas', 7.03),
(71, 1, '2015-04-23', 91055, 91579, 'Gasolina 98', 33.95, 48.00, 1.41, '', 'Las Gaunas', 6.48),
(72, 1, '2015-05-10', 91579, 91850, 'Gasolina 98', 17.49, 25.00, 1.43, '', 'Las Gaunas', 6.45),
(73, 1, '2015-05-28', 91850, 92407, 'Gasolina 98', 34.05, 49.00, 1.44, '', 'Las Gaunas', 6.11),
(74, 1, '2015-06-19', 92407, 92850, 'Gasolina 98', 17.14, 25.00, 1.43, '', 'Las Gaunas', 3.87),
(75, 1, '2015-07-02', 92850, 93078, 'Gasolina 98', 26.23, 38.01, 1.45, '', 'Las Gaunas', 11.50),
(76, 1, '2015-07-16', 93078, 93590, 'Gasolina 98', 34.10, 48.01, 1.41, '', 'Las Gaunas', 6.66),
(77, 1, '2015-08-23', 93590, 94033, 'Gasolina 98', 30.58, 40.61, 1.33, '', 'Las Gaunas', 6.90),
(78, 1, '2015-10-03', 94033, 94394, 'Gasolina 98', 27.95, 36.00, 1.29, '', 'Las Gaunas', 7.74),
(79, 1, '2015-10-03', 94394, 94960, 'Gasolina 98', 37.08, 47.02, 1.27, '', 'Las Gaunas', 6.55),
(80, 1, '2015-12-25', 94960, 95415, 'Gasolina 98', 39.10, 48.01, 1.23, '', 'Las Gaunas', 8.59),
(81, 1, '2016-02-21', 95415, 95839, 'Gasolina 98', 35.36, 41.65, 1.18, '', 'Las Gaunas', 8.34),
(82, 1, '2016-03-16', 95839, 96321, 'Gasolina 98', 35.70, 44.20, 1.24, '', 'Las Gaunas', 7.41),
(83, 1, '2016-04-17', 96321, 96726, 'Gasolina 98', 33.39, 43.00, 1.29, '', 'Las Gaunas', 8.24),
(84, 1, '2016-05-01', 96726, 97262, 'Gasolina 98', 35.93, 47.00, 1.28, '', 'Las Gaunas', 6.70),
(85, 1, '2016-05-29', 97262, 97743, 'Gasolina 98', 36.60, 48.60, 1.33, '', 'Las Gaunas', 7.61),
(86, 1, '2016-07-03', 97743, 98228, 'Gasolina 98', 36.78, 47.00, 1.28, '', 'Las Gaunas', 7.58),
(87, 1, '2016-07-25', 98228, 98777, 'Gasolina 98', 39.82, 48.50, 1.22, '', 'Las Gaunas', 7.25),
(88, 1, '2016-08-15', 98777, 99275, 'Gasolina 98', 28.37, 36.00, 1.27, '', 'Las Gaunas', 5.70),
(89, 1, '2016-09-09', 99275, 99850, 'Gasolina 98', 32.94, 41.80, 1.27, '', 'Las Gaunas', 5.73),
(90, 1, '2016-09-23', 99850, 100361, 'Gasolina 98', 28.19, 36.06, 1.28, '', 'Las Gaunas', 5.52),
(91, 1, '2016-10-02', 100361, 100810, 'Gasolina 98', 28.15, 36.00, 1.28, '', 'Las Gaunas', 6.27),
(92, 1, '2016-10-15', 100810, 101418, 'Gasolina 98', 34.65, 45.01, 1.30, '', 'Las Gaunas', 5.70),
(93, 1, '2016-12-26', 101418, 101854, 'Gasolina 98', 36.52, 50.00, 1.37, '', 'Las Gaunas', 8.38),
(94, 1, '2017-01-22', 101854, 102282, 'Gasolina 98', 35.10, 47.00, 1.34, '', 'Las Gaunas', 8.20),
(95, 1, '2017-02-11', 102282, 102762, 'Gasolina 98', 36.79, 50.00, 1.36, '', 'Las Gaunas', 7.66),
(96, 1, '2017-03-05', 102762, 103272, 'Gasolina 98', 35.65, 48.80, 1.37, '', 'Las Gaunas', 6.99),
(97, 1, '2017-04-02', 103272, 103792, 'Gasolina 98', 37.25, 51.00, 1.37, '', 'Las Gaunas', 7.16),
(100, 1, '2017-05-05', 103792, 104343, 'Gasolina 98', 40.66, 53.63, 1.32, '', 'Las Gaunas', 7.38),
(101, 1, '2017-06-12', 104343, 104880, 'Gasolina 98', 39.40, 50.00, 1.27, '', 'Las Gaunas', 7.34),
(102, 1, '2017-07-07', 104880, 105470, 'Gasolina 98', 38.74, 50.32, 1.30, '', 'Las Gaunas', 6.57),
(103, 1, '2017-07-14', 105470, 105978, 'Gasolina 98', 31.02, 37.50, 1.21, '', 'Las Gaunas', 6.11),
(104, 1, '2017-07-21', 105978, 106584, 'Gasolina 98', 39.09, 50.00, 1.28, '', 'Las Gaunas', 6.45);

--
-- Disparadores `repostajes`
--
DROP TRIGGER IF EXISTS `insertar_repostaje`;
DELIMITER //
CREATE TRIGGER `insertar_repostaje` AFTER INSERT ON `repostajes`
 FOR EACH ROW UPDATE vehiculos SET repostajes = repostajes+1 WHERE id_vehiculo = NEW.id_vehiculo
//
DELIMITER ;
DROP TRIGGER IF EXISTS `restar_repostaje`;
DELIMITER //
CREATE TRIGGER `restar_repostaje` AFTER DELETE ON `repostajes`
 FOR EACH ROW UPDATE vehiculos SET repostajes = repostajes-1 WHERE id_vehiculo = OLD.id_vehiculo
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `alias` char(15) CHARACTER SET latin1 NOT NULL,
  `clave` char(41) COLLATE utf8_spanish_ci NOT NULL,
  `antiguedad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nombre` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp` char(5) CHARACTER SET latin1 DEFAULT NULL,
  `localidad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` char(9) CHARACTER SET latin1 DEFAULT NULL,
  `web` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` enum('M','F') CHARACTER SET latin1 NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`alias`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`alias`, `clave`, `antiguedad`, `nombre`, `apellidos`, `direccion`, `cp`, `localidad`, `email`, `telefono`, `web`, `sexo`, `admin`) VALUES
('jesus', '*1F2DD777CB33BA893B0479FF76FDAD10C82C61F2', '2017-04-24 06:12:52', 'jesus', 'esteban', '', '', 'logroÃ±o', 'jesus', '', '', 'M', 0),
('leo', '*A4B6157319038724E3560894F7F932C8886EBFCF', '2017-04-18 19:24:51', 'Leopoldo', 'Virosta Ruiz', 'Alfonso VI 12 3B', '26007', 'Logrono', 'leopoldovirosta@ono.com', '677641241', 'https://leo.blogsyte.com', 'M', 1),
('test', '*A4B6157319038724E3560894F7F932C8886EBFCF', '2017-04-22 22:07:19', 'Test', 'para pruebas', '', '', 'LogroÃ±o', 'test', '', '', 'M', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id_vehiculo` int(5) NOT NULL AUTO_INCREMENT,
  `alias` char(15) CHARACTER SET latin1 NOT NULL,
  `tipo` enum('automovil','motocicleta','quad','comercial') COLLATE utf8_spanish_ci NOT NULL,
  `id_modelo` int(5) NOT NULL,
  `color` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `manufacturado` date DEFAULT NULL,
  `odometro` int(10) unsigned NOT NULL,
  `repostajes` int(4) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_vehiculo`),
  KEY `alias` (`alias`),
  KEY `id_modelo` (`id_modelo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `alias`, `tipo`, `id_modelo`, `color`, `manufacturado`, `odometro`, `repostajes`, `imagen`) VALUES
(1, 'leo', 'automovil', 1, 'Granate', '1995-11-25', 0, 70, 'zx.jpg'),
(14, 'test', 'automovil', 13, 'Gris', '1999-01-01', 0, 2, 'aston_martin_vantage.jpg'),
(16, 'jesus', 'automovil', 16, 'rojo', '2009-01-01', 0, 1, ''),
(17, 'test', 'automovil', 8, 'Negro', '2013-11-05', 12345, 2, 'vclass.jpeg');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `repostajes`
--
ALTER TABLE `repostajes`
  ADD CONSTRAINT `repostajes_ibfk_1` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`alias`) REFERENCES `usuarios` (`alias`),
  ADD CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id_modelo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
