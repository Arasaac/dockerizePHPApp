<?php 
require ('../../lang/lang_es.php');
include ('../../classes/querys/query.php');
$query= new query();
?>
<div id="products" style="float:right;">
	<div id="loading"><img src="images/loading2.gif" alt="Cargando..." /></div>
</div>
<div id="formulario_login" style="width:300px; background: url(images/login.gif) no-repeat top right; padding:10px;">
<form action="" method="post" name="formulario_login" id="formulario_login">
          <p align="left"><strong>Usuario: </strong>
            <input name="usuario1" type="text" id="usuario1" onkeypress="return handleEnter(this, event);" size="27" maxlength="10"/>
          </p>
    <p align="left"><strong>Contrase&ntilde;a: </strong> <input name="password1" type="password" id="password1"  onkeypress="return handleEnter(this, event);" maxlength="10"/></p>
<p align="center">
            <input type="button" name="submit" value="Acceder al Portal" onClick="cargar_div('inc/autentificar.php','usuario='+document.formulario_login.usuario1.value+'&password='+document.formulario_login.password1.value+'','formulario_login')"/>
</p>
</form>
</div>
