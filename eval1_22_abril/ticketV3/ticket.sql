-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2025 a las 06:03:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ticket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE `asientos` (
  `asiento_cod` int(11) NOT NULL,
  `asiento` varchar(10) NOT NULL,
  `ocupado` tinyint(1) NOT NULL DEFAULT 0,
  `sector_cod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`asiento_cod`, `asiento`, `ocupado`, `sector_cod`) VALUES
(1, 'X39', 0, 4),
(2, 'Y35', 1, 4),
(3, 'V9', 0, 1),
(4, 'F4', 1, 2),
(5, 'I17', 1, 3),
(6, 'W4', 1, 3),
(7, 'K17', 1, 4),
(8, 'C8', 0, 4),
(9, 'Z34', 0, 1),
(10, 'N36', 0, 3),
(11, 'E38', 0, 4),
(12, 'U34', 1, 4),
(13, 'B15', 0, 2),
(14, 'H2', 0, 4),
(15, 'R8', 1, 1),
(16, 'U32', 1, 4),
(17, 'C46', 0, 3),
(18, 'O46', 1, 4),
(19, 'E41', 1, 2),
(20, 'F6', 1, 1),
(21, 'W34', 1, 4),
(22, 'R50', 1, 2),
(23, 'L25', 0, 3),
(24, 'O6', 1, 3),
(25, 'S39', 1, 4),
(26, 'K41', 1, 3),
(27, 'W7', 1, 1),
(28, 'S40', 1, 1),
(29, 'H15', 1, 1),
(30, 'J8', 1, 3),
(31, 'M37', 0, 2),
(32, 'M15', 0, 2),
(33, 'O4', 1, 3),
(34, 'M19', 0, 3),
(35, 'B4', 0, 4),
(36, 'S6', 0, 2),
(37, 'W32', 1, 4),
(38, 'R3', 0, 4),
(39, 'T2', 1, 2),
(40, 'G17', 1, 2),
(41, 'T5', 0, 4),
(42, 'U31', 1, 4),
(43, 'H30', 0, 2),
(44, 'F8', 0, 4),
(45, 'G8', 1, 1),
(46, 'W48', 0, 3),
(47, 'V16', 0, 3),
(48, 'N34', 1, 1),
(49, 'Q36', 1, 1),
(50, 'B7', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `reserva_cod` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `asiento_cod` int(11) NOT NULL,
  `usuario_cod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`reserva_cod`, `fecha`, `cliente`, `asiento_cod`, `usuario_cod`) VALUES
(1, '2025-04-10', 'cliente1', 9, 1),
(3, '2025-04-26', 'cliente1', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `sector_cod` int(11) NOT NULL,
  `sector` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`sector_cod`, `sector`) VALUES
(1, 'Platea'),
(2, 'Galería'),
(3, 'Cancha'),
(4, 'VIP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_cod` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `clave` varchar(15) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_cod`, `usuario`, `clave`, `activo`) VALUES
(1, 'jhon', '123', 1),
(2, 'luis', '123', 0),
(3, 'eliam', '123', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD PRIMARY KEY (`asiento_cod`),
  ADD KEY `sector_cod` (`sector_cod`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`reserva_cod`),
  ADD KEY `asiento_cod` (`asiento_cod`),
  ADD KEY `usuario_cod` (`usuario_cod`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`sector_cod`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_cod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asientos`
--
ALTER TABLE `asientos`
  MODIFY `asiento_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `reserva_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `sector_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD CONSTRAINT `asientos_ibfk_1` FOREIGN KEY (`sector_cod`) REFERENCES `sectores` (`sector_cod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`asiento_cod`) REFERENCES `asientos` (`asiento_cod`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`usuario_cod`) REFERENCES `usuarios` (`usuario_cod`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
