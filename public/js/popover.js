/* Script que tiene como función principal agregar un icono que describa el tipo de contenido de cada campo en el formulario de un audiovisual.

Agrega de manera automática el siguiente texto a cada elemento input/textarea:
<a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content=""><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a>
Donde el valor de "data-content" es tomado del arreglo "dataContent".
*/

// Todas las descripciones o textos de ayuda de cada campo en el formulario.
var dataContent = {
	"titulo_propio": "Título original de distribución en el país del origen. Se incluyen, en su caso, el subtítulo que es una palabra o frase que aparece junto con y subordinada al título propio, incluyuendo la traducción al español entre paréntesis.",
	"titulo_paralelo": "Es un título propio en otra lengua (no es la traducción, sino un nuevo título creado para su versión en otra lengua). En caso de tener subtítulo también se consigna.",
	"titulo_atribuido": "Nombre dado por el documentalista cuando el material no tiene nobre propio.",
	"titulo_de_serie": "Es el nombre, en su idioma original y/o traducido, del conjunto de programas que pertenecen a un mismo proyecto de producción.",
	"numero_de_programa": "Número que ocupa el programa dentro de la serie.",
	"pais": "País o países donde se localizan las oficinas principales de la o las compañías productoras",
	"fecha": "Se consigna el año en que se terminó la producción de la obra.",
	"duracion": "Este dato indica la duración de la obra en el formato de horas, minutos y segundos, separados por dos puntos entre cada uno de ellos.",
	"investigacion": "Es el responsable de realizar la investigación científico social, su trabajo es desarrolla incluso antes de poner en marcha el proyecto audiovisual. Su labor es fundamental puesto que es quien plantea las hipótesis, realiza las búsquedas, recopila los materiales y presenta los resultados que serán integrados a la escaleta y guión de la película documental.",
	"realizacion": "Aquel que teniendo un tema lo comprende y busca expresarlo de forma audiovisual, para ello se apoya en el investigador o en su caso emprende el miso el trabajo de búsqueda y desarrollo del conocimiento. El realizador da forma y contenido al tema.",
	"direccion": "El término de director está más asociado al cine de ficción y se liga directamente a la dirección de actores. En muchas ocasiones el director no desarrolla la investigación ni el guión del documental sino que es contratado para plasmar el trabajo de otros en forma audiovisual.",
	"guion": "Eĺ guionista construye la estructura audiovisual de la investigación, se encarga de establecer por escrito el orden y la forma en que aparecerán todos aquellos elementos que harán entendible el tema.",
	"adaptacion": "Es un término poco utilizado en el cine documental y consigna a aquellas personas que teniendo una investigación en sus manos la transforman en un proyecto audiovisual; usualmente esta investigación es hecha con antelación por personas ajenas al grupo de trabajo que realizará la película. Normalmente la adaptación desemboca en un guión.",
	"idea_original": "Responsable de concebir la idea de abordar el tema en cuestión o bien a aquella persona que propone la forma, audiovisualmente hablando, en que dicho tema se presentará.",
	"fotografia": "Responsable de plasmar en imágenes la materia del documental, el fotógrafo diseña los encuadres de acuerdo con las propuestas del realizador y las necesidades del documental. En la mayoría de los casos opera la cámara.",
	"fotografia_fija": "Responsable del registro de imágenes fijas utilizadas en el documental.",
	"edicion": "Responsable de ordenar y estructurar el material audiovisual por medio de tecnología para lograr el resultado final de la obra. Estructura las secuencias del documental integrando, y en su caso, mezclando todas las fuentes de audio y video.",
	"sonido_grabacion": "El sonidista se encarga de registrar el sonido del documental ya sea de forma directa, cuando contecen las cosas, o indirecta, en estudio.",
	"sonido_edicion": "Es el encargado de crear la pista de sonido del documental. Ordena y mezcla las distintas fuentes: voces, música, incidentales, efectos y silencios.",
	"musica_original": "Encargado de componer e interpretar las piezas musicales que han sido creadas ex profeso para el documental",
	"musicalizacion": "Se encarga de selección de piezas musicales que serán incorporadas a la pista sonora del documental.",
	"voces": "Son los encargados de realizar la narración o conducción de los dichos que busca plasmar el realizador, por lo regular son voces en off. En este apartado también se incluyen a aquellos que se han encargado de realizar el doblaje de algún personaje del documental.",
	"actores": "En el cine documental los actores se encargan de realizar las recreaciones de algún hecho importante para la trama, representan personajes y situaciones que por algún motivo no pueden ser revividas por los protagonistas originales.",
	"animacion": "Es el encargado de realizar la simulación de movimiento producido a partir de la proyección continua de imágenes estáticas creadas y registradas de forma individual. La animación puede ser en dos o tres dimensiones.",
	"otros_colaboradores": "Por su especificidad los documentales pueden contar con el trabajo creativo de otro tipo de profesionales que a la postre imprimen alguna característica al documental. Algunos ejemplos de este tipos son: restaurador, efectos especiales, coreógrafo, entrenador, etc.",

	"entidad_productora": "Nombre(s) de la(s) entidad(es) productoras de la obra, tal como aparece en los créditos originales.",
	"productor": "Nombre(s) de la(s) persona(s) responsable(s) de la producción (personas físicas), tal como aparecen en los créditos de la obra.",
	"distribuidora": "Institución o empresa distribuidora del material en el país, en caso de no existir tal, se consigna la distribuidora original en el país de origen de la obra.",
	"historia_institucional": "Una breve semblanza de las instituciones productoras o el productor.",
	"resena_biografica": "Refiere una biografía sintética del realizador de la obra, priorizando su trabajo en producciones del tipo que se está consignando",
	"forma_de_ingreso": "Describe cómo llegó la unidad documental al acervo.",
	"fecha_de_ingreso": "Consigna la fecha de ingreso del material a la colección",

	"sinopsis": "Se consigna el contenido del material, refiriendo el resumen original del mismo, en idioma original y en su caso incluye una traducción al español de la versión original. Cuando no exista una sinopsis elaborada por el realizador o productor de los materiales se puede recuperar un texto que describa el material en forma adecuada. Cuando no sea posible lo anterior, ésta será elaborada por el catalogador.",
	"descriptor_onomastico": "Señala los nombres de las personas referidas en el documental así como los de aquellos que aprecen en el mismo. Se debe poner nombre y después apellidos.",
	"descriptor_toponimico": "Se incluyen los nombres de los lugares que aparecen en el documental, así como aquellos que sean referidos, siempre y cuando sean de trascendencia para el trabajo. Se debe referir el nombre completo del lugar, inclueyndo el artículo. El catalogador debe incluir municipio, estado y país, de acuerdo a las normas del INEGI.",
	"descriptor_cronologico": "En este apartado se tomarán en cuenta todas aquellas fechas o periodos de tiempo que señale o abarque el documental.",
	"tipo_de_produccion": "Se maneja un lenguaje restringido para este rubro: Película de ficción, Película documental, Programa de televisión, Trailer, Publicidad, Propaganda, Registros fílmicos, Registros en video, Extractos de otras producciones.",
	"genero": "Incluyendo subgéneros. Solo aplica para producciones concluidas.",
	"fuentes": "Es un rubro fundamental para registrar la estructura del material que se está catalogando. El objetivo principal de este apartado es consignar cómo se conformó la producción audiovisual, para tal efecto se debe señalar si se utlizaron alguna de las fuentes enlistadas.",
	"recursos": "Es un rubro fundamental para registrar la estructura del material que se está catalogando. El objetivo principal de este apartado es consignar cómo se conformó la producción audiovisual, para tal efecto se debe señalar si se utlizaron alguno de los recursos enlistados.",
	"versiones": "Da cuenta de posibles variantes realizadas simultáneamente o subsecuentemente a la producción. Se deben considerar como variantes aquellas modificaciones que alteran el contenido o la duración del material. En estos casos se debe elaborar una ficha de catalogación para cada una de las versiones.",
	"formato_original": "",
	"material_extra": "Da cuenta de la inclusión de materiales anexos a la producción como pueden ser: entrevistas, filmografías, biografías, making off, galería de fotos, otros títulos, etc. Se consigna sólo a nivel de unidad documental. El código de referencia de materiales con distintas versiones puede ser el mismo agregando al final las letras a,b,c, etc.",

	"condiciones_de_acceso": "Se refiere a la disponibilidad de utilización que se ofrece al usuario. En nuestro caso adoptamos las definiciones de: Usos no lucrativos (atender demandas de particulares como maestros, estudiantes, investigadores y público general) o Usos reservados para consulta in situ (la consulta solo se puede dar en el espacio físico en que se encuentran).",
	"existencia_y_localizacion_de_originales": "Información de contacto con la productora y/o distribuidora del material.",
	"idioma_original": "Se señala el o los idiomas originales de la producción.",
	"doblajes_disponibles": "Se consigna el o los idiomas a los que ha sido doblado el material.",
	"subtitulajes": "Se consigna el o los idiomas en los que ha sido subtitulado el material.",
	"soporte": "El soporte del material, este puede ser: Betamax, Betacam, VHS, DVCAM, MiniDV, DVD, etc.",
	"numero_copias": "",
	"descripcion_fisica": "",
	"color": "Se indicará si la producción es a color, blanco y negro o ambos.",
	"audio": "Se consigna el sistema de audio en que se encuentra la producción (Dolby, Dolby Digital, Estéreo, Monoaural, Sonido 2.1, Sonido 5.1, etc. Se indicará lo que esté consignado en la obra.",
	"sistema_de_grabacion": "Se señala el sistema de grabación y reproducción de los materiales, el cual puede ser: NTSC, PAL, SECAM, etc.",
	"region_dvd": 'Se señala, en caso de estar especificado, la región designada para la reproducción del DVD. En caso de no tener, se catalogará como "libre de región".',
	"requisitos_tecnicos": "Se señala qué equipo de reproducción se requiere para visionar el material.",

	"existencia_y_localizacion_de_copias": "Sirve para señalar la posible existencia de copias del material en algún otro acervo del Instituto Mora (biblioteca).",
	"unidades_de_descripcion_relacionadas": "Se consigna la relación que existe entre dos o más unidades de la misma colección a partir de coincidencias temáticas o conceptuales. La relación se establece con base en el conocimiento de las obras y debe ser aprobada por al menos dos integrantes del órgano de documentación.",
	"documentos_asociados": "Se hace referencia a cualquier publicación o documento (libros, artículos, transcripciones, etc.) que tenga relación directa con la producción catalogada. La relación puede ser de tipo temática, autorial, etc.",
	
	"area_de_notas": "Se debe poner toda aquella información que se considere relevante y que por alguna razón no pudo ser indexada en algún otro rubro.",
	
	"notas_del_archivero": "Fuentes usadas para complementar la información de la ficha (producción original, sitios web, publicaciones, etc.)",
	"datos_del_archivero": "Nombre de quién elaboró la ficha de la unidad.",
	"reglas_o_normas": "Aquellas normas que se utilizaron para la elaboración de la ficha. Se consignará solamente a nivel de colección.",
	"fecha_de_descripcion": "Fecha en que se ha elaborado la ficha de la unidad."
};

// Textos auxiliares para crear el icono de ayuda junto al elemento 'popover' de Bootstrap
var popoverTextInit = '<a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="';
var popoverTextLast = '"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a> ';

// jQuery para agregar el icono y el texto a todos los campos
$(document).ready(function(){
	for(var key in dataContent){
		var element = "#" + key;
		if(dataContent[key].trim()) // Si hay texto entonces agregamos el HTML
			$(element).before(popoverTextInit + dataContent[key].trim() + popoverTextLast) // Se agrega antes del input/textarea
		$(element).after('<div class="help-block with-errors"></div>'); // Agrega un div para mensajes de error de validación
	}

	// Habilita todos los popover en el documento
	$('[data-toggle="popover"]').popover()
});
