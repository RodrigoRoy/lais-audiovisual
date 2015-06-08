var crudApp = angular.module('crud', []);

crudApp.controller('mainCtrl', function ($scope,$http) {
	$scope.nombreAuxiliar = '';
	$scope.edit = false; // Bandera para mostrar/ocultar botones

	getDatos();

	$scope.enviar = function(){
		$http.post('manager.php?action=agregar',
		{
			'nombre': $scope.nombre,
			'correo': $scope.correo
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
    	$scope.nombreAuxiliar = nombre; // permite recordar el nombre durante el update
    	$http.get('manager.php?action=obtener&name=' + nombre).
    	success(function(data) {
	        $scope.nombre = data.nombre_usuario;
	        $scope.correo = data.correo_electronico;
	    });
    }

    $scope.actualizar = function(){
    	$scope.edit = false;
    	$http.post('manager.php?action=actualizar',
		{
			'nombre': $scope.nombre,
			'correo': $scope.correo,
			'nombreAuxiliar': $scope.nombreAuxiliar
		}).
		success(function(data, status, headers, config) {
			alert("Datos actualizados");
			//$scope.nombre = '';
			//$scope.correo = '';
			location.reload();
		}).
		error(function(data, status, headers, config) {
			alert("Error en actualizacion de datos");
		});
    }

    $scope.eliminar = function(nombre){
    	$http.post('manager.php?action=borrar',
		{
			'nombre': nombre
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
    	$http.get('manager.php?action=ver').
	    success(function(data) {
	        $scope.datos = data;
	    });
    }
});