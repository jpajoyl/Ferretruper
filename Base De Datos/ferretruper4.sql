-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ferretruperbd2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ferretruperbd2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ferretruperbd2` DEFAULT CHARACTER SET utf8 ;
USE `ferretruperbd2` ;

-- -----------------------------------------------------
-- Table `ferretruperbd2`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`usuarios` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo_usuario` VARCHAR(45) NOT NULL,
  `tipo_identificacion` VARCHAR(45) NOT NULL,
  `numero_identificacion` VARCHAR(45) NOT NULL,
  `digito_de_verificacion` TINYINT(1) NULL DEFAULT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) NULL DEFAULT NULL,
  `ciudad` VARCHAR(45) NOT NULL,
  `celular` VARCHAR(20) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `activa` TINYINT(4) NOT NULL,
  `clasificacion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`ventas` (
  `id_venta` INT(11) NOT NULL AUTO_INCREMENT,
  `subtotal` INT(11) NOT NULL,
  `iva` INT(11) NOT NULL,
  `retefuente` INT(11) NULL DEFAULT NULL,
  `descuento` INT(11) NULL DEFAULT NULL,
  `total` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `anulada` TINYINT(1) NULL DEFAULT NULL,
  `fecha_anulada` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_venta`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`tipo_venta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`tipo_venta` (
  `id_tipo_venta` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo_venta` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `plazo` INT(11) NULL DEFAULT NULL,
  `USUARIOS_id_cliente` INT(11) NOT NULL,
  `USUARIOS_id_empleado` INT(11) NOT NULL,
  `VENTAS_id_venta` INT(11) NOT NULL,
  PRIMARY KEY (`id_tipo_venta`),
  INDEX `fk_TIPO_VENTA_USUARIOS1_idx` (`USUARIOS_id_cliente` ASC),
  INDEX `fk_TIPO_VENTA_USUARIOS2_idx` (`USUARIOS_id_empleado` ASC),
  INDEX `fk_TIPO_VENTA_VENTAS1_idx` (`VENTAS_id_venta` ASC),
  CONSTRAINT `fk_TIPO_VENTA_USUARIOS1`
    FOREIGN KEY (`USUARIOS_id_cliente`)
    REFERENCES `ferretruperbd2`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TIPO_VENTA_USUARIOS2`
    FOREIGN KEY (`USUARIOS_id_empleado`)
    REFERENCES `ferretruperbd2`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TIPO_VENTA_VENTAS1`
    FOREIGN KEY (`VENTAS_id_venta`)
    REFERENCES `ferretruperbd2`.`ventas` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`abonos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`abonos` (
  `id_abono` INT(11) NOT NULL AUTO_INCREMENT,
  `valor` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `TIPO_VENTA_id_tipo_venta` INT(11) NOT NULL,
  PRIMARY KEY (`id_abono`),
  INDEX `fk_ABONOS_TIPO_VENTA1_idx` (`TIPO_VENTA_id_tipo_venta` ASC),
  CONSTRAINT `fk_ABONOS_TIPO_VENTA1`
    FOREIGN KEY (`TIPO_VENTA_id_tipo_venta`)
    REFERENCES `ferretruperbd2`.`tipo_venta` (`id_tipo_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`compras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`compras` (
  `id_compra` INT(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` VARCHAR(45) NOT NULL,
  `fecha_compra` DATE NOT NULL,
  `total_compra` INT(11) NOT NULL,
  `descuento_compra` INT(11) NULL DEFAULT NULL,
  `USUARIOS_id_proveedor` INT(11) NOT NULL,
  PRIMARY KEY (`id_compra`),
  INDEX `fk_COMPRAS_USUARIOS1_idx` (`USUARIOS_id_proveedor` ASC),
  CONSTRAINT `fk_COMPRAS_USUARIOS1`
    FOREIGN KEY (`USUARIOS_id_proveedor`)
    REFERENCES `ferretruperbd2`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`comprobantes_egreso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`comprobantes_egreso` (
  `id_comprobante_egreso` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_pago` DATE NOT NULL,
  `descripcion` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id_comprobante_egreso`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`credenciales_de_acceso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`credenciales_de_acceso` (
  `id_credencial` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `USUARIOS_id_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_credencial`),
  INDEX `fk_CREDENCIALES_DE_ACCESO_USUARIOS1_idx` (`USUARIOS_id_usuario` ASC),
  CONSTRAINT `fk_CREDENCIALES_DE_ACCESO_USUARIOS1`
    FOREIGN KEY (`USUARIOS_id_usuario`)
    REFERENCES `ferretruperbd2`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`informacion_facturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`informacion_facturas` (
  `id_informacion_facturas` INT(11) NOT NULL,
  `descripcion` VARCHAR(500) NULL DEFAULT NULL,
  PRIMARY KEY (`id_informacion_facturas`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`resoluciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`resoluciones` (
  `id_resolucion` INT(11) NOT NULL,
  `descripcion` VARCHAR(500) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `vigente` TINYINT(1) NOT NULL,
  `activa` TINYINT(4) NOT NULL,
  `numero_dian` INT(11) NOT NULL,
  PRIMARY KEY (`id_resolucion`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`facturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`facturas` (
  `id_factura` INT(11) NOT NULL AUTO_INCREMENT,
  `total` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `anulada` TINYINT(1) NULL DEFAULT NULL,
  `fecha_anulada` DATE NULL DEFAULT NULL,
  `numero_dian` INT(11) NOT NULL,
  `informacion_facturas_id_informacion_facturas` INT(11) NOT NULL,
  `resoluciones_id_resolucion` INT(11) NOT NULL,
  `ventas_id_venta` INT(11) NOT NULL,
  PRIMARY KEY (`id_factura`),
  INDEX `fk_facturas_informacion_facturas1_idx` (`informacion_facturas_id_informacion_facturas` ASC),
  INDEX `fk_facturas_resoluciones1_idx` (`resoluciones_id_resolucion` ASC),
  INDEX `fk_facturas_ventas1_idx` (`ventas_id_venta` ASC),
  CONSTRAINT `fk_facturas_informacion_facturas1`
    FOREIGN KEY (`informacion_facturas_id_informacion_facturas`)
    REFERENCES `ferretruperbd2`.`informacion_facturas` (`id_informacion_facturas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_facturas_resoluciones1`
    FOREIGN KEY (`resoluciones_id_resolucion`)
    REFERENCES `ferretruperbd2`.`resoluciones` (`id_resolucion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_facturas_ventas1`
    FOREIGN KEY (`ventas_id_venta`)
    REFERENCES `ferretruperbd2`.`ventas` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`productos` (
  `id_producto` INT(11) NOT NULL,
  `codigo_barras` VARCHAR(100) NULL DEFAULT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `descripcion` VARCHAR(500) NOT NULL,
  `referencia_fabrica` VARCHAR(45) NOT NULL,
  `tiene_iva` TINYINT(1) NOT NULL,
  `clasificacion_tributaria` VARCHAR(45) NOT NULL,
  `valor_utilidad` INT(11) NOT NULL,
  `activa` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`garantias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`garantias` (
  `id_garantias` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicial` DATE NOT NULL,
  `fecha_caducacion` DATE NOT NULL,
  `caducada` TINYINT(1) NOT NULL,
  `PRODUCTOS_id_producto` INT(11) NOT NULL,
  `VENTAS_id_venta` INT(11) NOT NULL,
  PRIMARY KEY (`id_garantias`),
  INDEX `fk_GARANTIAS_PRODUCTOS1_idx` (`PRODUCTOS_id_producto` ASC),
  INDEX `fk_GARANTIAS_VENTAS1_idx` (`VENTAS_id_venta` ASC),
  CONSTRAINT `fk_GARANTIAS_PRODUCTOS1`
    FOREIGN KEY (`PRODUCTOS_id_producto`)
    REFERENCES `ferretruperbd2`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_GARANTIAS_VENTAS1`
    FOREIGN KEY (`VENTAS_id_venta`)
    REFERENCES `ferretruperbd2`.`ventas` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`inventario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`inventario` (
  `id_inventario` INT(11) NOT NULL AUTO_INCREMENT,
  `precio` INT(11) NOT NULL,
  `unidades` INT(11) NOT NULL,
  `unidades_defectuosas` INT(11) NOT NULL,
  `productos_id_producto` INT(11) NOT NULL,
  `usuarios_id_usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id_inventario`),
  INDEX `fk_inventario_productos1_idx` (`productos_id_producto` ASC),
  INDEX `fk_inventario_usuarios1_idx` (`usuarios_id_usuario` ASC),
  CONSTRAINT `fk_inventario_productos1`
    FOREIGN KEY (`productos_id_producto`)
    REFERENCES `ferretruperbd2`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventario_usuarios1`
    FOREIGN KEY (`usuarios_id_usuario`)
    REFERENCES `ferretruperbd2`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`productoxcompra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`productoxcompra` (
  `id_productoxcompra` INT(11) NOT NULL AUTO_INCREMENT,
  `precio_unitario` INT(11) NOT NULL,
  `unidades` INT(11) NOT NULL,
  `descuento` INT(11) NULL DEFAULT NULL,
  `COMPRAS_id_compra` INT(11) NOT NULL,
  `PRODUCTOS_id_producto` INT(11) NOT NULL,
  PRIMARY KEY (`id_productoxcompra`),
  INDEX `fk_PRODUCTOXCOMPRA_COMPRAS1_idx` (`COMPRAS_id_compra` ASC),
  INDEX `fk_PRODUCTOXCOMPRA_PRODUCTOS1_idx` (`PRODUCTOS_id_producto` ASC),
  CONSTRAINT `fk_PRODUCTOXCOMPRA_COMPRAS1`
    FOREIGN KEY (`COMPRAS_id_compra`)
    REFERENCES `ferretruperbd2`.`compras` (`id_compra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUCTOXCOMPRA_PRODUCTOS1`
    FOREIGN KEY (`PRODUCTOS_id_producto`)
    REFERENCES `ferretruperbd2`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`productoxventa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`productoxventa` (
  `id_productoxventa` INT(11) NOT NULL AUTO_INCREMENT,
  `precio_unitario` INT(11) NOT NULL,
  `unidades` INT(11) NOT NULL,
  `PRODUCTOS_id_producto` INT(11) NOT NULL,
  `VENTAS_id_venta` INT(11) NOT NULL,
  PRIMARY KEY (`id_productoxventa`),
  INDEX `fk_PRODUCTOXVENTA_PRODUCTOS1_idx` (`PRODUCTOS_id_producto` ASC),
  INDEX `fk_PRODUCTOXVENTA_VENTAS1_idx` (`VENTAS_id_venta` ASC),
  CONSTRAINT `fk_PRODUCTOXVENTA_PRODUCTOS1`
    FOREIGN KEY (`PRODUCTOS_id_producto`)
    REFERENCES `ferretruperbd2`.`productos` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUCTOXVENTA_VENTAS1`
    FOREIGN KEY (`VENTAS_id_venta`)
    REFERENCES `ferretruperbd2`.`ventas` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ferretruperbd2`.`factura_compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ferretruperbd2`.`factura_compra` (
  `idfactura_compra` INT NOT NULL AUTO_INCREMENT,
  `compras_id_compra` INT(11) NOT NULL,
  `comprobantes_egreso_id_comprobante_egreso` INT(11) NOT NULL,
  PRIMARY KEY (`idfactura_compra`),
  INDEX `fk_factura_compra_compras1_idx` (`compras_id_compra` ASC),
  INDEX `fk_factura_compra_comprobantes_egreso1_idx` (`comprobantes_egreso_id_comprobante_egreso` ASC),
  CONSTRAINT `fk_factura_compra_compras1`
    FOREIGN KEY (`compras_id_compra`)
    REFERENCES `ferretruperbd2`.`compras` (`id_compra`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_compra_comprobantes_egreso1`
    FOREIGN KEY (`comprobantes_egreso_id_comprobante_egreso`)
    REFERENCES `ferretruperbd2`.`comprobantes_egreso` (`id_comprobante_egreso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
