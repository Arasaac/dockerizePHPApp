<?php 
session_start();
if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {

die;
?>
<script>
alert('La sesión ha caducado, vuelva a autentificarse para poder seguir trabajando');
</script>
<?php 
}
set_time_limit(95000); 
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);

//require_once "../../classes/querys/conexion.php";
require_once "../../classes/querys/query.php";
require_once "../../classes/excel/excelexport.php";

$query_class=new query();
$xls = new ExcelExport();
$conexion= new config_db();

$USERNAME = $conexion->USERNAME;
$PASSWORD = $conexion->PASSWORD;
$HOST     = $conexion->HOST;
$DBNAME   = $conexion->DBNAME; 

$id_listado='';
$id_listado=$_GET['id_listado'];

switch ($id_listado) {

	case 1: //Palabras que no tienen ningun tipo de imagen, clipart o pictograma OK
	
		$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabras.*
		FROM palabras
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.* FROM palabra_imagen WHERE palabra_imagen.id_palabra='".$row['id_palabra']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
			
		}
 	$xls->download("palabras_sin_nada.xls");
	break;

	case 2: //Palabras que tienen Clipart y (Pictograma de Color o Imagen) OK
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=9
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=2)";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) > 0) {
				
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
			
		}
 	$xls->download("cliparts_con_imagen_o_pictograma.xls");
	break;

	case 3: // Palabras que solo tienen Clipart (no tienen imagen o pictograma)
	
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE palabra_imagen.id_palabra=palabras.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=9
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=2 OR imagenes.id_tipo_imagen=3 OR imagenes.id_tipo_imagen=5)";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
		
		}
	$xls->download("palabras_solo_con_clipart.xls");
	break;
	
	case 4: //Palabras que tienen Imagen y Pictograma Color
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=2
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=10";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) > 0) {
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
			
		}
 	$xls->download("palabras_con_imagen_y_pictograma.xls");
	break;
	
	case 5: //Palabras que solo tienen Imagen (no tienen pictograma)
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=2
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5)";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
		
		}
	$xls->download("palabras_solo_con_imagen.xls");
	break;
	
	case 6: //Palabras que solo tienen Pictograma (no tienen ni clipart ni imagen)
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND (imagenes.id_tipo_imagen=2 OR imagenes.id_tipo_imagen=9)";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
		
		}
	$xls->download("palabras_solo_con_pictograma.xls");
	break;
	
	case 7: //Palabras con Pictograma (todas sin excluir)
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
		
		}
	$xls->download("palabras_con_pictograma.xls");
	break;
	
	case 8: //Palabras con Imagen (todas sin excluir)
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=2
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
		
		}
	$xls->download("palabras_con_imagen.xls");
	break;
	
	case 9: //Palabras sin definción
		$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabras.*
		FROM palabras
		WHERE (palabras.definicion IS NULL OR palabras.definicion='' OR palabras.definicion=' ')
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion']; }  
			$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
		
		}
	$xls->download("palabras_sin_definicion.xls");
	break;
	
	case 10: //Palabras que tienen Imagen o Pictograma Color
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=2)
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
	
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
			
		}
 	$xls->download("palabras_con_imagen_o_pictograma.xls");
	break;
		
	case 12: // Palabras de la RAE (5000) que no están en ARASAAC
	$xls->addRow(Array("ID ORDEN RAE","Palabra","Definicion"));
	
		$query = "SELECT palabras_rae_5000_utf8_compare.*
		FROM palabras_rae_5000_utf8_compare
		WHERE palabras_rae_5000_utf8_compare.is_arasaac=0
		ORDER BY palabras_rae_5000_utf8_compare.id_orden";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			$xls->addRow(Array($row['id_orden'],$row['palabra'],$definicion));
		
		}
	$xls->download("palabras_RAE_NO_ARASAAC.xls");
	break;
	
	case 13: //Palabras que tienen Pictograma de Color, Imagen o Clipart
	$xls->addRow(Array("ID Palabra","Palabra","Definicion"));
		
		$query = "SELECT * FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*
			FROM palabra_imagen
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) > 0) {	
	
					if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion));
				}
			
		}
 	$xls->download("palabras_con_imagen_pictograma_o_clipart.xls");
	break;
	
	case 14: 
	$xls->addRow(Array("ID Palabra","Palabra","Definicion","Pictograma","Imagen","Clipart"));
		
		$query = "SELECT * FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			//Imagenes
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=2";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) > 0) {
					$is_imagen='X';
				} else { $is_imagen=''; }
		    
			//Pictogramas
			$query3 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5)";
			$result3 = mysql_query($query3);
			
				if (mysql_num_rows($result3) > 0) {
					$is_picto='X';
				} else { $is_picto=''; }
				
			//Cliparts
			$query4 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=9";
			$result4 = mysql_query($query4);
			
				if (mysql_num_rows($result4) > 0) {
					$is_clipart='X';
				} else { $is_clipart=''; }
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion,$is_picto,$is_imagen,$is_clipart));
		}
 	$xls->download("listado_todas_palabras_indicando_imagen_pictograma_o_clipart.xls");
	break;
	
	case 15: //Comprobar Pictogramas Color sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=10";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*
			FROM palabra_imagen
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("pictogramas_color_huerfanos.xls");
	break;
	
	case 16: //Comprobar Pictogramas B&N sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=5";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*
			FROM palabra_imagen
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("pictogramas_b&n_huerfanos.xls");
	break;
	
	case 17: //Comprobar Imagenes sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=2";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*
			FROM palabra_imagen
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("pictogramas_imagenes_huerfanas.xls");
	break;
	
	case 18: //Comprobar Cliparts sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=9";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*
			FROM palabra_imagen
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("pictogramas_cliparts_huerfanos.xls");
	break;
	
	case 19: 
	$xls->addRow(Array("ID Imagen","N Palabras Asociadas","Definicion 1","Definicion 2","Definicion 3","Definicion 4","Definicion 5","Definicion 6","Definicion 7","Definicion 8","Definicion 9","Definicion 10","Definicion 11","Definicion 12","Definicion 13"));
		
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		    
			$palabra=array();
			//Pictogramas
			$query3 = "SELECT palabra_imagen.*, palabras.* 
			FROM palabra_imagen, palabras
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
			AND palabra_imagen.id_palabra=palabras.id_palabra";
			$result3 = mysql_query($query3);
			$n_resultados=mysql_num_rows($result3);
			
			$palabras='';
			
			while ($row3=mysql_fetch_array($result3)) {
		
					if (strlen($row3['definicion']) > 220) { $definicion=substr($row3['definicion'],0,220)."(+)"; } else {  $definicion=$row3['definicion'];  }
					$palabra[]=utf8_decode($row3['palabra']).": ".$definicion;
			}
				
				
				
		$xls->addRow(Array($row['id_imagen'],$n_resultados,$palabra[0],$palabra[1],$palabra[2],$palabra[3],$palabra[4],$palabra[5],$palabra[6],$palabra[7],$palabra[8],$palabra[9],$palabra[10],$palabra[11],$palabra[12]));
		}
 	$xls->download("pictogramas_color_asociado_palabras.xls");
	break;
	
	case 20: 
	$xls->addRow(Array("ID Palabra","Palabra","Definicion","Pictograma","Imagen","Clipart","Nº Pict Color","Nº Pict Negro","Nº Imagenes","Nº Cliparts"));
		
		$query = "SELECT * FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			//Imagenes
			$query2 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=2";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) > 0) {
					$is_imagen='X';
				} else { $is_imagen=''; }
		    
			//Pictogramas Color 
			$query3 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=10";
			$result3 = mysql_query($query3);
			
				if (mysql_num_rows($result3) > 0) {
					$is_picto='X';
				} else { $is_picto=''; }
			
			//Pictogramas Negro 
			$query5 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=5";
			$result5 = mysql_query($query5);
				
			//Cliparts
			$query4 = "SELECT palabra_imagen.*, imagenes.* 
			FROM palabra_imagen, imagenes 
			WHERE palabra_imagen.id_palabra='".$row['id_palabra']."' 
			AND palabra_imagen.id_imagen=imagenes.id_imagen 
			AND imagenes.id_tipo_imagen=9";
			$result4 = mysql_query($query4);
			
				if (mysql_num_rows($result4) > 0) {
					$is_clipart='X';
				} else { $is_clipart=''; }
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_palabra'],$row['palabra'],$definicion,$is_picto,$is_imagen,$is_clipart,mysql_num_rows($result3),mysql_num_rows($result5),mysql_num_rows($result2),mysql_num_rows($result4)));
		}
 	$xls->download("listado_todas_palabras_indicando_imagen_pictograma_o_clipart.xls");
	break;
	
	case 21: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE imagenes.id_tipo_imagen=2 
		AND imagenes.extension='png'
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("imagen_png_como_realista.xls");
	break;
	
	case 22: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5 OR imagenes.id_tipo_imagen=9)
		AND (imagenes.extension='jpg' OR imagenes.extension='jpeg')
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("imagen_jpg_como_pictograma_o_clipart.xls");
	break;
	
	case 23: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE (imagenes.estado=0 OR imagenes.estado=2)
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("no_visibles_o_pendientes_revision.xls");
	break;
	
	case 24: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5)
		AND imagenes.id_autor <> 2
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("pictogramas_no_sergio_palao.xls");
	break;
	
	case 25: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5)
		AND imagenes.id_licencia <> 2
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("pictogramas_revisar_licencia.xls");
	break;
	
	case 26: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE imagenes.id_tipo_imagen=2
		AND imagenes.id_licencia <> 2
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("imagenes_revisar_licencia.xls");
	break;
	
	case 27: 
	$xls->addRow(Array("ID Imagen","Palabra"));
		
		$query = "SELECT palabra_imagen.*, palabras.*, imagenes.* 
		FROM palabra_imagen, palabras, imagenes 
		WHERE (imagenes.id_tipo_imagen=10 OR imagenes.id_tipo_imagen=5 OR imagenes.id_tipo_imagen=9)
		AND imagenes.registrado <> 0
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
				
		if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }		
		$xls->addRow(Array($row['id_imagen'],$row['palabra']));
		}
 	$xls->download("mostrar_registrados.xls");
	break;
	
	case 28:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	
									    
						
									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
									
									$ruta_img='size=50&ruta=../../repositorio/originales/'.$archivo[$o];
									$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
									echo '<img src="../../classes/img/thumbnail.php?i='.$ruta_img.'" border="0" align="left">';
									
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;
	
	case 29:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=5 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	
									    
						
									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
									
									$ruta_img='size=50&ruta=../../repositorio/originales/'.$archivo[$o];
									$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
									echo '<img src="../../classes/img/thumbnail.php?i='.$ruta_img.'" border="0" align="left">';
									
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;
	
	case 30:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=2 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	
									    
						
									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
									
									$ruta_img='size=50&ruta=../../repositorio/originales/'.$archivo[$o];
									$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
									echo '<img src="../../classes/img/thumbnail.php?i='.$ruta_img.'" border="0" align="left">';
									
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;
	
	case 31:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=9 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	
									    
						
									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
									
									$ruta_img='size=50&ruta=../../repositorio/originales/'.$archivo[$o];
									$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
					
									echo '<img src="../../classes/img/thumbnail.php?i='.$ruta_img.'" border="0" align="left">';
									
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;
	
	case 32:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	

									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
																		
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;

	case 33:
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=2 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
			$imagen[]=$row['id_imagen'];
			$archivo[]=$row['imagen'];
		}
					$o=0;
					echo '<table cellspacing="0" cellpadding="0" width="100%" style="border: 1px solid #999999; padding: 20px;">';
						for ($i=1; $i<=$n_filas; $i++){ // FILAS
							echo '<tr align="left">'; 
							for ($e=1; $e<=$n_columnas; $e++){ //COLUMNAS 
								$file=$imagen[$o];
								if ($file != "") {	
									    					
									echo '<td style="border:1px dashed #CCCCCC; padding: 10px;">';
									echo $file."<br />";
									
									$query2 = "SELECT palabra_imagen.*, palabras.* 
									FROM palabra_imagen, palabras 
									WHERE palabra_imagen.id_imagen='".$file."' 
									AND palabra_imagen.id_palabra=palabras.id_palabra";
									$result2 = mysql_query($query2);
									
										if (mysql_num_rows($result2) > 0) {
											while ($row2=mysql_fetch_array($result2)) {
											
											echo "<b>- ".$row2['palabra'].":</b> ";
											if (strlen($row2['definicion']) > 250) { echo substr(utf8_encode($row2['definicion']),0,250)."(+)"; } else {  echo utf8_encode($row2['definicion']);  }
											echo "<br />";
											}
										} else { echo "No tiene palabras asociadas"; }
				
									echo '</td>';

								 $o++;  			
								} else { 
								$o++;
								}
						   
							} 
							echo "</tr>"; 
						} 
					echo '</table>';
	break;
	
	case 34: 
	$xls->addRow(Array("Palabra","Idioma"));
		
		$query = "SELECT traducciones.*, palabras.*, idiomas.* 
		FROM traducciones, palabras, idiomas 
		WHERE traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=idiomas.id_idioma
		AND traducciones.traduccion LIKE '%，%'";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
						
		$xls->addRow(Array($row['palabra'],utf8_decode($row['idioma'])));
		}
 	$xls->download("mostrar_comas_traducciones.xls");
	break;
	
	case 35: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=7";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_ingles.xls");
	break;

	case 36: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=9";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_catalan.xls");
	break;
	
	case 37: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=8";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_frances.xls");
	break;
	
	case 38: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=1";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_ruso.xls");
	break;
	
	case 39: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=5";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_bulgaro.xls");
	break;
	
	case 40: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=4";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_chino.xls");
	break;
	
	case 41: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=3";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_arabe.xls");
	break;
	
	case 42: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=2";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_rumano.xls");
	break;
	
	case 43: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			//if (strlen($row['definicion']) > 250) { //$definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			$definicion=$row['definicion'];
									
			$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));

		}
 	$xls->download("listado_palabras_para_traducir.xls");
	break;
	
	
	case 44:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Euskera","Gallego"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_gallego.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=utf8_decode($row3['traduccion']).';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_euskera,$palabras_gallego));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			$palabras_gallego='';
			
		} //Cierro el While
					
	$xls->download("TICO.xls");
	break;
	
	case 45:
	$xls->addRow(Array("ID imagen","castellano","Ruso","Rumano","Arabe","Chino","Bulgaro","Polaco"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra_2($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 1:
										if ($row3['traduccion']!= NULL) {
											$palabras_ruso.=$row3['traduccion'].';';
										}
										break;
										
										case 2:
										if ($row3['traduccion']!= NULL) {
											$palabras_rumano.=$row3['traduccion'].';';
										}
										break;
										
										case 3:
										if ($row3['traduccion']!= NULL) {
											$palabras_arabe.=$row3['traduccion'].';';
										} 
										break;
										
										case 4:
										if ($row3['traduccion']!= NULL) {
											$palabras_chino.=$row3['traduccion'].';';
										}
										break;
										
										case 5:
										if ($row3['traduccion']!= NULL) {
											$palabras_bulgaro.=$row3['traduccion'].';';
										}
										break;

										case 6:
										if ($row3['traduccion']!= NULL) {
											$palabras_polaco.=$row3['traduccion'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ruso,$palabras_rumano,$palabras_arabe,$palabras_chino,$palabras_bulgaro,$palabras_polaco));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("TICO_utf8.xls");
	break;
	
	case 47:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Euskera","Gallego"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	

					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row['id_imagen'].'.png='.$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_gallego.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_euskera,$palabras_gallego));
						
					$palabras_castellano='';
					$id_palabra='';
					$palabras_chino='';
					$palabras_rumano='';
					$palabras_polaco='';
					$palabras_ruso='';
					$palabras_bulgaro='';
					$palabras_arabe='';
					$palabras_ingles='';
					$palabras_frances='';
					$palabras_catalan='';
					$palabras_euskera='';
					$palabras_italiano='';
					$palabras_portugues='';
					$palabras_aleman='';
					$palabras_br='';
					$palabras_euskera='';
					$palabras_gallego='';
			
		} //Cierro el While
					
	$xls->download("Picto_Selector.xls");
	break;
	
	case 48:
	
	$xls->addRow(Array("ID imagen","ES"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	

					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row['id_imagen'].'.png='.$row2['palabra'].';';
							
						} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano));
			$palabras_castellano='';
			
		} //Cierro el While
					
	$xls->download("picto_selector_es.xls");
	break;
	
	case 49:
	
	$xls->addRow(Array("ID imagen","DE"));
	
		$query = "SELECT palabra_imagen.*,imagenes.*
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	
					
					$traducciones=$query_class->buscar_traduccion($row['id_palabra'],11);
					
					if (mysql_num_rows($traducciones) > 0) {
						
						while ($row2=mysql_fetch_array($traducciones)) {
							
							if ($row2['traduccion'] != NULL) {				
								$palabras.='';
							} else {
								$palabras.=$row['id_imagen'].'.png='.utf8_decode($row2['traduccion']).';';
							}
							
						} // Cierro el While de palabras asociadas a imagenes
				
						if ($palabras !='') { 
							$xls->addRow(Array($row['id_imagen'],$palabras));
						}
						$palabras='';
						
					}  //Cierro el IF

		} //Cierro el While
					
	$xls->download("picto_selector_de.xls");
	break;
	
	case 50:
	
	$xls->addRow(Array("ID imagen","IT"));
	
		$query = "SELECT palabra_imagen.*,imagenes.*
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	
					
					$traducciones=$query_class->buscar_traduccion($row['id_palabra'],12);
					
					if (mysql_num_rows($traducciones) > 0) {
						
						while ($row2=mysql_fetch_array($traducciones)) {
							
							if ($row2['traduccion'] != NULL) {				
								$palabras.='';
							} else {
								$palabras.=$row['id_imagen'].'.png='.utf8_decode($row2['traduccion']).';';
							}
							
						} // Cierro el While de palabras asociadas a imagenes
				
						if ($palabras !='') { 
							$xls->addRow(Array($row['id_imagen'],$palabras));
						}
						$palabras='';
						
					} //Cierro el IF
	
		} //Cierro el While
					
	$xls->download("picto_selector_it.xls");
	break;
	
	case 51:
	
	$xls->addRow(Array("ID imagen","EN"));
	
		$query = "SELECT palabra_imagen.*,imagenes.*
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	
					
					$traducciones=$query_class->buscar_traduccion($row['id_palabra'],7);
					$palabras='';
					
					if (mysql_num_rows($traducciones) > 0) {
						
						while ($row2=mysql_fetch_array($traducciones)) {
							
							if ($row2['traduccion'] != NULL) {				
								$palabras.='';
							} else {
								$palabras.=$row['id_imagen'].'.png='.utf8_decode($row2['traduccion']).';';
							}
							
						} // Cierro el While de palabras asociadas a imagenes
						
						if ($palabras !='') { 
							$xls->addRow(Array($row['id_imagen'],$palabras));
						}
						$palabras='';
				
					} //Cierro el IF

		} //Cierro el While
					
	$xls->download("picto_selector_en.xls");
	break;
	
	case 52:
	
	$xls->addRow(Array("ID imagen","FR"));
	
		$query = "SELECT palabra_imagen.*,imagenes.*
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	
					
					$traducciones=$query_class->buscar_traduccion($row['id_palabra'],8);
					
					if (mysql_num_rows($traducciones) > 0) {
						
						while ($row2=mysql_fetch_array($traducciones)) {
							
							if ($row2['traduccion'] != NULL) {				
								$palabras.='';
							} else {
								$palabras.=$row['id_imagen'].'.png='.utf8_decode($row2['traduccion']).';';
							}
							
						} // Cierro el While de palabras asociadas a imagenes
				
						if ($palabras !='') { 
							$xls->addRow(Array($row['id_imagen'],$palabras));
						}
						$palabras='';
					} //Cierro el IF

		} //Cierro el While
					
	$xls->download("picto_selector_fr.xls");
	break;
	
	case 53:
	
	$xls->addRow(Array("ID imagen","CA"));
	
		$query = "SELECT palabra_imagen.*,imagenes.*
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=10";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	
					
					$traducciones=$query_class->buscar_traduccion($row['id_palabra'],9);
					
					if (mysql_num_rows($traducciones) > 0) {
						
						while ($row2=mysql_fetch_array($traducciones)) {
							
							if ($row2['traduccion'] != NULL) {				
								$palabras.='';
							} else {
								$palabras.=$row['id_imagen'].'.png='.utf8_decode($row2['traduccion']).';';
							}
							
						} // Cierro el While de palabras asociadas a imagenes
				
						if ($palabras !='') { 
							$xls->addRow(Array($row['id_imagen'],$palabras));
						}
						$palabras='';
						
					} //Cierro el IF
			
		} //Cierro el While
					
	$xls->download("picto_selector_ca.xls");
	break;
	
	case 54:	
	$xls->addRow(Array("ID imagen","Castellano"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=12 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
								
						} // Cierro el While de palabras asociadas a imagenes
				
					} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano));
			
			
		} //Cierro el While
					
	$xls->download("Imagenes_LSE_TICO.xls");
	break;
	
	case 55:	
	$xls->addRow(Array("ID imagen","Castellano"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=12 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	

					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row['id_imagen'].'.jpg='.$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
						} // Cierro el While de palabras asociadas a imagenes
				
					} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano));
						
					$palabras_castellano='';
			
		} //Cierro el While
					
	$xls->download("LSE_Picto_Selector.xls");
	break;
	
	case 56:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portuges Brasil","Gallego","Euskera"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['id_palabra'].'='.$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;

										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_gallego.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_gallego,$palabras_euskera));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			$palabras_gallego='';
			
		} //Cierro el While
					
	$xls->download("Comunicador_CPA.xls");
	break;
	
	case 57: //Comprobar Videos LSE sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=11";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, palabras.*
			FROM palabra_imagen, palabras
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'
			AND palabra_imagen.id_palabra=palabras.id_palabra";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("videos_lse_huerfanos.xls");
	break;
	
	case 58: //Comprobar LSE sin palabra asociada. 
	$xls->addRow(Array("ID Imagen"));
		
		$query = "SELECT * FROM imagenes
		WHERE id_tipo_imagen=12";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
			$query2 = "SELECT palabra_imagen.*, palabras.*
			FROM palabra_imagen, palabras
			WHERE palabra_imagen.id_imagen='".$row['id_imagen']."'
			AND palabra_imagen.id_palabra=palabras.id_palabra";
			$result2 = mysql_query($query2);
			
				if (mysql_num_rows($result2) == 0) {	
	
					$xls->addRow(Array($row['id_imagen']));
				}
			
		}
 	$xls->download("lse_color_huerfanos.xls");
	break;
	
	case 59: //Comprobar DEFINICIONES LSE huerfanas de video
	$xls->addRow(Array("ID Palabra"));
	
	$path = "../../repositorio/LSE_definiciones/";
	$dir = opendir($path);
	while ($elemento = readdir($dir))
		{
		if($elemento != "." && $elemento != ".."){ 
		   $parte=explode('.',$elemento);
		
				$n_video=$query_class->comprobar_si_existe_ya_video_lse_acepcion($parte[0]);
			
				if ($n_video==0) {	
					$xls->addRow(Array($parte[0]));
				}
				
			} //Cierro el IF
		} //Cierro el While
 	$xls->download("definiciones_LSE_huerfanas_VIDEO.xls");
	break;
	
	case 60: //Comprobar DEFINICIONES LSE huerfanas de FOTO
	$xls->addRow(Array("ID Palabra"));
	
	$path = "../../repositorio/LSE_definiciones/";
	$dir = opendir($path);
	while ($elemento = readdir($dir))
		{
		if($elemento != "." && $elemento != ".."){ 
		   $parte=explode('.',$elemento);
		
				$n_video=$query_class->comprobar_si_existe_ya_imagen_lse_acepcion($parte[0]);
			
				if ($n_video==0) {	
					$xls->addRow(Array($parte[0]));
				}
				
			} //Cierro el IF
		} //Cierro el While
 	$xls->download("definiciones_LSE_huerfanas_IMAGEN.xls");
	break;
	
	case 61: //Comprobar Videos LSE sin DEFINICION. 
	$xls->addRow(Array("ID palabra","Palabra"));
		
		$query = "SELECT imagenes.*, palabra_imagen.*, palabras.* 
		FROM imagenes, palabra_imagen, palabras
		WHERE imagenes.id_tipo_imagen=11
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
			
			if (!file_exists("../../repositorio/LSE_definiciones/".$row['id_palabra'].".flv")) {				
	
					$xls->addRow(Array($row['id_palabra'],$row['palabra']));
			}
				
			
		}
 	$xls->download("videos_lse_huerfanos_DEFINICION.xls");
	break;
	
	case 62: //Comprobar Imagenes LSE sin DEFINICION. 
	$xls->addRow(Array("ID palabra","Palabra"));
		
		$query = "SELECT imagenes.*, palabra_imagen.*, palabras.* 
		FROM imagenes, palabra_imagen, palabras
		WHERE imagenes.id_tipo_imagen=12
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
			
			if (!file_exists("../../repositorio/LSE_definiciones/".$row['id_palabra'].".flv")) {				
	
					$xls->addRow(Array($row['id_palabra'],$row['palabra']));
			}
				
			
		}
 	$xls->download("imagenes_lse_huerfanas_DEFINICION.xls");
	break;
	
	case 63:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Euskera"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=5 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=utf8_decode($row3['traduccion']).';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_euskera));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("TICO_ByN.xls");
	break;
	
	case 64:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Gallego","Euskera"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_ga.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_ga,$palabras_euskera));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			$palabras_ga='';
			
		} //Cierro el While
					
	$xls->download("AraWord_Pictogramas_Color.xls");
	break;

	case 65:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Euskera","Gallego"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=5 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		
		while ($row=mysql_fetch_array($result)) {	

					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row['id_imagen'].'.png='.$row2['palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_gallego.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=$row['id_imagen'].'.png='.utf8_decode($row3['traduccion']).';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_euskera,$palabras_gallego));
						
					$palabras_castellano='';
					$id_palabra='';
					$palabras_chino='';
					$palabras_rumano='';
					$palabras_polaco='';
					$palabras_ruso='';
					$palabras_bulgaro='';
					$palabras_arabe='';
					$palabras_ingles='';
					$palabras_frances='';
					$palabras_catalan='';
					$palabras_euskera='';
					$palabras_italiano='';
					$palabras_portugues='';
					$palabras_aleman='';
					$palabras_br='';
					$palabras_euskera='';
					$palabras_gallego='';
			
		} //Cierro el While
					
	$xls->download("Picto_Selector_B&N.xls");
	break;
	
	case 66: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=12";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_italiano.xls");
	break;
	
	case 67: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=11";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_aleman.xls");
	break;
	
	case 68: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=13";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_portugues.xls");
	break;
	
	case 69: 
	$xls->addRow(Array("id_palabra","palabra","traduccion_1","traduccion_2","traduccion_3","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=15";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'','','',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_portugues_brasil.xls");
	break;
	
	case 70:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portuges Brasil"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['id_palabra'].'='.utf8_decode($row2['palabra']).';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=$row3['id_traduccion'].'='.utf8_decode($row3['traduccion']).';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("Comunicador_Iphone.xls");
	break;
	
	case 71:
	$xls->addRow(Array("ID imagen","castellano","Ruso","Rumano","Arabe","Chino","Bulgaro","Polaco"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=utf8_decode($row2['palabra']).'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra_2($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 1:
										if ($row3['traduccion']!= NULL) {
											$palabras_ruso.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										}
										break;
										
										case 2:
										if ($row3['traduccion']!= NULL) {
											$palabras_rumano.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										}
										break;
										
										case 3:
										if ($row3['traduccion']!= NULL) {
											$palabras_arabe.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										} 
										break;
										
										case 4:
										if ($row3['traduccion']!= NULL) {
											$palabras_chino.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										}
										break;
										
										case 5:
										if ($row3['traduccion']!= NULL) {
											$palabras_bulgaro.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										}
										break;

										case 6:
										if ($row3['traduccion']!= NULL) {
											$palabras_polaco.=$row3['id_traduccion'].'='.$row3['traduccion'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ruso,$palabras_rumano,$palabras_arabe,$palabras_chino,$palabras_bulgaro,$palabras_polaco));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("Comunicador_Iphone_UTF8.xls");
	break;
	
	case 72:

	$xls->addRow(Array("ID imagen","castellano","Ruso","Rumano","Arabe","Chino","Bulgaro","Polaco"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=utf8_decode($row2['palabra']).'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra_2($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 1:
										if ($row3['traduccion']!= NULL) {
											$palabras_ruso.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 2:
										if ($row3['traduccion']!= NULL) {
											$palabras_rumano.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 3:
										if ($row3['traduccion']!= NULL) {
											$palabras_arabe.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										} 
										break;
										
										case 4:
										if ($row3['traduccion']!= NULL) {
											$palabras_chino.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 5:
										if ($row3['traduccion']!= NULL) {
											$palabras_bulgaro.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;

										case 6:
										if ($row3['traduccion']!= NULL) {
											$palabras_polaco.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ruso,$palabras_rumano,$palabras_arabe,$palabras_chino,$palabras_bulgaro,$palabras_polaco));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("AraWord_Pictogramas_Color_UTF8.xls");
	break;
	
	case 73: 
	$xls->addRow(Array("id_palabra","palabra","traduccion","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=10";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_euskera.xls");
	break;
	
	case 74:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portuges Brasil"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
					
	$xls->download("Pictogramas_Color_idiomas_latinos_UTF-8.xls");
	break;
	
	case 75:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	/*$res_ar = $utfConverter->strToUtf8($d_palabra['traduccion']);
	$res_ru = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);
	$res_bulg = $utfConverter_ru->strToUtf8($d_palabra['traduccion']);*/
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=10 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado en HTML de TODOS los PICTOGRAMAS de COLOR con indicacion del id_imagen, palabra/traducción=id_tipo_palabra; (Idiomas NO latinos)</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">';
		echo '<tr>
				<td>ID imagen</td>
				<td>castellano</td>
				<td>Ruso</td>
				<td>Rumano</td>
				<td>Arabe</td>
				<td>Chino</td>
				<td>Bulgaro</td>
				<td>Polaco</td>
			  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra_2($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 1:
										if ($row3['traduccion']!= NULL) {
											$palabras_ruso.=$row3['id_traduccion'].'='.$utfConverter_ru->strToUtf8($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 2:
										if ($row3['traduccion']!= NULL) {
											$palabras_rumano.=$row3['id_traduccion'].'='.$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 3:
										if ($row3['traduccion']!= NULL) {
											$palabras_arabe.=$row3['id_traduccion'].'='.$utfConverter->strToUtf8($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										} 
										break;
										
										case 4:
										if ($row3['traduccion']!= NULL) {
											$palabras_chino.=$row3['id_traduccion'].'='.$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 5:
										if ($row3['traduccion']!= NULL) {
											$palabras_bulgaro.=$row3['id_traduccion'].'='.$utfConverter_ru->strToUtf8($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;

										case 6:
										if ($row3['traduccion']!= NULL) {
											$palabras_polaco.=$row3['id_traduccion'].'='.$row3['traduccion'].'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF

				echo '<tr>
				<td>'.$row['id_imagen'].'</td>
				<td>'.$palabras_castellano.'</td>
				<td>'.$palabras_ruso.'</td>
				<td>'.$palabras_rumano.'</td>
				<td>'.$palabras_arabe.'</td>
				<td>'.$palabras_chino.'</td>
				<td>'.$palabras_bulgaro.'</td>
				<td>'.$palabras_polaco.'</td>
				</tr>';
		
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			
		} //Cierro el While
		
		echo '</table>';
					
	break;
	
	case 76:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Gallego"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=5 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_ga.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_ga));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			$palabras_ga='';
			
		} //Cierro el While
					
	$xls->download("AraWord_Pictogramas_ByN.xls");
	break;
	
	case 77: 
	$xls->addRow(Array("id_palabra","palabra","traduccion","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=14";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_gallego.xls");
	break;
	
	case 78: 
	$xls->addRow(Array("id_traduccion","traduccion","definicion"));
		
		$query = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_idioma=8";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_traduccion=$row['id_traduccion'];
			if (strlen($row['definicion_traduccion']) > 250) { $definicion=substr($row['definicion_traduccion'],0,250)."(+)"; } else {  $definicion=$row['definicion_traduccion'];  }
			$xls->addRow(Array($id_traduccion,utf8_decode($row['traduccion']),$definicion));
			
			

		}
 	$xls->download("traducciones_frances.xls");
	break;
	
	case 79: 
	$xls->addRow(Array("id_palabra","palabra","traduccion","definicion"));
		
		$query = "SELECT palabras.* FROM palabras";

        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);
		
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {	
		
			$id_palabra=$row['id_palabra'];
			if (strlen($row['definicion']) > 250) { $definicion=substr($row['definicion'],0,250)."(+)"; } else {  $definicion=$row['definicion'];  }
			
			$query2 = "SELECT traducciones.*
				FROM traducciones 
				WHERE traducciones.id_palabra='$id_palabra'
				AND traducciones.id_idioma=6";
			$result2 = mysql_query($query2);
			$n_resultados=mysql_num_rows($result2);
			
			if ($n_resultados == 0) {	
									
					$xls->addRow(Array($row['id_palabra'],$row['palabra'],'',$definicion));
			
			}

		}
 	$xls->download("palabras_sin_traduccion_polaco.xls");
	break;
	
	case 80:
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
							
	$utfConverter_ch = new utf8(GB2312); 
	$utfConverter_ch->loadCharset(GB2312);
	
	$xls->addRow(Array("ID imagen","Castellano","Ingles","Frances","Catalan","Italiano","Aleman","Portugues","Portugues Brasil","Gallego"));
	
		$query = "SELECT * FROM imagenes WHERE id_tipo_imagen=12 ORDER BY id_imagen";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		$n_imagenes=mysql_num_rows($result);
		$n_columnas=2;
		$n_filas=$n_imagenes/$n_columnas;
		
		while ($row=mysql_fetch_array($result)) {	
		
					$palabras_castellano='';
					$id_palabra='';
					
					$query2 = "SELECT palabra_imagen.*, palabras.* 
							FROM palabra_imagen, palabras 
							WHERE palabra_imagen.id_imagen='".$row['id_imagen']."' 
							AND palabra_imagen.id_palabra=palabras.id_palabra";
					$connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
					$SelectedDB = mysql_select_db($DBNAME);
					$result2 = mysql_query($query2);
									
					if (mysql_num_rows($result2) > 0) {
						
						while ($row2=mysql_fetch_array($result2)) {
											
							$palabras_castellano.=$row2['palabra'].'='.$row2['id_tipo_palabra'].';';
							$id_palabra=$row2['id_palabra'];
							
							$traducciones=$query_class->buscar_traducciones_por_id_palabra($id_palabra);
							
							while ($row3=mysql_fetch_array($traducciones)) {
							
								switch ($row3['id_idioma']) {
																			
										case 7:
										if ($row3['traduccion']!= NULL) {
											$palabras_ingles.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 8:
										if ($row3['traduccion']!= NULL) {
											$palabras_frances.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 9:
										if ($row3['traduccion']!= NULL) {
											$palabras_catalan.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';'; 
										}
										break;
										
										case 10:
										if ($row3['traduccion']!= NULL) {
											$palabras_euskera.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 11:
										if ($row3['traduccion']!= NULL) {
											$palabras_aleman.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 12:
										if ($row3['traduccion']!= NULL) {
											$palabras_italiano.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 13:
										if ($row3['traduccion']!= NULL) {
											$palabras_portugues.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 14:
										if ($row3['traduccion']!= NULL) {
											$palabras_ga.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
										
										case 15:
										if ($row3['traduccion']!= NULL) {
											$palabras_br.=utf8_decode($row3['traduccion']).'='.$row2['id_tipo_palabra'].';';
										}
										break;
								
								} //Cierro el Switch
							
							} //Cierro el While de Traducciones disponibles
							
					} // Cierro el While de palabras asociadas a imagenes
				
				} else { $palabras_castellano=""; }//Cierro el IF
							
			$xls->addRow(Array($row['id_imagen'],$palabras_castellano,$palabras_ingles,$palabras_frances,$palabras_catalan,$palabras_italiano,$palabras_aleman,$palabras_portugues,$palabras_br,$palabras_ga));
			
			$palabras_chino='';
			$palabras_rumano='';
			$palabras_polaco='';
			$palabras_ruso='';
			$palabras_bulgaro='';
			$palabras_arabe='';
			$palabras_ingles='';
			$palabras_frances='';
			$palabras_catalan='';
			$palabras_euskera='';
			$palabras_italiano='';
			$palabras_portugues='';
			$palabras_aleman='';
			$palabras_br='';
			$palabras_ga='';
			
		} //Cierro el While
					
	$xls->download("AraWord_LSE_Color.xls");
	break;
	
	case 81:
	
		$query = "SELECT traducciones_4.*, palabras.*
		FROM traducciones_4, palabras 
		WHERE traducciones_4.id_palabra=palabras.id_palabra";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query); 
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Chino</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>Traducción</td>
			<td>Castellano</td>
			<td>Definición</td>
			<td>Locución</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
		
			echo '<tr>
				<td>'.$row['id_traduccion'].'</td>
				<td>'.$row['traduccion'].'</td>
				<td>'.$row['palabra'].'</td>
				<td>'.utf8_encode($row['definicion']).'</td>';
				echo '<td>';
				if (file_exists('../../repositorio/locuciones/4/'.$row['id_traduccion'].'.mp3')) {
					echo '<a href="'.$row['id_traduccion'].'.mp3">SI</a>';
				} else {
					echo "NO";
				}
				echo '</td>';
			 echo '</tr>'; 
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
	case 82:
	
		$query = "SELECT traducciones_8.*, palabras.*
		FROM traducciones_8, palabras 
		WHERE traducciones_8.id_palabra=palabras.id_palabra";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query);
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Francés</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>Traducción</td>
			<td>Castellano</td>
			<td>Definición</td>
			<td>Locución</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
		
			echo '<tr>
				<td>'.$row['id_traduccion'].'</td>
				<td>'.$row['traduccion'].'</td>
				<td>'.$row['palabra'].'</td>
				<td>'.utf8_encode($row['definicion']).'</td>';
				echo '<td>';
				if (file_exists('../../repositorio/locuciones/8/'.$row['id_traduccion'].'.mp3')) {
					echo '<a href="'.$row['id_traduccion'].'.mp3">SI</a>';
				} else {
					echo "NO";
				}
				echo '</td>';
			 echo '</tr>';  
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
	case 83: 
	$query = "SELECT traducciones_15.*
		FROM traducciones_15 ";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query);
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Francés</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>Traducción</td>
			<td>Definición</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
		
			echo '<tr>
				<td>'.$row['id_traduccion'].'</td>
				<td>'.$row['traduccion'].'</td>
				<td>'.utf8_decode($row['definicion_traduccion']).'</td>';
			 echo '</tr>';  
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
	case 84: 
	$query = "SELECT traducciones_16.*
		FROM traducciones_16 ";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query);
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Francés</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>Traducción</td>
			<td>Definición</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
		
			echo '<tr>
				<td>'.$row['id_traduccion'].'</td>
				<td>'.$row['traduccion'].'</td>
				<td>'.utf8_decode($row['definicion_traduccion']).'</td>';
			 echo '</tr>';  
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
	case 85: 
	$query = "SELECT traducciones_7.*
		FROM traducciones_7 ";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query);
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Francés</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>ID Palabra</td>
			<td>Traducción</td>
			<td>Definición</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
			if ($row['traduccion'] != "") {
				echo '<tr>
					<td>'.$row['id_traduccion'].'</td>
					<td>'.$row['id_palabra'].'</td>
					<td>'.$row['traduccion'].'</td>
					<td>'.utf8_decode($row['definicion_traduccion']).'</td>';
				 echo '</tr>';
			}
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
	case 86: 
	$query = "SELECT traducciones_16.*
		FROM traducciones_16";
        $connection = mysql_connect($HOST, $USERNAME, $PASSWORD);	
		$SelectedDB = mysql_select_db($DBNAME);
		$result = mysql_query($query);
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Traducciones en Croata</title>
</head>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<tr>
			<td>ID Traduccion</td>
			<td>ID Palabra</td>
			<td>Traducción</td>
			<td>Definición</td>
		  </tr>';
		
		while ($row=mysql_fetch_array($result)) {	
			if ($row['traduccion'] != "") {
				echo '<tr>
					<td>'.$row['id_traduccion'].'</td>
					<td>'.$row['id_palabra'].'</td>
					<td>'.$row['traduccion'].'</td>
					<td>'.utf8_decode($row['definicion_traduccion']).'</td>';
				 echo '</tr>';
			}
		} 
		echo '</table>
		<body>
		</body>
		</html>';
	break;
	
}
?>