-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 02:56:45
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
-- Base de datos: `archivose`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoradocumentos`
--

CREATE TABLE `bitacoradocumentos` (
  `bitacoraD_id` int(10) NOT NULL,
  `bitacoraD_expedienteid` int(10) NOT NULL,
  `bitacoraD_documentoid` int(10) NOT NULL,
  `bitacoraD_usuarioid` int(10) NOT NULL,
  `bitacoraD_movimiento` varchar(1) NOT NULL,
  `bitacoraD_fecha` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoraexpedientes`
--

CREATE TABLE `bitacoraexpedientes` (
  `bitacoraE_id` int(10) NOT NULL,
  `bitacoraE_expedienteId` int(10) NOT NULL,
  `bitacoraE_usuarioId` int(10) NOT NULL,
  `bitacoraE_movimiento` varchar(1) NOT NULL,
  `bitacoraE_fecha` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacorausuarios`
--

CREATE TABLE `bitacorausuarios` (
  `bitacoraU_id` int(10) NOT NULL,
  `bitacoraU_sesionid` int(10) NOT NULL,
  `bitacoraU_usuarioid` int(10) NOT NULL,
  `bitacoraU_movimiento` varchar(1) NOT NULL,
  `bitacoraU_fecha` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `documento_id` int(10) NOT NULL,
  `documento_expediente_id` int(10) NOT NULL,
  `documento_nombre` varchar(60) NOT NULL,
  `documento_archivo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente`
--

CREATE TABLE `expediente` (
  `expediente_id` int(10) NOT NULL,
  `expediente_numero` varchar(10) NOT NULL,
  `expediente_descripcion` varchar(60) NOT NULL,
  `expediente_clasificacion_archivistica` varchar(100) NOT NULL,
  `expediente_clasificacion_LFTAIPG` varchar(15) NOT NULL,
  `expediente_estado` varchar(15) NOT NULL,
  `expediente_fecha_apertura` date NOT NULL,
  `expediente_fecha_cierre` date DEFAULT NULL,
  `expediente_tiempo_tramite` int(2) NOT NULL,
  `expediente_tiempo_concentracion` int(2) NOT NULL,
  `expediente_tiempo_total` int(2) NOT NULL,
  `expediente_valor_documental` varchar(15) NOT NULL,
  `expediente_tradicion_documental` varchar(10) NOT NULL,
  `expediente_legajos` int(2) DEFAULT NULL,
  `expediente_observaciones` varchar(100) NOT NULL,
  `expediente_hojas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(50) DEFAULT NULL,
  `usuario_apellido` varchar(50) DEFAULT NULL,
  `usuario_usuario` varchar(50) DEFAULT NULL,
  `usuario_clave` varchar(50) DEFAULT NULL,
  `usuario_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_usuario`, `usuario_clave`, `usuario_email`) VALUES
(8, 'administrador', 'administrador', 'administrador', '2yKsb2aOUW04Y', 'administrador@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacoradocumentos`
--
ALTER TABLE `bitacoradocumentos`
  ADD PRIMARY KEY (`bitacoraD_id`);

--
-- Indices de la tabla `bitacoraexpedientes`
--
ALTER TABLE `bitacoraexpedientes`
  ADD PRIMARY KEY (`bitacoraE_id`);

--
-- Indices de la tabla `bitacorausuarios`
--
ALTER TABLE `bitacorausuarios`
  ADD PRIMARY KEY (`bitacoraU_id`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`documento_id`),
  ADD KEY `documento_expediente_id` (`documento_expediente_id`);

--
-- Indices de la tabla `expediente`
--
ALTER TABLE `expediente`
  ADD PRIMARY KEY (`expediente_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacoradocumentos`
--
ALTER TABLE `bitacoradocumentos`
  MODIFY `bitacoraD_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacoraexpedientes`
--
ALTER TABLE `bitacoraexpedientes`
  MODIFY `bitacoraE_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bitacorausuarios`
--
ALTER TABLE `bitacorausuarios`
  MODIFY `bitacoraU_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `documento_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `expediente`
--
ALTER TABLE `expediente`
  MODIFY `expediente_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
