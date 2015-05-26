<?php
# Filtros y funciones auxiliares

/* 
	Parser para cambiar el formato común de notación minutos y segundos para audiovisuales (80'15'')
	en el formato estándar de tiempo de mySQL (1:20:15). Se emplean expresiones regulares.
	
	Recibe como parámetro una cadena de texto con la duración en formato de minutos y segundos.
	Devuelve una cadena en formato estándar de mySQL.
*/
function setDuracion($duracion){
	// Verificar el caso cuando solo son segundos (15'')
	if(preg_match("/^([0-5]?\d) ?''$/", $duracion, $matches)){
		return $matches[1]; // Devuelve el mismo número sin apóstrofes
	}
	// Verificar el caso para solo minutos (80')
	elseif(preg_match("/^(\d{1,3}) ?'$/", $duracion, $matches)){
		$minutos = (int) $matches[1]; // Obtener el dígito de los minutos
		if($minutos >= 60){ // En caso de ser necesario, los minutos se convierten en horas.
			return (int) ($minutos/60) . ':' . $minutos%60;
		}else{
			return $minutos . '00'; // Se agrega 00 por formato de mySQL
		}
	}
	// Verificar el caso incluye minutos y segundos (80'15'') (es análogo al caso anterior)
	elseif(preg_match("/^(\d{1,3}) ?' ?([0-5]?\d) ?''$/", $duracion, $matches)){
		$minutos = (int) $matches[1]; // $matches[1] incluye los minutos y $matches[2] los segundos
		if($minutos >= 60){
			return (int) ($minutos/60) . ':' . $minutos%60 . ':' . $matches[2];
		}
		else{
			return $minutos . $matches[2];
		}
	}
	// En caso de ser un texto con sintaxis inválida
	return 0;
}

/* 
	Parser para cambiar el formato estándar de tiempo de mySQL (1:20:15) al
	formato común de notación minutos y segundos para audiovisuales (80'15'').
	
	Recibe como parámetro una cadena en formato estándar de mySQL.
	Devuelve una cadena de texto con la duración en formato de minutos y segundos.
*/
function getDuracion($duracion){
	if(preg_match("/^(\d{1,3}):(\d{2}):(\d{2})$/", $duracion, $matches)){
		$horas = (int) $matches[1];
		$minutos = (int) $matches[2];
		$segundos = (int) $matches[3];
		// Caso en que solo hay segundos
		if($horas == 0 && $minutos == 0){
			if($segundos == 0){ // En caso de que la duración sea por default 00:00:00
				return '';
			}
			return $segundos . "''";
		}
		// Caso en que hay minutos (y tal vez segundos)
		elseif ($horas == 0) {
			if($segundos == 0){ // Si no hay segundos (evita agregar 0 segundos)
				return $minutos . "'";
			}
			return $minutos . "'" . $segundos . "''";
		}
		else{ // Caso más general con horas y minutos (y tal vez segundos)
			if($segundos == 0){ // Si no hay segundos
				return (($horas*60) + $minutos) . "'";
			}
			return (($horas*60) + $minutos) . "'" . $segundos . "''";
		}
	}
	// Si la sintaxís de la duración es inválida devuelve la cadena vacia
	return '';
}

/*
	Recibe un arreglo de textos y devuelve una única cadena de texto separando con comas.
	Si el arreglo es vacio, devuelve la cadena vacia.
	Si solo hay un elemento, devuelve ese elemento (única cadena de texto).
*/
function setFuenteRecurso($fuenteRecurso){
	$length = count($fuenteRecurso); // Longitud del arreglo
	if($length == 0) {
		return '';
	}
	elseif ($length == 1) {
		return $fuenteRecurso[0];
	}
	elseif ($length > 1) {
		return implode(", ", $fuenteRecurso); // Agrega comas y junta en una sola cadena de texto.
	}
	// En caso de parámetro inválido
	return '';
	
}

/*
	Recibe una cadena de texto con valores separados por comas y devuelve un arreglo con los valores
	Si el texto es vacio, devuelve un arreglo vacio.
	Si solo hay un elemento, devuelve ese elemento (en un arreglo con un solo elemento).
*/
function getFuenteRecurso($fuenteRecurso){
	return explode(', ', $fuenteRecurso);
}

#### Pruebas para setDuracion()
/*$test = array("120'", "38'50''", "121'30''", "49''", "123 min.");
echo 'Pruebas para conversion de duracion <br>';
for($i=0; $i<count($test); $i++) {
	echo $test[$i] . " = " . setDuracion($test[$i]);
	echo '<br>';
}
#### Pruebas para setFuentesRecurso()
$test2 = array(
	array("Puesta en escena", "Fotografia", "Pintura"),
	array("Animacion", "Ficcion"),
	array("Videoclips"),
	array(),
	array("Documental", "Registros filmicos", "Pintura", "Otros graficos")
);
echo '<br><br>Pruebas para textos como arreglos de string<br>';
//print_r($test2);
foreach ($test2 as $arr) {
	print_r($arr);
	echo '===>' . setFuenteRecurso($arr);
	echo '<br>';
}
#### Pruebas para getDuracion()
$test = array("02:00:00", "00:38:50", "00:26:00", "02:01:30", "00:00:49", "123 min.");
echo 'Pruebas para conversion de duracion <br>';
for($i=0; $i<count($test); $i++) {
	echo $test[$i] . " = " . getDuracion($test[$i]);
	echo '<br>';
}
#### Pruebas para getFuenteRecurso()
$fuentes = "Animación, Ficción, Documental, Fotografía, Otros gráficos";
$recursos = "Entrevistas, Puesta en escena, Animación, Fotografía";
$fuentes_array = getFuenteRecurso($fuentes);
$recursos_array = getFuenteRecurso($recursos);
echo print_r($fuentes_array);
echo '<br>';
echo print_r($recursos_array);
echo '<br>';*/
?>