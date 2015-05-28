<!DOCTYPE html>
<html>
<body>
<head>
    <title>Sistema de apoyo a la catalogación de archivos audiovisuales</title>

    <meta charset="utf-8"> <!-- Codificación de la página (permite acentos) -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Para uso de diseño responsivo con Bootstrap -->
    
    <!-- Latest compiled and minified CSS (Bootstrap)-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
</head>

<body>

<?php
<<<<<<< HEAD
$servername = "localhost";
$username = "root";
$password = "djrashad";
$database = "Coleccion_Archivistica";
// NOTA: La manipulación a la base de datos se realiza con PDO (PHP Database Object)
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejo de errores con PDO

    $conn->exec("SET NAMES utf8"); // Permite mostrar los resultados con acentos y caracteres extraños
}
catch(PDOException $e) {
    echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
    echo "Error: " . $e->getMessage();
}
=======
require_once 'conexion.php'; // Conexión a la base de datos
>>>>>>> 5e5e6a41695baeb709cd238dfdbf12cd64d47c51
?>

	<div class="container">
		<div class="page-header">
			<h1>Borrar audiovisual</h1>
		</div>

		<!-- Realizar consulta en la base de acuerdo al id (código de identificación) -->
		<?php
		$sql = "DELETE FROM area_de_identificacion WHERE codigo_de_referencia = '" . $_GET['id'] . "';";
		echo '<pre>' . $sql . '</pre>';
		try{
	    	$conn->exec($sql);
	    	echo '<div class="alert alert-success" role="alert">Record deleted successfully</div>';
		}
		catch(PDOException $e){
	    	echo $e->getMessage();
	    }
		$conn = null;
		?>

	</div> <!--Container-->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript (Bootstrap)-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>