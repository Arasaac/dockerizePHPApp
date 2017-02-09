<?php 
session_start();
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
require ('../../../classes/languages/language_detect.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],28);
$color='#000000';

$categ2=$query->listar_tipos_imagen();
$autores=$query->listar_autores();
$licencias=$query->listar_licencias();

if (isset($_POST['form']) && $_POST['form']=='add_pictograms' && isset($_POST['palabras_seleccionadas']) && $_POST['palabras_seleccionadas'] != '') {

$palabras_seleccionadas=$_POST['palabras_seleccionadas'];
$tipo_pictograma=$_POST['tipo_picto'];
$estado=$_POST['estado'];
$id_licencia=$_POST['licencia'];
$id_autor=$_POST['autor'];
$tags=$_POST['tags'];

$tags=explode(',',$tags);

for ($i=0;$i<count($tags);$i++) { 
  	if ($tags[$i]!='') {
		$tags_convertidos.='{'.$tags[$i].'}';
	}
}

if ($_POST['registrado']=="false") { $registrado=0; } elseif ($_POST['registrado']=="true") { $registrado=1;}
if ($_POST['validos_senyalectica']=="false") { $validos_senyalectica=0; } elseif ($_POST['validos_senyalectica']=="true") { $validos_senyalectica=1;}

//---------------------------------------------------------------
//RECOJO LOS PICTOGRAMAS DE COLOR A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

	if (isset($_POST['usar_color']) && $_POST['usar_color'] !='') {
			
		foreach ($_POST['usar_color'] as $indice=>$valor){ 
			
			$url=$_POST['usar_color'][$indice]; //Importante es el indice no el valor
			
			$id_tipo_imagen=10;
			
			$nueva_imagen=$query->add_new_picture(1,$id_tipo_imagen,$url,$palabras_seleccionadas,$estado,$registrado,$id_autor,$id_licencia,$tags_convertidos,$tipo_pictograma,$validos_senyalectica,$url);
			
			copy("../../../importar/color/".$url."","../../../repositorio/originales/".$nueva_imagen."");
			unlink("../../../importar/color/".$url."");			
			
												
		}
	}
	
	//---------------------------------------------------------------
//RECOJO LOS PICTOGRAMAS DE BYN A USAR Y LAS PALABRAS ASIGNADAS A CADA UNA
//---------------------------------------------------------------

	if (isset($_POST['usar_byn']) && $_POST['usar_byn'] !='') {
			
		foreach ($_POST['usar_byn'] as $indice=>$valor){ 
			
			$url1=$_POST['usar_byn'][$indice]; //Importante es el indice no el valor
			
			$id_tipo_imagen1=5;
			
			$nueva_imagen1=$query->add_new_picture(1,$id_tipo_imagen1,$url1,$palabras_seleccionadas,$estado,$registrado,$id_autor,$id_licencia,$tags_convertidos,$tipo_pictograma,$validos_senyalectica,$url1);
			
			copy("../../../importar/byn/".$url1."","../../../repositorio/originales/".$nueva_imagen1."");
			unlink("../../../importar/byn/".$url1."");			
			
												
		}
	}
	
	$mensaje='<br /><div class="mensaje" align="center">Pictogramas añadidos</div><br />';
	
} //Cierro el IF de comprobar si se ha enviado el formulario
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARASAAC: GESTOR DE PICTOGRAMAS</title>
<script type="text/javascript" src="../js/ajax_herramientas.js"></script>
<script type="text/javascript" src="../../../js/prototype/prototype.js"> </script> 
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/effects.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/window.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/debug.js"> </script>
<script type="text/javascript" src="../../../js/windows_js_0.96.2/javascripts/window_effects.js"> </script> 
    
<link href="../../../js/windows_js_0.96.2/themes/default.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alphacube.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alert.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/alert_lite.css" rel="stylesheet" type="text/css" >	 </link>
<link href="../../../js/windows_js_0.96.2/themes/spread.css" rel="stylesheet" type="text/css" ></link> 
<link href="../../../js/windows_js_0.96.2/themes/debug.css" rel="stylesheet" type="text/css" ></link>
<link rel="stylesheet" href="../../../css/style.css" type="text/css" />
<link rel="STYLESHEET" type="text/css" href="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.css">

<script  src="../js/dhtmlxTabbar/codebase/dhtmlxcommon.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar.js"></script>
<script  src="../js/dhtmlxTabbar/codebase/dhtmlxtabbar_start.js"></script>

<script type="text/javascript" src="../js/color/picker.js"></script> 
<script>
function selydestodos(form,activa)
{
for(i=0;i<form.elements.length;i++)
if(form.elements[i].type=="checkbox")
form.elements[i].checked=activa;
}

function muestra(n){

	cargar_div2('formularios_configuracion.php','id='+n+'','configuracion'); 
 
}
</script>  
</head>
<body>
<div class="body_content">
<div id="principal">
<form action="<?php echo $PHP_SELF; ?>" method="post" name="form1" id="form1">
<div id="mi_repositorio">
 <h4 style="text-transform:uppercase;">GESTOR DE PICTOGRAMAS</h4>
 <?php echo $mensaje; ?>
      <table width="100%" border="0">
        <tr>
          <td colspan="2" align="left" valign="top"><div class="left" style="height:470px; width:100%;">
            <div class="left_box">
              <div id="b_tabbar" class="dhtmlxTabBar" imgpath="../js/dhtmlxTabbar/codebase/imgs/" style="width:100%; height:470px;"  skinColors="#FCFBFC,#F4F3EE" >
                
<div id="b2" name="PICTOGRAMAS COLOR" style="padding:10px; text-align:left;">
  <ul id="thelist2" style="height:5000px; overflow:auto; width:100%; border:none; float:left;">
    <?php 
$directorio = opendir("../../../importar/color/");
$r=0;

	while ($archivo = readdir($directorio)) {	
	if ($r < 51) {	
		 if (($archivo != '.') && ($archivo != '..')) {
			 
		  $ruta="importar/color/".$archivo;
		  $ruta_img='size=30&ruta=../../../../'.$ruta;
		  $encript->encriptar($ruta_img,1); 
		 
		  $ruta_cesto='ruta_cesto='.$ruta;
		  $encript->encriptar($ruta_cesto,1);
		  $extension = strtolower(substr(strrchr($ruta, "."), 1));
										
			echo "<li id=\"thelist2_".$r."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a><br /><input name=\"name_color[".$r."]\" type=\"text\" value=\"".$archivo."\"value=\"40\" size=\"11\"  disabled/><br /><input name=\"usar_color[".$r."]\" type=\"checkbox\" value=\"".$archivo."\" /></li>";
			
			$r++;
			}
	 	}
	 }
closedir($directorio); 
		?>				
  </ul>
                    
</div>

<div id="b1" name="PICTOGRAMAS ByN" style="padding:10px; text-align:left;">
<ul id="thelist2" style="height:5000px; overflow:auto; width:100%; border:none; float:left;">
    <?php 
$directorio1 = opendir("../../../importar/byn/");
$y=0;

	while ($archivo1 = readdir($directorio1)) {	
	if ($y < 51) {	
     if (($archivo1 != '.') && ($archivo1 != '..')) {
		 
      $ruta1="importar/byn/".$archivo1;
      $ruta_img1='size=30&ruta=../../../../'.$ruta1;
      $encript->encriptar($ruta_img1,1); 
     
	  $ruta_cesto1='ruta_cesto='.$ruta1;
      $encript->encriptar($ruta_cesto1,1);
	  $extension1 = strtolower(substr(strrchr($ruta1, "."), 1));
									
   		echo "<li id=\"thelist2_".$y."\" style=\"cursor:pointer; background-color:#FFFFFF;\" onmousemove=\"populateHiddenVars();\"><img src=\"../classes/img/thumbnail.php?i=".$ruta_img1."\" border=\"0\"/></a><br /><input name=\"name_byn[".$y."]\" type=\"text\" value=\"".$archivo1."\"value=\"40\" size=\"11\"  disabled/><br /><input name=\"usar_byn[".$y."]\" type=\"checkbox\" value=\"".$archivo1."\" /></li>";
		
		$y++;
	 	}
	   }
	 }
closedir($directorio1); 
		?>				
  </ul>
                    
</div>
                  
<div id="b3" name="OPCIONES" style="padding:10px; text-align:left;">
        
        <!--OPCIONES-->        
                
			 <div>
			   <p><strong>Estado:</strong>
                  <select name="estado" id="estado">
                    <option value="2">Pendiente revisi&oacute;n</option>
                    <option value="1" selected="selected">Visible</option>
                    <option value="0">No Visible</option>
                  </select>
				  <input name="form" type="hidden" id="form" value="add_pictograms" />
			   </p>
                <p><strong>Tipo de pictograma:</strong>
                  <select name="tipo_picto" id="tipo_picto">
                    <option value="2">Esquem&aacute;tico</option>
                    <option value="1" selected="selected">Realista</option>
                  </select>
                </p>
                <p><strong>Autor:</strong> 
                  <select name="autor" id="autor" required="1" realname="Autor" class="fonty">
                    <?php
						while ($row_rsAutor=mysql_fetch_array($autores)) { 
		  			  ?>
                    <option value="<?php echo $row_rsAutor['id_autor']?>" <?php if ($row_rsAutor['id_autor']==2) {echo "SELECTED";} ?>><?php echo utf8_encode($row_rsAutor['autor']); ?></option>
                    <?php 
			 		 }  // Cierro el While ?>
                  </select>
                </p>
                <p><strong>Licencia:</strong>
                  <select name="licencia" id="licencia" required="1" realname="Categor&iacute;a" class="fonty">
                    <?php
						while ($row_rsLicencia=mysql_fetch_array($licencias)) { 
					?>
                    <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row_rsLicencia['id_licencia']==2) {echo "SELECTED";} ?>><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
                    <?php 
			 		 }  // Cierro el While ?>
                  </select>
				</p>
                <p><strong>Tags: </strong></p>
                <p>
                  <label>
                  <textarea name="tags" cols="30" rows="3" id="tags"></textarea>
                  </label>
                </p>
               <p>
             <input name="registrado" type="checkbox" id="registrado" value="1"/>
  &nbsp;<strong>Registrado</strong> 
  <input name="validos_senyalectica" type="checkbox" id="validos_senyalectica" value="1" />
&nbsp;V&aacute;lido Se&ntilde;al&eacute;ctica<br /></p>
			 </div>
             <br />
             <br />
             <p><a href="javascript:void(0);" onclick="Dialog.alert({url: 'seleccionar_palabra.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:450}, okLabel: 'Cerrar'});"><img src="../../../images/mas.gif" alt="Asociar palabra a imagen" border="0" /></a>Palabra/acepci&oacute;n:</p>
             <p>
               <label>
               <input type="hidden" name="palabras_seleccionadas" id="palabras_seleccionadas" />
               </label>
             </p>
             <div class="right_articles" style="height:30px;">
			<div id="selected_word">
			
			  <div align="center">
				  <br><br>
			  </div> 
			</td>
        </tr>
        </table>
 </div>
</form>
</div>     
    </div>
</body>
</html>