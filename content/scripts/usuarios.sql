# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

#Insertar usuarios registrados a la tabla 'usuarios'
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Rodrigo",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Sergio",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Lourdes",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Carlos",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Felipe",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Penélope",0);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Verónica",0);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Elisa",0);
# Clave de los privilegios:
# 0 = None
# 1 = Add
# 2 = Add, edit
# 3 = Add, edit, delete