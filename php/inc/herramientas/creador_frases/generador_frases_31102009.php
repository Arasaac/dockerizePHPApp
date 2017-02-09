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
$frase_secciones=$_POST['frase_secciones'];
$frase1=$_POST['frase'];
$frase=rand(100000000000,10000000000000000000).'_pruebas';

/*    FILAS Y COLUMNAS        */

$filas=$_POST['filas'];
$columnas=$_POST['columnas'];

/*    LIENZO        */
$pixels_lienzo=$_POST['pixels_lienzo'];
$marco_lienzo=$_POST['marco_lienzo'];
$pixels_borde_lienzo=$_POST['pixels_borde_lienzo'];
$color_borde_lienzo=$_POST['color_borde_lienzo'];
$pixels_final_lienzo=(int)($_POST['pixels_final_lienzo']);

/*    FRASE        */
$posic_frase=$_POST['posic_frase'];
$fuente_frase=$_POST['fuente_frase'];
$size_font_frase=$_POST['size_font_frase'];
$may_frase=$_POST['may_frase'];
$color_frase=$_POST['color_frase'];

/***************************************************/
/*    SIMBOLOS        */
/***************************************************/

$fuente_simbolo=$_POST['fuente_simbolo'];

/*    SUPERIOR        */
$sup_idioma=$_POST['sup_idioma']; 
$sz_f_s=$_POST['sz_f_s'];
$sup_may=$_POST['sup_may'];
$color_sup=$_POST['color_sup'];

/*    INFERIOR        */
$inf_idioma=$_POST['inf_idioma'];
$sz_f_i=$_POST['sz_f_i'];
$inf_may=$_POST['inf_may'];
$color_inf=$_POST['color_inf'];

/*    PICTOGRAMAS SIN IMAGEN        */
$fuente_pictogramas=$_POST['fuente_pictogramas'];
$size_font_pictos=$_POST['size_font_pictos'];
$pictos_may=$_POST['pictos_may'];

/*    MARCO EXTERIOR SIMBOLOS        */
$marco_simbolo=$_POST['marco_simbolo'];
$grosor_borde_simbolo=$_POST['grosor_borde_simbolo'];
$color_borde_simbolo=$_POST['color_borde_simbolo'];
$color_predeterminado=$_POST['color_predeterminado_marco_simbolo'];

/*    LIENZO SIMBOLOS        */
$pixels_lienzo_simbolo=$_POST['pixels_lienzo_simbolo'];

/*    ACCIONES SOBRE SIMBOLOS        */
$accion=$_POST['accion'];
$color_contraste=$_POST['color_contraste'];

/***************************************************/
/*    SALIDA       */
/***************************************************/
$salida=$_POST['salida'];
$simbolo=1;

// ***************************************************************************************************
//    PROCESO LA FRASE EN SECCIONES
// ***************************************************************************************************
foreach ($_POST['thelist3'] as $indice=>$valor){ 
	$palabra_seccion[]=$valor;
}
// ***************************************************************************************************
//    PROCESO LAS IMAGENES A INSERTAR
// ***************************************************************************************************

$n_elementos=0;
	
foreach ($_POST['thelist2'] as $indice=>$valor){ 

	if ($valor > 0) { //Si el valor es numero es que tengo que añadir una imagen
	
	    $row=$query->datos_imagen($valor);
		
		if ($color_predeterminado==0) {
			$color_borde=color_borde_por_tipo_de_palabra($row['id_tipo_palabra']);
		} elseif ($color_predeterminado==1) {
			$color_borde=$color_borde_simbolo;
		} else {
			$color_borde=color_borde_por_tipo_de_palabra($row['id_tipo_palabra']);
		}
		
		if ($simbolo==1) {
			$pixels_simbolo_final=500;
			
			$nombre_img=basename(tempnam("../../../temp",'TMP')); 
			$extension_img_original = strtolower(substr(strrchr("../../../repositorio/originales/".$row['imagen'], "."), 1));
			copy("../../../repositorio/originales/".$row['imagen'], "../../../temp/COPIA_".$nombre_img.".".$extension_img_original);
			$imagen_original="../../../temp/COPIA_".$nombre_img.".".$extension_img_original;
			
			$img_para_procesar[]=crear_pictograma($imagen_original,$accion,$fuente_simbolo,$pixels_lienzo_simbolo,$pixels_simbolo_final,$grosor_borde_simbolo,$color_borde,$color_contraste,$id_traduccion,$palabra_seccion[$n_elementos],$sup_idioma,$inf_idioma,$sup_may,$inf_may,$sz_f_s,$color_sup,$color_inf,$sz_f_i,$marco_simbolo);
		
		} else {
			$img_para_procesar[]="../../../repositorio/originales/".$row['imagen'];
		}
	
	} else { // Si el valor no es número es que tengo que generar un pictograma con la palabra
	
		if ($pictos_may==1) {
			$texto=strtoupper_utf8($valor);
		} else { $texto=$valor; }
	
			if ($simbolo==1) {
				$pictograma_generado=generar_simbolos_solo_texto(500,500,$size_font_pictos,$color_sup,$fuente_pictogramas,'center',$texto,$salida);
				$img_para_procesar[]=crear_pictograma($pictograma_generado,$accion,$fuente_simbolo,$pixels_lienzo_simbolo,500,$grosor_borde_simbolo,$color_borde_simbolo,$color_contraste,$id_traduccion,$palabra_seccion[$n_elementos],$sup_idioma,$inf_idioma,$sup_may,$inf_may,$sz_f_s,$color_sup,$color_inf,$sz_f_i,$marco_simbolo);
			} else {
				$img_para_procesar[]=generar_simbolos_solo_texto(500,500,$size_font_pictos,$color_sup,$fuente_pictogramas,'center',$texto,$salida);
			}
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
	$ruta_cesto='ruta_cesto=temp/'.$imagen_encadenada;
	$ruta=$imagen_encadenada;
	$ruta_descarga='img=../../temp/'.$imagen_encadenada;
	

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
	
	switch ($salida) {

		case "gif":
		$img = new Image_Toolbox($frase_inicial);
		$img->save($frase_inicial, 'gif', '100'); 
		break;
		
		case "png":
		$img = new Image_Toolbox($frase_inicial);
		$img->save($frase_inicial, 'png', '100'); 
		break;
		
		case "jpg":
		$img = new Image_Toolbox($frase_inicial);
		$img->save($frase_inicial, 'jpg', '100'); 
		break;

	}

}
/***************************************************/


// ***************************************************************************************************
//    LE PONGO TEXTO
// ***************************************************************************************************

if ($posic_frase > 0) {

	if ($may_frase==1) {
		$frase1=strtoupper_utf8($frase1);
	}
	
	if ($posic_frase==1) {
		$ubicacion="top";
	} elseif ($posic_frase==2) {
		$ubicacion="bottom";
	} 
	
	$timg = new ATextImage();
	$timg->SetBackground(255,255,255);
	$timg->CreateImage($frase_inicial);
	
	$wd=$imageX;       //width of blank image
	$ht=$imageY;       //height of blank image
	
	$sz=$size_font_frase;
	$hex1=substr($color_frase, 1);
	$color1=hex2rgb($hex1);
	
	$fnt1="../../../plugins/html2ps/fonts/".$fuente_frase.".ttf";
	
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

	if ($marco_lienzo == 1) {
		$frame = new FrameMaker();
		$frame->set_picture($frase_inicial);
		$frame->set_border($pixels_borde_lienzo,$color_borde_lienzo,"solid");
		$frame->set_path($frase_inicial);
		$frame->show_picture();
	}


	if ($pixels_final_lienzo != 0) { 
		$img = new Image_Toolbox($frase_inicial);
		$img->newOutputSize($pixels_final_lienzo,0,0,false,'#FFFFFF'); 
		$img->save($frase_inicial,false,'100');
	}

// ***************************************************************************************************
//    GENERO UNA MINIATURA PARA MOSTRAR
// ***************************************************************************************************

		$img = new Image_Toolbox($frase_inicial);
		$img->newOutputSize(500,0,0,false,'#FFFFFF'); 
		$nombre_thumbnail=basename(tempnam("../../../temp",'TMP')); 
		$new_name='../../../temp/' . $nombre_thumbnail . '.'.$salida;
		$img->save($new_name,false,'100');
  	
// ***************************************************************************************************
//    FINALMENTE MUESTRO EN PANTALLA EL RESULTADO FINAL
// **************************************************************************************************

	$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
	$encript->encriptar($ruta_cesto,1);
	$encript->encriptar($ruta_descarga,1);

	echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../../images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="../../../inc/public/descargar.php?i='.$ruta_descarga.'""><img src=\'../../../images/download1.png\' border="0" alt="Descargar simbolo"></a>';
	
	if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
		echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Guardar Frase', '../gestionar_repositorio/mover_temp.php?img=".$ruta."&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../../images/filesave.png\" alt=\"Guardar Frase\" title=\"Guardar Frase\" border=\"0\"/></a>";
	}
	
	echo '<br><div align="center"><img src='.$new_name.'></div><br/><br/><br/><br/><br/><br/>';
	
	echo '<input type="hidden" tabindex="1" id="ur" name="URL" size="30" value="http://195.55.130.137/arasaac/inc/herramientas/creador_frases/imprimir_frase.php?img='.$frase_inicial.'"/>';
?>

