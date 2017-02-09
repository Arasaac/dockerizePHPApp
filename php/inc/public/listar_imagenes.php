<?php  
session_start();

include ('../../classes/querys/query.php');

$query=new query();

$id_tipo="";
$letra="";

$id_tipo=$_POST['id_tipo'];
$letra=$_POST['letra'];
		
/* ******************************************************************************************* */ 
/*                            LISTAR PALABRAS 												   */
/* ******************************************************************************************* */ 

	
		if(!isset($_POST['pg'])){ 
		  $pg = "0"; 
		} else {
		  $pg = $_POST['pg'];
		}
		$cantidad=5; // cantidad de resultados por p&aacute;gina 
		$inicial = $pg * $cantidad;
		
		$contar=$query->listar_palabras_con_imagenes($id_tipo,$letra,$_SESSION['AUTHORIZED']);
		$pegar=$query->listar_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad,$_SESSION['AUTHORIZED']);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<br /><h3>Resultado de la b&uacute;squeda </h3><br />
 <table cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th width="72" field="Name" dataType="String"><div align="left"><strong>Palabra</strong></div></th>
        <th width="62" field="DateAdded" dataType="Date" sort="asc"><div align="left"><strong>Acepci&oacute;n</strong></div></th>
        <th width="125" dataType="html"><div align="left"><strong>Im&aacute;genes disponibles </strong></div></th>
      </tr>
    </thead>
   <tbody>
      <?php
	  $color = 'tablaAlterno1';
	  
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		$estado=1;
		$result=$query->imagenes_por_palabra($entrada['id_palabra'],$_SESSION['AUTHORIZED'],$estado);
	
		?>
      <tr class="<?php echo $color; ?>">
        <td valign="top"><div align="left"><strong><?php echo utf8_encode($entrada['palabra']); ?></strong></div></td>
        <td valign="top"><div align="left"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
        <td valign="top">
		  <div align="left">
		    <?php
		$content="";
		$simbol=array();
		
		
		while ($row=mysql_fetch_array($result)) { 
			
			$simbol[]='<td>
			<div id="img_'.$row['id_imagen'].'">
			<a href="javascript:void(0);" onClick="cargar_div(\'inc/public/informacion_imagen.php\',\'id='.$row['id_imagen'].'\',\'informacion_imagen\');" /><img src="classes/img/thumbnail.php?size=50&ruta='.md5("../../").'/'.md5("repositorio/originales/").'/'.$row['imagen'].'" border="0"" alt="Mostrar informacion de la imagen"/></a><br><div id="products"><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/originales/").'/'.$row['imagen'].'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir imagen a mi cesto"></a>&nbsp;<a href="javascript:void(0);" onClick="cargar_div(\'inc/creador_simbolos/creador_simbolos.php\',\'img='.$row['imagen'].'&id_palabra='.$row['id_palabra'].'\',\'principal\');"><img src=\'images/paint.gif\' border="0" alt="Utilizar imagen en el creador"></a>
			    </div>
			</div>
		</td>';
		} 
		
		$o=0;
		$content.='<table style="text-align:left;">';
			for ($i=1; $i<=20; $i++){ // FILAS
				$content.="<tr>"; 
					for ($e=1; $e<=3; $e++){ //COLUMNAS 
						$file=$simbol[$o];
							if ($file=="") { break; }
							$content.=$file;  
							$o++;
					} 
				$content.="</tr>"; 
			} 
		$content.='</table>';
		echo $content;
		
		?>		
        </div></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
 </div>
</br>
   <table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/public/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=0","tabla_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/public/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>
              </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/public/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'>
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/public/listar_imagenes.php","id_tipo="+document.diccionario.tipo_palabra.value+"&letra="+document.diccionario.letra.value+"&pg=<?php echo $pages; ?>","tabla_imagenes"); cargar_div("inc/gestion_imagenes/limpiar_cuadro_informacion.php","i=","informacion_imagen");'></td>
            </tr>
</table>      