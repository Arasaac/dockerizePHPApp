<?php 
session_start();

include ("../../classes/querys/query.php");


$mensaje="";
$id_palabra=$_GET['id_palabra'];
$traduccion=$_POST['saisie'];
$estado=$_POST['estado'];
$pronunciacion=strtolower($_POST['pronunciacion']);

$id_idioma=9; 
$id_colaborador=$_SESSION['ID_USER'];

$query=new query();

if (isset($_POST['saisie'])) {

$resultados=$query->buscar_traduccion($id_palabra,$id_idioma);
$n_traducciones=mysql_num_rows($resultados);

	if ($n_traducciones == 0) {
		$traducciones=$query->add_traduccion($id_palabra,$id_idioma,$traduccion,'',$pronunciacion,$id_colaborador,$estado);
		$mensaje="Traduccion añadida";
		
	} elseif ($n_traducciones > 0) {
	
		if ($traduccion =="") {
			$traducciones=$query->borrar_traduccion($id_palabra,$id_idioma,$id_colaborador);
			$mensaje="Traduccion borrada";
		} else {
			$traducciones=$query->modify_traduccion($id_palabra,$id_idioma,$traduccion,$pronunciacion,$estado);
			$mensaje="Traduccion actualizada";
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../js/idiomas/style.css" type="text/css" rel="stylesheet">
<STYLE type=text/css>
.bt {
	FONT-SIZE: 14pt; WIDTH: 32px; COLOR: #cc0033
}
.bf {
	FONT-SIZE: 9pt; COLOR: #666666
}
.bt1 {	FONT-SIZE: 14pt; WIDTH: 32px; CURSOR: pointer; COLOR: #cc0033
}
</STYLE>
<script language=JavaScript src="../../js/idiomas/comlat.js"></script>
<script language=JavaScript src="../../js/idiomas/unilat.js"></script>
<script language=JavaScript src="../../js/ajax.js"></script>
</head>

<body onLoad="palabra_actual('id='+<?php echo $_GET['id_palabra']; ?>+'&t=9','palabra_actual.php');">
<div align="center">
<form action="<?php $PHP_SELF ?>" method="post" name="conversion" id="conversion">
  <div id="mensaje"><?php echo $mensaje; ?></div>
    <div id="palabra">
	</div>
<br><br><input class="bf" onclick="conversion.saisie.select();copy();" type="button" value="Copiar"> 
 &nbsp;&nbsp;&nbsp;<input name="Submit" type="submit" class="bf" id="Submit" value="Guardar">
&nbsp;&nbsp;&nbsp; 
<input class="bf" onclick="reset();conversion.saisie.focus();" type="button" value="Borrar"> 
<br><br>
<table>
  <tbody>
    <tr valign="top">
      <td><input class="bt1" onclick="alpha('À')" type="button" value="À" /></td>
      <td><input class="bt1" onclick="alpha('Ç')" type="button" value="Ç" /></td>
      <td><input class="bt1" onclick="alpha('É')" type="button" value="É" /></td>
      <td><input class="bt1" onclick="alpha('È')" type="button" value="È" /></td>
      <td><input class="bt1" onclick="alpha('Ï')" type="button" value="Ï" /></td>
      <td><input class="bt1" onclick="alpha('Ù')" type="button" value="Ù" /></td>
      <td><input class="bt1" onclick="alpha('Ü')" type="button" value="Ü" /></td>
      </tr>
    <tr valign="top">
      <td><input class="bt1" onclick="alpha('à')" type="button" value="à" /></td>
      <td><input class="bt1" onclick="alpha('ç')" type="button" value="ç" /></td>
      <td><input class="bt1" onclick="alpha('é')" type="button" value="é" /></td>
      <td><input class="bt1" onclick="alpha('è')" type="button" value="è" /></td>
      <td><input class="bt1" onclick="alpha('ï')" type="button" value="ï" /></td>
      <td><input class="bt1" onclick="alpha('ù')" type="button" value="ù" /></td>
      <td><input class="bt1" onclick="alpha('ü')" type="button" value="ü" /></td>
      </tr>
  </tbody>
</table>
<table>
  <tbody>
    <tr valign="top">
      <td><input class="bt1" onclick="alpha('’')" type="button" value="’" /></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</FORM>
</div>
</body>
</html>
