<?php  
session_start();
require_once('../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
include ('../../../classes/querys/query.php');
require ('../../../classes/languages/language_detect.php');
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],1);

$id_tipo="";
$letra="";

$id_tipo=$_POST['id_tipo'];
$letra=$_POST['letra'];
$panel=$_POST['panel'];
$fila=$_POST['fila'];
$columna=$_POST['columna'];
		
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
		
		if ($_POST['id_idioma']==0) { 
			$contar=$query->listar_diccionario_palabras_con_imagenes($id_tipo,$letra);
			$pegar=$query->listar_diccionario_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad);
			
		} elseif ($_POST['id_idioma'] > 0) { 
			
			$contar=$query->listar_diccionario_idiomas_palabras_con_imagenes($id_tipo,$letra,$_POST['id_idioma']);
			$pegar=$query->listar_diccionario_idiomas_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad,$_POST['id_idioma']);
		
		}
		
		$total_records = mysql_num_rows($contar);
		$pages = intval($total_records / $cantidad);
?>
<div align="left">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tbody>
         <?php
	  $color = 'tablaAlterno1';
		while ($entrada = mysql_fetch_array($pegar)) {
		
		$color = ($color == 'tablaAlterno1') ? 'tablaAlterno2' : 'tablaAlterno1';
		
		$ruta_creador='img=NULO&id_palabra='.$entrada['id_palabra'].'||'.$_POST['id_idioma'];
		$encript->encriptar($ruta_creador,1); 
		
		if ($_POST['id_idioma']==0) { 
			$acepcion=utf8_encode($entrada['palabra']);
			$definicion=$entrada['definicion'];
		} elseif ($_POST['id_idioma'] > 0) { 
			$acepcion=$entrada['traduccion'];
			$definicion=$entrada['explicacion'];
		}
		
		?>
         <tr class="<?php echo $color; ?>" height="2%">
           <td width="8%" valign="top"><span style="width:500px; height:300px;"><a href="javascript:void(0);" onclick="procesar('mostrar_imagenes.php','id=<?php echo $entrada['id_palabra']; ?>&panel=<?php echo $panel;  ?>&fila=<?php echo $fila; ?>&columna=<?php echo $columna; ?>&id_idioma=<?php echo $_POST['id_idioma']; ?>&acepcion=<?php echo urlencode($acepcion); ?>','tabla_palabras');" /> <img src="../../../images/seleccionar.gif" alt="<?php echo $translate['seleccionar_palabra']; ?>" title="<?php echo $translate['seleccionar_palabra']; ?>" border="0" /> </a></span></td>
           <td width="10%" align="left" valign="top"><?php echo $entrada['id_palabra']; ?></td>
           <td width="19%" align="left" valign="top"><?php echo $acepcion; ?></td>
           <td width="63%" align="left" valign="top"><span style="width:80%;"><?php if (strlen($definicion) > 175) { echo substr(utf8_encode($definicion),0,175)."..."; } else {  echo utf8_encode($definicion);  }?></span></td>
         </tr>
         <?php } ?>
       </tbody>
  </table>
<table width="100%" height="30" border="0" align="left" cellpadding="0" cellspacing="2">
       <tr class="textos">
         <td width="34%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="Submit" value="&lt;&lt;" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=0&panel=<?php echo $panel; ?>&fila=<?php echo $fila; ?>&columna=<?php echo $columna; ?>&id_idioma=<?php echo $_POST['id_idioma']; ?>','tabla_palabras');" />
         </td>
         <td width="11%"  style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><div align="center">
             <?php if ($_POST['pg'] != 0) { 
						$url = $_POST['pg'] - 1;
						} ?>
             <input type="button" name="Submit2" value="&lt; <?php echo $translate['anterior']; ?>" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $url ?>&panel=<?php echo $panel; ?>&fila=<?php echo $fila; ?>&columna=<?php echo $columna; ?>&id_idioma=<?php echo $_POST['id_idioma']; ?>','tabla_palabras');" />
         </div></td>
         <td width="9%">&nbsp;</td>
         <td width="11%"><div align="center">
             <?php if ($_POST['pg'] < $pages) { 
						$url = $_POST['pg'] + 1; 
						} ?>
             <input type="button" name="Submit2" value="<?php echo $translate['siguiente']; ?> &gt;" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $url ?>&panel=<?php echo $panel; ?>&fila=<?php echo $fila; ?>&columna=<?php echo $columna; ?>&id_idioma=<?php echo $_POST['id_idioma']; ?>','tabla_palabras');" />
         </div></td>
         <td width="35%" style="color:#A12B6F; font-family:Georgia, Times New Roman, Times, serif; font-size:12px; text-align:center;"><input type="button" name="button" value="&gt;&gt;" onclick="procesar('listar_palabras_reducido.php','id_tipo='+document.vm_diccionario.tipo_palabra.value+'&letra='+document.vm_diccionario.letra.value+'&pg=<?php echo $pages; ?>&id_idioma=<?php echo $_POST['id_idioma']; ?>','tabla_palabras');" /></td>
       </tr>
     </table>
</div>
</br>
</div>