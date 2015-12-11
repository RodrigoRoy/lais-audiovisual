# Indicar con que base de datos trabajar
USE Audiovisuales;
# Util para mostrar correctamente caracteres 'extraños'
SET NAMES utf8;


# Total de documentales en la base de datos
SELECT COUNT(*) AS documentales
	FROM area_de_identificacion
    WHERE codigo_de_referencia LIKE 'MXIM-AV-1-10%';

# Total de documentales con sinopsis
SELECT COUNT(*) AS sinopsis
	FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura
    WHERE sinopsis NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con pais
SELECT COUNT(*)
	FROM area_de_identificacion
    WHERE pais NOT LIKE '';

# Total de documentales con fecha
SELECT COUNT(*)
	FROM area_de_identificacion
    WHERE fecha NOT LIKE '';

# Total de documentales con duracion
SELECT COUNT(*)
	FROM area_de_identificacion
    WHERE duracion NOT LIKE '';

# Total de documentales con realizador(es)
SELECT COUNT(*)
	FROM area_de_identificacion
    WHERE realizacion NOT LIKE '';

# Total de documentales con imagen de portada
SELECT COUNT(*)
	FROM area_de_identificacion NATURAL JOIN informacion_adicional
    WHERE imagen NOT LIKE '';

# Total de documentales con URL
SELECT COUNT(*)
	FROM area_de_identificacion NATURAL JOIN informacion_adicional
    WHERE url NOT LIKE '';

### Información similar a la anterior pero recopilada por décadas:

# Total de documentales por década
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos, COUNT(*) AS total_por_decada
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas 
		FROM area_de_identificacion) AS claves
	GROUP BY decadas
	ORDER BY codigos DESC;

# Total de documentales, por década, con sinópsis NO vacia
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos, COUNT(*) AS sinopsis_disponibles
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, sinopsis
		FROM area_de_identificacion
			NATURAL JOIN area_de_contenido_y_estructura) AS claves
	WHERE sinopsis NOT LIKE ''
	GROUP BY decadas
	ORDER BY codigos DESC;

# Total de documentales, por década, con sinópsis vacia
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos, COUNT(*) AS sinopsis_disponibles
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, sinopsis
		FROM area_de_identificacion
			NATURAL JOIN area_de_contenido_y_estructura) AS claves
	WHERE sinopsis LIKE ''
	GROUP BY decadas
	ORDER BY codigos DESC;

# Total de documentales, de una década específica, con sinopsis vacia
SELECT COUNT(*) AS sinopsis_vacias
	FROM area_de_identificacion
		NATURAL JOIN area_de_contenido_y_estructura
    WHERE sinopsis LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1-11-%';


# Total de documentales, por década, sin imagen de portada
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos, COUNT(*) AS sin_portadas_disponibles
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, imagen
		FROM area_de_identificacion
			NATURAL JOIN informacion_adicional) AS claves
	WHERE imagen LIKE ''
	GROUP BY decadas
	ORDER BY codigos DESC;

# Total de documentales, por década, con imagen de portada
SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos, COUNT(*) AS portadas_disponibles
	FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, imagen
		FROM area_de_identificacion
			NATURAL JOIN informacion_adicional) AS claves
	WHERE imagen NOT LIKE ''
	GROUP BY decadas
	ORDER BY codigos DESC;