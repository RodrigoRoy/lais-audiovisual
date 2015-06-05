<?php
$servername = "localhost";
$username = "lais";
$password = "audiovisual";
$database = "CRUD";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("SET NAMES utf8");
}
catch(PDOException $e) {
    echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
    echo "Error: " . $e->getMessage();
}

switch ($_GET['action']) {
	case 'ver':
        obtener_datos();
        break;
    case 'obtener':
        obtener_usuario($_GET['name']);
        break;
    case 'agregar':
		agregar_datos();
        break;
    case 'actualizar':
        actualizar_usuario();
        break;
    case 'borrar':
        borrar();
        break;
}

function obtener_datos(){
    $select = "SELECT * FROM persona";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll();
    print_r(json_encode($data));
    $GLOBALS['conn'] = null;
};

function obtener_usuario($usuario){
    $select = "SELECT * FROM persona WHERE nombre_usuario = '" . $usuario . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() == 1){
        $data = $stmt->fetch(); // Obtener el único resultado de la base de datos
        print_r(json_encode($data));
    }
    $GLOBALS['conn'] = null;
}

function agregar_datos(){
	$data = json_decode(file_get_contents("php://input"));
    $name = $data->nombre;
    $email = $data->correo;
    $sql = "INSERT INTO persona() VALUES('" . $name . "', '" . $email . "');";
    try{
    	$GLOBALS['conn']->exec($sql);
	}
	catch(PDOException $e){
    	echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

function actualizar_usuario(){
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->nombre;
    $email = $data->correo;
    $name_aux = $data->nombreAuxiliar;
    $sql = "UPDATE persona SET nombre_usuario='" . $name . "', correo_electronico='" . $email . "' WHERE nombre_usuario='" . $name_aux . "'";
    try{
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

function borrar(){
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->nombre;
    $sql = "DELETE FROM persona WHERE nombre_usuario='" . $name . "'";
    try{
        $GLOBALS['conn']->exec($sql);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}
?>