<?php
session_start();
 
include ('../../classes/querys/query.php');
require_once ('../../classes/img/Image_Toolbox.class.php');
include("../../classes/img/ImageEditor.php");

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

$id_simbolo=$_POST['id_simbolo'];
$id_palabra=$_POST['id_palabra'];
$tipo_simbolo=$_POST['tipo_simbolo'];
$old_tipo_simbolo=$_POST['old_tipo_simbolo'];
$idioma=$_POST['idioma'];
$estado=$_POST['estado'];
$contraste=$_POST['contraste'];

if ($_POST['castellano']=="false") { $castellano=0; } elseif ($_POST['castellano']=="true") { $castellano=1;}
if ($_POST['registrado']=="false") { $registrado=0; } elseif ($_POST['registrado']=="true") { $registrado=1;}
if ($_POST['mayusculas']=="false") { $mayusculas=0; } elseif ($_POST['mayusculas']=="true") { $mayusculas=1;}
if ($_POST['marco']=="false") { $marco=0; } elseif ($_POST['marco']=="true") { $marco=1;}


if ($permisos['borrar_imagenes']==1) {

		$borrar='<a href="javascript:void(0);" onClick="ventana_confirmacion(\'Esta seguro que desea borrar el simbolo seleccionado?\',
			\'300\',\'100\',
			\'inc/gestion_simbolos/borrar_simbolo.php\', 
			\'id='.$id_simbolo.'\', 
			\'informacion_simbolo\',  
			\'inc/gestion_simbolos/listar_simbolos.php\', 
			\'id_tipo_palabra=\'+document.catalogo_simbolos.tipo_palabra.value+\'&letra=\'+document.catalogo_simbolos.letra.value+\'&id_tipo_simbolo=\'+document.catalogo_simbolos.tipo_simbolo.value+\'&idioma=\'+document.catalogo_simbolos.idioma.value+\'\', 
			\'tabla_simbolos\'
			);" /><img src="images/papelera.png" alt="Borrar imagen" border="0" /></a>';
			

} else { 

$borrar='';

}


$actualizar_simbolo=$query->actualizar_simbolo($id_simbolo, $id_palabra, $tipo_simbolo, $idioma, $estado, $castellano, $registrado, $mayusculas, $marco,$contraste);

$d_conf['calidad_75_jpg']=60;
$d_conf['calidad_150_jpg']=60;
$d_conf['calidad_75_png']=50;
$d_conf['calidad_150_png']=80;

 
if ($tipo_simbolo <> $old_tipo_simbolo) {

	$ext=$query->datos_tipo_simbolo($tipo_simbolo);
	$old_ext=$query->datos_tipo_simbolo($old_tipo_simbolo);
				
	if ($ext['ext'] <> $old_ext['ext']) {

		if ($ext['ext']=='jpg') {
		  
		  	$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.jpg', 'jpg', $d_conf['calidad_75_jpg']);  
			
			$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'_150.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.jpg', 'jpg', $d_conf['calidad_150_jpg']);  
			
			$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'_o.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.jpg', 'jpg', $d_conf['calidad_150_jpg']);
			
		  } elseif ($ext['ext']=='png') {
		  
		 	$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'.png', 'png8', $d_conf['calidad_75_png']);  
			
			$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'_150.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_150.png', 'png8', $d_conf['calidad_150_png']);  
			
			$img = new Image_Toolbox('../../repositorio/simbolos/'.$id_simbolo.'_o.'.$old_ext['ext'].'');
		  	$img->save('../../repositorio/simbolos/'.$id_simbolo.'_o.png', 'png8', $d_conf['calidad_150_png']);
			
		  }
	
		unlink ('../../repositorio/simbolos/'.$id_simbolo.'.'.$old_ext['ext'].'');
		unlink ('../../repositorio/simbolos/'.$id_simbolo.'_150.'.$old_ext['ext'].'');
		unlink ('../../repositorio/simbolos/'.$id_simbolo.'_o.'.$old_ext['ext'].'');
  
	}

}

/*echo '$_POST[\'id_simbolo\']:'.$id_simbolo;
echo '$_POST[\'id_palabra\']:'.$id_palabra;
echo '$_POST[\'tipo_simbolo\']:'.$tipo_simbolo;
echo '$_POST[\'idioma\']:'.$idioma;
echo '$_POST[\'estado\']:'.$estado;
echo '$_POST[\'castellano\']:'.$castellano;
echo '$_POST[\'registrado\']:'.$registrado;*/

$row=$query->datos_simbolo($id_simbolo);

// RECOPilO INFORMACION DE LA IMAGEN

$fsize = @filesize("../../repositorio/simbolos/".$row['id_simbolo'].".".$row['ext'])/1024;

	switch ($row['ext']) {
		case "gif":	$src = "gif"; $img = @imagecreatefromgif("../../repositorio/simbolos/".$row['id_simbolo'].".".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpg":		$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/simbolos/".$row['id_simbolo'].".".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpeg":	$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/simbolos/".$row['id_simbolo'].".".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "png":		$src = "png"; $img = @imagecreatefrompng("../../repositorio/simbolos/".$row['id_simbolo'].".".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
	 }
				

echo  '<div class="right" style="height:580px;">
			<h3>Imagen: <div id="products">'.$borrar.'&nbsp;<a href="javascript:void(0);" onClick="sendData(\'repositorio/simbolos/'.$row['id_simbolo']."_150.".$row['ext'].'\');"><img src=\'images/mas.gif\' border="0" alt="a&ntilde;adir s&iacute;mbolo a mi cesto"></a></div>
			    </h3>
			<div class="right_articles" style="height:170px;">
			<br>
			<img src="classes/img/thumbnail.php?size=250&ruta=../../repositorio/simbolos/'.$row['id_simbolo']."_150.".$row['ext'].'&enc=0" border="0"" alt="Mostrar informacion de la imagen"/>	
			</div>
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">
			  <b>Peso: </b>'; printf(" %.2f kB", $fsize);

echo '<br><b>Tama&ntilde;o: </b>'.$img_x.'x'.$img_y.'
		<br><b>A&ntilde;adido: </b>'.$row['fecha_alta'].'
		<br><b>Modificado: </b>'.$row['fecha_modificado'].'
			</div>';

 ?>
	 <h3>Configuraci&oacute;n:</h3>
     <div class="right_articles" style="height:250px;">
<form action="" method="POST" name="config_simbolo" id="config_simbolo">

	<div id="selected_word">
	   <p><strong>Palabra:</strong>
	     <em><strong><?php echo utf8_encode($row['palabra']); ?>,</strong></em>&nbsp;&nbsp;<?php echo utf8_encode($row['definicion']); ?>
	     <input name="id_palabra" type="hidden" id="id_palabra" value="<?php echo $row['id_palabra']?>" />
         <a href="javascript:void(0);" onclick="ventana_modal('','inc/gestion_simbolos/seleccionar_palabra.php');"><img src="images/mas.gif" alt="Seleccionar palabra" border="0" /></a>
	  </p>
	</div>
		
    <p><strong>Tipo S&iacute;mbolo</strong> 
	     <?php $categ3=$query->listar_categorias_simbolos(); ?>
         <select name="tipo_simbolo" class="textos" id="tipo_simbolo" required="1" realname="Categor&iacute;a">
           <option value="<?php echo $row['id_tipo_simbolo']?>"><?php echo $row['tipo_simbolo']?></option>
           <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
           <option value="<?php echo $row_rsCategorias3['id_tipo']?>"><?php echo $row_rsCategorias3['tipo_simbolo']; ?></option>
           <?php }  ?>
         </select>
		 <input name="old_tipo_simbolo" type="hidden" id="old_tipo_simbolo" value="<?php echo $row['id_tipo_simbolo']?>" />
    </p>
	   <p><strong>Idioma</strong> 
	     <?php $idiomas=$query->listar_idiomas(); ?>
         <select name="idioma" class="textos" id="idioma" required="1" realname="Idioma">
           <option value="<?php echo $row[3]?>"><?php if ($row[3]==0) { echo 'Sin idioma'; } else { echo $query->datos_idioma($row[3]); }?></option>
		   <option value="0">Sin idioma</option>
           <?php while ($row_idiomas=mysql_fetch_array($idiomas)) {  ?>
           <option value="<?php echo $row_idiomas['id_idioma']?>"><?php echo $row_idiomas['idioma']; ?></option>
           <?php }  ?>
         </select>
</p>
	   <p>
	     <input name="castellano" type="checkbox" id="castellano" value="1" <?php if ($row['castellano']==1) { echo 'checked'; } ?>/>
&nbsp;Texto en Castellano</p>
	   <p>
	     <input name="mayusculas" type="checkbox" id="mayusculas" value="1" <?php if ($row['mayusculas']==1) { echo 'checked'; } ?>/>
&nbsp;May&uacute;sculas </p>
	   <p>
         <input name="marco" type="checkbox" id="marco" value="1" <?php if ($row['marco']==1) { echo 'checked'; } ?>/>
&nbsp;Con marco </p>
	   <p><strong>Contraste:</strong>
         <select name="contraste" id="contraste">
           <option value="2"  <?php if ($row[7]==2) {echo "SELECTED";} ?>>Alto contraste</option>
           <option value="1"  <?php if ($row[7]==1) {echo "SELECTED";} ?>>Invertido</option>
           <option value="0"  <?php if ($row[7]==0) {echo "SELECTED";} ?>>Normal</option>
         </select>
</p>
	   <p><strong>Estado:</strong>
	        <select name="estado" id="estado">
				<option value="2"  <?php if ($row[8]==2) {echo "SELECTED";} ?>>Pendiente revisi&oacute;n</option>
                <option value="1"  <?php if ($row[8]==1) {echo "SELECTED";} ?>>Visible</option>
                <option value="0"  <?php if ($row[8]==0) {echo "SELECTED";} ?>>No Visible</option>
         </select>
    </p>
	   <p>
         <input name="registrado" type="checkbox" id="registrado" value="1" <?php if ($row['registrado']==1) { echo 'checked'; } ?>/>
&nbsp;Registrado 
<input name="id_simbolo" type="hidden" id="id_simbolo" value="<?php echo $id_simbolo ?>" />
    </p>
    <p align="center">
	     <input type="button" name="Submit" value="Modificar" onclick="cargar_div('inc/gestion_simbolos/modificar_simbolo.php','id_simbolo='+document.config_simbolo.id_simbolo.value+'&id_palabra='+document.config_simbolo.id_palabra.value+'&tipo_simbolo='+document.config_simbolo.tipo_simbolo.value+'&idioma='+document.config_simbolo.idioma.value+'&castellano='+document.config_simbolo.castellano.checked+'&estado='+document.config_simbolo.estado.value+'&registrado='+document.config_simbolo.registrado.checked+'&mayusculas='+document.config_simbolo.mayusculas.checked+'&marco='+document.config_simbolo.marco.checked+'&old_tipo_simbolo='+document.config_simbolo.old_tipo_simbolo.value+'&contraste='+document.config_simbolo.contraste.value+'','informacion_simbolo'); cargar_div('inc/gestion_simbolos/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'','tabla_simbolos');" />
    </p>
</form>
	 <div align="center"></div>
</div>
 
 </div>

