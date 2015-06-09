CREATE DATABASE IF NOT EXISTS CRUD CHARACTER SET UTF8;
USE CRUD;
SET NAMES utf8;
GRANT ALL ON CRUD.* TO lais@localhost IDENTIFIED BY 'audiovisual';

CREATE TABLE IF NOT EXISTS persona(
	nombre_usuario VARCHAR(40),
	correo_electronico VARCHAR(120)
);

INSERT INTO persona() VALUES('Rodrigo', 'roy@example.com');
INSERT INTO persona() VALUES('Ana', 'ana@example.com');
INSERT INTO persona() VALUES('Carlos', 'carlos@example.com');

SELECT * FROM persona;
#SELECT * FROM persona WHERE nombre_usuario = 'Name';
#DELETE FROM persona WHERE nombre_usuario='Name';
#UPDATE persona SET nombre_usuario='NewName', correo_electronico='new@mail.com' WHERE nombre_usuario='Name';