<!DOCTYPE html>
<html>
<body>
<head>
    <title>Sistema de apoyo a la catalogación de archivos audiovisuales</title>

    <meta charset="utf-8"> <!-- Codificación de la página (permite acentos) -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Para uso de diseño responsivo con Bootstrap -->
    
    <!-- Latest compiled and minified CSS (Bootstrap)-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript (Bootstrap)-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<?php
include 'Audiovisual.php'; // Clase para representar un audiovisual
?>

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
			<h1>Editar audiovisual</h1>
		</div>

		<!-- Realizar consulta en la base de acuerdo al id (código de identificación) -->
		<?php
		$select = "SELECT * FROM area_de_identificacion WHERE codigo_de_referencia = '" . $_GET['id'] . "'";
	    $stmt = $conn->prepare($select);
	    $stmt->execute();
	    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
	    // Check if id is in database (for develop purpose only)
	    if ($stmt->rowCount() == 0){
	    	echo '<pre>It not works!</pre>';
	    } else {
	    	echo '<pre>It works!</pre>';
	    	$data = $stmt->fetch(); // Obtener el único resultado de la base de datos
	    	$av = new Audiovisual($data); // Crear el objeto Audiovisual a partir de la información de la base
	    }
		?>

		<!-- El código de identificación es el único campo no-editable -->
		<p>Código de identificación: <input class="form-control" name="codigo_de_referencia" id="codigo_de_referencia" value="<?php echo $_GET['id'];?>" readonly></p>

		<!-- Todos los campos input son por default texto: type="text" -->
		<div class="panel panel-default">
			<div class="panel-heading">Área de identificación</div>
			<div class="panel-body collapse">
				Título propio <input class="form-control" autofocus id="titulo_propio" name="titulo_propio" value="<?php echo (isset($av->titulo_propio)) ? $av->titulo_propio : ''; ?>"><br>
				Título paralelo <input class="form-control" id="titulo_paralelo" name="titulo_paralelo" value="<?php echo (isset($av->titulo_paralelo)) ? $av->titulo_paralelo : ''; ?>"><br>
				Título atribuido <input class="form-control" id="titulo_atribuido" name="titulo_atribuido" value="<?php echo (isset($av->titulo_atribuido)) ? $av->titulo_atribuido : ''; ?>"><br>
				Título de la serie <input class="form-control" id="titulo_de_serie" name="titulo_de_serie" value="<?php echo (isset($av->titulo_de_serie)) ? $av->titulo_de_serie : ''; ?>"><br>
				Número de programa <input class="form-control" id="numero_de_programa" name="numero_de_programa" value="<?php echo (isset($av->numero_de_programa)) ? $av->numero_de_programa : ''; ?>"><br>
				País <input class="form-control" id="pais" name="pais" value="<?php echo (isset($av->pais)) ? $av->pais : ''; ?>"><br>
				Fecha <input class="form-control" id="fecha" name="fecha" type="number" min="1890" max="2019" value="<?php echo (isset($av->fecha)) ? $av->fecha : ''; ?>"><br>
				Duración <input class="form-control" id="duracion" name="duracion" placeholder="HH:MM:SS" value="<?php echo (isset($av->duracion)) ? $av->duracion : ''; ?>"><br>
				Investigación <input class="form-control" id="investigacion" name="investigacion" value="<?php echo (isset($av->investigacion)) ? $av->investigacion : ''; ?>"><br>
				Realización <input class="form-control" id="realizacion" name="realizacion" value="<?php echo (isset($av->realizacion)) ? $av->realizacion : ''; ?>"><br>
				Dirección <input class="form-control" id="direccion" name="direccion" value="<?php echo (isset($av->direccion)) ? $av->direccion : ''; ?>"><br>
				Guión <input class="form-control" id="guion" name="guion" value="<?php echo (isset($av->guion)) ? $av->guion : ''; ?>"><br>
				Adaptación <input class="form-control" id="adaptacion" name="adaptacion" value="<?php echo (isset($av->adaptacion)) ? $av->adaptacion : ''; ?>"><br>
				Idea original <input class="form-control" id="idea_original" name="idea_original" value="<?php echo (isset($av->idea_original)) ? $av->idea_original : ''; ?>"><br>
				Fotografía <input class="form-control" id="fotografia" name="fotografia" value="<?php echo (isset($av->fotografia)) ? $av->fotografia : ''; ?>"><br>
				Fotografía fija <input class="form-control" id="fotografia_fija" name="fotografia_fija" value="<?php echo (isset($av->fotografia_fija)) ? $av->fotografia_fija : ''; ?>"><br>
				Edición <input class="form-control" id="edicion" name="edicion" value="<?php echo (isset($av->edicion)) ? $av->edicion : ''; ?>"><br>
				Grabación de sonido <input class="form-control" id="sonido_grabacion" name="sonido_grabacion" value="<?php echo (isset($av->sonido_grabacion)) ? $av->sonido_grabacion : ''; ?>"><br>
				Edición de sonido <input class="form-control" id="sonido_edicion" name="sonido_edicion" value="<?php echo (isset($av->sonido_edicion)) ? $av->sonido_edicion : ''; ?>"><br>
				Música original <input class="form-control" id="musica_original" name="musica_original" value="<?php echo (isset($av->musica_original)) ? $av->musica_original : ''; ?>"><br>
				Musicalización <input class="form-control" id="musicalizacion" name="musicalizacion" value="<?php echo (isset($av->musicalizacion)) ? $av->musicalizacion : ''; ?>"><br>
				Voces <input class="form-control" id="voces" name="voces" value="<?php echo (isset($av->voces)) ? $av->voces : ''; ?>"><br>
				Actores <input class="form-control" id="actores" name="actores" value="<?php echo (isset($av->actores)) ? $av->actores : ''; ?>"><br>
				Animación <input class="form-control" id="animacion" name="animacion" value="<?php echo (isset($av->animacion)) ? $av->animacion : ''; ?>"><br>
				Otros colaboradores <input class="form-control" id="otros_colaboradores" name="otros_colaboradores" value="<?php echo (isset($av->otros_colaboradores)) ? $av->otros_colaboradores : ''; ?>"><br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de contexto</div>
			<div class="panel-body collapse">
				Entidad productora <input class="form-control" id="entidad_productora" name="entidad_productora"><br>
				Productor <input class="form-control" id="productor" name="productor"><br>
				Distribuidora <input class="form-control" id="distribuidora" name="distribuidora"><br>
				Historia institucional <textarea class="form-control" rows="4" id="historia_institucional" name="historia_institucional"></textarea><br>
				Reseña biográfica <textarea class="form-control" rows="4" id="resena_biografica" name="resena_biografica"></textarea><br>
				Forma de ingreso <input class="form-control" id="forma_de_ingreso" name="forma_de_ingreso" list="formaDeIngreso"><br>
				Fecha de ingreso <input class="form-control" id="fecha_de_ingreso" name="fecha_de_ingreso" type="date"><br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de contenido y estructura</div>
			<div class="panel-body collapse">
				Sinopsis <textarea class="form-control" rows="4" id="sinopsis" name="sinopsis"></textarea><br>
				Descriptor onomástico <input class="form-control" id="descriptor_onomastico" name="descriptor_onomastico"><br>
				Descriptor toponímico <textarea class="form-control" rows="2" id="descriptor_toponimico" name="descriptor_toponimico"></textarea><br>
				Descriptor cronológico <input class="form-control" id="descriptor_cronologico" name="descriptor_cronologico"><br>
				Tipo de producción <input class="form-control" id="tipo_de_produccion" name="tipo_de_produccion" list="tipoDeProduccion"><br>
				Género <input class="form-control" id="genero" name="genero"><br>
				Fuentes <input class="form-control" id="fuentes" name="fuentes" list="fuentesDatalist"><br>
				Recursos <input class="form-control" id="recursos" name="recursos" list="recursosDatalist"><br>
				Versiones <input class="form-control" id="versiones" name="versiones"><br>
				Formato original <input class="form-control" id="formato_original" name="formato_original"><br>
				Material extra <input class="form-control" id="material_extra" name="material_extra"><br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de condiciones de acceso</div>
			<div class="panel-body collapse">
				Condiciones de acceso <input class="form-control" id="condiciones_de_acceso" name="condiciones_de_acceso" list="condicionesDeAcceso"><br>
				Existencia y localizacion de originales <input class="form-control" id="existencia_y_localizacion_de_originales" name="existencia_y_localizacion_de_originales"><br>
				Idioma original <input class="form-control" id="idioma_original" name="idioma_original"><br>
				Doblajes disponibles <input class="form-control" id="doblajes_disponibles" name="doblajes_disponibles"><br>
				Subtitulajes disponibles <input class="form-control" id="subtitulajes" name="subtitulajes"><br>
				Soporte <input class="form-control" id="soporte" name="soporte"><br>
				Número de copias <input class="form-control" id="numero_copias" name="numero_copias" type="number" min="0"><br>
				Descripción física <textarea class="form-control" rows="2" id="descripcion_fisica" name="descripcion_fisica"></textarea><br>
				Color <input class="form-control" id="color" name="color"><br>
				Audio <input class="form-control" id="audio" name="audio"><br>
				Sistema de grabación <input class="form-control" id="sistema_de_grabacion" name="sistema_de_grabacion"><br>
				Región del DVD <input class="form-control" id="region_dvd" name="region_dvd"><br>
				Requisitos técnicos <input class="form-control" id="requisitos_tecnicos" name="requisitos_tecnicos"><br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de documentación asociada</div>
			<div class="panel-body collapse">
				Existencia y localización de copias <input class="form-control" id="existencia_y_localizacion_de_copias" name="existencia_y_localizacion_de_copias"> <br>
				Unidades de descripción relacionadas <textarea class="form-control" rows="2" id="unidades_de_descripcion_relacionadas" name="unidades_de_descripcion_relacionadas"></textarea> <br>
				Documentos asociados <textarea class="form-control" rows="2" id="documentos_asociados" name="documentos_asociados"></textarea> <br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de notas</div>
			<div class="panel-body collapse">
				Área de notas <textarea class="form-control" rows="4" id="area_de_notas" name="area_de_notas"></textarea> <br>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Área de descripción</div>
			<div class="panel-body collapse">
				Notas del archivero <textarea class="form-control" rows="2" id="notas_del_archivero" name="notas_del_archivero"></textarea> <br>
				Datos del archivero <input class="form-control" id="datos_del_archivero" name="datos_del_archivero"> <br>
				Reglas o normas <input class="form-control" id="reglas_o_normas" name="reglas_o_normas"> <br>
				Fecha de descripción <input class="form-control" id="fecha_de_descripcion" name="fecha_de_descripcion" type="date" value="<?php echo date('Y-m-d'); ?>" readonly> <br>
			</div>
		</div>

		<button type="button" class="btn btn-primary">Editar audiovisual</button> 
		<button type="button" class="btn btn-danger">Eliminar audiovisual</button>
	</div>

<!-- Datalists utilizados en los campos -->
<datalist id="formaDeIngreso">
	<option value="Compra">
	<option value="Donación">
	<option value="Producción propia">
</datalist>

<datalist id="tipoDeProduccion">
	<option value="Película de ficción">
	<option value="Película documental">
	<option value="Programa de televisión">
	<option value="Trailer">
	<option value="Publicidad">
	<option value="Propaganda">
	<option value="Registros fílmicos">
	<option value="Registros en video">
	<option value="Extractos de otras producciones">
</datalist>

<datalist id="recursosDatalist">
	<option value="Entrevistas">
	<option value="Grabación de campo">
	<option value="Puesta en escena">
	<option value="Animación">
	<option value="Fotografía">
	<option value="Pintura">
	<option value="Grabados">
	<option value="Cartografía">
	<option value="Testimonios orales">
	<option value="Testimonios video orales">
	<option value="Videoclips">
	<option value="Dibujo">
	<option value="Multimedia">
	<option value="Insidentales">
	<option value="Voz en off">
	<option value="Narración">
	<option value="Conducción">
	<option value="Interactividad">
</datalist>

<datalist id="fuentesDatalist">
	<option value="Animación">
	<option value="Ficción">
	<option value="Documental">
	<option value="Registros fílmicos">
	<option value="Fotografía">
	<option value="Pintura">
	<option value="Otros gráficos">
	<option value="Grabados">
	<option value="Hemerografía">
	<option value="Cartografía">
	<option value="Testimonios orales">
	<option value="Testimonios video orales">
	<option value="Noticieros fílmicos">
	<option value="Programas de TV">
	<option value="Publicidad">
	<option value="Videoclips">
	<option value="Dibujo">
	<option value="Multimedia">
	<option value="Registros fonográficos">
	<option value="Música de época">
	<option value="Documentos">
	<option value="Registros radiofónicos">
	<option value="Registros videográficos">
</datalist>

<datalist id="condicionesDeAcceso">
	<option value="Usos no lucrativos">
	<option value="Usos reservados para consulta in situ">
</datalist>

<!-- jQuery script -->
<script>
$(document).ready(function(){
	// Enable all tooltips in the document
	//$('[data-toggle="tooltip"]').tooltip();
	// Enable all popover in the document
	//$('[data-toggle="popover"]').popover()
	
	// Show all panels heading (development purpose only)
	//$("div.collapse").collapse('show');

	// Show the first panel heading (at least the fist must be showed)
	$("div.collapse").first().collapse('show');

	// Toggle collapse of each panel heading on click
    $(".panel-heading").click(function(){
        $(this).parent(".panel-default").children(".collapse").collapse('toggle');
    });
});
</script>

<!-- Script para agregar ayuda en los campos y hacer 'dropdown' en cada sección -->
<script src="js/popover.js"></script>

</body>
</html>