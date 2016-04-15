# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Cargar datos desde archivo csv para la tabla area_de_identificacion
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla area_de_contexto
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla area_de_contenido_y_estructura
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_contenido_y_estructura.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'area_de_condiciones_de_acceso'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_condiciones_de_acceso.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'area_de_documentacion_asociada'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_documentacion_asociada.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'area_de_notas'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'area_de_descripcion'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/area_de_descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'informacion_adicional'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/informacion_adicional.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;

# Cargar datos desde archivo csv para la tabla 'registro_actividades'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/backup/registro_actividades.csv'
	INTO TABLE registro_actividades
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 1 LINES;