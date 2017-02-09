<?php
/*********************************************************************************************
** 	Autor		:	Andrés Darío Gutiérrez Poveda.			          																**
** 	Fecha  	:	Abril 14 de 2004.	         				   	          															**
** 	Versión	:	1.0.1.                      			   	          															**
**	Empresa	:	Atila Servicios S.A. 			                      															**
**																																													**
**********************************************************************************************
**	Proposito:																																							**
**																																													**
** 		Esta clase se ocupa de hacer oparaciones con fechas.																	**
**																																													**
**********************************************************************************************
**	Nota:																																										**
**																																													**
**		En esta clase se encuentra una función inspirada en una realizada por André Cupini.		**
**		andre@neobiz.com.br.																																	**
**																																													**
**********************************************************************************************
**	Version 1.0.2  - 25 de Mayo de 2004 																										**
** 	Cambios para la versión 1.0.2																														**
**																																													**
**		- Inserción de la función machine_date.																								**
**		- Inserción de la función human_date.																									**
**		- Inserción de la función local_date.																									**
**		- Inserción de la función foreign_date.																								**
**		- Inserción de la función convert_timestamp.																					**
*********************************************************************************************/

class date{

	/*******************************************************************************************
 	** 	VARIABLES PRIVADAS																																		**
  *******************************************************************************************/
  
    
  /*******************************************************************************************
 	** 	MÉTODOS																																								**
  *******************************************************************************************/

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	operations ($date, $operation, $where = FALSE, $quant, 									**
 	**							$return_format = FALSE)																			**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Sumarle o restarle días, meses o años a una fecha dada. Obtener la fecha**
  **	resultado.																															**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha sobre la cual se va a operar.															**
 	**	- operacion: Operaciones posibles:																			**
 	**		-	'-': Restar.																												**
 	**		- '+': Sumar.																													**
 	**	- aoperar: Donde se quiere sumar Dia, Mes o Año.												**
 	**	-	cantidad: Cantidad que se va a sumar o restar.												**
 	*****************************************************************************/
	function operar($date, $operacion, $aoperar, $cantidad){
		if(!($operacion == "-" || $operacion == "+")) 
			$feedback .= "Date Class Error: Operaci&#243n no v&#225lida!!";
		else {
			// Separa dia, mes y año
			list($a_o, $mes, $dia) = explode("-",$date,3);
	
			// Determina la operación (Suma o resta)
			if($operacion == "-") 
				$op = "-";
			else
				$op = '';
	
			// Determina en  donde será efectuada la operación (dia, mes, año)
			if($aoperar == "dia") $op_dia	 = $op."$cantidad";
			if($aoperar == "mes") $op_mes = $op."$cantidad";
			if($aoperar == "a_o") $op_a_o	 = $op."$cantidad";
				
			// Generamos la nueva fecha
			$date = mktime(0, 0, 0, $mes + $op_mes, $dia + $op_dia, $a_o + $op_a_o);
			
			return $date;
		}
	}

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	fechaaletras ($fecha)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir la fecha de formato (Y-m-d) a letras en formato (d de m de Y).**																															**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a pasar a letras.																				**
 	*****************************************************************************/
	function fechaaletras($fecha){
		list($anio,$mes,$dia) = explode("-",$fecha,3);
		$fechaletras = $dia." de ".$this->mesaletras($mes)." de ".$anio;
		return $fechaletras;
	}

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	mesaletras ($m)																													**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir de número a letras el mes.																		**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- m: Mes a pasar a letras.																							**
 	*****************************************************************************/
	function mesaletras($m){
		if ($m == 1)
			$ms = 'Enero';
		else if ($m == 2)
			$ms = 'Febrero';
		else if ($m == 3)
			$ms = 'Marzo';
		else if ($m == 4)
			$ms = 'Abril';
		else if ($m == 5)
			$ms = 'Mayo';
		else if ($m == 6)
			$ms = 'Junio';
		else if ($m == 7)
			$ms = 'Julio';
		else if ($m == 8)
			$ms = 'Agosto';
		else if ($m == 9)
			$ms = 'Septiembre';
		else if ($m == 10)
			$ms = 'Octubre';
		else if ($m == 11)
			$ms = 'Noviembre';
		else if ($m == 12)
			$ms = 'Diciembre';
	
		return $ms;
	}

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	fechaactual ()																													**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver la fecha actual en el formato Y-m-d.														**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	*****************************************************************************/
	function fechaactual(){
		$today = getdate(); 
		$month = $today['mon'];
		$mday = $today['mday']; 
		$year = $today['year'];
		$hoy = $year."-".$month."-".$mday;
		return $hoy;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	dia ($fecha)																														**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el día actual en número.																				**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a la cual se quiere saber el día.												**
 	*****************************************************************************/
	function dia($fecha){
		list($anio,$mes,$dia) = explode('-',$fecha,3);
		return $dia;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	mes ($fecha)																														**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el mes actual en número.																				**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a la cual se quiere saber el mes.												**
 	*****************************************************************************/
	function mes($fecha){
		list($anio,$mes,$dia) = explode('-',$fecha,3);
		return $mes;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	anio ($fecha)																														**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el anio actual en número.																				**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a la cual se quiere saber el año.												**
 	*****************************************************************************/
	function anio($fecha){
		list($anio,$mes,$dia) = explode('-',$fecha,3);
		return $anio;
	}

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	mesanio ($fecha)																												**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el mes y año en el formato m Y.																**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a pasar a letras.																				**
 	*****************************************************************************/
	function mesanio($fecha){
		list($anio,$mes,$dia) = explode("-",$fecha,3);
		$mesanio = $this->mesaletras($mes)." ".$anio;
		return $mesanio;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	diames ($fecha)																													**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el día y mes en el formato m d.																**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha a pasar a letras.																				**
 	*****************************************************************************/
	function diames($fecha){
		list($anio,$mes,$dia) = explode("-",$fecha,3);
		$diames = $this->mesaletras($mes)." ".$dia;
		return $diames;
	}

	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** diadelasemana ($fecha)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver el dia de la semana correspondiente a la fecha.								**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha: Fecha de la cual se va a calcular el día.											**
 	*****************************************************************************/
	function diadelasemana($fecha){
		list($y,$m,$d) = explode("-",$fecha,3);
		$timestamp = mktime(0,0,0,$m,$d,$y); 
	 	$date = getdate ($timestamp); 
	 	$dayofweek = $date['wday'];
	
	 	return $dayofweek;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	diaaletras ($m)																													**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir de número a letras el día.																		**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- d: Día a pasar a letras.																							**
 	*****************************************************************************/
	function diaaletras($d){
		if ($d == 0)
			$ms = 'Domingo';
		else if ($d == 1)
			$ms = 'Lunes';
		else if ($d == 2)
			$ms = 'Martes';
		else if ($d == 3)
			$ms = 'Miercoles';
		else if ($d == 4)
			$ms = 'Jueves';
		else if ($d == 5)
			$ms = 'Viernes';
		else if ($d == 6)
			$ms = 'S&#225bado';
		
		return $ms;
	}
	
	function diaaletras_traducido($d,$lang){
		if ($d == 0)
			$ms = $lang['domingo'];
		else if ($d == 1)
			$ms = $lang['lunes'];
		else if ($d == 2)
			$ms = $lang['martes'];
		else if ($d == 3)
			$ms = $lang['miercoles'];
		else if ($d == 4)
			$ms = $lang['jueves'];
		else if ($d == 5)
			$ms = $lang['viernes'];
		else if ($d == 6)
			$ms = $lang['sabado'];
		
		return $ms;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	machine_date ($date)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir la fecha de formato DD-MM-YYYY a YYYY-MM-DD.									**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha en formato MM-DD-YYYY a cambiar.													**
 	*****************************************************************************/
	function machine_date($date){
		list($day, $month, $year) = split("-", $date);
		return $year . "-" . $month . "-" . $day;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	human_date ($date)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir la fecha de formato YYYY-MM-DD a DD-MM-YYYY.									**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha en formato YYYY-MM-DD a cambiar.													**
 	*****************************************************************************/
	function human_date($date){
	 	list($year, $month, $day) = split("-", $date);
		return $day . "-" . $month . "-" . $year;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	local_date ($date)																											**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir la fecha de formato MM-DD-YYYY a DD-MM-YYYY.									**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha en formato MM-DD-YYYY a cambiar.													**
 	*****************************************************************************/
	function local_date($date){
	 	list($month, $day, $year) = split("-", $date);
		return $day . "-" . $month . "-" . $year;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	foreign_date ($date)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir la fecha de formato DD-MM-YYYY a MM-DD-YYYY.									**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha en formato DD-MM-YYYY a cambiar.													**
 	*****************************************************************************/
	function foreign_date($date){
	 	list($month, $day, $year) = split("-", $date);
		return $month . "-" . $day . "-" . $year;
	}
	
	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	convert_timestamp ($timestamp)																					**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Convertir el timestamp a formato 'YYYY-MM-DD hh:mm:ss A'.								**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- timestamp: Timestamp a cambiar.																				**
 	*****************************************************************************/
 	function convert_timestamp($timestamp){
 		$year = substr($timestamp,0,4);
 		$month = substr($timestamp,4,2);
 		$day = substr($timestamp,6,2);
 		$hour = substr($timestamp,8,2);
 		$minute = substr($timestamp,10,2);
 		$second = substr($timestamp,12,2);
 		
 		$date = mktime($hour, $minute, $second, $month, $day, $year);
 		$date = date("Y-m-d h:i:s A", "$date");
 		
 		return $date;
 	}
 	
 	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	compare ($date,$date)																										**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Comparar las fechas de formato YYYY-MM-DD.															**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- date: Fecha en formato YYYY-MM-DD a comparar.													**
 	*****************************************************************************/
 	function compare($date,$date2){
 		list($y,$m,$d) = explode("-",$date,3);
 		list($y2,$m2,$d2) = explode("-",$date2,3);
 		 		
 		if(strcmp($y,$y2) == 0){
 			if(strcmp($m,$m2) == 0){
 				if(strcmp($d,$d2) == 0){
		 			$comp = 0;
		 		}else
 					$comp = strcmp($d,$d2);
 			}else
 				$comp = strcmp($m,$m2);
 		}else
 			$comp = strcmp($y,$y2);
 		return $comp;
 	}
 	
 	/*****************************************************************************
 	** 	NOMBRE:																																	**
  **																																					**
 	** 	diferencia ($fecha,$fecha2)																							**
  **																																					**
  ******************************************************************************
 	** 	OBJETIVO:																															 	**
  **																																					**
  ** 	Devolver la diferencia de las dos fechas.																**
 	**																																					**
 	******************************************************************************
 	**	ARGUMENTOS:																															**
 	**																																					**
 	**	- fecha y fecha2: Fechas que se van a restar.														**
 	*****************************************************************************/
	function diferencia($fecha,$fecha2){
		
		list($year,$month,$day) = explode('-',$fecha,3);
		list($year2,$month2,$day2) = explode('-',$fecha2,3);
		
		$yearaux = $year - $year2;
		$monthaux = $month - $month2;
		$dayaux = $day2 - $day;
		
		$date = mktime(0, 0, 0, $monthaux, $dayaux, $yearaux);
				
		$diferencia = date("Y-m-d", "$date");
		
		list($year,$month,$day) = explode("-",$diferencia,3);
		$year -= 2000;
		if($year < 0){
			$year = 0;
			$month = 0;
		}
		
		$diferenciaA['years'] = $year;
		$diferenciaA['months'] = $month;
		$diferenciaA['days'] = $day;
		
		return $diferenciaA;
	}
}
?>