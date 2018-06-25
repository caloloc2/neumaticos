<?php 

$path = "../img/logo-utn.png";
$type = mime_content_type($path);
$img_size = getimagesize($path);


$resize = array(250, 250);

$ratio = $img_size[0]/$img_size[1];

if ($resize[0]/$resize[1] > $ratio)
   $resize[0] = $resize[1] * $ratio;
else
   $resize[1] = $resize[0]/$ratio;

$func_images = array(
    'jpeg' => array('imagecreatefromjpeg', 'image/jpeg'),
    'jpg' => array('imagecreatefromjpeg', 'image/jpeg'),
    'png' => array('imagecreatefrompng', 'image/png'),
    'gif' => array('imagecreatefromgif', 'image/gif')
);

$img = call_user_func($func_images[$type][0], $path);
$new_img = imagecreatetruecolor($resize[0], $resize[1]);
imagecopyresized($new_img, $img, 0, 0, 0, 0, $resize[0], $resize[1], $img_size[0], $img_size[1]);
call_user_func($func_images[$tipo][1], $new_img, $path);
















/*function Imagen($imagen){
	$max_ancho=300;
	$max_alto=300;

	$img = "../img/logo-utn.png";
	$data = file_get_contents($foto);
	
	$size = getimagesize($foto);
	$ancho = $size['width'];
	$alto = $size['height'];
	
	$foto='';
	$mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	// Variables de la foto
	$name = $imagen['imagen']["name"];
	$type = mime_content_type($foto);
	$tmp_name = $imagen['imagen']["tmp_name"];
	$size = $imagen['imagen']["size"];

	$rtOriginal=$tmp_name;
	$original = @imagecreatefromjpeg($rtOriginal);					
			
	//Medir la imagen
	list($ancho,$alto)=getimagesize($rtOriginal);
	//Ratio
	$x_ratio = $max_ancho / $ancho;
	$y_ratio = $max_alto / $alto;
	//Proporciones
	/*if(($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	    $ancho_final = $ancho;
	    $alto_final = $alto;
	}else if(($x_ratio * $alto) < $max_alto){
	    $alto_final = ceil($x_ratio * $alto);
	    $ancho_final = $max_ancho;
	}else {
	    $ancho_final = ceil($y_ratio * $ancho);
	    $alto_final = $max_alto;
	}	

	//Crear un lienzo
	$lienzo=imagecreatetruecolor($max_ancho, $max_alto); 
	//Copiar original en lienzo
	$ooooo = imagecopyresampled($lienzo, $original, 0, 0, 0, $src_y, $max_ancho, $max_alto, $ancho, $max_alto);
	//Destruir la original
	imagedestroy($original);
	
	//Crear la imagen y guardar en directorio tmp/
	switch ($type) {
		case 'image/jpeg':
			imagejpeg($lienzo,"tmp/".$name, 75);
			break;
		case 'image/pjpeg':
			imagejpeg($lienzo,"tmp/".$name, 75);				
			break;
		case 'image/gif':
			imagegif($lienzo,"tmp/".$name);
			break;
		case 'image/png':
			imagepng($lienzo,"tmp/".$name, 9);
			break;
	}

	$foto = file_get_contents("tmp/".$name);
	@unlink($tmp_name);
	@unlink("tmp/".$name);	
	
	return $foto;
}*/