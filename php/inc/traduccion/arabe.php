<?php 
session_start();

$mensaje="";
$id_palabra=$_GET['id_palabra'];
$traduccion=$_POST['saisie'];
$estado=$_POST['estado'];
$pronunciacion=strtolower($_POST['pronunciacion']);
$id_idioma=3; 
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
<HTML><HEAD><TITLE>clavier arabe en ligne LEXILOGOS >></TITLE>
<STYLE type=text/css>.bt {
	FONT-SIZE: 18pt; WIDTH: 32px; COLOR: #cc0033; FONT-FAMILY: Times New Roman
}
.bta {
	FONT-SIZE: 18pt; WIDTH: 36px; COLOR: #cc0033; FONT-FAMILY: Times New Roman
}
.bf {
	FONT-SIZE: 9pt; COLOR: #666666
}
</STYLE>
<LINK href="../../js/idiomas/style.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../js/idiomas/cmlat.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/idiomas/carar.js"></SCRIPT>
<SCRIPT language=JavaScript src="../../js/ajax.js"></SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256"></HEAD>
<BODY onLoad="palabra_actual('id='+<?php echo $_GET['id_palabra']; ?>+'&t=3','palabra_actual.php')">
<DIV align=center>
<FORM action="<?php $PHP_SELF ?>" method="post" name=conversion>
<div id="mensaje"><?php echo $mensaje; ?></div>
      <div id="palabra">
	  
	  </div>
<BR>
<BR>
<INPUT class=bf onclick=conversion.saisie.select();copy() type=button value=Copiar> 
&nbsp;
<input type="submit" name="Submit" value="Guardar" id="Submit">
&nbsp;&nbsp; 
<INPUT class=bf onclick=reset();conversion.saisie.focus() type=button value=Borrar> 
<BR><BR>
<TABLE>
  <TBODY>
  <TR align=middle>
    <TD>D</TD>
    <TD>S</TD>
    <TD>s'</TD>
    <TD>s</TD>
    <TD>z</TD>
    <TD>r</TD>
    <TD>d'</TD>
    <TD>d</TD>
    <TD>H'</TD>
    <TD>H</TD>
    <TD>j</TD>
    <TD>t'</TD>
    <TD>t</TD>
    <TD>b</TD>
    <TD>a</TD></TR>
  <TR align=middle>
    <TD><INPUT class=bta onclick=alpha(1590) type=button value=Ö></TD>
    <TD><INPUT class=bta onclick=alpha(1589) type=button value=Õ></TD>
    <TD><INPUT class=bt onclick=alpha(1588) type=button value=Ô></TD>
    <TD><INPUT class=bt onclick=alpha(1587) type=button value=Ó></TD>
    <TD><INPUT class=bt onclick=alpha(1586) type=button value=Ò></TD>
    <TD><INPUT class=bt onclick=alpha(1585) type=button value=Ñ></TD>
    <TD><INPUT class=bt onclick=alpha(1584) type=button value=Ð></TD>
    <TD><INPUT class=bt onclick=alpha(1583) type=button value=Ï></TD>
    <TD><INPUT class=bt onclick=alpha(1582) type=button value=Î></TD>
    <TD><INPUT class=bt onclick=alpha(1581) type=button value=Í></TD>
    <TD><INPUT class=bt onclick=alpha(1580) type=button value=Ì></TD>
    <TD><INPUT class=bt onclick=alpha(1579) type=button value=Ë></TD>
    <TD><INPUT class=bt onclick=alpha(1578) type=button value=Ê></TD>
    <TD><INPUT class=bt onclick=alpha(1576) type=button value=È></TD>
    <TD><INPUT class=bt onclick=alpha(1575) type=button value=Ç></TD></TR></TBODY></TABLE>
<TABLE>
  <TBODY>
  <TR align=middle>
    <TD>-</TD>
    <TD>y</TD>
    <TD>w</TD>
    <TD>h</TD>
    <TD>n</TD>
    <TD>m</TD>
    <TD>l</TD>
    <TD>k</TD>
    <TD>q</TD>
    <TD>f</TD>
    <TD>g'</TD>
    <TD>"</TD>
    <TD>Z</TD>
    <TD>T</TD></TR>
  <TR align=middle>
    <TD><INPUT class=bt onclick=alpha(1569) type=button value=Á></TD>
    <TD><INPUT class=bt onclick=alpha(1610) type=button value=í></TD>
    <TD><INPUT class=bt onclick=alpha(1608) type=button value=æ></TD>
    <TD><INPUT class=bt onclick=alpha(1607) type=button value=å></TD>
    <TD><INPUT class=bt onclick=alpha(1606) type=button value=ä></TD>
    <TD><INPUT class=bt onclick=alpha(1605) type=button value=ã></TD>
    <TD><INPUT class=bt onclick=alpha(1604) type=button value=á></TD>
    <TD><INPUT class=bt onclick=alpha(1603) type=button value=ß></TD>
    <TD><INPUT class=bt onclick=alpha(1602) type=button value=Þ></TD>
    <TD><INPUT class=bt onclick=alpha(1601) type=button value=Ý></TD>
    <TD><INPUT class=bt onclick=alpha(1594) type=button value=Û></TD>
    <TD><INPUT class=bt onclick=alpha(1593) type=button value=Ú></TD>
    <TD><INPUT class=bt onclick=alpha(1592) type=button value=Ù></TD>
    <TD><INPUT class=bt onclick=alpha(1591) type=button value=Ø></TD></TR></TBODY></TABLE>
<TABLE>
  <TBODY>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1609) type=button value=ì></TD>
    <TD><INPUT class=bt onclick=alpha(1574) type=button value=Æ></TD>
    <TD><INPUT class=bt onclick=alpha(1572) type=button value=Ä></TD>
    <TD><INPUT class=bt onclick=alpha(1577) type=button value=É></TD>
    <TD><INPUT class=bt onclick=alpha(1573) type=button value=Å></TD>
    <TD><INPUT class=bt onclick=alpha(1571) type=button value=Ã></TD>
    <TD><INPUT class=bt onclick=alpha(1570) type=button value=Â></TD>
    <TD><INPUT class=bt onclick=alpha(1611) type=button value=&nbsp;ð></TD>
    <TD><INPUT class=bt onclick=alpha(1612) type=button value=&nbsp;ñ></TD>
    <TD><INPUT class=bt onclick=alpha(1613) type=button value=&nbsp;ò></TD>
    <TD><INPUT class=bt onclick=alpha(1614) type=button value=&nbsp;ó></TD>
    <TD><INPUT class=bt onclick=alpha(1615) type=button value=&nbsp;õ></TD>
    <TD><INPUT class=bt onclick=alpha(1616) type=button value=&nbsp;ö></TD>
    <TD><INPUT class=bt onclick=alpha(1617) type=button value=&nbsp;ø></TD>
    <TD><INPUT class=bt onclick=alpha(1618) type=button value=&nbsp;ú></TD></TR></TBODY></TABLE>
<TABLE>
  <TBODY>
  <TR vAlign=top>
    <TD><INPUT class=bt onclick=alpha(1567) type=button value=¿></TD>
    <TD><INPUT class=bt onclick=alpha(1563) type=button value=º></TD>
  <TD><INPUT class=bt onclick=alpha(1548) type=button value=¡></TD></TR></TBODY></TABLE></FORM>
<SCRIPT>document.conversion.saisie.focus();</SCRIPT>
</DIV>
</BODY></HTML>
