<?php

$respuesta['estado'] = false;

try{
	require 'meta.php';

	$id_cliente = $_POST['id_cliente'];

	$cliente = Meta::Consulta_Unico("SELECT * FROM clientes WHERE id_cliente=".$id_cliente);

	if ($cliente['id_cliente']!=''){
		$respuesta['cliente']['nombres'] = $cliente['nombres'];
		$respuesta['cliente']['placa'] = $cliente['placa'];
		$respuesta['cliente']['llantas'] = $cliente['llantas'];
		$respuesta['cliente']['fecha'] = $cliente['fecha'];
	}

	$consulta = Meta::Consulta("SELECT id_valor, id_cliente, num_llanta, sensor, camara FROM valores WHERE id_cliente='".$id_cliente."'");

	if (count($consulta)>0){
		$respuesta['valores'] = $consulta;

		$respuesta['estado'] = true;
	}
}catch(Exception $e){
	$respuesta['estado'] = $e->getMessage();
}

echo json_encode($respuesta);