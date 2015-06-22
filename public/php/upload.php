<?php
require_once 'conexion.php';

// Subir imágen a carpeta contenedora "Portadas"
$filename = $_FILES['file']['name'];
$destination = '../imgs/Portadas/' . $filename;
move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );

// Agregar el nombre de la imagen a la base de datos
$codigo_de_referencia = $_POST['codigo_de_referencia'];

$select = "SELECT imagen FROM informacion_adicional WHERE codigo_de_referencia = '" . $id . "'";
$stmt = $conn->prepare($select);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
if ($stmt->rowCount() == 1){
    $data = $stmt->fetch(); // Obtener el único resultado de la base de datos
    print_r(json_encode($data));
}



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