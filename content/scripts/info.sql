use Audiovisuales;
set names utf8;

# Lista con la cantidad de documentales por fuentes empleadas
select 'Cartografia', count(*) from area_de_contenido_y_estructura where fuentes like '%cartografia%'
union
select 'Dibujos', count(*) from area_de_contenido_y_estructura where fuentes like '%dibujo%'
union
select 'Documentales', count(*) from area_de_contenido_y_estructura where fuentes like '%documentales%'
union
select 'Documentos', count(*) from area_de_contenido_y_estructura where fuentes like '%documentos%'
union
select 'Entrevistas', count(*) from area_de_contenido_y_estructura where fuentes like '%entrevistas%'
union
select 'Ficción', count(*) from area_de_contenido_y_estructura where fuentes like '%ficcion%'
union
select 'Fotografías', count(*) from area_de_contenido_y_estructura where fuentes like '%fotografia%'
union
select 'Grabación de campo', count(*) from area_de_contenido_y_estructura where fuentes like '%grabacion de campo%'
union
select 'Grabados', count(*) from area_de_contenido_y_estructura where fuentes like '%grabados%'
union
select 'Hemerografía', count(*) from area_de_contenido_y_estructura where fuentes like '%hemerografia%'
union
select 'Multimedia', count(*) from area_de_contenido_y_estructura where fuentes like '%multimedia%'
union
select 'Música de época', count(*) from area_de_contenido_y_estructura where fuentes like '%musica de epoca%'
union
select 'Noticieros fílmicos', count(*) from area_de_contenido_y_estructura where fuentes like '%noticieros filmicos%'
union
select 'Pinturas', count(*) from area_de_contenido_y_estructura where fuentes like '%pinturas%'
union
select 'Programas de TV', count(*) from area_de_contenido_y_estructura where fuentes like '%programas de tv%'
union
select 'Publicidad', count(*) from area_de_contenido_y_estructura where fuentes like '%publicidad%'
union
select 'Registros fílmicos', count(*) from area_de_contenido_y_estructura where fuentes like '%registros filmicos%'
union
select 'Registros fonográficos', count(*) from area_de_contenido_y_estructura where fuentes like '%registros fonograficos%'
union
select 'Registros videográficos', count(*) from area_de_contenido_y_estructura where fuentes like '%registros videograficos%'
union
select 'Testimonios orales', count(*) from area_de_contenido_y_estructura where fuentes like '%testimonios orales%'
union
select 'Testimonios videorales', count(*) from area_de_contenido_y_estructura where fuentes like '%testimonios videorales%'
union
select 'Videoclips', count(*) from area_de_contenido_y_estructura where fuentes like '%videoclips%';

# Lista con la cantidad de documentales por recursos empleados
select 'Animación', count(*) from area_de_contenido_y_estructura where recursos like '%animacion%'
union
select 'Audiovisuales', count(*) from area_de_contenido_y_estructura where recursos like '%audiovisuales%'
union
select 'Conducción', count(*) from area_de_contenido_y_estructura where recursos like '%conduccion%'
union
select 'Gráficos', count(*) from area_de_contenido_y_estructura where recursos like '%graficos%'
union
select 'Incidentales', count(*) from area_de_contenido_y_estructura where recursos like '%incidentales%'
union
select 'Interactividad', count(*) from area_de_contenido_y_estructura where recursos like '%interactividad%'
union
select 'Intertítulos', count(*) from area_de_contenido_y_estructura where recursos like '%intertitulos%'
union
select 'Musicalización', count(*) from area_de_contenido_y_estructura where recursos like '%musicalizacion%'
union
select 'Narración en off', count(*) from area_de_contenido_y_estructura where recursos like '%narracion en off%'
union
select 'Puesta en escena', count(*) from area_de_contenido_y_estructura where recursos like '%puesta en escena%';

# Lista de los documentales con referencias a la década de 1880
select codigo_de_referencia, titulo_propio from area_de_identificacion natural join area_de_contenido_y_estructura where descriptor_cronologico like '%188_%';

# Guardar toda la información en archivos temporales para ser comparados con el comando diff
select *
	from area_de_identificacion 
		natural join area_de_contexto 
		natural join area_de_contenido_y_estructura
		natural join area_de_condiciones_de_acceso
		natural join area_de_documentacion_asociada
		natural join area_de_notas
		natural join area_de_descripcion
		natural join informacion_adicional 
	order by codigo_de_referencia
	into outfile '/tmp/predata.csv'
	#into outfile '/tmp/posdata.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';