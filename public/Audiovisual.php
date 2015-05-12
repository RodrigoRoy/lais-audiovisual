<?php
/* 
	Representación de un archivo audiovisual para el Laboratorio Audiovisual de Investigación Social (LAIS) del Instituto Mora
	@author Rodrigo Rivera
	@version 04.15
*/
class Audiovisual{

	// Propiedades del área de identificación
	public $codigo_de_referencia; // ID único de cada audiovisual
	public $titulo_propio;
	public $titulo_paralelo;
	public $titulo_atribuido;
	public $titulo_de_serie;
	public $numero_de_programa;
	public $pais;
	public $fecha;
	public $duracion;
	public $investigacion;
	public $realizacion;
	public $direccion;
	public $guion;
	public $adaptacion;
	public $idea_original;
	public $fotografia;
	public $fotografia_fija;
	public $edicion;
	public $sonido_grabacion;
	public $sonido_edicion;
	public $musica_original;
	public $musicalizacion;
	public $voces;
	public $actores;
	public $animacion;
	public $otros_colaboradores;

	// Propiedades del área de contexto
	public $entidad_productora;
	public $productor;
	public $distribuidora;
	public $historia_institucional;
	public $resena_biografica;
	public $forma_de_ingreso;
	public $fecha_de_ingreso;

	// Propiedades del área de contenido y estructura
	public $sinopsis;
	public $descriptor_onomastico;
	public $descriptor_toponimico;
	public $descriptor_cronologico;
	public $tipo_de_produccion;
	public $genero;
	public $fuentes;
	public $recursos;
	public $versiones;
	public $formato_original;
	public $material_extra;

	// Propiedades del área de condiciones de acceso
	public $condiciones_de_acceso;
	public $existencia_y_localizacion_de_originales;
	public $idioma_original;
	public $doblajes_disponibles;
	public $subtitulajes;
	public $soporte;  // características físicas y requisitos técnicos
	public $numero_copias;
	public $descripcion_fisica;
	public $color;
	public $audio;
	public $sistema_de_grabacion;
	public $region_dvd;
	public $requisitos_tecnicos;

	// Propiedades del área de documentacion asociada
	public $existencia_y_localizacion_de_copias;
	public $unidades_de_descripcion_relacionadas;
	public $documentos_asociados;

	// Propiedades del área de notas
	public $area_de_notas;

	// Propiedades del área de descripción
	public $notas_del_archivero;
	public $datos_del_archivero;
	public $reglas_o_normas;
	public $fecha_de_descripcion;

	// Nota: 65 propiedades en total.

	/* 
		Constructor que recibe un arreglo asociativo (preferentemente desde una base de datos) 
		Los valores key del arreglo coinciden con el nombre de los atributos de la clase. 
	*/
	function __construct($data){
		$this->codigo_de_referencia = (!empty($data['codigo_de_referencia'])) ? $data['codigo_de_referencia'] : null;
		$this->titulo_propio = (!empty($data['titulo_propio'])) ? $data['titulo_propio'] : null;
		$this->titulo_paralelo = (!empty($data['titulo_paralelo'])) ? $data['titulo_paralelo'] : null;
		$this->titulo_atribuido = (!empty($data['titulo_atribuido'])) ? $data['titulo_atribuido'] : null;
		$this->titulo_de_serie = (!empty($data['titulo_de_serie'])) ? $data['titulo_de_serie'] : null;
		$this->numero_de_programa = (!empty($data['numero_de_programa'])) ? $data['numero_de_programa'] : null;
		$this->pais = (!empty($data['pais'])) ? $data['pais'] : null;
		$this->fecha = (!empty($data['fecha'])) ? $data['fecha'] : null;
		$this->duracion = (!empty($data['duracion'])) ? $data['duracion'] : null;
		$this->investigacion = (!empty($data['investigacion'])) ? $data['investigacion'] : null;
		$this->realizacion = (!empty($data['realizacion'])) ? $data['realizacion'] : null;
		$this->direccion = (!empty($data['direccion'])) ? $data['direccion'] : null;
		$this->guion = (!empty($data['guion'])) ? $data['guion'] : null;
		$this->adaptacion = (!empty($data['adaptacion'])) ? $data['adaptacion'] : null;
		$this->idea_original = (!empty($data['idea_original'])) ? $data['idea_original'] : null;
		$this->fotografia = (!empty($data['fotografia'])) ? $data['fotografia'] : null;
		$this->fotografia_fija = (!empty($data['fotografia_fija'])) ? $data['fotografia_fija'] : null;
		$this->edicion = (!empty($data['edicion'])) ? $data['edicion'] : null;
		$this->sonido_grabacion = (!empty($data['sonido_grabacion'])) ? $data['sonido_grabacion'] : null;
		$this->sonido_edicion = (!empty($data['sonido_edicion'])) ? $data['sonido_edicion'] : null;
		$this->musica_original = (!empty($data['musica_original'])) ? $data['musica_original'] : null;
		$this->musicalizacion = (!empty($data['musicalizacion'])) ? $data['musicalizacion'] : null;
		$this->voces = (!empty($data['voces'])) ? $data['voces'] : null;
		$this->actores = (!empty($data['actores'])) ? $data['actores'] : null;
		$this->animacion = (!empty($data['animacion'])) ? $data['animacion'] : null;
		$this->otros_colaboradores = (!empty($data['otros_colaboradores'])) ? $data['otros_colaboradores'] : null;

		$this->entidad_productora = (!empty($data['entidad_productora'])) ? $data['entidad_productora'] : null;
		$this->productor = (!empty($data['productor'])) ? $data['productor'] : null;
		$this->distribuidora = (!empty($data['distribuidora'])) ? $data['distribuidora'] : null;
		$this->historia_institucional = (!empty($data['historia_institucional'])) ? $data['historia_institucional'] : null;
		$this->resena_biografica = (!empty($data['resena_biografica'])) ? $data['resena_biografica'] : null;
		$this->forma_de_ingreso = (!empty($data['forma_de_ingreso'])) ? $data['forma_de_ingreso'] : null;
		$this->fecha_de_ingreso = (!empty($data['fecha_de_ingreso'])) ? $data['fecha_de_ingreso'] : null;
		
		$this->sinopsis = (!empty($data['sinopsis'])) ? $data['sinopsis'] : null;
		$this->descriptor_onomastico = (!empty($data['descriptor_onomastico'])) ? $data['descriptor_onomastico'] : null;
		$this->descriptor_toponimico = (!empty($data['descriptor_toponimico'])) ? $data['descriptor_toponimico'] : null;
		$this->descriptor_cronologico = (!empty($data['descriptor_cronologico'])) ? $data['descriptor_cronologico'] : null;
		$this->tipo_de_produccion = (!empty($data['tipo_de_produccion'])) ? $data['tipo_de_produccion'] : null;
		$this->genero = (!empty($data['genero'])) ? $data['genero'] : null;
		$this->fuentes = (!empty($data['fuentes'])) ? $data['fuentes'] : null;
		$this->recursos = (!empty($data['recursos'])) ? $data['recursos'] : null;
		$this->versiones = (!empty($data['versiones'])) ? $data['versiones'] : null;
		$this->formato_original = (!empty($data['formato_original'])) ? $data['formato_original'] : null;
		$this->material_extra = (!empty($data['material_extra'])) ? $data['material_extra'] : null;
		
		$this->condiciones_de_acceso = (!empty($data['condiciones_de_acceso'])) ? $data['condiciones_de_acceso'] : null;
		$this->existencia_y_localizacion_de_originales = (!empty($data['existencia_y_localizacion_de_originales'])) ? $data['existencia_y_localizacion_de_originales'] : null;
		$this->idioma_original = (!empty($data['idioma_original'])) ? $data['idioma_original'] : null;
		$this->doblajes_disponibles = (!empty($data['doblajes_disponibles'])) ? $data['doblajes_disponibles'] : null;
		$this->subtitulajes = (!empty($data['subtitulajes'])) ? $data['subtitulajes'] : null;
		$this->soporte = (!empty($data['soporte'])) ? $data['soporte'] : null;
		$this->numero_copias = (!empty($data['numero_copias'])) ? $data['numero_copias'] : null;
		$this->descripcion_fisica = (!empty($data['descripcion_fisica'])) ? $data['descripcion_fisica'] : null;
		$this->color = (!empty($data['color'])) ? $data['color'] : null;
		$this->audio = (!empty($data['audio'])) ? $data['audio'] : null;
		$this->sistema_de_grabacion = (!empty($data['sistema_de_grabacion'])) ? $data['sistema_de_grabacion'] : null;
		$this->region_dvd = (!empty($data['region_dvd'])) ? $data['region_dvd'] : null;
		$this->requisitos_tecnicos = (!empty($data['requisitos_tecnicos'])) ? $data['requisitos_tecnicos'] : null;
		
		$this->existencia_y_localizacion_de_copias = (!empty($data['existencia_y_localizacion_de_copias'])) ? $data['existencia_y_localizacion_de_copias'] : null;
		$this->unidades_de_descripcion_relacionadas = (!empty($data['unidades_de_descripcion_relacionadas'])) ? $data['unidades_de_descripcion_relacionadas'] : null;
		$this->documentos_asociados = (!empty($data['documentos_asociados'])) ? $data['documentos_asociados'] : null;
		
		$this->area_de_notas = (!empty($data['area_de_notas'])) ? $data['area_de_notas'] : null;
		
		$this->notas_del_archivero = (!empty($data['notas_del_archivero'])) ? $data['notas_del_archivero'] : null;
		$this->datos_del_archivero = (!empty($data['datos_del_archivero'])) ? $data['datos_del_archivero'] : null;
		$this->reglas_o_normas = (!empty($data['reglas_o_normas'])) ? $data['reglas_o_normas'] : null;
		$this->fecha_de_descripcion = (!empty($data['fecha_de_descripcion'])) ? $data['fecha_de_descripcion'] : null;
	}

	/* 
		Representación en forma de cadena para ser visualizada en una página web.
		Formato: "Propiedad: Valor"
	*/
	public function __toString(){
		$str = '';
		foreach ($this as $key => $value) {
			if(!is_null($value)){
				$str .= '<strong>' . $key . '</strong>: ' . $value . '</br>';
			}
		}
		return $str;
	}
}