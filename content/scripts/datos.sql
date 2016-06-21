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
SELECT COUNT(*) AS pais
	FROM area_de_identificacion
    WHERE pais NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con fecha
SELECT COUNT(*) AS fecha
	FROM area_de_identificacion
    WHERE fecha NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con duracion
SELECT COUNT(*) AS duracion
	FROM area_de_identificacion
    WHERE duracion NOT LIKE '00:00:00' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con realizador(es)
SELECT COUNT(*) AS realizacion
	FROM area_de_identificacion
    WHERE realizacion NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con imagen de portada
SELECT COUNT(*) AS imagen
	FROM area_de_identificacion NATURAL JOIN informacion_adicional
    WHERE imagen NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con URL
SELECT COUNT(*) AS url
	FROM area_de_identificacion NATURAL JOIN informacion_adicional
    WHERE url NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con fuentes
SELECT COUNT(*) AS fuentes
	FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura
    WHERE fuentes NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';

# Total de documentales con recursos
SELECT COUNT(*) AS recursos
	FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura
    WHERE recursos NOT LIKE '' AND codigo_de_referencia LIKE 'MXIM-AV-1%';


### Obtener los códigos de referencia y titulo de documentales con información faltante:

# Documentales sin sinopsis
SELECT codigo_de_referencia, titulo_propio,  
  CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion,
  CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(codigo_de_referencia,'-',4),'-',-1) AS UNSIGNED) AS decada
	FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura
    WHERE sinopsis = '' AND codigo_de_referencia LIKE 'MXIM-AV-1%'
    ORDER BY decada DESC, numeracion ASC;

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

# Variante para contar la cantidad de documentales sin realizador o sin director y de una década en específico
SELECT codigo_de_referencia, titulo_propio, realizacion, direccion,
	CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion, 
	CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(codigo_de_referencia,'-',4),'-',-1) AS UNSIGNED) AS decada 
        FROM area_de_identificacion
        WHERE realizacion = '' AND direccion = '' AND codigo_de_referencia LIKE 'MXIM-AV-1%' 
        ORDER BY decada DESC, numeracion ASC;

# Similar al anterior pero obtiene la cantidad de documentales SIN realizador o SIN directos de una década en específico
SELECT COUNT(*) AS realizacion FROM area_de_identificacion 
	WHERE (realizacion NOT LIKE '' OR direccion NOT LIKE '') AND (codigo_de_referencia LIKE 'MXIM-AV-1%');