<?php 
include ('../../classes/querys/query.php');

$query=new query();

$nombre=$_POST['nombre'];
$primer_apellido=$_POST['primer_apellido'];
$segundo_apellido=$_POST['segundo_apellido'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];
$email=$_POST['email'];
$centro=$_POST['centro'];

if ($_POST['accion']=="add_portal") {

$comprobar_login=$query->comprobar_login($usuario);

	if ($comprobar_login==0) {
	
		$nuevo_usuario=$query->add_usuario_portal($nombre,$primer_apellido,$segundo_apellido,$usuario,$password,$email,$t_ruso,$t_arabe,$t_rumano,$t_chino,$t_polaco,$t_bulgaro,$t_ingles,$t_frances,$gestion_usuarios,$gestion_palabras,$definicion_palabras,$borrar_palabras,$add_imagenes,$borrar_imagenes,$add_simbolos,$borrar_simbolos,$simbolos_especiales);
	
	}


} 

echo "Uuario creado, compruebe su correo electrónico para confirmar el registro";
?>
