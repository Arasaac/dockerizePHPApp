<?php
session_start();

$mensaje="";
$id_palabra=$_GET['id_palabra'];
$traduccion=$_POST['saisie'];
$estado=$_POST['estado'];
$pronunciacion=strtolower($_POST['pronunciacion']);

$id_idioma=4; 
$id_colaborador=$_SESSION['ID_USER'];


include ("../../classes/querys/query.php");
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>Chino</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<STYLE type=text/css>
.bs {
	BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; FONT-SIZE: 16pt; BORDER-BOTTOM-WIDTH: 0px; WIDTH: 26pt; COLOR: #336600; FONT-FAMILY: Arial Unicode MS; HEIGHT: 26pt; BACKGROUND-COLOR: #ffffff; BORDER-RIGHT-WIDTH: 0px
}
.bs:hover {
	BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; FONT-SIZE: 16pt; BORDER-BOTTOM-WIDTH: 0px; WIDTH: 26pt; COLOR: #336600; FONT-FAMILY: Arial Unicode MS; HEIGHT: 26pt; BACKGROUND-COLOR: #e6e6e6; BORDER-RIGHT-WIDTH: 0px
}
.bt {
	BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; FONT-SIZE: 16pt; BORDER-BOTTOM-WIDTH: 0px; WIDTH: 26pt; COLOR: #330066; FONT-FAMILY: Arial Unicode MS; HEIGHT: 26pt; BACKGROUND-COLOR: #ffffff; BORDER-RIGHT-WIDTH: 0px
}
.bt:hover {
	BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; FONT-SIZE: 16pt; BORDER-BOTTOM-WIDTH: 0px; WIDTH: 26pt; COLOR: #330066; FONT-FAMILY: Arial Unicode MS; HEIGHT: 26pt; BACKGROUND-COLOR: #e6e6e6; BORDER-RIGHT-WIDTH: 0px
}
.bf {
	FONT-SIZE: 9pt; COLOR: #666666
}
</STYLE>
<LINK href="../../js/idiomas/style.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../js/idiomas/zh.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/ajax.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/idiomas/uni.js"></SCRIPT>
</HEAD>
<BODY onLoad="palabra_actual('id='+<?php echo $_GET['id_palabra']; ?>+'&t=4','palabra_actual.php');">
<DIV align=center>
<FORM action="<?php $PHP_SELF ?>" method="post" name=unicode>
<div id="mensaje"><?php echo $mensaje; ?></div>
  <p>
  <div id="palabra">
  
  </div>
    <BR>
  <BR>
  <INPUT class=bf onclick=unicode.saisie.select();copy() type=button value=Copiar>
  &nbsp;&nbsp;&nbsp; 
  <INPUT name="Enviar" type=submit class=bf  onMouseOver="conversion();" value=Guardar>
  &nbsp;&nbsp;
  <INPUT name="button" type="button" class="bf" onClick="del(); document.saisie.focus();" value="Borrar">
  <SCRIPT language=JavaScript>
document.writeln('<div id="B">');
for (i=0,j=0;i<cle.length-1;i++) { 
document.writeln('<input type=button value="&#'+cle[i]+';" onClick="beta('+i+')" class=bs title="'+py[i]+'">'); 
if (i+1==tra[j]) j++ };
document.writeln('</div>'); 
for (k=0;k<cle.length-1;k++) 
document.writeln('<div id="A'+k+'" style="display:none;"></div>');
     </SCRIPT>
    </p>
  </FORM>
<SCRIPT>document.unicode.saisie.focus</SCRIPT>
</DIV>
</BODY></HTML>
