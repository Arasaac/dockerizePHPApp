<?php 
require('requires_basico_sin_sesion.php');
require('operaciones_cesto.php');
require('funciones/funciones.php');
require('configuration/key.inc');
require('classes/crypt/5CR.php');
$encript = new E5CR($llave);

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
				
			$texto_buscar=utf8_decode($_GET['titulo_descripcion_basico']);
			$licencia=2;
			
			if (isset($_GET['area_curricular_basico']) && $_GET['area_curricular_basico'] > 0) {  $sql.="AND material_area_curricular LIKE '%{".$_GET['area_curricular_basico']."}%' ";  }
			if (isset($_GET['subarea_curricular_basico']) && $_GET['subarea_curricular_basico'] > 0) {  $sql.="AND material_subarea_curricular LIKE '%{".$_GET['subarea_curricular_basico']."}%' ";  }
			if (isset($_GET['tipo_basico']) && $_GET['tipo_basico'] > 0) {  $sql.="AND material_tipo LIKE '%{".$_GET['tipo_basico']."}%' ";  }
			if (isset($_GET['dirigido_basico']) && $_GET['dirigido_basico'] > 0) {  $sql.="AND material_dirigido LIKE '%{".$_GET['dirigido_basico']."}%' ";  }
			if (isset($_GET['nivel_basico']) && $_GET['nivel_basico'] > 0) {  $sql.="AND material_nivel LIKE '%{".$_GET['nivel_basico']."}%' ";  }
			if (isset($_GET['saa_basico']) && $_GET['saa_basico'] > 0) {  $sql.="AND material_saa LIKE '%{".$_GET['saa_basico']."}%' ";  }
			if (isset($_GET['idiomas_basico']) && $_GET['idiomas_basico'] !='') {  $sql.="AND material_idiomas LIKE '%{".$_GET['idiomas_basico']."}%' "; }
			
			if (isset($_GET['autor_basico']) && $_GET['autor_basico'] !='') {
				$autores=$query->buscar_autores_nombre(utf8_decode($_GET['autor_basico']));
				
					while ($row_autor=mysql_fetch_array($autores)) {
					
						$sql.="AND material_autor LIKE '%{".$row_autor['id_autor']."}%' "; 
					
					}
			}
			
			$contar=$query->buscar_materiales($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql);
			
				
			if ($contar==false) { 
			
				$mensaje='<div align="center" style="color:#FF0000"><img src="images/error.gif" alt="'.$translate['no_resultados_criterios'].'" title="'.$translate['no_resultados_criterios'].'"><br />'.$translate['no_resultados_criterios'].'.</div>';
			
			} else {
			
			$resultados=$query->buscar_materiales_limit($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql,$inicial,$cantidad);
			
			$total_records = $contar;
			$total_pages = intval($total_records / $cantidad);
			
			$n_resultados=$contar;
			
			$mensaje='<br /><h4>'.$translate['resultados_busqueda_materiales'].' ('.$n_resultados.'):</h4><br />
<p class="alineacion_derecha"><a href="rss/subscripcion.php?t=1&titulo_descripcion='.$_POST['titulo_descripcion'].'&area_curricular='.$_POST['area_curricular'].'&subarea_curricular='.$_POST['subarea_curricular'].'&tipo='.$_POST['tipo'].'&dirigido='.$_POST['dirigido'].'&nivel='.$_POST['nivel'].'&saa='.$_POST['saa'].'&autor='.$_POST['autor'].'" target="_blank">   '.$translate['subscribirse_resultados_busqueda'].'</a>&nbsp;<a href="rss/subscripcion.php?t=1&titulo_descripcion='.$_POST['titulo_descripcion'].'&area_curricular='.$_POST['area_curricular'].'&subarea_curricular='.$_POST['subarea_curricular'].'&tipo='.$_POST['tipo'].'&dirigido='.$_POST['dirigido'].'&nivel='.$_POST['nivel'].'&saa='.$_POST['saa'].'&autor='.$_POST['autor'].'" target="_blank"><img src="images/feed.png" alt="'.$translate['subscribirse_resultados_busqueda'].'" title="'.$translate['subscribirse_resultados_busqueda'].'" ></a></p><br />';
			
			}
		
	} elseif (isset($_GET['busqueda']) && $_GET['busqueda']=='avanzado'){
		
		if (!isset($_GET['pg'])) {
			$pg = 0; // $pg es la pagina actual
		} else { $pg=$_GET['pg']; }
		
		$inicial = $pg * $cantidad;
				
		$limite_inferior="5"; //resultados por debajo de la pagina actual
		$page_limit = $limite_inferior;	
		$limitpages = $page_limit;
		$page_limit = $pg + $limitpages;
		$texto_buscar=$_GET['texto_buscar'];
		$licencia=2;
		
		if (isset($_GET['area_curricular']) && $_GET['area_curricular'] !='') {
			foreach($_GET['area_curricular'] as $nombre_campo => $valor) {
				if ($valor != '') {
					$sql.="AND material_area_curricular LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['subarea_curricular']) && $_GET['subarea_curricular'] !='') {
			foreach( $_GET['subarea_curricular'] as $nombre_campo => $valor) {
				if ($valor != '') {
					$sql.="AND material_subarea_curricular LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['idiomas']) && $_GET['idiomas'] !='') {
			foreach( $_GET['idiomas'] as $nombre_campo => $valor) {
				if ($valor != '') {
					
					$sql.="AND material_idiomas LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['tipo']) && $_GET['tipo'] !='') {
			foreach( $_GET['tipo'] as $nombre_campo => $valor) {
				if ($valor != '') {
					
					$sql.="AND material_tipo LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['dirigido']) && $_GET['dirigido'] !='') {
			foreach( $_GET['dirigido'] as $nombre_campo => $valor) {
				if ($valor != '') {
					
					$sql.="AND material_dirigido LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['saa']) && $_GET['saa'] !='') {
			foreach( $_GET['saa'] as $nombre_campo => $valor) {
				if ($valor != '') {
					
					$sql.="AND material_saa LIKE '%{".$valor."}%'
					";
				}
			}
		}
		
		if (isset($_GET['nivel']) && $_GET['nivel'] !='') {
			foreach( $_GET['nivel'] as $nombre_campo => $valor) {
				if ($valor != '') {
					
					$sql.="AND material_nivel LIKE '%{".$valor."}%'
					";
				}
			}
		}
				
		$contar=$query->buscar_materiales($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql);
		
		if ($contar==false) { 
		
			$mensaje='<div align="center" style="color:#FF0000"><img src="images/error.gif" alt="'.$translate['no_resultados_criterios'].'" title="'.$translate['no_resultados_criterios'].'"><br />'.$translate['no_resultados_criterios'].'.</div>';
		
		} else {
		
		$resultados=$query->buscar_materiales_limit($_SESSION['AUTHORIZED'],$texto_buscar,$licencia,$sql,$inicial,$cantidad);
		$total_records = $contar;
		$total_pages = intval($total_records / $cantidad);
		
		$n_resultados=$contar;
		
		$mensaje='<br /><h4>'.$translate['resultados_busqueda_materiales'].' ('.$n_resultados.'):</h4><br /><br />';
		
		}
		
	}

} else { //ELSE del IF de comprobocación de si se está buscando

	if (!isset($_GET['pg'])) {
		$pg = 0; // $pg es la pagina actual
	} else { $pg=$_GET['pg']; }
					
		$inicial = $pg * $cantidad;
					
		$limite_inferior="5"; //resultados por debajo de la pagina actual
		$page_limit = $limite_inferior;
					
		$limitpages = $page_limit;
		$page_limit = $pg + $limitpages;
		
		$contar=$query->ultimos_materiales_publicados();
		$resultados=$query->ultimos_materiales_publicados_limit($inicial,$cantidad);
		$n_resultados=$contar;
		$total_records = $contar;
		$total_pages = intval($total_records / $cantidad);

	$mensaje='<br /><h4>'.$translate['ultimos_materiales_catalogo'].'</h4><br />';
	
} //Cierro el IF de comprobación de si se está buscando

$licencias=$query->listar_licencias();
$autores=$query->listar_autores();

$ac=$query->listar_areas_curriculares();
$ac_avanzado=$query->listar_areas_curriculares();

$dirigido=$query->listar_dirigido();
$dirigido_avanzado=$query->listar_dirigido();

//$edad=$query->listar_edad();

$nivel=$query->listar_nivel();
$nivel_avanzado=$query->listar_nivel();

$saa=$query->listar_saa();
$saa_avanzado=$query->listar_saa();

$tm=$query->listar_tipo_material();
$tm_avanzado=$query->listar_tipo_material();

$idiomas=$query->listar_idiomas();
$idiomas_avanzado=$query->listar_idiomas();

require('cabecera_html.php');

if (isset($_GET['id_material']) && $_GET['id_material'] > 0) {  
            
     $row=$query->ficha_material($_GET['id_material']);
	 echo '<title>ARASAAC - '.$translate['materiales'].': '.utf8_encode($row['material_titulo']).'</title>';
	 
} else {
	
	 echo '<title>ARASAAC: '.$translate['materiales'].'</title>';
	
}
?>
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
    <link rel="stylesheet" href="css/green_pagstyle.css" type="text/css" />
    <script type="text/javascript" src="js/ajax2.js"></script>
    <script type="text/javascript" src="js/prototype/prototype.js"> </script>
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

<body onload="cargar_div2('n_elementos_cesto.php','i=','n_cesto');">
           
<div class="body_content"> 
<?php include_once('include_facebook.php'); ?>
	  <div class="header">
  		<?php include('cabecera.php'); ?>
      </div>
      <?php include ('menu_principal.php'); ?>
      <br /><h4><?php echo $translate['materiales']; ?></h4>		
  	  <div id="principal">
      <div id="aviso">
        <img src="images/a_warning.gif" width="15" height="15" alt="<?php echo $translate['mensaje_aviso']; ?>" title="<?php echo $translate['mensaje_aviso']; ?>"> <?php echo $translate['colaborar_materiales']; ?>
       </div> 
       <br />
        <div id="materiales_encima_buscador">
  			<?php 
					//Con este código elimino la variable pg que es dinamica
			   		$str = $_SERVER['QUERY_STRING'];
					parse_str($str, $info);
					unset($info['buscador']);
					$cadena_url_buscador=http_build_query($info);
					if ($cadena_url_buscador !='') { $cadena_url_buscador=http_build_query($info).'&'; }
					//************************************************************
			
			include('barra_opciones_materiales_ajax.php');
			?>
  			


   	   <div id="loading">
                <div><img src="images/indicator.gif" alt="<?php echo $translate['cargando']; ?>" title="<?php echo $translate['cargando']; ?>"/></div>
       </div>
    </div>        
    <form id="search_materiales_basico" name="search_materiales_basico" action="<?php echo $PHP_SELF; ?>">
       <input id="hiddenStatusMenu" type="hidden" <?php if (isset($_GET['id_material']) && $_GET['id_material'] > 0) {  echo 'value="0"';  } else { echo 'value="1"'; } ?> />
       <input id="hiddenStatusMenu_avanzado" type="hidden" value="0" />
      <br  />
            
      <div id="busqueda_materiales">
      <?php if ((!isset($_GET['buscador']) && !isset($_GET['id_material'])) || (isset($_GET['buscador']) && $_GET['buscador']==1 )) {  ?>
        <div id="searchmenu">
		   <div id="cuadro_busqueda_materiales">
             <div id="flotar_derecha"><a href="materiales.php?<?php echo $cadena_url_buscador ?>buscador=0"><?php echo $translate['cerrar']; ?></a></div>
				 <div class="separador_verde"><?php echo $translate['buscador_basico_materiales']; ?>
				   <input name="busqueda" type="hidden" id="busqueda" value="basico" />
			       <input name="buscador" type="hidden" id="buscador" value="1" />
			 </div><br />
                 
             <div id="tabla1"> 
                <div id="tabla1_celda1"> 
                  <label for="titulo_descripcion_basico"><strong><?php echo $translate['titulo_descripcion_objetivos']; ?></strong></label>
                   <div class="suboption" id="so1">
                   		<input name="titulo_descripcion_basico" type="text" class="cuadro_busqueda_materiales" id="titulo_descripcion_basico" size="40" value="<?php if (isset($_GET['titulo_descripcion_basico']) && $_GET['titulo_descripcion_basico'] !='') { echo $_GET['titulo_descripcion_basico']; } ?>"/>
                   </div>
                   <label for="autor_basico"><strong><?php echo $translate['autor']; ?></strong></label>
                 	<div class="suboption" id="so3">
                  		 <input name="autor_basico" type="text" class="cuadro_busqueda_materiales" id="autor_basico" size="40" value="<?php if (isset($_GET['autor_basico']) && $_GET['autor_basico'] !='') { echo $_GET['autor_basico']; } ?>"/>
                	</div>
                    
                    <label for="idiomas_basico"><strong><?php echo $translate['idiomas']; ?></strong></label>
                       <div class="suboption" id="so2">
                         <select name="idiomas_basico" id="idiomas_basico">
                           <?php if (isset($_GET['idiomas_basico']) && $_GET['idiomas_basico'] !='') { 
						   		if ($_GET['idiomas_basico']=='es') {
									echo '<option value="es" selected="selected">'.$translate['spanish'].'</option>';
								} else { 
									$d_idioma=$query->datos_idioma_por_abreviatura($_GET['idiomas_basico']);
									
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
                
                <div id="tabla1_celda2">
                   <label for="area_curricular_basico"><strong><?php echo $translate['area']; ?></strong></label>
                     <div class="suboption" id="so1">
                       <select name="area_curricular_basico" id="area_curricular_basico" onChange="cargar_div2('inc/public/listar_subareas.php','id_area='+document.search_materiales_basico.area_curricular_basico.value+'','subareas');">
                           <?php if (isset($_GET['area_curricular_basico']) && $_GET['area_curricular_basico'] >0) { 
						   		$d_ac=$query->datos_material_ac($_GET['area_curricular_basico']);
								
                                if ($_SESSION['id_language'] > 0) {
                                
                                    echo '<option value="'.$d_ac['id_ac_material'].'" selected="selected">'.$d_ac['ac_material_'.$_SESSION['language'].''].'</option>';
                                    
                                } else {
                                
                                    echo '<option value="'.$d_ac['id_ac_material'].'" selected="selected">'.$d_ac['ac_material'].'</option>';
                                }
									echo '<option value="0">'.$translate['cualquiera'].'</option>';
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                         <?php while ($row_ac=mysql_fetch_array($ac)) {  
                                if ($_SESSION['id_language'] > 0) {
                                
                                    echo '<option value="'.$row_ac['id_ac_material'].'">'.$row_ac['ac_material_'.$_SESSION['language'].''].'</option>';
                                    
                                } else {
                                
                                    echo '<option value="'.$row_ac['id_ac_material'].'">'.$row_ac['ac_material'].'</option>';
                                }
                         } ?>
                       </select>
                 </div>
                 <div id="subareas">
                 <?php if (isset($_GET['subarea_curricular_basico']) && $_GET['subarea_curricular_basico'] >0) { 
				 	$id_area=$_GET['area_curricular_basico'];
					$listado_subareas=$query->listar_subareas_curriculares($id_area); 
					
					if (mysql_num_rows($listado_subareas) > 0 ) {

						echo '<label><strong>'.$translate['subarea'].'</strong></label>
							<div class="suboption" id="so2">
							<select name="subarea_curricular_basico" id="subarea_curricular_basico" realname="Subarea">';
								echo '<option value="0">'.$translate['cualquiera'].'</option>';
								while ($row=mysql_fetch_array($listado_subareas)) {
													
									echo '<option value="'.$row['id_subac_material'].'"';
									
										if ($_GET['subarea_curricular_basico']==$row['id_subac_material']) { echo 'selected="selected"'; }
										
									echo '>';
									
										if ($_SESSION['id_language'] > 0) {
											echo $row['subac_material_'.$_SESSION['language'].''];
										} else {
											echo $row['subac_material'];
										}
									echo '</option>'; 
								
								}
							 
						echo '</select></div>';
						} else {
						
							echo '<input name="subarea_curricular_basico" type="hidden" value="0" />';
						}
					?>
                 
                 <?php } else { ?>
                 <input name="subarea_curricular_basico" type="hidden" value="0" />
                 <?php } ?>
                 </div>
                 <label for="tipo_basico"><strong><?php echo $translate['tipo']; ?></strong></label>
                     <div class="suboption" id="so1">
                         <select name="tipo_basico" id="tipo_basico" realname="Tipo de Material">
                         <?php if (isset($_GET['tipo_basico']) && $_GET['tipo_basico'] >0) { 
						   		$d_tipo=$query->datos_material_tipo($_GET['tipo_basico']);
								
                                    if ($_SESSION['id_language'] > 0) {
                                        echo '<option value="'.$d_tipo['id_tipo_material'].'" selected="selected">'.$d_tipo['tipo_material_'.$_SESSION['language'] .''].'</option>';	
                                    } else {
                                        echo '<option value="'.$d_tipo['id_tipo_material'].'" selected="selected">'.$d_tipo['tipo_material'].'</option>';
                                    }
									
									echo '<option value="0">'.$translate['cualquiera'].'</option>';
								
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                           <?php while ($row_tm=mysql_fetch_array($tm)) {  
                                    if ($_SESSION['id_language'] > 0) {
                                        echo '<option value="'.$row_tm['id_tipo_material'].'">'.$row_tm['tipo_material_'.$_SESSION['language'] .''].'</option>';	
                                    } else {
                                        echo '<option value="'.$row_tm['id_tipo_material'].'">'.$row_tm['tipo_material'].'</option>';
                                    }
                             } ?>
                       </select>
                 </div>
                </div>
                
                
                <div id="tabla1_celda3">
                  <label for="dirigido_basico"><strong><?php echo $translate['dirigido']; ?></strong></label>
                   <div class="suboption" id="so2">
                     <select name="dirigido_basico" id="dirigido_basico" realname="Dirigido a">
                           <?php if (isset($_GET['dirigido_basico']) && $_GET['dirigido_basico'] >0) { 
						   		$d_dirigido=$query->datos_material_dirigido($_GET['dirigido_basico']);
								
                                   if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$d_dirigido['id_dirigido_material'].'" selected="selected">'.$d_dirigido['dirigido_material_'.$_SESSION['language'].''].'</option>'; 
                                   } else {
                                    echo '<option value="'.$d_dirigido['id_dirigido_material'].'" selected="selected">'.$d_dirigido['dirigido_material'].'</option>'; 
                                   }
								   
								   echo '<option value="0">'.$translate['cualquiera'].'</option>';
								
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                       <?php while ($row_dirigido=mysql_fetch_array($dirigido)) { 
                                if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$row_dirigido['id_dirigido_material'].'">'.$row_dirigido['dirigido_material_'.$_SESSION['language'].''].'</option>'; 
                                } else {
                                    echo '<option value="'.$row_dirigido['id_dirigido_material'].'">'.$row_dirigido['dirigido_material'].'</option>'; 
                                }
                     } ?>
                     </select>
                   </div>
                   <label for="nivel_basico"><strong><?php echo $translate['nivel']; ?></strong></label>
                   <div class="suboption" id="so2">
                     <select name="nivel_basico" id="nivel_basico" required="1" realname="Nivel">
                          <?php if (isset($_GET['nivel_basico']) && $_GET['nivel_basico'] > 0) { 
						   		$d_nivel=$query->datos_material_nivel($_GET['nivel_basico']);
								
                                if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$d_nivel['id_nivel_material'].'" selected="selected">'.$d_nivel['nivel_material_'.$_SESSION['language'].''].'</option>';
                                } else {
                                    echo '<option value="'.$d_nivel['id_nivel_material'].'" selected="selected">'.$d_nivel['nivel_material'].'</option>';
                                }
								
								echo '<option value="0">'.$translate['cualquiera'].'</option>';
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                       <?php while ($row_nivel=mysql_fetch_array($nivel)) {  
                                if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$row_nivel['id_nivel_material'].'">'.$row_nivel['nivel_material_'.$_SESSION['language'].''].'</option>';
                                } else {
                                    echo '<option value="'.$row_nivel['id_nivel_material'].'">'.$row_nivel['nivel_material'].'</option>';
                                }
                     } ?>
                     </select>
                   </div>
                   <label for="saa_basico"><strong><?php echo $translate['saac']; ?></strong></label>
                      
                   <div class="suboption" id="so2">
                     <select name="saa_basico" id="saa_basico" required="1" realname="SAA">
                         <?php if (isset($_GET['saa_basico']) && $_GET['saa_basico'] > 0) { 
						   		$d_saa=$query->datos_material_saa($_GET['saa_basico']);
								
                                if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$d_saa['id_saa_material'].'">'.$d_saa['saa_material_'.$_SESSION['language'].''].'</option>';
                                } else {
                                    echo '<option value="'.$d_saa['id_saa_material'].'">'.$d_saa['saa_material'].'</option>';
                                }
								
								echo '<option value="0">'.$translate['cualquiera'].'</option>';
							} else { ?>
                           		<option value="0" selected="selected"><?php echo $translate['cualquiera']; ?></option>
                           <?php } ?>
                       <?php while ($row_saa=mysql_fetch_array($saa)) {  
                        
                                if ($_SESSION['id_language'] > 0) {
                                    echo '<option value="'.$row_saa['id_saa_material'].'">'.$row_saa['saa_material_'.$_SESSION['language'].''].'</option>';
                                } else {
                                    echo '<option value="'.$row_saa['id_saa_material'].'">'.$row_saa['saa_material'].'</option>';
                                }
                        } ?>
                     </select>
                   </div>             
        	</div>


             
             </div>       
              <div>
             <br /><input name="button" type="submit" class="boton_grande" id="button" value="<?php echo $translate['buscar']; ?>" />
           </div>
          </div>
         </div>
         </form>
         <?php } elseif (isset($_GET['buscador']) && $_GET['buscador']==2) { ?>
         <form id="search_materiales_avanzado" name="search_materiales_avanzado" action="<?php echo $PHP_SELF; ?>">  
         <div id="searchmenu_avanzado">
           <div id="cuadro_busqueda_materiales">
            <div id="flotar_derecha"><a href="materiales.php?<?php echo $cadena_url_buscador ?>buscador=0"><?php echo $translate['cerrar']; ?></a></div>
            <div class="separador_verde"><?php echo $translate['buscador_avanzado_materiales']; ?>
              <input name="busqueda" type="hidden" id="busqueda" value="avanzado" />
              <input name="buscador" type="hidden" id="buscador" value="2" />
            </div> <br />
            
            <div id="tabla1"> 
            
                <div id="tabla1_celda1"> 
                
               	  <p>
               	    <label for="texto_buscar"><strong><?php echo $translate['titulo_descripcion_objetivos']; ?></strong></label> 
               	    <br />
               	    <input name="texto_buscar" type="text" class="cuadro_busqueda_materiales" id="texto_buscar" value="<?php if (isset($_GET['texto_buscar']) && $_GET['texto_buscar'] !='') { echo $_GET['texto_buscar']; } ?>"/>
               	    <br  /><br  />
               	    <label for="area_curricular"><strong><?php echo $translate['area']; ?> / <?php echo $translate['subarea']; ?></strong></label>
               	    <br  />
               	    <?php while ($row_ac_avanzado=mysql_fetch_array($ac_avanzado)) {  
                                $listado_subareas=$query->listar_subareas_curriculares($row_ac_avanzado['id_ac_material']);
                                if (mysql_num_rows($listado_subareas) > 0 ) {
                                   echo '<a href="javascript:void();" onClick="Effect.BlindDown(\'ac_'.$row_ac_avanzado['id_ac_material'].'\');; return false;"><img src="images/plus3.gif" ></a>&nbsp;';
                                } else {
                                    echo '<img src="images/line3.gif" alt="sub" title="sub">&nbsp;';
                                }
                                echo '<input type="checkbox" name="area_curricular[]" id="area_curricular" value="'.$row_ac_avanzado['id_ac_material'].'"';
									if (isset($_GET['area_curricular'])) {
										if (in_array($row_ac_avanzado['id_ac_material'],$_GET['area_curricular'])) {
											echo 'checked="checked" ';
										}
									}
								echo '/><label for="area_curricular">';
                                
                                    if ($_SESSION['id_language'] > 0) {
                                        echo $row_ac_avanzado['ac_material_'.$_SESSION['language'].''];
                                    } else {
                                        echo $row_ac_avanzado['ac_material'];
                                    }
                                
                                echo '</label><br/>';
                                if (mysql_num_rows($listado_subareas) > 0 ) {
                                    echo '<div id="ac_'.$row_ac_avanzado['id_ac_material'].'" style="padding-left:25px;"><a href="javascript:void();" onClick="Effect.BlindUp(\'ac_'.$row_ac_avanzado['id_ac_material'].'\');; return false;"><img src="images/minus3.gif" ></a><br />';
                                    while ($row=mysql_fetch_array($listado_subareas)) {			
                                        echo '<img src="images/line2.gif" alt="sub" title="sub">&nbsp;<input type="checkbox" name="subarea_curricular[]" id="subarea_curricular" value="'.$row['id_subac_material'].'"';
											if (isset($_GET['subarea_curricular'])) {
												if (in_array($row['id_subac_material'],$_GET['subarea_curricular'])) {
													echo 'checked="checked" ';
												}
											}
									echo '/><label for="subarea_curricular">';
                                        
                                            if ($_SESSION['id_language'] > 0) {
                                                echo $row['subac_material_'.$_SESSION['language'].''];
                                            } else {
                                                echo $row['subac_material'];
                                            }
                                            
                                        echo '<br />'; 
                                    }
                                    echo '</div>';
                                }
                         } ?>
           	      </p>
               	  <p>
               	    <label for="saa"><strong><?php echo $translate['saac']; ?></strong></label>
                    <br/>
                    <?php while ($row_saa_avanzado=mysql_fetch_array($saa_avanzado)) {  
                            echo '<input type="checkbox" name="saa[]" id="saa" value="'.$row_saa_avanzado['id_saa_material'].'"';
							if (isset($_GET['saa'])) {
								if (in_array($row_saa_avanzado['id_saa_material'],$_GET['saa'])) {
									echo 'checked="checked" ';
								}
							}
							
							echo '/><label for="saa">';
                            
                                if ($_SESSION['id_language'] > 0) {
                                    echo $row_saa_avanzado['saa_material_'.$_SESSION['language'].''];
                                } else {
                                    echo $row_saa_avanzado['saa_material'];
                                }
                            
                            echo '</label><br />';
                     } ?>
<br/>
           	      </p>
            </div>
                
                <div id="tabla1_celda2"> 
                  <label for="tipo"><strong><?php echo $translate['tipo']; ?></strong></label><br/>
                    <?php while ($row_tm_avanzado=mysql_fetch_array($tm_avanzado)) {  
                            
                        echo '<input type="checkbox" name="tipo[]" id="tipo" value="'.$row_tm_avanzado['id_tipo_material'].'"';
							if (isset($_GET['tipo'])) {
								if (in_array($row_tm_avanzado['id_tipo_material'],$_GET['tipo'])) {
									echo 'checked="checked" ';
								}
							}
							
						echo '/><label for="tipo">';
                        
                            if ($_SESSION['id_language'] > 0) {
                                echo $row_tm_avanzado['tipo_material_'.$_SESSION['language'].''];
                            } else {
                                echo $row_tm_avanzado['tipo_material'];
                            }
                        
                        echo '</label><br />';
                
                     } ?>
                  <br/><label for="dirigido"><strong><?php echo $translate['dirigido']; ?></strong></label><br/>
                 <?php while ($row_dirigido_avanzado=mysql_fetch_array($dirigido_avanzado)) {  
                        echo '<input type="checkbox" name="dirigido[]" id="dirigido" value="'.$row_dirigido_avanzado['id_dirigido_material'].'"';
							if (isset($_GET['dirigido'])) {
								if (in_array($row_dirigido_avanzado['id_dirigido_material'],$_GET['dirigido'])) {
									echo 'checked="checked" ';
								}
							}
							
						echo '/><label for="dirigido">';
                        
                            if ($_SESSION['id_language'] > 0) { 
                                echo $row_dirigido_avanzado['dirigido_material_'.$_SESSION['language'].''];
                            } else {
                                echo $row_dirigido_avanzado['dirigido_material'];
                            }
                            
                        echo '</label><br />';
                 } ?>
               
                </div>
                
                <div id="tabla1_celda3"> 
                    <p>
                      <label for="nivel"><strong><?php echo $translate['nivel']; ?></strong></label>
                      <br/>
                      <?php while ($row_nivel_avanzado=mysql_fetch_array($nivel_avanzado)) {  
                        echo '<input type="checkbox" name="nivel[]" id="nivel" value="'.$row_nivel_avanzado['id_nivel_material'].'"';
							if (isset($_GET['nivel'])) {
								if (in_array($row_nivel_avanzado['id_nivel_material'],$_GET['nivel'])) {
									echo 'checked="checked" ';
								}
							}
							
						echo '/><label for="nivel">';
                        
                            if ($_SESSION['id_language'] > 0) { 
                                echo $row_nivel_avanzado['nivel_material_'.$_SESSION['language'].''];
                            } else {
                                echo $row_nivel_avanzado['nivel_material'];
                            }
                            
                        echo '</label><br />';
                 } ?>
                    </p>
                    <p>
                      <label for="idiomas"><strong><?php echo $translate['idiomas']; ?>: </strong></label>
                      <br/>
                      <?php 
				   echo '<input type="checkbox" name="idiomas[]" id="idiomas" value="es"';
				  		   if (isset($_GET['idiomas'])) {
								if (in_array('es',$_GET['idiomas'])) {
									echo 'checked="checked" ';
								}
							}
                    echo '/><label for="idiomas">'.$translate['spanish'].'</label><br />';
                    
                    while ($row_idiomas_avanzado=mysql_fetch_array($idiomas_avanzado)) {  
                        echo '<input type="checkbox" name="idiomas[]" id="idiomas" value="'.$row_idiomas_avanzado['idioma_abrev'].'"';
							if (isset($_GET['idiomas'])) {
								if (in_array($row_idiomas_avanzado['idioma_abrev'],$_GET['idiomas'])) {
									echo 'checked="checked" ';
								}
							}
							
						echo '/><label for="idiomas">';
                        
                            if ($_SESSION['id_language'] > 0) {
                                echo $row_idiomas_avanzado['idioma_'.$_SESSION['language'].''];
                            } else {
                                echo $row_idiomas_avanzado['idioma'];
                            }
                        
                        echo '</label><br />';
                 } ?>
<br/>
                      <label for="licencia"><strong><?php echo $translate['licencia']; ?>: </strong></label>
                      <br/>
                      <select name="licencia" disabled="disabled" class="cuadro_busqueda_materiales" id="licencia">
                        <?php while ($row_rsLicencia=mysql_fetch_array($licencias)) {  ?>
                        <option value="<?php echo $row_rsLicencia['id_licencia']?>" <?php if ($row_rsLicencia['id_licencia']=='2') { echo 'selected'; } ?>>
                          <?php 	if ($_SESSION['id_language'] > 0) { 
                                        echo $row_rsLicencia['licencia_'.$_SESSION['language'].'']; 
                                    } else {
                                        echo $row_rsLicencia['licencia']; 
                                    } 
                              ?>
                        </option>
                        <?php }  ?>
                      </select>
                    </p>
                </div>

                
            </div>
           
               <input name="button2" type="submit" class="boton_grande" id="button2"  value="<?php echo $translate['buscar']; ?>" />
           </div>  
      </div>
     </form>  
    <?php } ?>            
        <div id="materiales">
           <?php if (isset($_GET['id_material']) && $_GET['id_material'] > 0) {  
            
                $row=$query->ficha_material($_GET['id_material']);
            ?>
           <br  />
           <div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
           <div class="separador_verde"><?php echo utf8_encode($row['material_titulo']); ?></div><br />
            <div id="tabla2">
            	<div id="tabla2_celda1">
                    <p><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
                            <?php echo utf8_encode($row['material_descripcion']); ?><br />
                          <br />
                            <strong><?php echo $translate['licencia']; ?>:</strong> <br />
                            <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'"  /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>
                  </p>
                          <p><strong><?php echo $translate['idiomas']; ?>:</strong>
                            <?php 
                              $mid=str_replace('}{',',',$row['material_idiomas']);
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
                            ?>
                    </p>
                </div>
                
                <div id="tabla2_celda2">
                
                  <strong>Autor/es:</strong> <br />
                  <?php 
                   $mau=str_replace('}{',',',$row['material_autor']);
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
				<g:plusone size="tall" href="http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>"></g:plusone>
                <br />
                  <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>" data-text="<?php echo utf8_encode($row['material_titulo']); ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><br />
                 <div class="fb-like" data-href="http://arasaac.org/materiales.php?id_material=<?php echo $row['id_material']; ?>" data-send="true" data-layout="box_count" data-width="450" data-show-faces="true"></div>
				  <br /><br />                
                  <strong>
                  <?php 
            
            
                  if (substr_count($row['material_archivos'],'.swf') == 1) {
                        
                      echo $translate['previsualizacion']."<br/>";
                      
                      $ma=str_replace('}{',',',$row['material_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
                            
                            $split_archivo=explode('.',$ma[$i]);
                            
                            if ($split_archivo[1] == 'swf') {
                                
                                echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="200" height="200">
                              <param name="movie" value="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" />
                              <param name="quality" value="high" />
                              <embed src="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="200" height="200"></embed>
                            </object><br/>';
                            }
                         
                        }
                      }
                    
                    
                  }
                  ?>
                  </strong>
                  <strong><?php echo $translate['archivo_s']; ?>:</strong> <br />
                  <br />
                  <?php 
                    $ma=str_replace('}{',',',$row['material_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
						 $archivo='zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i];
						 $ruta_cesto='ruta_cesto=zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i];
						 $encript->encriptar($ruta_cesto,1);
						 
                         echo "<a href=\"javascript:void(0);\" onclick=\"cargar_div2('operaciones_cesto_ajax.php','product_id=".$ruta_cesto."','n_cesto');\"><img src=\"images/add_4.png\" alt=\"".$translate['add_seleccion']."\" title=\"".$translate['add_seleccion']."\"></a>&nbsp;<a href=\"descargar.php?d=".$archivo."\"><img src=\"images/download_5.png\" alt=\"".$translate['descargar_material']."\" title=\"".$translate['descargar_material']."\"></a>&nbsp;&nbsp;<a href=\"".$archivo."\" target=\"_blank\">".$ma[$i]."</a>";
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								echo '&nbsp;('.tamano_archivo($peso_archivo).')';
						 }
						 
						 echo '<br /><br />'; 
                        }
                      }
                      
                  ?><br />      
                </div>
            </div>

            <br />
            <strong><a  href="javascript:void();" onClick="Effect.BlindDown('material_<?php echo $row['id_material'] ?>');; return false;" ><?php echo $translate['datos_clasificacion']; ?></a></strong>
            
             <div id="material_<?php echo $row['id_material'] ?>" style="display:block;"><br  />     
              <div id="tabla3">
              	<div id="tabla3_header">
                
                	<div id="tabla3_celda1">
                    	<strong><?php echo $translate['tipo']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda2">
                    	<strong><?php echo $translate['saac']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<strong><?php echo $translate['nivel']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda4">
                    	<strong><?php echo $translate['dirigido']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda5">
                    	<strong><?php echo $translate['areas_subareas']; ?>:</strong>
                    </div>
                    
                </div>
                
             	 <div id="tabla3_row">
                 
                    <div id="tabla3_celda1">
                      <?php 
						  $mt=str_replace('}{',',',$row['material_tipo']);
						  $mt=str_replace('{','',$mt);
						  $mt=str_replace('}','',$mt);
						  $mt=explode(',',$mt);
						  
						  for ($i=0;$i<count($mt);$i++) { 
							if ($mt[$i]!='') {
							 $data_tipo=$query->datos_material_tipo($mt[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo $data_tipo['tipo_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									echo $data_tipo['tipo_material'].'<br />'; 
								}
							}
						  }
					  ?>
                    </div>
                    
                    <div id="tabla3_celda2">
                    	<?php 
						  $msaa=str_replace('}{',',',$row['material_saa']);
						  $msaa=str_replace('{','',$msaa);
						  $msaa=str_replace('}','',$msaa);
						  $msaa=explode(',',$msaa);
						  
						  for ($i=0;$i<count($msaa);$i++) { 
							if ($msaa[$i]!='') {
							 $data_saa=$query->datos_material_saa($msaa[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo  $data_saa['saa_material_'.$_SESSION['language'].''].'<br />';
								} else {
									echo  $data_saa['saa_material'].'<br />'; 
								}
							}
						  }
						?>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<?php 
						  $mn=str_replace('}{',',',$row['material_nivel']);
						  $mn=str_replace('{','',$mn);
						  $mn=str_replace('}','',$mn);
						  $mn=explode(',',$mn);
						  
						  for ($i=0;$i<count($mn);$i++) { 
							if ($mn[$i]!='') {
							 $data_nivel=$query->datos_material_nivel($mn[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo  $data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									 echo  $data_nivel['nivel_material'].'<br />'; 
								}
							}
						  }
					  ?>
                    </div>
                    
                    <div id="tabla3_celda4">
                      <?php
						 $md=str_replace('}{',',',$row['material_dirigido']);
						  $md=str_replace('{','',$md);
						  $md=str_replace('}','',$md);
						  $md=explode(',',$md);
						  
						  for ($i=0;$i<count($md);$i++) { 
							if ($md[$i]!='') {
							 $data_dirigido=$query->datos_material_dirigido($md[$i]);
								if ($_SESSION['id_language'] > 0) {
									 echo  $data_dirigido['dirigido_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									 echo  $data_dirigido['dirigido_material'].'<br />'; 
								}
							}
						  }
						?>
                    </div>
                    
                    <div id="tabla3_celda5">
                    	<?php 
                   $mac=str_replace('}{',',',$row['material_area_curricular']);
                      $mac=str_replace('{','',$mac);
                      $mac=str_replace('}','',$mac);
                      $mac=explode(',',$mac);
                      
                      for ($i=0;$i<count($mac);$i++) { 
                        if ($mac[$i]!='') {
                         $data_ac=$query->datos_material_ac($mac[$i]);
                            if ($_SESSION['id_language'] > 0) {
                                echo  $data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
                            } else {
                                echo  $data_ac['ac_material'].'<br />'; 
                            }
                         
                          $msubac=str_replace('}{',',',$row['material_subarea_curricular']);
                          $msubac=str_replace('{','',$msubac);
                          $msubac=str_replace('}','',$msubac);
                          $msubac=explode(',',$msubac);
                          
                          for ($j=0;$j<count($msubac);$j++) { 
                                if ($msubac[$j]!='') {
                                  $subareas=$query->datos_subarea($msubac[$j]);
                                  if ($subareas['id_ac_material']==$mac[$i]) { 
                                        echo '<blockquote><img src="images/line2.gif" alt="sub" title="sub">&nbsp;';
                                            if ($_SESSION['id_language'] > 0) {
                                                echo $subareas['subac_material_'.$_SESSION['language'].''];
                                            } else {
                                                echo $subareas['subac_material'];
                                            }
                                        echo '</blockquote>';  
                                    }
                                }
                           }
                
                        }
                      }
                    ?>
                    </div>
                
                </div>
              
              </div>
             
             </div>
             <br />
            <div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16"  title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['enlace_permanente']; ?></a>&nbsp;|&nbsp;<a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>"  title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>&nbsp;<a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['descargar_materiales_zip']; ?></a><br /><br />
			
			<?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?>
             </div>  
           </div>
            
           <?php } else {  echo $mensaje;  
                
                if ($total_records > 0 ) {
            
                while ($row=mysql_fetch_array($resultados)) {  
            
                $i++;
                
                if ($pg == 0 && $i==1) { ?>
                    
         <div class="material">
           <div class="separador_verde"><?php echo utf8_encode($row['material_titulo']); ?></div><br />
            <div id="tabla2">
            	<div id="tabla2_celda1">
                    <p><strong><?php echo $translate['descripcion']; ?>:</strong> <br />
                            <?php echo utf8_encode($row['material_descripcion']); ?><br />
                          <br />
                            <strong><?php echo $translate['licencia']; ?>:</strong> <br />
                            <?php if ($row['logo_licencia'] != '') { echo '<a href="'.$row['link_licencia'].'" target="_blank"><img src="images/'.$row['logo_licencia'].'" alt="'.utf8_encode($row['licencia']).'" title="'.utf8_encode($row['licencia']).'"  /></a>';  } else {  echo utf8_encode($row['licencia']); } ?>
                  </p>
                          <p><strong><?php echo $translate['idiomas']; ?>:</strong>
                            <?php 
                              $mid=str_replace('}{',',',$row['material_idiomas']);
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
                            ?>
                    </p>
                </div>
                
                <div id="tabla2_celda2">
                
                  <strong>Autor/es:</strong> <br />
                  <?php 
                   $mau=str_replace('}{',',',$row['material_autor']);
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
				<g:plusone size="tall" href="http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>"></g:plusone>
                <br />
                  <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>" data-text="<?php echo utf8_encode($row['material_titulo']); ?>" data-count="horizontal" data-via="arasaac" data-lang="<?php $_SESSION['language']; ?>">Tweet</a>
				 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><br />
                 <div class="fb-like" data-href="http://arasaac.org/materiales.php?id_material=<?php echo $row['id_material']; ?>" data-send="true" data-layout="box_count" data-width="450" data-show-faces="true"></div>
                 <br /><br />
                 
                  <strong>
                  <?php 
            
            
                  if (substr_count($row['material_archivos'],'.swf') == 1) {
                        
                      echo $translate['previsualizacion']."<br/>";
                      
                      $ma=str_replace('}{',',',$row['material_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
                            
                            $split_archivo=explode('.',$ma[$i]);
                            
                            if ($split_archivo[1] == 'swf') {
                                
                                echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="200" height="200">
                              <param name="movie" value="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" />
                              <param name="quality" value="high" />
                              <embed src="zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i].'" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="200" height="200"></embed>
                            </object><br/>';
                            }
                         
                        }
                      }
                    
                    
                  }
                  ?>
                  </strong>
                  <strong><?php echo $translate['archivo_s']; ?>:</strong> <br />
                  <br />
                  <?php 
                    $ma=str_replace('}{',',',$row['material_archivos']);
                      $ma=str_replace('{','',$ma);
                      $ma=str_replace('}','',$ma);
                      $ma=explode(',',$ma);
                      
                      for ($i=0;$i<count($ma);$i++) { 
                        if ($ma[$i]!='') {
						 $archivo='zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i];
                         $ruta_cesto='ruta_cesto=zona_descargas/materiales/'.$row['id_material'].'/'.$ma[$i];
						 $encript->encriptar($ruta_cesto,1);
						 
                         echo "<a href=\"javascript:void(0);\" onclick=\"cargar_div2('operaciones_cesto_ajax.php','product_id=".$ruta_cesto."','n_cesto');\"><img src=\"images/add_4.png\" alt=\"".$translate['add_seleccion']."\" title=\"".$translate['add_seleccion']."\"></a>&nbsp;<a href=\"descargar.php?d=".$archivo."\"><img src=\"images/download_5.png\" alt=\"".$translate['descargar_material']."\" title=\"".$translate['descargar_material']."\"></a>&nbsp;&nbsp;<a href=\"".$archivo."\" target=\"_blank\">".$ma[$i]."</a>";
						 if (file_exists($archivo)) {
						 		$peso_archivo = filesize($archivo);
								echo '&nbsp;('.tamano_archivo($peso_archivo).')';
						 }
						 
						 echo '<br /><br />'; 
                        }
                      }
                      
                  ?><br />      
                </div>
            </div>

            <br />
            <strong><?php echo $translate['datos_clasificacion']; ?></strong>
            
             <div id="material_<?php echo $row['id_material'] ?>" style="display:block;"><br  />     
              <div id="tabla3">
              	<div id="tabla3_header">
                
                	<div id="tabla3_celda1">
                    	<strong><?php echo $translate['tipo']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda2">
                    	<strong><?php echo $translate['saac']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<strong><?php echo $translate['nivel']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda4">
                    	<strong><?php echo $translate['dirigido']; ?>:</strong>
                    </div>
                    
                    <div id="tabla3_celda5">
                    	<strong><?php echo $translate['areas_subareas']; ?>:</strong>
                    </div>
                    
                </div>
                
             	 <div id="tabla3_row">
                 
                    <div id="tabla3_celda1">
                      <?php 
						  $mt=str_replace('}{',',',$row['material_tipo']);
						  $mt=str_replace('{','',$mt);
						  $mt=str_replace('}','',$mt);
						  $mt=explode(',',$mt);
						  
						  for ($i=0;$i<count($mt);$i++) { 
							if ($mt[$i]!='') {
							 $data_tipo=$query->datos_material_tipo($mt[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo $data_tipo['tipo_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									echo $data_tipo['tipo_material'].'<br />'; 
								}
							}
						  }
					  ?>
                    </div>
                    
                    <div id="tabla3_celda2">
                    	<?php 
						  $msaa=str_replace('}{',',',$row['material_saa']);
						  $msaa=str_replace('{','',$msaa);
						  $msaa=str_replace('}','',$msaa);
						  $msaa=explode(',',$msaa);
						  
						  for ($i=0;$i<count($msaa);$i++) { 
							if ($msaa[$i]!='') {
							 $data_saa=$query->datos_material_saa($msaa[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo  $data_saa['saa_material_'.$_SESSION['language'].''].'<br />';
								} else {
									echo  $data_saa['saa_material'].'<br />'; 
								}
							}
						  }
						?>
                    </div>
                    
                    <div id="tabla3_celda3">
                    	<?php 
						  $mn=str_replace('}{',',',$row['material_nivel']);
						  $mn=str_replace('{','',$mn);
						  $mn=str_replace('}','',$mn);
						  $mn=explode(',',$mn);
						  
						  for ($i=0;$i<count($mn);$i++) { 
							if ($mn[$i]!='') {
							 $data_nivel=$query->datos_material_nivel($mn[$i]);
								if ($_SESSION['id_language'] > 0) {
									echo  $data_nivel['nivel_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									 echo  $data_nivel['nivel_material'].'<br />'; 
								}
							}
						  }
					  ?>
                    </div>
                    
                    <div id="tabla3_celda4">
                      <?php
						 $md=str_replace('}{',',',$row['material_dirigido']);
						  $md=str_replace('{','',$md);
						  $md=str_replace('}','',$md);
						  $md=explode(',',$md);
						  
						  for ($i=0;$i<count($md);$i++) { 
							if ($md[$i]!='') {
							 $data_dirigido=$query->datos_material_dirigido($md[$i]);
								if ($_SESSION['id_language'] > 0) {
									 echo  $data_dirigido['dirigido_material_'.$_SESSION['language'].''].'<br />'; 
								} else {
									 echo  $data_dirigido['dirigido_material'].'<br />'; 
								}
							}
						  }
						?>
                    </div>
                    
                    <div id="tabla3_celda5">
                    	<?php 
                   $mac=str_replace('}{',',',$row['material_area_curricular']);
                      $mac=str_replace('{','',$mac);
                      $mac=str_replace('}','',$mac);
                      $mac=explode(',',$mac);
                      
                      for ($i=0;$i<count($mac);$i++) { 
                        if ($mac[$i]!='') {
                         $data_ac=$query->datos_material_ac($mac[$i]);
                            if ($_SESSION['id_language'] > 0) {
                                echo  $data_ac['ac_material_'.$_SESSION['language'].''].'<br />';
                            } else {
                                echo  $data_ac['ac_material'].'<br />'; 
                            }
                         
                          $msubac=str_replace('}{',',',$row['material_subarea_curricular']);
                          $msubac=str_replace('{','',$msubac);
                          $msubac=str_replace('}','',$msubac);
                          $msubac=explode(',',$msubac);
                          
                          for ($j=0;$j<count($msubac);$j++) { 
                                if ($msubac[$j]!='') {
                                  $subareas=$query->datos_subarea($msubac[$j]);
                                  if ($subareas['id_ac_material']==$mac[$i]) { 
                                        echo '<blockquote><img src="images/line2.gif" alt="sub" title="sub">&nbsp;';
                                            if ($_SESSION['id_language'] > 0) {
                                                echo $subareas['subac_material_'.$_SESSION['language'].''];
                                            } else {
                                                echo $subareas['subac_material'];
                                            }
                                        echo '</blockquote>';  
                                    }
                                }
                           }
                
                        }
                      }
                    ?>
                    </div>
                
                </div>
              
              </div>
             
             </div>
             <br />
            <div class="informacion"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" width="16" height="16"  title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['enlace_permanente']; ?></a>&nbsp;|&nbsp;<a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><img src="images/compress.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>"  title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>&nbsp;<a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['descargar_materiales_zip']; ?></a><br /><br />
			
			<?php echo $translate['actualizado_dia']; ?>&nbsp;<?php echo $row['fecha_alta']; ?>
             </div>  
           </div>
                 
           <?php } else {
			/* $date_sin_hora=explode(" ",$row['fecha_alta']);
            $date=explode("-",$date_sin_hora[0]);
            $fecha_publicacion=$date[2].'-'.$date[1].'-'.$date[0];
            $publicado_hace=intval(compara_fechas($hoy,$fecha_publicacion)/86400); */
            ?>
           <div class="material" style="padding:10px; border:1px solid #CCCCCC; margin-bottom:15px;">
             <div id="tabla4">
           		<div id="tabla4_header">
                	<div id="tabla4_celda1"><a href="?id_material=<?php echo $row['id_material']; ?>"><strong><?php echo utf8_encode($row['material_titulo']); ?></strong></a>
                   <?php 
                      $mid=str_replace('}{',',',$row['material_idiomas']);
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
                   $mau=str_replace('}{',',',$row['material_autor']);
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
				<br />
                <div><?php echo utf8_encode($row['material_descripcion']); ?></div>
                <br />
                <div id="tabla4_row_crema">
               		<div id="tabla4_celda1"><a href="?id_material=<?php echo $row['id_material']; ?>"><img src="images/world_link.png" alt="<?php echo $translate['enlace_permanente']; ?>" title="<?php echo $translate['enlace_permanente']; ?>" /></a>&nbsp;<a href="?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['enlace_permanente']; ?></a>&nbsp;|&nbsp;<a href="http://twitter.com/share?url=http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>&text=<?php echo utf8_encode($row['material_titulo']); ?>&original_referer=http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>&via=arasaac" target="_blank"><img src="images/twitter_icon.jpg" border="0"></a> | <div class="fb-like" data-href="http://arasaac.org/materiales.php?id_material=<?php echo $row['id_material']; ?>" data-send="true" data-layout="button_count" data-width="150" data-show-faces="true"></div> | <g:plusone size="small" href="http://catedu.es/arasaac/materiales.php?id_material=<?php echo $row['id_material']; ?>"></g:plusone> </div>
                    <div id="tabla4_celda2"><a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><img src="images/zip_compress_20.png" alt="<?php echo $translate['descargar_materiales_zip']; ?>"  title="<?php echo $translate['descargar_materiales_zip']; ?>" /></a>&nbsp;<a href="inc/public/zip_material.php?id_material=<?php echo $row['id_material']; ?>"><?php echo $translate['descargar_materiales_zip']; ?></a>&nbsp;</div>
                    <div id="tabla4_celda3"><a href="?id_material=<?php echo $row['id_material']; ?>">(+Ampliar&nbsp;<?php echo $translate['informacion']; ?>)</a> </div>
                </div>
                
           </div>
           
           </div>
           <?php } } } // Cierro el While y el IF ?>
           
           <?php if (isset($n_resultados) && $n_resultados > 0) { ?>
           <div id="resultados_materiales"><strong><?php echo $translate['material']; ?>: </strong><?php echo $inicial ?> <?php echo $translate['a']; ?> <?php echo $inicial+$cantidad ?> <?php echo $translate['de']; ?> <?php echo $total_records ?><br /> 
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

