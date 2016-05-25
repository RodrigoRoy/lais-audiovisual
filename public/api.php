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
    case 'csearch':
        columnSearch($_GET['query'], $_GET['campo']);
        break;
    default:
        echo '<h1>API de acceso a la informaci&oacute;n&nbsp;de metaDOC</h1>
        <p>Para el uso correcto del API consulta "<strong>Desarrolladores</strong>" dentro de la p&aacute;gina "<a href="http://lais.mora.edu.mx/metadoc/#/acercade">Acerca del sitio</a>".</p>
        <h5><em>Laboratorio Audiovisual de Investigaci&oacute;n Social (LAIS) - Instituto Mora</em></h5>';
}

// Obtener toda la información de un documental de la base de datos.
// El formato es un JSON a partir de un arreglo asociativo que contiene todas las áreas y, a su vez, todos los campos dentro de ésta (incluyendo cadenas vacias)
// Recibe como parámetro una cadena de texto que representa el identificador único, es decir, el código de referencia del documental
// Si el $id no exite devuelve un arreglo vacio, en otro caso devuelve un objeto JSON con toda la información del documental.
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

// Devuelve un subconjunto de información del documental solicitado.
// La información básica que se envia es: código de referencia, título propio, fecha, duración, realizador/director y sinópsis.
// Recibe como parámetro una cadena de texto que representa el identificador único, es decir, el código de referencia del documental
// Si el $id no exite devuelve un arreglo vacio, en otro caso devuelve un objeto JSON con la información básica del documental.
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

// Función auxiliar que devulve todos los nombres de columnas de (el nombre de) una tabla pasada como parámetro. Auxiliar para búsquedas sobre toda la base de datos.
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

// Función auxiliar que regresa todos los nombres de columnas (sin repetición) de todas las tablas pasadas como parámetro (arreglo de cadenas de texto).
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

// Realiza un búsqueda exhaustiva en toda la base de datos en búsca de coincidencias con el query dado.
// El query es procesado para eliminar artículos y preposiciones. La búsqueda requiere que TODAS las palabras tengan aparición en un campo de la base de datos.
// Recibe una cadena de texto que representa el query de búsqueda.
// Si el parámetro o query es vacio devuelve un arreglo vacio, en caso contrario devuelve un objeto JSON que es una lista de objetos con las siguientes propiedades:
// - codigo_de_referencia
// - titulo_propio
// - fecha
// - imagen
// - campos (Lista de los campos donde hubo coincidencia de búsqueda)
function search($query){
    if(empty($query))
        return print_r("ERROR: Query de búsqueda vacío. Se requiere especificar un texto de búsqueda en el parámetro 'query'.");

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
        $select = "SELECT codigo_de_referencia, titulo_propio, fecha, imagen FROM area_de_identificacion NATURAL JOIN informacion_adicional WHERE codigo_de_referencia='" . $codigo . "'"; // $clave || $totalResults[$i]
        $stmt = $GLOBALS['conn']->prepare($select);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo con nombres de columnas de la base)
        if($stmt->rowCount() != 0){ // Evitar agregar valores inexistentes (false) al arreglo final de resultados
            $results = $stmt->fetch();
            $results['imagen'] = $results['imagen'] == "" ? "" : "http://lais.mora.edu.mx/metadoc/imgs/Portadas/${results['imagen']}"; // Completar URL de la imagen
            $results['campos'] = array_unique($totalResults[$codigo]); // Agregamos los rubros con coincidencias encontrados previamente
            array_push($registros, $results); // Agregamos al arreglo final
        }
    }

    if (!empty($registros)) // Solamente mostrar resultados cuando la búsqueda no es vacia
        usort($registros, "cmpFecha"); // Ordenar por fecha
    
    print_r(json_encode($registros));
}

// Auxiliar que recibe como parámetro un cadena de texto que representa un campo. 
// Devuelve como cadena de texto el área en que se encuentra contenido dicho campo. En caso de que el campo no exista se devuelve una cadena vacia.
function getArea($campo){
    // Arreglos que representan las áreas de la base de datos con sus respectivos campos como elementos del arreglo
    $identificacion = array('codigo_de_referencia', 'titulo_propio', 'titulo_paralelo', 'titulo_atribuido', 'titulo_de_serie', 'numero_de_programa', 'pais', 'fecha', 'duracion', 'investigacion', 'realizacion', 'direccion', 'guion', 'adaptacion', 'idea_original', 'fotografia', 'fotografia_fija', 'edicion', 'sonido_grabacion', 'sonido_edicion', 'musica_original', 'musicalizacion', 'voces', 'actores', 'animacion', 'otros_colaboradores');
    $contexto = array('entidad_productora', 'productor', 'distribuidora', 'historia_institucional', 'resena_biografica', 'forma_de_ingreso', 'fecha_de_ingreso');
    $contenido_y_estructura = array('sinopsis', 'descriptor_onomastico', 'descriptor_toponimico', 'descriptor_cronologico', 'tipo_de_produccion', 'genero', 'fuentes', 'recursos', 'versiones', 'formato_original', 'material_extra');
    $condiciones_de_acceso = array('condiciones_de_acceso', 'existencia_y_localizacion_de_originales', 'idioma_original', 'doblajes_disponibles', 'subtitulajes', 'soporte', 'numero_copias', 'descripcion_fisica', 'color', 'audio', 'sistema_de_grabacion', 'region_dvd', 'requisitos_tecnicos');
    $documentacion_asociada = array('existencia_y_localizacion_de_copias', 'unidades_de_descripcion_relacionadas', 'documentos_asociados');
    $notas = array('area_de_notas');
    $descripcion = array('notas_del_archivero', 'datos_del_archivero', 'reglas_o_normas', 'fecha_de_descripcion');
    $adicional = array('imagen', 'url');
    // Arreglo bidimensional que contiene los arreglos anteriores
    $areas = array('area_de_identificacion' => $identificacion, 'area_de_contexto' => $contexto, 'area_de_contenido_y_estructura' => $contenido_y_estructura, 'area_de_condiciones_de_acceso' => $condiciones_de_acceso, 'area_de_documentacion_asociada' => $documentacion_asociada, 'area_de_notas' => $notas, 'area_de_descripcion' => $descripcion, 'informacion_adicional' => $adicional);
    foreach ($areas as $areaKey => $areaArray)
        if (in_array($campo, $areaArray))
            return $areaKey;
    return "";
}

// Realiza una búsqueda acotada en un solo campo.
// El primer parámetro representa el query de búsqueda, el segundo parámetro representa el campo donde se desea buscar.
// Devuelve una lista (arreglo) que contiene arreglos asociativos con las siguientes keys: codigo_de_referencia y $campo
// (excepto si éste es "codigo_de_referencia", en cuyo caso solamente incluye key: codigo_de_referencia)
function columnSearch($query, $campo){
    $areaToSearch = getArea($campo);
    if(empty($areaToSearch)) // Si no exite el campo, devolver mensaje de error
        return print_r("ERROR: El campo no existe. Verifica que esté correctamente escrito");
    $selectCampo = ''; // se usará para la construcción de la sentencia SQL
    if ($campo != 'codigo_de_referencia')
        $selectCampo = ", ${campo}"; // incluir el campo para SELECT de la sentencia SQL
    
    $naturalJoin = ''; // se usará para la construcción de la sentencia SQL
    if ($areaToSearch != 'area_de_identificacion') {
        $naturalJoin = "NATURAL JOIN ${areaToSearch}"; // incluir el area (tabla) para NATURAL JOIN de la sentencia SQL
    }

    // lista de palabras a ignorar dentro del query:
    $exclude_words = array("el", "la", "los", "las", "un", "una", "unos", "unas", "lo", "a el", "al", "de el", "del", "a", "ante", "bajo", "con", "contra", "de", "desde", "durante", "en", "entre", "hacia", "hasta", "mediante", "para", "por", "según", "sin", "sobre", "tras", "este", "ese", "aquel", "esta", "esa", "aquella", "estos", "esos", "aquellos", "estas", "esas", "aquellas", "esto", "eso", "aquello", "mi", "mis", "tu", "tus", "su", "sus");
    $arrayQuery = explode(' ', $query); // Descomponer el texto de búsqueda en palabras individuales
    foreach ($exclude_words as $word) // si la consulta ($query) tiene palabras a ignorar, se eliminan
        if (in_array($word, $arrayQuery))
            unset($arrayQuery[array_search($word, $arrayQuery)]);
    $cleanQuery = implode("%", $arrayQuery); // nuevo query de búsqueda que incluye todas las palabras en orden separadas por "%" (para consulta con LIKE en SQL)

    // Construir sentencia SQL y obtener los resultados
    $select = "SELECT codigo_de_referencia ${selectCampo} FROM area_de_identificacion ${naturalJoin} WHERE ${campo} LIKE '%${cleanQuery}%'";
    $stmt = $GLOBALS['conn']->prepare($select); // Preparar instrucción
    $stmt->execute(); // Ejecutar instrucción
    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Establecer fetch mode (arreglo asociativo)
    if ($stmt->rowCount() > 0){
        $resultSet = $stmt->fetchAll(); // Obtener el conjunto de resultados
    }
    
    print_r(json_encode($resultSet)); // Devolver resultado en formato JSON
    $GLOBALS['conn'] = null; // Cerrar conexion
}
?>