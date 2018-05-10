<?php 

$respuesta['estado'] = false;

try{
	// guarda un 1 en el archivo inicia_camara para iniciar proceso de lectura de sensor y camara en la raspberry
	$fp = fopen("inicia_camara.txt", "w");
	fwrite($fp, "1");	
	fclose($fp);

	sleep(3.5); // espera durante 4 segundos hasta que lea el sensor, tome la imagen y la analice

	// lee dato del sensor
	$fp = fopen("archivo.txt", "r");
	$respuesta['sensor'] = fgets($fp);
	fclose($fp);

	// lee dato del procesamiento de la imagen
	$fp = fopen("imagen.txt", "r");
	$respuesta['imagen'] = fgets($fp);
	fclose($fp);	

	// guarda un 0 en el archivo para detener la lectura en la raspberry
	$fp = fopen("inicia_camara.txt", "w");
	fwrite($fp, "0");	
	fclose($fp);

	sleep(2);

	$respuesta['estado'] = true;
}catch(Exception $e){
	$respuesta['error'] = $e->getMessage();
}

echo json_encode($respuesta);