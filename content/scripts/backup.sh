#!/bin/bash
# This script must be executed in /content/scripts

# First check if directory named backup/ exists, if not then create it
cd ..
if [[ ! -d backup ]] ; then
	mkdir backup && echo 'Directory ../backup/ created' || exit 1
	chmod +w backup && echo 'Grant write permission to directory ../backup' || exit 1
fi
# Next, check if directory backup/ contains csv files then remove it
cd backup
if [[ -f area_de_identificacion.csv && -f area_de_contexto.csv && -f area_de_contenido_y_estructura.csv && -f area_de_condiciones_de_acceso.csv && -f area_de_documentacion_asociada.csv && -f area_de_notas.csv && -f area_de_descripcion.csv && -f informacion_adicional.csv ]] ; then
	rm *.csv && echo 'Removing all CSV files...' || exit 1
fi
# Finally execute MySQL export from file "export_csv.sql"
cd ../scripts
echo 'root password is required to export database'
# Execute one or another export depending if directory html/ exists (localhost) or not (server)
if [[ -d /var/www/html ]] ; then
	mysql -u root -p Audiovisuales --verbose < export_csv.sql && echo 'CSV files backup created in ../backup' || exit 1
else
	mysql -u root -p Audiovisuales --verbose < export_csv_server.sql && echo 'CSV files backup created in ../backup' || exit 1
fi