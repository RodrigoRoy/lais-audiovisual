# Indicar con que base de datos trabajar
USE Coleccion_Archivistica;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Mostrar tablas
SELECT * FROM area_de_identificacion;
SELECT * FROM area_de_contexto;
SELECT * FROM area_de_contenido_y_estructura;
SELECT * FROM area_de_condiciones_de_acceso;
SELECT * FROM area_de_documentacion_asociada;
SELECT * FROM area_de_notas;
SELECT * FROM area_de_descripcion;
SELECT * FROM informacion_adicional;
SELECT * FROM usuarios;
# Borrar todos los contenidos de las tablas
DELETE FROM area_de_identificacion;
DELETE FROM area_de_contexto;
DELETE FROM area_de_contenido_y_estructura;
DELETE FROM area_de_condiciones_de_acceso;
DELETE FROM area_de_documentacion_asociada;
DELETE FROM area_de_notas;
DELETE FROM area_de_descripcion;
DELETE FROM informacion_adicional;
DELETE FROM usuarios;
# Borrar todas las tablas (y sus contenidos) de la base Coleccion_Archivistica
DROP TABLE area_de_contexto;
DROP TABLE area_de_contenido_y_estructura;
DROP TABLE area_de_condiciones_de_acceso;
DROP TABLE area_de_documentacion_asociada;
DROP TABLE area_de_notas;
DROP TABLE area_de_descripcion;
DROP TABLE informacion_adicional;
DROP TABLE usuarios;
DROP TABLE area_de_identificacion; # Debido a que codigo_de_referencia es PK, se elimina al final
DROP VIEW decada1920, audiovisual; # Borar vistas
# Mostrar todos los registros de todas las tablas
SELECT *
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura
		NATURAL JOIN area_de_condiciones_de_acceso
		NATURAL JOIN area_de_documentacion_asociada
		NATURAL JOIN area_de_notas
		NATURAL JOIN area_de_descripcion
		NATURAL JOIN informacion_adicional;

# Mostrar algunos renglones de la tabla
SELECT codigo_de_referencia,titulo_propio, duracion FROM area_de_identificacion 
	WHERE duracion = '00:00:00';
# Mostrar por orden ascendente
SELECT * FROM area_de_identificacion
	ORDER BY codigo_de_referencia ASC;
# Mostrar por orden descendente
SELECT * FROM area_de_identificacion
	ORDER BY codigo_de_referencia DESC;
# Union de tablas mediante JOIN
# NATURAL JOIN es adecuado siempre y cuando la columna 'codigo_de_referencia' esté en las tablas involucradas
SELECT * 
	FROM area_de_identificacion NATURAL JOIN area_de_contexto;
# LEFT JOIN actua de la misma manera pero requiere indicar las columnas iguales
SELECT * 
	FROM area_de_identificacion AS identificacion LEFT JOIN area_de_contexto AS contexto
	ON identificacion.codigo_de_referencia = contexto.codigo_de_referencia;
# INNER JOIN es semánticamente equivalente a NATURAL [LEFT] JOIN
SELECT * 
	FROM area_de_identificacion INNER JOIN area_de_contexto
	ON area_de_identificacion.codigo_de_referencia = area_de_contexto.codigo_de_referencia;
# Selección selectiva de campos con NATURAL JOIN
SELECT codigo_de_referencia, titulo_propio, fecha, productor
	FROM area_de_identificacion NATURAL JOIN area_de_contexto;
# Mostrar contenido de 3 tablas
SELECT codigo_de_referencia, titulo_propio, productor, tipo_de_produccion
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura;

# Borrar selectivamente
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-4-1';
# Borrar un elemento y verificar la integridad de los datos mediante las llaves foráneas definidas
DELETE FROM area_de_contexto WHERE codigo_de_referencia = 'MXIM-AV-1-4-1';
DELETE FROM area_de_contenido_y_estructura WHERE codigo_de_referencia = 'MXIM-AV-1-4-2';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia = 'MXIM-AV-1-4-3';
# NOTA!
# Para borrar totalmente un registro o material audiovisual de la base de datos, se debe borrar desde la tabla 'area_de_identificacion'

# Selección completa de información de un audiovisual particular
SELECT *
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura
		NATURAL JOIN area_de_condiciones_de_acceso
		NATURAL JOIN area_de_documentacion_asociada
		NATURAL JOIN area_de_notas
		NATURAL JOIN area_de_descripcion
	WHERE codigo_de_referencia = 'MXIM-AV-1-4-64';

UPDATE area_de_identificacion
	SET codigo_de_referencia='MXIM-AV-1-4-30', pais='URSS', titulo_paralelo='El Hombre de la Cámara'
	WHERE codigo_de_referencia='MXIM-AV-1-4-1';
UPDATE area_de_contexto
	SET productor='Hola mundo'
	WHERE codigo_de_referencia='MXIM-AV-1-4-1';

UPDATE area_de_identificacion
	SET codigo_de_referencia='MXIM-AV-1-4-1', pais='Unión Soviética', titulo_paralelo='El hombre de la cámara'
	WHERE codigo_de_referencia='MXIM-AV-1-4-30';
UPDATE area_de_contexto
	SET productor='Foo'
	WHERE codigo_de_referencia='MXIM-AV-1-4-30';

SELECT CURDATE();
# Mostrar toda la información de las columnas
SELECT * FROM information_schema.`COLUMNS` C WHERE TABLE_SCHEMA = 'Coleccion_Archivistica.area_de_identificacion';
#SELECT COLUMN_NAME FROM information_schema.`COLUMNS` C WHERE TABLE_SCHEMA = 'Coleccion_Archivistica';
# Mostrar todas las tablas de la base de datos
SHOW TABLES;
#Mostrar todas las columnas de una tabla
SHOW COLUMNS FROM area_de_identificacion;
DESCRIBE area_de_identificacion;
#SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'my_database' AND TABLE_NAME = 'my_table';
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'Coleccion_Archivistica' AND TABLE_NAME = 'area_de_identificacion';

# Muestra el código de cada década
SELECT DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',4) as decadas FROM area_de_identificacion ORDER BY decadas ASC;

#SELECT PARA TRAER TODOS LOS ARCHIVOS DE UNA DECADA EN ESPECIFICO
SELECT codigo_de_referencia FROM area_de_identificacion WHERE codigo_de_referencia LIKE '%MXIM-AV-1-4%';

# Obtener una cantidad limitada de registros (en el ejemplo se piden 10 registros a partir del registro 0)
SELECT codigo_de_referencia, titulo_propio, pais, fecha, duracion, imagen
	FROM area_de_identificacion
		NATURAL JOIN informacion_adicional
	WHERE codigo_de_referencia LIKE '%MXIM-AV-1-4%'
	ORDER BY fecha ASC
	LIMIT 0,10; # offset, row_count

# Borrar pruebas
DELETE FROM area_de_identificacion WHERE titulo_propio LIKE '%Foo%';