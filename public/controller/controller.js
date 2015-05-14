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
			templateUrl: "templates/page2.html"
		})
		.when("/page3",{
			templateUrl: "templates/page3.html"
		})
		.otherwise({
			redirectTo: "/"
		});
});


