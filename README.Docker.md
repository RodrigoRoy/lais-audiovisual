# Metadoc como contenedor

Se usa Docker como una manera estandarizada de recrear el ambiente de programación y/o producción del sistema Metadoc. Se utiliza Docker Compose para orquestar todas las dependencias del backend: Apache (webserver), MySQL (database) y PHP (con la extensión PDO). El resto de dependencias del frontend son cargadas directamente como scripts (como AngularJS, jQuery, Bootstrap, etc.).

## Requisitos

- Crear archivo `.env` usando como referencia `.env.example`
- Copiar y pegar las portadas de los documentales en `/public/imgs/Portadas`
- Copiar y pegar las portadas auxiliares de los documentales en `/public/imgs/Portadas2`

## Ejecutar en modo de desarrollo

Con las variables de entorno definidas (`.env`) y las portadas agregadas, ejecutar el comando:
`docker compose watch`

Metadoc estará disponible en http://localhost:9000.

## Compilar para producción

Con las variables de entorno definidas (`.env`) y las portadas agregadas, ejecutar el comando:
`docker compose up --build`.

Metadoc estará disponible en http://localhost:9000.

## Acerca de la base de datos

### Restaurar respaldo

Si es la primera vez que se compila el contenedor, la base de datos requiere de un respaldo:

```
$ docker exec -i metadoc-db mysql -u <usuario> -p<password> <base_de_datos> < /ruta/del/respaldo.sql
```
