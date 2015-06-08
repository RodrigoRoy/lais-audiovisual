<?php
require_once 'filters.php';
require_once 'conexion.php';

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
    $datos->duracion = setDuracion($datos->duracion);
    /*
    if(isset($datos->fuentes)){
        $datos->fuentes = setFuenteRecurso($datos->fuentes);
    }else{
        $datos->fuentes = '';
    }
    
    if(isset($datos->recursos)){
        $datos->recursos = setFuenteRecurso($datos->recursos);
    }else{
        $datos->recursos = '';
    }
    */

    $identificacion = "INSERT INTO area_de_identificacion() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->titulo_propio . "','" 
            . $datos->titulo_paralelo . "','" 
            . $datos->titulo_atribuido . "','" 
            . $datos->titulo_de_serie . "','"
            . $datos->numero_de_programa . "','"
            . $datos->pais . "','"
            . $datos->fecha . "',"
            . $datos->duracion . ",'"
            . $datos->investigacion . "','"
            . $datos->realizacion . "','"
            . $datos->direccion . "','"
            . $datos->guion . "','"
            . $datos->adaptacion . "','"
            . $datos->idea_original . "','"
            . $datos->fotografia . "','"
            . $datos->fotografia_fija . "','"
            . $datos->edicion . "','"
            . $datos->sonido_grabacion . "','"
            . $datos->sonido_edicion . "','"
            . $datos->musica_original . "','"
            . $datos->musicalizacion . "','"
            . $datos->voces . "','"
            . $datos->actores . "','"
            . $datos->animacion . "','"
            . $datos->otros_colaboradores
            . "');";

        
        $contexto = "INSERT INTO area_de_contexto() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->entidad_productora . "','"
            . $datos->productor . "','"
            . $datos->distribuidora . "','"
            . $datos->historia_institucional . "','"
            . $datos->resena_biografica . "','"
            . $datos->forma_de_ingreso . "','"
            . $datos->fecha_de_ingreso 
            . "');";
        
        // Los campos de Fuentes y Recursos son un arreglo con múltiples valores y se utiliza la función
        // implode() para convertir en cadena de texto y delimitando por comas (,) cada valor.
        $contenido = "INSERT INTO area_de_contenido_y_estructura() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->sinopsis . "','"
            . $datos->descriptor_onomastico . "','"
            . $datos->descriptor_toponimico . "','"
            . $datos->descriptor_cronologico . "','"
            . $datos->tipo_de_produccion . "','"
            . $datos->genero . "','"
            . $datos->fuentes . "','"
            . $datos->recursos . "','"
            . $datos->versiones . "','"
            . $datos->formato_original . "','"
            . $datos->material_extra 
            . "');";
        
        $condiciones = "INSERT INTO area_de_condiciones_de_acceso() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->condiciones_de_acceso . "','"
            . $datos->existencia_y_localizacion_de_originales . "','"
            . $datos->idioma_original . "','"
            . $datos->doblajes_disponibles . "','"
            . $datos->subtitulajes . "','"
            . $datos->soporte . "','"
            . $datos->numero_copias . "','"
            . $datos->descripcion_fisica . "','"
            . $datos->color . "','"
            . $datos->audio . "','"
            . $datos->sistema_de_grabacion . "','"
            . $datos->region_dvd . "','"
            . $datos->requisitos_tecnicos 
            . "');";
        
        $documentacion = "INSERT INTO area_de_documentacion_asociada() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->existencia_y_localizacion_de_copias . "','"
            . $datos->unidades_de_descripcion_relacionadas . "','"
            . $datos->documentos_asociados 
            . "');";
        
        $notas = "INSERT INTO area_de_notas() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->area_de_notas 
            . "');";

        $descripcion = "INSERT INTO area_de_descripcion() VALUES('"
            . $datos->codigo_de_referencia . "','"
            . $datos->notas_del_archivero . "','"
            . $datos->datos_del_archivero . "','"
            . $datos->reglas_o_normas . "','"
            . $datos->fecha_de_descripcion 
            . "');";

        try{
            $GLOBALS['conn']->exec($identificacion);
            $GLOBALS['conn']->exec($contexto);
            $GLOBALS['conn']->exec($contenido);
            $GLOBALS['conn']->exec($condiciones);
            $GLOBALS['conn']->exec($documentacion);
            $GLOBALS['conn']->exec($notas);
            $GLOBALS['conn']->exec($descripcion);
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
    $datos->duracion = setDuracion($datos->duracion);
    /*
    if(isset($datos->fuentes)){
        $datos->fuentes = setFuenteRecurso($datos->fuentes);
    }else{
        $datos->fuentes = '';
    }
    
    if(isset($datos->recursos)){
        $datos->recursos = setFuenteRecurso($datos->recursos);
    }else{
        $datos->recursos = '';
    }
    */

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