<form action="javascript:cargar_div('inc/gestion_usuarios/add_usuario.php','accion=add&nombre='+document.usuario.nombre.value+'&primer_apellido='+document.usuario.primer_apellido.value+'&segundo_apellido='+document.usuario.segundo_apellido.value+'&usuario='+document.usuario.login.value+'&password='+document.usuario.password.value+'&email='+document.usuario.email.value+'&t_ruso='+document.usuario.traduccion_ruso.checked+'&t_arabe='+document.usuario.traduccion_arabe.checked+'&t_rumano='+document.usuario.traduccion_rumano.checked+'&t_chino='+document.usuario.traduccion_chino.checked+'&t_bulgaro='+document.usuario.traduccion_bulgaro.checked+'&t_polaco='+document.usuario.traduccion_polaco.checked+'&t_catalan='+document.usuario.traduccion_catalan.checked+'&gestion_usuarios='+document.usuario.gestion_usuarios.checked+'&t_ingles='+document.usuario.traduccion_ingles.checked+'&t_frances='+document.usuario.traduccion_frances.checked+'&gestion_palabras='+document.usuario.gestion_palabras.checked+'&definicion_palabras='+document.usuario.definicion_palabras.checked+'&borrar_palabras='+document.usuario.borrar_palabras.checked+'&add_imagenes='+document.usuario.add_imagenes.checked+'&borrar_imagenes='+document.usuario.borrar_imagenes.checked+'&add_simbolos='+document.usuario.add_simbolos.checked+'&borrar_simbolos='+document.usuario.borrar_simbolos.checked+'&simbolos_especiales='+document.usuario.simbolos_especiales.checked+'','listado_usuarios'); cargar_div('inc/gestion_usuarios/nuevo_usuario.php','i=','usuario');" method="post" name="usuario" id="usuario" onSubmit="return validateStandard(this, 'error');">
<h3>Nuevo usuario:</h3>
<div class="right_articles" style="height:260px;">
				<p><b>Nombre</b>:<br />
                  <input name="nombre" type="text" id="nombre" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Nombre" onkeypress="return handleEnter(this, event)"/>
                </p>
			    <p><strong>Primer apellido:</strong><br />
                    <input name="primer_apellido" type="text" id="primer_apellido" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Primer Apellido" onkeypress="return handleEnter(this, event)"/>
              </p>
			    <p><strong>Segundo apellido: </strong><br />
			      <input name="segundo_apellido" type="text" id="segundo_apellido" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Segundo Apellido" onkeypress="return handleEnter(this, event)" />
              </p>
			    <p><strong>Email:</strong><br />
			      <input name="email" type="text" id="email" maxlength="150" onkeypress="return handleEnter(this, event)"/>
              </p>
			    <p>
			      <strong>Login: </strong><br />
			      <input name="login" type="text" id="login" size="11" minlength="5" maxlength="10" required="1" regexp="/^\w*$/" realname="Usuario" onkeypress="return handleEnter(this, event)" onkeyup="cargar_div('inc/gestion_usuarios/comprobar_usuario.php','login='+this.value+'&boton=A&ntilde;adir','boton');"/>
			    </p>
    <p><strong>Password:</strong><br />
      <input name="password" type="text" id="password" size="11" maxlength="10" required="1" regexp="/^\w*$/" realname="Password" onkeypress="return handleEnter(this, event)" />
  </p>
		    </div>
		
		    <h3>Permisos:</h3>
		<div class="right_articles" style="height:260px;">
				<p><b>Traducci&oacute;n</b><br />
			      <input name="traduccion_ruso" type="checkbox" id="traduccion_ruso" value="1" /> &nbsp;Ruso
				  <input name="traduccion_chino" type="checkbox" id="traduccion_chino" value="1" /> &nbsp;Chino
				  <input name="traduccion_arabe" type="checkbox" id="traduccion_arabe" value="1" /> &nbsp;Arabe
				  <input name="traduccion_rumano" type="checkbox" id="traduccion_rumano" value="1" /> &nbsp;Rumano				</p>
				<p>
                  <input name="traduccion_bulgaro" type="checkbox" id="traduccion_bulgaro" value="1" <?php if ($row['traduccion_bulgaro']==1) { echo 'checked'; } ?>/>
&nbsp;B&uacute;lgaro
<input name="traduccion_polaco" type="checkbox" id="traduccion_polaco" value="1" <?php if ($row['traduccion_polaco']==1) { echo 'checked'; } ?>/>
&nbsp;Polaco 
<input name="traduccion_ingles" type="checkbox" id="traduccion_ingles" value="1" <?php if ($row['traduccion_bulgaro']==1) { echo 'checked'; } ?>/>
&nbsp;Ingl&eacute;s
<input name="traduccion_frances" type="checkbox" id="traduccion_frances" value="1" <?php if ($row['traduccion_polaco']==1) { echo 'checked'; } ?>/>
&nbsp;Franc&eacute;s </p>
				<p>
                  <input name="traduccion_catalan" type="checkbox" id="traduccion_catalan" value="1" <?php if ($row['traduccion_catalan']==1) { echo 'checked'; } ?>/>
&nbsp;Catal&aacute;n </p>
<p><b>Administraci&oacute;n</b><br />
			      <input name="gestion_usuarios" type="checkbox" id="gestion_usuarios" value="1" /> 
			      &nbsp;Administraci&oacute;n (usuarios, listados,....)</p>
				<p><b>Palabras</b><br />
			      <input name="gestion_palabras" type="checkbox" id="gestion_palabras" value="1" /> 
			      &nbsp;Gesti&oacute;n palabras
				  <input name="definicion_palabras" type="checkbox" id="definicion_palabras" value="1" /> 
				  &nbsp;Definici&oacute;n palabras<br />
				  <input name="borrar_palabras" type="checkbox" id="borrar_palabras" value="1" /> &nbsp;Borrar palabras
				</p>
				<p><b>Im&aacute;genes</b><br />
				  <input name="add_imagenes" type="checkbox" id="add_imagenes" value="1" /> 
				  &nbsp;A&ntilde;adir im&aacute;genes 
				  <input name="borrar_imagenes" type="checkbox" id="borrar_imagenes" value="1" /> 
				  &nbsp;Borrar im&aacute;genes
				</p>
				<p><b>S&iacute;mbolos</b><br />
				  <input name="add_simbolos" type="checkbox" id="add_simbolos" value="1" /> 
				  &nbsp;A&ntilde;adir s&iacute;mbolos 
				  <input name="borrar_simbolos" type="checkbox" id="borrar_simbolos" value="1" /> 
				  &nbsp;Borrar s&iacute;mbolos		  </p>
				<p>
				  <input name="simbolos_especiales" type="checkbox" id="simbolos_especiales" value="1" />
&nbsp;Ver S&iacute;mbolos especiales</p>
<div id="boton" align="center">
			  <input type="submit" name="Submit2" value="A&ntilde;adir" disabled="disabled"/>
		  </div>
		</p>
		</div>
 </form>	  
	  