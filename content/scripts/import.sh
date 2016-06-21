#!/bin/bash
# This script must be executed in /content/scripts
# Import database information from CSV files in directory ../backup/

# First check if directory named backup/ exists, if not then exit
cd ..
if [[ ! -d backup ]] ; then
	echo 'Directory ../backup/ do not exist.'
	exit 1
fi
# Next, check if directory backup/ contains csv files, if not then exit
cd backup
if [[ ! -f area_de_identificacion.csv && ! -f area_de_contexto.csv && ! -f area_de_contenido_y_estructura.csv && ! -f area_de_condiciones_de_acceso.csv && ! -f area_de_documentacion_asociada.csv && ! -f area_de_notas.csv && ! -f area_de_descripcion.csv && ! -f informacion_adicional.csv ]] ; then
	echo 'CSV files in ../backup/ do not exists.'
	exit 1
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
load data infile '${laispath}/area_de_identificacion.csv'
	into table area_de_identificacion
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_contexto.csv'
	into table area_de_contexto
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_contenido_y_estructura.csv'
	into table area_de_contenido_y_estructura
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_condiciones_de_acceso.csv'
	into table area_de_condiciones_de_acceso
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_documentacion_asociada.csv'
	into table area_de_documentacion_asociada
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_notas.csv'
	into table area_de_notas
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/area_de_descripcion.csv'
	into table area_de_descripcion
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/informacion_adicional.csv'
	into table informacion_adicional
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
load data infile '${laispath}/registro_actividades.csv'
	into table registro_actividades
	character set utf8
	fields terminated by ',' optionally enclosed by '"'
	lines terminated by '\n';
EOF

# If MySQL was executed without errors then report the backup and delete data was sucessful
[[ "$?" == 0 ]] && echo -e "Database information import was succeed" || exit 1