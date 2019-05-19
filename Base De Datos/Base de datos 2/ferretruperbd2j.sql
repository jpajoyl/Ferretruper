-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2019 a las 06:56:05
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE `ferretruperbd3`;
USE ferretruperbd3;
--
-- Base de datos: `ferretruperbd2j`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonos`
--

CREATE TABLE `abonos` (
  `id_abono` int(11) NOT NULL,
  `valor` float(11,2) NOT NULL,
  `fecha` date NOT NULL,
  `TIPO_VENTA_id_tipo_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `numero_factura` varchar(45) NOT NULL,
  `fecha_compra` date NOT NULL,
  `total_compra` float(11,2) NOT NULL,
  `descuento_compra` float(11,2) DEFAULT NULL,
  `USUARIOS_id_proveedor` int(11) NOT NULL,
  `activa` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes_egreso`
--

CREATE TABLE `comprobantes_egreso` (
  `id_comprobante_egreso` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales_de_acceso`
--

CREATE TABLE `credenciales_de_acceso` (
  `id_credencial` int(11) NOT NULL,
  `USUARIOS_id_usuario` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permiso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `credenciales_de_acceso`
--

INSERT INTO `credenciales_de_acceso` (`id_credencial`, `USUARIOS_id_usuario`, `usuario`, `password`, `permiso`) VALUES
(8, 63, 'juan', '1234', 0),
(9, 64, 'fredy', '1234', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `total` float(11,2) NOT NULL,
  `fecha` date NOT NULL,
  `anulada` tinyint(1) DEFAULT NULL,
  `fecha_anulada` date DEFAULT NULL,
  `numero_dian` int(11) NOT NULL,
  `informacion_facturas_id_informacion_facturas` int(11) NOT NULL,
  `resoluciones_id_resolucion` int(11) NOT NULL,
  `ventas_id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `idfactura_compra` int(11) NOT NULL,
  `compras_id_compra` int(11) NOT NULL,
  `comprobantes_egreso_id_comprobante_egreso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `garantias`
--

CREATE TABLE `garantias` (
  `id_garantias` int(11) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_caducacion` date NOT NULL,
  `caducada` tinyint(1) NOT NULL,
  `PRODUCTOS_id_producto` int(11) NOT NULL,
  `VENTAS_id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_facturas`
--

CREATE TABLE `informacion_facturas` (
  `id_informacion_facturas` int(11) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `precio_compra` float(11,2) NOT NULL,
  `unidades` int(11) NOT NULL,
  `unidades_defectuosas` int(11) NOT NULL,
  `productos_id_producto` int(11) NOT NULL,
  `usuarios_id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_barras` varchar(100) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `referencia_fabrica` varchar(45) NOT NULL,
  `tiene_iva` tinyint(1) NOT NULL,
  `clasificacion_tributaria` varchar(45) NOT NULL,
  `unidades_totales` int(11) NOT NULL,
  `precio` float(11,2) NOT NULL,
  `activa` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoxcompra`
--

CREATE TABLE `productoxcompra` (
  `id_productoxcompra` int(11) NOT NULL,
  `precio_unitario` float(11,2) NOT NULL,
  `unidades` int(11) NOT NULL,
  `descuento` int(11) DEFAULT NULL,
  `COMPRAS_id_compra` int(11) NOT NULL,
  `PRODUCTOS_id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoxventa`
--

CREATE TABLE `productoxventa` (
  `id_productoxventa` int(11) NOT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `unidades` int(11) NOT NULL,
  `PRODUCTOS_id_producto` int(11) NOT NULL,
  `VENTAS_id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resoluciones`
--

CREATE TABLE `resoluciones` (
  `id_resolucion` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `vigente` tinyint(1) NOT NULL,
  `activa` tinyint(4) NOT NULL,
  `numero_dian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_venta`
--

CREATE TABLE `tipo_venta` (
  `id_tipo_venta` int(11) NOT NULL,
  `tipo_venta` varchar(45) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `plazo` int(11) DEFAULT NULL,
  `USUARIOS_id_cliente` int(11) NOT NULL,
  `USUARIOS_id_empleado` int(11) NOT NULL,
  `VENTAS_id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(45) NOT NULL,
  `tipo_identificacion` varchar(45) NOT NULL,
  `numero_identificacion` varchar(45) NOT NULL,
  `digito_de_verificacion` tinyint(1) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `ciudad` varchar(45) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `activa` tinyint(4) NOT NULL,
  `clasificacion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `tipo_usuario`, `tipo_identificacion`, `numero_identificacion`, `digito_de_verificacion`, `nombre`, `direccion`, `email`, `ciudad`, `celular`, `telefono`, `activa`, `clasificacion`) VALUES
(61, 'cliente', 'CC', '1017276358', NULL, 'Jose Antonio', 'Cra 26 # 89a-68', 'joseAntonio@gmail.com', 'Medellin', '3116598462', '2265874', 1, ''),
(62, 'cliente', 'CC', '1001549652', NULL, 'Manuela Mejia', 'Cra 24 # 34-12', 'ManuRosita@gmail.com', 'Medellin', '3135698475', '2265874', 1, ''),
(63, 'empleado', 'CC', '1056146298', NULL, 'Juan', 'La del corazon', '', 'MEDALLO', '', '2248595', 1, ''),
(64, 'empleado', 'CC', '1016542387', NULL, 'Fredy', 'La del corazon', '', 'MEDALLO', '', '2248595', 1, ''),
(65, 'proveedor', 'NIT', '900826318', 4, 'HOMELAB SAS', 'Cra 68a # 65-96 int 214', 'homelab@gmail.com', 'Medellin', '', '4256398', 1, '1.-GRANDE CONTRIB'),
(66, 'proveedor', 'NIT', '900632784', 4, 'WAM SOFTWARE', 'Cra 27 # 54-20', 'wamsoft@wamail.com', 'Medellin', '3113323869', '2268795', 1, '3.-REGIMEN COMUN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `subtotal` float(11,2) NOT NULL,
  `iva` int(11) NOT NULL,
  `retefuente` int(11) DEFAULT NULL,
  `descuento` float(11,2) DEFAULT NULL,
  `total` float(11,2) NOT NULL,
  `fecha` date NOT NULL,
  `anulada` tinyint(1) DEFAULT NULL,
  `fecha_anulada` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD PRIMARY KEY (`id_abono`),
  ADD KEY `fk_ABONOS_TIPO_VENTA1_idx` (`TIPO_VENTA_id_tipo_venta`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_COMPRAS_USUARIOS1_idx` (`USUARIOS_id_proveedor`);

--
-- Indices de la tabla `comprobantes_egreso`
--
ALTER TABLE `comprobantes_egreso`
  ADD PRIMARY KEY (`id_comprobante_egreso`);

--
-- Indices de la tabla `credenciales_de_acceso`
--
ALTER TABLE `credenciales_de_acceso`
  ADD PRIMARY KEY (`id_credencial`),
  ADD KEY `fk_CREDENCIALES_DE_ACCESO_USUARIOS1_idx` (`USUARIOS_id_usuario`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `fk_facturas_informacion_facturas1_idx` (`informacion_facturas_id_informacion_facturas`),
  ADD KEY `fk_facturas_resoluciones1_idx` (`resoluciones_id_resolucion`),
  ADD KEY `fk_facturas_ventas1_idx` (`ventas_id_venta`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`idfactura_compra`),
  ADD KEY `fk_factura_compra_compras1_idx` (`compras_id_compra`),
  ADD KEY `fk_factura_compra_comprobantes_egreso1_idx` (`comprobantes_egreso_id_comprobante_egreso`);

--
-- Indices de la tabla `garantias`
--
ALTER TABLE `garantias`
  ADD PRIMARY KEY (`id_garantias`),
  ADD KEY `fk_GARANTIAS_PRODUCTOS1_idx` (`PRODUCTOS_id_producto`),
  ADD KEY `fk_GARANTIAS_VENTAS1_idx` (`VENTAS_id_venta`);

--
-- Indices de la tabla `informacion_facturas`
--
ALTER TABLE `informacion_facturas`
  ADD PRIMARY KEY (`id_informacion_facturas`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `fk_inventario_productos1_idx` (`productos_id_producto`),
  ADD KEY `fk_inventario_usuarios1_idx` (`usuarios_id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productoxcompra`
--
ALTER TABLE `productoxcompra`
  ADD PRIMARY KEY (`id_productoxcompra`),
  ADD KEY `fk_PRODUCTOXCOMPRA_COMPRAS1_idx` (`COMPRAS_id_compra`),
  ADD KEY `fk_PRODUCTOXCOMPRA_PRODUCTOS1_idx` (`PRODUCTOS_id_producto`);

--
-- Indices de la tabla `productoxventa`
--
ALTER TABLE `productoxventa`
  ADD PRIMARY KEY (`id_productoxventa`),
  ADD KEY `fk_PRODUCTOXVENTA_PRODUCTOS1_idx` (`PRODUCTOS_id_producto`),
  ADD KEY `fk_PRODUCTOXVENTA_VENTAS1_idx` (`VENTAS_id_venta`);

--
-- Indices de la tabla `resoluciones`
--
ALTER TABLE `resoluciones`
  ADD PRIMARY KEY (`id_resolucion`);

--
-- Indices de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD PRIMARY KEY (`id_tipo_venta`),
  ADD KEY `fk_TIPO_VENTA_USUARIOS1_idx` (`USUARIOS_id_cliente`),
  ADD KEY `fk_TIPO_VENTA_USUARIOS2_idx` (`USUARIOS_id_empleado`),
  ADD KEY `fk_TIPO_VENTA_VENTAS1_idx` (`VENTAS_id_venta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonos`
--
ALTER TABLE `abonos`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobantes_egreso`
--
ALTER TABLE `comprobantes_egreso`
  MODIFY `id_comprobante_egreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `credenciales_de_acceso`
--
ALTER TABLE `credenciales_de_acceso`
  MODIFY `id_credencial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `idfactura_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `garantias`
--
ALTER TABLE `garantias`
  MODIFY `id_garantias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productoxcompra`
--
ALTER TABLE `productoxcompra`
  MODIFY `id_productoxcompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productoxventa`
--
ALTER TABLE `productoxventa`
  MODIFY `id_productoxventa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  MODIFY `id_tipo_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abonos`
--
ALTER TABLE `abonos`
  ADD CONSTRAINT `fk_ABONOS_TIPO_VENTA1` FOREIGN KEY (`TIPO_VENTA_id_tipo_venta`) REFERENCES `tipo_venta` (`id_tipo_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_COMPRAS_USUARIOS1` FOREIGN KEY (`USUARIOS_id_proveedor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `credenciales_de_acceso`
--
ALTER TABLE `credenciales_de_acceso`
  ADD CONSTRAINT `fk_CREDENCIALES_DE_ACCESO_USUARIOS1` FOREIGN KEY (`USUARIOS_id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_facturas_informacion_facturas1` FOREIGN KEY (`informacion_facturas_id_informacion_facturas`) REFERENCES `informacion_facturas` (`id_informacion_facturas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturas_resoluciones1` FOREIGN KEY (`resoluciones_id_resolucion`) REFERENCES `resoluciones` (`id_resolucion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturas_ventas1` FOREIGN KEY (`ventas_id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `fk_factura_compra_compras1` FOREIGN KEY (`compras_id_compra`) REFERENCES `compras` (`id_compra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_compra_comprobantes_egreso1` FOREIGN KEY (`comprobantes_egreso_id_comprobante_egreso`) REFERENCES `comprobantes_egreso` (`id_comprobante_egreso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `garantias`
--
ALTER TABLE `garantias`
  ADD CONSTRAINT `fk_GARANTIAS_PRODUCTOS1` FOREIGN KEY (`PRODUCTOS_id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GARANTIAS_VENTAS1` FOREIGN KEY (`VENTAS_id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_productos1` FOREIGN KEY (`productos_id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventario_usuarios1` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productoxcompra`
--
ALTER TABLE `productoxcompra`
  ADD CONSTRAINT `fk_PRODUCTOXCOMPRA_COMPRAS1` FOREIGN KEY (`COMPRAS_id_compra`) REFERENCES `compras` (`id_compra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PRODUCTOXCOMPRA_PRODUCTOS1` FOREIGN KEY (`PRODUCTOS_id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productoxventa`
--
ALTER TABLE `productoxventa`
  ADD CONSTRAINT `fk_PRODUCTOXVENTA_PRODUCTOS1` FOREIGN KEY (`PRODUCTOS_id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PRODUCTOXVENTA_VENTAS1` FOREIGN KEY (`VENTAS_id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD CONSTRAINT `fk_TIPO_VENTA_USUARIOS1` FOREIGN KEY (`USUARIOS_id_cliente`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TIPO_VENTA_USUARIOS2` FOREIGN KEY (`USUARIOS_id_empleado`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TIPO_VENTA_VENTAS1` FOREIGN KEY (`VENTAS_id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
