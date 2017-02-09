<?php  
session_start();

include ('../../classes/querys/query.php');

$query=new query();

$id_tema="";
$id_subtema="";

$id_tema=$_POST['id_tema'];
$id_subtema=$_POST['id_subtema'];
		
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
		
		$contar=$query->listar_palabras_categorias($id_tema,$id_subtema);
		$pegar=$query->listar_palabras_categorias_limit($id_tema,$id_subtema,$inicial,$cantidad);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<br /><h3>Resultado de la b&uacute;squeda </h3><br />
 <table cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th field="Name" dataType="String"><div align="left"><strong>Palabra</strong></div></th>
        <th field="DateAdded" dataType="Date" sort="asc"><div align="left"><strong>Acepci&oacute;n</strong></div></th>
        <th dataType="html"><div align="left"><strong>Tema/Subtema</strong></div></th>
        <th dataType="html"><div align="left"><strong>Im&aacute;genes</strong></div></th>
        <th dataType="html"><div align="left"><strong>S&iacute;mbolos </strong></div></th>
      </tr>
    </thead>
   <tbody>
      <?php
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$imagenes=$query->imagenes_por_palabra($entrada['id_palabra'],$_SESSION['AUTHORIZED']);
		$num_imagenes=mysql_num_rows($imagenes);
		$simbolos=$query->simbolos_por_palabra($entrada['id_palabra'],$_SESSION['AUTHORIZED']);
		$num_simbolos=mysql_num_rows($simbolos);
		?>
      <tr>
        <td><div align="left"><?php echo utf8_encode($entrada['palabra']); ?></div></td>
        <td><div align="left"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
        <td style="color:#669966;"><?php echo utf8_encode($entrada['tema']).'/'.utf8_encode($entrada['subtema']); ?></td>
        <td><div align="center">
          <?php if ($num_imagenes==0) {  echo '<img src="images/no_visible.gif" alt="'.utf8_encode("No hay imágenes disponibles").'" border="0">';} else { echo '<a href="javascript:void(0);" onClick="cargar_div(\'inc/public/previsualizacion.php\',\'id_palabra='.$entrada['id_palabra'].'&mostrar=imagenes\',\'previsualizacion\');" /><img src="images/visible.gif" alt="'.utf8_encode("Hay imágenes disponibles").'" border="0"></a>';} ?>
        </div></td>
        <td><div align="center">
          <?php if ($num_simbolos==0) {  echo '<img src="images/no_visible.gif" alt="'.utf8_encode("No hay imágenes disponibles").'" border="0">';} else { echo '<a href="javascript:void(0);" onClick="cargar_div(\'inc/public/previsualizacion.php\',\'id_palabra='.$entrada['id_palabra'].'&mostrar=simbolos\',\'previsualizacion\');" /><img src="images/visible.gif" alt="'.utf8_encode("Hay imágenes disponibles").'" border="0"></a>';} ?>
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
                  <input type="button" name="Submit" value="&lt;&lt;" onclick='cargar_div("inc/public/listar_categorias.php","id_tema="+document.diccionario.id_tema.value+"&id_subtema="+document.diccionario.id_subtema.value+"&pg=0","tabla_categorias"); cargar_div("inc/public/previsualizacion.php","i=","previsualizacion");'>              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick='cargar_div("inc/public/listar_categorias.php","id_tema="+document.diccionario.id_tema.value+"&id_subtema="+document.diccionario.id_subtema.value+"&pg=<?php echo $url ?>","tabla_categorias"); cargar_div("inc/public/previsualizacion.php","i=","previsualizacion");'>
              </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick='cargar_div("inc/public/listar_categorias.php","id_tema="+document.diccionario.id_tema.value+"&id_subtema="+document.diccionario.id_subtema.value+"&pg=<?php echo $url ?>","tabla_categorias"); cargar_div("inc/public/previsualizacion.php","i=","previsualizacion");'>
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick='cargar_div("inc/public/categorias.php","id_tema="+document.diccionario.id_tema.value+"&id_subtema="+document.diccionario.id_subtema.value+"&pg=<?php echo $pages; ?>","tabla_categorias"); cargar_div("inc/public/previsualizacion.php","i=","previsualizacion");'></td>
            </tr>
</table>      