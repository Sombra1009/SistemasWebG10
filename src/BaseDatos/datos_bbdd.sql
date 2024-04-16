TRUNCATE TABLE `usuario`;
TRUNCATE TABLE `producto`;
TRUNCATE TABLE `categoria`;
TRUNCATE TABLE `listaCategoria`;
TRUNCATE TABLE `niveles`;
TRUNCATE TABLE `noticia`;
TRUNCATE TABLE `bundle`;
TRUNCATE TABLE `listaBundle`;
TRUNCATE TABLE `order`;
TRUNCATE TABLE `orderItem`;
TRUNCATE TABLE `sorteo`;
TRUNCATE TABLE `listaSorteo`;

/*
    admin: admin
    user: user
    pepe: pepe
*/

INSERT INTO `usuario` (`id`, `username`, `mail`, `password`, `role`, `created_at`, `nivel`, `xp`, `monedas`) VALUES
(1, 'admin', 'admin@ucm.es', '$2y$10$g8glnzdWHsFmNt1iwb.3OOQ/dsQd5EamXiuyZat5/py1MYsQCVfe6', 3, '2024-04-12 15:34:31', 1, 0, 0),
(2, 'user', 'user@ucm.es', '$2y$10$sd52nlmYNDSs7CD7Pxc0vOL5qGH2x9x5mTwpwEufjkr8aTWsd7.nq', 1, '2024-04-12 15:33:20', 1, 0, 0),
(3, 'pepe', 'pepe@ucm.es', '$2y$10$MfRKwedHmNfxV7MB68wLLe3sC7LfYzS.yFY7lD4mzsAqnUSol1WIq', 2, '2024-04-12 15:34:47', 1, 0, 0);


INSERT INTO `producto` (`nombre`,`descripcion`,`precio`,`stock`, `imagen`, `valoracion`, `user_id`, `descuento`,`nivel`, `fecha`) VALUES
('Minecraft', 'Descripcion del producto 1', 10.0, 10, './productos/1.png', 4, 1, 0,1, NOW()),
('Whatsapp 2', 'Descripcion del producto 2', 20.0, 20, './productos/2.png', 4, 1, 0,1, NOW()),
('CS:GO', 'Descripcion del producto 3', 30.0, 30, './productos/3.png', 4, 1, 10,0, NOW()),
('The Binding Of Issac', 'Descripcion del producto 4', 40.0, 40, './productos/4.png', 4, 1, 7,1, NOW()),
('The Binding Of Issac 2', 'Descripcion del producto 5', 40.0, 40, './productos/4.png', 4, 1, 10,3, NOW());



INSERT INTO `categoria` (`nombre`, `descripcion`) VALUES
( 'RPG', 'Descripcion del categoria 1'),
( 'RogueLike', 'Descripcion del categoria 2');

INSERT INTO `listaCategoria` (`idCategoria`,`idProd`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4);


INSERT INTO `niveles` (`nivel`, `xpLevel`) VALUES
(1, 100),
(2, 200),
(3, 300),
(4, 400),
(5, 500);

INSERT INTO `noticia` (`nombre`,`descripcion`, `imagen`) VALUES
('Noticias1','Descripcion del noticias 1','./noticias/1.png'),
('Noticias2','Descripcion del noticias 2', './noticias/2.png'),
('Noticias3','Descripcion del noticias 3', './noticias/3.png'),
('Noticias4','Descripcion del noticias 4', './noticias/4.png');

INSERT INTO `bundle` (`nombre`,`descripcion`, `imagen`, `estado`) VALUES
('INICIO','Descripcion del bundle 1', './bundle/1.png', 1),
('INICIO2','Descripcion del bundle 2', './bundle/2.png', 1);


INSERT INTO `listaBundle` (`idBundle`,`idProd`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4);

INSERT INTO `order` (`idUsuario`, `estado`, `fecha`) VALUES
(1, 1, NOW()),
(1, 2, NOW()),
(2, 1, NOW()),
(2, 2, NOW());

INSERT INTO `orderItem` (`idOrder`, `idProd`) VALUES
(1, 1),
(1, 2),
(3, 3),
(3, 4);

INSERT INTO `sorteo` (`nombre`,`descripcion`, `imagen`, `estado`) VALUES
('SORTEO','Descripcion del sorteo 1', './sorteo/1.png', 1),
('SORTEO2','Descripcion del sorteo 2', './sorteo/2.png', 1);

INSERT INTO `listaSorteo`(`idSorteo`, `idUsuario`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);



