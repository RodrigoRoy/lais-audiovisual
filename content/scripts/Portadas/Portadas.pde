/* 
  Crea portadas de títulos de documentales como imagenes jpg
  El código de referencia y título propio son leidos desde un archivos,
  dicho archivo es generado desde una consulta directa a la base de datos:
  $ mysql -u root -p -e "select codigo_de_referencia, titulo_propio from area_de_identificacion;" --skip-column-names Audiovisuales > /tmp/coleccion.txt
*/

// Setup e inicializaciones
size(176, 250);
PFont pfont = createFont("Liberation Serif Bold", 20, true);
textFont(pfont);
textAlign(CENTER, CENTER);
rectMode(CENTER);
fill(212, 223, 232);

String lines[] = loadStrings("/tmp/coleccion.txt");
for(int i = 0; i < lines.length; i++){
  String[] documental = split(lines[i], "\t");
  background(19, 18, 28);
  text(documental[1], width/2, height/2, width-10, height-10);
  save("/tmp/Portadas2/" + documental[0] + ".jpg");
}