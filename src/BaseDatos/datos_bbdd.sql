TRUNCATE TABLE `users`;
TRUNCATE TABLE `productos`;

/*
    pepito: userpass
    mipana: userpass
*/
INSERT INTO `users` (`mail`, `username`, `hashed_password`, `nivel`, `xp`, `role`, `created_at`) VALUES
('pepito@gmail.com', 'pepito', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 1, 0, 'user', NOW()),
('mipana@gmail.com', 'mipana', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', 1, 0, 'user', NOW());

INSERT INTO `productos` (`user_mail`, `imagen`, `precio`, `valoracion`, `product_name`, `descripcion`, `stock`) VALUES
('pepito@gmail.com', './productos/1.png', 10.0, 5, 'Minecraft', 'Descripcion del producto 1', 10),
('pepito@gmail.com', './productos/2.png', 20.0, 4, 'Whatsapp 2', 'Descripcion del producto 2', 20),
('pepito@gmail.com', './productos/3.png', 30.0, 3, 'cs:go', 'Descripcion del producto 3', 30),
('pepito@gmail.com', './productos/4.png', 40.0, 2, 'tboi', 'Descripcion del producto 4', 40);

INSERT INTO `niveles` (`nivel`, `xpMax`) VALUES
(1, 100),
(2, 200),
(3, 300),
(4, 400),
(5, 500);