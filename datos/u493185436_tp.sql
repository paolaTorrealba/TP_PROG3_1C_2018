-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2019 a las 17:00:52
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
  `imagen` mediumtext COLLATE utf8_spanish2_ci,
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
('AAAAS', 1, 'pagado', NULL, '2019-02-01 09:00:00', '2019-02-01 00:00:00', 5, 1200, 1, 'Pedro'),
('DDDER', 4, 'pagado', NULL, '2019-02-05 00:00:00', '2019-02-22 00:00:00', 4, 120, 3, 'Agustin'),
('fM7fb', 1, 'pagado', NULL, '2018-12-01 19:42:33', NULL, 1, 0, 0, 'Pepe'),
('GHYTR', 8, 'cancelado', NULL, '2019-02-28 11:00:00', '2019-02-28 00:00:00', 5, 800, 2, 'Josefina'),
('MmbhV', 1, 'pendiente', NULL, '2018-12-01 18:48:57', NULL, 1, 50, 0, 'Andrea'),
('RDESA', 4, 'pagado', NULL, '2019-02-15 00:00:00', '2019-02-15 00:00:00', 5, 520, 2, 'Gerardo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

CREATE TABLE `pedido_producto` (
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
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`id`, `codigo`, `idPlato`, `estado`, `cantidad`, `precio`, `fechaInicio`, `tiempo`, `fechaTerminado`, `usuario`) VALUES
(1, 'MmbhV', 1, 'pendiente', 2, 420, '2018-12-01 18:43:57', 10, '2018-12-01 18:53:57', 6),
(2, 'DDDER', 12, 'servido', 3, 120, '2019-02-15 00:00:00', 0, '2019-02-22 00:00:00', 4),
(3, 'GHYTR', 3, 'servido', 8, 120, '2019-02-15 00:00:00', 0, '2019-02-22 00:00:00', 4),
(4, 'GTHYJ', 7, 'servido', 4, 540, '2019-02-28 00:00:00', 5, '2019-02-28 00:00:00', 5),
(5, 'OPLIK', 1, 'pendiente', 7, 321, '2019-02-15 00:00:00', 3, '2019-02-13 00:00:00', 3);

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
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id`, `fecha`, `hora`, `usuario`) VALUES
(1, '2019-02-01', '11:04:00', '1'),
(2, '2019-02-03', '10:00:00', '2'),
(3, '2019-02-03', '12:00:00', '2');

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
(001, 'Admin', 'socio', 'activo', 'Nicolas', 'Gomez', '123', '2019-02-25 14:46:46', NULL, NULL),
(002, 'perez.jose', 'mozo', 'activo', 'Pepe', 'Perez', '123', '2019-02-21 23:22:44', NULL, NULL),
(003, 'Alvarez.Ernesto', 'cocinero', 'activo', 'Ernesto', 'Alvarez', '456', NULL, NULL, NULL),
(004, 'Gomez.Mica', 'bartender', 'activo', 'Micaela', 'gomez', '456', NULL, NULL, NULL),
(005, 'Guillen.Mariela', 'cervecero', 'activo', 'Mariela', 'Guillen', '456', NULL, NULL, NULL),
(006, 'Gil.Sebastian', 'cocinero', 'activo', 'Sebastian', 'Gil', '123', '2019-02-17 10:42:44', NULL, NULL),
(007, 'Pais.Manuel', 'mozo', 'activo', 'Manuel', 'Pais', '123', '2019-02-21 23:40:46', NULL, NULL),
(010, 'Torres.Paola', 'socio', 'activo', 'Paola', 'Torrealba', '999', '2019-02-17 10:39:51', NULL, NULL),
(013, 'BeltranMaria', 'socio', 'activo', 'Maria', 'Beltran', '123', NULL, NULL, NULL);

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
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
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
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `id` bigint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `id` int(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sesion`
--
ALTER TABLE `sesion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
