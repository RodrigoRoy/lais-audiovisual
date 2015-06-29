<?php
require_once 'conexion.php'; // Archivo de configuracion para la conexion con la base de datos

# Modificar el archivo de configuracion de PHP en el servidor en caso de ser necesario para el tamaño máximo de subida:
# /etc/php5/apache2/php.ini
# upload_max_filesize = 2M

// Subir imágen a carpeta contenedora "Portadas"
$filename = $_FILES['file']['name'];
$destination = '../imgs/Portadas/' . $filename;
move_uploaded_file( $_FILES['file']['tmp_name'] , $destination ); // Automágicamente se sube la imagen

$codigo_de_referencia = $_POST['codigo_de_referencia'];
// Cambiar el nombre de la imagen asociada
$info_adicional = "UPDATE informacion_adicional SET "
    . "imagen='" . $filename
    . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
// Ejecutar inserción o actualizacion
try{
    $conn->exec($info_adicional);
}
catch(PDOException $e){
    echo $e->getMessage();
}
$conn = null;
?>