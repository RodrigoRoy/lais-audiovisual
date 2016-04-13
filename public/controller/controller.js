// La dependencia ngFileUpload sirve para subir imagenes (https://github.com/danialfarid/ng-file-upload)
var lais = angular.module('lais',['ngRoute','ngCookies', 'ngMessages', 'ngAnimate', 'ngSanitize', 'ngFileUpload','infinite-scroll', 'mgcrea.ngStrap', 'isteven-multi-select', 'ui.bootstrap']);

lais.config(function ($routeProvider, $locationProvider){
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
		.when("/publicaciones",{
			templateUrl: "templates/publicaciones_y_vinculos.html"
		})
		.when("/decadas",{
			templateUrl: "templates/archivos_audiovisuales.html",
			//controller: "conexionCtrl"
			controller: "decadasCtrl"
		})
		.when("/decadas/:codigo",{
			templateUrl: "templates/archivos_por_decadas.html",
			controller: "muestraDecadaCtrl"
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
			//templateUrl: "templates/busqueda.html",
			//controller: "busquedaCtrl"
			controller: "muestraDecadaCtrl"
		})
		.when("/administracion_usuarios",{
			templateUrl: "templates/adminUsers.html",
			controller: "adminUserCtrl"
		})
		.when("/control_informacion",{
			templateUrl: "templates/control_informacion.html",
			controller: "controlDatosCtrl"
		})
		.when("/allContents", {
			templateUrl: "templates/allContents.html",
			controller: "allContentsCtrl"
		})
		.otherwise({
			redirectTo: "/"
		});
});

// Directiva para comprobar que dos inputs tengan el mismo valor (password).
// http://blog.brunoscopelliti.com/angularjs-directive-to-check-that-passwords-match/
lais.directive('pwCheck', function () {
	return {
	  require: 'ngModel',
		link: function (scope, elem, attrs, ctrl) {
			var firstPassword = '#' + attrs.pwCheck;
			elem.add(firstPassword).on('keyup', function () {
			  scope.$apply(function () {
			    var v = elem.val()===$(firstPassword).val();
			    ctrl.$setValidity('pwmatch', v);
			  });
			});
		}
	}
});

//Servicio que hace global la función de agregar nuevo elemento que guarda la decada y redirige al formulario
lais.service('agregarNuevoAll', function( $cookieStore, $location){
	// Acción del icono para agregar un nuevo audiovisual
    this.agregarNew = function(decada){
		if(decada != undefined )
			$cookieStore.put('decada',decada); // Almacena el código de década
		$location.url('/archivos/agregarArchivo/'); // Ir a la página "Agregar audiovisual"

    }
});

// Servicio cuya finalidad es ser intermediario de parametros entre controladores
lais.service('ParamService', function(){
	// Contenedor para los parametros entre controladores o para información repetitiva
	var params = {
		"test": "Hola mundo" // Valor de prueba
	};

	// Agregar una clave y valor que se desea recordar
	this.set = function(key, value){
		if(key != null){
			params[key] = value;
		}
	};

	// Obtener un valor mediante su clave o llave en el arreglo asociativo 'params'
	this.get = function(key){
		return params[key];
	};

	// Limpia todos los campos del formulario y los encapsula en un arreglo asociativo para ser enviados a la base de datos
	// Se eliminan espacios con trim() y se reemplazan multiples espacios por uno solo. La mayoría de los campos utilizan la función:
	// trim().replace(/\s\s+/g, ' ') excepto para textos donde se desea mantener tabuladores o saltos de linea se utiliza la función:
	// .trim().replace(/  /g, ' ') [http://stackoverflow.com/questions/1981349/regex-to-replace-multiple-spaces-with-a-single-space]
	this.scopeData2object = function(scope){
		scope.createFuentes();
		scope.createRecursos();
		return {
			'codigo_de_referencia': (scope.codigo_de_referencia !== undefined) ? scope.codigo_de_referencia : "",
			'titulo_propio' : (scope.titulo_propio !== undefined) ? scope.titulo_propio.trim().replace(/\s\s+/g, ' ') : "",
			'titulo_paralelo': (scope.titulo_paralelo !== undefined) ? scope.titulo_paralelo.trim().replace(/\s\s+/g, ' ') : "",
			'titulo_atribuido': (scope.titulo_atribuido !== undefined) ? scope.titulo_atribuido.trim().replace(/\s\s+/g, ' ') : "",
			'titulo_de_serie': (scope.titulo_de_serie !== undefined) ? scope.titulo_de_serie.trim().replace(/\s\s+/g, ' ') : "",
			'numero_de_programa': (scope.numero_de_programa !== undefined) ? scope.numero_de_programa.trim().replace(/\s\s+/g, ' ') : "",
			'pais': (scope.pais !== undefined) ? scope.pais.trim().replace(/\s\s+/g, ' ') : "",
			'fecha': (scope.fecha !== undefined) ? scope.fecha.trim().replace(/  +/g, '') : "", // TODO setFecha()?
			'duracion': setDuracion(scope.duracion), // Parse desde filter.js
			'investigacion': (scope.investigacion !== undefined) ? scope.investigacion.trim().replace(/\s\s+/g, ' ') : "",
			//'investigacion': this.array2string(scope.investigacion),
			'realizacion': (scope.realizacion !== undefined) ? scope.realizacion.trim().replace(/\s\s+/g, ' ') : "",
			'direccion': (scope.direccion !== undefined) ? scope.direccion.trim().replace(/\s\s+/g, ' ') : "",
			'guion': (scope.guion !== undefined) ? scope.guion.trim().replace(/\s\s+/g, ' ') : "",
			'adaptacion': (scope.adaptacion !== undefined) ? scope.adaptacion.trim().replace(/\s\s+/g, ' ') : "",
			'idea_original': (scope.idea_original !== undefined) ? scope.idea_original.trim().replace(/\s\s+/g, ' ') : "",
			'fotografia': (scope.fotografia !== undefined) ? scope.fotografia.trim().replace(/\s\s+/g, ' ') : "",
			'fotografia_fija': (scope.fotografia_fija !== undefined) ? scope.fotografia_fija.trim().replace(/\s\s+/g, ' ') : "",
			'edicion': (scope.edicion !== undefined) ? scope.edicion.trim().replace(/\s\s+/g, ' ') : "",
			'sonido_grabacion': (scope.sonido_grabacion !== undefined) ? scope.sonido_grabacion.trim().replace(/\s\s+/g, ' ') : "",
			'sonido_edicion': (scope.sonido_edicion !== undefined) ? scope.sonido_edicion.trim().replace(/\s\s+/g, ' ') : "",
			'musica_original': (scope.musica_original !== undefined) ? scope.musica_original.trim().replace(/\s\s+/g, ' ') : "",
			'musicalizacion': (scope.musicalizacion !== undefined) ? scope.musicalizacion.trim().replace(/\s\s+/g, ' ') : "",
			'voces': (scope.voces !== undefined) ? scope.voces.trim().replace(/\s\s+/g, ' ') : "",
			'actores': (scope.actores !== undefined) ? scope.actores.trim().replace(/\s\s+/g, ' ') : "",
			'animacion': (scope.animacion !== undefined) ? scope.animacion.trim().replace(/\s\s+/g, ' ') : "",
			'otros_colaboradores': (scope.otros_colaboradores !== undefined) ? scope.otros_colaboradores.trim().replace(/\s\s+/g, ' ') : "",
			'entidad_productora': (scope.entidad_productora !== undefined) ? scope.entidad_productora.trim().replace(/\s\s+/g, ' ') : "",
			'productor': (scope.productor !== undefined) ? scope.productor.trim().replace(/\s\s+/g, ' ') : "",
			'distribuidora': (scope.distribuidora !== undefined) ? scope.distribuidora.trim().replace(/\s\s+/g, ' ') : "",
			'historia_institucional': (scope.historia_institucional !== undefined) ? scope.historia_institucional.trim().replace(/  +/g, ' ') : "",
			'resena_biografica': (scope.resena_biografica !== undefined) ? scope.resena_biografica.trim().replace(/  +/g, ' ') : "",
			'forma_de_ingreso': (scope.forma_de_ingreso !== undefined) ? scope.forma_de_ingreso.trim().replace(/\s\s+/g, ' ') : "",
			'fecha_de_ingreso': (scope.fecha_de_ingreso !== undefined) ? scope.fecha_de_ingreso.trim().replace(/  +/g, ' ') : "", // TODO setFechaIngreso()?
			'sinopsis': (scope.sinopsis !== undefined) ? scope.sinopsis.trim().replace(/  +/g, ' ') : "",
			'descriptor_onomastico': (scope.descriptor_onomastico !== undefined) ? scope.descriptor_onomastico.trim().replace(/  +/g, ' ') : "",
			'descriptor_toponimico': (scope.descriptor_toponimico !== undefined) ? scope.descriptor_toponimico.trim().replace(/  +/g, ' ') : "",
			'descriptor_cronologico': (scope.descriptor_cronologico !== undefined) ? scope.descriptor_cronologico.trim().replace(/  +/g, ' ') : "",
			'tipo_de_produccion': (scope.tipo_de_produccion !== undefined) ? scope.tipo_de_produccion.trim().replace(/\s\s+/g, ' ') : "",
			'genero': (scope.genero !== undefined) ? scope.genero.trim().replace(/\s\s+/g, ' ') : "",
			'fuentes': scope.fuentes, // Parse desde filter.js "setFuenteRecurso()" sustituido por $scope.createFuentes()
			'recursos': scope.recursos, // Parse desde filter.js  "setFuenteRecurso()" sustituido por $scope.createRecursos()
			'versiones': (scope.versiones !== undefined) ? scope.versiones.trim().replace(/\s\s+/g, ' ') : "",
			'formato_original': (scope.formato_original !== undefined) ? scope.formato_original.trim().replace(/\s\s+/g, ' ') : "",
			'material_extra': (scope.material_extra !== undefined) ? scope.material_extra.trim().replace(/\s\s+/g, ' ') : "",
			'condiciones_de_acceso': (scope.condiciones_de_acceso !== undefined) ? scope.condiciones_de_acceso.trim().replace(/\s\s+/g, ' ') : "",
			'existencia_y_localizacion_de_originales': (scope.existencia_y_localizacion_de_originales !== undefined) ? scope.existencia_y_localizacion_de_originales.trim().replace(/  +/g, ' ').trim().replace(/\s\s+/g, ' ') : "",
			'idioma_original': (scope.idioma_original !== undefined) ? scope.idioma_original.trim().replace(/\s\s+/g, ' ') : "",
			'doblajes_disponibles': (scope.doblajes_disponibles !== undefined) ? scope.doblajes_disponibles.trim().replace(/\s\s+/g, ' ') : "",
			'subtitulajes': (scope.subtitulajes !== undefined) ? scope.subtitulajes.trim().replace(/\s\s+/g, ' ') : "",
			'soporte': (scope.soporte !== undefined) ? scope.soporte.trim().replace(/\s\s+/g, ' ') : "",
			'numero_copias': (scope.numero_copias !== undefined) ? scope.numero_copias.trim().replace(/\s\s+/g, ' ') : "",
			'descripcion_fisica': (scope.descripcion_fisica !== undefined) ? scope.descripcion_fisica.trim().replace(/  +/g, ' ') : "",
			'color': (scope.color !== undefined) ? scope.color.trim().replace(/\s\s+/g, ' ') : "",
			'audio': (scope.audio !== undefined) ? scope.audio.trim().replace(/\s\s+/g, ' ') : "",
			'sistema_de_grabacion': (scope.sistema_de_grabacion !== undefined) ? scope.sistema_de_grabacion.trim().replace(/\s\s+/g, ' ') : "",
			'region_dvd': (scope.region_dvd !== undefined) ? scope.region_dvd.trim().replace(/\s\s+/g, ' ') : "",
			'requisitos_tecnicos': (scope.requisitos_tecnicos !== undefined) ? scope.requisitos_tecnicos.trim().replace(/\s\s+/g, ' ') : "",
			'existencia_y_localizacion_de_copias': (scope.existencia_y_localizacion_de_copias !== undefined) ? scope.existencia_y_localizacion_de_copias.trim().replace(/\s\s+/g, ' ') : "",
			'unidades_de_descripcion_relacionadas': (scope.unidades_de_descripcion_relacionadas !== undefined) ? scope.unidades_de_descripcion_relacionadas.trim().replace(/  +/g, ' ') : "",
			'documentos_asociados': (scope.documentos_asociados !== undefined) ? scope.documentos_asociados.trim().replace(/  +/g, ' ') : "",
			'area_de_notas': (scope.area_de_notas !== undefined) ? scope.area_de_notas.trim().replace(/  +/g, ' ') : "",
			'notas_del_archivero': (scope.notas_del_archivero !== undefined) ? scope.notas_del_archivero.trim().replace(/  +/g, ' ') : "",
			'datos_del_archivero': (scope.datos_del_archivero !== undefined) ? scope.datos_del_archivero.trim().replace(/\s\s+/g, ' ') : "",
			'reglas_o_normas': (scope.reglas_o_normas !== undefined) ? scope.reglas_o_normas.trim().replace(/\s\s+/g, ' ') : "",
			//'fecha_de_descripcion': (scope.fecha_de_descripcion !== undefined) ? scope.fecha_de_descripcion.trim().replace(/  +/g, ' ') : "", // TODO: setFechaDescripcion()?
			'fecha_de_descripcion': (scope.fecha_de_descripcion !== undefined) ? (scope.fecha_de_descripcion) : "0000-00-00",
			'url': (scope.url !== undefined) ? scope.url.trim() : ""
		}
	}

	this.array2string = function(scopeVarArray){
		var onlyNames = [];
		for(var i in scopeVarArray){
			scopeVarArray[i]['nombre'] = (scopeVarArray[i]['nombre'] !== undefined) ? scopeVarArray[i]['nombre'].trim().replace(/\s\s+/g, ' ') : "";
			onlyNames.push(scopeVarArray[i]['nombre']);
		}
		var text = onlyNames.join().replace(/,,+/g, ','); // Reemplaza multiples comas
		text = (text.charAt(0) === ',') ? text.substring(1) : text; // Elimina coma al inicio en caso de haber
		text = (text.charAt(text.length-1) === ',') ? text.substring(0, text.length-2) : text; // Elimina coma al final en cabo de haber
		return text; 
	};
});

// Servicio que permite hacer un parse de décadas y encabezados de cada rubro
lais.service('DecadaService', function($http){
	this.allDecades = {
		'1':"1890-1899",
		'2':"1900-1909",
		'3':"1910-1919",
		'4':"1920-1929",
		'5':"1930-1939",
		'6':"1940-1949",
		'7':"1950-1959",
		'8':"1960-1969",
		'9':"1970-1979",
		'10':"1980-1989",
		'11':"1990-1999",
		'12':"2000-2009",
		'13':"2010-2019",
		'14':"2020-2029",
		'15':"2030-2039",
		'16':"2040-2049",
		'17':"2050-2059",
		'18':"2060-2069",
		'19':"2070-2079",
		'20':"2080-2089",
		'21':"2090-2099",
		'22':"2100-2109"
	};

	this.areas = {
		'identificacion': 'identificación',
		'contexto': 'contexto',
		'contenido': 'contenido y estructura',
		'condiciones':'condiciones de acceso',
		'documentacion': 'documentación asociada',
		'notas': 'notas',
		'descripcion': 'control de la descripcion',
		'adicional': 'información adicional'
	};

	// Traducción de los encabezados (nombre_en_base_datos -> Nombre para leer)
	this.encabezados = {
		'codigo_de_referencia': 'Código de referencia',
		'titulo_propio': 'Título propio',
		'titulo_paralelo': 'Título paralelo',
		'titulo_atribuido': 'Título atribuido',
		'titulo_de_serie': 'Título de serie',
		'numero_de_programa': 'Número de programa',
		'pais': 'País',
		'fecha': 'Fecha',
		'duracion': 'Duración',
		'investigacion': 'Investigación',
		'realizacion': 'Realización',
		'direccion': 'Dirección',
		'guion': 'Guión',
		'adaptacion': 'Adaptación',
		'idea_original': 'Idea original',
		'fotografia': 'Fotografía',
		'fotografia_fija': 'Fotografía fija',
		'edicion': 'Edición',
		'sonido_grabacion': 'Grabación de sonido',
		'sonido_edicion': 'Edición de sonido',
		'musica_original': 'Música original',
		'musicalizacion': 'Musicalización',
		'voces': 'Voces',
		'actores': 'Actores',
		'animacion': 'Animación',
		'otros_colaboradores': 'Otros colaboradores',
		'entidad_productora': 'Entidad productora',
		'productor': 'Productor',
		'distribuidora': 'Distribuidora',
		'historia_institucional': 'Historia institucional',
		'resena_biografica': 'Reseña biográfica',
		'forma_de_ingreso': 'Forma de ingreso',
		'fecha_de_ingreso': 'Fecha de ingreso',
		'sinopsis': 'Sinopsis',
		'descriptor_onomastico': 'Descriptor onomástico',
		'descriptor_toponimico': 'Descriptor toponímico',
		'descriptor_cronologico': 'Descriptor cronológico',
		'tipo_de_produccion': 'Tipo de produccion',
		'genero': 'Género',
		'fuentes': 'Fuentes',
		'recursos': 'Recursos',
		'versiones': 'Versiones',
		'formato_original': 'Formato original',
		'material_extra': 'Material extra',
		'condiciones_de_acceso': 'Condiciones de acceso',
		'existencia_y_localizacion_de_originales': 'Existencia y localización de originales',
		'idioma_original': 'Idioma original',
		'doblajes_disponibles': 'Doblajes disponibles',
		'subtitulajes': 'Subtitulajes',
		'soporte': 'Soporte',
		'numero_copias': 'Número de copias',
		'descripcion_fisica': 'Descripción física',
		'color': 'Color',
		'audio': 'Audio',
		'sistema_de_grabacion': 'Sistema de grabación',
		'region_dvd': 'Región del DVD',
		'requisitos_tecnicos': 'Requisitos técnicos',
		'existencia_y_localizacion_de_copias': 'Existencia y localización de copias',
		'unidades_de_descripcion_relacionadas': 'Unidades de descripción relacionadas',
		'documentos_asociados': 'Documentos asociados',
		'area_de_notas': 'Área de notas',
		'notas_del_archivero': 'Notas del archivero',
		'datos_del_archivero': 'Datos del archivero',
		'reglas_o_normas': 'Reglas o normas',
		'fecha_de_descripcion': 'Fecha de descripción',
		'imagen': 'Imagen',
		'url': 'URL'
	};
});

//Controlador que muestra los datos en el html, con la conexion a la base de datos
// Actualmente fue reemplazado por decadasCtrl
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

//Controlador que muestra todas las decadas existentes
lais.controller('decadasCtrl',function($scope, $location, $http, $cookieStore, DecadaService){
	$scope.allDecades = DecadaService.allDecades;

	//Eliminar el cookie del codigo de decadas
	$cookieStore.remove('decada');
	
	//Utiizó para que el modal se quitara cuando un usuario le da un botón de regresar a la página
	$('#modalInfo').modal('hide'); // Ocultar modal
	$('body').removeClass('modal-open'); // Eliminar del DOM
	$('.modal-backdrop').remove();

	$http.get('php/manejoBD.php?action=mostrarDecadas').
	success(function(data){
		$scope.decadas = data;
	});

	// Acción del icono para agregar un nuevo audiovisual
    $scope.agregarNuevo = function(){
    	// Construir string que corresponde a la siguiente década (suponiendo consecutividad)
    	var matches = /(.*-)(\d)/g.exec($scope.decadas[0]); // Separar el último dígito (la década) con expresion regular
    	var numeracion = parseInt(matches[2]) + 1;
    	var decada = matches[1] + numeracion; // Nuevo string con década siguiente (+1)
    	$cookieStore.put('decada', decada); // Almacena el código de década
		$location.url('/archivos/agregarArchivo/'); // Ir a la página "Agregar audiovisual"
    };

    // Arreglo con los nombres de campos demasiado largos para ser mostrados inicialmente en la vista
	$scope.showCampos = {
		"historia-institucional": false,
		"historia-archivistica": false,
		"alcance-y-contenido": false
	};
	// Cambia a true el valor de un campo largo ($scope.showCampos). Recibe una cadena de texto con el nombre del campo
    $scope.makeVisible = function(campo){
    	$scope.showCampos[campo] = true;
    };
});

//Controlador que mostrara los archivos audiovisuales con su portada por decadas
lais.controller('muestraDecadaCtrl',function($scope, $location, $routeParams, $http, $timeout, $cookieStore, ParamService, DecadaService, agregarNuevoAll){
	// ########## PROPIEDADES DEL CONTROLADOR ##########
	$scope.codigo = $routeParams.codigo; // Código de la década
	$scope.query = $routeParams.query; // Query de búsqueda en la barra de navegación
	$scope.allDecades = DecadaService.allDecades;
	$scope.encabezados = DecadaService.encabezados;
	$scope.archivos = []; // Los registros por décadas (incluyen titulo, fecha, duracion, imagen)
	$scope.allInfo = []; // Toda la información del registro seleccionado (se inicializa más adelante)
	$scope.allInfoCopy = []; // Copia de los datos originales (ver $scope.preprocesamientoUnidad())
	$scope.busy = false;
	var howMany = 30; // Cantidad de audiovisuales que se obtienen de la base de datos cuando es necesario
	$scope.errores = false; //Muetra el error de confirmación de contraseña para borrar un registro
	//$scope.uniqueName son todos los rubros que coinciden con la búsqueda
	$scope.predicate = 'fecha'; // Predicado o propiedad que se utilizará para el ordenamiento
	$scope.reverse = 'true'; // Orden descendente (true) o ascendente (false) de los registros
	$scope.hideInfo = false; //Banderá para esconder la información completa de cada registro
	// Arreglo auxiliar agrupado por areas para mostrar correctamente keywords dentro de la tabla de información completa (ver función focus())
	var areas = {
    	'identificacion': ['codigo_de_referencia', 'titulo_propio', 'titulo_paralelo', 'titulo_atribuido', 'titulo_de_serie', 'numero_de_programa', 'pais', 'fecha', 'duracion', 'investigacion', 'realizacion', 'direccion', 'guion', 'adaptacion', 'idea_original', 'fotografia', 'fotografia_fija', 'edicion', 'sonido_grabacion', 'sonido_edicion', 'musica_original', 'musicalizacion', 'voces', 'actores', 'animacion', 'otros_colaboradores'],
    	'contexto': ['entidad_productora', 'productor', 'distribuidora', 'historia_institucional', 'resena_biografica', 'forma_de_ingreso', 'fecha_de_ingreso'],
    	'contenido': ['sinopsis', 'descriptor_onomastico', 'descriptor_toponimico', 'descriptor_cronologico', 'tipo_de_produccion', 'genero', 'fuentes', 'recursos', 'versiones', 'formato_original', 'material_extra'],
    	'condiciones': ['condiciones_de_acceso', 'existencia_y_localizacion_de_originales', 'idioma_original', 'doblajes_disponibles', 'subtitulajes', 'soporte', 'numero_copias', 'descripcion_fisica', 'color', 'audio', 'sistema_de_grabacion', 'region_dvd', 'requisitos_tecnicos'],
    	'documentacion': ['existencia_y_localizacion_de_copias', 'unidades_de_descripcion_relacionadas', 'documentos_asociados'],
    	'notas': ['area_de_notas'],
    	'descripcion': ['notas_del_archivero', 'datos_del_archivero', 'reglas_o_normas', 'fecha_de_descripcion'],
    	'adicional': ['imagen', 'url']
    }
    $scope.visibles = $scope.archivos.length; // Cantidad de documentales visibles (útil al filtrarlos en búsquedas)
    $scope.predicate = "fecha"; // Ordenamiento por "fecha" (año)
	$scope.reverse = true; // Orden ascendente/descendente del ordenamiento
	var articulos = ["el", "la", "los", "las", "un", "una", "unos", "unas", "lo", "al", "del"]; // Lista de artículos en español (útil para corregir los nombres)
	$scope.loading = true;

    // ########## CONEXIONES CON BASE DE DATOS ##########

	// En caso de que sea una búsqueda se obtienen todos los registros que coincidan con el query
	if($scope.query){
		$http.get('php/manejoBD.php?action=busqueda2&query='+$scope.query+'&permiso='+$scope.permiso)
			.success(function(data, status, headers, config) {
				if(data)
					$scope.uniqueNames = data.splice(data.length-1, 1)[0]; // Los rubros siempre vienen al final de "data"
				$scope.archivos = data;
				$scope.visibles = $scope.archivos.length;
				for(var i in $scope.archivos){ // A todos los archivos se les agrega la propiedad "show"
					$scope.archivos[i]['show'] = true; // Esto permite filtrar resultados de manera inmediata
					$scope.preprocesamiento($scope.archivos[i]); // Limpia de espacios vacios y agrega "titulo_adecuado" y "titulo_visible"
					// Y eliminar espacios en blanco para un correcto comportamiento en ordenamiento:
					//$scope.archivos[i]['fecha'] = $scope.archivos[i]['fecha'].trim().replace(/  */g, '');
					//$scope.archivos[i]['titulo_propio'] = $scope.archivos[i]['titulo_propio'].trim();
				}
				$scope.inputQuery = []; // Objeto para mostrar los objetos multiselect para filtar la busqueda
				for(var i in $scope.uniqueNames){
					$scope.inputQuery.push({name: DecadaService.encabezados[$scope.uniqueNames[i]], ticked: true, total: 0, area: '', originalName: $scope.uniqueNames[i]});
				}
				
				for(var key in $scope.archivos){
					var rubrosList = $scope.getRubros($scope.archivos[key]); // Arreglo que solo contiene los rubros (sin repeticiones)
					for(var i in rubrosList)
						for(var j in $scope.inputQuery)
							if($scope.inputQuery[j]['name'] === rubrosList[i]) // Si aparece el rubro del registro en inputQuery
								$scope.inputQuery[j]['total']++;
				}

				for(var i in $scope.inputQuery){
					$scope.inputQuery[i]['area'] = DecadaService.areas[$scope.searchArea($scope.inputQuery[i]['originalName'])];
				}

				$scope.loading = false;
			});
	}

	// Obtiene los datos (id,imagen,titulo,duracion) necesarios para mostrar portadas en el template.
	// En caso de requerir otros datos, modificar la función del manejador de la base (manejoDB.php)
	$scope.firstLoad = function(){
		if($scope.busy) // No hacer nada si ya no hay datos que obtener de la base
			return;
		$scope.busy = true; // En estos momentos estamos "ocupados" obteniendo datos de la base
		$http.get('php/manejoBD.php?action=firstGet&codigo='+$routeParams.codigo+"&howMany="+howMany+"&offset="+$scope.archivos.length).
			success(function(data, status, headers, config) {
				for(i in data){ // Recorrer por indice (av) cada audiovisual de la base
					var archivo = data[i]; // Temporalmente guardar en variable para su posterior manipulación (preprocesamiento)
					$scope.preprocesamiento(archivo); // Limpia de espacios vacios y agrega "titulo_adecuado" y "titulo_visible"
					$scope.archivos.push(archivo); // Agregar al arreglo que los contendrá
					//console.log("Imgen: " + data[av].imagen);
				}
				$scope.busy = false; // En este momento ya NO estamos "ocupados"
				if (data.length == 0) // Excepto si ya no hay datos que obtener de la base
					$scope.busy = true;
			}).
			error(function(data, status, headers, config) {
				// called asynchronously if an error occurs or server returns response with an error status.
				alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
			});

		// Manera alternativa de obtener ancho y alto de una imagen mediante jQuery (se utiliza PHP en su lugar):
		// $(document).ready(function(){
		// 	var screenImage = $("img[src$='007142.jpg']");
		// 	var theImage = new Image();
		// 	theImage.src = screenImage.attr("src");
		// 	var imageWidth = theImage.width;
		// 	var imageHeight = theImage.height;
		// 	console.log(imageWidth, imageHeight);
		// });
	};

	// Obtiene los datos (id,imagen,titulo,duracion) necesarios para mostrar portadas después de una búsqueda
	// En caso de requerir otros datos, modificar la función del manejador de la base (manejoDB.php)
	// (Esta función es una copia de firstLoad())
	/*$scope.firstQueryLoad = function(){
		if($scope.busy) // No hacer nada si ya no hay datos que obtener de la base
			return;
		$scope.busy = true; // En estos momentos estamos "ocupados" obteniendo datos de la base
		$http.get('php/manejoBD.php?action=busqueda&query='+$routeParams.query+"&howMany="+howMany+"&offset="+$scope.archivos.length).
			success(function(data, status, headers, config) {
				for(av in data){ // Recorrer por indice (av) cada audiovisual de la base
					$scope.archivos.push(data[av]); // Agregar al arreglo que los contendrá
					console.log("archivos", $scope.archivos);
				}
				$scope.busy = false; // En este momento ya NO estamos "ocupados"
				if (data.length == 0) // Excepto si ya no hay datos que obtener de la base
					$scope.busy = true;
			}).
			error(function(data, status, headers, config) {
				// called asynchronously if an error occurs or server returns response with an error status.
			});
	};*/

	// Obtener toda la información de un audiovisual particular. Recibe el código de identificación
	$scope.getAllInfo = function(codigoId){
		$scope.hideInfo = false; //Inicializar el botón de ver más para que siempre este visible
		//console.log("codigo: " + codigoId);
		$http.get('php/manejoBD.php?action=obtenerXAreas&id=' + codigoId).
    	success(function(data) {
    		$scope.allInfo = data;
    		// Limpiar algunos campos:
    		$scope.preprocesamientoUnidad();
    		getImgSize('imgs/Portadas/' + $scope.allInfo.adicional.imagen); // Llamada asincrona para obtener el ancho y largo original ($scope.imgActualWidth, $scope.imgActualHeight)
    	}).
    	error(function(data, status, headers, config) {
			// called asynchronously if an error occurs or server returns response with an error status.
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});
	};

	// Obtener toda la información del siguiente/anterior audiovisual de la lista $scope.archivos.
	// Recibe el código de identificación del audiovisual actual y la dirección que se desea: "next" o "prev".
	$scope.getAllInfoNear = function(codigoId, direction){
		var nextID = ''; // El codigo_de_referencia del siguiente/anterior documental
		if(direction.toLowerCase() === 'next' || direction === undefined){ // Caso para encontrar el siguiente
			for(var i in $scope.archivos){ // Buscar en los archivos disponibles
				if($scope.archivos[i].codigo_de_referencia === codigoId && i !== $scope.archivos.length){ // Si encontramos el codigo actual
					nextID = $scope.archivos[parseInt(i)+1].codigo_de_referencia; // Hemos encontrado el código buscado
					break;
				}
			}
		}
		else if(direction.toLowerCase() === 'prev'){ // Caso para encontrar el anterior
			for(var i in $scope.archivos){ // Buscar en los archivos disponibles
				if($scope.archivos[i].codigo_de_referencia === codigoId && i !== 0){ // Si encontramos el codigo actual
					nextID = $scope.archivos[parseInt(i)-1].codigo_de_referencia; // Hemos encontrado el código buscado
					break;
				}
			}
		}
		//$scope.hideInfo = false; //Inicializar el botón de ver más para que siempre este visible
		$http.get('php/manejoBD.php?action=obtenerXAreas&id=' + nextID).
    	success(function(data) {
    		$scope.allInfo = data;
    		// Limpiar algunos campos:
    		$scope.preprocesamientoUnidad();
    		getImgSize('imgs/Portadas/' + $scope.allInfo.adicional.imagen); // Llamada asincrona para obtener el ancho y largo original ($scope.imgActualWidth, $scope.imgActualHeight)
    		//console.log($scope.allInfo);
    	}).
    	error(function(data, status, headers, config) {
			// called asynchronously if an error occurs or server returns response with an error status.
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});
	};

	// ########## BUSQUEDAS, ORDENAMIENTO Y FILTRADO ##########

	// Función que actualiza la propiedad "show" del arreglo $scope.archivos que contiene los registros de la búsqueda que se muestran
	// Verifica los rubros de cada registro y los compara con $scope.outputQuery (que es un multiselect para filtrar resultados)
	$scope.updateVisibility = function(){
		// Para el caso en que se da clic hasta quitar todos los filtros del multiselect (sin usar "Select None")
		if($scope.outputQuery.length === 0){
			$scope.updateNone();
			return;
		}

		var contador = 0;
		for(var key in $scope.archivos){
			var rubrosList = $scope.getRubros($scope.archivos[key]); // Arreglo que solo contiene los rubros (sin repeticiones)
			loop:
			for(var i in rubrosList)
				for(var j in $scope.outputQuery)
					if($scope.outputQuery[j]['name'] === rubrosList[i]){ // Si aparece el rubro del registro en outputQuery
						$scope.archivos[key]['show'] = true;
						contador++;
						break loop; // Para evitar reasignar a falso si el siguiente rubro no está contenido
					}else{
						$scope.archivos[key]['show'] = false;
					}
		}
		$scope.visibles = contador;
	};
	
	// TODO: Puede optimizarse
	$scope.updateView = function(){
		var contador = 0;
		for(var key in $scope.archivos){
			var rubrosList = $scope.getRubros($scope.archivos[key]); // Arreglo que solo contiene los rubros (sin repeticiones)
			loop:
			for(var i in rubrosList)
				for(var j in $scope.inputQuery){
					console.log($scope.archivos[key]['titulo_propio'], $scope.inputQuery[j]['name'], "===", rubrosList[i], "?:", $scope.inputQuery[j]['name'] === rubrosList[i]);
					if(($scope.inputQuery[j]['ticked']) && ($scope.inputQuery[j]['name'] === rubrosList[i])){ // Si aparece el rubro del registro en inputQuery
						$scope.archivos[key]['show'] = true;
						contador++;
						break loop; // Para evitar reasignar a falso si el siguiente rubro no está contenido
					}else{
						$scope.archivos[key]['show'] = false;
					}
				}
		}
		$scope.visibles = contador;
	};

	// Auxiliar que devuelve un arreglo de los rubros (campos) donde un registro tuvo coincidencias de búsqueda (sin repeticiones).
	// Evita lidiar con arreglos anidados dentro de $scope.archivos (para el caso de la propiedad "rubros")
	$scope.getRubros = function(registro){
		var uniqueRubros = [];
		//var registro = $scope.archivos[codigo_de_referencia];
		for(var palabra in registro.rubros)
			for(var rubro in registro.rubros[palabra]){
				var nombreRubro = DecadaService.encabezados[registro.rubros[palabra][rubro]];
				if(!(uniqueRubros.indexOf(nombreRubro) > -1)) // Si no está contenido se agrega (esto evita repeticiones)
					uniqueRubros.push(nombreRubro);
			}
		return uniqueRubros;
	};

	// isteven Multiselect transalation:
	$scope.localLang = {
		selectAll       : "Seleccionar todo",
		selectNone      : "Seleccionar ninguno",
		reset           : "Reset",
		search          : "Búsqueda",
		nothingSelected : "Nada está seleccionado"
	}

	// Oculta todos los archivos en la vista
	$scope.updateNone = function(){
		for(var key in $scope.archivos){
			$scope.archivos[key].show = false;
		}
		$scope.visibles = 0;
	};

	// Muestra todos los archivos en la vista
	$scope.updateAll = function(){
		for(var key in $scope.archivos){
			$scope.archivos[key].show = true;
		}
		$scope.visibles = $scope.archivos.length;
	};

	// Permite marcar todos los checkbox de búsqueda y los elementos visibles (propiedad "show" del arreglo "archivos") según el parámetro booleano dado
	$scope.setAllFilters = function(bool){
		// Asigna todos los checkbox por el parámetro dado:
		for(var i in $scope.inputQuery){
			$scope.inputQuery[i]['ticked'] = bool;
		}
		// Esconde/muestra todos los archivos (ya que los checkbox no actualizan esta propiedad de la misma manera que al dar clic en la vista):
		for(var i in $scope.archivos){
			$scope.archivos[i].show = bool;
		}
		// Actualiza también la cantidad de elementos visibles:
		if(bool)
			$scope.visibles = $scope.archivos.length;
		else
			$scope.visibles = 0;
	};


	// Recibe el nombre de la propiedad o predicado que se utilizará para el ordenamiento de los registros (por ejemplo: 'fecha')
	// Revierte el orden ascendente/descendente en caso de ser la misma propiedad o predicado (uso con la directiva orderBy).
	// $scope.order = function(predicate){
	// 	$scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : true;
 //        $scope.predicate = predicate;
	// };

	// Parser del select "ordenSelect" en la vista. Determina el área de ordenamiento y el orden de los datos.
	$scope.parseOrdenamiento = function(){
		var orden = $scope.ordenamiento.split("|");
		$scope.predicate = orden[0];
		$scope.reverse = (orden[1] === 'true');
	};

	// Busca el registro con codigo de referencia dado como parámetro y devuelve el arreglo "rubros" asociado a ese registro
	$scope.findRubros = function(codigo_de_referencia){
		for(var i in $scope.archivos)
			if($scope.archivos[i].codigo_de_referencia === codigo_de_referencia)
				return $scope.archivos[i].rubros;

	};

	// Resalta la cadena de texto dada como parámetro dentro del modal que contiene toda la información del registro audiovisual
	$scope.highlight = function(query){
		$("#modalInfo").removeHighlight();
		$("#modalInfo").highlight(query, true);
	};

	// Auxiliar para determinar el área de un rubro (util al auto-mostrar la pestaña donde aparece la keyword)
	// Utiliza la variable "areas" que contiene el agrupamiento de todos los campos
	$scope.searchArea = function(rubro){
		for(var key in areas){
			for(var i in areas[key]){
				if(areas[key][i] === rubro){
					return key;
				}
			}
		}
	};

	// Mostrar tab relacionada con el keyword de la búsqueda
	$scope.focus = function(keyword, rubro){
		var area = $scope.searchArea(rubro); // Determinar el área (id de la pestaña/nav-pill/nav-tab)
		$scope.hideInfo = true; // Mostrar modal si está oculto
	    $('.nav-pills a[data-target="#' + area + '"]').tab('show'); // Mostrar pestaña (nav-pill/nav-tab)
	    $scope.highlight(keyword); // Resaltar la keyword correspondiente dentro del texto
	};

	// ########## FORMATO Y VISUALIZACIÓN DE LA INFORMACIÓN ##########

	// Preprocesamiento de la información principal (mosaico de portadas). Agrega valores auxiliares para mostrar titulos correctos.
	$scope.preprocesamiento = function(archivo){
		archivo['fecha'] = archivo['fecha'].trim().replace(/  */g, ''); // Quitar espacios en fecha (para ordenamiento alfabetico correcto)
		archivo['titulo_propio'] = archivo['titulo_propio'].trim();
		archivo['titulo_paralelo'] = archivo['titulo_paralelo'].trim();
		archivo['titulo_adecuado'] = $scope.tituloAdecuado(archivo); // Seleccionar el titulo a mostrar (en caso de que haya varios)
		archivo['titulo_visible'] = $scope.tituloVisible(archivo['titulo_adecuado']); // Coloca al final el artículo (gramátical del español) del "titulo_adecuado" (en caso de haber)
	};

	// Preprocesamiento de la información en todas las áreas de un audiovisual ($scope.allInfo)
	$scope.preprocesamientoUnidad = function(){
		// Cambios puntuales (específicos) y permanentes
		$scope.allInfo.identificacion.duracion = getDuracion($scope.allInfo.identificacion.duracion); // Parse desde filters.js
		$scope.allInfo.descripcion.fecha_de_descripcion = getFechaDescripcion($scope.allInfo.descripcion.fecha_de_descripcion); // Parse desde filters.js
		// Agregar nuevos campos "titulo_adecuado" y "titulo_visible":
		$scope.allInfo.secret = [];
		$scope.allInfo.secret['titulo_adecuado'] = $scope.tituloAdecuado($scope.allInfo.identificacion);
		$scope.allInfo.secret['titulo_visible'] = $scope.tituloVisible($scope.allInfo.secret['titulo_adecuado']);

		$scope.allInfoCopy = []; // Vaciar la copia actual
		for(var area in $scope.allInfo){
			$scope.allInfoCopy[area] = [];
			for(var campo in $scope.allInfo[area]){ // Aplicar modificaciones
				if(area !== 'adicional'){ // Porque la imagen y la url deben conservar el nombre original tal cual
					$scope.allInfo[area][campo] = $scope.allInfo[area][campo].trim().replace(/  */g, ' '); // Limpiar espacios vacios
					$scope.allInfo[area][campo] = ($scope.allInfo[area][campo].slice(-1) === '.') ? ($scope.allInfo[area][campo].slice(0, -1)) : ($scope.allInfo[area][campo]); // Eliminar punto al final
					$scope.allInfo[area][campo] = ($scope.allInfo[area][campo].length > 0) ? ($scope.allInfo[area][campo].charAt(0).toUpperCase() + $scope.allInfo[area][campo].slice(1)) : ($scope.allInfo[area][campo]); // Mayúscula la primera letra	
				}
				$scope.allInfoCopy[area][campo] = $scope.allInfo[area][campo];
				// Cambia URL por un ícono con hipervínculo
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/g,
					'<a href="$&" target="_blank" title="$&"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a>');
				// Cambiar "in situ" a itálicas
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/in situ/gi, '<em>$&</em>');
				// Cambiar "videorales" a itálicas
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/videorales/gi, '<em>$&</em>');
			}
		}
	};

	// Selecciona cual es mejor título para mostrar.
	// Debido a que un título puede incluir entre paréntesis la traducción "oficial" en español o tener uno o varios titulos paralelos.
	// La prioridad de selección es la siguiente: 
	//   1. titulo entre paréntesis 
	//   2. primer o único titulo paralelo
	//   3. título propio
	$scope.tituloAdecuado = function(archivo){
		// Prioridad por mostrar títulos parentizados en titulo_propio
		// if((matches = /\((.*)\)$/.exec(archivo.titulo_propio.trim())) !== null)
		// 	return matches[1];
		// De no ser el caso, prioridad a titulo_paralelo
		if (archivo.titulo_paralelo !== ''){
			var titulos = archivo.titulo_paralelo.split(","); // Puede haber varios títulos paralelos (separados por coma)
			if (titulos.length > 1) // De ser así, tomar solamente el primero
				return titulos[0].trim();
			// En caso contrario, tomar todo el titulo_paralelo
			return archivo.titulo_paralelo;
		}
		// En otro caso, solo existe titulo_propio
		return archivo.titulo_propio;
	};

	// Recibe un titulo_adecuado y en caso de iniciar con un artículo gramátical en español (el, la, los, las, etc.) lo escribe al final.
	// Ejemplo de conversión:
	// "La hora de los hornos" => "Hora de los hornos, La"
	// El resultado de esta función es (comúnmente) asignado a "titulo_visible"
	$scope.tituloVisible = function(titulo){
		var descomposicion = titulo.trim().split(" "); // Descomposición de palabras del título
		for(var i in articulos){ // Buscar en la lista de articulos
			if(articulos[i].indexOf(descomposicion[0].toLowerCase()) > -1){ // Si hay un artículo en la primera palabra del título
				descomposicion[descomposicion.length-1] = descomposicion[descomposicion.length-1] + "," // Agregar coma
				descomposicion[descomposicion.length] = descomposicion[0]; // Pasar articulo al final
				descomposicion[0] = "" // Borrar el artículo al inicio
				var newTitulo = descomposicion.join(' ').trim(); // Crear el nuevo título y quitar espacio vacio al inicio
				return newTitulo.charAt(0).toUpperCase() + newTitulo.slice(1); // Poner en mayúscula la primera letra
			}
		}
		return titulo; // En caso de que no haya artículo
	}

	// Auxiliar para recortar el título (cadena pasada como primer parámetro) en caso de que exceda el límite de longitud (entero pasado como segundo parámetro)
	// En caso de exceder el límite, se recorta el título a maxLength y se agregan puntos suspensivos.
	$scope.recortarTitulo = function(titulo, maxLength){
		return (titulo.length > maxLength) ? (titulo.substring(0, maxLength) + "...") : (titulo);
	};

	// Dada la información del archivo (pasado como parámetro) devuelve el titulo paralelo en cado de haberlo, en caso contrario devuelve el titulo propio.
	// Acorta el texto y agrega "..." para adecuarlo a la vista en cuadrícula de la colección.
	$scope.tituloApropiado = function(archivo){
		var maxLength = 40; // Longitud máxima permitida (para la vista)
		// Prioridad por mostrar títulos parentizados en titulo_propio
		if((matches = /\((.*)\)$/.exec(archivo.titulo_propio.trim())) !== null)
			return (matches[1].length > maxLength) ? (matches[1].substring(0,maxLength) + "...") : (matches[1]);
		// De no ser el caso, prioridad a titulo_paralelo
		if (archivo.titulo_paralelo !== ''){
			var titulos = archivo.titulo_paralelo.split(","); // Puede haber varios títulos paralelos (separados por coma)
			if (titulos.length > 1) // De ser así, tomar solamente el primero
				return (titulos[0].trim().length > maxLength) ? (titulos[0].trim().substring(0,maxLength) + "...") : (titulos[0].trim());
			// En caso contrario, tomar todo el titulo_paralelo
			return (archivo.titulo_paralelo.length > maxLength) ? (archivo.titulo_paralelo.substring(0,maxLength) + "...") : (archivo.titulo_paralelo);
		}
		// En otro caso, solo existe titulo_propio
		return (archivo.titulo_propio.length > maxLength) ? (archivo.titulo_propio.substring(0,maxLength) + "...") : (archivo.titulo_propio);
	};

	// Crea un documento PDF con la biblioteca pdfmake(.min).js y al final se abre el PDF en el navegador
	$scope.openPDF = function(){
		var docDefinition = {
			footer: function(currentPage, pageCount) { 
				//return {text: currentPage.toString() + ' de ' + pageCount, alignment: 'right'};
				return {
					style: 'table',
					table: {
						widths: [28, '*', 50, 28],
						body: [
							[
								'',
								{text: 'Laboratorio Audiovisual de Investigación Social. Instituto Mora.', fontSize: 10, italics: true, alignment: 'left'},
								{text: currentPage.toString() + ' de ' + pageCount, italics: true, alignment: 'right'},
								''
							]
						]
					},
					layout: 'noBorders'
				}
			},
			header: {text: '"' + $scope.allInfoCopy.secret.titulo_adecuado + '"', fontSize: 10, italics: true, alignment: 'right', margin: [25,25,50,50]},
			content: [
				{image: 'mora_lais', fit: [110, 40], alignment: 'right'},
				{text: 'Ficha de catalogación', style: 'header'},
				{
					text: [
						'Documentación de la colección de materiales audiovisuales del Laboratorio Audiovisual de Investigación Social del Instituo Mora para el documental "',
						{text: $scope.allInfoCopy.secret.titulo_adecuado, italics: true, bold: true},
						'".'
					]
				},
				$scope.title2pdfmake($scope.allInfoCopy.identificacion, 'Área de identificación'),
				$scope.array2pdfmake($scope.allInfoCopy.identificacion),
				$scope.title2pdfmake($scope.allInfoCopy.contexto, 'Área de contexto'),
				$scope.array2pdfmake($scope.allInfoCopy.contexto),
				$scope.title2pdfmake($scope.allInfoCopy.contenido_y_estructura, 'Área de contenido y estructura'),
				$scope.array2pdfmake($scope.allInfoCopy.contenido_y_estructura),
				$scope.title2pdfmake($scope.allInfoCopy.condiciones_de_acceso, 'Área de condiciones de acceso'),
				$scope.array2pdfmake($scope.allInfoCopy.condiciones_de_acceso),
				$scope.title2pdfmake($scope.allInfoCopy.documentacion_asociada, 'Área de documentación asociada'),
				$scope.array2pdfmake($scope.allInfoCopy.documentacion_asociada),
				$scope.title2pdfmake($scope.allInfoCopy.notas, 'Área de notas'),
				$scope.array2pdfmake($scope.allInfoCopy.notas),
				(function(){
					return ($scope.allInfoCopy.adicional.imagen === '') ? "" : {text: 'Portada', style: 'subheader'}
				})(),
				(function(){
					return ($scope.allInfoCopy.adicional.imagen === '') ? "" : {image: getBase64Image(document.getElementById("imgPortada")), width: 150 }
				})(),
				{
					text: "Fecha de consulta: " + $scope.getTodayDate() + ".", fontSize: 10, margin: [0, 10]
				}
			],
			styles: {
				header: {
					fontSize: 22,
					bold: true,
					margin: [0, 0, 0, 10]
				},
				subheader: {
					fontSize: 16,
					bold: true,
					margin: [0, 10, 0, 5]
				},
				table: {
					margin: [0, 5, 0, 15]
				}
			},
			images: {
				mora_lais: 'data:image/png;base64,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'
			}
		};
		// open the PDF in a new window
		pdfMake.createPdf(docDefinition).open();
	};

	// Convierte una imagen a base64. El parámetro se espera ser del tipo: document.getElementById("id-img-tag")
	function getBase64Image(img) {
		// Create an empty canvas element
		var canvas = document.createElement("canvas");
		canvas.width = $scope.imgActualWidth;
		canvas.height = $scope.imgActualHeight;

		// Copy the image contents to the canvas
		var ctx = canvas.getContext("2d");
		ctx.drawImage(img, 0, 0);

		// Get the data-URL formatted image
		// Firefox supports PNG and JPEG. You could check img.src to
		// guess the original format, but be aware the using "image/jpg"
		// will re-encode the image.
		var dataURL = canvas.toDataURL("image/jpeg");

		return dataURL;
		//return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
	}

	// Llamada asincrona para obtener el tamaño original de una imagen.
	// El ancho y largo se almacenan en $scope.imgActualWidth y $scope.imgActualHeight, respectivamente.
	function getImgSize(imgSrc) {
		var newImg = new Image();

		newImg.onload = function() {
		  var height = newImg.height;
		  var width = newImg.width;
		  //console.log('The image size is '+width+'*'+height);
		  $scope.imgActualWidth = width;
		  $scope.imgActualHeight = height;
		}

		newImg.src = imgSrc; // this must be done AFTER setting onload
	}

	// Agrega un título (en formato de pdfmake.js) si el área dada como parámetro no está vacia
	$scope.title2pdfmake = function(area, readableTitle){
		if(!$scope.isEmpty(area))
			return {
				text: readableTitle,
				style: 'subheader'
			}
		return '';
	};

	// Agrega el contenido del área como tabla (en formato de pdfmake.js) si el área dada como parámetro no está vacia
	$scope.array2pdfmake = function(area){
		if(!$scope.isEmpty(area))
			return {
				style: 'table',
				table: {
					widths: [100, '*'],
					body: $scope.content2pdfmake(area)
				},
				layout: {
					hLineWidth: function(i, node) {return (i === 0 || i === node.table.body.length) ? 0 : 1; },
					vLineWidth: function(i, node) {return 0; },
					hLineColor: function(i, node) {return 'gray'; },
					vLineColor: function(i, node) {return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray'; }
				}
			};
		return '';
	};

	// Auxiliar para imprimir cada campo de un área dada (se utiliza en array2pdfmake())
	$scope.content2pdfmake = function(area){
		var parsed = [];
		for(var key in area)
			if(area[key] !== '')
				parsed.push([$scope.encabezados[key], area[key]]);
		return parsed;
	};

	// Devuelve la fecha del día de hoy en el formato dd/mm/aa
	$scope.getTodayDate = function(){
		var hoy = new Date();
		return hoy.getDate() + "/" + (hoy.getMonth()+1) + "/" + hoy.getFullYear();
	};

	// Determina si un area está vacia. Un área se considera vacía si todos sus campos contienen cadena vacía
	$scope.isEmpty = function(area){
		var rubro = "";
    	for(rubro in area)
    		if(area[rubro] !== '')
    			return false;
    	return true;
	}

	// ########## ADMINISTRACIÓN DE LOS AUDIOVISUALES (AGREGAR, EDITAR, BORRAR) ##########

	// Acción del icono para agregar un nuevo audiovisual
    $scope.agregarNuevo = function(decada){
    	agregarNuevoAll.agregarNew(decada);
    }

	// Acción al presionar el icono de edición
	$scope.editar = function(id){
		$('#modalInfo').modal('hide'); // Ocultar modal
		$('body').removeClass('modal-open'); // Eliminar del DOM
		$('.modal-backdrop').remove();
		$location.url('/archivos/editarArchivo/' + id); // Redirigir a la página de edición
    }

    
    // Acción del icono para eliminar/borrar
    $scope.eliminar = function(id){
    	var user = $cookieStore.get('nombre'); // nombre del usuario que realiza el borrado
    	$http.post('php/manejoBD.php?action=borrar',
		{
			'codigo_de_referencia': id,
			'user': user ? user : ''
		}).
		success(function(data, status, headers, config) {
			alert("Registro eliminado");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error en la conexión");
		});
    }

    //Función que confirma la eliminación de un registro mediante un password
    $scope.confirmar = function(usuario, pass){
    	$scope.errores = false;
    	$http.post('php/manejoBD.php?action=getPassword',{
    		'Username' : usuario
    	}).success(function(data){
    		if(data.Password === pass){ //Verifica las contraseñas
    			$scope.eliminar($scope.allInfo.identificacion.codigo_de_referencia);
    		}else{
    			//console.log("error de verificacion");
    			$scope.errores = true;
    		}
    	});
		
    }

    //Función que ocula la información de un registro
    $scope.hideInfos = function(){
    	$scope.hideInfo = !$scope.hideInfo;
    }

    // Auxiliar para obtener los rubros de manera no-ordenada alfabeticamente
    $scope.notSort = function(obj){
    	if (!obj)
    		return [];
    	return Object.keys(obj);
    }
});

//Controlador que hace post para agregar datos a la base de datos y recupera los datos desde el html
lais.controller('agregarDatosCtrl',function($scope, $http, $location, Upload, ParamService, $cookieStore){
	// Impide acceso no autorizado en la página
	if(!$scope.sesion && !$scope.permiso >= 1){
		console.log('No hay permisos suficientes para estar en esta página');
		$location.url('/decadas/');
	}

	$scope.inputFuentes = [
		{name: "Entrevistas", ticked: false},
		{name: "Grabación de campo", ticked: false},
		{name: "Ficción", ticked: false},
		{name: "Documentales", ticked: false},
		{name: "Registros fílmicos", ticked: false},
		{name: "Fotografías", ticked: false},
		{name: "Pinturas", ticked: false},
		{name: "Grabados", ticked: false},
		{name: "Hemerografía", ticked: false},
		{name: "Cartografía", ticked: false},
		{name: "Testimonios orales", ticked: false},
		{name: "Testimonios videorales", ticked: false},
		{name: "Noticieros fílmicos", ticked: false},
		{name: "Programas de tv", ticked: false},
		{name: "Publicidad", ticked: false},
		{name: "Videoclips", ticked: false},
		{name: "Dibujos", ticked: false},
		{name: "Multimedia", ticked: false},
		{name: "Música de época", ticked: false},
		{name: "Documentos", ticked: false},
		{name: "Registros fonográficos", ticked: false},
		{name: "Registros videográficos", ticked: false}
	];

	$scope.inputRecursos = [
		{name: "Puesta en escena", ticked: false},
		{name: "Animación", ticked: false},
		{name: "Incidentales", ticked: false},
		{name: "Narración en off", ticked: false},
		{name: "Conducción", ticked: false},
		{name: "Intertítulos", ticked: false},
		{name: "Interactividad", ticked: false},
		{name: "Musicalización", ticked: false},
		{name: "Gráficos", ticked: false},
		{name: "Audiovisuales", ticked: false}
	];

	$scope.localLang = {
		selectAll       : "Seleccionar todos",
		selectNone      : "Seleccionar ninguno",
		reset           : "Reset",
		search          : "Busqueda",
		nothingSelected : "Nada seleccionado aún"
	};

	$scope.createFuentes = function(){
		$scope.fuentes = "";
		for(var i in $scope.outputFuentes){
			$scope.fuentes = $scope.fuentes + $scope.outputFuentes[i].name + ", ";
		}
		$scope.fuentes = $scope.fuentes.trim();
		$scope.fuentes = ($scope.fuentes.length > 0 && $scope.fuentes.slice(-1) === ',') ? ($scope.fuentes.slice(0, -1)) : ($scope.fuentes); // Quitar "," final
		console.log("fuentes: " + $scope.fuentes);
	};

	$scope.createRecursos = function(){
		$scope.recursos = "";
		for(var i in $scope.outputRecursos){
			$scope.recursos = $scope.recursos + $scope.outputRecursos[i].name + ", ";
		}
		$scope.recursos = $scope.recursos.trim();
		$scope.recursos = ($scope.recursos.length > 0 && $scope.recursos.slice(-1) === ',') ? ($scope.recursos.slice(0, -1)) : ($scope.recursos); // Quitar "," final
		console.log("recursos: " + $scope.recursos);
	};

	//$scope.errorDuplicado = false; // DEPRECATED. La función sugerencias() ya impide repetidos.

	//$scope.investigacion = [{nombre:""}];
	//$scope.realizacion = [{nombre:""}];
	/*$scope.agregar = function(scopeVar){
		//console.log("length", scopeVar.length);
		scopeVar.push({
			nombre: ""
		});
	};

	$scope.eliminar = function(scopeVar){
		scopeVar.pop();
	};*/

	// Establece el código de referencia con numeración consecutiva
	$scope.codigoDecada = $cookieStore.get('decada');
	//console.log("codigoDecada:", $scope.codigoDecada);

	$http.get('php/manejoBD.php?action=getIndice&decada=' + $scope.codigoDecada).
	success(function(data, status, headers, config) {
		$scope.codigo_de_referencia = $scope.codigoDecada + '-' + data;
	}).
	error(function(data, status, headers, config) {
		alert("Error de conexión");
	});

	// Acción al presionar el botón de "Enviar" del formulario
	// Recibe como parámetro el archivo de imagen (único elemento que se sube a parte)
	$scope.envia = function(files){
		//console.log("datos para el servidor: ", ParamService.scopeData2object($scope));
		$http.post('php/manejoBD.php?action=agregar', 
			ParamService.scopeData2object($scope) // Encapsular todos los datos para el servidor
		).success(function(data, status, headers, congif){
			//console.log("información de documental enviada");
			if(data.Status !== 'Ok'){ // Si hay algún error en la base de datos
				//alert("El archivo Audiovisual está duplicado");
				$scope.errorDuplicado = true;
				console.log("Duplicado!");
				alert("Hubo un error con la base de datos.\nPor favor intente más tarde.")
				return;
			}
			//console.log("en proceso de envio...");
			$scope.upload(files); // Subir la imagen después de crear el registro en la base
			//console.log("información agregada correctamente");
			alert("La información del documental ha sido agregada");
			$location.url('/decadas/');
		}).error(function(error){
			console.log("Error en envio de los datos: " + error);
		});
	}

	// Cancela el envio de datos al redirigir a la página /decadas
	$scope.cancela = function(){
		$location.url('/decadas/');
	};

	// Funciones auxiliares para subir archivos (imagenes)
	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });
    // Función que hace el "trabajo sucio" de pedir a PHP que suba la imagen al servidor y a la base de datos
    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: 'php/upload.php', // Script que maneja la imagen
                    method: 'POST',
                    sendFieldsAs: 'form',
                    fields: {'codigo_de_referencia': $scope.codigo_de_referencia}, // Datos adicionales
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                });
            }
        }
    };

    // Autocorrige el código de identificación para mantener la numeración correcta en la base de datos
    $scope.sugerencias = function(){
    	if($scope.codigo_de_referencia !== undefined){ // Porque que no se hace asignación (valor undefined) si el campo es inválido
    		$http.get('php/manejoBD.php?action=sugerencia&clave=' + $scope.codigo_de_referencia).
			success(function(data, status, headers, config) {
				// Asigna el nuevo codigo_de_referencia (data contiene el número sugerido, revisar manejoBD.php para detalles)
				$scope.codigo_de_referencia = $scope.codigo_de_referencia.substring(0, $scope.codigo_de_referencia.search(/-\d{1,4}$/)) + "-" + data;
			}).
			error(function(data, status, headers, config) {
				alert("Error de conexión");
			});
    	}
    };
});

// Edición de audiovisuales
lais.controller('edicionCtrl', function($scope, $http, $routeParams, $location, Upload, ParamService){
	// Impide acceso no autorizado en la página
	if(!$scope.sesion && !$scope.permiso >= 2){
		console.log('No hay permisos suficientes');
		$location.url('/decadas/');
	}

	$scope.inputFuentes = [
		{name: "Entrevistas", ticked: false},
		{name: "Grabación de campo", ticked: false},
		{name: "Ficción", ticked: false},
		{name: "Documentales", ticked: false},
		{name: "Registros fílmicos", ticked: false},
		{name: "Fotografías", ticked: false},
		{name: "Pinturas", ticked: false},
		{name: "Grabados", ticked: false},
		{name: "Hemerografía", ticked: false},
		{name: "Cartografía", ticked: false},
		{name: "Testimonios orales", ticked: false},
		{name: "Testimonios videorales", ticked: false},
		{name: "Noticieros fílmicos", ticked: false},
		{name: "Programas de tv", ticked: false},
		{name: "Publicidad", ticked: false},
		{name: "Videoclips", ticked: false},
		{name: "Dibujos", ticked: false},
		{name: "Multimedia", ticked: false},
		{name: "Música de época", ticked: false},
		{name: "Documentos", ticked: false},
		{name: "Registros fonográficos", ticked: false},
		{name: "Registros videográficos", ticked: false}
	];

	$scope.inputRecursos = [
		{name: "Puesta en escena", ticked: false},
		{name: "Animación", ticked: false},
		{name: "Incidentales", ticked: false},
		{name: "Narración en off", ticked: false},
		{name: "Conducción", ticked: false},
		{name: "Intertítulos", ticked: false},
		{name: "Interactividad", ticked: false},
		{name: "Musicalización", ticked: false},
		{name: "Gráficos", ticked: false},
		{name: "Audiovisuales", ticked: false}
	];

	// Obtener todos los datos de cada campo desde la base
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
		//$scope.fuentes = $scope.getFuente(data.fuentes); //getFuenteRecurso(data.fuentes); // Parse desde filter.js
		$scope.getFuente(data.fuentes); //getFuenteRecurso(data.fuentes); // Parse desde filter.js
		//$scope.recursos = getFuenteRecurso(data.recursos); // Parse desde filter.js
		$scope.getRecurso(data.recursos);
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
		$scope.fecha_de_descripcion = new Date(data.fecha_de_descripcion);
		$scope.url = data.url;
		$scope.imagen_previa = data.imagen;
    });
    
	$scope.localLang = {
		selectAll       : "Seleccionar todos",
		selectNone      : "Seleccionar ninguno",
		reset           : "Reset",
		search          : "Busqueda",
		nothingSelected : "Nada seleccionado aún"
	};

	$scope.getFuente = function(fuenteString){
		var fuentes = fuenteString;
		fuentes = (fuentes === undefined) ? "" : fuentes.trim().replace(/  */g, ' ');
		fuentes = (fuentes.slice(-1) === '.' || fuentes.slice(-1) === ',') ? (fuentes.slice(0, -1)) : (fuentes);
		var fuentesArray = fuentes.split(",");
		for(var i in fuentesArray){
			var fuente = fuentesArray[i].trim().toLowerCase();
			fuente = (fuente.length > 0) ? (fuente.charAt(0).toUpperCase() + fuente.slice(1)) : (fuente);
			for(var j in $scope.inputFuentes){
				if(($scope.inputFuentes[j].name.indexOf(fuente) > -1) && (fuente !== '')){ // Si es la misma fuente (y si split no creó la cadena vacia)
					$scope.inputFuentes[j].ticked = true;
				}
			}
		}
	};

	$scope.getRecurso = function(recursoString){
		//console.log("recursos originales: ", recursoString);
		var recursos = recursoString;
		recursos = (recursos === undefined) ? "" : recursos.trim().replace(/  */g, ' ');
		recursos = (recursos.slice(-1) === '.' || recursos.slice(-1) === ',') ? (recursos.slice(0, -1)) : (recursos);
		var recursosArray = recursos.split(",");
		for(var i in recursosArray){
			var recurso = recursosArray[i].trim().toLowerCase();
			recurso = (recurso.length > 0) ? (recurso.charAt(0).toUpperCase() + recurso.slice(1)) : (recurso);
			//console.log(i, recurso);
			for(var j in $scope.inputRecursos){
				if(($scope.inputRecursos[j].name.indexOf(recurso) > -1) && recurso !== ''){ // Si es la misma fuente (y si split no creó la cadena vacia)
					$scope.inputRecursos[j].ticked = true;
				}
			}
		}
	};

	$scope.createFuentes = function(){
		$scope.fuentes = "";
		for(var i in $scope.outputFuentes){
			$scope.fuentes = $scope.fuentes + $scope.outputFuentes[i].name + ", ";
		}
		$scope.fuentes = $scope.fuentes.trim();
		$scope.fuentes = ($scope.fuentes.length > 0 && $scope.fuentes.slice(-1) === ',') ? ($scope.fuentes.slice(0, -1)) : ($scope.fuentes); // Quitar "," final
		console.log("fuentes: " + $scope.fuentes);
	};

	$scope.createRecursos = function(){
		$scope.recursos = "";
		for(var i in $scope.outputRecursos){
			$scope.recursos = $scope.recursos + $scope.outputRecursos[i].name + ", ";
		}
		$scope.recursos = $scope.recursos.trim();
		$scope.recursos = ($scope.recursos.length > 0 && $scope.recursos.slice(-1) === ',') ? ($scope.recursos.slice(0, -1)) : ($scope.recursos); // Quitar "," final
		console.log("recursos: " + $scope.recursos);
	};

    // Acción del botón "Editar" del formulario
    $scope.editar = function(files){
		$http.post('php/manejoBD.php?action=actualizar', 
			ParamService.scopeData2object($scope) // Encapsula y envia los datos a la base
		).success(function(data,status, headers, congif){
			$scope.upload(files); // Subir la imagen después de crear el registro en la base
			alert("La información del documental ha sido actualizada");
			$location.url('/decadas/');
		}).error(function(error){
			console.log("Error de los datos: " + error);
		});
	}

	// Cancela la edición al redirigir a la página /decadas
	$scope.cancela = function(){
		$location.url('/decadas/');
	};

    // Componentes para subir archivos (imagenes)
	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });
    // Función que hace el "trabajo sucio" de pedir a PHP que suba la imagen al servidor y a la base de datos
    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: 'php/upload.php', // Script que maneja la imagen
                    method: 'POST',
                    sendFieldsAs: 'form',
                    fields: {'codigo_de_referencia': $scope.codigo_de_referencia}, // Datos adicionales
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    console.log('file ' + config.file.name + 'uploaded. Response: ' + data);
                });
            }
        }
    };
});

//Controlador que verifica el login y logout 
lais.controller('datosAutentificacion', function($scope, $http, $cookieStore, $location, $window){
	//$scope.permiso = 0; //Variable que guarda el permiso de cada usuario
	$scope.errores = false; //Variable para mostrar erros de iniciar sesión con los usuarios
	$scope.sesion = $cookieStore.get('sesion'); //Cookie para recodar la sesión del usuario
	$scope.user = $cookieStore.get('nombre'); //Cookie para recordar el nombre del usuario
	$scope.permiso = $cookieStore.get('permiso'); //Cookie para recordar el permiso del usuario
	
	//Funcion que verifica el login con username y password mandandolos a la base de datos
	//mediante post
	$scope.login= function(){
		$http.post('php/manejoBD.php?action=login',
			{
				'Username' : $scope.usuario,
				'Password' : $scope.pass
			}).success(function(data,status,headers,config){
				console.log("Se mandaron los datos");
				if($scope.usuario == data.Username && $scope.pass == data.Password){
					$cookieStore.put('sesion','true'); //Iniciamos el Cookie de iniciar sesion a true
					$cookieStore.put('nombre',data.Username); //Iniciamos el Cookie con el nombre de usuario que recibimos en la petición de la base de datos
					$cookieStore.put('permiso',data.Privilegio); //Iniciamos el Cookie de permiso con base a los privilegios que tiene el usuario
					$scope.sesion = $cookieStore.get('sesion'); //Obtenemos el cookie de iniciar sesion
					$scope.user = $cookieStore.get('nombre'); //Obtenemos el cookie del nombre del usuario
					$scope.permiso = $cookieStore.get('permiso'); //Obtenemos el cookie del permiso del susuario
					$scope.agregar = true;
					//console.log("En sesion\n"+ $scope.sesion);
					//console.log($scope.permiso);
					//console.log("Usuario\n"+ $scope.user);

					$window.location.reload(false);
					//console.log("Usuario\n"+ $scope.usuario);
					//$location.reload(true);
				}else{ 
					$cookieStore.remove('sesion'); //Removemos el cookie sesion del usuario
					$cookieStore.remove('nombre'); //Removemos el cookie del nombre del usuario
					$cookieStore.remove('permiso'); //Removemos el cookie del permiso del usuario
					//Inicamos las variables para que se muestren los errores de iniciar sesion
					$scope.sesion = false;  
					$scope.errores = true; 
					$scope.permiso = 0;
					$scope.usuario = "";
					$scope.pass = "";
				}
			}).error(function(data){
				console.log("ERROR");
			});
	}
	//Función que hace el logout de un usuario
	$scope.logout = function(){
		//Removemos los cookies ya que ha cerrado sesion
		$cookieStore.remove('sesion');
		$cookieStore.remove('nombre');
		$cookieStore.remove('permiso');
		$scope.sesion = false;
		$scope.permiso = 0;
		$scope.usuario = "";
		$scope.pass = "";
		$location.url('/inicio');
	}
});

// Mini-controlador de la barra de búsqueda
lais.controller('busquedaFormCtrl',function($scope, $location){
	// Acción al presionar el botón de búsqueda en la barra superior de la página
	$scope.busqueda = function(query){
		if(query === undefined)
			return;
		var texto = query.replace(/\s+/g, " ").trim().toLowerCase(); // Eliminar espacios en blanco y pasar a minúsculas
		if(texto.length > 0)
    		$location.url('/archivos/busqueda/' + texto);
    }
});

// Permite mostrar los resultados de una búsqueda
// (Actualmente ya no se ocupa)
lais.controller('busquedaCtrl',function($scope, $http, $routeParams, $location){
	$scope.query = $routeParams.query; // Obtener query desde la barra de dirección
	$http.get('php/manejoBD.php?action=buscar&query=' + $routeParams.query)
	    .success(function(data) {
	        $scope.datos = data; // Resultados de la búsqueda
	    })
	    .error(function(data, status, headers, config) {
			// called asynchronously if an error occurs or server returns response with an error status.
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});
});

// Pequeño controlador especificamente creado para el formulario de contacto.
lais.controller('contactCtrl', function($scope, $http){
	// El formulario tiene las siguientes variables definidas en la vista (index.html):
	// $scope.name, $scope.message, $scope.email;

	// Envia la información del formulario para que el correo se envié por "manejoBD.php"
	$scope.enviar = function(){
		$('#contactModal').modal('hide'); // cerrar modal (porque el envio bloqueará un par de segundos la página)
		// enviar correo mediate PHPmailer:
		$http.post('php/manejoBD.php?action=mail',
		{
			'Name': $scope.name,
			'Message': $scope.message,
			'Email': $scope.email
		}).
		success(function(data, status, headers, config) {
			// if comentado porque el envio es síncrono y no funciona correctamente la comprobación
			//if(data.success){ // Si el mensaje se envió correctamente desde "manejoBD.php"
				$scope.name = "";
				$scope.message = "";
				$scope.email = "";
				alert("Mensaje enviado.\nGracias por tu opinión.");
			//}
		}).
		error(function(data, status, headers, config) {
			alert("Error de conexión. Es probable que la señal de internet sea baja, revisa la conexión e intenta nuevamente.");
		});
	};
});

//Administración de usuarios
lais.controller('adminUserCtrl',function($scope,$http, $location){
	// Impide acceso no autorizado en la página
	if(!$scope.sesion && !($scope.permiso >= 3)){
		console.log('No hay permisos suficientes');
		$location.url('/inicio');
	}
	
	$scope.nombreAuxiliar = ''; //Guardar el nombre del usuario temporalmente
	$scope.edit = false;
	$scope.privilegios = { // Renombre de los permisos de usuario a un número (como en la base de datos)
		"0": "Sin Permisos",
		"1": "Agregar",
		"2": "Agregar y Editar",
		"3": "Agregar, Editar y Eliminar"
	};
	//Variable que nos ayuda mostrar los errores de que se a duplicado un usuario al crear uno nuevo
	$scope.errorDuplicadoLogin = false;

	// $scope.datos contiene todos los usuarios (ver función getDatos)
	getDatos(); // Inicializacion, $scope.datos se llena.
	
	// Acción al dar clic en el botón "Enviar". Agrega los datos del nuevo usuario a la base.
	$scope.enviar = function(){
		$http.post('php/manejoBD.php?action=agregarUsuario',
		{
			'Username': $scope.nombre,
			'Password': $scope.password,
			'Privilegio': $scope.privilegio
		}).
		success(function(data, status, headers, config) {
			if(data.Status === undefined){ // Cuando no recibimos respuesta de la base, es porque el nombre de usuario está repetido
				$scope.errorDuplicadoLogin = true;
				return;
			}
			alert("Nuevo usuario registrado exitosamente.");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error de conexión durante envio de datos.");
		});
	}

    // Acción al dar clic en el botón "Editar". Actualiza los datos de un usuario existente en la base.
    $scope.actualizar = function(){
    	$scope.errorDuplicadoLogin = false;
    	$http.post('php/manejoBD.php?action=actualizarUsuario',
		{
			'Username': $scope.nombre, // Nombre nuevo
			'Password': $scope.password,
			'Privilegio': $scope.privilegio,
			'nombreAuxiliar': $scope.nombreAuxiliar // Nombre 'anterior' (no necesariamente igual a $scope.nombre)
		}).
		success(function(data, status, headers, config) {
			if(data.Status === undefined){ // Cuando no recibimos respuesta de la base, es porque el nombre de usuario está repetido
				$scope.edit = true;
				$scope.errorDuplicadoLogin = true;
				return;
			}
			$scope.edit = false;
			alert("Datos de usuario actualizados exitosamente.");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error de conexión al enviar datos de actualización.");
		});
    }

    // Acción al dar clic en el botón de editar (icono de lápiz)
	// Reasigna los valores de los campos por los del usuario seleccionado (parámetro 'nombre') para editarlos
	$scope.editar = function(nombre){
    	$scope.edit = true;
    	$scope.nombreAuxiliar = nombre; // Recuerda y permite cambiar el nombre de usuario durante la consulta SQL
    	$http.get('php/manejoBD.php?action=obtenerUsuario&name=' + nombre).
    	success(function(data,status) {
	        $scope.nombre = data.Username;
	        $scope.password = data.Password;
	        $scope.privilegio = data.Privilegio;
	      	$scope.errorDuplicadoLogin = false;
	    }).
	    error(function(data, status, headers, config) {
			alert("Error de conexión durante envio de datos.");
		});
    }

    // Acción al dar clic en el botón de borrar (icono de tache)
    // Elimina el registro de la base de datos
    $scope.eliminar = function(nombre){
    	$http.post('php/manejoBD.php?action=borrarUsuario',
		{
			'Username': nombre
		}).
		success(function(data, status, headers, config) {
			alert("El usuario fué eliminado de la base de datos.");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error de conexión al borrar al usurio.");
		});
    }

    // Obtener todos los registros existentes de los usuarios en la base de datos
    function getDatos(){
    	$http.get('php/manejoBD.php?action=verUsuarios').
	    success(function(data) {
	        $scope.datos = data;
	    });
    };
});

lais.controller('controlDatosCtrl', function($scope, $http, $location, DecadaService){
	if(!$scope.sesion && !($scope.permiso >= 3)){
		console.log('No hay permisos suficientes');
		$location.url('/inicio');
	}

	$scope.totales = {}; // Guarda las cantidades de los documentales con información faltante
	/* Ejemplo:
		$scope.totales = {
			documentales: 900,
			sinopsis: 750,
			pais: 800,
			fecha: 855,
			duracion: 798,
			realizacion: 777,
			fuentes: 701,
			recursos: 710,
			imagen: 120,
			url: 56
		};
	*/
	$scope.decadas = []; // Contiene los códigos de referencia de las décadas existentes en la base de datos (ejemplo: MXIMIM-AV-1-4)
	$scope.faltantes = []; // Guarda la lista de los documentales (código y nombre) con alguna información específica faltante
	$scope.decada = 'MXIM-AV-1'; // Código de la década que se muestra en pantalla. Por default: toda la colección
	// Objeto para mostrar textos de apoyo en la vista:
	$scope.infoDecadas = {
		"MXIM-AV-1-14": {fecha: "2020", titulo: "2020 a 2030"},
		"MXIM-AV-1-13": {fecha: "2010", titulo: "2010 a 2020"},
		"MXIM-AV-1-12": {fecha: "2000", titulo: "2000 a 2010"},
		"MXIM-AV-1-11": {fecha: "1990", titulo: "1990 a 2000"},
		"MXIM-AV-1-10": {fecha: "1980", titulo: "1980 a 1990"},
		"MXIM-AV-1-9": {fecha: "1970", titulo: "1970 a 1980"},
		"MXIM-AV-1-8": {fecha: "1960", titulo: "1960 a 1970"},
		"MXIM-AV-1-7": {fecha: "1950", titulo: "1950 a 1960"},
		"MXIM-AV-1-6": {fecha: "1940", titulo: "1940 a 1950"},
		"MXIM-AV-1-5": {fecha: "1930", titulo: "1930 a 1940"},
		"MXIM-AV-1-4": {fecha: "1920", titulo: "1920 a 1930"},
		"MXIM-AV-1-3": {fecha: "1910", titulo: "1910 a 1920"},
		"MXIM-AV-1-2": {fecha: "1900", titulo: "1900 a 1910"},
		"MXIM-AV-1-1": {fecha: "1890", titulo: "1890 a 1900"},
		"MXIM-AV-1": {fecha: "Todo", titulo: "toda la colección"}
	};
	$scope.campo = ''; // Auxiliar para mostrar el campo específico consultado en la vista. Se asigna en la función "getFaltantes"

	// ***** INICIALIZACIÓN ****
	// Obtener los códigos de las décadas. Sirve para mostrar los botones por época en la vista
	$http.get('php/manejoBD.php?action=mostrarDecadas')
		.success(function(data){
			$scope.decadas = data;
		})
		.error(function(data, status, headers, config){
			console.log("Error de conexión en la base.");
		});

	// Obtener las cifras de los documentales con información faltante. Por default, obtener la información de toda la colección.
	$http.get('php/manejoBD.php?action=estadisticas&decada=' + $scope.decada)
    	.success(function(data,status) {
	        $scope.totales = {
				documentales: data.documentales,
				sinopsis: data.sinopsis,
				pais: data.pais,
				fecha: data.fecha,
				duracion: data.duracion,
				realizacion: data.realizacion,
				fuentes: data.fuentes,
				recursos: data.recursos,
				imagen: data.imagen,
				url: data.url
			};
	    })
	    .error(function(data, status, headers, config) {
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});

	// Se manda a llamar cada vez que el usuario da clic en un botón con una década.
	// Las cantidades de documentales se actualizan en la variable "$scope.totales" según la década seleccionada.
	$scope.setDecada = function(decada){
		$scope.decada = decada;
		$http.get('php/manejoBD.php?action=estadisticas&decada=' + $scope.decada)
	    	.success(function(data,status) {
		        $scope.totales = {
					documentales: data.documentales,
					sinopsis: data.sinopsis,
					pais: data.pais,
					fecha: data.fecha,
					duracion: data.duracion,
					realizacion: data.realizacion,
					fuentes: data.fuentes,
					recursos: data.recursos,
					imagen: data.imagen,
					url: data.url
				};
		    })
		    .error(function(data, status, headers, config) {
				alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
			});
	};

	// Se manda a llamar cada vez que se da clic en el botón al lado de una gráfica para obtener el listado específico
	// de los documentales con información faltante.
	// La lista "$scope.faltantes" contiene objetos con dos propiedades: el código de referencia y el título propio del documental
	$scope.getFaltantes = function(campo){
		var area = ''; // Auxiliar para determinar si la consulta requiere un NATURAL JOIN

		// Si la información requerida no está en la tabla "area_de_identificacion", entonces es necesario
		// incluir el nombre del campo en la petición GET para realizar un NATURAL JOIN
		switch(campo){
			case "sinopsis":
				area = 'area_de_contenido_y_estructura'
				break;
			case "imagen":
				area = 'informacion_adicional'
				break;
			case "url":
				area = 'informacion_adicional'
				break;
			case "fuentes":
				area = 'area_de_contenido_y_estructura'
				break;
			case "recursos":
				area = 'area_de_contenido_y_estructura'
				break;
		}

		$http.get('php/manejoBD.php?action=detalles&decada=' + $scope.decada + '&campo=' + campo + '&area=' + area)
	    	.success(function(data,status) {
		        $scope.faltantes = data;
		        $scope.campo = campo; // texto para usar en la vista
		    })
		    .error(function(data, status, headers, config) {
				alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
			});
	};

	// ##### Las siguientes funciones son copia directa del controlador "muestraDecadaCtrl" #####

	// Obtener toda la información de un audiovisual particular. Recibe el código de identificación
	$scope.getAllInfo = function(codigoId){
		$scope.hideInfo = false; //Inicializar el botón de ver más para que siempre este visible
		//console.log("codigo: " + codigoId);
		$http.get('php/manejoBD.php?action=obtenerXAreas&id=' + codigoId).
    	success(function(data) {
    		$scope.allInfo = data;
    		// Limpiar algunos campos:
    		$scope.preprocesamientoUnidad();
    		//getImgSize('imgs/Portadas/' + $scope.allInfo.adicional.imagen); // Llamada asincrona para obtener el ancho y largo original ($scope.imgActualWidth, $scope.imgActualHeight)
    		console.log($scope.allInfo);
    	}).
    	error(function(data, status, headers, config) {
			// called asynchronously if an error occurs or server returns response with an error status.
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});
	};

	// Preprocesamiento de la información en todas las áreas de un audiovisual ($scope.allInfo)
	$scope.preprocesamientoUnidad = function(){
		// Cambios puntuales (específicos) y permanentes
		$scope.allInfo.identificacion.duracion = getDuracion($scope.allInfo.identificacion.duracion); // Parse desde filters.js
		$scope.allInfo.descripcion.fecha_de_descripcion = getFechaDescripcion($scope.allInfo.descripcion.fecha_de_descripcion); // Parse desde filters.js
		// Agregar nuevos campos "titulo_adecuado" y "titulo_visible":
		$scope.allInfo.secret = [];
		$scope.allInfo.secret['titulo_adecuado'] = $scope.tituloAdecuado($scope.allInfo.identificacion);
		$scope.allInfo.secret['titulo_visible'] = $scope.tituloVisible($scope.allInfo.secret['titulo_adecuado']);

		$scope.allInfoCopy = []; // Vaciar la copia actual
		for(var area in $scope.allInfo){
			$scope.allInfoCopy[area] = [];
			for(var campo in $scope.allInfo[area]){ // Aplicar modificaciones
				if(area !== 'adicional'){ // Porque la imagen y la url deben conservar el nombre original tal cual
					$scope.allInfo[area][campo] = $scope.allInfo[area][campo].trim().replace(/  */g, ' '); // Limpiar espacios vacios
					$scope.allInfo[area][campo] = ($scope.allInfo[area][campo].slice(-1) === '.') ? ($scope.allInfo[area][campo].slice(0, -1)) : ($scope.allInfo[area][campo]); // Eliminar punto al final
					$scope.allInfo[area][campo] = ($scope.allInfo[area][campo].length > 0) ? ($scope.allInfo[area][campo].charAt(0).toUpperCase() + $scope.allInfo[area][campo].slice(1)) : ($scope.allInfo[area][campo]); // Mayúscula la primera letra	
				}
				$scope.allInfoCopy[area][campo] = $scope.allInfo[area][campo];
				// Cambia URL por un ícono con hipervínculo
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/g,
					'<a href="$&" target="_blank" title="$&"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a>');
				// Cambiar "in situ" a itálicas
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/in situ/gi, '<em>$&</em>');
				// Cambiar "videorales" a itálicas
				$scope.allInfo[area][campo] = $scope.allInfo[area][campo].replace(/videorales/gi, '<em>$&</em>');
			}
		}
	};

	// Selecciona cual es mejor título para mostrar.
	// Debido a que un título puede incluir entre paréntesis la traducción "oficial" en español o tener uno o varios titulos paralelos.
	// La prioridad de selección es la siguiente: 
	//   1. titulo entre paréntesis 
	//   2. primer o único titulo paralelo
	//   3. título propio
	$scope.tituloAdecuado = function(archivo){
		// Prioridad por mostrar títulos parentizados en titulo_propio
		if((matches = /\((.*)\)$/.exec(archivo.titulo_propio.trim())) !== null)
			return matches[1];
		// De no ser el caso, prioridad a titulo_paralelo
		if (archivo.titulo_paralelo !== ''){
			var titulos = archivo.titulo_paralelo.split(","); // Puede haber varios títulos paralelos (separados por coma)
			if (titulos.length > 1) // De ser así, tomar solamente el primero
				return titulos[0].trim();
			// En caso contrario, tomar todo el titulo_paralelo
			return archivo.titulo_paralelo;
		}
		// En otro caso, solo existe titulo_propio
		return archivo.titulo_propio;
	};

	$scope.encabezados = DecadaService.encabezados;
	var articulos = ["el", "la", "los", "las", "un", "una", "unos", "unas", "lo", "al", "del"]; // Lista de artículos en español (útil para corregir los nombres)

	// Recibe un titulo_adecuado y en caso de iniciar con un artículo gramátical en español (el, la, los, las, etc.) lo escribe al final.
	// Ejemplo de conversión:
	// "La hora de los hornos" => "Hora de los hornos, La"
	// El resultado de esta función es (comúnmente) asignado a "titulo_visible"
	$scope.tituloVisible = function(titulo){
		var descomposicion = titulo.trim().split(" "); // Descomposición de palabras del título
		for(var i in articulos){ // Buscar en la lista de articulos
			if(articulos[i].indexOf(descomposicion[0].toLowerCase()) > -1){ // Si hay un artículo en la primera palabra del título
				descomposicion[descomposicion.length-1] = descomposicion[descomposicion.length-1] + "," // Agregar coma
				descomposicion[descomposicion.length] = descomposicion[0]; // Pasar articulo al final
				descomposicion[0] = "" // Borrar el artículo al inicio
				var newTitulo = descomposicion.join(' ').trim(); // Crear el nuevo título y quitar espacio vacio al inicio
				return newTitulo.charAt(0).toUpperCase() + newTitulo.slice(1); // Poner en mayúscula la primera letra
			}
		}
		return titulo; // En caso de que no haya artículo
	}

	// Auxiliar para recortar el título (cadena pasada como primer parámetro) en caso de que exceda el límite de longitud (entero pasado como segundo parámetro)
	// En caso de exceder el límite, se recorta el título a maxLength y se agregan puntos suspensivos.
	$scope.recortarTitulo = function(titulo, maxLength){
		return (titulo.length > maxLength) ? (titulo.substring(0, maxLength) + "...") : (titulo);
	};

	// Dada la información del archivo (pasado como parámetro) devuelve el titulo paralelo en cado de haberlo, en caso contrario devuelve el titulo propio.
	// Acorta el texto y agrega "..." para adecuarlo a la vista en cuadrícula de la colección.
	$scope.tituloApropiado = function(archivo){
		var maxLength = 40; // Longitud máxima permitida (para la vista)
		// Prioridad por mostrar títulos parentizados en titulo_propio
		if((matches = /\((.*)\)$/.exec(archivo.titulo_propio.trim())) !== null)
			return (matches[1].length > maxLength) ? (matches[1].substring(0,maxLength) + "...") : (matches[1]);
		// De no ser el caso, prioridad a titulo_paralelo
		if (archivo.titulo_paralelo !== ''){
			var titulos = archivo.titulo_paralelo.split(","); // Puede haber varios títulos paralelos (separados por coma)
			if (titulos.length > 1) // De ser así, tomar solamente el primero
				return (titulos[0].trim().length > maxLength) ? (titulos[0].trim().substring(0,maxLength) + "...") : (titulos[0].trim());
			// En caso contrario, tomar todo el titulo_paralelo
			return (archivo.titulo_paralelo.length > maxLength) ? (archivo.titulo_paralelo.substring(0,maxLength) + "...") : (archivo.titulo_paralelo);
		}
		// En otro caso, solo existe titulo_propio
		return (archivo.titulo_propio.length > maxLength) ? (archivo.titulo_propio.substring(0,maxLength) + "...") : (archivo.titulo_propio);
	};

	// Auxiliar para obtener los rubros de manera no-ordenada alfabeticamente
    $scope.notSort = function(obj){
    	if (!obj)
    		return [];
    	return Object.keys(obj);
    }

    // Acción al presionar el icono de edición
	$scope.editar = function(id){
		$('#modalInfo').modal('hide'); // Ocultar modal
		$('body').removeClass('modal-open'); // Eliminar del DOM
		$('.modal-backdrop').remove();
		$location.url('/archivos/editarArchivo/' + id); // Redirigir a la página de edición
    }
});

lais.controller('allContentsCtrl', function($scope, $http, $location, DecadaService){
	if(!$scope.sesion && !($scope.permiso >= 3)){
		console.log('No hay permisos suficientes');
		$location.url('/inicio');
	}

	$scope.encabezados = DecadaService.encabezados;
	$scope.notSort = function(obj){
    	if (!obj)
    		return [];
    	return Object.keys(obj);
    }

	$http.get('php/manejoBD.php?action=getAbsolutelyAll')
    	.success(function(data, status){
			$scope.allContents = data;
	    })
	    .error(function(data, status, headers, config) {
			alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
		});


	// Crea un documento PDF con la biblioteca pdfmake(.min).js y al final se abre el PDF en el navegador
	$scope.allContentsPDF = function(){
		$http.get('php/manejoBD.php?action=getAbsolutelyAll')
	    	.success(function(data, status){
	    		var coleccion = data.slice(0, 9);
		        console.log("Totales: ", coleccion.length);
		        var content = [];
		        for(var doc in coleccion)
		        	for(var area in coleccion[doc]){
		        		if(coleccion[doc][area] !== '')
			        		content.push(
			        			{
									columns: [
										{
											width: 100,
											text: $scope.encabezados[area]
										},
										{
											width: '*',
											text: coleccion[doc][area]
										}
									]
								}
			        		);
		        	}

		        var docDefinition = {
					footer: function(currentPage, pageCount) { 
						//return {text: currentPage.toString() + ' de ' + pageCount, alignment: 'right'};
						return {
							style: 'table',
							table: {
								widths: [28, '*', 60, 28],
								body: [
									[
										'',
										{text: 'Laboratorio Audiovisual de Investigación Social. Instituto Mora.', fontSize: 10, italics: true, alignment: 'left'},
										{text: currentPage.toString() + ' de ' + pageCount, italics: true, alignment: 'right'},
										''
									]
								]
							},
							layout: 'noBorders'
						}
					},
					//header: {text: '"LAIS"', fontSize: 10, italics: true, alignment: 'right', margin: [25,25,50,50]},
					content: content,
					styles: {
						header: {
							fontSize: 22,
							bold: true,
							margin: [0, 0, 0, 10]
						},
						subheader: {
							fontSize: 16,
							bold: true,
							margin: [0, 10, 0, 5]
						},
						table: {
							margin: [0, 5, 0, 15]
						}
					}
				};
				// open the PDF in a new window
				pdfMake.createPdf(docDefinition).open();
				//pdfMake.createPdf(docDefinition).download('all.pdf');

				console.log('PDF created');

		    })
		    .error(function(data, status, headers, config) {
				alert("No hay conexión con la base de datos.\nPor favor vuelve a intentar o revisa la conexión a internet.");
			});
	};
});