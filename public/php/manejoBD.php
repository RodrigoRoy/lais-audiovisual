<?php
include 'filters.php';
include 'conexion.php';
	



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
    $_POST['duracion'] = setDuracion($_POST['duracion']);
    
    if(isset($_POST['fuentes'])){
        $_POST['fuentes'] = setFuenteRecurso($_POST['fuentes']);
    }else{
        $_POST['fuentes'] = '';
    }
    
    if(isset($_POST['recursos'])){
        $_POST['recursos'] = setFuenteRecurso($_POST['recursos']);
    }else{
        $_POST['recursos'] = '';
    }

    $identificacion = "INSERT INTO area_de_identificacion() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['titulo_propio'] . "','" 
            . $_POST['titulo_paralelo'] . "','" 
            . $_POST['titulo_atribuido'] . "','" 
            . $_POST['titulo_de_serie'] . "','"
            . $_POST['numero_de_programa'] . "','"
            . $_POST['pais'] . "','"
            . $_POST['fecha'] . "',"
            . $_POST['duracion'] . ",'"
            . $_POST['investigacion'] . "','"
            . $_POST['realizacion'] . "','"
            . $_POST['direccion'] . "','"
            . $_POST['guion'] . "','"
            . $_POST['adaptacion'] . "','"
            . $_POST['idea_original'] . "','"
            . $_POST['fotografia'] . "','"
            . $_POST['fotografia_fija'] . "','"
            . $_POST['edicion'] . "','"
            . $_POST['sonido_grabacion'] . "','"
            . $_POST['sonido_edicion'] . "','"
            . $_POST['musica_original'] . "','"
            . $_POST['musicalizacion'] . "','"
            . $_POST['voces'] . "','"
            . $_POST['actores'] . "','"
            . $_POST['animacion'] . "','"
            . $_POST['otros_colaboradores']
            . "');";

        $contexto = "INSERT INTO area_de_contexto() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['entidad_productora'] . "','"
            . $_POST['productor'] . "','"
            . $_POST['distribuidora'] . "','"
            . $_POST['historia_institucional'] . "','"
            . $_POST['resena_biografica'] . "','"
            . $_POST['forma_de_ingreso'] . "','"
            . $_POST['fecha_de_ingreso'] 
            . "');";
        
        // Los campos de Fuentes y Recursos son un arreglo con múltiples valores y se utiliza la función
        // implode() para convertir en cadena de texto y delimitando por comas (,) cada valor.
        $contenido = "INSERT INTO area_de_contenido_y_estructura() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['sinopsis'] . "','"
            . $_POST['descriptor_onomastico'] . "','"
            . $_POST['descriptor_toponimico'] . "','"
            . $_POST['descriptor_cronologico'] . "','"
            . $_POST['tipo_de_produccion'] . "','"
            . $_POST['genero'] . "','"
            . $_POST['fuentes'] . "','"
            . $_POST['recursos'] . "','"
            . $_POST['versiones'] . "','"
            . $_POST['formato_original'] . "','"
            . $_POST['material_extra'] 
            . "');";
        
        $condiciones = "INSERT INTO area_de_condiciones_de_acceso() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['condiciones_de_acceso'] . "','"
            . $_POST['existencia_y_localizacion_de_originales'] . "','"
            . $_POST['idioma_original'] . "','"
            . $_POST['doblajes_disponibles'] . "','"
            . $_POST['subtitulajes'] . "','"
            . $_POST['soporte'] . "','"
            . $_POST['numero_copias'] . "','"
            . $_POST['descripcion_fisica'] . "','"
            . $_POST['color'] . "','"
            . $_POST['audio'] . "','"
            . $_POST['sistema_de_grabacion'] . "','"
            . $_POST['region_dvd'] . "','"
            . $_POST['requisitos_tecnicos'] 
            . "');";
        
        $documentacion = "INSERT INTO area_de_documentacion_asociada() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['existencia_y_localizacion_de_copias'] . "','"
            . $_POST['unidades_de_descripcion_relacionadas'] . "','"
            . $_POST['documentos_asociados'] 
            . "');";
        
        $notas = "INSERT INTO area_de_notas() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['area_de_notas'] 
            . "');";

        $descripcion = "INSERT INTO area_de_descripcion() VALUES('"
            . $_POST['codigo_de_referencia'] . "','"
            . $_POST['notas_del_archivero'] . "','"
            . $_POST['datos_del_archivero'] . "','"
            . $_POST['reglas_o_normas'] . "','"
            . $_POST['fecha_de_descripcion'] 
            . "');";

        // Mostrar en página las consultas realizadas (para revisar sintáxis)
        /*echo '<pre>' . $identificacion . '</pre>';
        echo '<pre>' . $contexto . '</pre>';
        echo '<pre>' . $contenido . '</pre>';
        echo '<pre>' . $condiciones . '</pre>';
        echo '<pre>' . $documentacion . '</pre>';
        echo '<pre>' . $notas . '</pre>';
        echo '<pre>' . $descripcion . '</pre>';*/
        
        try{
            $conn->exec($identificacion);
            $conn->exec($contexto);
            $conn->exec($contenido);
            $conn->exec($condiciones);
            $conn->exec($documentacion);
            $conn->exec($notas);
            $conn->exec($descripcion);

            echo '<div class="alert alert-success" role="alert"><p>New record created successfully</p><p>View the record <a href="vista.php?id=' 
            . $_POST['codigo_de_referencia'] . '">here</a></p></div>';
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        $conn = null;
}

/*Funcion que agrega un nuevo archivo audivisual*/
function agregar2(){
    $datos = json_decode(file_get_contents("php://input"));
    //print_r($datos);
    //Propiedades del área de identificación
    $codigo_de_referencia = $datos->codigo_de_referencia; //ID único de cada audiovisual
    $titulo_propio = $datos->titulo_propio;
    $titulo_paralelo = $datos->titulo_paralelo;
    $titulo_atribuido = $datos->titulo_atribuido;
    $titulo_de_serie = $datos->titulo_de_serie;
    $numero_de_programa = $datos->numero_de_programa;
    $pais = $datos->pais;
    $fecha = $datos->fecha;
    $duracion = $datos->duracion;
    $investigacion = $datos->investigacion;
    $realizacion = $datos->realizacion;
    $direccion = $datos->direccion;
    $guion = $datos->guion;
    $adaptacion = $datos->adaptacion;
    $idea_original = $datos->idea_original;
    $fotografia = $datos->fotografia;
    $fotografia_fija = $datos->fotografia_fija;
    $edicion = $datos->edicion;
    $sonido_grabacion = $datos->sonido_grabacion;
    $sonido_edicion = $datos->sonido_edicion;
    $musica_original = $datos->musica_original;
    $musicalizacion = $datos->musicalizacion;
    $voces = $datos->voces;
    $actores = $datos->actores;
    $animacion = $datos->animacion;
    $otros_colaboradores = $datos->otros_colaboradores;

    //Propiedades de área de contexto
    $entidad_productora = $datos->entidad_productora;
    $productor = $datos->productor;
    $distribuidora = $datos->distribuidora;
    $historia_institucional = $datos->historia_institucional;
    $resena_biografica = $datos->resena_biografica;
    $forma_de_ingreso = $datos->forma_de_ingreso;
    $fecha_de_ingreso = $datos->fecha_de_ingreso;

    //Propiedades del área de contenido y estructura
    $sinopsis = $datos->sinopsis;
    $descriptor_onomastico = $datos->descriptor_onomastico;
    $descriptor_toponimico = $datos->descriptor_toponimico;
    $descriptor_cronologico = $datos->descriptor_cronologico;
    $tipo_de_produccion = $datos->tipo_de_produccion;
    $genero = $datos->genero;
    $fuentes = $datos->fuentes;
    $recursos = $datos->recursos;
    $versiones = $datos->versiones;
    $formato_original = $datos->formato_original;
    $material_extra = $datos->material_extra;

    //Propiedades del área de condiciones de acceso
    $condiciones_de_acceso = $datos->condiciones_de_acceso;
    $existencia_y_localizacion_de_originales = $datos->existencia_y_localizacion_de_originales;
    $idioma_original = $datos->idioma_original;
    $doblajes_disponibles = $datos->doblajes_disponibles;
    $subtitulajes = $datos->subtitulajes;
    $soporte = $datos->soporte;  // características físicas y requisitos técnicos
    $numero_copias = $datos->numero_copias;
    $descripcion_fisica = $datos->descripcion_fisica;
    $color = $datos->color;
    $audio = $datos->audio;
    $sistema_de_grabacion = $datos->sistema_de_grabacion;
    $region_dvd = $datos->region_dvd;
    $requisitos_tecnicos = $datos->requisitos_tecnicos;

    //Propiedades del área de documentación asociada
    $existencia_y_localizacion_de_copias = $datos->existencia_y_localizacion_de_copias;
    $unidades_de_descripcion_relacionadas = $datos->unidades_de_descripcion_relacionadas;
    $documentos_asociados = $datos->documentos_asociados;

    //Propiedades del área de notas
    $area_de_notas = $datos->area_de_notas;

    //Propiedades del área de descripción
    $notas_del_archivero = $datos->notas_del_archivero;
    $datos_del_archivero = $datos->datos_del_archivero;
    $reglas_o_normas = $datos->reglas_o_normas;
    $fecha_de_descripcion = $datos->fecha_de_descripcion;

    $duracion = setDuracion($duracion);
    
    if(isset($fuentes)){
        $fuentes = setFuenteRecurso($fuentes);
    }else{
        $fuentes = '';
    }
    
    if(isset($recursos)){
        $recursos = setFuenteRecurso($recursos);
    }else{
        $recursos = '';
    }

    $identificacion = "INSERT INTO area_de_identificacion() VALUES('"
            . $codigo_de_referencia . "','"
            . $titulo_propio . "','" 
            . $titulo_paralelo . "','" 
            . $titulo_atribuido . "','" 
            . $titulo_de_serie . "','"
            . $numero_de_programa . "','"
            . $pais . "','"
            . $fecha . "',"
            . $duracion . ",'"
            . $investigacion . "','"
            . $realizacion . "','"
            . $direccion . "','"
            . $guion . "','"
            . $adaptacion . "','"
            . $idea_original . "','"
            . $fotografia . "','"
            . $fotografia_fija . "','"
            . $edicion . "','"
            . $sonido_grabacion . "','"
            . $sonido_edicion . "','"
            . $musica_original . "','"
            . $musicalizacion . "','"
            . $voces . "','"
            . $actores . "','"
            . $animacion . "','"
            . $otros_colaboradores
            . "');";

        $contexto = "INSERT INTO area_de_contexto() VALUES('"
            . $codigo_de_referencia . "','"
            . $entidad_productora . "','"
            . $productor . "','"
            . $distribuidora . "','"
            . $historia_institucional . "','"
            . $resena_biografica . "','"
            . $forma_de_ingreso . "','"
            . $fecha_de_ingreso 
            . "');";
        
        // Los campos de Fuentes y Recursos son un arreglo con múltiples valores y se utiliza la función
        // implode() para convertir en cadena de texto y delimitando por comas (,) cada valor.
        $contenido = "INSERT INTO area_de_contenido_y_estructura() VALUES('"
            . $codigo_de_referencia . "','"
            . $sinopsis . "','"
            . $descriptor_onomastico . "','"
            . $descriptor_toponimico . "','"
            . $descriptor_cronologico . "','"
            . $tipo_de_produccion . "','"
            . $genero . "','"
            . $fuentes . "','"
            . $recursos . "','"
            . $versiones . "','"
            . $formato_original . "','"
            . $material_extra 
            . "');";
        
        $condiciones = "INSERT INTO area_de_condiciones_de_acceso() VALUES('"
            . $codigo_de_referencia . "','"
            . $condiciones_de_acceso . "','"
            . $existencia_y_localizacion_de_originales . "','"
            . $idioma_original . "','"
            . $doblajes_disponibles . "','"
            . $subtitulajes . "','"
            . $soporte . "','"
            . $numero_copias . "','"
            . $descripcion_fisica . "','"
            . $color . "','"
            . $audio . "','"
            . $sistema_de_grabacion . "','"
            . $region_dvd . "','"
            . $requisitos_tecnicos 
            . "');";
        
        $documentacion = "INSERT INTO area_de_documentacion_asociada() VALUES('"
            . $codigo_de_referencia . "','"
            . $existencia_y_localizacion_de_copias . "','"
            . $unidades_de_descripcion_relacionadas . "','"
            . $documentos_asociados 
            . "');";
        
        $notas = "INSERT INTO area_de_notas() VALUES('"
            . $codigo_de_referencia . "','"
            . $area_de_notas 
            . "');";

        $descripcion = "INSERT INTO area_de_descripcion() VALUES('"
            . $codigo_de_referencia . "','"
            . $notas_del_archivero . "','"
            . $datos_del_archivero . "','"
            . $reglas_o_normas . "','"
            . $fecha_de_descripcion 
            . "');";
        

        //Mostrar en página las consultas realizadas (para revisar sintáxis)
        /*echo '<pre>' . $identificacion . '</pre>';
        echo '<pre>' . $contexto . '</pre>';
        echo '<pre>' . $contenido . '</pre>';
        echo '<pre>' . $condiciones . '</pre>';
        echo '<pre>' . $documentacion . '</pre>';
        echo '<pre>' . $notas . '</pre>';
        echo '<pre>' . $descripcion . '</pre>';*/

        try{
            $qry = $conn->query($identificacion);
            print_r(json_encode($qry));
            $qry = $conn->query($contexto);
            print_r(json_encode($qry));
            $qry = $conn->query($contenido);
            print_r(json_encode($qry));
            $qry = $conn->query($condiciones);
            print_r(json_encode($qry));
            $qry = $conn->query($documentacion);
            print_r(json_encode($qry));
            $qry = $conn->query($notas);
            print_r(json_encode($qry));
            $qry = $conn->query($descripcion);
            print_r(json_encode($qry));

            echo '<div class="alert alert-success" role="alert"><p>New record created successfully</p><p>View the record <a href="vista.php?id=' 
            . $codigo_de_referencia . '">here</a></p></div>';
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        $conn = null;

}

 /*Casos para tomar la acción del controlador*/
switch ($_GET['action']) {
    case 'agregar':
        agregar();
        break;
    case 'ver':
        mostrar();
        break;
}

?>