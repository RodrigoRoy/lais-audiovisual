# Definiciones para crear base de datos de LAIS con MySQL
# Rodrigo Rivera (15.02.19)

# Crear base de datos
CREATE DATABASE IF NOT EXISTS Coleccion_Archivistica CHARACTER SET UTF8;

# Mostrar todas las bases de datos existentes
#SHOW DATABASES;

# Indicar con que base de datos trabajar
USE Coleccion_Archivistica;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Otorga privilegios a las cuentas de usuario MySQL
GRANT ALL ON Coleccion_Archivistica.* TO lais@localhost IDENTIFIED BY 'audiovisual';

# Eliminar una base de datos
#DROP DATABASE IF EXISTS Coleccion_Archivistica;

# AREA DE IDENTIFICACION
# Longitud maxima para los nombre: 70 (fuente: UK Government Data Standards Catalogue)
CREATE TABLE IF NOT EXISTS area_de_identificacion(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	titulo_propio VARCHAR(120) DEFAULT '',
	titulo_paralelo VARCHAR(120) DEFAULT '',
	titulo_atribuido VARCHAR(120) DEFAULT '',
	titulo_de_serie VARCHAR(70) DEFAULT '',
	numero_de_programa VARCHAR(15) DEFAULT "NN",
	pais VARCHAR(30) DEFAULT '', # Alternativa con ISO Standard: http://en.wikipedia.org/wiki/ISO_3166-2
	fecha VARCHAR(12) DEFAULT '', # La fecha puede ser un periodo: "[1980-1990]"
	duracion TIME,

	investigacion VARCHAR(160) DEFAULT '',
	realizacion VARCHAR(160) DEFAULT '',
	direccion VARCHAR(160) DEFAULT '',
	guion VARCHAR(160) DEFAULT '',
	adaptacion VARCHAR(160) DEFAULT '',
	idea_original VARCHAR(160) DEFAULT '',
	fotografia VARCHAR(160) DEFAULT '',
	fotografia_fija VARCHAR(160) DEFAULT '',
	edicion VARCHAR(160) DEFAULT '',
	# Sonido
	sonido_grabacion VARCHAR(160) DEFAULT '',
	sonido_edicion VARCHAR(160) DEFAULT '', # columna 'edicion' ya existe
	# Musica
	musica_original VARCHAR(160) DEFAULT '',
	musicalizacion VARCHAR(160) DEFAULT '',
	voces VARCHAR(160) DEFAULT '',
	actores VARCHAR(160) DEFAULT '',
	animacion VARCHAR(160) DEFAULT '',
	otros_colaboradores VARCHAR(160) DEFAULT ''

	#PRIMARY KEY (codigo_de_referencia) # Las restricciones se agregaran despues de crear la tabla
);
# Agregar la llave primaria de la tabla codigo_de_referencia
#ALTER TABLE area_de_identificacion ADD PRIMARY KEY (codigo_de_referencia);
# Agregar restriccion (para su posible manipulacion) que agrega la llave primaria (PK) en la tabla codigo_de_referencia
ALTER TABLE area_de_identificacion ADD CONSTRAINT codigoUnicoPK 
	PRIMARY KEY(codigo_de_referencia);

# AREA DE CONTEXTO
CREATE TABLE IF NOT EXISTS area_de_contexto(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	entidad_productora VARCHAR(250) DEFAULT '',
	productor VARCHAR(160) DEFAULT '',
	distribuidora VARCHAR(160) DEFAULT '',
	historia_institucional TEXT,
	resena_biografica TEXT,
	forma_de_ingreso VARCHAR(35) DEFAULT '',
	fecha_de_ingreso VARCHAR(12) DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_contexto ADD CONSTRAINT codigoIdentificacionFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE
	ON UPDATE CASCADE;

# AREA DE CONTENIDO Y ESTRUCTURA
CREATE TABLE IF NOT EXISTS area_de_contenido_y_estructura(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	sinopsis TEXT DEFAULT '',
	descriptor_onomastico TEXT DEFAULT '',
	descriptor_toponimico TEXT DEFAULT '',
	descriptor_cronologico TEXT DEFAULT '',
	tipo_de_produccion VARCHAR(31) DEFAULT '',
	genero VARCHAR(30) DEFAULT '',
	fuentes VARCHAR(170) DEFAULT '',
	recursos VARCHAR(170) DEFAULT '',
	versiones VARCHAR(45) DEFAULT '',
	formato_original VARCHAR(25) DEFAULT '',
	material_extra VARCHAR(30) DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_contenido_y_estructura ADD CONSTRAINT codigoContEstructFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE CONDICIONES DE ACCESO
CREATE TABLE IF NOT EXISTS area_de_condiciones_de_acceso(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	condiciones_de_acceso VARCHAR(37) DEFAULT '',
	existencia_y_localizacion_de_originales TEXT DEFAULT '',
	idioma_original VARCHAR(40) DEFAULT '',
	doblajes_disponibles VARCHAR(40) DEFAULT '',
	subtitulajes VARCHAR(40) DEFAULT '',
	soporte VARCHAR(25) DEFAULT '',
	numero_copias VARCHAR(20) DEFAULT '',
	descripcion_fisica VARCHAR(60) DEFAULT '',
	color VARCHAR(80) DEFAULT '',
	audio VARCHAR(30) DEFAULT '',
	sistema_de_grabacion VARCHAR(10) DEFAULT '',
	region_dvd VARCHAR(20) DEFAULT '',
	requisitos_tecnicos VARCHAR(40) DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_condiciones_de_acceso ADD CONSTRAINT codigoCondAccesoFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE DOCUMENTACION ASOCIADA
CREATE TABLE IF NOT EXISTS area_de_documentacion_asociada(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	existencia_y_localizacion_de_copias TEXT DEFAULT '',
	unidades_de_descripcion_relacionadas TEXT DEFAULT '',
	documentos_asociados TEXT DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_documentacion_asociada ADD CONSTRAINT codigoDocAsociadaFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE NOTAS
CREATE TABLE IF NOT EXISTS area_de_notas(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	area_de_notas TEXT DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_notas ADD CONSTRAINT codigoNotasFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE
	ON UPDATE CASCADE;

# AREA DE DESCRIPCION
CREATE TABLE IF NOT EXISTS area_de_descripcion(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	notas_del_archivero VARCHAR(75) DEFAULT '',
	datos_del_archivero VARCHAR(60) DEFAULT '',
	reglas_o_normas VARCHAR(31) DEFAULT '',
	fecha_de_descripcion DATE
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_descripcion ADD CONSTRAINT codigoDescripcionFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# INFORMACION ADICIONAL
CREATE TABLE IF NOT EXISTS informacion_adicional(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	imagen VARCHAR(255) DEFAULT '',
	url VARCHAR(255) DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE informacion_adicional ADD CONSTRAINT codigoInfoAdicionalFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# Crear tabla para usuarios registrados
CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Password` varchar(255) DEFAULT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Privilegio` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Username` (`Username`)
);

#Insertar usuarios registrados a la tabla 'usuarios'
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Sergio",0);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Carlos",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Felipe",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Lourdes",3);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Fulanito1",2);
INSERT INTO usuarios (Password,Username,Privilegio) values("lais","Usuario1",1);