<?php
set_time_limit(95000);
 
require_once "../../classes/querys/query.php";
$query=new query();

$id_idioma=$_GET['id_idioma']; 	

switch ($id_idioma) {
	case 99: $value="es"; break;
	case 2: $value="ro"; break;
	case 6: $value="po"; break;
	case 7: $value="en"; break;
	case 8: $value="fr"; break;
	case 9: $value="ca";  break;
	case 10: $value="eu"; break;	
	case 11: $value="de"; break;
	case 12: $value="it"; break;
	case 13: $value="pt"; break;
	case 15: $value="br"; break;
	case 14: $value="ga"; break;
}

if (isset($_GET['id_idioma']) && $_GET['id_idioma'] > 0) { 
		
		$tema=array();
		$num_categ=$query->listado_temas();
		$numrows = mysql_num_rows($num_categ);
								
			while ($row=mysql_fetch_array($num_categ)) {
								
				$tema[]=$row['id_tema'];
				
					if ($value=='es') { 
						$tema['tema'][]=$row['tema'];
					} elseif ($value != 'es') {
						$tema['tema'][]=$row['tema_'.$value.''];
					}
								
			}
		
			$menustring='';
					
					for ($i=0;$i<$numrows;$i++) {

						$menustring.=".|".$tema['tema'][$i]."||||1\n";
						
							$subtemas=$query->listado_subtemas($tema[$i],50); 
							$num_rows2=mysql_num_rows($subtemas);
										
								if ($num_rows2 > 0) {
									while ($row2=mysql_fetch_array($subtemas)) {
																				
										if ($value=='es') { 
											
											
											if (in_array($row2['id_subtema'],$array_subcategorias)) { 
											
												$menustring.="..|".$row2['subtema']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."|activar|\n" ; 
											} else {
												
												$menustring.="..|".$row2['subtema']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."||\n" ; 
											}
											
											
										
										} else { 
										
											if (in_array($row2['id_subtema'],$array_subcategorias)) { 
											
												$menustring.="..|".$row2['subtema_'.$value.'']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."|activar|\n"; 
											
											} else {
												
												$menustring.="..|".$row2['subtema_'.$value.'']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."||\n"; 
												
											}
											
																					  
									   }
										
									}
								}	
											
							
					}	
					
		$fp = fopen('../../arbol_categorias/'.$value.'.txt', 'w');
		fwrite($fp, $menustring);
		fclose($fp);
		
	}
?>
<form id="form1" name="form1" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <p>Idioma
    <select name="id_idioma">
      <option value="99">Castellano</option>
      <option value="2">Rumano</option>
      <option value="6">Polaco</option>
      <option value="7">Ingles</option>
      <option value="8">Frances</option>
      <option value="9">Catalan</option>
      <option value="10">Euskera</option>
      <option value="11">Aleman</option>
      <option value="12">Italiano</option>
      <option value="13">Portugues</option>
      <option value="15">Portugues Brasil</option>
      <option value="14">Gallego</option>
    </select>
    <input type="submit" value="Enviar" />
  </p>
</form>