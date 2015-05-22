<!DOCTYPE html>
<html>
<body>
<head>
    <title>Sistema de apoyo a la catalogación de archivos audiovisuales</title>

    <meta charset="utf-8"> <!-- Codificación de la página (permite acentos) -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Para uso de diseño responsivo con Bootstrap -->
    
    <!-- Latest compiled and minified CSS (Bootstrap)-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
</head>

<body>

	<!-- CONEXION CON LA BASE DE DATOS -->
	<!-- TODO: Encapsular la lógica de la conexión a la base -->
	<?php
	$servername = "localhost";
	$username = "root";
	$password = "advantage7";
	$database = "Coleccion_Archivistica";
	// NOTA: La manipulación a la base de datos se realiza con PDO (PHP Database Object)
	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejo de errores con PDO

	    $conn->exec("SET NAMES utf8"); // Permite mostrar los resultados con acentos y caracteres extraños
	}
	catch(PDOException $e) {
	    echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
	    echo "Error: " . $e->getMessage();
	}
	?>

	<div class="container">
		<div class="page-header">
			<h1>Actualizar audiovisual</h1>
		</div>

		<!-- Realizar consulta en la base de acuerdo al id (código de identificación) -->
		<?php
		$identificacion = "INSERT INTO area_de_identificacion() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['titulo_propio'] . "','" 
			. $_POST['titulo_paralelo'] . "','" 
			. $_POST['titulo_atribuido'] . "','" 
			. $_POST['titulo_de_serie'] . "','"
			. $_POST['numero_de_programa'] . "','"
			. $_POST['pais'] . "','"
			. $_POST['fecha'] . "',"
			. str_replace("'", "", $_POST['duracion']) . ",'"
			. $_POST['investigacion'] . "','"
			. $_POST['realizacion'] . "','"
			. $_POST['direccion'] . "','"
			. $_POST['guion'] . "','"
			. $_POST['adaptacion'] . "','"
			. $_POST['idea_original'] . "','"
			. $_POST['fotografia'] . "','"
			. $_POST['fotografia_fija'] . "','"
			. $_POST['edicion'] . "','"
			. $_POST['sonido_grabacion'] . "','"
			. $_POST['sonido_edicion'] . "','"
			. $_POST['musica_original'] . "','"
			. $_POST['musicalizacion'] . "','"
			. $_POST['voces'] . "','"
			. $_POST['actores'] . "','"
			. $_POST['animacion'] . "','"
			. $_POST['otros_colaboradores']
			. "');";

		$contexto = "INSERT INTO area_de_contexto() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['entidad_productora'] . "','"
			. $_POST['productor'] . "','"
			. $_POST['distribuidora'] . "','"
			. $_POST['historia_institucional'] . "','"
			. $_POST['resena_biografica'] . "','"
			. $_POST['forma_de_ingreso'] . "','"
			. $_POST['fecha_de_ingreso'] 
			. "');";
		
		// Los campos de Fuentes y Recursos son un arreglo con múltiples valores y se utiliza la función
		// implode() para convertir en cadena de texto y delimitando por comas (,) cada valor.
		$contenido = "INSERT INTO area_de_contenido_y_estructura() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['sinopsis'] . "','"
			. $_POST['descriptor_onomastico'] . "','"
			. $_POST['descriptor_toponimico'] . "','"
			. $_POST['descriptor_cronologico'] . "','"
			. $_POST['tipo_de_produccion'] . "','"
			. $_POST['genero'] . "','"
			. implode(", ", $_POST['fuentes']) . "','"
			. implode(", ", $_POST['recursos']) . "','"
			. $_POST['versiones'] . "','"
			. $_POST['formato_original'] . "','"
			. $_POST['material_extra'] 
			. "');";
		
		$condiciones = "INSERT INTO area_de_condiciones_de_acceso() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['condiciones_de_acceso'] . "','"
			. $_POST['existencia_y_localizacion_de_originales'] . "','"
			. $_POST['idioma_original'] . "','"
			. $_POST['doblajes_disponibles'] . "','"
			. $_POST['subtitulajes'] . "','"
			. $_POST['soporte'] . "','"
			. $_POST['numero_copias'] . "','"
			. $_POST['descripcion_fisica'] . "','"
			. $_POST['color'] . "','"
			. $_POST['audio'] . "','"
			. $_POST['sistema_de_grabacion'] . "','"
			. $_POST['region_dvd'] . "','"
			. $_POST['requisitos_tecnicos'] 
			. "');";
		
		$documentacion = "INSERT INTO area_de_documentacion_asociada() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['existencia_y_localizacion_de_copias'] . "','"
			. $_POST['unidades_de_descripcion_relacionadas'] . "','"
			. $_POST['documentos_asociados'] 
			. "');";
		
		$notas = "INSERT INTO area_de_notas() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['area_de_notas'] 
			. "');";

		$descripcion = "INSERT INTO area_de_descripcion() VALUES('"
			. $_POST['codigo_de_referencia'] . "','"
			. $_POST['notas_del_archivero'] . "','"
			. $_POST['datos_del_archivero'] . "','"
			. $_POST['reglas_o_normas'] . "','"
			. $_POST['fecha_de_descripcion'] 
			. "');";

		echo '<pre>' . $identificacion . '</pre>';
		echo '<pre>' . $contexto . '</pre>';
		echo '<pre>' . $contenido . '</pre>';
		echo '<pre>' . $condiciones . '</pre>';
		echo '<pre>' . $documentacion . '</pre>';
		echo '<pre>' . $notas . '</pre>';
		echo '<pre>' . $descripcion . '</pre>';
		
		try{
	    	$conn->exec($identificacion);
	    	$conn->exec($contexto);
	    	$conn->exec($contenido);
	    	$conn->exec($condiciones);
	    	$conn->exec($documentacion);
	    	$conn->exec($notas);
	    	$conn->exec($descripcion);

	    	echo '<div class="alert alert-success" role="alert">New record created successfully</div>';
		}
		catch(PDOException $e){
	    	echo $e->getMessage();
	    }

		$conn = null;
		?>

	</div> <!--Container-->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript (Bootstrap)-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>