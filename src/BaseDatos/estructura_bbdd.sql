
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `order_item`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `niveles`;
DROP TABLE IF EXISTS `categorias`;
DROP TABLE IF EXISTS `categorias_productos`;


CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` integer AUTO_INCREMENT PRIMARY KEY,
  `mail` integer,
  `order_date` datetime,
  `state` integer COMMENT '0-Pendiente, 1-Completado, 2-Enviado'
);

CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` integer AUTO_INCREMENT PRIMARY KEY,
  `order_id` integer,
  `product_id` integer,
  `cantidad` integer,
  `precio` integer
);

CREATE TABLE IF NOT EXISTS `users` (
  `mail` varchar(255) PRIMARY KEY,
  `username` varchar(255) UNIQUE,
  `hashed_password` varchar(255),
  `nivel` integer,
  `xp` integer,
  `role` integer,
  `created_at` datetime
);


CREATE TABLE IF NOT EXISTS `productos` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(255),
  `descripcion` text,
  `precio` double,
  `cantidad` integer,
  `imagen` varchar(255),
  `valoracion` integer,
  `user_mail` varchar(255) 
);



CREATE TABLE IF NOT EXISTS `niveles` (
  `nivel` integer PRIMARY KEY,
  `xpMax` integer
);

CREATE TABLE IF NOT EXISTS `categorias` (
  `name` varchar(255) PRIMARY KEY,
  `descripcion` text
);

CREATE TABLE IF NOT EXISTS `categorias_productos` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `categorias_name` varchar(255),
  `productos_id` integer
);


ALTER TABLE `order_item` ADD FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `order_item` ADD FOREIGN KEY (`product_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users` ADD FOREIGN KEY (`nivel`) REFERENCES `niveles` (`nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `productos` ADD FOREIGN KEY (`user_mail`) REFERENCES `users` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `categorias_productos` ADD FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `categorias_productos` ADD FOREIGN KEY (`categorias_name`) REFERENCES `categorias` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

