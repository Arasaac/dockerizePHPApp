<?php 
if (isset($_GET['i'])) {
	$datos=explode('-',$_GET['i']);
	$id_usuario=$datos[1];
	$id_panel=$datos[0];
} else {
	$id_usuario=$_GET['id_usuario'];
	$id_panel=$_GET['id_panel'];
}

//include_once ('html2fpdf.php');

require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
include ('../../../classes/querys/query.php');
$query=new query();

$panel=$query->datos_panel($id_panel,$id_usuario);
	
	$n_items=$panel['n_items'];
	$principal=$panel['simbolo_principal'];
	$panel_width=$panel['panel_width'];
	$simbolos_width=$panel['simbolos_width'];
	$principal_width=$panel['principal_width'];
	$borde_panel=$panel['borde_panel'];
	$grosor_borde_panel=$panel['grosor_borde_panel'];
	$color_borde_panel=$panel['color_borde_panel'];
	$panel_color_fondo=$panel['panel_color_fondo'];
	
	$borde_simbolos=$panel['borde_simbolos'];
	$grosor_borde_simbolos=$panel['grosor_borde_simbolos'];
	$color_borde_simbolos=$panel['color_borde_simbolos'];
	$espacio_entre_simbolos=$panel['espacio_entre_simbolos'];
	
	$borde_simbolo_principal=$panel['borde_simbolo_principal'];
	$grosor_borde_simbolo_principal=$panel['grosor_borde_simbolo_principal'];
	$color_borde_simbolo_principal=$panel['color_borde_simbolo_principal'];
	
	$contenido_panel=$panel['contenido_panel'];
	$nombre_panel=$panel['nombre_panel'];
	$tags_panel=$panel['tags_panel'];
	
	$txt_superior=$panel['txt_superior'];
	$txt_inferior=$panel['txt_inferior'];
	
	$id_panel=$panel['id_panel'];
	
	$text_smb=explode(";",$contenido_panel); 	
	$text_n_simb=count($text_smb);
				
		for ($h=0; $h<=$text_n_simb; $h++){
				if (!empty($text_smb[$h])) {
					$text_simbolo=explode("|", $text_smb[$h]);
					
						if ($text_simbolo[0] != 'allItems') {
							
							if (substr_count($text_simbolo[1],'node') > 0) { $item=explode('node',$text_simbolo[1]); }
							elseif (substr_count($text_simbolo[1],'txt') > 0) { $item=explode('txt',$text_simbolo[1]); }
							$item_box=explode('box',$text_simbolo[0]);
							$box[$item_box[1]]=$item[1];
						} 
				}
		}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head> 
<style type="text/css">
	#body {
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:12px;
	color:#000000;	
	}
    #dhtmlgoodies_dragDropContainer{	/* Main container for this script */
		width:100%;
		height:700px;
		border:1px solid #CCCCCC;
		background-color:#FFF;
		-moz-user-select:none;
	}
	#dhtmlgoodies_dragDropContainer ul{	/* General rules for all <ul> */
		margin-top:0px;
		margin-left:0px;
		margin-bottom:0px;
		padding:2px;
	}
	
	/* Start main container CSS */
	
	div#dhtmlgoodies_mainContainer{	/* Right column DIV */
		width:<?php echo $panel_width; ?>px;
		<?php if ($borde_panel ==1) { echo 'border: '.$grosor_borde_panel.'px solid '.$color_borde_panel.';'; }?>
		float:left;	
		background-color:<?php echo $panel_color_fondo; ?>;
	}
	#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
		float:left;
		margin:<?php echo $espacio_entre_simbolos; ?>px;
		<?php if ($borde_simbolos ==1) { echo 'border: '.$grosor_borde_simbolos.'px solid '.$color_borde_simbolos.';'; } 
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>

		/* CSS HACK */
		width: <?php echo $simbolos_width+22; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $simbolos_width+20; ?>px;	/* Other browsers */
		width: /**/<?php echo $simbolos_width+20; ?>px;
		
		height: <?php echo $simbolos_width+20; ?>px;
		background-color:#FFFFFF;
				
	}
	
	#dhtmlgoodies_mainContainer div li{

	margin-left:-42px;
	margin-top: -16px;
	
	}
	
	#dhtmlgoodies_mainContainer #big{
		/* CSS HACK */
		width: <?php echo $principal_width+2; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $principal_width; ?>px;	/* Other browsers */
		width: /**/<?php echo $principal_width; ?>px;
		<?php if ($borde_simbolo_principal ==1) { echo 'border: '.$grosor_borde_simbolo_principal.'px solid '.$color_borde_simbolo_principal.';'; }
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>
		height: <?php echo $principal_width; ?>px;
		background-color:#FFFFFF;
	}
	
	#dhtmlgoodies_mainContainer #big img{
	
	padding: 10px;
	margin-top: 10px
	
	}
	
	#dhtmlgoodies_mainContainer #big li{
	
	float:left;
	
	}
	
	#dhtmlgoodies_mainContainer div ul{
		margin-left:2px;
		list-style:none;
	}
	
	#dhtmlgoodies_mainContainer div p{	/* Heading above small boxes */
		margin:0px;
		padding:0px;
		padding-left:12px;
		font-weight:bold;
		background-color:#317082;	
		color:#FFF;	
		margin-bottom:5px;
	}
	
	
	</style>
</head> 
<body> 
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><b><span style="font:Georgia, Times New Roman, Times, serif; font-size:14px;"><b><?php echo utf8_encode("Creador de Paneles de Comunicaci&oacute;n ARASAAC"); ?></span></b></td>
  </tr>
  <tr>
    <td><hr></td>
  </tr>
  <tr>
    <td><br /><?php if ($txt_superior !='') { echo utf8_decode($txt_superior).'<br />'; } ?></td>
  </tr>
  <tr>
    <td><div id="dhtmlgoodies_mainContainer">
      <?php for($i = 1; $i <= $n_items; $i++) { 
		
			if ($i==1) {
			    echo '<div'; if ($principal==1) { echo ' id="big"'; } echo'><ul id="box'.$i.'">';
				if (is_array($box)) {
					if (array_key_exists($i,$box)) {  
					
						$row=$query->datos_archivo_repositorio($box[$i]);
						if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
						elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
						
						$ruta_img='size='.($principal_width-40).'&ruta=../../../../'.$ruta;
						$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
						
						print "<li id=\"node".$box[$i]."\"><img src=\"../../../".$ruta."\" width=\"".($principal_width-20)."\" height=\"".($principal_width-20)."\" border=\"0\"/></li>";  
						
					}
				}
				echo '</ul></div>';
			} else {
				echo '<div><ul id="box'.$i.'">';
				if (is_array($box)) {
					if (array_key_exists($i,$box)) {  
				
					$row=$query->datos_archivo_repositorio($box[$i]);
					if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
					elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
					
					$ruta_img='size='.$simbolos_width.'&ruta=../../../../'.$ruta;
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
					
					print "<li id=\"node".$box[$i]."\"><img src=\"../../../".$ruta."\" width=\"".($simbolos_width+20)."\" height=\"".($simbolos_width+20)."\" border=\"0\"/></li>";  
					}
				}
				echo '</ul></div>';
			}
		
		
		} ?>
    </div></td>
  </tr>
  <tr>
    <td><?php if ($txt_inferior !='') { echo '<br />'.utf8_decode($txt_inferior); } ?></td>
  </tr>
  <tr>
    <td><hr></td>
  </tr>
    <tr>
    <td align="center"><span style="font:Georgia, Times New Roman, Times, serif; font-size:14px;"><strong>&copy; ARASAAC, <?php echo date("Y"); ?></strong></span></td>
  </tr>
</table>
</div>
</body> 
</html>