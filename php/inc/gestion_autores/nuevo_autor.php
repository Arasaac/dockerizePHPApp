<form action="javascript:cargar_div('inc/gestion_autores/add_autor.php','accion=add&nombre='+document.usuario.nombre.value+'&empresa_institucion='+document.usuario.empresa_institucion.value+'&web_autor='+document.usuario.web_autor.value+'&email='+document.usuario.email.value+'','listado_usuarios'); cargar_div('inc/gestion_autores/nuevo_autor.php','i=','usuario');" method="post" name="usuario" id="usuario" onSubmit="return validateStandard(this, 'error');">
<h3>Nuevo usuario:</h3>
<div class="right_articles" style="height:260px;">
				<p><b>Nombre y apellidos</b>:<br />
                  <input name="nombre" type="text" id="nombre" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Nombre" onkeypress="return handleEnter(this, event)"/>
                </p>
			    <p><strong>Empresa / Institución:</strong><br />
                    <input name="empresa_institucion" type="text" id="empresa_institucion" size="30" maxlength="50" regexp="/^\w*$/" realname="Empresa o Institución" onkeypress="return handleEnter(this, event)"/>
              </p>
			    <p><strong>Web: </strong><br />
			      <input name="web_autor" type="text" id="web_autor" onkeypress="return handleEnter(this, event)" value="http://" size="30" maxlength="50" regexp="/^\w*$/" realname="Web del autor" />
              </p>
			    <p><strong>Email:</strong><br />
			      <input name="email" type="text" id="email" maxlength="150" onkeypress="return handleEnter(this, event)"/>
		      </p>
</div>
<div class="right_articles" style="height:260px;">
	      <div id="boton" align="center">
			  <input type="submit" name="Submit2" value="A&ntilde;adir" />
		  </div>
		</p>
		</div>
 </form>	  
	  