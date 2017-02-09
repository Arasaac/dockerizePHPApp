<?php
session_start();  // INICIO LA SESION
include "GIFEncoder.class.php";
require_once('../crypt/5CR.php');
require_once('../../configuration/key.inc');
require_once ('../img/Image_Toolbox.class.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {

			foreach ($_SESSION['cart'] as $key => $value) {
			
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta=$key['ruta_cesto'];
			$img = new Image_Toolbox('../../'.$ruta);
			$nombre_img=basename(tempnam("../../temp",'GIF')); 
			$img->save('../../temp/'.$nombre_img.'.gif', 'gif', '100'); 
			$frames [ ] = '../../temp/'.$nombre_img.'.gif';
			$framed [ ] = $_POST['milisegundos'];						
			}
}
		
/*
	Build a frames array from sources...
*/
/*if ( $dh = opendir ( "frames/" ) ) {
	while ( false !== ( $dat = readdir ( $dh ) ) ) {
		if ( $dat != "." && $dat != ".." ) {
			$frames [ ] = "frames/$dat";
			$framed [ ] = 5;
		}
	}
	closedir ( $dh );
}*/
/*
		GIFEncoder constructor:
        =======================

		image_stream = new GIFEncoder	(
							URL or Binary data	'Sources'
							int					'Delay times'
							int					'Animation loops' 0=Infinitos
							int					'Disposal'
							int					'Transparent red, green, blue colors'
							int					'Source type'
						);
*/
$gif = new GIFEncoder	(
							$frames,
							$framed,
							$_POST['loops'],
							2,
							0, 0, 0,
							"url"
		);
/*
		Possibles outputs:
		==================

        Output as GIF for browsers :
        	- Header ( 'Content-type:image/gif' );
        Output as GIF for browsers with filename:
        	- Header ( 'Content-disposition:Attachment;filename=myanimation.gif');
        Output as file to store into a specified file:
        	- FWrite ( FOpen ( "myanimation.gif", "wb" ), $gif->GetAnimation ( ) );
*/

$nombre_tmp=basename(tempnam("../../temp",'GIF'));
FWrite ( FOpen ( "../../temp/".$nombre_tmp.".gif", "wb" ), $gif->GetAnimation ( ) );

	$ruta_cesto='ruta_cesto=temp/'.$nombre_tmp.'.gif';
	$encript->encriptar($ruta_cesto,1);

echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a></div><br><div align="center"><img src="temp/'.$nombre_tmp.'.gif" border="0"><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_img.'.gif"/></form></div>';
?>
