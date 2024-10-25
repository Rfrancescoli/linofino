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

CREATE TABLE roles (
    idroles				INT AUTO_INCREMENT PRIMARY KEY,
    nombre 				VARCHAR(10) NOT NULL UNIQUE  -- ADM, SUP, COL
) ENGINE = INNODB;

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

CREATE TABLE accesos (
    idacceso 			INT AUTO_INCREMENT PRIMARY KEY,
    idroles 			INT NOT NULL,
    modulo 				VARCHAR(50) NULL,
    ruta 				VARCHAR(100) NOT NULL,
    visible 			BOOLEAN NOT NULL,
    texto 				VARCHAR(100) NULL,
    icono 				VARCHAR(100) NULL,
    CONSTRAINT fk_idrole_acceso FOREIGN KEY (idroles) REFERENCES roles (idroles)
) ENGINE = INNODB;