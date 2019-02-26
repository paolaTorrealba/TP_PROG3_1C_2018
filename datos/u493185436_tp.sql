-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2019 a las 21:19:34
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u493185436_tp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_mesa` int(5) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `precio_final` float NOT NULL,
  `foto_mesa` mediumtext NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `tiempo_final` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `puntosMesa` int(2) NOT NULL,
  `puntosResto` int(2) NOT NULL,
  `puntosMozo` int(2) NOT NULL,
  `puntosCocinero` int(2) NOT NULL,
  `descripcion` varchar(66) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`puntosMesa`, `puntosResto`, `puntosMozo`, `puntosCocinero`, `descripcion`) VALUES
(9, 6, 7, 8, 'Muy buen servicio, recomendable, buenos precios'),
(9, 9, 9, 9, '\"muy rico\"'),
(9, 9, 9, 9, '\"muy rico\"'),
(9, 9, 9, 9, 'excelente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` bigint(2) UNSIGNED ZEROFILL NOT NULL,
  `estado` enum('cerrada','con clientes esperando pedido','con clientes comiendo','con clientes pagando') COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `estado`) VALUES
(01, 'con clientes pagando'),
(02, 'con clientes esperando pedido'),
(03, 'cerrada'),
(04, 'cerrada'),
(05, 'cerrada'),
(06, 'cerrada'),
(07, 'cerrada'),
(08, 'cerrada'),
(09, 'cerrada'),
(10, 'cerrada'),
(11, 'cerrada'),
(12, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `codigo` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` int(3) NOT NULL,
  `estado` enum('pendiente','en preparacion','listo para servir','servido','pagado','cancelado') COLLATE utf8_spanish2_ci NOT NULL,
  `imagen` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechaTerminado` datetime DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `mesa` bigint(5) NOT NULL,
  `precioFinal` bigint(11) NOT NULL,
  `tiempo` int(11) NOT NULL,
  `cliente` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`codigo`, `usuario`, `estado`, `imagen`, `fechaTerminado`, `fechaInicio`, `mesa`, `precioFinal`, `tiempo`, `cliente`) VALUES
('2xtee', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('3tVld', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('3v9Ob', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('6NvC0', 0, 'pendiente', 'nombreArchivo', NULL, NULL, 5, 0, 0, 'pepe'),
('7oWXr', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('8b2nB', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('8Jdu1', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('A554M', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('AAAAS', 1, 'pagado', '', '2019-02-01 09:00:00', '2019-02-01 00:00:00', 5, 1200, 1, 'Pedro'),
('Alv9f', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('AUIlS', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('AzGog', 0, 'pendiente', './fotos/pepe_AzGog.j', NULL, NULL, 5, 0, 0, 'pepe'),
('bsHsv', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('Cc9Xg', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('CyOcY', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('DDDER', 4, 'pagado', '', '2019-02-05 00:00:00', '2019-02-22 00:00:00', 4, 120, 3, 'Agustin'),
('dW4fJ', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('ej7SK', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('f7Wbq', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('fM7fb', 1, 'pagado', '', '2018-12-01 19:42:33', NULL, 1, 0, 0, 'Pepe'),
('fwDvR', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('g2r3o', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('GHYTR', 8, 'cancelado', '', '2019-02-28 11:00:00', '2019-02-28 00:00:00', 5, 800, 2, 'Josefina'),
('hqAoR', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('INuNM', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('iogNC', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('jQXhb', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('KgiV3', 0, 'pendiente', './fotos/pepe_KgiV3.j', NULL, NULL, 5, 0, 0, 'pepe'),
('Kke7E', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('ksFkV', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('LnBXK', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('M2n7k', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('MFyLs', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('MmbhV', 1, 'pendiente', '', '2018-12-01 18:48:57', NULL, 1, 50, 0, 'Andrea'),
('MWH7q', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Roxana'),
('mXd2E', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('NdvTt', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('NxnHd', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('Nxz3o', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('PgcI2', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('Py9uJ', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('qAakK', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('QkyoD', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('qLBdX', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('RDESA', 4, 'pagado', '', '2019-02-15 00:00:00', '2019-02-15 00:00:00', 5, 520, 2, 'Gerardo'),
('rQagv', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('RzvUa', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('s8Sxw', 0, 'pendiente', './fotos/pepe_s8Sxw.j', NULL, NULL, 5, 0, 0, 'pepe'),
('sDibF', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('sKJIp', 0, 'pendiente', NULL, NULL, NULL, 5, 0, 0, 'pepe'),
('sKl7v', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('SN5Oa', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('SSamf', 0, 'pendiente', './fotos/pepe_SSamf.j', NULL, NULL, 5, 0, 0, 'pepe'),
('t8efY', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('TtM6X', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('wAuHw', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'etekvina'),
('WlCwK', 0, 'pendiente', '', NULL, NULL, 4, 0, 0, 'Paola'),
('Xc9QR', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('xtGKO', 0, 'pendiente', NULL, NULL, NULL, 5, 0, 0, 'pepe'),
('y346z', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('YSRcJ', 0, 'pendiente', NULL, NULL, NULL, 5, 0, 0, 'pepe'),
('zaiU4', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('Zl75D', 0, 'pendiente', '', NULL, NULL, 5, 0, 0, 'pepe'),
('ZWS36', 0, 'pendiente', NULL, NULL, NULL, 5, 0, 0, 'pepe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_plato`
--

CREATE TABLE `pedido_plato` (
  `id` bigint(2) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `idPlato` int(2) NOT NULL,
  `estado` enum('pendiente','en preparacion','listo para servir','servido') NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` int(10) NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `tiempo` int(10) NOT NULL,
  `fechaTerminado` datetime NOT NULL,
  `usuario` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido_plato`
--

INSERT INTO `pedido_plato` (`id`, `codigo`, `idPlato`, `estado`, `cantidad`, `precio`, `fechaInicio`, `tiempo`, `fechaTerminado`, `usuario`) VALUES
(1, 'MmbhV', 1, 'pendiente', 2, 420, '2018-12-01 18:43:57', 10, '2018-12-01 18:53:57', 6),
(2, 'DDDER', 12, 'servido', 3, 120, '2019-02-15 00:00:00', 0, '2019-02-22 00:00:00', 4),
(3, 'GHYTR', 3, 'servido', 8, 120, '2019-02-15 00:00:00', 0, '2019-02-22 00:00:00', 4),
(4, 'GTHYJ', 7, 'servido', 4, 540, '2019-02-28 00:00:00', 5, '2019-02-28 00:00:00', 5),
(5, 'OPLIK', 1, 'pendiente', 7, 321, '2019-02-15 00:00:00', 3, '2019-02-13 00:00:00', 3),
(7, 'Cc9Xg', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(9, 'Alv9f', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(12, 'QkyoD', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(13, 'f7Wbq', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(14, 'f7Wbq', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(15, 'f7Wbq', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(16, 'Kke7E', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(17, 'Kke7E', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(18, 'Kke7E', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(19, 'hqAoR', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(20, 'hqAoR', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(21, 'hqAoR', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(22, 'g2r3o', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(23, 'g2r3o', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(24, 'g2r3o', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(25, 'qLBdX', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(26, 'qLBdX', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(27, 'qLBdX', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(28, 'M2n7k', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(29, 'M2n7k', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(30, 'M2n7k', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(31, 'Xc9QR', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(32, 'Xc9QR', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(33, 'Xc9QR', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(34, 'SN5Oa', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(35, 'SN5Oa', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(36, 'SN5Oa', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(37, 'AUIlS', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(38, 'AUIlS', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(39, 'AUIlS', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(40, 'Zl75D', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(41, 'Zl75D', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(42, 'Zl75D', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(43, 'zaiU4', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(44, 'zaiU4', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(45, 'zaiU4', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(46, '7oWXr', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(47, '7oWXr', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(48, '7oWXr', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(49, 'dW4fJ', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(50, 'dW4fJ', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(51, 'dW4fJ', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(52, 'Nxz3o', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(53, 'Nxz3o', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(54, 'Nxz3o', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(55, '3tVld', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(56, '3tVld', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(57, '3tVld', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(58, 'PgcI2', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(59, 'PgcI2', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(60, 'PgcI2', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(61, 'sKl7v', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(62, 'sKl7v', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(63, 'sKl7v', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(64, 'Iupea', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(65, 'Iupea', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(66, 'Iupea', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(67, 'MFyLs', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(68, 'MFyLs', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(69, 'MFyLs', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(70, 'sDibF', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(71, 'sDibF', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(72, 'sDibF', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(73, 'ksFkV', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(74, 'ksFkV', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(75, 'ksFkV', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(76, 'qAakK', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(77, 'qAakK', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(78, 'qAakK', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(79, 'ej7SK', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(80, 'ej7SK', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(81, 'ej7SK', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(82, 'NdvTt', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(83, 'NdvTt', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(84, 'NdvTt', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(85, 'FBIwj', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(86, 'FBIwj', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(87, 'FBIwj', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(88, 'bsHsv', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(89, 'bsHsv', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(90, 'bsHsv', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(91, 'sKJIp', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(92, 'sKJIp', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(93, 'sKJIp', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(94, 'YSRcJ', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(95, 'YSRcJ', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(96, 'YSRcJ', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(97, 'KgiV3', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(98, 'KgiV3', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(99, 'KgiV3', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(100, '6NvC0', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(101, '6NvC0', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(102, '6NvC0', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(103, 'ZWS36', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(104, 'ZWS36', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(105, 'ZWS36', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(106, 'SSamf', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(107, 'SSamf', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(108, 'SSamf', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(109, 's8Sxw', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(110, 's8Sxw', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(111, 's8Sxw', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(112, 'AzGog', 1, 'pendiente', 2, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(113, 'AzGog', 6, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(114, 'AzGog', 2, 'pendiente', 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato`
--

CREATE TABLE `plato` (
  `id` int(2) UNSIGNED ZEROFILL NOT NULL,
  `detalle` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `sector` enum('cocina','barra','cerveza','candy') COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`id`, `detalle`, `sector`, `precio`) VALUES
(01, 'pizza muzarella', 'cocina', 210),
(02, 'hamburgueza', 'cocina', 100),
(03, 'agua chica', 'barra', 50),
(04, 'copa helada', 'candy', 80),
(05, 'flan', 'candy', 65),
(06, 'cerveza negra chica', 'cerveza', 60),
(07, 'cerveza negra grande', 'cerveza', 80),
(08, 'cerveza rubia chica', 'cerveza', 55),
(09, 'cerveza rubia grande', 'cerveza', 75),
(10, 'ravioles verdura', 'cocina', 110),
(11, 'sorrentinos', 'cocina', 120),
(12, 'gaseosa chica', 'barra', 55),
(13, 'fernet', 'barra', 115),
(14, 'empanada carne', 'cocina', 35),
(15, 'provoleta', 'cocina', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

CREATE TABLE `sesion` (
  `id` int(2) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id`, `fechaHora`, `usuario`) VALUES
(4, '2019-02-25 13:10:01', 'Admin'),
(5, '2019-02-25 13:33:57', 'Admin'),
(6, '2019-02-25 14:35:34', 'Torrealba.Paola'),
(7, '2019-02-25 15:36:00', 'Torrealba.Paola'),
(8, '2019-02-25 16:37:39', 'Torrealba.Paola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(3) UNSIGNED ZEROFILL NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `perfil` enum('socio','mozo','cocinero','bartender','cervecero') COLLATE utf8_spanish2_ci NOT NULL,
  `estado` enum('activo','suspendido','eliminado','') COLLATE utf8_spanish2_ci DEFAULT 'activo',
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ult_fecha_log` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `perfil`, `estado`, `nombre`, `apellido`, `clave`, `ult_fecha_log`, `fecha_baja`, `fecha_alta`) VALUES
(001, 'Torrealba.Paola', 'socio', 'activo', 'Paola', 'Torrealba', '123', '2019-02-25 16:37:39', NULL, NULL),
(002, 'Anzaldo.Luis', 'mozo', 'activo', 'Luis', 'Anzaldo', '123', '2019-02-21 23:22:44', NULL, NULL),
(003, 'Alvarez.Ernesto', 'cocinero', 'activo', 'Ernesto', 'Alvarez', '456', NULL, NULL, NULL),
(004, 'Gomez.Mica', 'bartender', 'activo', 'Micaela', 'gomez', '456', NULL, NULL, NULL),
(005, 'Guillen.Mariela', 'cervecero', 'activo', 'Mariela', 'Guillen', '456', NULL, NULL, NULL),
(006, 'Gil.Sebastian', 'cocinero', 'activo', 'Sebastian', 'Gil', '123', '2019-02-17 10:42:44', NULL, NULL),
(007, 'Pais.Manuel', 'mozo', 'activo', 'Manuel', 'Pais', '123', '2019-02-21 23:40:46', NULL, NULL),
(010, 'Chermaz.Alberto', 'socio', 'activo', 'Alberto', 'Chermaz', '999', '2019-02-17 10:39:51', NULL, NULL),
(013, 'Beltran.Maria', 'socio', 'activo', 'Maria', 'Beltran', '123', NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `pedido_plato`
--
ALTER TABLE `pedido_plato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plato`
--
ALTER TABLE `plato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id_mesa` bigint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedido_plato`
--
ALTER TABLE `pedido_plato`
  MODIFY `id` bigint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
