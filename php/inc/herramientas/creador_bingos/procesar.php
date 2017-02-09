<?php
session_start();  // INICIO LA SESION
include "../classes/gifmerge/GIFEncoder.class.php";
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require_once ('../classes/img/Image_Toolbox.class.php');
include ('../../../classes/querys/query.php');
require ('../../../classes/languages/language_detect.php');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],26);

$id_usuario=$_POST['id_usuario'];
$output=$_POST['output'];
$imagen_original='';

if ($output==1) {
	
	if ($_POST['desde']==1) {
	
			if (isset($_POST['thelist2']) && $_POST['thelist2'] !="") {
			
					foreach ($_POST['thelist2'] as $indice=>$valor){ 
						
						$url=$_POST['thelist3'][$indice]; //Importante es el indice no el valor
						
							if ($url != '') {
								$encript->desencriptar($url,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
								$ruta=$url['ruta_cesto'];
								$img = new Image_Toolbox('../../../'.$ruta);
								$nombre_img=basename(tempnam("../../../temp",'GIF')); 
								$img->save('../../../temp/'.$nombre_img.'.gif', 'gif', '256'); 
								$frames [ ] = '../../../temp/'.$nombre_img.'.gif';
								$framed [ ] = $_POST['milisegundos'];
							}						
					}
			  } else {
			  
			  		foreach ($_POST['thelist3'] as $indice=>$valor){ 
						
						$encript->desencriptar($valor,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
						$ruta=$valor['ruta_cesto'];
						$img = new Image_Toolbox('../../../'.$ruta);
						$nombre_img=basename(tempnam("../../../temp",'GIF')); 
						$img->save('../../../temp/'.$nombre_img.'.gif', 'gif', '256'); 
						$frames [ ] = '../../../temp/'.$nombre_img.'.gif';
						$framed [ ] = $_POST['milisegundos'];
					
					}
			  
			  
			  }
	
	} elseif ($_POST['desde']==2) {
	
			$id_seleccion=$_POST['id_seleccion'];
			
			$simbolos_seleccion=$query->datos_simbolos_seleccion($id_seleccion,$id_usuario);
			
			while ($row=mysql_fetch_array($simbolos_seleccion)) {
			
				if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $img = new Image_Toolbox('../../../usuarios/'.$row['ruta_file'].'/'.$row['file_name']); }
				elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $img = new Image_Toolbox('../../../repositorio/originales/'.$row['file_name']); } 
				
				$nombre_img=basename(tempnam("../../../temp",'GIF'));
				$img->save('../../../temp/'.$nombre_img.'.gif', 'gif', '256'); 
				$frames [ ] = '../../../temp/'.$nombre_img.'.gif';
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
	
	$nombre_tmp=basename(tempnam("../../../temp",'GIF'));
	FWrite ( FOpen ( "../../../temp/".$nombre_tmp.".gif", "wb" ), $gif->GetAnimation ( ) );
	
		$ruta_cesto='ruta_cesto=temp/'.$nombre_tmp.'.gif';
		$encript->encriptar($ruta_cesto,1);
		$ruta='img=../../temp/'.$nombre_tmp.'.gif';
		$encript->encriptar($ruta,1);	
	
	echo '<div id="products" style="height:40px; border:1px solid #CCC; padding: 5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a> <a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');">'.$translate['add_seleccion'].'</a> | <a href="../../inc/public/descargar.php?i='.$ruta.'""><img src=\'../../images/download_3.png\' border="0" alt="'.$translate['descargar_simbolo'].'" title="'.$translate['descargar_simbolo'].'"></a> <a href="../../inc/public/descargar.php?i='.$ruta.'"">'.$translate['descargar_simbolo'].'</a>';
	
	if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
		echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Guardar GIF animado', 'gestionar_repositorio/mover_temp.php?img='+document.img_subida.imagen_actual.value+'&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../images/filesave.png\" alt=\"Guardar GIF animado\" title=\"Guardar GIF animado\" border=\"0\"/></a>";
	}
	
	echo '</div><br><div align="center"><img src="../../temp/'.$nombre_tmp.'.gif" border="0"><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_tmp.'.gif"/></div>';

} elseif ($output==2) {

include('../classes/flash/class.flashslideshow.php');
$movie = new flashSlideShow(500, 500, 3, '#FFFFFF');

		if ($_POST['desde']==1) {
		
			if (isset($_POST['thelist2']) && $_POST['thelist2'] !="") {
			
					foreach ($_POST['thelist2'] as $indice=>$valor){ 
						
						$url=$_POST['thelist3'][$indice]; //Importante es el indice no el valor
						
							if ($url != '') {
								$encript->desencriptar($url,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
								$ruta=$url['ruta_cesto'];
								$movie->addImage('../../../'.$ruta);
							}						
					}
			  } else {
			  
			  		foreach ($_POST['thelist3'] as $indice=>$valor){ 
						
						$encript->desencriptar($valor,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
						$ruta=$valor['ruta_cesto'];
						$movie->addImage('../../../'.$ruta);
					
					}
			  
			  
			  }
		
	} elseif ($_POST['desde']==2) {
	
			$id_seleccion=$_POST['id_seleccion'];
			
			$simbolos_seleccion=$query->datos_simbolos_seleccion($id_seleccion,$id_usuario);
			
			while ($row=mysql_fetch_array($simbolos_seleccion)) {
			
				if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $movie->addImage('../../../usuarios/'.$row['ruta_file'].'/'.$row['file_name']); }
				elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $movie->addImage('../../../repositorio/originales/'.$row['file_name']); } 
			
			}	
		
	}
	
	$nombre_tmp=basename(tempnam("../../../temp",'GIF'));
	$movie->save("../../../temp/".$nombre_tmp.".swf");

	$ruta_cesto='ruta_cesto=temp/'.$nombre_tmp.'.swf';
	$encript->encriptar($ruta_cesto,1);
	$ruta='img=../../temp/'.$nombre_tmp.'.swf';
	$encript->encriptar($ruta,1);	
	
	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../images/cesto.gif\' border="0" alt="'.$translate['add_animacion_cesto'].'" title="'.$translate['add_animacion_cesto'].'"></a>';
	
	if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
		echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Guardar GIF animado', 'gestionar_repositorio/mover_temp.php?img='+document.img_subida.imagen_actual.value+'&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../images/filesave.png\" alt=\"Guardar GIF animado\" title=\"Guardar GIF animado\" border=\"0\"/></a>";
	}
	
	echo '&nbsp;<a href="../../inc/public/descargar.php?i='.$ruta.'"><img src=\'../../images/download1.png\' border="0" alt="'.$translate['add_animacion_cesto'].'" title="'.$translate['add_animacion_cesto'].'"></a></div><br><div align="center"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
 codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" name="Gallery"
 width="500" height="500" align="middle" id="Gallery">
  <param name="movie" value="../../temp/'.$nombre_tmp.'.swf"/>
  <param name="quality" value="high" />
  <param name="scale" value="noborder" />
  <param name="salign" value="lt" />
  <param name="bgcolor" value="#FFFFFF" />
  <embed src="../../temp/'.$nombre_tmp.'.swf" width="500" height="500" align="middle" quality="high" bgcolor="#FFFFFF"
 name="Gallery" scale="noborder" salign="lt" type="application/x-shockwave-flash"
 pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_tmp.'.swf"/></div>';
	
}
?>
