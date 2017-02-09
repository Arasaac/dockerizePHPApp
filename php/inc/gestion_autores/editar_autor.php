<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_autor=$_POST['id'];
$pg=$_POST['pg'];

$row=$query->datos_autor($id_autor);
?>
<form action="javascript:cargar_div('inc/gestion_autores/add_autor.php','accion=actualizar&id_autor='+document.usuario.id_autor.value+'&nombre='+document.usuario.nombre.value+'&empresa_institucion='+document.usuario.empresa_institucion.value+'&web_autor='+document.usuario.web_autor.value+'&email='+document.usuario.email.value+'&pg=<?php echo $pg; ?>','listado_usuarios'); cargar_div('inc/gestion_autores/nuevo_autor.php','i=','usuario');" method="post" name="usuario" id="usuario" onSubmit="return validateStandard(this, 'error');">
<h3>Actualizar usuario: </h3>
<div class="right_articles" style="height:260px;">
  <p><b>Nombre y apellidos</b>:<br />
    <input name="nombre" type="text" required="1" id="nombre" onkeypress="return handleEnter(this, event)" value="<?php echo utf8_encode($row['autor']); ?>" size="30" maxlength="50" regexp="/^\w*$/" realname="Nombre"/>
    </p>
  <p><strong>Empresa / Institución:</strong><br />
      <input name="empresa_institucion" type="text" id="empresa_institucion" onkeypress="return handleEnter(this, event)" value="<?php echo utf8_encode($row['empresa_institucion']); ?>" size="30" maxlength="50" regexp="/^\w*$/" realname="Empresa o Institución"/>
    </p>
  <p><strong>Web: </strong><br />
    <input name="web_autor" type="text" id="web_autor" onkeypress="return handleEnter(this, event)" value="<?php echo $row['web_autor']; ?>" size="30" maxlength="50" regexp="/^\w*$/" realname="Web del autor" />
    </p>
  <p><strong>Email:</strong><br />
    <input name="email" type="text" id="email" onkeypress="return handleEnter(this, event)" value="<?php echo $row['email_autor']; ?>" maxlength="150"/>
    <input name="id_autor" type="hidden" id="id_autor" value="<?php echo $id_autor; ?>" />
  </p>
</div>
    <div id="boton" align="center">
				  <input type="submit" name="Submit22" value="Actualizar datos"/>
  </div>
		  </p>
		</div>
</form>  
	  