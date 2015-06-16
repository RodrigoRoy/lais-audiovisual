var lais = angular.module('lais',['ngRoute']);

lais.config(function ($routeProvider, $locationProvider){
	//console.log("Ruteando");
	$routeProvider
		.when("/",{
			templateUrl: "templates/inicio.html"
		})
		.when("/inicio",{
			templateUrl: "templates/inicio.html"
		})
		.when("/acercade",{
			templateUrl: "templates/acerca_del_sitio.html"
			
		})
		.when("/archivos",{
			templateUrl: "templates/archivos_audiovisuales.html",
			controller: "conexionCtrl"
		})
		.when("/archivos/agregarArchivo",{
			templateUrl: "templates/agregarArchivo.html",
			controller: "agregarDatosCtrl"
		})
		.when("/archivos/editarArchivo/:id",{
			templateUrl: "templates/editarArchivo.html",
			controller: "edicionCtrl"
		})
		.when("/archivos/busqueda/:query",{
			templateUrl: "templates/buscarRegistros.html",
			controller: "busquedaCtrl"
		})
		.otherwise({
			redirectTo: "/"
		});
});

//Controlador que muestra los datos en el html, con la conexion a la base de datos
lais.controller('conexionCtrl', function($scope, $http, $location){
	$http.get('php/manejoBD.php?action=ver').
    success(function(data) {
        $scope.registros = data;
    });

    $scope.editar = function(id){
    	$location.url('/archivos/editarArchivo/' + id);
    }

    $scope.eliminar = function(id){
    	$http.post('php/manejoBD.php?action=borrar',
		{
			'codigo_de_referencia': id
		}).
		success(function(data, status, headers, config) {
			alert("Registro eliminado");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error al borrar usuario");
		});
    }
});

lais.controller('edicionCtrl', function($scope, $http, $routeParams, $location){
	$http.get('php/manejoBD.php?action=obtener&id=' + $routeParams.id).
    success(function(data) {
        $scope.codigo_de_referencia = data.codigo_de_referencia;
		$scope.titulo_propio = data.titulo_propio;
		$scope.titulo_paralelo = data.titulo_paralelo;
		$scope.titulo_atribuido = data.titulo_atribuido;
		$scope.titulo_de_serie = data.titulo_de_serie;
		$scope.numero_de_programa = data.numero_de_programa;
		$scope.pais = data.pais;
		$scope.fecha = data.fecha;
		$scope.duracion = getDuracion(data.duracion); // Parse desde filter.js
		$scope.investigacion = data.investigacion;
		$scope.realizacion = data.realizacion;
		$scope.direccion = data.direccion;
		$scope.guion = data.guion;
		$scope.adaptacion = data.adaptacion;
		$scope.idea_original = data.idea_original;
		$scope.fotografia = data.fotografia;
		$scope.fotografia_fija = data.fotografia_fija;
		$scope.edicion = data.edicion;
		$scope.sonido_grabacion = data.sonido_grabacion;
		$scope.sonido_edicion = data.sonido_edicion;
		$scope.musica_original = data.musica_original;
		$scope.musicalizacion = data.musicalizacion;
		$scope.voces = data.voces;
		$scope.actores = data.actores;
		$scope.animacion = data.animacion;
		$scope.otros_colaboradores = data.otros_colaboradores;
		$scope.entidad_productora = data.entidad_productora;
		$scope.productor = data.productor;
		$scope.distribuidora = data.distribuidora;
		$scope.historia_institucional = data.historia_institucional;
		$scope.resena_biografica = data.resena_biografica;
		$scope.forma_de_ingreso = data.forma_de_ingreso;
		$scope.fecha_de_ingreso = data.fecha_de_ingreso;
		$scope.sinopsis = data.sinopsis;
		$scope.descriptor_onomastico = data.descriptor_onomastico;
		$scope.descriptor_toponimico = data.descriptor_toponimico;
		$scope.descriptor_cronologico = data.descriptor_cronologico;
		$scope.tipo_de_produccion = data.tipo_de_produccion;
		$scope.genero = data.genero;
		$scope.fuentes = getFuenteRecurso(data.fuentes); // Parse desde filter.js
		$scope.recursos = getFuenteRecurso(data.recursos); // Parse desde filter.js
		$scope.versiones = data.versiones;
		$scope.formato_original = data.formato_original;
		$scope.material_extra = data.material_extra;
		$scope.condiciones_de_acceso = data.condiciones_de_acceso;
		$scope.existencia_y_localizacion_de_originales = data.existencia_y_localizacion_de_originales;
		$scope.idioma_original = data.idioma_original;
		$scope.doblajes_disponibles = data.doblajes_disponibles;
		$scope.subtitulajes = data.subtitulajes;
		$scope.soporte = data.soporte;
		$scope.numero_copias = data.numero_copias;
		$scope.descripcion_fisica = data.descripcion_fisica;
		$scope.color = data.color;
		$scope.audio = data.audio;
		$scope.sistema_de_grabacion = data.sistema_de_grabacion;
		$scope.region_dvd = data.region_dvd;
		$scope.requisitos_tecnicos = data.requisitos_tecnicos;
		$scope.existencia_y_localizacion_de_copias = data.existencia_y_localizacion_de_copias;
		$scope.unidades_de_descripcion_relacionadas = data.unidades_de_descripcion_relacionadas;
		$scope.documentos_asociados = data.documentos_asociados;
		$scope.area_de_notas = data.area_de_notas;
		$scope.notas_del_archivero = data.notas_del_archivero;
		$scope.datos_del_archivero = data.datos_del_archivero;
		$scope.reglas_o_normas = data.reglas_o_normas;
		$scope.fecha_de_descripcion = data.fecha_de_descripcion;
    });

	$scope.editar = function(){
    	$http.post('php/manejoBD.php?action=actualizar',
    		scopeData2object($scope)
		).
		success(function(data, status, headers, config) {
			alert("Registro actualizado");
			// Enviar al usuario a los audiovisuales
			$location.url('/archivos/');
		}).
		error(function(data, status, headers, config) {
			alert("Error al editar usuario");
		});
    }
});

//Controlador que hace post para agregar datos a la base de datos y recupera los datos desde el html
lais.controller('agregarDatosCtrl',function($scope, $http, $location){
	$scope.envia = function(){
		$http.post('php/manejoBD.php?action=agregar', 
				scopeData2object($scope)
			).success(function(data,status, headers, congif){
			alert("El archivo Audiovisual ha sido agregado");
			//console.log("Datos: " + data);
			//console.log("Estado: " + data["Status"]);
			//console.log("Estado del envio: " + data.Status);
			$location.url('/archivos/');
		}).error(function(error){
			console.log("Error de los datos: " + error);
		});
	}
});

lais.controller('busquedaFormCtrl',function($scope, $location){
	$scope.busqueda = function(query){
		if(query === undefined)
			return;
		var texto = query.replace(/\s+/g, " ").trim().toLowerCase(); // Eliminar espacios en blanco y pasar a minúsculas.
		//texto = texto.trim().toLowerCase();
		if(texto.length > 0)
    		$location.url('/archivos/busqueda/' + texto);
    }
});

lais.controller('busquedaCtrl',function($scope, $http, $routeParams, $location){
	$scope.query = $routeParams.query;
	$http.get('php/manejoBD.php?action=buscar&query=' + $routeParams.query).
    success(function(data) {
        $scope.datos = data;
    });
});

function scopeData2object(scope){
	return {
		'codigo_de_referencia': (scope.codigo_de_referencia !== undefined) ? scope.codigo_de_referencia : "",
		'titulo_propio' : (scope.titulo_propio !== undefined) ? scope.titulo_propio : "",
		'titulo_paralelo': (scope.titulo_paralelo !== undefined) ? scope.titulo_paralelo : "",
		'titulo_atribuido': (scope.titulo_atribuido !== undefined) ? scope.titulo_atribuido : "",
		'titulo_de_serie': (scope.titulo_de_serie !== undefined) ? scope.titulo_de_serie : "",
		'numero_de_programa': (scope.numero_de_programa !== undefined) ? scope.numero_de_programa : "",
		'pais': (scope.pais !== undefined) ? scope.pais : "",
		'fecha': (scope.fecha !== undefined) ? scope.fecha : "",
		'duracion': setDuracion(scope.duracion), // Parse desde filter.js
		'investigacion': (scope.investigacion !== undefined) ? scope.investigacion : "",
		'realizacion': (scope.realizacion !== undefined) ? scope.realizacion : "",
		'direccion': (scope.direccion !== undefined) ? scope.direccion : "",
		'guion': (scope.guion !== undefined) ? scope.guion : "",
		'adaptacion': (scope.adaptacion !== undefined) ? scope.adaptacion : "",
		'idea_original': (scope.idea_original !== undefined) ? scope.idea_original : "",
		'fotografia': (scope.fotografia !== undefined) ? scope.fotografia : "",
		'fotografia_fija': (scope.fotografia_fija !== undefined) ? scope.fotografia_fija : "",
		'edicion': (scope.edicion !== undefined) ? scope.edicion : "",
		'sonido_grabacion': (scope.sonido_grabacion !== undefined) ? scope.sonido_grabacion : "",
		'sonido_edicion': (scope.sonido_edicion !== undefined) ? scope.sonido_edicion : "",
		'musica_original': (scope.musica_original !== undefined) ? scope.musica_original : "",
		'musicalizacion': (scope.musicalizacion !== undefined) ? scope.musicalizacion : "",
		'voces': (scope.voces !== undefined) ? scope.voces : "",
		'actores': (scope.actores !== undefined) ? scope.actores : "",
		'animacion': (scope.animacion !== undefined) ? scope.animacion : "",
		'otros_colaboradores': (scope.otros_colaboradores !== undefined) ? scope.otros_colaboradores : "",
		'entidad_productora': (scope.entidad_productora !== undefined) ? scope.entidad_productora : "",
		'productor': (scope.productor !== undefined) ? scope.productor : "",
		'distribuidora': (scope.distribuidora !== undefined) ? scope.distribuidora : "",
		'historia_institucional': (scope.historia_institucional !== undefined) ? scope.historia_institucional : "",
		'resena_biografica': (scope.resena_biografica !== undefined) ? scope.resena_biografica : "",
		'forma_de_ingreso': (scope.forma_de_ingreso !== undefined) ? scope.forma_de_ingreso : "",
		'fecha_de_ingreso': (scope.fecha_de_ingreso !== undefined) ? scope.fecha_de_ingreso : "",
		'sinopsis': (scope.sinopsis !== undefined) ? scope.sinopsis : "",
		'descriptor_onomastico': (scope.descriptor_onomastico !== undefined) ? scope.descriptor_onomastico : "",
		'descriptor_toponimico': (scope.descriptor_toponimico !== undefined) ? scope.descriptor_toponimico : "",
		'descriptor_cronologico': (scope.descriptor_cronologico !== undefined) ? scope.descriptor_cronologico : "",
		'tipo_de_produccion': (scope.tipo_de_produccion !== undefined) ? scope.tipo_de_produccion : "",
		'genero': (scope.genero !== undefined) ? scope.genero : "",
		'fuentes': setFuenteRecurso(scope.fuentes), // Parse desde filter.js
		'recursos': setFuenteRecurso(scope.recursos), // Parse desde filter.js
		'versiones': (scope.versiones !== undefined) ? scope.versiones : "",
		'formato_original': (scope.formato_original !== undefined) ? scope.formato_original : "",
		'material_extra': (scope.material_extra !== undefined) ? scope.material_extra : "",
		'condiciones_de_acceso': (scope.condiciones_de_acceso !== undefined) ? scope.condiciones_de_acceso : "",
		'existencia_y_localizacion_de_originales': (scope.existencia_y_localizacion_de_originales !== undefined) ? scope.existencia_y_localizacion_de_originales : "",
		'idioma_original': (scope.idioma_original !== undefined) ? scope.idioma_original : "",
		'doblajes_disponibles': (scope.doblajes_disponibles !== undefined) ? scope.doblajes_disponibles : "",
		'subtitulajes': (scope.subtitulajes !== undefined) ? scope.subtitulajes : "",
		'soporte': (scope.soporte !== undefined) ? scope.soporte : "",
		'numero_copias': (scope.numero_copias !== undefined) ? scope.numero_copias : "",
		'descripcion_fisica': (scope.descripcion_fisica !== undefined) ? scope.descripcion_fisica : "",
		'color': (scope.color !== undefined) ? scope.color : "",
		'audio': (scope.audio !== undefined) ? scope.audio : "",
		'sistema_de_grabacion': (scope.sistema_de_grabacion !== undefined) ? scope.sistema_de_grabacion : "",
		'region_dvd': (scope.region_dvd !== undefined) ? scope.region_dvd : "",
		'requisitos_tecnicos': (scope.requisitos_tecnicos !== undefined) ? scope.requisitos_tecnicos : "",
		'existencia_y_localizacion_de_copias': (scope.existencia_y_localizacion_de_copias !== undefined) ? scope.existencia_y_localizacion_de_copias : "",
		'unidades_de_descripcion_relacionadas': (scope.unidades_de_descripcion_relacionadas !== undefined) ? scope.unidades_de_descripcion_relacionadas : "",
		'documentos_asociados': (scope.documentos_asociados !== undefined) ? scope.documentos_asociados : "",
		'area_de_notas': (scope.area_de_notas !== undefined) ? scope.area_de_notas : "",
		'notas_del_archivero': (scope.notas_del_archivero !== undefined) ? scope.notas_del_archivero : "",
		'datos_del_archivero': (scope.datos_del_archivero !== undefined) ? scope.datos_del_archivero : "",
		'reglas_o_normas': (scope.reglas_o_normas !== undefined) ? scope.reglas_o_normas : "",
		'fecha_de_descripcion': (scope.fecha_de_descripcion !== undefined) ? scope.fecha_de_descripcion : ""
	}
}