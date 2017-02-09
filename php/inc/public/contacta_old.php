<?php 
require ('../../lang/lang_es.php');
include ('../../classes/querys/query.php');
$query= new query();
?>
<div class="left">
			<h3><?php echo utf8_encode($lang['cabecera_contacta']); ?></h3>
			<p><?php echo utf8_encode($lang['texto_contacta']); ?></p>
			<hr>
			<form action="aplicacion/enviar_email.php" method="post" name="contacta" id="contacta" onSubmit="return validateCompleteForm(this, 'error');">
		  <p><strong><?php echo  utf8_encode($lang['persona_contacto']); ?></strong>&nbsp;
              <input name="persona_contacto" type="text" id="persona_contacto" required="1" regexp="/^\w*$/" realname="<?php echo  $lang['persona_contacto']; ?>" maxlength="75" size="50" onkeypress="return handleEnter(this, event)">
          </p>
		  <p><strong><?php echo  utf8_encode($lang['email_contacto']); ?></strong>&nbsp;
		      <input name="email" type="text" id="email" required="1" regexp="email" realname="<?php echo  $lang['email_contacto']; ?>" maxlength="40" size="40" onkeypress="return handleEnter(this, event)">
          </p>
		  <p><strong><?php echo  utf8_encode($lang['mensaje']); ?></strong></p>
		  <p>&nbsp;&nbsp;<textarea name="cuerpo" cols="50" rows="8" wrap="VIRTUAL" id="cuerpo" required="1" regexp="/^\w*$/" realname="<?php echo  $lang['mensaje']; ?>"></textarea>
            <input name="lang" type="hidden" id="lang" value="<?php echo $conf['lang'];?>" />
</p>
		  <p align="center"><input type="button" name="submit" value="<?php echo utf8_encode($lang['boton_mensaje']); ?>" onClick="cargar_div('inc/public/enviar_email.php','persona='+document.contacta.persona_contacto.value+'&email='+document.contacta.email.value+'&texto='+document.contacta.cuerpo.value+'','principal')"/>
		  </p>
  </form>
</div>


<?php include ("derecho.php"); ?>