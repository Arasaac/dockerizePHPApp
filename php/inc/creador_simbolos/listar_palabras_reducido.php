<?php  
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
		$cantidad=10; // cantidad de resultados por p&aacute;gina 
		$inicial = $pg * $cantidad;
		
		$contar=$query->listar_diccionario_palabras_con_imagenes($id_tipo,$letra);
		$pegar=$query->listar_diccionario_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<div align="left">
  <table width="100%" border="0"  height="460" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody>
         <?php
	  $color = 'tablaAlterno1';
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		?>
         <tr class="<?php echo $color; ?>" height="2%">
           <td width="8%" valign="top"><span style="width:500px; height:300px;"> <a href="javascript:void(0);" onclick="seleccionar_palabra_creador('<?php echo $entrada['id_palabra']; ?>');" /> <img src="images/seleccionar.gif" alt="Seleccionar palabra" border="0" /> </a></span></td>
           <td width="10%" align="left" valign="top"><?php echo $entrada['id_palabra']; ?></td>
           <td width="19%" align="left" valign="top"><?php echo $entrada['palabra']; ?></td>
           <td width="63%" align="left" valign="top"><span style="width:80%;"><?php if (strlen($entrada['definicion']) > 175) { echo substr(utf8_encode($entrada['definicion']),0,175)."..."; } else {  echo utf8_encode($entrada['definicion']);  }?></span></td>
         </tr>
         <?php } ?>
       </tbody>
  </table></td>
    </tr>
    <tr>
      <td><table width="100%" height="30" border="0" align="left" cellpadding="0" cellspacing="2">
       <tr class="textos">
         <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="Submit" value="&lt;&lt;" onclick="cargar_div('inc/creador_simbolos/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&amp;letra='+document.vm_diccionario.letra.value+'&amp;pg=0','tabla_palabras');" />
         </td>
         <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
             <?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
             <input type="button" name="Submit2" value="&lt; Anterior" onclick="cargar_div('inc/creador_simbolos/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&amp;letra='+document.vm_diccionario.letra.value+'&amp;pg=<?php echo $url ?>','tabla_palabras');" />
         </div></td>
         <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
         <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
             <?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
             <input type="button" name="Submit2" value="Siguiente &gt;" onclick="cargar_div('inc/creador_simbolos/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&amp;letra='+document.vm_diccionario.letra.value+'&amp;pg=<?php echo $url ?>','tabla_palabras');" />
         </div></td>
         <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick="cargar_div('inc/creador_simbolos/listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&amp;letra='+document.vm_diccionario.letra.value+'&amp;pg=<?php echo $pages; ?>','tabla_palabras');" /></td>
       </tr>
     </table></td>
    </tr>
  </table>

    
      
 
</div>
</br>
</div>