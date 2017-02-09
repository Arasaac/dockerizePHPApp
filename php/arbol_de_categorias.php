<?php if ((!isset($_GET['arbol']) || $_GET['arbol']==1)) {  ?>
        	<div id="menu_categorias">
              <?php 
			  $str5 = $_SERVER['QUERY_STRING'];
			  parse_str($str5, $info5);
			  unset($info5['arbol']);
			  $cadena_url_arbol=http_build_query($info5); 	
			  if ($cadena_url_arbol !='') { $cadena_url_arbol=http_build_query($info5).'&'; } 
			  ?>
           		<div id="flotar_derecha"><a href="<?php echo $PHP_SELF; ?>?<?php echo $cadena_url_arbol; ?>arbol=0"><?php echo $translate['cerrar']; ?></a></div>
                <br />
           		<?php				
					unset($info3['busqueda']);
					unset($info3['id_subtema']);
					unset($info3['subcategoria[]']);
					unset($info3['l']);
					unset($info3['id']);
					unset($info3['id_palabra']);
					$cadena_url3=http_build_query($info3);
					if ($cadena_url3 !='') { $cadena_url3=http_build_query($info3).'&'; }
					
					// get contents of a file into a string
					$filename = "arbol_categorias/".$_SESSION['language'].".txt";
					$handle = fopen($filename,"r");
					$menustring = fread($handle, filesize($filename));
					fclose($handle);
					
					$menustring = str_replace ('{cadena_url_3}',$cadena_url3,$menustring);
				
					$phptreemid = new PHPTreeMenu();
					$phptreemid->setMenuStructureString($menustring);
					$phptreemid->setPHPTreeMenuDefaultExpansion('2|3|6');
					$phptreemid->setIconsize(16, 16);
					$phptreemid->parseStructureForMenu('treemenu1');
					$phptreemid->setPHPTreeMenuTheme('');
					print $phptreemid->newPHPTreeMenu('treemenu1');
			?> 
         <br /> <br /><input type="submit" name="Submit" value="<?php echo $translate['buscar']; ?>" class="boton_mediano" />
         <br /> <br />
         <?php if ($_SESSION['language']=='es') {  ?>
         <div style="visibility:hidden;">
			<?php //include ('applet_vivoreco.html'); ?>
        </div>
        <?php }  ?>
   	</div>
    <?php } ?>