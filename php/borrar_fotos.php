<?php 

$respuesta['estado'] = false;

try{	
	$files = glob('../llantas/*'); // Devuelve un vector con todos los archivos y directorios	

	foreach($files as $file){
	    if(is_file($file))
	    unlink($file); //elimino el fichero
	}

	$fp = fopen("inicia_camara.txt", "w");
	fwrite($fp, "0");	
	fclose($fp);

	/*$fp = fopen("archivo.txt", "w");
	fwrite($fp, "0");	
	fclose($fp);

	$fp = fopen("imagen.txt", "w");
	fwrite($fp, "0");	
	fclose($fp);*/

	$respuesta['estado'] = true;
}catch(Exception $e){
	$respuesta['error'] = $e->getMessage();
}

echo json_encode($respuesta);