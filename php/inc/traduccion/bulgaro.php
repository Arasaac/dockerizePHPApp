<?php 
session_start();

$mensaje="";
$id_palabra=$_GET['id_palabra'];
$traduccion=$_POST['saisie'];
$estado=$_POST['estado'];
$pronunciacion=strtolower($_POST['pronunciacion']);

$id_idioma=5; 
$id_colaborador=$_SESSION['ID_USER'];

include ("../../classes/querys/query.php");
$query=new query();

if (isset($_POST['saisie'])) {

$resultados=$query->buscar_traduccion($id_palabra,$id_idioma);
$n_traducciones=mysql_num_rows($resultados);

	if ($n_traducciones == 0) {
		$traducciones=$query->add_traduccion($id_palabra,$id_idioma,$traduccion,'',$pronunciacion,$id_colaborador,$estado);
		$mensaje="Traduccion a&ntilde;adida";
		
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
<HTML><HEAD><TITLE>clavier russe cyrillique en ligne LEXILOGOS >></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1251">
<META content=alphabet,russe,clavier,cyrillique,russian,keyboard,online,virtual name=Keywords>
<STYLE type=text/css>
.bt {
	FONT-SIZE: 18pt; WIDTH: 32px; COLOR: #cc0033; FONT-FAMILY: Times New Roman; HEIGHT: 34px
}
.bf {
	FONT-SIZE: 9pt; COLOR: #666666
}
</STYLE>
<LINK href="../../js/idiomas/style.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../js/idiomas/cmlat.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/idiomas/carru.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/ajax.js"></SCRIPT>
</HEAD>
<BODY onLoad="palabra_actual('id='+<?php echo $id_palabra; ?>+'&t=5','palabra_actual.php')">
<DIV align=center>
<FORM action="<?php $PHP_SELF; ?>" method="post" name="conversion" id="conversion">
<div id="mensaje"><?php echo $mensaje; ?></div>
    <div id="palabra">
	</div>
<BR><BR><INPUT class=bf onclick=conversion.saisie.select();copy() type=button value=Copiar> 
&nbsp;
<input type="submit" name="Submit" value="Guardar" id="Submit">
&nbsp;&nbsp; 
<INPUT class=bf onclick=reset();conversion.saisie.focus() type=button value=Borrar> 
<BR><BR>
<TABLE>
  <TBODY>
  <TR vAlign=top>
    <TD align=middle>a</TD>
    <TD align=middle>b</TD>
    <TD align=middle>v</TD>
    <TD align=middle>g</TD>
    <TD align=middle>d</TD>
    <TD align=middle>e</TD>
    <TD align=middle>e</TD>
    <TD align=middle>z</TD>
    <TD align=middle>z</TD>
    <TD align=middle>i</TD>
    <TD align=middle>j</TD>
    <TD align=middle>k</TD>
    <TD align=middle>l</TD>
    <TD align=middle>m</TD></TR>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1040) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1041) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1042) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1043) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1044) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1045) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1025) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1046) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1047) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1048) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1049) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1050) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1051) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1052) type=button value=�></TD></TR>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1072) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1073) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1074) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1075) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1076) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1077) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1105) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1078) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1079) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1080) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1081) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1082) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1083) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1084) type=button value=�></TD></TR></TBODY></TABLE><BR>
<TABLE>
  <TBODY>
  <TR>
    <TD align=middle>n</TD>
    <TD align=middle>o</TD>
    <TD align=middle>p</TD>
    <TD align=middle>r</TD>
    <TD align=middle>s</TD>
    <TD align=middle>t</TD>
    <TD align=middle>u</TD>
    <TD align=middle>f</TD>
    <TD align=middle>x</TD>
    <TD align=middle>c</TD>
    <TD align=middle>c</TD>
    <TD align=middle>s</TD>
    <TD align=middle>sc</TD>
    <TD align=middle>��</TD>
    <TD align=middle>y</TD>
    <TD align=middle>�</TD>
    <TD align=middle>e</TD>
    <TD align=middle>ju</TD>
    <TD align=middle>ja</TD></TR>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1053) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1054) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1055) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1056) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1057) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1058) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1059) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1060) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1061) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1062) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1063) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1064) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1065) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1066) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1067) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1068) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1069) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1070) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1071) type=button value=�></TD></TR>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1085) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1086) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1087) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1088) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1089) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1090) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1091) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1092) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1093) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1094) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1095) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1096) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1097) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1098) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1099) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1100) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1101) type=button value=�></TD>
    <TD><INPUT class=bt onclick=alpha(1102) type=button value=�></TD>
  <TD><INPUT class=bt onclick=alpha(1103) type=button value=�></TD></TR></TBODY></TABLE></FORM>
<SCRIPT>document.conversion.saisie.focus();</SCRIPT>
</DIV>
</BODY></HTML>
