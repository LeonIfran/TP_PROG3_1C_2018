-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2018 a las 19:00:05
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--
CREATE DATABASE IF NOT EXISTS `comanda` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `comanda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id_encuesta` int(11) NOT NULL,
  `cod_mesa` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mesa` int(11) DEFAULT NULL,
  `restaurante` int(11) DEFAULT NULL,
  `mozo` int(11) DEFAULT NULL,
  `cocinero` int(11) DEFAULT NULL,
  `comentarios` varchar(66) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id_encuesta`, `cod_mesa`, `fecha`, `mesa`, `restaurante`, `mozo`, `cocinero`, `comentarios`) VALUES
(1, 10000, '2018-12-02 22:00:00', 8, 8, 8, 8, 'saadsdass'),
(2, 10001, '2018-12-03 00:00:00', 5, 5, 5, 5, 'asdsasdadsa'),
(3, 10001, '2018-11-29 00:00:00', 10, 6, 7, 9, 'dsasasd'),
(4, 10001, '2018-11-27 00:00:00', 5, 4, 2, 3, 'adsadsdas'),
(6, 10000, '2018-12-02 16:30:00', 3, 5, 4, 5, 'asddsadasdas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `num_factura` int(7) UNSIGNED ZEROFILL NOT NULL,
  `cod_mesa` int(5) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `importe` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`num_factura`, `cod_mesa`, `fecha`, `importe`) VALUES
(0000001, 10001, '2018-12-02 14:22:00', '500.00'),
(0000002, 10001, '2018-12-01 17:22:00', '999.99'),
(0000003, 10001, '2018-12-01 17:22:00', '999.99'),
(0000007, 10000, '2018-11-29 00:00:00', '100.00'),
(0000008, 10000, '2018-11-01 00:00:00', '200.00'),
(0000009, 10000, '2018-11-15 00:00:00', '250.00'),
(0000010, 10002, '2018-12-04 14:41:55', '345.30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logeos`
--

CREATE TABLE `logeos` (
  `id` int(11) NOT NULL,
  `fecha_logeo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `logeos`
--

INSERT INTO `logeos` (`id`, `fecha_logeo`) VALUES
(1, '2018-12-02 22:02:46'),
(1, '2018-12-02 22:05:26'),
(2, '2018-12-03 00:10:25'),
(2, '2018-12-03 01:58:36'),
(2, '2018-12-03 03:52:14'),
(2, '2018-12-04 00:58:44'),
(2, '2018-12-04 14:29:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `cod_mesa` int(5) NOT NULL,
  `estado_mesa` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`cod_mesa`, `estado_mesa`) VALUES
(10000, 'cerrada'),
(10001, 'con clientes esperando'),
(10002, 'cerrada'),
(10003, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `cod_pedido` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `cod_mesa` int(5) DEFAULT NULL,
  `desc_pedido` varchar(60) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `foto_mesa` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`cod_pedido`, `cod_mesa`, `desc_pedido`, `foto_mesa`) VALUES
('2S4HD', 10001, 'merluza, vino', 'src/clases/fotos/10001_2S4HD.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE `pedido_detalles` (
  `cod_pedido` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `item` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `area` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado_pedido` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tiempo_estimado` time DEFAULT '00:00:00',
  `tiempo_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) DEFAULT NULL,
  `tiempo_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedido_detalles`
--

INSERT INTO `pedido_detalles` (`cod_pedido`, `item`, `area`, `estado_pedido`, `tiempo_estimado`, `tiempo_inicio`, `id`, `tiempo_fin`) VALUES
('2S4HD', 'merluza', 'cocina', 'cancelado', '00:37:23', '2018-12-03 02:00:49', 3, '2018-12-03 02:22:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `perfil` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `perfil`, `usuario`, `pass`, `estado`) VALUES
(1, 'bartender', 'Pedr01', '1234', 'activo'),
(2, 'cocinero', 'roberto', 'qwerty', 'suspendido'),
(3, 'socio', 'Edson01', 'dragon', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `encuestas_fk_cod_mesa` (`cod_mesa`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`num_factura`),
  ADD KEY `cod_mesa` (`cod_mesa`);

--
-- Indices de la tabla `logeos`
--
ALTER TABLE `logeos`
  ADD PRIMARY KEY (`id`,`fecha_logeo`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`cod_mesa`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`cod_pedido`),
  ADD KEY `cod_mesa` (`cod_mesa`);

--
-- Indices de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD PRIMARY KEY (`cod_pedido`,`item`),
  ADD KEY `fk_id_personal` (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `num_factura` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `cod_mesa` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10004;
--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_fk_cod_mesa` FOREIGN KEY (`cod_mesa`) REFERENCES `mesas` (`cod_mesa`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cod_mesa`) REFERENCES `mesas` (`cod_mesa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `logeos`
--
ALTER TABLE `logeos`
  ADD CONSTRAINT `logeos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `personal` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cod_mesa`) REFERENCES `mesas` (`cod_mesa`);

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD CONSTRAINT `fk_id_personal` FOREIGN KEY (`id`) REFERENCES `personal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_detalles_ibfk_1` FOREIGN KEY (`cod_pedido`) REFERENCES `pedidos` (`cod_pedido`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
