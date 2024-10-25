CREATE DATABASE linofino;
USE linofino;

CREATE TABLE personas
(
	idpersona			INT AUTO_INCREMENT PRIMARY KEY,
    apellidos			VARCHAR(40)			NOT NULL,
    nombres				VARCHAR(40)			NOT NULL,
    telefono			CHAR(9)				NOT NULL,
    dni					CHAR(8)				NOT NULL,
    direccion			VARCHAR(100)		NULL,
    CONSTRAINT uk_dni_per UNIQUE (dni)
)ENGINE = INNODB;

-- ALTER TABLE personas ADD `direccion` VARCHAR(100) NOT NULL AFTER `dni`;
-- ALTER TABLE personas ADD `TELEFONO` char(9) NOT NULL AFTER `nombres`;

CREATE TABLE usuarios
(
	idusuario			INT AUTO_INCREMENT PRIMARY KEY,
    idpersona			INT 				NOT NULL,
    nomusuario			VARCHAR(30)			NOT NULL,
    claveacceso			VARCHAR(70)			NOT NULL,
    perfil				CHAR(3)				NOT NULL, -- ADM | COL | AST
    CONSTRAINT fk_idpersonausu FOREIGN KEY (idpersona) REFERENCES personas (idpersona),
    CONSTRAINT uk_nomusuario_usu UNIQUE (nomusuario),
    CONSTRAINT ck_perfil_usu CHECK (perfil IN ('ADM', 'COL', 'SUP'))
)ENGINE = INNODB;

ALTER TABLE usuarios DROP CONSTRAINT ck_perfil_usu;
ALTER TABLE usuarios ADD CONSTRAINT ck_perfil_usu CHECK (perfil IN ('ADM', 'COL', 'SUP'));

ALTER TABLE usuarios ADD idperfil INT NULL;
-- Actualizar idperfil en la tabla usuarios
ALTER TABLE usuarios MODIFY COLUMN idperfil INT NOT NULL;
ALTER TABLE usuarios ADD CONSTRAINT fk_idperfil_usu FOREIGN KEY (idperfil) REFERENCES perfiles (idperfil);

CREATE TABLE tareas
(
	idtarea				INT AUTO_INCREMENT PRIMARY KEY,
    nombretarea			VARCHAR(100)		NOT NULL,
    precio				DECIMAL(5,2)		NOT NULL,
    idusuregistra		INT					NOT NULL,
    idusuactualiza		INT					NULL,
    create_at			DATETIME			NOT NULL DEFAULT NOW(),
    update_at			DATETIME			NULL,
    CONSTRAINT uk_nombretarea_tar UNIQUE (nombretarea),
    CONSTRAINT ck_precio_tar CHECK (precio > 0),
    CONSTRAINT fk_idusuregistra_tar FOREIGN KEY (idusuregistra) REFERENCES usuarios (idusuario),
    CONSTRAINT fk_idusuactualiza_tar FOREIGN KEY (idusuactualiza) REFERENCES usuarios (idusuario)
)ENGINE = INNODB;

CREATE TABLE jornadas
(
	idjornada			INT AUTO_INCREMENT PRIMARY KEY,
    idpersona			INT					NOT NULL,
    horainicio			DATETIME			NOT NULL,
    horatermino			DATETIME			NULL,
    CONSTRAINT fk_idpersona_jor FOREIGN KEY (idpersona) REFERENCES personas (idpersona),
    CONSTRAINT ck_horas_jor CHECK (horainicio < horatermino)
)ENGINE = INNODB;

CREATE TABLE detalletareas
(
	iddetalle			INT AUTO_INCREMENT PRIMARY KEY,
    idususupervisor		INT 				NOT NULL, -- Encargado de agregar este dato
    idjornada			INT					NOT NULL, -- Día, trabajador
    idtarea				INT					NOT NULL, -- Operación realizada
    cantidad			SMALLINT			NOT NULL,
    preciotarea			DECIMAL(5,2)		NOT NULL,
    idusucaja			INT					NULL, -- Encargado de realizar el pago
    pagado				CHAR(1)				NOT NULL DEFAULT 'N',
    create_at			DATETIME			NOT NULL DEFAULT NOW(),
    update_at			DATETIME			NULL,
    CONSTRAINT fk_idususupervisor_dta FOREIGN KEY (idususupervisor) REFERENCES jornadas (idjornada),
    CONSTRAINT fk_idjornada_dta FOREIGN KEY (idjornada) REFERENCES jornadas (idjornada),
    CONSTRAINT fk_idtarea_dta FOREIGN KEY (idtarea) REFERENCES tareas (idtarea),
    CONSTRAINT fk_idusucaja_dta FOREIGN KEY (idusucaja) REFERENCES usuarios (idusuario),
    CONSTRAINT ck_pagado_dta CHECK (pagado IN ('S', 'N'))
)ENGINE = INNODB;

select * from personas;

CREATE TABLE modulos
(
	idmodulo		INT AUTO_INCREMENT PRIMARY KEY,
    modulo			VARCHAR(30)			NOT NULL,
    create_at		DATETIME			NOT NULL DEFAULT NOW(),
    CONSTRAINT uk_modulo_mod UNIQUE (modulo)
) ENGINE = INNODB;

INSERT INTO modulos (modulo) VALUES
	('jornadas'), -- 1
    ('pagos'), -- 2
    ('produccion'), -- 3
    ('reportes'), -- 4
    ('usuarios'), -- 5
    ('tareas'); -- 6
    
CREATE TABLE vistas
(
	idvista			INT AUTO_INCREMENT PRIMARY KEY,
    idmodulo		INT					NULL,
    ruta			VARCHAR(50)			NOT NULL,
    sidebaroption	CHAR(1)				NOT NULL,
    texto			VARCHAR(20)			NULL,
    icono			VARCHAR(20)			NULL,
    CONSTRAINT fk_idmodulo_vis FOREIGN KEY (idmodulo) REFERENCES modulos (idmodulo),
    CONSTRAINT uk_ruta_vis	UNIQUE(ruta),
    CONSTRAINT ck_sidebaroption_vis CHECK (sidebaroption IN ('S', 'N'))
) ENGINE = INNODB;

-- HOME
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(NULL, 'home', 'S', 'Inicio', 'fa-solid fa-wallet');
-- JORNADAS
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(1, 'listar-jornada', 'S', 'Jornadas', 'fa-solid fa-wallet');
-- PAGOS
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(2, 'listar-pago', 'S', 'Pagos', 'fa-solid fa-wallet');
-- PRODUCCION
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(3, 'listar-produccion', 'S', 'Producción', 'fa-solid fa-wallet');
-- REPORTES
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(4, 'reporte-diario', 'S', 'Reportes', 'fa-solid fa-wallet');
-- USUARIOS
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(5, 'listar-usuario', 'S', 'Usuarios', 'fa-solid fa-wallet'),
    (5, 'registrar-usuario', 'N', NULL, NULL),
    (5, 'actualizar-usuario', 'N',  NULL, NULL);
-- TAREAS
INSERT INTO vistas (idmodulo, ruta, sidebaroption, texto, icono) VALUES
	(6, 'listar-tarea', 'S', 'Tareas', 'fa-solid fa-wallet'),
    (6, 'registrar-tarea', 'N', NULL, NULL);

CREATE TABLE perfiles
(
	idperfil			INT AUTO_INCREMENT PRIMARY KEY,
    perfil				VARCHAR(30) NOT NULL,
    nombrecorto			CHAR(3)		NOT NULL,
    create_at			DATETIME 	NOT NULL DEFAULT NOW(),
    CONSTRAINT uk_perfil_per UNIQUE (perfil),
    CONSTRAINT uk_nombrecorto_per UNIQUE (nombrecorto)
) ENGINE = INNODB;

INSERT INTO perfiles (perfil, nombrecorto) VALUES
	('Administrador', 'ADM'), 
	('Supervisor', 'SUP'), 
	('Colaborador', 'COL');

CREATE TABLE permisos
(
	idpermiso			INT AUTO_INCREMENT PRIMARY KEY,
    idperfil			INT 				NOT NULL,
    idvista				INT 				NOT NULL,
    create_at			DATETIME			NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_idperfil_per FOREIGN KEY (idperfil) REFERENCES perfiles (idperfil),
    CONSTRAINT fk_idvisita_per FOREIGN KEY (idvista) REFERENCES vistas (idvista),
    CONSTRAINT uk_vista_per UNIQUE (idperfil, idvista)
)ENGINE = INNODB;

SELECT * FROM VISTAS;
SELECT * FROM PERMISOS;

-- Administrador
INSERT INTO permisos (idperfil, idvista) VALUES
	(1, 1),
    (1, 2),
    (1, 3),
    (1, 4),
    (1, 5),
    (1, 6),
    (1, 7),
    (1, 8),
    (1, 9),
    (1, 10);
-- Supervisor
INSERT INTO permisos (idperfil, idvista) VALUES
	(2, 1),
    (2, 4),
    (2, 5),
    (2, 9),
    (2, 3);
-- Colaborador
INSERT INTO permisos (idperfil, idvista) VALUES
	(3, 1),
	(3, 9);

    -- procedure al que yo le mande el codigo de perfil
    -- procedure que reciba el codigo y devuelve el tdetalle cn todo el acceso que yo tengo permitido ingresar
    -- tengo que saber cual es el modulo y cual es la vista
    -- procedure que reciba una foranea de perfil