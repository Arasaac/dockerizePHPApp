<?php 
session_start(); 
require ('../../classes/languages/language_detect.php');
include ('../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],16); 

include ('../../funciones/funciones.php');
require_once('../../configuration/key.inc');
require ('../../classes/crypt/5CR.php'); 
$encript = new E5CR($llave);
$email=$_POST['email'];

if (!isset($_POST['email']) || $_POST['email'] =='') {

echo '<h3>'.$translate['boletin_noticias'].'</h3>
	 <div align="center"><div class="mensaje">&nbsp;&nbsp;'.$translate['escriba_email'].'&nbsp;&nbsp;</div></div><br> 
'.$translate['explicacion_subscripcion_boletin'].'<br /><br />'; 

echo '<form action="" method="post" name="contacta" id="contacta">
<p align="center">&nbsp;<br />
    <input name="email" type="text" id="email" maxlength="40" size="40" style="font-size:18px; text-align:center; color:#3366FF;">
</p><br />
    <p align="center"><input type="button" value="'.$translate['subscribirse'].'" onClick="cargar_div2(\'inc/public/subscribirse_boletin_noticias.php\',\'email=\'+document.contacta.email.value+\'\',\'formulario_contacta\');" style="font-size:20px;"/>
    </p>
</form>';

} else {

	if (comprobar_email($_POST['email'])==1) {
	
		$email_subscriptor=$query->comprobar_email_subscriptor($_POST['email']);
		$num_emails=mysql_num_rows($email_subscriptor);
		$row_emails=mysql_fetch_array($email_subscriptor);
		
			if ($num_emails>0) { 
				echo '<h3>'.$translate['boletin_noticias'].'</h3><br />';
					if ($row_emails['activo']==0) { 
					
						$id_subscriptor=$row_emails['id_subscriptor'];
						
						$ruta='idusu='.$id_subscriptor.'&os='.rand(100000000000000000000,10000000000000000000000000000000000000000);
						$encript->encriptar($ruta,1);
					
						$url_confirmacion='http://localhost/saac/?s='.$ruta;
						
						$from='arasaac@educa.aragon.es';
						$fromname='ARASAAC';
						$email_destinatario=$row_emails['email_subscriptor'];
						$asunto=$translate['confirmacion_subscripcion_boletin'];
						$cuerpo=$translate['texto_email_subscripcion_1'].': <a href="'.$url_confirmacion.'">'.$url_confirmacion.'<a/>';
						$cuerpo_html=$translate['texto_email_subscripcion_1'].': <a href="'.$url_confirmacion.'">'.$url_confirmacion.'<a/>';
						$ruta='../../classes/mail/';
						
						$envio=enviar_mail($from,$fromname,$email_destinatario,$asunto, $cuerpo, $cuerpo_html,$ruta);
						
						echo '<div align="center"><div style="border: 1px solid #990000; color:#FF0000; background-color:#FFFFCC;">&nbsp;&nbsp;'.$translate['mensaje_boletin_1'].'<br /></div></div><br>'; 
					} elseif ($row_emails['activo']==1) { 
					
						echo '<div align="center"><div style="border: 1px solid #990000; color:#FF0000; background-color:#FFFFCC;">&nbsp;&nbsp;'.$translate['mensaje_boletin_2'].'<br /></div></div><br>'; 
					}
			} elseif ($num_emails==0) {
	
					$id_subscriptor=$query->add_subscriptor($_POST['email']);
					
					$ruta='idusu='.$id_subscriptor.'&os='.rand(100000000000000000000,10000000000000000000000000000000000000000);
					$encript->encriptar($ruta,1);
					
					$url_confirmacion='http://localhost/saac/?s='.$ruta;
						
						$from='arasaac@educa.aragon.es';
						$fromname='ARASAAC';
						$email_destinatario=$_POST['email'];
						$asunto=$translate['confirmacion_subscripcion_boletin'];
						$cuerpo=$translate['texto_email_subscripcion_1'].': <a href="'.$url_confirmacion.'">'.$url_confirmacion.'<a/>';
						$cuerpo_html=$translate['texto_email_subscripcion_1'].': <a href="'.$url_confirmacion.'">'.$url_confirmacion.'<a/>';
						$ruta='../../classes/mail/';
						
					$envio=enviar_mail($from,$fromname,$email_destinatario,$asunto, $cuerpo, $cuerpo_html,$ruta);
						
					echo '<h3>'.$translate['boletin_noticias'].'</h3><br />
						 <div align="center"><div style="border: 1px solid #990000; color:#FF0000; background-color:#FFFFCC;">&nbsp;&nbsp;'.$translate['mensaje_boletin_3'].'<br /></div></div><br>'; 
			
			}
			
	} elseif (comprobar_email($_POST['email'])==0) {

		echo '<h3>'.$translate['boletin_noticias'].'</h3>
		 <div align="center"><div class="mensaje">&nbsp;&nbsp;'.$translate['escriba_email_valido'].'&nbsp;</div></div><br> 
	'.$translate['explicacion_subscripcion_boletin'].'<br /><br />'; 
	
	echo '<form action="" method="post" name="contacta" id="contacta">
	<p align="center">&nbsp;<br />
		<input name="email" type="text" id="email" maxlength="40" size="40" style="font-size:18px; text-align:center; color:#3366FF;">
	</p><br />
		<p align="center"><input type="button" value="'.$translate['subscribirse'].'" onClick="cargar_div2(\'inc/public/subscribirse_boletin_noticias.php\',\'email=\'+document.contacta.email.value+\'\',\'formulario_contacta\');" style="font-size:20px;"/>
		</p>
	</form>';
	
	}
}
?>