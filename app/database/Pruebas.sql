USE linofino;

CALL spu_personas_registrar(@idpersona, 'Contreras Anicama', 'Luis', '987654321', '87654321', '');
SELECT @idpersona AS 'idpersona';

CALL spu_usuarios_registrar(@idusuario, 1, 'ruben', '123456789', 'ADM');
SELECT @idusuario AS 'idusuario';

CALL spu_usuarios_listar();

SELECT * FROM personas;
SELECT * FROM usuarios;


SET SQL_SAFE_UPDATES = 0;

DELETE FROM usuarios;
DELETE FROM personas;
DELETE FROM usuarios WHERE idusuario IS NOT NULL;
DELETE FROM personas WHERE idpersona IS NOT NULL;

ALTER TABLE usuarios AUTO_INCREMENT 1;
ALTER TABLE personas AUTO_INCREMENT 1;