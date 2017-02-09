<?php 
	if ($total_pages > 0) {
				
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
              
	}
	
?>