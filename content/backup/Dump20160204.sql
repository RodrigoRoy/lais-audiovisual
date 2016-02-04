CREATE DATABASE  IF NOT EXISTS `Audiovisuales` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Audiovisuales`;
-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Audiovisuales
-- ------------------------------------------------------
-- Server version	5.5.46-0+deb8u1

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
-- Table structure for table `area_de_condiciones_de_acceso`
--

DROP TABLE IF EXISTS `area_de_condiciones_de_acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_condiciones_de_acceso` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `condiciones_de_acceso` varchar(37) DEFAULT '',
  `existencia_y_localizacion_de_originales` text,
  `idioma_original` varchar(80) DEFAULT '',
  `doblajes_disponibles` varchar(80) DEFAULT '',
  `subtitulajes` varchar(80) DEFAULT '',
  `soporte` varchar(25) DEFAULT '',
  `numero_copias` varchar(40) DEFAULT '',
  `descripcion_fisica` varchar(60) DEFAULT '',
  `color` varchar(90) DEFAULT '',
  `audio` varchar(50) DEFAULT '',
  `sistema_de_grabacion` varchar(20) DEFAULT '',
  `region_dvd` varchar(20) DEFAULT '',
  `requisitos_tecnicos` varchar(60) DEFAULT '',
  KEY `codigoCondAccesoFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoCondAccesoFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_condiciones_de_acceso`
--

LOCK TABLES `area_de_condiciones_de_acceso` WRITE;
/*!40000 ALTER TABLE `area_de_condiciones_de_acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_condiciones_de_acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_contenido_y_estructura`
--

DROP TABLE IF EXISTS `area_de_contenido_y_estructura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_contenido_y_estructura` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `sinopsis` text,
  `descriptor_onomastico` text,
  `descriptor_toponimico` text,
  `descriptor_cronologico` text,
  `tipo_de_produccion` varchar(31) DEFAULT '',
  `genero` varchar(30) DEFAULT '',
  `fuentes` varchar(350) DEFAULT '',
  `recursos` varchar(150) DEFAULT '',
  `versiones` varchar(150) DEFAULT '',
  `formato_original` varchar(45) DEFAULT '',
  `material_extra` varchar(300) DEFAULT '',
  KEY `codigoContEstructFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoContEstructFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_contenido_y_estructura`
--

LOCK TABLES `area_de_contenido_y_estructura` WRITE;
/*!40000 ALTER TABLE `area_de_contenido_y_estructura` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_contenido_y_estructura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_contexto`
--

DROP TABLE IF EXISTS `area_de_contexto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_contexto` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `entidad_productora` varchar(500) DEFAULT '',
  `productor` varchar(160) DEFAULT '',
  `distribuidora` varchar(160) DEFAULT '',
  `historia_institucional` text,
  `resena_biografica` text,
  `forma_de_ingreso` varchar(50) DEFAULT '',
  `fecha_de_ingreso` varchar(12) DEFAULT '',
  KEY `codigoIdentificacionFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoIdentificacionFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_contexto`
--

LOCK TABLES `area_de_contexto` WRITE;
/*!40000 ALTER TABLE `area_de_contexto` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_contexto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_descripcion`
--

DROP TABLE IF EXISTS `area_de_descripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_descripcion` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `notas_del_archivero` text,
  `datos_del_archivero` varchar(120) DEFAULT '',
  `reglas_o_normas` varchar(31) DEFAULT '',
  `fecha_de_descripcion` date DEFAULT NULL,
  KEY `codigoDescripcionFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoDescripcionFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_descripcion`
--

LOCK TABLES `area_de_descripcion` WRITE;
/*!40000 ALTER TABLE `area_de_descripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_descripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_documentacion_asociada`
--

DROP TABLE IF EXISTS `area_de_documentacion_asociada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_documentacion_asociada` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `existencia_y_localizacion_de_copias` text,
  `unidades_de_descripcion_relacionadas` text,
  `documentos_asociados` text,
  KEY `codigoDocAsociadaFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoDocAsociadaFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_documentacion_asociada`
--

LOCK TABLES `area_de_documentacion_asociada` WRITE;
/*!40000 ALTER TABLE `area_de_documentacion_asociada` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_documentacion_asociada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_identificacion`
--

DROP TABLE IF EXISTS `area_de_identificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_identificacion` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `titulo_propio` varchar(150) DEFAULT '',
  `titulo_paralelo` varchar(150) DEFAULT '',
  `titulo_atribuido` varchar(150) DEFAULT '',
  `titulo_de_serie` varchar(90) DEFAULT '',
  `numero_de_programa` varchar(75) DEFAULT '',
  `pais` varchar(50) DEFAULT '',
  `fecha` varchar(12) DEFAULT '',
  `duracion` time DEFAULT NULL,
  `investigacion` varchar(500) DEFAULT '',
  `realizacion` varchar(500) DEFAULT '',
  `direccion` varchar(500) DEFAULT '',
  `guion` varchar(500) DEFAULT '',
  `adaptacion` varchar(500) DEFAULT '',
  `idea_original` varchar(500) DEFAULT '',
  `fotografia` varchar(500) DEFAULT '',
  `fotografia_fija` varchar(500) DEFAULT '',
  `edicion` varchar(500) DEFAULT '',
  `sonido_grabacion` varchar(500) DEFAULT '',
  `sonido_edicion` varchar(500) DEFAULT '',
  `musica_original` varchar(500) DEFAULT '',
  `musicalizacion` varchar(500) DEFAULT '',
  `voces` varchar(500) DEFAULT '',
  `actores` varchar(500) DEFAULT '',
  `animacion` varchar(500) DEFAULT '',
  `otros_colaboradores` varchar(500) DEFAULT '',
  PRIMARY KEY (`codigo_de_referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_identificacion`
--

LOCK TABLES `area_de_identificacion` WRITE;
/*!40000 ALTER TABLE `area_de_identificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_identificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_de_notas`
--

DROP TABLE IF EXISTS `area_de_notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_de_notas` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `area_de_notas` text,
  KEY `codigoNotasFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoNotasFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_de_notas`
--

LOCK TABLES `area_de_notas` WRITE;
/*!40000 ALTER TABLE `area_de_notas` DISABLE KEYS */;
/*!40000 ALTER TABLE `area_de_notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informacion_adicional`
--

DROP TABLE IF EXISTS `informacion_adicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informacion_adicional` (
  `codigo_de_referencia` varchar(20) NOT NULL,
  `imagen` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  KEY `codigoInfoAdicionalFK` (`codigo_de_referencia`),
  CONSTRAINT `codigoInfoAdicionalFK` FOREIGN KEY (`codigo_de_referencia`) REFERENCES `area_de_identificacion` (`codigo_de_referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informacion_adicional`
--

LOCK TABLES `informacion_adicional` WRITE;
/*!40000 ALTER TABLE `informacion_adicional` DISABLE KEYS */;
/*!40000 ALTER TABLE `informacion_adicional` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-04 10:12:59
