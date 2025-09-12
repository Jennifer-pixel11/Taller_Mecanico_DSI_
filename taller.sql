-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2025 a las 06:14:25
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
-- Base de datos: `taller`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `id_mecanico` int(11) DEFAULT NULL,
  `cliente` varchar(100) DEFAULT NULL,
  `vehiculo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `servicio` varchar(100) DEFAULT NULL,
  `estado` enum('Pendiente','Confirmada','Completada','Cancelada') DEFAULT 'Pendiente',
  `servicio_id` int(11) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `cliente_id`, `vehiculo_id`, `id_mecanico`, `cliente`, `vehiculo`, `descripcion`, `fecha`, `hora`, `servicio`, `estado`, `servicio_id`, `usuario`) VALUES
(14, 2, 2, 3, NULL, NULL, 'Mantenimiento preventivo', '2025-09-11', '10:30:00', NULL, 'Completada', 1, NULL),
(15, 3, 3, 3, NULL, NULL, 'Revisión de liquido de frenos', '2025-08-14', '11:30:00', NULL, 'Completada', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `telefono`, `correo`, `direccion`) VALUES
(2, 'José Fuentes', '75775623', 'JoseF123@gmail.com', '1° Calle Oriente, B. La Cruz'),
(3, 'Maria Alvarenga ', '72901634', 'mari123@gmail.com', 'Av. los Laureles, Barrio Jocotal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `fecha_emision` date NOT NULL DEFAULT curdate(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id`, `servicio_id`, `numero`, `fecha_emision`, `total`) VALUES
(1, 6, 'FACT-0001', '2025-09-11', 70.00),
(2, 6, 'FACT-0002', '2025-09-11', 70.00),
(3, 7, 'FACT-0003', '2025-09-11', 0.00),
(4, 7, 'FACT-0004', '2025-09-11', 0.00),
(5, 7, 'FACT-0005', '2025-09-11', 45.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_servicios`
--

CREATE TABLE `historial_servicios` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT 5,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `nombre`, `descripcion`, `cantidad`, `cantidad_minima`, `precio`, `imagen`, `fecha_modificacion`, `id_proveedor`) VALUES
(12, 'Aceite valvoline', 'aceite', 28, 5, 25.00, 'uploads/aceite.png', '2025-06-16 22:36:35', 4),
(13, 'Copa de auto', 'Toyota', 16, 5, 32.00, 'uploads/copa.webp', '2025-06-15 22:51:57', 4),
(14, 'Limpieza', 'Articulos de limpieza', 23, 5, 15.00, 'uploads/Imagen2.jpg', '2025-09-07 16:07:03', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mecanicos`
--

CREATE TABLE `mecanicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mecanicos`
--

INSERT INTO `mecanicos` (`id`, `nombre`, `especialidad`, `telefono`) VALUES
(1, 'luis', 'gerente', '12345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `destinatario` varchar(100) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `destinatario`, `mensaje`, `fecha_envio`) VALUES
(1, 'Jennifer Argueta', 'Cambio de aceite pendiente', '2025-06-09 05:42:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_insumos`
--

CREATE TABLE `proveedor_insumos` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `rubro` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'Activo',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor_insumos`
--

INSERT INTO `proveedor_insumos` (`id_proveedor`, `nombre`, `nombre_contacto`, `telefono`, `correo_electronico`, `direccion`, `rubro`, `estado`, `fecha_registro`) VALUES
(1, 'Insumos El Motor', 'Carlos Méndez', '7744-8899', 'cmendez@motorinsumos.com', 'Av. Central #45, San Salvador', 'Repuestos', 'Activo', '2025-06-15 15:08:54'),
(4, 'Excel automotriz', 'alberto', '12345678', 'alberto@gmail.com', 'san salvador', 'Insumos', 'Activo', '2025-06-15 16:51:15'),
(5, 'super repuestos', 'Juan', '12345678', 'juan@gmail.com', 'San Martin', 'Automotriz', 'Activo', '2025-06-15 23:24:06'),
(6, 'Prueba Proveedor', 'Kevin', '25014876', 'Kevin25@gmail.com', 'Suchitoto', 'Automotriz', 'Activo', '2025-06-17 04:35:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparaciones`
--

CREATE TABLE `reparaciones` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `mecanico_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `descripcion` text DEFAULT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparacion_repuestos`
--

CREATE TABLE `reparacion_repuestos` (
  `id` int(11) NOT NULL,
  `reparacion_id` int(11) NOT NULL,
  `repuesto_id` int(11) NOT NULL,
  `cantidad_usada` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparacion_servicios`
--

CREATE TABLE `reparacion_servicios` (
  `id` int(11) NOT NULL,
  `reparacion_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `vehiculo_id`, `descripcion`, `fecha`, `costo`) VALUES
(6, 2, 'Mantenimiento preventivo', '2025-09-11', 70.00),
(7, 3, 'Revisión de liquido de frenos', '2025-08-14', 45.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_catalogo`
--

CREATE TABLE `servicios_catalogo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_catalogo`
--

INSERT INTO `servicios_catalogo` (`id`, `nombre`) VALUES
(1, 'Cambio de aceite'),
(2, 'Alineación'),
(3, 'Balanceo'),
(4, 'Revisión de frenos'),
(5, 'Cambio del filtro de gasolina y aire'),
(6, 'Cambio del refrigerante'),
(7, 'Cambio de la faja del alternador'),
(8, 'Ajuste del tiempo de encendido'),
(9, 'Revisión de las luces y los faros'),
(10, 'Ajuste del clutch');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL DEFAULT 'sin_correo@example.com',
  `telefono` varchar(15) DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `rol` enum('Gerente','Mecánico','Visitante') NOT NULL DEFAULT 'Visitante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `correo`, `telefono`, `clave`, `fecha_creacion`, `rol`) VALUES
(1, 'Jose', 'sin_correo@example.com', NULL, '$2y$10$aQY5aRYhGdfSwIUcFYLNaembiMc4JJ8tk94gdPO9IaLAS/flPqofi', '2025-06-15 15:37:58', 'Visitante'),
(2, 'Jennifer', 'sin_correo@example.com', NULL, '$2y$10$CiIXmgVhq2Dpdl7TxUjcVehe8EOtliodQrScxLwRusTQWLGh0QuVW', '2025-06-15 15:37:58', 'Gerente'),
(3, 'Juan Mecanico', 'sin_correo@example.com', NULL, '$2y$10$0erSxh.rgGAx0hAaeSe5j.hvKbl1lQlVMMbDk41fSH6oQ0D4tsC3O', '2025-06-15 15:37:58', 'Mecánico'),
(4, 'admin', 'sin_correo@example.com', NULL, '$2y$10$DIAdC3yzm0vzRT/.3rlz3uQEH2iqv/MsXbxY7xeAuufHP0awCjL6i', '2025-06-15 15:37:58', 'Visitante'),
(5, 'luis', 'sin_correo@example.com', NULL, 'luis12345678', '2025-06-15 15:37:58', 'Visitante'),
(6, 'admin2', 'sin_correo@example.com', NULL, '$2y$10$NWVb4mDPmlfvhASPmbQNUOcSs2t3r10cFprTAe/lpikQCeWVUFPAi', '2025-06-15 15:37:58', 'Gerente'),
(7, 'ben', 'sin_correo@example.com', NULL, '$2y$10$oWbq6wYtxYlngVcqWGUi6.zDIPZS/jrAhT5RYttjnBQhQmm2pZT7C', '2025-06-15 15:37:58', 'Visitante'),
(9, 'jael', 'jael@gmail.com', '12345678', '$2y$10$5G.I6o4zRuKNBDtb8Mc73eRGKfPiXjQ/9hnCvKxpOcJq6ypJy.Oyy', '2025-06-15 15:52:06', 'Visitante'),
(10, 'usuario', 'usuario@gmail.com', '73080923', '$2y$10$yV/c9fAYCXAQ8yujt9HVKOpU2l955j3idKxrud70CN2HLgHJH8fZq', '2025-06-16 21:07:26', 'Visitante'),
(11, 'usuarioprueba', 'usuarioprueba@gmail.com', '71542895', '$2y$10$QicURgjS1Ew.TdVIg2Aa7OM4A9HbrSIE1CV9KUUDN10Awe5yKQA/u', '2025-06-16 22:30:04', 'Visitante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `cliente`, `marca`, `modelo`) VALUES
(2, 'P123-456', 2, 'Toyota', 'Corolla'),
(3, 'P115-798', 3, 'Ford', 'Escape');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_citas_cliente` (`cliente_id`),
  ADD KEY `fk_citas_vehiculo` (`vehiculo_id`),
  ADD KEY `fk_citas_mecanico` (`id_mecanico`),
  ADD KEY `fk_servicio` (`servicio_id`) USING BTREE;

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedor_insumos` (`id_proveedor`);

--
-- Indices de la tabla `mecanicos`
--
ALTER TABLE `mecanicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor_insumos`
--
ALTER TABLE `proveedor_insumos`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `mecanico_id` (`mecanico_id`);

--
-- Indices de la tabla `reparacion_repuestos`
--
ALTER TABLE `reparacion_repuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reparacion_id` (`reparacion_id`),
  ADD KEY `repuesto_id` (`repuesto_id`);

--
-- Indices de la tabla `reparacion_servicios`
--
ALTER TABLE `reparacion_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reparacion_id` (`reparacion_id`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_servicios_vehiculo` (`vehiculo_id`);

--
-- Indices de la tabla `servicios_catalogo`
--
ALTER TABLE `servicios_catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente` (`cliente`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `mecanicos`
--
ALTER TABLE `mecanicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedor_insumos`
--
ALTER TABLE `proveedor_insumos`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reparacion_repuestos`
--
ALTER TABLE `reparacion_repuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reparacion_servicios`
--
ALTER TABLE `reparacion_servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `servicios_catalogo`
--
ALTER TABLE `servicios_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_citas_mecanico` FOREIGN KEY (`id_mecanico`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios_catalogo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citas_vehiculo` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`);

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_ibfk_1` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `historial_servicios`
--
ALTER TABLE `historial_servicios`
  ADD CONSTRAINT `historial_servicios_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `historial_servicios_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_proveedor_insumos` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor_insumos` (`id_proveedor`);

--
-- Filtros para la tabla `reparaciones`
--
ALTER TABLE `reparaciones`
  ADD CONSTRAINT `reparaciones_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `reparaciones_ibfk_2` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `reparaciones_ibfk_3` FOREIGN KEY (`mecanico_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reparacion_repuestos`
--
ALTER TABLE `reparacion_repuestos`
  ADD CONSTRAINT `reparacion_repuestos_ibfk_1` FOREIGN KEY (`reparacion_id`) REFERENCES `reparaciones` (`id`),
  ADD CONSTRAINT `reparacion_repuestos_ibfk_2` FOREIGN KEY (`repuesto_id`) REFERENCES `inventario` (`id`);

--
-- Filtros para la tabla `reparacion_servicios`
--
ALTER TABLE `reparacion_servicios`
  ADD CONSTRAINT `reparacion_servicios_ibfk_1` FOREIGN KEY (`reparacion_id`) REFERENCES `reparaciones` (`id`),
  ADD CONSTRAINT `reparacion_servicios_ibfk_2` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_vehiculo` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `fk_vehiculos_cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
