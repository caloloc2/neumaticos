var propietario = '';
var placa = '';
var num_llantas = 0;
var llanta_actual = 1;

var reporte = [];

$('#formulario').submit(function(){
	propietario = document.getElementById('propietario').value;
	placa = document.getElementById('placa').value;
	num_llantas = document.getElementById('num_llantas').value;

	if ((num_llantas>0)&&(num_llantas<=8)){
		$('#formulario').fadeOut(150);
		Pasos(llanta_actual, 0);
	}else{
		alert('El n&uacute;mero de llantas debe ser mayor a cero y menor a 8.');
	}
	return false;
})

function Pasos(num, tipo){
	if (tipo==0){
		//configura el cuadro poniendo nombre del numero de llanta al que se le va a hacer el analisis
		$('#analisis .titulo').html('Análisis '+num+'° neumático');
		$('#analisis').fadeIn(150)
	}else{
		Reporte();
		$('#analisis').hide();
	}
}

$('#empezar').click(function(){	
	$('#empezar').hide();
	$('.cargando').show();

	setTimeout(function(){
		$.ajax({
			url: 'php/archivo.php',
			dataType: 'json',
			async: false,
			success: function(datos) {
				if (datos['estado']){
					var llanta = {
						num_llanta: llanta_actual,
						sensor : parseFloat(datos['sensor']),
						valor_imagen : datos['imagen']
					};
					reporte.push(llanta);					
				}
			},
			error:function(e){
				console.log(e.responseText);
			}
		});

		if (llanta_actual<num_llantas){
			setTimeout(function(){
				llanta_actual++;
				$('#empezar').show();
				$('.cargando').hide();
				Pasos(llanta_actual, 0);
			}, 30000)
		}else{
			$('#analisis .titulo').html('Generando reporte de resultados...');
			setTimeout(function(){
				Pasos(llanta_actual, 1);			
				$('#reporte').show();	
			}, 8000)
		}
	}, 3000)
})

$('#nuevo').click(function(){
	Reiniciar();
})

$('#cancelar').click(function(){
	Reiniciar();
})

function Reiniciar(){
	$.ajax({
		url: 'php/borrar_fotos.php',
		dataType: 'json',
		async: false,
		success: function(datos) {
			console.log(datos);
		},
		error:function(e){
			console.log(e.responseText);
		}
	});
	propietario = '';
	placa = '';
	num_llantas = 0;
	llanta_actual = 1;
	reporte = [];
	$('#formulario').fadeIn(150);
	$('#analisis').fadeOut(150)
	$('#reporte').fadeOut(150)
	document.getElementById('propietario').value = '';
	document.getElementById('placa').value = '';
	document.getElementById('num_llantas').value = '';
}

$('#imprimir').click(function(){
	$('#imprimir').hide();
	$('#nuevo').hide();
	window.print();
	$('#imprimir').show();
	$('#nuevo').show();
})

function Reporte(){


	$('#reporte .cabeza .title .propietario').html('Nombre del Propietario: '+propietario);
	$('#reporte .cabeza .title .placa').html('Placa: '+placa);
	$('#reporte .cabeza .title .num_llantas').html('N&uacute;mero de llantas: '+num_llantas);
	console.log(reporte);

	for (x=0; x<num_llantas; x++){

		var item = '';
		item += '<li class="item">';
		item += '<h2>Llanta # '+reporte[x]['num_llanta']+'</h2>';

		item += '<div class="imagenes">';
		item += '<figure><img src="llantas/foto_'+(x+1)+'.jpg" alt=""></figure>';
		item += '<figure><img src="llantas/gris_'+(x+1)+'.jpg" alt=""></figure>';
		item += '<figure><img src="llantas/proc_'+(x+1)+'.jpg" alt=""></figure>';
		item += '</div>';

		item += '<div class="informacion">';
		item += '<p>Medida Obtenida: '+reporte[x]['sensor']+' mm</p>';
		item += '<p>Valor de An&aacute;lisis: '+reporte[x]['valor_imagen']+'</p>';
		if ((reporte[x]['sensor']>=1)&&(reporte[x]['sensor']<=2.99)){
			item += '<p class="resultado">Neum&aacute;tico en mal estado.</p>';			
		}else if ((reporte[x]['sensor']>=3)&&(reporte[x]['sensor']<=5.99)) {
			item += '<p class="resultado">Neum&aacute;tico en estado medio.</p>';
		}else if ((reporte[x]['sensor']>=6)&&(reporte[x]['sensor']<=10)) {
			item += '<p class="resultado">Neum&aacute;tico en buen estado.</p>';
		}
		item += '</div>';
		item += '</li>';

		$('#llantas').append(item);
	};
}
