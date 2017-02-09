<?php
session_start();
$id_usuario=$_SESSION['ID_USER'];

if ($_SESSION['ID_USER'] == '' || $_SESSION['ID_USER']==0) {
?>
<script>
alert('La sesión ha caducado, vuelva a autentificarse para poder seguir trabajando');
window.close();
</script>
<?php 
}

// $Header: /cvsroot/html2ps/demo/index.php,v 1.5 2007/05/06 18:49:30 Konstantin Exp $
require_once('config.inc.php');
$id_panel=$_GET['id_panel'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

<script language="javascript" type="text/javascript">

String.prototype.trim = function() {
        var x=this;
        x=x.replace( /^\s*/, "" );
        x=x.replace( /\s*$/, "" );
        return x;
}

function validate() {
        var formobj = document.forms[0];
        var urlval = formobj.URL.value.trim();

        if ( !isValidURL( urlval ) ) {
                alert( 'Please input a valid URL.' );
                return false;
        }

        return true;
}

function isValidURL(url) {

        if ( url == null )
                return false;

// space extr
        var reg='^ *';
//protocol
        reg = reg+'(?:([Hh][Tt][Tt][Pp](?:[Ss]?))(?:\:\\/\\/))?';
//usrpwd
        reg = reg+'(?:(\\w+\\:\\w+)(?:\\@))?';
//domain
        reg = reg+'([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|localhost|([Ww][Ww][Ww].|[a-zA-Z0-9].)?[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,6})';
//port
        reg = reg+'(\\:\\d+)?';
//path
        reg = reg+'((?:\\/.*)*\\/?)?';
//filename
        reg = reg+'(.*?\\.(\\w{2,4}))?';
//qrystr
        reg = reg+'(\\?(?:[^\\#\\?]+)*)?';
//bkmrk
        reg = reg+'(\\#.*)?';
// space extr
        reg = reg+' *$';

        return url.match(new RegExp(reg, 'i'));
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML2PS/PDF</title>

<!--CSS file may be preferred as external file-->

<style type="text/css">
/* standard tag styles */
body {
        color:#000;
        background-color:#fff;
        margin:10px;
        font-family:arial, helvetica, sans-serif;
        color:#000;
        font-size:12px;
        line-height:18px;
}
p {
  color:#000;
  font-size:12px;
  line-height:18px;
  margin-top:3px;
 }
 h1 {
        font-family:arial, helvetica, sans-serif;
        color:#669;
        font-size:27px;
        letter-spacing:-1px;
        margin-top:12px;
        margin-bottom:12px;
}
input,textarea,select {
        background-color:#eeeeee;
        border: 1px solid #045564;
}
textarea {
 width: 290px;
 height: 150px;
}
img {
        border:0px;
}
fieldset {
        border: #26a solid 1px;
        margin-left:10px;
        padding-bottom:0px;
        padding-top:0px;
        margin-top:10px;
}
legend {
        background: #eee;
        border: #26a solid 1px;
        padding: 1px 10px;
        font-weight:bold;
}
/* special class/styles */
.submit {
        background-color:#669;
        color:#fff;
}
.nulinp {
        border:0px;
        background-color:#fff;
}
.hand {
        cursor: pointer;
}
/* forms formatting */
div.form-row {
        clear: both;
        padding-top: 5px;
}
div.form-row span.labl {
        float: left;
        width: 160px;
        text-align: right;
}
div.form-row span.formw {
        float: right;
        width: 300px;
        text-align: left;
}
div.spacer {
        clear: both;
}
div.comment {
  line-height: 1.1em;
}
</style>
</head>
<body>
<div style="width:500px;"><form action="demo/html2ps.php" method="get" style="margin-top:12px">
<fieldset>
<legend>&nbsp;Formato</legend>
<div class="form-row">
<label class="hand" for="pixel">
<span class="labl">PIXELS de la Página</a></span></label>
<span class="formw">
<select name="pixels" id="pixel">
<option value="640">640</option>
<option value="800">800</option>
<option value="1024" selected="selected">1024</option>
<option value="1280">1280</option>
</select>
<input name="process_mode" type="hidden" id="process_mode" value="single" />
<input type="hidden" tabindex="1" id="ur" name="URL" size="30" value="http://195.55.130.137/arasaac/inc/herramientas/creador_paneles/exportar_panel.php?id_panel=<?php echo $id_panel ?>&id_usuario=<?php echo $id_usuario; ?>"/>
</span></div>

<div class="form-row">
<label class="hand" for="scalepoint"><span class="labl">Mantener proporcionalidad</a></span></label>
<span class="formw">
<input class="nulinp" type="checkbox" name="scalepoints" value="1" checked="checked" id="scalepoint"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="renderi"><span class="labl">Renderizar imágenes</span></label>
<span class="formw">
 <input class="nulinp" type="checkbox" name="renderimages" value="1" checked="checked" id="renderi"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="renderi"><span class="labl">Procesar hipervínculos</a></span></label>
<span class="formw">
 <input class="nulinp" type="checkbox" name="renderlinks" value="1" checked="checked" id="renderl"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="renderf"><span class="labl">Formularios Interactivos</span></label>
<span class="formw">
<input class="nulinp" type="checkbox" name="renderforms" value="1" id="renderl"/><sup style="color: red">FPDF/PDFLIB <em>1.6</em> output only!</sup>
</span>
</div>

<div class="form-row">
<label class="hand" for="renderi"><span class="labl">Substitute special fields</span></label>
<span class="formw">
 <input class="nulinp" type="checkbox" name="renderfields" value="1" checked="checked" id="renderl" disabled="disabled"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="medi"><span class="labl">Formato de impresión</span></label>
<span class="formw">
<select name="media" id="medi">
<!--Can use php here to obtain predefined media types OR leave as is-->
<option value="Letter">Letter</option>
<option value="Legal">Legal</option>
<option value="Executive">Executive</option>
<option value="A0Oversize">A0Oversize</option>
<option value="A0">A0</option>
<option value="A1">A1</option>
<option value="A2">A2</option>
<option value="A3">A3</option>
<option value="A4" selected="selected">A4</option>
<option value="A5">A5</option>
<option value="B5">B5</option>
<option value="Folio">Folio</option>
<option value="A6">A6</option>
<option value="A7">A7</option>
<option value="A8">A8</option>
<option value="A9">A9</option>
<option value="A10">A10</option>
<option value="Screenshot640">Image 640&times;480</option>
<option value="Screenshot800">Image 800&times;600</option>
<option value="Screenshot1024">Image 1024&times;768</option>
<!--end php predefined media options if used-->
</select>
</span>
</div>

<div class="form-row">
<label class="hand" for="cssmedia"><span class="labl">CSS</span></label>
<span class="formw">
<select name="cssmedia" id="cssmedia" disabled="disabled">
<option value="handheld">Handheld</option>
<option value="print">Print</option>
<option value="projection">Projection</option>
<option value="Screen" selected="selected">Screen</option>
<option value="tty">TTY</option>
<option value="tv">TV</option>
</select>
</span>
</div>

<div class="form-row">
<label class="hand" for="lm"><span class="labl">Margen izquierdo:mm</span></label>
<span class="formw">
<input id="lm" type="text" size="3" name="leftmargin" value="30" disabled="disabled"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="rm"><span class="labl">Margen derecho:mm</span></label>
<span class="formw">
<input id="rm" type="text" size="3" name="rightmargin" value="15" disabled="disabled"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="tm"><span class="labl">Mrgen Superior:mm</span></label>
<span class="formw">
<input id="tm" type="text" size="3" name="topmargin" value="15" disabled="disabled"/>
</span>
</div>
<div class="form-row">
<label class="hand" for="bm"><span class="labl">Margen inferior:mm</span></label>
<span class="formw">
<input id="bm" type="text" size="3" name="bottommargin" value="15" disabled="disabled"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="automargins"><span class="labl">Auto-size vertical margins</span></label>
<span class="formw">
<input id="automargins" class="nulinp" type="checkbox" name="automargins" value="1" disabled="disabled"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="landsc"><span class="labl">Apaisado</span></label>
<span class="formw">
<input id="landsc" class="nulinp" type="checkbox" name="landscape" value="1"/>
</span>
</div>

<div class="form-row">
<label class="hand" for="encod"><span class="labl">Codificación</span></label>
<span class="formw">
<select id="encod" name="encoding">
<option value="" selected="selected">Autodetect</option>
<option value="utf-8">utf-8</option>
<option value="iso-8859-1">iso-8859-1</option>
<option value="iso-8859-2">iso-8859-2</option>
<option value="iso-8859-3">iso-8859-3</option>
<option value="iso-8859-4">iso-8859-4</option>
<option value="iso-8859-5">iso-8859-5</option>
<option value="iso-8859-6">iso-8859-6</option>
<option value="iso-8859-7">iso-8859-7</option>
<option value="iso-8859-9">iso-8859-9</option>
<option value="iso-8859-10">iso-8859-10</option>
<option value="iso-8859-11">iso-8859-11</option>
<option value="iso-8859-13">iso-8859-13</option>
<option value="iso-8859-14">iso-8859-14</option>
<option value="iso-8859-15">iso-8859-15</option>
<option value="windows-1250">windows-1250</option>
<option value="windows-1251">windows-1251</option>
<option value="windows-1252">windows-1252</option>
<option value="koi8-r">koi8-r</option>
</select>
</span>
</div>
<div class="spacer"></div><br />
</fieldset>

<fieldset>
<legend>&nbsp;Formato Archivo&nbsp;</legend>
<div class="form-row">
<label class="hand" for="ps"><span class="labl">Salida</span></label>
<span class="formw">
<input class="nulinp" type="radio" id="pdf" name="method" value="fpdf" checked="checked"/>PDF (FPDF)
<br /><input class="nulinp" type="radio" id="png" name="method" value="png"/>Image (PNG) <span style="color: red; vertical-align: super; font-size: smaller;">beta</span>
<!--<br /><input class="nulinp" type="radio" id="png" name="method" value="pcl"/>PCL <span style="color: red; vertical-align: super; font-size: smaller;">alpha</span>-->
</span>
</div>

<div class="form-row">
<label class="hand" for="ps"><span class="labl">Compatibilidad PDF:</span></label>
<span class="formw">
<select name="pdfversion">
<option value="1.2">PDF 1.2 (NOT supported by PDFLIB!)</b></option>
<option value="1.3" selected="selected">PDF 1.3 (Acrobat Reader 4)</option>
<option value="1.4">PDF 1.4 (Acrobat Reader 5)</option>
<option value="1.5">PDF 1.5 (Acrobat Reader 6)</option>
</select>
<br/>
</span>
</div>

<div class="form-row">
<label class="hand" for="towher"><span class="labl">Destino</span></label>
<span class="formw">
<label for="towher1">&nbsp;</label>
<input name="output" type="radio" class="nulinp" id="towher1" value="1" checked="checked" /> 
Descargar
<br />
</span> :
</div>

<div class="form-row">
&nbsp;
<span class="formw">
<!-- <input class="submit" type="submit" value="Download File (debugging only)" /> -->
<input class="submit" type="reset"  name="reset"  value="RESETEAR" />
&nbsp;
<input class="submit" type="submit" name="convert" onClick="javascript: return validate();" value="CONVERTIR" />
</span>
</div>
<div class="spacer"></div><br />
</fieldset>
</form>
</div>

<p>&nbsp;</p>

</body>
</html>