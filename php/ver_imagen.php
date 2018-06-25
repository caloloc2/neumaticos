<?php

	require 'meta.php';

	$id = $_GET['id'];
	$foto = $_GET['foto'];

	$consulta = Meta::Consulta("SELECT ".$foto." FROM valores WHERE id_valor='".$id."'");

	//print_r($consulta);

	header("Content-Type: image/jpeg"); 
	echo $consulta[0][$foto];