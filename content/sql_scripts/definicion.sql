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
	titulo_propio VARCHAR(120) DEFAULT NULL,
	titulo_paralelo VARCHAR(120) DEFAULT NULL,
	titulo_atribuido VARCHAR(120) DEFAULT NULL,
	titulo_de_serie VARCHAR(70) DEFAULT NULL,
	numero_de_programa VARCHAR(15) DEFAULT "NN",
	pais VARCHAR(30) DEFAULT NULL, # Alternativa con ISO Standard: http://en.wikipedia.org/wiki/ISO_3166-2
	fecha VARCHAR(12) DEFAULT NULL, # La fecha puede ser un periodo: "[1980-1990]"
	duracion TIME DEFAULT NULL,

	investigacion VARCHAR(160) DEFAULT NULL,
	realizacion VARCHAR(160) DEFAULT NULL,
	direccion VARCHAR(160) DEFAULT NULL,
	guion VARCHAR(160) DEFAULT NULL,
	adaptacion VARCHAR(160) DEFAULT NULL,
	idea_original VARCHAR(160) DEFAULT NULL,
	fotografia VARCHAR(160) DEFAULT NULL,
	fotografia_fija VARCHAR(160) DEFAULT NULL,
	edicion VARCHAR(160) DEFAULT NULL,
	# Sonido
	sonido_grabacion VARCHAR(160) DEFAULT NULL,
	sonido_edicion VARCHAR(160) DEFAULT NULL, # columna 'edicion' ya existe
	# Musica
	musica_original VARCHAR(160) DEFAULT NULL,
	musicalizacion VARCHAR(160) DEFAULT NULL,
	voces VARCHAR(160) DEFAULT NULL,
	actores VARCHAR(160) DEFAULT NULL,
	animacion VARCHAR(160) DEFAULT NULL,
	otros_colaboradores VARCHAR(160) DEFAULT NULL

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
	entidad_productora VARCHAR(250) DEFAULT NULL,
	productor VARCHAR(160) DEFAULT NULL,
	distribuidora VARCHAR(160) DEFAULT NULL,
	historia_institucional TEXT,
	resena_biografica TEXT,
	forma_de_ingreso VARCHAR(35) DEFAULT NULL,
	fecha_de_ingreso VARCHAR(12) DEFAULT NULL
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_contexto ADD CONSTRAINT codigoIdentificacionFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE
	ON UPDATE CASCADE;

# AREA DE CONTENIDO Y ESTRUCTURA
CREATE TABLE IF NOT EXISTS area_de_contenido_y_estructura(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	sinopsis TEXT DEFAULT NULL,
	descriptor_onomastico TEXT DEFAULT NULL,
	descriptor_toponimico TEXT DEFAULT NULL,
	descriptor_cronologico TEXT DEFAULT NULL,
	tipo_de_produccion VARCHAR(31) DEFAULT NULL,
	genero VARCHAR(30) DEFAULT NULL,
	fuentes VARCHAR(170) DEFAULT NULL,
	recursos VARCHAR(170) DEFAULT NULL,
	versiones VARCHAR(45) DEFAULT NULL,
	formato_original VARCHAR(25) DEFAULT NULL,
	material_extra VARCHAR(30) DEFAULT NULL
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_contenido_y_estructura ADD CONSTRAINT codigoContEstructFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE CONDICIONES DE ACCESO
CREATE TABLE IF NOT EXISTS area_de_condiciones_de_acceso(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	condiciones_de_acceso VARCHAR(37) DEFAULT NULL,
	existencia_y_localizacion_de_originales TEXT DEFAULT NULL,
	idioma_original VARCHAR(40) DEFAULT NULL, # VARCHAR(50) ?
	doblajes_disponibles VARCHAR(40) DEFAULT NULL,
	subtitulajes VARCHAR(40) DEFAULT NULL, # VARCHAR(50) ?
	soporte VARCHAR(25) DEFAULT NULL, # VARCHAR(50) ?
	numero_copias VARCHAR(20) DEFAULT NULL, # VARCHAR(50) ?
	descripcion_fisica VARCHAR(60) DEFAULT NULL, # VARCHAR(50) ?
	color VARCHAR(80) DEFAULT NULL, # VARCHAR(50) ?
	audio VARCHAR(30) DEFAULT NULL,
	sistema_de_grabacion VARCHAR(10) DEFAULT NULL,
	region_dvd VARCHAR(20) DEFAULT NULL,
	requisitos_tecnicos VARCHAR(40) DEFAULT NULL
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_condiciones_de_acceso ADD CONSTRAINT codigoCondAccesoFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE DOCUMENTACION ASOCIADA
CREATE TABLE IF NOT EXISTS area_de_documentacion_asociada(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	existencia_y_localizacion_de_copias TEXT DEFAULT NULL, # VARCHAR ?
	unidades_de_descripcion_relacionadas TEXT DEFAULT NULL, # VARCHAR ?
	documentos_asociados TEXT DEFAULT NULL # VARCHAR ?
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_documentacion_asociada ADD CONSTRAINT codigoDocAsociadaFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;

# AREA DE NOTAS
CREATE TABLE IF NOT EXISTS area_de_notas(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	area_de_notas TEXT DEFAULT NULL
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_notas ADD CONSTRAINT codigoNotasFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE
	ON UPDATE CASCADE;

# AREA DE DESCRIPCION
CREATE TABLE IF NOT EXISTS area_de_descripcion(
	codigo_de_referencia VARCHAR(20) NOT NULL,
	notas_del_archivero VARCHAR(75) DEFAULT NULL,
	datos_del_archivero VARCHAR(60) DEFAULT NULL,
	reglas_o_normas VARCHAR(31) DEFAULT NULL,
	fecha_de_descripcion VARCHAR(12) DEFAULT NULL # DATE DATA TYPE ?
);
# Agregar llave foranea (FK) para el codigo_de_referencia que ya existe en la tabla area_de_identificacion
ALTER TABLE area_de_descripcion ADD CONSTRAINT codigoDescripcionFK
	FOREIGN KEY(codigo_de_referencia) REFERENCES area_de_identificacion(codigo_de_referencia)
	ON DELETE CASCADE	
	ON UPDATE CASCADE;
