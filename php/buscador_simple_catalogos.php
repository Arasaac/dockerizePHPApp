	<?php if ((!isset($_GET['buscador']) || $_GET['buscador']==1)) {  ?>
    <div id="cuadro_busqueda_catalogos">
    <?php unset($info['buscador']); $cadena_url_buscador=http_build_query($info); 	if ($cadena_url_buscador !='') { $cadena_url_buscador=http_build_query($info).'&'; } ?>
      <div id="flotar_derecha"><a href="<?php echo $PHP_SELF; ?>?<?php echo $cadena_url_buscador ?>buscador=0"><?php echo $translate['cerrar']; ?></a></div>
                    <span class="separador_verde">
                    <input name="busqueda" type="hidden" id="busqueda" value="basico" />
    </span>
                    <?php if (isset($_GET['p']) && $_GET['p'] !='') { ?><input name="p" type="hidden" id="p" value="<?php echo $_GET['p']; ?>" /><?php }?>
                    <?php if (isset($_GET['arbol']) && $_GET['arbol'] !='') { ?><input name="arbol" type="hidden" id="arbol" value="<?php echo $_GET['arbol']; ?>" /><?php }?>
                    <br />
                        
                          <strong><label for="tipo_palabra"><?php echo $translate['tipo_de_palabra']; ?></label>:</strong>
                          <select name="tipo_palabra" class="textos" id="tipo_palabra">
                          <?php if (isset($_GET['tipo_palabra']) && $_GET['tipo_palabra'] > 0 && $_GET['tipo_palabra'] < 99) { 

									$d_tipo=$query->datos_tipo_palabra($_GET['tipo_palabra']);
								
                                    if ($_SESSION['id_language'] > 0) {
                                        echo '<option value="'.$d_tipo['id_tipo_palabra'].'" selected="selected">'.$d_tipo['tipo_palabra_'.$_SESSION['language'] .''].'</option>';	
                                    } else {
                                        echo '<option value="'.$d_tipo['id_tipo_palabra'].'" selected="selected">'.$d_tipo['tipo_palabra'].'</option>';
                                    }
									
									echo '<option value="99">'.$translate['todas'].'</option>';
							} else  { ?>
                           		<option value="99" selected="selected"><?php echo $translate['todas']; ?></option>
                            <?php } ?> 
                            <?php $categ3=$query->listar_categorias_palabras(); ?>                           
                            <?php while ($row_rsCategorias3=mysql_fetch_array($categ3)) {  ?>
                            <option value="<?php echo $row_rsCategorias3['id_tipo_palabra']?>"><?php echo $row_rsCategorias3['tipo_palabra_'.$_SESSION['language'] .'']; ?></option>
                            <?php }  ?>
                          </select>
                          <label for="TXTlocate"></label>
                          <select name="TXTlocate" id="TXTlocate">
                        	<option value="1" <?php if (isset($_GET['TXTlocate']) && $_GET['TXTlocate'] ==1) { echo "selected"; } ?>><?php echo $translate['comienza_por']; ?></option>
                            <option value="2" <?php if (isset($_GET['TXTlocate']) && $_GET['TXTlocate'] ==2) { echo "selected"; } ?>><?php echo $translate['contiene']; ?></option>
                            <option value="3" <?php if (isset($_GET['TXTlocate']) && $_GET['TXTlocate'] ==3) { echo "selected"; } ?>><?php echo $translate['termina_por']; ?></option>
                            <option value="4" <?php if (isset($_GET['TXTlocate']) && $_GET['TXTlocate'] ==4) { echo "selected"; } ?>><?php echo $translate['es_igual_a']; ?></option>
                          </select>
                        <label for="letra"></label>
                        <input name="letra" type="text" id="letra" size="10" value="<?php if (isset($_GET['letra']) && $_GET['letra'] !='') { echo $_GET['letra']; } ?>"/>
                         <strong><label for="filtrado"><?php echo $translate['ordenado_por']; ?></label></strong>
                        <select name="filtrado" id="filtrado">
                        	<option value="1" <?php if (isset($_GET['filtrado']) && $_GET['filtrado'] ==1) { echo "selected"; } ?>><?php echo $translate['fecha_alta']; ?></option>
                            <option value="2" <?php if (isset($_GET['filtrado']) && $_GET['filtrado'] ==2) { echo "selected"; } ?>><?php echo $translate['palabra']; ?></option>
                        </select>
                        <label for="orden"></label>
                        <select name="orden" id="orden">
                          <option value="desc" <?php if (isset($_GET['orden']) && $_GET['orden'] =='desc') { echo "selected"; } ?>><?php echo $translate['descendente']; ?></option>
                   	      <option value="asc" <?php if (isset($_GET['orden']) && $_GET['orden'] =='asc') { echo "selected"; } ?>><?php echo $translate['ascendente']; ?></option>
                          
                        </select>
                        <input type="submit" name="Submit" value="<?php echo $translate['buscar']; ?>" class="boton_grande"/><br /><br />
					
	  </div>
       <?php } ?> 