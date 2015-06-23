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
// Verificar si ya existe una imagen (nombre de imagen) en la base de datos
$select = "SELECT imagen FROM informacion_adicional WHERE codigo_de_referencia = '" . $codigo_de_referencia . "'";
$stmt = $conn->prepare($select);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
$data = $stmt->fetch(); // Obtener el único resultado de la base de datos
// Verificar si se requiere crear o actualizar el registro
if ($data['imagen'] == null || $data['imagen'] == ''){
	// Agregar el nombre de la imagen a la base de datos
    $info_adicional = "INSERT INTO informacion_adicional(codigo_de_referencia, imagen) VALUES('"
		. $codigo_de_referencia . "','"
		. $filename
		. "');";
}else{
	// Cambiar el nombre de la imagen asociada
	$info_adicional = "UPDATE informacion_adicional SET "
        . "imagen='" . $filename
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
}
// Ejecutar inserción o actualizacion
try{
    $conn->exec($info_adicional);
}
catch(PDOException $e){
    echo $e->getMessage();
}

$conn = null;
?>