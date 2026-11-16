-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2024 a las 07:51:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion-producto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_product`
--

CREATE TABLE `tbl_product` (
  `tbl_product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `tbl_supplier_id` int(11) NOT NULL,
  `purchase` int(11) NOT NULL,
  `selling` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_product`
--

INSERT INTO `tbl_product` (`tbl_product_id`, `product_name`, `tbl_supplier_id`, `purchase`, `selling`, `stock`, `date_updated`) VALUES
(1, 'Impresora Marka 123', 1, 100, 120, 25, '2024-05-25 12:53:12'),
(3, 'Ad Publicity', 3, 80, 100, 28, '2024-05-25 12:53:29'),
(4, 'Sistema Operativo Bestia', 4, 200, 220, 70, '2024-05-25 12:53:52'),
(5, 'Generador Corriente 234', 1, 90, 110, 40, '2024-05-25 12:54:12'),
(6, 'Bombilla Eco energy', 1, 120, 140, 55, '2024-05-25 12:54:31'),
(7, 'Movil Flip Tech', 2, 130, 150, 65, '2024-05-25 12:55:00'),
(8, 'Analitica Massive', 3, 70, 90, 35, '2024-05-25 12:55:13'),
(9, 'Calcurador Maniac', 4, 180, 200, 75, '2024-05-25 12:55:52'),
(10, 'AmigaTronic', 5, 110, 130, 45, '2024-05-25 12:56:05'),
(11, 'Luz de Citico', 1, 130, 150, 60, '2024-05-25 12:56:21'),
(12, 'Pantalla Look At', 2, 160, 180, 70, '2024-05-25 12:57:28'),
(22, 'Impresaora Green 123', 2, 180, 200, 80, '2024-05-25 12:52:54'),
(31, 'Procesador 526 Ghz', 8, 25000, 28000, 35, '2024-05-25 12:38:04'),
(32, 'Domaco', 2, 1258, 2000, 25, '2024-05-26 07:51:21'),
(33, 'Carmon', 10, 258, 300, 22, '2024-05-27 15:57:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `tbl_supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`tbl_supplier_id`, `supplier_name`, `supplier_contact`) VALUES
(1, 'HP', '3250812417'),
(2, 'Samsung', '3076548713'),
(3, 'Google', '3062587413'),
(4, 'Linus Torvalds', '3069857461'),
(5, 'Pexels', '3056859471'),
(8, 'Intel', '3026547895'),
(10, 'GaronaT', '3052586471');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `role`) VALUES
(3, 'configuroweb', '$2b$12$Ahn4RZdTECJL178Q5kAuEucJtReBsqbIyDxCCWHiBjinh8ggDZYy.', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`tbl_product_id`);

--
-- Indices de la tabla `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`tbl_supplier_id`);

--
-- Indices de la tabla `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `tbl_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `tbl_supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
