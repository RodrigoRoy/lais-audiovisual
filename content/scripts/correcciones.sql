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