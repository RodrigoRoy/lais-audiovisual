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
		.when("/page2",{
			templateUrl: "templates/page2.html",
			controller: "conexionCtrl"
		})
		.when("/page3",{
			templateUrl: "templates/page3.html"
		})
		.otherwise({
			redirectTo: "/"
		});
});

lais.controller('conexionCtrl', function($scope, $http){
	$http.get('http://localhost/lais/public/php/conexion.php').
    success(function(data) {
        $scope.users = data;
    });
});