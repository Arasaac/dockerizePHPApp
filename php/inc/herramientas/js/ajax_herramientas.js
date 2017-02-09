/* FUNCION QUE PONE EL CURSOR EN UN CAM;PO DETERMINADO   */
/* *************************************************** */
function sf(ID){
document.getElementById(ID).focus();
}

function goto(code, name, lastname ){

	location.replace("seleccion.php?s="+code+"");
} 

/*      FUNCION QUE MUESTRA LA VENTA A MODAL          */
/* *************************************************** */

function ventana_confirmacion(txt,ancho,alto,url,variables,div,url1,variables1,div1) {
		Dialog.confirm(txt, 
			{windowParameters: {className: 'alphacube', width: ancho, height: alto}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { procesar(''+url+'',''+variables+'',''+div+''); 
				if (url1 !='' && variables1!='' && div1!='') {
					cargar_div3(''+url1+'',''+variables1+'',''+div1+''); 
				} 
			return true;  }
		});
}


/* FUNCION CONFIRMACION REALOAD                      */
/* *************************************************** */

function borrar_carpeta(txt,ancho,alto,url,variables,div,id_carpeta){
	
			Dialog.confirm(txt, 
			{windowParameters: {className: 'alphacube', width: ancho, height: alto}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { 
				var pars   = variables;
				var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
							
			Dialog.closeInfo();	
			setTimeout(location.replace("gestionar_repositorio.php?idd="+id_carpeta+""),500);
			return true;  
			}
		});
				
}


/* FUNCION CONFIRMACION REALOAD                      */
/* *************************************************** */

function borrar_archivos(txt,ancho,alto,url,param,div,id_carpeta){
	
			Dialog.confirm(txt, 
			{windowParameters: {className: 'alphacube', width: ancho, height: alto}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { 
			var goto="gestionar_repositorio.php?idd="+id_carpeta+"";
			cargar_div4(url,param,div,goto);
			return true;  
			}
		});
				
}

function cargar_div4(url,param,div,goto){

	var myAjax = new Ajax.Request( url, {method: 'post', parameters: param, onLoading: showLoad, onComplete: location.replace(goto)} );
}

function cargar_div3(url,param,div){

	var myAjax = new Ajax.Request( url, {method: 'post', parameters: param, onLoading: showLoad, onComplete: window.location.reload()} );
}

function guardar_nueva_seleccion(url,param,div){

	 procesar(url,param,div);
	 var thelist2=document.getElementById("thelist2");
	 thelist2.innerHTML = '';
	 borrar_mi_seleccion();
	 document.seleccion_simbolos.mi_seleccion.value='';
	 document.seleccion_simbolos.id_usuario.value='';
	 document.seleccion_simbolos.nombre_seleccion.value='';
	 document.seleccion_simbolos.tags.value='';
	 
	
}

function guardar_repositorio(){

	var url="gestionar_repositorio/guardar_repositorio.php";
	var seleccion=document.getElementById("mi_seleccion");
	var id_directorio=document.getElementById("id_directorio");
	var id_usuario=document.getElementById("id_usuario");
	var parent=document.getElementById("parent");
	var param = ''+seleccion.value+'&id_directorio='+id_directorio.value+'&id_usuario='+id_usuario.value+'&parent='+parent.value+'';

	var myAjax = new Ajax.Request( url, {method: 'post', parameters: param, onLoading: showLoad, onComplete: window.location.reload()} );
}

function openInfoDialog(text) {
		Dialog.info(text,
				        {windowParameters: {className: "alert_lite",width:250, height:100}, showProgress: true});
		timeout=3;
		setTimeout("infoTimeout()", 1000)
}

function infoTimeout() {
	  timeout--;
	  if (timeout >0) {
	    Dialog.setInfoMessage("<br>" + timeout + "sg ...")
  		setTimeout("infoTimeout()", 1000)
    }
	  else
	    Dialog.closeInfo()
}


/*  VENTANAS MODALES DE GREYBOX */
/* *************************************************** */
      var GB_ANIMATION = true;
      var GB_IMG_DIR = "js/greybox/";
      var GB_overlay_click_close = true;

      function changeHeadline(url){
		
		procesar(url,'i=','principal');
		setTimeout("parent.GB_hide();",2000);
      }

/* FUNCION SELECCIONAR IMAGEN CREADOR                       */
/* *************************************************** */

function seleccionar_palabra_creador(id_palabra) {
	
	showLoad ();
	var content = document.getElementById("simbolo");
	content.innerHTML = '';
	
	var content = document.getElementById("imagenes_disponibles");
	content.innerHTML = '';
	
	procesar('palabra_seleccionada.php','id='+id_palabra+'','selected_word'); 
	procesar('mostrar_imagenes.php','id='+id_palabra+'','imagenes_disponibles'); 
	procesar('mostrar_color_borde.php','id='+id_palabra+'','color_borde'); 
	HideLoad ();
	Dialog.closeInfo();

}

/* FUNCION SELECCIONAR PICTOGRAMA CREADOR PANELES                      */
/* *************************************************** */

function seleccionar_pictograma_paneles(panel,fila,columna,img) {
	
	
	var campo="img_"+panel+"_"+fila+"_"+columna+"";
	var imagen="imagen_"+panel+"_"+fila+"_"+columna+"";
	document.getElementById(""+campo+"").value=img;
	document.getElementById(""+imagen+"").src="../classes/img/thumbnail.php?i="+img+"";
	Dialog.closeInfo();
	
}

/* FUNCION SELECCIONAR PICTOGRAMA CREADOR HORARIOS                      */
/* *************************************************** */

function seleccionar_pictograma_horarios(panel,fila,columna,img,txt) {
	
	
	var campo="img_"+panel+"_"+fila+"_"+columna+"";
	var campo2="txt_"+panel+"_"+fila+"_"+columna+"";
	var imagen="imagen_"+panel+"_"+fila+"_"+columna+"";
	document.getElementById(""+campo+"").value=img;
	document.getElementById(""+campo2+"").value=txt;
	document.getElementById(""+imagen+"").src="../classes/img/thumbnail.php?i="+img+"";
	Dialog.closeInfo();
	
}

function configurar_celda(panel,fila,columna,dbc,dabc,dptc,dftc,dsftc,dmtc,dtist,dtict,dtbc) {
	
	var bc="bc_"+panel+"_"+fila+"_"+columna+"";
	var tbc="tbc_"+panel+"_"+fila+"_"+columna+"";
	var abc="abc_"+panel+"_"+fila+"_"+columna+"";
	//var cbc="cbc_"+panel+"_"+fila+"_"+columna+"";
	var ptc="ptc_"+panel+"_"+fila+"_"+columna+"";
	var ftc="ftc_"+panel+"_"+fila+"_"+columna+"";
	var sftc="sftc_"+panel+"_"+fila+"_"+columna+"";
	var mtc="mtc_"+panel+"_"+fila+"_"+columna+"";
	//var ctc="ctc_"+panel+"_"+fila+"_"+columna+"";
	var tict="tict_"+panel+"_"+fila+"_"+columna+"";
	var tist="tist_"+panel+"_"+fila+"_"+columna+"";
	
	document.getElementById(""+bc+"").value=dbc;
	document.getElementById(""+tbc+"").value=dtbc;
	document.getElementById(""+abc+"").value=dabc;
	//document.getElementById(""+cbc+"").value=dcbc;
	document.getElementById(""+ptc+"").value=dptc;
	document.getElementById(""+ftc+"").value=dftc;
	document.getElementById(""+sftc+"").value=dsftc;
	document.getElementById(""+mtc+"").value=dmtc;
	//document.getElementById(""+ctc+"").value=dctc;
	document.getElementById(""+tict+"").value=dtict;
	document.getElementById(""+tist+"").value=dtist;
	
	Dialog.closeInfo();
	
}

function copiar_contenido_celda(n_filas,n_columnas,p,f,c) {
	
	var img_copiar=document.getElementById("img_"+p+"_"+f+"_"+c+"").value;
	var txt_copiar=document.getElementById("txt_"+p+"_"+f+"_"+c+"").value;
	
	var n_paneles=1;
	
	for (p=1;p<=n_paneles;p++) // FILAS
	{
		for (f=1;f<=n_filas;f++) // FILAS
		{
			for (c=1;c<=n_columnas;c++) // COLUMNAS
			{
				document.getElementById("portapapeles_img_"+p+"_"+f+"_"+c+"").value=img_copiar;
				document.getElementById("portapapeles_txt_"+p+"_"+f+"_"+c+"").value=txt_copiar;
				
			}
			
		}
	}
}

function pegar_contenido_celda(p,f,c) {
	var imagen="imagen_"+p+"_"+f+"_"+c+"";
	var img=document.getElementById("portapapeles_img_"+p+"_"+f+"_"+c+"").value;
	document.getElementById("txt_"+p+"_"+f+"_"+c+"").value=document.getElementById("portapapeles_txt_"+p+"_"+f+"_"+c+"").value;
	document.getElementById("img_"+p+"_"+f+"_"+c+"").value=document.getElementById("portapapeles_img_"+p+"_"+f+"_"+c+"").value;
	document.getElementById(""+imagen+"").src="../classes/img/thumbnail.php?i="+img+"";
}

function configurar_todas_celdas(n_paneles,n_filas,n_columnas,dbc,dabc,dptc,dftc,dsftc,dmtc,dtist,dtict,dtbc,dcbc,dctc) {
	
	var f=1;
	var c=1;
	var p=1;
	
	for (p=1;p<=n_paneles;p++) // FILAS
	{
		for (f=1;f<=n_filas;f++) // FILAS
		{
			for (c=1;c<=n_columnas;c++) // COLUMNAS
			{
				
				if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
            	{	
					document.getElementById("bc_"+p+"_"+f+"_"+c+"").value=dbc;
					document.getElementById("tbc_"+p+"_"+f+"_"+c+"").value=dtbc;
					document.getElementById("abc_"+p+"_"+f+"_"+c+"").value=dabc;
					document.getElementById("cbc_"+p+"_"+f+"_"+c+"").value=dcbc;
					document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
					document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dftc;
					document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
					document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
					document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
					document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
					document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
				}
				
			}
		}
	}

}

function configurar_todas_celdas_horario(n_paneles,n_filas,n_columnas,dptc,dftc,dsftc,dmtc,dtist,dtict,dctc,color_fondo,aplicar_configuracion_a,dttc) {
	
	var f=1;
	var c=1;
	var p=1;
	
	if (aplicar_configuracion_a==3) { 
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=2;f<=n_filas+1;f++) // FILAS
			{
				for (c=2;c<=n_columnas+1;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	
	} else if (aplicar_configuracion_a==1) { 
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=1;f<=1;f++) // FILAS
			{
				for (c=2;c<=n_columnas+1;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	} else if (aplicar_configuracion_a==2) { 
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=2;f<=n_filas+1;f++) // FILAS
			{
				for (c=1;c<=1;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
		
	} else if (aplicar_configuracion_a==4) { //TODAS LAS CELDAS
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=1;f<=n_filas+1;f++) // FILAS
			{
				for (c=1;c<=n_columnas+1;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	}

}

function configurar_todas_celdas_tableros(n_paneles,n_filas,n_columnas,dptc,dftc,dsftc,dmtc,dtist,dtict,dctc,color_fondo,aplicar_configuracion_a,dttc) {
	
	var f=1;
	var c=1;
	var p=1;
	
	if (aplicar_configuracion_a==4) { //TODAS LAS CELDAS
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=1;f<=n_filas;f++) // FILAS
			{
				for (c=1;c<=n_columnas;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	}

}

function configurar_todas_celdas_calendario(n_paneles,n_filas,n_columnas,dptc,dftc,dsftc,dmtc,dtist,dtict,dctc,color_fondo,aplicar_configuracion_a,dttc) {
	
	var f=1;
	var c=1;
	var p=1;
	
	if (aplicar_configuracion_a==3) { 
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=2;f<=n_filas;f++) // FILAS
			{
				for (c=1;c<=n_columnas;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	
	} else if (aplicar_configuracion_a==1) { 
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=1;f<=1;f++) // FILAS
			{
				for (c=1;c<=n_columnas;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
			
	} else if (aplicar_configuracion_a==4) { //TODAS LAS CELDAS
	
		for (p=1;p<=n_paneles;p++) // PANELES
		{
			for (f=1;f<=n_filas;f++) // FILAS
			{
				for (c=1;c<=n_columnas;c++) // COLUMNAS
				{
					if (document.getElementById("bc_"+p+"_"+f+"_"+c+""))
					 {	
						document.getElementById("ptc_"+p+"_"+f+"_"+c+"").value=dptc;
						document.getElementById("ftc_"+p+"_"+f+"_"+c+"").value=dftc;
						document.getElementById("sftc_"+p+"_"+f+"_"+c+"").value=dsftc;
						document.getElementById("mtc_"+p+"_"+f+"_"+c+"").value=dmtc;
						document.getElementById("ttc_"+p+"_"+f+"_"+c+"").value=dttc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").value=dctc;
						document.getElementById("ctc_"+p+"_"+f+"_"+c+"").style.backgroundColor=dctc;
						document.getElementById("tict_"+p+"_"+f+"_"+c+"").value=dtict;
						document.getElementById("tist_"+p+"_"+f+"_"+c+"").value=dtist;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").value=color_fondo;
						document.getElementById("cfc_"+p+"_"+f+"_"+c+"").style.backgroundColor=color_fondo;
					 }
				}
			}
		}
	}

}

function mostrar_capa_calendario(n) {
	
	if (n==1) {
		$('4').style.display = "none";
		$('3').style.display = "none";
		$('1').style.display = "block";
	} else if (n==3) {
		$('3').style.display = "block";
		$('1').style.display = "none";
		$('4').style.display = "none";
	} else if (n==4) {
		$('3').style.display = "none";
		$('1').style.display = "none";
		$('4').style.display = "block";
	}

}

function mostrar_capa_horario(n) {
	
	if (n==1) {
		$('4').style.display = "none";
		$('2').style.display = "none";
		$('3').style.display = "none";
		$('1').style.display = "block";
	} else if (n==2) {
		$('2').style.display = "block";
		$('3').style.display = "none";
		$('1').style.display = "none";
		$('4').style.display = "none";
	} else if (n==3) {
		$('2').style.display = "none";
		$('3').style.display = "block";
		$('1').style.display = "none";
		$('4').style.display = "none";
	} else if (n==4) {
		$('2').style.display = "none";
		$('3').style.display = "none";
		$('1').style.display = "none";
		$('4').style.display = "block";
	}

}

/* FUNCION ELIMINAR PICTOGRAMA CREADOR PANELES                      */
/* *************************************************** */

function eliminar_pictograma_paneles(panel,fila,columna) {
	
	
	var campo="img_"+panel+"_"+fila+"_"+columna+"";
	var imagen="imagen_"+panel+"_"+fila+"_"+columna+"";
	document.getElementById(""+campo+"").value='';
	document.getElementById(""+imagen+"").src="../../../images/empty.jpg";
	document.getElementById("txt_"+panel+"_"+fila+"_"+columna+"").value="";
	
}


/* FUNCION LIMPIAR LIENZO                       */
/* *************************************************** */

function limpiar_lienzo_creador_simbolos() {
	
	showLoad ();
	var content = document.getElementById("simbolo");
	content.innerHTML = '';
	HideLoad ();

	
}



/* FUNCION DESCONECTAR/LOGOUT                       */
/* *************************************************** */

function desconectar(page,param,div){

		Dialog.confirm("¿Está seguro que desea desconectarse?<br>Su cesto será vaciado", 
			{windowParameters: {className: 'alphacube', width: 300, height: 100}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { 
				var url    = 'inc/logout.php';
				var rand   = Math.random(9999);
				var pars   = 'id=' + rand;
				var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
				clearCart_sin_confirmacion();
							
			Dialog.closeInfo();	
			setTimeout(window.location.reload(),1000);
			return true;  
			}
		});
		
}


function procesar(page,param,div){

		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else
		
		var content = document.getElementById(""+div+"");
		
		XhrObj.open("POST", page);
		//showLoad ();
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				//HideLoad ();
				content.innerHTML = XhrObj.responseText ;
				
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param)
}


function cargar_div2(page,param,div){

		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else


		var content = document.getElementById(""+div+"");

		
		XhrObj.open("POST", page);

		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200);
				content.innerHTML = XhrObj.responseText ;
				
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param)
}


/* FUNCION AJAX BÁSICA DE CARGA                        */
/* *************************************************** */
function cargar_div(page,param,div){

		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		var content = document.getElementById(""+div+"");

		
		XhrObj.open("POST", page);
		showLoad ();
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				HideLoad();
				content.innerHTML = XhrObj.responseText ;			
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param)
}

function data(param, page, id, id2, contenido2)
	{
		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		//définition de l'endroit d'affichage:
		var content = document.getElementById(""+id+"");
		var content2 = document.getElementById(""+id2+"");
		
		XhrObj.open("POST", page);

		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
				content2.innerHTML = contenido2;
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param);
}//fin fonction SendData

function enviar(letra) {
		document.location.replace("<?php $PHP_SELF ?>?pg=&letra="+letra+"&ct=<?php echo $_GET['ct']; ?>");
		}

function ct(ct) {
		document.location.replace("<?php $PHP_SELF ?>?pg=&letra=<?php echo $_GET['letra']; ?>&ct="+ct+"");
		}
		

/* FUNCION QUE GESTIONA EL CREADOR DE SIMBOLOS          */
/* *************************************************** */

function previsualizar(){ 

var orden;
var idioma;

//var i; 
//    for (i=0;i<document.form1.orden.length;i++){ 
//       if (document.form1.orden[i].checked) 
//          break; 
//    } 
//var orden = document.form1.orden[i].value;

cargar_div('../classes/text_image/formimage.php','pixels_final='+document.form1.pixels_final.value+'&fuente_castellano='+document.form1.fuente_castellano.value+'&color_contraste='+document.form1.color_alto_contraste.value+'&accion='+document.form1.accion.value+'&id='+document.form1.id_palabra.value+'&marco='+document.form1.marco.value+'&pixels_lienzo='+document.form1.pixels_lienzo.value+'&id_palabra='+document.form1.id_palabra.value+'&txt_cas='+document.form1.palabra.value+'&sz_f_s='+document.form1.size_font_sup.value+'&sz_f_i='+document.form1.size_font_inf.value+'&inf_may='+
document.form1.inf_may.value+'&sup_may='+document.form1.sup_may.value+'&id_traduccion='+document.form1.id_traduccion.value+'&color_sup='+document.form1.color_sup.value+"&color_inf="+document.form1.color_inf.value+"&archivo="+document.img_subida.imagen_subida.value+"&pixels_borde="+document.form1.grosor.value+"&color_borde="+document.form1.color_borde.value+"&sup_idioma="+document.form1.sup_idioma.value+"&inf_idioma="+document.form1.inf_idioma.value,'simbolo');
}

function previsualizar_frase(){ 

var orden;
var idioma;

cargar_div('generador_frases.php',''+document.getElementById("frase_secciones").value+'&pixels_final_lienzo='+document.getElementById("pixels_final").value+'&fuente_frase='+document.getElementById("fuente_frase").value+'&marco_lienzo='+document.getElementById("marco").value+'&pixels_lienzo='+document.getElementById("pixels_lienzo").value+'&sz_f_s='+document.getElementById("size_font_sup").value+'&sz_f_i='+document.getElementById("size_font_inf").value+'&inf_may='+
document.getElementById("inf_may").value+'&sup_may='+document.getElementById("sup_may").value+'&color_sup='+document.getElementById("color_sup").value+'&color_inf='+document.getElementById("color_inf").value+'&pixels_borde_lienzo='+document.getElementById("grosor").value+'&color_borde_lienzo='+document.getElementById("color_borde_lienzo").value+'&sup_idioma='+document.getElementById("sup_idioma").value+'&inf_idioma='+document.getElementById("inf_idioma").value+'&imagenes='+document.getElementById("imagenes").value+'&frase='+document.getElementById("frase_completa").value+'&salida='+document.getElementById("formato_salida").value+'&fuente_pictogramas='+document.getElementById("fuente_pictogramas").value+'&size_font_pictos='+document.getElementById("size_font_pictos").value+'&pictos_may='+document.getElementById("pictos_may").value+'&filas='+document.getElementById("filas").value+'&columnas='+document.getElementById("columnas").value+'&posic_frase='+document.getElementById("posic_frase").value+'&size_font_frase='+document.getElementById("frase_size_font").value+'&may_frase='+document.getElementById("may_frase").value+'&color_frase='+document.getElementById("color_frase").value+'&marco_simbolo='+document.getElementById("marco_simbolo").value+'&grosor_borde_simbolo='+document.getElementById("grosor_borde_simbolo").value+'&color_borde_simbolo='+document.getElementById("color_borde_simbolo").value+'&pixels_lienzo_simbolo='+document.getElementById("pixels_lienzo_simbolo").value+'&fuente_simbolo='+document.getElementById("fuente_simbolo").value+'&color_predeterminado_marco_simbolo='+document.getElementById("color_marco_simbolo_predeterminado").value,'frase');
}

function generar_animacion(id_usuario) {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("form1");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += "&thelist3[]=" + escape(Formulario.elements[i].value) ;
                   }

			}

	}

var url    = 'creador_animaciones/procesar.php';
var pars   = document.form1.seleccion_cesto.value+'&milisegundos='+document.form1.milisegundos.value+'&loops='+document.form1.loops.value+'&desde='+document.form1.desde.value+'&id_seleccion='+document.form1.mi_seleccion.value+'&id_usuario='+id_usuario+'&output='+document.form1.output.value+cadenaFormulario;
var myAjax = new Ajax.Request( url, {method: 'post', parameters: pars, onLoading: showLoad, onComplete: showResponse2 } );
				
				
/*cargar_div('creador_animaciones/procesar.php',document.form1.seleccion_cesto.value+'&milisegundos='+document.form1.milisegundos.value+'&loops='+document.form1.loops.value+'&desde='+document.form1.desde.value+'&id_seleccion='+document.form1.mi_seleccion.value+'&id_usuario='+id_usuario+'&output='+document.form1.output.value+cadenaFormulario,'simbolo');	*/


/*cargar_div('creador_animaciones/procesar.php',document.getElementById("seleccion_cesto").value+'&milisegundos='+document.getElementById("milisegundos").value+'&loops='+document.getElementById("loops").value+'&desde='+document.getElementById("desde").value+'&id_seleccion='+document.getElementById("mi_seleccion").value+'&id_usuario='+id_usuario+'&output='+document.getElementById("output").value+cadenaFormulario,'simbolo');*/	
}

function addProduct(element, dropon, event) {
	sendData(element.id);
}

function sendData (prod) {
	var url    = '../cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'product_id=' + prod + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=procesar('comun/contar_cesto.php','accion=numero_simbolos','n_cesto');
	//var n_simbolos2=cargar_div('../inc/contar_cesto.php','accion=numero_simbolos','n_cesto2');
}	
		
function clearCart () {
	
		Dialog.confirm("&iquest;Est&aacute; seguro que desea vaciar su cesto?", 
			{windowParameters: {className: 'alphacube', width: 300, height: 100}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { 
			
				var url    = '../cesto.php';
				var rand   = Math.random(9999);
				var pars   = 'clear=true&rand=' + rand;
				var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
				$('n_cesto').innerHTML = '0';
				var cesto2 = document.getElementById("n_cesto2");
				if (cesto2 != null) { cesto2.innerHTML = '0'; }
							
			return true;  
			Dialog.closeInfo();	
			}
		});
		
}

function clearCart_sin_confirmacion() {
	var url    = 'inc/cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clear=true&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	$('n_cesto').innerHTML = '0';
	var cesto2 = document.getElementById("n_cesto2");
	if (cesto2 != null) { cesto2.innerHTML = '0'; }
}

function clearCart_OLD() {
	var url    = 'inc/cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clear=true&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	$('n_cesto').innerHTML = '0';
}

function borrar_mi_seleccion() {
	var url    = 'cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clear_mi_seleccion=true&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: restaurar_seleccion} );
}

function restaurar_seleccion(originalRequest) {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
	$('thelist2').innerHTML = originalRequest.responseText;
}

function clearProduct (id) {
	var url    = 'inc/cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clearProduct=true&id=' + id + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=procesar('inc/contar_cesto.php','accion=numero_simbolos','n_cesto');
}	

function clearProduct_herramientas (id) {
	var url    = 'cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clearProduct=true&id=' + id + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=procesar('../contar_cesto.php','accion=numero_simbolos','n_cesto');
}

function showResponse (originalRequest) {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
	$('cart').innerHTML = originalRequest.responseText;
}

function showResponse2 (originalRequest) {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
	var animacion = document.getElementById("animacion");
	animacion.innerHTML = originalRequest.responseText;
}

function showLoad () {
	$('clearCart').style.display = "none";
	$('loading').style.display = "block";
}

function HideLoad () {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
}

function showDIV (id) {
	var div = document.getElementById(""+id+"");
	div.style.display = "block";
}

function hideDIV (id) {
	var div = document.getElementById(""+id+"");
	div.style.display = "none";
}
/***********************************************
* Disable "Enter" key in Form script- By Nurul Fadilah(nurul@REMOVETHISvolmedia.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
function handleEnter (field, event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
					break;
			i = (i + 1) % field.form.elements.length;
			field.form.elements[i].focus();
			return false;
		} 
		else
		return true;
	}  
	
/***********************************************
* SCRIPT AUTOCOMPLETAR
***********************************************/	

	function lookup(inputString,language) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('suggestions').hide();
		} else {
			
		var cadenaFormulario = "";
		var Formulario = document.getElementById("seleccion_simbolos");
		var longitudFormulario = Formulario.elements.length;
			
		 	for (var i = 0; i < longitudFormulario; i++) {
					
				if (Formulario.elements[i].type=='checkbox') {
						   
						   if (Formulario.elements[i].checked == true) {                                           
					  
								  cadenaFormulario += Formulario.elements[i].name + "||";
								  
						   }
		
				}
	
			}

			var myAjax = new Ajax.Request('rpc.php', {method: 'post', parameters: 'queryString='+inputString+'&language='+language+'&checks='+cadenaFormulario+'', onComplete: mostrar_sugerencias} );
		}
	} // lookup
	
	function mostrar_sugerencias (originalRequest) {
		
		$('suggestions').show();
		var cuadro_sugerencias = document.getElementById("autoSuggestionsList");
		cuadro_sugerencias.innerHTML = originalRequest.responseText;	
		
	}
	
	function fill(thisValue) {
		$('s').value='';
		setTimeout("$('suggestions').hide();", 200);
		document.getElementById('id_palabra').value = thisValue; 
		var mi_seleccion=document.getElementById('mi_seleccion').value; 
		var language=document.getElementById('idiomafrase').value; 
		cargar_div2('paso2.php',''+mi_seleccion+'&palabra='+thisValue+'&language='+language+'&tipo=1','thelist2'); 
	}
	
	
	function add_imagen_listado(id,ruta_cesto,acepcion,ruta_mp3,ruta_img,ruta_mp3_reproductor) {
		
		var html;
		var code;
		var contador;
		contador=document.getElementById('contador').value;
		html= document.getElementById('thelist2').innerHTML;
		
		if (ruta_mp3 !='') { 
		
		code='<li id="thelist2_'+contador+'"><div style="float:left;"><input name="usar['+contador+']" id="U'+contador+'" type="checkbox" value="'+ruta_cesto+'" checked="checked" /></div><img src="../classes/img/thumbnail.php?i='+ruta_img+'" border="0"/><div id="mp3_player'+contador+'" style="float:right;"><input name="mp3['+contador+']" type="hidden" value="'+ruta_mp3+'" size="10" /><object type="application/x-shockwave-flash" data="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" height="15" width="15"> <param name="movie" value="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /></object></div><input name="txt['+contador+']" id="txt'+contador+'" type="text" value="'+acepcion+'" size="10" />Añadir/Modificar:<br /><a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_locucion.php?id='+contador+'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/add_selection_mp3.png" border="0" alt="Añadir/Modificar locución" title="Añadir/Modificar locución"></a>&nbsp;<a href="javascript:void();" onclick="delete_mp3('+contador+');"><img src="../../../images/delete_mp3" border="0" alt="Borrar locución" title="Borrar locución"></a>&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_texto.php?id='+contador+'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/editar.gif" border="0" alt="Añadir/Modificar texto" title="Añadir/Modificar texto"></a></li>';
		
		} else {
		 code='<li id="thelist2_'+contador+'"><div style="float:left;"><input name="usar['+contador+']" id="U'+contador+'" type="checkbox" value="'+ruta_cesto+'" checked="checked"/></div><img src="../classes/img/thumbnail.php?i='+ruta_img+'" border="0"/><div id="mp3_player'+contador+'" style="float:right;"><input name="mp3['+contador+']" type="hidden" value="" size="10" /></div><input name="txt['+contador+']" id="txt'+contador+'" type="text" value="'+acepcion+'" size="10" />Añadir/Modificar:<br /><a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_locucion.php?id='+contador+'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/add_selection_mp3.png" border="0" alt="Añadir/Modificar locución" title="Añadir/Modificar locución"></a>&nbsp;<a href="javascript:void();" onclick="delete_mp3('+contador+');"><img src="../../../images/delete_mp3" border="0" alt="Borrar locución" title="Borrar locución"></a>&nbsp;<a href="javascript:void(0);" onclick="Dialog.alert({url: \'seleccionar_texto.php?id='+contador+'\', options: {method: \'get\'}},{windowParameters: {className: \'alphacube\', width:500}, okLabel: \'Cerrar\'});"><img src="../../../images/editar.gif" border="0" alt="Añadir/Modificar texto" title="Añadir/Modificar texto"></a></li>';
			
		}
		
		document.getElementById('contador').value=parseInt(contador)+1;
		document.getElementById('thelist2').innerHTML=html+code;
		Dialog.closeInfo();
	}
	
	function add_mp3(id,ruta_mp3,ruta_mp3_reproductor) {
		
		code ='<object type="application/x-shockwave-flash" data="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" height="15" width="15"> <param name="movie" value="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /></object><input name="mp3['+id+']" type="hidden" value="'+ruta_mp3+'" size="10" />';
		document.getElementById('mp3_player'+id+'').innerHTML=code;
		Dialog.closeInfo();
		
	}
	
	function add_mp3_div(div_id,hidden_id,ruta_mp3,ruta_mp3_reproductor) {
		
		code ='<object type="application/x-shockwave-flash" data="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" height="15" width="15"> <param name="movie" value="../../../swf/angular1.swf?src='+ruta_mp3_reproductor+'" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /></object><input name="'+hidden_id+'" id="'+hidden_id+'" type="hidden" value="'+ruta_mp3+'" />';
		
		//<a href="javascript:void();" onclick="delete_mp3_div('+div_id+','+hidden_id+');"><img src="../../../images/delete_mp3" border="0" alt="Borrar locución" title="Borrar locución"></a>
		document.getElementById(''+div_id+'').innerHTML=code;
		Dialog.closeInfo();
		
	}
	
	function delete_mp3_div(div_id,hidden_id) {

		document.getElementById(''+div_id+'').innerHTML='<input name="'+hidden_id+'" id="'+hidden_id+'" type="hidden" value=""/>';
		
	}
	
	function delete_mp3(id) {
		
		document.getElementById('mp3_player'+id+'').innerHTML='<input name="mp3['+id+']" type="hidden" value="" size="10" />';
		
	}
	
	function add_txt(id,acepcion) {
		
		document.getElementById('txt'+id+'').value=acepcion;
		Dialog.closeInfo();
		
	}
/***********************************************
* FUNCIONES SORTABLE LISTS
***********************************************/
	var sections = [];
 
	function createNewSection(html) {
		var name = $F('sectionName');
		var tipo_actividad = $F('tipo_actividad');
		var contenido='';
		
		var myAjax = new Ajax.Request('mostrar_formulario_actividad.php', {method: 'post', parameters: 'id_tipo_actividad='+tipo_actividad+'&id='+(sections.length + 1)+'&nombre_actividad='+name+'&group_select='+html+'', onComplete: function(originalRequest){  		
		
		   if (name != '') {
			var newDiv = Builder.node('div', {id: '' + (sections.length + 1), className: 'section', style: 'display:none;' }, [
				Builder.node('div', {id: 'form_' + (sections.length + 1), className: 'form'}, '').update(originalRequest.responseText),
			]);
	
			sections.push(newDiv.id);
			$('page').appendChild(newDiv);
			Effect.Appear(newDiv.id);
			destroyLineItemSortables();
			createLineItemSortables();
			createGroupSortable();
		   }
		
		} } );
	}
 
	function createLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'lineitem'});
		}
	}
 
	function destroyLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.destroy(sections[i]);
		}
	}
 
	function createGroupSortable() {
		Sortable.create('page',{tag:'div',only:'section',handle:'handle'});
	}
 
	/*
	Debug Functions for checking the group and item order
	*/
	function getGroupOrder() {
		var sections = document.getElementsByClassName('section');
		var alerttext = '';
		sections.each(function(section) {
			var sectionID = section.id;
			var order = Sortable.serialize(sectionID);
			alerttext += sectionID + '&';
		});
		alert(alerttext);
		return false;
	}
	
	function borrar_actividad(id) {
		var nodo = document.getElementById(''+id+'');
		nodo.parentNode.removeChild(nodo);
	}
	
	function crear_grupo() {
		var contador = document.getElementById('contador').value;
		var seleccion='';
		for (i=0;i<contador;i++) {
			var checks = document.getElementById('U'+i+'').checked;
			if (checks==true) { seleccion=seleccion+'||'+i; } 
			
		}
		return seleccion;
		
	}

/***********************************************
* FUNCIONES CREAR GRUPOS
***********************************************/
var ios = 0;
var aos = 0;
function insertGroups(theSel, newText)
{
  var newValue=crear_grupo();
  
  if (theSel.length == 0) {
    var newOpt1 = new Option(newText, newValue);
    theSel.options[0] = newOpt1;
    theSel.selectedIndex = 0;
  } else if (theSel.selectedIndex != -1) {
    var selText = new Array();
    var selValues = new Array();
    var selIsSel = new Array();
    var newCount = -1;
    var newSelected = -1;
    var i;
    for(i=0; i<theSel.length; i++)
    {
      newCount++;
      if (newCount == theSel.selectedIndex) {
        selText[newCount] = newText;
        selValues[newCount] = newValue;
        selIsSel[newCount] = false;
        newCount++;
        newSelected = newCount;
      }
      selText[newCount] = theSel.options[i].text;
      selValues[newCount] = theSel.options[i].value;
      selIsSel[newCount] = theSel.options[i].selected;
    }
    for(i=0; i<=newCount; i++)
    {
      var newOpt = new Option(selText[i], selValues[i]);
      theSel.options[i] = newOpt;
      theSel.options[i].selected = selIsSel[i];
    }
  }
}

function removeItemGroups(theSel)
{
  var selIndex = theSel.selectedIndex;
  if (selIndex != -1) {
    for(i=theSel.length-1; i>=0; i--)
    {
      if(theSel.options[i].selected)
      {
        theSel.options[i] = null;
      }
    }
    if (theSel.length > 0) {
      theSel.selectedIndex = selIndex == 0 ? 0 : selIndex - 1;
    }
  }
}

function showGroupSelection(theSel)
{
  var selIndex = theSel.selectedIndex;
  if (selIndex != -1) {
    for(i=theSel.length-1; i>=0; i--)
    {
      if(theSel.options[i].selected)
      {
        alert(theSel.options[i].value);
      }
    }
    if (theSel.length > 0) {
      theSel.selectedIndex = selIndex == 0 ? 0 : selIndex - 1;
    }
  }
	
}

function formSelectGroup(theSel)
{
  var selIndex = theSel.selectedIndex;
  var html='<select name="grupos">';
  if (selIndex != -1) {
    for(i=theSel.length-1; i>=0; i--)
    {
       html=html+'<option value="'+theSel.options[i].value+'">'+theSel.options[i].text+'</option>';
    }
    if (theSel.length > 0) {
      theSel.selectedIndex = selIndex == 0 ? 0 : selIndex - 1;
    }
	html=html+'</select>';
	return html;
  }
	
}


function selydestodos(form,activa)
{
for(i=0;i<form.elements.length;i++)
if(form.elements[i].type=="checkbox")
form.elements[i].checked=activa;
}

function add_palabra(page,param,div){

		var content = document.getElementById(""+div+"");
		var palabras = document.form1.palabras_seleccionadas.value;
		document.form1.palabras_seleccionadas.value = document.form1.palabras_seleccionadas.value + param + ';';
		cargar_div2(page,'id='+document.form1.palabras_seleccionadas.value,div);
		return false;

}

function borrar_palabra(page,param,div){

		var content = document.getElementById(""+div+"");
		var palabras = document.form1.palabras_seleccionadas.value;
		document.form1.palabras_seleccionadas.value = palabras.replace(''+param+';','');
		cargar_div2(page,'id='+document.form1.palabras_seleccionadas.value,div);
		return false;

}
//-->