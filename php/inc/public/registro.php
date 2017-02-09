<?php 
require ('../../lang/lang_es.php');
include ('../../classes/querys/query.php');
$query= new query();
?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<div id="formulario_registro">
	<h3>Registro
<div id="products" style="float:right;">
				<div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div>
		    </div>
			</h3>
			<p align="left">Para poder registrarse como usuario de ARASAAC debe completar los campos que encontrar&aacute; a continuaci&oacute;n. Una vez env&iacute;ados, recibir&aacute; un correo electr&oacute;nico en el que deber&aacute; confirmar su registro haciendo clic sobre el enlace que se le proporcionar&aacute;. </p>
  <hr>
<form action="" method="post" name="registro" id="registro" onSubmit="return validateCompleteForm(this, 'error');">
  <table width="100%" border="0">
    <tr>
      <td align="left" valign="top"><p><b>Nombre</b>: (*)<br />
          <input name="nombre" type="text" id="nombre" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Nombre" onkeypress="return handleEnter(this, event)"/>
      </p>
        <p><strong>Primer apellido:</strong> (*)<br />
            <input name="primer_apellido" type="text" id="primer_apellido" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Primer Apellido" onkeypress="return handleEnter(this, event)"/>
        </p>
        <p><strong>Segundo apellido: </strong><br />
            <input name="segundo_apellido" type="text" id="segundo_apellido" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Segundo Apellido" onkeypress="return handleEnter(this, event)" />
        </p></td>
      <td align="left" valign="top"><p><strong>Email:</strong> (*)<br />
            <input name="email" type="text" id="email" maxlength="150" onkeypress="return handleEnter(this, event)"/>
      </p>
        <p><strong>Centro de Trabajo: </strong> (*)<br />
            <input name="centro" type="text" id="centro" size="30" maxlength="50" required="1" regexp="/^\w*$/" realname="Segundo Apellido" onkeypress="return handleEnter(this, event)" />
        </p>
        <p> <strong>Usuario: </strong>  (*)<br />
            <input name="login" type="text" id="login" size="11" minlength="5" maxlength="10" required="1" regexp="/^\w*$/" realname="Usuario"/>
        </p>
        <p><strong>Contrase&ntilde;a:</strong> (*)<br />
            <input name="password" type="text" id="password" size="11" maxlength="10" required="1" regexp="/^\w*$/" realname="Password" onkeypress="return handleEnter(this, event)" />
        </p></td>
    </tr>
  </table>
    <p align="left"> (*) Campos obligatorios</p>
<p align="center"><input type="button" name="submit" value="Registrarme" onClick="cargar_div('inc/public/registrar_usuario.php','nombre='+document.registro.nombre.value+'&primer_apellido='+document.registro.primer_apellido.value+'&segundo_apellido='+document.registro.segundo_apellido.value+'&usuario='+document.registro.login.value+'&password='+document.registro.password.value+'&email='+document.registro.email.value+'&centro='+document.registro.centro.value+'','formulario_registro');"/>
    </p>
  </form>
</div>
