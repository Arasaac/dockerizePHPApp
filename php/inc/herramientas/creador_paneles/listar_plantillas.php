<?php  
session_start();
$id_usuario=$_SESSION['ID_USER'];
include ('../../../classes/querys/query.php');
$query=new query();
$letra="";
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
		
		$contar=$query->listar_plantillas_por_palabra($letra);
		$pegar=$query->listar_plantillas_por_palabra_limit($letra,$inicial,$cantidad);
		
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
           <td width="14%" valign="middle"><span style="width:500px; height:300px;"> <a href="<?php echo $PHP_SELF ?>?id_plantilla=<?php echo $entrada['id_template_panel']; ?>&id_panel=<?php echo $_POST['id_panel']; ?>" target="_self"/> <img src="../../../images/seleccionar.gif" alt="Seleccionar palabra" border="0" /> </a></span></td>
           <td width="33%" align="left" valign="middle"><?php echo $entrada['nombre_panel']; ?></td>
           <td width="53%" align="left" valign="middle"><span style="width:80%;"><?php if (strlen($entrada['tags_panel']) > 175) { echo substr(utf8_encode($entrada['tags_panel']),0,175)."..."; } else {  echo utf8_encode($entrada['tags_panel']);  }?></span></td>
         </tr>
         <?php } ?>
       </tbody>
  </table></td>
    </tr>
    <tr>
      <td><table width="100%" height="30" border="0" align="left" cellpadding="0" cellspacing="2">
       <tr>
         <td width="59%" align="right" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="right">
           <input type="button" name="Submit" value="&lt;&lt;" onclick="cargar_div('listar_plantillas.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=0','tabla_palabras');" />         
         </div></td>
         <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
             <?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
             <input type="button" name="Submit2" value="&lt; Anterior" onclick="cargar_div('listar_plantillas.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $url ?>','tabla_palabras');" />
         </div></td>
         <td width="3%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
         <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
             <div align="left">
               <?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
               <input type="button" name="Submit2" value="Siguiente &gt;" onclick="cargar_div('listar_plantillas.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $url ?>','tabla_palabras');" />
                </div></td>
         <td width="20%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="left">
           <input type="button" name="button" value="&gt;&gt;" onclick="cargar_div('listar_plantillas.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $pages; ?>','tabla_palabras');" />
         </div></td>
       </tr>
     </table></td>
    </tr>
  </table>

    
      
 
</div>
</br>
</div>