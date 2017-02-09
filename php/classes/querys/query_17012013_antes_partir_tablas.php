<?php 
require ('conexion.php');

class query extends config_db {

//               FUNCION AUTENTIFICAR                      //
//*********************************************************//

	function authenticate($username, $password) {
		$query = "SELECT colaboradores.*, colaboradores_permisos.* 
		FROM colaboradores, colaboradores_permisos
		WHERE colaboradores.login='$username' 
		AND colaboradores.password='$password' 
		AND colaboradores.id_colaborador=colaboradores_permisos.id_colaborador
		AND colaboradores.estado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	} // FIN DE LA FUNCION AUTENTIFICAR

//               FUNCION AUTENTIFICAR                      //
//*********************************************************//

	function datos_traductor($username) {
		$query = "SELECT * 
		FROM traductores
		WHERE login='$username' 
		AND estado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	} // FIN DE LA FUNCION AUTENTIFICAR

//               FUNCION AUTENTIFICAR CATALOGADOR                  //
//*********************************************************//

	function datos_catalogador($username) {
		$query = "SELECT * 
		FROM catalogadores
		WHERE login='$username' 
		AND estado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	} // FIN DE LA FUNCION AUTENTIFICAR
	
//               FUNCION INTERNACIONALIZACION                      //
//*********************************************************//

	function get_internacionalizacion_page_content($idioma,$id_page) {
		$query = "SELECT * FROM internacionalizacion
		WHERE id_page='$id_page' OR id_page=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		
		
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			
			while ($data=mysql_fetch_array($result)) {
				
				$key=$data['key'];
				
				if ($data[''.$idioma.''] == '' || $data[''.$idioma.'']==NULL) { 
					$lang[$key]=$data['es'];
				} else {
					$lang[$key]=$data[''.$idioma.''];
				}
			
			}
			mysql_close($connection);
			return $lang;
		}
	} // FIN DE LA FUNCION 

//      FUNCION DATOS TABLA INTERNACIONALIZACION                      //
//*********************************************************//
	
	function datos_internacionalizacion() {
		$query = "SELECT * FROM internacionalizacion";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);

		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} // FIN DE LA FUNCION
	
	
	function listado_paginas_internacionalizacion() {
		$query = "SELECT * FROM internacionalizacion_pages ORDER BY id_page asc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);

		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} // FIN DE LA FUNCION
	
	function datos_item_internacionalizacion($id_key) {
		$query = "SELECT * FROM internacionalizacion WHERE id_key='$id_key'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);

		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}
	} // FIN DE LA FUNCION
	
//******************************************************************************//
	function actualizar_item_internacionalizacion($key,$contenido,$idioma) {

		$UpdateRecords = "UPDATE internacionalizacion SET $idioma='".addslashes($contenido)."' WHERE id_key='$key'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}
	
	function actualizar_definicion_traduccion($key,$contenido) {

		$UpdateRecords = "UPDATE traducciones SET definicion_traduccion='".addslashes($contenido)."' WHERE id_traduccion='".$key."'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}
	
	function actualizar_estado_definicion_traduccion($key,$estado) {

		$UpdateRecords = "UPDATE traducciones SET estado_definicion_traduccion='$estado' WHERE id_traduccion='$key'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}
	
	function datos_traduccion($id_traduccion) {
		
		$query = "SELECT *
		FROM traducciones
		WHERE id_traduccion='$id_traduccion'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	function actualizar_item_tabla_idiomas($key,$contenido,$idioma) {

		if ($idioma=='es') {
			$UpdateRecords = "UPDATE idiomas SET idioma_es='".addslashes($contenido)."', idioma='$contenido' WHERE id_idioma='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE idiomas SET idioma_$idioma='".addslashes($contenido)."' WHERE id_idioma='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
			
		}
	}
	
	function actualizar_item_tabla_categorias_enlaces($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE categorias_enlaces SET categoria='".addslashes($contenido)."' WHERE id_categoria_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE categorias_enlaces SET categoria_$idioma='".addslashes($contenido)."' WHERE id_categoria_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function datos_categoria_enlace($id_categoria_enlace) {
		
		$query = "SELECT *
		FROM categorias_enlaces
		WHERE id_categoria_enlace='$id_categoria_enlace'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	function actualizar_item_tabla_enlaces($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE enlaces SET enlace='".addslashes($contenido)."' WHERE id_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE enlaces SET enlace_$idioma='".addslashes($contenido)."' WHERE id_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords);
			mysql_close($connection);
		}

	}
	
	function actualizar_descripcion_item_tabla_enlaces($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE enlaces SET descripcion_enlace='".addslashes($contenido)."' WHERE id_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE enlaces SET descripcion_enlace_$idioma='".addslashes($contenido)."' WHERE id_enlace='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function datos_enlace($id_enlace) {
		
		$query = "SELECT *
		FROM enlaces
		WHERE id_enlace='$id_enlace'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	
	function actualizar_item_tabla_temas($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE temas SET tema='".addslashes($contenido)."' WHERE id_tema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE temas SET tema_$idioma='".addslashes($contenido)."' WHERE id_tema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function actualizar_item_tabla_temas_tmp($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE temas_tmp SET tema='".addslashes($contenido)."' WHERE id_tema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE temas_tmp SET tema_$idioma='".addslashes($contenido)."' WHERE id_tema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function actualizar_item_tabla_subtemas($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE subtemas SET subtema='".addslashes($contenido)."' WHERE id_subtema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE subtemas SET subtema_$idioma='".addslashes($contenido)."' WHERE id_subtema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function actualizar_item_tabla_subtemas_tmp($key,$contenido,$idioma) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE subtemas_tmp SET subtema='".addslashes($contenido)."' WHERE id_subtema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$UpdateRecords = "UPDATE subtemas_tmp SET subtema_$idioma='".addslashes($contenido)."' WHERE id_subtema='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function actualizar_item_tabla_material($key,$contenido,$idioma,$tabla,$campo,$id) {
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE $tabla SET $campo='".addslashes($contenido)."' WHERE $id='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$valor=$campo.'_'.$idioma;
			$UpdateRecords = "UPDATE $tabla SET $valor='".addslashes($contenido)."' WHERE $id='$key'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}

	}
	
	function datos_tabla_material($id_item,$tabla,$id) {
		
		$query = "SELECT *
		FROM $tabla
		WHERE $id='$id_item'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	function actualizar_item_noticia($id_noticia,$campo,$contenido,$idioma) {
		
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE noticias 
			SET $campo='".addslashes($contenido)."', fecha_modificacion='$fecha'
			WHERE id_noticia='$id_noticia'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		} else {
			$valor=$campo.'_'.$idioma;
			$UpdateRecords = "UPDATE noticias 
			SET $valor='".addslashes($contenido)."',fecha_modificacion='$fecha'
			WHERE id_noticia='$id_noticia'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}
		
	}
	
	function actualizar_item_tabla($tabla,$campo_indice,$item,$campo,$contenido,$idioma) {
				
		if ($idioma=='es') {
			$UpdateRecords = "UPDATE ".$tabla." 
			SET $campo='".addslashes($contenido)."'
			WHERE $campo_indice='$item'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords);
			mysql_close($connection);
		} else {
			$valor=$campo.'_'.$idioma;
			$UpdateRecords = "UPDATE ".$tabla."
			SET $valor='".addslashes($contenido)."'
			WHERE $campo_indice='$item'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 
			mysql_close($connection);
		}
		
	}
	
	function datos_tabla($tabla,$campo_busqueda,$id_item) {
		
		$query = "SELECT *
		FROM $tabla
		WHERE $campo_busqueda='$id_item'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	
	function datos_eu($id_eu) {
		
		$query = "SELECT *
		FROM ejemplos_uso
		WHERE id_eu='$id_eu'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
	function datos_eu2($id_eu) {
		
		$query = "SELECT *
		FROM eu, eu_descripcion
		WHERE eu.id_eu='$id_eu'
		AND eu.id_eu=eu_descripcion.id_eu";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);

		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return $result;
		}
		else {
			mysql_close($connection);
			return $row;
		}	
	
	}
	
//               FUNCION COMPROBAR LOGIN                      //
//*********************************************************//

	function comprobar_login($username) {
		$query = "SELECT * FROM colaboradores
		WHERE login='$username'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows=mysql_num_rows($result);
		mysql_close($connection);
		return $numrows;
	} // FIN DE LA FUNCION 
	
	
//               FUNCION COMPROBAR PERMISOS                      //
//*********************************************************//

	function permisos_usuario($id_usuario) {
		$query = "SELECT colaboradores.*, colaboradores_permisos.* 
		FROM colaboradores, colaboradores_permisos
		WHERE colaboradores.id_colaborador='$id_usuario'  
		AND colaboradores.id_colaborador=colaboradores_permisos.id_colaborador
		AND colaboradores.estado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	} // FIN DE LA FUNCION AUTENTIFICAR
	
//  LISTAR ULTIMOS SIMBOLOS PREDEFINIDOS AÑADIDOS            //
//*********************************************************//

	function ultimos_simbolos_predefinidos($limit,$registrado,$permisos) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		} else {
			if ($permisos['simbolos_especiales']==1) {
				$mostrar_registradas="AND simbolos.registrado < 3 ";
			} elseif ($permisos['simbolos_especiales']==0) {
				$mostrar_registradas="AND simbolos.registrado < 2 ";
			}
		}
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.estado=1 
		AND simbolos.id_palabra=palabras.id_palabra 
		AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo
		$mostrar_registradas
		ORDER BY simbolos.fecha_modificado desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR
	

//   LISTAR ULTIMOS SIMBOLOS AÑADIDOS  (solo la imagen)          //
//*********************************************************//

	function ultimos_simbolos($limit) {
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.estado=1 
		AND simbolos.id_palabra=palabras.id_palabra 
		AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo
		ORDER BY simbolos.fecha_modificado desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR


//   BUSCAR SIMBOLOS TEMPORAL         //
//*********************************************************//

	function buscar_si_existe_simbolo_tmp($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$sup_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inf_idioma,$inf_mayusculas,$inf_font,$id_imagen,$sup_id_traduccion,$inf_id_traduccion) {
		$query = "SELECT *
		FROM simbolos_temp
		WHERE id_palabra='$id_palabra' 
		AND id_tipo_simbolo='$id_tipo_simbolo'
		AND marco='$marco'
		AND contraste='$contraste'
		AND sup_con_texto='$sup_con_texto'
		AND sup_idioma='$sup_idioma'
		AND sup_mayusculas='$sup_mayusculas'
		AND sup_font='$sup_font'
		AND inf_con_texto='$inf_con_texto'
		AND inf_idioma='$inf_idioma'
		AND inf_mayusculas='$inf_mayusculas'
		AND inf_font='$inf_font'
		AND id_imagen='$id_imagen'
		AND sup_id_traduccion='$sup_id_traduccion'
		AND inf_id_traduccion='$inf_id_traduccion'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return 1;
		}
	} // FIN 

//   BUSCAR SIMBOLOS FINAL        //
//*********************************************************//

	function buscar_si_existe_simbolo_final($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$sup_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inf_idioma,$inf_mayusculas,$inf_font,$id_imagen,$sup_id_traduccion,$inf_id_traduccion) {
		$query = "SELECT *
		FROM simbolos
		WHERE id_palabra='$id_palabra' 
		AND id_tipo_simbolo='$id_tipo_simbolo'
		AND marco='$marco'
		AND contraste='$contraste'
		AND sup_con_texto='$sup_con_texto'
		AND sup_idioma='$sup_idioma'
		AND sup_mayusculas='$sup_mayusculas'
		AND sup_font='$sup_font'
		AND inf_con_texto='$inf_con_texto'
		AND inf_idioma='$inf_idioma'
		AND inf_mayusculas='$inf_mayusculas'
		AND inf_font='$inf_font'
		AND id_imagen='$id_imagen'
		AND sup_id_traduccion='$sup_id_traduccion'
		AND inf_id_traduccion='$inf_id_traduccion'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return 1;
		}
	} // FIN 

// 							AÑADIR NUEVO SIMBOLO TEMPORAL                     //
//******************************************************************************//
	function grabar_simbolo_tmp($id_palabra,$id_tipo_simbolo,$marco,$contraste,$sup_con_texto,$superior_idioma,$sup_mayusculas,$sup_font,$inf_con_texto,$inferior_idioma,$inf_mayusculas,$inf_font,$archivo_temporal,$sup_font_size,$sup_font_color,$inf_font_size,$inf_font_color,$id_imagen,$sup_id_traduccion,$inf_id_traduccion) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO simbolos_temp (id_palabra,id_tipo_simbolo,marco,contraste,sup_con_texto,sup_idioma,sup_mayusculas,sup_font,inf_con_texto,inf_idioma,inf_mayusculas,inf_font,fecha_alta,archivo_temporal,sup_font_size,sup_font_color,inf_font_size,inf_font_color,id_imagen,sup_id_traduccion,inf_id_traduccion) 
			VALUES ('$id_palabra','$id_tipo_simbolo','$marco','$contraste','$sup_con_texto','$superior_idioma','$sup_mayusculas','$sup_font','$inf_con_texto','$inferior_idioma','$inf_mayusculas','$inf_font','$fecha','$archivo_temporal','$sup_font_size','$sup_font_color','$inf_font_size','$inf_font_color','$id_imagen','$sup_id_traduccion','$inf_id_traduccion')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection); 
				//recibo el último id
				mysql_close($connection);
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

//               FUNCION COMPROBAR LOGIN                      //
//*********************************************************//

	function comprobar_si_existe_ya_video_lse_acepcion($id_palabra) {
		$query = "SELECT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_palabra='$id_palabra'
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=11";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows=mysql_num_rows($result);
		mysql_close($connection);
		return $numrows;
	} // FIN DE LA FUNCION 

//               FUNCION COMPROBAR SI EXISTE IMAGEN LSE    //
//*********************************************************//

	function comprobar_si_existe_ya_imagen_lse_acepcion($id_palabra) {
		$query = "SELECT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_palabra='$id_palabra'
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=12";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$result = mysql_query($query);
		$numrows=mysql_num_rows($result);
		mysql_close($connection);
		return $numrows;
	} // FIN DE LA FUNCION 
	
//   LISTAR IMAGENES ORGINALES PARA EXPORTAR     //
//*********************************************************//
function listar_imagenes_orginales_para_exportar($id_tipo_imagen) {

		$query = "SELECT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabra_imagen.id_palabra=palabras.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo_imagen'";
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;

}

//   LISTAR IMAGENES ORGINALES PARA EXPORTAR CON LIMITE   //
//*********************************************************//
function listar_imagenes_orginales_para_exportar_con_limite($id_tipo_imagen,$inicio,$fin) {

		$query = "SELECT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabra_imagen.id_palabra=palabras.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo_imagen'
		AND imagenes.id_imagen > $inicio
		AND imagenes.id_imagen < $fin";
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;

}

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_imagenes($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=2
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";
		
/*		$query = "SELECT imagenes.*, palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=2
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc";*/

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_imagenes_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=2
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";
		
		/*$query = "SELECT imagenes.*, palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=2
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT $inicial,$cantidad";*/

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_cliparts($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename, 
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=9
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_cliparts_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=9
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_pictogramas_byn($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=5
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	} 

//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function listar_pictogramas_byn_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=5
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";


		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
		
//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS         //
//*********************************************************//

	function listar_pictogramas_color($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=10
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_pictogramas_color_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=10
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} 
//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS         //
//*********************************************************//

	function listar_originales($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_tipo_pictograma,$sql,$txt_locate) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
			
		if (isset($sql) && $sql !='') { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
				'.$sql; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
		} else {
			
			if ($id_subtema==99999) { 
				$sql_subtema=''; 
				$subtema_tabla='';
				$subtema_tabla_from='';
			} 
			else { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
			
			}
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { 
		
			switch ($txt_locate) { 
			
				case 1:
				$sql_letra="AND palabras.palabra LIKE '$letra%%'";
				break;
				
				case 2:
				$sql_letra="AND palabras.palabra LIKE '%%$letra%%'";
				break;
				
				case 3:
				$sql_letra="AND palabras.palabra LIKE '%%$letra'"; 
				break;
				
				case 4:
				$sql_letra="AND palabras.palabra ='$letra'"; 
				break;
				
				default:
				$sql_letra="AND palabras.palabra LIKE '$letra%%'";
				break;
			
			}
			

		}
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT COUNT(*)
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$id_tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row[0];
		
	} 

//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_originales_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_tipo_pictograma,$sql,$txt_locate) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
			
		if (isset($sql) && $sql !='') { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
				'.$sql; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
		} else {
			
			if ($id_subtema==99999) { 
				$sql_subtema=''; 
				$subtema_tabla='';
				$subtema_tabla_from='';
			} 
			else { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
			
			}
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { 
		
			switch ($txt_locate) { 
			
				case 1:
				$sql_letra="AND palabras.palabra LIKE '$letra%%'";
				break;
				
				case 2:
				$sql_letra="AND palabras.palabra LIKE '%%$letra%%'";
				break;
				
				case 3:
				$sql_letra="AND palabras.palabra LIKE '%%$letra'"; 
				break;
				
				case 4:
				$sql_letra="AND palabras.palabra ='$letra'"; 
				break;
				
				default:
				$sql_letra="AND palabras.palabra LIKE '$letra%%'";
				break;
			
			}
		}
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT 
		imagenes.id_imagen,imagenes.imagen,
		palabras.definicion,palabras.palabra,
		palabras.id_palabra,palabras.id_tipo_palabra  
		$subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=$id_tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas	
		ORDER BY $sql_filtrado $orden
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			mysql_close($connection);
			return 0;
		}
		else {
			mysql_close($connection);
			return $result;
		}
	} 
	
//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS         //
//*********************************************************//

	function listar_pictogramas_idioma($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_idioma,$tipo_pictograma) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND traducciones.traduccion LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*, traducciones.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_pictogramas_idioma_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_idioma,$tipo_pictograma) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND traducciones.traduccion LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*, traducciones.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden 
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMOS PICTOGRAMAS COLOR AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_pictogramas_idioma_limit_optimizada($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_idioma,$tipo_pictograma) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND traducciones.traduccion LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_tipo_imagen,
		palabras.*, traducciones.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden 
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}
	
//   LISTAR ORIGINALES BUSCANDO POR IDIOMA         //
//*********************************************************//

	function listar_originales_idioma($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_idioma,$tipo_pictograma,$txt_locate,$sql) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
			
		if (isset($sql) && $sql !='') { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
				'.$sql; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
		} else {
			
			if ($id_subtema==99999) { 
				$sql_subtema=''; 
				$subtema_tabla='';
				$subtema_tabla_from='';
			} 
			else { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
			
			}
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { 
		
			switch ($txt_locate) { 
			
				case 1:
				$sql_letra="AND traducciones.traduccion LIKE '$letra%%'";
				break;
				
				case 2:
				$sql_letra="AND traducciones.traduccion LIKE '%%$letra%%'";
				break;
				
				case 3:
				$sql_letra="AND traducciones.traduccion LIKE '%%$letra'"; 
				break;
				
				case 4:
				$sql_letra="AND traducciones.traduccion='$letra'"; 
				break;
				
				default:
				$sql_letra="AND traducciones.traduccion LIKE '$letra%%'";
				break;
			
			}
			

		}	
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT COUNT(*)
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row[0];
		
	} 

//   LISTAR ORIGINALES BUSCANDO POR IDIOMA LIMIT          //
//*********************************************************//

	function listar_originales_idioma_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema,$id_idioma,$tipo_pictograma,$txt_locate,$sql) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if (isset($sql) && $sql !='') { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
				'.$sql; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
		} else {
			
			if ($id_subtema==99999) { 
				$sql_subtema=''; 
				$subtema_tabla='';
				$subtema_tabla_from='';
			} 
			else { 
				$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
				$subtema_tabla=',palabra_subtema.*';
				$subtema_tabla_from=', palabra_subtema';
			
			}
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { 
		
			switch ($txt_locate) { 
			
				case 1:
				$sql_letra="AND traducciones.traduccion LIKE '$letra%%'";
				break;
				
				case 2:
				$sql_letra="AND traducciones.traduccion LIKE '%%$letra%%'";
				break;
				
				case 3:
				$sql_letra="AND traducciones.traduccion LIKE '%%$letra'"; 
				break;
				
				case 4:
				$sql_letra="AND traducciones.traduccion='$letra'"; 
				break;
				
				default:
				$sql_letra="AND traducciones.traduccion LIKE '$letra%%'";
				break;
			
			}
			

		}
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT imagenes.id_imagen,imagenes.imagen,
		palabras.id_palabra,palabras.id_tipo_palabra,
		traducciones.traduccion,traducciones.explicacion,
		traducciones.id_traduccion,traducciones.id_idioma  
		$subtema_tabla
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden 
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}
	


//   BUSCAR ORIGINALES POR SUBTEMA BUSCANDO POR IDIOMA      //
//   ACTUALMENTE NO SE USA ESTA FUNCION                     //
//*********************************************************//

	function buscar_originales_idioma_por_subtema($id_subtema,$id_idioma,$tipo_pictograma) {
	
		$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
		$subtema_tabla=',palabra_subtema.*';
		$subtema_tabla_from=', palabra_subtema';	
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*, traducciones.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras, traducciones $subtema_tabla_from
		WHERE imagenes.estado=1
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.traduccion IS NOT NULL
		$sql_subtema	
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   BUSCAR ORIGINALES POR SUBTEMA      //
//*********************************************************//

	function buscar_originales_por_subtema($id_subtema,$tipo_pictograma) {
	
		$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.id_subtema='.$id_subtema.''; 
		$subtema_tabla=',palabra_subtema.*';
		$subtema_tabla_from=', palabra_subtema';	
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_subtema
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	}

//   BUSCAR ORIGINALES POR TEMA      //
//*********************************************************//

	function buscar_originales_por_tema($id_tema,$tipo_pictograma) {
	
		$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
			AND palabra_subtema.tema_id='.$id_tema.''; 
		$subtema_tabla=',palabra_subtema.*';
		$subtema_tabla_from=', palabra_subtema';	
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_subtema
		AND imagenes.id_tipo_imagen=$tipo_pictograma
		AND palabra_imagen.id_imagen=imagenes.id_imagen";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	}
	
//   LISTAR ULTIMOS SIGNOS LSE COLOR         //
//*********************************************************//

	function listar_lse_color($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=12
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMOS SIGNOS LSE COLOR AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_lse_color_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=12
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 

//   LISTAR ULTIMOS SIGNOS LSE B&N AÑADIDOS        //
//*********************************************************//

	function listar_lse_byn($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=13
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMOS SIGNOS LSE B&N AÑADIDOS LIMIT          //
//*********************************************************//

	function listar_lse_byn_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=13
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}
	
//   LISTAR ULTIMOS VIDEOS DE ACEPCIONES EN LSE         //
//*********************************************************//

	function listar_videos_acepciones_lse($registrado,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} 
		else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema	
		AND imagenes.id_tipo_imagen=11
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
		
	} 

//   LISTAR ULTIMOS VIDEOS DE ACEPCIONES EN LSE  LIMIT          //
//*********************************************************//

	function listar_videos_acepciones_lse_limit($registrado,$inicial,$cantidad,$id_tipo,$letra,$filtrado,$orden,$id_subtema) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_subtema==99999) { 
			$sql_subtema=''; 
			$subtema_tabla='';
			$subtema_tabla_from='';
		} else { 
			$sql_subtema='AND palabra_subtema.id_palabra=palabras.id_palabra
		AND palabra_subtema.id_subtema='.$id_subtema.''; 
			$subtema_tabla=',palabra_subtema.*';
			$subtema_tabla_from=', palabra_subtema';
		
		}
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($filtrado==1) { $sql_filtrado='imagenes.ultima_modificacion'; } 
		elseif ($filtrado==2) { $sql_filtrado='palabras.palabra'; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.* $subtema_tabla
		FROM palabra_imagen, imagenes, palabras $subtema_tabla_from
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_letra
		$sql_tipo
		$sql_subtema
		AND imagenes.id_tipo_imagen=11
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		ORDER BY $sql_filtrado $orden LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
	
	
//   LISTAR ORIGINALES PARA GENERADOR SIMBOLOS LIMIT          //
//*********************************************************//

	function listar_originales_limit_para_generador($inicial,$cantidad,$id_tipo_simbolo) {
			
		if ($id_tipo_simbolo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND imagenes.id_tipo_imagen='.$id_tipo_simbolo.''; }
			
		$query = "SELECT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		$sql_tipo
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		ORDER BY palabra_imagen.id_imagen asc
		LIMIT $inicial,$cantidad";
		
		//$query = "SELECT palabra_imagen.*, imagenes.*, palabras.*
//		FROM palabra_imagen, imagenes, palabras
//		WHERE imagenes.estado=1
//		AND palabra_imagen.id_palabra=8762
//		AND palabras.id_palabra=palabra_imagen.id_palabra
//		AND palabra_imagen.id_imagen=imagenes.id_imagen";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
	
//   LISTAR SIMBOLOS PROVISIONALES PARA REVISAR          //
//*********************************************************//

	function listar_simbolos_provisionales_limit($inicial,$cantidad) {
			
		$query = "SELECT *
		FROM simbolos_temp
		WHERE revisado = 0
		ORDER BY id_simbolo_tmp desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
		

		
			
//   LISTAR ULTIMAS IMAGENES AÑADIDAS  (solo la imagen)          //
//*********************************************************//

	function ultimas_imagenes($limit,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=2
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 


//   BUSCAR MATERIALES         //
//*********************************************************//

	function buscar_materiales($registrado,$texto_buscar,$licencia,$sql) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND material_estado=1";
		}
		
		if ($texto_buscar !='') {
			
			$sql_texto="AND (material_titulo LIKE '%$texto_buscar%' 
			OR material_descripcion LIKE '%$texto_buscar%' 
			OR material_objetivos LIKE '%$texto_buscar%') 
			";
		
		}
		
		$query = "SELECT COUNT(*) FROM materiales
		WHERE material_licencia = '$licencia'
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY fecha_alta desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows[0] == 0) {
			return false;
		}
		else {
			return $numrows[0];
		}
	} 

//   BUSCAR MATERIALES CON LIMITE         //
//*********************************************************//

	function buscar_materiales_limit($registrado,$texto_buscar,$licencia,$sql,$inicial,$cantidad) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND material_estado=1";
		}
		
		if ($texto_buscar !='') {
			
			$sql_texto="AND (material_titulo LIKE '%$texto_buscar%' 
			OR material_descripcion LIKE '%$texto_buscar%' 
			OR material_objetivos LIKE '%$texto_buscar%') 
			";
		
		}
		
		$query = "SELECT * FROM materiales
		WHERE material_licencia = '$licencia'
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return false;
		}
		else {
			return $result;
		}
	}

//   BUSCAR SOFTWARE         //
//*********************************************************//

	function buscar_software($registrado,$texto_buscar,$sql,$idioma) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND software_estado=1";
		}
		
		if ($texto_buscar !='' && $idioma=='es') {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional LIKE '%$texto_buscar%') 
			";
		
		} elseif ($texto_buscar !='' && $idioma!='es') {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion_".$idioma." LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo_".$idioma." LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional_".$idioma." LIKE '%$texto_buscar%') 
			";
		} else {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional LIKE '%$texto_buscar%') 
			";
		}
		
		$query = "SELECT COUNT(*) 
		FROM software, software_descripcion,software_objetivo,
		software_informacion_adicional
		WHERE software.id_software=software_descripcion.id_software
		AND software.id_software=software_objetivo.id_software
		AND software.id_software=software_informacion_adicional.id_software
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY fecha_alta desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows[0] == 0) {
			return false;
		}
		else {
			return $numrows[0];
		}
	} 

//   BUSCAR SOFTWARE CON LIMITE         //
//*********************************************************//

	function buscar_software_limit($registrado,$texto_buscar,$sql,$inicial,$cantidad,$idioma) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND software_estado=1";
		}
		
		if ($texto_buscar !='' && $idioma=='es') {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional LIKE '%$texto_buscar%') 
			";
		
		} elseif ($texto_buscar !='' && $idioma!='es') {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion_".$idioma." LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo_".$idioma." LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional_".$idioma." LIKE '%$texto_buscar%') 
			";
		} else {
			
			$sql_texto="AND (software.software_titulo LIKE '%$texto_buscar%' 
			OR software_descripcion.software_descripcion LIKE '%$texto_buscar%' 
			OR software_objetivo.software_objetivo LIKE '%$texto_buscar%'
			OR software_informacion_adicional.software_informacion_adicional LIKE '%$texto_buscar%') 
			";
		}
		
		$query = "SELECT software.*, software_descripcion.*,software_objetivo.*,
		software_informacion_adicional.* 
		FROM software, software_descripcion,software_objetivo,
		software_informacion_adicional
		WHERE software.id_software=software_descripcion.id_software
		AND software.id_software=software_objetivo.id_software
		AND software.id_software=software_informacion_adicional.id_software
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY software.software_destacado desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return false;
		}
		else {
			return $result;
		}
	}

//   BUSCAR EJEMPLOS DE USO         //
//*********************************************************//

	function buscar_eu($registrado,$texto_buscar,$sql,$idioma) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND eu_estado=1
			";
		}
		
		if ($texto_buscar !='' && $idioma=='es') {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion LIKE '%$texto_buscar%')  
			";
		
		} elseif ($texto_buscar !='' && $idioma!='es') {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion_".$idioma." LIKE '%$texto_buscar%') 
			";
		} else {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion LIKE '%$texto_buscar%') 
			";
		}
		
		$query = "SELECT COUNT(*) 
		FROM eu, eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY eu.fecha_alta desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows[0] == 0) {
			return false;
		}
		else {
			return $numrows[0];
		}
	} 

//   BUSCAR EJEMPLOS DE USO CON LIMITE         //
//*********************************************************//

	function buscar_eu_limit($registrado,$texto_buscar,$sql,$inicial,$cantidad,$idioma) {
	
		if ($registrado==false) {
			$mostrar_visibles="AND eu_estado=1
			";
		}
		
		if ($texto_buscar !='' && $idioma=='es') {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion LIKE '%$texto_buscar%') 
			";
		
		} elseif ($texto_buscar !='' && $idioma!='es') {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion_".$idioma." LIKE '%$texto_buscar%') 
			";
		} else {
			
			$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion LIKE '%$texto_buscar%')  
			";
		}
		
		$query = "SELECT eu.*, eu_descripcion.*
		FROM eu, eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY eu.eu_destacado desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return false;
		}
		else {
			return $result;
		}
	}
	
//   BUSCAR EJEMPLOS DE USO COMPLETO         //
//*********************************************************//

	function buscar_eu_completo($texto_buscar,$sql) {
	
		$mostrar_visibles="AND eu_estado=1
		";
		$idioma=='es';
			
		$sql_texto="AND (eu.eu_titulo LIKE '%$texto_buscar%' 
			OR eu_descripcion.eu_descripcion LIKE '%$texto_buscar%')  
		";
		
		$query = "SELECT eu.*, eu_descripcion.*
		FROM eu, eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		$sql
		$sql_texto
		$mostrar_visibles
		ORDER BY eu.id_eu desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return false;
		}
		else {
			return $result;
		}
	}
	
		
//   LISTAR ULTIMOS CLIPARTS  (solo la imagen)          //
//*********************************************************//

	function ultimos_cliparts($limit,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=9
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMOS PICTOGRAMAS COLOR  (solo la imagen)          //
//*********************************************************//

	function ultimos_pictogramas_color($limit,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=10
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMOS PICTOGRAMAS BYN  (solo la imagen)          //
//*********************************************************//

	function ultimos_pictogramas_byn($limit,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen=5
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMOS PICTOGRAMAS    //
//*********************************************************//

	function ultimos_pictogramas_limit($limit,$id_tipo_imagen,$registrado) {
		
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
			
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen
		WHERE imagenes.estado=1 
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra=palabras.id_palabra 
		AND imagenes.id_tipo_imagen=tipos_imagen.id_tipo
		AND imagenes.id_tipo_imagen='$id_tipo_imagen'
		$mostrar_registradas
		ORDER BY imagenes.ultima_modificacion desc LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//   LISTAR ULTIMAS NOTICIAS VISIBLES        //
//*********************************************************//

	function ultimas_noticias_publicadas($limit) {
	
		$query = "SELECT noticias.*, colaboradores.*
		FROM noticias, colaboradores
		WHERE noticias.id_colaborador=colaboradores.id_colaborador
		AND noticias.estado=1
		ORDER BY noticias.fecha_insercion desc
		LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
	
//   LISTAR ULTIMAS NOTICIAS          //
//*********************************************************//

	function ultimas_noticias($limit) {
	
		
		$query = "SELECT noticias.*, colaboradores.*
		FROM noticias, colaboradores
		WHERE noticias.id_colaborador=colaboradores.id_colaborador
		ORDER BY noticias.fecha_insercion desc
		LIMIT 0,$limit";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 

//   LISTAR ULTIMAS NOTICIAS          //
//*********************************************************//

	function listar_noticias() {
	
		$query = "SELECT *
		FROM noticias
		ORDER BY id_noticia desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} 

//   LISTAR NOTICIAS          //
//*********************************************************//

	function listar_noticias_limit($inicial,$cantidad) {
	
		$query = "SELECT noticias.*, colaboradores.*
		FROM noticias, colaboradores
		WHERE noticias.id_colaborador=colaboradores.id_colaborador
		AND noticias.estado=1
		ORDER BY noticias.fecha_insercion desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMAS NOTICIAS          //
//*********************************************************//

	function listar_noticias_idioma($idioma) {
	
		$query = "SELECT *
		FROM noticias
		WHERE titulo_$idioma != ''
		ORDER BY id_noticia desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} 

	function listar_noticias_idioma_limit($idioma,$inicial,$cantidad) {
	
		$query = "SELECT noticias.*, colaboradores.*
		FROM noticias, colaboradores
		WHERE noticias.id_colaborador=colaboradores.id_colaborador
		AND noticias.titulo_$idioma != ''
		AND noticias.estado=1
		ORDER BY noticias.fecha_insercion desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMOS MATERIALES VISIBLES        //
//*********************************************************//

	function ultimos_materiales_publicados() {
	
		
		$query = "SELECT COUNT(*)
		FROM materiales, licencias
		WHERE materiales.material_licencia=licencias.id_licencia
		AND materiales.material_estado=1
		ORDER BY materiales.fecha_alta desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows[0] == 0) {
			return 0;
		}
		else {
			return $numrows[0];
		}
	} 
	
//   LISTAR ULTIMOS MATERIALES VISIBLES CON LIMITE       //
//*********************************************************//

	function ultimos_materiales_publicados_limit($inicial,$cantidad) {
	
		
		$query = "SELECT materiales.*, licencias.*
		FROM materiales, licencias
		WHERE materiales.material_licencia=licencias.id_licencia
		AND materiales.material_estado=1
		ORDER BY materiales.fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 

//   LISTAR ULTIMOS MATERIALES VISIBLES CON LIMITE       //
//*********************************************************//

	function ultimos_eu_publicados_limit($inicial,$cantidad) {
	
		$query = "SELECT eu.*, eu_descripcion.*
		FROM eu, eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		AND eu.eu_estado=1
		ORDER BY eu.fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 	
//   LISTAR ULTIMAS FICHAS SOFTWARE        //
//*********************************************************//

	function ultimas_fichas_software() {
	
		$query = "SELECT COUNT(1) FROM software";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$rows = mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	} 
	
//   LISTAR LISTAR ULTIMAS FICHAS SOFTWARE CON LIMITE       //
//*********************************************************//

	function ultimas_fichas_software_limit($inicial,$cantidad) {
	
		
		$query = "SELECT software.*, software_descripcion.*, software_informacion_adicional.*, software_objetivo.*, licencias.*
		FROM software, software_descripcion, software_informacion_adicional, software_objetivo, licencias
		WHERE software.id_software=software_descripcion.id_software
		AND software.id_software=software_informacion_adicional.id_software
		AND software.id_software=software_objetivo.id_software
		AND software.software_licencia=licencias.id_licencia
		ORDER BY software.fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}


//   LISTAR ULTIMAS FICHAS SOFTWARE        //
//*********************************************************//

	function ultimas_fichas_eu() {
	
		$query = "SELECT COUNT(1) FROM eu";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$rows = mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	} 
	
//   LISTAR LISTAR ULTIMAS FICHAS SOFTWARE CON LIMITE       //
//*********************************************************//

	function ultimas_fichas_eu_limit($inicial,$cantidad) {
	
		
		$query = "SELECT eu.*, eu_descripcion.*
		FROM eu, eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		ORDER BY eu.fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}


//   LISTAR ULTIMAS FICHAS SOFTWARE DESTACADO       //
//*********************************************************//

	function ultimas_fichas_software_destacado() {
	
		$query = "SELECT COUNT(1) FROM software WHERE software_destacado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$rows = mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	} 
	
//   LISTAR LISTAR ULTIMAS FICHAS SOFTWARE CON LIMITE DESTACADO       //
//*********************************************************//

	function ultimas_fichas_software_destacado_limit($inicial,$cantidad) {
	
		
		$query = "SELECT software.*, software_descripcion.*, software_informacion_adicional.*, software_objetivo.*, licencias.*
		FROM software, software_descripcion, software_informacion_adicional, software_objetivo, licencias
		WHERE software.id_software=software_descripcion.id_software
		AND software.id_software=software_informacion_adicional.id_software
		AND software.id_software=software_objetivo.id_software
		AND software.software_licencia=licencias.id_licencia
		AND software.software_destacado=1
		ORDER BY RAND()
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}

//   LISTAR ULTIMAS FICHAS EJEMPLOS USO DESTACADO       //
//*********************************************************//

	function ultimas_fichas_eu_destacado() {
	
		$query = "SELECT COUNT(1) FROM eu WHERE eu_destacado=1";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$rows = mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	} 
	
//   LISTAR LISTAR ULTIMAS FICHAS EJEMPLOS DE USO CON LIMITE DESTACADO       //
//*********************************************************//

	function ultimas_fichas_eu_destacado_limit($inicial,$cantidad) {
	
		
		$query = "SELECT eu.*, eu_descripcion.*	
		FROM eu,eu_descripcion
		WHERE eu.id_eu=eu_descripcion.id_eu
		AND eu.eu_destacado=1
		ORDER BY RAND()
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}
	

	
//   DATOS FICHA SOFTWARE       //
//*********************************************************//

	function datos_software($id) {
		
		$query = "SELECT software.*, software_descripcion.*, software_informacion_adicional.*, software_objetivo.*, licencias.*
		FROM software, software_descripcion, software_informacion_adicional, software_objetivo, licencias
		WHERE software.id_software=$id
		AND software.id_software=software_descripcion.id_software
		AND software.id_software=software_informacion_adicional.id_software
		AND software.id_software=software_objetivo.id_software
		AND software.software_licencia=licencias.id_licencia";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	}

//   DATOS FICHA EJEMPLO DE USO       //
//*********************************************************//

	function datos_ficha_eu($id) {
		
		$query = "SELECT eu.*, eu_descripcion.*
		FROM eu, eu_descripcion
		WHERE eu.id_eu=$id
		AND eu.id_eu=eu_descripcion.id_eu";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	}
//                   FUNCION DATOS TIPO SOFTWARE        //
//******************************************************************************//	

	function datos_tipo_software($id_tipo) {
		$query = "SELECT software_tipo.*
		FROM software_tipo
		WHERE software_tipo.id_tipo_software='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}

//                   FUNCION DATOS TIPO EJEMPLO DE USO       //
//******************************************************************************//	

	function datos_tipo_eu($id_tipo) {
		$query = "SELECT eu_tipo.*
		FROM eu_tipo
		WHERE eu_tipo.id_tipo_eu='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}
//                   FUNCION DATOS TIPO SISTEMA OPERATIVO        //
//******************************************************************************//	

	function datos_so($id_so) {
		$query = "SELECT software_so.*
		FROM software_so
		WHERE software_so.id_so='$id_so'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}
	
//   LISTAR ULTIMOS MATERIALES          //
//*********************************************************//

	function ultimos_materiales() {
	
		
		$query = "SELECT materiales.*, licencias.*
		FROM materiales, licencias
		WHERE materiales.material_licencia=licencias.id_licencia
		ORDER BY materiales.fecha_alta desc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	}
	
//   LISTAR ULTIMOS MATERIALES CON LIMITE         //
//*********************************************************//

	function ultimos_materiales_limit($inicial,$cantidad) {
	
		
		$query = "SELECT materiales.*, licencias.*
		FROM materiales, licencias
		WHERE materiales.material_licencia=licencias.id_licencia
		ORDER BY materiales.fecha_alta desc
		LIMIT $inicial,$cantidad";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} 
	
//   			LISTADO DE DIRECTORIO RAIZ POR USUARIO			//
//***************************************************************************//

function directorio_raiz($id_usuario) {
		
		$query = "SELECT * FROM repositorio_directorios WHERE id_usuario='$id_usuario' AND parent=0";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row['id'];
		}
	} 
	
//   			LISTADO DE DIRECTORIOS DEL REPOSITORIO POR USUARIO			//
//***************************************************************************//

function listado_directorios($id_usuario,$parent) {
		
		$query = "SELECT * FROM repositorio_directorios WHERE id_usuario='$id_usuario' AND parent='$parent'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} 

//   			LISTADO DE DIRECTORIOS POR USUARIO			//
//***************************************************************************//

function listado_directorios_usuario($id_usuario) {
		
		$query = "SELECT * FROM repositorio_directorios WHERE id_usuario='$id_usuario'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} 

//   			LISTADO DE TEMAS SIMBOLOS				//
//*********************************************************//

function datos_subtema($id_subtema) {

		$query = "SELECT temas.*,subtemas.* 
		FROM temas,subtemas 
		WHERE subtemas.id_subtema='$id_subtema'
		AND subtemas.id_tema=temas.id_tema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR

function datos_subtema_tmp($id_subtema) {

		$query = "SELECT temas_tmp.*,subtemas_tmp.* 
		FROM temas_tmp,subtemas_tmp 
		WHERE subtemas_tmp.id_subtema='$id_subtema'
		AND subtemas_tmp.id_tema=temas_tmp.id_tema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR
	
//   			LISTADO DE TEMAS SIMBOLOS				//
//*********************************************************//

function datos_tema($id_tema) {

		$query = "SELECT * 
		FROM temas 
		WHERE id_tema='$id_tema'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR

function datos_tema_tmp($id_tema) {

		$query = "SELECT * 
		FROM temas_tmp 
		WHERE id_tema='$id_tema'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $row;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR
	
//   			LISTADO DE TEMAS SIMBOLOS				//
//*********************************************************//

function listado_temas() {

		$query = "SELECT * FROM temas ORDER BY tema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR


//   LISTADO DE TEMAS SIMBOLOS POR IDIOMAS				//
//*********************************************************//

function listado_temas_idiomas($idioma) {

		$query = "SELECT * FROM temas ORDER BY tema_$idioma";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} // FIN DE LA FUNCION 
	
function listado_temas_tmp() {

		$query = "SELECT * FROM temas_tmp ORDER BY tema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR

//   			LISTADO DE SUBTEMAS SIMBOLOS				//
//*********************************************************//
function listado_subtemas_completo() {

		$query = "SELECT * FROM subtemas ORDER BY subtema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
} // FIN DE LA FUNCION AUTENTIFICAR

//   			LISTADO DE SUBTEMAS SIMBOLOS				//
//*********************************************************//
function listado_subtemas_completo_tmp() {

		$query = "SELECT * FROM subtemas_tmp ORDER BY subtema";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
} // FIN 

//   			LISTADO DE SUBTEMAS SIMBOLOS				//
//*********************************************************//

function listado_subtemas($id_tema,$limit) {

		if ($limit=='') { $limite=''; } else { $limite='LIMIT 0,'.$limit; }

		$query = "SELECT subtemas.*,temas.* 
		FROM subtemas, temas 
		WHERE subtemas.id_tema='$id_tema'
		AND temas.id_tema='$id_tema'
		ORDER BY subtemas.subtema asc
		$limite";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} // FIN 

//   LISTADO DE SUBTEMAS SIMBOLOS POR IDIOMA ORDENADO POR ESE IDIOMA	//
//*********************************************************//

function listado_subtemas_idiomas($id_tema,$limit,$idioma) {

		if ($limit=='') { $limite=''; } else { $limite='LIMIT 0,'.$limit; }

		$query = "SELECT subtemas.*,temas.* 
		FROM subtemas, temas 
		WHERE subtemas.id_tema='$id_tema'
		AND temas.id_tema='$id_tema'
		ORDER BY subtemas.subtema_$idioma asc
		$limite";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} // FIN
	
//   			LISTADO DE SUBTEMAS SIMBOLOS TMP		   //
//*********************************************************//

function listado_subtemas_tmp($id_tema,$limit) {

		if ($limit=='') { $limite=''; } else { $limite='LIMIT 0,'.$limit; }

		$query = "SELECT subtemas_tmp.*,temas_tmp.* 
		FROM subtemas_tmp, temas_tmp 
		WHERE subtemas_tmp.id_tema='$id_tema'
		AND temas_tmp.id_tema='$id_tema'
		ORDER BY subtemas_tmp.subtema asc
		$limite";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	} // FIN 

//   			LISTADO DE SUBTEMAS DE UNA PALABRA				//
//*********************************************************//

function listado_subtemas_palabra($id_palabra) {

		$query = "SELECT subtemas.*,temas.*, palabra_subtema.* 
		FROM subtemas, temas, palabra_subtema
		WHERE palabra_subtema.id_palabra='$id_palabra'
		AND subtemas.id_subtema=palabra_subtema.id_subtema
		AND temas.id_tema=subtemas.id_tema
		ORDER BY subtemas.subtema asc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR

//   LISTADO DE SUBTEMAS DE UNA PALABRA EN TABLA TEMPORAL			//
//*********************************************************//

function listado_subtemas_palabra_tmp($id_palabra) {

		$query = "SELECT subtemas_tmp.*,temas_tmp.*, palabra_subtema_tmp.* 
		FROM subtemas_tmp, temas_tmp, palabra_subtema_tmp
		WHERE palabra_subtema_tmp.id_palabra='$id_palabra'
		AND subtemas_tmp.id_subtema=palabra_subtema_tmp.id_subtema
		AND temas_tmp.id_tema=subtemas_tmp.id_tema
		ORDER BY subtemas_tmp.subtema asc";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);

		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return 0;
		}
		else {
			return $result;
		}
	} // FIN DE LA FUNCION AUTENTIFICAR
	
//                   FUNCION LISTAR FUENTES SIMBOLOS                             //
//******************************************************************************//	

	function listar_fuentes_simbolos() {
		$query = "SELECT fuentes_simbolos.*
		FROM fuentes_simbolos
		ORDER BY nombre_fuente";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR CATEGORIAS DE SIMBOLOS         //
//******************************************************************************//	

	function listar_categorias_simbolos() {
		$query = "SELECT tipos_simbolos.*
		FROM tipos_simbolos
		ORDER BY tipo_simbolo";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR CATEGORIAS DE ENLACES //
//******************************************************************************//	

	function listar_categorias_enlaces() {
		$query = "SELECT categorias_enlaces.*
		FROM categorias_enlaces
		ORDER BY orden";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);		
		return $result;
	}

//                   FUNCION LISTAR PLANTILLAS PANELES  //
//******************************************************************************//	

	function listar_plantillas_paneles() {
		$query = "SELECT paneles_plantillas.*
		FROM paneles_plantillas
		ORDER BY id_plantilla";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);		
		return $result;
	}

//                   FUNCION DATOS PLANTILLA DE PANELES  //
//******************************************************************************//	

	function datos_plantilla_panel($id_plantilla) {
		$query = "SELECT paneles_plantillas.*
		FROM paneles_plantillas
		WHERE paneles_plantillas.id_plantilla='$id_plantilla'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}
		
//                   FUNCION LISTAR MIS SELECCIONES //
//******************************************************************************//	

	function listar_mis_selecciones($id_usuario) {
		$query = "SELECT seleccion.*
		FROM seleccion
		WHERE id_usuario='$id_usuario'
		ORDER BY fecha_modificacion DESC";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
		
//                   FUNCION LISTAR ENLACES POR CATEGORIAS                       //
//******************************************************************************//	
	function listar_enlaces_por_categoria($id_categoria) {
	
		$query = "SELECT categorias_enlaces.*, enlaces.*
		FROM categorias_enlaces, enlaces
		WHERE enlaces.id_categoria_enlace = '$id_categoria'
		AND enlaces.enlace_activo = 1
		AND enlaces.id_categoria_enlace = categorias_enlaces.id_categoria_enlace
		ORDER BY enlaces.id_enlace";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	
	
	}

//                   FUNCION LISTAR ENLACES DESTACDOS                       //
//******************************************************************************//	
	function listar_enlaces_destacados() {
	
		$query = "SELECT categorias_enlaces.*, enlaces.*
		FROM categorias_enlaces, enlaces
		WHERE enlaces.destacado = 1
		AND enlaces.enlace_activo = 1
		AND enlaces.id_categoria_enlace = categorias_enlaces.id_categoria_enlace
		ORDER BY enlaces.id_enlace";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	
	
	}

//                   FUNCION LISTAR ENLACES                       //
//******************************************************************************//	
	function listar_enlaces() {
	
		$query = "SELECT *
		FROM enlaces
		ORDER BY id_enlace";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	
	
	}

//                   FUNCION LISTAR EJEMPLOS DE USO                       //
//******************************************************************************//	
	function listar_ejemplos_uso() {
	
		$query = "SELECT *
		FROM ejemplos_uso
		WHERE estado = 1
		ORDER BY id_eu desc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	
	
	}
	
//                   FUNCION LISTAR SIMBOLOS         //
//******************************************************************************//	

	function listar_simbolos($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($idioma==99) { $sql_idioma=''; } 
		elseif ($idioma==98) { $sql_idioma='AND simbolos.castellano=1'; }
		elseif ($idioma==97) { $sql_idioma='AND simbolos.castellano=0 AND simbolos.id_idioma=0'; } 
		else { $sql_idioma='AND simbolos.id_idioma='.$idioma.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_idioma
		$mostrar_registradas
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS CON LIMITE        //
//******************************************************************************//	

	function listar_simbolos_limit($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$inicial,$cantidad,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($idioma==99) { $sql_idioma=''; } 
		elseif ($idioma==98) { $sql_idioma='AND simbolos.castellano=1'; }
		elseif ($idioma==97) { $sql_idioma='AND simbolos.castellano=0 AND simbolos.id_idioma=0'; } 
		else { $sql_idioma='AND simbolos.id_idioma='.$idioma.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_idioma
		$mostrar_registradas
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS ESPECIALES        //
//******************************************************************************//	

	function listar_simbolos_especiales($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos_especiales.registrado=0";
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($idioma==99) { $sql_idioma=''; } 
		elseif ($idioma==98) { $sql_idioma='AND simbolos_especiales.castellano=1'; }
		elseif ($idioma==97) { $sql_idioma='AND simbolos_especiales.castellano=0 AND simbolos_especiales.id_idioma=0'; } 
		else { $sql_idioma='AND simbolos_especiales.id_idioma='.$idioma.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos_especiales.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos_especiales.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos_especiales.*, palabras.*, tipos_simbolos.*
		FROM simbolos_especiales, palabras, tipos_simbolos
		WHERE simbolos_especiales.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_idioma
		$mostrar_registradas
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS ESPECIALES CON LIMITE        //
//******************************************************************************//	

	function listar_simbolos_especiales_limit($id_tipo_palabra,$letra,$id_tipo_simbolo,$idioma,$inicial,$cantidad,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos_especiales.registrado=0";
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($idioma==99) { $sql_idioma=''; } 
		elseif ($idioma==98) { $sql_idioma='AND simbolos_especiales.castellano=1'; }
		elseif ($idioma==97) { $sql_idioma='AND simbolos_especiales.castellano=0 AND simbolos_especiales.id_idioma=0'; } 
		else { $sql_idioma='AND simbolos_especiales.id_idioma='.$idioma.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos_especiales.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos_especiales.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos_especiales.*, palabras.*, tipos_simbolos.*
		FROM simbolos_especiales, palabras, tipos_simbolos
		WHERE simbolos_especiales.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_idioma
		$mostrar_registradas
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS ARASAAC        //
//******************************************************************************//	

	function listar_simbolos_arasaac($id_tipo_palabra,$letra,$id_tipo_simbolo,$registrado,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($minusculas == 1 && $mayusculas == 1) {
		 	$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		} elseif ($minusculas == 1) { 
		    $sql_mayusculas='AND (simbolos.inf_mayusculas=0)';
		} elseif ($mayusculas == 1) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1)';
		} elseif ($minusculas == 0 && $mayusculas == 0) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		}
		
		
		if ($castellano==0 &&($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1)) {  
		
			$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
			$sql_idioma_inferior='AND (simbolos.inf_idioma=99999 ';
					if ($castellano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=0 '; } 
					if ($ruso==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=7 '; }
					if ($frances==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=9 '; }   
			$sql_idioma_inferior.= ' )';			
		
		} elseif ($castellano==1) { 
		
			if ($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1) {
			
			$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			$sql_idioma_superior='AND (simbolos.inf_idioma=99999 ';
					if ($ruso==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=7 '; }
					if ($frances==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=9 '; }   
			$sql_idioma_superior.= ' )';
			
			} elseif ($ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
			
				$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			
			}
		
		} elseif ($castellano==0 && $ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0)  {
		
			$sql_idioma_inferior='';
			$sql_idioma_inferior='';
		}
		
		if ($tipo_letra==99) { $sql_tipo_letra=''; } 
		else { $sql_tipo_letra='AND (simbolos.sup_font='.$tipo_letra.' OR simbolos.inf_font='.$tipo_letra.')'; }
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($marco==99) { $sql_marco=''; } 
		else { $sql_marco='AND simbolos.marco='.$marco.''; }
		
		if ($contraste==99) { $sql_contraste=''; } 
		else { $sql_contraste='AND simbolos.contraste='.$contraste.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_marco
		$sql_contraste
		$sql_tipo_letra
		$sql_mayusculas
		$sql_idioma_inferior
		$sql_idioma_superior
		$mostrar_registradas
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS CON LIMITE        //
//******************************************************************************//	

	function listar_simbolos_arasaac_limit($id_tipo_palabra,$letra,$id_tipo_simbolo,$inicial,$cantidad,$registrado,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($castellano==0 &&($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1)) {  
		
			$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
			$sql_idioma_inferior='AND (simbolos.inf_idioma=99999 ';
					if ($castellano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=0 '; } 
					if ($ruso==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=7 '; }
					if ($frances==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=9 '; }   
			$sql_idioma_inferior.= ' )';			
		
		} elseif ($castellano==1) { 
		
			if ($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1) {
			
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
				$sql_idioma_superior='AND (simbolos.inf_idioma=99999 ';
						if ($ruso==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=1 '; } 
						if ($rumano==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=2 '; } 
						if ($arabe==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=3 '; } 
						if ($chino==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=4 '; } 
						if ($bulgaro==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=5 '; } 
						if ($polaco==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=6 '; } 
						if ($ingles==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=7 '; }
						if ($frances==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=8 '; }
						if ($catalan==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=9 '; }   
				$sql_idioma_superior.= ' )';
			
			} elseif ($ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
			
				$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			
			}
		
		
		} elseif ($castellano==0 && $ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
		
			$sql_idioma_inferior='';
			$sql_idioma_inferior='';
		}
		
		
		if ($minusculas == 1 && $mayusculas == 1) {
		 	$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		} elseif ($minusculas == 1) { 
		    $sql_mayusculas='AND (simbolos.inf_mayusculas=0)';
		} elseif ($mayusculas == 1) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1)';
		} elseif ($minusculas == 0 && $mayusculas == 0) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		}
		
		if ($tipo_letra==99) { $sql_tipo_letra=''; } 
		else { $sql_tipo_letra='AND (simbolos.sup_font='.$tipo_letra.' OR simbolos.inf_font='.$tipo_letra.')'; }
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($marco==99) { $sql_marco=''; } 
		else { $sql_marco='AND simbolos.marco='.$marco.''; }
		
		if ($contraste==99) { $sql_contraste=''; } 
		else { $sql_contraste='AND simbolos.contraste='.$contraste.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_marco
		$sql_contraste
		$sql_tipo_letra
		$mostrar_registradas
		$sql_mayusculas
		$sql_idioma_inferior
		$sql_idioma_superior
		AND palabras.palabra LIKE '$sql_letra%%'
		ORDER BY palabras.palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS POR CATEGORIAS        //
//******************************************************************************//	

	function listar_palabras_categorias($id_tema,$id_subtema) {
	
		if ($id_subtema=='') { $sql_subtema=''; } 
		else { $sql_subtema='AND palabra_subtema.id_subtema='.$id_subtema.''; }
		
		$query = "SELECT palabras.*, palabra_subtema.*, temas.*, subtemas.*
		FROM palabras, palabra_subtema, temas, subtemas
		WHERE palabra_subtema.id_palabra=palabras.id_palabra 
		$sql_subtema
		AND palabra_subtema.id_subtema=subtemas.id_subtema
		AND subtemas.id_tema=temas.id_tema
		AND temas.id_tema='$id_tema'
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_palabras_categorias_limit($id_tema,$id_subtema,$inicial,$cantidad) {
	
		if ($id_subtema=='') { $sql_subtema=''; } 
		else { $sql_subtema='AND palabra_subtema.id_subtema='.$id_subtema.''; }
		
		$query = "SELECT palabras.*, palabra_subtema.*, temas.*, subtemas.*
		FROM palabras, palabra_subtema, temas, subtemas
		WHERE palabra_subtema.id_palabra=palabras.id_palabra 
		$sql_subtema
		AND palabra_subtema.id_subtema=subtemas.id_subtema
		AND subtemas.id_tema=temas.id_tema
		AND temas.id_tema='$id_tema'
		ORDER BY palabras.palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS POR CATEGORIAS        //
//******************************************************************************//	

	function listar_palabras_catalogadas_por_tema($id_tema) {
		
		$query = "SELECT palabras.*, palabra_subtema_tmp.*, temas_tmp.*, subtemas_tmp.*
		FROM palabras, palabra_subtema_tmp, temas_tmp, subtemas_tmp
		WHERE palabra_subtema_tmp.tema_id='$id_tema'
		AND palabra_subtema_tmp.id_palabra=palabras.id_palabra 
		AND palabra_subtema_tmp.id_subtema=subtemas_tmp.id_subtema
		AND palabra_subtema_tmp.tema_id=temas_tmp.id_tema
		GROUP BY palabra_subtema_tmp.id_palabra
		ORDER BY palabras.id_palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_palabras_catalogadas_por_tema_limit($id_tema,$inicial,$cantidad) {
		
		$query = "SELECT palabras.*, palabra_subtema_tmp.*, temas_tmp.*, subtemas_tmp.*
		FROM palabras, palabra_subtema_tmp, temas_tmp, subtemas_tmp
		WHERE palabra_subtema_tmp.tema_id='$id_tema'
		AND palabra_subtema_tmp.id_palabra=palabras.id_palabra 
		AND palabra_subtema_tmp.id_subtema=subtemas_tmp.id_subtema
		AND palabra_subtema_tmp.tema_id=temas_tmp.id_tema
		GROUP BY palabra_subtema_tmp.id_palabra
		ORDER BY palabras.id_palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR OTRAS PALABRAS ASOCIADAS A UNA IMAGEN        //
//******************************************************************************//
	function palabras_asociadas($id_imagen,$id_palabra) {
	
		$query = "SELECT palabras.*, palabra_imagen.*
		FROM palabras, palabra_imagen
		WHERE palabra_imagen.id_imagen='$id_imagen' 
		AND palabra_imagen.id_palabra=palabras.id_palabra
		AND palabra_imagen.id_palabra <> '$id_palabra'
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);		
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
		
	
	}
	
//                   FUNCION LISTAR TODAS LAS PALABRAS DICCIONARIO              //
//******************************************************************************//	

	function listar_diccionario() {
			
		$query = "SELECT palabras.*
		FROM palabras
		ORDER BY palabras.id_palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR PALABRAS PARA GESTION         //
//******************************************************************************//	

	function listar_diccionario_palabras($id_tipo,$letra) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT palabras.*
		FROM palabras
		WHERE palabras.palabra LIKE '$sql_letra%%' $sql_tipo  
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_diccionario_palabras_limit($id_tipo,$letra,$inicial,$cantidad) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT palabras.*
		FROM palabras
		WHERE palabras.palabra LIKE '$sql_letra%%' $sql_tipo  
		ORDER BY palabras.palabra asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


//        FUNCION LISTAR PALABRAS PARA GESTION INCLUYENDO TIPO DE IMAGEN        //
//******************************************************************************//	

	function listar_diccionario_palabras_con_imagenes_por_tipo_imagen($id_tipo,$letra,$id_tipo_imagen) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($id_tipo_imagen==99) { $sql_tipo_imagen=''; } 
		else { $sql_tipo_imagen='AND imagenes.id_tipo_imagen='.$id_tipo_imagen.''; }
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		$query = "SELECT DISTINCT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$sql_letra
		$sql_tipo	
		$sql_tipo_imagen
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

// FUNCION LISTAR PALABRAS PARA GESTION INCLUYENDO TIPO DE IMAGEN CON LIMITE     //
//******************************************************************************//	

	function listar_diccionario_palabras_con_imagenes_limit_por_tipo_imagen($id_tipo,$letra,$inicial,$cantidad,$id_tipo_imagen) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=="") { $sql_letra=''; } 
		else { $sql_letra="AND palabras.palabra LIKE '$letra%%'"; }
		
		if ($id_tipo_imagen==99) { $sql_tipo_imagen=''; } 
		else { $sql_tipo_imagen='AND imagenes.id_tipo_imagen='.$id_tipo_imagen.''; }
		
		$query = "SELECT DISTINCT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,imagenes.ultima_modificacion,
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE imagenes.estado=1
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$sql_letra
		$sql_tipo	
		$sql_tipo_imagen
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


	
//                   FUNCION LISTAR PALABRAS PARA GESTION         //
//******************************************************************************//	

	function listar_diccionario_palabras_con_imagenes($id_tipo,$letra) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT palabras.*, palabra_imagen.* 
		FROM palabras, palabra_imagen
		WHERE palabras.palabra LIKE '$sql_letra%%' $sql_tipo 
		AND  palabras.id_palabra = palabra_imagen.id_palabra
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_diccionario_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT palabras.*, palabra_imagen.*
		FROM palabras, palabra_imagen
		WHERE palabras.palabra LIKE '$sql_letra%' $sql_tipo  
		AND  palabras.id_palabra = palabra_imagen.id_palabra
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION         //
//******************************************************************************//	

	function listar_diccionario_idiomas_palabras_con_imagenes($id_tipo,$letra,$id_idioma) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT traducciones.*, palabra_imagen.*, palabras.*
		FROM traducciones, palabra_imagen, palabras
		WHERE traducciones.traduccion LIKE '$sql_letra%%' 
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra = palabra_imagen.id_palabra
		AND traducciones.id_palabra = palabras.id_palabra
		$sql_tipo 
		GROUP BY traducciones.id_palabra
		ORDER BY traducciones.traduccion asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_diccionario_idiomas_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad,$id_idioma) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT traducciones.*, palabra_imagen.*, palabras.*
		FROM traducciones, palabra_imagen, palabras
		WHERE traducciones.traduccion LIKE '$sql_letra%%' 
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra = palabra_imagen.id_palabra
		AND traducciones.id_palabra=palabras.id_palabra
		$sql_tipo 
		GROUP BY traducciones.id_palabra
		ORDER BY traducciones.traduccion asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
		
//                   FUNCION LISTAR PALABRAS PARA GESTION         //
//******************************************************************************//	

	function listar_diccionario_idiomas_palabras($id_tipo,$letra,$id_idioma) {
			
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		$query = "SELECT DISTINCT traducciones.*, palabras.*
		FROM traducciones, palabras
		WHERE traducciones.traduccion LIKE '$sql_letra%%' 
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra=palabras.id_palabra
		$sql_tipo 
		ORDER BY traducciones.traduccion asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS PARA GESTION CON LIMITE        //
//******************************************************************************//	

	function listar_diccionario_idiomas_palabras_limit($id_tipo,$letra,$id_idioma,$inicial,$cantidad) {
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		$query = "SELECT DISTINCT traducciones.*, palabras.*
		FROM traducciones, palabras
		WHERE traducciones.traduccion LIKE '$sql_letra%%' 
		AND traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra=palabras.id_palabra
		$sql_tipo 
		ORDER BY traducciones.traduccion asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	
	function listar_diccionario_palabras_por_tipos_con_imagenes_limit($sql,$letra,$inicial,$cantidad) {
			
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		
		$query = "SELECT DISTINCT palabras.*, palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabras, palabra_imagen, imagenes
		WHERE palabras.palabra LIKE '$sql_letra%'  
		AND  palabras.id_palabra = palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$sql
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_diccionario_idiomas_palabras_por_tipos_con_imagenes_limit($sql,$letra,$inicial,$cantidad,$id_idioma) {
			
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT traducciones.*, palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM traducciones, palabra_imagen, imagenes
		WHERE traducciones.id_idioma = $id_idioma
		AND traducciones.traduccion LIKE '$sql_letra%' 
		AND traducciones.id_palabra = palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$sql
		GROUP BY traducciones.id_palabra
		ORDER BY traducciones.traduccion
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//         FUNCION LISTAR PALABRAS UNICAS PARA CUADRO DE BSUQUEDA SUPERIOR        //
//******************************************************************************//	

	function listar_diccionario_unico_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad) {
	
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		if ($letra=='todas') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT DISTINCT palabras.*, palabra_imagen.*
		FROM palabras, palabra_imagen
		WHERE palabras.palabra LIKE '$sql_letra%%' $sql_tipo  
		AND  palabras.id_palabra = palabra_imagen.id_palabra
		GROUP BY palabras.palabra
		ORDER BY palabras.palabra
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR SIMBOLOS POR PALABRA         //
//******************************************************************************//	

	function simbolos_por_palabra($id_palabra,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		$query = "SELECT palabras.*, simbolos.*, tipos_simbolos.*
		FROM palabras, simbolos, tipos_simbolos
		WHERE simbolos.id_palabra='$id_palabra'
		AND simbolos.id_palabra=palabras.id_palabra
		AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo
		$mostrar_registradas
		AND simbolos.estado=1";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


//                   FUNCION LISTAR SIMBOLOS ARASAAC POR ID PALABRA       //
//******************************************************************************//	

	function simbolos_por_id_palabra_con_filtro($id_palabra,$id_tipo_palabra,$id_tipo_simbolo,$registrado,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($tipo_letra==99) { $sql_tipo_letra=''; } 
		else { $sql_tipo_letra='AND (simbolos.sup_font='.$tipo_letra.' OR simbolos.inf_font='.$tipo_letra.')'; }
		
		if ($minusculas == 1 && $mayusculas == 1) {
		 	$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		} elseif ($minusculas == 1) { 
		    $sql_mayusculas='AND (simbolos.inf_mayusculas=0)';
		} elseif ($mayusculas == 1) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1)';
		} elseif ($minusculas == 0 && $mayusculas == 0) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		}
		
		
		if ($castellano==0 &&($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1)) {  
		
			$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
			$sql_idioma_inferior='AND (simbolos.inf_idioma=99999 ';
					if ($castellano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=0 '; } 
					if ($ruso==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=7 '; }
					if ($frances==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=9 '; }   
			$sql_idioma_inferior.= ' )';
			$sql_tipo_letra=''; 			
		
		} elseif ($castellano==1) { 
		
			if ($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1) {
			
			$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			$sql_idioma_superior='AND (simbolos.inf_idioma=99999 ';
					if ($ruso==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=7 '; }
					if ($frances==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=9 '; }   
			$sql_idioma_superior.= ' )';
			
			} elseif ($ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
			
				$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			
			}
		
		} elseif ($castellano==0 && $ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0)  {
		
			$sql_idioma_inferior='';
			$sql_idioma_inferior='';
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($marco==99) { $sql_marco=''; } 
		else { $sql_marco='AND simbolos.marco='.$marco.''; }
		
		if ($contraste==99) { $sql_contraste=''; } 
		else { $sql_contraste='AND simbolos.contraste='.$contraste.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		AND simbolos.id_palabra='$id_palabra'
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_marco
		$sql_contraste
		$sql_tipo_letra
		$sql_mayusculas
		$sql_idioma_inferior
		$sql_idioma_superior
		$mostrar_registradas
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS ARASAAC POR PALABRA       //
//******************************************************************************//	

	function simbolos_por_palabra_con_filtro($palabra,$id_tipo_palabra,$id_tipo_simbolo,$registrado,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($tipo_letra==99) { $sql_tipo_letra=''; } 
		else { $sql_tipo_letra='AND (simbolos.sup_font='.$tipo_letra.' OR simbolos.inf_font='.$tipo_letra.')'; }
		
		if ($minusculas == 1 && $mayusculas == 1) {
		 	$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		} elseif ($minusculas == 1) { 
		    $sql_mayusculas='AND (simbolos.inf_mayusculas=0)';
		} elseif ($mayusculas == 1) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1)';
		} elseif ($minusculas == 0 && $mayusculas == 0) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		}
		
		
		if ($castellano==0 &&($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1)) {  
		
			$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
			$sql_idioma_inferior='AND (simbolos.inf_idioma=99999 ';
					if ($castellano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=0 '; } 
					if ($ruso==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=7 '; }
					if ($frances==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=9 '; }   
			$sql_idioma_inferior.= ' )';
			$sql_tipo_letra=''; 			
		
		} elseif ($castellano==1) { 
		
			if ($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1) {
			
			$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			$sql_idioma_superior='AND (simbolos.inf_idioma=99999 ';
					if ($ruso==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=7 '; }
					if ($frances==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=9 '; }   
			$sql_idioma_superior.= ' )';
			
			} elseif ($ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
			
				$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			
			}
		
		} elseif ($castellano==0 && $ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0)  {
		
			$sql_idioma_inferior='';
			$sql_idioma_inferior='';
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($marco==99) { $sql_marco=''; } 
		else { $sql_marco='AND simbolos.marco='.$marco.''; }
		
		if ($contraste==99) { $sql_contraste=''; } 
		else { $sql_contraste='AND simbolos.contraste='.$contraste.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		AND palabras.palabra LIKE '%$palabra%'
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_marco
		$sql_contraste
		$sql_tipo_letra
		$sql_mayusculas
		$sql_idioma_inferior
		$sql_idioma_superior
		$mostrar_registradas
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SIMBOLOS ARASAAC POR TAG       //
//******************************************************************************//	

	function simbolos_por_tag_con_filtro($tag,$id_tipo_palabra,$id_tipo_simbolo,$registrado,$marco,$contraste,$tipo_letra,$mayusculas,$minusculas,$castellano,$ruso,$rumano,$arabe,$chino,$bulgaro,$polaco,$ingles,$frances,$catalan) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND simbolos.registrado=0";
		}
		
		if ($tipo_letra==99) { $sql_tipo_letra=''; } 
		else { $sql_tipo_letra='AND (simbolos.sup_font='.$tipo_letra.' OR simbolos.inf_font='.$tipo_letra.')'; }
		
		if ($minusculas == 1 && $mayusculas == 1) {
		 	$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		} elseif ($minusculas == 1) { 
		    $sql_mayusculas='AND (simbolos.inf_mayusculas=0)';
		} elseif ($mayusculas == 1) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1)';
		} elseif ($minusculas == 0 && $mayusculas == 0) { 
			$sql_mayusculas='AND (simbolos.inf_mayusculas=1 OR simbolos.inf_mayusculas=0)';
		}
		
		
		if ($castellano==0 &&($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1)) {  
		
			$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
			$sql_idioma_inferior='AND (simbolos.inf_idioma=99999 ';
					if ($castellano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=0 '; } 
					if ($ruso==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=7 '; }
					if ($frances==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_inferior.='OR simbolos.inf_idioma=9 '; }   
			$sql_idioma_inferior.= ' )';
			$sql_tipo_letra=''; 			
		
		} elseif ($castellano==1) { 
		
			if ($ruso==1 || $rumano==1 || $arabe==1 || $chino==1 || $bulgaro==1 || $polaco==1 || $ingles==1 || $frances==1 || $catalan==1) {
			
			$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			$sql_idioma_superior='AND (simbolos.inf_idioma=99999 ';
					if ($ruso==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=1 '; } 
					if ($rumano==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=2 '; } 
					if ($arabe==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=3 '; } 
					if ($chino==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=4 '; } 
					if ($bulgaro==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=5 '; } 
					if ($polaco==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=6 '; } 
					if ($ingles==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=7 '; }
					if ($frances==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=8 '; }
					if ($catalan==1) { $sql_idioma_superior.='OR simbolos.sup_idioma=9 '; }   
			$sql_idioma_superior.= ' )';
			
			} elseif ($ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0) {
			
				$sql_idioma_superior='AND simbolos.sup_con_texto=0 ';
				$sql_idioma_inferior='AND simbolos.inf_idioma=0 ';
			
			}
		
		} elseif ($castellano==0 && $ruso==0 && $rumano==0 && $arabe==0 && $chino==0 && $bulgaro==0 && $polaco==0 && $ingles==0 && $frances==0 && $catalan==0)  {
		
			$sql_idioma_inferior='';
			$sql_idioma_inferior='';
		}
		
		if ($id_tipo_palabra==99) { $sql_tipo_palabra=''; } 
		else { $sql_tipo_palabra='AND palabras.id_tipo_palabra='.$id_tipo_palabra.''; }
		
		if ($marco==99) { $sql_marco=''; } 
		else { $sql_marco='AND simbolos.marco='.$marco.''; }
		
		if ($contraste==99) { $sql_contraste=''; } 
		else { $sql_contraste='AND simbolos.contraste='.$contraste.''; }
		
		if ($id_tipo_simbolo==99) { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo=tipos_simbolos.id_tipo'; } 
		else { $sql_tipo_simbolo='AND simbolos.id_tipo_simbolo='.$id_tipo_simbolo.' AND tipos_simbolos.id_tipo='.$id_tipo_simbolo.''; }
		
		$query = "SELECT simbolos.*, palabras.*, tipos_simbolos.*
		FROM simbolos, palabras, tipos_simbolos
		WHERE simbolos.id_palabra=palabras.id_palabra
		AND simbolos.tags_simbolo LIKE '%{".$tag."}%'
		$sql_tipo_simbolo
		$sql_tipo_palabra
		$sql_marco
		$sql_contraste
		$sql_tipo_letra
		$sql_mayusculas
		$sql_idioma_inferior
		$sql_idioma_superior
		$mostrar_registradas
		ORDER BY palabras.palabra asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
		
//                   FUNCION LISTAR IMAGENES POR PALABRA         //
//******************************************************************************//	

	function imagenes_por_palabra($id_palabra,$registrado,$estado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($estado !='' && $estado < 4 && $estado > 0) {
			$sql_estado='AND imagenes.estado='.$estado.'';
		} elseif ($estado='all') {
			$sql_estado='';
		} else {
			$sql_estado='AND imagenes.estado=1';
		}
		
		$query = "SELECT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_palabra='$id_palabra'
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		$sql_estado";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR IMAGENES POR PALABRA Y TIPO DE IMAGEN       //
//******************************************************************************//	

	function imagenes_por_palabra_y_tipo_imagen($id_palabra,$registrado,$estado,$id_tipo_imagen) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($estado !='' && $estado < 4 && $estado > 0) {
			$sql_estado='AND imagenes.estado='.$estado.'';
		} elseif ($estado='all') {
			$sql_estado='';
		} else {
			$sql_estado='AND imagenes.estado=1';
		}
		
		if ($id_tipo_imagen==99) { $sql_tipo_imagen=''; } 
		else { $sql_tipo_imagen='AND imagenes.id_tipo_imagen='.$id_tipo_imagen.''; }
		
		$query = "SELECT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_palabra='$id_palabra'
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$sql_tipo_imagen
		$mostrar_registradas
		$sql_estado";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
//                   FUNCION LISTAR IMAGENES POR PALABRA         //
//******************************************************************************//	

	function listar_palabras_con_imagenes($id_tipo,$letra,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		$query = "SELECT DISTINCT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE palabras.palabra LIKE '$letra%%'
		$sql_tipo
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		AND imagenes.estado=1
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	

//                   FUNCION LISTAR IMAGENES POR PALABRA         //
//******************************************************************************//	

	function listar_palabras_con_imagenes_limit($id_tipo,$letra,$inicial,$cantidad,$registrado) {
	
		if ($registrado==false) {
			$mostrar_registradas="AND imagenes.registrado=0";
		}
		
		if ($id_tipo==99) { $sql_tipo=''; } 
		else { $sql_tipo='AND palabras.id_tipo_palabra='.$id_tipo.''; }
		
		$query = "SELECT palabra_imagen.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		palabras.*
		FROM palabra_imagen, imagenes, palabras
		WHERE palabras.palabra LIKE '$letra%%'
		$sql_tipo
		AND palabras.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen=imagenes.id_imagen
		$mostrar_registradas
		AND imagenes.estado=1
		GROUP BY palabras.id_palabra
		ORDER BY palabras.palabra
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PALABRAS         //
//******************************************************************************//	

	function listar_palabras() {

		$query = "SELECT *
		FROM palabras";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_palabras_limit($inicial,$cantidad) {

		$query = "SELECT palabras.*
		FROM palabras
		WHERE palabras.estado=1
		ORDER BY palabras.id_palabra asc
		LIMIT $inicial,$cantidad";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;

	}
	
	function listar_palabras_tipo($id_tipo_palabra) {

		$query = "SELECT *
		FROM palabras
		WHERE id_tipo_palabra='$id_tipo_palabra'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

	function listar_palabras_tipo_limit($id_tipo_palabra,$inicial,$cantidad) {

		$query = "SELECT *
		FROM palabras
		WHERE id_tipo_palabra='$id_tipo_palabra'
		LIMIT $inicial,$cantidad";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
//                   FUNCION LISTAR TRADUCCIONES				        //
//******************************************************************************//	

	function listar_traducciones() {

		$query = "SELECT *
		FROM traducciones";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR TRADUCCIONES				        //
//******************************************************************************//	

	function listar_traducciones_por_idioma($id_idioma) {

		$query = "SELECT *
		FROM traducciones
		WHERE id_idioma=$id_idioma";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR TRADUCCIONES				        //
//******************************************************************************//	

	function listar_traducciones_por_idioma_con_info_es($id_idioma) {

		$query = "SELECT traducciones.*, palabras.*
		FROM traducciones, palabras
		WHERE traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra=palabras.id_palabra";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR TRADUCCIONES CON LIMITE				        //
//******************************************************************************//	

	function listar_traducciones_por_idioma_con_info_es_limit($id_idioma,$inicial,$cantidad) {

		$query = "SELECT traducciones.*, palabras.*
		FROM traducciones, palabras
		WHERE traducciones.id_idioma=$id_idioma
		AND traducciones.id_palabra=palabras.id_palabra
		LIMIT $inicial,$cantidad";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION DATOS TIPO IMAGEN         //
//******************************************************************************//	

	function datos_tipo_imagen($id_tipo) {
		/*$query = "SELECT tipos_imagen.*
		FROM tipos_imagen";*/

		$query = "SELECT tipos_imagen.*
		FROM tipos_imagen
		WHERE id_tipo='$id_tipo'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS TIPO PALABRA         //
//******************************************************************************//	

	function datos_tipo_palabra($id_tipo) {
		/*$query = "SELECT tipos_imagen.*
		FROM tipos_imagen";*/

		$query = "SELECT tipos_palabra.*
		FROM tipos_palabra
		WHERE id_tipo_palabra='$id_tipo'";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row= mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
	
//                   FUNCION LISTAR TIPOS IMAGEN         //
//******************************************************************************//	

	function listar_tipos_imagen() {
		/*$query = "SELECT tipos_imagen.*
		FROM tipos_imagen";*/

		$query = "SELECT tipos_imagen.*
		FROM tipos_imagen
		WHERE activo=1
		ORDER BY orden asc";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR TIPOS IMAGEN SELECCIONADOS        //
//******************************************************************************//	

	function listar_tipos_imagen_seleccionados($pictogramas_color,$pictogramas_byn,$fotografia,$videos_lse,$lse_color,$lse_byn) {
		/*$query = "SELECT tipos_imagen.*
		FROM tipos_imagen";*/
		
		if ($pictogramas_color==0) { $sql_pictogramas_color=' AND id_tipo !=10 '; } else { $sql_pictogramas_color=''; }
		if ($pictogramas_byn==0) { $sql_pictogramas_byn=' AND id_tipo !=5 '; } else { $sql_pictogramas_byn=''; }
		if ($fotografia==0) { $sql_fotografia=' AND id_tipo !=2 '; } else { $sql_fotografia=''; }
		if ($videos_lse==0) { $sql_videos_lse=' AND id_tipo !=11 '; } else { $sql_videos_lse=''; }
		if ($lse_color==0) { $sql_lse_color=' AND id_tipo !=12 '; } else {  $sql_lse_color=''; }
		if ($lse_byn==0) { $sql_lse_byn=' AND id_tipo !=13 '; } else { $sql_lse_byn=''; }
		
		$query = "SELECT tipos_imagen.*
		FROM tipos_imagen
		WHERE activo=1
		$sql_pictogramas_color
		$sql_pictogramas_byn
		$sql_fotografia
		$sql_videos_lse
		$sql_lse_color
		$sql_lse_byn
		ORDER BY orden asc";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR AUTORES         //
//******************************************************************************//	

	function listar_autores() {
		$query = "SELECT autores.*
		FROM autores
		ORDER BY autor asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR AUTORES         //
//******************************************************************************//	

	function listar_autores_sin($autores) {
	
		  $mau=str_replace('}{',',',$autores);
		  $mau=str_replace('{','',$mau);
		  $mau=str_replace('}','',$mau);
		  $mau=explode(',',$mau);
		  
		  for ($i=0;$i<count($mau);$i++) { 
			if ($mau[$i]!='') {
			 $sql.='AND id_autor != '.$mau[$i].' '; 
			}
		  }
		  
		$query = "SELECT autores.*
		FROM autores
		WHERE autor IS NOT NULL
		$sql
		ORDER BY autor asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION DATOS SELECCION        //
//******************************************************************************//	

	function datos_seleccion($id_seleccion,$id_usuario) {
		$query = "SELECT seleccion.*
		FROM seleccion
		WHERE seleccion.id_seleccion = '$id_seleccion'
		AND seleccion.id_usuario='$id_usuario'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION SIMBOLOS SELECCION       //
//******************************************************************************//	

	function datos_simbolos_seleccion($id_seleccion,$id_usuario) {
		$query = "SELECT seleccion_simbolos.*,repositorio_archivos.*
		FROM seleccion_simbolos,repositorio_archivos
		WHERE seleccion_simbolos.id_seleccion = '$id_seleccion'
		AND seleccion_simbolos.id_file=repositorio_archivos.file_id
		AND repositorio_archivos.id_usuario='$id_usuario'
		ORDER BY seleccion_simbolos.orden asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}	
//                   FUNCION DATOS MATERIALES        //
//******************************************************************************//	

	function datos_material($id_material) {
		$query = "SELECT materiales.*
		FROM materiales
		WHERE id_material = '$id_material'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS MATERIALES        //
//******************************************************************************//	

	function ficha_material($id_material) {
		$query = "SELECT materiales.*, licencias.*
		FROM materiales, licencias
		WHERE materiales.id_material = '$id_material'
		AND materiales.material_licencia=licencias.id_licencia";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $row;
		}
		else {
			return $row;
		}
	}
	
//                   FUNCION DATOS AUTOR        //
//******************************************************************************//	

	function datos_autor($id_autor) {
		$query = "SELECT autores.*
		FROM autores
		WHERE id_autor = '$id_autor'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS LICENCIA        //
//******************************************************************************//	

	function datos_licencia($id_licencia) {
		$query = "SELECT licencias.*
		FROM licencias
		WHERE id_licencia = '$id_licencia'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
	
//                   FUNCION DATOS TIPOS MATERIAL        //
//******************************************************************************//	

	function datos_material_tipo($id_tipo) {
		$query = "SELECT material_tipo.*
		FROM material_tipo
		WHERE id_tipo_material = '$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS SAA MATERIAL        //
//******************************************************************************//	

	function datos_material_saa($id_saa) {
		$query = "SELECT material_saa.*
		FROM material_saa
		WHERE id_saa_material = '$id_saa'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS SAA MATERIAL        //
//******************************************************************************//	

	function datos_material_nivel($id_nivel) {
		$query = "SELECT material_nivel.*
		FROM material_nivel
		WHERE id_nivel_material = '$id_nivel'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS EDAD MATERIAL        //
//******************************************************************************//	

	function datos_material_edad($id_edad) {
		$query = "SELECT material_edad.*
		FROM material_edad
		WHERE id_edad_material = '$id_edad'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}


//                   FUNCION DATOS MATERIAL  DIRIGIDO      //
//******************************************************************************//	

	function datos_material_dirigido($id_dirigido) {
		$query = "SELECT material_dirigido.*
		FROM material_dirigido
		WHERE id_dirigido_material = '$id_dirigido'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS MATERIAL  AREA CURRICULAR     //
//******************************************************************************//	

	function datos_material_ac($id_ac) {
		$query = "SELECT material_area_curricular.*
		FROM material_area_curricular
		WHERE id_ac_material = '$id_ac'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION DATOS MATERIAL  SUBAREA CURRICULAR     //
//******************************************************************************//	

	function datos_material_subac($id_subac) {
		$query = "SELECT material_subarea.*
		FROM material_subarea
		WHERE id_subac_material = '$id_subac'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
	
								
//                   FUNCION LISTAR AREAS CURRICULARES         //
//******************************************************************************//	

	function listar_areas_curriculares() {
		$query = "SELECT material_area_curricular.*
		FROM material_area_curricular
		ORDER BY orden_ac asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR AREAS CURRICULARES         //
//******************************************************************************//	

	function listar_areas_curriculares_sin($ar_cur) {
	
		  $mac=str_replace('}{',',',$ar_cur);
		  $mac=str_replace('{','',$mac);
		  $mac=str_replace('}','',$mac);
		  $mac=explode(',',$mac);
		  
		  for ($i=0;$i<count($mac);$i++) { 
			if ($mac[$i]!='') {
			 $sql.="AND id_ac_material != ".$mac[$i]." 
			 "; 
			}
		  }
		$query = "SELECT material_area_curricular.*
		FROM material_area_curricular
		WHERE ac_material IS NOT NULL
		$sql
		ORDER BY ac_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SUBAREAS CURRICULARES         //
//******************************************************************************//	

	function listar_subareas_curriculares($id_area) {
		$query = "SELECT material_subarea.*
		FROM material_subarea
		WHERE id_ac_material='$id_area'
		ORDER BY subac_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

	function listar_subareas() {
		$query = "SELECT material_subarea.*
		FROM material_subarea
		ORDER BY subac_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
//               FUNCION LISTAR SUBAREAS CURRICULARES ASOCIADAS A MATERIAL       //
//******************************************************************************//	

	function datos_subarea($id_subarea) {
	
		$query = "SELECT material_subarea.*
		FROM material_subarea
		WHERE id_subac_material='$id_subarea'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
	
//                   FUNCION LISTAR AREAS CURRICULARES         //
//******************************************************************************//	

	function listar_subareas_curriculares_sin($ar_cur,$id_area) {
	
		  $mac=str_replace('}{',',',$ar_cur);
		  $mac=str_replace('{','',$mac);
		  $mac=str_replace('}','',$mac);
		  $mac=explode(',',$mac);
		  
		  for ($i=0;$i<count($mac);$i++) { 
			if ($mac[$i]!='') {
			 $sql.="AND id_subac_material != ".$mac[$i]." 
			 "; 
			}
		  }
		$query = "SELECT material_subarea.*
		FROM material_subarea
		WHERE subac_material IS NOT NULL
		AND id_ac_material='$id_area'
		$sql
		ORDER BY subac_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

		
//                   FUNCION LISTAR DIRIGIDO         //
//******************************************************************************//	

	function listar_dirigido() {
		$query = "SELECT material_dirigido.*
		FROM material_dirigido
		ORDER BY dirigido_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR DIRIGIDO         //
//******************************************************************************//	

	function listar_dirigido_sin($dirigido) {
	
		 $md=str_replace('}{',',',$dirigido);
		  $md=str_replace('{','',$md);
		  $md=str_replace('}','',$md);
		  $md=explode(',',$md);
		  
		  for ($i=0;$i<count($md);$i++) { 
			if ($md[$i]!='') {
			 $sql.='AND id_dirigido_material != '.$md[$i].' 
			 '; 
			}
		  }
		  
		$query = "SELECT material_dirigido.*
		FROM material_dirigido
		WHERE dirigido_material IS NOT NULL
		$sql
		ORDER BY dirigido_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR EDAD         //
//******************************************************************************//	

	function listar_edad() {
		$query = "SELECT material_edad.*
		FROM material_edad
		ORDER BY edad_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR EDAD         //
//******************************************************************************//	

	function listar_edad_sin($edad) {
	
	 	  $me=str_replace('}{',',', $edad);
		  $me=str_replace('{','',$me);
		  $me=str_replace('}','',$me);
		  $me=explode(',',$me);
		  
		  for ($i=0;$i<count($me);$i++) { 
			if ($me[$i]!='') {
			 $sql.='AND id_edad_material != '.$me[$i].' 
			 '; 
			}
		  }
		  
		$query = "SELECT material_edad.*
		FROM material_edad
		WHERE edad_material IS NOT NULL
		$sql
		ORDER BY edad_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR EDAD         //
//******************************************************************************//	

	function listar_nivel() {
		$query = "SELECT material_nivel.*
		FROM material_nivel
		ORDER BY nivel_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_nivel_sin($nivel) {
	
		  $mn=str_replace('}{',',',$nivel);
		  $mn=str_replace('{','',$mn);
		  $mn=str_replace('}','',$mn);
		  $mn=explode(',',$mn);
		  
		  for ($i=0;$i<count($mn);$i++) { 
			if ($mn[$i]!='') {
			 $sql.='AND id_nivel_material != '.$mn[$i].'
			 '; 
			}
		  }
		  
		$query = "SELECT material_nivel.*
		FROM material_nivel
		WHERE nivel_material IS NOT NULL
		$sql
		ORDER BY nivel_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	

//                   FUNCION LISTAR SAA         //
//******************************************************************************//	

	function listar_saa() {
		$query = "SELECT material_saa.*
		FROM material_saa
		ORDER BY saa_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}			

//                   FUNCION LISTAR SAA         //
//******************************************************************************//	

	function listar_saa_sin($saa) {
	 	 $msaa=str_replace('}{',',',$saa);
		  $msaa=str_replace('{','',$msaa);
		  $msaa=str_replace('}','',$msaa);
		  $msaa=explode(',',$msaa);
		  
		  for ($i=0;$i<count($msaa);$i++) { 
			if ($msaa[$i]!='') {
			 $sql.='AND id_saa_material != '.$msaa[$i].'
			 '; 
			}
		  }
		  
		$query = "SELECT material_saa.*
		FROM material_saa
		WHERE saa_material IS NOT NULL
		$sql
		ORDER BY saa_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR TIPO         //
//******************************************************************************//	

	function listar_tipo_material() {
		$query = "SELECT material_tipo.*
		FROM material_tipo
		ORDER BY tipo_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}	

//                   FUNCION LISTAR TIPO         //
//******************************************************************************//	

	function listar_tipo_material_sin($tipo_mat) {
	
		 $mt=str_replace('}{',',',$tipo_mat);
		  $mt=str_replace('{','',$mt);
		  $mt=str_replace('}','',$mt);
		  $mt=explode(',',$mt);
		  
		  for ($i=0;$i<count($mt);$i++) { 
			if ($mt[$i]!='') {
			$sql.='AND id_tipo_material != '.$mt[$i].'
			'; 
			}
		  }
		  
		$query = "SELECT material_tipo.*
		FROM material_tipo
		WHERE tipo_material IS NOT NULL
		$sql
		ORDER BY tipo_material asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
			
//                   FUNCION LISTAR LICENCIAS         //
//******************************************************************************//	

	function listar_licencias() {
		$query = "SELECT licencias.*
		FROM licencias";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


//                   FUNCION LISTAR IDIOMAS         //
//******************************************************************************//	

	function listar_idiomas() {
		$query = "SELECT idiomas.*
		FROM idiomas
		ORDER BY idioma";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR IDIOMAS         //
//******************************************************************************//	

	function buscar_fuente_idioma($idioma) {
		$query = "SELECT idiomas.*
		FROM idiomas
		WHERE idiomas.id_idioma='$idioma'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row['id_fuente'];
		}
	}
		
				
//                   FUNCION LISTAR CATEGORIAS DE PALABRAS PARA SIMBOLOS         //
//******************************************************************************//	

	function listar_categorias_palabras() {
		$query = "SELECT tipos_palabra.*
		FROM tipos_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR USUARIOS         //
//******************************************************************************//	

	function listar_usuarios() {
		$query = "SELECT colaboradores.*, colaboradores_permisos.*
		FROM colaboradores, colaboradores_permisos
		WHERE colaboradores.id_colaborador=colaboradores_permisos.id_colaborador
		AND colaboradores.estado=1";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR USUARIOS LIMIT       //
//******************************************************************************//	

	function listar_usuarios_limit($inicial,$cantidad) {
		$query = "SELECT colaboradores.*, colaboradores_permisos.*
		FROM colaboradores, colaboradores_permisos
		WHERE colaboradores.id_colaborador=colaboradores_permisos.id_colaborador
		AND colaboradores.estado=1
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR USUARIOS LIMIT       //
//******************************************************************************//	

	function listar_autores_limit($inicial,$cantidad) {
		$query = "SELECT autores.*
		FROM autores
		ORDER BY autor
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


//                   FUNCION LISTAR BOLETINES        //
//******************************************************************************//	

	function listar_boletines() {
		$query = "SELECT newsletters.*
		FROM newsletters
		ORDER BY fecha_publicacion desc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR BOLETINES      //
//******************************************************************************//	

	function listar_boletines_limit($inicial,$cantidad) {
		$query = "SELECT newsletters.*
		FROM newsletters
		ORDER BY fecha_publicacion desc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR TIPO SOFTWARE        //
//******************************************************************************//	

	function listar_tipo_software() {
		$query = "SELECT software_tipo.*
		FROM software_tipo
		ORDER BY tipo_software asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}	

//                   FUNCION LISTAR TIPO EJEMPLO DE USO        //
//******************************************************************************//	

	function listar_tipo_eu() {
		$query = "SELECT eu_tipo.*
		FROM eu_tipo
		ORDER BY tipo_eu asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION LISTAR CUALQUIER TABLA        //
//******************************************************************************//	

	function listar_tabla($tabla,$order_by) {
		$query = "SELECT ".$tabla.".*
		FROM ".$tabla."
		ORDER BY ".$order_by."";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
//                   FUNCION DATOS TIPO SOFTWARE        //
//******************************************************************************//	

	function datos_software_tipo($id_tipo) {
		$query = "SELECT software_tipo.*
		FROM software_tipo
		WHERE id_tipo_software = '$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
//                   FUNCION DATOS TIPO EJEMPLOS USO        //
//******************************************************************************//	

	function datos_eu_tipo($id_tipo) {
		$query = "SELECT eu_tipo.*
		FROM eu_tipo
		WHERE id_tipo_eu = '$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}

//                   FUNCION LISTAR SISTEMA OPERATIVO SOFTWARE        //
//******************************************************************************//	

	function listar_so_software() {
		$query = "SELECT software_so.*
		FROM software_so
		ORDER BY so asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}	

//                   FUNCION DATOS TIPO SOFTWARE        //
//******************************************************************************//	

	function datos_so_software($id_so) {
		$query = "SELECT software_so.*
		FROM software_so
		WHERE id_so = '$id_so'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
//                   FUNCION DATOS USUARIO        //
//******************************************************************************//	

	function datos_usuario($id_usuario) {
		$query = "SELECT colaboradores.*, colaboradores_permisos.*
		FROM colaboradores, colaboradores_permisos
		WHERE colaboradores.id_colaborador='$id_usuario'
		AND colaboradores.id_colaborador=colaboradores_permisos.id_colaborador
		AND colaboradores.estado=1";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
//                   FUNCION DATOS PALABRA        //
//******************************************************************************//	

	function datos_palabra($id_palabra) {
		$query = "SELECT palabras.*, tipos_palabra.*
		FROM palabras, tipos_palabra
		WHERE palabras.id_palabra = '$id_palabra'
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}

//                   FUNCION DATOS NOTICIA        //
//******************************************************************************//	

	function datos_noticia($id_noticia) {
		$query = "SELECT noticias.*, colaboradores.*
		FROM noticias, colaboradores
		WHERE noticias.id_noticia = '$id_noticia'
		AND noticias.id_colaborador=colaboradores.id_colaborador";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}
	
//                   FUNCION DATOS IMAGEN        //
//******************************************************************************//	

	function datos_imagen($id_imagen) {
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		imagenes.fecha_creacion, imagenes.ultima_modificacion,
		palabra_imagen.*, palabras.*, tipos_imagen.*,colaboradores.*, licencias.*, autores.*
		FROM imagenes, palabra_imagen, palabras, tipos_imagen, colaboradores, licencias, autores
		WHERE imagenes.id_imagen = '$id_imagen'
		AND imagenes.id_colaborador=colaboradores.id_colaborador
		AND imagenes.id_tipo_imagen = tipos_imagen.id_tipo
		AND palabra_imagen.id_imagen= '$id_imagen'
		AND imagenes.id_licencia = licencias.id_licencia
		AND imagenes.id_autor = autores.id_autor
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}


//                   FUNCION DATOS SIMBOLO        //
//******************************************************************************//	

	function datos_simbolo($id_simbolo) {
		$query = "SELECT simbolos.*, tipos_simbolos.*, palabras.*, idiomas.*
		FROM simbolos, tipos_simbolos, palabras, idiomas
		WHERE simbolos.id_simbolo = '$id_simbolo'
		AND simbolos.id_tipo_simbolo = tipos_simbolos.id_tipo
		AND simbolos.id_palabra = palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}

//                   FUNCION DATOS SIMBOLO ESPECIAL       //
//******************************************************************************//	

	function datos_simbolo_especial($id_simbolo) {
		$query = "SELECT simbolos_especiales.*, tipos_simbolos.*, palabras.*, idiomas.*
		FROM simbolos_especiales, tipos_simbolos, palabras, idiomas
		WHERE simbolos_especiales.id_simbolo = '$id_simbolo'
		AND simbolos_especiales.id_tipo_simbolo = tipos_simbolos.id_tipo
		AND simbolos_especiales.id_palabra = palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}

//                   FUNCION DATOS SIMBOLO ARASAAC       //
//******************************************************************************//	

	function datos_simbolo_arasaac($id_simbolo) {
		$query = "SELECT simbolos.*, tipos_simbolos.*, palabras.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM simbolos, tipos_simbolos, palabras, imagenes
		WHERE simbolos.id_simbolo = '$id_simbolo'
		AND simbolos.id_tipo_simbolo = tipos_simbolos.id_tipo
		AND simbolos.id_palabra = palabras.id_palabra
		AND simbolos.id_imagen=imagenes.id_imagen";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}
//                   FUNCION DATOS TIPO SIMBOLO        //
//******************************************************************************//	

	function datos_tipo_simbolo($id_tipo) {
		$query = "SELECT tipos_simbolos.*
		FROM tipos_simbolos
		WHERE tipos_simbolos.id_tipo='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row;
	}

//                DATOS IDIOMA       //
//******************************************************************************//	

	function datos_idioma($id_idioma) {
		$query = "SELECT idiomas.*
		FROM idiomas
		WHERE idiomas.id_idioma=$id_idioma";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		mysql_close($connection);
		return $row['idioma'];
	}
	
	function datos_idioma_completo($id_idioma) {
		$query = "SELECT idiomas.*
		FROM idiomas
		WHERE idiomas.id_idioma=$id_idioma";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		mysql_close($connection);
		return $row;
	}

	function datos_idioma_por_abreviatura($abreviatura) {
		$query = "SELECT idiomas.*
		FROM idiomas
		WHERE idiomas.idioma_abrev='$abreviatura'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		mysql_close($connection);
		return $row;
	}
//                DATOS FUENTES SIMBOLOS       //
//******************************************************************************//	

	function datos_fuentes_simbolos($id_fuente) {
		$query = "SELECT fuentes_simbolos.*
		FROM fuentes_simbolos
		WHERE fuentes_simbolos.id_font='$id_fuente'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		mysql_close($connection);
		return $row;
	}
//                DATOS ARCHIVO REPOSITORIO       //
//******************************************************************************//	

	function datos_archivo_repositorio($id_file) {
		$query = "SELECT repositorio_archivos.*, repositorio_directorios.*
		FROM repositorio_archivos, repositorio_directorios
		WHERE repositorio_archivos.file_id='$id_file' AND repositorio_archivos.id_directorio=repositorio_directorios.id";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		mysql_close($connection);
		return $row;
	}
			
//                IDIOMAS DISPONIBLES PARA LA PALABRA        //
//******************************************************************************//	

	function idiomas_disponibles($id_palabra,$estado) {
	
		if ($estado==0) { $sql_estado='AND traducciones.estado = 0'; }
		elseif ($estado==1) { $sql_estado='AND traducciones.estado = 1';  }
		elseif ($estado==2) {  $sql_estado='AND traducciones.estado = 2'; }
		else { $sql_estado='';  } 
		$query = "SELECT palabras.*, tipos_palabra.*, traducciones.*, idiomas.*
		FROM palabras, tipos_palabra, traducciones, idiomas
		WHERE palabras.id_palabra = '$id_palabra'
		AND traducciones.id_palabra = '$id_palabra'
		AND traducciones.id_idioma = idiomas.id_idioma
		$sql_estado
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		GROUP BY idiomas.id_idioma";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

//                IMAGENES DISPONIBLES PARA LA PALABRA        //
//******************************************************************************//	

	function imagenes_disponibles($id_palabra) {
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}


//                IMAGENES DISPONIBLES PARA LA PALABRA Y DIFERENTES TIPOS       //
//******************************************************************************//	

	function imagenes_disponibles_tipos($id_palabra,$with_pictcolor,$with_pictnegro,$with_imagenes,$with_cliparts) {
			
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		$with_pictcolor
		$with_pictnegro
		$with_imagenes
		$with_cliparts";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_diferentes_tipos($id_palabra,$sql) {
			
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		$sql";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
//                IMAGENES DISPONIBLES PARA LA PALABRA POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_tipo($id_palabra,$id_tipo) {
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_tipo_limit($id_palabra,$id_tipo,$inicial,$cantidad) {
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_tipo_contar($id_palabra,$id_tipo) {
		$query = "SELECT COUNT(*)
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.id_palabra = '$id_palabra'
		AND palabra_imagen.id_palabra = '$id_palabra'
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$num_rows=mysql_num_rows($result);
		$rows=mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	}
	

//                IMAGENES DISPONIBLES PARA LA PALABRA POR TIPO E IDIOMA      //
//******************************************************************************//	

	function imagenes_disponibles_idioma_tipo($id_traduccion,$id_tipo,$id_idioma) {
		$query = "SELECT traducciones.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.id_traduccion = '$id_traduccion'
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_idioma_tipo_limit($id_traduccion,$id_tipo,$id_idioma,$inicial,$cantidad) {
		$query = "SELECT traducciones.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.id_traduccion = '$id_traduccion'
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_idioma_tipo_contar($id_traduccion,$id_tipo,$id_idioma) {
		$query = "SELECT COUNT(*)
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.id_traduccion = '$id_traduccion'
		AND traducciones.id_palabra=palabra_imagen.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'";

		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$num_rows=mysql_num_rows($result);
		$rows=mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	}
	
//                IMAGENES DISPONIBLES PARA LA PALABRA POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_solo_por_tipo($id_tipo,$limite) {
		$query = "SELECT palabras.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*,autores.*,licencias.*
		FROM palabras, imagenes, palabra_imagen,autores,licencias
		WHERE imagenes.id_tipo_imagen='$id_tipo'
		AND imagenes.id_imagen=palabra_imagen.id_imagen
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND imagenes.id_autor=autores.id_autor
		AND imagenes.id_licencia=licencias.id_licencia
		ORDER BY imagenes.id_imagen desc
		LIMIT 0,$limite";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
//                IMAGENES DISPONIBLES POR PALABRA POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_tipo_por_palabra($palabra,$id_tipo) {
		$query = "SELECT palabras.*, tipos_palabra.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.palabra LIKE '%$palabra%'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_tipo_por_palabra_limit($palabra,$id_tipo,$inicial,$cantidad) {
		$query = "SELECT palabras.*, tipos_palabra.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.palabra LIKE '%$palabra%'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

	function imagenes_disponibles_tipo_por_palabra_contar($palabra,$id_tipo) {
		$query = "SELECT COUNT(*)
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.palabra LIKE '%$palabra%'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$num_rows=mysql_num_rows($result);
		$rows=mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	}
//                IMAGENES DISPONIBLES POR PALABRA POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_idioma_tipo_por_palabra($palabra,$id_tipo,$id_idioma) {
		$query = "SELECT traducciones.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.traduccion LIKE '%$palabra%'
		AND traducciones.id_idioma=$id_idioma
		AND palabra_imagen.id_palabra = traducciones.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_idioma_tipo_por_palabra_limit($palabra,$id_tipo,$id_idioma,$inicial,$cantidad) {
		$query = "SELECT traducciones.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.traduccion LIKE '%$palabra%'
		AND traducciones.id_idioma=$id_idioma
		AND palabra_imagen.id_palabra = traducciones.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_idioma_tipo_por_palabra_contar($palabra,$id_tipo,$id_idioma) {
		$query = "SELECT COUNT(*)
		FROM traducciones, imagenes, palabra_imagen
		WHERE traducciones.traduccion LIKE '%$palabra%'
		AND traducciones.id_idioma=$id_idioma
		AND palabra_imagen.id_palabra = traducciones.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND imagenes.id_tipo_imagen='$id_tipo'";
        
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		$num_rows=mysql_num_rows($result);
		$rows=mysql_fetch_array($result);
		mysql_close($connection);
		return $rows[0];
	}
//                IMAGENES DISPONIBLES POR PALABRA EXACTA POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_tipo_por_palabra_exacta($palabra,$id_tipo) {
		$query = "SELECT palabras.*, tipos_palabra.*, 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*
		FROM palabras, tipos_palabra, imagenes, palabra_imagen
		WHERE palabras.palabra = '$palabra'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		AND tipos_palabra.id_tipo_palabra=palabras.id_tipo_palabra
		AND imagenes.id_tipo_imagen='$id_tipo'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
//                IMAGENES DISPONIBLES POR TAGS POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_tipo_por_tag($tag,$id_tipo) {
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*, palabras.*
		FROM imagenes, palabra_imagen, palabras
		WHERE imagenes.tags_imagen LIKE '%{".$tag."}%'
		AND imagenes.id_tipo_imagen='$id_tipo'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function imagenes_disponibles_tipo_por_tag_limit($tag,$id_tipo,$inicial,$cantidad) {
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*, palabras.*
		FROM imagenes, palabra_imagen, palabras
		WHERE imagenes.tags_imagen LIKE '%{".$tag."}%'
		AND imagenes.id_tipo_imagen='$id_tipo'
		AND palabra_imagen.id_palabra = palabras.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	

//                IMAGENES DISPONIBLES IDIOMAS POR TAGS POR TIPO        //
//******************************************************************************//	

	function imagenes_disponibles_idioma_tipo_por_tag($tag,$id_tipo,$id_idioma) {
		$query = "SELECT 
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename,
		palabra_imagen.*, traducciones.*
		FROM imagenes, palabra_imagen, traducciones
		WHERE imagenes.tags_imagen LIKE '%{".$tag."}%'
		AND imagenes.id_tipo_imagen='$id_tipo'
		AND traducciones.id_idioma=$id_idioma
		AND palabra_imagen.id_palabra = traducciones.id_palabra
		AND palabra_imagen.id_imagen = imagenes.id_imagen";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
			
//                NUBE DE TAGS        //
//******************************************************************************//	

	function construir_nube_tags($n) {
		$query = "SELECT imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM imagenes
		WHERE imagenes.tags_imagen IS NOT NULL";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		while ($row=mysql_fetch_array($result)) {
		
		$tags_palabra.=$row['tags_imagen'];
		  
		}
		
		  $tags1=str_replace('}{',',',$tags_palabra);
		  $tags1=str_replace('{','',$tags1);
		  $tags1=str_replace('}','',$tags1);
		
		  $tags2=explode(',',$tags1);
  			
			while(list($key,$value) = each($tags2)){
                if (isset($value) && $value !='lse' && $value !='lengua de signos') {
                    $tags[$value] += 1;
                }
            }
		
		// Ordeno el array de mayor a menor
		arsort($tags);
		// Selecciono los primeros n valores (los mas altos)
		$tags=array_slice($tags, 0, $n);

		//Desordenor el array de nuevo
		$new=array();
		$c=count($tags);
		
		$k=array_keys($tags);
		$v=array_values($tags);
		
		   while($c>0) {
			 $i=array_rand($k);
			 $new[$k[$i]]=$v[$i];
			 unset($k[$i]); #exlude selected number from list
			 $c--;
		   }
		
		// Compongo el código para ser almacenado en el archivo
		 $nube_tags='<?php ';
		 foreach ($new as $tag => $count) {

			$nube_tags.='$tags[\''.$tag.'\']='.$count.'; ';
		 }
		 $nube_tags.=' ?>';
		  		  
		  // Abro el archivo para escritura
		  $fp2 = fopen("../../configuration/tags.inc", 'w');
		  //chmod("../../configuration/tags.inc", 0777);
		
		  fwrite($fp2, $nube_tags);
		  fclose($fp2);

		mysql_close($connection);
		return true;
	}
	
			
//                   BUSCAR PALABRAS       //
//******************************************************************************//	

	function buscar_palabras($txt) {
		$query = "SELECT palabras.*
		FROM palabras
		WHERE palabras.palabra LIKE '$txt%%'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

//                   BUSCAR AUTORES POR NOMBRE      //
//******************************************************************************//	

	function buscar_autores_nombre($txt) {
		$query = "SELECT autores.*
		FROM autores
		WHERE autor LIKE '%%$txt%%'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}


//                   BUSCAR PALABRAS ASOCIADAS A IMAGEN      //
//******************************************************************************//	

	function buscar_palabras_asociadas_imagen($id_imagen) {
		$query = "SELECT palabras.*, palabra_imagen.*
		FROM palabras, palabra_imagen
		WHERE palabra_imagen.id_imagen='$id_imagen'
		AND palabra_imagen.id_palabra=palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

//                   BUSCAR ACEPCIONES EN LSE      //
//******************************************************************************//	

	function buscar_acepcion_lse($id_palabra) {
		$query = "SELECT palabra_imagen.*,
		imagenes.id_imagen,imagenes.id_colaborador,imagenes.imagen,imagenes.extension,imagenes.id_tipo_imagen,
		imagenes.estado,imagenes.registrado,imagenes.id_licencia,imagenes.id_autor,imagenes.tags_imagen,
		imagenes.tipo_pictograma,imagenes.validos_senyalectica,imagenes.original_filename
		FROM palabra_imagen, imagenes
		WHERE palabra_imagen.id_imagen=imagenes.id_imagen
		AND imagenes.id_tipo_imagen=11
		AND palabra_imagen.id_palabra='$id_palabra'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
		
//                   BUSCAR PALABRAS       //
//******************************************************************************//	

	function comprobar_palabra($txt) {
		$query = "SELECT palabras.*
		FROM palabras
		WHERE palabras.palabra = '$txt'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}	

//    COMPROBAR SI EXISTE EL EMAIL EN LA BBDD DE SUBSCRIPTORES                  //
//******************************************************************************//	

	function comprobar_email_subscriptor($email) {
		$query = "SELECT newsletter_subscribers.*
		FROM newsletter_subscribers
		WHERE email_subscriptor = '$email'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
// 					FUNCION ACTUALIZAR DEFINICION 		                     //
//******************************************************************************//
	function actualizar_definicion($id_palabra, $definicion) {
	
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);

		$UpdateRecords = "UPDATE palabras SET definicion='$definicion', ultima_modificacion='$fecha'
		WHERE id_palabra='$id_palabra'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}

// 					FUNCION ACTUALIZAR SI HAY O NO LOCUCION                      //
//******************************************************************************//
	function actualizar_locucion_es($id_palabra,$si_no) {
	
		$UpdateRecords = "UPDATE palabras SET locucion_es='$si_no'
		WHERE id_palabra='$id_palabra'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}

// 		FUNCION ACTUALIZAR SI HAY O NO LOCUCION PARA TRADUCCION                  //
//******************************************************************************//
	function actualizar_locucion_traduccion($id_traduccion,$si_no) {
	
		$UpdateRecords = "UPDATE traducciones SET locucion='$si_no'
		WHERE id_traduccion='$id_traduccion'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}
	
//                   BUSCAR TRADUCCION        //
//******************************************************************************//	

	function buscar_traduccion($id_palabra,$id_idioma) {
		$query = "SELECT palabras.*, traducciones.*, idiomas.*
		FROM palabras, traducciones, idiomas
		WHERE traducciones.id_palabra = $id_palabra
		AND traducciones.id_idioma = $id_idioma
		AND traducciones.id_idioma = idiomas.id_idioma
		AND traducciones.id_palabra = palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}	
	
	function buscar_traduccion_por_idioma($id_idioma) {
		$query = "SELECT palabras.*, traducciones.*, idiomas.*
		FROM palabras, traducciones, idiomas
		WHERE traducciones.id_idioma = $id_idioma
		AND traducciones.id_idioma = idiomas.id_idioma
		AND traducciones.id_palabra = palabras.id_palabra
		ORDER BY traducciones.id_palabra ASC";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function buscar_traduccion_por_idioma_sin_asociar_palabra($id_idioma) {
		$query = "SELECT traducciones.*, idiomas.*
		FROM traducciones, idiomas
		WHERE traducciones.id_idioma = $id_idioma
		AND traducciones.id_idioma = idiomas.id_idioma
		ORDER BY traducciones.id_palabra ASC";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function buscar_traduccion_por_idioma_temp($id_idioma) {
		$query = "SELECT palabras.*, traducciones_temp.*, idiomas.*
		FROM palabras, traducciones_temp, idiomas
		WHERE traducciones_temp.id_idioma = $id_idioma
		AND traducciones_temp.id_idioma = idiomas.id_idioma
		AND traducciones_temp.id_palabra = palabras.id_palabra
		ORDER BY traducciones_temp.id_palabra ASC";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	
	function buscar_traduccion_por_id($id_traduccion) {
		$query = "SELECT palabras.*, traducciones.*, idiomas.*
		FROM palabras, traducciones, idiomas
		WHERE traducciones.id_traduccion = '$id_traduccion'
		AND traducciones.id_idioma = idiomas.id_idioma
		AND traducciones.id_palabra = palabras.id_palabra
		ORDER BY traducciones.id_palabra ASC";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function buscar_traducciones_por_id_palabra($id_palabra) {
		$query = "SELECT palabras.*, traducciones.*, idiomas.*
		FROM palabras, traducciones, idiomas
		WHERE traducciones.id_palabra = '$id_palabra'
		AND (traducciones.id_idioma = 7
		OR traducciones.id_idioma = 8
		OR traducciones.id_idioma = 9
		OR traducciones.id_idioma = 10
		OR traducciones.id_idioma = 11
		OR traducciones.id_idioma = 12
		OR traducciones.id_idioma = 13
		OR traducciones.id_idioma = 14
		OR traducciones.id_idioma = 15)
		AND traducciones.id_idioma = idiomas.id_idioma
		AND traducciones.id_palabra = palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
	
	function buscar_traducciones_por_id_palabra_2($id_palabra) {
		$query = "SELECT palabras.*, traducciones.*, idiomas.*
		FROM palabras, traducciones, idiomas
		WHERE traducciones.id_palabra = '$id_palabra'
		AND (traducciones.id_idioma = 7
		OR traducciones.id_idioma = 1
		OR traducciones.id_idioma = 2
		OR traducciones.id_idioma = 3
		OR traducciones.id_idioma = 4
		OR traducciones.id_idioma = 5
		OR traducciones.id_idioma = 6)
		AND traducciones.id_idioma = idiomas.id_idioma
		AND traducciones.id_palabra = palabras.id_palabra";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}

// 							INSERTAR NUEVA IMAGEN A MI REPOSITORIO                             //
//******************************************************************************//
	function add_original_repositorio($name,$id_directorio,$id_palabra,$id_imagen,$id_tipo_imagen,$id_usuario) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$dir=$this->datos_directorio($id_directorio,$id_usuario);
		$directorio=$dir['ruta_dir'];
		
		$ssql = "INSERT INTO repositorio_archivos
		(file_name, id_directorio, id_palabra, id_imagen, id_tipo_imagen, ruta_file,id_usuario) 
		VALUES ('$name', '$id_directorio', '$id_palabra', '$id_imagen', '$id_tipo_imagen', '$directorio','$id_usuario')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}

// 							COPIAR ARCHIVO                            //
//******************************************************************************//
	function copiar_archivo($tipo,$id_file,$origen,$destino,$id_usuario) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$data=$this->datos_archivo_repositorio($id_file);
		$dir=$this->datos_directorio($destino,$id_usuario);
		
		$ssql = "INSERT INTO repositorio_archivos
		(file_name,id_directorio,id_palabra,id_imagen,id_simbolo,id_tipo_imagen,fecha_creacion,ruta_file,id_usuario) 
		VALUES ('".$data['file_name']."','$destino','".$data['id_palabra']."','".$data['id_imagen']."','".$data['id_simbolo']."','".$data['id_tipo_imagen']."','".$data['fecha_creacion']."','".$data['ruta_file']."','$id_usuario')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				$extension = strtolower(substr(strrchr($data['file_name'], "."), 1));
				
				if ($tipo==1) {		
					copy ('../../../usuarios/'.$data['ruta_file'].'/'.$data['file_name'],'../../../usuarios/'.$dir['ruta_dir'].'/'.$ultimo_id.'.'.$extension.'');
					
					$nombre_archivo=$ultimo_id.'.'.$extension;
					$directorio=$dir['ruta_dir'];
					
					$UpdateRecords = "UPDATE repositorio_archivos SET file_name='$nombre_archivo', ruta_file='$directorio' WHERE file_id='$ultimo_id'";
					$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
					$SelectedDB = mysql_select_db($this->DBNAME);
					$result = mysql_query($UpdateRecords); 	
				}
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}
	

// 							MOVER ARCHIVO                            //
//******************************************************************************//
	function mover_archivo($tipo,$id_file,$origen,$destino,$id_usuario) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$data=$this->datos_archivo_repositorio($id_file);
		$dir=$this->datos_directorio($destino,$id_usuario);
				
				if ($tipo==1) {		
					copy ('../../../usuarios/'.$data['ruta_file'].'/'.$data['file_name'],'../../../usuarios/'.$dir['ruta_dir'].'/'.$data['file_name']);
					unlink('../../../usuarios/'.$data['ruta_file'].'/'.$data['file_name']);
					
					/*$nombre_archivo=$ultimo_id.'.'.$extension;*/
					$directorio=$dir['ruta_dir'];
					$id_directorio=$dir['id'];
					
					$UpdateRecords = "UPDATE repositorio_archivos SET ruta_file='$directorio', id_directorio='$id_directorio' WHERE file_id='$id_file'";
					$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
					$SelectedDB = mysql_select_db($this->DBNAME);
					$result = mysql_query($UpdateRecords); 	
				}
				mysql_close($connection);
				return true;
	}
	
		
// 							INSERTAR NUEVA IMAGEN TEMPORAL A MI REPOSITORIO                             //
//******************************************************************************//
	function add_temp_repositorio($name,$id_directorio,$directorio,$id_usuario) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO repositorio_archivos
		(file_name,id_directorio,id_usuario) 
		VALUES ('$name','$id_directorio','$id_usuario')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				$extension = strtolower(substr(strrchr($name, "."), 1));
				
				$palabra=explode('_',$name);
				$id_palabra=$palabra[1];
				
				copy ('../../../temp/'.$name.'','../../../usuarios/'.$directorio.'/'.$ultimo_id.'.'.$extension.'');
				
				$nombre_archivo=$ultimo_id.'.'.$extension;
				$UpdateRecords = "UPDATE repositorio_archivos SET file_name='$nombre_archivo', ruta_file='$directorio', id_palabra='$id_palabra' WHERE file_id='$ultimo_id'";
        		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords); 	
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}	


// 	 INSERTAR NUEVA IMAGEN TEMPORAL DESDE ZIP A MI REPOSITORIO                             //
//******************************************************************************//
	function validar_simbolos_temporales($nombre_campo,$valor) {
		
		if ($valor==1) { 
		
			$query = "SELECT *
			FROM simbolos_temp
			WHERE revisado = 0
			AND id_simbolo_tmp='$nombre_campo'";
			
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($query); 
			$row = mysql_fetch_array($result);
			
			$carpeta=$row['id_tipo_simbolo'].$row['marco'].$row['contraste'].$row['sup_con_texto'].$row['sup_idioma'].$row['sup_mayusculas'].$row['sup_font'].$row['inf_con_texto'].$row['inf_idioma'].$row['inf_mayusculas'].$row['inf_font'];
			
			$id_palabra=$row['id_palabra'];
			$id_imagen=$row['id_imagen'];
			$id_tipo_simbolo=$row['id_tipo_simbolo'];
			$marco=$row['marco'];
			$contraste=$row['contraste'];
			$sup_con_texto=$row['sup_con_texto'];
			$sup_idioma=$row['sup_idioma'];
			$sup_mayusculas=$row['sup_mayusculas'];
			$sup_font=$row['sup_font'];
			$inf_con_texto=$row['inf_con_texto'];
			$inf_idioma=$row['inf_idioma'];
			$inf_mayusculas=$row['inf_mayusculas'];
			$inf_font=$row['inf_font'];
			$sup_font_size=$row['sup_font_size'];
			$sup_font_color=$row['sup_font_color'];
			$inf_font_size=$row['inf_font_size'];
			$inf_font_color=$row['inf_font_color'];
			$archivo_temporal=$row['archivo_temporal'];
			$sup_id_traduccion=$row['sup_id_traduccion'];
			$inf_id_traduccion=$row['inf_id_traduccion'];
			
			$timestamp=time();
			$fecha=date("Y-m-d H:i:s",$timestamp);
			
			$picture_data=$this->datos_imagen($id_imagen);
			
			$tags_simbolo=$picture_data['tags_imagen'];
			
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$ssql = "INSERT INTO simbolos (id_palabra,id_imagen,id_tipo_simbolo,marco,contraste,sup_con_texto,sup_idioma,sup_mayusculas,sup_font,inf_con_texto,inf_idioma,inf_mayusculas,inf_font,sup_font_size,sup_font_color,inf_font_size,inf_font_color,estado,fecha_alta,fecha_modificado,registrado,tags_simbolo,sup_id_traduccion,inf_id_traduccion) 
			VALUES ('$id_palabra','$id_imagen','$id_tipo_simbolo','$marco','$contraste','$sup_con_texto','$sup_idioma','$sup_mayusculas','$sup_font','$inf_con_texto','$inf_idioma','$inf_mayusculas','$inf_font','$sup_font_size','$sup_font_color','$inf_font_size','$inf_font_color','1','$fecha','$fecha','0','$tags_simbolo','$sup_id_traduccion','$inf_id_traduccion')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				$origen='../../repositorio/simbolos/pendientes/'.$carpeta.'/'.$archivo_temporal;
				$extension = strtolower(substr(strrchr($origen, "."), 1));
				
				if (!is_dir('../../repositorio/simbolos/fuente/'.$carpeta.'/')) {
				   mkdir('../../repositorio/simbolos/fuente/'.$carpeta.'/', 0777);
				} 	
							
				copy ($origen,'../../repositorio/simbolos/fuente/'.$carpeta.'/'.$ultimo_id.'.'.$extension.'');
				unlink ($origen);
				
				$qDelete = "DELETE FROM simbolos_temp WHERE id_simbolo_tmp = '$nombre_campo'";	
				$delete_result = mysql_query($qDelete);	
				mysql_close($connection);
				return $ultimo_id;
				
			}else{
				mysql_close($connection);
				return false;
			}
		
		} elseif ($valor==2) {
		
				$UpdateRecords = "UPDATE simbolos_temp SET revisado=1 WHERE id_simbolo_tmp = '$nombre_campo'";
        		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords); 
				mysql_close($connection);
				return true;
		}
		
 		
	}

// 	 INSERTAR NUEVA IMAGEN TEMPORAL DESDE ZIP A MI REPOSITORIO                             //
//******************************************************************************//
	function actualizar_simbolos_temporales($id_simbolo_tmp,$nombre_tmp) {
		
				$UpdateRecords = "UPDATE simbolos_temp SET archivo_temporal='$nombre_tmp' WHERE id_simbolo_tmp = '$id_simbolo_tmp'";
        		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords);
				mysql_close($connection);
	}
	
// 	 INSERTAR NUEVA IMAGEN TEMPORAL DESDE ZIP A MI REPOSITORIO                             //
//******************************************************************************//
	function add_zip_repositorio($id_directorio,$id_usuario,$origen) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$dir=$this->datos_directorio($id_directorio,$id_usuario);
		$ssql = "INSERT INTO repositorio_archivos
		(file_name,id_directorio,id_usuario) 
		VALUES ('$name','$id_directorio','$id_usuario')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				$extension = strtolower(substr(strrchr($origen, "."), 1));
				$directorio=$dir['ruta_dir'];
				
				copy ($origen,'../../../usuarios/'.$dir['ruta_dir'].'/'.$ultimo_id.'.'.$extension.'');
				
				$nombre_archivo=$ultimo_id.'.'.$extension;
				$UpdateRecords = "UPDATE repositorio_archivos SET file_name='$nombre_archivo', ruta_file='$directorio' WHERE file_id='$ultimo_id'";
        		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords); 	
				mysql_close($connection);
				return $ultimo_id;
				
			}else{
				mysql_close($connection);
				return false;
			} 		
	}	


// 			   INSERTAR IMAGEN SUBIDA A MI REPOSITORIO                           //
//******************************************************************************//
	function add_upload_repositorio($name,$id_directorio,$directorio,$id_usuario) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO repositorio_archivos
		(file_name,id_directorio) 
		VALUES ('$name','$id_directorio')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				$extension = strtolower(substr(strrchr($name, "."), 1));
				
				$nombre_archivo=$ultimo_id.'.'.$extension;
				$UpdateRecords = "UPDATE repositorio_archivos SET file_name='$nombre_archivo', ruta_file='$directorio', id_usuario='$id_usuario' WHERE file_id='$ultimo_id'";
        		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords); 	
				mysql_close($connection);
				return $nombre_archivo;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}	

function do_upload($upload_dir,$upload_url,$query,$id_dir,$ruta,$id_user) {

  $temp_name = $_FILES['userfile']['tmp_name'];
  $file_name = $_FILES['userfile']['name']; 
  $file_name = str_replace("\\","",$file_name);
  $file_name = str_replace("'","",$file_name);
  
  $file_name=$this->add_upload_repositorio($file_name,$id_dir,$ruta,$id_user);
  
  $file_path = $upload_dir.$file_name;

	//File Name Check
  if ( $file_name =="") { 
  	$message = "Normbre de archivo incorrecto";
  	return $message;
  }

  $result  =  move_uploaded_file($temp_name, $file_path);
  if (!chmod($file_path,0777))
   	$message = "El cambio de permisos a 777 ha fallado.";
  else
    $message = "$file_name ha sido añadido correctamente.";
  return $message;
}

function do_zip_upload($upload_dir,$upload_url,$query,$id_dir,$ruta) {

  $temp_name = $_FILES['userfile']['tmp_name'];
  $file_name = $_FILES['userfile']['name']; 
  $file_name = str_replace("\\","",$file_name);
  $file_name = str_replace("'","",$file_name);
    
  $file_path = $upload_dir.$file_name;

	//File Name Check
  if ( $file_name =="") { 
  	$message = "Normbre de archivo incorrecto";
  	return $message;
  }

  $result  =  move_uploaded_file($temp_name, $file_path);
  if (!chmod($file_path,0777))
   	$message = "El cambio de permisos a 777 ha fallado.";
  else
    $message = "$file_name ha sido añadido correctamente.";
  return $message;
}

		
// 							INSERTAR NUEVA NOTICIA                             //
//******************************************************************************//
	function add_noticia($id_usuario,$titulo,$noticia,$estado,$idioma) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO noticias
		(id_colaborador, titulo, noticia, fecha_insercion, fecha_modificacion, estado, idioma) 
		VALUES ('$id_usuario', '$titulo', '$noticia', '$fecha', '$fecha', '$estado', '$idioma')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}

// 							AÑADIR SUBSCRIPTOR                             //
//******************************************************************************//
	function add_subscriptor($email) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO newsletter_subscribers
		(email_subscriptor,fecha_alta,activo) 
		VALUES ('$email','$fecha',0)";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}

// 							AÑADIR NUEVO BOLETIN                             //
//******************************************************************************//
	function add_newsletter($boletin) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO newsletters
		(newsletter,fecha_publicacion) 
		VALUES ('$boletin','$fecha')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}
	
// 					FUNCION CONFIRMAR SUBSCRIPCION                              //
//******************************************************************************//
function confirmar_subscripcion($id_subscriptor) {

		$UpdateRecords = "UPDATE newsletter_subscribers 
		SET activo=1
		WHERE id_subscriptor='$id_subscriptor'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);

}
	
//******************************************************************************//	
	function add_adscripcion_palabra($id_imagen,$id_palabra) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO palabra_imagen
		(id_imagen, id_palabra) 
		VALUES ('$id_imagen', '$id_palabra')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}
	
// 							INSERTAR NUEVO SIMBOLO                              //
//******************************************************************************//
	function add_nuevo_simbolo($id_palabra,$tipo_simbolo,$idioma,$estado,$castellano,$registrado,$mayusculas,$contraste,$marco) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO simbolos 
		(id_palabra, id_tipo_simbolo, id_idioma, castellano, mayusculas, marco, contraste, estado, fecha_alta, fecha_modificado, registrado) 
		VALUES ('$id_palabra', '$tipo_simbolo', '$idioma', '$castellano', '$mayusculas', '$marco', '$contraste', '$estado', '$fecha', '$fecha','$registrado')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}


// 							AÑADIR AUTOR                         //
//******************************************************************************//
	function add_autor($nombre,$empresa_institucion,$web_autor,$email) {
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO autores (autor, empresa_institucion, web_autor, email_autor) 
			VALUES ('$nombre', '$empresa_institucion', '$web_autor', '$email')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}

// 					FUNCION ACTUALIZAR DEFINICION 		                     //
//******************************************************************************//
	function actualizar_autor($id_autor,$nombre,$empresa_institucion,$web_autor,$email) {

		$UpdateRecords = "UPDATE autores SET autor='$nombre', empresa_institucion='$empresa_institucion', web_autor='$web_autor', email_autor='$email'
		WHERE id_autor='$id_autor'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	}
	
// 							INSERTAR TRADUCCION                         //
//******************************************************************************//
	function add_traduccion($id_palabra, $id_idioma, $traduccion,$explicacion,$pronunciacion,$id_colaborador,$estado) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		$fecha_modificacion=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO traducciones (id_palabra, traduccion, explicacion,pronunciacion, id_idioma, id_colaborador,  estado, fecha_alta, fecha_modificacion) 
			VALUES ('$id_palabra', '$traduccion', '$explicacion', '$pronunciacion','$id_idioma', '$id_colaborador', '$estado', '$fecha', '$fecha')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}

// 							INSERTAR TRADUCCION TEMPOARAL                       //
//******************************************************************************//
	function add_traduccion_temp($id_palabra, $id_idioma, $traduccion,$explicacion,$pronunciacion,$id_colaborador,$estado) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		$fecha_modificacion=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO traducciones_temp (id_palabra, traduccion, explicacion,pronunciacion, id_idioma, id_colaborador,  estado, fecha_alta, fecha_modificacion) 
			VALUES ('$id_palabra', '$traduccion', '$explicacion', '$pronunciacion','$id_idioma', '$id_colaborador', '$estado', '$fecha', '$fecha')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}
	
// 							AÑADIR NUEVA PALABRA                        //
//******************************************************************************//
	function add_palabra($PickList,$palabra, $definicion, $id_tipo_palabra,$id_colaborador,$estado) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO palabras (palabra, definicion, id_tipo_palabra, id_colaborador, fecha_creacion, ultima_modificacion, estado) 
			VALUES ('$palabra', '$definicion', '$id_tipo_palabra', '$id_colaborador','$fecha', '$fecha','$estado')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection);
				if (isset($PickList)) {
  					foreach ($PickList as $indice=>$valor){ 
					$ssql2= "INSERT INTO palabra_subtema (id_palabra, id_subtema) 
							VALUES ('$ultimo_id','$valor')";
					$result = mysql_query($ssql2,$connection); 
					}
				}
				mysql_close($connection);
				return $ultimo_id;
			}else{
				mysql_close($connection);
				return false;
			} 		
	}	


// 							AÑADIR NUEVO USUARIO                       //
//******************************************************************************//
	function add_usuario($nombre,$primer_apellido,$segundo_apellido,$usuario,$password,$email,$t_ruso,$t_arabe,$t_rumano,$t_chino,$t_polaco,$t_bulgaro,$t_ingles,$t_frances,$t_catalan,$gestion_usuarios,$gestion_palabras,$definicion_palabras,$borrar_palabras,$add_imagenes,$borrar_imagenes,$add_simbolos,$borrar_simbolos,$simbolos_especiales) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO colaboradores (nombre, primer_apellido, segundo_apellido, login, password, email, estado) 
			VALUES ('$nombre', '$primer_apellido', '$segundo_apellido', '$usuario','$password', '$email','1')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				//recibo el último id
				$ultimo_id = mysql_insert_id($connection); 
				$ssql2= "INSERT INTO colaboradores_permisos (id_colaborador, traduccion_ruso, traduccion_arabe, traduccion_rumano, 
				traduccion_chino, traduccion_polaco,traduccion_bulgaro,traduccion_ingles,traduccion_frances,traduccion_catalan,gestion_usuarios, gestion_palabras, 
				definicion_palabras, borrar_palabras, add_imagenes, borrar_imagenes, add_simbolos, borrar_simbolos, simbolos_especiales ) 
				VALUES 
				('$ultimo_id','$t_ruso','$t_arabe','$t_rumano','$t_chino','$t_polaco','$t_bulgaro','$t_ingles',
				'$t_frances','$t_catalan','$gestion_usuarios','$gestion_palabras','$definicion_palabras',
				 '$borrar_palabras', '$add_imagenes', '$borrar_imagenes', '$add_simbolos', '$borrar_simbolos','$simbolos_especiales')";
				$result = mysql_query($ssql2,$connection);
				
				$ssql3 = "INSERT INTO repositorio_directorios (name, parent, id_usuario,ruta_dir) 
				VALUES ('raiz', '0', '$ultimo_id', '$ultimo_id')";
				$result3 = mysql_query($ssql3,$connection);
				
				mkdir ("../../usuarios/$ultimo_id/", 0777);
				chmod("../../usuarios/$ultimo_id/", 0777);  
				mysql_close($connection);
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

// 							AÑADIR NUEVO USUARIO                       //
//******************************************************************************//
	function registro_previo_usuario($nombre,$primer_apellido,$segundo_apellido,$usuario,$password,$email,$centro) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO colaboradores (nombre, primer_apellido, segundo_apellido, login, password, email, estado, centro, id_tipo) 
			VALUES ('$nombre', '$primer_apellido', '$segundo_apellido', '$usuario','$password', '$email','0','$centro','1')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection); 
			$ssql2= "INSERT INTO colaboradores_permisos (id_colaborador) VALUES ('$ultimo_id')";
			$result = mysql_query($ssql2,$connection);
				//recibo el último id
				mysql_close($connection);
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

// 							AÑADIR NUEVA SELECCION                      //
//******************************************************************************//
	function crear_nueva_seleccion($id_usuario,$nombre,$tags) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO seleccion (id_usuario,seleccion,tags) 
			VALUES ('$id_usuario','$nombre','$tags')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection); 
				//recibo el último id
				mysql_close($connection);
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

// 							MODIFICAR SELECCION                      //
//******************************************************************************//
	function modificar_seleccion($id_seleccion,$id_usuario,$nombre,$tags) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$UpdateRecords = "UPDATE seleccion 
		SET seleccion='$nombre', fecha_modificacion='$fecha',tags='$tags' WHERE id_seleccion='$id_seleccion'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		
		$qDelete = "DELETE FROM seleccion_simbolos WHERE id_seleccion='$id_seleccion'";	
		$result = mysql_query($qDelete);	
		mysql_close($connection);	
		return $id_seleccion;		
	}
	
// 							AÑADIR NUEVO SIMBOLO A SELECCION                      //
//******************************************************************************//
	function add_simbolos_seleccion($id_seleccion,$orden,$id_file,$id_palabra) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO seleccion_simbolos (id_seleccion,orden,id_file,id_palabra) 
			VALUES ('$id_seleccion','$orden','$id_file','$id_palabra')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection); 
				mysql_close($connection);
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

// 							AÑADIR NUEVO SIMBOLO A SELECCION                      //
//******************************************************************************//
	function add_campo_internacionalizacion($add_key,$add_id_pagina,$add_valor) {
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		/*$ssql = "INSERT INTO internacionalizacion  
		VALUES (NULL,'$add_key,'$add_id_pagina','$add_valor','','','')";*/
		
		$ssql ="INSERT INTO `internacionalizacion` ( `id_key` , `key` , `id_page` , `es` , `en` , `ca` , `fr` ) 
		VALUES (
			NULL ,  '$add_key',  '$add_id_pagina',  '$add_valor', NULL , NULL , NULL
		)";

			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection); 
				mysql_close($connection);
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}
	
// 							AÑADIR NUEVO MATERIAL                      //
//******************************************************************************//
	
	function add_new_material($titulo,$descripcion,$objetivos,$estado,$autores,$ac,$dirigido,$edad,$nivel,$saa,$tipo,$archivos,$id_licencia,$subac,$idiomas) {
	
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO materiales (material_titulo,fecha_alta,material_descripcion,material_objetivos,
		material_estado,material_autor,material_area_curricular,material_dirigido,material_edad,material_nivel,
		material_saa,material_tipo,material_archivos,material_licencia,material_subarea_curricular,material_idiomas) 
		VALUES ('$titulo','$fecha','$descripcion','$objetivos','$estado','$autores','$ac','$dirigido','$edad',
		'$nivel','$saa','$tipo','$archivos','$id_licencia','$subac','$idiomas')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			$ultimo_id = mysql_insert_id($connection);
				mysql_close($connection);
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 
	
	}

// 							AÑADIR NUEVO FICHA SOFTWARE                      //
//******************************************************************************//
	
	function add_new_ficha_software($titulo,$descripcion,$objetivo,$informacion_adicional,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$so,$id_licencia,$idiomas,$url1,$url2,$url3,$precio) {
	
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO software (software_titulo,fecha_alta,software_estado,software_destacado,software_archivos,software_capturas,software_autor,software_tipo,software_so,software_licencia,software_idiomas,software_url1,software_url2,software_url3,software_precio)
		VALUES ('$titulo','$fecha','$estado','$destacado','$archivos','$capturas','$autores',
		'$tipo','$so','$id_licencia','$idiomas','$url1','$url2','$url3','$precio')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				$ultimo_id = mysql_insert_id($connection);
				
				$ssql2= "INSERT INTO software_descripcion (id_software,software_descripcion) VALUES ('$ultimo_id','$descripcion')";
				$result2 = mysql_query($ssql2,$connection);
				
				$ssql3= "INSERT INTO software_objetivo (id_software,software_objetivo) VALUES ('$ultimo_id','$objetivo')";
				$result3 = mysql_query($ssql3,$connection);
				
				$ssql3= "INSERT INTO software_informacion_adicional (id_software,software_informacion_adicional) 
				VALUES ('$ultimo_id','$informacion_adicional')";
				$result3 = mysql_query($ssql3,$connection);
				mysql_close($connection);
				 
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 
	
	}


// 							AÑADIR NUEVO FICHA EJEMPLOS DE USO                    //
//******************************************************************************//
	
	function add_new_ficha_eu($titulo,$descripcion,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$idiomas,$url1,$url2,$url3) {
	
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO eu (eu_titulo,fecha_alta,eu_estado,eu_destacado,eu_archivos,eu_capturas,eu_autor,eu_tipo,eu_idiomas,eu_url1,eu_url2,eu_url3)
		VALUES ('$titulo','$fecha','$estado','$destacado','$archivos','$capturas','$autores',
		'$tipo','$idiomas','$url1','$url2','$url3')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				$ultimo_id = mysql_insert_id($connection);
				
				$ssql2= "INSERT INTO eu_descripcion (id_eu,eu_descripcion) VALUES ('$ultimo_id','$descripcion')";
				$result2 = mysql_query($ssql2,$connection);
				 
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 
	
	}


// 							AÑADIR NUEVO DIRECTORIO                      //
//******************************************************************************//
	function crear_directorio($nombre,$id_usuario,$parent,$ruta) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		$directorio=$this->datos_directorio($parent,$id_usuario);
		$root=$directorio['ruta_dir'];
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO repositorio_directorios (name,parent,id_usuario,ruta_dir) 
			VALUES ('$nombre','$parent','$id_usuario','$root/$nombre')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				$ultimo_id = mysql_insert_id($connection); 
				
				$oldumask = umask(0);
				mkdir ("../../../usuarios/$root/$nombre/", 0777);
				chmod("../../../usuarios/$root/$nombre/", 0777); 
				
				mysql_close($connection);
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}


// 							BORRAR DIRECTORIO                      //
//******************************************************************************//
	function borrar_directorio($id_dir,$id_usuario,$parent,$ruta) {
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
				
		$query2 = "SELECT * FROM repositorio_directorios
		WHERE ruta_dir LIKE '$ruta%' AND id_usuario='$id_usuario'";
		$result2 = mysql_query($query2); 
		
		while ($row2=mysql_fetch_array($result2)) {
		
			$id_directorio=$row2['id'];
			$qDelete4 = "DELETE FROM repositorio_archivos WHERE id_directorio='$id_directorio' AND id_usuario='$id_usuario'";
			$result4 = mysql_query($qDelete4);
			$qDelete = "DELETE FROM repositorio_directorios WHERE id='$id_directorio' AND id_usuario='$id_usuario'";
			$result = mysql_query($qDelete);
		
		}
		
		mysql_close($connection);
		 	
	}
	
// 							AÑADIR NUEVO DIRECTORIO                      //
//******************************************************************************//
	function borrar_archivo($id_file,$tipo,$ruta) {
	
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM repositorio_archivos WHERE file_id='$id_file'";	
		$result = mysql_query($qDelete); 
		
		if ($tipo==1) {
		
			unlink('../../../usuarios/'.$ruta);
		
		}
		
		mysql_close($connection);
	
	
	}
//                   FUNCION DATOS DIRECTORIO         //
//******************************************************************************//	

	function datos_directorio($id,$id_usuario) {
		$query = "SELECT * FROM repositorio_directorios
		WHERE id='$id' AND id_usuario='$id_usuario'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$rows = mysql_fetch_array($result);
		mysql_close($connection);
		return $rows;
	}


//                   FUNCION CONTENIDO DIRECTORIO (FICHEROS)       //
//******************************************************************************//	

	function contenido_directorio($id_directorio) {
		$query = "SELECT repositorio_archivos.*, repositorio_directorios.* 
		FROM repositorio_archivos, repositorio_directorios
		WHERE repositorio_archivos.id_directorio='$id_directorio' 
		AND repositorio_archivos.id_directorio=repositorio_directorios.id";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		mysql_close($connection);
		return $result;
	}
					
// 					FUNCION ACTIVAR USUARIO 		                     //
//******************************************************************************//

	function activar_usuario ($id_colaborador) {
	
	$UpdateRecords = "UPDATE colaboradores 
		SET estado='1' WHERE id_colaborador='$id_colaborador'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords);
		mysql_close($connection);
	
	}	

// 					FUNCION ACTUALIZAR USUARIO 		                     //
//******************************************************************************//
	function actualizar_usuario($id_colaborador,$nombre,$primer_apellido,$segundo_apellido,$usuario,$password,$email,$t_ruso,$t_arabe,$t_rumano,$t_chino,$t_polaco,$t_bulgaro,$t_ingles,$t_frances,$t_catalan,$gestion_usuarios,$gestion_palabras,$definicion_palabras,$borrar_palabras,$add_imagenes,$borrar_imagenes,$add_simbolos,$borrar_simbolos,$simbolos_especiales) {

		$UpdateRecords = "UPDATE colaboradores 
		SET nombre='$nombre', primer_apellido='$primer_apellido', segundo_apellido='$segundo_apellido', login='$usuario', password='$password',
		estado='1', email='$email'
		WHERE id_colaborador='$id_colaborador'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 	
		mysql_close($connection);
		
		$UpdateRecords2 = "UPDATE colaboradores_permisos
		SET traduccion_ruso='$t_ruso', traduccion_arabe='$t_arabe', traduccion_rumano='$t_rumano',
		traduccion_chino='$t_chino',traduccion_polaco='$t_polaco',traduccion_bulgaro='$t_bulgaro',
		traduccion_ingles='$t_ingles',traduccion_frances='$t_frances',traduccion_catalan='$t_catalan',
		gestion_usuarios='$gestion_usuarios', gestion_palabras='$gestion_palabras', definicion_palabras='$definicion_palabras', 
		borrar_palabras='$borrar_palabras', add_imagenes='$add_imagenes', borrar_imagenes='$borrar_imagenes', add_simbolos='$add_simbolos',
		borrar_simbolos='$borrar_simbolos', simbolos_especiales='$simbolos_especiales'
		 WHERE id_colaborador='$id_colaborador'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords2); 
		mysql_close($connection);
	}

// 					FUNCION ACTUALIZAR NOTICIA                     //
//******************************************************************************//
	function actualizar_noticia($id_noticia, $titulo, $noticia, $estado, $idioma) {
		
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$UpdateRecords = "UPDATE noticias 
		SET titulo='$titulo', noticia='$noticia', estado='$estado', fecha_modificacion='$fecha', idioma='$idioma'
		WHERE id_noticia='$id_noticia'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);
			
	}

// 					FUNCION MODIFICAR MATERIAL		                     //
//******************************************************************************//

	function modificar_material($id_material,$titulo,$descripcion,$objetivos,$estado,$autores,$ac,$dirigido,$edad,$nivel,$saa,$tipo,$archivos,$id_licencia,$subac,$idiomas) {
	
	$UpdateRecords = "UPDATE materiales 
		SET material_titulo='$titulo', material_descripcion='$descripcion', material_objetivos='$objetivos',
		material_estado='$estado',material_autor='$autores',material_area_curricular='$ac',
		material_dirigido='$dirigido',material_edad='$edad',material_nivel='$nivel',
		material_saa='$saa',material_tipo='$tipo',material_archivos='$archivos',
		material_licencia='$id_licencia', material_subarea_curricular='$subac',
		material_idiomas='$idiomas'
		WHERE id_material='$id_material'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);
	
	}

// 					FUNCION MODIFICAR SOFTWARE		                     //
//******************************************************************************//

	function modificar_software($id_software,$titulo,$descripcion,$objetivo,$informacion_adicional,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$so,$id_licencia,$idiomas,$url1,$url2,$url3,$precio) {
	
		$UpdateRecords = "UPDATE software 
		SET software_titulo='$titulo', software_autor='$autores', software_capturas='$capturas',
		software_tipo='$tipo', software_so='$so', software_precio='$precio', software_licencia='$id_licencia',
		software_estado='$estado', software_idiomas='$idiomas', software_archivos='$archivos', 
		software_destacado='$destacado', software_url1='$url1', software_url2='$url2', 
		software_url3='$url3'
		WHERE id_software='$id_software'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		
		$UpdateRecords2 = "UPDATE software_descripcion 
		SET software_descripcion='$descripcion'
		WHERE id_software='$id_software'";
		$result2 = mysql_query($UpdateRecords2);
		
		$UpdateRecords3 = "UPDATE software_objetivo 
		SET software_objetivo='$objetivo'
		WHERE id_software='$id_software'";
		$result3 = mysql_query($UpdateRecords3);
		
		$UpdateRecords4 = "UPDATE software_informacion_adicional 
		SET software_informacion_adicional='$informacion_adicional'
		WHERE id_software='$id_software'";
		$result4 = mysql_query($UpdateRecords4);
		
		mysql_close($connection);
	
	}

// 					FUNCION MODIFICAR FICHA EJEMPLO DE USO	                     //
//******************************************************************************//

	function modificar_eu($id_eu,$titulo,$descripcion,$estado,$destacado,$archivos,$capturas,$autores,$tipo,$idiomas,$url1,$url2,$url3) {
	
		$UpdateRecords = "UPDATE eu 
		SET eu_titulo='$titulo', eu_autor='$autores', eu_capturas='$capturas',
		eu_tipo='$tipo', eu_estado='$estado', eu_idiomas='$idiomas', 
		eu_archivos='$archivos', eu_destacado='$destacado', eu_url1='$url1', 
		eu_url2='$url2', eu_url3='$url3'
		WHERE id_eu='$id_eu'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		
		$UpdateRecords2 = "UPDATE eu_descripcion 
		SET eu_descripcion='$descripcion'
		WHERE id_eu='$id_eu'";
		$result2 = mysql_query($UpdateRecords2);
		
		mysql_close($connection);
	
	}
	
// 					FUNCION ACTUALIZAR NUMERO DE VECES VISTA IMAGEN              //
//******************************************************************************//
//SE ANULA ESTA FUNCION AL HABER ELIMINADO EL CAMPO VECES_VISTO EN LA TABLA IMAGENES
//******************************************************************************//
function imagen_numero_visitas($id_imagen) {

$UpdateRecords = "UPDATE imagenes 
		SET veces_visto=veces_visto+1
		WHERE id_imagen='$id_imagen'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);

}

// 					FUNCION ACTUALIZAR NUMERO DE VECES VISTO SÍMBOLO              //
//******************************************************************************//
function simbolo_numero_visitas($id_simbolo) {

$UpdateRecords = "UPDATE simbolos 
		SET veces_visto=veces_visto+1
		WHERE id_simbolo='$id_simbolo'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);

}


// 					FUNCION ACTUALIZAR SIMBOLO 		                     //
//******************************************************************************//
	function actualizar_simbolo($id_simbolo, $id_palabra, $tipo_simbolo, $idioma, $estado, $castellano, $registrado, $mayusculas, $marco, $contraste) {
		
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$UpdateRecords = "UPDATE simbolos 
		SET id_palabra='$id_palabra', id_tipo_simbolo='$tipo_simbolo', id_idioma='$idioma', estado='$estado', castellano='$castellano',
		registrado='$registrado', fecha_modificado='$fecha', mayusculas='$mayusculas', marco='$marco', contraste='$contraste'
		WHERE id_simbolo='$id_simbolo'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);
			
	}


// 					FUNCION ACTUALIZAR IMAGEN 		                     //
//******************************************************************************//
	function actualizar_imagen($id_imagen,$id_tipo_imagen,$estado,$registrado,$id_licencia,$id_autor,$tags,$tipo_pictograma,$validos_senyalectica) {
		
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
				
		$UpdateRecords = "UPDATE imagenes 
		SET estado='$estado', 
		registrado='$registrado', ultima_modificacion='$fecha',
		id_licencia='$id_licencia', id_autor='$id_autor',
		tags_imagen='$tags', id_tipo_imagen='$id_tipo_imagen',
		tipo_pictograma=$tipo_pictograma,
		validos_senyalectica='$validos_senyalectica'
		WHERE id_imagen='$id_imagen'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);
			
	}
				
// 							AÑADIR NUEVA IMAGEN                        //
//******************************************************************************//
	function add_new_picture($id_usuario,$id_tipo_imagen,$imagen,$id_palabra,$estado,$registrado,$id_autor,$id_licencia,$tags,$tipo_pictograma,$validos_senyalectica,$original_filename) {
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		$fecha_modificacion=date("Y-m-d H:i:s",$timestamp);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$ssql = "INSERT INTO imagenes(id_colaborador,id_tipo_imagen,fecha_creacion, ultima_modificacion, estado, registrado,id_autor,id_licencia,tags_imagen,tipo_pictograma,validos_senyalectica,original_filename) 
			VALUES ('$id_usuario', '$id_tipo_imagen', '$fecha', '$fecha', '$estado','$registrado','$id_autor','$id_licencia','$tags','$tipo_pictograma','$validos_senyalectica','$original_filename')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
			
				$palabras_seleccionadas=explode(';',$id_palabra);
				$ultimo_id = mysql_insert_id($connection);
	
				foreach ($palabras_seleccionadas as $key => $value) {
				
					if ($value != '') {
						
						//recibo el último id
						
						$ssql2= "INSERT INTO palabra_imagen (id_palabra, id_imagen) VALUES ('$value','$ultimo_id')";
						$result = mysql_query($ssql2,$connection); 
						
						$extension = strtolower(substr(strrchr($imagen, "."), 1));
						
						$UpdateRecords = "UPDATE imagenes SET imagen='$ultimo_id.$extension', extension='$extension' WHERE id_imagen='$ultimo_id'";
						$result = mysql_query($UpdateRecords,$connection); 							
						
					}
				
				}
				mysql_close($connection);
				return $ultimo_id.".".$extension;
				
			}else{
				mysql_close($connection);
				return false;
			} 		
	}
	
// 					FUNCION ACTUALIZAR PALABRA 		                     //
//******************************************************************************//
	function update_palabra($id_palabra,$PickList,$palabra,$id_tipo_palabra,$estado) {

		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
		
		$UpdateRecords = "UPDATE palabras SET id_tipo_palabra='$id_tipo_palabra', ultima_modificacion='$fecha'
		WHERE id_palabra='$id_palabra'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 	
		
		$qDelete = "DELETE FROM palabra_subtema WHERE id_palabra='$id_palabra'";	
		$result3 = mysql_query($qDelete); 
		
			if (isset($PickList)) {
  				foreach ($PickList as $indice=>$valor){ 
					$ssql2= "INSERT INTO palabra_subtema (id_palabra, id_subtema) 
							VALUES ('$id_palabra','$valor')";
					$result2 = mysql_query($ssql2,$connection); 
				}
			}
		
		mysql_close($connection);
					
	}

// 					FUNCION ACTUALIZAR PALABRA CATALOGADOR	                     //
//******************************************************************************//
	function update_palabra_catalogador($id_palabra,$PickList) {	
	
		$qDelete = "DELETE FROM palabra_subtema WHERE id_palabra='$id_palabra'";
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result3 = mysql_query($qDelete,$connection); 
		
			if (isset($PickList)) {
  				foreach ($PickList as $indice=>$valor){ 
					$subtema=$this->datos_subtema_tmp($valor);
					$id_tema=$subtema['id_tema'];
					$ssql2= "INSERT INTO palabra_subtema (id_palabra, id_subtema, tema_id) 
							VALUES ('$id_palabra','$valor','$id_tema')";
					$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
					$SelectedDB = mysql_select_db($this->DBNAME);
					$result2 = mysql_query($ssql2,$connection); 
				}
			}
		
		mysql_close($connection);
					
	}
	
// 					FUNCION ACTUALIZAR PALABRA CATALOGADOR TEMPORAL	                     //
//******************************************************************************//
	function update_palabra_catalogador_tmp($id_palabra,$PickList) {	
		
		$qDelete = "DELETE FROM palabra_subtema_tmp WHERE id_palabra='$id_palabra'";
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result3 = mysql_query($qDelete,$connection); 
		
			if (isset($PickList)) {
  				foreach ($PickList as $indice=>$valor){ 
					$subtema=$this->datos_subtema_tmp($valor);
					$id_tema=$subtema['id_tema'];
					$ssql2= "INSERT INTO palabra_subtema_tmp (id_palabra, id_subtema, tema_id) 
							VALUES ('$id_palabra','$valor','$id_tema')";
					$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
					$SelectedDB = mysql_select_db($this->DBNAME);
					$result2 = mysql_query($ssql2,$connection); 
				}
			}
		
		mysql_close($connection);
					
	}

// 					FUNCION ASIGNAR PALABRA A SUBTEMA	                     //
//******************************************************************************//
	function asignar_palabra_subtema_tmp($id_palabra,$id_tema,$id_subtema) {	
		
		$query6 = "SELECT * FROM palabra_subtema_tmp 
		WHERE id_palabra='$id_palabra' 
		AND tema_id='$id_tema'
		AND id_subtema='$id_subtema'";
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result6 = mysql_query($query6); 
	
		$numrows = mysql_num_rows($result6);
		
			if ($numrows==0) {
					$ssql2= "INSERT INTO palabra_subtema_tmp (id_palabra, id_subtema, tema_id) 
							VALUES ('$id_palabra','$id_subtema','$id_tema')";
					$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
					$SelectedDB = mysql_select_db($this->DBNAME);
					$result2 = mysql_query($ssql2,$connection); 
			} 
		
		mysql_close($connection);
					
	}
	
// 					FUNCION ACTUALIZAR DEFINICION 		                     //
//******************************************************************************//
	function modify_traduccion($id_traduccion,$id_palabra,$id_idioma,$traduccion,$pronunciacion,$estado,$explicacion) {

		$UpdateRecords = "UPDATE traducciones SET traduccion='$traduccion', estado='$estado', pronunciacion='$pronunciacion',explicacion='$explicacion'
		WHERE id_palabra='$id_palabra' AND id_idioma=$id_idioma AND id_traduccion='$id_traduccion'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		
		$query6 = "SELECT * FROM simbolos WHERE sup_id_traduccion='$id_traduccion' OR inf_id_traduccion='$id_traduccion'";
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result6 = mysql_query($query6); 
	
		$numrows = mysql_num_rows($result6);
		
		if ($numrows > 0) {
			while ($row6=mysql_fetch_array($result6)) {
				
				$id_simbolo=$row6['id_simbolo'];
				$simbolo=$this->datos_simbolo($id_simbolo);
				
				$folder=$simbolo['id_tipo_simbolo'].$simbolo['marco'].$simbolo['contraste'].$simbolo['sup_con_texto'].$simbolo['sup_idioma'].$simbolo['sup_mayusculas'].$simbolo['sup_font'].$simbolo['inf_con_texto'].$simbolo['inf_idioma'].$simbolo['inf_mayusculas'].$simbolo['inf_font'];
				
				$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				
				$qDelete = "DELETE FROM simbolos WHERE id_simbolo='$id_simbolo'";	
				$result = mysql_query($qDelete); 
				
					if (file_exists('../../repositorio/simbolos/fuente/'.$folder.'/'.$id_simbolo.'.'.$simbolo['ext'].'')) { 
						unlink('../../repositorio/simbolos/fuente/'.$folder.'/'.$id_simbolo.'.'.$simbolo['ext'].'');
					}
		 
			} //Cierro el While
			
		} //Cierro el IF	
		mysql_close($connection);
	}


//******************************************************************************//
	function actualizar_autores_licencia_imagenes($id_colaborador) {

		$UpdateRecords = "UPDATE imagenes SET id_licencia='2', id_autor='3'
		WHERE id_colaborador='$id_colaborador'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 
		mysql_close($connection);
	}


// BORRAR TRADUCCION
//********************************************************************************************************//	
	function borrar_traduccion($id_traduccion,$id_palabra,$id_idioma,$id_colaborador) {
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM traducciones WHERE id_palabra='$id_palabra' AND id_idioma=$id_idioma 
		AND id_colaborador='$id_colaborador' AND id_traduccion='$id_traduccion'";	
		$result = mysql_query($qDelete); 
		
		$query6 = "SELECT * FROM simbolos WHERE sup_id_traduccion='$id_traduccion' OR inf_id_traduccion='$id_traduccion'";
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result6 = mysql_query($query6); 
	
		$numrows = mysql_num_rows($result6);
		
		if ($numrows > 0) {
			while ($row6=mysql_fetch_array($result6)) {
				
				$id_simbolo=$row6['id_simbolo'];
				$simbolo=$this->datos_simbolo($id_simbolo);
				
				$folder=$simbolo['id_tipo_simbolo'].$simbolo['marco'].$simbolo['contraste'].$simbolo['sup_con_texto'].$simbolo['sup_idioma'].$simbolo['sup_mayusculas'].$simbolo['sup_font'].$simbolo['inf_con_texto'].$simbolo['inf_idioma'].$simbolo['inf_mayusculas'].$simbolo['inf_font'];
				
				$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				
				$qDelete = "DELETE FROM simbolos WHERE id_simbolo='$id_simbolo'";	
				$result = mysql_query($qDelete); 
				
					if (file_exists('../../repositorio/simbolos/fuente/'.$folder.'/'.$id_simbolo.'.'.$simbolo['ext'].'')) { 
						unlink('../../repositorio/simbolos/fuente/'.$folder.'/'.$id_simbolo.'.'.$simbolo['ext'].'');
					}
			} //Cierro el While
		} //Cierro el IF
		mysql_close($connection);
		return mysql_error();		
	}
	
// BORRAR USUARIO
//********************************************************************************************************//	
	function delete_usuario($id_colaborador) {
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM colaboradores WHERE id_colaborador='$id_colaborador'";	
		$result = mysql_query($qDelete); 
		
		$qDelete1 = "DELETE FROM colaboradores_permisos WHERE id_colaborador='$id_colaborador'";	
		$result1 = mysql_query($qDelete1); 
		
		$qDelete2 = "DELETE FROM paneles_usuarios WHERE id_usuario='$id_colaborador'";	
		$result2 = mysql_query($qDelete2); 
		
		$qDelete3 = "DELETE FROM repositorio_archivos WHERE id_usuario='$id_colaborador'";	
		$result3 = mysql_query($qDelete3); 
		
		$qDelete4 = "DELETE FROM repositorio_directorios WHERE id_usuario='$id_colaborador'";	
		$result4 = mysql_query($qDelete4); 
		
			$query6 = "SELECT * FROM seleccion WHERE id_usuario='$id_colaborador'";
	
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result6 = mysql_query($query6); 
	
			while ($row6=mysql_fetch_array($result6)) {
				$qDelete7 = "DELETE FROM seleccion_simbolos WHERE id_seleccion='".$row6['id_seleccion']."'";	
				$result7 = mysql_query($qDelete7); 
			}
		
		$qDelete5 = "DELETE FROM seleccion WHERE id_usuario='$id_colaborador'";	
		$result5 = mysql_query($qDelete5); 
		
		$UpdateRecords = "UPDATE imagenes SET id_colaborador=1
		WHERE id_colaborador='$id_colaborador'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 	
		mysql_close($connection);
		return mysql_error();		
	}
	
// BORRAR IMAGEN
//********************************************************************************************************//	
	function delete_imagen($id_imagen) {
	
		$imagen=$this->datos_imagen($id_imagen);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM imagenes WHERE id_imagen='$id_imagen'";	
		$result = mysql_query($qDelete); 
		
		$qDelete1 = "DELETE FROM palabra_imagen WHERE id_imagen='$id_imagen'";	
		$result1 = mysql_query($qDelete1);
		
		unlink('../../repositorio/originales/'.$imagen['imagen']);
		mysql_close($connection);
		return mysql_error();		
	}

// BORRAR VIDEO ACEPCION LSE	
//********************************************************************************************************//	
	function delete_video_acepcion_lse($id_imagen) {
	
		$imagen=$this->datos_imagen($id_imagen);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM imagenes WHERE id_imagen='$id_imagen'";	
		$result = mysql_query($qDelete); 
		
		$qDelete1 = "DELETE FROM palabra_imagen WHERE id_imagen='$id_imagen'";	
		$result1 = mysql_query($qDelete1);
		
		unlink('../../repositorio/LSE_acepciones/'.$imagen['imagen']);
		
		if (file_exists('../../importar/videos/acepciones/'.$imagen['id_palabra'].'.flv')) { 
			unlink('../../importar/videos/acepciones/'.$imagen['id_palabra'].'.flv');
		}
		mysql_close($connection);
		return mysql_error();		
	}
	
// BORRAR IMAGEN
//********************************************************************************************************//	
	function delete_adscripcion_palabra($id_palabra,$id_imagen) {
			
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete1 = "DELETE FROM palabra_imagen WHERE id_imagen='$id_imagen' AND id_palabra='$id_palabra'";	
		$result1 = mysql_query($qDelete1);
		
		return mysql_error();		
	}
	
// BORRAR SIMBOLO
//********************************************************************************************************//	
	function delete_simbolo($id_simbolo) {
		
		$simbolo=$this->datos_simbolo($id_simbolo);
		
		$folder=$simbolo['id_tipo_simbolo'].$simbolo['marco'].$simbolo['contraste'].$simbolo['sup_con_texto'].$simbolo['sup_idioma'].$simbolo['sup_mayusculas'].$simbolo['sup_font'].$simbolo['inf_con_texto'].$simbolo['inf_idioma'].$simbolo['inf_mayusculas'].$simbolo['inf_font'];
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM simbolos WHERE id_simbolo='$id_simbolo'";	
		$result = mysql_query($qDelete); 
		
		unlink('../../repositorio/simbolos/fuente/'.$folder.'/'.$id_simbolo.'.'.$simbolo['ext'].'');
		
		mysql_close($connection);
		return mysql_error();	
			
	}
	
// BORRAR SIMBOLO ESPECIAL
//********************************************************************************************************//	
	function delete_simbolo_especial($id_simbolo) {
		
		$simbolo=$this->datos_simbolo_especial($id_simbolo);
		
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete = "DELETE FROM simbolos_especiales WHERE id_simbolo='$id_simbolo'";	
		$result = mysql_query($qDelete); 
		
		if ($simbolo['registrado']==2) {
			
			if (file_exists('../../repositorio/specials_smbl/'.$id_simbolo.'.'.$simbolo['ext'].'')) { 
				unlink('../../repositorio/specials_smbl/'.$id_simbolo.'.'.$simbolo['ext'].''); 
			}
			if (file_exists('../../repositorio/specials_smbl/'.$id_simbolo.'_150.'.$simbolo['ext'].'')) { 
				unlink('../../repositorio/specials_smbl/'.$id_simbolo.'_150.'.$simbolo['ext'].''); 
			}
			if (file_exists('../../repositorio/specials_smbl/'.$id_simbolo.'_o.'.$simbolo['ext'].'')) { 
				unlink('../../repositorio/specials_smbl/'.$id_simbolo.'_o.'.$simbolo['ext'].''); 
			}
		
		} 
		mysql_close($connection);	
		return mysql_error();	
			
	}	

//********************************************************************************************************//	
	function actualizar_tabla_palabras_utf8() {

		$query1 = "SELECT * FROM palabras";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result1 = mysql_query($query1); 
		
		while ($row=mysql_fetch_array($result1)) {
		
			$palabra=utf8_encode($row['palabra']);
			$id_palabra=$row['id_palabra'];
		
			$UpdateRecords = "UPDATE palabras SET palabra='$palabra'
			WHERE id_palabra='$id_palabra'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 	
		
		
		}
		mysql_close($connection);
		return mysql_error();	
	}

	function actualizar_tabla_traducciones_utf8($id_idioma) {

		$query1 = "SELECT * FROM traducciones";
				
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result1 = mysql_query($query1); 
		
		while ($row=mysql_fetch_array($result1)) {
		
			$traduccion=utf8_encode($row['traduccion']);
			$explicacion=utf8_encode($row['explicacion']);
			$id_palabra=$row['id_palabra'];
			$timestamp=time();
			$fecha=date("Y-m-d H:i:s",$timestamp);
			$fecha_modificacion=date("Y-m-d H:i:s",$timestamp);
		
			$UpdateRecords = "UPDATE traducciones SET fecha_alta='$fecha', fecha_modificacion='$fecha'
			WHERE id_palabra='$id_palabra' AND id_idioma=$id_idioma";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 	
		
		
		}
		mysql_close($connection);
		return mysql_error();	
	}

	function convertir_tabla_5000_palabras_utf8() {

		$query1 = "SELECT * FROM palabras_rae_5000_utf8_compare";
				
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result1 = mysql_query($query1); 
		
		while ($row=mysql_fetch_array($result1)) {
		
			$palabra_utf8=utf8_encode($row['palabra']);
			$id_orden=$row['id_orden'];
		
			$UpdateRecords = "UPDATE palabras_rae_5000_utf8_compare SET palabra='$palabra_utf8' WHERE id_orden='$id_orden'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 	
		}
		mysql_close($connection);
		return mysql_error();	
	}
	
	function comparar_palabras_arasaac_rae() {
	
		$query1 = "SELECT * FROM palabras";
		
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result1 = mysql_query($query1); 
		
		while ($row=mysql_fetch_array($result1)) {
		
			$query2 = "SELECT * FROM palabras_rae_5000_utf8_compare WHERE palabra='".$row['palabra']."'";
					
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result2 = mysql_query($query2);
			$row2=mysql_fetch_array($result2);
			
				if (mysql_num_rows($result2) > 0) {
				
				$UpdateRecords = "UPDATE palabras_rae_5000_utf8_compare SET is_arasaac=1 WHERE id_orden='".$row2['id_orden']."'";
				$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
				$SelectedDB = mysql_select_db($this->DBNAME);
				$result = mysql_query($UpdateRecords); 
				
				}
			
			}
		
		mysql_close($connection);
	
	}
//    FUNCIONES DE LA ZONA DE USUARIOS Y HERRAMIENTAS      //
//*********************************************************//
//*********************************************************//
//*********************************************************//
//*********************************************************//
//*********************************************************//


//                   FUNCION LISTAR PANELES PARA GESTION         //
//******************************************************************************//	

	function listar_paneles_por_palabra($letra,$id_usuario) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT paneles_usuarios.*
		FROM paneles_usuarios
		WHERE (paneles_usuarios.nombre_panel LIKE '%%$sql_letra%%' OR paneles_usuarios.tags_panel LIKE '%%$sql_letra%%')
		AND  paneles_usuarios.id_usuario='$id_usuario'
		GROUP BY paneles_usuarios.id_panel
		ORDER BY paneles_usuarios.nombre_panel asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_paneles_por_palabra_limit($letra,$id_usuario,$inicial,$cantidad) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT paneles_usuarios.*
		FROM paneles_usuarios
		WHERE (paneles_usuarios.nombre_panel LIKE '%%$sql_letra%%' OR paneles_usuarios.tags_panel LIKE '%%$sql_letra%%')
		AND  paneles_usuarios.id_usuario='$id_usuario' 
		GROUP BY paneles_usuarios.id_panel
		ORDER BY paneles_usuarios.nombre_panel asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR PLANTILLAS PARA GESTION         //
//******************************************************************************//	

	function listar_plantillas_por_palabra($letra) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT paneles_templates.*
		FROM paneles_templates
		WHERE (paneles_templates.nombre_panel LIKE '%%$sql_letra%%' OR paneles_templates.tags_panel LIKE '%%$sql_letra%%')
		GROUP BY paneles_templates.id_template_panel
		ORDER BY paneles_templates.nombre_panel asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_plantillas_por_palabra_limit($letra,$inicial,$cantidad) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT paneles_templates.*
		FROM paneles_templates
		WHERE (paneles_templates.nombre_panel LIKE '%%$sql_letra%%' OR paneles_templates.tags_panel LIKE '%%$sql_letra%%')
		GROUP BY paneles_templates.id_template_panel
		ORDER BY paneles_templates.nombre_panel asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}

//                   FUNCION LISTAR SELECCIONES PARA GESTION         //
//******************************************************************************//	

	function listar_selecciones_por_palabra($letra,$id_usuario) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT seleccion.*
		FROM seleccion
		WHERE (seleccion.seleccion LIKE '%%$sql_letra%%' OR seleccion.tags LIKE '%%$sql_letra%%')
		AND seleccion.id_usuario='$id_usuario'
		GROUP BY seleccion.id_seleccion
		ORDER BY seleccion.seleccion asc";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);	
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}
	
	function listar_selecciones_por_palabra_limit($letra,$id_usuario,$inicial,$cantidad) {
			
		if ($letra=='') { $sql_letra=''; } else { $sql_letra=$letra; }
		
		$query = "SELECT seleccion.*
		FROM seleccion
		WHERE (seleccion.seleccion LIKE '%%$sql_letra%%' OR seleccion.tags LIKE '%%$sql_letra%%')
		AND seleccion.id_usuario='$id_usuario'
		GROUP BY seleccion.id_seleccion
		ORDER BY seleccion.seleccion asc
		LIMIT $inicial,$cantidad";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $result;
		}
	}


//                   FUNCION LISTAR PLANTILLAS PARA GESTION         //
//******************************************************************************//	

	function datos_plantilla($id_plantilla) {
		
		$query = "SELECT paneles_templates.*
		FROM paneles_templates
		WHERE paneles_templates.id_template_panel='$id_plantilla'";

        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($query);
		$row=mysql_fetch_array($result); 
		
		$numrows = mysql_num_rows($result);
		mysql_close($connection);
		// COMPROBAMOS QUE HAYA RESULTADOS
		// SI EL NUMERO DE RESULTADOS ES 0 SIGNIFICA QUE NO HAY REGISTROS CON ESOS DATOS
		if ($numrows == 0) {
			return $result;
		}
		else {
			return $row;
		}
	}
	
		
function datos_panel($id_panel,$id_usuario) {

		$query1 = "SELECT * FROM paneles_usuarios WHERE id_panel='$id_panel' AND id_usuario='$id_usuario'";
				
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result1 = mysql_query($query1); 
		$row=mysql_fetch_array($result1);
		mysql_close($connection);
		return $row;
		
}


function guardar_nuevo_panel($id_usuario,$n_items,$principal,$panel_width,$simbolos_width,$principal_width,$borde_panel,$grosor_borde_panel,$color_borde_panel,$borde_simbolos,$grosor_borde_simbolos,$color_borde_simbolos,$borde_simbolo_principal,$grosor_borde_simbolo_principal,$color_borde_simbolo_principal,$contenido_panel,$nombre_panel,$tags_panel,$txt_inferior,$txt_superior,$panel_color_fondo,$espacio_entre_simbolos) {
		
		$timestamp=time();
		$fecha=date("Y-m-d H:i:s",$timestamp);
	
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
  
		$ssql = "INSERT INTO paneles_usuarios (id_usuario,n_items,simbolo_principal,panel_width,simbolos_width,principal_width,borde_panel,grosor_borde_panel,color_borde_panel,borde_simbolos,grosor_borde_simbolos,color_borde_simbolos,borde_simbolo_principal,grosor_borde_simbolo_principal,color_borde_simbolo_principal,contenido_panel,nombre_panel,tags_panel,fecha_creacion,fecha_modificacion,txt_inferior,txt_superior,panel_color_fondo,espacio_entre_simbolos) VALUES ('$id_usuario','$n_items','$principal','$panel_width','$simbolos_width','$principal_width','$borde_panel','$grosor_borde_panel','$color_borde_panel','$borde_simbolos','$grosor_borde_simbolos','$color_borde_simbolos','$borde_simbolo_principal','$grosor_borde_simbolo_principal','$color_borde_simbolo_principal','$contenido_panel','$nombre_panel','$tags_panel','$fecha','$fecha','$txt_inferior','$txt_superior','$panel_color_fondo','$espacio_entre_simbolos')";
			
			//lo inserto en la base de datos
			if (mysql_query($ssql,$connection)){
				$ultimo_id = mysql_insert_id($connection); 
				mysql_close($connection);
				//recibo el último id
				return $ultimo_id;
			} else {
				mysql_close($connection);
				return false;
			} 		
	}

function actualizar_panel($id_panel,$id_usuario,$n_items,$principal,$panel_width,$simbolos_width,$principal_width,$borde_panel,$grosor_borde_panel,$color_borde_panel,$borde_simbolos,$grosor_borde_simbolos,$color_borde_simbolos,$borde_simbolo_principal,$grosor_borde_simbolo_principal,$color_borde_simbolo_principal,$contenido_panel,$nombre_panel,$tags_panel,$txt_inferior,$txt_superior,$panel_color_fondo,$espacio_entre_simbolos) {
		
			$timestamp=time();
			$fecha=date("Y-m-d H:i:s",$timestamp);
		
			$UpdateRecords = "UPDATE paneles_usuarios SET n_items='$n_items',simbolo_principal='$principal',panel_width='$panel_width',simbolos_width='$simbolos_width',principal_width='$principal_width',borde_panel='$borde_panel',grosor_borde_panel='$grosor_borde_panel',color_borde_panel='$color_borde_panel',borde_simbolos='$borde_simbolos',grosor_borde_simbolos='$grosor_borde_simbolos',color_borde_simbolos='$color_borde_simbolos',borde_simbolo_principal='$borde_simbolo_principal',grosor_borde_simbolo_principal='$grosor_borde_simbolo_principal',color_borde_simbolo_principal='$color_borde_simbolo_principal',contenido_panel='$contenido_panel',nombre_panel='$nombre_panel',tags_panel='$tags_panel',fecha_modificacion='$fecha',txt_inferior='$txt_inferior',txt_superior='$txt_superior',panel_color_fondo='$panel_color_fondo',espacio_entre_simbolos='$espacio_entre_simbolos'
			WHERE id_panel='$id_panel' AND id_usuario='$id_usuario'";
			$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
			$SelectedDB = mysql_select_db($this->DBNAME);
			$result = mysql_query($UpdateRecords); 	
			mysql_close($connection);
			
  
		
	}

// BORRAR PANELES USUARIO
//********************************************************************************************************//	
	function borrar_panel($id_panel,$id_usuario) {
			
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete1 = "DELETE FROM paneles_usuarios WHERE id_panel='$id_panel' AND id_usuario='$id_usuario'";	
		$result1 = mysql_query($qDelete1);
		mysql_close($connection);
		return mysql_error();		
	}

// BORRAR SELECCION USUARIO
//********************************************************************************************************//	
	function borrar_seleccion($id_seleccion,$id_usuario) {
			
		$connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		
		$qDelete1 = "DELETE FROM seleccion WHERE id_seleccion='$id_seleccion' AND id_usuario='$id_usuario'";	
		$result1 = mysql_query($qDelete1);
		
		$qDelete2 = "DELETE FROM seleccion_simbolos WHERE id_seleccion='$id_seleccion'";	
		$result1 = mysql_query($qDelete2);
		mysql_close($connection);
		return mysql_error();		
	}	

// ACTUALIZAR PALABRA ASOCIADA A ARCHIVO DEL REPOSITORIO DE USUARIOS
//******************************************************************************//
	function actualizar_palabra_asociada_archivo_repositorio($file_id,$id_palabra) {

		$UpdateRecords = "UPDATE repositorio_archivos SET id_palabra='$id_palabra'
		WHERE file_id='$file_id'";
        $connection = mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD);
		$SelectedDB = mysql_select_db($this->DBNAME);
		$result = mysql_query($UpdateRecords); 	
		mysql_close($connection);
	}

} // Cierro la clase
?>