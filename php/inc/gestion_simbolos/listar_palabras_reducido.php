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
		
		$contar=$query->listar_diccionario_palabras($id_tipo,$letra);
		$pegar=$query->listar_diccionario_palabras_limit($id_tipo,$letra,$inicial,$cantidad);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
 <table cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th field="Id" dataType="Number">&nbsp;</th>
        <th align="left" field="Id" dataType="Number">Id</th>
        <th align="left" field="Name" dataType="String">Palabra</th>
        <th align="left" dataType="html">Acepcion</th>
      </tr>
    </thead>
   <tbody>
      <?php
	  $color = 'tablaAlterno1';
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		?>
      <tr class="<?php echo $color; ?>">
        <td><span style="width:500px; height:300px;">
          <input type="button" name="Submit2" value="S" onclick="cargar_div('inc/gestion_simbolos/palabra_seleccionada.php','id=<?php echo $entrada['id_palabra']; ?>','selected_word'); Dialog.closeInfo();" />         </span></td>
        <td align="left"><?php echo $entrada['id_palabra']; ?></td>
        <td align="left"><?php echo utf8_encode($entrada['palabra']); ?></td>
        <td align="left"><div id="palabra_<?php echo $entrada['id_palabra']?>"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
</div>
</br>
   <table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/creador_simbolos/listar_palabras_reducido.php","id_tipo="+document.vm_diccionario.tipo_palabra.value+"&letra="+document.vm_diccionario.letra.value+"&pg=0","tabla_palabras");'>              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/creador_simbolos/listar_palabras_reducido.php","id_tipo="+document.vm_diccionario.tipo_palabra.value+"&letra="+document.vm_diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_palabras");'>
              </div></td>
              <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/creador_simbolos/listar_palabras_reducido.php","id_tipo="+document.vm_diccionario.tipo_palabra.value+"&letra="+document.vm_diccionario.letra.value+"&pg=<?php echo $url ?>","tabla_palabras");'>
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/creador_simbolos/listar_palabras_reducido.php","id_tipo="+document.vm_diccionario.tipo_palabra.value+"&letra="+document.vm_diccionario.letra.value+"&pg=<?php echo $pages; ?>","tabla_palabras");'></td>
            </tr>
</table>      
