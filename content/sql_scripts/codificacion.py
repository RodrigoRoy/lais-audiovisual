import csv
import re

#codificacionDuracion("Fichas década5 (1930) Identificacion.csv")
def codificacionDuracion(archivo):
	with open(archivo) as f:
		fieldnames = ('Código de referencia','Propio','Paralelo','Atribuido','Titulo de serie','Número programa','País','Fecha','Duración','Investigación','Realización','Dirección','Guión','Adaptación','Idea original','Fotografía','Fotografía fija','Edición','Grabación','Edición','Original','Musicalización','Voces','Actores','Animación','Otros colaboradores')
		r = csv.DictReader(f, fieldnames)
		#next(f, None) # skip header
		rows = []
		for row in r:
			if re.search("(^\d{0,3}' ?[0-5]?\d''$)|(^\d{0,3}'$)|(^[0-5]?\d''$)",row['Duración']):
				row['Duración'] = setDuracion(row['Duración'])
			rows.append(row)
		w = csv.DictWriter(open(archivo,"w"), fieldnames)
		w.writerows(rows)

def setDuracion(duracion):
       ''' Cambia el formato MM'SS'' por HH:MM:SS '''
       # Verificar el caso cuando solo son segundos (15'')
       matches = re.match(r"^([0-5]?\d) ?''$", duracion.strip())
       if matches:
               return matches.group(1)
       # Verificar el caso para solo minutos (80')
       matches = re.match(r"^(\d{1,3}) ?'$", duracion.strip())
       if matches:
               minutos = int(matches.group(1)) # Obtener el dígito de los minutos
               if minutos >= 60:
                       return str(int(minutos/60)) + ':' + str(minutos%60)
               else:
                       return str(minutos) + '00' # Se agrega 00 por formato de MySQL
       # Verificar el caso incluye minutos y segundos (80'15'') (es análogo al caso anterior)
       matches = re.match(r"^(\d{1,3}) ?' ?([0-5]?\d) ?''$", duracion.strip())
       if matches:
               minutos = int(matches.group(1)) # matches.group(1) incluye los minutos y matches.group(2) los segundos
               if minutos >= 60:
                       return str(int(minutos/60)) + ':' + str(minutos%60) + ':' + matches.group(2)
               else:
                       return str(minutos) + matches.group(2)
       # En caso de ser un texto con sintaxis inválida
       return str(0);

def codificacionDescripcion(archivo):
	with open(archivo) as f:
		fieldnames = ('Código de referencia','Titulo propio','Notas del archivero','Datos del archivero','Reglas o normase','Fecha de descripción')
		r = csv.DictReader(f, fieldnames)
		#next(f, None) # skip header
		rows = []
		for row in r:
			if re.search("^(\d{1,2})\/(\d{1,2})\/(\d{4})$",row['Fecha de descripción'].strip()):
				row['Fecha de descripción'] = setFechaDescripcion(row['Fecha de descripción'])
			rows.append(row)
		w = csv.DictWriter(open(archivo,"w"), fieldnames)
		w.writerows(rows)

def setFechaDescripcion(descripcion):
       ''' Cambia el formato MM'SS'' por HH:MM:SS '''
       # Verificar el caso cuando solo son segundos (15'')
       matches = re.match(r"^(\d{1,2})\/(\d{1,2})\/(\d{4})$", descripcion.strip())
       if matches:
               return matches.group(3) + "-" + matches.group(2) + "-" + matches.group(1) 


''' Ejemplos de uso
codificacionDuracion("Fichas década4 (1920) Identificacion.csv")
setDuracion("15''")
setDuracion("80'")
setDuracion("80'15''")
setDuracion("180'59''")
'''

decadas = {4:"1920", 5:"1930", 6:"1940"}

for llave in decadas.keys():
	print(llave)
	codificacionDuracion("../csv/Fichas década" + str(llave) + " (" + decadas[llave] + ") Identificacion.csv")
	codificacionDescripcion("../csv/Fichas década" + str(llave) + " (" + decadas[llave] + ") Descripcion.csv")

'''
codificacionDuracion("Fichas década4 (1920) Identificacion.csv")
codificacionDuracion("Fichas década5 (1930) Identificacion.csv")
codificacionDescripcion("Fichas década4 (1920) Descripcion.csv")
codificacionDescripcion("Fichas década5 (1930) Descripcion.csv")
'''
