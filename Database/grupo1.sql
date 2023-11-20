-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2023 a las 15:17:47
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `grupo1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombres`, `apellidos`, `dni`, `telefono`, `email`, `fecha_registro`) VALUES
(11, 'Carlos', 'Perez', '11223344A', '555-1234', 'carlos@example.com', '2023-11-20'),
(12, 'Ana', 'Martinez', '22334455B', '555-5678', 'ana@example.com', '2023-11-20'),
(13, 'Luis', 'Gonzalez', '33445566C', '555-9012', 'luis@example.com', '2023-11-20'),
(14, 'Elena', 'Rodriguez', '44556677D', '555-3456', 'elena@example.com', '2023-11-20'),
(15, 'Javier', 'Lopez', '55667788E', '555-7890', 'javier@example.com', '2023-11-20'),
(16, 'Isabel', 'Sanchez', '66778899F', '555-2345', 'isabel@example.com', '2023-11-20'),
(17, 'Miguel', 'Fernandez', '77889900G', '555-6789', 'miguel@example.com', '2023-11-20'),
(18, 'Laura', 'Gomez', '88990011H', '555-1234', 'laura@example.com', '2023-11-20'),
(19, 'Pablo', 'Martin', '99001122I', '555-5678', 'pablo@example.com', '2023-11-20'),
(20, 'Carmen', 'Diaz', '00112233J', '555-9012', 'carmen@example.com', '2023-11-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_pedido` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `direccion`, `fecha_pedido`, `estado`, `detalle`, `idCliente`) VALUES
(11, 'Calle 1, Ciudad A', '2023-11-21', 'Pendiente', 'Pedido 1', 11),
(12, 'Avenida 2, Ciudad B', '2023-11-22', 'En Proceso', 'Pedido 2', 12),
(13, 'Plaza 3, Ciudad C', '2023-11-23', 'Entregado', 'Pedido 3', 13),
(14, 'Carrera 4, Ciudad D', '2023-11-24', 'Pendiente', 'Pedido 4', 14),
(15, 'Camino 5, Ciudad E', '2023-11-25', 'En Proceso', 'Pedido 5', 15),
(16, 'Ruta 6, Ciudad F', '2023-11-26', 'Entregado', 'Pedido 6', 16),
(17, 'Autopista 7, Ciudad G', '2023-11-27', 'Pendiente', 'Pedido 7', 17),
(18, 'Carretera 8, Ciudad H', '2023-11-28', 'En Proceso', 'Pedido 8', 18),
(19, 'Aeropuerto 9, Ciudad I', '2023-11-29', 'Entregado', 'Pedido 9', 19),
(20, 'Terminal 10, Ciudad J', '2023-11-30', 'Pendiente', 'Pedido 10', 20);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idCliente` (`idCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `Pedidos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
