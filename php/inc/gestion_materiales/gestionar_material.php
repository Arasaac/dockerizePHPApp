<?php 
session_start();

include ('../../classes/querys/query.php');

$query=new query();
$permisos=$query->permisos_usuario($_SESSION['ID_USER']);
$licencias=$query->listar_licencias();

if (isset($_GET['id']) && $_GET['id'] !='') {

$row=$query->datos_material($_GET['id']);
$autores=$query->listar_autores_sin($row['material_autor']);
$ac=$query->listar_areas_curriculares_sin($row['material_area_curricular']);
$ac1=$query->listar_areas_curriculares();
$dirigido=$query->listar_dirigido_sin($row['material_dirigido']);
$edad=$query->listar_edad_sin($row['material_edad']);
$nivel=$query->listar_nivel_sin($row['material_nivel']);
$saa=$query->listar_saa_sin($row['material_saa']);
$tm=$query->listar_tipo_material_sin($row['material_tipo']);
$boton_enviar='Modificar material';
$web_envio='modificar_material.php';
$id_material=$_GET['id'];

} else {

$autores=$query->listar_autores();
$ac=$query->listar_areas_curriculares();
$ac1=$query->listar_areas_curriculares();
$dirigido=$query->listar_dirigido();
$edad=$query->listar_edad();
$nivel=$query->listar_nivel();
$saa=$query->listar_saa();
$tm=$query->listar_tipo_material();
$boton_enviar='Añadir material';
$web_envio='add_material.php';
$id_material='';

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
    area1=new nicEditor({iconsPath : '../../js/nicEdit/nicEditorIcons.gif'}).panelInstance('texto');
}

function removeAreas() {
	area1.removeInstance('texto');
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

<script language="javascript" type="text/javascript" src="../../js/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
	

	// Custom save callback, gets called when the contents is to be submitted
	function customSave() {
	
	var contenido=Url.encode(document.getElementById('texto').value);
	
		selIt_sin(); 
	
		cargar_div('<?php echo $web_envio ?>','descripcion='+contenido+'&titulo='+document.getElementById('titulo').value+'&estado='+document.getElementById('estado').value+'&objetivos='+document.getElementById('objetivos').value+'&PickAutores='+document.getElementById('autores').value+'&PickAC='+document.getElementById('ac').value+'&Pickdirigido='+document.getElementById('dirigido').value+'&Pickedad='+document.getElementById('edad').value+'&PickIdiomas='+document.getElementById('idiomas').value+'&PickNivel='+document.getElementById('nivel').value+'&PickSAA='+document.getElementById('saa').value+'&PickTipo='+document.getElementById('tipo').value+'&id_licencia='+document.getElementById('licencia').value+'&id_material='+document.getElementById('id_material').value+'&PickArchivos='+document.getElementById('archivos').value+'&PickSUBAC='+document.getElementById('subac').value+'','mensaje_actualizacion');
		
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
function selIt(btn,PickList) {
  var pickList = document.getElementById(""+PickList+"");
  var pickOptions = pickList.options;
  var pickOLength = pickOptions.length;
/*  if (pickOLength < 1) {
    alert("Por favor, seleccione al menos un valor usando el botón [->]");
    return false;
  }*/
  for (var i = 0; i < pickOLength; i++) {
    pickOptions[i].selected = true;
  }
  return true;
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
  
  var pickList3 = document.getElementById("PickAC[]");
  var pickOptions3 = pickList3.options;
  var pickOLength3 = pickOptions3.length;
  for (var c = 0; c < pickOLength3; c++) {
    document.getElementById('ac').value = document.getElementById('ac').value + '{'+pickOptions3[c].value+'}';
    pickOptions3[c].selected = true;
  }
  
  var pickList4 = document.getElementById("Pickdirigido[]");
  var pickOptions4 = pickList4.options;
  var pickOLength4 = pickOptions4.length;
  for (var d = 0; d < pickOLength4; d++) {
    document.getElementById('dirigido').value = document.getElementById('dirigido').value + '{'+pickOptions4[d].value+'}';
    pickOptions4[d].selected = true;
  }
  
  var pickList5 = document.getElementById("Pickedad[]");
  var pickOptions5 = pickList5.options;
  var pickOLength5 = pickOptions5.length;
  for (var e = 0; e < pickOLength5; e++) {
    document.getElementById('edad').value = document.getElementById('edad').value + '{'+pickOptions5[e].value+'}';
    pickOptions5[e].selected = true;
  }
  
  var pickList6 = document.getElementById("PickNivel[]");
  var pickOptions6 = pickList6.options;
  var pickOLength6 = pickOptions6.length;
  for (var f = 0; f < pickOLength6; f++) {
    document.getElementById('nivel').value = document.getElementById('nivel').value + '{'+pickOptions6[f].value+'}';
    pickOptions6[f].selected = true;
  }
  
  var pickList7 = document.getElementById("PickSAA[]");
  var pickOptions7 = pickList7.options;
  var pickOLength7 = pickOptions7.length;
  for (var g = 0; g < pickOLength7; g++) {
    document.getElementById('saa').value = document.getElementById('saa').value + '{'+pickOptions7[g].value+'}';
    pickOptions7[g].selected = true;
  }
  
  var pickList8 = document.getElementById("PickTipo[]");
  var pickOptions8 = pickList8.options;
  var pickOLength8 = pickOptions8.length;
  for (var h = 0; h < pickOLength8; h++) {
    document.getElementById('tipo').value = document.getElementById('tipo').value + '{'+pickOptions8[h].value+'}';
    pickOptions8[h].selected = true;
  }
  
  var pickList9 = document.getElementById("PickSUBAC[]");
  var pickOptions9 = pickList9.options;
  var pickOLength9 = pickOptions9.length;
  for (var i = 0; i < pickOLength9; i++) {
    document.getElementById('subac').value = document.getElementById('subac').value + '{'+pickOptions9[i].value+'}';
    pickOptions9[i].selected = true;
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
<div id="actualizar_definicion" style="width:750px;">
<div id="mensaje_actualizacion">
<form action="javascript:void(0);" method="post" name="nuevo_material" id="nuevo_material">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="38%" valign="top"><p><strong>Estado:</strong>
            <select name="estado" id="estado">
            <?php if (isset($row['material_estado'])) { ?>
              <option value="2" <?php if ($row['material_estado']==2) { echo "selected"; } ?>>Pendiente revisi&oacute;n</option>
              <option value="1" <?php if ($row['material_estado']==1) { echo "selected"; } ?>>Visible</option>
              <option value="0 <?php if ($row['material_estado']==0) { echo "selected"; } ?>">No Visible</option>
            <?php } else { ?>
              <option value="2" selected="selected">Pendiente revisi&oacute;n</option>
              <option value="1">Visible</option>
              <option value="0">No Visible</option>
            <?php } ?>
            </select>
            </p>
        <p><strong>T&iacute;tulo:</strong>
              <input name="titulo" type="text" id="titulo" size="60" value="<?php echo utf8_encode($row['material_titulo']); ?>" />
          </p>
        <p align="left"><strong>Descripción:</strong></p>
        <p>
          <textarea name="texto" cols="55" rows="13" id="texto"><?php echo utf8_encode($row['material_descripcion']); ?></textarea>
        </p>
        <p><strong>Objetivos:</strong></p>
        <p>
          <textarea name="objetivos" cols="55" rows="8" id="objetivos"><?php echo utf8_encode($row['material_objetivos']); ?></textarea>
        </p>
        <p><strong>Licencia:</strong>
          <select name="licencia" id="licencia" required="1" realname="Categoría" class="fonty">
           <?php if (isset($row['material_licencia'])) { 
		   
				 while ($row_rsLicencia=mysql_fetch_array($licencias)) { 
					?>
            <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row['material_licencia']==$row_rsLicencia['id_licencia']) { echo "selected"; } ?>><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
            <?php 
					}  
           
            } else { ?>
            <?php
					while ($row_rsLicencia=mysql_fetch_array($licencias)) { 
					?>
            <option value="<?php echo $row_rsLicencia['id_licencia']?>"><?php echo utf8_encode($row_rsLicencia['licencia']); ?></option>
            <?php 
					}  
			 } ?>
          </select>
</p>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Dir. Temporal
              <input type="hidden" name="archivos" id="archivos"  />
            </strong></td>
            <td>&nbsp;</td>
            <td><b>Seleccionados</b></td>
          </tr>
          <tr>
            <td><select id="SelectArchivos" style="WIDTH: 200px" multiple="multiple" size="5" name="SelectArchivos">
                <?php 
				$path="../../zona_descargas/materiales/temp/";
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
            <td><select id="PickArchivos[]" style="WIDTH: 200px" multiple="multiple" size="5" name="PickArchivos[]">
            <?php 
			 if (isset($row['material_archivos']) && $row['material_archivos'] != '') { 
					$ma=str_replace('}{',',',$row['material_archivos']);
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
        <p>
        </p>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Idiomas
                <input type="hidden" name="idiomas" id="idiomas"  />
            </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><select id="SelectIdiomas" style="WIDTH: 200px" multiple="multiple" size="5" name="SelectIdiomas">
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
            <td><select id="PickIdiomas[]" style="WIDTH: 200px" multiple="multiple" size="5" name="PickIdiomas[]">
                <?php 
			 if (isset($row['material_idiomas']) && $row['material_idiomas'] != '') { 
					$id=str_replace('}{',',',$row['material_idiomas']);
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
        <p>&nbsp; </p></td>
      <td width="62%" align="center" valign="top"><table cellpadding="0" cellspacing="0">
  <TR>
    <TD colspan="3"><strong>Autores
      <input type="hidden" name="autores" id="autores" />
      <input name="id_material" type="hidden" id="id_material" value="<?php echo $id_material; ?>" />
    </strong></TD>
    </TR>
  
                    <TR>
                      <TD><SELECT id="AutoresList" style="WIDTH: 250px" multiple size="5" name="AutoresList">
                          <?php while ($row_autores=mysql_fetch_array($autores)) {  ?>
                          <OPTION value="<?php echo $row_autores['id_autor'] ?>" sel><?php echo utf8_encode($row_autores['autor']); ?></OPTION>
                          <?php } ?>
                        </SELECT></TD>
                      <TD><INPUT onclick="addIt('AutoresList','PickAutores[]');" type="button" value="->">
                          <BR>
                          <INPUT onclick="delIt('AutoresList','PickAutores[]');" type="button" value="<-"></TD>
                      <TD><select id="PickAutores[]" style="WIDTH: 250px" multiple size=5 name="PickAutores[]">
						<?php 
						if (isset($row['material_autor']) && $row['material_autor'] != '') { 
							  $mau=str_replace('}{',',',$row['material_autor']);
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
						</select></TD>
                    </tr>
          </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>Area Curricular
              <input type="hidden" name="ac" id="ac" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="ACList" style="WIDTH: 250px" multiple="multiple" size="5" name="ACList">
                <?php while ($row_ac=mysql_fetch_array($ac)) {  ?>
                <option value="<?php echo $row_ac['id_ac_material']; ?>" sel="sel"><?php echo $row_ac['ac_material']; ?></option>
                <?php } ?>
            </select></td>
            <td><input onclick="addIt('ACList','PickAC[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('ACList','PickAC[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickAC[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickAC[]">
                <?php 
				  if (isset($row['material_area_curricular']) && $row['material_area_curricular'] != '') {
				   	  $mac=str_replace('}{',',',$row['material_area_curricular']);
					  $mac=str_replace('{','',$mac);
					  $mac=str_replace('}','',$mac);
					  $mac=explode(',',$mac);
					  
					  for ($i=0;$i<count($mac);$i++) { 
						if ($mac[$i]!='') {
						 $data_ac=$query->datos_material_ac($mac[$i]);
						 echo '<option value="'.$mac[$i].'" sel="sel">'.$data_ac['ac_material'].'</option>'; 
						}
					  }
					} 
				?>
              </select></td>
          </tr>
        </table>
        <table width="335" cellpadding="0" cellspacing="0">
          <tr>
            <td width="334"><strong>Subarea Curricular
                <input type="hidden" name="subac" id="subac" />
            </strong></td>
          </tr>
          <tr>
            <td height="45">Area:
              <select name="listado_areas" id="listado_areas" onchange="cargar_div('listar_subareas.php','id_area='+document.nuevo_material.listado_areas.value+'&msc=<?php echo $row['material_subarea_curricular'] ?>','listado_subareas');">
              <option value="0" sel="sel">Seleccionar</option>
              <?php while ($row_ac1=mysql_fetch_array($ac1)) {  ?>
                <option value="<?php echo $row_ac1['id_ac_material']; ?>"><?php echo $row_ac1['ac_material']; ?></option>
              <?php } ?>
             </select></td>
          </tr>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td>
              	<div id="listado_subareas">
              		<select id="SUBACList" style="WIDTH: 250px" multiple="multiple" size="5" name="SUBACList"></select>
                </div>   
              </td>
              <td><input onclick="addIt('SUBACList','PickSUBAC[]');" type="button" value="-&gt;" />
                  <br />
                  <input onclick="delIt('SUBACList','PickSUBAC[]');" type="button" value="&lt;-" /></td>
              <td><select id="PickSUBAC[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickSUBAC[]">
              <?php 
				  if (isset($row['material_subarea_curricular']) && $row['material_subarea_curricular'] != '') {
				   	  $msubac=str_replace('}{',',',$row['material_subarea_curricular']);
					  $msubac=str_replace('{','',$msubac);
					  $msubac=str_replace('}','',$msubac);
					  $msubac=explode(',',$msubac);
					  
					  for ($i=0;$i<count($msubac);$i++) { 
						if ($msubac[$i]!='') {
						 $data_subac=$query->datos_material_subac($msubac[$i]);
						 echo '<option value="'.$msubac[$i].'" sel="sel">'.$data_subac['subac_material'].'</option>'; 
						}
					  }
					} 
				?>
              </select></td>
          </tr>
        </table>
       
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>Dirigido
              <input type="hidden" name="dirigido" id="dirigido" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="dirigidoList" style="WIDTH: 250px" multiple="multiple" size="5" name="dirigidoList">
                <?php while ($row_dirigido=mysql_fetch_array($dirigido)) {  ?>
                <option value="<?php echo $row_dirigido['id_dirigido_material'] ?>" sel="sel"><?php echo $row_dirigido['dirigido_material']; ?></option>
                <?php } ?>
            </select></td>
            <td><input onclick="addIt('dirigidoList','Pickdirigido[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('dirigidoList','Pickdirigido[]');" type="button" value="&lt;-" /></td>
            <td><select id="Pickdirigido[]" style="WIDTH: 250px" multiple="multiple" size="5" name="Pickdirigido[]">
                <?php 
				if (isset($row['material_dirigido']) && $row['material_dirigido'] != '') {
				  $md=str_replace('}{',',',$row['material_dirigido']);
				  $md=str_replace('{','',$md);
				  $md=str_replace('}','',$md);
				  $md=explode(',',$md);
				  
				  for ($i=0;$i<count($md);$i++) { 
					if ($md[$i]!='') {
					 $data_dirigido=$query->datos_material_dirigido($md[$i]);
					  echo '<option value="'.$md[$i].'" sel="sel">'.$data_dirigido['dirigido_material'].'</option>';  
					}
				  }
				}
				?>
              </select> </td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>Edad
              <input type="hidden" name="edad" id="edad" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="edadList" style="WIDTH: 250px" multiple="multiple" size="5" name="edadList">
                <?php while ($row_edad=mysql_fetch_array($edad)) {  ?>
                <option value="<?php echo $row_edad['id_edad_material'] ?>" sel="sel"><?php echo $row_edad['edad_material']; ?></option>
                <?php } ?>
            </select></td>
            <td><input onclick="addIt('edadList','Pickedad[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('edadList','Pickedad[]');" type="button" value="&lt;-" /></td>
            <td><select id="Pickedad[]" style="WIDTH: 250px" multiple="multiple" size="5" name="Pickedad[]">
                <?php 
				if (isset($row['material_edad']) && $row['material_edad'] != '') {	
				  $me=str_replace('}{',',', $row['material_edad']);
				  $me=str_replace('{','',$me);
				  $me=str_replace('}','',$me);
				  $me=explode(',',$me);
				  
				  for ($i=0;$i<count($me);$i++) { 
					if ($me[$i]!='') {
					 $data_edad=$query->datos_material_edad($me[$i]);
					 echo '<option value="'.$me[$i].'" sel="sel">'.$data_edad['edad_material'].'</option>';
					}
				  }
				}		
				?>
              </select>            </td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>Nivel
              <input type="hidden" name="nivel" id="nivel" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="nivelList" style="WIDTH: 250px" multiple="multiple" size="5" name="nivelList">
                <?php while ($row_nivel=mysql_fetch_array($nivel)) {  ?>
                <option value="<?php echo $row_nivel['id_nivel_material'] ?>" sel="sel"><?php echo $row_nivel['nivel_material']; ?></option>
                <?php } ?>
            </select></td>
            <td><input onclick="addIt('nivelList','PickNivel[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('nivelList','PickNivel[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickNivel[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickNivel[]">
                <?php 
			   if (isset($row['material_nivel']) && $row['material_nivel'] != '') {
				  $mn=str_replace('}{',',',$row['material_nivel']);
				  $mn=str_replace('{','',$mn);
				  $mn=str_replace('}','',$mn);
				  $mn=explode(',',$mn);
				  
				  for ($i=0;$i<count($mn);$i++) { 
					if ($mn[$i]!='') {
					 $data_nivel=$query->datos_material_nivel($mn[$i]);
					  echo '<option value="'.$mn[$i].'" sel="sel">'.$data_nivel['nivel_material'].'</option>'; 
					}
				  }
				}
				?>
              </select> </td>
          </tr>
        </table>
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><strong>SAA
              <input type="hidden" name="saa" id="saa" />
            </strong></td>
          </tr>
          <tr>
            <td><select id="SelectSAA" style="WIDTH: 250px" multiple="multiple" size="5" name="SelectSAA">
                <?php while ($row_saa=mysql_fetch_array($saa)) {  ?>
                <option value="<?php echo $row_saa['id_saa_material'] ?>" sel="sel"><?php echo $row_saa['saa_material']; ?></option>
                <?php } ?>
            </select></td>
            <td><input onclick="addIt('SelectSAA','PickSAA[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('SelectSAA','PickSAA[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickSAA[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickSAA[]">
                <?php 
			 if (isset($row['material_saa']) && $row['material_saa'] != '') {
				  $msaa=str_replace('}{',',',$row['material_saa']);
				  $msaa=str_replace('{','',$msaa);
				  $msaa=str_replace('}','',$msaa);
				  $msaa=explode(',',$msaa);
				  
				  for ($i=0;$i<count($msaa);$i++) { 
					if ($msaa[$i]!='') {
					 $data_saa=$query->datos_material_saa($msaa[$i]);
					 echo '<option value="'.$msaa[$i].'" sel="sel">'. $data_saa['saa_material'].'</option>'; 
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
              <option value="<?php echo $row_tm['id_tipo_material'] ?>" sel="sel"><?php echo $row_tm['tipo_material']; ?></option>
              <?php } ?>
            </select></td>
            <td><input onclick="addIt('SelectTipo','PickTipo[]');" type="button" value="-&gt;" />
                <br />
                <input onclick="delIt('SelectTipo','PickTipo[]');" type="button" value="&lt;-" /></td>
            <td><select id="PickTipo[]" style="WIDTH: 250px" multiple="multiple" size="5" name="PickTipo[]">
                <?php 
			 if (isset($row['material_tipo']) && $row['material_tipo'] != '') {	
				  $mt=str_replace('}{',',',$row['material_tipo']);
				  $mt=str_replace('{','',$mt);
				  $mt=str_replace('}','',$mt);
				  $mt=explode(',',$mt);
				  
				  for ($i=0;$i<count($mt);$i++) { 
					if ($mt[$i]!='') {
					 $data_tipo=$query->datos_material_tipo($mt[$i]);
					 echo '<option value="'.$mt[$i].'" sel="sel">'.$data_tipo['tipo_material'].'</option>';
					}
				  }
			  }
				?>
              </select>            </td>
          </tr>
        </table>        </td>
    </tr>
  </table>
  <p align="center"><input type="button" name="save" value="<?php echo $boton_enviar; ?>" onclick="removeAreas(); customSave();" />
  </p>
  </form>
</div>
</body>
</html>

