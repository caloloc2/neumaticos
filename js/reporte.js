$(document).ready(function(){
	Valores(id_cliente);
	$('#reporte').show();
})

$('#buscar').submit(function(){
	Listar_Reportes();
	return false;
})

function Listar_Reportes(){
	$.ajax({
		url: 'php/buscar_reporte.php',
		dataType: 'json',
		async: false,
		type: "POST",
		data:{
			fecha: document.getElementById('fecha').value
		},
		success: function(datos) {
			console.log(datos);
			if (datos['estado']){
				if (datos['clientes'].length>0){
					var registro = "";
					datos['clientes'].forEach(function(item, el){						
						registro += '<tr>';
						registro += '<td>'+item['fecha']+'</td>';
						registro += '<td>'+item['nombres']+'</td>';
						registro += '<td>'+item['placa']+'</td>';
						registro += '<td align="center">'+item['llantas']+'</td>';
						registro += '<td><a href="reporte.php?id='+item['id_cliente']+'">Imprimir</a></td>';
						registro += '<td><a href="#" onclick="Borrar('+item['id_cliente']+'); return false;">Eliminar</a></td>';
						registro += '</tr>';
					})

					$('#listado').html(registro);
				}
			}
			
		},
		error:function(e){
			console.log(e.responseText);
		}
	});
}

function Valores(id_cliente){
	$.ajax({
		url: 'php/buscar_valores.php',
		dataType: 'json',
		async: false,
		type: "POST",
		data:{
			id_cliente: id_cliente
		},
		success: function(datos) {
			console.log(datos);	
			Reporte(datos);
		},
		error:function(e){
			console.log(e.responseText);
		}
	});
}

function Reporte(datos){
	var propietario = datos['cliente']['nombres'];
	var placa = datos['cliente']['placa'];
	var num_llantas = datos['cliente']['llantas'];
	var fecha = datos['cliente']['fecha'];

	$('#reporte .cabeza .title .propietario').html('Nombre del Propietario: '+propietario);
	$('#reporte .cabeza .title .placa').html('Placa: '+placa);
	$('#reporte .cabeza .title .num_llantas').html('N&uacute;mero de llantas: '+num_llantas);
	$('#reporte .cabeza .title .fecha').html('Fecha: '+fecha);
	
	if (datos['valores'].length>0){
		for (x=0; x<datos['valores'].length; x++){

			var item = '';
			item += '<li class="item">';
			item += '<h2>Llanta # '+datos['valores'][x]['num_llanta']+'</h2>';

			item += '<div class="imagenes">';
			item += '<figure><img src="php/ver_imagen.php?id='+datos['valores'][x]['id_valor']+'&foto=foto_normal" alt="" /></figure>';
			item += '<figure><img src="php/ver_imagen.php?id='+datos['valores'][x]['id_valor']+'&foto=foto_gris" alt=""></figure>';
			item += '<figure><img src="php/ver_imagen.php?id='+datos['valores'][x]['id_valor']+'&foto=foto_procesada" alt=""></figure>';
			item += '</div>';

			item += '<div class="informacion">';
			item += '<p>Medida Obtenida: '+datos['valores'][x]['sensor']+' mm</p>';
			item += '<p>Valor de An&aacute;lisis: '+datos['valores'][x]['camara']+'</p>';
			if ((datos['valores'][x]['sensor']>=1)&&(datos['valores'][x]['sensor']<=2.99)){
				item += '<p class="resultado">Neum&aacute;tico en mal estado.</p>';			
			}else if ((datos['valores'][x]['sensor']>=3)&&(datos['valores'][x]['sensor']<=5.99)) {
				item += '<p class="resultado">Neum&aacute;tico en estado medio.</p>';
			}else if (datos['valores'][x]['sensor']>=6) {
				item += '<p class="resultado">Neum&aacute;tico en buen estado.</p>';
			}else{
				item += '<p class="resultado">Valor no medible.</p>';
			}
			item += '</div>';
			item += '</li>';

			$('#llantas').append(item);
		};	
	}
	
}

$('#imprimir').click(function(){
	$('#imprimir').hide();
	$('#regresar').hide();
	window.print();
	$('#imprimir').show();
	$('#regresar').show();
})

function Borrar(id){
	$.ajax({
		url: 'php/eliminar_reportes.php',
		dataType: 'json',
		async: false,
		type: "POST",
		data:{
			id_cliente: id
		},
		success: function(datos) {
			console.log(datos);
			if (datos['estado']){
				Listar_Reportes();
			}else{
				alert("Hubo un error al eliminar el reporte.");
			}
		},
		error:function(e){
			console.log(e.responseText);
		}
	});
}