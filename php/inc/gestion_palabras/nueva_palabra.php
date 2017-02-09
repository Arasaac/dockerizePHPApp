<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Nueva Palabra</title>
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
<div id="content" style="background-color:#FFF; border:1px solid #CCC;">
<form action="add_palabra.php" method="post" name="nueva_palabra" id="nueva_palabra" onSubmit="return formCheck(this);">
  <div align="center" id="nueva_palabra">
    <h2>Introduzca la nueva palabra</h2>
      <br />
        <input name="palabra" type="text" id="palabra" onkeypress="return handleEnter(this, event)" value="" size="50" maxlength="100">
      <br /><br />
        <input type="button" name="Submit" value="Comprobar" onClick="cargar_div2('comprobar_palabra.php','palabra='+document.nueva_palabra.palabra.value+'','nueva_palabra');"> <br /><br />

  </div>
</form>
</div>
<div id="footer">
		<p>CATEDU <?php echo date("Y"); ?> | ARASAAC</p>
</div>
</div>
</body>
</html>