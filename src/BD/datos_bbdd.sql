TRUNCATE TABLE `usuario`;
TRUNCATE TABLE `producto`;
TRUNCATE TABLE `categoria`;
TRUNCATE TABLE `listaCategoria`;
TRUNCATE TABLE `niveles`;
TRUNCATE TABLE `noticia`;
TRUNCATE TABLE `foro`;
TRUNCATE TABLE `orders`;
TRUNCATE TABLE `orderItem`;
TRUNCATE TABLE `sorteo`;
TRUNCATE TABLE `listaSorteo`;

/*
    admin: admin; Rol de administrador
    user: user; Rol de usuario
    pepe: pepe; Rol de vendedor
    ramon: ramon; Rol para verificar como vendedor
*/

INSERT INTO `usuario` (`id`, `username`, `mail`, `password`, `salt`, `role`, `created_at`, `nivel`, `xp`, `monedas`) VALUES
(1, 'admin', 'admin@ucm.es', '$2y$10$MbpbZOH9j56lfZsTR/eAz.Zraw3Ja0igQvOgl86iMjB1rgv1RZJNm', '9fc963c7edbf4dd1634e949bea21828b', 3, '2024-04-12 15:34:31', 5, 0, 0),
(2, 'user', 'user@ucm.es', '$2y$10$xfCfrjS0IT4V1vsFDsgpPeFZDSBCKRhIuZLP4YkXIl1PFsBZi9XBu', 'b87d42e0dabee473ddb59022c0a83b3e', 1, '2024-04-12 15:33:20', 1, 0, 0),
(3, 'pepe', 'pepe@ucm.es', '$2y$10$6cD/zEKTnUPeph5afkt6sOrj6MnkQuUi.lrKVFkKHOSJxAaSKOitK', '31030863bde734c100ea2b54f479befb', 2, '2024-04-12 15:34:47', 1, 0, 0),
(4, 'ramon', 'ramon@ucm.es', '$2y$10$CAsnupeJNJtkY9Ui1RNvNuGVWjEZ97toTOBhbaELpgmaLHON9vScG', '0b72849672c5f492a27bc6347d0cde85', 0, '2024-05-14 10:49:23', 1, 0, 0);


INSERT INTO `producto` (`nombre`,`descripcion`,`precio`,`stock`, `imagen`, `valoracion`, `user_id`, `descuento`,`nivel`, `fecha`,`estado`) VALUES
('Minecraft', 'Descripcion del producto 1', 10.0, 10, './productos/1.png', 4, 1, 0,1, NOW(), 1),
('Whatsapp 2', 'Descripcion del producto 2', 20.0, 20, './productos/2.png', 4, 1, 0,1, NOW(), 1),
('CS:GO', 'Descripcion del producto 3', 30.0, 30, './productos/3.png', 4, 1, 10,0, NOW(), 1),
('The Binding Of Issac', 'Descripcion del producto 4', 40.0, 40, './productos/4.png', 4, 1, 7,1, NOW(), 1),
('The Binding Of Issac 2', 'Descripcion del producto 5', 40.0, 40, './productos/4.png', 4, 1, 10,3, NOW(), 1);

INSERT INTO `foro` (`idProducto`, `titulo`) VALUES
(1, 'Foro de Minecraft'),
(2, 'Foro de Whatsapp 2'),
(3, 'Foro de CS:GO'),
(4, 'Foro de The Binding Of Issac'),
(5, 'Foro de The Binding Of Issac 2');

INSERT INTO `categoria` (`nombre`, `descripcion`) VALUES
( 'RPG', 'Descripcion del categoria 1'),
( 'RogueLike', 'Descripcion del categoria 2'),
( 'FPS', 'Descripcion del categoria 3'),
( 'Aventura', 'Descripcion del categoria 4'),
( 'Plataforma', 'Descripcion del categoria 5'),
( 'Estrategia', 'Descripcion del categoria 6'),
( 'Deportes', 'Descripcion del categoria 7'),
( 'Simulacion', 'Descripcion del categoria 8'),
( 'Carreras', 'Descripcion del categoria 9'),
( 'Indie', 'Descripcion del categoria 10'),
( 'Casual', 'Descripcion del categoria 11'),
( 'Multijugador', 'Descripcion del categoria 12'),
( 'Cooperativo', 'Descripcion del categoria 13'),
( 'Competitivo', 'Descripcion del categoria 14'),
( 'Puzzle', 'Descripcion del categoria 15'),
( 'Horror', 'Descripcion del categoria 16'),
( 'Survival', 'Descripcion del categoria 17'),
( 'Shooter', 'Descripcion del categoria 18'),
( 'Accion', 'Descripcion del categoria 19'),
( 'Aventura Grafica', 'Descripcion del categoria 20'),
( 'Plataforma 2D', 'Descripcion del categoria 21'),
( 'Plataforma 3D', 'Descripcion del categoria 22');

INSERT INTO `listaCategoria` (`idCategoria`,`idProd`) VALUES
(11, 1),
(7, 2),
(4, 3),
(14, 4),
(20, 5);


INSERT INTO `niveles` (`nivel`, `xpLevel`) VALUES
(1, 100),
(2, 200),
(3, 300),
(4, 400),
(5, 500),
(6, 600),
(7, 700),
(8, 800),
(9, 900),
(10, 1000);

INSERT INTO `noticia` (`nombre`,`descripcion`, `imagen`, `fecha`) VALUES
('Noticias1','Descripcion del noticias 1','./noticias/1.png', NOW()),
('Noticias2','Descripcion del noticias 2', './noticias/2.png', NOW()),
('Noticias3','Descripcion del noticias 3', './noticias/3.png', NOW()),
('Noticias4','Descripcion del noticias 4', './noticias/4.png', NOW());

INSERT INTO `orders` (`idUsuario`, `estado`, `fecha`) VALUES
(1, 0, NOW()),
(2, 0, NOW()),
(3, 0, NOW());

INSERT INTO `sorteo` (`nombre`,`descripcion`, `imagen`, `idProd`, `fecha`, `estado`) VALUES
('SORTEO','Descripcion del sorteo 1', './sorteo/1.png', 1, "2024-05-30 23:59:59", 1),
('SORTEO2','Descripcion del sorteo 2', './sorteo/2.png', 2, "2024-07-11 23:59:59", 1),
('SORTEO3','Descripcion del sorteo 3', './sorteo/3.png', 3, "2024-07-11 23:59:59", 1);

INSERT INTO `listaSorteo`(`idSorteo`, `idUsuario`) VALUES
(1, 1),
(2, 2);



