# Agregar valores a la tabla area_de_identificacion
# PRUEBAS! Los datos reales se deben agregar desde archivos 'csv'
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-1','Chelovek kinoapparatom','El hombre de la cámara',DEFAULT,DEFAULT,DEFAULT,'Unión Soviética','1929',6605,DEFAULT,'Dziga Vertov',DEFAULT,'Dziga Vertov',DEFAULT,DEFAULT,'Mikhail Kaufman',DEFAULT,'Elizaveta Svilova',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-2','Drifters',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Reino Unido','1929',5000,DEFAULT,'John Grierson',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Basil Emmott',DEFAULT,'John Grierson',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-3','Kino-Glaz','Kino-Eye',DEFAULT,DEFAULT,DEFAULT,'Unión Soviética','1924',9800,DEFAULT,'Dziga Vertov',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Mikhail Kaufman',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-4','Nanook of the north','Nanouk l´esquimau (Francia) / Nanook el esquimal (España)',DEFAULT,DEFAULT,DEFAULT,'Estados Unidos','1922',7816,DEFAULT,'Robert J. Flaherty',DEFAULT,'Robert J. Flaherty',DEFAULT,DEFAULT,'Robert J. Flaherty',DEFAULT,'Charles Gelb / Robert J. Flaherty',DEFAULT,DEFAULT,'Timothy Brock',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Ayudante de dirección: Thierry Mallet');
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-5','"Nogent, eldorado du diamanche"','Nogent',DEFAULT,DEFAULT,DEFAULT,'Francia','1929',1700,DEFAULT,'Marcel Carné',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Marcel Carné',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Bernard Gerard (música añadida en 1968)',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Michel Sanvoisin');
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-6','Regen','Inglés: Rain. Francés: La Pluie',DEFAULT,DEFAULT,DEFAULT,'Holanda','1929',12,DEFAULT,'"Joris Ivens, Mannus H. K. Franken"',DEFAULT,'"Joris Ivens, Mannus H. K. Franken"',DEFAULT,DEFAULT,'Joris Ivens',DEFAULT,'Joris Ivens',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);

#################### DECADA 4 (1920) ####################

# Cargar datos desde archivo csv para la tabla area_de_identificacion
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\r\n' # Debido a la manipulación con Python3
	IGNORE 3 LINES;

# Cargar datos desde archivo csv para la tabla area_de_contexto
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

# Cargar datos desde archivo csv para la tabla area_de_contenido_y_estructura
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero, fuentes, recursos, versiones, formato_original, material_extra);

# Cargar datos desde archivo csv para la tabla 'area_de_condiciones_de_acceso'
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

# Cargar datos desde archivo csv para la tabla 'area_de_documentacion_asociada'
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

# Cargar datos desde archivo csv para la tabla 'area_de_notas'
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

# Cargar datos desde archivo csv para la tabla 'area_de_descripcion'
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

# Agregar los códigos de referencia desde el archivo de Notas (el resto se inicializa vacio)
LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década4\ (1920)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 5 (1930) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\r\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década5\ (1930)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 6 (1940) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\r\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década6\ (1940)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 7 (1950) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\r\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década7\ (1950)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 8 (1960) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década8\ (1960)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 9 (1970) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década9\ (1970)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 10 (1980) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década10\ (1980)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 11 (1990) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década11\ (1990)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);

#################### DECADA 12 (2000) ####################

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Identificacion.csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

LOAD DATA INFILE '/var/www/html/lais-audiovisual/content/csv/Fichas\ década12\ (2000)\ Notas.csv'
	INTO TABLE informacion_adicional
	CHARACTER SET UTF8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, @notasIgnoradas);