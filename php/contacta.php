<?php 
require('requires_basico.php');
require ('funciones/funciones.php');

/* INICIALIZO LA CLASE FILTER QUE PREVIENE ATAQUES XSS de INYECCION DE CODIGO HTML */
require ('classes/inputfilter/class.inputfilter.php');
$ifilter = new InputFilter();


$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],13); 

/* INICIALIZO LAS VARIABLES */
/************************************************************************* */
$email='';
$p_contacto='';
$cuerpo='';
$asunto='';
/************************************************************************* */

/* FILTRO TODOS LOS $_POST PARA EVITAR ATAQUES DE INYECCION DE CODIGO XSS */
$_POST = $ifilter->process($_POST);
$_GET = $ifilter->process($_GET);
/************************************************************************* */

if (isset($_GET['c']) && $_GET['c']==1) { 

	$asunto=$translate['formulario_contacto'].": ".$translate['envio_materiales'];
	
}


/************************************************************************* */
if (isset($_POST['enviar_formulario_contacto'])) { 

	$email=$_POST['email'];
	$p_contacto=utf8_decode($_POST['persona_contacto']);
	$cuerpo=utf8_decode($_POST['cuerpo']);

	if ((!$email) || (!$p_contacto) || (!$cuerpo))
	{
		$mensaje='<div class="mensaje">'.$translate['rellene_todos_parametros'].'</div>';
	
	} else {
		
		if (comprobar_email($email)==1) { 
			if (!isset($_POST['asunto']) || $_POST['asunto']=='') { $asunto=$translate['formulario_contacto'].": ARASAAC"; } else { $asunto=$translate['formulario_contacto']." ARASAAC: ".$_POST['asunto']; }
			$ruta='classes/mail/';
			
			$destinatario = "arasaac@educa.aragon.es"; 
			enviar_mail($email,$p_contacto,$destinatario,$asunto, $cuerpo, $cuerpo,$ruta);
			
			$mensaje='<div class="mensaje">'.$translate['mensaje_enviado'].'</div>';
		
			$email='';
			$p_contacto='';
			$cuerpo='';
			$asunto='';
		} elseif (comprobar_email($email)==0) { 
		
			$mensaje='<div class="mensaje">'.utf8_decode($translate['email_erroneo']).'</div>';
		}
	
	 }
}
 
require('cabecera_html.php');
?>
    <title>ARASAAC: <?php echo $translate['cabecera_contacta']; ?></title>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
	<script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script> 
    <?php require ('text_size_css.php'); ?>
</head>

<body>
            
<div class="body_content"> 

	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>	
      <br /><h4><?php echo $translate['cabecera_contacta']; ?></h4>	
		<div id="principal">
          <div id="formulario_contacta">
			<?php if (isset($mensaje)) { echo utf8_encode($mensaje).'<br>'; } ?>
<div style="float:right;">
                            <div id="loading"><img src="images/loading2.gif" alt="<?php echo $translate['cargando']; ?>..." /></div>
                        </div>
                        <br />
            		<form action="<?php echo $PHP_SELF; ?>" method="POST" name="contacta" id="contacta">
                      <p align="left"><strong><label for="persona_contacto"><?php echo $translate['nombre'].':'; ?></label></strong><br />
                        <input name="persona_contacto" type="text" class="contacta_input" id="persona_contacto" value="<?php echo $p_contacto; ?>" size="50" maxlength="75" realname="<?php echo $translate['nombre']; ?>" />
                      (*)</p>
                      <p align="left"><strong><label for="email"><?php echo $translate['email_contacto']; ?></label></strong><br />
                          <input name="email" type="text" class="contacta_input" id="email" size="40" maxlength="40" value="<?php echo $email; ?>">
                      (*)</p>
                      <strong>
                      <label for="asunto"><?php echo $translate['asunto']; ?></label>
                      </strong><br />
                      <input name="asunto" type="text" class="contacta_input" id="asunto" size="40" maxlength="60" value="<?php echo $asunto; ?>">
                      <br /><br />
                      <p><strong><label for="cuerpo"><?php echo $translate['texto_mensaje']; ?></label>
                      </strong> (*)</p>
                      <p>&nbsp;&nbsp;
                        <textarea name="cuerpo" cols="60" rows="8" wrap="VIRTUAL" id="cuerpo" realname="<?php echo $translate['texto_mensaje']; ?>"><?php echo $cuerpo; ?></textarea>
                      </p>
            (*) <?php echo $translate['campos_obligatorios']; ?><br /><br />
            <p>
              <label>
                <input type="submit" name="enviar_formulario_contacto" id="enviar_formulario_contacto" value="<?php echo $translate['enviar']; ?>" class="boton_grande" />
              </label>
              <input type="hidden" name="enviar_formulario_contacto" id="enviar_formulario_contacto">
            </p>
            </form>
            </div>
        </div>

	    <?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>

