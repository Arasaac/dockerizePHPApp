<?php
session_start();

$id_usuario=$_SESSION['ID_USER']; 

require('../funciones/funciones_herramientas.php');
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
$query=new query();
		
$dir="../../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_img=basename(tempnam("../../../temp",'TMP')); 


/***************************************************/
/*    RECOGO VALORES         */
/***************************************************/

$imagenes_insertar=$_POST['imagenes'];
$frase1=$_POST['frase'];
$frase=rand(100000000000,10000000000000000000).'_pruebas';
$salida=$_POST['salida'];
$pixels_final=(int)($_POST['pixels_final']);
$fuente_castellano=$_POST['fuente_castellano'];
$pixels_borde=$_POST['pixels_borde'];
$color_borde=$_POST['color_borde'];
$color_letra_superior=$_POST['color_sup'];
$marco=$_POST['marco'];
$pixels_lienzo=$_POST['pixels_lienzo'];
$sz_f_s=$_POST['sz_f_s'];
$sz_f_i=$_POST['sz_f_i'];
$inf_may=$_POST['inf_may'];
$sup_may=$_POST['sup_may'];
$color_sup=$_POST['color_sup'];
$color_inf=$_POST['color_inf'];
$sup_idioma=$_POST['sup_idioma'];
$inf_idioma=$_POST['inf_idioma'];
$fuente_pictogramas=$_POST['fuente_pictogramas'];
$size_font_pictos=$_POST['size_font_pictos'];
$pictos_may=$_POST['pictos_may'];
$filas=$_POST['filas'];
$columnas=$_POST['columnas'];

// ***************************************************************************************************
//    PROCESO LAS IMAGENES A INSERTAR
// ***************************************************************************************************

foreach ($_POST['thelist2'] as $indice=>$valor){ 
	
	$n_elementos=0;
	
	if ($valor > 0) { //Si el valor es numero es que tengo que añadir una imagen
	
	    $row=$query->datos_imagen($valor);
		$img_para_procesar[]="../../../repositorio/originales/".$row['imagen'];
	
	} else { // Si el valor no es número es que tengo que generar un pictograma con la palabra
	
		if ($pictos_may==1) {
			$texto=strtoupper_utf8($valor);
		} else { $texto=$valor; }
	
	    $img_para_procesar[]=generar_simbolos_solo_texto(500,500,$size_font_pictos,$color_sup,$fuente_pictogramas,'center',$texto,$salida);
	}
	
	$n_elementos++;

}

if ($filas==1 ) {
	$imagen_encadenada=encadenar_imagenes(0,$img_para_procesar,$salida);
} elseif ($filas>1) {

	$n_filas=$n_elementos/$columnas;
	$imgs_dividido=array_chunk($img_para_procesar,$columnas);

	$imagen_fila=array();
	
	for ($r=0;$r<$filas;$r++) { //genero cada fila
	
	  $imagen_fila[]='../../../temp/'.encadenar_imagenes(0,$imgs_dividido[$r],$salida);
	}
	
	$imagen_encadenada=encadenar_imagenes(1,$imagen_fila,$salida);

}
// ***************************************************************************************************
//    GESTIONO EL FORMATO DE SALIDA DEL ARCHIVO
// ***************************************************************************************************

	$frase_inicial='../../../temp/'.$imagen_encadenada;
	$ruta_img='size=450&ruta=../../../../temp/'.$imagen_encadenada;
	$ruta_cesto='ruta_cesto=../../../temp/'.$imagen_encadenada;
	$ruta=$imagen_encadenada;
	

/***************************************************/
/*    RECUPERO TAMAÑO IMAGEN			           */
/***************************************************/

switch ($salida) {

	case "gif":
	$source = imagecreatefromgif($frase_inicial); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "png":
	$source = imagecreatefrompng($frase_inicial); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;
	
	case "jpg":
	$source = imagecreatefromjpeg($frase_inicial); /* DEFINO EL ORIGEN DE LA IMAGEN COMO GIF */ 
	$imageX = imagesx($source); /* ALMACENO LA ANCHURA DE LA IMAGEN */
	$imageY = imagesy($source);  /* ALMACENO LA ALTURA DE LA IMAGEN */
	break;

}
/***************************************************/

/***************************************************/
/*    AMPLIAR EL LIENZO SI ES NECESARIO           */
/***************************************************/

if ($pixels_lienzo > 0) {
	DEFINE('SIMBOLO',$frase_inicial);
	$pixels=$pixels_lienzo;
	$graph = new Graph($imageX+$pixels,$imageY+$pixels);
	$graph->SetFrame(false);
	$graph->img->SetMargin(0,0,0,0);
	$graph->SetMarginColor('white');
	$graph->SetScale('linlin',0,100,0,100);
	// We don't want any axis to be shown
	$graph->xaxis->Hide();
	$graph->yaxis->Hide();
	$graph->SetBackgroundImage(SIMBOLO,BGIMG_CENTER);
	$graph->Stroke($frase_inicial);

}
/***************************************************/


// ***************************************************************************************************
//    LE PONGO TEXTO
// ***************************************************************************************************

if ($sup_idioma > 0 || $inf_idioma > 0) {

	if ($inf_may==1) {
		$frase1=strtoupper_utf8($frase1);
	}
	
	if ($sup_idioma==1 && $inf_idioma==0) {
		$ubicacion="top";
	} elseif ($sup_idioma==0 && $inf_idioma==1) {
		$ubicacion="bottom";
	} else {
		$ubicacion="bottom";
	}
	
	$timg = new ATextImage();
	$timg->SetBackground(255,255,255);
	$timg->CreateImage($frase_inicial);
	
	$wd=$imageX;       //width of blank image
	$ht=$imageY;       //height of blank image
	
	$sz=$sz_f_s;
	$hex1=substr($color_sup, 1);
	$color1=hex2rgb($hex1);
	
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_castellano.".ttf";
	
	$timg->SetFont($fnt1,$sz);
	$timg->SetTextColor($color1[0], $color1[1], $color1[2]);
	$timg->SetPos("center",$ubicacion,"center"); 
	
	$txt=stripslashes($frase1);
	$tx=explode("\n",$txt);
	
	 foreach($tx as $t)
	 {
		$timg->AddLine($t);
	 }
	 
	$timg->MakeImage($wd,$ht);

	switch ($salida) {
	
		case "gif":
		$timg->ShowGif($frase_inicial,"");
		break;
		
		case "png":
		$timg->ShowPng($frase_inicial,"");
		break;
		
		case "jpg":
		$timg->ShowJpg($frase_inicial,"");	
		break;
	
	}

}

// ***************************************************************************************************
//    LE PONGO MARCO EXTERIOR
// ***************************************************************************************************

	if ($marco == 1) {
		$frame = new FrameMaker();
		$frame->set_picture($frase_inicial);
		$frame->set_border($pixels_borde,$color_borde,"solid");
		$frame->set_path($frase_inicial);
		$frame->show_picture();
		$img = new Image_Toolbox($frase_inicial);
		if ($pixels_final != 0) { $img->newOutputSize($pixels_final,0,2,false,'#FFFFFF'); }
		$img->save($frase_inicial, $salida, '100'); 
	}

// ***************************************************************************************************
//    FINALMENTE MUESTRO EN PANTALLA EL RESULTADO FINAL
// ***************************************************************************************************

$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
$encript->encriptar($ruta_cesto,1);

	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../../images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="../../../inc/public/descargar.php?i='.$ruta.'""><img src=\'../../../images/download1.png\' border="0" alt="Descargar simbolo"></a>';
	
	echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Guardar Frase', '../gestionar_repositorio/mover_temp.php?img=".$ruta."&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../../images/filesave.png\" alt=\"Guardar Frase\" title=\"Guardar Frase\" border=\"0\"/></a>";
	
echo '<br><div align="center"><img src="../classes/img/thumbnail.php?i='.$ruta_img.'"><form id="img_subida" name="img_subida" method="post\ action=""></form></div><br/><br/><br/><br/><br/><br/>';
?>

