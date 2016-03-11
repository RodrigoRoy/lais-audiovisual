#!/bin/bash

mysql -u root -p -e "select codigo_de_referencia, titulo_propio from area_de_identificacion;" --skip-column-names Audiovisuales > /tmp/coleccion.txt

cd ~/processing-3.0.2
./processing-java --sketch=${HOME}/sketchbook/Portadas/ --run