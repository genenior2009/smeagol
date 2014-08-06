##############################################################################################
-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2014 a las 19:16:07
-- Versión del servidor: 5.5.36
-- Versión de PHP: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `smeagol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `label` varchar(150) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `node_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_node1_idx` (`node_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `name`, `label`, `url`, `parent_id`, `order_id`, `node_id`) VALUES
(1, 'default', NULL, NULL, 0, 0, NULL),
(2, 'admin', NULL, NULL, 0, 0, NULL),
(3, NULL, 'Inicio', '/', 1, 0, NULL),
(4, NULL, 'Nosotros', NULL, 1, 1, 1),
(5, NULL, 'Servicios', NULL, 1, 2, 5),
(6, NULL, 'Programación web', NULL, 5, 0, 4),
(7, NULL, 'Desarrollo de Portales', NULL, 5, 1, 6),
(8, NULL, 'Soluciones', NULL, 1, 3, 7),
(9, NULL, 'Soporte', NULL, 1, 4, 8),
(10, NULL, 'Contáctenos', NULL, 1, 5, 9),
(11, NULL, 'Dashboard', 'admin', 2, 0, NULL),
(12, NULL, 'Contenido', 'admin/page', 2, 1, NULL),
(13, NULL, 'Noticias', 'admin/noticias', 2, 2, NULL),
(14, NULL, 'Menus', 'admin/menus', 2, 3, NULL),
(15, NULL, 'Temas', 'admin/themes', 2, 4, NULL),
(16, NULL, 'Usuarios', 'admin/users', 2, 5, NULL),
(17, NULL, 'Permisos', 'admin/permissions', 16, 1, NULL),
(18, NULL, 'Roles', 'admin/roles', 16, 0, NULL),
(19, NULL, 'Smeagol CMS', NULL, 7, 0, 10),
(20, NULL, 'Drupal CMS', NULL, 7, 1, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `node`
--

CREATE TABLE IF NOT EXISTS `node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(250) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `node_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_node_node_type1_idx` (`node_type_id`),
  KEY `fk_node_user1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `node`
--

INSERT INTO `node` (`id`, `title`, `content`, `url`, `created`, `modified`, `node_type_id`, `user_id`) VALUES
(1, 'Nosotros', '<p><strong>Smeagol CMS, un</strong><strong>&nbsp;demo de desarrolado en Zend Framework 2</strong></p>\r\n\r\n<p>Nosotros somos hinchas de Zend Framework 2</p>\r\n\r\n<p>Gurus del php&nbsp;</p>\r\n\r\n<p>que deasrrollamos aplicaciones alucinantes</p>\r\n', 'nosotros', '2014-07-01 20:47:24', '2014-07-17 13:56:17', 1, 1),
(2, 'Smeagol primer CMS en ZF2', 'haber si funca', 'noticias/smeagol-primer-cms-en-zf2', '2014-07-01 20:47:24', NULL, 2, 1),
(3, 'El mundial Brasil 2014 esta que quema', 'El mundial esta super emocionante', 'noticias/mundialsuper-emocionante', '2014-07-01 20:47:24', NULL, 2, 1),
(4, 'Programación Web', '<p>Somos unos tigres del PHP y dem&aacute;s hierbas</p>\r\n', 'servicios/programacion-web', '2014-07-10 22:47:08', '2014-07-17 13:50:46', 1, 1),
(5, 'Servicios', '<p>Somos Expertos Programadores y le ofrecemos los siguientes servicios</p>\r\n\r\n<p><a href="/servicios/programacion-web">Programaci&oacute;n web</a>&nbsp;</p>\r\n\r\n<p><a href="/servicios/desarrollo-de-portales">Desarrollo de Portales</a></p>\r\n', 'servicios', '2014-07-17 13:50:18', '2014-07-17 13:50:18', 1, 1),
(6, 'Desarrollo de Portales', '<p>Creamos portales con smeagol y drupal&nbsp;</p>\r\n', 'servicios/desarrollo-de-portales', '2014-07-17 13:52:35', '2014-07-17 13:52:35', 1, 1),
(7, 'Soluciones', '<p><img alt="" src="/files/fotos/puesta-de-sol.jpg" style="float:left; height:141px; width:188px" />Hacemos desarrollo de software a medida y contamos con las siguientes soluciones</p>\r\n\r\n<p><a href="/soluciones/smeagolcms">Smeagol CMS</a></p>\r\n\r\n<p><a href="/soluciones/intranets">Intranets</a></p>\r\n', 'soluciones/intranets', '2014-07-17 13:54:35', '2014-08-03 19:41:00', 1, 1),
(8, 'Soporte', '<p>Brindamos el mejor soporte al mejor precio</p>\r\n\r\n<p>en planes</p>\r\n\r\n<p>8x5</p>\r\n\r\n<p>24x7</p>\r\n', 'soporte', '2014-07-17 13:58:17', '2014-07-17 13:58:17', 1, 1),
(9, 'Contactenos', '<p>Cont&aacute;ctenos y no se arrepentir&aacute;</p>\r\n\r\n<p>al fono &nbsp;666-666-666</p>\r\n', 'contactenos', '2014-07-17 13:59:13', '2014-07-17 13:59:13', 1, 1),
(10, 'Smeagol', '<h1>El mejor CMS en Zend Frammework 2  :D</h1>', 'servicios/desarrollo-de-portales/smeagol', '2014-07-22 08:05:00', NULL, 1, 1),
(11, 'Drupal 7', '<h1> El Mejor CMS del mundo</h1>\r\n<h2> Que lo usa hasta el tío Obama<h2>', 'servicios/desarrollo-de-portales/drupal', '2014-07-22 08:05:00', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `node_type`
--

CREATE TABLE IF NOT EXISTS `node_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `node_type`
--

INSERT INTO `node_type` (`id`, `name`) VALUES
(1, 'page'),
(2, 'notice');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `resource` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `type` varchar(30) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`type`, `description`) VALUES
('admin', 'Usuarios Administradores, todos los permisos'),
('editor', 'Usuarios con el rol de editor, por defecto puede crear, editar y borrar todos los contenidos'),
('guest', 'Usuarios anónimos, por defecto pueden acceder a todos los contenidos'),
('member', 'Usuarios Autenticados, por defecto pueden editar su propio contenido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_type` varchar(30) NOT NULL,
  `permission_resource` varchar(250) NOT NULL,
  PRIMARY KEY (`role_type`,`permission_resource`),
  KEY `fk_role_permission_role1_idx` (`role_type`),
  KEY `fk_role_permission_permission1_idx` (`permission_resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `active` int(11) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `role_type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_role_idx` (`role_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `surname`, `email`, `active`, `last_login`, `modified`, `role_type`) VALUES
(1, 'admin', 'c6865cf98b133f1f3de596a4a2894630', 'Admin', 'of Universe', 'tucorreo@gmail.com', 1, NULL, '2014-07-01 20:47:24', 'admin'),
(2, 'pepito', 'c6865cf98b133f1f3de596a4a2894630', 'Pepito', 'Linuxero', 'pepito@hotmail.com', 1, '2014-08-04 00:00:00', '2014-08-04 00:00:00', 'editor'),
(3, 'pepito', 'c6865cf98b133f1f3de596a4a2894630', 'Pepito', 'Linuxero', 'pepito@hotmail.com', 1, NULL, NULL, 'editor');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_node1` FOREIGN KEY (`node_id`) REFERENCES `node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `node`
--
ALTER TABLE `node`
  ADD CONSTRAINT `fk_node_node_type1` FOREIGN KEY (`node_type_id`) REFERENCES `node_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_node_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `fk_role_permission_role1` FOREIGN KEY (`role_type`) REFERENCES `role` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_permission_permission1` FOREIGN KEY (`permission_resource`) REFERENCES `permission` (`resource`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_type`) REFERENCES `role` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;