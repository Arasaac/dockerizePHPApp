<?php 
session_start(); 
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],16); 

echo '<div id="formulario_contacta" align="left" style="padding:10px;">	'; 

echo utf8_encode('<h3>'.$translate['boletin_noticias'].'</h3>
<br />'.$translate['explicacion_subscripcion_boletin'].'<br /><br />'); 

echo '<form action="" method="post" name="contacta" id="contacta">
<p align="center">&nbsp;<br />
    <input name="email" type="text" id="email" maxlength="40" size="40" style="font-size:18px; text-align:center; color:#3366FF;">
</p>
    <br /><p align="center"><input type="button" value="'.$translate['subscribirse'].'" onClick="cargar_div2(\'inc/public/subscribirse_boletin_noticias.php\',\'email=\'+document.contacta.email.value+\'\',\'formulario_contacta\');" style="font-size:20px;"/>
    </p><br />
</form>
</div>';
 ?>
