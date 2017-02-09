<?php
require_once("../../lang/lang_es.php");
require_once("../../funciones/funciones.php");
include ('../../classes/querys/query.php');

$query=new query();

require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave


$nombre=$_POST['nombre'];
$primer_apellido=$_POST['primer_apellido'];
$segundo_apellido=$_POST['segundo_apellido'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];
$email=$_POST['email'];
$centro=$_POST['centro'];


if ((!$nombre) || (!$primer_apellido) || (!$usuario) || (!$password) || (!$email) || (!$centro))
{
echo '<br><div  align="center"><div class="mensaje">'.utf8_encode($lang['mensaje1']).'</div></div><br>';
include ("registro.php");
} else {

$id_usuario=$query->registro_previo_usuario($nombre,$primer_apellido,$segundo_apellido,$usuario,$password,$email,$centro);

$link='id_usuario='.$id_usuario;

$encript->encriptar($link,1); 

$asunto="Registro en el Portal ARASAAC";
$p_contacto="Portal ARASAAC";
$email_emisor="arasaac@educa.aragon.es";
$ruta='../../classes/mail/';

$destinatario = $email; 
$cuerpo='Este mensaje ha sido enviado desde una dirección de correo electrónico exclusivamente de notificación que no admite mensajes. Por favor, no responda a este mensaje. 

Estimado/a '.$nombre.' '.$primer_apellido.' '.$segundo_apellido.'

Para confirmar su registro como usuario en ARASAAC debe hacer clic en el siguiente enlace:

<a href="http://catedu.es/internos/servicios/saac/confirmar_registro.php?i='.$link.'">http://catedu.es/internos/servicios/saac/confirmar_registro.php?i='.$link.'</a> 

Dispone de 1 semana para confirmar su registro. En caso de no hacerlo su cuenta será cancelada. Si tiene cualquier problema no dude en contactar con nosotros desde el Portal.

Atentamente, 

Administrador ARASAAC';


enviar_mail($email_emisor,$p_contacto,$destinatario,$asunto, $cuerpo, $cuerpo,$ruta);


echo '<br><div  align="center"><div class="mensaje">'.utf8_encode('Mensaje enviado. Para completar su registro deberá responder al mail que recibirá en breves instantes.').'</div></div><br>';

}
?>
