<!DOCTYPE html>
<html>
<body>
<head>
    <title>Consulta base de datos del LAIS</title>
    <meta name="description" content="Ejemplo de consulta a base de datos MySQL con PHP para el LAIS">
    <meta name="author" content="Rodrigo Eduardo Colín Rivera">

    <meta charset="utf-8"> <!-- Codificación de la página (permite acentos) -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Para uso de diseño responsivo con Bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bibliotecas Bootstrap y jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<?php
include 'Audiovisual.php'; // Clase para representar un audiovisual
?>

<!-- CONEXION CON LA BASE DE DATOS -->
<?php
$servername = "localhost";
$username = "root";
$password = "advantage7";
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
?>


<div class="container">
	<h1>Vista individual de Audiovisual</h1>
	
	<?php
	$select = "SELECT * FROM audiovisual WHERE codigo_de_referencia='" . $_GET['id'] . "'"; // $_GET['id'] == código de identificación
    $stmt = $conn->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    
    if ($stmt->rowCount() == 0){ // Si la búsqueda es existosa pero no afectó ningún registro (i.e. no hay coincidencias de la búsqueda)
        echo '<div class="alert alert-danger" role="alert"><strong>Audiovisual no encontrado</strong><br>El código de identificación es incorrecto.</div>';
    } else {
        $data = $stmt->fetch(); // Obtener el único resultado de la base de datos
        $av = new Audiovisual($data); // Crear el objeto Audiovisual a partir de la información de la base
        echo $av; // Se utiliza toString() para la representación
    }
	?>
</div>

</body>
</html>