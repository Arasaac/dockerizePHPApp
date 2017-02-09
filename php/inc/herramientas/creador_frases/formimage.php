<?php
require('../../../funciones/funciones.php');
include_once ("../../../classes/querys/query.php");
include_once ("../../../classes/framemaker/framemaker.php");
include_once('../../../classes/utf8/utf8.class.php');
require_once ('../../../classes/img/Image_Toolbox.class.php');
require "../../../classes/text_image/class.atextimage.php";
require("../../../classes/graficas/jpgraph/jpgraph.php");
require("../../../classes/graficas/jpgraph/jpgraph_scatter.php");
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
include("../../../classes/text_image/fagd.php");

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

		
$dir="../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_img=basename(tempnam("../../temp",'TMP')).'_'.$_POST['id_palabra']; 

$accion="normal";
$accion=$_POST['accion'];
$imagen_tratada="";
$imagen_original=$_POST['archivo'];
$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
$fuente_castellano=$_POST['fuente_castellano'];
$pixels_final=(int)($_POST['pixels_final']);


/***************************************************/
/*    CONFIGURACIÓN DEL BORDE DEL SÍMBOLO           */
/***************************************************/

$pixels_borde=$_POST['pixels_borde'];
$color_borde=$_POST['color_borde'];


/***************************************************/

/***************************************************/
/*    RECUPERO TAMAÑO IMAGEN			           */
/***************************************************/

switch ($extension) {

	case "gif":
	$source = imagecreatefromgif($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "png":
	$source = imagecreatefrompng($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "jpg":
	$source = imagecreatefromjpeg($dir.$imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;

}
/***************************************************/


if (!isset($accion) || $accion=="") {
$imagen_tratada=$_POST['archivo'];
} else {

	switch ($accion) {
	
	case 'invertir':
	invert_image($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,true,$extension);
	$imagen_tratada=$nombre_img.'.'.$extension;
	break;
	
	
	case 'alto_contraste':
	
	$color_contraste=substr($_POST['color_contraste'], 1);
	
	if ($extension=='jpg') {
		alto_contraste_jpg($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
	} elseif ($extension=='png') {
		alto_contraste_png($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
	} elseif ($extension=='gif') {
		alto_contraste_png($dir.$imagen_original,'../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);
	}
	
	$imagen_tratada=$nombre_img.'.'.$extension;
	break;
	
	
	case 'normal':
	$imagen_tratada=$_POST['archivo'];
	break;
	
	case 'tratada':
	$imagen_tratada=$nombre_img.'.'.$extension;
	break;
	}

}

/***************************************************/
/*    AMPLIAR EL LIENZO SI ES NECESARIO           */
/***************************************************/

if ($_POST['pixels_lienzo'] > 0) {
	DEFINE('SIMBOLO',$dir.$imagen_tratada);
	$pixels=$_POST['pixels_lienzo'];
	$graph = new Graph($imageX+$pixels,$imageY+$pixels);
	$graph->SetFrame(false);
	$graph->img->SetMargin(0,0,0,0);
	$graph->SetMarginColor('white');
	$graph->SetScale('linlin',0,100,0,100);
	// We don't want any axis to be shown
	$graph->xaxis->Hide();
	$graph->yaxis->Hide();
	$graph->SetBackgroundImage(SIMBOLO,BGIMG_CENTER);
	$graph->Stroke($dir.$imagen_tratada);
	
	switch ($extension) {

		case "gif":
		$img = new Image_Toolbox($dir.$imagen_tratada);
		$img->save($dir.$imagen_tratada, 'gif', '100'); 
		break;
		
		case "png":
		$img = new Image_Toolbox($dir.$imagen_tratada);
		$img->save($dir.$imagen_tratada, 'png', '100'); 
		break;
		
		case "jpg":
		$img = new Image_Toolbox($dir.$imagen_tratada);
		$img->save($dir.$imagen_tratada, 'jpg', '100'); 
		break;

	}
}
/***************************************************/


/***************************************************/
/*    CODIFICACION DIFERENTES IDIOMAS           */
/***************************************************/

define("MAP_DIR","../utf8/MAPPING");
define("CP1250",MAP_DIR . "/CP1250.MAP");
define("CP1251",MAP_DIR . "/CP1251.MAP");
define("CP1252",MAP_DIR . "/CP1252.MAP");
define("CP1253",MAP_DIR . "/CP1253.MAP");
define("CP1254",MAP_DIR . "/CP1254.MAP");
define("CP1255",MAP_DIR . "/CP1255.MAP");
define("CP1256",MAP_DIR . "/CP1256.MAP");
define("CP1257",MAP_DIR . "/CP1257.MAP");
define("CP1258",MAP_DIR . "/CP1258.MAP");
define("CP874", MAP_DIR . "/CP874.MAP");
define("CP932", MAP_DIR . "/CP932.MAP");
define("CP936", MAP_DIR . "/CP936.MAP");
define("CP949", MAP_DIR . "/CP949.MAP");
define("CP950", MAP_DIR . "/CP950.MAP");
define("GB2312", MAP_DIR . "/GB2312.MAP");
define("BIG5", MAP_DIR . "/BIG5.MAP");


$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$id_traduccion=$_POST['id_traduccion'];
$query=new query();
$result=$query->buscar_traduccion_por_id($id_traduccion);
$d_palabra=mysql_fetch_array($result);

$castellano=$_POST['txt_cas'];

$res_ar = $utfConverter->strToUtf8($d_palabra['traduccion']);
$res_ru = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);
$res_bulg = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);


$img=$imagen_tratada;
$basead="../../temp/";

switch ($d_palabra['idioma']) {

	case 'Chino':
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$lang_ext_mayusc=$d_palabra['traduccion'];
	$font_ext="../../fonts/Cyberbit.ttf";	
	break;
	
	case 'Rumano':
	$lang_ext_mayusc=strtoupper($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	case 'Polaco':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion'];
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	case 'Ruso':
	$lang_ext_mayusc=strtoupper($res_ru);
	$lang_ext_minusc=$res_ru; 
	$font_ext="../../plugins/html2ps/fonts/times.ttf";
	break;
	
	case 'Bulgaro':
	$lang_ext_mayusc=strtoupper($res_bulg);
	$lang_ext_minusc=$res_bulg; 
	$font_ext="../../plugins/html2ps/fonts/times.ttf";
	break;
	
	case 'Arabe':
/*	$lang_ext_mayusc=strtoupper($res_ar);
	$lang_ext_minusc=$res_ar; 
	$font_ext="../../plugins/html2ps/fonts/times.ttf";*/
	
	$lang_ext_mayusc=fagd($res_ar,'','normal');
	$lang_ext_minusc=fagd($res_ar,'','normal'); 
	// Replace path by your own font path
	$font_ext= "../../plugins/html2ps/fonts/FreeFarsi.ttf";
	
	break;
	
	case 'Ingles':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	case 'Frances':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	case 'Catalan':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	
	case 99:
	$lang_ext="";
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	default:
	$lang_ext="";
	$font_ext="../../plugins/html2ps/fonts/arial.ttf";
	break;


}

//$orden=$_POST['orden'];

$sup_idioma=$_POST['sup_idioma'];
$inf_idioma=$_POST['inf_idioma'];

//0-Sin idioma
//1-Castellano
//2-Idioma

$castellano_mayusc=strtoupper_utf8($castellano); 
$castellano_minusc=$castellano; 

$orden=$sup_idioma.$inf_idioma;

switch ($orden) {

	case 12:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2=$font_ext;
	if ($_POST['sup_may']==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
	if ($_POST['inf_may']==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
	
	break;
	
	case 21:
	$fnt1=$font_ext;
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	if ($_POST['sup_may']==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
	if ($_POST['inf_may']==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
	
	break;
	
	case 10:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	if ($_POST['sup_may']==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
	$texto2="";
	break;
	
	case 01:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	if ($_POST['inf_may']==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
	break;
	
	case 02:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	if ($_POST['inf_may']==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
	$fnt2=$font_ext;
	break;
	
	case 20:
	$fnt1=$font_ext;
	if ($_POST['sup_may']==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
	$texto2="";
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;
	
	case 0:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	$texto2="";
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;
	
	default:
	$fnt1="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	$texto2="";
	$fnt2="../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;
}

$timg = new ATextImage();
$timg->SetBackground(255,255,255);
$timg->CreateImage($dir.$imagen_tratada);


$di=$_REQUEST['di'];
$fm=$extension; // Extension de salida
$si="yes";       //save image to atest.png?
$wd=500;       //width of blank image
$ht=500;       //height of blank image

$just="center";
$horz="center";
$vert="top";
$sz=$_POST['sz_f_s'];
$hex1=substr($_POST['color_sup'], 1);
$color1=hex2rgb($hex1);

$timg->SetFont($fnt1,$sz);
$timg->SetTextColor($color1[0], $color1[1], $color1[2]);
$timg->SetPos("center","top","center"); 

$txt=stripslashes($texto1);
$tx=explode("\n",$txt);

 foreach($tx as $t)
 {
 	$timg->AddLine($t);
 }
 
$timg->MakeImage($wd,$ht);

$hex2=substr($_POST['color_inf'], 1);
$color2=hex2rgb($hex2);

$sz1=$_POST['sz_f_i'];
$timg->SetFont($fnt2,$sz1);
$timg->SetTextColor($color2[0], $color2[1], $color2[2]);
//if($border=="1") { $timg->SetBorder(0,0,0); }
		
$timg->SetPos("center","bottom","center");       
$timg->AddLine($texto2,TRUE);
$timg->MakeImage($wd,$ht);


if($fm == "png"){

	$timg->ShowPng('../../temp/'.$nombre_img.'.png',$di);
	
	if ($_POST['marco'] == 1) {
		$frame = new FrameMaker();
		$frame->set_picture('../../temp/'.$nombre_img.'.png');
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path('../../temp/'.$nombre_img.'.png');
		$frame->show_picture();
		$img = new Image_Toolbox('../../temp/'.$nombre_img.'.png');
		if ($pixels_final != 0) { $img->newOutputSize($pixels_final,$pixels_final,1,false,'#FFFFFF'); }
		$img->save('../../temp/'.$nombre_img.'.png', 'png', '100'); 
	}
	
	$ruta_cesto='ruta_cesto=temp/'.$nombre_img.'.png';
	$encript->encriptar($ruta_cesto,1);
	
	$ruta='img=../../temp/'.$nombre_img.'.png';
	$encript->encriptar($ruta,1);

	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="inc/public/descargar.php?i='.$ruta.'""><img src=\'images/download1.png\' border="0" alt="Descargar simbolo"></a></div><br><div align="center"><img src=\'temp/'.$nombre_img.'.png\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_img.'.png"/></form></div>';
}


if($fm == "jpg"){
	$timg->ShowJpg('../../temp/'.$nombre_img.'.jpg',$di);

	if ($_POST['marco'] == 1) {
		$frame = new FrameMaker();
		$frame->set_picture('../../temp/'.$nombre_img.'.jpg');
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path('../../temp/'.$nombre_img.'.jpg');
		$frame->show_picture();
		
		if ($pixels_final != 0) { 
			$img = new Image_Toolbox('../../temp/'.$nombre_img.'.jpg');
			$img->newOutputSize($pixels_final,$pixels_final,2,false,'#FFFFFF');
			$img->save('../../temp/'.$nombre_img.'.jpg', 'jpg', '100'); 
		}
	}
	
	$ruta_cesto='ruta_cesto=temp/'.$nombre_img.'.jpg';
	$encript->encriptar($ruta_cesto,1);
	
	$ruta='img=../../temp/'.$nombre_img.'.jpg';
	$encript->encriptar($ruta,1);
	
	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="inc/public/descargar.php?i='.$ruta.'""><img src=\'images/download1.png\' border="0" alt="Descargar simbolo"></a></div><br><div align="center"><img src=\'temp/'.$nombre_img.'.jpg\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_img.'.jpg"/></form></div>';
}


if($fm == "gif"){
	$timg->ShowGif('../../temp/'.$nombre_img.'.gif',$di);
	
		if ($_POST['marco'] == 1) {
			$frame = new FrameMaker();
			$frame->set_picture('../../temp/'.$nombre_img.'.gif');
			$frame->set_border($pixels_borde,$color_borde,"solid");
			$frame->set_path('../../temp/'.$nombre_img.'.gif');
			$frame->show_picture();
			
			if ($pixels_final != 0) { 
				$img = new Image_Toolbox('../../temp/'.$nombre_img.'.gif');
				$img->newOutputSize($pixels_final,$pixels_final,2,false,'#FFFFFF');
				$img->save('../../temp/'.$nombre_img.'.gif', 'gif', '100');
			} 
		}
	
	$ruta_cesto='ruta_cesto=temp/'.$nombre_img.'.gif';
	$encript->encriptar($ruta_cesto,1);
	
	$ruta='img=../../temp/'.$nombre_img.'.gif';
	$encript->encriptar($ruta,1);
		
	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="inc/public/descargar.php?i='.$ruta.'""><img src=\'images/download1.png\' border="0" alt="Descargar simbolo"></a></div><br><div align="center"><img src=\'temp/'.$nombre_img.'.gif\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$imagen_original.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nombre_img.'.gif"/></form></div>';

}
?>

