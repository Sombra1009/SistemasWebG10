DROP TABLE IF EXISTS `producto`;

DROP TABLE IF EXISTS `categoria`;

DROP TABLE IF EXISTS `listaCategoria`;

DROP TABLE IF EXISTS `usuario`;

DROP TABLE IF EXISTS `niveles`;

DROP TABLE IF EXISTS `historialMonedero`;

DROP TABLE IF EXISTS `orders`;

DROP TABLE IF EXISTS `orderItem`;

DROP TABLE IF EXISTS `sorteo`;

DROP TABLE IF EXISTS `bundle`;

DROP TABLE IF EXISTS `noticia`;

CREATE TABLE IF NOT EXISTS `producto` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` text,
  `precio` double,
  `stock` integer,
  `imagen` varchar(255),
  `valoracion` integer,
  `user_id` integer,
  `descuento` integer,
  `nivel` integer,
  `fecha` timestamp
);

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` varchar(255)
);

CREATE TABLE IF NOT EXISTS `listaCategoria` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idCategoria` integer,
  `idProd` integer
);


CREATE TABLE IF NOT EXISTS `usuario` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) UNIQUE,
  `mail` varchar(255) UNIQUE,
  `password` varchar(255),
  `role` integer,
  `created_at` timestamp,
  `nivel` integer,
  `xp` integer,
  `monedas` double
);

CREATE TABLE IF NOT EXISTS `niveles` (
  `nivel` integer PRIMARY KEY,
  `xpLevel` integer
);

CREATE TABLE IF NOT EXISTS `historialMonedero` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idUsuario` integer,
  `monedas` double,
  `estado` integer,
  `fecha` datetime
);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idUsuario` integer,
  `estado` integer,
  `fecha` datetime
);

CREATE TABLE IF NOT EXISTS `orderItem` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idOrder` integer,
  `idProd` integer
);

CREATE TABLE IF NOT EXISTS `sorteo` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` text,
  `imagen` varchar(255),
  `estado` integer
);

CREATE TABLE IF NOT EXISTS `listaSorteo` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idSorteo` integer,
  `idUsuario` integer
);

CREATE TABLE IF NOT EXISTS `bundle` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` text,
  `imagen` varchar(255),
  `estado` integer
);

CREATE TABLE IF NOT EXISTS `listaBundle` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `idBundle` integer,
  `idProd` integer
);

CREATE TABLE IF NOT EXISTS `noticia` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` text,
  `imagen` varchar(255)
);

ALTER TABLE `producto` ADD FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE; 
ALTER TABLE `producto` ADD FOREIGN KEY (`nivel`) REFERENCES `niveles` (`nivel`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaCategoria` ADD FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaCategoria` ADD FOREIGN KEY (`idProd`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `usuario` ADD FOREIGN KEY (`nivel`) REFERENCES `niveles` (`nivel`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `historialMonedero` ADD FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `orders` ADD FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `orderItem` ADD FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `orderItem` ADD FOREIGN KEY (`idProd`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaSorteo` ADD FOREIGN KEY (`idSorteo`) REFERENCES `sorteo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaSorteo` ADD FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaBundle` ADD FOREIGN KEY (`idBundle`) REFERENCES `bundle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `listaBundle` ADD FOREIGN KEY (`idProd`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;