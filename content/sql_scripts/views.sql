# Ejemplo de vista: 
# DECADA 1920-1929 (DÉCADA 4)
CREATE
	OR REPLACE
	VIEW decada1920
	AS SELECT *
		FROM area_de_identificacion 
			NATURAL JOIN area_de_contexto 
			NATURAL JOIN area_de_contenido_y_estructura
			NATURAL JOIN area_de_condiciones_de_acceso
			NATURAL JOIN area_de_documentacion_asociada
			NATURAL JOIN area_de_notas
			NATURAL JOIN area_de_descripcion
		WHERE codigo_de_referencia REGEXP '^[A-Z]{4}-[A-Z]{2}-[0-9]+-4'
		ORDER BY codigo_de_referencia ASC;

# Vista con todos los datos de los audiovisuales en todas las tablas
CREATE
	OR REPLACE
	VIEW audiovisual
	AS SELECT *
		FROM area_de_identificacion 
			NATURAL JOIN area_de_contexto 
			NATURAL JOIN area_de_contenido_y_estructura
			NATURAL JOIN area_de_condiciones_de_acceso
			NATURAL JOIN area_de_documentacion_asociada
			NATURAL JOIN area_de_notas
			NATURAL JOIN area_de_descripcion;

SELECT * FROM decada1920;
SELECT * FROM audiovisual;