<?php  
session_start();

include ('../../classes/querys/query.php');

$query=new query();

$id_tipo="";
$letra="";

$id_tipo_simbolo=$_POST['id_tipo_simbolo'];
$id_tipo_palabra=$_POST['id_tipo_palabra'];
$letra=$_POST['letra'];
$idioma=$_POST['idioma'];
		
/* ******************************************************************************************* */ 
/*                            LISTAR SIMBOLOS 												   */
/* ******************************************************************************************* */ 

	
		if(!isset($_POST['pg'])){ 
		  $pg = "0"; 
		} else {
		  $pg = $_POST['pg'];
		}
		$cantidad=10; // cantidad de resultados por p&aacute;gina 
		$inicial = $pg * $cantidad;
		
		$contar=$query->listar_simbolos($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$_SESSION['AUTHORIZED']);
		$pegar=$query->listar_simbolos_limit($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$inicial,$cantidad,$_SESSION['AUTHORIZED']);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<br /><h3>Resultado de la b&uacute;squeda </h3><br />
 <table cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th width="2%" field="Name" dataType="String"><div align="left"><strong>Opc.</strong></div></th>
        <th width="15%" datatype="html"><div align="left"><strong>Simbolo </strong></div></th>
        <th width="25%" field="DateAdded" datatype="Date" sort="asc"><div align="left"><strong>Palabra</strong></div></th>
        <th width="25%" field="DateAdded" dataType="Date" sort="asc"><div align="left"><strong>Acepci&oacute;n</strong></div></th>
        <th width="40%" field="DateAdded" dataType="Date" sort="asc"><strong>Modificado</strong></th>
      </tr>
    </thead>
   <tbody>
      <?php
	  $color = 'tablaAlterno1';
	  
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		?>
      <tr class="<?php echo $color; ?>">
        <td width="2%"><div align="left"><?php echo '<div id="products"><a href="javascript:void(0);" onClick="sendData(\''.md5("repositorio/simbolos/").'/'.$entrada['id_simbolo'].'_o.'.$entrada['ext'].'\');"><img src=\'images/cesto.gif\' border="0" alt="A&ntilde;adir s&iacute;mbolo a mi cesto"></a>'; ?></div></td>
        <td width="15%"><div align="left"><?php echo '<a href="javascript:void(0);" onClick="cargar_div(\'inc/public/informacion_simbolo.php\',\'id='.$entrada['id_simbolo'].'\',\'informacion_simbolo\');" /><img src="classes/img/thumbnail.php?size=50&ruta='.md5("../../").'/'.md5("repositorio/simbolos/").'/'.$entrada['id_simbolo'].'.'.$entrada['ext'].'" border="0"" alt="Mostrar informacion del s&iacute;mbolo"/></a>'; ?> </div></td>
        <td width="25%"><div align="left"><?php echo utf8_encode($entrada['palabra']); ?></div></td>
        <td width="25%"><div align="left"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
        <td width="40%"><?php echo $entrada['fecha_modificado']; ?></td>
      </tr>
      <?php } ?>
   </tbody>
</table>
 </div>
</br>
   <table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick="cargar_div('inc/public/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=0','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick="cargar_div('inc/public/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $url ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">
              </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick="cargar_div('inc/public/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $url ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick="cargar_div('inc/public/listar_simbolos.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $pages ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');"></td>
            </tr>
</table>      