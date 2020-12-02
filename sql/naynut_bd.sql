-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-05-2018 a las 18:33:09
-- Versión del servidor: 5.6.32-78.1
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `chiclay4_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL,
  `mostrar` int(11) DEFAULT '1',
  `tipo` int(11) DEFAULT NULL,
  `titulo` text COLLATE utf8_unicode_ci,
  `descripcion` text COLLATE utf8_unicode_ci,
  `boton` text COLLATE utf8_unicode_ci,
  `link` text COLLATE utf8_unicode_ci,
  `imagen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `banners`
--

INSERT INTO `banners` (`id`, `mostrar`, `tipo`, `titulo`, `descripcion`, `boton`, `link`, `imagen`, `orden`, `estado_idestado`) VALUES
(1, 1, NULL, '', '', NULL, NULL, '5O9Z14.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `ide` int(11) NOT NULL,
  `id_suscrito` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `texto` text,
  `imagen` text,
  `fecha_registro` date DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT '2',
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ide`, `id_suscrito`, `tipo`, `texto`, `imagen`, `fecha_registro`, `estado_idestado`, `orden`) VALUES
(2, 1, 2, 'Error de prueba  edita pue ome', NULL, '2017-11-02', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `idestado` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`idestado`, `nombre`, `valor`) VALUES
(1, 'Habilitado', NULL),
(2, 'Deshabilitado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos_productos`
--

CREATE TABLE IF NOT EXISTS `favoritos_productos` (
  `id_suscrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria_producto`
--

CREATE TABLE IF NOT EXISTS `galeria_producto` (
  `id_image` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `nombre` text,
  `imagen` text,
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE IF NOT EXISTS `linea_pedido` (
  `id_linea` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `talla` varchar(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `estado_entrega` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

-- CREATE TABLE IF NOT EXISTS `marcas` (
  -- `id_marca` int(11) NOT NULL,
  -- `nombre` varchar(200) NOT NULL,
  -- `banner` text,
  -- `imagen` text,
  -- `nombre_rewrite` tinytext,
  -- `estado_idestado` int(11) DEFAULT NULL,
  -- `orden` int(11) DEFAULT NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_suscrito` int(11) NOT NULL,
  `codigo` varchar(250) DEFAULT NULL,
  `envio` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `articulos` int(11) NOT NULL,
  `direccion` varchar(350) NOT NULL,
  `comentario` varchar(300) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `estado_entrega` int(11) DEFAULT '2',
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL,
  -- `id_marca` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `titulo_rewrite` text NOT NULL,
  `tipo` int(11) DEFAULT '2',
  `stock` int(11) NOT NULL DEFAULT '2',
  `igv` int(11) DEFAULT '2',
  `garantia` text NOT NULL,
  `condicion` varchar(300) DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `puntuales` varchar(400) CHARACTER SET utf8 DEFAULT NULL,
  `especificaciones` text,
  `detalle` text,
  `imagen` varchar(250) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `costo_promo` decimal(10,0) DEFAULT NULL,
  `likes` int(11) DEFAULT '3',
  `orden` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `productos_entregados`
--

CREATE TABLE IF NOT EXISTS `productos_entregados` (
  `id_image` int(11) NOT NULL,
  `id_suscrito` int(11) DEFAULT NULL,
  `nombre` text,
  `imagen` text,
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE IF NOT EXISTS `publicacion` (
  `idpublicacion` int(11) NOT NULL,
  `estado_idestado` int(11) NOT NULL,
  `titulo` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `titulo_rewrite` text CHARACTER SET utf8,
  `avance` text,
  `descripcion` text CHARACTER SET utf8,
  `imagen` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `archivo` text,
  `fecha_registro` date DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idpublicacion`, `estado_idestado`, `titulo`, `titulo_rewrite`, `avance`, `descripcion`, `imagen`, `archivo`, `fecha_registro`, `orden`) VALUES
(1, 1, 'Historia de las botas Timberland', 'historia-de-las-botas-timberland', 'Abington, Massachusetts es una ciudad pintoresca que en los años cincuenta formó parte de una revolución del calzado.', '<p>En este pueblo de Nueva Inglaterra la familia Swartz fund&oacute; una empresa especializada en calzado que posteriormente se convertir&iacute;a en la firma Timberland.Diez a&ntilde;os despu&eacute;s, la familia introdujo la tecnolog&iacute;a de inyecci&oacute;n de molde en sus productos. &Eacute;sta permiti&oacute; fusionar la suela con la piel del calzado sin necesidad de costuras, lo que evitaba que el agua y la nieve entraran en el interior del zapato.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>En los a&ntilde;os setenta la empresa se traslad&oacute; a Newmarket, New Hampshire, donde la compa&ntilde;&iacute;a encontr&oacute; su nombre e identidad. Ellos se inspiraron en los bosques madereros de la zona (Timberland en ingl&eacute;s). Para las d&eacute;cadas siguientes, la marca ampli&oacute; su gama de productos a piezas de piel impermeable y calzado de alto rendimiento, as&iacute; como prendas de uso rudo.</p>\r\n\r\n<p>Las famosas botas amarillas &mdash;Yellow Boots o 6 inch&mdash; son el producto estrella de la marca y una de las pocas piezas que no ha cambiado su dise&ntilde;o desde que se lanz&oacute; al mercado. Est&aacute;n fabricadas de cuatro filas de bordado en nylon, suelas de caucho, tecnolog&iacute;a anti fatiga, piel a prueba de agua, cordones Taslan, collar de piel acolchada y ojales de lat&oacute;n a prueba de oxido.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Las famosas botas amarillas &mdash;Yellow Boots o 6 inch&mdash; son el producto estrella de la marca y una de las pocas piezas que no ha cambiado su dise&ntilde;o desde que se lanz&oacute; al mercado. Est&aacute;n fabricadas de cuatro filas de bordado en nylon, suelas de caucho, tecnolog&iacute;a anti fatiga, piel a prueba de agua, cordones Taslan, collar de piel acolchada y ojales de lat&oacute;n a prueba de oxido.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Estas piezas originalmente se crearon para satisfacer las necesidades de los obreros, pero gracias a su particular dise&ntilde;o y c&oacute;modas suelas cautivaron al mundo: el a&ntilde;o pasado se convirtieron en un it shoe y celebridades como Rihanna, Kanye West, Gwen Stefani y otros las convirtieron en un b&aacute;sico.</p>\r\n', 'UYWV20.jpg', NULL, '2017-11-29', 1);


--
-- Estructura de tabla para la tabla `suscritos`
--

CREATE TABLE IF NOT EXISTS `suscritos` (
  `id_suscrito` int(11) NOT NULL,
  `email` text NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellidos` varchar(300) DEFAULT NULL,
  `empresa` varchar(300) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `imagen` text,
  `clave` varchar(250) NOT NULL,
  `telefono` varchar(250) DEFAULT NULL,
  
  `direccion` varchar(300) DEFAULT NULL,
  `referencia` varchar(250) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado_idestado` int(11) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `idtipo_usu` int(11) NOT NULL,
  `nombre_tipousu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`idtipo_usu`, `nombre_tipousu`) VALUES
(1, 'Administrador'),
(2, 'Invitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL,
  `estado_idestado` int(11) NOT NULL,
  `idtipo_usu` int(11) DEFAULT NULL,
  `codusuario` varchar(100) DEFAULT NULL,
  `nomusuario` varchar(200) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `estado_idestado`, `idtipo_usu`, `codusuario`, `nomusuario`, `email`, `fecha_ingreso`, `contrasena`, `orden`) VALUES
(2, 1, 1, 'admin', 'Luis Eduardo Mori Ayala', 'ing.moriayala@gmail.com', '2016-11-23 15:50:43', '68131eeb338e47dfd20ca0aaeaa66a40', 1);


--
-- Estructura de tabla para la tabla `videos`
--
CREATE TABLE IF NOT EXISTS `videos` (
  `idvideo` int(11) NOT NULL,
  `nombre_video` varchar(200) DEFAULT NULL,
  `nombrevideo_rewrite` text,
  `link` text,
  `estado_idestado` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ide`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `favoritos_productos`
--
ALTER TABLE `favoritos_productos`
  ADD KEY `productos_id_producto` (`id_producto`), ADD KEY `suscritos_id_suscrito` (`id_suscrito`);

--
-- Indices de la tabla `galeria_producto`
--
ALTER TABLE `galeria_producto`
  ADD PRIMARY KEY (`id_image`), ADD KEY `productos_id_producto` (`id_producto`), ADD KEY `estado_idestado` (`estado_idestado`);

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`id_linea`), ADD KEY `pedidos_id_pedido` (`id_pedido`), ADD KEY `productos_id_producto` (`id_producto`);

--
-- Indices de la tabla `marcas`
--
-- ALTER TABLE `marcas`
  -- ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`), ADD KEY `suscritos_id_suscrito` (`id_suscrito`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`), 
  -- ADD KEY `marcas_id_marca` (`id_marca`),
  ADD KEY `estado_idestado` (`estado_idestado`);

--
-- Indices de la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
  ADD PRIMARY KEY (`id_image`), ADD KEY `suscritos_id_suscrito` (`id_suscrito`), ADD KEY `estado_idestado` (`estado_idestado`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idpublicacion`), ADD KEY `estado_idestado` (`estado_idestado`);

--
-- Indices de la tabla `suscritos`
--
ALTER TABLE `suscritos`
  ADD PRIMARY KEY (`id_suscrito`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`idtipo_usu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`), ADD KEY `fk_usuario_estado1` (`estado_idestado`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`idvideo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ide` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `galeria_producto`
--
ALTER TABLE `galeria_producto`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `marcas`
--
-- ALTER TABLE `marcas`
  -- MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idpublicacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `suscritos`
--
ALTER TABLE `suscritos`
  MODIFY `id_suscrito` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `idtipo_usu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `idvideo` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `favoritos_productos`
--
ALTER TABLE `favoritos_productos`
ADD CONSTRAINT `favoritos_productos_ibfk_1` FOREIGN KEY (`id_suscrito`) REFERENCES `suscritos` (`id_suscrito`),
ADD CONSTRAINT `favoritos_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `galeria_producto`
--
ALTER TABLE `galeria_producto`
ADD CONSTRAINT `galeria_producto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
ADD CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
ADD CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);


--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_suscrito`) REFERENCES `suscritos` (`id_suscrito`);

--
-- Filtros para la tabla `productos`
--
-- ALTER TABLE `productos`
-- ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`);

--
-- Filtros para la tabla `productos_entregados`
--
ALTER TABLE `productos_entregados`
ADD CONSTRAINT `productos_entregados_ibfk_1` FOREIGN KEY (`id_suscrito`) REFERENCES `suscritos` (`id_suscrito`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`estado_idestado`) REFERENCES `estado` (`idestado`) ON DELETE NO ACTION;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
