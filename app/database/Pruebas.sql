USE linofino;

CALL spu_personas_registrar(@idpersona, 'Contreras Anicama', 'Luis', '987654321', '87654321', '');
SELECT @idpersona AS 'idpersona';

CALL spu_usuarios_registrar(@idusuario, 1, 'ruben', '123456789', 'ADM');
SELECT @idusuario AS 'idusuario';

CALL spu_usuarios_listar();

SELECT * FROM personas;
SELECT * FROM usuarios;