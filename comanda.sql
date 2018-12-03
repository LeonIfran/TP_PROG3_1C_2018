-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2018 a las 07:28:09
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
  `cod_mesa` int(11) NOT NULL,
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

INSERT INTO `encuestas` (`cod_mesa`, `fecha`, `mesa`, `restaurante`, `mozo`, `cocinero`, `comentarios`) VALUES
(1000, '2018-12-02 02:21:26', 7, 8, 9, 10, 'la mesa se movia mucho'),
(10000, '2018-12-02 02:05:35', NULL, NULL, NULL, NULL, NULL),
(10000, '2018-12-02 02:06:02', NULL, NULL, NULL, NULL, NULL),
(10000, '2018-12-02 02:06:34', NULL, NULL, NULL, NULL, NULL);

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
(2, '2018-12-03 01:58:36');

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
(1000, 'cerrada'),
(1001, '“con clientes pagando'),
(10000, 'cerrada'),
(10001, 'con clientes esperando');

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
('2S4HD', 10001, 'merluza, vino', 'src/clases/fotos/10001_2S4HD.jpg'),
('A542E', 1000, 'Pizza, Sprite', 'aa.jpg'),
('AE85L', 1001, 'milanesa, papas fritas, brahma', 'src/clases/fotos/1001_AE85L.jpg'),
('AE86T', 1001, 'Grilled Cheese, burakki coffee', 'bb.jpg'),
('AE89B', 1001, 'milanesa, papas fritas, brahma', 'src/clases/fotos/1001_AE89B.jpg'),
('anPZV', 1000, 'sopa de tomato, empanadas, quilmes', 'src/clases/fotos/1000_anPZV.jpg'),
('B7E9A', 10000, 'hamburguesa triple, fanta', ''),
('D9GZJ', 1000, 'choripan, manaos', 'src/clases/fotos/1000_D9GZJ.jpg'),
('TY7oI', 1000, 'sopa de macaco, piña, tequila', 'src/clases/fotos/1000_TY7oI.jpg');

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
('2S4HD', 'merluza', 'cocina', 'en preparacion', '00:37:23', '2018-12-03 02:00:49', 3, '2018-12-03 02:22:59'),
('A542E', 'sprite', 'bar', 'listo para servir', '00:01:10', '2018-11-30 20:34:15', 2, '2018-12-03 02:31:01'),
('AE85L', 'choripan', 'cocina', 'terminado', '00:15:00', '2018-12-03 02:33:25', 3, '2018-12-03 02:40:00'),
('AE86T', 'sprite', 'bar', 'listo para servir', '00:12:00', '2018-12-03 02:35:42', 2, '2018-12-03 02:43:00'),
('AE89B', 'sprite', 'bar', 'terminado', '00:01:30', '2018-12-03 02:34:28', 2, '2018-12-03 02:35:00'),
('D9GZJ', 'coca', 'bar', 'en preparacion', '00:10:00', '2018-12-01 01:51:38', 3, NULL),
('D9GZJ', 'choripan', 'cocina', 'en preparacion', '00:17:00', '2018-11-30 23:30:49', 2, NULL),
('D9GZJ', 'manaos', 'bar', 'en preparacion', '00:10:00', '2018-12-01 00:34:49', 3, NULL),
('D9GZJ', 'sprite', 'bar', 'listo para servir', '00:10:00', '2018-12-03 02:35:42', 2, '2018-12-03 02:41:00'),
('TY7oI', 'tequila', 'bar', 'listo para servir', '00:11:13', '2018-12-01 00:30:47', 3, '2018-12-01 00:44:00');

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
  ADD PRIMARY KEY (`cod_mesa`,`fecha`);

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
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `cod_mesa` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;
--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `encuestas_ibfk_1` FOREIGN KEY (`cod_mesa`) REFERENCES `mesas` (`cod_mesa`);

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
