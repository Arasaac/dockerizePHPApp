<?php
require ('../../classes/languages/language_detect.php');
require_once("../../lang/lang_es.php");
require_once("../../funciones/funciones.php");
include ('../../classes/querys/query.php');
$query= new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],13); 
	
$email=$_POST['email'];
$p_contacto=utf8_decode($_POST['persona']);
$cuerpo=utf8_decode($_POST['texto']);

if ((!$email) || (!$p_contacto) || (!$cuerpo))
{
echo '<div  align="center"><div class="mensaje">'.$translate['rellene_todos_parametros'].'</div></div><br>'; ?>
<h3><?php echo $translate['cabecera_contacta']; ?>
			<div id="products" style="float:right;">
				<div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>
		    </div>
			</h3>
            <br />
<form action="" method="post" name="contacta" id="contacta" onSubmit="return validateCompleteForm(this, 'error');">
		  <p align="left"><strong><?php echo $translate['nombre'].':'; ?></strong>&nbsp;
              <input name="persona_contacto" type="text" id="persona_contacto" required="1" regexp="/^\w*$/" realname="<?php echo $translate['nombre']; ?>" maxlength="75" size="50" onkeypress="return handleEnter(this, event)">
          </p>
		  <p align="left"><strong><?php echo $translate['email_contacto']; ?></strong>&nbsp;
		      <input name="email" type="text" id="email" required="1" regexp="email" realname="<?php echo  $translate['email_contacto']; ?>" maxlength="40" size="40" onkeypress="return handleEnter(this, event)">
          </p>
          <br />
		  <p align="left"><strong><?php echo $translate['texto_mensaje']; ?></strong></p>
		  <p>&nbsp;&nbsp;
		    <textarea name="cuerpo" cols="60" rows="8" wrap="VIRTUAL" id="cuerpo" required="1" regexp="/^\w*$/" realname="<?php echo $translate['texto_mensaje']; ?>"></textarea>
</p>
<br /><br />
<p align="center"><img src="images/mail_foward.png" alt="Enviar" onClick="cargar_div('inc/public/enviar_email.php','persona='+document.contacta.persona_contacto.value+'&email='+document.contacta.email.value+'&texto='+document.contacta.cuerpo.value+'','formulario_contacta');" /> &nbsp;<a href="javascript:void(0);" onclick="cargar_div('inc/public/enviar_email.php','persona='+document.contacta.persona_contacto.value+'&email='+document.contacta.email.value+'&texto='+document.contacta.cuerpo.value+'','formulario_contacta');"><b><?php echo $translate['enviar']; ?></b></a>
		  </p>
  </form>
<?php 
} else {

$asunto="Formulario de contacto: ARASAAC";
$ruta='../../classes/mail/';

$destinatario = "arasaac@educa.aragon.es"; 
enviar_mail($email,$p_contacto,$destinatario,$asunto, $cuerpo, $cuerpo,$ruta);

echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><div  align="center"><div class="mensaje">'.$translate['mensaje_enviado'].'</div></div><br /><br /><br /><br /><br /><br />';

}
?>
