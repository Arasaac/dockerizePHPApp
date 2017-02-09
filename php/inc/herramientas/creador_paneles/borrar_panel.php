<?php 
session_start();
$id_usuario=$_SESSION['ID_USER'];

if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {
die; 
}

include ('../../../classes/querys/query.php');
$query=new query();
$delete=$query->borrar_panel($_POST['idd'],$id_usuario);
echo "SU PANEL HA SIDO BORRADO";

?>