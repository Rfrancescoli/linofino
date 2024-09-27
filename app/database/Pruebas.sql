USE linofino;

CALL spu_personas_registrar(@idpersona, 'Contreras Anicama', 'Luis', '987654321', '87654321', '');
SELECT @idpersona AS 'idpersona';


SELECT * FROM personas;