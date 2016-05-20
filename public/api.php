<?php
require_once 'php/conexion.php';

/*Casos para tomar la acción del controlador*/
switch ($_GET['req']) {
    case 'get':
        getAllInfo($_GET['id']);
        break;
    case 'sget':
        simpleGet($_GET['id']);
        break;
    case 'search':
        search($_GET['query']);
        break;
    case 'asearch':
        areaSearch($_GET['query']);
        break;
    default:
        echo 'Default';
}

function getAllInfo($id){
    $areas = array(); // Arreglo contenedor de todos los datos

    $select = "SELECT * FROM area_de_identificacion WHERE codigo_de_referencia = '${id}'"; // Query por tabla
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
    $select = "SELECT * FROM area_de_descripcion WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["descripcion"] = $stmt->fetch();
        unset($areas['descripcion']['codigo_de_referencia']);
    }
    $select = "SELECT * FROM informacion_adicional WHERE codigo_de_referencia = '" . $id . "'";
    $stmt = $GLOBALS['conn']->prepare($select);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1){
        $areas["adicional"] = $stmt->fetch();
        unset($areas['adicional']['codigo_de_referencia']);
    }
    
    print_r(json_encode($areas)); // Devolver resultado en formato JSON
    $GLOBALS['conn'] = null; // Cerrar conexion
}

function simpleGet($id){
    $select = "SELECT codigo_de_referencia, titulo_propio, fecha, duracion, realizacion, sinopsis FROM area_de_identificacion NATURAL JOIN area_de_contenido_y_estructura WHERE codigo_de_referencia = '${id}'";
    $stmt = $GLOBALS['conn']->prepare($select); // Preparar instrucción
    $stmt->execute(); // Ejecutar instrucción
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
    if ($stmt->rowCount() == 1){
        $result = $stmt->fetch(); // Obtener los datos
    }
    
    print_r(json_encode($result)); // Devolver resultado en formato JSON
    $GLOBALS['conn'] = null; // Cerrar conexion
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
        foreach ($columNames as $name)
            array_push($output, $name);
        $output = array_unique($output);
    }
    return $output;
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

// Función de comparación para ordenar por fecha
function cmpFecha($item1, $item2){
    return $item2['fecha'] - $item1['fecha'];
}

function search($query){
    // lista de palabras a ignorar:
    $exclude_words = array("el", "la", "los", "las", "un", "una", "unos", "unas", "lo", "a el", "al", "de el", "del", "a", "ante", "bajo", "con", "contra", "de", "desde", "durante", "en", "entre", "hacia", "hasta", "mediante", "para", "por", "según", "sin", "sobre", "tras", "este", "ese", "aquel", "esta", "esa", "aquella", "estos", "esos", "aquellos", "estas", "esas", "aquellas", "esto", "eso", "aquello", "mi", "mis", "tu", "tus", "su", "sus");
    $arrayQuery = explode(' ', $query); // Descomponer el texto de búsqueda en palabras individuales
    foreach ($exclude_words as $word) // si la consulta ($query) tiene palabras a ignorar, se eliminan
        if (in_array($word, $arrayQuery))
            unset($arrayQuery[array_search($word, $arrayQuery)]);

    $cleanQuery = implode("%", $arrayQuery); // nuevo query de búsqueda que incluye todas las palabras en orden (no necesariamente juntas)
    $totalResults = array(); // Arreglo para almacenar los códigos de los registros con ocurrencias de las palabras
    $tablas = array('area_de_identificacion', 'area_de_contexto', 'area_de_contenido_y_estructura', 'area_de_condiciones_de_acceso', 'area_de_documentacion_asociada', 'area_de_notas', 'area_de_descripcion');
    $columnas = getAllColumnNames($tablas); // Todos los nombres (strings) de columnas

    // Se obtendrán los códigos y los rubros donde hay coincidencias en la búsqueda:
    foreach ($arrayQuery as $query) // Para cada palabra individual del query original
        foreach ($columnas as $columna) { // Buscar en cada columna de toda la base
            $select = "SELECT codigo_de_referencia FROM area_de_identificacion NATURAL JOIN area_de_contexto NATURAL JOIN area_de_contenido_y_estructura NATURAL JOIN area_de_condiciones_de_acceso NATURAL JOIN area_de_documentacion_asociada NATURAL JOIN area_de_notas NATURAL JOIN area_de_descripcion WHERE " . $columna . " LIKE '%" . $cleanQuery . "%' ORDER BY fecha ASC";
            $stmt = $GLOBALS['conn']->prepare($select);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
            while($row = $stmt->fetch()){ // Para cada resultado de la consulta (cada codigo_de_referencia)
                $codigo_de_referencia = $row['codigo_de_referencia'];
                if(array_key_exists($codigo_de_referencia, $totalResults)) // Si ya había coincidencia con este registro
                    array_push($totalResults[$codigo_de_referencia], $columna); // Entonces se agrega el campo o rubor donde hay coincidencia
                else
                    $totalResults[$codigo_de_referencia] = array($columna); // En otro caso, es la primera coincidencia y se guarda la palabra y el rubro
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
            $results['campos'] = $totalResults[$codigo]; // Agregamos los rubros con coincidencias encontrados previamente
            array_push($registros, $results); // Agregamos al arreglo final
        }
    }
    
    // Incluir la propiedad "uniqueNames" a los registros encontrados
    $uniqueNames = array(); // Permite agregar únicamente los nombres de los campos/rubros con coincidencias (ayuda al multiselect de la vista para hacer filtros)
    foreach ($totalResults as $registro)
        foreach ($registro as $rubro) {
            $uniqueNames = array_merge($uniqueNames, $rubro);
            $uniqueNames = array_unique($uniqueNames); // Evitar repetidos
        }
    usort($uniqueNames, "cmpCampos"); // Ordena por prioridad de los rubros (campos)

    if (!empty($registros)) // Solamente mostrar resultados cuando la búsqueda no es vacia
        usort($registros, "cmpFecha"); // Ordenar por fecha
    
    print_r(json_encode($registros));
}
?>