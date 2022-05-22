-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2022 a las 00:50:36
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `cofecha`, `idusuario`) VALUES
(1, '2021-11-17 18:52:52', 6),
(2, '2021-11-09 18:53:00', 5),
(6, '2022-03-28 03:39:52', 8),
(7, '2022-03-28 03:42:07', 8),
(18, '2022-04-13 04:45:19', 9),
(19, '2022-04-13 04:46:27', 9),
(20, '2022-04-13 04:46:32', 9),
(25, '2022-04-13 04:55:04', 9),
(26, '2022-04-13 05:04:46', 9),
(27, '2022-04-13 05:18:26', 9),
(29, '2022-04-26 02:53:29', 9),
(51, '2022-04-26 04:27:05', 9),
(52, '2022-04-26 04:27:16', 9),
(53, '2022-04-26 04:28:33', 9),
(54, '2022-04-26 04:28:45', 9),
(55, '2022-04-26 04:29:20', 9),
(56, '2022-04-26 05:04:03', 9),
(57, '2022-04-26 05:04:10', 9),
(58, '2022-04-26 05:04:39', 9),
(59, '2022-04-26 05:05:06', 9),
(60, '2022-04-26 05:06:17', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestado`
--

INSERT INTO `compraestado` (`idcompraestado`, `idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) VALUES
(10, 2, 2, '2022-03-30 03:34:23', NULL),
(11, 1, 3, '2022-04-24 00:50:21', NULL),
(15, 25, 1, '2022-04-13 04:55:04', NULL),
(16, 26, 1, '2022-04-13 05:04:46', '0000-00-00 00:00:00'),
(17, 18, 2, '2022-04-13 00:13:56', NULL),
(18, 19, 2, '2022-04-13 00:15:04', NULL),
(19, 20, 2, '2022-04-13 00:15:04', NULL),
(20, 27, 2, '2022-04-13 05:18:57', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL,
  `cipreciototal` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraitem`
--

INSERT INTO `compraitem` (`idcompraitem`, `idproducto`, `idcompra`, `cicantidad`, `cipreciototal`) VALUES
(1, 1, 1, 1, NULL),
(2, 2, 1, 1, NULL),
(3, 1, 6, 3, '9000'),
(4, 2, 6, 2, '9138'),
(5, 1, 7, 3, '9000'),
(16, 1, 18, 1, '3000'),
(17, 1, 19, 1, '3000'),
(18, 1, 20, 1, '3000'),
(23, 1, 25, 1, '3000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
  `link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`, `link`) VALUES
(0, 'Libros', 'publico', NULL, NULL, 'productosListado.php'),
(1, 'Productos', 'productos padre', NULL, NULL, NULL),
(2, 'compras ', 'compras padre', NULL, NULL, NULL),
(4, 'productos listado', 'ABM productos', 1, NULL, 'productos.php'),
(5, 'Compras', 'compras listado', 2, NULL, 'compras.php'),
(9, 'Rol', 'Rol', NULL, NULL, NULL),
(10, 'Rol Listado', '', 9, NULL, 'rol.php'),
(11, 'Roles Usuarios', '', 9, NULL, 'usuariorol.php'),
(12, 'Usuarios', 'ABM usuarios', NULL, NULL, 'usuario.php'),
(89, 'Menu', '-', NULL, NULL, 'menu.php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(0, 1),
(0, 2),
(0, 3),
(1, 1),
(1, 2),
(2, 1),
(4, 1),
(4, 2),
(5, 1),
(9, 1),
(12, 1),
(89, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(100) NOT NULL,
  `proautor` varchar(100) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL,
  `proprecio` float NOT NULL,
  `proeditorial` varchar(100) NOT NULL,
  `proanio` int(11) NOT NULL,
  `proimagen` varchar(100) NOT NULL,
  `prodeshabilitado` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `proautor`, `prodetalle`, `procantstock`, `proprecio`, `proeditorial`, `proanio`, `proimagen`, `prodeshabilitado`) VALUES
(1, 'Fundamentos de Programacion php', 'Marcelo s', 'La presente publicación Fundamentos de programación PHP tiene como objetivo dar a conocer los primeros pasos que todo Ingeniero de Sistemas, software e Informática debe conocer para empezar a analizar, diseñar y codificar sus primeros algoritmos y pasar la barra que todo programador debe dominar que son las estructuras del control de flujo tales como if, switch, select case, while y for. La publicación presenta 9 capítulos', 3, 3000, 'Alfaomega', 2008, '', 1),
(2, 'Lógica De Programación Orientada A Objetos', 'Efraín Oviedo Regin', 'Presentamos la obra Lógica de programación orientada a objetos, la cual es de gran ayuda a todo aquel que quiera incursionar por primera vez en la solución de problemas a través de un computador, donde el razonamiento lógico debe predominar para que se puedan alcanzar soluciones correctas.', 2, 4569, 'Ecoe ediciones', 2015, '', 1),
(3, 'Billy Summers', 'King Stephen', 'Billy Summers es un asesino a sueldo y el mejor en lo suyo, pero tiene una norma: solo acepta un encargo si su objetivo es realmente mala persona. Ahora Billy quiere dejarlo, pero todavía le queda un último golpe.', 2, 2000, 'Plaza & Janes Editores', 2021, '', 0),
(4, 'Asesino De Brujas, Libro 1', 'Mahurin Shelby', 'Asesinos de brujas: La bruja blanca se desarrolla en un mundo de mujeres empoderadas, magia oscura y donde los romances son fuera de serie', 3, 1970, 'Puck', 2021, 'a87ff679a2f3e71d9181a67b7542122c', 1),
(5, 'En El Limbo', 'Bachrach Estanislao', 'En el limbo es una herramienta esencial de autoconocimiento científico para que aprendas a utilizar tus emociones en beneficio propio. Este libro te enseñará que cualquier habilidad puede ser desarrollada.', 4, 1699, 'Sudamerica', 2020, '', 0),
(6, 'Asesino De Brujas, Libro 2', 'Mahurin Shelby', 'Para sobrevivir, necesitan aliados. Y unos muy poderosos. Pero mientras Lou se preocupa cada vez más por salvar a sus seres queridos, se adentra en el lado oscuro de la magia. ', 3, 1980, 'Puck', 2021, '1679091c5a880faf6fb5e6087eb1b2dc', 1),
(7, 'De Ninguna Parte', 'Navarro Julia', 'De ninguna parte es un viaje a los confines de la conciencia de dos jóvenes, Abir y Jacob, cuyas vidas se cruzan en un campo de refugiados en el sur del Líbano. Ambos, eternos exiliados de sí mismos, se encontrarán años más tarde en Bruselas', 0, 1999, 'Plaza & Janes Editores', 2021, '', 0),
(8, 'Guia Para Sobrevivir Al Presentes', 'Bilinkis Santiago', 'Santiago Bilinkis propone en esta Guía para sobrevivir al presente una manera apasionante de desbloquear nuestra ingenuidad frente a los dispositivos. Y nos ofrece ideas para utilizar ', 2, 2049, 'Sudamerica', 2019, '', 0),
(9, 'BROMATOLOGIA EN  CASA ', 'Mariana, Pitaro Hoffman Erica, Crimer Daniela', '¿Es correcto lavar la carne? ¿Y si le pongo limón? ¿Es seguro darles una hamburguesa a los chicos? Si saco la parte con hongos, ¿lo puedo comer? ¿Mezclando detergente y lavandina limpio y desinfecto al mismo tiempo? ¿Dejo la tapita de metal del queso crema? Se me llenó la cocina de cucarachas y mosquitas. No entiendo lo que dice el rótulo de las galletitas. Había olor feo en la pescadería, ¿es normal? ¿Necesito sanitizar la fruta y las verduras?', 119, 221.91, 'vergara', 2021, '', 1),
(112, 'birrita en la vereda', 'mil house', 'un monton de detalless', 8, 800, 'bola 8', 2002, '', 0),
(114, 'amigues', 'milhaouses', 'historia corta2', 0, 200, 'penguin original', 2021, '', 1),
(128, 'SOY UNA TONTA POR QUERERTE', 'SOSA VILLADA, CAMILA', 'En plena década de los años 90 una mujer se gana la vida como novia de alquiler de hombres gays. En un fumadero de Harlem una travesti latina conoce íntimamente nada menos que a Billie Holiday. Un grupo de rugbiers regatea el precio de una noche de sexo y a cambio recibe su merecido. Monjas; abuelas; niños y perros nunca son lo que parecen. Los nueve relatos que componen este libro están habitados por personajes extravagantes y profundamente humanos que resisten de modos tan extraños como ellos; frente a lo', 10, 2000, 'TUSQUETS', 2022, '', 1),
(130, 'PROBANDO', 'autore', '5', 5, 5, '5', 0, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'Administrador'),
(2, 'Deposito'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(50) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(1, 'yesica Gonzalez', 'd2e6d61d26a275cdf3a7cfb99a494629', 'yesiGonzalo@_correo.com', NULL),
(2, 'Oliver Muñoz', '5e8667a439c68f5145dd2fcbecf02209', 'oliver31@_correo.com', NULL),
(3, 'SimonPizarro', 'd54d1702ad0f8326224b817c796763c9', 'pizarrosimon@_correo.com', NULL),
(4, 'VeronicaMellado', '682e346419a7e9898008f09e846299f8', 'vero1998@_correo.com', NULL),
(5, 'VictoriaFuentess', 'acbd1f86c247d682725cfd556b03635d', 'fuentes_123@_correo.com', NULL),
(6, 'AdrianMedina', '821f3157e1a3456bfe1a000a1adf0862', 'medina_adrian@_correo.com', '2022-03-30 14:32:43'),
(8, 'patricio v', '202cb962ac59075b964b07152d234b70', 'pachuvillalba@gmail.com', NULL),
(9, 'patricio', '202cb962ac59075b964b07152d234b70', 'patricio@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(4, 2),
(4, 3),
(5, 2),
(5, 3),
(6, 3),
(9, 1),
(9, 2),
(9, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
