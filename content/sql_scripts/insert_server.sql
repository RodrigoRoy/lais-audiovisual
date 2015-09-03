# Indicar con que base de datos trabajar
USE Coleccion_Archivistica;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

#################### DECADA 4 (1920) ####################

# Cargar datos desde archivo csv para la tabla area_de_identificacion
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

# Cargar datos desde archivo csv para la tabla area_de_contexto
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

# Cargar datos desde archivo csv para la tabla area_de_contenido_y_estructura
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero, fuentes, recursos, versiones, formato_original, material_extra);

# Cargar datos desde archivo csv para la tabla 'area_de_condiciones_de_acceso'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

# Cargar datos desde archivo csv para la tabla 'area_de_documentacion_asociada'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

# Cargar datos desde archivo csv para la tabla 'area_de_notas'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

# Cargar datos desde archivo csv para la tabla 'area_de_descripcion'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

# Cargar datos desde archivo csv para la tabla 'informacion_adicional'
LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Portadas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, url, imagen);

#################### DECADA 5 (1930) ####################

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Portadas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, url, imagen);

#################### DECADA 6 (1940) ####################

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Portadas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, url, imagen);

#################### DECADA 7 (1950) ####################

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Portadas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, url, imagen);