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
UPDATE area_de_identificacion SET codigo_de_referencia='MXIM-AV-1-12-354' WHERE codigo_de_referencia='MXIM-AV-1-12-188-1';
UPDATE area_de_identificacion SET codigo_de_referencia='MXIM-AV-1-12-355' WHERE codigo_de_referencia='MXIM-AV-1-12-188-2';
