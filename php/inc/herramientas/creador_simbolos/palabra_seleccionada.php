<?php 

include ('../../../classes/querys/query.php');

$query=new query();

$datos_palabra=$query->datos_palabra($_POST['id']);

$idiomas_disponibles=$query->idiomas_disponibles($_POST['id'],1);

$id_palabra=$_POST['id'];



define("MAP_DIR","../../../classes/utf8/MAPPING");

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



include_once('../../../classes/utf8/utf8.class.php');

$utfConverter = new utf8(CP1251); //defaults to CP1250.

$utfConverter->loadCharset(CP1256);



$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.

$utfConverter_ru->loadCharset(CP1251);



$utfConverter_ch = new utf8(GB2312); 

$utfConverter_ch->loadCharset(GB2312);



header('Content-type: text') ; // on déclare ce qui va être afficher



echo '<textarea name="palabra" cols="30" rows="2" id="palabra" realname="Palabra" style="font-size:12px">'.$datos_palabra['palabra'].'</textarea><br><input name="id_palabra" type="hidden" id="id_palabra" value="'.$_POST['id'].'"><em><strong>'.$datos_palabra['palabra'].',</strong></em>&nbsp;'.utf8_encode($datos_palabra['definicion']).'';





echo '<br><br><strong>Idiomas disponibles</strong><br>';



$num_traducciones=mysql_num_rows($idiomas_disponibles);



if ($num_traducciones > 0) {



	echo '<select name="id_traduccion" size="1" id="id_traduccion">';



	while ($row=mysql_fetch_array($idiomas_disponibles)) {



		switch ($row['idioma']) {

		

			case 'Chino':

			$chino=$query->buscar_traduccion($id_palabra,4);

			if (mysql_num_rows($chino) > 0) {

				while ($row_chino=mysql_fetch_array($chino)) {

					if ($row_chino['estado']==1) { echo '<option value="'.$row_chino['id_traduccion'].'">Chino - '.$row_chino['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Rumano':

			$rumano=$query->buscar_traduccion($id_palabra,2);

			if (mysql_num_rows($rumano) > 0) {

				while ($row_rumano=mysql_fetch_array($rumano)) {

					if ($row_rumano['estado']==1) { echo '<option value="'.$row_rumano['id_traduccion'].'">Rumano - '.$row_rumano['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Polaco':

			$polaco=$query->buscar_traduccion($id_palabra,6);

			if (mysql_num_rows($polaco) > 0) {

				while ($row_polaco=mysql_fetch_array($polaco)) {

					if ($row_polaco['estado']==1) { echo '<option value="'.$row_polaco['id_traduccion'].'">Polaco - '.$row_polaco['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Ruso':

			$ruso=$query->buscar_traduccion($id_palabra,1);

			if (mysql_num_rows($ruso) > 0) {

				while ($row_ruso=mysql_fetch_array($ruso)) {

					$res_ru = $utfConverter_ru->strToUtf8($row_ruso['traduccion']);

					if ($row_ruso['estado']==1) { echo '<option value="'.$row_ruso['id_traduccion'].'">Ruso - '.$res_ru.'</option>'; }

				}

			}

			break;

			

			case 'Bulgaro':

			$bulgaro=$query->buscar_traduccion($id_palabra,5);

			if (mysql_num_rows($bulgaro) > 0) {

				while ($row_bulgaro=mysql_fetch_array($bulgaro)) {

					$res_bulg = $utfConverter_ru->strToUtf8($row_bulgaro['traduccion']);

					if ($row_bulgaro['estado']==1) { echo '<option value="'.$row_bulgaro['id_traduccion'].'">Bulgaro - '.$res_bulg.'</option>'; }

				}

			}

			break;

			

			case 'Arabe':

			$arabe=$query->buscar_traduccion($id_palabra,3);

			if (mysql_num_rows($arabe) > 0) {

				while ($row_arabe=mysql_fetch_array($arabe)) {

					$res_ar = $utfConverter->strToUtf8($row_arabe['traduccion']);

					if ($row_arabe['estado']==1) { echo '<option value="'.$row_arabe['id_traduccion'].'">Arabe - '.$res_ar.'</option>'; }

				}

			}

			break;

			

			case 'Ingles':

			$ingles=$query->buscar_traduccion($id_palabra,7);

			if (mysql_num_rows($ingles) > 0) {

				while ($row_ingles=mysql_fetch_array($ingles)) {

					if ($row_ingles['estado']==1) { echo '<option value="'.$row_ingles['id_traduccion'].'">Ingles - '.$row_ingles['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Frances':

			$frances=$query->buscar_traduccion($id_palabra,8);

			if (mysql_num_rows($frances) > 0) {

				while ($row_frances=mysql_fetch_array($frances)) {

					if ($row_frances['estado']==1) { echo '<option value="'.$row_frances['id_traduccion'].'">Frances - '.$row_frances['traduccion'].'</option>'; }

				}

			}

			break;

			

			case 'Catalan':

			$catalan=$query->buscar_traduccion($id_palabra,9);

			if (mysql_num_rows($catalan) > 0) {

				while ($row_catalan=mysql_fetch_array($catalan)) {

					if ($row_catalan['estado']==1) { echo '<option value="'.$row_catalan['id_traduccion'].'">Catalan - '.$row_catalan['traduccion'].'</option>'; }

				}

			}

			break;

		

		}

	}



echo '</select>';

  

} else {



echo 'No hay traducciones disponibles &nbsp;<input name="id_traduccion" type="hidden" id="idioma" value="0" /><br><br>';



}



?>



