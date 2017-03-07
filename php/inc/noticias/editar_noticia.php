<?php 
session_start();

include ('../../classes/querys/query.php');

$query=new query();
$datos_noticia=$query->datos_noticia($_GET['id_noticia']);
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

<script type="text/javascript" src="../../js/nicEdit/nicEdit.js"></script>
<script type="text/javascript">
var area1, area2, area3;
function toggleAreas() {
    area1=new nicEditor({iconsPath : '../../js/nicEdit/nicEditorIcons.gif'}).panelInstance('texto');
}

function removeAreas() {
	area1.removeInstance('texto');
}

bkLib.onDomLoaded(function() { toggleAreas(); });
</script>
<script language="javascript" type="text/javascript">
		// Custom save callback, gets called when the contents is to be submitted
	function customSave() {
	
		var contenido=Url.encode(document.getElementById('texto').value);

		cargar_div('modificar_noticia.php','noticia='+contenido+'&idioma='+document.getElementById('idioma').value+'&titulo='+document.getElementById('titulo').value+'&estado='+document.getElementById('estado').value+'&id_noticia=<?php echo $_GET['id_noticia']; ?>','mensaje_actualizacion');
				
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
                  <option value="2"  <?php if ($datos_noticia[7]==2) {echo "SELECTED";} ?>>Pendiente revisi&oacute;n</option>
                  <option value="1"  <?php if ($datos_noticia[7]==1) {echo "SELECTED";} ?>>Visible</option>
                  <option value="0"  <?php if ($datos_noticia[7]==0) {echo "SELECTED";} ?>>No Visible</option>
        </select>
    <strong>T&iacute;tulo:</strong>
    <input name="titulo" type="text" id="titulo" value="<?php echo utf8_encode($datos_noticia['titulo']); ?>" size="25" />
</p>
<p align="left"><strong>Idioma:</strong>
	  <select name="idioma" id="idioma">
      		<?php  echo '<option value="'.$datos_noticia['idioma'].'">'.$datos_noticia['idioma'].'</option>'; ?>
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
    <textarea name="texto" cols="57" rows="13" id="texto"><?php echo utf8_encode($datos_noticia['noticia']); ?></textarea>
  </p>
  <p align="center"><input type="button" name="save" value="Actualizar noticia" onclick="removeAreas(); customSave();" />
  </p>
  </form>
 </div>
</div>
</body>
</html>