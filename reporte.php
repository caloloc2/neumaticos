<?php
if (isset($_GET['id'])){
	$id = $_GET['id'];
?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Neumaticos</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	</head>
	<body>
		
		<div id="reporte">
			<div class="cabeza">
				<figure><img src="img/logo-utn.png" alt=""></figure>
				<div class="title">
					<h1>Reporte de An&aacute;lisis</h1>

					<p class="propietario">Nombre del Propietario: ---</p>
					<p class="placa">Placa: ---</p>
					<p class="num_llantas">N&uacute;mero de Llantas: ---</p>
					<p class="fecha">Fecha: ---</p>
				</div>
			</div>
			
			<ul class="cuerpo" id="llantas">
			
			</ul>

			<input type="button" value="Imprimir Reporte" id="imprimir">
			<a href="reportes.html"><input type="button" value="Regresar a Reportes" id="regresar"></a>
		</div>
		
		<script>
			var id_cliente = '<?= $id; ?>';
		</script>
		<script src="js/jquery.min.js"></script>
		<script src="js/reporte.js"></script>
	</body>
	</html>
<?php 

}

?>