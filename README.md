# metaDOC - Sistema de Catalogación de Documentales

## Introducción
El resguardo y documentación de materiales audiovisuales constituye una tarea prioritaria entre quienes recurrimos a ellos cotidianamente con fines de investigación. El **[Laboratorio Audiovisual de Investigación Social (LAIS)](http://www.mora.edu.mx/Investigacion/SitePages/LAIS.aspx)** del **[Instituto de Investigación Dr. José María Luis Mora](http://www.mora.edu.mx/)** se propuso abocarse a esta labor para construir un acervo debidamente documentado, ponerlo en acceso para consulta y potenciar así la investigación con este tipo de materiales.

## Objetivo

Este proyecto desea crear una base de datos para el manejo actual y futuro de las **fichas de documentación** de los materiales audiovisuales del LAIS junto con una interfaz de usuario que permita manipular fácilmente la base de datos.

## Arquitectura del sistema

El sistema consiste en una **aplicación web** que emplea las siguientes tecnologías:

- Servidor
  - Linux (Debian)
  - Apache
  - MySQL
  - PHP
  - Python
- Cliente
  - HTML
  - Javascript
  - CSS
  - AngularJS
  - Twitter Bootstrap

![](https://raw.githubusercontent.com/RodrigoRoy/lais-audiovisual/master/content/doc/Diagramas/EsquemaGeneral.png)

## Version inicial

Principales características del sistema:
- Presentación por décadas de la ficha de catalogación de los documentales de la colección del LAIS.
- Mostrar la ficha de catalogación a nivel de unidad simple de cada documental en una ventana temporal emergente para rápida navegación.
- Búsqueda contextual de contenido con opción de filtrar los resultados por área de catalogación y opción de ordenamiento por año o título.
- Sistema de usuarios y niveles de permiso para controlar la creación, edición y borrado de las fichas de catalogación de documentales.
- Énfasis en mostrar portadas de los documentales.
- Diseño responsivo (diseño adaptable para computadoras de escritorio y dispositivos móviles).

![](https://raw.githubusercontent.com/RodrigoRoy/lais-audiovisual/master/content/doc/Diagramas/Sistema01_small.jpg)

## Futuro desarrollo

- Aumentar la base de datos con la información de más fichas de catalogación de la colección del LAIS.
- Formulario de contacto para sugerencias de usuarios.
- Incorporar estadísticas de uso e información sobre el contenido de la base de datos.

## Sitio

metaDOC está disponible (temporalmente) en la siguiente dirección de internet:

[lais-interno.mora.edu.mx/metaDOC/public/](http://lais-interno.mora.edu.mx/metaDOC/public/#/)

## Licencia

[MIT](./LICENSE.md)