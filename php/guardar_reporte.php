<?php

$respuesta['estado'] = false;

try{
	include 'meta.php';

	$nombres = $_POST['nombres'];
	$placa = $_POST['placa'];
	$llantas = $_POST['llantas'];
	$valores = $_POST['valores'];
	$fecha = date('Y-m-d');

	$reporte = Meta::Nuevo_Reporte($nombres, $placa, $llantas, $fecha);
	$id = Meta::Consulta_Unico("SELECT id_cliente FROM clientes ORDER BY id_cliente DESC LIMIT 1");

	if ($id['id_cliente']!=''){
		
		$id_cliente = $id['id_cliente'];
		$foto = '../llantas/foto_'.$linea['num_llanta'];
		$gris = '../llantas/gris_'.$linea['num_llanta'];
		$proc = '../llantas/proc_'.$linea['num_llanta'];
		
		foreach ($valores as $linea) {
			$nuevo_valor = Meta::Nuevo_Valor($id_cliente, $linea['num_llanta'], $linea['sensor'], $linea['valor_imagen'], $foto, $gris, $proc);
		}
		
	}else{
		$respuesta['error'] = "Error al guardar el reporte.";
	}

}catch(Exception $e){
	$respuesta['error'] = $e->getMessage();
}

echo json_encode($respuesta);