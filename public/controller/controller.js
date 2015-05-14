var lais = angular.module('lais',['ngRoute']);

lais.config(function ($routeProvider, $locationProvider){
	console.log("Ruteando");
	$routeProvider
		.when("/page1",{
			templateUrl: "templates/page1.html"
		})
		.when("/page2",{
			templateUrl: "templates/page2.html"
		})
		.when("/page3",{
			templateUrl: "templates/page1.html"
		})
		.otherwise({
			redirectTo: "/"
		});
});


