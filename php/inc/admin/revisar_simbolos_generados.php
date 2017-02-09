<?php 
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

foreach($_POST as $nombre_campo => $valor) {

	if ($nombre_campo != 'button') { 
		//echo $nombre_campo.'='.$valor.'<br />';
		$validacion=$query->validar_simbolos_temporales($nombre_campo,$valor);
	}
	
}

$inicial=0;
$cantidad=100;

$resultados=$query->listar_simbolos_provisionales_limit($inicial,$cantidad);

echo '<form name="form1" method="post" action="">';
echo '<div><ul>';
while ($row=mysql_fetch_array($resultados)) {

	$file=$row['archivo_temporal'];
	$folder=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
	$id_smb_temp=$row['id_simbolo_tmp'];
	$ruta_img='size=150&ruta=../../repositorio/simbolos/pendientes/'.$folder.'/'.$file;
	$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL
    echo "<li style=\"border: 1px solid #000; margin: 10px; padding: 10px; list-style-type: none; position: relative; width: 150px; height: 170px; float: left; \"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/><br /><label><img src=\"../../images/ok1.gif\" border=\"0\"><input type=\"radio\" name=\"".$id_smb_temp."\" id=\"".$id_smb_temp."\" value=\"1\" style=\"font-size:18px;\" checked></label>&nbsp;&nbsp;<label><img src=\"../../images/no_visible.gif\" border=\"0\"><input type=\"radio\" name=\"".$id_smb_temp."\" id=\"".$id_smb_temp."\" value=\"2\" style=\"font-size:18px;\"></label></li>"; 

} //Cierro el While que recorre los simbolos provisionales pendientes de revisar
echo '</ul></div>';
echo '<input type="submit" name="button" id="button" value="Enviar" style="position: relative; float: right; font-size: 40px; margin-top:50px;">';
echo '</form>';
?>
