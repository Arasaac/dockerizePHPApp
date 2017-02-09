<?php 
session_start();

include ("../../classes/querys/query.php");


$mensaje="";
$id_palabra=$_GET['id_palabra'];
$traduccion=$_POST['saisie'];
$estado=$_POST['estado'];
$pronunciacion=strtolower($_POST['pronunciacion']);

$id_idioma=2; 
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
<STYLE type=text/css>.bt {
	FONT-SIZE: 14pt; WIDTH: 32px; COLOR: #cc0033
}
.bf {
	FONT-SIZE: 9pt; COLOR: #666666
}
</STYLE>
<script language=JavaScript src="../../js/idiomas/cmlat.js"></script>
<script language=JavaScript src="../../js/ajax.js"></script>
</head>

<body onLoad="palabra_actual('id='+<?php echo $_GET['id_palabra']; ?>+'&t=2','palabra_actual.php');">
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
<TABLE>
  <TBODY>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(258) type=button value=Ă> </TD>
    <TD><INPUT class=bt onclick=alpha(194) type=button value=Â> </TD>
    <TD><INPUT class=bt onclick=alpha(206) type=button value=Î> </TD>
    <TD><INPUT class=bt onclick=alpha(350) type=button value=Ş> </TD>
    <TD><INPUT class=bt onclick=alpha(354) type=button value=Ţ> </TD></TR>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(259) type=button value=ă> </TD>
    <TD><INPUT class=bt onclick=alpha(226) type=button value=â> </TD>
    <TD><INPUT class=bt onclick=alpha(238) type=button value=î> </TD>
    <TD><INPUT class=bt onclick=alpha(351) type=button value=ş> </TD>
    <TD><INPUT class=bt onclick=alpha(355) type=button value=ţ> 
</TD></TR></TBODY></TABLE></FORM>
</div>
</body>
</html>
