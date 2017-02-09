<?php 
session_start();

	define("MAP_DIR","../../classes/utf8/MAPPING");
	define("CP1250",MAP_DIR . "/CP1250.MAP");
	define("CP1251",MAP_DIR . "/CP1251.MAP");
	define("CP1252",MAP_DIR . "/CP1252.MAP");
	define("CP1253",MAP_DIR . "/CP1253.MAP");
	define("CP1254",MAP_DIR . "/CP1254.MAP");
	define("CP1255",MAP_DIR . "/CP1255.MAP");
	define("CP1256",MAP_DIR . "/CP1256.MAP");
	define("CP1257",MAP_DIR . "/CP1257.MAP");
	define("CP1258",MAP_DIR . "/CP1258.MAP");
	define("CP874", MAP_DIR . "/CP874.MAP");
	define("CP932", MAP_DIR . "/CP932.MAP");
	define("CP936", MAP_DIR . "/CP936.MAP");
	define("CP949", MAP_DIR . "/CP949.MAP");
	define("CP950", MAP_DIR . "/CP950.MAP");
	define("GB2312", MAP_DIR . "/GB2312.MAP");
	define("BIG5", MAP_DIR . "/BIG5.MAP");

include_once('../../classes/utf8/utf8.class.php');	
	
	$utfConverter = new utf8(CP1251); //defaults to CP1250.
	$utfConverter->loadCharset(CP1256);
	
	$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
	$utfConverter_ru->loadCharset(CP1251);
	
include ("../../classes/querys/query.php");
$query= new query();

$mensaje="";

$traduccion=$_POST['traduccion'];
$explicacion=$_POST['explicacion'];
$estado=$_POST['estado'];
$pronunciacion=$_POST['pronunciacion'];
$id_colaborador=$_SESSION['ID_USER'];
$id_idioma=$_GET['id_idioma'];
$id_palabra=$_GET['id_palabra'];
$accion = $_REQUEST["accion"];
$id_traduccion=$_POST['id_traduccion'];

if ($id_idioma==3) { //Arabe
	$codificacion='windows-1256';
} elseif ($id_idioma==1) { //Ruso
	$codificacion='windows-1251';
} elseif ($id_idioma==5) { //Bulgaro
	$codificacion='windows-1251';
} else {
	$codificacion='utf-8';
}


switch ($accion) {

case 'add':
	if (isset($_POST['traduccion'])) {
		$traducciones=$query->add_traduccion($id_palabra,$id_idioma,$traduccion,$explicacion,$pronunciacion,$id_colaborador,$estado);
		$mensaje="Traduccion añadida";
	}
break;

case 'Modificar':

	if (isset($_POST['traduccion'])) {
		$traducciones=$query->modify_traduccion($id_traduccion,$id_palabra,$id_idioma,$traduccion,$pronunciacion,$estado,$explicacion);
		$mensaje="Traduccion actualizada";
	}
	
break;

case 'Borrar':
$traducciones=$query->borrar_traduccion($id_traduccion,$id_palabra,$id_idioma,$id_colaborador);
$mensaje="Traduccion borrada";
break;
}

$resultados=$query->buscar_traduccion($id_palabra,$id_idioma);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Teclado Virtual</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../../js/virtualkeyboardlite/vk_loader.js?vk_layout=BG%20Bulgarian&vk_skin=small"></script>
</head>
 <body>
 <table cellpadding="0" cellspacing="0" border="0">
   <tr>
     <td valign="top">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>&nbsp;</td>
           <td><strong>Traduccion</strong></td>
           <td><strong>Explicacion</strong></td>
           <td><strong>Pronunciacion</strong></td>
           <td><strong>Estado </strong></td>
           <td><strong>Opciones</strong></td>
         </tr>
       <p>
         <?php 
	 while ($traduccion=mysql_fetch_array($resultados)) { 
	 
		if ($id_idioma==3) { //Arabe
			$mostrar_traduccion=$utfConverter->strToUtf8($traduccion['traduccion']);
		} elseif ($id_idioma==1) { //Ruso
			$mostrar_traduccion=$utfConverter_ru->strToUtf8($traduccion['traduccion']);
		} elseif ($id_idioma==5) { //Bulgaro
			$mostrar_traduccion=$utfConverter_ru->strToUtf8($traduccion['traduccion']);
		} else {
			$mostrar_traduccion=$traduccion['traduccion'];
		}

	 ?>
      </p>
         <tr>
           <td><?php echo $traduccion['id_traduccion']; ?></td>
         <form action="<?php $PHP_SELF ?>" method="post">
           <td><input name="traduccion" type="text" id="traduccion" onfocus="VirtualKeyboard.attachInput(this)" value="<?php echo $mostrar_traduccion; ?>" size="20" /></td>
           <td><input name="explicacion" type="text" id="explicacion" value="<?php echo $traduccion['explicacion']; ?>" size="20" /></td>
           <td><?php 
	 	echo "<input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	 ?></td>
           <td><?php 
	 	echo "<input name=\"id_traduccion\" type=\"hidden\" value=\"".$traduccion['id_traduccion']."\">
		<select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
       </select>";
	 ?></td>
           <td>
             <input type="submit" name="accion" id="modify" value="Modificar" /><input type="submit" name="accion" id="delete" value="Borrar" onclick="return confirm('¿Está seguro que desea borrar la traducción?');" />            </td>
           </form>
         </tr>
            
      <?php } ?>  
      <tr>
       <td colspan="3"><strong>Nueva Traduccion</strong></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      	<form action="<?php $PHP_SELF ?>" method="post">
           <td><input name="traduccion" type="text" id="traduccion" onfocus="VirtualKeyboard.attachInput(this)" value="" size="20" /></td>
           <td><input name="explicacion" type="text" id="explicacion" value="" size="20" /></td>
           <td><?php 
	 	echo "<input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"\">";
	 ?></td>
           <td><?php 
	 	echo "<input name=\"accion\" type=\"hidden\" value=\"add\">
		<select name=\"estado\" id=\"estado\">
                  <option value=\"2\" selected>Pendiente revisi&oacute;n</option>
                  <option value=\"1\">Visible</option>
                  <option value=\"0\">No Visible</option>
       </select>";
	 ?></td>
           <td> <label>
             <input type="submit" name="add" id="add" value="Agregar" />
           </label></td>
          </form>
         </tr>
      	</table>
     </td>
    </tr>
   <tr>
    <td valign="top"><br />
	</td>
    </tr>
   <tr>
     <td valign="top" align="center">
	 <div id="td"></div>
       <div id="dbg">      </div>
    <p align="center"></p>
	 <script type="text/javascript">
             VirtualKeyboard.toggle('traduccion','td');
     </script> </td>
    </tr>
  </table>
 </body>
</html>