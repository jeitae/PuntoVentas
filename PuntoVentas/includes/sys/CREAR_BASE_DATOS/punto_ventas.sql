drop database if exists punto_ventas;

create database punto_ventas;

use punto_ventas;

-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-09-2013 a las 22:32:48
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sisventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albalinea`
--

CREATE TABLE IF NOT EXISTS `albalinea` (
  `codalbaran` int(11) NOT NULL DEFAULT '0',
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) DEFAULT NULL,
  `codigo` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `cantidad` decimal(19,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(19,2) NOT NULL DEFAULT '0.00',
  `importe` decimal(19,2) NOT NULL DEFAULT '0.00',
  `dcto` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albalineap`
--

CREATE TABLE IF NOT EXISTS `albalineap` (
  `codalbaran` varchar(20) NOT NULL DEFAULT '0',
  `codproveedor` int(5) NOT NULL DEFAULT '0',
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(19,2) NOT NULL DEFAULT '0.00',
  `importe` decimal(19,2) NOT NULL DEFAULT '0.00',
  `dcto` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codalbaran`,`codproveedor`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albalineaptmp`
--

CREATE TABLE IF NOT EXISTS `albalineaptmp` (
  `codalbaran` int(11) NOT NULL DEFAULT '0',
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) DEFAULT NULL,
  `codigo` varchar(15) DEFAULT NULL,
  `cantidad` decimal(19,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(19,2) NOT NULL DEFAULT '0.00',
  `importe` decimal(19,2) NOT NULL DEFAULT '0.00',
  `dcto` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albalineatmp`
--

CREATE TABLE IF NOT EXISTS `albalineatmp` (
  `codalbaran` int(11) NOT NULL DEFAULT '0',
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) DEFAULT NULL,
  `codigo` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `cantidad` decimal(19,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(19,2) NOT NULL DEFAULT '0.00',
  `importe` decimal(19,2) NOT NULL DEFAULT '0.00',
  `dcto` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranes`
--

CREATE TABLE IF NOT EXISTS `albaranes` (
  `codalbaran` int(11) NOT NULL AUTO_INCREMENT,
  `codfactura` int(11) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `iva` tinyint(4) NOT NULL DEFAULT '0',
  `codcliente` int(5) DEFAULT '0',
  `estado` varchar(1) CHARACTER SET utf8 DEFAULT '1',
  `totalalbaran` decimal(19,2) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranesp`
--

CREATE TABLE IF NOT EXISTS `albaranesp` (
  `codalbaran` varchar(20) NOT NULL DEFAULT '0',
  `codproveedor` int(5) NOT NULL DEFAULT '0',
  `codfactura` varchar(20) DEFAULT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `iva` tinyint(4) NOT NULL DEFAULT '0',
  `estado` varchar(1) DEFAULT '1',
  `totalalbaran` decimal(19,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`codalbaran`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranesptmp`
--

CREATE TABLE IF NOT EXISTS `albaranesptmp` (
  `codalbaran` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Temporal de albaranes de proveedores para controlar acceso s' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranestmp`
--

CREATE TABLE IF NOT EXISTS `albaranestmp` (
  `codalbaran` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Temporal de albaranes para controlar acceso simultaneo' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE IF NOT EXISTS `articulos` (
  `codarticulo` int(10) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(5) NOT NULL,
  `referencia` varchar(35) NOT NULL,
  `descripcion` varchar(35) NOT NULL,
  `impuesto` float NOT NULL,
  `codproveedor1` int(5) NOT NULL DEFAULT '1',
  `codproveedor2` int(5) NOT NULL,
  `descripcion_corta` varchar(35) NOT NULL,
  `codubicacion` int(3) NOT NULL,
  `stock` int(10) NOT NULL,
  `stock_minimo` int(8) NOT NULL,
  `aviso_minimo` varchar(1) NOT NULL DEFAULT '0',
  `datos_producto` varchar(200) NOT NULL,
  `fecha_alta` date NOT NULL DEFAULT '0000-00-00',
  `codembalaje` int(3) NOT NULL,
  `unidades_caja` int(8) NOT NULL,
  `precio_ticket` varchar(1) NOT NULL DEFAULT '0',
  `modificar_ticket` varchar(1) NOT NULL DEFAULT '0',
  `observaciones` text NOT NULL,
  `precio_compra` decimal(19,2) DEFAULT NULL,
  `precio_almacen` decimal(19,2) DEFAULT NULL,
  `precio_tienda` decimal(19,2) DEFAULT NULL,
  `precio_pvp` decimal(19,2) DEFAULT NULL,
  `precio_iva` decimal(19,2) DEFAULT NULL,
  `codigobarras` varchar(15) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codarticulo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Articulos' AUTO_INCREMENT=94 ;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codarticulo`, `codfamilia`, `referencia`, `descripcion`, `impuesto`, `codproveedor1`, `codproveedor2`, `descripcion_corta`, `codubicacion`, `stock`, `stock_minimo`, `aviso_minimo`, `datos_producto`, `fecha_alta`, `codembalaje`, `unidades_caja`, `precio_ticket`, `modificar_ticket`, `observaciones`, `precio_compra`, `precio_almacen`, `precio_tienda`, `precio_pvp`, `precio_iva`, `codigobarras`, `imagen`, `borrado`) VALUES
(1, 75, '0001', 'Electrolight peque', 18, 24, 0, 'Electrolight', 14, 15, 10, '1', 'Electrolight peque', '2013-08-26', 10, 40, '1', '0', 'Ninguna Observacion', 40.00, 60.00, 60.00, NULL, 70.80, '5600000000922', 'foto92.jpg', '0'),
(2, 74, '0002', 'Vitatom con Ginzem 100mg', 18, 24, 0, 'Vitatom', 14, 21, 10, '1', 'Vitatom con Ginzem 100mg', '2013-08-26', 10, 40, '1', '0', 'Ninguna Observacion', 20.00, 50.00, 50.00, NULL, 59.00, '5600000000939', 'foto93.jpg', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artpro`
--

CREATE TABLE IF NOT EXISTS `artpro` (
  `codarticulo` varchar(15) NOT NULL,
  `codfamilia` int(3) NOT NULL,
  `codproveedor` int(5) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  PRIMARY KEY (`codarticulo`,`codfamilia`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `artpro`
--

INSERT INTO `artpro` (`codarticulo`, `codfamilia`, `codproveedor`, `precio`) VALUES
('2', 74, 25, 20.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authteam`
--

CREATE TABLE IF NOT EXISTS `authteam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `teamname` varchar(25) NOT NULL DEFAULT '',
  `teamlead` varchar(25) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `teamname` (`teamname`,`teamlead`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authuser`
--

CREATE TABLE IF NOT EXISTS `authuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(25) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `team` varchar(25) NOT NULL DEFAULT '',
  `level` int(4) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT '',
  `lastlogin` datetime DEFAULT NULL,
  `logincount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `codcliente` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `nif` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codprovincia` int(2) NOT NULL DEFAULT '0',
  `localidad` varchar(35) NOT NULL,
  `codformapago` int(2) NOT NULL DEFAULT '0',
  `codentidad` int(2) NOT NULL DEFAULT '0',
  `cuentabancaria` varchar(20) NOT NULL,
  `codpostal` varchar(5) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `movil` varchar(14) NOT NULL,
  `email` varchar(35) NOT NULL,
  `web` varchar(45) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codcliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Clientes' AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`codcliente`, `nombre`, `nif`, `direccion`, `codprovincia`, `localidad`, `codformapago`, `codentidad`, `cuentabancaria`, `codpostal`, `telefono`, `movil`, `email`, `web`, `borrado`) VALUES
(40, 'Jose Calderon Saavedra', '10427467495', 'Calle Salamanca 148', 39, 'Lima', 10, 28, '104596871233', '1', '', '', '', '', '0'),
(41, 'Tito Castillo Bardales', '10426985743', 'Calle Palomas 748', 39, 'Lima', 10, 28, '1025639741569', '1', '', '', '', '', '0'),
(1, 'Cliente', 'NA', 'NA', 39, 'Iquitos', 10, 28, '4574222222222228', '01', '', '', '', '', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobradores`
--

CREATE TABLE IF NOT EXISTS `cobradores` (
  `codcobrador` int(2) NOT NULL AUTO_INCREMENT,
  `nombrecobrador` varchar(40) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codcobrador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Cobradores' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cobradores`
--

INSERT INTO `cobradores` (`codcobrador`, `nombrecobrador`, `borrado`) VALUES
(9, 'Cobrandor 1', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE IF NOT EXISTS `cobros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codfactura` int(11) NOT NULL,
  `bbcodfactura` int(11) NOT NULL,
  `nombreCliente` varchar(45) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numdocumento` varchar(30) NOT NULL,
  `fechacobro` date NOT NULL DEFAULT '0000-00-00',
  `observaciones` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Cobros de facturas a clientes' AUTO_INCREMENT=69 ;

--
-- Volcado de datos para la tabla `cobros`
--

INSERT INTO `cobros` (`id`, `codfactura`, `bbcodfactura`, `nombreCliente`, `importe`, `codformapago`, `numdocumento`, `fechacobro`, `observaciones`) VALUES
(56, 0, 2091, 41, 59.00, 10, '', '2013-08-26', ''),
(57, 2102, 0, 40, 0.00, 10, '', '2013-08-26', ''),
(58, 2104, 0, 40, 59.00, 10, '', '2013-08-26', ''),
(59, 0, 2092, 41, 59.00, 10, '', '2013-08-26', ''),
(60, 2105, 0, 40, 59.00, 10, '', '2013-08-26', ''),
(61, 0, 2093, 41, 59.00, 10, '', '2013-08-26', ''),
(62, 0, 2096, 41, 60.00, 10, '', '2013-08-30', ''),
(63, 2106, 0, 40, 59.00, 10, '', '2013-08-30', ''),
(64, 0, 2095, 40, 60.00, 10, '', '2013-08-30', ''),
(65, 0, 2094, 41, 60.00, 10, '', '2013-08-30', ''),
(66, 0, 2097, 40, 50.00, 10, '', '2013-08-31', ''),
(67, 2107, 0, 41, 129.80, 10, '', '2013-08-31', ''),
(68, 0, 2114, 40, 60.00, 10, '', '2013-09-04', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefactulinea`
--

CREATE TABLE IF NOT EXISTS `eefactulinea` (
  `bbcodfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`bbcodfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas a clientes' AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `eefactulinea`
--

INSERT INTO `eefactulinea` (`bbcodfactura`, `numlinea`, `codfamilia`, `codigo`, `cantidad`, `precio`, `importe`, `dcto`) VALUES
(2088, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2089, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2090, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2090, 2, 74, '2', 1.00, 50.00, 50.00, 0),
(2091, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2092, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2093, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2094, 1, 75, '1', 1.00, 60.00, 60.00, 0),
(2095, 1, 75, '1', 1.00, 60.00, 60.00, 0),
(2096, 1, 75, '1', 1.00, 60.00, 60.00, 0),
(2097, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2098, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2098, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2099, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2099, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2100, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2100, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2100, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2101, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2101, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2101, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2102, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2102, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2102, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2103, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2103, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2103, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2104, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2104, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2104, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2105, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2105, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2105, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2106, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2106, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2106, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2107, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2107, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2107, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2108, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2108, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2108, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2109, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2109, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2109, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2110, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2110, 2, 75, '1', 1.00, 60.00, 60.00, 0),
(2110, 3, 75, '1', 1.00, 60.00, 60.00, 0),
(2111, 1, 75, '1', 1.00, 60.00, 60.00, 0),
(2112, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2113, 1, 74, '2', 1.00, 50.00, 50.00, 0),
(2114, 1, 75, '1', 1.00, 60.00, 60.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefactulineap`
--

CREATE TABLE IF NOT EXISTS `eefactulineap` (
  `bbcodfactura` varchar(20) NOT NULL DEFAULT '',
  `codproveedor` int(5) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`bbcodfactura`,`codproveedor`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefactulineaptmp`
--

CREATE TABLE IF NOT EXISTS `eefactulineaptmp` (
  `bbcodfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`bbcodfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores temporal' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefactulineatmp`
--

CREATE TABLE IF NOT EXISTS `eefactulineatmp` (
  `bbcodfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`bbcodfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Temporal de linea de facturas a clientes' AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `eefactulineatmp`
--

INSERT INTO `eefactulineatmp` (`bbcodfactura`, `numlinea`, `codfamilia`, `codigo`, `cantidad`, `precio`, `importe`, `dcto`) VALUES
(2381, 1, 75, '1', 1.00, 60.00, 60.00, 0),
(2378, 1, 74, '2', 1.00, 50.00, 50.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefacturas`
--

CREATE TABLE IF NOT EXISTS `eefacturas` (
  `bbcodfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `codcliente` int(5) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT '0',
  `totalfactura` decimal(19,2) NOT NULL,
  `fechavencimiento` date NOT NULL DEFAULT '0000-00-00',
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  `remito` varchar(20) NOT NULL,
  `numfactura` varchar(20) NOT NULL,
  PRIMARY KEY (`bbcodfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='facturas de ventas a clientes' AUTO_INCREMENT=2115 ;

--
-- Volcado de datos para la tabla `eefacturas`
--

INSERT INTO `eefacturas` (`bbcodfactura`, `fecha`, `iva`, `codcliente`, `estado`, `totalfactura`, `fechavencimiento`, `borrado`, `remito`, `numfactura`) VALUES
(2088, '2013-08-26', 18, 40, '1', 59.00, '0000-00-00', '0', '', ''),
(2089, '2013-08-26', 18, 1, '1', 59.00, '0000-00-00', '0', '', ''),
(2090, '2013-08-26', 18, 40, '1', 118.00, '0000-00-00', '0', '', ''),
(2091, '2013-08-26', 18, 41, '2', 59.00, '0000-00-00', '0', '', ''),
(2092, '2013-08-26', 18, 41, '2', 59.00, '0000-00-00', '0', '', ''),
(2093, '2013-08-26', 18, 41, '2', 59.00, '0000-00-00', '0', '', ''),
(2094, '2013-08-30', 0, 41, '2', 60.00, '0000-00-00', '0', '', ''),
(2095, '2013-08-30', 0, 40, '2', 60.00, '0000-00-00', '0', '', ''),
(2096, '2013-08-30', 0, 41, '2', 60.00, '0000-00-00', '0', '', ''),
(2097, '2013-08-31', 0, 40, '2', 50.00, '0000-00-00', '1', '', ''),
(2098, '2013-08-31', 0, 1, '1', 110.00, '0000-00-00', '1', '', ''),
(2099, '2013-08-31', 0, 41, '1', 110.00, '0000-00-00', '1', '', ''),
(2100, '2013-08-31', 0, 1, '1', 170.00, '0000-00-00', '1', '', ''),
(2114, '2013-09-04', 0, 40, '2', 60.00, '0000-00-00', '0', '', ''),
(2113, '2013-09-04', 0, 1, '1', 50.00, '0000-00-00', '1', '', ''),
(2112, '2013-08-31', 0, 1, '1', 50.00, '0000-00-00', '1', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefacturasp`
--

CREATE TABLE IF NOT EXISTS `eefacturasp` (
  `bbcodfactura` varchar(20) NOT NULL DEFAULT '',
  `codproveedor` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT '0',
  `totalfactura` decimal(19,2) NOT NULL,
  `fechapago` date NOT NULL DEFAULT '0000-00-00',
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bbcodfactura`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='facturas de compras a proveedores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefacturasptmp`
--

CREATE TABLE IF NOT EXISTS `eefacturasptmp` (
  `bbcodfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  PRIMARY KEY (`bbcodfactura`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='temporal de facturas de proveedores' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eefacturastmp`
--

CREATE TABLE IF NOT EXISTS `eefacturastmp` (
  `bbcodfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  PRIMARY KEY (`bbcodfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='temporal de facturas a clientes' AUTO_INCREMENT=2383 ;

--
-- Volcado de datos para la tabla `eefacturastmp`
--

INSERT INTO `eefacturastmp` (`bbcodfactura`, `fecha`) VALUES
(2382, '2013-09-04'),
(2381, '2013-09-04'),
(2380, '2013-09-04'),
(2379, '2013-09-04'),
(2378, '2013-09-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `embalajes`
--

CREATE TABLE IF NOT EXISTS `embalajes` (
  `codembalaje` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codembalaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Embalajes' AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `embalajes`
--

INSERT INTO `embalajes` (`codembalaje`, `nombre`, `borrado`) VALUES
(10, 'Caja', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidades`
--

CREATE TABLE IF NOT EXISTS `entidades` (
  `codentidad` int(2) NOT NULL AUTO_INCREMENT,
  `nombreentidad` varchar(50) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codentidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Entidades Bancarias' AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `entidades`
--

INSERT INTO `entidades` (`codentidad`, `nombreentidad`, `borrado`) VALUES
(28, 'Banco de la Nacion', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventcal`
--

CREATE TABLE IF NOT EXISTS `eventcal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eventDate` date DEFAULT NULL,
  `eventTitle` varchar(100) DEFAULT NULL,
  `eventContent` text,
  `borrado` varchar(1) CHARACTER SET cp850 NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `eventDate` date DEFAULT NULL,
  `eventContent` longtext,
  `langCode` varchar(20) DEFAULT 'en',
  PRIMARY KEY (`eventID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factulinea`
--

CREATE TABLE IF NOT EXISTS `factulinea` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  `fvendedor` varchar(20) NOT NULL,
  PRIMARY KEY (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas a clientes' AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `factulinea`
--

INSERT INTO `factulinea` (`codfactura`, `numlinea`, `codfamilia`, `codigo`, `cantidad`, `precio`, `importe`, `dcto`,`fvendedor`) VALUES
(2103, 1, 74, '2', 1.00, 50.00, 50.00, 0,''),
(2104, 1, 74, '2', 1.00, 50.00, 50.00, 0,''),
(2105, 1, 74, '2', 1.00, 50.00, 50.00, 0,''),
(2106, 1, 74, '2', 1.00, 50.00, 50.00, 0,''),
(2107, 1, 75, '1', 1.00, 60.00, 60.00, 0,''),
(2107, 2, 74, '2', 1.00, 50.00, 50.00, 0,''),
(500, 1, 74, '2', 5.00, 50.00, 250.00, 0,''),
(2109, 1, 75, '1', 1.00, 60.00, 60.00, 0,'');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factulineap`
--

CREATE TABLE IF NOT EXISTS `factulineap` (
  `codfactura` varchar(20) NOT NULL DEFAULT '',
  `codproveedor` int(5) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`codfactura`,`codproveedor`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores' AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `factulineap`
--

INSERT INTO `factulineap` (`codfactura`, `codproveedor`, `numlinea`, `codfamilia`, `codigo`, `cantidad`, `precio`, `importe`, `dcto`) VALUES
('000147', 25, 1, 74, '2', 1.00, 20.00, 20.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factulineaptmp`
--

CREATE TABLE IF NOT EXISTS `factulineaptmp` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores temporal' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factulineatmp`
--

CREATE TABLE IF NOT EXISTS `factulineatmp` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL AUTO_INCREMENT,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` decimal(19,2) NOT NULL,
  `precio` decimal(19,2) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Temporal de linea de facturas a clientes' AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `factulineatmp`
--

INSERT INTO `factulineatmp` (`codfactura`, `numlinea`, `codfamilia`, `codigo`, `cantidad`, `precio`, `importe`, `dcto`) VALUES
(0, 4, 74, '2', 1.00, 50.00, 50.00, 0),
(0, 5, 74, '2', 1.00, 50.00, 50.00, 0),
(0, 3, 75, '1', 1.00, 60.00, 60.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `codfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `nombreCliente` varchar(45) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT '0',
  `totalfactura` decimal(19,2) NOT NULL,
  `fechavencimiento` date NOT NULL DEFAULT '0000-00-00',
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  `remito` varchar(20) NOT NULL,
`numfactura` varchar(20) NOT NULL,
  `fvendedor` varchar(20) NOT NULL,
  PRIMARY KEY (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='facturas de ventas a clientes' AUTO_INCREMENT=2110 ;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`codfactura`, `fecha`, `iva`, `nombreCliente`, `estado`, `totalfactura`, `fechavencimiento`, `borrado`, `remito`, `numfactura`,`fvendedor`) VALUES
(2089, '2013-08-26', 18, 1, '1', 0.00, '0000-00-00', '0', '', '', ''),
(2090, '2013-08-26', 18, 41, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2091, '2013-08-26', 18, 1, '1', 0.00, '0000-00-00', '0', '', '', ''),
(2092, '2013-08-26', 18, 1, '1', 0.00, '0000-00-00', '0', '', '', ''),
(2093, '2013-08-26', 18, 40, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2094, '2013-08-26', 18, 1, '1', 0.00, '0000-00-00', '0', '', '', ''),
(2095, '2013-08-26', 18, 41, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2096, '2013-08-26', 18, 40, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2097, '2013-08-26', 18, 40, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2098, '2013-08-26', 18, 41, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2099, '2013-08-26', 18, 41, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2100, '2013-08-26', 18, 40, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2101, '2013-08-26', 18, 40, '1', 0.00, '0000-00-00', '1', '', '', ''),
(2102, '2013-08-26', 18, 40, '2', 0.00, '0000-00-00', '1', '', '', ''),
(2103, '2013-08-26', 18, 1, '1', 59.00, '0000-00-00', '0', '', '', ''),
(2104, '2013-08-26', 18, 40, '2', 59.00, '0000-00-00', '0', '', '', ''),
(2105, '2013-08-26', 18, 40, '2', 59.00, '0000-00-00', '0', '', '', ''),
(2106, '2013-08-30', 18, 40, '2', 59.00, '0000-00-00', '0', '', '', ''),
(2107, '2013-08-31', 18, 41, '2', 129.80, '0000-00-00', '0', '', '', ''),
(500, '2013-08-31', 18, 1, '1', 295.00, '0000-00-00', '1', '', '', ''),
(2109, '2013-08-31', 18, 1, '1', 70.80, '0000-00-00', '1', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturasp`
--

CREATE TABLE IF NOT EXISTS `facturasp` (
  `codfactura` varchar(20) NOT NULL DEFAULT '',
  `codproveedor` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT '0',
  `totalfactura` decimal(19,2) NOT NULL,
  `fechapago` date NOT NULL DEFAULT '0000-00-00',
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codfactura`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='facturas de compras a proveedores';

--
-- Volcado de datos para la tabla `facturasp`
--

INSERT INTO `facturasp` (`codfactura`, `codproveedor`, `fecha`, `iva`, `estado`, `totalfactura`, `fechapago`, `borrado`) VALUES
('000147', 25, '2013-08-31', 18, '2', 23.60, '0000-00-00', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturasptmp`
--

CREATE TABLE IF NOT EXISTS `facturasptmp` (
  `codfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  PRIMARY KEY (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='temporal de facturas de proveedores' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturastmp`
--

CREATE TABLE IF NOT EXISTS `facturastmp` (
  `codfactura` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  PRIMARY KEY (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='temporal de facturas a clientes' AUTO_INCREMENT=2393 ;

--
-- Volcado de datos para la tabla `facturastmp`
--

INSERT INTO `facturastmp` (`codfactura`, `fecha`) VALUES
(2389, '2013-09-02'),
(2392, '2013-09-04'),
(2391, '2013-09-03'),
(2390, '2013-09-03'),
(2388, '2013-09-02'),
(2387, '2013-09-02'),
(2386, '2013-09-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE IF NOT EXISTS `familias` (
  `codfamilia` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(35) DEFAULT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codfamilia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='familia de articulos' AUTO_INCREMENT=76 ;

--
-- Volcado de datos para la tabla `familias`
--

INSERT INTO `familias` (`codfamilia`, `nombre`, `borrado`) VALUES
(74, 'Vitaminas', '0'),
(75, 'Energizantes', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formapago`
--

CREATE TABLE IF NOT EXISTS `formapago` (
  `codformapago` int(2) NOT NULL AUTO_INCREMENT,
  `nombrefp` varchar(40) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codformapago`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Forma de pago' AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `formapago`
--

INSERT INTO `formapago` (`codformapago`, `nombrefp`, `borrado`) VALUES
(10, 'Contado', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE IF NOT EXISTS `impuestos` (
  `codimpuesto` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  `valor` decimal(19,1) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codimpuesto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='tipos de impuestos' AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`codimpuesto`, `nombre`, `valor`, `borrado`) VALUES
(17, 'IV', 13.0, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librodiario`
--

CREATE TABLE IF NOT EXISTS `librodiario` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `tipodocumento` varchar(1) NOT NULL,
  `coddocumento` varchar(20) NOT NULL,
  `codcomercial` int(5) NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numpago` varchar(30) NOT NULL,
  `total` decimal(19,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Movimientos diarios' AUTO_INCREMENT=84 ;

--
-- Volcado de datos para la tabla `librodiario`
--

INSERT INTO `librodiario` (`id`, `fecha`, `tipodocumento`, `coddocumento`, `codcomercial`, `codformapago`, `numpago`, `total`) VALUES
(69, '2013-08-26', '2', '2091', 41, 10, '', 59.00),
(70, '2013-08-26', '2', '2091', 41, 10, '', 59.00),
(71, '2013-08-26', '2', '2102', 40, 10, '', 0.00),
(72, '2013-08-26', '2', '2104', 40, 10, '', 59.00),
(73, '2013-08-26', '2', '2092', 41, 10, '', 59.00),
(74, '2013-08-26', '2', '2105', 40, 10, '', 59.00),
(75, '2013-08-26', '2', '2093', 41, 10, '', 59.00),
(76, '2013-08-30', '2', '2096', 41, 10, '', 60.00),
(77, '2013-08-30', '2', '2106', 40, 10, '', 50.00),
(78, '2013-08-30', '2', '2095', 40, 10, '', 60.00),
(79, '2013-08-30', '2', '2094', 41, 10, '', 60.00),
(80, '2013-08-31', '2', '2097', 40, 10, '', 50.00),
(81, '2013-08-31', '2', '2107', 41, 10, '', 129.80),
(82, '2013-08-31', '1', '000147', 25, 10, '000111', 23.60),
(83, '2013-09-04', '2', '2114', 40, 10, '', 60.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codfactura` varchar(20) NOT NULL,
  `codproveedor` int(5) NOT NULL,
  `importe` decimal(19,2) NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numdocumento` varchar(30) NOT NULL,
  `fechapago` date DEFAULT '0000-00-00',
  `observaciones` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Pagos de facturas a proveedores' AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `codfactura`, `codproveedor`, `importe`, `codformapago`, `numdocumento`, `fechapago`, `observaciones`) VALUES
(8, '000147', 25, 23.60, 10, '000111', '2013-08-31', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `indice` int(1) NOT NULL DEFAULT '0',
  `usuario` varchar(10) DEFAULT NULL,
  `clave` varchar(10) DEFAULT NULL,
  `servidor` varchar(20) DEFAULT NULL,
  `basedatos` varchar(20) DEFAULT NULL,
  `numeracionfactura` decimal(10,0) DEFAULT NULL,
  `numeracionboleta` decimal(10,0) DEFAULT NULL,
  `setnumfac` decimal(1,0) DEFAULT NULL,
  `setnumbol` decimal(1,0) DEFAULT NULL,
  `fondofac` text,
  `imagenfac` varchar(30) DEFAULT NULL,
  `fondoguia` text,
  `imagenguia` varchar(30) DEFAULT NULL,
  `filasdetallefactura` int(2) DEFAULT NULL,
  `ivaimp` decimal(2,0) DEFAULT NULL,
  `nombremoneda` varchar(20) DEFAULT NULL,
  `simbolomoneda` varchar(20) DEFAULT NULL,
  `codigomoneda` varchar(10) DEFAULT NULL,
  `nomempresa` tinytext,
  `giro` varchar(50) DEFAULT NULL,
  `fonos` varchar(30) DEFAULT NULL,
  `direccion` varchar(30) DEFAULT NULL,
  `comuna` varchar(30) DEFAULT NULL,
  `ciudadactual` varchar(30) DEFAULT NULL,
  `numerofiscal` varchar(20) DEFAULT NULL,
  `resolucionsii` varchar(50) DEFAULT NULL,
  `rutempresa` varchar(20) DEFAULT NULL,
  `giro2` varchar(50) DEFAULT NULL,
  `logoempresa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`indice`),
  KEY `indice` (`indice`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`indice`, `usuario`, `clave`, `servidor`, `basedatos`, `numeracionfactura`, `numeracionboleta`, `setnumfac`, `setnumbol`, `fondofac`, `imagenfac`, `fondoguia`, `imagenguia`, `filasdetallefactura`, `ivaimp`, `nombremoneda`, `simbolomoneda`, `codigomoneda`, `nomempresa`, `giro`, `fonos`, `direccion`, `comuna`, `ciudadactual`, `numerofiscal`, `resolucionsii`, `rutempresa`, `giro2`, `logoempresa`) VALUES
(1, '', '', '', '', 500, NULL, 0, NULL, 'NO', 'Factura v3chile.jpg', 'SI', 'logo.jpg', 10, 13, 'Colones', 'c:', 'CRC', 'TCU Universidad de Costa Rica - Sistema de Punto de Ventas', 'Venta en Local', '065- 458596', 'Guapiles', 'CENTRO', 'Guapiles', '10427467495', '123', '10427467495', 'Venta de Articulos', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petroleo`
--

CREATE TABLE IF NOT EXISTS `petroleo` (
  `mes` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `codproveedor` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `nif` varchar(12) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codprovincia` int(2) NOT NULL,
  `localidad` varchar(35) NOT NULL,
  `codentidad` int(2) NOT NULL,
  `cuentabancaria` varchar(20) NOT NULL,
  `codpostal` varchar(5) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `movil` varchar(14) NOT NULL,
  `email` varchar(35) NOT NULL,
  `web` varchar(45) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codproveedor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Proveedores' AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`codproveedor`, `nombre`, `nif`, `direccion`, `codprovincia`, `localidad`, `codentidad`, `cuentabancaria`, `codpostal`, `telefono`, `movil`, `email`, `web`, `borrado`) VALUES
(24, 'NEGOCIOS TERRONES S.R.L', '2014569874', 'Calle Cruz de Chalpon 156', 38, 'Chiclayo', 28, '457125896321895', '1', '', '', '', '', '0'),
(25, 'TCB EXPORT IMPORT SRL', '245236987421', 'Calle Progreso 186', 39, 'Lima', 28, '5263987412398', '1', '', '', '', '', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `codprovincia` int(2) NOT NULL AUTO_INCREMENT,
  `nombreprovincia` varchar(40) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codprovincia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Provincias' AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`codprovincia`, `nombreprovincia`, `borrado`) VALUES
(1, 'San Jose', '0'),
(2, 'Alajuela', '0'),
(3, 'Cartago', '0'),
(4, 'Heredia', '0'),
(5, 'Guanacaste', '0'),
(6, 'Puntarenas', '0'),
(7, 'Limon', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabbackup`
--

CREATE TABLE IF NOT EXISTS `tabbackup` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `archivo` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE IF NOT EXISTS `ubicaciones` (
  `codubicacion` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codubicacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Ubicaciones' AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`codubicacion`, `nombre`, `borrado`) VALUES
(14, 'Zona 1', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uf`
--

CREATE TABLE IF NOT EXISTS `uf` (
  `Fecha` varchar(20) DEFAULT NULL,
  `Valor` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `useronline`
--

CREATE TABLE IF NOT EXISTS `useronline` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `timestamp` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=268 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(200)  NOT NULL DEFAULT '',
  `user_name` varchar(25) unique NOT NULL DEFAULT '',
  `user_pwd` varchar(50)  NOT NULL DEFAULT '',
  `user_email` varchar(200)  NOT NULL DEFAULT '',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `joined` date NOT NULL DEFAULT '0000-00-00',
  `rol` boolean NOT NULL,
  `user_activated` boolean NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `full_name`, `user_name`, `user_pwd`, `user_email`, `activation_code`, `joined`, `rol`, `user_activated`) VALUES
(1, 'Administrador', 'admin', 'e756e26154f31e502382339270d32aa2', 'jeisoncespedes@gmail.com', 2597, now(), 1, 1),
(2, 'Jeison Cespedes', 'jeison', 'e756e26154f31e502382339270d32aa2', 'jeisoncespedes@gmail.com', 2537, now(), 2, 1);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE IF NOT EXISTS `vendedores` (
  `codvendedor` int(5) NOT NULL AUTO_INCREMENT,
  `nombrevendedor` varchar(45) NOT NULL,
  `movil` varchar(14) NOT NULL,
  `email` varchar(35) NOT NULL,
  `borrado` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codvendedor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Clientes' AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`codvendedor`, `nombrevendedor`, `movil`, `email`, `borrado`) VALUES
(12, 'Vendedor 1', '', '', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
