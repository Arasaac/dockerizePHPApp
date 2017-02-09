<?php 
session_start();

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$color='#000000';

if (isset($_POST['img']) && $_POST['img'] !='' && isset($_POST['id_palabra']) && $_POST['id_palabra'] !='') {

	$id_palabra=$_POST['id_palabra'];
	$datos_palabra=$query->datos_palabra($_POST['id_palabra']);
	$idiomas_disponibles=$query->idiomas_disponibles($id_palabra,1);
	$tipos_imagen=$query->listar_tipos_imagen();
	
	$id_tipo_palabra=$datos_palabra['id_tipo_palabra'];
	
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

	$dir="../../temp/";
	$borrar=CleanFiles($dir); //Borro los archivos temporales
	$nombre_img=basename(tempnam("../../temp",'tmp')); 
	
	$imagen_original=$_POST['img'];
	$extension = strtolower(substr(strrchr($imagen_original, "."), 1));
	
	$nueva_imagen=$nombre_img.'.'.$extension;
	
	copy ('../../repositorio/originales/'.$imagen_original,'../../temp/'.$nueva_imagen);
	
	$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
	$encript->encriptar($ruta_cesto,1);
					
	$usar_imagen='<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a></div><br><div align="center"><img src=\'temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';
	
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty">'.utf8_encode($datos_palabra['palabra']).'</textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="'.$datos_palabra['id_palabra'].'" size="3" maxlength="3" /> <br><em><strong>'.utf8_encode($datos_palabra['palabra']).',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'<br><br><strong>Idiomas disponibles</strong><br>';
	
	$palabra_seleccionada.=idiomas_disponibles($id_palabra,$idiomas_disponibles);
	
	$imagenes_disponibles=imagenes_disponibes($tipos_imagen,$query,$datos_palabra['id_palabra']);

} else {

	$usar_imagen='';
	$id_palabra='';
	$palabra_seleccionada='<textarea name="palabra" cols="25" rows="2" id="palabra" class="fonty"></textarea>  <input name="id_palabra" type="hidden" id="id_palabra" value="" size="3" maxlength="3" /> <input name="idioma" type="hidden" id="idioma" value="0" />';
	$imagenes_disponibles='';

}
?>
<div class="left" style="height:650px;">
  <h3>CREADOR DE ANIMACIONES v 0.1:</h3>
  <div class="left_box">
<div id="simbolo" align="center"></div>
</div>
</div>	
<div class="right">
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<!-- PRIMER ITEM -->
<h3><a  href="javascript:void();" onClick="shoh('imagen1');" ><img src="images/u.gif" alt="Desplegar opciones" name="imgimagen1" width="9" height="9" border="0" ></a>&nbsp;Crear</h3>
<p>Por el momento el creador coge las im&aacute;genes que est&aacute;n en el &quot;carro de la compra&quot; (en el orden en el que se hayan a&ntilde;adido) para elaborar la animaci&oacute;n. Esta es, &uacute;nicamente, una versi&oacute;n inicial que se ir&aacute; desarrollando y perfeccionando. </p>
<div style="display:block;" id="imagen1" >
			
		    <div align="center">
                      <p>
                        <input type="button" name="Submit2" value="Previsualizar" onclick="cargar_div('classes/gifmerge/procesar.php','milisegundos='+document.form1.milisegundos.value+'&loops='+document.form1.loops.value+'','simbolo');" />
                      </p>
            </div>	
			
	</div>
<p>&nbsp;</p>
<!-- CUARTO ITEM -->	                        
<h3><a  href="javascript:void();" onClick="shoh('imagen4');" ><img src="images/u.gif" alt="" name="imgimagen4" width="9" height="9" border="0" ></a>&nbsp;Intervalo de tiempo entre s&iacute;mbolos</h3>

	<div style="display: block;" id="imagen4" >	      
  		<p>
  		  <input name="milisegundos" type="text" id="milisegundos" value="100" size="3" maxlength="3"/>
  		milisegundos (1 segundo = 100 milisegundos)</p>
	</div>
	

<!-- LIENZAO ITEM -->	                        
<h3><a  href="javascript:void();" onClick="shoh('imagen7');" ><img src="images/u.gif" alt="" name="imgimagen7" width="9" height="9" border="0" ></a>&nbsp;Repeticiones</h3>

	<div style="display: block;" id="imagen7" >	      
  		<p>Loops: 
  		  <input name="loops" type="text" id="loops" value="0" size="2" maxlength="2"/>
  		  0 equivale a Infinitas
	  </p>
	</div>
	

<!-- CUARTO ITEM -->
</form>
		
	</div>
		
</div>
