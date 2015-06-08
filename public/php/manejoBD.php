<?php
include 'filters.php';
include 'conexion.php';
	

 /*Casos para tomar la acción del controlador*/
switch ($_GET['action']) {
    case 'agregar':
        agregar();
        break;
    case 'ver':
        mostrar();
        break;
    case 'actualizar':
        actualizar();
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


/*Funcion que agrega un nuevo archivo audivisual*/
function agregar(){
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
    //$fuentes = $datos->fuentes;
    //$recursos = $datos->recursos;
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
    
    /*
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
    */

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
            $qry = $GLOBALS['conn']->exec($identificacion);          
            $qry = $GLOBALS['conn']->query($contexto);
            $qry = $GLOBALS['conn']->query($contenido);
            $qry = $GLOBALS['conn']->query($condiciones);
            $qry = $GLOBALS['conn']->query($documentacion);
            $qry = $GLOBALS['conn']->query($notas);
            $qry = $GLOBALS['conn']->query($descripcion);
            
            //echo '<div class="alert alert-success" role="alert"><p>New record created successfully</p><p>View the record <a href="vista.php?id=' 
            //. $codigo_de_referencia . '">here</a></p></div>';
            
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        $GLOBALS['conn'] = null;
}

function actualizar(){
    $datos = json_decode(file_get_contents("php://input"));
    
    $codigo_de_referencia = $datos->codigo_de_referencia;
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

    $entidad_productora = $datos->entidad_productora;
    $productor = $datos->productor;
    $distribuidora = $datos->distribuidora;
    $historia_institucional = $datos->historia_institucional;
    $resena_biografica = $datos->resena_biografica;
    $forma_de_ingreso = $datos->forma_de_ingreso;
    $fecha_de_ingreso = $datos->fecha_de_ingreso;

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

    $existencia_y_localizacion_de_copias = $datos->existencia_y_localizacion_de_copias;
    $unidades_de_descripcion_relacionadas = $datos->unidades_de_descripcion_relacionadas;
    $documentos_asociados = $datos->documentos_asociados;

    $area_de_notas = $datos->area_de_notas;

    $notas_del_archivero = $datos->notas_del_archivero;
    $datos_del_archivero = $datos->datos_del_archivero;
    $reglas_o_normas = $datos->reglas_o_normas;
    $fecha_de_descripcion = $datos->fecha_de_descripcion;

    $duracion = setDuracion($duracion);
    
    /*
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
    */

    $identificacion = "UPDATE area_de_identificacion SET "
        . "titulo_propio='" . $titulo_propio . "', " 
        . "titulo_paralelo='" . $titulo_paralelo . "', " 
        . "titulo_atribuido='" . $titulo_atribuido . "', " 
        . "titulo_de_serie='" . $titulo_de_serie . "', "
        . "numero_de_programa='" . $numero_de_programa . "', "
        . "pais='" . $pais . "', "
        . "fecha='" . $fecha . "', "
        . "duracion='" . $duracion . "', "
        . "investigacion='" . $investigacion . "', "
        . "realizacion='" . $realizacion . "', "
        . "direccion='" . $direccion . "', "
        . "guion='" . $guion . "', "
        . "adaptacion='" . $adaptacion . "', "
        . "idea_original='" . $idea_original . "', "
        . "fotografia='" . $fotografia . "', "
        . "fotografia_fija='" . $fotografia_fija . "', "
        . "edicion='" . $edicion . "', "
        . "sonido_grabacion='" . $sonido_grabacion . "', "
        . "sonido_edicion='" . $sonido_edicion . "', "
        . "musica_original='" . $musica_original . "', "
        . "musicalizacion='" . $musicalizacion . "', "
        . "voces='" . $voces . "', "
        . "actores='" . $actores . "', "
        . "animacion='" . $animacion . "', "
        . "otros_colaboradores='" . $otros_colaboradores
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
    
    $contexto = "UPDATE area_de_contexto SET "
        . "entidad_productora='" . $entidad_productora . "', "
        . "productor='" . $productor . "', "
        . "distribuidora='" . $distribuidora . "', "
        . "historia_institucional='" . $historia_institucional . "', "
        . "resena_biografica='" . $resena_biografica . "', "
        . "forma_de_ingreso='" . $forma_de_ingreso . "', "
        . "fecha_de_ingreso='" . $fecha_de_ingreso
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
    
    $contenido = "UPDATE area_de_contenido_y_estructura SET "
        . "codigo_de_referencia='" . $codigo_de_referencia . "', "
        . "sinopsis='" . $sinopsis . "', "
        . "descriptor_onomastico='" . $descriptor_onomastico . "', "
        . "descriptor_toponimico='" . $descriptor_toponimico . "', "
        . "descriptor_cronologico='" . $descriptor_cronologico . "', "
        . "tipo_de_produccion='" . $tipo_de_produccion . "', "
        . "genero='" . $genero . "', "
        . "fuentes='" . $fuentes . "', "
        . "recursos='" . $recursos . "', "
        . "versiones='" . $versiones . "', "
        . "formato_original='" . $formato_original . "', "
        . "material_extra='" . $material_extra
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
    
    $condiciones = "UPDATE area_de_condiciones_de_acceso SET "
        . "codigo_de_referencia='" . $codigo_de_referencia . "', "
        . "condiciones_de_acceso='" . $condiciones_de_acceso . "', "
        . "existencia_y_localizacion_de_originales='" . $existencia_y_localizacion_de_originales . "', "
        . "idioma_original='" . $idioma_original . "', "
        . "doblajes_disponibles='" . $doblajes_disponibles . "', "
        . "subtitulajes='" . $subtitulajes . "', "
        . "soporte='" . $soporte . "', "
        . "numero_copias='" . $numero_copias . "', "
        . "descripcion_fisica='" . $descripcion_fisica . "', "
        . "color='" . $color . "', "
        . "audio='" . $audio . "', "
        . "sistema_de_grabacion='" . $sistema_de_grabacion . "', "
        . "region_dvd='" . $region_dvd . "', "
        . "requisitos_tecnicos='" . $requisitos_tecnicos
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
    
    $documentacion = "UPDATE area_de_documentacion_asociada SET "
        . "codigo_de_referencia='" . $codigo_de_referencia . "', "
        . "existencia_y_localizacion_de_copias='" . $existencia_y_localizacion_de_copias . "', "
        . "unidades_de_descripcion_relacionadas='" . $unidades_de_descripcion_relacionadas . "', "
        . "documentos_asociados='" . $documentos_asociados
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";
    
    $notas = "UPDATE area_de_notas SET "
        . "codigo_de_referencia='" . $codigo_de_referencia . "', "
        . "area_de_notas='" . $area_de_notas
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";

    $descripcion = "UPDATE area_de_descripcion SET "
        . "codigo_de_referencia='" . $codigo_de_referencia . "', "
        . "notas_del_archivero='" . $notas_del_archivero . "', "
        . "datos_del_archivero='" . $datos_del_archivero . "', "
        . "reglas_o_normas='" . $reglas_o_normas . "', "
        . "fecha_de_descripcion='" . $fecha_de_descripcion
        . "' WHERE codigo_de_referencia='" . $codigo_de_referencia . "'";

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
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
    $GLOBALS['conn'] = null;
}

?>