# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;

# Este documento sirve para realizar consultas y pruebas a la base de datos

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
DELETE FROM registro_actividades;
DELETE FROM usuarios;
# Borrar todas las tablas (y sus contenidos) de la base Audiovisuales
DROP TABLE area_de_contexto;
DROP TABLE area_de_contenido_y_estructura;
DROP TABLE area_de_condiciones_de_acceso;
DROP TABLE area_de_documentacion_asociada;
DROP TABLE area_de_notas;
DROP TABLE area_de_descripcion;
DROP TABLE informacion_adicional;
DROP TABLE area_de_identificacion; # Debido a que codigo_de_referencia es PK, se elimina al final
DROP TABLE usuarios;
# Borrar toda la base de datos
DROP DATABASE IF EXISTS Audiovisuales;

# Mostrar información del diseño de la base, de las tablas y columnas
SHOW DATABASES;
SHOW TABLES FROM Audiovisuales;
SHOW COLUMNS FROM area_de_condiciones_de_acceso;

# Borrar una década
DELETE FROM area_de_identificacion WHERE codigo_de_referencia LIKE 'MXIM-AV-1-13%';

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

# Selección completa de información de una década
SELECT *
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura
		NATURAL JOIN area_de_condiciones_de_acceso
		NATURAL JOIN area_de_documentacion_asociada
		NATURAL JOIN area_de_notas
        NATURAL JOIN area_de_descripcion
		NATURAL JOIN informacion_adicional
	WHERE codigo_de_referencia LIKE 'MXIM-AV-1-9%';

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
SELECT * FROM information_schema.`COLUMNS` C WHERE TABLE_SCHEMA = 'Audiovisuales.area_de_identificacion';
#SELECT COLUMN_NAME FROM information_schema.`COLUMNS` C WHERE TABLE_SCHEMA = 'Audiovisuales';
# Mostrar todas las tablas de la base de datos
SHOW TABLES;
#Mostrar todas las columnas de una tabla
SHOW COLUMNS FROM area_de_identificacion;
DESCRIBE area_de_identificacion;
#SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'my_database' AND TABLE_NAME = 'my_table';
SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'Audiovisuales' AND TABLE_NAME = 'area_de_identificacion';

# Muestra el código de cada década (ordenada alfabnumericamente, lo cual es incorrecto)
SELECT DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',4) as decadas 
	FROM area_de_identificacion 
    ORDER BY decadas ASC;

# Ordenar correctamente (de manera numérica) los codigos de las décadas
# Requiere subconsulta del código de las décadas, hacer substring y cast para ordenamiento numérico.
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos
	FROM (SELECT DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas 
		FROM area_de_identificacion) AS claves
	ORDER BY codigos DESC;

#SELECT PARA TRAER TODOS LOS ARCHIVOS DE UNA DECADA EN ESPECIFICO
SELECT codigo_de_referencia FROM area_de_identificacion WHERE codigo_de_referencia LIKE '%MXIM-AV-1-4%';

# Obtener una cantidad limitada de registros (en el ejemplo se piden 10 registros a partir del registro 0)
SELECT codigo_de_referencia, titulo_propio, pais, fecha, duracion, imagen
	FROM area_de_identificacion
		NATURAL JOIN informacion_adicional
	WHERE codigo_de_referencia LIKE '%MXIM-AV-1-4%'
	ORDER BY fecha DESC
	LIMIT 0,10; # offset, row_count

# Borrar pruebas
DELETE FROM area_de_identificacion WHERE titulo_propio LIKE '%Foo%';

# Obtener indices por década
SELECT 
	DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',-1) as decadas 
	FROM area_de_identificacion 
	WHERE codigo_de_referencia LIKE '%MXIM-AV-1-4%'
	ORDER BY decadas ASC;

# Verificación de integridad de los usuarios (no permite modificación en nombres existentes)
UPDATE usuarios SET Username ='Sergio', Password ='lais', Privilegio ='3' WHERE Username='Usuario1';

# Selección para depurar información
SELECT codigo_de_referencia, titulo_propio, otros_colaboradores 
	FROM area_de_identificacion
	WHERE codigo_de_referencia LIKE 'MXIM-AV-1-7%'
	ORDER BY codigo_de_referencia ASC;
SELECT * 
	FROM area_de_identificacion 
	WHERE codigo_de_referencia LIKE 'MXIM-AV-1-5%';

# Permite borrar los registro de una década particular
DELETE FROM area_de_identificacion WHERE codigo_de_referencia LIKE 'MXIM-AV-1-5%';

# Todos los materiales audiovisuales sin sinopsis
SELECT codigo_de_referencia, titulo_propio, sinopsis
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contenido_y_estructura
	WHERE sinopsis = '';
# Cuántos materiales sin sinopsis
SELECT COUNT(*)
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contenido_y_estructura
	WHERE sinopsis = '';
    
# Todos los materiales audiovisuales que incluyen URL en la sinopsis
SELECT codigo_de_referencia, titulo_propio, sinopsis
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contenido_y_estructura 
	WHERE sinopsis LIKE '%http%';
    
# Materiales sin portada
SELECT codigo_de_referencia, titulo_propio
	FROM area_de_identificacion 
		NATURAL JOIN informacion_adicional
	WHERE imagen = '';
# Cuántos materiales sin portada
SELECT COUNT(*)
	FROM area_de_identificacion 
		NATURAL JOIN informacion_adicional
	WHERE imagen = '';

# Orden descendente en datos de una década
SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen
	FROM area_de_identificacion
		NATURAL JOIN informacion_adicional
    WHERE codigo_de_referencia LIKE 'MXIM-AV-1-9%'
    ORDER BY fecha DESC;

# Limitar la cantidad de resultados (offset/apuntador y cantidad)
SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen
	FROM area_de_identificacion
		NATURAL JOIN informacion_adicional
    WHERE codigo_de_referencia LIKE 'MXIM-AV-1-9%'
    ORDER BY fecha DESC
    LIMIT 0,8;

# Manera adecuada (subconsulta) de obtener de manera ordenada los primeros 32 audiovisuales de una década
SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen
	FROM (SELECT *
		FROM area_de_identificacion
			NATURAL JOIN informacion_adicional
		WHERE codigo_de_referencia LIKE 'MXIM-AV-1-9%'
		ORDER BY fecha DESC) AS ordered
	#ORDER BY fecha DESC
	LIMIT 0,32; # offset, row_count

# Usar REGEXP para detectar campos que tengan espacios vacios al inicio
SELECT *
	FROM area_de_identificacion 
	WHERE realizacion REGEXP '^ ';

SELECT codigo_de_referencia
	FROM area_de_identificacion
	WHERE codigo_de_referencia LIKE 'MXIM-AV-1-11-%';

# Seleccionar documentales de la década 11 (1990) sin realizador
SELECT codigo_de_referencia, titulo_propio
	FROM area_de_identificacion
    WHERE codigo_de_referencia LIKE 'MXIM-AV-1-12-%' AND realizacion = '';
    

SELECT codigo_de_referencia, titulo_propio
	FROM area_de_identificacion
    WHERE codigo_de_referencia LIKE 'MXIM-AV-1-12-%' AND fecha = '';
    
# Obtener k (168) sinopsis desde el índice i (0) de manera ordenada (tanto como es posible) por codigo_de_referencia
SELECT subconsulta.codigo_de_referencia, subconsulta.titulo_propio, subconsulta.sinopsis
FROM
(SELECT claves.codigo_de_referencia, claves.numeracion, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigo, titulo_propio, sinopsis
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, codigo_de_referencia, CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion
		FROM area_de_identificacion) AS claves
        NATURAL JOIN area_de_contenido_y_estructura
        NATURAL JOIN area_de_identificacion
	ORDER BY codigo, numeracion ASC
    LIMIT 0 , 168)subconsulta;

# Modificar la longitud de un campo y el valor por defecto
ALTER TABLE area_de_condiciones_de_acceso
	ALTER audio SET DEFAULT ''
	MODIFY audio VARCHAR(50);

select codigo_de_referencia, productor, distribuidora from area_de_contexto where productor <> '' or distribuidora <> '';
