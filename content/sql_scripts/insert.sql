# Agregar valores a la tabla area_de_identificacion # TODO: Syntax for time lapse
# PRUEBAS! Los datos reales se deben agregar desde archivos 'csv'
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-1','Chelovek kinoapparatom','El hombre de la cámara',DEFAULT,DEFAULT,DEFAULT,'Unión Soviética','1929',6605,DEFAULT,'Dziga Vertov',DEFAULT,'Dziga Vertov',DEFAULT,DEFAULT,'Mikhail Kaufman',DEFAULT,'Elizaveta Svilova',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-2','Drifters',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Reino Unido','1929',5000,DEFAULT,'John Grierson',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Basil Emmott',DEFAULT,'John Grierson',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-3','Kino-Glaz','Kino-Eye',DEFAULT,DEFAULT,DEFAULT,'Unión Soviética','1924',9800,DEFAULT,'Dziga Vertov',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Mikhail Kaufman',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-4','Nanook of the north','Nanouk l´esquimau (Francia) / Nanook el esquimal (España)',DEFAULT,DEFAULT,DEFAULT,'Estados Unidos','1922',7816,DEFAULT,'Robert J. Flaherty',DEFAULT,'Robert J. Flaherty',DEFAULT,DEFAULT,'Robert J. Flaherty',DEFAULT,'Charles Gelb / Robert J. Flaherty',DEFAULT,DEFAULT,'Timothy Brock',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Ayudante de dirección: Thierry Mallet');
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-5','"Nogent, eldorado du diamanche"','Nogent',DEFAULT,DEFAULT,DEFAULT,'Francia','1929',1700,DEFAULT,'Marcel Carné',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Marcel Carné',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Bernard Gerard (música añadida en 1968)',DEFAULT,DEFAULT,DEFAULT,DEFAULT,'Michel Sanvoisin');
#INSERT INTO area_de_identificacion() VALUES('MXIM-AV-1-4-6','Regen','Inglés: Rain. Francés: La Pluie',DEFAULT,DEFAULT,DEFAULT,'Holanda','1929',12,DEFAULT,'"Joris Ivens, Mannus H. K. Franken"',DEFAULT,'"Joris Ivens, Mannus H. K. Franken"',DEFAULT,DEFAULT,'Joris Ivens',DEFAULT,'Joris Ivens',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT);

# Cargar datos desde archivo csv para la tabla area_de_identificacion
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas década4 (1920).csv'
	INTO TABLE area_de_identificacion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES;

# Cargar datos desde archivo csv para la tabla area_de_contexto
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Contexto.csv'
	INTO TABLE area_de_contexto
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, entidad_productora, productor, distribuidora, historia_institucional, resena_biografica, forma_de_ingreso, fecha_de_ingreso);

# Cargar datos desde archivo csv para la tabla area_de_contenido_y_estructura
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Contenido.csv'
	INTO TABLE area_de_contenido_y_estructura
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, sinopsis, descriptor_onomastico, descriptor_toponimico, descriptor_cronologico,	tipo_de_produccion,	genero,	fuentes, recursos, versiones, formato_original, material_extra);

# Cargar datos desde archivo csv para la tabla 'area_de_condiciones_de_acceso'
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Condiciones.csv'
	INTO TABLE area_de_condiciones_de_acceso
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, condiciones_de_acceso, existencia_y_localizacion_de_originales, idioma_original, doblajes_disponibles, subtitulajes, soporte, numero_copias, descripcion_fisica, color, audio, sistema_de_grabacion, region_dvd, requisitos_tecnicos);

# Cargar datos desde archivo csv para la tabla 'area_de_documentacion_asociada'
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Documentacion.csv'
	INTO TABLE area_de_documentacion_asociada
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, existencia_y_localizacion_de_copias, unidades_de_descripcion_relacionadas, documentos_asociados);

# Cargar datos desde archivo csv para la tabla 'area_de_notas'
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Notas.csv'
	INTO TABLE area_de_notas
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, area_de_notas);

# Cargar datos desde archivo csv para la tabla 'area_de_descripcion'
LOAD DATA INFILE '/home/rodrigo/Instituto\ Mora/Excel/Fichas\ década4\ \(1920\)\ Descripcion.csv'
	INTO TABLE area_de_descripcion
	CHARACTER SET utf8
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
	LINES TERMINATED BY '\n'
	IGNORE 3 LINES
	(codigo_de_referencia, @tituloIgnorado, notas_del_archivero, datos_del_archivero, reglas_o_normas, fecha_de_descripcion);

INSERT
	INTO area_de_identificacion(codigo_de_referencia, titulo_propio, pais, fecha, duracion)
	VALUES ('MXIM-AV-1-10-28', 'Titulo de ejemplo', 'México', '2015', '1010');