<?php

$respuesta['estado'] = false;

try{
	require 'meta.php';

	$fecha = $_POST['fecha'];

	$consulta = Meta::Consulta("SELECT * FROM clientes WHERE fecha='".$fecha."'");

	if (count($consulta)>0){
		$respuesta['clientes'] = $consulta;
		$respuesta['estado'] = true;
	}
}catch(Exception $e){
	$respuesta['estado'] = $e->getMessage();
}

echo json_encode($respuesta);