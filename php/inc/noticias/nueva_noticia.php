<?php 
session_start();

include ('../../classes/querys/query.php');

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>Simple example</title>
<script type="text/javascript">
function cargar_div(page,param,div){

		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		//définition de l'endroit d'affichage:
		var content = document.getElementById(""+div+"");

		
		XhrObj.open("POST", page);
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
				
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param)
}

</script>

<script language="javascript" type="text/javascript" src="../../js/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "texto",
		save_callback : "customSave",
		content_css : "example_advanced.css",
	theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		debug : false
	});

	// Custom save callback, gets called when the contents is to be submitted
	function customSave(id, content) {
	
	var contenido=Url.encode(content);
	
		cargar_div('add_noticia.php','noticia='+contenido+'&idioma='+document.getElementById('idioma').value+'&titulo='+document.getElementById('titulo').value+'&estado='+document.getElementById('estado').value+'','mensaje_actualizacion');
		
		<?php if ($_SERVER['HTTP_HOST']=='localhost') { ?>
		var url ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/saac/inc/inicio.php";
		parent.changeHeadline(url);
		<?php } else { ?>
		var url ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/internos/servicios/saac/inc/inicio.php";
		parent.changeHeadline(url);
		<?php } ?>
		
		
	}

// CLASE QUE ME PERMITE ENVIAR EL CONTENIDO DE TINYCE CODIFICADO DE MODO QUE COJA LAS EÑES Y LOS ACENTOS
// *******************************************************************************************************
var Url = {

    // public method for url encoding
    encode : function (string) {
        return escape(this._utf8_encode(string));
    },

    // public method for url decoding
    decode : function (string) {
        return this._utf8_decode(unescape(string));
    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}

</script>
</head>
<body>
<div id="actualizar_definicion" style="width:450px;">
<div id="mensaje_actualizacion">
<form action="" method="post" name="nueva_noticia" id="nueva_noticia">
  <p><strong>Estado:</strong>
    <select name="estado" id="estado">
      <option value="2" selected="selected">Pendiente revisi&oacute;n</option>
      <option value="1">Visible</option>
      <option value="0">No Visible</option>
        </select>
    <strong>T&iacute;tulo:</strong>
    <input name="titulo" type="text" id="titulo" size="25" />
</p>
<p align="left"><strong>Idioma:</strong>
	  <select name="idioma" id="idioma">
            <option value="es">es</option>
            <?php 
			$idiomas=$query->listar_idiomas();
			while ($row_idiomas=mysql_fetch_array($idiomas)) {
				if ($row_idiomas['idioma_abrev'] != '') {
				echo '<option value="'.$row_idiomas['idioma_abrev'].'">'.$row_idiomas['idioma_abrev'].'</option>';
				}
			}			
			?>
        </select>
</p>
  <p align="left"><strong>Noticia:</strong></p>
  <p>
    <textarea name="texto" cols="57" rows="13" id="texto"></textarea>
  </p>
  <p align="center"><input type="button" name="save" value="Añadir noticia" onclick="tinyMCE.triggerSave();" />
  </p>
  </form>
 </div>
</div>
</body>
</html>

