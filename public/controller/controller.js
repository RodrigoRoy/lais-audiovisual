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
			templateUrl: "templates/agregarArchivo.html"
		})
		.otherwise({
			redirectTo: "/"
		});
});

lais.controller('conexionCtrl', function($scope, $http){
	$http.get('http://localhost/lais-audiovisual/public/php/manejoBD.php?action=ver').
    success(function(data) {
        $scope.registros = data;
        console.log(data);
    });
});