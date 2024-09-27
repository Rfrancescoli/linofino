USE linofino;

DROP PROCEDURE IF EXISTS `spu_usuarios_registrar`;
DELIMITER // 
CREATE PROCEDURE `spu_usuarios_registrar`
(
	OUT _idusuario		INT,
    IN _idpersona		INT,
	IN _nomusuario		VARCHAR(30),
    IN _claveacceso		VARCHAR(70),
    IN _perfil			CHAR(3)
)
BEGIN
	DECLARE existe_error INT DEFAULT 0;
    
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
		BEGIN
        SET existe_error = 1;
		END;
        
    INSERT INTO usuarios (idpersona, nomusuario, claveacceso, perfil) 
    VALUES (_idpersona, _nomusuario, _claveacceso, _perfil);
    
    IF existe_error = 1 THEN
		SET _idusuario = -1;
	ELSE
		SET _idusuario = LAST_INSERT_ID();
    END IF;
END //


DROP PROCEDURE IF EXISTS `spu_usuarios_listar`;
DELIMITER //
CREATE PROCEDURE `spu_usuarios_listar`()
BEGIN
	SELECT
		US.idusuario,
        PE.apellidos, PE.nombres, PE.telefono, PE.dni, PE.direccion,
        US.nomusuario, US.perfil
		FROM usuarios US
		INNER JOIN personas PE ON PE.idpersona = US.idpersona
		ORDER BY US.idusuario DESC;
END //