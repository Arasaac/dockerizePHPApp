<?php 
session_start();
require ('../../../classes/languages/language_detect.php');
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],28);

$idiomafrase=$_POST['idiomafrase'];
$orden_frase=rawurldecode($_POST['mi_seleccion']);
$partes_frase = explode("&",$orden_frase);

if (isset($_POST['frase_secciones'])) { 
	$frase_secciones=rawurldecode($_POST['frase_secciones']); 
	$palabras_parte_frase = explode("&",$frase_secciones); 

	foreach ($palabras_parte_frase as $indice=>$valor){
	
		if ($valor !='') {
				$chopped_palabra = explode("thelist3[]=",$valor);
				$modpalabra[]=$chopped_palabra[1];
		}
	}
}


if (isset($_POST['imagenes'])) { 
	$imagenes_secciones=rawurldecode($_POST['imagenes']); 
	$partes_imagenes_secciones = explode("&",$imagenes_secciones); 
	
	foreach ($partes_imagenes_secciones as $indice=>$valor){

		if ($valor !='') {
				$chopped_img = explode("thelist2[]=",$valor);
				$chopped_img2 = explode("||",rawurldecode($chopped_img[1]));
				$modimg[]=$chopped_img2[0];
		}
	}

}

$sql='AND imagenes.id_tipo_imagen <> 11 '; 

if (isset($_POST['pictogramas_color'])) { $with_pictogramas_color=1;} else {  $sql.='AND imagenes.id_tipo_imagen <> 10 '; $with_pictogramas_color=''; }
if (isset($_POST['pictogramas_byn'])) {$with_pictogramas_byn=1; } else {  $sql.='AND imagenes.id_tipo_imagen <>  5 '; $with_pictogramas_byn=''; }
if (isset($_POST['fotografia'])) { $with_fotografia=1; } else {  $sql.='AND imagenes.id_tipo_imagen <>  2 '; $with_fotografia=''; }
if (isset($_POST['lse_color'])) { $with_lse_color=1; } else {  $sql.='AND imagenes.id_tipo_imagen <>  12 '; $with_lse_color=''; }
if (isset($_POST['lse_byn'])) { $with_lse_byn=1; } else {  $sql.='AND imagenes.id_tipo_imagen <>  13 '; $with_lse_byn=''; }

if (isset($_POST['mi_seleccion'])) {
	
	$orden=0;
	
		foreach ($partes_frase as $indice=>$valor){ 
		
			if ($valor !='') {
			$chopped_frase = explode("thelist2[]=",$valor);
			$chopped_frase2 = explode("||",rawurldecode($chopped_frase[1]));
			//echo $modpalabra[$orden];
			//echo $modimg[$orden];
			//echo $chopped_frase2[0].'/'.$chopped_frase2[1].'</br>';
			
			$img=array();
			
			if ($chopped_frase2[2]==1) { //Si es una palabra del diccionario
				
				if ($chopped_frase2[0] > 0) {
					
					if ($chopped_frase2[1] == 0) {
						$dp=$query->datos_palabra($chopped_frase2[0]);
						$id_palabra=$chopped_frase2[0];
						$palabra_mostrar=utf8_encode($dp['palabra']);
						
					} elseif ($chopped_frase2[1] > 0) {
						$dt=$query->buscar_traduccion_por_id($chopped_frase2[0]);
						$row_dt=mysql_fetch_array($dt);
						$palabra_mostrar=$row_dt['traduccion'];
						$id_palabra=$row_dt['id_palabra'];
						$dp=$query->datos_palabra($id_palabra);
					}
					
					$img_disponibles=$query->imagenes_disponibles_diferentes_tipos($id_palabra,$sql);
					$num_resultados=mysql_num_rows($img_disponibles);
					
					$alternativas='<div style="float: left; position: relative; border:1px dashed #CCC; width:100%; margin:5px;">';
					
					if ($num_resultados > 0) {
						
						$k=0;
						$modimg=array();
						$file='';
						
						while ($row=mysql_fetch_array($img_disponibles)) {
							
							$ruta_img='size=30&ruta=../../../../repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
							
							$ruta='img=repositorio/originales/'.$row['imagen'].'&id_imagen='.$row['id_imagen'].'&id_palabra='.$row['id_palabra'];
							$encript->encriptar($ruta,1);
							
							$ruta_cesto='ruta_cesto=repositorio/originales/'.$row['imagen'];
							$encript->encriptar($ruta_cesto,1);
						
							if ($orden==0) {
								if ($modimg[$orden]==$row['id_imagen']) {
									$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" checked="checked"/>';
								} else {
									if ($k==0) {
										$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" checked="checked"/>';
									} else {
										$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" />';
									}
								}
							} else {
								if ($modimg[$orden]==$row['id_imagen']) {
									$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" checked="checked"/>';
								} else {
									if ($k==0) {
										$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" checked="checked"/>';
									} else {
										$img[]='<img src="../classes/img/thumbnail.php?i='.$ruta_img.'" alt="'.$translate['imagen'].': '.$file.'" border="0"/><input type="radio" name="'.$orden.'" id="'.$orden.'" value="'.$row['id_imagen'].'||1" />';
									}
								}
							}			
						 $k++;
						}			
					}
					
					$alternativas.='<p><ul style="width:95%">';
						$limite=count($img);
						for($i=0;$i<$limite;$i++){
						  $alternativas.="<li style=\"float: left; position: relative; list-style:none;\">".$img[$i]."</li>";
						}
					$alternativas.='</ul></p>';
					
					if (isset($modpalabra[$orden]) && $modpalabra[$orden] !='') { 
					$alternativas.='<input type="text" name="p_'.$orden.'" id="p_'.$orden.'" value="'.$modpalabra[$orden].'" style="width:95%; font-size:14px; margin-top:20px; margin-bottom:10px;"/></div>';
					} else {
					$alternativas.='<input type="text" name="p_'.$orden.'" id="p_'.$orden.'" value="'.$palabra_mostrar.'" style="width:95%; font-size:14px; margin-top:20px; margin-bottom:10px;"/></div>';	
					}
					
					$palabra[]=$alternativas;
					
				} else {
					if (isset($modpalabra[$orden]) && $modpalabra[$orden] !='') { 					
						$palabra[]='<div style="float: left; position: relative; border:1px dashed #CCC; width:100%; margin:5px; text-align:left; padding-left:20px; padding-top:10px;"><span style="font-size:24px">'.$chopped_frase2[0].'<span /><br /><br /><input type="hidden" name="'.$orden.'" id="'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'||1"/><input name="p_'.$orden.'" type="text" id="p_'.$orden.'" value="'.$modpalabra[$orden].'" style="width:95%; font-size:14px; margin-bottom:10px;"/><br /></div>';
					} else {
						$palabra[]='<div style="float: left; position: relative; border:1px dashed #CCC; width:100%; margin:5px; text-align:left; padding-left:20px; padding-top:10px;"><span style="font-size:24px">'.$chopped_frase2[0].'<span /><br /><br /><input type="hidden" name="'.$orden.'" id="'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'||1"/><input name="p_'.$orden.'" type="text" id="p_'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'" style="width:95%; font-size:14px; margin-bottom:10px;"/><br /></div>';
					}
					
				}
				
			} elseif($chopped_frase2[2]==2) {
				if (isset($modpalabra[$orden]) && $modpalabra[$orden] !='') {
				$palabra[]='<div style="float: left; position: relative; border:1px dashed #CCC; width:100%; margin:5px; text-align:left; padding-left:20px; padding-top:10px;"><span style="font-size:24px">'.$chopped_frase2[0].'<span /><br /><br /><input type="hidden" name="'.$orden.'" id="'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'||2"/><input name="p_'.$orden.'" type="text" id="p_'.$orden.'" value="'.$modpalabra[$orden].'" style="width:95%; font-size:14px; margin-bottom:10px;"/><br /></div>';
				} else {
				$palabra[]='<div style="float: left; position: relative; border:1px dashed #CCC; width:100%; margin:5px; text-align:left; padding-left:20px; padding-top:10px;"><span style="font-size:24px">'.$chopped_frase2[0].'<span /><br /><br /><input type="hidden" name="'.$orden.'" id="'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'||2"/><input name="p_'.$orden.'" type="text" id="p_'.$orden.'" value="'.rawurldecode($chopped_frase2[0]).'" style="width:95%; font-size:14px; margin-bottom:10px;"/><br /></div>';
				}
				
			}
			
		$orden++; 
	}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title><?php echo $translate['Herramientas ARASAAC']; ?>: <?php echo $translate['creador_frases']; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script src="../js/scriptaculous/prototype.js" type="text/javascript"></script>
  <script src="../js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script src="../js/scriptaculous/unittest.js" type="text/javascript"></script>
  <script type="text/javascript" src="../js/ajax_herramientas.js"></script>
  <link rel="stylesheet" href="../../../css/style.css" type="text/css" />

    <script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/effects.js"> </script>
  	<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/window.js"> </script>
  	<script type="text/javascript" src="../js/windows_js_0.96.2/javascripts/debug.js"> </script>
	<link href="../js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="../js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="../js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
	<link href="../js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
  	<link href="../js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" >	 </link>
    <script type="text/javascript">
		function enviarformulario(url) {
		var form=document.seleccion_simbolos.action = url;
		form.submit()
		}
	</script>
</head>
<body>
<div class="body_content">
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxMenu/css/dhtmlXMenu.css">
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXProtobar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXMenuBar.js"></script>
<script language="JavaScript" src="../js/dhtmlxMenu/js/dhtmlXCommon.js"></script>
	<div id="principal">
<form action="" method="post" name="seleccion_simbolos" id="seleccion_simbolos" >

<div id="mi_repositorio">
 <h4><span style="text-transform:uppercase;"><?php echo $translate['creador_frases']; ?></span>:<?php echo $translate['paso_2']; ?>
 <div style="float:right; font-size:0.8em;"><?php if ($_SESSION['language']=='es') { echo '<a href="../../../zona_descargas/documentacion/manual_creador_frases_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>'; } else { echo '<a href="../../../zona_descargas/documentacion/manual_creador_frases_es.pdf" target="_blank" title="'.$translate['descargar_manual_pdf'].'">'.$translate['manual'].'</a>';  }?></div></h4>
      <table width="100%" border="0">
        <tr>
          <td width="100%" valign="top"><?php echo $translate['explicacion_paso_2']; ?><br /></td>
          </tr>
        <tr>
          <td height="22" align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td height="22" align="center" valign="top">
          <?php 
		  
		 			$limite_palabra=count($palabra);
					for($o=0;$o<$limite_palabra;$o++){
					  echo $palabra[$o];
					}
					
		  			
		  ?>          </td>
          </tr>
        <tr>
          <td height="22" align="center" valign="top"><p>
          </p>
            <p>
              <input name="guardar2" type="submit" id="guardar2" value="<< <?php echo $translate['ir_paso_1']; ?>" style="font-size:24px;" onclick="seleccion_simbolos.action='creador_frases.php'; return true;" />&nbsp;&nbsp;
              <input name="guardar" type="submit" id="guardar" value="<?php echo $translate['ir_paso_3']; ?> >>" style="font-size:24px;" onclick="seleccion_simbolos.action='creador_frases_3.php'; return true;" />
              <input name="mi_seleccion" type="hidden" id="mi_seleccion" value="<?php echo $_POST['mi_seleccion']; ?>"/>
              <input name="n_elementos" type="hidden" id="n_elementos" value="<?php echo $orden; ?>" />
              <?php 
			  	if ($with_pictogramas_color==1) { echo '<input name="pictogramas_color" type="hidden" id="pictogramas_color" value="1" />'; } 
			  	if ($with_pictogramas_byn==1) { echo '<input type="hidden" name="pictogramas_byn" id="pictogramas_byn" value="1"/>'; }
				if ($with_fotografia==1) { echo '<input type="hidden" name="fotografia" id="fotografia" value="1"/>'; }
				if ($with_lse_color==1) { echo '<input type="hidden" name="lse_color" id="lse_color" value="1"/>'; }
				if ($with_lse_byn==1) { echo '<input type="hidden" name="lse_byn" id="lse_byn" value="1"/>'; }
			  ?>
              <input name="idiomafrase" type="hidden" id="idiomafrase" value="<?php echo $_POST['idiomafrase']; ?>" />
              <input name="frase_secciones" type="hidden" id="frase_secciones" value="<?php if (isset($_POST['frase_secciones'])) { echo $_POST['frase_secciones'];} ?>" />
            </p></td>
        </tr>
      </table>
 </div>
</form>
</div>
<div align="center" class="footer">
<p><b><?php echo $translate['autores_herramienta']; ?>:</b> David Romero <?php echo $translate['y']; ?> José Manuel Marcos</p>
      <p>
        &copy; <?php echo $translate['herramientas_arasaac_catedu']; ?> <?php echo date("Y"); ?> | <?php echo $translate['dto_educacion']; ?><br />
        <a href="http://www.aragob.es" target="_blank"><img src="../../../images/minilogo_aragob.gif" alt="<?php echo $translate['dto_educacion']; ?>" border="0" tittle="<?php echo $translate['dto_educacion']; ?>"/></a></p>
  </div>
</div>
</body>
</html>

