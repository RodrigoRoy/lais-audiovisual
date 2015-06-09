// Filtros y funciones auxiliares

/* 
	Parser para cambiar el formato común de notación minutos y segundos para audiovisuales (80'15'')
	en el formato estándar de tiempo de mySQL (1:20:15). Se emplean expresiones regulares.
	
	Recibe como parámetro una cadena de texto con la duración en formato de minutos y segundos.
	Devuelve una cadena en formato estándar de mySQL.
*/
function setDuracion(duracion){
	// Verificar el caso cuando solo son segundos (15'')
	var matches;
	if((matches = /^([0-5]?\d) ?''$/.exec(duracion)) !== null) {
		return matches[1];
	}
	// Verificar el caso para solo minutos (80')
	else if((matches = /^(\d{1,3}) ?'$/.exec(duracion)) !== null) {
		var minutos = parseInt(matches[1]); // Obtener el dígito de los minutos
		if(minutos >= 60){ // En caso de ser necesario, los minutos se convierten en horas
			return parseInt(minutos/60) + ":" + (minutos%60);
		}else{
			return minutos + "00"; // Se agrega 00 por formato de mySQL
		}
	}
	// Verificar el caso incluye minutos y segundos (80'15'') (es análogo al caso anterior)
	else if((matches = /^(\d{1,3}) ?' ?([0-5]?\d) ?''$/.exec(duracion)) !== null){
		var minutos = parseInt(matches[1]); // $matches[1] incluye los minutos y $matches[2] los segundos
		if(minutos >= 60){
			return parseInt(minutos/60) + ":" + minutos%60 + ":" + matches[2];
		}
		else{
			return minutos + matches[2];
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
function getDuracion(duracion){
	var matches;
	if((matches = /^(\d{1,3}):(\d{2}):(\d{2})$/.exec(duracion)) !== null){
		var horas = parseInt(matches[1]);
		var minutos = parseInt(matches[2]);
		var segundos = parseInt(matches[3]);
		// Caso en que solo hay segundos
		if(horas == 0 && minutos == 0){
			if(segundos == 0){ // En caso de que la duración sea por default 00:00:00
				return '';
			}
			return segundos + "''";
		}
		// Caso en que hay minutos (y tal vez segundos)
		else if(horas == 0) {
			if(segundos == 0){ // Si no hay segundos (evita agregar 0 segundos)
				return minutos + "'";
			}
			return minutos + "'" + segundos + "''";
		}
		else{ // Caso más general con horas y minutos (y tal vez segundos)
			if(segundos == 0){ // Si no hay segundos
				return ((horas*60) + minutos) + "'";
			}
			return ((horas*60) + minutos) + "'" + segundos + "''";
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
function setFuenteRecurso(fuenteRecurso){
	if(fuenteRecurso === undefined) // Arreglo no inicializado o vacio
		return '';
	var length = fuenteRecurso.length; // Longitud del arreglo
	if(length == 0) {
		return '';
	}
	else if(length == 1){
		return fuenteRecurso[0];
	}
	else if(length > 1){
		return fuenteRecurso.join(); // Agrega comas (por deafult) y junta en una sola cadena de texto.
	}
	// En caso de parámetro inválido
	return '';
}

/*
	Recibe una cadena de texto con valores separados por comas y devuelve un arreglo con los valores
	Si el texto es vacio, devuelve un arreglo vacio.
	Si solo hay un elemento, devuelve ese elemento (en un arreglo con un solo elemento).
*/
function getFuenteRecurso(fuenteRecurso){
	if(fuenteRecurso === undefined) // Cadenas vacias
		return [];
	else if(fuenteRecurso.length == 0)
		return [];
	return fuenteRecurso.split(",");
}