# El codigo de referencia para MXIM-AV-1-12-286 estaba repetido en el área de contenido y estructura, el error sobreescribió los datos hasta MXIM-AV-1-12-290
delete from area_de_contenido_y_estructura where codigo_de_referencia = 'MXIM-AV-1-12-286' or codigo_de_referencia = 'MXIM-AV-1-12-287' or codigo_de_referencia = 'MXIM-AV-1-12-288' or codigo_de_referencia = 'MXIM-AV-1-12-289' or codigo_de_referencia = 'MXIM-AV-1-12-290';
insert into area_de_contenido_y_estructura values ('MXIM-AV-1-12-286', '', 'Jesse Friedman, Arnold Friedman, Elaine Friedman, David Friedman, Seth Friedman, John McDermott (inspector postal), Detective Frances Galasso, Detective Anthony Sgueglia, Joseph Onorato (Asistente de Fiscal de distrito), Judd Maltin (mejor amigo de Jesse), Howard Friedman (hermano de Arnold), Ron Georgalis, Scott Banks, Jueza Abbey Boklan, Debbie Nathan, Jerri Bernstein (abogado), Peter Panaro (abogado), Anthony Sgueglia (detective)', 'Estados Unidos: Nueva York: Great Neck, Nassau', '1984, 1988, 1980', 'Documental', '', 'Testimonios videorales, documentos, fotografías, noticieros fílmicos, registros fonográficos, registros videográficos, entrevistas, musica de época, grabación de campo', 'Gráficos', '', '', 'El caso, Películas inéditas');
insert into area_de_contenido_y_estructura values ('MXIM-AV-1-12-287', '', '', '', '', '', '', '', '', '', '', '');
insert into area_de_contenido_y_estructura values ('MXIM-AV-1-12-288', '', '', 'México: Chiapas', '', 'Documental', '', 'Testimonios videorales, grabación de campo, entrevistas, registros fonográficos', 'Musicalización, narración en off', '', '', '');
insert into area_de_contenido_y_estructura values ('MXIM-AV-1-12-289', '', '', 'México: Chiapas: San Juan de la Libertad', '1999', 'Documental', '', 'Testimonios videorales, grabación de campo, entrevistas, registros fonográficos', 'Musicalización, narración en off', '', '', '');
insert into area_de_contenido_y_estructura values ('MXIM-AV-1-12-290', '', '', 'México: Chiapas: Oventic Caracol II', '1997, 2004', 'Documental', '', 'Testimonio videoral, testimonios orales, entrevistas, grabación de campo', 'Musicalización, narración en off', '', '', '');

# El codigo de referencia para MXIM-AV-1-10-85 omitía el último dígito (5) en el area de condiciones de acceso y area de documentación asociada
delete from area_de_condiciones_de_acceso where codigo_de_referencia = 'MXIM-AV-1-10-8' or codigo_de_referencia = 'MXIM-AV-1-10-85';
insert into area_de_condiciones_de_acceso values ('MXIM-AV-1-10-8', 'Usos reservados para consulta in situ', '', 'Español', '', '', 'VHS', '1 dvd', 'Copia', 'Color', '', 'NTSC', '', 'Reproductor VHS y monitor');
insert into area_de_condiciones_de_acceso values ('MXIM-AV-1-10-85', 'Usos reservados para consulta in situ', '', 'Español', '', '', 'DVD', '1 dvd', 'Copia', 'Color, blanco y negro', '', '', '', 'Reproductor DVD  y monitor');
delete from area_de_documentacion_asociada where codigo_de_referencia = 'MXIM-AV-1-10-8' or codigo_de_referencia = 'MXIM-AV-1-10-85';
insert into area_de_documentacion_asociada values ('MXIM-AV-1-10-8', '', '', '');
insert into area_de_documentacion_asociada values ('MXIM-AV-1-10-85', '', '', '');

# Reasignar codigo_de_referencia para una mejor catalogación
update area_de_identificacion set codigo_de_referencia='MXIM-AV-1-12-354' where codigo_de_referencia='MXIM-AV-1-12-188-1';
update area_de_identificacion set codigo_de_referencia='MXIM-AV-1-12-355' where codigo_de_referencia='MXIM-AV-1-12-188-2';

# Reasignar el codigo_de_referencia porque estaba repetido
delete from informacion_adicional where codigo_de_referencia = 'MXIM-AV-1-13-46-8';
insert into informacion_adicional values ('MXIM-AV-1-13-46-8', '', '');
insert into informacion_adicional values ('MXIM-AV-1-13-46-9', '', 'https://www.youtube.com/watch?v=pyZm_Dog-7c');

# Reasignar codigo_de_referencia para individualizar materiales (no son errores, son para tener más ordenada la colección)
# Se recomienda verificar primero que cada tabla contenga el mismo codigo_de_referencia:
#SELECT codigo_de_referencia, titulo_propio FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia = 'MXIM-AV-1-12-188';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-356' where codigo_de_referencia = 'MXIM-AV-1-12-188';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-357' where codigo_de_referencia = 'MXIM-AV-1-12-188-3';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-358' where codigo_de_referencia = 'MXIM-AV-1-12-188-4';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-359' where codigo_de_referencia = 'MXIM-AV-1-12-188-5';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-360' where codigo_de_referencia = 'MXIM-AV-1-12-188-6';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-361' where codigo_de_referencia = 'MXIM-AV-1-12-188-7';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-362' where codigo_de_referencia = 'MXIM-AV-1-12-188-8';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-363' where codigo_de_referencia = 'MXIM-AV-1-12-188-9';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-364' where codigo_de_referencia = 'MXIM-AV-1-12-188-10';
# Quedará libre temporalmente el codigo_de_referencia = 'MXIM-AV-1-12-188'
# --------------------
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-11-218' where codigo_de_referencia = 'MXIM-AV-1-11-53-1';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-11-219' where codigo_de_referencia = 'MXIM-AV-1-11-53-2';
# --------------------
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-4-7' where codigo_de_referencia = 'MXIM-AV-1-12-338';
# Quedará libre temporalmente el codigo_de_referencia = 'MXIM-AV-1-12-338'

# Borrar portadas temporales. Ahora son reemplazadas por imagenes generadas en Processing
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-6-13';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-6-9';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-7-9';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-9-17';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-11-129';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-11-107';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-11-134';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-11-206';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-233';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-234';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-235';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-236';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-237';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-105';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-106';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-287';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-181';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-12-290';

# Copiar una portada a otro documental
update informacion_adicional set imagen = 'MXIM-AV-1-12-21.jpg' where codigo_de_referencia = 'MXIM-AV-1-12-253';

# Es mejor mantener un registro general de actividades que solo de los borrados
drop table borrados;

# Incluir el símbolo de igualdad (=) como separador de títulos paralelos
update area_de_identificacion set titulo_paralelo = "Del Polo al ecuador = Dall Polo all'Equatore" where titulo_paralelo = "Del Polo al ecuador, Dall Polo all'Equatore";
update area_de_identificacion set titulo_paralelo = 'Excursiones caníbales = Viajes caníbales' where titulo_paralelo = 'Excursiones caníbales, Viajes caníbales';
update area_de_identificacion set titulo_paralelo = 'Nuestro siglo = Nosso século' where titulo_paralelo = 'Nuestro siglo, Nosso século';
update area_de_identificacion set titulo_paralelo = 'El final = film e vida' where titulo_paralelo = 'El final, film e vida';
update area_de_identificacion set titulo_paralelo = 'Pathé alrededor del mundo = Pathé around the world' where titulo_paralelo = 'Pathé alrededor del mundo, Pathé around the world';
update area_de_identificacion set titulo_paralelo = 'Swagatam (bienvenidos) = Swagatam (welcome)' where titulo_paralelo = 'Swagatam (bienvenidos), Swagatam (welcome)';
update area_de_identificacion set titulo_paralelo = 'Los cosechadores y yo = Los cosechadores y la cosechadora' where titulo_paralelo = 'Los cosechadores y yo, Los cosechadores y la cosechadora';
update area_de_identificacion set titulo_paralelo = 'Poses del siglo XIX = 19th Poses' where titulo_paralelo = 'Poses del siglo XIX, 19th Poses';
update area_de_identificacion set titulo_paralelo = 'Hablemos de Antonio Campos = Let´s talk about António Campos' where titulo_paralelo = 'Hablemos de Antonio Campos, Let´s talk about António Campos';
update area_de_identificacion set titulo_paralelo = 'Cine-Ojo = Kino-Eye' where titulo_paralelo = 'Cine-Ojo, Kino-Eye';
update area_de_identificacion set titulo_paralelo = 'Nanook el esquimal = Nanook del norte. Una historia de vida y amor en el Ártico actual' where titulo_paralelo = 'Nanook del norte Una historia de vida y amor in el Artico actual, Nanook el esquimal,';
update area_de_identificacion set titulo_paralelo = 'Lluvia = Rain = La Pluie' where titulo_paralelo = 'Lluvia, Rain, La Pluie';
update area_de_identificacion set titulo_paralelo = 'La caída de la dinastía Romanov = The fall of the Romanov dynasty' where titulo_paralelo = 'La caída de la dinastía Romanov, The fall of the Romanov dynasty';
update area_de_identificacion set titulo_paralelo = 'Tres cantos a Lenin = Three songs about Lenin' where titulo_paralelo = 'Tres cantos a Lenin, Three songs about Lenin';
update area_de_identificacion set titulo_paralelo = 'Semana Santa en Lorca = Semana Santa en Murcia y Cartagena = Fiestas de Primavera en Murcia' where titulo_paralelo = 'Semana Santa en Lorca, Semana Santa en Murcia y Cartagena, Fiestas de Primavera en Murcia';
update area_de_identificacion set titulo_paralelo = 'Danza Barong-Keket en Bali = Barong Kèkèt Dance on Bali' where titulo_paralelo = 'Danza Barong-Keket en Bali, Barong Kèkèt Dance on Bali';
update area_de_identificacion set titulo_paralelo = 'Taris, rey del agua = Taris, roi de léau' where titulo_paralelo = 'Taris, rey del agua, Taris, roi de léau';
update area_de_identificacion set titulo_paralelo = 'La sangre de las bestias = Blood of the beasts' where titulo_paralelo = 'La sangre de las bestias, Blood of the beasts';
update area_de_identificacion set titulo_paralelo = 'Londres puede soportarlo = Londres resiste' where titulo_paralelo = 'Londres puede soportarlo, Londres resiste';
update area_de_identificacion set titulo_paralelo = 'Los amos locos = The mad masters = Os mestres loucos' where titulo_paralelo = 'Los amos locos, The mad masters, Os mestres loucos';
update area_de_identificacion set titulo_paralelo = 'Mami agua = Mamy Wata' where titulo_paralelo = 'Mami agua, Mamy Wata';
update area_de_identificacion set titulo_paralelo = 'Nosotros = Nós' where titulo_paralelo = 'Nosotros, Nós';
update area_de_identificacion set titulo_paralelo = 'Los años locos = Mad years' where titulo_paralelo = 'Los años locos, Mad years';
update area_de_identificacion set titulo_paralelo = 'Bailes folklóricos en Desa, Rumania = Folk dances at Desa, Romania' where titulo_paralelo = 'Bailes folklóricos en Desa, Rumania, Folk dances at Desa, Romania';
update area_de_identificacion set titulo_paralelo = 'El principio = O inicio = Beginning = Au début' where titulo_paralelo = 'El principio, O inicio, Beginning, Au début';
update area_de_identificacion set titulo_paralelo = 'En la tierra de las canoas de guerra = Im land der Kriegs-Kanus = In the land of the headhunters' where titulo_paralelo = 'En la tierra de las canoas de guerra, Im land der Kriegs-Kanus, In the land of the headhunters';
update area_de_identificacion set titulo_paralelo = 'El fondo del aire es rojo = A grin without a cat' where titulo_paralelo = 'El fondo del aire es rojo, A grin without a cat';
update area_de_identificacion set titulo_paralelo = 'El tren en marcha = The train rolls on' where titulo_paralelo = 'El tren en marcha, The train rolls on';
update area_de_identificacion set titulo_paralelo = 'Los tambores de antaño = Tourou et Bitti' where titulo_paralelo = 'Los tambores de antaño, Tourou et Bitti';
update area_de_identificacion set titulo_paralelo = 'Toros en Forcalhos = Tourada em Forcalhos' where titulo_paralelo = 'Toros en Forcalhos, Tourada em Forcalhos';
update area_de_identificacion set titulo_paralelo = 'Las estaciones = Les saisons' where titulo_paralelo = 'Las estaciones, Les saisons';

# Agregar el campo "fecha_de_modificacion" en tabla "información_adicional"
alter table informacion_adicional
	add column fecha_de_modificacion TIMESTAMP;

# Eliminar formatos originales inconsistentes:
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-4%' and formato_original like '%VHS%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-5%' and formato_original like '%VHS%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-6%' and formato_original like '%VHS%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-7%' and formato_original like '%VHS%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-8%' and formato_original like '%VHS%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-4%' and formato_original like '%DVD%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-5%' and formato_original like '%DVD%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-6%' and formato_original like '%DVD%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-7%' and formato_original like '%DVD%';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-8%' and formato_original like '%DVD%';
update area_de_contenido_y_estructura set formato_original = '16 mm, Beta SP' where codigo_de_referencia = 'MXIM-AV-1-9-14';
update area_de_contenido_y_estructura set formato_original = '' where codigo_de_referencia like 'MXIM-AV-1-10%' and formato_original like '%DVD%';

# Cambiar idioma_original de "Muda" a "Silente"
update area_de_condiciones_de_acceso set idioma_original = 'Silente' where idioma_original like 'Muda';

# Reasignar codigo_de_referencia para una mejor catalogación
update area_de_identificacion set codigo_de_referencia='MXIM-AV-1-9-31' where codigo_de_referencia='MXIM-AV-1-5-13';

# Asignar una fecha no vacia para los campos donde no se asigno fecha_de_descripcion
update area_de_descripcion set fecha_de_descripcion = '2015-06-01' where fecha_de_descripcion = '0000-00-00';

# Corrección de nombre de catalogador/archivero
update area_de_descripcion set datos_del_archivero = 'Elisa Dolores Espinosa Cruz' where datos_del_archivero = 'Elisa D. Espinosa';

# Eliminar género "Footage"
update area_de_contenido_y_estructura set genero = '' where genero like '%footage%';

# Corregir la reseña_biografica del LAIS, que antes tenía solamente un URL inválido
update area_de_contexto set resena_biografica = 'El Instituto Mora es un centro público CONACyT, dedicado a la investigación y docencia en historia y ciencias sociales. Se fundó en 1981, cuenta con una planta permanente de investigadores en diversas disciplinas y líneas de investigación e imparte diversos posgrados. En 1993, en el área de Historia Oral, comienza la producción audiovisual, con el documental Un pueblo en la memoria. Desde entonces, el Instituto ha seguido produciendo documental a partir de los resultados de diversas investigaciones. En el 2000 se conforma el Laboratorio Audiovisual de Investigación Social, donde se ha seguido realizando documental, en el marco de su objetivo central: desarrollar investigación social con y sobre imágenes de los siglos XIX a XXI. A la fecha el LAIS ha producido: Un pueblo en la memoria (1994), Tradición o modernidad: reto de una generación (1996), El buen restaurador ama lo antiguo (1997), Cuando la rumba nos conoció (1998), Mi Multi es mi Multi (1999), Km. C-62 Un nómada del riel (2000), El arte de hacer ciudad (2000), De dolor y esperanza (2002), Revelando el rollo. Los usos de lo visual en la investigación social (2002), El triángulo de Tacubaya (2005), Ciudad Olimpia. El año en que fuimos modernos (2007), De la tele a la boca. Una reflexión sobre desarrollo infantil y televisión (2008) e Historias para no pensar (2012)' where resena_biografica = 'http://www.mora.edu.mx/Investigacion/Principal/laboratorio.html';

# Poner mayúsculas en numero_copias
update area_de_condiciones_de_acceso set numero_copias = '1 DVD' where numero_copias = '1 dvd';
update area_de_condiciones_de_acceso set numero_copias = '1 VHS' where numero_copias = '1 vhs';
update area_de_condiciones_de_acceso set numero_copias = '1 VHS, 1 DVD' where numero_copias = '1 vhs / 1 dvd';

# Usar una imagen de otro documental
update informacion_adicional set imagen = 'falamosdeantoniocampos.jpg' where codigo_de_referencia = 'MXIM-AV-1-12-341';

-- Documentales sin portada (y con imagen incorrecta):
-- MXIM-AV-1-13-46
-- MXIM-AV-1-12-366
-- MXIM-AV-1-12-365
-- MXIM-AV-1-12-338
-- MXIM-AV-1-12-290
-- MXIM-AV-1-12-289
-- MXIM-AV-1-12-288
-- MXIM-AV-1-12-287
-- MXIM-AV-1-12-237
-- MXIM-AV-1-12-236
-- MXIM-AV-1-12-235
-- MXIM-AV-1-12-234
-- MXIM-AV-1-12-233
-- MXIM-AV-1-12-232
-- MXIM-AV-1-12-181
-- MXIM-AV-1-11-224
-- MXIM-AV-1-11-134
-- (portada.jpg)
-- (empty)
select codigo_de_referencia, imagen from informacion_adicional where codigo_de_referencia = 'MXIM-AV-1-13-46' or codigo_de_referencia = 'MXIM-AV-1-12-366' or codigo_de_referencia = 'MXIM-AV-1-12-365' or codigo_de_referencia = 'MXIM-AV-1-12-338' or codigo_de_referencia = 'MXIM-AV-1-12-290' or codigo_de_referencia = 'MXIM-AV-1-12-289' or codigo_de_referencia = 'MXIM-AV-1-12-288' or codigo_de_referencia = 'MXIM-AV-1-12-287' or codigo_de_referencia = 'MXIM-AV-1-12-237' or codigo_de_referencia = 'MXIM-AV-1-12-236' or codigo_de_referencia = 'MXIM-AV-1-12-235' or codigo_de_referencia = 'MXIM-AV-1-12-234' or codigo_de_referencia = 'MXIM-AV-1-12-233' or codigo_de_referencia = 'MXIM-AV-1-12-232' or codigo_de_referencia = 'MXIM-AV-1-12-181' or codigo_de_referencia = 'MXIM-AV-1-11-224' or codigo_de_referencia = 'MXIM-AV-1-11-134' or imagen = 'portada.jpg' or imagen = '';
update informacion_adicional set imagen = '' where codigo_de_referencia = 'MXIM-AV-1-13-46' or codigo_de_referencia = 'MXIM-AV-1-12-366' or codigo_de_referencia = 'MXIM-AV-1-12-365' or codigo_de_referencia = 'MXIM-AV-1-12-338' or codigo_de_referencia = 'MXIM-AV-1-12-290' or codigo_de_referencia = 'MXIM-AV-1-12-289' or codigo_de_referencia = 'MXIM-AV-1-12-288' or codigo_de_referencia = 'MXIM-AV-1-12-287' or codigo_de_referencia = 'MXIM-AV-1-12-237' or codigo_de_referencia = 'MXIM-AV-1-12-236' or codigo_de_referencia = 'MXIM-AV-1-12-235' or codigo_de_referencia = 'MXIM-AV-1-12-234' or codigo_de_referencia = 'MXIM-AV-1-12-233' or codigo_de_referencia = 'MXIM-AV-1-12-232' or codigo_de_referencia = 'MXIM-AV-1-12-181' or codigo_de_referencia = 'MXIM-AV-1-11-224' or codigo_de_referencia = 'MXIM-AV-1-11-134' or imagen = 'portada.jpg' or imagen = '';

# Corregir VHS
select codigo_de_referencia, soporte, numero_copias, descripcion_fisica from area_de_condiciones_de_acceso where soporte like '%vhs%' and soporte not like '%dvd%';

# Correccion de fechas para "El secreto del alcohol", "La calle de los niños", "Historias de gente grande"
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-11-229' where codigo_de_referencia = 'MXIM-AV-1-13-46-1';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-372' where codigo_de_referencia = 'MXIM-AV-1-13-46-2';
update area_de_identificacion set codigo_de_referencia = 'MXIM-AV-1-12-373' where codigo_de_referencia = 'MXIM-AV-1-13-46-6';
