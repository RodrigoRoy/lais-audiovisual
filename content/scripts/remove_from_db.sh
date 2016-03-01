#!/bin/bash
# This script must be executed in /content/scripts
# Create single (content/documentary) backup information to CSV files in directory ../removed/

# Check if exists codigo_de_referencia as argument
if [[ ! "$#" == 1 ]]; then
	echo 'Please specify only <codigo_de_referencia> of the documentary in arguments. Example:'
	echo '$ ./remove_from_db.sh MXIM-AV-1-12-131'
	exit 1
fi
codigo="$1" # codigo_de_referencia from documental

# $laispath contains the path from saving the removed data documentary depending if directory /var/www/html exists (localhost) or not (server)
[[ -d /var/www/html ]] && laispath=/var/www/html/lais-audiovisual || laispath=/var/www/lais-audiovisual

cd ..
# If directory ../removed/ not exists then create it
if [[ ! -d removed ]] ; then
	mkdir removed && echo 'Directory ../removed/ created' || exit 1
	chmod a+w removed && echo 'Grant write permission to directory ../removed' || exit 1
fi

cd removed
# If files csv from the same codigo_de_referencia exists ask for overwrite them
if [[ -f "${codigo}_area_de_identificacion.csv" && -f "${codigo}_area_de_contexto.csv" && -f "${codigo}_area_de_contenido_y_estructura.csv" && -f "${codigo}_area_de_condiciones_de_acceso.csv" && -f "${codigo}_area_de_documentacion_asociada.csv" && -f "${codigo}_area_de_notas.csv" && -f "${codigo}_area_de_descripcion.csv" && -f "${codigo}_informacion_adicional.csv" ]] ; then
	read -p "Backup already exists, overwrite it? (y/n): " overwrite
	if [[ "$overwrite" == 'y' || "$overwrite" == 'Y' ]] ; then
		for file in ${codigo}*.csv ; do
			rm $file
			echo "$file deleted"
		done
	else
		echo 'Backup not created.'
		exit 0
	fi
fi

# Execute SQL statements for export the data with codigo_de_referencia = $codigo and delete from data base
echo '(MySQL) root password is required to export database'
mysql -u root -p Audiovisuales --verbose << EOF
set names utf8;
select * 
	from area_de_identificacion
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_identificacion.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_contexto
	where codigo_de_referencia = "$codigo" 
	into outfile "${laispath}/content/removed/${codigo}_area_de_contexto.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_contenido_y_estructura
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_contenido_y_estructura.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_condiciones_de_acceso
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_condiciones_de_acceso.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_documentacion_asociada
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_documentacion_asociada.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_notas
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_notas.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from area_de_descripcion
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_area_de_descripcion.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
select * 
	from informacion_adicional
	where codigo_de_referencia = "$codigo"
	into outfile "${laispath}/content/removed/${codigo}_informacion_adicional.csv"
		character set utf8
		fields terminated by ',' optionally enclosed by '"'
		lines terminated by '\n';
delete from area_de_identificacion where codigo_de_referencia = "$codigo";
EOF

# If MySQL was executed without errors then report the backup and delete data was sucessful
[[ "$?" == 0 ]] && echo -e "Backup of $codigo created in ../backup \n$codigo deleted from database" || exit 1