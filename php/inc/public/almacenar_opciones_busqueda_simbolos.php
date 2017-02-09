<?php 
session_start();

include ('../../classes/querys/query.php');

$_SESSION['minusculas']=0;
$_SESSION['mayusculas']=0;
$_SESSION['castellano']=0;
$_SESSION['ruso']=0;
$_SESSION['rumano']=0;
$_SESSION['arabe']=0;
$_SESSION['chino']=0;
$_SESSION['bulgaro']=0;
$_SESSION['polaco']=0;
$_SESSION['ingles']=0;
$_SESSION['frances']=0;
$_SESSION['catalan']=0;

$condicionantes=explode('||',$_POST['checkboxes']);

foreach ($condicionantes as $nombre_campo => $valor) {

	if ($valor != '') {
		$val=explode('=',$valor);
		$_SESSION[''.$val[0].'']=$val[1];
	}
	
}

if (!isset($_POST['tipo_letra'])) {
	$_SESSION['tipo_letra']=99; 
} else { $_SESSION['tipo_letra']=$_POST['tipo_letra']; }

if (!isset($_POST['id_tipo'])) {
	$_SESSION['id_tipo']=99; 
} else { $_SESSION['id_tipo']=$_POST['id_tipo']; }

if (!isset($_POST['tipo_simbolo'])) {
	$_SESSION['id_tipo_simbolo']=99; 
} else { $_SESSION['id_tipo_simbolo']=$_POST['tipo_simbolo'];}

if (!isset($_POST['marco'])) {
	$_SESSION['marco']=99; 
} else { $_SESSION['marco']=$_POST['marco']; }

if (!isset($_POST['contraste'])) {
	$_SESSION['contraste']=99; 
} else { $_SESSION['contraste']=$_POST['contraste']; }


echo '<span class="mensaje" style="padding-left: 20px; padding-right: 20px; padding-top:1px; padding-bottom:1px;">Parámetros almacenados</ span>';
?>