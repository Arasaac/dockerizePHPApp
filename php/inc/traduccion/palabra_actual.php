<?php
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

include ("../../classes/querys/query.php");
$query= new query();

include_once('../../classes/utf8/utf8.class.php');
$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

header('Content-type: text') ; // on déclare ce qui va être afficher
					
if(isset($_POST['id']) && !empty($_POST['id']) ){

$id_palabra=$_POST['id'];
$id_idioma=$_POST['t'];

$resultados=$query->buscar_traduccion($id_palabra,$id_idioma);
$traduccion=mysql_fetch_array($resultados);
		
switch ($_POST['t']) {

	case 4: //chino
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea onKeyUp=conversion() onFocus=conversion() onMouseOver=conversion(); name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea>
		<input name=\"resultat\" type=\"hidden\" value=\"\">
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion:</strong> <input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;

	case 2: //rumano
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea  name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea><br>
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion: </strong><input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 9: //Catalan
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea  name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea><br>
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion: </strong><input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 8: //francés
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea  name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea><br>
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion: </strong><input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 7: //Ingés
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea  name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea><br>
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion: </strong><input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	
	case 6: //POLACO
	
	echo "<strong>Palabra actual:</strong> ".$traduccion['traduccion']."<BR>
	    <textarea  name=saisie cols=\"50\" rows=3 style=\"font-size:22px; color:#0000FF;\">".$traduccion['traduccion']."</textarea><br>
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion: </strong><input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 1: //ruso
	$res_ru = $utfConverter_ru->strToUtf8($traduccion['traduccion']);
	echo "<strong>Palabra actual:</strong> ".$res_ru."<BR>
	    <TEXTAREA onkeyup=transcrire() style=\"PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-SIZE: 20pt; PADDING-BOTTOM: 5px; WIDTH: 80%; COLOR: blue; PADDING-TOP: 5px;  FONT-FAMILY: Times New Roman;\" name=saisie rows=3>".$res_ru."</TEXTAREA><br>		
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion:</strong> <input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 5: //Búlgaro
	$res_bulg = $utfConverter_ru->strToUtf8($traduccion['traduccion']);
	echo "<strong>Palabra actual:</strong> ".$res_bulg."<BR>
	    <TEXTAREA onkeyup=transcrire() style=\"PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-SIZE: 20pt; PADDING-BOTTOM: 5px; WIDTH: 80%; COLOR: blue; PADDING-TOP: 5px;  FONT-FAMILY: Times New Roman;\" name=saisie rows=3>".$res_bulg."</TEXTAREA><br>		
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion:</strong> <input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	case 3: //arabe
	$res_ar = $utfConverter->strToUtf8($traduccion['traduccion']);
	echo "<strong>Palabra actual:</strong> ".$res_ar."<BR>
	    <TEXTAREA dir=rtl onkeyup=transcrire() style=\"PADDING-RIGHT: 5px; PADDING-LEFT: 5px; FONT-SIZE: 26pt; PADDING-BOTTOM: 5px; WIDTH: 80%; COLOR: blue; PADDING-TOP: 5px; FONT-FAMILY: Times New Roman;\" name=saisie rows=3>".$res_ar."</TEXTAREA><br>		
		<strong>Estado:</strong> <select name=\"estado\" id=\"estado\">
                  <option value=\"2\""; if ($traduccion['estado']==2) { echo "selected";} echo ">Pendiente revisi&oacute;n</option>
                  <option value=\"1\""; if ($traduccion['estado']==1) { echo "selected";} echo ">Visible</option>
                  <option value=\"0\""; if ($traduccion['estado']==0) { echo "selected";} echo ">No Visible</option>
        </select>&nbsp;<strong>Pronunciacion:</strong> <input name=\"pronunciacion\" id=\"pronunciacion\" type=\"text\" value=\"".$traduccion['pronunciacion']."\">";
	
	break;
	
	
}
	  

}



?>