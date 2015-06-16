# Crear base de datos
CREATE DATABASE IF NOT EXISTS Usuarios CHARACTER SET UTF8;

# Mostrar todas las bases de datos existentes
#SHOW DATABASES;

# Eliminar una base de datos
#DROP DATABASE IF EXISTS Usuarios;


# Indicar con que base de datos trabajar
USE Usuarios;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Otorga privilegios a las cuentas de usuario MySQL
GRANT ALL ON Usuarios.* TO lais@localhost IDENTIFIED BY 'audiovisual';

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Password` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Privilegio` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Privilegio` (`Privilegio`)
);
#Insertar a la base de datos
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Sergio",0);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Carlos",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Felipe",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Lourdes",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Fulanito1",2);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Usuario1",1);

#Borrar la tabla usuarios
#Drop table usuarios;