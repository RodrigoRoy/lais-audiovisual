<?php
include 'filters.php';
include 'conexion.php';
	

/* Casos para tomar la acción del controlador */
switch ($_GET['action']) {
	case 'agregar':
		echo "break";
        break;
	case 'ver':
		mostrar();
		break;
}
	
/*Funcion que muestra los datos completos de cada archivo audiovisual*/
function mostrar(){
	$select = "SELECT * FROM area_de_identificacion";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    
    // Check if id is in database (for develop purpose only)
    if ($stmt->rowCount() == 0){
    } else {
        $data = $stmt->fetchAll(); // Obtener el único resultado de la base de datos
        for($i=0; $i < count($data) ; $i++) { 
      		$data[$i]['duracion'] = getDuracion($data[$i]['duracion']);	
        }
        
        print_r(json_encode($data));
        return json_encode($data);

    }
}

function agregar(){
    $datos = json_encode(file_get_contents("php://input"));
    
}

?>