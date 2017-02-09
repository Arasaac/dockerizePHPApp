<?php 
require('makeSecure.php');
if (!isset($_SESSION['IsReviser']) || $_SESSION['IsReviser']==0) { header ("Location: index.php"); }
$mensaje=$_GET['mensaje'];
$query=new query();
$datos_catalogador=$query->datos_catalogador($_SESSION['userName']);
$translate=$query->get_internacionalizacion_page_content('es',1);

$id_temas=str_replace('}{',',',$datos_catalogador['temas']);
$id_temas=str_replace('{','',$id_temas);
$id_temas=str_replace('}','',$id_temas);
$id_temas=explode(',',$id_temas);

//$temas=$query->listado_temas();
$temas=$query->listado_temas_tmp();

if ($_GET['id_tema']> 0) { 

	$id_tema=$_GET['id_tema'];
	
	if (!isset($_GET['pg'])) {
		$pg = 0; // $pg es la pagina actual
	} else { $pg=$_GET['pg']; }				
		$cantidad=1;
		$inicial = $pg * $cantidad;
						
		$limite_inferior="1"; //resultados por debajo de la pagina actual
		$page_limit = $limite_inferior;
						
		$limitpages = $page_limit;
		$page_limit = $pg + $limitpages;
		
		$contar=$query->listar_palabras_catalogadas_por_tema($id_tema);
		$resultados=$query->listar_palabras_catalogadas_por_tema_limit($id_tema,$inicial,$cantidad);

		$total_records = mysql_num_rows($contar);
		$total_pages = intval($total_records / $cantidad);
		$row=mysql_fetch_array($resultados);	
} 	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Editar Palabra</title>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/prototype/prototype.js"> </script> 
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
<body <?php if (count($id_temas)==1) { echo 'onload="cargar_div2(\'listar_subtemas.php\',\'tema='.$id_temas[0].'\',\'subtemas\')"'; } ?> >
<div style="float:left">Id palabra: 
  <input name="id_palabra2" type="text" id="id_palabra2" value="<?php echo $row['id_palabra']; ?>" size="8" maxlength="6" disabled="disabled" />
</div>
<div style="float:right"><?php echo $_SESSION['userName']; ?>  <a href="logout.php"><?php echo $translate['desconectar']; ?></a><?php if ($_SESSION['IsAdmin']==1) { echo ' | <a href="index.php">Zona Administrador</a>';  } ?></div>
<div id="container">
<div id="content">
<form id="form1" method="GET" action="<?php echo $PHP_SELF; ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <td align="center" style="color:#F00;"><?php echo $mensaje; ?><br /></td>
      </tr>
    <tr>
      <td align="center">
        Página: 
        <input name="pg" type="text" id="pg" value="<?php echo $pg; ?>" size="5" maxlength="5" />
      </td>
    </tr>
    <tr>
      <td align="center"><?php 
	if ($total_pages > 0) {
				
					
                    if ($page_limit > $total_pages ) {
                    
                        $page_limit = $total_pages;
                    
                    }
                    
                    $page_start = $pg;
                    $page_stop = $page_start + $limitpages;
                    
                        if ($page_stop > $total_pages) { 
                        
                            $page_stop = $page_stop -$total_pages;
                            $page_start = $page_start -$page_stop;
                        
                        }
                    
                    $content.= '<p><div id="pagination">';
                    
                    // Volver a Inicio
                    if($pg > 0) {
                    
                    $prev_limit = ($pg - $limitpages);

                    $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=0\"><< </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"><<</span>';
                    
                    }
                    
                    // Pagina anterior
                    if($pg > 0) { 
                    
                    $prev = ($pg - 1);
                    $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=".$prev."\"> <</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled">< </span>';
                    
                    }
                    
                    // Paginacion
                    if($total_pages >= $limitpages) {
                    
                        for($i = $page_start-$limite_inferior; ($i <= $total_pages & $i <=$page_limit); $i++) {
                        
                            if(($i) >= 0) { 	
                                if(($pg) == $i) { 
                                
                                $content.= '<span class="current">'.$i.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                
                                } else {
                                
                                $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=".$i."\">".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                            }
                        
                        } // Cierro el FOR
                    
                    } else {
                    
                        for($i = 0; $i <= $total_pages; $i++) {
                        
                            if(($pg) == $i) {
                            
                            $content.= '<span class="current">'.$i.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            
                            } else {
                            
                            $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=".$i."\">".$i."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        
                        } // Cierro el FOR
                        
                    } // Cierro el IF
                    
                    }
                    
                    // Siguiente página
                    if($pg < $total_pages) {
                    
                    $next = ($pg + 1);
                    $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=".$next."\"> ></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> ></span>';
                    
                    }
                    
                    // Ultima página
                    if($pg < $total_pages)
                    {
                    
                    $last = $total_pages;
                    $content.= "<a href=\"".$PHP_SELF."?id_tema=".$_GET['id_tema']."&pg=".$last."\">  >></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> >></span>';
                    
                    }
                    
                    
                    $content.= "</p></div>";
                    
                    
                    $content.= "</p></div>";
              
	}
	echo $content;
?></td>
      </tr>
  </table>
</form>
<form action="update_palabra.php" method="post" name="nueva_palabra" id="nueva_palabra">
  <div align="center" id="nueva_palabra">
	<p><?php echo '<big><b>'.$row['palabra'].'</b></big><br />'.utf8_encode($row['definicion']); ?>
  <input name="palabra" type="hidden" id="palabra" value="<?php echo $row['palabra']; ?>" />
  <input name="id_palabra" type="hidden" id="id_palabra" value="<?php echo $row['id_palabra']; ?>" />
  <input name="pg" type="hidden" id="pg" value="<?php echo $pg; ?>" />
  <input name="tema_id" type="hidden" id="tema_id" value="<?php echo $_GET['id_tema']; ?>" />
  <input name="origen" type="hidden" id="origen" value="revisor" />
  <br>
</p>
	  <p>
	    <strong>Temas:</strong>
  <select name="temas" id="temas" required="1" realname="Categor&iacute;a" onchange="javascipt:document.location.href='<?php echo $PHP_SELF; ?>?id_tema='+document.nueva_palabra.temas.value">
    <?php while ($row_rsTemas=mysql_fetch_array($temas)) { ?>
    <option value="<?php echo $row_rsTemas['id_tema']?>" <?php if ($row_rsTemas['id_tema']==$_GET['id_tema']) { echo 'selected="selected"'; } ?>><?php echo $row_rsTemas['tema']; ?></option>   
    <?php }  // Cierro el While ?>
</select>
</p>
	  <TABLE>
					  <TR>
					    <TD><strong>Subtemas</strong></TD>
						<TD>&nbsp;</TD>
						<TD><strong>Subtemas seleccionados <?php if ($_SESSION['IsAdmin']==0) { echo '(1)'; } ?></strong></TD>
					  </TR>
					  <TR>
					    <TD><?php $listado_subtemas=$query->listado_subtemas_tmp($_GET['id_tema'],100); ?>
                        <div id="subtemas">
                        	<select id=SelectList style="WIDTH: 280px" multiple size=8 name=SelectList>
                            <?php 
							  while ($row_subtemas=mysql_fetch_array($listado_subtemas)) {

								echo '<option value="'.$row_subtemas['id_subtema'].'">'.$row_subtemas['tema']."-".$row_subtemas['subtema'].'</option>';

							  } 
							?>
                            </select>
                            </div></TD>
					    <TD><input name="button" type=button onclick=addIt(); value="->" />
                          <br />
						  <?php 
						  	//$subtemas= $query->listado_subtemas_palabra($row['id_palabra']); 
							$subtemas= $query->listado_subtemas_palabra_tmp($row['id_palabra']);
						  ?>
                        <input name="button" type=button onclick=delIt(); value="<-" <?php if ($_SESSION['IsAdmin']==0) { echo 'disabled="disabled"'; } ?> /></TD>
					    <TD><select id="PickList" style="WIDTH: 280px" multiple size=8 name="PickList[]" checkallownull="false" checktype="text" checkmessage="<?php echo "Debe definir algún subtema"; ?>">
						<?php 
						while ($row_sc=mysql_fetch_array($subtemas)) {
							echo '<option value="'.$row_sc['id_subtema'].'">'.$row_sc['tema']."-".$row_sc['subtema'].'</option>';
						}		
						?>
                        </select></TD>
	    </TR>
	  </TABLE>
        <input type="submit" name="Submit" value="Actualizar datos palabra" onclick="return selIt_sin();" /><br />
        <?php if ($_SESSION['IsAdmin']==0) { echo '(1) Si hay algún error en la asignación de subtemas en el cuadro de la derecha que ya se ha guardado poneros en contacto con nosotros por email (administradores) indicando el id de palabra (esquina superior izquierda) y el error a subsanar.'; } ?>
          </p>
    </div>
</form>
</div>
</div>
</body>
</html>