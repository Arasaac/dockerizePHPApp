<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_usuario=$_POST['id'];

$usuario=$query->datos_usuario($id_usuario);
$row=mysql_fetch_array($usuario);

?>
<form action="javascript:cargar_div('inc/gestion_usuarios/add_usuario.php','accion=actualizar&id_usuario='+document.usuario.id_usuario.value+'&nombre='+document.usuario.nombre.value+'&primer_apellido='+document.usuario.primer_apellido.value+'&segundo_apellido='+document.usuario.segundo_apellido.value+'&usuario='+document.usuario.login.value+'&password='+document.usuario.password.value+'&email='+document.usuario.email.value+'&t_ruso='+document.usuario.traduccion_ruso.checked+'&t_arabe='+document.usuario.traduccion_arabe.checked+'&t_rumano='+document.usuario.traduccion_rumano.checked+'&t_chino='+document.usuario.traduccion_chino.checked+'&t_bulgaro='+document.usuario.traduccion_bulgaro.checked+'&t_polaco='+document.usuario.traduccion_polaco.checked+'&t_ingles='+document.usuario.traduccion_ingles.checked+'&t_frances='+document.usuario.traduccion_frances.checked+'&t_catalan='+document.usuario.traduccion_catalan.checked+'&gestion_usuarios='+document.usuario.gestion_usuarios.checked+'&gestion_palabras='+document.usuario.gestion_palabras.checked+'&definicion_palabras='+document.usuario.definicion_palabras.checked+'&borrar_palabras='+document.usuario.borrar_palabras.checked+'&add_imagenes='+document.usuario.add_imagenes.checked+'&borrar_imagenes='+document.usuario.borrar_imagenes.checked+'&add_simbolos='+document.usuario.add_simbolos.checked+'&borrar_simbolos='+document.usuario.borrar_simbolos.checked+'&simbolos_especiales='+document.usuario.simbolos_especiales.checked+'&gestionar_materiales='+document.usuario.gestionar_materiales.checked+'&gestionar_enlaces='+document.usuario.gestionar_enlaces.checked+'','usuario'); cargar_div('inc/gestion_usuarios/listado_usuarios.php','id=0','listado_usuarios');" method="post" name="usuario" id="usuario" onSubmit="return validateStandard(this, 'error');">
<h3>Datos usuario:</h3>
<div class="right_articles" style="height:260px;">
		<p><b>Nombre</b>:<br />
          <input name="nombre" type="text" id="nombre" value="<?php echo $row['nombre'];?>" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Nombre"/>
      </p>
			  <p><strong>Primer apellido:</strong><br />
                    <input name="primer_apellido" type="text" id="primer_apellido" value="<?php echo $row['primer_apellido'];?>" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Primer Apellido"/>
              </p>
			    <p><strong>Segundo apellido: </strong><br />
			      <input name="segundo_apellido" type="text" id="segundo_apellido" value="<?php echo $row['segundo_apellido'];?>" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Segundo Apellido" />
              </p>
			    <p><strong>Email:</strong><br />
			      <input name="email" type="text" id="email" value="<?php echo $row['email'];?>" maxlength="150" />
              </p>
			    <p>
			      <strong>Login: </strong><br />
			      <input name="login" type="text" id="login" value="<?php echo $row['login'];?>" size="11" minlength="5" maxlength="10" required="1" regexp="/^\w*$/" realname="Usuario" onkeyup="cargar_div('inc/gestion_usuarios/comprobar_usuario.php','login='+this.value+'&boton=Actualizar datos','boton');"/>
			    </p>
	    <p><strong>Password:</strong><br />
			      <input name="password" type="text" id="password" value="<?php echo $row['password'];?>" size="11" maxlength="10" required="1" regexp="/^\w*$/" realname="Password" />
				  <input name="id_usuario" type="hidden" id="id_usuario" value="<?php echo $id_usuario?>">
    </p>
  </div>
	<h3>Permisos:</h3>
		<div class="right_articles" style="height:260px;">
	    <p><b>Traducci&oacute;n</b><br />
		<input name="traduccion_ruso" type="checkbox" id="traduccion_ruso" value="1" <?php if ($row['traduccion_ruso']==1) { echo 'checked'; } ?> /> &nbsp;Ruso
		<input name="traduccion_chino" type="checkbox" id="traduccion_chino" value="1" <?php if ($row['traduccion_chino']==1) { echo 'checked'; } ?>/> &nbsp;Chino
		<input name="traduccion_arabe" type="checkbox" id="traduccion_arabe" value="1" <?php if ($row['traduccion_arabe']==1) { echo 'checked'; } ?>/> &nbsp;Arabe
		<input name="traduccion_rumano" type="checkbox" id="traduccion_rumano" value="1" <?php if ($row['traduccion_rumano']==1) { echo 'checked'; } ?>/> &nbsp;Rumano		  </p>
	    <p>
	      <input name="traduccion_bulgaro" type="checkbox" id="traduccion_bulgaro" value="1" <?php if ($row['traduccion_bulgaro']==1) { echo 'checked'; } ?>/>
&nbsp;B&uacute;lgaro 
<input name="traduccion_polaco" type="checkbox" id="traduccion_polaco" value="1" <?php if ($row['traduccion_polaco']==1) { echo 'checked'; } ?>/>
&nbsp;Polaco 
	      <input name="traduccion_ingles" type="checkbox" id="traduccion_ingles" value="1" <?php if ($row['traduccion_ingles']==1) { echo 'checked'; } ?>/>
&nbsp;Ingl&eacute;s
<input name="traduccion_frances" type="checkbox" id="traduccion_frances" value="1" <?php if ($row['traduccion_frances']==1) { echo 'checked'; } ?>/>
&nbsp;Franc&eacute;s </p>
	    <p>
	      <input name="traduccion_catalan" type="checkbox" id="traduccion_catalan" value="1" <?php if ($row['traduccion_catalan']==1) { echo 'checked'; } ?>/>
&nbsp;Catal&aacute;n</p>
<p><b>Usuarios</b><br />
			      <input name="gestion_usuarios" type="checkbox" id="gestion_usuarios" value="1" <?php if ($row['gestion_usuarios']==1) { echo 'checked'; } ?>/> 
			      &nbsp;Gesti&oacute;n usuarios
		  </p>
				<p><b>Palabras</b><br />
			      <input name="gestion_palabras" type="checkbox" id="gestion_palabras" value="1" <?php if ($row['gestion_palabras']==1) { echo 'checked'; } ?>/> 
			      &nbsp;Gesti&oacute;n palabras
				  <input name="definicion_palabras" type="checkbox" id="definicion_palabras" value="1" <?php if ($row['definicion_palabras']==1) { echo 'checked'; } ?>/> 
				  &nbsp;Definici&oacute;n palabras<br />
				  <input name="borrar_palabras" type="checkbox" id="borrar_palabras" value="1" <?php if ($row['borrar_palabras']==1) { echo 'checked'; } ?>/> &nbsp;Borrar palabras
				</p>
				<p><b>Im&aacute;genes</b><br />
				  <input name="add_imagenes" type="checkbox" id="add_imagenes" value="1" <?php if ($row['add_imagenes']==1) { echo 'checked'; } ?>/> 
				  &nbsp;A&ntilde;adir im&aacute;genes 
				  <input name="borrar_imagenes" type="checkbox" id="borrar_imagenes" value="1" <?php if ($row['borrar_imagenes']==1) { echo 'checked'; } ?>/> 
				  &nbsp;Borrar im&aacute;genes
				</p>
				<p><b>S&iacute;mbolos</b><br />
				  <input name="add_simbolos" type="checkbox" id="add_simbolos" value="1" <?php if ($row['add_simbolos']==1) { echo 'checked'; } ?>/> 
				  &nbsp;A&ntilde;adir s&iacute;mbolos 
				  <input name="borrar_simbolos" type="checkbox" id="borrar_simbolos" value="1" <?php if ($row['borrar_simbolos']==1) { echo 'checked'; } ?>/> 
				  &nbsp;Borrar s&iacute;mbolos          </p>
				<p>
  <input name="simbolos_especiales" type="checkbox" id="simbolos_especiales" value="1" <?php if ($row['simbolos_especiales']==1) { echo 'checked'; } ?>/>
  &nbsp;Ver s&iacute;mbolos especiales				</p>
				<p><strong>Materiales</strong></p>
				<p>
				  <input name="gestionar_materiales" type="checkbox" id="gestionar_materiales" value="1" <?php if ($row['simbolos_especiales']==1) { echo 'checked'; } ?>/>
&nbsp;Gestionar materiales</p>
				<p><strong>Enlaces</strong></p>
				<p>
                  <input name="gestionar_enlaces" type="checkbox" id="gestionar_enlaces" value="1" <?php if ($row['simbolos_especiales']==1) { echo 'checked'; } ?>/>
&nbsp;Gestionar enlaces</p>
<div id="boton" align="center">
				  <input type="submit" name="Submit22" value="Actualizar datos" />
		  </div>
				</p>
		</div>
</form>	  
	  