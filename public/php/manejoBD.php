<?php
require_once 'filters.php';
require_once 'conexion.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

/*Casos para tomar la acción del controlador*/
switch ($_GET['action']) {
    case 'agregar':
        agregar();
        break;
    case 'ver':
        mostrar();
        break;
    case 'buscar':
        buscar($_GET['query']);
        break;
    case 'busqueda': // Versión actualizada del caso 'buscar'
        busqueda($_GET['query'],$_GET['howMany'],$_GET['offset']);
        break;
    case 'busqueda2': // Versión actualizada del caso 'busqueda'
        busqueda2($_GET['query'], $_GET['permiso']);
        break;
    case 'obtener':
        getId($_GET['id']);
        break;
    case 'actualizar':
        actualizar();
        break;
    case 'borrar':
        borrar();
        break;
    case 'login':
        login();
        break;
    case 'getPassword':
        getPassword();
        break;
    case 'mostrarDecadas':
        mostrarDecadas();
        break;
    case 'mostrarCaratula':
        mostrarCaratula($_GET['query']);
        break;
    case 'obtenerXAreas':
        obtenerArea($_GET['id']);
        break;
    case 'getAbsolutelyAll':
        getAbsolutelyAll();
        break;
    case 'getSinopsis':
        getSinopsis($_GET['howMany'],$_GET['offset']);
        break;
    case 'mostrarCaratulaScroll':
        mostrarCaratulaScroll($_GET['codigo'],$_GET['howMany'],$_GET['offset']);
        break;
    case 'getDecada':
        getDecada($_GET['decada']);
        break;
    case 'firstGet':
        firstGet($_GET['codigo'],$_GET['howMany'],$_GET['offset']);
        break;
    case 'getIndice':
        getIndice($_GET['decada']);
        break;
    case 'mail':
        mailMe();
        break;
    case 'count':
        countAll();
        break;
    case 'verUsuarios':
        obtener_datosUsuarios();
        break;
    case 'obtenerUsuario':
        obtener_usuario($_GET['name']);
        break;
    case 'agregarUsuario':
        agregar_datosUsuario();
        break;
    case 'actualizarUsuario':
        actualizar_usuario();
        break;
    case 'borrarUsuario':
        borrarUsuario();
        break;
    case 'estadisticas':
        datos_estadisticos($_GET['decada']);
        break;
    case 'registro':
        registro_actividades($_GET['offset'], $_GET['rowCount']);
        break;
    case 'detalles':
        faltantes_detalles($_GET['decada'], $_GET['campo'], $_GET['area']);
        break;
    case 'sugerencia':
        sugerencia($_GET['clave']);
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
        foreach ($data as &$registro) { // In order to be able to directly modify array elements within the loop precede $value with &. In that case the value will be assigned by reference.
            $registro['duracion'] = getDuracion($registro['duracion']);
        }
        print_r(json_encode($data));
        return json_encode($data);
    }
}

/*Funcion que agrega un nuevo archivo audivisual*/
function agregar(){
    $datos = json_decode(file_get_contents("php://input"));
    
    # Parse de información (limpiar espacios en blanco y detalle con comillas)
    foreach ($datos as &$dato) { # el símbolo amperson (&) es necesario para modificar (permite paso por referencia y no por valor)
        $dato = preg_replace('/  */', ' ', $dato); # Eliminar múltiples espacios vacios por uno solo
        $dato = trim($dato); # Elimina espacios en blanco al inicio y al final
        $dato = str_replace("'", "\\'", $dato); # Esto permite incluir single quote (') sin error de sintaxis
        $dato = str_replace("\"", "\\\"", $dato); # Esto permite incluir double quote (") sin error de sintaxis
    }
    
    $identificacion = "INSERT INTO area_de_identificacion() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->titulo_propio', 
        '$datos->titulo_paralelo', 
        '$datos->titulo_atribuido', 
        '$datos->titulo_de_serie', 
        '$datos->numero_de_programa', 
        '$datos->pais', '$datos->fecha', 
        '$datos->duracion', 
        '$datos->investigacion', 
        '$datos->realizacion', 
        '$datos->direccion', 
        '$datos->guion', 
        '$datos->adaptacion', 
        '$datos->idea_original', 
        '$datos->fotografia', 
        '$datos->fotografia_fija', 
        '$datos->edicion', 
        '$datos->sonido_grabacion', 
        '$datos->sonido_edicion', 
        '$datos->musica_original', 
        '$datos->musicalizacion', 
        '$datos->voces', 
        '$datos->actores', 
        '$datos->animacion', 
        '$datos->otros_colaboradores');";
    $contexto = "INSERT INTO area_de_contexto() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->entidad_productora', 
        '$datos->productor', 
        '$datos->distribuidora', 
        '$datos->historia_institucional', 
        '$datos->resena_biografica', 
        '$datos->forma_de_ingreso', 
        '$datos->fecha_de_ingreso');";
    $contenido = "INSERT INTO area_de_contenido_y_estructura() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->sinopsis', 
        '$datos->descriptor_onomastico', 
        '$datos->descriptor_toponimico', 
        '$datos->descriptor_cronologico', 
        '$datos->tipo_de_produccion', 
        '$datos->genero', 
        '$datos->fuentes', 
        '$datos->recursos', 
        '$datos->versiones', 
        '$datos->formato_original', 
        '$datos->material_extra');";
    $condiciones = "INSERT INTO area_de_condiciones_de_acceso() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->condiciones_de_acceso', 
        '$datos->existencia_y_localizacion_de_originales', 
        '$datos->idioma_original', 
        '$datos->doblajes_disponibles', 
        '$datos->subtitulajes', 
        '$datos->soporte', 
        '$datos->numero_copias', 
        '$datos->descripcion_fisica', 
        '$datos->color', 
        '$datos->audio', 
        '$datos->sistema_de_grabacion', 
        '$datos->region_dvd', 
        '$datos->requisitos_tecnicos');";
    $documentacion = "INSERT INTO area_de_documentacion_asociada() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->existencia_y_localizacion_de_copias', 
        '$datos->unidades_de_descripcion_relacionadas', 
        '$datos->documentos_asociados');";
    $notas = "INSERT INTO area_de_notas() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->area_de_notas');";
    $descripcion = "INSERT INTO area_de_descripcion() VALUES(
        '$datos->codigo_de_referencia', 
        '$datos->notas_del_archivero', 
        '$datos->datos_del_archivero', 
        '$datos->reglas_o_normas', 
        '$datos->fecha_de_descripcion');";
    # Agregar en blanco la imagen y demás información adicional
    $info_adicional = "INSERT INTO informacion_adicional(codigo_de_referencia) VALUES(
        '$datos->codigo_de_referencia');";
    # Datos para el registro de actividades
    $registro_actividades = "INSERT INTO registro_actividades VALUES('$datos->codigo_de_referencia', '$datos->titulo_propio', now(), '$datos->user', '$datos->accion');";

    try{
        $GLOBALS['conn']->exec($identificacion);
        $GLOBALS['conn']->exec($contexto);
        $GLOBALS['conn']->exec($contenido);
        $GLOBALS['conn']->exec($condiciones);
        $GLOBALS['conn']->exec($documentacion);
        $GLOBALS['conn']->exec($notas);
        $GLOBALS['conn']->exec($descripcion);
        $GLOBALS['conn']->exec($info_adicional);
        
        // Si fué posible la creación, guardar datos al registro de actividades
        $GLOBALS['conn']->exec($registro_actividades);

        print_r(json_encode(array("Status"=>"Ok"))); // Responder que la operación fué exitosa
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

/*Funcion que actualiza la información de un registro (campos de un documental)*/
function actualizar(){
    $datos = json_decode(file_get_contents("php://input"));

    # Parse de información (limpiar espacios en blanco y detalle con comillas)
    foreach ($datos as &$dato) { # el símbolo amperson (&) es necesario para modificar (permite paso por referencia y no por valor)
        $dato = preg_replace('/  */', ' ', $dato); # Eliminar múltiples espacios vacios por uno solo
        $dato = trim($dato); # Elimina espacios en blanco al inicio y al final
        $dato = str_replace("'", "\\'", $dato); # Esto permite incluir single quote (') sin error de sintaxis
    }
    
    $identificacion = "UPDATE area_de_identificacion SET "
        . "titulo_propio='" . $datos->titulo_propio . "', " 
        . "titulo_paralelo='" . $datos->titulo_paralelo . "', " 
        . "titulo_atribuido='" . $datos->titulo_atribuido . "', " 
        . "titulo_de_serie='" . $datos->titulo_de_serie . "', "
        . "numero_de_programa='" . $datos->numero_de_programa . "', "
        . "pais='" . $datos->pais . "', "
        . "fecha='" . $datos->fecha . "', "
        . "duracion='" . $datos->duracion . "', "
        . "investigacion='" . $datos->investigacion . "', "
        . "realizacion='" . $datos->realizacion . "', "
        . "direccion='" . $datos->direccion . "', "
        . "guion='" . $datos->guion . "', "
        . "adaptacion='" . $datos->adaptacion . "', "
        . "idea_original='" . $datos->idea_original . "', "
        . "fotografia='" . $datos->fotografia . "', "
        . "fotografia_fija='" . $datos->fotografia_fija . "', "
        . "edicion='" . $datos->edicion . "', "
        . "sonido_grabacion='" . $datos->sonido_grabacion . "', "
        . "sonido_edicion='" . $datos->sonido_edicion . "', "
        . "musica_original='" . $datos->musica_original . "', "
        . "musicalizacion='" . $datos->musicalizacion . "', "
        . "voces='" . $datos->voces . "', "
        . "actores='" . $datos->actores . "', "
        . "animacion='" . $datos->animacion . "', "
        . "otros_colaboradores='" . $datos->otros_colaboradores
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";
    
    $contexto = "UPDATE area_de_contexto SET "
        . "entidad_productora='" . $datos->entidad_productora . "', "
        . "productor='" . $datos->productor . "', "
        . "distribuidora='" . $datos->distribuidora . "', "
        . "historia_institucional='" . $datos->historia_institucional . "', "
        . "resena_biografica='" . $datos->resena_biografica . "', "
        . "forma_de_ingreso='" . $datos->forma_de_ingreso . "', "
        . "fecha_de_ingreso='" . $datos->fecha_de_ingreso
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";
    
    $contenido = "UPDATE area_de_contenido_y_estructura SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "sinopsis='" . $datos->sinopsis . "', "
        . "descriptor_onomastico='" . $datos->descriptor_onomastico . "', "
        . "descriptor_toponimico='" . $datos->descriptor_toponimico . "', "
        . "descriptor_cronologico='" . $datos->descriptor_cronologico . "', "
        . "tipo_de_produccion='" . $datos->tipo_de_produccion . "', "
        . "genero='" . $datos->genero . "', "
        . "fuentes='" . $datos->fuentes . "', "
        . "recursos='" . $datos->recursos . "', "
        . "versiones='" . $datos->versiones . "', "
        . "formato_original='" . $datos->formato_original . "', "
        . "material_extra='" . $datos->material_extra
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";
    
    $condiciones = "UPDATE area_de_condiciones_de_acceso SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "condiciones_de_acceso='" . $datos->condiciones_de_acceso . "', "
        . "existencia_y_localizacion_de_originales='" . $datos->existencia_y_localizacion_de_originales . "', "
        . "idioma_original='" . $datos->idioma_original . "', "
        . "doblajes_disponibles='" . $datos->doblajes_disponibles . "', "
        . "subtitulajes='" . $datos->subtitulajes . "', "
        . "soporte='" . $datos->soporte . "', "
        . "numero_copias='" . $datos->numero_copias . "', "
        . "descripcion_fisica='" . $datos->descripcion_fisica . "', "
        . "color='" . $datos->color . "', "
        . "audio='" . $datos->audio . "', "
        . "sistema_de_grabacion='" . $datos->sistema_de_grabacion . "', "
        . "region_dvd='" . $datos->region_dvd . "', "
        . "requisitos_tecnicos='" . $datos->requisitos_tecnicos
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";
    
    $documentacion = "UPDATE area_de_documentacion_asociada SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "existencia_y_localizacion_de_copias='" . $datos->existencia_y_localizacion_de_copias . "', "
        . "unidades_de_descripcion_relacionadas='" . $datos->unidades_de_descripcion_relacionadas . "', "
        . "documentos_asociados='" . $datos->documentos_asociados
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";
    
    $notas = "UPDATE area_de_notas SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "area_de_notas='" . $datos->area_de_notas
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";

    $descripcion = "UPDATE area_de_descripcion SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "notas_del_archivero='" . $datos->notas_del_archivero . "', "
        . "datos_del_archivero='" . $datos->datos_del_archivero . "', "
        . "reglas_o_normas='" . $datos->reglas_o_normas . "', "
        . "fecha_de_descripcion='" . $datos->fecha_de_descripcion
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";

    $info_adicional = "UPDATE informacion_adicional SET "
        . "codigo_de_referencia='" . $datos->codigo_de_referencia . "', "
        . "url='" . $datos->url . "', "
        . "fecha_de_modificacion='" . $datos->fecha_de_modificacion
        . "' WHERE codigo_de_referencia='" . $datos->codigo_de_referencia . "'";

    $registro_actividades = "INSERT INTO registro_actividades VALUES('$datos->codigo_de_referencia', '$datos->titulo_propio', now(), '$datos->user', '$datos->accion');";

    try{
        $stmt = $GLOBALS['conn']->prepare($identificacion);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($contexto);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($contenido);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($condiciones);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($documentacion);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($notas);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($descripcion);
        $stmt->execute();
        $stmt = $GLOBALS['conn']->prepare($info_adicional);
        $stmt->execute();

        // Si fué posible actualizar, guardar datos al registro de actividades
        $stmt = $GLOBALS['conn']->prepare($registro_actividades);
        $stmt->execute();
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

function borrar(){
    $datos = json_decode(file_get_contents("php://input"));

    try{
        // Obtener el titulo del material que se desea borrar
        $titulo = '';
        $select = "SELECT titulo_propio FROM area_de_identificacion WHERE codigo_de_referencia = '" . $datos->codigo_de_referencia . "';";
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->rowCount() == 1){
            $titulo = $stmt->fetch()["titulo_propio"];
        }

        // El borrado actual se lleva a cabo
        $sql = "DELETE FROM area_de_identificacion WHERE codigo_de_referencia = '" . $datos->codigo_de_referencia . "';";
        $GLOBALS['conn']->exec($sql);

        // Si fué posible borrar, guardar el codigo y nombre del documental así como la fecha y quién lo realizó
        $sql = "INSERT INTO registro_actividades VALUES('$datos->codigo_de_referencia', '$titulo', now(), '$datos->user', '$datos->accion');";
        $GLOBALS['conn']->exec($sql);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    
    $GLOBALS['conn'] = null;
}

function getId($id){
    $select = "SELECT * FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() == 1){
        $data = $stmt->fetch(); // Obtener el único resultado de la base de datos
        print_r(json_encode($data));
    }
    $GLOBALS['conn'] = null;
}


//Función que hace el login para verificar si los usuarios estan en la base de datos
function login(){
    $datos = json_decode(file_get_contents("php://input"));
    $query = 'SELECT * FROM usuarios WHERE Username="'.$datos->Username.'" and Password="'.$datos->Password.'"';
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        print_r(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
    }else{
        print_r(json_encode(array("Id"=>"-1")));
    }
}

// Petición del password de un usuario
function getPassword(){
    $data = json_decode(file_get_contents("php://input"));
    $user = $data->Username;
    $query = "SELECT Password FROM usuarios WHERE Username='$user'";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->execute();
    if($stmt->rowCount() == 1){
        print_r(json_encode($stmt->fetch(PDO::FETCH_ASSOC)));
    }else{
        print_r(json_encode(array("Id"=>"-1")));
    }
}

//Función que resive un query sobre cada decada para mostrarlas
function mostrarCaratula($query){
    $select = "SELECT codigo_de_referencia FROM area_de_identificacion WHERE codigo_de_referencia LIKE '%".$query."%'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    //$stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    
    // Check if id is in database (for develop purpose only)
    if ($stmt->rowCount() == 0){
    } else {
        $data = $stmt->fetchAll(PDO::FETCH_COLUMN,0); // Obtener el único resultado de la base de datos
        print_r(json_encode($data));
        //print_r($data);
    }
}

// Devulve todos los nombres de columnas de (el nombre de) una tabla pasada como parámetro. Auxiliar para búsquedas sobre toda la base de datos.
function getColumnNames($table){
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'Audiovisuales' AND TABLE_NAME = :table";
    try{
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->bindValue(':table', $table);
        $stmt->execute();
        $output = array();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
        while($row = $stmt->fetch()){
            $output[] = $row['COLUMN_NAME'];
        }
        return $output;
    }
    catch(PDOException $e){
        echo "I'm sorry, Dave. I'm afraid I can't do that.<br>"; // :)
        echo "Error: " . $e->getMessage();
    }
}

// Regresa todos los nombres de columnas (sin repetición) de todas las tablas pasadas como parámetro (arreglo de cadenas de texto).
// Devuelve un arreglo de cadenas de texto que representan cada nombre de columna
function getAllColumnNames($tables){
    $output = array();
    foreach ($tables as $table) {
        $columNames = getColumnNames($table);
        foreach ($columNames as $name) {
            array_push($output, $name);
        }
        $output = array_unique($output);
    }
    return $output;
}

function buscar($query){
    $arrayQuery = explode(' ', $query);
    $totalResults = array();
    $tablas = array('area_de_identificacion', 'area_de_contexto', 'area_de_contenido_y_estructura', 'area_de_condiciones_de_acceso', 'area_de_documentacion_asociada', 'area_de_notas', 'area_de_descripcion');
    $columnas = getAllColumnNames($tablas);
    
    foreach ($arrayQuery as $value) {
        foreach ($columnas as $columna) {
            $select = "SELECT codigo_de_referencia FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion WHERE " . $columna . " LIKE '%" . $value . "%'";
            $stmt = $GLOBALS['conn']->prepare($select);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
            $results = $stmt->fetchAll();
            foreach ($results as $registro){
                array_push($totalResults, $registro['codigo_de_referencia']);
            }
            $totalResults = array_unique($totalResults);
        }
    }
    $registros = array();
    foreach ($totalResults as $clave) {
        $select = "SELECT * FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion WHERE codigo_de_referencia='" . $clave . "'";
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
        $results = $stmt->fetch();
        array_push($registros, $results);
    }
    print_r(json_encode($registros));
}


//Funcion que muestra las caratulas de las decadas existentes en la base de datos
function mostrarDecadas(){
    $select = "SELECT claves.decadas, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigos FROM (SELECT DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas FROM area_de_identificacion) AS claves ORDER BY codigos DESC";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0){
        $data = $stmt->fetchAll(PDO::FETCH_COLUMN,0); // Obtener la información de la primer columna (indice 0)
        print_r(json_encode($data));
    }
}

//Funcion que obtiene los datos por area de cada archivo audivisual
function obtenerArea($id){
    $areas = array(); // Arreglo contenedor de todos los datos

    $select = "SELECT * FROM area_de_identificacion WHERE codigo_de_referencia = '" . $id . "'"; // Query por tabla
    $stmt = $GLOBALS['conn']->prepare($select); // Preparar instrucción
    $stmt->execute(); // Ejecutar instrucción
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() == 1){
        $areas["identificacion"] = $stmt->fetch(); // Obtener los datos y agregarlos al arreglo $areas
    }
    $select = "SELECT * FROM area_de_contexto WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["contexto"] = $stmt->fetch();
        unset($areas['contexto']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM area_de_condiciones_de_acceso WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["condiciones_de_acceso"] = $stmt->fetch();
        unset($areas['condiciones_de_acceso']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM area_de_contenido_y_estructura WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["contenido_y_estructura"] = $stmt->fetch();
        unset($areas['contenido_y_estructura']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM area_de_descripcion WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["descripcion"] = $stmt->fetch();
        unset($areas['descripcion']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM area_de_documentacion_asociada WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["documentacion_asociada"] = $stmt->fetch();
        unset($areas['documentacion_asociada']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM area_de_notas WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["notas"] = $stmt->fetch();
        unset($areas['notas']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM informacion_adicional WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["adicional"] = $stmt->fetch();
        unset($areas['adicional']['codigo_de_referencia']);
    }
    // Agregar la orientación de la imagen:
    $areas["secret"]["orientacion"] = getOrientation($areas);
    
    print_r(json_encode($areas)); // Devolver resultado para ser leido por controller.js
    $GLOBALS['conn'] = null; // Cerrar conexion
}

# Obtener toda la información de la base de datos
function getAbsolutelyAll(){
    $select = "SELECT * FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r(json_encode($data));
    $GLOBALS['conn'] = null;
}

# Obtener sinopsis (de manera ordenada). El parámetro $howMany indica la cantidad de registros por devolver y el parámetro $offset indica el índice a partir del cual se comienzan a obtener.
function getSinopsis($howMany, $offset){
    $select = "SELECT claves.codigo_de_referencia, claves.numeracion, CAST(SUBSTRING_INDEX(decadas,'-',-1) AS UNSIGNED) AS codigo, titulo_propio, sinopsis FROM (SELECT SUBSTRING_INDEX(codigo_de_referencia,'-',4) AS decadas, codigo_de_referencia, CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion FROM area_de_identificacion) AS claves NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_identificacion ORDER BY codigo, numeracion ASC LIMIT $offset, $howMany;";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r(json_encode($data));
    $GLOBALS['conn'] = null;
}

function mostrarCaratulaScroll($codigo,$howMany,$offset){
    $select = "SELECT codigo_de_referencia FROM area_de_identificacion WHERE codigo_de_referencia LIKE '%".$codigo."%' LIMIT ".$offset.",".$howMany;
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    //$stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    
    // Check if id is in database (for develop purpose only)
    if ($stmt->rowCount() != 0){
        $data = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
        print_r(json_encode($data));
        //print_r($data);
    }
}

# Obtener (todos) los datos básicos para mostrar audiovisuales por décadas: id, imagen, titulo, pais, fecha, duracion.
function getDecada($codigoDecada){
    $select = "SELECT codigo_de_referencia, titulo_propio, pais, fecha, duracion, imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia LIKE '%".$codigoDecada."%' ORDER BY fecha ASC";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() != 0){
        $data = $stmt->fetchAll(); // Obtener los datos
        print_r(json_encode($data)); // Convertir a json y mostrar para poder rescatar los datos desde otro script
    }
}

# Determina si la orientación de la imagen es vertical/portrait (portada) u horizontal/landscape (captura de pantalla)
# Recibe un arreglo asociativo con la información del audiovisual (obtenida por consulta a MySQL). Este arreglo debe contener la llave (key) "imagen", que corresponde al nombre del archivo
# Devuelve una cadena de texto: "landscape" si el ancho de la imagen es mayor que la altura, "portrait" en otro caso.
function getOrientation($audiovisual){
    if (array_key_exists('imagen', $audiovisual) && !empty($audiovisual['imagen'])) { // Caso para objeto $audiovisual con poca información (firstGet(), busqueda2())
        $dataImage = getimagesize("../imgs/Portadas/" . $audiovisual['imagen']); // getimagesize() devuelve un arreglo con varios datos. Revisar documentación para detalles
    }
    elseif (array_key_exists('adicional', $audiovisual) && !empty($audiovisual['adicional']['imagen'])) { // Caso para objeto $audiovisual con información completa (obtenerAreas())
        $dataImage = getimagesize("../imgs/Portadas/" . $audiovisual['adicional']['imagen']); // getimagesize() devuelve un arreglo con varios datos. Revisar documentación para detalles
    }
    if (isset($dataImage)){ // Si la variable $dataImage fué inicializada
        $width = $dataImage[0];
        $height = $dataImage[1];
        if($width > $height)
            return "landscape";
    }
    return "portrait"; // valor por default si no existe imagen
}

# Obtener datos básicos para mostrar audiovisuales por décadas: id, imagen, titulo, pais, fecha, duracion.
function firstGet($codigo, $howMany, $offset){
    #$select = "SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia LIKE '%".$codigo."%' ORDER BY fecha DESC LIMIT ".$offset.",".$howMany;
    $select = "SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen FROM (SELECT * FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia LIKE '%".$codigo."%' ORDER BY fecha DESC) AS ordered LIMIT ".$offset.",".$howMany;
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() != 0){
        $data = $stmt->fetchAll(); // Obtener los datos
        foreach ($data as &$audiovisual) {
            $audiovisual['orientacion'] = getOrientation($audiovisual);
        }
        print_r(json_encode($data)); // Convertir a json y mostrar para poder rescatar los datos desde otro script
    }
}

// Búsqueda en toda la base de datos a partir de una frase o palabra (parámetro $query)
// Devuelve solamente la cantidad de elementos deseada (parámetro $howMany)
// a partir del índice indicado (parámetro $offset)
// OPTIMIZABLE:
function busqueda($query, $howMany, $offset){
    $arrayQuery = explode(' ', $query); // Descomponer el texto de búsqueda en palabras individuales
    $totalResults = array(); // Arreglo para almacenar los códigos de los registros con ocurrencias de las palabras
    $tablas = array('area_de_identificacion', 'area_de_contexto', 'area_de_contenido_y_estructura', 'area_de_condiciones_de_acceso', 'area_de_documentacion_asociada', 'area_de_notas', 'area_de_descripcion', 'informacion_adicional');
    $columnas = getAllColumnNames($tablas); // Todos los nombres (strings) de columnas
    
    foreach ($arrayQuery as $value) { // Para cada palabra individual del query original
        foreach ($columnas as $columna) { // Buscar en cada columna de toda la base
            $select = "SELECT codigo_de_referencia FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion NATURAL JOIN informacion_adicional WHERE " . $columna . " LIKE '%" . $value . "%' ORDER BY fecha ASC";
            $stmt = $GLOBALS['conn']->prepare($select);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_COLUMN,0); // Obtener todos los datos de la única columna (codigo_de_referencia)
            $totalResults = array_merge($totalResults, $results); // Agregarlos a un único arreglo
            $totalResults = array_unique($totalResults); // No incluir repetidos
        }
    }
    $registros = array(); // Registros de la base de datos con coincidencias de palabras buscadas
    for ($i=$offset; $i < ($offset+$howMany); $i++) { // Solo obtener n resultados ($howMany) a partir del índice i ($offset)
        if($i < sizeof($totalResults)){ // Para evitar ArrayIndexOutOfBoundException
            $select = "SELECT codigo_de_referencia, titulo_propio, pais, fecha, duracion, imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia='" . $totalResults[$i] . "'"; // $clave || $totalResults[$i]
            $stmt = $GLOBALS['conn']->prepare($select);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
            if($stmt->rowCount() != 0){ // Evitar agregar valores inexistentes (false) al arreglo final de resultados
                $results = $stmt->fetch();
                array_push($registros, $results);
            }
        }
    }



    if (!empty($registros)) { // Solamente mostrar resultados cuando la búsqueda no es vacia
        print_r(json_encode($registros));
    }
}

// Función de comparación para ordenar por fecha
function cmpFecha($item1, $item2){
    return $item2['fecha'] - $item1['fecha'];
}

// Función de comparación para priorizar los campos de las areas de documentación.
// Útil para ordenar los resultados por áreas en la función busqueda2()
// Devuelve un entero menor que, igual, o mayor que cero si el primer argumento es considerado respectivamente menor que, igual, o mayor que el segundo.
function cmpCampos($str1, $str2){
    // Arreglo asociativo que indica la prioridad de cada campo (menor valor indica mayor prioridad)
    $campos = array(
        'codigo_de_referencia' => 0, 
        'titulo_propio' => 1, 
        'titulo_paralelo' => 2, 
        'titulo_atribuido' => 3, 
        'titulo_de_serie' => 4, 
        'numero_de_programa' => 5, 
        'pais' => 6, 
        'fecha' => 7, 
        'duracion' => 8, 
        'investigacion' => 9, 
        'realizacion' => 10, 
        'direccion' => 11, 
        'guion' => 12, 
        'adaptacion' => 13, 
        'idea_original' => 14, 
        'fotografia' => 15, 
        'fotografia_fija' => 16, 
        'edicion' => 17, 
        'sonido_grabacion' => 18, 
        'sonido_edicion' => 19, 
        'musica_original' => 20, 
        'musicalizacion' => 21, 
        'voces' => 22, 
        'actores' => 23, 
        'animacion' => 24, 
        'otros_colaboradores' => 25, 
        'entidad_productora' => 26, 
        'productor' => 27, 
        'distribuidora' => 28, 
        'historia_institucional' => 29, 
        'resena_biografica' => 30, 
        'forma_de_ingreso' => 31, 
        'fecha_de_ingreso' => 32, 
        'sinopsis' => 33, 
        'descriptor_onomastico' => 34, 
        'descriptor_toponimico' => 35, 
        'descriptor_cronologico' => 36, 
        'tipo_de_produccion' => 37, 
        'genero' => 38, 
        'fuentes' => 39, 
        'recursos' => 40, 
        'versiones' => 41, 
        'formato_original' => 42, 
        'material_extra' => 43, 
        'condiciones_de_acceso' => 44, 
        'existencia_y_localizacion_de_originales' => 45, 
        'idioma_original' => 46, 
        'doblajes_disponibles' => 47, 
        'subtitulajes' => 48, 
        'soporte' => 49, 
        'numero_copias' => 50, 
        'descripcion_fisica' => 51, 
        'color' => 52, 
        'audio' => 53, 
        'sistema_de_grabacion' => 54, 
        'region_dvd' => 55, 
        'requisitos_tecnicos' => 56, 
        'existencia_y_localizacion_de_copias' => 57, 
        'unidades_de_descripcion_relacionadas' => 58, 
        'documentos_asociados' => 59, 
        'area_de_notas' => 60, 
        'notas_del_archivero' => 61, 
        'datos_del_archivero' => 62, 
        'reglas_o_normas' => 63, 
        'fecha_de_descripcion' => 64, 
        'imagen' => 65, 
        'url' => 66
    );
    return $campos[$str1] - $campos[$str2];
}

// Búsqueda que incluye el rubro en donde se encontró la coincidencia
// El parámetro $permiso se utiliza para restringir la búsqueda dentro del area_de_decripcion
function busqueda2($query, $permiso){
    // lista de palabras a ignorar:
    $exclude_words = array("el", "la", "los", "las", "un", "una", "unos", "unas", "lo", "a el", "al", "de el", "del", "a", "ante", "bajo", "con", "contra", "de", "desde", "durante", "en", "entre", "hacia", "hasta", "mediante", "para", "por", "según", "sin", "sobre", "tras", "este", "ese", "aquel", "esta", "esa", "aquella", "estos", "esos", "aquellos", "estas", "esas", "aquellas", "esto", "eso", "aquello", "mi", "mis", "tu", "tus", "su", "sus");
    //$arrayQuery = array();
    //array_push($arrayQuery, $query);
    ##### desscomentar/comentar 2 lineas anteriores y descomentar/comentar 3 lineas posteriores para cambiar las keywords a buscar
    $arrayQuery = explode(' ', $query); // Descomponer el texto de búsqueda en palabras individuales
    //if(sizeof($arrayQuery) > 1)
        //array_push($arrayQuery, $query);
    foreach ($exclude_words as $word) { // si la consulta ($query) tiene palabras a ignorar, se eliminan
        if (in_array($word, $arrayQuery)) {
            unset($arrayQuery[array_search($word, $arrayQuery)]);
        }
    }
    $cleanQuery = implode("%", $arrayQuery); // nuevo query de búsqueda que incluye todas las palabras en orden (no necesariamente juntas)
    $totalResults = array(); // Arreglo para almacenar los códigos de los registros con ocurrencias de las palabras
    $tablas = array('area_de_identificacion', 'area_de_contexto', 'area_de_contenido_y_estructura', 'area_de_condiciones_de_acceso', 'area_de_documentacion_asociada', 'area_de_notas', 'area_de_descripcion');
    if ($permiso == 0) // Si la consulta no tiene permisos suficientes, no buscar dentro del area_de_descripcion
        array_pop($tablas);
    $columnas = getAllColumnNames($tablas); // Todos los nombres (strings) de columnas

    // Se obtendrán los códigos y los rubros donde hay coincidencias en la búsqueda:
    foreach ($arrayQuery as $query) { // Para cada palabra individual del query original
        foreach ($columnas as $columna) { // Buscar en cada columna de toda la base
            $select = "SELECT codigo_de_referencia FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion WHERE " . $columna . " RLIKE '[[:<:]]" . $cleanQuery . "[[:>:]]' ORDER BY fecha ASC";
            if ($permiso == 0) // Si la consulta no tiene permisos suficientes, no buscar dentro del area_de_descripcion
                $select = "SELECT codigo_de_referencia FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas WHERE " . $columna . " RLIKE '[[:<:]]" . $cleanQuery . "[[:>:]]' ORDER BY fecha ASC";
            $stmt = $GLOBALS['conn']->prepare($select);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
            while($row = $stmt->fetch()){ // Para cada resultado de la consulta (cada codigo_de_referencia)
                $codigo_de_referencia = $row['codigo_de_referencia'];
                if(array_key_exists($codigo_de_referencia, $totalResults)) // Si ya había coincidencia con este registro
                    if(array_key_exists($query, $totalResults[$codigo_de_referencia])) // Y si es la misma palabra de la búsqueda
                        array_push($totalResults[$codigo_de_referencia][$query], $columna); // Entonces se agrega el campo o rubor donde hay coincidencia
                    else
                        $totalResults[$codigo_de_referencia][$query] = array($columna); // Si no, se agrega la palabra (query) y el campo donde hay coincidencia
                else
                    $totalResults[$codigo_de_referencia] = array($query=>array($columna)); // En otro caso, es la primera coincidencia y se guarda la palabra y el rubro
            }
        }
    }
    // Falta completar los resultados obtenidos con la información necesaria para la vista (titulo, pais, fehca, duración, imagen)
    $registros = array(); // Registros de la base de datos con coincidencias de palabras buscadas
    foreach($totalResults as $codigo => $querys) {
        $select = "SELECT codigo_de_referencia, titulo_propio, titulo_paralelo, fecha, imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia='" . $codigo . "'"; // $clave || $totalResults[$i]
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
        if($stmt->rowCount() != 0){ // Evitar agregar valores inexistentes (false) al arreglo final de resultados
            $results = $stmt->fetch();
            $results['rubros'] = $totalResults[$codigo]; // Agregamos los rubros con coincidencias encontrados previamente
            array_push($registros, $results); // Agregamos al arreglo final
            //$registros[$results['codigo_de_referencia']] = $results; // Agregar con codigo_de_referencia como llave del objeto/arreglo asociativo
        }
    }
    
    // Incluir la propiedad "uniqueNames" a los registros encontrados
    $uniqueNames = array(); // Permite agregar únicamente los nombres de los campos/rubros con coincidencias (ayuda al multiselect de la vista para hacer filtros)
    foreach ($totalResults as $registro)
        foreach ($registro as $rubro) {
            $uniqueNames = array_merge($uniqueNames, $rubro);
            $uniqueNames = array_unique($uniqueNames); // Evitar repetidos
        }
    usort($uniqueNames, 'cmpCampos'); // Ordena por prioridad de los rubros (campos)

    if (!empty($registros)) { // Solamente mostrar resultados cuando la búsqueda no es vacia
        usort($registros, "cmpFecha"); // Ordenar por fecha
        array_push($registros, $uniqueNames);
        //$registros['uniqueNames'] = $uniqueNames;

        // Agregar la orientación de las imágenes:
        foreach ($registros as $key => &$audiovisual) {
            if($key < count($registros)-1) // porque el último elemento contiene un listado de campos
                $audiovisual['orientacion'] = getOrientation($audiovisual);
        }
        print_r(json_encode($registros));
    }
}

# Determinar el siguiente indice consecutivo dentro de una década
# Recibe el código de identificación de una década (e.g. MXIM-AV-1-4)
# Devuelve el primer indice consecutivo faltante en la numeración de audiovisuales
function getIndice($decada){
    $select = "SELECT DISTINCT SUBSTRING_INDEX(codigo_de_referencia,'-',-1) as decadas FROM area_de_identificacion WHERE codigo_de_referencia LIKE '%" . $decada . "%' ORDER BY decadas ASC";
    $stmt = $GLOBALS['conn']->prepare($select); // Obtener la numeración de la década (últimos dígitos del código de identificación)
    $stmt->execute();
    if ($stmt->rowCount() == 0){
        print_r(json_encode(1)); // Nueva década
    } else {
        $data = $stmt->fetchAll(PDO::FETCH_COLUMN,0); // Obtener todos los datos de la única columna
        sort($data); // Ordenar para recorrer en orden
        for ($i=1; $i <= sizeof($data); $i++) {
            if($i != (int)$data[$i-1]){ // El primer momento en que hay un "hueco" en la numeración
                print_r(json_encode($i)); // Devolver el indice que llena el "hueco"
                return;
            }
        }
        print_r(json_encode(sizeof($data)+1)); // Devolver el último indice (no hay "huecos" en la numeración)
    }
}

# A partir de la información del formulario de contacto, se envia un correo con la información del usuario, su correo (opcionalmente)
# y el mensaje del usuario. El mensaje se envia mediante la biblioteca PHPMailer, ya que permite enviar correos desde una
# cuenta en otro servidor (por ejemplo GMail, Outlook) y permite usar el formato HTML, adjuntar archivos, entre otras funciones.
# Para detalles sobre cómo usar PHPMailer: https://github.com/PHPMailer/PHPMailer
function mailMe(){
    $data = json_decode(file_get_contents("php://input")); // Obtener datos del controlador(controller.js -> contactCtrl -> $scope.enviar)

    $title = "Opinión de metaDOC"; // Titulo del mensaje (no es el subject)
    $mailSubject = '[metaDOC] Opinión de usuario'; // El subject o asunto del correo
    $user = empty($data->Name) ? "Anónimo" : $data->Name; // Nombre del usuario
    $message = $data->Message; // Mensaje del usuario
    $userMail = empty($data->Email) ? "" : $data->Email; // Email opcional del usuario
    // Correo del usuario en formato HTML:
    $userMailHTML = empty($userMail) ? "" : '<br> <strong>Correo</strong> <a href="mailto:' . $userMail . '?subject=Opini%C3%B3n%20del%20sitio%20metaDOC">' . $userMail . '</a>';
    // Correo del usuario en formato de texto plano:
    $userMailNonHTML = empty($userMail) ? "" : "\nCorreo: " . $userMail;

    /* El mensaje enviado tiene el siguiente formato (tanto en HTML como en texto plano):
        <titulo>
        De: <usuario>
        Correo: <correoUsuario>
        Mensaje:
        <mensajeEscritoPorUsuario>
        -------
        <pieDelMensaje>
    */
    // Mensaje del correo en formato HTML
    $htmlbody = '<h3>' . $title . '</h3> ' .
            '<p>' .
                '<strong>De</strong>: ' . $user .
                $userMailHTML .
            '</p>' .
            '<p>' .
                '<strong>Mensaje</strong>:' .
                '<br>' .
                $message .
            '</p>' .
            '<hr>' .
            '<small>Mensaje enviado desde el sitio <a href="http://lais.mora.edu.mx/metadoc">metaDOC</a></small>';
    // Mensaje de correo en formato de texto plano:
    $simplebody = $title . "\n\n" . 
            "De: " . $user . 
            $userMailNonHTML . "\n\n" . 
            "Mensaje:\n" . 
            $message . "\n\n" . 
            "----------\n" . 
            "Mensaje enviado desde el sitio metaDOC (http://lais.mora.edu.mx/metadoc)";

    // A continuación viene la creación y envio del mensaje usando PHPMailer:
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Allow UTF-8 encoding
    $mail->CharSet = 'UTF-8';
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "rodrigo.cln@ciencias.unam.mx";
    //Password to use for SMTP authentication
    $mail->Password = "animeroyrogers";
    //Set who the message is to be sent from
    $mail->setFrom('rodrigo.cln@ciencias.unam.mx', 'Rodrigo Eduardo Colín Rivera');
    //Set an alternative reply-to address
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //Set who the message is to be sent to
    $mail->addAddress('rcolin@institutomora.edu.mx', 'Rodrigo Colín');
    // Add a "CC" address
    //$mail->addCC("animeroy@gmail.com", "Roy");
    //Set the subject line
    $mail->Subject = $mailSubject;
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($htmlbody);
    //Add the body in plain text
    //$mail->Body = "Hello world. This is a plain-text message body.\nFoo.";
    //Replace the plain text body with one created manually
    $mail->AltBody = $simplebody;
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    
    $response = array('success' => false); // Variable "success" para indicar si el mensaje se envió correctamente
    if ($mail->send()) //send the message
        $response['success'] = true;
    echo json_encode($response); // Responder al controlador si la operación fué correcta
}

// Devuelve la cantidad de registros (documentales) que hay en la base de datos
function countAll(){
    $select = "SELECT COUNT(*) AS total FROM area_de_identificacion";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetch();
    print_r(json_encode($data));
    $GLOBALS['conn'] = null;
}

//Obtiene todo los usuarios
function obtener_datosUsuarios(){
    $select = "SELECT * FROM usuarios";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll();
    print_r(json_encode($data));
    $GLOBALS['conn'] = null;
}

//Obtiene información de un usuario
function obtener_usuario($usuario){
    $select = "SELECT * FROM usuarios WHERE Username = '" . $usuario . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() == 1){
        $data = $stmt->fetch(); // Obtener el único resultado de la base de datos
        print_r(json_encode($data));
    }
    $GLOBALS['conn'] = null;
}


//Funcion que agrega un nuevo usuario con sus respectivos datos
function agregar_datosUsuario(){
    $data = json_decode(file_get_contents("php://input"));
    $sql = "INSERT INTO usuarios(Password,Username,Privilegio) VALUES('" . $data->Password . "', '" . $data->Username . "', '" . $data->Privilegio . "');";
    try{
        $GLOBALS['conn']->exec($sql);
        print_r(json_encode(array("Status"=>"Ok")));
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

//Función que actualiza a un usuario existente
function actualizar_usuario(){
    $data = json_decode(file_get_contents("php://input"));
    $sql = "UPDATE usuarios SET Username ='" . $data->Username . "', Password ='" . $data->Password . "', Privilegio ='" . $data->Privilegio . "' WHERE Username='" . $data->nombreAuxiliar . "'";
    try{
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        print_r(json_encode(array("Status"=>"Ok")));
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

//Función que borra un usuario
function borrarUsuario(){
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->Username;
    $sql = "DELETE FROM usuarios WHERE Username='" . $name . "'";
    try{
        $GLOBALS['conn']->exec($sql);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

// Obtiene diversas estadísticas sobre la cantidad de documentales en la base de datos
// El parámetro $decada nos indica de qué década en particular se desesan las estadísticas
function datos_estadisticos($decada){
    $datos = array(); # guardar toda la información en un solo arreglo
    try {
        # Realizar la cantidad de documentales totales
        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS documentales FROM area_de_identificacion WHERE codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ); # Obtener resultado como objeto, por ejemplo: {documentales: 800}
        $result = $stmt->fetch(); # El único resultado es un número
        $datos["documentales"] = $result->documentales; # Guardar el resultado en el arreglo
        # De manera análoga para el resto de datos deseados:

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS sinopsis FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura WHERE sinopsis NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["sinopsis"] = $result->sinopsis;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS pais FROM area_de_identificacion WHERE pais NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["pais"] = $result->pais;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS fecha FROM area_de_identificacion WHERE fecha NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["fecha"] = $result->fecha;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS duracion FROM area_de_identificacion WHERE duracion NOT LIKE '00:00:00' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["duracion"] = $result->duracion;

        //$stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS realizacion FROM area_de_identificacion WHERE realizacion NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS realizacion FROM area_de_identificacion WHERE (realizacion NOT LIKE '' OR direccion NOT LIKE '') AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["realizacion"] = $result->realizacion;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS fuentes FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura WHERE fuentes NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["fuentes"] = $result->fuentes;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS recursos FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura WHERE recursos NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["recursos"] = $result->recursos;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE imagen NOT LIKE '' AND codigo_de_referencia LIKE '$decada%'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["imagen"] = $result->imagen;

        $stmt = $GLOBALS['conn']->prepare("SELECT COUNT(*) AS url FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE url NOT LIKE '' AND codigo_de_referencia LIKE '$decada%';");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $result = $stmt->fetch();
        $datos["url"] = $result->url;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    print_r(json_encode($datos));
    $GLOBALS['conn'] = null;
}

// Petición a la base de datos de los primeros n registros a partir de la posición k,
// donde n es el parámetro $offset y k es el parámetro $rowCount.
function registro_actividades($offset, $rowCount){
    $select = "SELECT * FROM registro_actividades ORDER BY fecha DESC LIMIT $offset, $rowCount";
    try{
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data = $stmt->fetchAll();
        print_r(json_encode($data));
        $GLOBALS['conn'] = null;
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}

// Indica cuáles documentales tienen información faltante.
// $decada indica el subconjunto de documentales a revisar
// $campo es el área o campo que se desea verificar si está vacio
// $area es el nombre de la tabla donde se encuentra el campo (es opcional para información que no está en el área de identificación)
// Devuelve un arreglo de objetos con el codigo de referencia y el nombre propio de los documentales
// con información vacia en el campo $campo (de la tabla $area).
function faltantes_detalles($decada, $campo, $area){
    $void = $campo == 'duracion' ? '00:00:00' : ''; # La "cadena vacia" para duración (TIME) es '00:00:00'
    $join = empty($area) ? '' : "NATURAL JOIN $area"; # Si la consulta SQL requiere hacer un NATURAL JOIN
    # Consulta SQL. Utiliza los parametros y las variable $join y $void:
    $select = "SELECT codigo_de_referencia, titulo_propio, 
      CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion, 
      CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(codigo_de_referencia,'-',4),'-',-1) AS UNSIGNED) AS decada 
        FROM area_de_identificacion $join 
        WHERE $campo = '$void' AND codigo_de_referencia LIKE '$decada%' 
        ORDER BY decada DESC, numeracion ASC";

    if($campo == 'realizacion')
        $select = "SELECT codigo_de_referencia, titulo_propio, 
          CAST(SUBSTRING_INDEX(codigo_de_referencia,'-',-1) AS UNSIGNED) AS numeracion, 
          CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(codigo_de_referencia,'-',4),'-',-1) AS UNSIGNED) AS decada 
            FROM area_de_identificacion $join 
            WHERE $campo = '$void' AND direccion = '' AND codigo_de_referencia LIKE '$decada%' 
            ORDER BY decada DESC, numeracion ASC";

    try {
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_FUNC, "getOnlyNecessary");
        # NOTA: La consulta en $select ordena numéricamente mediante dos columnas auxiliares ('numeracion' y 'decada')
        # pero para no enviar estos datos innecesarios, la función "getOnlyNecessary" los ignora.
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    $GLOBALS['conn'] = null;
    print_r(json_encode($datos));
}

// Auxiliar para ignorar columnas que no se requieren. Ver la consulta de la función faltantes_detalles en caso de más explicación.
function getOnlyNecessary($codigo, $titulo, $numeracion, $decada){
    return (object) array('codigo_de_referencia' => $codigo, 'titulo_propio' => $titulo);
}

// Recibe código de referencia, determina si es un nuevo registro de nueva década y devuelve un código de sugerencia.
// Devuelve el valor "1" para indicar que se va a crear una nueva década
// Devuelve un valor numérico distinto de 1 para indicar la numeración correcta de una década existente
function sugerencia($clave){
    $select = "SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(codigo_de_referencia,'-',-2), '-', 1) as decadas FROM area_de_identificacion ORDER BY decadas ASC";
    try{
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        if ($stmt->rowCount() == 0){
            // error
        } else {
            $data = $stmt->fetchAll(PDO::FETCH_COLUMN,0); // Todas las claves de décadas existentes en la base de datos
            if(in_array(explode("-", $clave)[3], $data)){ // Si la clave de década se encuentra en $data
                getIndice(substr($clave, 0, strrpos($clave, '-'))); // Sugerir próximo indice consecutivo
            }
            else{
                print_r(json_encode(1)); // Indicar que se trata de una nueva década
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}
?>