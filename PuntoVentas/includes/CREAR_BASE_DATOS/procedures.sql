use punto_ventas;


drop procedure if exists pVerificar_user;
DELIMITER $$
CREATE PROCEDURE pVerificar_user(in  vUser_name varchar(25) , in vUser_pwd varchar(50))
BEGIN
 

select * from users where user_name = vUser_name and user_pwd = md5(vUser_pwd) and user_activated <> 0;


END$$
DELIMITER ;

drop procedure if exists pConsulta_familias;
DELIMITER $$
CREATE PROCEDURE pConsulta_familias()
BEGIN
 

SELECT * FROM familias WHERE borrado=0 ORDER BY nombre ASC;


END$$
DELIMITER ;


drop procedure if exists pConsulta_proveedores;
DELIMITER $$
CREATE PROCEDURE pConsulta_proveedores()
BEGIN
 

SELECT codproveedor,nombre,nif FROM proveedores WHERE borrado=0 ORDER BY nombre ASC;


END$$
DELIMITER ;


drop procedure if exists pConsulta_ubicaciones;
DELIMITER $$
CREATE PROCEDURE pConsulta_ubicaciones()
BEGIN
 

SELECT codubicacion,nombre FROM ubicaciones WHERE borrado=0 ORDER BY nombre ASC;


END$$
DELIMITER ;


drop procedure if exists pConsulta_codFactura;
DELIMITER $$
CREATE PROCEDURE pConsulta_codFactura()
BEGIN
 

INSERT INTO facturastmp (codfactura,fecha) VALUE (null,now());
select codfactura from facturastmp where codfactura = (select last_insert_id());

END$$
DELIMITER ;


select * from users;


INSERT INTO facturastmp (codfactura,fecha) VALUE (null,now());
select * from facturastmp order by 1 desc;

select * from parametros;

SELECT * FROM factulinea;