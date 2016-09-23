-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: idealshop
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Pedido_Detalle`
--

DROP TABLE IF EXISTS `Pedido_Detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pedido_Detalle` (
  `id_pedido_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `Pedido_Detallecol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_pedido_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pedido_Detalle`
--

LOCK TABLES `Pedido_Detalle` WRITE;
/*!40000 ALTER TABLE `Pedido_Detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pedido_Detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Registro_Delivery`
--

DROP TABLE IF EXISTS `Registro_Delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Registro_Delivery` (
  `id_delivery` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(45) DEFAULT NULL,
  `nro_documento` varchar(45) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `nombre_contacto` varchar(45) DEFAULT NULL,
  `ape_paterno` varchar(45) DEFAULT NULL,
  `apr_materno` varchar(45) DEFAULT NULL,
  `tipo_doc` varchar(45) DEFAULT NULL,
  `nro_doc` varchar(45) DEFAULT NULL,
  `correo_contacto` varchar(45) DEFAULT NULL,
  `telefono_contacto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_delivery`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Registro_Delivery`
--

LOCK TABLES `Registro_Delivery` WRITE;
/*!40000 ALTER TABLE `Registro_Delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `Registro_Delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (1,'The  Military  Wives','In  My  Dreams 33');
INSERT INTO `album` VALUES (2,'Adele','21');
INSERT INTO `album` VALUES (3,'Bruce  Springsteen','Wrecking Ball (Deluxe)');
INSERT INTO `album` VALUES (4,'Lana  Del  Rey','Born  To  Die');
INSERT INTO `album` VALUES (5,'Gotye 3','Making  Mirrors');
INSERT INTO `album` VALUES (6,'des','de gr');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comprador`
--

DROP TABLE IF EXISTS `comprador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comprador` (
  `id_comprador` int(11) NOT NULL AUTO_INCREMENT,
  `id_epartamento` int(11) NOT NULL,
  `nombres` varchar(120) DEFAULT NULL,
  `ape_paterno` varchar(120) DEFAULT NULL,
  `ape_materno` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `celular` int(15) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  PRIMARY KEY (`id_comprador`),
  KEY `fk_comprador_Departamento1_idx` (`id_epartamento`),
  CONSTRAINT `fk_comprador_Departamento1` FOREIGN KEY (`id_epartamento`) REFERENCES `departamento` (`id_epartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comprador`
--

LOCK TABLES `comprador` WRITE;
/*!40000 ALTER TABLE `comprador` DISABLE KEYS */;
/*!40000 ALTER TABLE `comprador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conductor`
--

DROP TABLE IF EXISTS `conductor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conductor` (
  `id_conductor` int(11) NOT NULL,
  `nombres` varchar(45) DEFAULT NULL,
  `ape_paterno` varchar(120) DEFAULT NULL,
  `apr_materno` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `celular` int(15) DEFAULT NULL,
  `id_operador_logistico` int(11) NOT NULL,
  PRIMARY KEY (`id_conductor`),
  KEY `fk_Conductor_Operador_Logistico1_idx` (`id_operador_logistico`),
  CONSTRAINT `fk_Conductor_Operador_Logistico1` FOREIGN KEY (`id_operador_logistico`) REFERENCES `operador_logistico` (`id_operador_logistico`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conductor`
--

LOCK TABLES `conductor` WRITE;
/*!40000 ALTER TABLE `conductor` DISABLE KEYS */;
/*!40000 ALTER TABLE `conductor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_plano`
--

DROP TABLE IF EXISTS `delivery_plano`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_plano` (
  `id_delivery_plano` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) DEFAULT NULL,
  `descripcion` varchar(120) DEFAULT NULL,
  `timepo_entrega` time DEFAULT NULL,
  `precio_entrega` decimal(19,4) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_delivery_plano`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_plano`
--

LOCK TABLES `delivery_plano` WRITE;
/*!40000 ALTER TABLE `delivery_plano` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_plano` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `id_epartamento` int(11) NOT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_epartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direcciones` (
  `id_direcciones` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_epartamento` int(11) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_direcciones`),
  KEY `fk_Direcciones_Departamento1_idx` (`id_epartamento`),
  KEY `fk_Direcciones_Usuario1_idx` (`id_usuario`),
  CONSTRAINT `fk_Direcciones_Departamento1` FOREIGN KEY (`id_epartamento`) REFERENCES `departamento` (`id_epartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Direcciones_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distrito`
--

DROP TABLE IF EXISTS `distrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distrito` (
  `id_distrito` int(11) NOT NULL AUTO_INCREMENT,
  `distrito` varchar(45) DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  PRIMARY KEY (`id_distrito`),
  KEY `fk_Distrito_Departamento1_idx` (`id_departamento`),
  CONSTRAINT `fk_Distrito_Departamento1` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_epartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distrito`
--

LOCK TABLES `distrito` WRITE;
/*!40000 ALTER TABLE `distrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `distrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fidelizacion`
--

DROP TABLE IF EXISTS `fidelizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fidelizacion` (
  `id_tienda` int(11) NOT NULL,
  `id_usuario` varchar(45) DEFAULT NULL,
  `nro` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fidelizacion`
--

LOCK TABLES `fidelizacion` WRITE;
/*!40000 ALTER TABLE `fidelizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `fidelizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operador_logistico`
--

DROP TABLE IF EXISTS `operador_logistico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operador_logistico` (
  `id_operador_logistico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) DEFAULT NULL,
  `direccion` varchar(120) DEFAULT NULL,
  `id_epartamento` int(11) NOT NULL,
  PRIMARY KEY (`id_operador_logistico`),
  KEY `fk_Operador_Logistico_Departamento1_idx` (`id_epartamento`),
  CONSTRAINT `fk_Operador_Logistico_Departamento1` FOREIGN KEY (`id_epartamento`) REFERENCES `departamento` (`id_epartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operador_logistico`
--

LOCK TABLES `operador_logistico` WRITE;
/*!40000 ALTER TABLE `operador_logistico` DISABLE KEYS */;
/*!40000 ALTER TABLE `operador_logistico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT NULL,
  `tipo_pago` int(11) DEFAULT NULL,
  `tipo_pago_compro` varchar(45) DEFAULT NULL,
  `sub_total` decimal(19,4) DEFAULT NULL,
  `igv` int(6) DEFAULT NULL,
  `monto_total` decimal(19,4) DEFAULT NULL,
  `estado_pedido` int(1) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_Pedido_Usuario1_idx` (`id_usuario`),
  CONSTRAINT `fk_Pedido_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido_detalle`
--

DROP TABLE IF EXISTS `pedido_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_detalle` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(6) DEFAULT NULL,
  `precio_unitario` decimal(19,4) DEFAULT NULL,
  `precio_total` decimal(19,4) DEFAULT NULL,
  `comentario` text,
  PRIMARY KEY (`id_pedido`,`id_producto`),
  KEY `fk_Pedido_has_Producto_Producto1_idx` (`id_producto`),
  KEY `fk_Pedido_has_Producto_Pedido1_idx` (`id_pedido`),
  CONSTRAINT `fk_Pedido_has_Producto_Pedido1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedido_has_Producto_Producto1` FOREIGN KEY (`id_producto`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido_detalle`
--

LOCK TABLES `pedido_detalle` WRITE;
/*!40000 ALTER TABLE `pedido_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedido_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_brand` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `description` text,
  `stock` int(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `outstanding` tinyint(1) DEFAULT NULL COMMENT 'Oferta',
  PRIMARY KEY (`id_product`),
  KEY `fk_Producto_Marca_idx` (`id_brand`),
  KEY `fk_Producto_Categoria1_idx` (`id_category`),
  KEY `id_categoria` (`id_category`),
  CONSTRAINT `fk_Producto_Categoria1` FOREIGN KEY (`id_category`) REFERENCES `product_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Marca` FOREIGN KEY (`id_brand`) REFERENCES `product_brand` (`id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (6,1,2,'Categoria 1','Descripcion de categoria',25,1,1);
INSERT INTO `product` VALUES (9,1,2,'Product 1','Descripcion 1',45,1,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_attribute`
--

DROP TABLE IF EXISTS `product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_attribute` (
  `id_producto_atributo` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `tipo_atributo` varchar(45) DEFAULT NULL,
  `valor` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_producto_atributo`),
  KEY `fk_Producto_Atributo_Producto1_idx` (`id_producto`),
  CONSTRAINT `fk_Producto_Atributo_Producto1` FOREIGN KEY (`id_producto`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_attribute`
--

LOCK TABLES `product_attribute` WRITE;
/*!40000 ALTER TABLE `product_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_brand`
--

DROP TABLE IF EXISTS `product_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_brand` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) DEFAULT NULL,
  `descripcion` text,
  `orden` varchar(45) DEFAULT NULL COMMENT 'Orden de visualización',
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_brand`
--

LOCK TABLES `product_brand` WRITE;
/*!40000 ALTER TABLE `product_brand` DISABLE KEYS */;
INSERT INTO `product_brand` VALUES (1,'Marca 1','Descripo','1',1);
/*!40000 ALTER TABLE `product_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat_top` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `description` text COMMENT '	',
  `image` varchar(200) DEFAULT NULL,
  `orden` varchar(45) DEFAULT NULL COMMENT 'Orden de visualización',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_category`),
  KEY `fk_Categoria_Categoria1_idx` (`id_cat_top`),
  CONSTRAINT `fk_Categoria_Categoria1` FOREIGN KEY (`id_cat_top`) REFERENCES `product_category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (2,0,'Categoria 1','Descropcion categoria 1','categoria-1.jpg','1',1);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_image` (
  `id_producto_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `imagen` varchar(120) DEFAULT NULL,
  `principal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_producto_imagen`),
  KEY `fk_Producto_Imagen_Producto1_idx` (`id_producto`),
  CONSTRAINT `fk_Producto_Imagen_Producto1` FOREIGN KEY (`id_producto`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_price`
--

DROP TABLE IF EXISTS `product_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_price` (
  `id_producto_precio` int(11) NOT NULL AUTO_INCREMENT COMMENT '		',
  `id_producto` int(11) NOT NULL,
  `id_tienda` int(11) NOT NULL,
  `tipo_moneda` varchar(15) DEFAULT NULL,
  `precio` decimal(19,4) DEFAULT NULL,
  `oferta` tinyint(1) DEFAULT NULL,
  `precio_oferta` decimal(19,4) DEFAULT NULL,
  `oferta_fecha_ini` datetime DEFAULT NULL,
  `oferta_fecha_fin` datetime DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_producto_precio`),
  KEY `fk_Producto_Precio_Producto1_idx` (`id_producto`),
  KEY `fk_Producto_Precio_Tienda1_idx` (`id_tienda`),
  CONSTRAINT `fk_Producto_Precio_Producto1` FOREIGN KEY (`id_producto`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Precio_Tienda1` FOREIGN KEY (`id_tienda`) REFERENCES `tienda` (`id_tienda`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_price`
--

LOCK TABLES `product_price` WRITE;
/*!40000 ALTER TABLE `product_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(45) DEFAULT NULL,
  `id_distrito` int(11) NOT NULL,
  PRIMARY KEY (`id_provincia`),
  KEY `fk_Provincia_Distrito1_idx` (`id_distrito`),
  CONSTRAINT `fk_Provincia_Distrito1` FOREIGN KEY (`id_distrito`) REFERENCES `distrito` (`id_distrito`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tienda`
--

DROP TABLE IF EXISTS `tienda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tienda` (
  `id_tienda` int(11) NOT NULL AUTO_INCREMENT,
  `id_epartamento` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tienda`),
  KEY `fk_Tienda_Departamento1_idx` (`id_epartamento`),
  CONSTRAINT `fk_Tienda_Departamento1` FOREIGN KEY (`id_epartamento`) REFERENCES `departamento` (`id_epartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tienda`
--

LOCK TABLES `tienda` WRITE;
/*!40000 ALTER TABLE `tienda` DISABLE KEYS */;
/*!40000 ALTER TABLE `tienda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(120) DEFAULT NULL,
  `ape_paterno` varchar(120) DEFAULT NULL,
  `ape_materno` varchar(120) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `tipo_doc` varchar(45) DEFAULT NULL,
  `numero_doc` int(15) DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `celular` int(15) DEFAULT NULL,
  `tipo_fidelidad` varchar(45) DEFAULT NULL,
  `nro_fidelidad` varchar(45) DEFAULT NULL,
  `saldo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usurio_perfil`
--

DROP TABLE IF EXISTS `usurio_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usurio_perfil` (
  `id_usurio_perfil` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `contrasenha` varchar(250) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_inscripcion` datetime DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_usurio_perfil`),
  KEY `fk_Usurio_Perfil_Usuario1_idx` (`id_usuario`),
  CONSTRAINT `fk_Usurio_Perfil_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `user` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usurio_perfil`
--

LOCK TABLES `usurio_perfil` WRITE;
/*!40000 ALTER TABLE `usurio_perfil` DISABLE KEYS */;
/*!40000 ALTER TABLE `usurio_perfil` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-23 17:49:19
