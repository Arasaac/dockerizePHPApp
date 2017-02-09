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

$id_tipo=$_GET['id_tipo'];

	if (isset($_GET['id_idioma']) && $_GET['id_idioma'] > 0 && isset($_GET['id_tipo']) && $_GET['id_tipo'] > 0) {

		if ($value=='es') {
			$num_categ=$query->listado_temas();
		} elseif ($value !='es') {
			$num_categ=$query->listado_temas_idiomas($value);
		}
					
			$numrows = mysql_num_rows($num_categ);
			$n_temas=0;
					
					while ($row=mysql_fetch_array($num_categ)) {
						
						$tema=array();

						$resultado_originales_por_tema=$query->buscar_originales_por_tema($row['id_tema'],$tipo_pictograma);
						$n_resultado_originales_por_tema=mysql_num_rows($resultado_originales_por_tema);
						
						echo $n_resultado_originales_por_tema;
						
						//IF que comprueba si un tema tiene palabras asociadas. Si no tiene no lo muestro
							if ($n_resultado_originales_por_tema > 0) {
								
								$tema[]=$row['id_tema'];
						
								if ($value=='es') { 
									$tema['tema'][]=$row['tema'];
								} else {
									$tema['tema'][]=$row['tema_'.$value.''];
								}
								
								$n_temas++;
								
							} //Cierro el IF que comprueba si un tema tiene palabras asociadas
		}
			
							echo $n_temas;
							
			$menustring='';
					
					for ($i=0;$i<$n_temas;$i++) {
						
						//$menustring.=".|".$tema['tema'][$i]."||||1\n"
						
						if (in_array($tema[$i],$array_categorias)) {
							
							$menustring.=".|".$tema['tema'][$i]."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_tema=".$tema[$i]."|".$tema[$i]."|activar|\n" ;
						} else {
							$menustring.=".|".$tema['tema'][$i]."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_tema=".$tema[$i]."|".$tema[$i]."||\n" ;
							
						}
						
							if ($value=='es') { 
								$subtemas=$query->listado_subtemas($tema[$i],50);
							} else {
								$subtemas=$query->listado_subtemas_idiomas($tema[$i],50,$value);
							}
							
							$num_rows2=mysql_num_rows($subtemas);
										
								if ($num_rows2 > 0) {
									while ($row2=mysql_fetch_array($subtemas)) {									
										 
											if ($value=='es') { 
											
											//PARA MOSTRAR SOLO SUBCATEGORIAS QUE TENGAN PALABRAS ASIGNADAS EN CASTELLANO
												$resultado_originales=$query->buscar_originales_por_subtema($row2['id_subtema'],$id_tipo);
												
												$n_resultado_originales=mysql_num_rows($resultado_originales);
												if ($n_resultado_originales > 0) {
												
													if (in_array($row2['id_subtema'],$array_subcategorias)) { 
													
														$menustring.="..|".$row2['subtema']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."|activar|\n" ; 
													} else {
														
														$menustring.="..|".$row2['subtema']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."||\n" ; 
													}
												
												} //Cierro el IF de comprobar si hay resultados para una determinada subcategoria
											
											} else { 
												
												//PARA MOSTRAR SOLO SUBCATEGORIAS QUE TENGAN PALABRAS ASIGNADAS Y TRADUCIDAS
												//DESACTIVADO PORQUE VA MUY LENTO
												/*$resultado_originales=$query->buscar_originales_idioma_por_subtema($row2['id_subtema'],$_SESSION['id_language'],$tipo_pictograma);
												$n_resultado_originales=mysql_num_rows($resultado_originales);
												if ($n_resultado_originales > 0) {*/
												
												//PARA MOSTRAR SOLO SUBCATEGORIAS QUE TENGAN PALABRAS ASIGNADAS EN CATEELLANO
												$resultado_originales=$query->buscar_originales_por_subtema($row2['id_subtema'],$id_tipo);
												
												$n_resultado_originales=mysql_num_rows($resultado_originales);
												if ($n_resultado_originales > 0) {
													
													if (in_array($row2['id_subtema'],$array_subcategorias)) { 
													
														$menustring.="..|".$row2['subtema_'.$value.'']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."|activar|\n"; 
													
													} else {
														
														$menustring.="..|".$row2['subtema_'.$value.'']."|".$PHP_SELF."?{cadena_url_3}busqueda=basico&id_subtema=".$row2['id_subtema']."|".$row2['id_subtema']."||\n"; 
														
													}
												
												} //Cierro el IF de comprobar si hay resultados para una determinada subcategoria
												
										   } //Cierro el IF del idioma
										
									}
								}	
											
							
					}	
						
		/*$fp = fopen('../../arbol_categorias/'.$value.'_'.$id_tipo.'.txt', 'w');
		fwrite($fp, $menustring);
		fclose($fp);*/
		
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

  </p>
  <p>Tipo a exportar
  <input name="id_tipo" type="text" id="id_tipo" size="5" maxlength="2" />
  <p>2 - Realista</p>
  <p>3 - Animados</p>
  <p>5 - Pictogramas Blanco y Negro</p>
  <p>9 - Clipart</p>
  <p>10 - Pictogramas Color</p>
  <p>11 - Videos LSE</p>
  <p>12 - LSE Color</p>
  <p>13 - LSE ByN</p>    
  <input type="submit" value="Enviar" />
</form>