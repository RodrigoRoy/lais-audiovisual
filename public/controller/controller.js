var lais = angular.module('lais',['ngRoute','ngCookies', 'ngFileUpload','infinite-scroll']);

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
			controller: "busquedaCtrl"
		})
		.when("/administracion_usuarios",{
			templateUrl: "templates/adminUsers.html",
			controller: "adminUser"
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

//Controlador que muestra todas las decadas existentes
lais.controller('decadasCtrl',function($scope, $location, $http){
	$scope.allDecades = {'1':"1890-1899",
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
					  '22':"3000-3009" };
	$http.get('php/manejoBD.php?action=mostrarDecadas').
	success(function(data){
		$scope.decadas = data;
	});
});

//Controlador que mostrara los archivos audiovisuales con su portada por decadas
lais.controller('muestraDecadaCtrl',function($scope,$location,$routeParams,$http, $timeout){
	console.log("Parametro URL: "+ $routeParams.codigo);
	$scope.codigo = $routeParams.codigo;
	var allDecades = {'1':"1890-1899",
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
					  '22':"3000-3009" };
	$scope.encabezados = {
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
		'sinopsis': 'Sinópsis',
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
		'fecha_de_descripcion': 'Fecha de descripción'
	};
	
	
	$('#decadas').html('<h1 style="margin-left:4.6%;">Década '+allDecades[($scope.codigo).split("-")[3]]+'</h1>');
	
	
	$scope.archivos = [];

	var contador = 0; // Solo necesario en función loadMore
	var howMany = 18;
	$scope.busy = false;

	$scope.loadMore = function(){
		if($scope.busy)
			return;
		$scope.busy = true;
		$http.get('php/manejoBD.php?action=mostrarCaratulaScroll&codigo='+$routeParams.codigo+"&howMany="+howMany+"&offset="+contador).
		success(function(data){
			//console.log("Datos: " + data);
			//$scope.archivos = data;
			for(portada in data){
				$scope.archivos.push(data[portada]);
				contador++;
				//console.log(data[portada]);
			}
			//console.log($scope.archivos.length);
			$scope.busy = false;
			if (data.length == 0)
				$scope.busy = true;
			//console.log("Data length: " + data.length);
		});		
	};

	/* 
		Obtiene los datos (id,imagen,titulo,duracion) necesarios para mostrar portadas en el template.
		En caso de requerir otros datos, modificar la función del manejador de la base (manejoDB.php)
	*/
	$scope.firstLoad = function(){
		if($scope.busy) // No hacer nada si ya no hay datos que obtener de la base
			return;
		$scope.busy = true; // En estos momentos estamos "ocupados" obteniendo datos de la base
		$http.get('php/manejoBD.php?action=firstGet&codigo='+$routeParams.codigo+"&howMany="+howMany+"&offset="+$scope.archivos.length).
			success(function(data, status, headers, config) {
				for(av in data){ // Recorrer por indice (av) cada audiovisual de la base
					$scope.archivos.push(data[av]); // Agregar al arreglo que los contendrá
					console.log("Imgen: " + data[av].imagen);
				}
				$scope.busy = false; // En este momento ya NO estamos "ocupados"
				if (data.length == 0) // Excepto si ya no hay datos que obtener de la base
					$scope.busy = true;
			}).
			error(function(data, status, headers, config) {
				// called asynchronously if an error occurs or server returns response with an error status.
			});
	};

	$scope.getAllInfo = function(codigoId){
		console.log("codigo: " + codigoId);
		$http.get('php/manejoBD.php?action=obtenerXAreas&id=' + codigoId).
    	success(function(data) {
    		$scope.allInfo = data;
    	});
	};

	$scope.editar = function(id){
		$('#modalInfo').modal('hide'); // Ocultar modal
		$('body').removeClass('modal-open'); // Eliminar del DOM
		$('.modal-backdrop').remove();
		$location.url('/archivos/editarArchivo/' + id); // Redirigir a la página de edición
    }

    $scope.confirmacion = function(){
    	var c = confirm("¿Seguro que deseas borrar el archivo audiovisual?" + "\n" + $scope.allInfo.identificacion.codigo_de_referencia);
    	if(c == true){
    		console.log("Id: " + $scope.allInfo.identificacion.codigo_de_referencia);
    		$scope.eliminar($scope.allInfo.identificacion.codigo_de_referencia);
    	}else{
    		
    	}
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

    $scope.hideInfo = false;
    $scope.hideInfos = function(){
    	$scope.hideInfo = !$scope.hideInfo;
    }

    $scope.notSort = function(obj){
    	if (!obj)
    		return [];
    	return Object.keys(obj);
    }
});


lais.controller('edicionCtrl', function($scope, $http, $routeParams, $location, Upload){
	if(!$scope.sesion && !$scope.permiso >= 2){
		console.log('No hay permisos suficientes');
		$location.url('/archivos/');
	}

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
		$scope.url = data.url;
		$scope.imagen_previa = data.imagen;
    });

	/*$scope.editar = function(){
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
    }*/

    $scope.editar = function(files){
		$http.post('php/manejoBD.php?action=actualizar', 
			scopeData2object($scope)
		).success(function(data,status, headers, congif){
			$scope.upload(files); // Subir la imagen después de crear el registro en la base
			alert("El archivo Audiovisual ha sido actualizado");
			$location.url('/archivos/');
		}).error(function(error){
			console.log("Error de los datos: " + error);
		});
	}

    // Componentes para subir archivos (imagenes)
	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });
    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: 'php/upload.php',
                    method: 'POST',
                    sendFieldsAs: 'form',
                    fields: {'codigo_de_referencia': $scope.codigo_de_referencia},
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

//Controlador que hace post para agregar datos a la base de datos y recupera los datos desde el html
lais.controller('agregarDatosCtrl',function($scope, $http, $location, Upload){
	if(!$scope.sesion && !$scope.permiso >= 1){
		console.log('No hay permisos suficientes');
		$location.url('/archivos/');
	}

	$scope.envia = function(files){
		$http.post('php/manejoBD.php?action=agregar', 
			scopeData2object($scope)
		).success(function(data,status, headers, congif){
			//console.log(files);
			$scope.upload(files); // Subir la imagen después de crear el registro en la base
			alert("El archivo Audiovisual ha sido agregado");
			//console.log("Datos: " + data);
			//console.log("Estado: " + data["Status"]);
			//console.log("Estado del envio: " + data.Status);
			$location.url('/archivos/');
		}).error(function(error){
			console.log("Error de los datos: " + error);
		});
	}

	// Componentes para subir archivos (imagenes)
	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });
    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: 'php/upload.php',
                    method: 'POST',
                    sendFieldsAs: 'form',
                    fields: {'codigo_de_referencia': $scope.codigo_de_referencia},
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


//Funcion que verifica el login y logout 
lais.controller('datosAutentificacion', function($scope, $http, $cookieStore, $location, $window){
	$scope.permiso = 0;
	$scope.errores = false;
	$scope.sesion = $cookieStore.get('sesion');
	$scope.user = $cookieStore.get('nombre');
	//console.log("Inicio:" + $scope.sesion);
	$scope.login= function(){
		//console.log("Usuario: " + $scope.usuario);
		//console.log("Pass: " + $scope.pass);
		$http.post('php/manejoBD.php?action=login',
			{
				'Username' : $scope.usuario,
				'Password' : $scope.pass
			}).success(function(data,status,headers,config){
				console.log("Se mandaron los datos");
				if($scope.usuario == data.Username && $scope.pass == data.Password){
					$cookieStore.put('sesion','true');
					$cookieStore.put('nombre',data.Username);
					$scope.sesion = $cookieStore.get('sesion');
					$scope.user = $cookieStore.get('nombre');
					$scope.permiso = data.Privilegio;
					$scope.agregar = true;
					//console.log("En sesion\n"+ $scope.sesion);
					//console.log($scope.permiso);
					//console.log("Usuario\n"+ $scope.user);

					$window.location.reload(false);
					//console.log("Usuario\n"+ $scope.usuario);
					//$location.reload(true);
				}else{
					$cookieStore.remove('sesion');
					$cookieStore.remove('nombre');
					$scope.sesion = false;
					$scope.errores = true;
					$scope.permiso = 0;
					//console.log("Error de Sesion\n"+ $scope.sesion);
					//console.log($scope.permiso);
					$scope.permiso = 0;
					$scope.usuario = "";
					$scope.pass = "";
					//console.log("Usuario\n"+ $scope.usuario);
				}
			}).error(function(data){
				console.log("ERROR");
			});
	}

	$scope.logout = function(){
		$cookieStore.remove('sesion');
		$cookieStore.remove('nombre');
		$scope.sesion = false;
		$scope.permiso = 0;
		$scope.usuario = "";
		$scope.pass = "";
		//console.log("Cerrar Sesion\n" + $scope.sesion);
		//console.log($scope.permiso);
		//console.log("Usuario\n"+ $scope.user);
		$location.url('/inicio');

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

//Administración de usuarios
lais.controller('adminUser',function($scope,$http, $location){
	//console.log("Sesion: " + $scope.sesion);
	//console.log("Permiso: " + $scope.permiso);

	if(!$scope.sesion && !($scope.permiso >= 3)){
		console.log('No hay permisos suficientes');
		$location.url('/inicio');
	}
	$scope.nombreAuxiliar = '';
	$scope.edit = false; 

	getDatos();

	$scope.enviar = function(){
		$http.post('php/manejoBD.php?action=agregarUsuario',
		{
			'Username': $scope.nombre,
			'Password': $scope.password,
			'Privilegio': $scope.privilegio
		}).
		success(function(data, status, headers, config) {
			alert("Datos enviados");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error! en envio de datos");
		});
	}

	$scope.editar = function(nombre){
    	$scope.edit = true;
    	$scope.nombreAuxiliar = nombre;
    	$http.get('php/manejoBD.php?action=obtenerUsuario&name=' + nombre).
    	success(function(data) {
	        $scope.nombre = data.Username;
	        $scope.password = data.Password;
	        $scope.privilegio = data.Privilegio;
	      
	    }).
	    error(function(data, status, headers, config) {
	    	console.log("Error");
			console.log(data);
			console.log(status);
		});
    }

    $scope.actualizar = function(){
    	$scope.edit = false;
    	$http.post('php/manejoBD.php?action=actualizarUsuario',
		{
			'Username': $scope.nombre,
			'Password': $scope.password,
			'Privilegio': $scope.privilegio,
			'nombreAuxiliar': $scope.nombreAuxiliar
		}).
		success(function(data, status, headers, config) {
			alert("Datos actualizados");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error en actualizacion de datos");
		});
    }

    $scope.eliminar = function(nombre){
    	$http.post('php/manejoBD.php?action=borrarUsuario',
		{
			'Username': nombre
		}).
		success(function(data, status, headers, config) {
			alert("Usuario eliminado");
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error al borrar usuario");
		});
    }

    function getDatos(){
    	$scope.privilegios ={
    		"0":"Sin Permisos",
    		"1": "Agregar",
    		"2": "Agregar y Editar",
    		"3": "Agregar, Editar y Eliminar"
    	};

    	$http.get('php/manejoBD.php?action=verUsuarios').
	    success(function(data) {
	        $scope.datos = data;
	    });
    };
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
		'fecha_de_descripcion': (scope.fecha_de_descripcion !== undefined) ? scope.fecha_de_descripcion : "",
		'url': (scope.url !== undefined) ? scope.url : ""
	}
}
