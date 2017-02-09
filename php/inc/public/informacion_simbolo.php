<?php 
session_start();

include ('../../classes/querys/query.php');
$query=new query();

$id_simbolo=$_POST['id'];
$row=$query->datos_simbolo($id_simbolo);

// RECOPilO INFORMACION DE LA IMAGEN

$fsize = @filesize("../../repositorio/simbolos/".$row['id_simbolo']."_150.".$row['ext'])/1024;

	switch ($row['ext']) {
		case "gif":	$src = "gif"; $img = @imagecreatefromgif("../../repositorio/simbolos/".$row['id_simbolo']."_150.".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpg":		$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/simbolos/".$row['id_simbolo']."_150.".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "jpeg":	$src = "jpeg"; $img = @imagecreatefromjpeg("../../repositorio/simbolos/".$row['id_simbolo']."_150.".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
		case "png":		$src = "png"; $img = @imagecreatefrompng("../../repositorio/simbolos/".$row['id_simbolo']."_150.".$row['ext']); $img_y = imagesy($img); $img_x = imagesx($img); break;
	 }
				

echo  '<div class="right" style="height:580px;">
			<h3>Imagen: </h3><div id="products" style="float:right;">'.$borrar.'&nbsp;<a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$row['id_simbolo'].'_o.'.$row['ext'].'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir s&iacute;mbolo a mi cesto"></a></div>			<br>
			    
			<div align="center">
			<img src="classes/img/thumbnail.php?size=250&ruta='.md5("../../").'/'.md5("repositorio/simbolos/").'/'.$row['id_simbolo']."_150.".$row['ext'].'" border="0"" alt="Mostrar informacion de la imagen"/>	
			</div>
			<h3>Informaci&oacute;n:</h3>
			<div class="right_articles">
			  <b>Peso: </b>'; printf(" %.2f kB", $fsize);

echo '<br><b>Tama&ntilde;o: </b>'.$img_x.'x'.$img_y.'
		<br><b>A&ntilde;adido: </b>'.$row['fecha_alta'].'
		<br><b>Modificado: </b>'.$row['fecha_modificado'].'
			</div>';

 ?>
<h3>Configuraci&oacute;n: </h3>
<div class="right_articles" style="height:200px;">
	<div id="selected_word">
	   <p><strong>Palabra:</strong>
	     <em><strong><?php echo utf8_encode($row['palabra']); ?>,</strong></em>&nbsp;&nbsp;<?php echo utf8_encode($row['definicion']); ?><a href="javascript:void(0);" onclick="ventana_modal('','inc/gestion_simbolos/seleccionar_palabra.php');"></a>	  </p>
	</div>
		
	   <p><strong>Tipo S&iacute;mbolo:</strong> 
	     <?php $categ3=$query->listar_categorias_simbolos(); ?>
    <?php echo $row['tipo_simbolo']?></p>
	   <p><strong>Idioma</strong> 
	     <?php 
		 $idiomas=$query->listar_idiomas(); 
		 if ($row[3]==0) { echo 'Sin idioma'; } else { echo $query->datos_idioma($row[3]); }
		 ?>
  </p>
		<strong>Texto:</strong><br />
	   <p>
	     	<?php if ($row['castellano']==1) { echo '<li>Texto en Castellano</li>'; } else { echo '<li>Sin texto</li>'; } ?> 
  </p>
	   <p>
	     	<?php if ($row['mayusculas']==1) { echo '<li>Texto en may&uacute;sculas</li>'; } else { echo '<li>Texto en min&uacute;sculas</li>'; } ?> 
  </p>
	   <p>
         	<strong>Marco:</strong> <?php if ($row['marco']==1) { echo 'Con marco'; } else { echo 'Sin marco'; } ?>
	   </p>
	   <p><strong>Contraste:</strong>
           <?php if ($row[7]==2) {echo "Alto contraste";} ?>
           <?php if ($row[7]==1) {echo "Invertido";} ?>
           <?php if ($row[7]==0) {echo "Normal";} ?>
  </p>
    <p align="center">&nbsp;</p>
	 <div align="center"></div>
</div>
 
 </div>