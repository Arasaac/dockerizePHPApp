<?php 


function elimina_acentos($cadena){

$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿ";

$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuy";

return(strtr($cadena,$tofind,$replac));

}



function color_borde_por_tipo_de_palabra($id_tipo_palabra) {



	switch ($id_tipo_palabra) {

	

		case 1:

		$color='#FFFF00';

		break;

	

		case 2:

		$color='#FF9900';

		break;

		

		case 3:

		$color='#33CC00';

		break;

		

		case 4:

		$color='#3366FF';

		break;

		

		case 5:

		$color='#FF66CC';

		break;

		

		case 6:

		$color='#FFFFFF';

		break;

		

		default:

		$color='#000000';

		break;

	

	}



	return $color;



}





function crear_pictograma($imagen_original,$accion,$fuente_castellano,$pixels_lienzo,$pixels_final,$pixels_borde,$color_borde,$color_contraste,$id_traduccion,$txt_cas,$sup_idioma,$inf_idioma,$sup_may,$inf_may,$sz_f_s,$color_sup,$color_inf,$sz_f_i,$marco) {



$dir="../../../temp";

$nombre_img=basename(tempnam("../../../temp",'TMP')); 

$extension = strtolower(substr(strrchr($imagen_original,"."), 1));



/***************************************************/

/*    RECUPERO TAMAÑO IMAGEN			           */

/***************************************************/



switch ($extension) {



	case "gif":

	$source = imagecreatefromgif($imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 

	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */

	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */

	break;

	

	case "png":

	$source = imagecreatefrompng($imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 

	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */

	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */

	break;

	

	case "jpg":

	$source = imagecreatefromjpeg($imagen_original); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 

	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */

	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */

	break;



}

/***************************************************/





/*if (!isset($accion) || $accion=="") {

$imagen_tratada=$imagen_original;

} else {



	switch ($accion) {

	

	case 'invertir':

	invert_image($imagen_original,'../../../temp/'.$nombre_img.'.'.$extension,true,$extension);

	$imagen_tratada=$nombre_img.'.'.$extension;

	break;

	

	

	case 'alto_contraste':

	

	$color_contraste=substr($color_contraste, 1);

	

	if ($extension=='jpg') {

		alto_contraste_jpg($imagen_original,'../../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);

	} elseif ($extension=='png') {

		alto_contraste_png($imagen_original,'../../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);

	} elseif ($extension=='gif') {

		alto_contraste_png($imagen_original,'../../../temp/'.$nombre_img.'.'.$extension,$color_contraste,$extension);

	}

	

	$imagen_tratada=$nombre_img.'.'.$extension;

	break;

	

	

	case 'normal':

	$imagen_tratada=$imagen_original;

	break;

	

	case 'tratada':

	$imagen_tratada=$nombre_img.'.'.$extension;

	break;

	}



}

*/

/***************************************************/

/*    AMPLIAR EL LIENZO SI ES NECESARIO           */

/***************************************************/



if ($pixels_lienzo > 0) {

	//DEFINE('SIMBOLO',$imagen_original);

	$pixels=$pixels_lienzo;

	$graph = new Graph($imageX+$pixels,$imageY+$pixels);

	$graph->SetFrame(false);

	$graph->img->SetMargin(0,0,0,0);

	$graph->SetMarginColor('white');

	$graph->SetScale('linlin',0,100,0,100);

	// We don't want any axis to be shown

	$graph->xaxis->Hide();

	$graph->yaxis->Hide();

	$graph->SetBackgroundImage($imagen_original,BGIMG_CENTER);

	$graph->Stroke($imagen_original);

	

	switch ($extension) {



		case "gif":

		$img = new Image_Toolbox($imagen_original);

		$img->save($imagen_original, 'gif', '100'); 

		break;

		

		case "png":

		$img = new Image_Toolbox($imagen_original);

		$img->save($imagen_original, 'png', '100'); 

		break;

		

		case "jpg":

		$img = new Image_Toolbox($imagen_original);

		$img->save($imagen_original, 'jpg', '100'); 

		break;



	}

	

}

/***************************************************/





/***************************************************/

/*    CODIFICACION DIFERENTES IDIOMAS           */

/***************************************************/

define("MAP_DIR","../classes/utf8/MAPPING");
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

$id_traduccion=$id_traduccion;
$query=new query();

$result=$query->buscar_traduccion_por_id($id_traduccion);
$d_palabra=mysql_fetch_array($result);

$castellano=$txt_cas;

$res_ar = $utfConverter->strToUtf8($d_palabra['traduccion']);
$res_ru = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);
$res_bulg = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);

$img=$imagen_tratada;
$basead="../../../temp/";

switch ($d_palabra['idioma']) {

	case 'Chino':
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$lang_ext_mayusc=$d_palabra['traduccion'];
	$font_ext="../../../fonts/Cyberbit.ttf";	
	break;

	case 'Rumano':
	$lang_ext_mayusc=strtoupper($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Polaco':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion'];
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Ruso':
	$lang_ext_mayusc=strtoupper($res_ru);
	$lang_ext_minusc=$res_ru; 
	$font_ext="../../../plugins/html2ps/fonts/times.ttf";
	break;

	case 'Bulgaro':
	$lang_ext_mayusc=strtoupper($res_bulg);
	$lang_ext_minusc=$res_bulg; 
	$font_ext="../../../plugins/html2ps/fonts/times.ttf";
	break;

	case 'Arabe':
/*	$lang_ext_mayusc=strtoupper($res_ar);
	$lang_ext_minusc=$res_ar; 
	$font_ext="../../plugins/html2ps/fonts/times.ttf";*/

	$lang_ext_mayusc=fagd($res_ar,'','normal');
	$lang_ext_minusc=fagd($res_ar,'','normal'); 
	// Replace path by your own font path
	$font_ext= "../../../plugins/html2ps/fonts/FreeFarsi.ttf";
	break;

	case 'Ingles':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Frances':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Catalan':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Euskera':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Aleman':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Italiano':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Portugues':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Portugues de Brasil':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 'Gallego':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;
	
	case 'Croata':
	$lang_ext_mayusc=strtoupper_utf8($d_palabra['traduccion']);
	$lang_ext_minusc=$d_palabra['traduccion']; 
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	case 99:
	$lang_ext="";
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

	default:
	$lang_ext="";
	$font_ext="../../../plugins/html2ps/fonts/arial.ttf";
	break;

}


//$orden=$_POST['orden'];
//0-Sin idioma
//1-Castellano
//2-Idioma

$castellano_mayusc=strtoupper_utf8($castellano); 
$castellano_minusc=$castellano; 
$orden=$sup_idioma.$inf_idioma;

switch ($orden) {

	case 12:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2=$font_ext;
	if ($sup_may==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
	if ($inf_may==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
	break;

	case 21:
	$fnt1=$font_ext;
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	if ($sup_may==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
	if ($inf_may==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
	break;

	case 10:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	if ($sup_may==1) { $texto1=$castellano_mayusc; } else { $texto1=$castellano_minusc; }
	$texto2="";
	break;

	case 01:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	if ($inf_may==1) { $texto2=$castellano_mayusc; } else { $texto2=$castellano_minusc; }
	break;

	case 02:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	if ($inf_may==1) { $texto2=$lang_ext_mayusc; } else { $texto2=$lang_ext_minusc; }
	$fnt2=$font_ext;
	break;

	case 20:
	$fnt1=$font_ext;
	if ($sup_may==1) { $texto1=$lang_ext_mayusc; } else { $texto1=$lang_ext_minusc; }
	$texto2="";
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;

	case 0:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	$texto2="";
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;

	default:
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$texto1="";
	$texto2="";
	$fnt2="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	break;

}

$timg = new ATextImage();
$timg->SetBackground(255,255,255);
$timg->CreateImage($imagen_original);
$di=$_REQUEST['di'];
$fm=$extension; // Extension de salida
$si="yes";       //save image to atest.png?
$wd=500;       //width of blank image
$ht=500;       //height of blank image

$just="center";
$horz="center";
$vert="top";
$sz=$sz_f_s;
$hex1=substr($color_sup, 1);
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
$hex2=substr($color_inf, 1);
$color2=hex2rgb($hex2);

$sz1=$sz_f_i;
$timg->SetFont($fnt2,$sz1);
$timg->SetTextColor($color2[0], $color2[1], $color2[2]);
//if($border=="1") { $timg->SetBorder(0,0,0); }
$timg->SetPos("center","bottom","center");       
$timg->AddLine($texto2,TRUE);
$timg->MakeImage($wd,$ht);

if($fm == "png"){

	$timg->ShowPng('../../../temp/'.$nombre_img.'.png',$di);

	if ($marco == 1) {
		$frame = new FrameMaker();
		$frame->set_picture('../../../temp/'.$nombre_img.'.png');
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path('../../../temp/'.$nombre_img.'.png');
		$frame->show_picture();	
	}

	if ($pixels_final != 0) { 
		$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.png');
		$img->newOutputSize($pixels_final,$pixels_final,1,false,'#FFFFFF'); 
		$img->save('../../../temp/'.$nombre_img.'.png', 'png', '100');
	}

	// DOY 20 PIXELS DE MARGEN ALREDEDOR DE CADA PICTOGRAMA PARA QUE SE VISUALICE MEJOR LA SECUENCIA DE PICTOGRAMAS
	$graph2 = new Graph($pixels_final+20,$pixels_final+20);
	$graph2->SetFrame(false);
	$graph2->img->SetMargin(0,0,0,0);
	$graph2->SetMarginColor('white');
	$graph2->SetScale('linlin',0,100,0,100);
	$graph2->xaxis->Hide();
	$graph2->yaxis->Hide();
	$graph2->SetBackgroundImage('../../../temp/'.$nombre_img.'.png',BGIMG_CENTER);
	$graph2->Stroke('../../../temp/'.$nombre_img.'.png');
	$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.png');
	$img->save('../../../temp/'.$nombre_img.'.png', 'png', '100'); 
	return '../../../temp/'.$nombre_img.'.png';
}

if($fm == "jpg"){
	$timg->ShowJpg('../../../temp/'.$nombre_img.'.jpg',$di);

	if ($marco == 1) {
		$frame = new FrameMaker();
		$frame->set_picture('../../../temp/'.$nombre_img.'.jpg');
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path('../../../temp/'.$nombre_img.'.jpg');
		$frame->show_picture();
	}

	if ($pixels_final != 0) { 
		$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.jpg');
		$img->newOutputSize($pixels_final,$pixels_final,1,false,'#FFFFFF');
		$img->save('../../../temp/'.$nombre_img.'.jpg', 'jpg', '100'); 
	}

		

	// DOY 20 PIXELS DE MARGEN ALREDEDOR DE CADA PICTOGRAMA PARA QUE SE VISUALICE MEJOR LA SECUENCIA DE PICTOGRAMAS
	$graph2 = new Graph($pixels_final+20,$pixels_final+20);
	$graph2->SetFrame(false);
	$graph2->img->SetMargin(0,0,0,0);
	$graph2->SetMarginColor('white');
	$graph2->SetScale('linlin',0,100,0,100);
	$graph2->xaxis->Hide();
	$graph2->yaxis->Hide();
	$graph2->SetBackgroundImage('../../../temp/'.$nombre_img.'.jpg',BGIMG_CENTER);
	$graph2->Stroke('../../../temp/'.$nombre_img.'.jpg');

	$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.jpg');
	$img->save('../../../temp/'.$nombre_img.'.jpg', 'jpg', '100'); 

	return '../../../temp/'.$nombre_img.'.jpg';

}


if($fm == "gif"){

	$timg->ShowGif('../../../temp/'.$nombre_img.'.gif',$di);

	if ($marco == 1) {
		$frame = new FrameMaker();
		$frame->set_picture('../../../temp/'.$nombre_img.'.gif');
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path('../../../temp/'.$nombre_img.'.gif');
		$frame->show_picture();
	}

	if ($pixels_final != 0) { 
		$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.gif');
		$img->newOutputSize($pixels_final,$pixels_final,1,false,'#FFFFFF');
		$img->save('../../../temp/'.$nombre_img.'.gif', 'gif', '100');
	} 

	// DOY 20 PIXELS DE MARGEN ALREDEDOR DE CADA PICTOGRAMA PARA QUE SE VISUALICE MEJOR LA SECUENCIA DE PICTOGRAMAS
	$graph2 = new Graph($pixels_final+20,$pixels_final+20);
	$graph2->SetFrame(false);
	$graph2->img->SetMargin(0,0,0,0);
	$graph2->SetMarginColor('white');
	$graph2->SetScale('linlin',0,100,0,100);
	$graph2->xaxis->Hide();
	$graph2->yaxis->Hide();
	$graph2->SetBackgroundImage('../../../temp/'.$nombre_img.'.gif',BGIMG_CENTER);
	$graph2->Stroke('../../../temp/'.$nombre_img.'.gif');

	$img = new Image_Toolbox('../../../temp/'.$nombre_img.'.gif');
	$img->save('../../../temp/'.$nombre_img.'.gif', 'gif', '100'); 

	return '../../../temp/'.$nombre_img.'.gif';

}

}

// ***************************************************************************************************

// ***************************************************************************************************
//    ENCADENO LAS IMAGENES PARA FORMAR UNA UNICA IMAGEN
// ***************************************************************************************************

function encadenar_imagenes($under,$img_para_procesar,$salida) {

	$nombre_img=basename(tempnam("../../../temp",'TMP')); 
	$n_elementos=count($img_para_procesar); 

	$imgBuf = array ();
	$maxW=0; $maxH=0;

	foreach ($img_para_procesar as $link)
	{
		switch(substr($link,strrpos ($link,".")+1))
		{
			case 'png':
				$iTmp = imagecreatefrompng($link);
				break;

			case 'gif':
				$iTmp = imagecreatefromgif($link);
				break;               

			case 'jpeg':           

			case 'jpg':
				$iTmp = imagecreatefromjpeg($link);
				break;               
		}

		if ($under)
		{
			$maxW=(imagesx($iTmp)>$maxW)?imagesx($iTmp):$maxW;
			$maxH+=imagesy($iTmp);
		}
		else
		{
			$maxW+=imagesx($iTmp);
			$maxH=(imagesy($iTmp)>$maxH)?imagesy($iTmp):$maxH;
		}
		
		array_push ($imgBuf,$iTmp);
	}

	//GENERO EL FONDO BLANCO PARA PREVENIR QUE LOS HUECOS SIN PALABRA O PICTOGRAMA SE RELLENEN DE NEGRO
	$iOut = imagecreatetruecolor($maxW,$maxH) ;
	$iOutColor = imagecolorallocate($iOut, 255, 255,255); 
	imagefilledrectangle($iOut, 0, 0, $maxW, $maxH, $iOutColor);

	$pos=0;
	foreach ($imgBuf as $img)
	{
		if ($under)
			imagecopy ($iOut,$img,0,$pos,0,0,imagesx($img),imagesy($img));
		else
			imagecopy ($iOut,$img,$pos,0,0,0,imagesx($img),imagesy($img));   
		$pos+= $under ? imagesy($img) : imagesx($img);
		imagedestroy ($img);
	}

	switch ($salida) {

		case 'jpg':
		imagejpeg($iOut,'../../../temp/'.$nombre_img.'.jpg');
		$imagen_encadenada=$nombre_img.'.jpg';
		break;

		case 'png':
		imagepng($iOut,'../../../temp/'.$nombre_img.'.png'); 
		$imagen_encadenada=$nombre_img.'.png';
		break;

		case 'gif':
		imagegif($iOut,'../../../temp/'.$nombre_img.'.gif'); 
		$imagen_encadenada=$nombre_img.'.gif';
		break;

	}

	return $imagen_encadenada;

}

// ***************************************************************************************************
//    ENCADENO LAS IMAGENES PARA FORMAR UNA UNICA IMAGEN
// ***************************************************************************************************

function encadenar_imagenes_arriba($top,$img_para_procesar,$salida) {

	$nombre_img=basename(tempnam("../../../temp",'TMP')); 
	$n_elementos=count($img_para_procesar); 

	$imgBuf = array ();
	$maxW=0; $maxH=0;

	foreach ($img_para_procesar as $link)
	{
		switch(substr($link,strrpos ($link,".")+1))
		{
			case 'png':
				$iTmp = imagecreatefrompng($link);
				break;

			case 'gif':
				$iTmp = imagecreatefromgif($link);
				break;               

			case 'jpeg':           

			case 'jpg':
				$iTmp = imagecreatefromjpeg($link);
				break;               
		}

		if ($top)
		{
			$maxW=(imagesx($iTmp)>$maxW)?imagesx($iTmp):$maxW;
			$maxH+=imagesy($iTmp);
		}
		else
		{
			$maxW+=imagesx($iTmp);
			$maxH=(imagesy($iTmp)>$maxH)?imagesy($iTmp):$maxH;
		}
		
		array_push ($imgBuf,$iTmp);
	}

	//GENERO EL FONDO BLANCO PARA PREVENIR QUE LOS HUECOS SIN PALABRA O PICTOGRAMA SE RELLENEN DE NEGRO
	$iOut = imagecreatetruecolor($maxW,$maxH) ;
	$iOutColor = imagecolorallocate($iOut, 255, 255,255); 
	imagefilledrectangle($iOut, 0, 0, $maxW, $maxH, $iOutColor);

	$pos=0;
	foreach ($imgBuf as $img)
	{
		if ($top)
			imagecopy ($iOut,$img,0,0,0,0,imagesx($img),imagesy($img));
		else
			imagecopy ($iOut,$img,$pos,0,0,0,imagesx($img),imagesy($img));   
		$pos+= $top ? imagesy($img) : imagesx($img);
		imagedestroy ($img);
	}

	switch ($salida) {

		case 'jpg':
		imagejpeg($iOut,'../../../temp/'.$nombre_img.'.jpg');
		$imagen_encadenada=$nombre_img.'.jpg';
		break;

		case 'png':
		imagepng($iOut,'../../../temp/'.$nombre_img.'.png'); 
		$imagen_encadenada=$nombre_img.'.png';
		break;

		case 'gif':
		imagegif($iOut,'../../../temp/'.$nombre_img.'.gif'); 
		$imagen_encadenada=$nombre_img.'.gif';
		break;

	}

	return $imagen_encadenada;

}

/*****************************************************************************************************************/
/*    FUNCION PARA TRANSFORMAR EN MAYUSCULAS CARACTERES CON ACENTOS Y EÑES EN UTF-8 (UTILIZADO LOS SIMBOLOS)  */
/******************************************************************************************************************/

function strtoupper_utf8($string){
	
    $string=utf8_decode($string);
    $string=mb_strtoupper($string); // importante utilizar la funcion mb_strtoupper porque strtoupper no funcionaba en el servidor aunque si en local
    $string=utf8_encode($string);
    return $string;
}


function hex2rgb($hex){   

  if(!preg_match('/[0-9a-fA-F]{6}+$/', $hex)) { 
  echo "Error : input is not a valid hexadecimal number"; 
  return 0; 

} 

  
  for($i=0; $i<3; $i++) { 
	  $temp = substr($hex, 2*$i, 2); 
	  $rgb[$i] = 16 * hexdec(substr($temp, 0, 1)) + 
	  hexdec(substr($temp, 1, 1)); 
  } 


return $rgb; 

}


/*****************************************************************************************************************/
/*    FUNCION PARA GENERAR SIMBOLOS A PARTIR DE TEXTO EN MEDIO   */
/******************************************************************************************************************/

function generar_simbolos_solo_texto($width,$height,$sz_f_s,$color_sup,$fuente_castellano,$ubicacion,$texto,$extension) {

	$nombre_img=basename(tempnam("../../../temp",'TMP'));
	$im = @imagecreate($width+20,$height+20);
	$background_color = imagecolorallocate($im, 255, 255, 255);
	imagepng($im,"../../../temp/".$nombre_img.".png");

	$timg = new ATextImage();
	$timg->SetBackground(255,255,255);
	$timg->CreateImage("../../../temp/".$nombre_img.'.png');


	$wd=$width;       //width of blank image
	$ht=$height;       //height of blank image


	$sz=$sz_f_s;
	$hex1=substr($color_sup,1);
	$color1=hex2rgb($hex1);

	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$timg->SetFont($fnt1,$sz);
	$timg->SetTextColor($color1[0], $color1[1], $color1[2]);
	$timg->SetPos("center",$ubicacion,"center"); 
	$txt=stripslashes($texto);
	$tx=explode("\n",$txt);

	 foreach($tx as $t)
	 {
		$timg->AddLine($t);
	 }

	$timg->MakeImage($wd,$ht);

	switch ($extension) {
		case "gif":
		$timg->ShowGif("../../../temp/".$nombre_img.'.'.$extension,"");
		break;

		case "png":
		$timg->ShowPng("../../../temp/".$nombre_img.'.'.$extension,"");
		break;

		case "jpg":
		$timg->ShowJpg("../../../temp/".$nombre_img.'.'.$extension,"");	
		break;
	}

return "../../../temp/".$nombre_img.'.'.$extension;
}

function generar_simbolos_solo_texto_con_alineacion($width,$height,$sz_f_s,$color_sup,$fuente_castellano,$alineacion_vertical,$texto,$extension,$alineacion_horizontal,$justificado) {

	$nombre_img=basename(tempnam("../../../temp",'TMP'));
	$im = @imagecreate($width+20,$height+20);
	$background_color = imagecolorallocate($im, 255, 255, 255);
	imagepng($im,"../../../temp/".$nombre_img.".png");

	$timg = new ATextImage();
	$timg->SetBackground(255,255,255);
	$timg->CreateImage("../../../temp/".$nombre_img.'.png');


	$wd=$width;       //width of blank image
	$ht=$height;       //height of blank image


	$sz=$sz_f_s;
	$hex1=substr($color_sup,1);
	$color1=hex2rgb($hex1);

	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	$timg->SetFont($fnt1,$sz);
	$timg->SetTextColor($color1[0], $color1[1], $color1[2]);
	$timg->SetPos($alineacion_horizontal,$alineacion_vertical,$justificado); 
	$txt=stripslashes($texto);
	$tx=explode("\n",$txt);

	 foreach($tx as $t)
	 {
		$timg->AddLine($t);
	 }

	$timg->MakeImage($wd,$ht);

	switch ($extension) {
		case "gif":
		$timg->ShowGif("../../../temp/".$nombre_img.'.'.$extension,"");
		break;

		case "png":
		$timg->ShowPng("../../../temp/".$nombre_img.'.'.$extension,"");
		break;

		case "jpg":
		$timg->ShowJpg("../../../temp/".$nombre_img.'.'.$extension,"");	
		break;
	}

return "../../../temp/".$nombre_img.'.'.$extension;
}

function idiomas_disponibles($id_palabra,$idiomas_disponibles,$query) {


define("MAP_DIR","../classes/utf8/MAPPING");
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


include_once('../classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$num_traducciones=mysql_num_rows($idiomas_disponibles);

if ($num_traducciones > 0) {

$idiomas='<select name="id_traduccion" size="1" id="id_traduccion">';

while ($row=mysql_fetch_array($idiomas_disponibles)) {

	switch ($row['idioma']) {

		case 'Chino':
			$chino=$query->buscar_traduccion($id_palabra,4);
			if (mysql_num_rows($chino) > 0) {

				while ($row_chino=mysql_fetch_array($chino)) {
					if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.='<option value="'.$row_chino['id_traduccion'].'">Chino - '.$row_chino['traduccion'].'</option>'; }
				}
			}
			break;

			case 'Rumano':
			$rumano=$query->buscar_traduccion($id_palabra,2);
			if (mysql_num_rows($rumano) > 0) {
				while ($row_rumano=mysql_fetch_array($rumano)) {
					if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL) { $idiomas.='<option value="'.$row_rumano['id_traduccion'].'">Rumano - '.$row_rumano['traduccion'].'</option>'; }
				}
			}
			break;

			case 'Polaco':
			$polaco=$query->buscar_traduccion($id_palabra,6);
			if (mysql_num_rows($polaco) > 0) {

				while ($row_polaco=mysql_fetch_array($polaco)) {
					if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL) { $idiomas.='<option value="'.$row_polaco['id_traduccion'].'">Polaco - '.$row_polaco['traduccion'].'</option>'; }
				}

			}
			break;

			case 'Ruso':
			$ruso=$query->buscar_traduccion($id_palabra,1);
			if (mysql_num_rows($ruso) > 0) {
				while ($row_ruso=mysql_fetch_array($ruso)) {
					$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);
					if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL) { $idiomas.='<option value="'.$row_ruso['id_traduccion'].'">Ruso - '.$res_ru.'</option>'; }
				}
			}
			break;

			case 'Bulgaro':
			$bulgaro=$query->buscar_traduccion($id_palabra,5);
			if (mysql_num_rows($bulgaro) > 0) {
				while ($row_bulgaro=mysql_fetch_array($bulgaro)) {
					$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);
					if ($row_bulgaro['estado']==1 && $row_bulgaro['traduccion'] != NULL) { $idiomas.='<option value="'.$row_bulgaro['id_traduccion'].'">Bulgaro - '.$res_bulg.'</option>'; }
				}
			}
			break;

			

			case 'Arabe':

			$arabe=$query->buscar_traduccion($id_palabra,3);

			if (mysql_num_rows($arabe) > 0) {

				while ($row_arabe=mysql_fetch_array($arabe)) {

					$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);

					if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL) { $idiomas.='<option value="'.$row_arabe['id_traduccion'].'">Arabe - '.$res_ar.'</option>'; }

				}

			}

			break;

			

			case 'Ingles':

			$ingles=$query->buscar_traduccion($id_palabra,7);

			if (mysql_num_rows($ingles) > 0) {

				while ($row_ingles=mysql_fetch_array($ingles)) {

					if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL) { $idiomas.='<option value="'.$row_ingles['id_traduccion'].'">Ingles - '.$row_ingles['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Frances':

			$frances=$query->buscar_traduccion($id_palabra,8);

			if (mysql_num_rows($frances) > 0) {

				while ($row_frances=mysql_fetch_array($frances)) {

					if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL) { $idiomas.='<option value="'.$row_frances['id_traduccion'].'">Frances - '.$row_frances['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Catalan':

			$catalan=$query->buscar_traduccion($id_palabra,9);

			if (mysql_num_rows($catalan) > 0) {

				while ($row_catalan=mysql_fetch_array($catalan)) {

					if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL) { $idiomas.='<option value="'.$row_catalan['id_traduccion'].'">Catalan - '.$row_catalan['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Euskera':

			$euskera=$query->buscar_traduccion($id_palabra,10);

			if (mysql_num_rows($euskera) > 0) {

				while ($row_euskera=mysql_fetch_array($euskera)) {

					if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL) { $idiomas.='<option value="'.$row_euskera['id_traduccion'].'">Euskera - '.$row_euskera['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Aleman':

			$aleman=$query->buscar_traduccion($id_palabra,11);

			if (mysql_num_rows($aleman) > 0) {

				while ($row_aleman=mysql_fetch_array($aleman)) {

					if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL) { $idiomas.='<option value="'.$row_aleman['id_traduccion'].'">Aleman - '.$row_aleman['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Italiano':

			$italiano=$query->buscar_traduccion($id_palabra,12);

			if (mysql_num_rows($italiano) > 0) {

				while ($row_italiano=mysql_fetch_array($italiano)) {

					if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL) { $idiomas.='<option value="'.$row_italiano['id_traduccion'].'">Italiano - '.$row_italiano['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Portugues':

			$portugues=$query->buscar_traduccion($id_palabra,13);

			if (mysql_num_rows($portugues) > 0) {

				while ($row_portugues=mysql_fetch_array($portugues)) {

					if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL) { $idiomas.='<option value="'.$row_portugues['id_traduccion'].'">Portugues - '.$row_portugues['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Portugues de Brasil':

			$portugues_br=$query->buscar_traduccion($id_palabra,15);

				if (mysql_num_rows($portugues_br) > 0) {

						while ($row_portugues_br=mysql_fetch_array($portugues_br)) {

							if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL) { $idiomas.='<option value="'.$row_portugues_br['id_traduccion'].'">Portugues de Brasil- '.$row_portugues_br['traduccion'].'</option>'; }

						}

				}

			break;

			

			case 'Gallego':

			$gallego=$query->buscar_traduccion($id_palabra,14);

				if (mysql_num_rows($gallego) > 0) {

						while ($row_gallego=mysql_fetch_array($gallego)) {

							if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL) { $idiomas.='<option value="'.$row_gallego['id_traduccion'].'">Gallego- '.$row_gallego['traduccion'].'</option>'; }

						}

				}

			break;
			
			case 'Croata':
			$croata=$query->buscar_traduccion($id_palabra,16);
			if (mysql_num_rows($croata) > 0) {
				while ($row_croata=mysql_fetch_array($croata)) {
					if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.='<option value="'.$row_croata['id_traduccion'].'">Croata - '.$row_croata['traduccion'].'</option>'; }
				}
			}
			break;

	

	}



}



$idiomas.='</select>';



} else {



$idiomas='No hay traducciones disponibles &nbsp;<input name="id_traduccion" type="hidden" id="id_traduccion" value="0" /><br><br>';

}





return $idiomas;



} // Cierro la funcion



//*****************************************************************************************************************************************************

//*****************************************************************************************************************************************************

//*****************************************************************************************************************************************************



function idiomas_disponibles_con_castellano($id_palabra,$idiomas_disponibles,$query) {


include_once('../classes/utf8/utf8.class.php');

define("MAP_DIR","../classes/utf8/MAPPING");
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

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$num_traducciones=mysql_num_rows($idiomas_disponibles);



$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 



if ($num_traducciones > 0) {



$idiomas='<select name="id_traduccion" size="1" id="id_traduccion">';



while ($row=mysql_fetch_array($idiomas_disponibles)) {



	switch ($row['idioma']) {

		

		case 'Chino':

			$chino=$query->buscar_traduccion($id_palabra,4);

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			if (mysql_num_rows($chino) > 0) {

				while ($row_chino=mysql_fetch_array($chino)) {

					if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_chino['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_chino['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Rumano':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$rumano=$query->buscar_traduccion($id_palabra,2);

			if (mysql_num_rows($rumano) > 0) {

				while ($row_rumano=mysql_fetch_array($rumano)) {

					if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_rumano['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_rumano['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Polaco':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$polaco=$query->buscar_traduccion($id_palabra,6);

			if (mysql_num_rows($polaco) > 0) {

				while ($row_polaco=mysql_fetch_array($polaco)) {

					if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_polaco['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_polaco['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Ruso':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$ruso=$query->buscar_traduccion($id_palabra,1);

			if (mysql_num_rows($ruso) > 0) {

				while ($row_ruso=mysql_fetch_array($ruso)) {

					$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);

					if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_ruso['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ru.'</option>'; }

				}

			}

			break;

			

			case 'Bulgaro':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$bulgaro=$query->buscar_traduccion($id_palabra,5);

			if (mysql_num_rows($bulgaro) > 0) {

				while ($row_bulgaro=mysql_fetch_array($bulgaro)) {

					$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);

					if ($row_bulgaro['estado']==1 && $row_bulgaro['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_bulgaro['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_bulg.'</option>'; }

				}

			}

			break;

			

			case 'Arabe':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$arabe=$query->buscar_traduccion($id_palabra,3);

			if (mysql_num_rows($arabe) > 0) {

				while ($row_arabe=mysql_fetch_array($arabe)) {

					$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);

					if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_arabe['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ar.'</option>'; }

				}

			}

			break;

			

			case 'Ingles':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$ingles=$query->buscar_traduccion($id_palabra,7);

			if (mysql_num_rows($ingles) > 0) {

				while ($row_ingles=mysql_fetch_array($ingles)) {

					if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_ingles['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_ingles['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Frances':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$frances=$query->buscar_traduccion($id_palabra,8);

			if (mysql_num_rows($frances) > 0) {

				while ($row_frances=mysql_fetch_array($frances)) {

					if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_frances['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_frances['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Catalan':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$catalan=$query->buscar_traduccion($id_palabra,9);

			if (mysql_num_rows($catalan) > 0) {

				while ($row_catalan=mysql_fetch_array($catalan)) {

					if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_catalan['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_catalan['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Euskera':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$euskera=$query->buscar_traduccion($id_palabra,10);

			if (mysql_num_rows($euskera) > 0) {

				while ($row_euskera=mysql_fetch_array($euskera)) {

					if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_euskera['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_euskera['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Aleman':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$aleman=$query->buscar_traduccion($id_palabra,11);

			if (mysql_num_rows($aleman) > 0) {

				while ($row_aleman=mysql_fetch_array($aleman)) {

					if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_aleman['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_aleman['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Italiano':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$italiano=$query->buscar_traduccion($id_palabra,12);

			if (mysql_num_rows($italiano) > 0) {

				while ($row_italiano=mysql_fetch_array($italiano)) {

					if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_italiano['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_italiano['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Portugues':

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			$portugues=$query->buscar_traduccion($id_palabra,13);

			if (mysql_num_rows($portugues) > 0) {

				while ($row_portugues=mysql_fetch_array($portugues)) {

					if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_portugues['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Portugues de Brasil':

			$portugues_br=$query->buscar_traduccion($id_palabra,15);

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			if (mysql_num_rows($portugues_br) > 0) {

				while ($row_portugues_br=mysql_fetch_array($portugues_br)) {

					if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_portugues_br['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues_br['traduccion'].'</option>'; }

					}

			}

			break;

			

			case 'Gallego':

			$gallego=$query->buscar_traduccion($id_palabra,14);

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			if (mysql_num_rows($gallego) > 0) {

				while ($row_gallego=mysql_fetch_array($gallego)) {

					if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_gallego['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_gallego['traduccion'].'</option>'; }

					}

			}

			break;
			
			case 'Finlandes':

			$finlandes=$query->buscar_traduccion($id_palabra,16);

			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 

			if (mysql_num_rows($finlandes) > 0) {

				while ($row_finlandes=mysql_fetch_array($finlandes)) {

					if ($row_finlandes['estado']==1 && $row_finlandes['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_finlandes['id_traduccion'].'">'.$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_finlandes['traduccion'].'</option>'; }

					}

			}

			break;
			

			break;
			
			case 'Croata':
			$croata=$query->buscar_traduccion($id_palabra,16);
			if (mysql_num_rows($croata) > 0) {
				while ($row_croata=mysql_fetch_array($croata)) {
					if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.='<option value="i_'.$row_croata['id_traduccion'].'">Croata - '.$row_croata['traduccion'].'</option>'; }
				}
			}
			break;

	

	}



}



/*if ($_SESSION['language']!='es') {*/

	

	$palabra=$query->datos_palabra($id_palabra); 

	$idiomas.='<option value="c_'.$id_palabra.'">'.$translate['spanish'].' - '.utf8_encode($palabra['palabra']).'</option>';

	

/*}*/



$idiomas.='</select>';



} else {



$idiomas=$translate['no_hay_traducciones'].'&nbsp;<input name="id_traduccion" type="hidden" id="id_traduccion" value="0" /><br><br>';

}





return $idiomas;



} // Cierro la funcion





//*****************************************************************************************************************************************************

//*****************************************************************************************************************************************************

function CleanFiles($dir)

{

    //Borrar los ficheros temporales

    $t=time();

    $h=opendir($dir);

    while($file=readdir($h))

    {

        if(substr($file,0,3)=='tmp')

        {

            $path=$dir.'/'.$file;

            if($t-filemtime($path)>1800) //Establezo el tiempo 3600 (segundos) = 1h

                @unlink($path);

        }

    }

    closedir($h);

} 



//*****************************************************************************************************************************************************

//*****************************************************************************************************************************************************



function imagenes_disponibes($tipos_imagen,$query,$id_palabra,$encript) {

$resultados='';
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 

while ($salida=mysql_fetch_array($tipos_imagen)) {

if ($salida['id_tipo']!=11 && $salida['id_tipo']!=13) {  

	$img_disponibles=$query->imagenes_disponibles_tipo($id_palabra,$salida['id_tipo']);

	$num_resultados=mysql_num_rows($img_disponibles);

	// Inicializo las variables
	$o=0;
	$img=array();
	$file='';
	
	// Si el numero de resultados es mayor de 0 muestro los resultados

	if ($num_resultados > 0) {

	

		$resultados.='<div id="b'.$salida['id_tipo'].'" name="'.utf8_encode($salida['tipo_imagen_'.$_SESSION['language'].'']).' ('.$num_resultados.')" style="padding:10px;">

		<ul id="thelist2" style="height:280px; overflow:auto; width:100%; border:none; float:left;">';

		

			while ($row=mysql_fetch_array($img_disponibles)) {

				$img[]=$row['imagen'];

			}

			for ($i=1; $i<=10; $i++){ // FILAS

						$file=$img[$o];
						$ruta_img='size=70&ruta=../../../../repositorio/originales/'.$file;
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL

						if ($file=="") { break; }
						$resultados.="<li id=\"thelist2_".$ruta_img."\" style=\"cursor:pointer; background-color:#FFFFFF;\">

						<a href=\"javascript:void()\" onclick=\"javascript:cargar_div('utilizar_imagen.php','img=".$file."','simbolo');\">

						<img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" alt=\"".$translate['hacer_clic_para_creador']."\" title=\"".$translate['hacer_clic_para_creador']."\" border=\"0\"/>

						</a></li>"; 

						$o++;  

			} 

		$resultados.='</ul></div>';

	

		} // Cierro el IF de comprobacion de si hay resultados

		

	} // Cierro el IF para no mostrar los videos FLV (LSE)



} // Cierro el While 



return $resultados;

}



//*****************************************************************************************************************************************************

//*****************************************************************************************************************************************************



function saludo ()

{

if (Date("H") > 5 && Date("H")< 14) $mensaje = "Buenos Días";

elseif (Date("H") > 13 && Date("H") < 20) $mensaje = "Buenas Tardes";

elseif (Date("H") > 19 && Date("H") <= 23) $mensaje = "Buenas Noches";

elseif (Date("H") >= 0 && Date("H") < 6) $mensaje = "Buenas Noches";

return $mensaje;

}



//*****************************************************************************************************************************************************

function generar_ficha_oca($imagen_filename,$numero_casilla,$grados_rotar,$color_numero,$fontsize,$pictograma) { 
		//GENERO UN NOMBRE DE ARCHIVO TEMPORAL
		$file_name=rand(99999,9999999999999).'_'.basename($imagen_filename);
		$url_filename='../../../temp/'.$file_name;
		$file_sin_extension = explode('.',$file_name);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen_filename,'../../../temp/'.$file_name);
		
		//CONSTRUYO UNA IMAGEN CON EL NUMERO Y LA METO EN UN ARRAY JUNTO CON LA IMAGEN COPIADA
		$imagen_fila_txt=generar_simbolos_solo_texto_con_alineacion(500,50,$fontsize,$color_numero,'arial','top',$numero_casilla,'png','left','left');
		//UNO AMBAS IMAGENES PONIENDO ARRIBA LA IMAGEN CON EL NUMERO
		//$img_para_procesar='../../../temp/'.encadenar_imagenes_arriba(1,$imagen_fila_txt,"png");
		
		$imagem = new mergePictures($url_filename,$imagen_fila_txt);
		$imagem->merge("up");
		$imagem->save('../../../temp/',$file_sin_extension[0],"png");
		//$imagem->merge("down");
		//$imagem->save("imgs","foto2","bmp");
		//$imagem->over();
		//$imagem->save("imgs","foto1","gif");

		
		//ROTO LA IMAGEN LOS GRADOS NECESARIOS
		$pictograma->source_path = $url_filename;
		$pictograma->target_path = $url_filename;
		$pictograma->preserve_aspect_ratio = true;
    	$pictograma->enlarge_smaller_images = true;
    	$pictograma->preserve_time = true;
		$pictograma->rotate($grados_rotar,0);

return $url_filename;

}


function generar_ficha_domino($imagen_filename1,$imagen_filename2,$pictograma,$orientacion_ficha,$color_ficha) { 

	if ($orientacion_ficha==1) { //VERTICAL
		
		//GENERO UN NOMBRE DE ARCHIVO TEMPORAL
		$file_name=rand(99999,9999999999999).'_'.basename($imagen_filename1);
		$url_filename='../../../temp/'.$file_name;
		$file_sin_extension = explode('.',$file_name);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen_filename1,'../../../temp/'.$file_name);
		
		$file_name2=rand(99999,9999999999999).'_'.basename($imagen_filename2);
		$url_filename2='../../../temp/'.$file_name2;
		$file_sin_extension2 = explode('.',$file_name2);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen_filename2,'../../../temp/'.$file_name2);
		
		$imagenes[]='../../../temp/'.$file_name;
		$imagenes[]='../../../images/domino/centro_'.$color_ficha.'.png';
		$imagenes[]='../../../temp/'.$file_name2;
		
		$url_filename2='../../../temp/'.encadenar_imagenes(1,$imagenes,'png');
		
	} elseif ($orientacion_ficha==2) { //HORIZONTAL
		
		//GENERO UN NOMBRE DE ARCHIVO TEMPORAL
		$file_name=rand(99999,9999999999999).'_'.basename($imagen_filename1);
		$url_filename='../../../temp/'.$file_name;
		$file_sin_extension = explode('.',$file_name);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen_filename1,'../../../temp/'.$file_name);
		
		$file_name2=rand(99999,9999999999999).'_'.basename($imagen_filename2);
		$url_filename2='../../../temp/'.$file_name2;
		$file_sin_extension2 = explode('.',$file_name2);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen_filename2,'../../../temp/'.$file_name2);
		
		$imagenes[]='../../../temp/'.$file_name;
		$imagenes[]='../../../images/domino/centro_vertical_'.$color_ficha.'.png';
		$imagenes[]='../../../temp/'.$file_name2;
		
		$url_filename2='../../../temp/'.encadenar_imagenes(0,$imagenes,'png');
		
	}

	$frame = new FrameMaker();
	$frame->set_picture($url_filename2);
	$frame->set_border(20,$color_ficha,"solid");
	$frame->set_path($url_filename2);
	$frame->show_picture();
		
return $url_filename2;

}

//*****************************************************************************************************************************************************

function generar_ficha_domino_x_pictogramas($imagen,$numero,$pictograma) {
	
		//GENERO UN NOMBRE DE ARCHIVO TEMPORAL
		$file_name=rand(99999,9999999999999).'_'.basename($imagen);
		$url_filename='../../../temp/'.$file_name;
		$file_sin_extension = explode('.',$file_name);  
		//COPIO EL ARCHIVO ORIGINAL A LA CARPETA TEMPORAL
		copy ('../../../'.$imagen,'../../../temp/'.$file_name);
		
		switch ($numero) {
			
			case 2:
			$imagen1[]='../../../temp/'.$file_name;
			$imagen1[]='../../../images/domino/blanco.png';
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen1,'png');
			
			$imagen3[]='../../../images/domino/blanco.png';
			$imagen3[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen3,'png');
			
			$url_filename='../../../temp/'.encadenar_imagenes(1,$url_imagen,'png');
			break;
			
			case 3:
			$imagen1[]='../../../temp/'.$file_name;
			$imagen1[]='../../../images/domino/blanco.png';
			$imagen1[]='../../../images/domino/blanco.png';
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen1,'png');
			
			$imagen2[]='../../../images/domino/blanco.png';
			$imagen2[]='../../../temp/'.$file_name;
			$imagen2[]='../../../images/domino/blanco.png';
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen2,'png');
			
			$imagen3[]='../../../images/domino/blanco.png';
			$imagen3[]='../../../images/domino/blanco.png';
			$imagen3[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen3,'png');
			
			$url_filename='../../../temp/'.encadenar_imagenes(1,$url_imagen,'png');
			break;
			
			case 4:
			$imagen1[]='../../../temp/'.$file_name;
			$imagen1[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen1,'png');
			
			$imagen3[]='../../../temp/'.$file_name;
			$imagen3[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen3,'png');
			
			$url_filename='../../../temp/'.encadenar_imagenes(1,$url_imagen,'png');
			break;
			
			case 5:
			$imagen1[]='../../../temp/'.$file_name;
			$imagen1[]='../../../images/domino/blanco.png';
			$imagen1[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen1,'png');
			
			$imagen2[]='../../../images/domino/blanco.png';
			$imagen2[]='../../../temp/'.$file_name;
			$imagen2[]='../../../images/domino/blanco.png';
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen2,'png');
			
			$imagen3[]='../../../temp/'.$file_name;
			$imagen3[]='../../../images/domino/blanco.png';
			$imagen3[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen3,'png');
			
			$url_filename='../../../temp/'.encadenar_imagenes(1,$url_imagen,'png');
			break;
			
			case 6:
			$imagen1[]='../../../temp/'.$file_name;
			$imagen1[]='../../../images/domino/blanco.png';
			$imagen1[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen1,'png');
			
			$imagen2[]='../../../temp/'.$file_name;
			$imagen2[]='../../../images/domino/blanco.png';
			$imagen2[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen2,'png');
			
			$imagen3[]='../../../temp/'.$file_name;
			$imagen3[]='../../../images/domino/blanco.png';
			$imagen3[]='../../../temp/'.$file_name;
			$url_imagen[]='../../../temp/'.encadenar_imagenes(0,$imagen3,'png');
			
			$url_filename='../../../temp/'.encadenar_imagenes(1,$url_imagen,'png');
			break;
			
		}
	
	//REDUZCO LA IMAGEN A 500x500
	$pictograma->source_path = $url_filename;
	$pictograma->target_path = $url_filename;
	$pictograma->preserve_aspect_ratio = true;
	$pictograma->enlarge_smaller_images = true;
	$pictograma->preserve_time = true;
	$pictograma->resize(500,500);
				
	return $url_filename;

}
//*****************************************************************************************************************************************************
?>