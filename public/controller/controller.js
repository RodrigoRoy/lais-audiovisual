var lais = angular.module('lais',['ngRoute']);

lais.config(function ($routeProvider, $locationProvider){
	console.log("Ruteando");
	$routeProvider
		.when("/",{
			templateUrl: "templates/inicio.html"
		})
		.when("/inicio",{
			templateUrl: "templates/inicio.html"
		})
		.when("/acercade",{
			templateUrl: "templates/acerca_del_sitio.html",
			
		})
		.when("/archivos",{
			templateUrl: "templates/archivos_audiovisuales.html",
			controller: "conexionCtrl"
		})
		.when("/archivos/agregarArchivo",{
			templateUrl: "templates/agregarArchivo.html",
			controller: "agregarDatosCtrl"
		})
		.otherwise({
			redirectTo: "/"
		});
});

//Controlador que muestra los datos en el html, con la conexion a la base de datos
lais.controller('conexionCtrl', function($scope, $http){
	$http.get('php/manejoBD.php?action=ver').
    success(function(data) {
        $scope.registros = data;
        console.log(data);
    });
});

//Controlador que hace post para agregar datos a la base de datos y recupera los datos desde el html
lais.controller('agregarDatosCtrl',function($scope, $http){
	$scope.envia = function(){
		$http.post('php/manejoBD.php?action=agregar',
			{
				// Propiedades del área de identificación
				'codigo_de_referencia': $scope.codigo_de_referencia, // ID único de cada audiovisual
				'titulo_propio' : $scope.titulo_propio,
				'titulo_paralelo': $scope.titulo_paralelo,
				'titulo_atribuido': $scope.titulo_atribuido,
				'titulo_de_serie': $scope.titulo_de_serie,
				'numero_de_programa': $scope.numero_de_programa,
				'pais': $scope.pais,
				'fecha': $scope.fecha,
				'duracion': $scope.duracion,
				'investigacion': $scope.investigacion,
				'realizacion': $scope.realizacion,
				'direccion': $scope.direccion,
				'guion': $scope.guion,
				'adaptacion': $scope.adaptacion,
				'idea_original': $scope.idea_original,
				'fotografia': $scope.fotografia,
				'fotografia_fija': $scope.fotografia_fija,
				'edicion': $scope.edicion,
				'sonido_grabacion': $scope.sonido_grabacion,
				'sonido_edicion': $scope.sonido_edicion,
				'musica_original': $scope.musica_original,
				'musicalizacion': $scope.musicalizacion,
				'voces': $scope.voces,
				'actores': $scope.actores,
				'animacion': $scope.animacion,
				'otros_colaboradores': $scope.otros_colaboradores,
				'entidad_productora' : $scope.entidad_productora,  //Propiedades del área de contexto
				'productor' : $scope.productor,
				'distribuidora' : $scope.distribuidora,
				'historia_institucional' : $scope.historia_institucional,
				'resena_biografica' : $scope.resena_biografica,
				'forma_de_ingreso' : $scope.forma_de_ingreso,
				'fecha_de_ingreso' : $scope.fecha_de_ingreso,
				'sinopsis' : $scope.sinopsis, //Propiedades del área de contenido y estructura
				'descriptor_onomastico' : $scope.descriptor_onomastico,
				'descriptor_toponimico' : $scope.descriptor_toponimico,
				'descriptor_cronologico' : $scope.descriptor_cronologico,
				'tipo_de_produccion' : $scope.tipo_de_produccion,
				'genero' : $scope.genero,
				//fuentes' : $scope.fuentes,
				//fecursos' : $scope.recursos,
				'versiones' : $scope.versiones,
				'formato_original' : $scope.formato_original,
				'material_extra' : $scope.material_extra,
				'condiciones_de_acceso' : $scope.condiciones_de_acceso, //Propiedades del área de condiciones de acceso
				'existencia_y_localizacion_de_originales' : $scope.existencia_y_localizacion_de_originales,
				'idioma_original' : $scope.idioma_original,
				'doblajes_disponibles' : $scope.doblajes_disponibles,
				'subtitulajes' : $scope.subtitulajes,
				'soporte' : $scope.soporte,  // características físicas y requisitos técnicos
				'numero_copias' : $scope.numero_copias,
				'descripcion_fisica' : $scope.descripcion_fisica,
				'color' : $scope.color,
				'audio' : $scope.audio,
				'sistema_de_grabacion' : $scope.sistema_de_grabacion,
				'region_dvd' : $scope.region_dvd,
				'requisitos_tecnicos' : $scope.requisitos_tecnicos,
				'existencia_y_localizacion_de_copias' : $scope.existencia_y_localizacion_de_copias, //Propiedades del área de documentación aociada
				'unidades_de_descripcion_relacionadas' : $scope.unidades_de_descripcion_relacionadas,
				'documentos_asociados' : $scope.documentos_asociados,
				'area_de_notas' : $scope.area_de_notas, //Propiedades del área de notas
				'notas_del_archivero' : $scope.notas_del_archivero, //Propiedades del área de descripción
				'datos_del_archivero' : $scope.datos_del_archivero,
				'reglas_o_normas' : $scope.reglas_o_normas,
				'fecha_de_descripcion' : $scope.fecha_de_descripcion

		}).success(function(data,status, headers, congif){
			console.log($scope.titulo_propio);
			console.log($scope.titulo_paralelo);
			alert("El archivo Audiovisual ha sido agregado");
			$('#audiovisualForm').after('<div class="alert alert-success" role="alert"><p>New record' + $scope.codigo_de_referencia + 'created successfully </p><p>View the record</p></div>');
		}).error(function(error){
			console.log(error);
		});
	}
});

