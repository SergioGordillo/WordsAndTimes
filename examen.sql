-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2020 a las 13:32:42
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examen`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombreCliente` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `direccion` varchar(90) DEFAULT NULL,
  `telefono` varchar(14) DEFAULT NULL,
  `nif` varchar(9) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombreCliente`, `apellidos`, `direccion`, `telefono`, `nif`, `email`) VALUES
(3, 'Joaquín1', 'Sánchez', 'Juandd', '678017350', '53146809L', 'joaquin_1919@hotmail.com'),
(12, 'Maria', 'Sanchez', 'Avenida Ancha', '875478964', '53146809L', 'maria@hotmail.com'),
(30, 'joaquin', 'sanchez', 'No tengo', '678017350', '75058508D', 'joaquin_1919@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `Palabra` varchar(30) NOT NULL,
  `Veces` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `idPrueba` int(11) NOT NULL,
  `nombrePrueba` varchar(45) DEFAULT NULL,
  `aparatosNecesarios` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `prueba`
--

INSERT INTO `prueba` (`idPrueba`, `nombrePrueba`, `aparatosNecesarios`, `descripcion`) VALUES
(1, 'Graduación', 'Refractometro', 'Prueba a realizar a los nuevos clientes.'),
(2, 'Paquiometria', 'Laser Escimer', 'MEdición Cornena'),
(3, 'Densiometria Cristalino', 'PetaZoom', 'Control Cataratas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pruebacliente`
--

CREATE TABLE `pruebacliente` (
  `prueba_idprueba` int(11) NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  `diagnostico` varchar(45) DEFAULT NULL,
  `fechaPrueba` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`Palabra`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`idPrueba`);

--
-- Indices de la tabla `pruebacliente`
--
ALTER TABLE `pruebacliente`
  ADD PRIMARY KEY (`prueba_idprueba`,`cliente_idCliente`,`fechaPrueba`),
  ADD KEY `fk_prueba-cliente_pruebas1_idx` (`prueba_idprueba`),
  ADD KEY `fk_prueba-cliente_cliente1_idx` (`cliente_idCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `idPrueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pruebacliente`
--
ALTER TABLE `pruebacliente`
  ADD CONSTRAINT `fk_prueba-cliente_cliente1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prueba-cliente_prueba1` FOREIGN KEY (`prueba_idprueba`) REFERENCES `prueba` (`idPrueba`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
