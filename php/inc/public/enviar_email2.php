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
echo '<div  align="center"><div class="mensaje">'.$translate['rellene_todos_parametros'].'</div></div></br>'; ?>
			<div id="products" style="float:right;">
				<div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>
		    </div>
            <br />
<form action="" method="post" name="contacta" id="contacta">
		  <p align="left"><strong><?php echo $translate['nombre'].':'; ?></strong>&nbsp;
              <input name="persona_contacto" type="text" id="persona_contacto" value="<?php echo $p_contacto; ?>" size="50" maxlength="75" realname="<?php echo $translate['nombre']; ?>">
          </p>
		  <p align="left"><strong><?php echo $translate['email_contacto']; ?></strong>&nbsp;
		      <input name="email" type="text" id="email" value="<?php echo $email; ?>" size="40" maxlength="40" realname="<?php echo  $translate['email_contacto']; ?>">
  </p>
          <br />
		  <p align="left"><strong><?php echo $translate['texto_mensaje']; ?></strong></p>
		  <p>&nbsp;&nbsp;
		    <textarea name="cuerpo" cols="60" rows="8" wrap="VIRTUAL" id="cuerpo" realname="<?php echo $translate['texto_mensaje']; ?>"><?php echo $cuerpo; ?></textarea>
  </p>
        <br /><br />
            <p align="center">
              <label>
                <input type="button" name="enviar" id="enviar" value="<?php echo $translate['enviar']; ?>" onClick="cargar_div2('inc/public/enviar_email2.php','persona='+document.contacta.persona_contacto.value+'&email='+document.contacta.email.value+'&texto='+document.contacta.cuerpo.value+'','formulario_contacta');" class="boton_grande" />
              </label>
            </p>
  </form>
<?php 
} else {

$asunto="Formulario de contacto: ARASAAC";
$ruta='../../classes/mail/';

$destinatario = "arasaac@educa.aragon.es"; 
enviar_mail($email,$p_contacto,$destinatario,$asunto, $cuerpo, $cuerpo,$ruta);

echo '<div  align="center"><div class="mensaje">'.$translate['mensaje_enviado'].'</div></div></br>';
 ?>
			<div id="products" style="float:right;">
				<div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>
		    </div>
            <br />
<form action="" method="post" name="contacta" id="contacta">
		  <p align="left"><strong><?php echo $translate['nombre'].':'; ?></strong>&nbsp;
              <input name="persona_contacto" type="text" id="persona_contacto" size="50" maxlength="75" realname="<?php echo $translate['nombre']; ?>">
          </p>
		  <p align="left"><strong><?php echo $translate['email_contacto']; ?></strong>&nbsp;
		      <input name="email" type="text" id="email" size="40" maxlength="40" realname="<?php echo  $translate['email_contacto']; ?>">
  </p>
          <br />
		  <p align="left"><strong><?php echo $translate['texto_mensaje']; ?></strong></p>
		  <p>&nbsp;&nbsp;
		    <textarea name="cuerpo" cols="60" rows="8" wrap="VIRTUAL" id="cuerpo" realname="<?php echo $translate['texto_mensaje']; ?>"></textarea>
  </p>
        <br /><br />
            <p align="center">
              <label>
                <input type="button" name="enviar" id="enviar" value="<?php echo $translate['enviar']; ?>" onClick="cargar_div2('inc/public/enviar_email2.php','persona='+document.contacta.persona_contacto.value+'&email='+document.contacta.email.value+'&texto='+document.contacta.cuerpo.value+'','formulario_contacta');" class="boton_grande" />
              </label>
            </p>
</form>
<?php }
?>
