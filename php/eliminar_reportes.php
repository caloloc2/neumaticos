<?php 

$respuesta['estado'] = false;

try{
	require 'meta.php';

	$id_cliente = $_POST['id_cliente'];

	$eliminar = Meta::Ejecutar_Sentencia("DELETE FROM clientes WHERE id_cliente=".$id_cliente);
	$eliminar = Meta::Ejecutar_Sentencia("DELETE FROM valores WHERE id_cliente=".$id_cliente);

	$respuesta['estado'] = true;
}catch(Exception $e){
	$respuesta['error'] = $e->getMessage();
}

echo json_encode($respuesta);