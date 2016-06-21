# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Exporta todos los registros en la base de datos de la tabla area_de_identificacion
SELECT 'codigo_de_referencia', 'titulo_propio', 'titulo_paralelo', 'titulo_atribuido', 'titulo_de_serie', 'numero_de_programa', 'pais', 'fecha', 'duracion', 'investigacion', 'realizacion', 'direccion', 'guion', 'adaptacion', 'idea_original', 'fotografia', 'fotografia_fija', 'edicion', 'sonido_grabacion', 'sonido_edicion', 'musica_original', 'musicalizacion', 'voces', 'actores', 'animacion', 'otros_colaboradores'
	UNION
SELECT * 
	FROM area_de_identificacion INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_identificacion.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_contexto
SELECT 'codigo_de_referencia', 'entidad_productora', 'productor', 'distribuidora', 'historia_institucional', 'resena_biografica', 'forma_de_ingreso', 'fecha_de_ingreso'
	UNION
SELECT * 
	FROM area_de_contexto INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_contexto.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_contenido_y_estructura
SELECT 'codigo_de_referencia', 'sinopsis', 'descriptor_onomastico', 'descriptor_toponimico', 'descriptor_cronologico', 'tipo_de_produccion', 'genero', 'fuentes', 'recursos', 'versiones', 'formato_original', 'material_extra'
	UNION
SELECT * 
	FROM area_de_contenido_y_estructura INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_contenido_y_estructura.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_condiciones_de_acceso
SELECT 'codigo_de_referencia', 'condiciones_de_acceso', 'existencia_y_localizacion_de_originales', 'idioma_original', 'doblajes_disponibles', 'subtitulajes', 'soporte', 'numero_copias', 'descripcion_fisica', 'color', 'audio', 'sistema_de_grabacion', 'region_dvd', 'requisitos_tecnicos'
	UNION
SELECT * 
	FROM area_de_condiciones_de_acceso INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_condiciones_de_acceso.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_documentacion_asociada
SELECT 'codigo_de_referencia', 'existencia_y_localizacion_de_copias', 'unidades_de_descripcion_relacionadas', 'documentos_asociados'
	UNION
SELECT * 
	FROM area_de_documentacion_asociada INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_documentacion_asociada.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_notas
SELECT 'codigo_de_referencia', 'area_de_notas'
	UNION
SELECT * 
	FROM area_de_notas INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_notas.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla area_de_descripcion
SELECT 'codigo_de_referencia', 'notas_del_archivero', 'datos_del_archivero', 'reglas_o_normas', 'fecha_de_descripcion'
	UNION
SELECT * 
	FROM area_de_descripcion INTO OUTFILE '/var/www/lais-audiovisual/content/backup/area_de_descripcion.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exporta todos los registros en la base de datos de la tabla informacion_adicional
SELECT 'codigo_de_referencia', 'imagen', 'url', 'fecha_de_modificacion'
	UNION
SELECT * 
	FROM informacion_adicional INTO OUTFILE '/var/www/lais-audiovisual/content/backup/informacion_adicional.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';

# Exportar todos los registros en la base de datos de la tabla registro_actividades
SELECT 'codigo_de_referencia', 'titulo_propio', 'fecha', 'usuario', 'accion'
	UNION
SELECT *
	FROM registro_actividades INTO OUTFILE '/var/www/lais-audiovisual/content/backup/registro_actividades.csv'
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n';