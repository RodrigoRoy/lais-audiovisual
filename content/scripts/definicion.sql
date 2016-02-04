# Definiciones para crear base de datos de LAIS con MySQL
# Rodrigo Rivera (15.02.19)

# Borrar toda la base de datos (para iniciar desde cero)
DROP DATABASE IF EXISTS Audiovisuales;

# Crear base de datos
CREATE DATABASE IF NOT EXISTS Audiovisuales CHARACTER SET UTF8;

# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Otorga todos los privilegios al usuario "lais" (en "localhost") con pass "audiovisual" en la base de datos
GRANT ALL ON Audiovisuales.* TO lais@localhost IDENTIFIED BY 'audiovisual';

# AREA DE IDENTIFICACION
CREATE TABLE IF NOT EXISTS area_de_identificacion(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	titulo_propio VARCHAR(150) DEFAULT '',
	titulo_paralelo VARCHAR(150) DEFAULT '',
	titulo_atribuido VARCHAR(150) DEFAULT '',
	titulo_de_serie VARCHAR(90) DEFAULT '',
	numero_de_programa VARCHAR(75) DEFAULT '',
	pais VARCHAR(50) DEFAULT '', # Alternativa con ISO Standard: http://en.wikipedia.org/wiki/ISO_3166-2
	fecha VARCHAR(12) DEFAULT '', # La fecha puede ser un periodo: "[1980-1990]"
	duracion TIME,

	investigacion VARCHAR(500) DEFAULT '',
	realizacion VARCHAR(500) DEFAULT '',
	direccion VARCHAR(500) DEFAULT '',
	guion VARCHAR(500) DEFAULT '',
	adaptacion VARCHAR(500) DEFAULT '',
	idea_original VARCHAR(500) DEFAULT '',
	fotografia VARCHAR(500) DEFAULT '',
	fotografia_fija VARCHAR(500) DEFAULT '',
	edicion VARCHAR(500) DEFAULT '',
	# Sonido
	sonido_grabacion VARCHAR(500) DEFAULT '',
	sonido_edicion VARCHAR(500) DEFAULT '', # columna 'edicion' ya existe
	# Musica
	musica_original VARCHAR(500) DEFAULT '',
	musicalizacion VARCHAR(500) DEFAULT '',
	voces VARCHAR(500) DEFAULT '',
	actores VARCHAR(500) DEFAULT '',
	animacion VARCHAR(500) DEFAULT '',
	otros_colaboradores VARCHAR(500) DEFAULT ''

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
	entidad_productora VARCHAR(500) DEFAULT '',
	productor VARCHAR(160) DEFAULT '',
	distribuidora VARCHAR(160) DEFAULT '',
	historia_institucional TEXT,
	resena_biografica TEXT,
	forma_de_ingreso VARCHAR(50) DEFAULT '',
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
	sinopsis TEXT,
	descriptor_onomastico TEXT,
	descriptor_toponimico TEXT,
	descriptor_cronologico TEXT,
	tipo_de_produccion VARCHAR(31) DEFAULT '',
	genero VARCHAR(30) DEFAULT '',
	fuentes VARCHAR(350) DEFAULT '', # si se ocupan todos los tipos de fuentes
	recursos VARCHAR(150) DEFAULT '', # si se ocupan todos los tipos de recursos
	versiones VARCHAR(150) DEFAULT '',
	formato_original VARCHAR(45) DEFAULT '',
	material_extra VARCHAR(300) DEFAULT ''
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
	existencia_y_localizacion_de_originales TEXT,
	idioma_original VARCHAR(80) DEFAULT '',
	doblajes_disponibles VARCHAR(80) DEFAULT '',
	subtitulajes VARCHAR(80) DEFAULT '',
	soporte VARCHAR(25) DEFAULT '',
	numero_copias VARCHAR(40) DEFAULT '',
	descripcion_fisica VARCHAR(60) DEFAULT '',
	color VARCHAR(90) DEFAULT '',
	audio VARCHAR(50) DEFAULT '',
	sistema_de_grabacion VARCHAR(20) DEFAULT '',
	region_dvd VARCHAR(20) DEFAULT '',
	requisitos_tecnicos VARCHAR(60) DEFAULT ''
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_condiciones_de_acceso ADD CONSTRAINT codigoCondAccesoFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE DOCUMENTACION ASOCIADA
CREATE TABLE IF NOT EXISTS area_de_documentacion_asociada(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	existencia_y_localizacion_de_copias TEXT,
	unidades_de_descripcion_relacionadas TEXT,
	documentos_asociados TEXT
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_documentacion_asociada ADD CONSTRAINT codigoDocAsociadaFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE NOTAS
CREATE TABLE IF NOT EXISTS area_de_notas(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	area_de_notas TEXT
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_notas ADD CONSTRAINT codigoNotasFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE
	ON UPDATE CASCADE;

# AREA DE DESCRIPCION
CREATE TABLE IF NOT EXISTS area_de_descripcion(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	notas_del_archivero TEXT,
	datos_del_archivero VARCHAR(120) DEFAULT '',
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
CREATE TABLE IF NOT EXISTS usuarios(
  Id int(11) NOT NULL AUTO_INCREMENT,
  Password varchar(255) NOT NULL,
  Username varchar(255) NOT NULL UNIQUE,
  Privilegio int DEFAULT NULL,
  
  PRIMARY KEY(Id)
);