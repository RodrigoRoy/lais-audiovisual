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
	<div class="container">
		<div class="page-header">
			<h1>Agregar audiovisual</h1>
		</div>

		<form role="form" id="audiovisualForm" method="POST" data-toggle="validator" action="agregar2.php"> <!-- Se omite action="another.php" para que la acción se ejecute en este documento -->

			<!-- El código de identificación es el único campo no-editable -->
			<div class="form-group">
				<label for="codigo_de_referencia">Código de identificación:</label>
				<input class="form-control" name="codigo_de_referencia" id="codigo_de_referencia" value="<?php echo $_GET['id'];?>" maxlength="20" pattern="^\w{3,5}-\w{1,3}-\d{1,2}-\d{1,2}-\d{1,4}$" data-error="El formato debe ser similar a: MXIM-AV-1-8-1"> <!--readonly-->
			</div>

			<!-- Todos los campos input son por default texto: type="text" -->
			<div class="panel panel-default">
				<div class="panel-heading">Área de identificación</div>
				<div class="panel-body collapse">
					<div class="form-group control-group">
						<label for="titulo_propio">Título propio</label>
						<input class="form-control" autofocus id="titulo_propio" name="titulo_propio" maxlength="120">
					</div>
					<div class="form-group control-group">
						<label for="titulo_paralelo">Título paralelo</label>
						<input class="form-control" id="titulo_paralelo" name="titulo_paralelo" maxlength="120">
					</div>
					<div class="form-group control-group">
						<label for="titulo_atribuido">Título atribuido</label>
						<input class="form-control" id="titulo_atribuido" name="titulo_atribuido" maxlength="120">
					</div>
					<div class="form-group">
						<label for="titulo_de_serie">Título de la serie</label>
						<input class="form-control" id="titulo_de_serie" name="titulo_de_serie" maxlength="70">
					</div>
					<div class="form-group">
						<label for="numero_de_programa">Número de programa</label>
						<input class="form-control" id="numero_de_programa" name="numero_de_programa" maxlength="15">
					</div>
					<div class="form-group">
						<label for="pais">País</label>
						<input class="form-control" id="pais" name="pais" maxlength="30">
					</div>
					<div class="form-group">
						<label for="fecha">Fecha</label>
						<input class="form-control" id="fecha" name="fecha" maxlength="12" pattern="\d{1,4}( ?- ?\d{1,4})?">
					</div>
					<div class="form-group">
						<label for="duracion">Duración</label>
						<input class="form-control" id="duracion" name="duracion" placeholder="Formato: MM'SS' (Ejemplo: 120', 38'60'', 49'')" pattern="(\d{0,3}' ?[0-5]?\d'')|(\d{0,3}')|([0-5]?\d'')" data-error="Formato incorrecto. Utiliza el símbolo de apóstrofe ( ' ) para indicar horas y minutos.">
					</div>
					<div class="form-group">
						<label for="investigacion">Investigación</label>
						<input class="form-control" id="investigacion" name="investigacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="realizacion">Realización</label>
						<input class="form-control" id="realizacion" name="realizacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="direccion">Dirección</label>
						<input class="form-control" id="direccion" name="direccion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="guion">Guión</label>
						<input class="form-control" id="guion" name="guion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="adaptacion">Adaptación</label>
						<input class="form-control" id="adaptacion" name="adaptacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="idea_original">Idea original</label>
						<input class="form-control" id="idea_original" name="idea_original" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="fotografia">Fotografía</label>
						<input class="form-control" id="fotografia" name="fotografia" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="fotografia_fija">Fotografía fija</label>
						<input class="form-control" id="fotografia_fija" name="fotografia_fija" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="edicion">Edición</label>
						<input class="form-control" id="edicion" name="edicion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="sonido_grabacion">Grabación de sonido</label>
						<input class="form-control" id="sonido_grabacion" name="sonido_grabacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="sonido_edicion">Edición de sonido</label>
						<input class="form-control" id="sonido_edicion" name="sonido_edicion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="musica_original">Música original</label>
						<input class="form-control" id="musica_original" name="musica_original" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="musicalizacion">Musicalización</label>
						<input class="form-control" id="musicalizacion" name="musicalizacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="voces">Voces</label>
						<input class="form-control" id="voces" name="voces" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="actores">Actores</label>
						<input class="form-control" id="actores" name="actores" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="animacion">Animación</label>
						<input class="form-control" id="animacion" name="animacion" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="otros_colaboradores">Otros colaboradores</label>
						<input class="form-control" id="otros_colaboradores" name="otros_colaboradores" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de contexto</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="entidad_productora">Entidad productora</label>
						<input class="form-control" id="entidad_productora" name="entidad_productora" maxlength="250" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="productor">Productor</label>
						<input class="form-control" id="productor" name="productor" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="distribuidora">Distribuidora</label>
						<input class="form-control" id="distribuidora" name="distribuidora" maxlength="160" pattern="^[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+(,[ÀÈÌÒÙàèìòùÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÃÑÕãñõÄËÏÖÜŸäëïöüŸçÇ\w\s-'.:()\/]+)*$" data-error="Solo se permiten nombres válidos (separados por comas en caso de ser varios)">
					</div>
					<div class="form-group">
						<label for="historia_institucional">Historia institucional</label>
						<textarea class="form-control" rows="4" id="historia_institucional" name="historia_institucional"></textarea>
					</div>
					<div class="form-group">
						<label for="resena_biografica">Reseña biográfica</label>
						<textarea class="form-control" rows="4" id="resena_biografica" name="resena_biografica"></textarea>
					</div>
					<div class="form-group">
						<label for="forma_de_ingreso">Forma de ingreso</label>
						<input class="form-control" id="forma_de_ingreso" name="forma_de_ingreso" list="formaDeIngreso" maxlength="35">
					</div>
					<div class="form-group">
						<label for="fecha_de_ingreso">Fecha de ingreso</label>
						<input class="form-control" id="fecha_de_ingreso" name="fecha_de_ingreso" maxlength="12" pattern="([0-3]?\d ?\/ ?[01]?\d ?\/ ?)?\d{4}" data-error="Incluye el año de ingreso o la fecha completa separada por guiones (Ej: 15/3/1991)">
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de contenido y estructura</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="sinopsis">Sinopsis</label>
						<textarea class="form-control" rows="4" id="sinopsis" name="sinopsis"></textarea>
					</div>
					<div class="form-group">
						<label for="descriptor_onomastico">Descriptor onomástico</label>
						<input class="form-control" id="descriptor_onomastico" name="descriptor_onomastico">
					</div>
					<div class="form-group">
						<label for="descriptor_toponimico">Descriptor toponímico</label>
						<textarea class="form-control" rows="2" id="descriptor_toponimico" name="descriptor_toponimico"></textarea>
					</div>
					<div class="form-group">
						<label for="descriptor_cronologico">Descriptor cronológico</label>
						<input class="form-control" id="descriptor_cronologico" name="descriptor_cronologico">
					</div>
					<div class="form-group">
						<label for="tipo_de_produccion">Tipo de producción</label>
						<input class="form-control" id="tipo_de_produccion" name="tipo_de_produccion" list="tipoDeProduccion" maxlength="31">
					</div>
					<div class="form-group">
						<label for="genero">Género</label>
						<input class="form-control" id="genero" name="genero" maxlength="30">
					</div>
					<div class="form-group">
						<label for="fuentes">Fuentes</label>
						<select class="form-control select-toggle" id="fuentes" name="fuentes[]" size="12" multiple>
							<option value="Animación">Animación</option>
							<option value="Ficción">Ficción</option>
							<option value="Documental">Documental</option>
							<option value="Registros fílmicos">Registros fílmicos</option>
							<option value="Fotografía">Fotografía</option>
							<option value="Pintura">Pintura</option>
							<option value="Otros gráficos">Otros gráficos</option>
							<option value="Grabados">Grabados</option>
							<option value="Hemerografía">Hemerografía</option>
							<option value="Cartografía">Cartografía</option>
							<option value="Testimonios orales">Testimonios orales</option>
							<option value="Testimonios video orales">Testimonios video orales</option>
							<option value="Noticieros fílmicos">Noticieros fílmicos</option>
							<option value="Programas de TV">Programas de TV</option>
							<option value="Publicidad">Publicidad</option>
							<option value="Videoclips">Videoclips</option>
							<option value="Dibujo">Dibujo</option>
							<option value="Multimedia">Multimedia</option>
							<option value="Registros fonográficos">Registros fonográficos</option>
							<option value="Música de época">Música de época</option>
							<option value="Documentos">Documentos</option>
							<option value="Registros radiofónicos">Registros radiofónicos</option>
							<option value="Registros videográficos">Registros videográficos</option>
						</select>
					</div>
					<div class="form-group">
						<label for="recursos">Recursos</label>
						<select class="form-control select-toggle" id="recursos" name="recursos[]" size="12" multiple>
							<option value="Entrevistas">Entrevistas</option>
							<option value="Grabación de campo">Grabación de campo</option>
							<option value="Puesta en escena">Puesta en escena</option>
							<option value="Animación">Animación</option>
							<option value="Fotografía">Fotografía</option>
							<option value="Pintura">Pintura</option>
							<option value="Grabados">Grabados</option>
							<option value="Cartografía">Cartografía</option>
							<option value="Testimonios orales">Testimonios orales</option>
							<option value="Testimonios video orales">Testimonios video orales</option>
							<option value="Videoclips">Videoclips</option>
							<option value="Dibujo">Dibujo</option>
							<option value="Multimedia">Multimedia</option>
							<option value="Insidentales">Insidentales</option>
							<option value="Voz en off">Voz en off</option>
							<option value="Narración">Narración</option>
							<option value="Conducción">Conducción</option>
							<option value="Interactividad">Interactividad</option>
						</select>
					</div>
					<div class="form-group">
						<label for="versiones">Versiones</label>
						<input class="form-control" id="versiones" name="versiones" maxlength="45">
					</div>
					<div class="form-group">
						<label for="formato_original">Formato original</label>
						<input class="form-control" id="formato_original" name="formato_original" maxlength="25">
					</div>
					<div class="form-group">
						<label for="material_extra">Material extra</label>
						<input class="form-control" id="material_extra" name="material_extra" maxlength="30">
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de condiciones de acceso</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="condiciones_de_acceso">Condiciones de acceso</label>
						<input class="form-control" id="condiciones_de_acceso" name="condiciones_de_acceso" list="condicionesDeAcceso" maxlength="37">
					</div>
					<div class="form-group">
						<label for="existencia_y_localizacion_de_originales">Existencia y localizacion de originales</label>
						<textarea class="form-control" rows="2" id="existencia_y_localizacion_de_originales" name="existencia_y_localizacion_de_originales"></textarea>
					</div>
					<div class="form-group">
						<label for="idioma_original">Idioma original</label>
						<input class="form-control" id="idioma_original" name="idioma_original" maxlength="40">
					</div>
					<div class="form-group">
						<label for="doblajes_disponibles">Doblajes disponibles</label>
						<input class="form-control" id="doblajes_disponibles" name="doblajes_disponibles" maxlength="40">
					</div>
					<div class="form-group">
						<label for="subtitulajes">Subtitulajes disponibles</label>
						<input class="form-control" id="subtitulajes" name="subtitulajes" maxlength="40">
					</div>
					<div class="form-group">
						<label for="soporte">Soporte</label>
						<input class="form-control" id="soporte" name="soporte" maxlength="40">
					</div>
					<div class="form-group">
						<label for="numero_copias">Número de copias</label>
						<input class="form-control" id="numero_copias" name="numero_copias" maxlength="40">
					</div>
					<div class="form-group">
						<label for="descripcion_fisica">Descripción física</label>
						<textarea class="form-control" rows="2" id="descripcion_fisica" name="descripcion_fisica" maxlength="60"></textarea>
					</div>
					<div class="form-group">
						<label for="color">Color</label>
						<input class="form-control" id="color" name="color" maxlength="80">
					</div>
					<div class="form-group">
						<label for="audio">Audio</label>
						<input class="form-control" id="audio" name="audio" maxlength="30">
					</div>
					<div class="form-group">
						<label for="sistema_de_grabacion">Sistema de grabación</label>
						<input class="form-control" id="sistema_de_grabacion" name="sistema_de_grabacion" maxlength="10">
					</div>
					<div class="form-group">
						<label for="region_dvd">Región del DVD</label>
						<input class="form-control" id="region_dvd" name="region_dvd" maxlength="20">
					</div>
					<div class="form-group">
						<label for="requisitos_tecnicos">Requisitos técnicos</label>
						<input class="form-control" id="requisitos_tecnicos" name="requisitos_tecnicos" maxlength="40">
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de documentación asociada</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="existencia_y_localizacion_de_copias">Existencia y localización de copias</label>
						<input class="form-control" id="existencia_y_localizacion_de_copias" name="existencia_y_localizacion_de_copias">
					</div>
					<div class="form-group">
						<label for="unidades_de_descripcion_relacionadas">Unidades de descripción relacionadas</label>
						<textarea class="form-control" rows="2" id="unidades_de_descripcion_relacionadas" name="unidades_de_descripcion_relacionadas"></textarea>
					</div>
					<div class="form-group">
						<label for="documentos_asociados">Documentos asociados</label>
						<textarea class="form-control" rows="2" id="documentos_asociados" name="documentos_asociados"></textarea>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de notas</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="area_de_notas">Área de notas</label>
						<textarea class="form-control" rows="4" id="area_de_notas" name="area_de_notas"></textarea>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Área de descripción</div>
				<div class="panel-body collapse">
					<div class="form-group">
						<label for="notas_del_archivero">Notas del archivero</label>
						<textarea class="form-control" rows="2" id="notas_del_archivero" name="notas_del_archivero" maxlength="75"></textarea>
					</div>
					<div class="form-group">
						<label for="datos_del_archivero">Datos del archivero</label>
						<input class="form-control" id="datos_del_archivero" name="datos_del_archivero" maxlength="60">
					</div>
					<div class="form-group">
						<label for="reglas_o_normas">Reglas o normas</label>
						<input class="form-control" id="reglas_o_normas" name="reglas_o_normas" maxlength="31">
					</div>
					<div class="form-group">
						<label for="fecha_de_descripcion">Fecha de descripción</label>
						<input class="form-control" id="fecha_de_descripcion" name="fecha_de_descripcion" type="date" readonly>
					</div>
				</div>
			</div>

			<button type="submit" class="btn btn-default">Enviar</button> 
		</form>
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

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript (Bootstrap)-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!-- Script para colpsar/mostrar cada panel/sección del formulario -->
<script src="../js/collapse-panel.js"></script>

<!-- Script para agregar ayuda en los campos del formulario -->
<script src="../js/popover.js"></script>

<!-- (Bootstrap) Form Validator
Se añade data-toggle="validator" a la etiqueta <form> para habilitar las validaciones
Se requiere agregar <div class="help-block with-errors"></div> después de cada input/textarea del formulario -->
<script src="../js/validator.min.js"></script>

<script>
$('.select-toggle').each(function(){    
    var select = $(this), values = {};    
    $('option',select).each(function(i, option){
        values[option.value] = option.selected;        
    }).click(function(event){        
        values[this.value] = !values[this.value];
        $('option',select).each(function(i, option){            
            option.selected = values[option.value];        
        });
    });
});
</script>

</body>
</html>