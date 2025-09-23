CREATE DATABASE IF NOT EXISTS cine;
USE cine;

CREATE TABLE PERSONAL (
    idPersonal INT AUTO_INCREMENT PRIMARY KEY,
    ci VARCHAR(20) NOT NULL,
    puesto VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    turno ENUM('Tiempo Completo','Medio Tiempo','Fines de Semana') NOT NULL,
    salario DECIMAL(10,2) NOT NULL
);

CREATE TABLE Hist_Entrada_personal (
    idPersonal INT,
    horaEntrada TIME NOT NULL,
    horaSalida TIME NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (idPersonal) REFERENCES PERSONAL(idPersonal)
);

CREATE TABLE USUARIO (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nom_usu VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(50) NOT NULL,
    puntos INT DEFAULT 0,
    fec_creacion DATE NOT NULL,
    fec_nac DATE NOT NULL,
    telefono VARCHAR(20),
    ci_nit VARCHAR(20),
    contrasena VARCHAR(255) NOT NULL,
    fecha_acceso DATETIME NULL
);

CREATE TABLE PELICULA (
    idPelicula INT AUTO_INCREMENT PRIMARY KEY,
    nom_pel VARCHAR(100) NOT NULL,
    lenguaje VARCHAR(50),
    formato ENUM('2D','3D','4D') NOT NULL,
    categoria VARCHAR(50),
    fecha_lanzamiento DATE,
    estado ENUM('En proyeccion','Desactivado') NOT NULL DEFAULT 'En proyeccion',
    clasificacion VARCHAR(20),
    sonido VARCHAR(50)
);

CREATE TABLE RESENA (
    idResena INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT,
    idPelicula INT,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 10),
    comentario TEXT,
    FOREIGN KEY (idUsuario) REFERENCES USUARIO(idUsuario),
    FOREIGN KEY (idPelicula) REFERENCES PELICULA(idPelicula)
);

CREATE TABLE SALA (
    nro_Sala INT PRIMARY KEY,
    capacidad INT NOT NULL
);

CREATE TABLE Se_proyecta (
    idProyeccion INT AUTO_INCREMENT PRIMARY KEY,
    idPelicula INT,
    nro_Sala INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (idPelicula) REFERENCES PELICULA(idPelicula),
    FOREIGN KEY (nro_Sala) REFERENCES SALA(nro_Sala)
);

CREATE TABLE BUTACA (
    idButaca INT AUTO_INCREMENT PRIMARY KEY,
    nro_Fila INT NOT NULL,
    nro_Col INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    estado ENUM('LIBRE','RESERVADA','OCUPADA') NOT NULL DEFAULT 'LIBRE'
);


CREATE TABLE Tiene (
    nro_Sala INT,
    idButaca INT,
    PRIMARY KEY (nro_Sala,idButaca),
    FOREIGN KEY (nro_Sala) REFERENCES SALA(nro_Sala),
    FOREIGN KEY (idButaca) REFERENCES BUTACA(idButaca)
);

CREATE TABLE hist_mantenimiento (
    idMantenimiento INT AUTO_INCREMENT PRIMARY KEY,
    nro_Sala INT,
    fechaMantenimiento DATE NOT NULL,
    FOREIGN KEY (nro_Sala) REFERENCES SALA(nro_Sala)
);

CREATE TABLE PRODUCTOS (
    idProducto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    stock INT NOT NULL,
    es_combo ENUM('True','False') NOT NULL DEFAULT 'False',
    activo ENUM('Activo','Desactivado') NOT NULL DEFAULT 'Activo'
);

CREATE TABLE Combo_detalle (
    idCombo INT,
    idProducto INT,
    cantidadProd INT NOT NULL,
    PRIMARY KEY (idCombo,idProducto),
    FOREIGN KEY (idCombo) REFERENCES PRODUCTOS(idProducto),
    FOREIGN KEY (idProducto) REFERENCES PRODUCTOS(idProducto)
);

CREATE TABLE VENTA (
    idVenta INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT,
    total DECIMAL(10,2) NOT NULL,
    tipo_pago VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES USUARIO(idUsuario)
);

CREATE TABLE Detalle_venta (
    idDetalle_venta INT AUTO_INCREMENT PRIMARY KEY,
    idVenta INT,
    idPelicula INT,
    idButaca INT,
    nro_Sala INT,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idVenta) REFERENCES VENTA(idVenta),
    FOREIGN KEY (idPelicula) REFERENCES PELICULA(idPelicula),
    FOREIGN KEY (idButaca) REFERENCES BUTACA(idButaca),
    FOREIGN KEY (nro_Sala) REFERENCES SALA(nro_Sala)
);

CREATE TABLE Detalle_prods (
    idDetalle_prod INT AUTO_INCREMENT PRIMARY KEY,
    idVenta INT,
    idProducto INT,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idVenta) REFERENCES VENTA(idVenta),
    FOREIGN KEY (idProducto) REFERENCES PRODUCTOS(idProducto)
);

INSERT INTO PERSONAL (ci, puesto, nombre, turno, salario)
VALUES 
('12545104', 'Recursos Humanos', 'Ana Perez', 'Tiempo Completo', 4500.00),
('12545104', 'Gestion Comercial', 'Carlos Gomez', 'Medio Tiempo', 3800.00),
('12545104', 'Gestion Salas', 'Maria Lopez', 'Fines de Semana', 3000.00),
('12545104', 'Gestion Usuario', 'Luis Fernandez', 'Tiempo Completo', 4200.00);

INSERT INTO PERSONAL (ci, puesto, nombre, turno, salario)
VALUES
('1234567', 'Cajero', 'Ana Lopez', 'Tiempo Completo', 3500.00),
('2345678', 'Proyeccionista', 'Carlos Gomez', 'Medio Tiempo', 2500.00),
('3456789', 'Limpieza', 'Maria Rios', 'Fines de Semana', 1200.00);

INSERT INTO Hist_Entrada_personal (idPersonal, horaEntrada, horaSalida, fecha)
VALUES
(1, '14:00:00', '22:00:00', '2025-09-19'),
(2, '18:00:00', '23:00:00', '2025-09-19');

INSERT INTO USUARIO (nom_usu, nombre, rol, puntos, fec_creacion, fec_nac, telefono, ci_nit)
VALUES
('juan23', 'Juan Perez', 'Cliente', 120, '2025-01-15', '2000-03-21', '70012345', '9876543'),
('maria88', 'Maria Torres', 'Cliente', 80, '2025-03-10', '1995-11-12', '76543210', '1234567'),
('admin01', 'Luis Fernandez', 'Administrador', 0, '2025-06-01', '1980-05-05', '70123456', NULL);

INSERT INTO PELICULA (nom_pel, lenguaje, formato, categoria, fecha_lanzamiento, estado, clasificacion, sonido)
VALUES
('Inception', 'Ingles', '2D', 'Sci-Fi', '2010-07-16', 'En proyeccion', 'PG-13', 'Dolby'),
('Coco', 'Espanol', '3D', 'Animacion', '2017-10-27', 'En proyeccion', 'PG', 'Atmos'),
('Avengers: Endgame', 'Ingles', '4D', 'Accion', '2019-04-26', 'Desactivado', 'PG-13', 'IMAX');

INSERT INTO SALA (nro_Sala, capacidad)
VALUES
(1, 100),
(2, 80);

INSERT INTO BUTACA (nro_Fila, nro_Col, tipo)
VALUES
(1, 1, 'Normal'),
(1, 2, 'Normal'),
(2, 1, 'VIP'),
(2, 2, 'Normal');

INSERT INTO Tiene (nro_Sala, idButaca)
VALUES
(1, 1), (1, 2), (1, 3),
(2, 4);

INSERT INTO Se_proyecta (idPelicula, nro_Sala, fecha, hora)
VALUES
(1, 1, '2025-09-21', '19:00:00'),
(2, 2, '2025-09-21', '20:30:00');

INSERT INTO hist_mantenimiento (nro_Sala, fechaMantenimiento)
VALUES
(1, '2025-08-10'),
(2, '2025-09-01');

INSERT INTO PRODUCTOS (nombre, precio, descripcion, stock, es_combo, activo)
VALUES
('Coca-Cola 500ml', 15.00, 'Bebida gaseosa', 50, 'False', 'Activo'),
('Nachos con queso', 20.00, 'Snack salado', 30, 'False', 'Activo'),
('Combo Nachos + Refresco', 30.00, 'Incluye 1 Nachos + 1 Refresco', 10, 'True', 'Activo');

INSERT INTO Combo_detalle (idCombo, idProducto, cantidadProd)
VALUES
(3, 1, 1),
(3, 2, 1);

INSERT INTO VENTA (idUsuario, total, tipo_pago, fecha)
VALUES
(1, 45.00, 'Tarjeta', '2025-09-21'),
(2, 30.00, 'Efectivo', '2025-09-21');

INSERT INTO Detalle_venta (idVenta, idPelicula, idButaca, nro_Sala, subtotal)
VALUES
(1, 1, 1, 1, 30.00),
(1, 1, 2, 1, 30.00),
(2, 2, 4, 2, 25.00);

INSERT INTO Detalle_prods (idVenta, idProducto, cantidad, subtotal)
VALUES
(1, 1, 1, 15.00),
(2, 3, 1, 30.00);

INSERT INTO RESENA (idUsuario, idPelicula, puntuacion, comentario)
VALUES
(1, 1, 9, 'Excelente trama, muy recomendable.'),
(2, 2, 8, 'Muy emotiva, ideal para toda la familia.');

INSERT INTO PERSONAL (ci, puesto, nombre, turno, salario)
VALUES
('4567890', 'Gerente', 'Roberto Silva', 'Tiempo Completo', 6000.00),
('5678901', 'Taquillero', 'Laura Mendoza', 'Tiempo Completo', 2800.00),
('6789012', 'Seguridad', 'Jorge Herrera', 'Fines de Semana', 1500.00),
('7890123', 'Dulceria', 'Sofia Castro', 'Medio Tiempo', 2200.00),
('8901234', 'Proyeccionista', 'Diego Rojas', 'Tiempo Completo', 3200.00);

INSERT INTO Hist_Entrada_personal (idPersonal, horaEntrada, horaSalida, fecha)
VALUES
(1, '08:00:00', '16:00:00', '2025-09-20'),
(2, '14:00:00', '22:00:00', '2025-09-20'),
(3, '18:00:00', '02:00:00', '2025-09-20'),
(4, '16:00:00', '20:00:00', '2025-09-20'),
(5, '12:00:00', '20:00:00', '2025-09-20');

INSERT INTO USUARIO (nom_usu, nombre, rol, puntos, fec_creacion, fec_nac, telefono, ci_nit)
VALUES
('carlos99', 'Carlos Rodriguez', 'Cliente', 200, '2024-11-20', '1998-07-15', '71234567', '7654321'),
('ana45', 'Ana Garcia', 'Cliente', 50, '2025-02-28', '2001-12-03', '72345678', '8765432'),
('pedro77', 'Pedro Martinez', 'Cliente', 300, '2024-08-10', '1990-04-22', '73456789', '9876543'),
('lucia22', 'Lucia Fernandez', 'Cliente', 75, '2025-05-15', '1995-09-30', '74567890', '5432167'),
('miguel33', 'Miguel Sanchez', 'Administrador', 0, '2024-12-01', '1985-11-18', '75678901', NULL);

INSERT INTO PELICULA (nom_pel, lenguaje, formato, categoria, fecha_lanzamiento, estado, clasificacion, sonido)
VALUES
('The Batman', 'Ingles', '2D', 'Accion', '2022-03-04', 'En proyeccion', 'PG-13', 'Dolby Atmos'),
('Spider-Man: No Way Home', 'Ingles', '3D', 'Accion', '2021-12-17', 'En proyeccion', 'PG-13', 'IMAX'),
('Frozen 2', 'Espanol', '2D', 'Animacion', '2019-11-22', 'En proyeccion', 'PG', 'Dolby'),
('Dune', 'Ingles', '4D', 'Ciencia Ficcion', '2021-10-22', 'En proyeccion', 'PG-13', 'IMAX'),
('Black Panther', 'Ingles', '3D', 'Accion', '2018-02-16', 'Desactivado', 'PG-13', 'Dolby'),
('La La Land', 'Ingles', '2D', 'Musical', '2016-12-09', 'En proyeccion', 'PG-13', 'Dolby'),
('Toy Story 4', 'Espanol', '3D', 'Animacion', '2019-06-21', 'En proyeccion', 'G', 'Atmos');

INSERT INTO SALA (nro_Sala, capacidad)
VALUES
(3, 120),
(4, 60),
(5, 150),
(6, 90);

INSERT INTO BUTACA (nro_Fila, nro_Col, tipo)
VALUES
(1, 1, 'Normal'), (1, 2, 'Normal'), (1, 3, 'Normal'), (1, 4, 'Normal'), (1, 5, 'Normal'),
(2, 1, 'Normal'), (2, 2, 'Normal'), (2, 3, 'VIP'), (2, 4, 'VIP'), (2, 5, 'Normal'),
(3, 1, 'Normal'), (3, 2, 'Normal'), (3, 3, 'Normal'), (3, 4, 'Normal'), (3, 5, 'Normal');

INSERT INTO Tiene (nro_Sala, idButaca)
VALUES
(3, 5), (3, 6), (3, 7), (3, 8), (3, 9),
(3, 10), (3, 11), (3, 12), (3, 13), (3, 14),
(3, 15), (3, 16), (3, 17), (3, 18), (3, 19);

INSERT INTO Se_proyecta (idPelicula, nro_Sala, fecha, hora)
VALUES
(4, 3, '2025-09-21', '16:00:00'),
(5, 4, '2025-09-21', '18:30:00'),
(6, 5, '2025-09-21', '21:00:00'),
(7, 6, '2025-09-21', '22:30:00'),
(1, 1, '2025-09-22', '15:00:00'),
(2, 2, '2025-09-22', '17:30:00'),
(3, 3, '2025-09-22', '20:00:00'),
(4, 4, '2025-09-23', '19:00:00'),
(6, 5, '2025-09-23', '21:30:00');

INSERT INTO hist_mantenimiento (nro_Sala, fechaMantenimiento)
VALUES
(3, '2025-08-15'),
(4, '2025-09-05'),
(5, '2025-07-20'),
(6, '2025-09-10');

INSERT INTO PRODUCTOS (nombre, precio, descripcion, stock, es_combo, activo)
VALUES
('Pepsi 500ml', 14.00, 'Bebida gaseosa', 40, 'False', 'Activo'),
('Agua Mineral 500ml', 10.00, 'Agua sin gas', 60, 'False', 'Activo'),
('Jugo de Naranja 350ml', 12.00, 'Jugo natural', 25, 'False', 'Activo'),
('Palomitas Grandes', 25.00, 'Palomitas de maiz con mantequilla', 20, 'False', 'Activo'),
('Palomitas Medianas', 18.00, 'Palomitas de maiz', 30, 'False', 'Activo'),
('Hot Dog', 22.00, 'Pan con salchicha', 15, 'False', 'Activo'),
('Chocolates Variados', 15.00, 'Mezcla de chocolates', 35, 'False', 'Activo'),
('Combo Familiar', 75.00, '2 Palomitas Grandes + 4 Refrescos', 8, 'True', 'Activo'),
('Combo Pareja', 45.00, '1 Palomitas Medianas + 2 Refrescos', 12, 'True', 'Activo'),
('Combo Individual Premium', 35.00, 'Palomitas Grandes + Refresco + Chocolate', 10, 'True', 'Activo');

INSERT INTO Combo_detalle (idCombo, idProducto, cantidadProd)
VALUES
(8, 4, 2),
(8, 1, 4),
(9, 5, 1),
(9, 1, 2),
(10, 4, 1),
(10, 1, 1),
(10, 7, 1);

INSERT INTO VENTA (idUsuario, total, tipo_pago, fecha)
VALUES
(3, 120.00, 'Tarjeta', '2025-09-20'),
(4, 65.50, 'Efectivo', '2025-09-20'),
(5, 45.00, 'Tarjeta', '2025-09-19'),
(1, 90.00, 'Efectivo', '2025-09-19'),
(2, 150.00, 'Tarjeta', '2025-09-18');

INSERT INTO Detalle_venta (idVenta, idPelicula, idButaca, nro_Sala, subtotal)
VALUES
(3, 4, 5, 3, 35.00),
(3, 4, 6, 3, 35.00),
(3, 4, 7, 3, 50.00);

INSERT INTO Detalle_prods (idVenta, idProducto, cantidad, subtotal)
VALUES
(3, 8, 1, 75.00);

INSERT INTO Detalle_venta (idVenta, idPelicula, idButaca, nro_Sala, subtotal)
VALUES
(4, 6, 10, 5, 30.00);

INSERT INTO Detalle_prods (idVenta, idProducto, cantidad, subtotal)
VALUES
(4, 5, 1, 18.00),
(4, 3, 1, 12.00),
(4, 7, 1, 15.00);

INSERT INTO Detalle_venta (idVenta, idPelicula, idButaca, nro_Sala, subtotal)
VALUES
(5, 7, 12, 6, 25.00),
(5, 7, 13, 6, 25.00);

INSERT INTO Detalle_prods (idVenta, idProducto, cantidad, subtotal)
VALUES
(5, 10, 1, 35.00);

INSERT INTO RESENA (idUsuario, idPelicula, puntuacion, comentario)
VALUES
(3, 4, 10, 'Espectacular! Los efectos en 4D son increibles.'),
(4, 6, 9, 'Hermosa historia y banda sonora.'),
(5, 7, 8, 'Divertida para toda la familia.'),
(1, 3, 7, 'Buena pelicula pero esperaba mas del formato 3D.'),
(2, 1, 9, 'Clasico que nunca falla.'),
(3, 2, 8, 'Muy buena adaptacion del comic.');

INSERT INTO VENTA (idUsuario, total, tipo_pago, fecha)
VALUES
(1, 55.00, 'Efectivo', '2025-08-15'),
(2, 70.00, 'Tarjeta', '2025-08-20'),
(3, 40.00, 'Efectivo', '2025-09-01'),
(4, 85.00, 'Tarjeta', '2025-09-05'),
(1, 60.00, 'Efectivo', '2025-09-10');

INSERT INTO Se_proyecta (idPelicula, nro_Sala, fecha, hora)
VALUES
(1, 1, '2025-08-10', '19:00:00'),
(2, 2, '2025-08-12', '20:30:00'),
(3, 3, '2025-08-15', '18:00:00'),
(4, 4, '2025-08-20', '21:00:00'),
(5, 5, '2025-08-25', '17:30:00');
