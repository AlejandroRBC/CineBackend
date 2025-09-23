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
    estado ENUM('En proyección','Desactivado') NOT NULL DEFAULT 'En proyección',
    clasificacion VARCHAR(20),
    sonido VARCHAR(50)
);


CREATE TABLE RESEÑA (
    idReseña INT AUTO_INCREMENT PRIMARY KEY,
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
    tipo VARCHAR(50) NOT NULL
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
('12545104', 'Recursos Humanos', 'Ana Pérez', 'Tiempo Completo', 4500.00),
('12545104', 'Gestión Comercial', 'Carlos Gómez', 'Medio Tiempo', 3800.00),
('12545104', 'Gestión Salas', 'María López', 'Fines de Semana', 3000.00),
('12545104', 'Gestión Usuario', 'Luis Fernández', 'Tiempo Completo', 4200.00);

