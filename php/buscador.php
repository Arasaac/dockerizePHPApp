<div class="search_field_buscador_general">
                <form action="buscar.php" method="GET" id="autossugest">
                  <strong><label for="s"><?php echo $translate['buscar_en_catalogos']; ?></label>:</strong>&nbsp;
                  <input name="s" type="text" id="s" value="<?php if (isset($_GET['s']) && $_GET['s'] !='') { echo $_GET['s']; } else { echo $translate['palabra_a_buscar']; } ?>" size="25"/>
                  <select name="idiomasearch" id="idiomasearch">
                    <option value="0" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==0) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='es') { echo 'selected="selected"'; } ?>><?php echo $translate['spanish']; ?></option>
                    <option value="7" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==7) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='en') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(7); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="8" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==8) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='fr') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(8); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="9" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==9) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ca') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(9); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="14" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==14) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ga') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(14); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="11" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==11) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='de') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(11); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="12" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==12) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='it') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(12); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="13" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==13) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='pt') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(13); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="15" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==15) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='br') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(15); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="10" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==10) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='eu') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(10); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="2" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==2) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ro') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(2); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="6" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==6) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='po') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(6); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="4" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==4) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='zh') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(4); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="3" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==3) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ar') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(3); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="1" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==1) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='ru') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(1); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="5" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==5) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='bg') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(5); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                    <option value="16" <?php if (isset($_GET['idiomasearch']) && $_GET['idiomasearch']==16) { echo 'selected="selected"'; } elseif (!isset($_GET['idiomasearch']) && $_SESSION['language']=='fi') { echo 'selected="selected"'; } ?>>
                      <?php $datos_idioma=$query->datos_idioma_completo(16); echo $datos_idioma['idioma_'.$_SESSION['language'].'']; ?>
                    </option>
                  </select>
                  <input type="submit" name="Buscar" id="boton_buscador_general" value="<?php echo $translate['buscar']; ?>" class="boton_mediano"/>
                   [<a href="ayuda.php#A-1" target="_self" title="<?php echo $translate['ir_ayuda_este_buscador']; ?> A-1"><?php echo $translate['ayuda']; ?></a>]
        		  
        		  <input name="buscar_por" type="hidden" id="buscar_por" value="1" />
                  
             <div id="resultados_sugeridos">
  <div class="suggestionsBox" id="suggestions" style="display: none;">
                            <img src="js/autoComplete/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                            <div class="suggestionList" id="autoSuggestionsList"></div>
                 	  </div>
     </div>
             	  <input name="pictogramas_color" type="checkbox" id="pictogramas_color" value="1" checked="checked" />
                  <label for="pictogramas_color"><?php echo $translate['pictogramas_color']; ?></label>
                  <input name="pictogramas_byn" type="checkbox" id="pictogramas_byn" value="1" checked="checked" />
                  <label for="pictogramas_byn"><?php echo $translate['pictogramas_byn']; ?></label>
                  <input name="fotografia" type="checkbox" id="fotografia" value="1" checked="checked" />
                  <label for="fotografia"><?php echo $translate['fotografias']; ?></label>
                  <input name="videos_lse" type="checkbox" id="videos_lse" value="1" checked="checked" /> 
                  <label for="videos_lse"><?php echo $translate['videos_lse']; ?></label>
                  <input name="lse_color" type="checkbox" id="lse_color" value="1" checked="checked" />
                  <label for="lse_color"><?php echo $translate['lse_color']; ?></label>
			    <?php if (isset($_SESSION['AUTHORIZED']) && $_SESSION['AUTHORIZED']== true) { ?>
                    <input name="simbolos" type="checkbox" id="simbolos" value="1" />
                  <a href="javascript:void(0);" onclick="Dialog.alert({url: 'inc/public/opciones_busqueda_simbolos.php', options: {method: 'get'}},{windowParameters: {className: 'alphacube', width:420, height:350}, okLabel: '<?php echo $translate['cerrar']; ?>' });"><?php echo $translate['simbolos']; ?></a>
                  <input name="lse_byn" type="checkbox" id="lse_byn" value="1" />
				  <?php echo $translate['lse_byn']; ?>
                  
                  <?php } ?>
                  <br />
                </form>
  </div>