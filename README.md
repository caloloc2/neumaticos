# neumaticos
Proyecto Raspberry Pi con Python para detectar estado de neumaticos.

Utiliza una camara conectada a la raspberry y mediante la foto obtenida
y realizando procesamiento digital de la imagen mediante python
determina el estado del neumatico y si es apto para su uso.


---- Interfaz
En la interfaz debe tener el ingreso de datos de vehiculo, 
especificar cantidad de llantas, para que genere un reporte en pdf, 
tambien que muestre la foto y la foto luego de los filtros.

Que tenga un boton para iniciar la lectura, en el raspberry que se encienda un gpio por 3 segundos, 
yo con ese 1L hago el analisis con un sensor de distancia, y te envio un resultado, 
y el otro resultado es el que se obtiene de la camara.

lo que yo mando desde el arduino solo le pones no mas, 
pero el otro calculo es el que se hace con la camara
los datos del vehiculo ponle, propietario,placa, # neumaticos (se debe hacer el analisis en cada llanta para despues hacer un reporte).
