<?php
require_once 'conexion.php';

// Subir imágen a carpeta contenedora "Portadas"
$filename = $_FILES['file']['name'];
$destination = '../imgs/Portadas/' . $filename;
move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );

// Agregar el nombre de la imagen a la base de datos
$codigo_de_referencia = $_POST['codigo_de_referencia'];
$info_adicional = "INSERT INTO informacion_adicional(codigo_de_referencia, imagen) VALUES('"
    . $codigo_de_referencia . "','"
    . $filename
    . "');";
try{
    $conn->exec($info_adicional);
}
catch(PDOException $e){
    echo $e->getMessage();
}
$conn = null;
?>