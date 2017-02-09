<?php 
include ('classes/querys/query.php');
include ('funciones/funciones.php');
$query=new query();

define("MAP_DIR","classes/utf8/MAPPING");
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

include_once('classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$id_idioma=3;
//$traducciones=$query->buscar_traduccion_por_idioma_temp($id_idioma);
$traducciones=$query->buscar_traduccion_por_idioma($id_idioma);
?>
<table width="694" cellpadding="0" cellspacing="0">
<?php while ($tr=mysql_fetch_array($traducciones)) { 

switch ($id_idioma) {

case 1:
$traduccion=$utfConverter_ru->strToUtf8($tr['traduccion']); // Ruso
$explicacion=$utfConverter_ru->strToUtf8($tr['explicacion']);
break;

case 2:
$traduccion=$tr['traduccion']; // Rumano
$explicacion=$tr['explicacion'];
break;

case 3:
$traduccion=$utfConverter->strToUtf8($tr['traduccion']); // Arabe
$explicacion=$utfConverter->strToUtf8($tr['explicacion']);
break;

case 4:
$traduccion=$tr['traduccion']; // Chino
$explicacion=$tr['explicacion'];
break;

case 5:
$traduccion=$utfConverter_ru->strToUtf8($tr['traduccion']); // Bulgaro
$explicacion=$utfConverter_ru->strToUtf8($tr['explicacion']);
break;

case 6:
$traduccion=$tr['traduccion']; // Polaco
$explicacion=$tr['explicacion'];
break;


case 7:
$traduccion=$tr['traduccion']; // Inglés
$explicacion=$tr['explicacion'];
break;

case 8:
$traduccion=$tr['traduccion']; // Francés
$explicacion=$tr['explicacion'];
break;

}
?>
  <tr>
    <td width="66" align="right"><div align="center"><?php echo $tr['id_palabra']; ?></div></td>
    <td width="310"><?php echo idiomas_disponibles_modo_texto($tr['id_palabra'],8,$query); ?></td>
    <td width="310"><?php echo  $tr['explicacion']; ?></td>
  </tr>
<?php } ?>
</table>
