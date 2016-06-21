#!/bin/bash
# This script must be executed in /content/scripts
# Export database information to CSV files in directory ../backup/

# First check if directory named backup/ exists, if not then create it
cd ..
if [[ ! -d backup ]] ; then
	mkdir backup && echo 'Directory ../backup/ created' || exit 1
	chmod a+w backup && echo 'Grant write permission to directory ../backup' || exit 1
fi
# Next, check if directory backup/ contains csv files then remove it
cd backup
if [[ -f area_de_identificacion.csv && -f area_de_contexto.csv && -f area_de_contenido_y_estructura.csv && -f area_de_condiciones_de_acceso.csv && -f area_de_documentacion_asociada.csv && -f area_de_notas.csv && -f area_de_descripcion.csv && -f informacion_adicional.csv ]] ; then
	rm *.csv && echo 'Removing all CSV files...' || exit 1
fi

# Obtain directory name (remember that the project can be in diferent locations by Apache server)
cd ..
# Concat current directory with the location /backup and assign to var to use in mysql statements
laispath="$(pwd)/backup"
# This is unnecesary, just to return to the original directory
cd scripts
echo '(MySQL) root password is required to export database'

# Finally execute MySQL export to CSV
mysql -u root -p Audiovisuales --verbose << EOF
set names utf8;
# select 'codigo_de_referencia', 'titulo_propio', 'titulo_paralelo', 'titulo_atribuido', 'titulo_de_serie', 'numero_de_programa', 'pais', 'fecha', 'duracion', 'investigacion', 'realizacion', 'direccion', 'guion', 'adaptacion', 'idea_original', 'fotografia', 'fotografia_fija', 'edicion', 'sonido_grabacion', 'sonido_edicion', 'musica_original', 'musicalizacion', 'voces', 'actores', 'animacion', 'otros_colaboradores'
# 	union
select * 
	from area_de_identificacion into outfile '${laispath}/area_de_identificacion.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'entidad_productora', 'productor', 'distribuidora', 'historia_institucional', 'resena_biografica', 'forma_de_ingreso', 'fecha_de_ingreso'
# 	union
select * 
	from area_de_contexto into outfile '${laispath}/area_de_contexto.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'sinopsis', 'descriptor_onomastico', 'descriptor_toponimico', 'descriptor_cronologico', 'tipo_de_produccion', 'genero', 'fuentes', 'recursos', 'versiones', 'formato_original', 'material_extra'
# 	union
select * 
	from area_de_contenido_y_estructura into outfile '${laispath}/area_de_contenido_y_estructura.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'condiciones_de_acceso', 'existencia_y_localizacion_de_originales', 'idioma_original', 'doblajes_disponibles', 'subtitulajes', 'soporte', 'numero_copias', 'descripcion_fisica', 'color', 'audio', 'sistema_de_grabacion', 'region_dvd', 'requisitos_tecnicos'
# 	union
select * 
	from area_de_condiciones_de_acceso into outfile '${laispath}/area_de_condiciones_de_acceso.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'existencia_y_localizacion_de_copias', 'unidades_de_descripcion_relacionadas', 'documentos_asociados'
# 	union
select * 
	from area_de_documentacion_asociada into outfile '${laispath}/area_de_documentacion_asociada.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'area_de_notas'
# 	union
select * 
	from area_de_notas into outfile '${laispath}/area_de_notas.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'notas_del_archivero', 'datos_del_archivero', 'reglas_o_normas', 'fecha_de_descripcion'
# 	union
select * 
	from area_de_descripcion into outfile '${laispath}/area_de_descripcion.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'imagen', 'url', 'fecha_de_modificacion'
# 	union
select * 
	from informacion_adicional into outfile '${laispath}/informacion_adicional.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
# select 'codigo_de_referencia', 'titulo_propio', 'fecha', 'usuario', 'accion'
# 	union
select *
	from registro_actividades into outfile '${laispath}/registro_actividades.csv'
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
EOF

# If MySQL was executed without errors then report the backup and delete data was sucessful
[[ "$?" == 0 ]] && echo -e "CSV files backup created in ../backup" || exit 1