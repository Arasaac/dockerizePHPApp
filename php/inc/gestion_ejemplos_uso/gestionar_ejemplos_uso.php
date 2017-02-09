<?php 
session_start();

include ('../../classes/querys/query.php');

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

if (isset($_GET['id']) && $_GET['id'] !='') {

$row=$query->datos_ficha_eu($_GET['id']);
$autores=$query->listar_autores_sin($row['eu_autor']);
$tm=$query->listar_tipo_eu();
$boton_enviar='Modificar Ejemplo Uso';
$web_envio='modificar_ejemplo_uso.php';
$id_eu=$_GET['id'];

} else {

$autores=$query->listar_autores();
$tm=$query->listar_tipo_eu();
$boton_enviar='Añadir Ficha Ejemplo Uso';
$web_envio='add_ejemplo_uso.php';
$id_eu='';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>Simple example</title>
<script type="text/javascript" src="../../js/nicEdit/nicEdit.js"></script>
<script type="text/javascript">
var area1, area2, area3;
function toggleAreas() {
    area1=new nicEditor({iconsPath : '../../js/nicEdit/nicEditorIcons.gif'}).panelInstance('descripcion');
}

function removeAreas() {
	area1.removeInstance('descripcion');
}

bkLib.onDomLoaded(function() { toggleAreas(); });
</script>
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
<script language="javascript" type="text/javascript">
	
	// Custom save callback, gets called when the contents is to be submitted
	function customSave() {
	
		selIt_sin();
		
		cargar_div('<?php echo $web_envio ?>','descripcion='+document.getElementById('descripcion').value+'&titulo='+document.getElementById('titulo').value+'&estado='+document.getElementById('estado').value+'&destacado='+document.getElementById('destacado').checked+'&PickArchivos='+document.getElementById('archivos').value+'&PickCapturas='+document.getElementById('capturas').value+'&PickAutores='+document.getElementById('autores').value+'&PickTipo='+document.getElementById('tipo').value+'&PickIdiomas='+document.getElementById('idiomas').value+'&url1='+document.getElementById('url1').value+'&url2='+document.getElementById('url2').value+'&url3='+document.getElementById('url3').value+'&id_eu='+document.getElementById('id_eu').value+'','mensaje_actualizacion');
		
/*		<?php if ($_SERVER['HTTP_HOST']=='localhost') { ?>
		var url ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/saac/inc/inicio.php";
		parent.changeHeadline(url);
		<?php } else { ?>
		var url ="http://<?php echo $_SERVER['HTTP_HOST']; ?>/internos/servicios/saac/inc/inicio.php";
		parent.changeHeadline(url);
		<?php } ?>*/
		
		
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

<!--

// PickList script- By Sean Geraty (http://www.freewebs.com/sean_geraty/)
// Visit JavaScript Kit (http://www.javascriptkit.com) for this JavaScript and 100s more
// Please keep this notice intact

// Control flags for list selection and sort sequence
// Sequence is on option value (first 2 chars - can be stripped off in form processing)
// It is assumed that the select list is in sort sequence initially
var singleSelect = true;  // Allows an item to be selected once only
var sortSelect = true;  // Only effective if above flag set to true
var sortPick = true;  // Will order the picklist in sort sequence

// Adds a selected item into the picklist
function addIt(SelectList,PickList) {
  var selectList = document.getElementById(""+SelectList+"");
  var selectIndex = selectList.selectedIndex;
  var selectOptions = selectList.options;
  var pickList = document.getElementById(""+PickList+"");
  var pickOptions = pickList.options;
  var pickOLength = pickOptions.length;
  // An item must be selected
  while (selectIndex > -1) {
    pickOptions[pickOLength] = new Option(selectList[selectIndex].text);
    pickOptions[pickOLength].value = selectList[selectIndex].value;
    // If single selection, remove the item from the select list
    if (singleSelect) {
      selectOptions[selectIndex] = null;
    }
    if (sortPick) {
      var tempText;
      var tempValue;
      // Sort the pick list
      while (pickOLength > 0 && pickOptions[pickOLength].value < pickOptions[pickOLength-1].value) {
        tempText = pickOptions[pickOLength-1].text;
        tempValue = pickOptions[pickOLength-1].value;
        pickOptions[pickOLength-1].text = pickOptions[pickOLength].text;
        pickOptions[pickOLength-1].value = pickOptions[pickOLength].value;
        pickOptions[pickOLength].text = tempText;
        pickOptions[pickOLength].value = tempValue;
        pickOLength = pickOLength - 1;
      }
    }
    selectIndex = selectList.selectedIndex;
    pickOLength = pickOptions.length;
  }
  selectOptions[0].selected = true;
}

// Deletes an item from the picklist
function delIt(SelectList,PickList) {
  var selectList = document.getElementById(""+SelectList+"");
  var selectOptions = selectList.options;
  var selectOLength = selectOptions.length;
  var pickList = document.getElementById(""+PickList+"");
  var pickIndex = pickList.selectedIndex;
  var pickOptions = pickList.options;
  while (pickIndex > -1) {
    // If single selection, replace the item in the select list
    if (singleSelect) {
      selectOptions[selectOLength] = new Option(pickList[pickIndex].text);
      selectOptions[selectOLength].value = pickList[pickIndex].value;
    }
    pickOptions[pickIndex] = null;
    if (singleSelect && sortSelect) {
      var tempText;
      var tempValue;
      // Re-sort the select list
      while (selectOLength > 0 && selectOptions[selectOLength].value < selectOptions[selectOLength-1].value) {
        tempText = selectOptions[selectOLength-1].text;
        tempValue = selectOptions[selectOLength-1].value;
        selectOptions[selectOLength-1].text = selectOptions[selectOLength].text;
        selectOptions[selectOLength-1].value = selectOptions[selectOLength].value;
        selectOptions[selectOLength].text = tempText;
        selectOptions[selectOLength].value = tempValue;
        selectOLength = selectOLength - 1;
      }
    }
    pickIndex = pickList.selectedIndex;
    selectOLength = selectOptions.length;
  }
}

// Selection - invoked on submit
function selIt_sin() {

  var pickList1 = document.getElementById("PickArchivos[]");
  var pickOptions1 = pickList1.options;
  var pickOLength1 = pickOptions1.length;

  for (var a = 0; a < pickOLength1; a++) {
	document.getElementById('archivos').value = document.getElementById('archivos').value + '{'+pickOptions1[a].value+'}';
    pickOptions1[a].value = true;
  }
  
  var pickList2 = document.getElementById("PickAutores[]");
  var pickOptions2 = pickList2.options;
  var pickOLength2 = pickOptions2.length;
  for (var b = 0; b < pickOLength2; b++) {
    document.getElementById('autores').value = document.getElementById('autores').value + '{'+pickOptions2[b].value+'}';
    pickOptions2[b].selected = true;
  }
  
  
  var pickList4 = document.getElementById("PickCapturas[]");
  var pickOptions4 = pickList4.options;
  var pickOLength4 = pickOptions4.length;
  for (var d = 0; d < pickOLength4; d++) {
    document.getElementById('capturas').value = document.getElementById('capturas').value + '{'+pickOptions4[d].value+'}';
    pickOptions4[d].selected = true;
  }
    
  var pickList8 = document.getElementById("PickTipo[]");
  var pickOptions8 = pickList8.options;
  var pickOLength8 = pickOptions8.length;
  for (var h = 0; h < pickOLength8; h++) {
    document.getElementById('tipo').value = document.getElementById('tipo').value + '{'+pickOptions8[h].value+'}';
    pickOptions8[h].selected = true;
  }
  
  
  var pickList10 = document.getElementById("PickIdiomas[]");
  var pickOptions10 = pickList10.options;
  var pickOLength10 = pickOptions10.length;
  for (var i = 0; i < pickOLength10; i++) {
    document.getElementById('idiomas').value = document.getElementById('idiomas').value + '{'+pickOptions10[i].value+'}';
    pickOptions10[i].selected = true;
  }
  
  return true;
}
//-->
</script>
</head>
<body>
<div id="mensaje_actualizacion">
<form action="javascript:void(0);" method="post" name="nuevo_material" id="nuevo_material">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="38%" valign="top"><p><strong>Estado:</strong>
          <select name="estado" id="estado">
            <?php if (isset($row['eu_estado'])) { ?>
            <option value="2" <?php if ($row['eu_estado']==2) { echo "selected"; } ?>>Pendiente revisi&oacute;n</option>
            <option value="1" <?php if ($row['eu_estado']==1) { echo "selected"; } ?>>Visible</option>
            <option value="0" <?php if ($row['eu_estado']==0) { echo "selected"; } ?>>No Visible</option>
            <?php } else { ?>
            <option value="2" selected="selected">Pendiente revisi&oacute;n</option>
            <option value="1">Visible</option>
            <option value="0">No Visible</option>
            <?php } ?>
          </select>
      </p>
        <p><strong>Destacado:</strong>
          <input name="destacado" type="checkbox" id="destacado" value="1" <?php if ($row['eu_destacado']==1) { echo ' checked="checked"'; } ?> />
          <label for="destacado"></label>
        </p>
        <p><strong>T&iacute;tulo:</strong>
          <input name="titulo" type="text" id="titulo" size="25" value="<?php echo $row['eu_titulo']; ?>" />
        </p>
        <p align="left"><strong>Descripción:</strong></p>
        <p>
		<textarea name="descripcion" id="descripcion" cols="54" rows="10"><?php echo $row['eu_descripcion']; ?></textarea>
        </p>
        <p align="left"><strong>URL 1:</strong>
          <input name="url1" type="text" id="url1" size="25" value="<?php echo $row['eu_url1']; ?>" />
      </p>
        <p align="left"><strong>URL 2:</strong>
          <input name="url2" type="text" id="url2" size="25" value="<?php echo $row['eu_url2']; ?>" />
        </p>
        <p align="left"><strong>URL 3:</strong>
          <input name="url3" type="text" id="url3" size="25" value="<?php echo $row['eu_url3']; ?>" />
        </p>
        <p></p></td>
      <td width="62%" align="right" valign="top"><table cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3"><strong>Autores
            <input type="hidden" name="autores" id="autores" />
            <input name="id_eu" type="hidden" id="id_eu" value="<?php echo $id_eu; ?>" />
          </strong></td>
        </tr>
        <tr>
          <td><select id="AutoresList" style="WIDTH: 250px" multiple="multiple" size="5" name="AutoresList">
            <?php while ($row_autores=mysql_fetch_array($autores)) {  ?>
            <option value="<?php echo $row_autores['id_autor'] ?>" sel="sel"><?php echo utf8_encode($row_autores['autor']); ?></option>
            <?php } ?>
          </select></td>
          <td><input onclick="addIt('AutoresList','PickAutores[]');" type="button" value="-&gt;" />
            <br />
            <input onclick="delIt('AutoresList','PickAutores[]');" type="button" value="&lt;-" /></td>
          <td><select id="PickAutores[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickAutores[]">
            <?php 
						if (isset($row['eu_autor']) && $row['eu_autor'] != '') { 
							  $mau=str_replace('}{',',',$row['eu_autor']);
							  $mau=str_replace('{','',$mau);
							  $mau=str_replace('}','',$mau);
							  $mau=explode(',',$mau);
							  
							  for ($i=0;$i<count($mau);$i++) { 
								if ($mau[$i]!='') {
								 $data_autor=$query->datos_autor($mau[$i]);
								 echo '<option value="'.$mau[$i].'" sel="sel">'.utf8_encode($data_autor['autor']).'</option>'; 
								}
							  }
							}  
						  ?>
          </select></td>
        </tr>
      </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>Tipo
              <input type="hidden" name="tipo" id="tipo" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="SelectTipo" style="WIDTH: 250px" multiple="multiple" size="5" name="SelectTipo">
              <?php while ($row_tm=mysql_fetch_array($tm)) {  ?>
              <option value="<?php echo $row_tm['id_tipo_eu'] ?>" sel="sel"><?php echo $row_tm['tipo_eu']; ?></option>
              <?php } ?>
            </select></td>
            <td><input onclick="addIt('SelectTipo','PickTipo[]');" type="button" value="-&gt;" />
              <br />
              <input onclick="delIt('SelectTipo','PickTipo[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickTipo[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickTipo[]">
              <?php 
			 if (isset($row['eu_tipo']) && $row['eu_tipo'] != '') {	
				  $mt=str_replace('}{',',',$row['eu_tipo']);
				  $mt=str_replace('{','',$mt);
				  $mt=str_replace('}','',$mt);
				  $mt=explode(',',$mt);
				  
				  for ($i=0;$i<count($mt);$i++) { 
					if ($mt[$i]!='') {
					 $data_tipo=$query->datos_eu_tipo($mt[$i]);
					 echo '<option value="'.$mt[$i].'" sel="sel">'.$data_tipo['tipo_eu'].'</option>';
					}
				  }
			  }
				?>
            </select></td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Capturas
              <input type="hidden" name="capturas" id="capturas"  />
            </strong></td>
            <td>&nbsp;</td>
            <td><b>Seleccionados</b></td>
          </tr>
          <tr>
            <td><select id="SelectCapturas" style="WIDTH: 250px" multiple="multiple" size="5" name="SelectCapturas">
              <?php 
				$path="../../zona_descargas/ejemplos_uso/temp/";
				$dir= opendir ($path);
				while ($entrada= readdir ($dir)) {
					if ($entrada != '.' && $entrada != '..' && $entrada != 'index.php') { 
	 				?>
              <option value="<?php echo $entrada ?>" sel="sel"><?php echo $entrada; ?></option>
              <?php } } ?>
            </select></td>
            <td><input onclick="addIt('SelectCapturas','PickCapturas[]');" type="button" value="-&gt;" />
              <br />
              <input onclick="delIt('SelectCapturas','PickCapturas[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickCapturas[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickCapturas[]">
              <?php 
			 if (isset($row['eu_capturas']) && $row['eu_capturas'] != '') { 
					$ca=str_replace('}{',',',$row['eu_capturas']);
				 	$ca=str_replace('{','',$ca);
				  	$ca=str_replace('}','',$ca);
				  	$ca=explode(',',$ca);
				  
					  for ($i=0;$i<count($ca);$i++) { 
						if ($ca[$i]!='') {
						 echo '<option value="'.$ca[$i].'" sel="sel">'.$ca[$i].'</option>'; 
						}
					  }
			
				}				  
			  ?>
            </select></td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Archivos
              <input type="hidden" name="archivos" id="archivos"  />
            </strong></td>
            <td>&nbsp;</td>
            <td><b>Seleccionados</b></td>
          </tr>
          <tr>
            <td><select id="SelectArchivos" style="WIDTH: 250px" multiple="multiple" size="5" name="SelectArchivos">
              <?php 
				$path="../../zona_descargas/ejemplos_uso/temp/";
				$dir= opendir ($path);
				while ($entrada= readdir ($dir)) {
					if ($entrada != '.' && $entrada != '..' && $entrada != 'index.php') { 
	 				?>
              <option value="<?php echo $entrada ?>" sel="sel"><?php echo $entrada; ?></option>
              <?php } } ?>
            </select></td>
            <td><input onclick="addIt('SelectArchivos','PickArchivos[]');" type="button" value="-&gt;" />
              <br />
              <input onclick="delIt('SelectArchivos','PickArchivos[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickArchivos[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickArchivos[]">
              <?php 
			 if (isset($row['eu_archivos']) && $row['eu_archivos'] != '') { 
					$ma=str_replace('}{',',',$row['eu_archivos']);
				 	$ma=str_replace('{','',$ma);
				  	$ma=str_replace('}','',$ma);
				  	$ma=explode(',',$ma);
				  
					  for ($i=0;$i<count($ma);$i++) { 
						if ($ma[$i]!='') {
						 echo '<option value="'.$ma[$i].'" sel="sel">'.$ma[$i].'</option>'; 
						}
					  }
			
				}				  
			  ?>
            </select></td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Idiomas
              <input type="hidden" name="idiomas" id="idiomas"  />
            </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><select id="SelectIdiomas" style="WIDTH: 250px" multiple="multiple" size="5" name="SelectIdiomas">
              <?php 
					echo '<option value="es" sel="sel">es</option>';
					$idiomas=$query->listar_idiomas();
					while ($row_idiomas=mysql_fetch_array($idiomas)) {
						if ($row_idiomas['idioma_abrev'] != '') {
							echo '<option value="'.$row_idiomas['idioma_abrev'].'" sel="sel">'.$row_idiomas['idioma_abrev'].'</option>';
						}
					}
	 				?>
            </select></td>
            <td><input onclick="addIt('SelectIdiomas','PickIdiomas[]');" type="button" value="-&gt;" />
              <br />
              <input onclick="delIt('SelectIdiomas','PickIdiomas[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickIdiomas[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickIdiomas[]">
              <?php 
			 if (isset($row['eu_idiomas']) && $row['eu_idiomas'] != '') { 
					$id=str_replace('}{',',',$row['eu_idiomas']);
				 	$id=str_replace('{','',$id);
				  	$id=str_replace('}','',$id);
				  	$id=explode(',',$id);
				  
					  for ($i=0;$i<count($id);$i++) { 
						if ($id[$i]!='') {
						 echo '<option value="'.$id[$i].'" sel="sel">'.$id[$i].'</option>'; 
						}
					  }
			
				}				  
			  ?>
            </select></td>
          </tr>
      </table>
        <p align="left">&nbsp;</p></td>
    </tr>
  </table>
  <p align="center"><input type="button" name="save" value="<?php echo $boton_enviar; ?>" onclick="removeAreas(); customSave();" />
  </p>
  </form>
</div>
</body>
</html>

