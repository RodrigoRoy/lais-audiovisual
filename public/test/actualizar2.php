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
	<?php
	require_once 'conexion.php'; // Conexión a la base de datos
	require_once 'filters.php'; // Filtros y conversiones extras para los campos duracion, fuentes y recursos
	
	// Cambiar al formato correcto en los campos duracion, fuentes y recursos.
	$_POST['duracion'] = setDuracion($_POST['duracion']);
	if(isset($_POST['fuentes'])){
		$_POST['fuentes'] = setFuenteRecurso($_POST['fuentes']);
	}else{
		$_POST['fuentes'] = '';
	}
	if(isset($_POST['recursos'])){
		$_POST['recursos'] = setFuenteRecurso($_POST['recursos']);
	}else{
		$_POST['recursos'] = '';
	}
	?>

	<div class="container">
		<div class="page-header">
			<h1>Actualizar audiovisual</h1>
		</div>

		<!-- Sentencias SQL para la actualización en la base (suponiendo que no se alterará el código de referencia) -->
		<?php
		$identificacion = "UPDATE area_de_identificacion SET "
			. "titulo_propio='" . $_POST['titulo_propio'] . "', " 
			. "titulo_paralelo='" . $_POST['titulo_paralelo'] . "', " 
			. "titulo_atribuido='" . $_POST['titulo_atribuido'] . "', " 
			. "titulo_de_serie='" . $_POST['titulo_de_serie'] . "', "
			. "numero_de_programa='" . $_POST['numero_de_programa'] . "', "
			. "pais='" . $_POST['pais'] . "', "
			. "fecha='" . $_POST['fecha'] . "', "
			. "duracion='" . $_POST['duracion'] . "', "
			. "investigacion='" . $_POST['investigacion'] . "', "
			. "realizacion='" . $_POST['realizacion'] . "', "
			. "direccion='" . $_POST['direccion'] . "', "
			. "guion='" . $_POST['guion'] . "', "
			. "adaptacion='" . $_POST['adaptacion'] . "', "
			. "idea_original='" . $_POST['idea_original'] . "', "
			. "fotografia='" . $_POST['fotografia'] . "', "
			. "fotografia_fija='" . $_POST['fotografia_fija'] . "', "
			. "edicion='" . $_POST['edicion'] . "', "
			. "sonido_grabacion='" . $_POST['sonido_grabacion'] . "', "
			. "sonido_edicion='" . $_POST['sonido_edicion'] . "', "
			. "musica_original='" . $_POST['musica_original'] . "', "
			. "musicalizacion='" . $_POST['musicalizacion'] . "', "
			. "voces='" . $_POST['voces'] . "', "
			. "actores='" . $_POST['actores'] . "', "
			. "animacion='" . $_POST['animacion'] . "', "
			. "otros_colaboradores='" . $_POST['otros_colaboradores']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";
		
		$contexto = "UPDATE area_de_contexto SET "
			. "entidad_productora='" . $_POST['entidad_productora'] . "', "
			. "productor='" . $_POST['productor'] . "', "
			. "distribuidora='" . $_POST['distribuidora'] . "', "
			. "historia_institucional='" . $_POST['historia_institucional'] . "', "
			. "resena_biografica='" . $_POST['resena_biografica'] . "', "
			. "forma_de_ingreso='" . $_POST['forma_de_ingreso'] . "', "
			. "fecha_de_ingreso='" . $_POST['fecha_de_ingreso']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";
		
		$contenido = "UPDATE area_de_contenido_y_estructura SET "
			. "codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "', "
			. "sinopsis='" . $_POST['sinopsis'] . "', "
			. "descriptor_onomastico='" . $_POST['descriptor_onomastico'] . "', "
			. "descriptor_toponimico='" . $_POST['descriptor_toponimico'] . "', "
			. "descriptor_cronologico='" . $_POST['descriptor_cronologico'] . "', "
			. "tipo_de_produccion='" . $_POST['tipo_de_produccion'] . "', "
			. "genero='" . $_POST['genero'] . "', "
			. "fuentes='" . $_POST['fuentes'] . "', "
			. "recursos='" . $_POST['recursos'] . "', "
			. "versiones='" . $_POST['versiones'] . "', "
			. "formato_original='" . $_POST['formato_original'] . "', "
			. "material_extra='" . $_POST['material_extra']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";
		
		$condiciones = "UPDATE area_de_condiciones_de_acceso SET "
			. "codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "', "
			. "condiciones_de_acceso='" . $_POST['condiciones_de_acceso'] . "', "
			. "existencia_y_localizacion_de_originales='" . $_POST['existencia_y_localizacion_de_originales'] . "', "
			. "idioma_original='" . $_POST['idioma_original'] . "', "
			. "doblajes_disponibles='" . $_POST['doblajes_disponibles'] . "', "
			. "subtitulajes='" . $_POST['subtitulajes'] . "', "
			. "soporte='" . $_POST['soporte'] . "', "
			. "numero_copias='" . $_POST['numero_copias'] . "', "
			. "descripcion_fisica='" . $_POST['descripcion_fisica'] . "', "
			. "color='" . $_POST['color'] . "', "
			. "audio='" . $_POST['audio'] . "', "
			. "sistema_de_grabacion='" . $_POST['sistema_de_grabacion'] . "', "
			. "region_dvd='" . $_POST['region_dvd'] . "', "
			. "requisitos_tecnicos='" . $_POST['requisitos_tecnicos']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";
		
		$documentacion = "UPDATE area_de_documentacion_asociada SET "
			. "codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "', "
			. "existencia_y_localizacion_de_copias='" . $_POST['existencia_y_localizacion_de_copias'] . "', "
			. "unidades_de_descripcion_relacionadas='" . $_POST['unidades_de_descripcion_relacionadas'] . "', "
			. "documentos_asociados='" . $_POST['documentos_asociados']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";
		
		$notas = "UPDATE area_de_notas SET "
			. "codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "', "
			. "area_de_notas='" . $_POST['area_de_notas']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";

		$descripcion = "UPDATE area_de_descripcion SET "
			. "codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "', "
			. "notas_del_archivero='" . $_POST['notas_del_archivero'] . "', "
			. "datos_del_archivero='" . $_POST['datos_del_archivero'] . "', "
			. "reglas_o_normas='" . $_POST['reglas_o_normas'] . "', "
			. "fecha_de_descripcion='" . $_POST['fecha_de_descripcion']
			. "' WHERE codigo_de_referencia='" . $_POST['codigo_de_referencia'] . "'";

		// Mostrar en página las consultas realizadas (para revisar sintáxis)
		/*echo '<pre>' . $identificacion . '</pre>';
		echo '<pre>' . $contexto . '</pre>';
		echo '<pre>' . $contenido . '</pre>';
		echo '<pre>' . $condiciones . '</pre>';
		echo '<pre>' . $documentacion . '</pre>';
		echo '<pre>' . $notas . '</pre>';
		echo '<pre>' . $descripcion . '</pre>';*/
		
		try{ // Realizar las llamadas de actualización a la base de datos
			// Prepare statement and execute the query
    		$stmt = $conn->prepare($identificacion);
	    	$stmt->execute();
	    	$stmt = $conn->prepare($contexto);
	    	$stmt->execute();
			$stmt = $conn->prepare($contenido);
	    	$stmt->execute();
	    	$stmt = $conn->prepare($condiciones);
	    	$stmt->execute();
	    	$stmt = $conn->prepare($documentacion);
	    	$stmt->execute();
	    	$stmt = $conn->prepare($notas);
	    	$stmt->execute();
	    	$stmt = $conn->prepare($descripcion);
	    	$stmt->execute();
	    	// Si todo está correcto, mostrar mensaje exitoso
	    	echo '<div class="alert alert-success" role="alert"><p>Record updated successfully</p><p>View the record <a href="vista.php?id=' 
	    	. $_POST['codigo_de_referencia'] . '">here</a></p></div>';
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