<?php  
session_start();

include ('../../classes/querys/query.php');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 

$encript = new E5CR($llave);
$query=new query();

$id_tipo="";
$letra="";

$id_tipo_simbolo=$_POST['id_tipo_simbolo'];
$id_tipo_palabra=$_POST['id_tipo_palabra'];
$letra=$_POST['letra'];
$idioma=$_POST['idioma'];

$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

		
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
		
		$contar=$query->listar_simbolos_especiales($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$_SESSION['AUTHORIZED']);
		$pegar=$query->listar_simbolos_especiales_limit($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$inicial,$cantidad,$_SESSION['AUTHORIZED']);
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
 <table cellpadding="0" cellspacing="0" border="0">
    <thead>
      <tr>
        <th width="15%" field="Name" dataType="String"><div align="left"><strong>Id Simbolo </strong></div></th>
        <th width="15%" datatype="html"><div align="left"><strong>Simbolo </strong></div></th>
        <th width="25%" field="DateAdded" datatype="Date" sort="asc"><div align="left"><strong>Palabra</strong></div></th>
        <th width="45%" field="DateAdded" dataType="Date" sort="asc"><div align="left"><strong>Acepci&oacute;n</strong></div></th>
      </tr>
    </thead>
   <tbody>
      <?php
		while ($entrada = mysql_fetch_array($pegar)) {
		
			if ($permisos['borrar_simbolos']==1) {
			
			$borrar='<a href="javascript:void(0);" onClick="ventana_confirmacion(\'Esta seguro que desea borrar el simbolo seleccionado?\',
			\'300\',\'100\',
			\'inc/gestion_simbolos/borrar_simbolo_especial.php\', 
			\'id='.$entrada['id_simbolo'].'\', 
			\'informacion_simbolo\',  
			\'inc/gestion_simbolos/listar_simbolos_especiales.php\', 
			\'id_tipo_palabra=\'+document.catalogo_simbolos.tipo_palabra.value+\'&letra=\'+document.catalogo_simbolos.letra.value+\'&id_tipo_simbolo=\'+document.catalogo_simbolos.tipo_simbolo.value+\'&idioma=\'+document.catalogo_simbolos.idioma.value+\'\', 
			\'tabla_simbolos\'
			);" /><img src="images/papelera.png" alt="Borrar imagen" border="0" /></a>';
						
			
			} else { 
			
			$borrar='';
			
			}
			
			if ($entrada['registrado']==2) {
					$ruta_img='size=50&ruta=../../repositorio/specials_smbl/'.$entrada['id_simbolo'].".".$entrada['ext'];
					$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					$ruta_cesto='ruta_cesto=repositorio/specials_smbl/'.$entrada['id_simbolo'].".".$entrada['ext'];
				    $encript->encriptar($ruta_cesto,1);
				
			} 				
		
			if (($entrada['registrado']==2 && $permisos['simbolos_especiales']==1) || $entrada['registrado']==1 || $entrada['registrado']==0) {		
		?>
      <tr>
        <td width="15%"><div align="left"><?php echo $entrada['id_simbolo']; ?></div></td>
        <td width="15%"><div align="left"><?php echo '<a href="javascript:void(0);" onClick="cargar_div(\'inc/gestion_simbolos/informacion_simbolo_especial.php\',\'id='.$entrada['id_simbolo'].'\',\'informacion_simbolo\');" /><img src="classes/img/thumbnail_no_cache.php?i='.$ruta_img.'" border="0"" alt="Mostrar informacion del s&iacute;mbolo"/></a><br><div id="products">'.$borrar.'&nbsp;<a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="a&ntilde;adir s&iacute;mbolo a mi cesto"></a>'; ?> </div></td>
        <td width="25%"><div align="left"><?php echo utf8_encode($entrada['palabra']); ?></div></td>
        <td width="55%"><div align="left"><?php echo utf8_encode($entrada['definicion']); ?></div></td>
      </tr>
      <?php
	   	
	   }
	   } ?>
   </tbody>
</table>
 </div>
</br>
   <table width="60%" height="30" border="0" align="center" cellpadding="0" cellspacing="2">
            <tr class="textos">
                <td width="9%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">
                  <input type="button" name="Submit" value="&lt;&lt;" onclick="cargar_div('inc/gestion_simbolos/listar_simbolos_especiales.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=0','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">              </td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
                  <input type="button" name="Submit" value="< Anterior" onclick="cargar_div('inc/gestion_simbolos/listar_simbolos_especiales.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $url ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">
              </div></td>
                <td width="28%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;">&nbsp;</td>
                <td width="26%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center"><?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
                  <input type="button" name="Submit" value="Siguiente >" onclick="cargar_div('inc/gestion_simbolos/listar_simbolos_especiales.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $url ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');">
              </div></td>
              <td width="9%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick="cargar_div('inc/gestion_simbolos/listar_simbolos_especiales.php','id_tipo_palabra='+document.catalogo_simbolos.tipo_palabra.value+'&letra='+document.catalogo_simbolos.letra.value+'&id_tipo_simbolo='+document.catalogo_simbolos.tipo_simbolo.value+'&idioma='+document.catalogo_simbolos.idioma.value+'&pg=<?php echo $pages ?>','tabla_simbolos'); cargar_div('inc/gestion_simbolos/limpiar_cuadro_informacion.php','i=','informacion_simbolo');"></td>
            </tr>
</table>      