<!-- CONEXION CON LA BASE DE DATOS -->
<!-- Al final se tendrá disponible la variable $conn para efectuar consultas SQL a la base de datos -->
<?php
$servername = "localhost";
$username = "lais";
$password = "audiovisual";
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
