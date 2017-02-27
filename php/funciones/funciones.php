<?php
/*****************************************************************************************************************/
/*    FUNCION PARA SABER SI UN NUMERO ES PAR   */
/******************************************************************************************************************/ 
function esPar($numero){ 
   $resto = $numero%2; 
   if (($resto==0) && ($numero!=0)) { 
        return true; 
   } else{ 
        return false; 
   }
}

/*****************************************************************************************************************/
/*    FUNCION PARA REEMPLAZAR ACENTOS  */
/******************************************************************************************************************/ 
function replaceAccents($string){ 
$GLOBALS['normalizeChars'] = array( 
    'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o',  
    'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'i', 'ÿ'=>'i', 'À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Ç'=>'c', 'È'=>'e', 'É'=>'e', 'Ê'=>'e', 'Ë'=>'e', 'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i',  
    'Ñ'=>'n', 'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u', 'Ý'=>'i' 
    ); 
return strtr($string,$GLOBALS['normalizeChars']); 
}
/*****************************************************************************************************************/
/*    FUNCION PARA CALCULAR A QUE DIA DE LA SEMANA CORRESPONDE UNA FECHA   */
/******************************************************************************************************************/
function calcula_numero_dia_semana($dia,$mes,$ano){ 
   	$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano)); 
   	if ($numerodiasemana == 0) 
      	 $numerodiasemana = 6; 
   	else 
      	 $numerodiasemana--; 
   	return $numerodiasemana; 
} 

/*****************************************************************************************************************/
/*    FUNCION PARA CALCULAR CUAL ES EL ULTIMO DIA DE UN MES   */
/******************************************************************************************************************/
function ultimoDia($mes,$ano){ 
   	$ultimo_dia=28; 
   	while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
      	 $ultimo_dia++; 
   	} 
   	return $ultimo_dia; 
}

/*****************************************************************************************************************/
/*    FUNCION PARA RESALTAR UNA LETRA O APALBRA DENTRO DE UNA CADENA  */
/******************************************************************************************************************/
    //$sentence is the sentence that you are looking for
    //$rech is the word you searching in the sentence
	function normaliza($cadena){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
	ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
	bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		//$cadena = strtolower($cadena);
		return utf8_encode($cadena);
	}

    //$sentence is the sentence that you are looking for
    //$rech is the word you searching in the sentence
	function CheckSentence($sentence,$rech,$estilo)
	{	
		$sentence_original=$sentence;
		$rech_original=$rech;
		
		$sentence=normaliza($sentence);
		$rech=normaliza($rech);
		
		$len = strlen($rech);
		
		if ($len != 0) 
		{
			$find = $sentence;
		
			while ($find = stristr($find, $rech)) // find $search text - case insensitiv
			{	
				$txt = substr($find, 0, $len);	// get new search text 
				$find = substr($find, $len);
				
				$len_original = strlen($rech_original);
				$txt_original = substr($sentence_original,0,$len_original+1);	// get new search text 
				
				if (strtolower($rech_original)==strtolower($rech)) {
				
				$subject1 = str_replace($txt,$txt,$sentence);
					
					if ($sentence_original==$subject1) {
						$subject = str_replace($txt, "<font style='".$estilo."'>" . $rech_original ."</font>", $sentence);
					} else {
						$subject = str_replace($txt, "<font style='".$estilo."'>" . $txt_original ."</font>", $sentence);
						
					}
				} elseif (strtolower($rech_original)!=strtolower($rech)) {
					
					$subject1 = str_replace($txt,$rech_original,$sentence);
					
					if ($sentence_original==$subject1) {
						$subject = str_replace($txt, "<font style='".$estilo."'>" . $rech_original ."</font>", $sentence);
					} else {
						$subject = str_replace($txt, "<font style='".$estilo."'>" . $txt ."</font>", $sentence);
						
					}
					
				}
				
			}
		}			
		// depend what you need. i used a return just for the demo page
        return @$subject ;
        //echo $subject ;
	}
/*****************************************************************************************************************/
/*    FUNCION PARA BORRAR DE FORMA RECURSIVA  */
/******************************************************************************************************************/
function rmdir_recurse($path)
{
    $path= rtrim($path, '/').'/';
    $handle = opendir($path);
    for (;false !== ($file = readdir($handle));)
        if($file != "." and $file != ".." )
        {
            $fullpath= $path.$file;
            if(is_dir($fullpath) )
            {
                rmdir_recurse($fullpath);
                rmdir($fullpath);
            }
            else
              unlink($fullpath);
        }
    closedir($handle);
}

/*****************************************************************************************************************/
/*    FUNCION PARA TRANSFORMAR EN MAYUSCULAS CARACTERES CON ACENTOS Y EÑES EN UTF-8 (UTILIZADO LOS SIMBOLOS)  */
/******************************************************************************************************************/

function strtoupper_utf8($string){
    //$string=utf8_decode($string);
    $string=mb_strtoupper($string,'UTF-8'); // importante utilizar la funcion mb_strtoupper porque strtoupper no funcionaba en el servidor aunque si en local
    //$string=utf8_encode($string);
    return $string;
}

function strtolower_utf8($string){
    //$string=utf8_decode($string);
    $string=mb_strtolower($string,'UTF-8'); // importante utilizar la funcion mb_strtolower porque strtoupper no funcionaba en el servidor aunque si en local
    //$string=utf8_encode($string);
    return $string;
}

/******************************************************************************************************************/

function recursive_dirlist($base_dir)
{
global $getDirList_alldirs,$getDirList_allfiles;
   function getDirList($base)
   {
   global $getDirList_alldirs,$getDirList_allfiles;
   if(is_dir($base))
       {
           $dh = opendir($base);
       while (false !== ($dir = readdir($dh)))
           {
           if (is_dir($base ."/". $dir) && $dir !== '.' && $dir !== '..') //note the change in this line
               {
                   $subs = $dir    ;
                   $subbase = $base ."/". $dir;//note the change in this line
                   $getDirList_alldirs[]=$subbase;
                   getDirList($subbase);
               }
           elseif(is_file($base ."/". $dir) && $dir !== '.' && $dir !== '..')//change in this line too
               {
               $getDirList_allfiles[]=$base ."/". $dir;//change in this line too
               }
           }
           closedir($dh);
       }
   }

getDirList($base_dir);
$retval['dirs']=$getDirList_alldirs;
$retval['files']=$getDirList_allfiles;
return $retval;
}

/******************************************************************************************************************/

function imagenes_disponibes($tipos_imagen,$query,$id_palabra,$encript) {

require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

while ($salida=mysql_fetch_array($tipos_imagen)) {

$img_disponibles=$query->imagenes_disponibles_tipo($id_palabra,$salida['id_tipo']);
$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {

	$resultados.='<b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	
		while ($row=mysql_fetch_array($img_disponibles)) {
			$img[]=$row['imagen'];
		}

	$resultados.='<div style="width:100%;"><table class=\"tabla_img\">';
	
		for ($i=1; $i<=10; $i++){ // FILAS
			$resultados.="<tr>"; 
				for ($e=1; $e<=5; $e++){ //COLUMNAS
				
					$file=$img[$o];
					
					$ruta_img='size=50&ruta=../../repositorio/originales/'.$file;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					if ($file=="") { break; }
					
					 $ruta_creador='img=repositorio/originales/'.$file.'&id_palabra='.$row['id_palabra'];
			  		 $encript->encriptar($ruta_creador,1); 
			  
					$resultados.="<td width=\"25%\" class=\"tabla_img\" style=\"padding:15px;\"><div align=\"center\">
					<a href=\"inc/herramientas/creador_simbolos/creador_simbolos.php?i=".$ruta_creador."\" onclick=\"return GB_showFullScreen('Creador de Simbolos', this.href)\">
					<img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" alt=\"Imagen: ".$file."\" border=\"0\"/>
					</a></div></td>"; 
					$o++; 
				} 
			$resultados.="</tr>"; 
		} 
	$resultados.='</table></div></div>';

	} // Cierro el IF de comprobacion de si hay resultados


} // Cierro el While 

return $resultados;
}

function imagenes_simbolos_disponibes_por_tag($query,$tag,$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn) {

require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

while ($salida=mysql_fetch_array($tipos_imagen)) {

if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
	$img_disponibles=$query->imagenes_disponibles_tipo_por_tag($tag,$salida['id_tipo']);
} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
	$img_disponibles=$query->imagenes_disponibles_idioma_tipo_por_tag($tag,$salida['id_tipo'],$_SESSION['id_language']);
}

$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {

	if ($salida['ext']=='flv') { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' video/s)</b><hr>';
	} else { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	}
	
		while ($row=mysql_fetch_array($img_disponibles)) {

			if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
			
				$resultados.='<ul id="thelist6">';
				
				$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
				$encript->encriptar($ruta_cesto,1);
				
				$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
				$encript->encriptar($ruta,1);
							
				$resultados.='<li><object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					<param name="wmode" value="transparent">
					<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				   </object>
						<br />
						<b>';
					
					if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
						$resultados.=utf8_encode($row['palabra']);
					} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
						$resultados.=$row['traduccion'];
					}
					
					$resultados.='</b><br><a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/video_acepcion_lse.php?i='.$row['id_imagen'].'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src=\'images/search.png\' border="0" alt="Ampliar informaci�n de la acepci�n" title="Ampliar informaci�n de la acepci�n"></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir video a mi cesto" title="a&ntilde;adir video a mi cesto"></a>&nbsp;&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src=\'images/icono_lse_16x16.jpg\' border="0" alt="Ver acepcion en tama�o original" title="Ver acepcion en tama�o original"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar video"></a></li>';
			
			} else { //Para el resto de tipos de Originales
			
				$resultados.='<ul id="thelist3">';
						
					
							$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							
							$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
							$encript->encriptar($ruta,1);
							
							$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_cesto,1);
							
							 $ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
							 $encript->encriptar($ruta_creador,1); 
						
						$resultados.='<li>
						<a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/imagen.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a><br />
						<b>';
					
					if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
						$resultados.=utf8_encode($row['palabra']);
					} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
						$resultados.=$row['traduccion'];
					}
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></li>'; 
						
			}		

		}
		
	$resultados.='</ul></td></tr>';

	} 
$resultados.='</table></div>';
	
} // Cierro el While 


if ($simbolos==1) {
		
		if (!isset($_SESSION['tipo_letra'])) {
			$tipo_letra=99; 
		} else { $tipo_letra=$_SESSION['tipo_letra']; }
		
		if (!isset($_SESSION['id_tipo'])) {
			$id_tipo=99; 
		} else { $id_tipo=$_SESSION['id_tipo']; }
		
		if (!isset($_SESSION['id_tipo_simbolo'])) {
			$id_tipo_simbolo=99; 
		} else { $id_tipo_simbolo=$_SESSION['id_tipo_simbolo'];}
		
		if (!isset($_SESSION['marco'])) {
			$marco=99; 
		} else { $marco=$_SESSION['marco']; }
		
		if (!isset($_SESSION['contraste'])) {
			$contraste=99; 
		} else { $contraste=$_SESSION['contraste']; }
		
		if (!isset($_SESSION['mayusculas'])) {
			$mayusculas=0; 
		} else { $mayusculas=$_SESSION['mayusculas']; }
		
		if (!isset($_SESSION['minusculas'])) {
			$minusculas=0; 
		} else { $minusculas=$_SESSION['minusculas']; }

		if (!isset($_SESSION['castellano'])) {
			$castellano=0; 
		} else { $castellano=$_SESSION['castellano']; }
		
		if (!isset($_SESSION['ruso'])) {
			$ruso=0; 
		} else { $ruso=$_SESSION['ruso']; }
		
		if (!isset($_SESSION['rumano'])) {
			$rumano=0; 
		} else { $rumano=$_SESSION['rumano']; }
		
		if (!isset($_SESSION['arabe'])) {
			$arabe=0; 
		} else { $arabe=$_SESSION['arabe']; }
		
		if (!isset($_SESSION['chino'])) {
			$chino=0; 
		} else { $chino=$_SESSION['chino']; }
		
		if (!isset($_SESSION['bulgaro'])) {
			$bulgaro=0; 
		} else { $bulgaro=$_SESSION['bulgaro']; }
		
		if (!isset($_SESSION['polaco'])) {
			$polaco=0; 
		} else { $polaco=$_SESSION['polaco']; }
		
		if (!isset($_SESSION['ingles'])) {
			$ingles=0; 
		} else { $ingles=$_SESSION['ingles']; }
		
		if (!isset($_SESSION['frances'])) {
			$frances=0; 
		} else { $frances=$_SESSION['frances']; }
		
		if (!isset($_SESSION['catalan'])) {
			$catalan=0; 
		} else { $catalan=$_SESSION['catalan']; }
		
		
		$listado_simbolos=$query->simbolos_por_tag_con_filtro($tag,$id_tipo,$id_tipo_simbolo,false,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan); 
		
		//$listado_simbolos=$query->simbolos_por_palabra($palabra,false); 
		$num_resultados_simbolos=mysql_num_rows($listado_simbolos);
		
			if ($num_resultados_simbolos > 0) {
			
				$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
				$resultados.='<tr><td><b>Simbolos ('.$num_resultados_simbolos.' simbolo/s)</b><hr>';
				$resultados.='<ul id="thelist3">';
				
				while ($row=mysql_fetch_array($listado_simbolos)) {
				
					$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
				
					$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_simbolo='.$row['id_simbolo'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_cesto,1);
					
					$resultados.='<li> <a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/simbolo.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Image" border="0" class="image" title="'.utf8_encode($row['palabra']).': ';
					if (strlen($row['definicion']) > 100) { $resultados.=substr (utf8_encode($row['definicion']), 0, 100)."..."; } else {$resultados.=utf8_encode($row['definicion']); }  
					$resultados.='" /></a><br />';
					$resultados.='<div id="products"><b>';
			  		if (strlen($row['palabra']) > 15) { $resultados.=substr(utf8_encode($row['palabra']),0,15).".."; } else {  $resultados.=utf8_encode($row['palabra']);  }
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto">&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar S�mbolo" title="Descargar S�mbolo"></a></div></li>';
					
					
				
				}				
				
				$resultados.='</ul></td></tr>';
				$resultados.='</table></div>';
				
			
			}
		
	
	}
	
return $resultados;
}



function imagenes_simbolos_disponibes_por_palabra($query,$palabra,$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn) {

require ('../../classes/highlight/highlight.class.php'); 
$resaltar = new Highlighter();

require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);


$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

while ($salida=mysql_fetch_array($tipos_imagen)) {

if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
	$img_disponibles=$query->imagenes_disponibles_tipo_por_palabra($palabra,$salida['id_tipo']);
} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
	$img_disponibles=$query->imagenes_disponibles_idioma_tipo_por_palabra($palabra,$salida['id_tipo'],$_SESSION['id_language']);
}

$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {

	if ($salida['ext']=='flv') { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' video/s)</b><hr>';
	} else { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	}
	
		while ($row=mysql_fetch_array($img_disponibles)) {

			if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
			
				$resultados.='<ul id="thelist6">';
				
				$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
				$encript->encriptar($ruta_cesto,1);
				
				$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
				$encript->encriptar($ruta,1);
							
				$resultados.='<li>
						<object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					 <param name="wmode" value="transparent">
					<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				   </object><br />
						<b>';
						
						if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
							$resultados.=$resaltar->CheckSentence(utf8_encode($row['palabra']),$palabra);
						} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
							$resultados.=$resaltar->CheckSentence($row['traduccion'], $palabra);
						}
					
					$resultados.='</b><br><a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/video_acepcion_lse.php?i='.$row['id_imagen'].'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src=\'images/search.png\' border="0" alt="Ampliar informaci�n de la acepci�n" title="Ampliar informaci�n de la acepci�n"></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir video a mi cesto" title="a&ntilde;adir video a mi cesto"></a>&nbsp;&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src=\'images/icono_lse_16x16.jpg\' border="0" alt="Ver acepcion en tama�o original" title="Ver acepcion en tama�o original"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar video"></a></li>';
			
			} else { //Para el resto de tipos de Originales
		
				$resultados.='<ul id="thelist3">';
						
					
							$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							
							$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
							$encript->encriptar($ruta,1);
							
							$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_cesto,1);
							
							$ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
							$encript->encriptar($ruta_creador,1); 
						
						$resultados.='<li>
						<a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/imagen.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a><br />
						<b>';
						
						if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
							$resultados.=$resaltar->CheckSentence(utf8_encode($row['palabra']), $palabra);
						} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
							$resultados.=$resaltar->CheckSentence($row['traduccion'], $palabra);
						}
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></li>';
						 
			}		

		}
		
	$resultados.='</ul></td></tr>';

	} 
$resultados.='</table></div>';
	
} // Cierro el While 

if ($simbolos==1) {
		
		if (!isset($_SESSION['tipo_letra'])) {
			$tipo_letra=99; 
		} else { $tipo_letra=$_SESSION['tipo_letra']; }
		
		if (!isset($_SESSION['id_tipo'])) {
			$id_tipo=99; 
		} else { $id_tipo=$_SESSION['id_tipo']; }
		
		if (!isset($_SESSION['id_tipo_simbolo'])) {
			$id_tipo_simbolo=99; 
		} else { $id_tipo_simbolo=$_SESSION['id_tipo_simbolo'];}
		
		if (!isset($_SESSION['marco'])) {
			$marco=99; 
		} else { $marco=$_SESSION['marco']; }
		
		if (!isset($_SESSION['contraste'])) {
			$contraste=99; 
		} else { $contraste=$_SESSION['contraste']; }
		
		if (!isset($_SESSION['mayusculas'])) {
			$mayusculas=0; 
		} else { $mayusculas=$_SESSION['mayusculas']; }
		
		if (!isset($_SESSION['minusculas'])) {
			$minusculas=0; 
		} else { $minusculas=$_SESSION['minusculas']; }

		if (!isset($_SESSION['castellano'])) {
			$castellano=0; 
		} else { $castellano=$_SESSION['castellano']; }
		
		if (!isset($_SESSION['ruso'])) {
			$ruso=0; 
		} else { $ruso=$_SESSION['ruso']; }
		
		if (!isset($_SESSION['rumano'])) {
			$rumano=0; 
		} else { $rumano=$_SESSION['rumano']; }
		
		if (!isset($_SESSION['arabe'])) {
			$arabe=0; 
		} else { $arabe=$_SESSION['arabe']; }
		
		if (!isset($_SESSION['chino'])) {
			$chino=0; 
		} else { $chino=$_SESSION['chino']; }
		
		if (!isset($_SESSION['bulgaro'])) {
			$bulgaro=0; 
		} else { $bulgaro=$_SESSION['bulgaro']; }
		
		if (!isset($_SESSION['polaco'])) {
			$polaco=0; 
		} else { $polaco=$_SESSION['polaco']; }
		
		if (!isset($_SESSION['ingles'])) {
			$ingles=0; 
		} else { $ingles=$_SESSION['ingles']; }
		
		if (!isset($_SESSION['frances'])) {
			$frances=0; 
		} else { $frances=$_SESSION['frances']; }
		
		if (!isset($_SESSION['catalan'])) {
			$catalan=0; 
		} else { $catalan=$_SESSION['catalan']; }
		
		$listado_simbolos=$query->simbolos_por_palabra_con_filtro($palabra,$id_tipo,$id_tipo_simbolo,false,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan); 
		
		//$listado_simbolos=$query->simbolos_por_palabra($palabra,false); 
		$num_resultados_simbolos=mysql_num_rows($listado_simbolos);
		
			if ($num_resultados_simbolos > 0) {
			
				$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
				$resultados.='<tr><td><b>Simbolos ('.$num_resultados_simbolos.' simbolo/s)</b><hr>';
				$resultados.='<ul id="thelist3">';
				
				while ($row=mysql_fetch_array($listado_simbolos)) {
				
					$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
				
					$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_simbolo='.$row['id_simbolo'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_cesto,1);
					
					$resultados.='<li> <a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/simbolo.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Image" border="0" class="image" title="'.utf8_encode($row['palabra']).': ';
					if (strlen($row['definicion']) > 100) { $resultados.=substr (utf8_encode($row['definicion']), 0, 100)."..."; } else {$resultados.=utf8_encode($row['definicion']); }  
					$resultados.='" /></a><br />';
					$resultados.='<div id="products"><b>';
			  		if (strlen($row['palabra']) > 15) { $resultados.=substr($resaltar->CheckSentence(utf8_encode($row['palabra']), $palabra),0,15).".."; } else {  $resultados.=$resaltar->CheckSentence(utf8_encode($row['palabra']),$palabra);  }
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto">&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar S�mbolo" title="Descargar S�mbolo"></a></div></li>';
					
					
				
				}				
				
				$resultados.='</ul></td></tr>';
				$resultados.='</table></div>';
				
			
			}
		
	
	}
	
return $resultados;
}


function imagenes_simbolos_disponibes_por_palabra_exacta($query,$palabra,$pictogramas_color,$pictogramas_byn,$fotografia,$simbolos,$videos_lse,$lse_color,$lse_byn) {

require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);


$tipos_imagen=$query->listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn);

while ($salida=mysql_fetch_array($tipos_imagen)) {

if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
	$img_disponibles=$query->imagenes_disponibles_tipo($palabra,$salida['id_tipo']);
} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
	$img_disponibles=$query->imagenes_disponibles_idioma_tipo($palabra,$salida['id_tipo'],$_SESSION['id_language']);
}
$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {
	
	if ($salida['ext']=='flv') { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' video/s)</b><hr>';
	} else { 
		$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	}
		while ($row=mysql_fetch_array($img_disponibles)) {

		if ($salida['id_tipo']==11) { //Si el tipo de original es Video de Acepciones en LSE
		
			$resultados.='<ul id="thelist6">';
			
			$ruta_cesto='ruta_cesto=repositorio/LSE_acepciones/'.$row['imagen'];
			$encript->encriptar($ruta_cesto,1);
			
			$ruta='img=../../repositorio/LSE_acepciones/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
			$encript->encriptar($ruta,1);
						
			$resultados.='<li>
					<object id="'.$row['id_imagen'].'" width="110" height="125" data="plugins/flowplayer/flowplayer-3.1.1.swf"  
					type="application/x-shockwave-flash"> 
					<param name="wmode" value="transparent">
					<param name="movie" value="plugins/flowplayer/flowplayer-3.1.1.swf" />  
					<param name="allowfullscreen" value="true" /> 
					<param name="flashvars"  
						value=\'config={"clip": { "url": "repositorio/LSE_acepciones/'.$row['imagen'].'", "bufferLength": 2, "autoBuffering": true,
							"autoPlay": false, "scaling": "fit"}, "play": {"replayLabel": "Repetir" }, "plugins": { "controls": {"volume": false, "mute": false, "time":false, "height":15, "backgroundColor": "#FFFFFF", "progressColor": "#000000", "bufferColor": "#CCCCCC" } }  }\' /> 
				   </object><br />
					<b>';
					
					if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
						$resultados.=utf8_encode($row['palabra']);
					} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
						$resultados.=$row['traduccion'];
					}
					
					$resultados.='</b><br><a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/video_acepcion_lse.php?i='.$row['id_imagen'].'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src=\'images/search.png\' border="0" alt="Ampliar informaci�n de la acepci�n" title="Ampliar informaci�n de la acepci�n"></a>&nbsp;&nbsp;<a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir video a mi cesto" title="a&ntilde;adir video a mi cesto"></a>&nbsp;&nbsp;<a href="javascript:MM_openBrWindow(\'inc/public/ver_acepcion.php?i='.$row['id_imagen'].'\',\'\',\'location=no,scrollbars=yes,resizable=no,width=710,height=730\')"><img src=\'images/icono_lse_16x16.jpg\' border="0" alt="Ver acepcion en tama�o original" title="Ver acepcion en tama�o original"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar video"></a></li>';
		
		} else { //Para el resto de tipos de Originales
		
			$resultados.='<ul id="thelist3">';
					
				
						$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
						
						$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
						$encript->encriptar($ruta,1);
						
						$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
						$encript->encriptar($ruta_cesto,1);
						
						$ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  			$encript->encriptar($ruta_creador,1); 
					
					$resultados.='<li>
					<a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/imagen.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a><br />
					<b>';
					
					if ($_SESSION['language']=='es' && $_SESSION['id_language']==0) {
						$resultados.=utf8_encode($row['palabra']);
					} elseif ($_SESSION['language']!='es' && $_SESSION['id_language']>0) {
						$resultados.=$row['traduccion'];
					}
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></li>';
			} 
					

		}
		
	$resultados.='</ul></td></tr>';

	} 
$resultados.='</table></div>';

} // Cierro el While 

	if ($simbolos==1) {
		
		if (!isset($_SESSION['tipo_letra'])) {
			$tipo_letra=99; 
		} else { $tipo_letra=$_SESSION['tipo_letra']; }
		
		if (!isset($_SESSION['id_tipo'])) {
			$id_tipo=99; 
		} else { $id_tipo=$_SESSION['id_tipo']; }
		
		if (!isset($_SESSION['id_tipo_simbolo'])) {
			$id_tipo_simbolo=99; 
		} else { $id_tipo_simbolo=$_SESSION['id_tipo_simbolo'];}
		
		if (!isset($_SESSION['marco'])) {
			$marco=99; 
		} else { $marco=$_SESSION['marco']; }
		
		if (!isset($_SESSION['contraste'])) {
			$contraste=99; 
		} else { $contraste=$_SESSION['contraste']; }
		
		if (!isset($_SESSION['mayusculas'])) {
			$mayusculas=0; 
		} else { $mayusculas=$_SESSION['mayusculas']; }
		
		if (!isset($_SESSION['minusculas'])) {
			$minusculas=0; 
		} else { $minusculas=$_SESSION['minusculas']; }

		if (!isset($_SESSION['castellano'])) {
			$castellano=0; 
		} else { $castellano=$_SESSION['castellano']; }
		
		if (!isset($_SESSION['ruso'])) {
			$ruso=0; 
		} else { $ruso=$_SESSION['ruso']; }
		
		if (!isset($_SESSION['rumano'])) {
			$rumano=0; 
		} else { $rumano=$_SESSION['rumano']; }
		
		if (!isset($_SESSION['arabe'])) {
			$arabe=0; 
		} else { $arabe=$_SESSION['arabe']; }
		
		if (!isset($_SESSION['chino'])) {
			$chino=0; 
		} else { $chino=$_SESSION['chino']; }
		
		if (!isset($_SESSION['bulgaro'])) {
			$bulgaro=0; 
		} else { $bulgaro=$_SESSION['bulgaro']; }
		
		if (!isset($_SESSION['polaco'])) {
			$polaco=0; 
		} else { $polaco=$_SESSION['polaco']; }
		
		if (!isset($_SESSION['ingles'])) {
			$ingles=0; 
		} else { $ingles=$_SESSION['ingles']; }
		
		if (!isset($_SESSION['frances'])) {
			$frances=0; 
		} else { $frances=$_SESSION['frances']; }
		
		if (!isset($_SESSION['catalan'])) {
			$catalan=0; 
		} else { $catalan=$_SESSION['catalan']; }
		
		$listado_simbolos=$query->simbolos_por_id_palabra_con_filtro($palabra,$id_tipo,$id_tipo_simbolo,false,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan); 
		
		//$listado_simbolos=$query->simbolos_por_palabra($palabra,false); 
		$num_resultados_simbolos=mysql_num_rows($listado_simbolos);
		
			if ($num_resultados_simbolos > 0) {
			
				$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
				$resultados.='<tr><td><b>Simbolos ('.$num_resultados_simbolos.' simbolo/s)</b><hr>';
				$resultados.='<ul id="thelist3">';
				
				while ($row=mysql_fetch_array($listado_simbolos)) {
				
					$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
				
					$ruta='img=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'].'&id_simbolo='.$row['id_simbolo'];
					$encript->encriptar($ruta,1);
					
					$ruta_img='size=50&ruta=../../repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
					$ruta_cesto='ruta_cesto=repositorio/simbolos/fuente/'.$folder.'/'.$row['id_simbolo'].'.'.$row['ext'];
					$encript->encriptar($ruta_cesto,1);
					
					$resultados.='<li> <a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/simbolo.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Image" border="0" class="image" title="'.utf8_encode($row['palabra']).': ';
					if (strlen($row['definicion']) > 100) { $resultados.=substr (utf8_encode($row['definicion']), 0, 100)."..."; } else {$resultados.=utf8_encode($row['definicion']); }  
					$resultados.='" /></a><br />';
					$resultados.='<div id="products"><b>';
			  		if (strlen($row['palabra']) > 15) { $resultados.=substr(utf8_encode($row['palabra']),0,15).".."; } else {  $resultados.=utf8_encode($row['palabra']);  }
					
					$resultados.='</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto" title="a&ntilde;adir imagen a mi cesto">&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar S�mbolo" title="Descargar S�mbolo"></a></div></li>';
					
					
				
				}				
				
				$resultados.='</ul></td></tr>';
				$resultados.='</table></div>';
				
			
			}
		
	
	}

return $resultados;
}

function imagenes_simbolos_disponibes($query,$id_palabra) {

require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

$tipos_imagen=$query->listar_tipos_imagen();

while ($salida=mysql_fetch_array($tipos_imagen)) {

$img_disponibles=$query->imagenes_disponibles_tipo($id_palabra,$salida['id_tipo']);
$num_resultados=mysql_num_rows($img_disponibles);

// Inicializo las variables
$o=0;
$img=array();
$file='';

$resultados.='<div style="width:100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0">';
// Si el numero de resultados es mayor de 0 muestro los resultados
if ($num_resultados > 0) {

	$resultados.='<tr><td><b>'.utf8_encode($salida['tipo_imagen']).' ('.$num_resultados.' imagen/es)</b><hr>';
	
		while ($row=mysql_fetch_array($img_disponibles)) {

		
			$resultados.='<ul id="thelist3">';
					
				
						$ruta_img='size=50&ruta=../../repositorio/originales/'.$row['imagen'];
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
						
						$ruta='img=../../repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
						$encript->encriptar($ruta,1);
						
						$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
						$encript->encriptar($ruta_cesto,1);
						
						$ruta_creador='img=repositorio/originales/'.$row['imagen'].'&id_palabra='.$row['id_palabra'];
			  			$encript->encriptar($ruta_creador,1);
					
					$resultados.='<li>
					<a href="javascript:void(0);" onclick="Dialog.alert({url: \'inc/public/imagen.php?i='.$ruta.'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:600, height:570, hideEffect: Effect.SwitchOff, resizable: true}, okLabel: \'Cerrar\'});"><img src="classes/img/thumbnail.php?i='.$ruta_img.'" alt="Imagen: '.$file.'" border="0"/></a><br />
					<b>'.utf8_encode($row['palabra']).'</b><br><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;&nbsp;&nbsp;<a href="inc/herramientas/creador_simbolos/creador_simbolos.php?i='.$ruta_creador.'" onclick="return GB_showFullScreen(\'Creador de Simbolos\', this.href)"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>&nbsp;&nbsp;&nbsp;<a href="inc/public/descargar.php?i='.$ruta.'"><img src=\'images/download1.png\' border="0" alt="Descargar imagen" title="Descargar imagen"></a></li>'; 
					

		}
		
	$resultados.='</ul></td></tr>';

	} 
$resultados.='</table></div>';
	
} // Cierro el While 

return $resultados;
}



function idiomas_disponibles($id_palabra,$idiomas_disponibles,$query) {

define("MAP_DIR","../../classes/utf8/MAPPING");
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

include_once('../../classes/utf8/utf8.class.php');
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
			$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
				if (mysql_num_rows($croata) > 0) {
					while ($row_croata=mysql_fetch_array($croata)) {
						if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_croata['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_croata,$cadena_url,$translate); $idiomas.='<br />'; }
					}
				}
			break;
	
	}

}

$idiomas.='</select>';

} else {

$idiomas='No hay traducciones disponibles &nbsp;<input name="idioma" type="hidden" id="idioma" value="0" /><input name="id_traduccion" type="hidden" id="id_traduccion" value="0" /><br><br>';
}


return $idiomas;

} // Cierro la funcion

function idiomas_disponibles_modo_texto($id_palabra,$idiomas_disponibles,$query) {

define("MAP_DIR","../../classes/utf8/MAPPING");
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

include_once('../../classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$num_traducciones=mysql_num_rows($idiomas_disponibles);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 

if ($num_traducciones > 0) {

$idiomas='<b>'.$translate['traducciones_disponibles'].':</b><br />';

	if ($_SESSION['language']!='es' && $_SESSION['id_language'] > 0) {
	
	$palabra=$query->datos_palabra($id_palabra); 
	$idiomas.=$translate['spanish'].' - '.utf8_encode($palabra['palabra']).'<br />';
	
	}

		while ($row=mysql_fetch_array($idiomas_disponibles)) {
		
			switch ($row['idioma']) {
				
				case 'Chino':
					$chino=$query->buscar_traduccion($id_palabra,4);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($chino) > 0) {
						while ($row_chino=mysql_fetch_array($chino)) {
							if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_chino['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Rumano':
					$rumano=$query->buscar_traduccion($id_palabra,2);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($rumano) > 0) {
						while ($row_rumano=mysql_fetch_array($rumano)) {
							if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_rumano['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Polaco':
					$polaco=$query->buscar_traduccion($id_palabra,6);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($polaco) > 0) {
						while ($row_polaco=mysql_fetch_array($polaco)) {
							if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_polaco['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Ruso':
					$ruso=$query->buscar_traduccion($id_palabra,1);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ruso) > 0) {
						while ($row_ruso=mysql_fetch_array($ruso)) {
							$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);
							if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ru.'<br />'; }
						}
					}
					break;
					
					case 'Bulgaro':
					$bulgaro=$query->buscar_traduccion($id_palabra,5);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($bulgaro) > 0) {
						while ($row_bulgaro=mysql_fetch_array($bulgaro)) {
							$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);
							if ($row_bulgaro['estado']==1 && $row_bulgaro['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_bulg.'<br />'; }
						}
					}
					break;
					
					case 'Arabe':
					$arabe=$query->buscar_traduccion($id_palabra,3);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($arabe) > 0) {
						while ($row_arabe=mysql_fetch_array($arabe)) {
							$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);
							if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ar.'<br />'; }
						}
					}
					break;
					
					case 'Ingles':
					$ingles=$query->buscar_traduccion($id_palabra,7);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ingles) > 0) {
						while ($row_ingles=mysql_fetch_array($ingles)) {
							if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_ingles['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Frances':
					$frances=$query->buscar_traduccion($id_palabra,8);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($frances) > 0) {
						while ($row_frances=mysql_fetch_array($frances)) {
							if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_frances['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Catalan':
					$catalan=$query->buscar_traduccion($id_palabra,9);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($catalan) > 0) {
						while ($row_catalan=mysql_fetch_array($catalan)) {
							if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_catalan['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Euskera':
					$euskera=$query->buscar_traduccion($id_palabra,10);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($euskera) > 0) {
						while ($row_euskera=mysql_fetch_array($euskera)) {
							if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_euskera['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Aleman':
					$aleman=$query->buscar_traduccion($id_palabra,11);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($aleman) > 0) {
						while ($row_aleman=mysql_fetch_array($aleman)) {
							if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_aleman['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Italiano':
					$italiano=$query->buscar_traduccion($id_palabra,12);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($italiano) > 0) {
						while ($row_italiano=mysql_fetch_array($italiano)) {
							if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_italiano['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Portugues':
					$portugues=$query->buscar_traduccion($id_palabra,13);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues) > 0) {
						while ($row_portugues=mysql_fetch_array($portugues)) {
							if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Portugues de Brasil':
					$portugues_br=$query->buscar_traduccion($id_palabra,15);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues_br) > 0) {
						while ($row_portugues_br=mysql_fetch_array($portugues_br)) {
							if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues_br['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Gallego':
					$gallego=$query->buscar_traduccion($id_palabra,14);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($gallego) > 0) {
								while ($row_gallego=mysql_fetch_array($gallego)) {
									if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_gallego['traduccion'].'<br />'; }
								}
						}
					break;
					
					case 'Croata':
					$croata=$query->buscar_traduccion($id_palabra,16);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($croata) > 0) {
								while ($row_croata=mysql_fetch_array($croata)) {
									if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_croata['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_croata,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					
			}

}

$idiomas.='<br />';

} else {

$idiomas=$translate['no_hay_traducciones'].'<br>';
}


return $idiomas;

} // Cierro la funcion

function insertar_locucion_castellano($encript,$datos_palabra,$cadena_url,$translate) {
	
		if (file_exists('repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3')) {
			$locucion.=' <object type="application/x-shockwave-flash" 
						data="swf/angular1.swf?src=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3" 
						height="15" width="15">
						<param name="movie"
						value="swf/angular1.swf?src=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3" />
						<param name="quality" value="high" />
						<param name="bgcolor" value="#ffffff" />
						</object> ';
									
			$ruta_mp3='ruta_cesto=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3';
			$encript->encriptar($ruta_mp3,1);
									
			$ruta_locucion='mp3=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3&id_palabra='.$datos_palabra['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
			$encript->encriptar($ruta_locucion,1);
					
			$locucion.=' <a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'"><img src=\'images/add_selection_mp3.png\' border="0" alt="'.$translate['add_locucion_seleccion'].'" title="'.$translate['add_locucion_seleccion'].'"></a> <a href="descargar_locucion.php?d='.$ruta_locucion.'"><img src=\'images/dowload_mp3.png\' border="0" alt="'.$translate['descargar_locucion'].'" title="'.$translate['descargar_locucion'].'"></a>';
			
		} else {
			$locucion='';
			$locucion.='<a href="escuchar_locucion.php?palabra='.htmlentities(utf8_encode($datos_palabra['palabra'])).'" target="_blank" onClick="window.open(this.href, this.target, \'width=70,height=70\'); return false;"><img src=\'images/speaker.png\' alt="Escuchar palabra '.utf8_encode($datos_palabra['palabra']).'" title="Escuchar palabra '.utf8_encode($datos_palabra['palabra']).'"></a>';	
		}	
			
	return $locucion;
}

function insertar_locucion_castellano_resultados($encript,$datos_palabra,$cadena_url,$translate) {
	
		if (file_exists('repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3')) {
			$locucion='';
			$locucion.='<br /><object type="application/x-shockwave-flash" 
						data="swf/angular1.swf?src=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3" 
						height="15" width="15">
						<param name="movie"
						value="swf/angular1.swf?src=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3" />
						<param name="quality" value="high" />
						<param name="bgcolor" value="#ffffff" />
						</object> '.$translate['escuchar_locucion'];
									
			$ruta_mp3='ruta_cesto=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3';
			$encript->encriptar($ruta_mp3,1);
									
			$ruta_locucion='mp3=repositorio/locuciones/0/'.$datos_palabra['id_palabra'].'.mp3&id_palabra='.$datos_palabra['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
			$encript->encriptar($ruta_locucion,1);
			
			$locucion.='<br /><a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'"><img src=\'images/add_selection_mp3.png\' border="0" alt="'.$translate['add_locucion_seleccion'].'" title="'.$translate['add_locucion_seleccion'].'"></a> <a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'">'.$translate['add_locucion_seleccion'].'</a><br /> <a href="descargar_locucion.php?d='.$ruta_locucion.'"><img src=\'images/dowload_mp3.png\' border="0" alt="'.$translate['descargar_locucion'].'" title="'.$translate['descargar_locucion'].'"></a> <a href="descargar_locucion.php?d='.$ruta_locucion.'">'.$translate['descargar_locucion'].'</a>';
			
		} else {
			$locucion='';
			$ruta_locucion='id_palabra='.$datos_palabra['id_palabra'].'&id_idioma='.$_SESSION['id_language'];
			$encript->encriptar($ruta_locucion,1);
			$locucion.='<br /><a href="escuchar_locucion.php?palabra='.htmlentities(utf8_encode($datos_palabra['palabra'])).'" target="_blank" onClick="window.open(this.href, this.target, \'width=70,height=70\'); return false;"><img src=\'images/speaker.png\' alt="'.$translate['escuchar_locucion'].' de '.utf8_encode($datos_palabra['palabra']).'" title="'.$translate['escuchar_locucion'].' de '.utf8_encode($datos_palabra['palabra']).'"></a> <a href="escuchar_locucion.php?palabra='.htmlentities(utf8_encode($datos_palabra['palabra'])).'" target="_blank" onClick="window.open(this.href, this.target, \'width=70,height=70\'); return false;">'.$translate['escuchar_locucion'].'</a>';
			$locucion.='<br /><a href="descargar_wav.php?d='.$ruta_locucion.'"><img src=\'images/dowload_mp3.png\' border="0" alt="'.$translate['descargar_locucion'].'" title="'.$translate['descargar_locucion'].'"></a> <a href="descargar_wav.php?d='.$ruta_locucion.'">'.$translate['descargar_locucion'].'</a>';
		}	
			
	return $locucion;
}


function insertar_locucion_idioma($encript,$datos_palabra,$cadena_url,$translate) {
	$locucion='';
	if (file_exists('repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3')) {
		$locucion.=' <object type="application/x-shockwave-flash" 
					data="swf/angular1.swf?src=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3" 
					height="14" width="14">
					<param name="movie"
					value="swf/angular1.swf?src=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					</object> ';
								
		$ruta_mp3='ruta_cesto=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3';
		$encript->encriptar($ruta_mp3,1);
												
		$ruta_locucion='mp3=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3&id_palabra='.$datos_palabra['id_palabra'].'&id_idioma='.$datos_palabra['id_idioma'];
		$encript->encriptar($ruta_locucion,1);
				
		$locucion.=' <a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'"><img src=\'images/add_selection_mp3.png\' border="0" alt="'.$translate['add_locucion_seleccion'].'" title="'.$translate['add_locucion_seleccion'].'"></a> <a href="descargar_locucion.php?d='.$ruta_locucion.'"><img src=\'images/dowload_mp3.png\' border="0" alt="'.$translate['descargar_locucion'].'" title="'.$translate['descargar_locucion'].'"></a>';
								
		} 
	return $locucion;
							
}

function insertar_locucion_idioma_resultados($encript,$datos_palabra,$cadena_url,$translate) {
	$locucion='';
	if (file_exists('repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3')) {
		$locucion.='<br /><object type="application/x-shockwave-flash" 
					data="swf/angular1.swf?src=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3" 
					height="14" width="14">
					<param name="movie"
					value="swf/angular1.swf?src=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					</object> '.$translate['escuchar_locucion'];
								
		$ruta_mp3='ruta_cesto=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3';
		$encript->encriptar($ruta_mp3,1);
												
		$ruta_locucion='mp3=repositorio/locuciones/'.$datos_palabra['id_idioma'].'/'.$datos_palabra['id_traduccion'].'.mp3&id_palabra='.$datos_palabra['id_palabra'].'&id_idioma='.$datos_palabra['id_idioma'];
		$encript->encriptar($ruta_locucion,1);
				
		$locucion.='<br /><a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'"><img src=\'images/add_selection_mp3.png\' border="0" alt="'.$translate['add_locucion_seleccion'].'" title="'.$translate['add_locucion_seleccion'].'"></a> <a href="'.$_SERVER['PHP_SELF'].'?'.$cadena_url.'product_id='.$ruta_mp3.'">'.$translate['add_locucion_seleccion'].'</a><br /> <a href="descargar_locucion.php?d='.$ruta_locucion.'"><img src=\'images/dowload_mp3.png\' border="0" alt="'.$translate['descargar_locucion'].'" title="'.$translate['descargar_locucion'].'"></a> <a href="descargar_locucion.php?d='.$ruta_locucion.'">'.$translate['descargar_locucion'].'</a>';
								
		} 
	return $locucion;
							
}

function idiomas_disponibles_modo_texto_2($id_palabra,$idiomas_disponibles,$query) {

define("MAP_DIR","classes/utf8/MAPPING");
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

include_once('classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$num_traducciones=mysql_num_rows($idiomas_disponibles);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 

if ($num_traducciones > 0) {

$idiomas='<b>'.$translate['traducciones_disponibles'].':</b><br />';

	if ($_SESSION['language']!='es' && $_SESSION['id_language'] > 0) {
	
	$palabra=$query->datos_palabra($id_palabra); 
	$idiomas.=$translate['spanish'].' - '.utf8_encode($palabra['palabra']);
	$idiomas.='<br />';
	

	
	}

		while ($row=mysql_fetch_array($idiomas_disponibles)) {
		
			switch ($row['idioma']) {
				
				case 'Chino':
					$chino=$query->buscar_traduccion($id_palabra,4);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($chino) > 0) {
						while ($row_chino=mysql_fetch_array($chino)) {
							if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_chino['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Rumano':
					$rumano=$query->buscar_traduccion($id_palabra,2);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($rumano) > 0) {
						while ($row_rumano=mysql_fetch_array($rumano)) {
							if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_rumano['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Polaco':
					$polaco=$query->buscar_traduccion($id_palabra,6);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($polaco) > 0) {
						while ($row_polaco=mysql_fetch_array($polaco)) {
							if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_polaco['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Ruso':
					$ruso=$query->buscar_traduccion($id_palabra,1);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ruso) > 0) {
						while ($row_ruso=mysql_fetch_array($ruso)) {
							$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);
							if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ru.'<br />'; }
						}
					}
					break;
					
					case 'Bulgaro':
					$bulgaro=$query->buscar_traduccion($id_palabra,5);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($bulgaro) > 0) {
						while ($row_bulgaro=mysql_fetch_array($bulgaro)) {
							$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);
							if ($row_bulgaro['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_bulg.'<br />'; }
						}
					}
					break;
					
					case 'Arabe':
					$arabe=$query->buscar_traduccion($id_palabra,3);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($arabe) > 0) {
						while ($row_arabe=mysql_fetch_array($arabe)) {
							$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);
							if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ar.'<br />'; }
						}
					}
					break;
					
					case 'Ingles':
					$ingles=$query->buscar_traduccion($id_palabra,7);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ingles) > 0) {
						while ($row_ingles=mysql_fetch_array($ingles)) {
							if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_ingles['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Frances':
					$frances=$query->buscar_traduccion($id_palabra,8);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($frances) > 0) {
						while ($row_frances=mysql_fetch_array($frances)) {
							if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_frances['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Catalan':
					$catalan=$query->buscar_traduccion($id_palabra,9);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($catalan) > 0) {
						while ($row_catalan=mysql_fetch_array($catalan)) {
							if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_catalan['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Euskera':
					$euskera=$query->buscar_traduccion($id_palabra,10);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($euskera) > 0) {
						while ($row_euskera=mysql_fetch_array($euskera)) {
							if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_euskera['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Aleman':
					$aleman=$query->buscar_traduccion($id_palabra,11);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($aleman) > 0) {
						while ($row_aleman=mysql_fetch_array($aleman)) {
							if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_aleman['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Italiano':
					$italiano=$query->buscar_traduccion($id_palabra,12);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($italiano) > 0) {
						while ($row_italiano=mysql_fetch_array($italiano)) {
							if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_italiano['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Portugues':
					$portugues=$query->buscar_traduccion($id_palabra,13);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues) > 0) {
						while ($row_portugues=mysql_fetch_array($portugues)) {
							if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Portugues de Brasil':
					$portugues_br=$query->buscar_traduccion($id_palabra,15);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues_br) > 0) {
						while ($row_portugues_br=mysql_fetch_array($portugues_br)) {
							if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues_br['traduccion'].'<br />'; }
						}
					}
					break;
					
					case 'Gallego':
					$gallego=$query->buscar_traduccion($id_palabra,14);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($gallego) > 0) {
								while ($row_gallego=mysql_fetch_array($gallego)) {
									if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_gallego['traduccion'].'<br />'; }
								}
						}
					break;
					
					case 'Croata':
					$croata=$query->buscar_traduccion($id_palabra,16);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($croata) > 0) {
								while ($row_croata=mysql_fetch_array($croata)) {
									if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_croata['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_croata,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					
			}

}

$idiomas.='<br />';

} else {

$idiomas=$translate['no_hay_traducciones'].'<br>';
}


return $idiomas;

} // Cierro la funcion

function idiomas_disponibles_modo_texto_3($id_palabra,$idiomas_disponibles,$query,$encript,$cadena_url,$translate) {

define("MAP_DIR","classes/utf8/MAPPING");
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

include_once('classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$num_traducciones=mysql_num_rows($idiomas_disponibles);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1); 

if ($num_traducciones > 0) {

$idiomas='<b>'.$translate['traducciones_disponibles'].':</b><br />';

	if ($_SESSION['language']!='es' && $_SESSION['id_language'] > 0) {
	
	$palabra=$query->datos_palabra($id_palabra); 
	$idiomas.=$translate['spanish'].' - '.utf8_encode($palabra['palabra']);
	$idiomas.=insertar_locucion_castellano($encript,$palabra,$cadena_url,$translate);
	$idiomas.='<br />';
	

	
	}

		while ($row=mysql_fetch_array($idiomas_disponibles)) {
		
			switch ($row['idioma']) {
				
				case 'Chino':
					$chino=$query->buscar_traduccion($id_palabra,4);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($chino) > 0) {
						while ($row_chino=mysql_fetch_array($chino)) {
							if ($row_chino['estado']==1 && $row_chino['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_chino['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_chino,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Rumano':
					$rumano=$query->buscar_traduccion($id_palabra,2);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($rumano) > 0) {
						while ($row_rumano=mysql_fetch_array($rumano)) {
							if ($row_rumano['estado']==1 && $row_rumano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_rumano['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_rumano,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Polaco':
					$polaco=$query->buscar_traduccion($id_palabra,6);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($polaco) > 0) {
						while ($row_polaco=mysql_fetch_array($polaco)) {
							if ($row_polaco['estado']==1 && $row_polaco['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_polaco['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_polaco,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Ruso':
					$ruso=$query->buscar_traduccion($id_palabra,1);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ruso) > 0) {
						while ($row_ruso=mysql_fetch_array($ruso)) {
							$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);
							if ($row_ruso['estado']==1 && $row_ruso['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ru; $idiomas.=insertar_locucion_idioma($encript,$row_ruso,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Bulgaro':
					$bulgaro=$query->buscar_traduccion($id_palabra,5);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($bulgaro) > 0) {
						while ($row_bulgaro=mysql_fetch_array($bulgaro)) {
							$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);
							if ($row_bulgaro['estado']==1 && $row_bulgaro['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_bulg; $idiomas.=insertar_locucion_idioma($encript,$row_bulgaro,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Arabe':
					$arabe=$query->buscar_traduccion($id_palabra,3);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($arabe) > 0) {
						while ($row_arabe=mysql_fetch_array($arabe)) {
							$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);
							if ($row_arabe['estado']==1 && $row_arabe['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$res_ar; $idiomas.=insertar_locucion_idioma($encript,$row_arabe,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Ingles':
					$ingles=$query->buscar_traduccion($id_palabra,7);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($ingles) > 0) {
						while ($row_ingles=mysql_fetch_array($ingles)) {
							if ($row_ingles['estado']==1 && $row_ingles['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_ingles['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_ingles,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Frances':
					$frances=$query->buscar_traduccion($id_palabra,8);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($frances) > 0) {
						while ($row_frances=mysql_fetch_array($frances)) {
							if ($row_frances['estado']==1 && $row_frances['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_frances['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_frances,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Catalan':
					$catalan=$query->buscar_traduccion($id_palabra,9);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($catalan) > 0) {
						while ($row_catalan=mysql_fetch_array($catalan)) {
							if ($row_catalan['estado']==1 && $row_catalan['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_catalan['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_catalan,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Euskera':
					$euskera=$query->buscar_traduccion($id_palabra,10);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($euskera) > 0) {
						while ($row_euskera=mysql_fetch_array($euskera)) {
							if ($row_euskera['estado']==1 && $row_euskera['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_euskera['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_euskera,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Aleman':
					$aleman=$query->buscar_traduccion($id_palabra,11);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($aleman) > 0) {
						while ($row_aleman=mysql_fetch_array($aleman)) {
							if ($row_aleman['estado']==1 && $row_aleman['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_aleman['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_aleman,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Italiano':
					$italiano=$query->buscar_traduccion($id_palabra,12);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($italiano) > 0) {
						while ($row_italiano=mysql_fetch_array($italiano)) {
							if ($row_italiano['estado']==1 && $row_italiano['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_italiano['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_italiano,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Portugues':
					$portugues=$query->buscar_traduccion($id_palabra,13);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues) > 0) {
						while ($row_portugues=mysql_fetch_array($portugues)) {
							if ($row_portugues['estado']==1 && $row_portugues['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_portugues,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Portugues de Brasil':
					$portugues_br=$query->buscar_traduccion($id_palabra,15);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
					if (mysql_num_rows($portugues_br) > 0) {
						while ($row_portugues_br=mysql_fetch_array($portugues_br)) {
							if ($row_portugues_br['estado']==1 && $row_portugues_br['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_portugues_br['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_portugues_br,$cadena_url,$translate); $idiomas.='<br />'; }
						}
					}
					break;
					
					case 'Gallego':
					$gallego=$query->buscar_traduccion($id_palabra,14);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($gallego) > 0) {
								while ($row_gallego=mysql_fetch_array($gallego)) {
									if ($row_gallego['estado']==1 && $row_gallego['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_gallego['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_gallego,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					
					case 'Finlandes':
					$finlandes=$query->buscar_traduccion($id_palabra,16);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($finlandes) > 0) {
								while ($row_finlandes=mysql_fetch_array($finlandes)) {
									if ($row_finlandes['estado']==1 && $row_finlandes['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_finlandes['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_finlandes,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					
					case 'Croata':
					$croata=$query->buscar_traduccion($id_palabra,16);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($croata) > 0) {
								while ($row_croata=mysql_fetch_array($croata)) {
									if ($row_croata['estado']==1 && $row_croata['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_croata['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_croata,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					
					case 'Turco':
					$turco=$query->buscar_traduccion($id_palabra,17);
					$datos_idioma=$query->datos_idioma_completo($row['id_idioma']); 
						if (mysql_num_rows($turco) > 0) {
								while ($row_turco=mysql_fetch_array($turco)) {
									if ($row_turco['estado']==1 && $row_turco['traduccion'] != NULL) { $idiomas.=$datos_idioma['idioma_'.$_SESSION['language'].''].' - '.$row_turco['traduccion']; $idiomas.=insertar_locucion_idioma($encript,$row_turco,$cadena_url,$translate); $idiomas.='<br />'; }
								}
						}
					break;
					

					
			}

}

$idiomas.='<br />';

} else {

$idiomas=$translate['no_hay_traducciones'].'<br>';
}


return $idiomas;

} // Cierro la funcion

function flashmp3($texte) {
$texte = preg_replace("'<flashmp3=([^\]>]+)>([^\[]+)<\/flashmp3>'Ui",'<br><br><object type="application/x-shockwave-flash" data="/son/dewplayer.swf?son=/son/\\1" width="200" height="20"><param name="movie" value="/son/dewplayer.swf?son=/son/\\1"></object><span valign="middle"><br>\\2</span>',$texte);
return $texte;
}

function apres_propre($texte) {
$texte = flashmp3($texte);
return $texte;
}
// <flashmp3=nomdefichier.mp3>Escucha este fragmento, fruto de mis delirios musicales</flashmp3>

//For Count Days
function count_days($start, $end)
{
   if( $start != '0000-00-00' and $end != '0000-00-00' )
   {
       $timestamp_start = strtotime($start);
       $timestamp_end = strtotime($end);
       if( $timestamp_start >= $timestamp_end ) return 0;
       $start_year = date("Y",$timestamp_start);
       $end_year = date("Y", $timestamp_end);
       $num_days_start = date("z",strtotime($start));
       $num_days_end = date("z", strtotime($end));
       $num_days = 1;
       $i = 1;
       if( $end_year > $start_year )
       {
           while( $i < ( $end_year - $start_year ) )
           {
             $num_days = $num_days + date("z", strtotime(($start_year + $i)."-12-31"));
             $i++;
           }
         }
         return ( $num_days_end + $num_days ) - $num_days_start;
   }
   else
   {
         return 0;
     }
}

function compara_fechas($fecha1,$fecha2)
            
{
            
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
            
              list($dia1,$mes1,$a�o1)=explode("/",$fecha1);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
            
              list($dia1,$mes1,$a�o1)=explode("-",$fecha1);
      
	  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
            
              list($dia2,$mes2,$a�o2)=explode("/",$fecha2);
            
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
            
        list($dia2,$mes2,$a�o2)=explode("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$a�o1) - mktime(0,0,0, $mes2,$dia2,$a�o2);
        return ($dif);                         
            
}

function suma_fechas($fecha,$ndias)
{
            

      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            

              list($dia,$mes,$a�o)=split("/", $fecha);
            

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            

              list($dia,$mes,$a�o)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$a�o) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            

      return ($nuevafecha);  
}
function saludo ()
{
if (Date("H") > 5 && Date("H")< 14) $mensaje = "Buenos Días";
elseif (Date("H") > 13 && Date("H") < 20) $mensaje = "Buenas Tardes";
elseif (Date("H") > 19 && Date("H") <= 23) $mensaje = "Buenas Noches";
elseif (Date("H") >= 0 && Date("H") < 6) $mensaje = "Buenas Noches";
return $mensaje;
}

function saludo_idioma($lang)
{
if (Date("H") > 5 && Date("H")< 14) $mensaje = $lang['buenos_dias'];
elseif (Date("H") > 13 && Date("H") < 20) $mensaje = $lang['buenas_tardes'];
elseif (Date("H") > 19 && Date("H") <= 23) $mensaje = $lang['buenas_noches'];
elseif (Date("H") >= 0 && Date("H") < 6) $mensaje = $lang['buenas_noches'];
return $mensaje;
}

/* FUNCION QUE REDIMENSIONA LAS IMAGENES                                                                */
/* ---------------------------------------------------------------------------------------------------- */
function redimensionar($filename,$max_size) 
{ 
		$source = imagecreatefromjpeg($filename);  
   		$thumbX = $max_size;    
   		$imageX = imagesx($source);
   		$imageY = imagesy($source);    
   		$thumbY = (int)(($thumbX*$imageY) / $imageX ); 
		if ($imageX > $thumbX)
		{
			include("img/ImageEditor.php");
			$f = $filename;
			$d = strrpos($f, "/");
			$file = substr($f, $d);
			$path = substr($f, 0, $d);
			$imageEditor = new ImageEditor($file,$path);
			$imageEditor->resize($thumbX, $thumbY);
			$imageEditor->outputFile($file,$path);
		}        
}

/* FUNCION QUE LIMPIA LOS NOMBRES DE CARACTERES ESPECIALES */
// CON � y N excluidas
/* ---------------------------------------------------------------------------------------------------- */
function es_parser_con_241_209($str) 
{ 
       $tmp = ""; 
       for($i = 0; $i < strlen($str); $i++) { 
               switch(ord($str[$i])) { 
                       case 192: case 193: 
                               $tmp .= "A"; 
                               break; 
                       case 200: case 201: 
                               $tmp .= "E"; 
                               break; 
                       case 204: case 205:
                               $tmp .= "I"; 
                               break; 
                       case 210: case 211: 
                               $tmp .= "O"; 
                               break; 
                       case 217: case 218:
                               $tmp .= "U"; 
                               break; 
                       case 224: case 225: 
                               $tmp .= "a"; 
                               break; 
                       case 232: case 233:  
                               $tmp .= "e"; 
                               break; 
                       case 236: case 237: 
                               $tmp .= "i"; 
                               break; 
                       case 242: case 243: 
                               $tmp .= "o"; 
                               break; 
                       case 249: case 250:                               
					           $tmp .= "u"; 
                               break; 
                       case 231:                               
					          $tmp .= "c"; 
                               break; 
                       case 199: 
                               $tmp .= "C"; 
                               break; 
                       case 128:
                               $tmp .= "EU"; 
                               break; 
					   case 220: 
                               $tmp .= "U"; 
                               break; 
					   case 252: 
                               $tmp .= "u"; 
                               break;
                       default: 
                               $tmp .= (string)$str[$i]; 
                               break; 
               } 
       } 
       return($tmp); 
} 

/* FUNCION QUE LIMPIA LOS NOMBRES DE CARACTERES ESPECIALES */
/* ---------------------------------------------------------------------------------------------------- */
function es_parser($str) 
{ 
       $tmp = ""; 
       for($i = 0; $i < strlen($str); $i++) { 
               switch(ord($str[$i])) { 
                       case 192: case 193: 
                               $tmp .= "A"; 
                               break; 
                       case 200: case 201: 
                               $tmp .= "E"; 
                               break; 
                       case 204: case 205:
                               $tmp .= "I"; 
                               break; 
                       case 210: case 211: 
                               $tmp .= "O"; 
                               break; 
                       case 217: case 218:
                               $tmp .= "U"; 
                               break; 
                       case 224: case 225: 
                               $tmp .= "a"; 
                               break; 
                       case 232: case 233:  
                               $tmp .= "e"; 
                               break; 
                       case 236: case 237: 
                               $tmp .= "i"; 
                               break; 
                       case 242: case 243: 
                               $tmp .= "o"; 
                               break; 
                       case 249: case 250:                               
					           $tmp .= "u"; 
                               break; 
                       case 241:                                
					           $tmp .= "n"; 
                               break; 
                       case 209:
                               $tmp .= "N"; 
                               break; 
                       case 231:                               
					          $tmp .= "c"; 
                               break; 
                       case 199: 
                               $tmp .= "C"; 
                               break; 
                       case 128:
                               $tmp .= "EU"; 
                               break; 
					   case 220: 
                               $tmp .= "U"; 
                               break; 
					   case 252: 
                               $tmp .= "u"; 
                               break;
                       default: 
                               $tmp .= (string)$str[$i]; 
                               break; 
               } 
       } 
       return($tmp); 
} 

/* FUNCION QUE AVERIGUA EL TAMA�O QUE OCUPAN LOS ARCHIVOS ALMACENADOS EN LA CARPETA PERSONAL DE CADA WQ */
/* ---------------------------------------------------------------------------------------------------- */
function dir_size($dir) { /* Inicio la funcion */
	$totalsize=0; /* inicializo la varieble */
	if ($dirstream = @opendir($dir)) { /* Abro el directorio */
		while (false !== ($filename = readdir ($dirstream))) /* Mientras haya archivos que leer en el directorio realizo el bucle */
{
			if ($filename!="." && $filename!="..") /* Me aseguro que el archivo no sea el indicador de directorios "." o ".." */
			{
				if (is_file($dir."/".$filename)) 
					$totalsize+=filesize($dir."/".$filename); /* Si es archivo sumo el tama�o del archivo al valor actual de $totalsize */
				if (is_dir($dir."/".$filename)) /* Si es directorio llamo nuevamente a la funcion dir_size con la nueva ruta */
					//$totalsize+=dir_size($dir."/".$filename);
					$totalsize=$totalsize;
					}
				}
			}
			closedir($dirstream); /* Cierro el directorio */
			return $totalsize; /* Devuelvo el valor obtenido en la variable $totalsize */
		}

/* FUNCION QUE GENERA UN PASSWORD ALEATORIO DE LETRAS Y NUMEROS */
function generar_password () { 
$i=0;
$password="";
// Aqui colocamos el largo del password
$pw_largo = 6; 
// Colocamos el rango de caracteres ASCII para la creacion de el password
$desde_ascii = 50; // "2" 
$hasta_ascii = 122; // "z" 
// Aqui quitamos caracteres especiales
$no_usar = array (58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111); 
while ($i < $pw_largo) { 
mt_srand ((double)microtime() * 1000000); 
// limites aleatorios con tabla ASCII
$numero_aleat = mt_rand ($desde_ascii, $hasta_ascii); 
if (!in_array ($numero_aleat, $no_usar)) { 
$password = $password . chr($numero_aleat); 
$i++; 
} 
} 
return $password; 
} 

function hex2rgb($color){ 
  
   $color = str_replace('#', '', $color);
    if (strlen($color) != 6){ return array(0,0,0); }
    $rgb = array();
    for ($x=0;$x<3;$x++){
        $rgb[$x] = hexdec(substr($color,(2*$x),2));
    }
   return $rgb;
	
  //if (!preg_match("[0-9a-fA-F]{\6}",$hex)) { 
  //echo "Error : input is not a valid hexadecimal number"; 
  //return 0; 
  //} 
  
  //for($i=0; $i<3; $i++) { 
  //$temp = substr($hex, 2*$i, 2); 
  //$rgb[$i] = 16 * hexdec(substr($temp, 0, 1)) + 
  //hexdec(substr($temp, 1, 1)); 
  //} 
  
  return $rgb; 
}

function enviar_mail($from,$fromname,$email_destinatario,$asunto, $cuerpo, $cuerpo_html,$ruta) {

	// primero hay que incluir la clase phpmailer para poder instanciar
	//un objeto de la misma
	require ($ruta."class.phpmailer.php");
				
	//instanciamos un objeto de la clase phpmailer al que llamamos 
	//por ejemplo mail
	$mail = new PHPMailer();
	
	// telling the class to use SMTP
	$mail->IsSMTP();
	/*
	 * enables SMTP debug information (for testing)
	 * 1 = errors and messages
	 * 2 = messages only
	 */
	$mail->SMTPDebug  = 0;
	$mail->Debugoutput = 'html';
	// sets the prefix to the server
	$mail->SMTPSecure = "tls";
	// enable SMTP authentication
	$mail->SMTPAuth   = true;
	// set the SMTP server
	$mail->Host       = "smtp.gmail.com";
	//$mail->Host       = "172.27.13.170";
	// set the SMTP port for the SMTP server, 587 might be possible too
	$mail->Port       = 587; //No es necesario el puerto si es una cuenta de Gmail
	// e-mail address username
	$mail->Username   = "arasaac@gmail.com";
	// e-mail address password
	$mail->Password   = "%portal#arasaac2008%";
				
	//Indicamos cual es nuestra direccion de correo y el nombre que 
	//queremos que vea el usuario que lee nuestro correo
	$mail->SetFrom($email_destinatario,$fromname);
	$mail->AddReplyTo($from,$fromname);
				
	//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
	//una cuenta gratuita, por tanto lo pongo a 30  
	$mail->Timeout=30;
				
	//Indicamos cual es la direccion de destino del correo
	$mail->AddAddress($email_destinatario);
				
	//Asignamos asunto y cuerpo del mensaje
	//El cuerpo del mensaje lo ponemos en formato html, haciendo 
	//que se vea en negrita
	$mail->Subject = $asunto;
	$mail->Body = $cuerpo_html;
				
	//Definimos AltBody por si el destinatario del correo no admite email con formato html 
	$mail->AltBody = $cuerpo;
				
	//Send the message, check for errors
	if(!$mail->Send()) {
	  $mensaje_email="Problemas enviando correo electronico a ".$valor."<br/>".$mail->ErrorInfo;
	} else {
	  $mensaje_email="Mensaje enviado correctamente";
	}
				   
	return $mensaje_email;
} //Fin Funcion	enviar Email	



function file_ext($file) {
  $extension = split("[.]", $file);
  $ext_file = $extension[count($extension)-1];
  return strtolower($ext_file);
}


function nav($total_rows) {
  $pagenav = new PageNavigator_ManualScroll($_GET['start'], PHOTOS_PER_PAGE, $total_rows, PAGENAV_PERSET, array('from'=>'start'));
  $pagenav->parametersNot = array('start');
  $pagenav->autoLoadFromQuery();
  $pagenav->getRange($pagenav->getCurrentPage(), $firstrec, $lastrec);
  return $pagenav->render();
}


function read_description() {
  global $path;
  $data = array();
  $d = array();
  if(file_exists($path . DESCRIPTION_FILENAME)) {
    $data = file($path . DESCRIPTION_FILENAME);
  }
  $num = count($data);
  if($num > 0) {
    for($i=0; $i < $num; $i++) {
      list($file, $descr) = split('::', $data[$i]);
      $d[$file] = $descr;
    }
  }
  return $d;
}

function cmp_name_asc(&$a, &$b) 
{ 
    if ($a['name']==$b['name']) return 0; 
        return ($a['name']<$b['name']) ? -1 : 1; 
}
function cmp_name_desc(&$a, &$b) 
{ 
    if ($a['name']==$b['name']) return 0; 
        return ($a['name']>$b['name']) ? -1 : 1; 
}
function cmp_time_asc(&$a, &$b) 
{ 
    if ($a['last_modified']==$b['last_modified']) return 0; 
        return ($a['last_modified']<$b['last_modified']) ? -1 : 1; 
}
function cmp_time_desc(&$a, &$b) 
{ 
    if ($a['last_modified']==$b['last_modified']) return 0; 
        return ($a['last_modified']>$b['last_modified']) ? -1 : 1; 
}
function cmp_size_asc(&$a, &$b) 
{ 
    if ($a['size']==$b['size']) return 0; 
        return ($a['size']<$b['size']) ? -1 : 1; 
}
function cmp_size_desc(&$a, &$b) 
{ 
    if ($a['size']==$b['size']) return 0; 
        return ($a['size']>$b['size']) ? -1 : 1; 
}

function CleanFiles($dir)
{
	$t=time();
	if (is_dir($dir) ) 
        { 
           $handle=opendir($dir); 
           while (false!==($file = readdir($handle))) { 
               if ($file != "." && $file != ".." && $file != "index.php") {  
                   //$Diff = (time() - filectime("$dir/$file"))/60/60/24;
                   //if ($Diff > 1) unlink("$dir/$file"); //Borro los archivos con mas de 2 dias de antiguedad
				   $path=$dir.'/'.$file;
				   if($t-filemtime($path)>10800) //Establezo el tiempo 3600 (segundos) = 1h
				   @unlink($path);

               } 
           }
           closedir($handle); 
        }
	
/*    //Borrar los ficheros temporales
    $t=time();
    $h=opendir($dir);
    while($file=readdir($h))
    {
        if(substr($file,0,3)=='tmp')
        {
            $path=$dir.'/'.$file;
            if($t-filemtime($path)>43200) //Establezo el tiempo 3600 (segundos) = 1h
                @unlink($path);
        }
    }
    closedir($h);*/
} 



function invert_image($input,$output,$color=false,$type='jpg')
 {
     if($type == 'jpg') { $bild = imagecreatefromjpeg($input); }
     elseif($type == 'png') { $bild = imagecreatefrompng($input); }
	 elseif($type == 'gif') { $bild = imagecreatefromgif($input); }
  
     $x = imagesx($bild);
     $y = imagesy($bild);
  
     for($i=0; $i<$y; $i++)
     {
         for($j=0; $j<$x; $j++)
         {
             $pos = imagecolorat($bild, $j, $i);
             $f = imagecolorsforindex($bild, $pos);
             if($color == true)
             {
				 $col = imagecolorresolve($bild, 255-$f['red'], 255-$f['green'], 255-$f['blue']);
             }else{
                 $gst = $f['red']*0.15 + $f['green']*0.5 + $f['blue']*0.35;
                 $col = imagecolorclosesthwb($bild, 255-$gst, 255-$gst, 255-$gst);
            }
             imagesetpixel($bild, $j, $i, $col);
         }
     }
	 
    if(empty($output)) { header('Content-type: image/'.$type); } else { $output=$output; }
	
    if($type == 'jpg') { imagejpeg($bild,$output,90); }
    elseif($type == 'png') { imagepng($bild,$output); } 
	elseif($type == 'gif') { imagegif($bild,$output); } 
}


function alto_contraste_png($input,$output,$newColor,$type='jpg')
 {
 
 	 if($type == 'jpg') { $image = imagecreatefromjpeg($input); }
     elseif($type == 'png') { $image = imagecreatefrompng($input); }
	 elseif($type == 'gif') { $image = imagecreatefromgif($input); }
	  
        $colorToChange = "FFFFFF";  

        $c1 = sscanf($colorToChange,"%2x%2x%2x"); 
        $c2 = sscanf($newColor ,"%2x%2x%2x"); 

        $cIndex = imagecolorexact($image,$c1[0],$c1[1],$c1[2]); 
        imagecolorset($image,$cIndex,$c2[0],$c2[1],$c2[2]); 

   if(empty($output)) { header('Content-type: image/'.$type); } else { $output=$output; } 
		
	if($type == 'jpg') { imagejpeg($image,$output); }
    elseif($type == 'png') { imagepng($image,$output); }
	elseif($type == 'gif') { imagegif($image,$output); }  
	 
}

function alto_contraste_jpg($input,$output,$newColor,$type='jpg')
 {
 
 	 if($type == 'jpg') { $image = imagecreatefromjpeg($input); }
     elseif($type == 'png') { $image = imagecreatefrompng($input); }
	 elseif($type == 'gif') { $image = imagecreatefromgif($input); }
	  
        $width = imagesx($image); 
        $height = imagesy($image); 

        $colorToChange = "FFFFFF"; 

        $c1 = sscanf($colorToChange,"%2x%2x%2x"); 
        $c2 = sscanf($newColor,"%2x%2x%2x"); 
        
        $cnew = imagecolorallocate($image,$c2[0],$c2[1],$c2[2]); 

        for ($y=0;$y<$height;$y++) { 
                for ($x=0;$x<$width;$x++) { 
                        $rgb = imagecolorat($image,$x,$y); 
                        $r = ($rgb >> 16) & 0xFF; 
                        $g = ($rgb >> 8) & 0xFF; 
                        $b = $rgb & 0xFF; 
                        if (($r==$c1[0]) && ($g==$c1[1]) && ($b==$c1[2])) { 
                                imagesetpixel($image,$x,$y,$cnew); 
                        } 
                } 
        } 
         

   if(empty($output)) { header('Content-type: image/'.$type); } else { $output=$output; } 
		
	if($type == 'jpg') { imagejpeg($image,$output); }
    elseif($type == 'png') { imagepng($image,$output); }
	elseif($type == 'gif') { imagegif($image,$output); } 
	 
}

function comprobar_email($email){ 
   	$mail_correcto = 0; 
   	//compruebo unas cosas primeras 
   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
      	 if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
         	 //miro si tiene caracter . 
         	 if (substr_count($email,".")>= 1){ 
            	 //obtengo la terminacion del dominio 
            	 $term_dom = substr(strrchr ($email, '.'),1); 
            	 //compruebo que la terminaci�n del dominio sea correcta 
            	 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
               	 //compruebo que lo de antes del dominio sea correcto 
               	 $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
               	 $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
               	 if ($caracter_ult != "@" && $caracter_ult != "."){ 
                  	 $mail_correcto = 1; 
               	 } 
            	 } 
         	 } 
      	 } 
   	} 
   	if ($mail_correcto) 
      	 return 1; 
   	else 
      	 return 0; 
} 

function generar_ficha($translate,$row,$query) {

$index='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARASAAC: '.utf8_encode($row['material_titulo']).'</title>
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
a {	color:#333333;	text-decoration: underline; background: inherit; font-weight:bold;}
a.active {	color:#333333;	text-decoration: underline; background: inherit; font-weight:bold; }
a:hover { color: #8FB60C; background: inherit;  text-decoration: underline; }

h3 {
font-size: 20px;
color: #8FB60C;
text-transform:uppercase;

}
-->
</style>
</head>
<body>';
$index.='<a href="http://catedu.es/arasaac/" target="_blank"><img src="arasaac.jpg" alt="ARASAAC" title="ARASAAC" border="0"></a><br /><br />';
$index.='<div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
<h3>'.utf8_encode($row['material_titulo']).'</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="49%" height="110" valign="top"><p><strong>'.$translate['descripcion'].':</strong> <br />
        '.utf8_encode($row['material_descripcion']).'<br />
      <br />
        <strong>'.$translate['licencia'].':</strong> <br />';
			$row_licencia=$query->datos_licencia($row['material_licencia']);
     
	 			if ($row_licencia['logo_licencia'] != '') { 
	  
	  				$index.='<a href="'.$row_licencia['link_licencia'].'" target="_blank">'.utf8_encode($row_licencia['licencia']).'</a>';  
	
				} else {  
	
					$index.=utf8_encode($row_licencia['licencia']); 
				} 
	
   $index.='</p>
      <p><strong>'.$translate['idiomas'].':</strong>';
	  
	   	  $mid=str_replace('}{',',',$row['material_idiomas']);
		  $mid=str_replace('{','',$mid);
		  $mid=str_replace('}','',$mid);
		  $mid=explode(',',$mid);
		  
		  for ($i=0;$i<count($mid);$i++) { 
			if ($mid[$i]!='') {
				if ($mid[$i]=='es') {
					$index.=$translate['spanish'];
				} else {
			 		$data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
						if ($_SESSION['language']=='es') { 
			 				$index.=$data_idioma['idioma'].'&nbsp;|&nbsp;';
						} else {
							$index.=$data_idioma['idioma_'.$_SESSION['language'].''].'&nbsp;|&nbsp;';
						}
				} 
			}
		  }
		
$index.='</p></td>
    <td width="51%" valign="top"><strong>Autor/es:</strong> <br />';
      
	   	  $mau=str_replace('}{',',',$row['material_autor']);
		  $mau=str_replace('{','',$mau);
		  $mau=str_replace('}','',$mau);
		  $mau=explode(',',$mau);
		  
		  for ($i=0;$i<count($mau);$i++) { 
			if ($mau[$i]!='') {
			 $data_autor=$query->datos_autor($mau[$i]);
			 	if (isset($data_autor['email_autor']) && $data_autor['email_autor'] !='') {
					$index.='<a href="mailto:'.$data_autor['email_autor'].'">'.utf8_encode($data_autor['autor']).'</a><br />'; 
				} else {
			 		$index.=utf8_encode($data_autor['autor']).'<br />'; 
				}
			}
		  }
		
      $index.='<br />
      <strong>';
	  
     if (substr_count($row['material_archivos'],'.swf') == 1) {
	  		
		 $index.=$translate['previsualizacion']."<br/>";
		  
	  	  $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 	
			 	$split_archivo=explode('.',$ma[$i]);
				
				if ($split_archivo[1] == 'swf') {
					
					$index.='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="200" height="200">
				  <param name="movie" value="'.$row['id_material'].'/'.$ma[$i].'" />
				  <param name="quality" value="high" />
				  <embed src="'.$ma[$i].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="200" height="200"></embed>
				</object><br/>';
				}
			 
			}
		  }
	  	
		
	  }
	 
      $index.='</strong><strong>'.$translate['archivo_s'].':</strong> <br />
      <br />';
	  
     
	    $ma=str_replace('}{',',',$row['material_archivos']);
		  $ma=str_replace('{','',$ma);
		  $ma=str_replace('}','',$ma);
		  $ma=explode(',',$ma);
		  
		  for ($i=0;$i<count($ma);$i++) { 
			if ($ma[$i]!='') {
			 $index.='<a href="'.$ma[$i].'" target="_blank">'.$ma[$i].'<a/><br /><br />'; 
			}
		  }
		  
	  $index.='<br /></td>
  </tr>
</table>
<br />
 <div id="material_'.$row['id_material'].'"> 
 <table width="100%%" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td valign="top" bgcolor="#D8FE9E"><strong>'.$translate['tipo'].':</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>'.$translate['saac'].':</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>'.$translate['nivel'].':</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>'.$translate['dirigido'].':</strong></td>
    <td valign="top" bgcolor="#D8FE9E"><strong>'.$translate['areas_subareas'].':</strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFCC">';
 
	      $mt=str_replace('}{',',',$row['material_tipo']);
		  $mt=str_replace('{','',$mt);
		  $mt=str_replace('}','',$mt);
		  $mt=explode(',',$mt);
		  
		  for ($i=0;$i<count($mt);$i++) { 
			if ($mt[$i]!='') {
			 $data_tipo=$query->datos_material_tipo($mt[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					$index.=$data_tipo['tipo_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
			 		$index.=$data_tipo['tipo_material'].'<br />'; 
				}
			}
		  }
   $index.='</td>
    <td valign="top" bgcolor="#FFFFCC">';
	
	  	  $msaa=str_replace('}{',',',$row['material_saa']);
		  $msaa=str_replace('{','',$msaa);
		  $msaa=str_replace('}','',$msaa);
		  $msaa=explode(',',$msaa);
		  
		  for ($i=0;$i<count($msaa);$i++) { 
			if ($msaa[$i]!='') {
			 $data_saa=$query->datos_material_saa($msaa[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					$index.=$data_saa['saa_material_'.$_SESSION['language'].''].'<br />';
				} else {
			 		$index.=$data_saa['saa_material'].'<br />'; 
				}
			}
		  }
		  
	$index.='</td>
    <td valign="top" bgcolor="#FFFFCC">'; 
	
	   	  $mn=str_replace('}{',',',$row['material_nivel']);
		  $mn=str_replace('{','',$mn);
		  $mn=str_replace('}','',$mn);
		  $mn=explode(',',$mn);
		  
		  for ($i=0;$i<count($mn);$i++) { 
			if ($mn[$i]!='') {
			 $data_nivel=$query->datos_material_nivel($mn[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					$index.=$data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
					 $index.=$data_nivel['nivel_material'].'<br />'; 
				}
			}
		  }
	  $index.='</td>
    <td valign="top" bgcolor="#FFFFCC">';
	
	 	  $md=str_replace('}{',',',$row['material_dirigido']);
		  $md=str_replace('{','',$md);
		  $md=str_replace('}','',$md);
		  $md=explode(',',$md);
		  
		  for ($i=0;$i<count($md);$i++) { 
			if ($md[$i]!='') {
			 $data_dirigido=$query->datos_material_dirigido($md[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					$index.=$data_dirigido['dirigido_material_'.$_SESSION['language'].''].'<br />'; 
				} else {
					 $index.=$data_dirigido['dirigido_material'].'<br />'; 
				}
			}
		  }
		  
	$index.='</td>
    <td valign="top" bgcolor="#FFFFCC">'; 
	 
	      $mac=str_replace('}{',',',$row['material_area_curricular']);
		  $mac=str_replace('{','',$mac);
		  $mac=str_replace('}','',$mac);
		  $mac=explode(',',$mac);
		  
		  for ($i=0;$i<count($mac);$i++) { 
			if ($mac[$i]!='') {
			 $data_ac=$query->datos_material_ac($mac[$i]);
			 	if ($_SESSION['id_language'] > 0) {
					$index.=$data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
				} else {
			   		$index.=$data_ac['ac_material'].'<br />'; 
				}
			 
			  $msubac=str_replace('}{',',',$row['material_subarea_curricular']);
			  $msubac=str_replace('{','',$msubac);
			  $msubac=str_replace('}','',$msubac);
			  $msubac=explode(',',$msubac);
			  
			  for ($j=0;$j<count($msubac);$j++) { 
					if ($msubac[$j]!='') {
					  $subareas=$query->datos_subarea($msubac[$j]);
					  if ($subareas['id_ac_material']==$mac[$i]) { 
					  		$index.='<blockquote>|_&nbsp;';
								if ($_SESSION['id_language'] > 0) {
									$index.=$subareas['subac_material_'.$_SESSION['language'].''];
								} else {
									$index.=$subareas['subac_material'];
								}
							$index.='</blockquote>';  
						}
					}
			   }
	
			}
		  }
		$index.='</td>
    </tr>
</table>
 </div>
 <br />';
$index.='</div>  
</div>';

$index.='<br /><a href="http://www.aragob.es" target="_blank"><img src="minilogo_aragob.gif" alt="'.$translate['dto_educacion'].'" width="12" height="12" border="0" title="'.$translate['dto_educacion'].'"/></a>&nbsp;'.$translate['dto_educacion'].'&nbsp;|&nbsp;<a href="http://catedu.es" target="_blank">CATEDU</a>, '.date("Y").'.
</body>
</html>';

return $index;	
}

function tamano_archivo($peso , $decimales = 2 ) {
$clase = array(" Bytes", " KB", " MB", " GB", " TB");
return round($peso/pow(1024,($i = floor(log($peso, 1024)))),$decimales ).$clase[$i];
}

/** 
     * Funcion que limpia un array de elementos repetidos 
     * @access private 
     * @param array $array El array a comprobar 
     * @return array El array limpio 
     */ 
 function limpiarArray($array){ 
        $retorno=null; 
        if($array!=null){ 
            $retorno[0]=$array[0]; 
        } 
        for($i=1;$i<count($array);$i++){ 
            $repetido=false; 
            $elemento=$array[$i]; 
            for($j=0;$j<count($retorno) && !$repetido;$j++){ 
                if($elemento==$retorno[$j]){ 
                    $repetido=true; 
                } 
            } 
            if(!$repetido){ 
                $retorno[]=$elemento; 
            } 
        } 
        return $retorno; 
    } 
	
?>
