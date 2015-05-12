# Mostrar todo el contenido de la tabla
SELECT * FROM area_de_identificacion;
# Mostrar algunos renglones de la tabla
SELECT codigo_de_referencia,titulo_propio, duracion FROM area_de_identificacion 
	WHERE duracion = '00:00:00';
# Mostrar por orden ascendente/descendente
SELECT * FROM area_de_identificacion
	ORDER BY codigo_de_referencia ASC;

SELECT * FROM area_de_identificacion
	ORDER BY codigo_de_referencia DESC;

# Mostrar todo el contenido de la tabla area_de_contexto
SELECT * FROM area_de_contexto;

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

SELECT codigo_de_referencia, titulo_propio, fecha, productor
	FROM area_de_identificacion NATURAL JOIN area_de_contexto;

# Mostrar todo el contenido de la tabla 'area_de_contenido_y_estructura'
SELECT * FROM area_de_contenido_y_estructura;

# Mostrar contenido de 3 tablas
SELECT codigo_de_referencia, titulo_propio, productor, tipo_de_produccion
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura;

# Mostrar todo el contenido de la tabla 'area_de_condiciones_de_uso'
SELECT * FROM area_de_condiciones_de_acceso;

# Borrar tabla area_de_identificacion
DROP TABLE area_de_identificacion;
# Borrar tabla area_de_contexto
DROP TABLE area_de_contexto;

# Borra el contenido de la tabla
DELETE FROM area_de_identificacion;

# Borrar selectivamente
DELETE FROM area_de_identificacion WHERE codigo_de_referencia='MXIM-AV-1-4-1';

# Borrar un elemento y verificar la integridad de los datos mediante las llaves foráneas definidas
DELETE FROM area_de_contexto WHERE codigo_de_referencia = 'MXIM-AV-1-4-1';
DELETE FROM area_de_contenido_y_estructura WHERE codigo_de_referencia = 'MXIM-AV-1-4-2';
DELETE FROM area_de_identificacion WHERE codigo_de_referencia = 'MXIM-AV-1-4-3';
# NOTA!
# Para borrar totalmente un registro o material audiovisual de la base de datos, se debe borrar desde la tabla 'area_de_identificacion'


# Mostrar tablas
SELECT * FROM area_de_identificacion;
SELECT * FROM area_de_contexto;
SELECT * FROM area_de_contenido_y_estructura;
SELECT * FROM area_de_condiciones_de_acceso;
SELECT * FROM area_de_documentacion_asociada;
SELECT * FROM area_de_notas;
SELECT * FROM area_de_descripcion;
# Borrar todos los contenidos de las tablas
DELETE FROM area_de_identificacion;
DELETE FROM area_de_contexto;
DELETE FROM area_de_contenido_y_estructura;
DELETE FROM area_de_condiciones_de_acceso;
DELETE FROM area_de_documentacion_asociada;
DELETE FROM area_de_notas;
DELETE FROM area_de_descripcion;

# Mostrar todos los registros de todas las tablas
SELECT *
	FROM area_de_identificacion 
		NATURAL JOIN area_de_contexto 
		NATURAL JOIN area_de_contenido_y_estructura
		NATURAL JOIN area_de_condiciones_de_acceso
		NATURAL JOIN area_de_documentacion_asociada
		NATURAL JOIN area_de_notas
		NATURAL JOIN area_de_descripcion;

SELECT codigo_de_referencia, titulo_propio, pais, fecha FROM area_de_identificacion
	WHERE titulo_propio LIKE '%diamanche%';

SELECT * FROM area_de_identificacion WHERE codigo_de_referencia = 'MXIM-AV-1-8-1';