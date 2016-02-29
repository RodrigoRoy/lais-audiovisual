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
# Finally execute MySQL import from file "insert_backup.sql"
cd ../scripts
echo '(MySQL) root password is required to import database'
# Execute one or another export depending if directory html/ exists (localhost) or not (server)
if [[ -d /var/www/html ]] ; then
	mysql -u root -p Audiovisuales --verbose < insert_backup.sql && echo 'Database information import was succeed' || exit 1
else
	mysql -u root -p Audiovisuales --verbose < insert_backup_server.sql && echo 'Database information import was succeed' || exit 1
fi