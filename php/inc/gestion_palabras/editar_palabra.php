<?php 

include ('../../classes/querys/query.php');

$query=new query();

$id_palabra=$_GET['id'];

$palabra=$query->datos_palabra($id_palabra);

if (isset($_GET['mensaje'])) {
$mensaje='<div  align="center"><div class="mensaje">'.$_GET['mensaje'].'</div></div>';
} else {
$mensaje='';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Editar Palabra</title>
<link rel="stylesheet" href="../../css/emergentes.css" type="text/css" />
<script language="Javascript" src="../../js/formcheck/formcheck.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<script language="Javascript" src="../../js/expand-collaps/collapse_expand_single_item.js"></script>
<script type="text/javascript" src="../../js/prototype/prototype.js"> </script> 
<SCRIPT language=JavaScript>
var singleSelect = true;  // Allows an item to be selected once only
var sortSelect = true;  // Only effective if above flag set to true
var sortPick = true;  // Will order the picklist in sort sequence

// Adds a selected item into the picklist
function addIt() {
  var selectList = document.getElementById("SelectList");
  var selectIndex = selectList.selectedIndex;
  var selectOptions = selectList.options;
  var pickList = document.getElementById("PickList");
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
function delIt() {
  var selectList = document.getElementById("SelectList");
  var selectOptions = selectList.options;
  var selectOLength = selectOptions.length;
  var pickList = document.getElementById("PickList");
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
function selIt(btn) {
  var pickList = document.getElementById("PickList");
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
function selIt_sin(btn) {
  var pickList = document.getElementById("PickList");
  var pickOptions = pickList.options;
  var pickOLength = pickOptions.length;
  for (var i = 0; i < pickOLength; i++) {
    pickOptions[i].selected = true;
  }
  return true;
}
//-->
</SCRIPT>
</head>
<body>
<div>
<div id="content">
<?php echo $mensaje; ?>
<form action="update_palabra.php" method="post" name="nueva_palabra" id="nueva_palabra" onSubmit="return formCheck(this);">
  <div align="center" id="nueva_palabra">
	  <TABLE>
					  <TR>
					    <TD colspan="3"><strong>Palabra:</strong>
                        <input name="palabra" type="text" id="palabra" value="<?php echo $palabra['palabra']; ?>" size="50"  readonly="yes" onkeypress="return handleEnter(this, event)" /></TD>
	      </TR>
					  <TR>
					    <TD colspan="3"><strong>
                        <?php $categ2=$query->listar_categorias_palabras(); ?>
                        Tipo de Palabra:</strong>
                          <select name="id_tipo_palabra" id="id_tipo_palabra">
                            <option value="<?php echo $palabra['id_tipo_palabra'] ?>" selected="selected"><?php echo utf8_encode($palabra['tipo_palabra']); ?></option>
                            <?php while ($row_rsCategorias=mysql_fetch_array($categ2)) {  ?>
                            <option value="<?php echo $row_rsCategorias['id_tipo_palabra']?>"><?php echo $row_rsCategorias['tipo_palabra']; ?></option>
                            <?php  }  // Cierro el While ?>
                        </select></TD>
	      </TR>
					  <TR>
					    <TD colspan="3"><strong>
					      <?php $temas=$query->listado_temas(); ?>
				        Temas:</strong>
                          <select name="temas" id="temas" required="1" realname="Categor&iacute;a" class="fonty" onchange="cargar_div2('../listar_subtemas.php','tema='+document.nueva_palabra.temas.value+'','subtemas')">
                            <option value="0" selected="selected">Seleccione un tema</option>
                            <?php while ($row_rsTemas=mysql_fetch_array($temas)) {  ?>
                            <option value="<?php echo $row_rsTemas['id_tema']?>"><?php echo $row_rsTemas['tema']; ?></option>
                            <?php }  // Cierro el While ?>
                        </select></TD>
	      </TR>
					  <TR>
					    <TD><strong>Subtemas</strong></TD>
						<TD>&nbsp;</TD>
						<TD><strong>Subtemas seleccionados </strong></TD>
					  </TR>
					  <TR>
					    <TD><div id="subtemas"><select id=SelectList style="width: 280px; height:180px;" multiple size=8 name=SelectList>
                                                </select></div></TD>
					    <TD><input name="button" type=button onclick=addIt(); value="->" />
                          <br />
						  <?php $subtemas= $query->listado_subtemas_palabra($id_palabra); ?>
                        <input name="button" type=button onclick=delIt(); value="<-" /></TD>
					    <TD><select id="PickList" style="width: 280px; height:180px;" multiple size=8 name="PickList[]" checkallownull="false" checktype="text" checkmessage="<?php echo "Debe definir algún subtema"; ?>">
						<?php 
						while ($row=mysql_fetch_array($subtemas)) {
							echo '<option value="'.$row['id_subtema'].'">'.utf8_decode($row['tema'])."-".utf8_decode($row['subtema']).'</option>';
						}		
						?>
                        </select></TD>
	    </TR>
	  </TABLE>
	  <br />
        <input type="submit" name="Submit" value="Actualizar datos palabra" onclick="return selIt_sin();" />
          </p>

          <input name="id_palabra" type="hidden" id="id_palabra" value="<?php echo $id_palabra; ?>" />
  </div>
</form>
</div>
<div id="footer">
		<p>CATEDU <?php echo date("Y"); ?> | ARASAAC </p>
</div>
</div>
</body>
</html>