<?php 
require('requires_basico.php');
require ('funciones/funciones.php');
require ('configuration/key.inc');
require ('classes/crypt/5CR.php');
$encript = new E5CR($llave);

$pagina="ejemplos_uso.php";
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],12); 
$hoy=date("d-m-Y");
$hace_dias=5; //Valor en días para mostrar la imagen de Novedad
$cantidad= 5;
$content='';
$i=0;

if (isset($_GET['busqueda'])) {
	
	if (isset($_GET['busqueda']) && $_GET['busqueda']=='basico') {

		if (!isset($_GET['pg'])) {
			$pg = 0; // $pg es la pagina actual
		} else { $pg=$_GET['pg']; }
		
			$inicial = $pg * $cantidad;
			$limite_inferior="5"; //resultados por debajo de la pagina actual
			$page_limit = $limite_inferior;			
			$limitpages = $page_limit;
			$page_limit = $pg + $limitpages;
				
			$texto_buscar=utf8_decode($_GET['titulo_descripcion']);
			
			$sql='';
			
			if (isset($_GET['id_tipo_eu']) && $_GET['id_tipo_eu'] > 0) {  $sql.="AND eu_tipo LIKE '%{".$_GET['id_tipo_eu']."}%' 
			";  }
			if (isset($_GET['idiomas']) && $_GET['idiomas'] !='') {  $sql.="AND eu_idiomas LIKE '%{".$_GET['idiomas']."}%' 
			"; }
			
			if (isset($_GET['autor']) && $_GET['autor'] !='') {
				$autores=$query->buscar_autores_nombre(utf8_decode($_GET['autor']));
				
					while ($row_autor=mysql_fetch_array($autores)) {
					
						$sql.="AND eu_autor LIKE '%{".$row_autor['id_autor']."}%' 
						"; 
					
					}
			}
			
			$contar=$query->buscar_eu($_SESSION['AUTHORIZED'],$texto_buscar,$sql,$_SESSION['language']);
			
				
			if ($contar==false) { 
			
				$mensaje='<div align="center" style="color:#FF0000"><img src="images/error.gif" alt="'.$translate['no_resultados_criterios'].'" title="'.$translate['no_resultados_criterios'].'"><br />'.$translate['no_resultados_criterios'].'.</div>';
			
			} else {
			
			$resultados=$query->buscar_eu_limit($_SESSION['AUTHORIZED'],$texto_buscar,$sql,$inicial,$cantidad,$_SESSION['language']);
			
			$total_records = $contar;
			$total_pages = intval($total_records / $cantidad);
			
			$n_resultados=$contar;
			
			$mensaje='<br /><h4>'.$translate['resultados_busqueda_eu'].' ('.$n_resultados.'):</h4><br />
<p class="alineacion_derecha"><a href="rss/subscripcion.php?t=7&titulo_descripcion='.$_GET['titulo_descripcion'].'&autor='.$_GET['autor'].'&id_tipo_eu='.$_GET['id_tipo_eu'].'&idiomas='.$_GET['idiomas'].'" target="_blank">   '.$translate['subscribirse_resultados_busqueda'].'</a>&nbsp;<a href="rss/subscripcion.php?t=7&titulo_descripcion='.$_GET['titulo_descripcion'].'&autor='.$_GET['autor'].'&id_tipo_eu='.$_GET['id_tipo_eu'].'&idiomas='.$_GET['idiomas'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_busqueda'].'" title="'.$translate['subscribirse_resultados_busqueda'].'" ></a></p><br />';
			
			}
		
		} else {
		
		$resultados=$query->buscar_eu_limit($_SESSION['AUTHORIZED'],$texto_buscar,$sql,$inicial,$cantidad);
		$total_records = $contar;
		$total_pages = intval($total_records / $cantidad);
		
		$n_resultados=$contar;
		
		$mensaje='<br /><h4>'.$translate['resultados_busqueda_eu'].' ('.$n_resultados.'):</h4><br /><br />';
		
		}
		

} else { //ELSE del IF de comprobocación de si se está buscando

	if (!isset($_GET['pg'])) {
		$pg = 0; // $pg es la pagina actual
	} else { $pg=$_GET['pg']; }
		
		$cantidad=20;		
		$inicial = $pg * $cantidad;
					
		$limite_inferior="5"; //resultados por debajo de la pagina actual
		$page_limit = $limite_inferior;
					
		$limitpages = $page_limit;
		$page_limit = $pg + $limitpages;
		
		$contar=$query->ultimas_fichas_eu_destacado();
		$resultados=$query->ultimas_fichas_eu_destacado_limit($inicial,$cantidad);
		$n_resultados=$contar;
		$total_records = $contar;
		$total_pages = intval($total_records / $cantidad);

	$mensaje='<br /><h4>'.$translate['eu_destacado'].'</h4><br />';
	
} //Cierro el IF de comprobación de si se está buscando

$tm=$query->listar_tipo_eu();
$idiomas=$query->listar_idiomas();

require('cabecera_html.php');

if (isset($_GET['id_eu']) && $_GET['id_eu'] > 0) {  
            
     $row=$query->datos_eu2($_GET['id_eu']);
	 echo '<title>ARASAAC - '.$translate['ejemplos_de_uso'].': '.$row['eu_titulo'].'</title>';
	 
} else {
	
	 echo '<title>ARASAAC: '.$translate['ejemplos_de_uso'].'</title>';
	
}
?>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script src="js/galleria/galleria-1.2.6.min.js"></script>
    <!-- Coloca esta petición de presentación donde creas oportuno. -->
	<script type="text/javascript">
      window.___gcfg = {lang: '<?php echo $_SESSION['language']; ?>'};
    
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <?php require ('text_size_css.php'); ?>
</head>

<body>
        
<div class="body_content"> 
<?php include_once('include_facebook.php'); ?>
	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>
      <br /><h4><?php echo $translate['ejemplos_de_uso']; ?></h4>		
  	  <div id="principal">
            <div id="materiales_encima_buscador">
  			<?php 
					//Con este código elimino la variable pg que es dinamica
			   		$str = $_SERVER['QUERY_STRING'];
					parse_str($str, $info);
					unset($info['buscador']);
					$cadena_url_buscador=http_build_query($info);
					if ($cadena_url_buscador !='') { $cadena_url_buscador=http_build_query($info).'&'; }
					//************************************************************
			
			include('barra_opciones_ejemplos_uso.php');
			?>
  			


   	   <div id="loading">
                <div><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
       </div>
    </div>        
    <form id="search_eu_basico" name="search_eu_basico" action="<?php echo $PHP_SELF; ?>">
       <input id="hiddenStatusMenu" type="hidden" <?php if (isset($_GET['id_eu']) && $_GET['id_eu'] > 0) {  echo 'value="0"';  } else { echo 'value="1"'; } ?> />
       <input id="hiddenStatusMenu_avanzado" type="hidden" value="0" />
       <input id="hiddenStatusMenu_categorias" type="hidden" value="0" />
      <br  />
           
      <?php if ((isset($_GET['buscador']) && $_GET['buscador']==1)) {  ?>
        <div id="searchmenu">
		   <div id="cuadro_busqueda_materiales">
             <div id="flotar_derecha"><a href="<?php echo $pagina; ?>?<?php echo $cadena_url_buscador ?>buscador=0"><?php echo $translate['cerrar']; ?></a></div>
				 <div class="separador_verde"><?php echo $translate['buscador_basico_eu']; ?>
				   <input name="busqueda" type="hidden" id="busqueda" value="basico" />
			       <input name="buscador" type="hidden" id="buscador" value="1" />
			 </div><br />
                 
             <div id="tabla1"> 
                <div id="tabla1_celda1"> 
                  <label for="titulo_descripcion_basico"><strong><?php echo $translate['titulo_descripcion']; ?></strong></label>
                   <div class="suboption" id="so1">
                   		<input name="titulo_descripcion" type="text" class="cuadro_busqueda_materiales" id="titulo_descripcion" size="40" value="<?php if (isset($_GET['titulo_descripcion_basico']) && $_GET['titulo_descripcion_basico'] !='') { echo $_GET['titulo_descripcion_basico']; } ?>"/>
                   </div>
                   <label for="autor_basico"><strong><?php echo $translate['autor']; ?></strong></label>
                 	<div class="suboption" id="so3">
                  		 <input name="autor" type="text" class="cuadro_busqueda_materiales" id="autor" size="40" value="<?php if (isset($_GET['autor_basico']) && $_GET['autor_basico'] !='') { echo $_GET['autor_basico']; } ?>"/>
                	</div>
                    
                </div>
                
                <div id="tabla1_celda2">
                   <label for="id_tipo_eu"><strong><?php echo $translate['area']; ?></strong></label>
                     <div class="suboption" id="so1">
                       <select name="id_tipo_eu" id="id_tipo_eu">
                       
                           <?php if (isset($_GET['id_tipo_eu']) && $_GET['id_tipo_eu'] > 0) { 
						   
						   		$d_ts=$query->datos_tipo_eu($_GET['id_tipo_eu']);
								
                                if ($_SESSION['id_language'] > 0) {
                                
                                    echo '<option value="'.$d_ts['id_tipo_eu'].'" selected="selected">'.$d_ts['tipo_eu_'.$_SESSION['language'].''].'</option>';
                                    
                                } else {
                                
                                    echo '<option value="'.$d_ts['id_tipo_eu'].'" selected="selected">'.$d_ts['tipo_eu'].'</option>';
                                }
									echo '<option value="0">'.$translate['cualquiera'].'</option>';
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                         <?php while ($row_tsf=mysql_fetch_array($tm)) {  
                                if ($_SESSION['id_language'] > 0) {
                                
                                    echo '<option value="'.$row_tsf['id_tipo_eu'].'">'.$row_tsf['tipo_eu_'.$_SESSION['language'].''].'</option>';
                                    
                                } else {
                                
                                    echo '<option value="'.$row_tsf['id_tipo_eu'].'">'.$row_tsf['tipo_eu'].'</option>';
                                }
                         } ?>
                       </select>
                 </div>
                 
                </div>
                
                
                <div id="tabla1_celda3">

                  <label for="idiomas_basico"><strong><?php echo $translate['idiomas']; ?></strong></label>
                       <div class="suboption" id="so2">
                         <select name="idiomas" id="idiomas">
                           <?php if (isset($_GET['idiomas']) && $_GET['idiomas'] !='') { 
						   		if ($_GET['idiomas']=='es') {
									echo '<option value="es" selected="selected">'.$translate['spanish'].'</option>';
								} else { 
									$d_idioma=$query->datos_idioma_por_abreviatura($_GET['idiomas']);
									
									if ($_SESSION['id_language'] > 0) {
                                        echo '<option value="'.$d_idioma['idioma_abrev'].'" selected="selected">'.$d_idioma['idioma_'.$_SESSION['language'].''].'</option>';
                                    } else {
                                        echo '<option value="'.$d_idioma['idioma_abrev'].'" selected="selected">'.$d_idioma['idioma'].'</option>';
                                    }
								}
								echo '<option value="">'.$translate['cualquiera'].'</option>';
							} else { ?>
                           		<option value="" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                           <option value="es"><?php echo $translate['spanish']; ?></option>
                           <?php while ($row_idiomas=mysql_fetch_array($idiomas)) {  
                            
                                    if ($_SESSION['id_language'] > 0) {
                                        echo '<option value="'.$row_idiomas['idioma_abrev'].'">'.$row_idiomas['idioma_'.$_SESSION['language'].''].'</option>';
                                    } else {
                                        echo '<option value="'.$row_idiomas['idioma_abrev'].'">'.$row_idiomas['idioma'].'</option>';
                                    }
                            } ?>
                         </select>
                    </div>
          
        	</div>


             
             </div>                    <input name="button" type="submit" class="boton_grande" id="button" value="<?php echo $translate['buscar']; ?>" />        
              <div>
             
           </div>
          </div>
         </div>
         </form>
         <?php } elseif ((!isset($_GET['buscador']) && !isset($_GET['id_eu'])) || (isset($_GET['buscador']) && $_GET['buscador']==2)) { ?>
         <ul id="thelist10">
           <?php
		   while ($row_tsf=mysql_fetch_array($tm)) { 
		   ?>
             <li id="thelist10" <?php if (isset($_GET['id_tipo_eu']) && $_GET['id_tipo_eu']==$row_tsf['id_tipo_eu']) {  echo 'style="border: 2px solid #F00;"'; } ?>><a href="<?php echo $pagina; ?>?busqueda=basico&buscador=2&id_tipo_eu=<?php echo $row_tsf['id_tipo_eu']; ?>"><img src="images/<?php echo $row_tsf['imagen_tipo_eu']; ?>" alt="<?php echo $row_tsf['tipo_eu']; ?>" title="<?php echo $row_tsf['tipo_eu']; ?>" width="75" height="75" /></a><br /><a href="<?php echo $pagina; ?>?busqueda=basico&buscador=2&id_tipo_eu=<?php echo $row_tsf['id_tipo_eu']; ?>"><?php if ($_SESSION['id_language'] > 0) { echo $row_tsf['tipo_eu_'.$_SESSION['language'].'']; } else { echo $row_tsf['tipo_eu']; } ?></a></li>
           <?php }  ?> 
             </ul>
    	<?php }  ?>             
         <div id="materiales">
           <?php if (isset($_GET['id_eu']) && $_GET['id_eu'] > 0) {  
            
                $row=$query->datos_eu2($_GET['id_eu']);
            ?>
           <br  />
           <div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
           <div class="separador_verde"><?php if ($_SESSION['id_language'] > 0) { echo $row['eu_titulo_'.$_SESSION['language'].'']; } else {echo $row['eu_titulo']; } ?></div><br />
            <div id="tabla2">
            	<div id="tabla2_celda1">
                    <p>    
                    	  <?php if ($row['eu_descripcion'] !='') { ?>
                          <strong><?php echo $translate['descripcion']; ?>:</strong> <br />
                            <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_descripcion_'.$_SESSION['language'].'']; } else { echo $row['eu_descripcion']; } ?><br />
                          <br />
                          <?php } ?>
                          
						  
						  <?php if ($row['eu_objetivo'] !='') { ?>
                          <strong><?php echo $translate['eu_objetivo']; ?>:</strong> <br />
                            <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_objetivo_'.$_SESSION['language'].'']; } else {echo $row['eu_objetivo']; } ?><br />
                          <br />
                          <?php } ?>
                          <?php if ($row['eu_informacion_adicional'] !='') { ?>
                          <strong><?php echo $translate['informacion_adicional']; ?>:</strong> <br />
                            <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_informacion_adicional_'.$_SESSION['language'].'']; } else {echo $row['eu_informacion_adicional']; } ?><br />
                          <?php } ?>
                            <?php if ($row['eu_precio'] !='') { ?>
                            <br />
                            <strong><?php echo $translate['precio']; ?>:</strong><br />
                            <?php echo $row['eu_precio']; ?>
                            <?php } ?>
					  </p>                           
                    </p>
                </div>
                
                <div id="tabla2_celda2">
                
                  <strong>Autor/es:</strong> <br />
                  <?php 
                   $mau=str_replace('}{',',',$row['eu_autor']);
                      $mau=str_replace('{','',$mau);
                      $mau=str_replace('}','',$mau);
                      $mau=explode(',',$mau);
                      
                      for ($i=0;$i<count($mau);$i++) { 
                        if ($mau[$i]!='') {
                         $data_autor=$query->datos_autor($mau[$i]);
                         echo utf8_encode($data_autor['autor']).'<br />'; 
                        }
                      }
                    ?>
                  <br />
                   <!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
				<g:plusone size="tall" href="http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>"></g:plusone>
                <br />
                  <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>" data-text="<?php echo $row['eu_titulo']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><br />
                 <div class="fb-like" data-href="http://arasaac.org/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>" data-send="true" data-layout="box_count" data-width="450" data-show-faces="true"></div>
                 <br /><br />                  <?php if ($row['eu_url1'] != NULL || $row['eu_url2'] != NULL || $row['eu_url1'] != NULL) { ?>
                  <strong><?php echo $translate['paginas_web']; ?>:</strong> <br />
                  <?php
				  if ($row['eu_url1'] != NULL) { 
				  echo "<a href=\"".$row['eu_url1']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url1']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url1']."\"></a> <a href=\"".$row['eu_url1']."\" target=\"_blank\">".$row['eu_url1']."</a><br />";
				  }
				  ?>
                  <?php
				  if ($row['eu_url2'] != NULL) { 
				  echo "<a href=\"".$row['eu_url2']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url2']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url2']."\"></a> <a href=\"".$row['eu_url2']."\" target=\"_blank\">".$row['eu_url2']."</a><br />";
				  }
				  ?>
                  <?php
				  if ($row['eu_url3'] != NULL) { 
				  echo "<a href=\"".$row['eu_url3']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url3']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url3']."\"></a> <a href=\"".$row['eu_url3']."\" target=\"_blank\">".$row['eu_url3']."</a><br />";
				  }
				  ?>
                  <br />
                  <?php }  ?>
                  <?php if ($row['eu_archivos'] != NULL) { ?>
                  <strong><?php echo $translate['archivo_s']; ?>:</strong> <br />
                  <br />
                  <?php 
                    $ma=str_replace('}{',',',$row['eu_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
						 $archivo='zona_descargas/ejemplos_uso/'.$_GET['id_eu'].'/'.$ma[$i];
						 $ruta_cesto='ruta_cesto=zona_descargas/ejemplos_uso/'.$_GET['id_eu'].'/'.$ma[$i];
						 $encript->encriptar($ruta_cesto,1);
						 
                         echo "<a href=\"".$PHP_SELF."?".$cadena_url."product_id=".$ruta_cesto."\"><img src=\"images/add_4.png\" alt=\"".$translate['add_seleccion']."\" title=\"".$translate['add_seleccion']."\"></a>&nbsp;<a href=\"descargar.php?d=".$archivo."\"><img src=\"images/download_5.png\" alt=\"".$translate['descargar_sofware']."\" title=\"".$translate['descargar_sofware']."\"></a>&nbsp;&nbsp;<a href=\"".$archivo."\" target=\"_blank\">".$ma[$i]."</a>";
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								echo '&nbsp;('.tamano_archivo($peso_archivo).')';
						 }
						 
						 echo '<br /><br />'; 
                        }
                      }
                      
                  ?><br /> 
                  <?php }  ?>
                            <?php if ($row['eu_capturas'] !='') { ?>
                            <br />
                            <strong><?php echo $translate['capturas_pantalla']; ?>:</strong><br />
          					<div id="<?php echo $row['id_eu']; ?>">
                            <?php 
							   	$mcp=str_replace('}{',',',$row['eu_capturas']);
								$mcp=str_replace('{','',$mcp);
								$mcp=str_replace('}','',$mcp);
								$mcp=explode(',',$mcp);
								  
								  for ($i=0;$i<count($mcp);$i++) { 
									if ($mcp[$i]!='') {
									 echo "<img src=\"zona_descargas/ejemplos_uso/".$_GET['id_eu']."/screenshot/".$mcp[$i]."\"><br />"; 
									}
								  }
								?>
                            
                            </div>
                            <script>
								Galleria.loadTheme('js/galleria/themes/classic/galleria.classic.min.js');
								$("#<?php echo $row['id_eu']; ?>").galleria({
									width: 400,
									height: 300
								});
							</script>
						<?php } ?>     
                </div>
            </div>

            <br />
            <strong><a  href="javascript:void();" onClick="Effect.BlindDown('eu_<?php echo $row['id_eu'] ?>');; return false;" ><?php echo $translate['datos_clasificacion']; ?></a></strong>
            
             <div id="eu_<?php echo $row['id_eu'] ?>" style="display:block;"><br  />     
              <div id="tabla3">
              	<div id="tabla3_header">
              	  <div id="tabla3_celda2">
                   	  <strong><?php echo $translate['idiomas']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<strong><?php echo $translate['area']; ?>:</strong>
                    </div>

                    
                </div>
                
             	 <div id="tabla3_row">
             	   <div id="tabla3_celda2">
                        <?php 
                              $mid=str_replace('}{',',',$row['eu_idiomas']);
                              $mid=str_replace('{','',$mid);
                              $mid=str_replace('}','',$mid);
                              $mid=explode(',',$mid);
                              
                              for ($i=0;$i<count($mid);$i++) { 
                                if ($mid[$i]!='') {
                                    if ($mid[$i]=='es') {
                                        echo $translate['spanish']. ' <img src="images/spain-flag-icon.png"  alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'"><br />';
                                    } else {
                                        $data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
                                            if ($_SESSION['language']=='es') { 
                                                echo $data_idioma['idioma'].' <img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'"><br />';
                                            } else {
                                                echo $data_idioma['idioma_'.$_SESSION['language'].''].' <img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'"><br />';
                                            }
                                    } 
                                }
                              }
                            ?>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<?php 
						  $mt=str_replace('}{',',',$row['eu_tipo']);
						  $mt=str_replace('{','',$mt);
						  $mt=str_replace('}','',$mt);
						  $mt=explode(',',$mt);
						  
						  for ($i=0;$i<count($mt);$i++) { 
							if ($mt[$i]!='') {
							 $data_tipo=$query->datos_eu_tipo($mt[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo '<a href="'.$pagina.'?busqueda=basico&buscador=2&id_tipo_eu='.$data_tipo['id_tipo_eu'].'">'.$data_tipo['tipo_eu_'.$_SESSION['language'].''].'</a><br />'; 
								} else {
									echo '<a href="'.$pagina.'?busqueda=basico&buscador=2&id_tipo_eu='.$data_tipo['id_tipo_eu'].'">'.$data_tipo['tipo_eu'].'</a><br />'; 
								}
							}
						  }
					  ?>
                    </div>
           	    </div>
              
              </div>
             
             </div>
             <br />
            <div class="informacion">
             <div style="float:left"><a href="?id_eu=<?php echo $row['id_eu']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16"  title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_eu=<?php echo $row['id_eu']; ?>"><?php echo $translate['enlace_permanente']; ?></a></div>
			<div style="float:right"><?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?></div>
             </div>  
           </div>
            
           <?php } else {  echo $mensaje;  
                
                if ($total_records > 0 ) {
            
                while ($row=mysql_fetch_array($resultados)) {  
            
                $i++;
                
                if ($pg == 0 && $i==1) { ?>
                    
         <div class="material" <?php if ($row['eu_destacado']==1) { echo 'style="border:3px solid #FF3;"'; } ?>">
           <div class="separador_verde"><?php if ($_SESSION['id_language'] > 0) { echo $row['eu_titulo_'.$_SESSION['language'].'']; } else {echo $row['eu_titulo']; } ?></div><br />
            <div id="tabla2">
           	  <div id="tabla2_celda1">
    <div id="tabla5">
                      <div id="tabla2_celda3">
                        <p>
                          <?php if ($row['eu_descripcion'] !='') { ?>
                          <strong><?php echo $translate['descripcion']; ?>:</strong> <br />
                          <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_descripcion_'.$_SESSION['language'].'']; } else {echo $row['eu_descripcion']; } ?>
                          <br />
                          <br />
                          <?php } ?>
                          <?php if ($row['eu_objetivo'] !='') { ?>
                          <strong><?php echo $translate['eu_objetivo']; ?>:</strong> <br />
                          <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_objetivo_'.$_SESSION['language'].'']; } else {echo $row['eu_objetivo']; } ?>
                          <br />
                          <br />
                          <?php } ?>
                          <?php if ($row['eu_informacion_adicional'] !='') { ?>
                          <strong><?php echo $translate['informacion_adicional']; ?>:</strong> <br />
                          <?php if ($_SESSION['id_language'] > 0) { echo $row['eu_informacion_adicional_'.$_SESSION['language'].'']; } else {echo $row['eu_informacion_adicional']; } ?>
                          <br />
                          <?php } ?>
                          <?php if ($row['eu_precio'] !='') { ?>
                          <br />
                          <strong><?php echo $translate['precio']; ?>:</strong><br />
                          <?php echo $row['eu_precio']; ?>
                          <?php } ?>
                          
                        </p>
                      </div>
            </div>
           	  </div>
                
                <div id="tabla2_celda2"><strong>Autor/es:</strong> <br />
                  <?php 
                   $mau=str_replace('}{',',',$row['eu_autor']);
                      $mau=str_replace('{','',$mau);
                      $mau=str_replace('}','',$mau);
                      $mau=explode(',',$mau);
                      
                      for ($i=0;$i<count($mau);$i++) { 
                        if ($mau[$i]!='') {
                         $data_autor=$query->datos_autor($mau[$i]);
                         echo utf8_encode($data_autor['autor']).'<br />'; 
                        }
                      }
                    ?>
                  <br />
                  <!-- Coloca esta etiqueta donde quieras que se muestre el botón +1. -->
                  <g:plusone size="tall" href="http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>"></g:plusone>
                  <br />
                  <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>" data-text="<?php echo $row['eu_titulo']; ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
                  <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                  <br />
                  <div class="fb-like" data-href="http://arasaac.org/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>" data-send="true" data-layout="box_count" data-width="450" data-show-faces="true"></div>
                  <br />
                  <br />
                  <?php if ($row['eu_url1'] != NULL || $row['eu_url2'] != NULL || $row['eu_url1'] != NULL) { ?>
                  <strong><?php echo $translate['paginas_web']; ?>:</strong> <br />
                  <?php
				  if ($row['eu_url1'] != NULL) { 
				  echo "<a href=\"".$row['eu_url1']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url1']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url1']."\"></a> <a href=\"".$row['eu_url1']."\" target=\"_blank\">".$row['eu_url1']."</a><br />";
				  }
				  ?>
                  <?php
				  if ($row['eu_url2'] != NULL) { 
				  echo "<a href=\"".$row['eu_url2']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url2']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url2']."\"></a> <a href=\"".$row['eu_url2']."\" target=\"_blank\">".$row['eu_url2']."</a><br />";
				  }
				  ?>
                  <?php
				  if ($row['eu_url3'] != NULL) { 
				  echo "<a href=\"".$row['eu_url3']."\" target=\"_blank\"><img src=\"images/weblink_icon.jpg\" alt=\"".$translate['visit_webpage'].": ".$row['eu_url3']."\" title=\"".$translate['visit_webpage'].": ".$row['eu_url3']."\"></a> <a href=\"".$row['eu_url3']."\" target=\"_blank\">".$row['eu_url3']."</a><br />";
				  }
				  ?>
                  <br />
                  <?php }  ?>
                  <?php if ($row['eu_archivos'] != NULL) { ?>
                  <strong><?php echo $translate['archivo_s']; ?>:</strong> <br />
                  <br />
                  <?php 
                    $ma=str_replace('}{',',',$row['eu_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
						 $archivo='zona_descargas/ejemplos_uso/'.$row['id_eu'].'/'.$ma[$i];
						 $ruta_cesto='ruta_cesto=zona_descargas/ejemplos_uso/'.$row['id_eu'].'/'.$ma[$i];
						 $encript->encriptar($ruta_cesto,1);
						 
                         echo "<a href=\"".$PHP_SELF."?".$cadena_url."product_id=".$ruta_cesto."\"><img src=\"images/add_4.png\" alt=\"".$translate['add_seleccion']."\" title=\"".$translate['add_seleccion']."\"></a>&nbsp;<a href=\"descargar.php?d=".$archivo."\"><img src=\"images/download_5.png\" alt=\"".$translate['descargar_sofware']."\" title=\"".$translate['descargar_sofware']."\"></a>&nbsp;&nbsp;<a href=\"".$archivo."\" target=\"_blank\">".$ma[$i]."</a>";
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								echo '&nbsp;('.tamano_archivo($peso_archivo).')';
						 }
						 
						 echo '<br /><br />'; 
                        }
                      }
                      
                  ?>
                  <br /> 
                  <?php }  ?>  
                          <?php if ($row['eu_capturas'] !='') { ?>
                            <br />
                            <strong><?php echo $translate['capturas_pantalla']; ?>:</strong><br />
                            <div id="<?php echo $row['id_eu']; ?>">
                            <?php 
							   	$mcp=str_replace('}{',',',$row['eu_capturas']);
								$mcp=str_replace('{','',$mcp);
								$mcp=str_replace('}','',$mcp);
								$mcp=explode(',',$mcp);
								  
								  for ($i=0;$i<count($mcp);$i++) { 
									if ($mcp[$i]!='') {
									 echo "<img src=\"zona_descargas/ejemplos_uso/".$row['id_eu']."/screenshot/".$mcp[$i]."\"><br />"; 
									}
								  }
								?>
                            
                            </div>
                            <script>
								Galleria.loadTheme('js/galleria/themes/classic/galleria.classic.min.js');
								$("#<?php echo $row['id_eu']; ?>").galleria({
									width: 400,
									height: 300
								});
							</script>
							<?php } ?>   
                </div>
            </div>

            <br />
            <strong><?php echo $translate['datos_clasificacion']; ?></strong>
            
             <div id="eu_<?php echo $row['id_eu'] ?>" style="display:block;"><br  />     
              <div id="tabla3">
              	<div id="tabla3_header">
              	  <div id="tabla3_celda2">
                   	  <strong><?php echo $translate['idiomas']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<strong><?php echo $translate['area']; ?>:</strong>
                    </div>
                    
                </div>
                
             	 <div id="tabla3_row">
             	   <div id="tabla3_celda2">
                        <?php 
                              $mid=str_replace('}{',',',$row['eu_idiomas']);
                              $mid=str_replace('{','',$mid);
                              $mid=str_replace('}','',$mid);
                              $mid=explode(',',$mid);
                              
                              for ($i=0;$i<count($mid);$i++) { 
                                if ($mid[$i]!='') {
                                    if ($mid[$i]=='es') {
                                        echo $translate['spanish']. ' <img src="images/spain-flag-icon.png"  alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'"><br />';
                                    } else {
                                        $data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
                                            if ($_SESSION['language']=='es') { 
                                                echo $data_idioma['idioma'].' <img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'"><br />';
                                            } else {
                                                echo $data_idioma['idioma_'.$_SESSION['language'].''].' <img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'"><br />';
                                            }
                                    } 
                                }
                              }
                            ?>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<?php 
						  $mt=str_replace('}{',',',$row['eu_tipo']);
						  $mt=str_replace('{','',$mt);
						  $mt=str_replace('}','',$mt);
						  $mt=explode(',',$mt);
						  
						  for ($i=0;$i<count($mt);$i++) { 
							if ($mt[$i]!='') {
							 $data_tipo=$query->datos_eu_tipo($mt[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo '<a href="'.$pagina.'?busqueda=basico&buscador=2&id_tipo_eu='.$data_tipo['id_tipo_eu'].'">'.$data_tipo['tipo_eu_'.$_SESSION['language'].''].'</a><br />'; 
								} else {
									echo '<a href="'.$pagina.'?busqueda=basico&buscador=2&id_tipo_eu='.$data_tipo['id_tipo_eu'].'">'.$data_tipo['tipo_eu'].'</a><br />'; 
								}
							}
						  }
					  ?>
                    </div>
           	    </div>
              
              </div>
             
             </div>
             <br />
            <div class="informacion">
             <div style="float:left"><a href="?id_eu=<?php echo $row['id_eu']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16"  title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_eu=<?php echo $row['id_eu']; ?>"><?php echo $translate['enlace_permanente']; ?></a></div>
			<div style="float:right"><?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?></div>
             </div>   
           </div>
                 
           <?php } else {
			/* $date_sin_hora=explode(" ",$row['fecha_alta']);
            $date=explode("-",$date_sin_hora[0]);
            $fecha_publicacion=$date[2].'-'.$date[1].'-'.$date[0];
            $publicado_hace=intval(compara_fechas($hoy,$fecha_publicacion)/86400); */
            ?>
           <div class="material" style="padding:10px;  margin-bottom:15px;<?php if ($row['eu_destacado']==1) { echo "border:2px solid #FF3;"; } else { echo "border:1px solid #CCCCCC;"; } ?> background-color:#FFFEF0;">
             <div id="tabla4">
           		<div id="tabla4_header">
                	<div id="tabla4_celda1"><a href="?id_eu=<?php echo $row['id_eu']; ?>"><strong><?php if ($_SESSION['id_language'] > 0) { echo $row['eu_titulo_'.$_SESSION['language'].'']; } else {echo $row['eu_titulo']; } ?></strong></a>
                   <?php 
                      $mid=str_replace('}{',',',$row['eu_idiomas']);
                      $mid=str_replace('{','',$mid);
                      $mid=str_replace('}','',$mid);
                      $mid=explode(',',$mid);
                      
                      for ($i=0;$i<count($mid);$i++) { 
                        if ($mid[$i]!='') {
                            if ($mid[$i]=='es') {
                                echo '<img src="images/spain-flag-icon.png"  alt="'.$translate['spanish'].'" title="'.$translate['spanish'].'">&nbsp;';
                            } else {
                                $data_idioma=$query->datos_idioma_por_abreviatura($mid[$i]);
                                    if ($_SESSION['language']=='es') { 
                                        echo '<img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma'].'" title="'.$data_idioma['idioma'].'">&nbsp;';
                                    } else {
                                        echo '<img src="images/'.$data_idioma['img_flag'].'"  alt="'.$data_idioma['idioma_'.$_SESSION['language'].''].'" title="'.$data_idioma['idioma_'.$_SESSION['language'].''].'">&nbsp;';
                                    }
                            } 
                        }
                      }
                    ?></div>	
               	    <div id="tabla4_celda2"><?php 
                   $mau=str_replace('}{',',',$row['eu_autor']);
                      $mau=str_replace('{','',$mau);
                      $mau=str_replace('}','',$mau);
                      $mau=explode(',',$mau);
                      
                      for ($i=0;$i<count($mau);$i++) { 
                        if ($mau[$i]!='') {
                         $data_autor=$query->datos_autor($mau[$i]);
                         echo utf8_encode($data_autor['autor']).'<br />'; 
                        }
                      }
                    ?>
                    </div>
                    <div id="tabla4_celda3"><?php echo $row['fecha_alta']; ?></div>
               </div>
               </div>
               
               <br />
				<div id="tabla4">
				<?php if ($_SESSION['id_language'] > 0) { echo $row['eu_descripcion_'.$_SESSION['language'].'']; } else {echo $row['eu_descripcion']; } ?>
                </div>
                <br />
                
                <div id="tabla4">
                <div id="tabla4_row_crema">
               		<div id="tabla4_celda1"><a href="?id_eu=<?php echo $row['id_eu']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_eu=<?php echo $row['id_eu']; ?>"><?php echo $translate['enlace_permanente']; ?></a>&nbsp;|&nbsp;<a href="http://twitter.com/share?url=http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>&text=<?php echo $row['eu_titulo']; ?>&original_referer=http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>&via=arasaac" target="_blank"><img src="images/twitter_icon.jpg" border="0"></a> | <div class="fb-like" data-href="http://arasaac.org/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div> | <g:plusone size="small" href="http://catedu.es/arasaac/<?php echo $pagina; ?>?id_eu=<?php echo $row['id_eu']; ?>"></g:plusone> </div>
               		<div id="tabla4_celda2">&nbsp;</div>
                    <div id="tabla4_celda3"><a href="?id_eu=<?php echo $row['id_eu']; ?>">(+<?php echo $translate['ampliar_informacion']; ?>)</a> </div>
                </div>
                
           </div>
           
           </div>
           <?php } } } // Cierro el While y el IF ?>
           
           <?php if (isset($n_resultados) && $n_resultados > 0) { ?>
           <div id="resultados_materiales"><strong><?php echo $translate['ejemplos_de_uso']; ?>: </strong><?php echo $inicial ?> <?php echo $translate['a']; ?> <?php echo $inicial+$cantidad ?> <?php echo $translate['de']; ?> <?php echo $total_records ?><br /> 
               <?php  
			   		//Con este código elimino la variable pg que es dinamica
			   		$str = $_SERVER['QUERY_STRING'];
					parse_str($str, $info);
					unset($info['pg']);
					$cadena_url=http_build_query($info);
					if ($cadena_url !='') { $cadena_url=http_build_query($info).'&'; }
					//************************************************************
					
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

                    $content.= "<a href=\"".$PHP_SELF."?pg=0&".$cadena_url."\"><< </a>&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"><<</span>';
                    
                    }
                    
                    // Pagina anterior
                    if($pg > 0) { 
                    
                    $prev = ($pg - 1);
                    $content.= "<a href=\"".$PHP_SELF."?".$cadena_url."pg=".$prev."\"> <</a>&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled">< </span>';
                    
                    }
                    
                    // Paginacion
                    if($total_pages >= $limitpages) {
                    
                        for($i = $page_start-$limite_inferior; ($i <= $total_pages & $i <=$page_limit); $i++) {
                        
                            if(($i) >= 0) { 	
                                if(($pg) == $i) { 
                                
                                $content.= '<span class="current">'.$i.'</span>&nbsp;';
                                
                                } else {
                                
                                $content.= "<a href=\"".$PHP_SELF."?".$cadena_url."pg=".$i."\">".$i."</a>&nbsp;";
                                }
                            }
                        
                        } // Cierro el FOR
                    
                    } else {
                    
                        for($i = 0; $i <= $total_pages; $i++) {
                        
                            if(($pg) == $i) {
                            
                            $content.= '<span class="current">'.$i.'</span>&nbsp;';
                            
                            } else {
                            
                            $content.= "<a href=\"".$PHP_SELF."?".$cadena_url."pg=".$i."\">".$i."</a>&nbsp;";
                        
                        } // Cierro el FOR
                        
                    } // Cierro el IF
                    
                    }
                    
                    // Siguiente página
                    if($pg < $total_pages) {
                    
                    $next = ($pg + 1);
                    $content.= "<a href=\"".$PHP_SELF."?".$cadena_url."pg=".$next."\"> ></a>&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> ></span>';
                    
                    }
                    
                    // Ultima página
                    if($pg < $total_pages)
                    {
                    
                    $last = $total_pages;
                    $content.= "<a href=\"".$PHP_SELF."?".$cadena_url."pg=".$last."\">  >></a>&nbsp;";
                    
                    } else {
                    
                    $content.= '<span class="disabled"> >></span>';
                    
                    }
                    
                    
                    $content.= "</p></div>";
                    
                    echo $content;
                    ?>
             </div>
             <?php } ?>
             <br />
           <?php } // Cierro el IF de comprobacion de si esta establecido $_POST['i'] ?>
         </div>
</div>
<?php include ('footer.php'); ?>
</div>   
<?php include('google_stats.html'); ?>
</body>
</html>

