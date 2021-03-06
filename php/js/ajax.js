function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

/*      FUNCION QUE MUESTRA LA VENTA A MODAL          */
/* *************************************************** */

function ventana_confirmacion(txt,ancho,alto,url,variables,div,url1,variables1,div1) {
		Dialog.confirm(txt, 
			{windowParameters: {className: 'alphacube', width: ancho, height: alto}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { cargar_div(''+url+'',''+variables+'',''+div+''); 
				if (url1 !='' && variables1!='' && div1!='') {
					cargar_div(''+url1+'',''+variables1+'',''+div1+''); 
				} 
			return true;  }
		});
}

function ventana_confirmacion_listado_simbolos(txt,ancho,alto,url,div) {
	
		var cadenaFormulario = "";
        var Formulario = document.getElementById("listado_de_simbolos");
        var longitudFormulario = Formulario.elements.length;
		
		 for (var i = 0; i < longitudFormulario; i++) {
						
				if (Formulario.elements[i].type=='checkbox') {
						   if (Formulario.elements[i].checked == true) {                                           
					  
								  cadenaFormulario += Formulario.elements[i].name + "||";
						   }
		
					}
		
		}
	
		Dialog.confirm(txt, 
			{windowParameters: {className: 'alphacube', width: ancho, height: alto}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { cargar_div(''+url+'','checkboxes='+cadenaFormulario+'',''+div+''); 
				recogercheckbox_administrador_simbolos();
			return true;  }
		});
}

/* FUNCION BORRAR CARPETA                      */
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

/*  FUNCIONES DHTMLXTREE */
/* *************************************************** */

	function onNodeSelect(nodeId){
		alert(nodeId);
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
	
	cargar_div('inc/creador_simbolos/palabra_seleccionada.php','id='+id_palabra+'','selected_word'); 
	cargar_div('inc/creador_simbolos/mostrar_imagenes.php','id='+id_palabra+'','imagenes_disponibles'); 
	cargar_div('inc/creador_simbolos/mostrar_color_borde.php','id='+id_palabra+'','color_borde'); 
	HideLoad ();
	Dialog.closeInfo();

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

		Dialog.confirm("&iquest;Est&aacute; seguro que desea desconectarse?<br>Su cesto ser&aacute; vaciado", 
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
	

/* FUNCION AJAX B�SICA DE CARGA                        */
/* *************************************************** */
function cargar_div(page,param,div){

var myAjax = new Ajax.Request( page, {method: 'post', parameters: param, onLoading: showLoad, onComplete: showResponse2 } );

	function showResponse2 (originalRequest) {
		$('loading').style.display = "none";
		$('clearCart').style.display = "block";
		var animacion = document.getElementById(""+div+"");
		animacion.innerHTML = originalRequest.responseText;
	}

}

function cargar_div3(url,param,div){

	var myAjax = new Ajax.Request( url, {method: 'post', parameters: param, onLoading: showLoad, onComplete: window.location.reload()} );
}

function procesar(page,param,div){

var myAjax = new Ajax.Request( page, {method: 'post', parameters: param, onLoading: showLoad, onComplete: showResponse3 } );

	function showResponse3 (originalRequest) {
		$('loading').style.display = "none";
		$('clearCart').style.display = "block";
		var animacion = document.getElementById(""+div+"");
		animacion.innerHTML = originalRequest.responseText;
	}
}


function cargar_div2(page,param,div){

var myAjax = new Ajax.Request( page, {method: 'post', parameters: param, onComplete: showResponse4 } );

	function showResponse4 (originalRequest) {
		var animacion = document.getElementById(""+div+"");
		animacion.innerHTML = originalRequest.responseText;
	}
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

		//d�finition de l'endroit d'affichage:
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

cargar_div('classes/text_image/formimage.php','pixels_final='+document.form1.pixels_final.value+'&fuente_castellano='+document.form1.fuente_castellano.value+'&color_contraste='+document.form1.color_alto_contraste.value+'&accion='+document.form1.accion.value+'&id='+document.form1.id_palabra.value+'&marco='+document.form1.marco.value+'&pixels_lienzo='+document.form1.pixels_lienzo.value+'&id_palabra='+document.form1.id_palabra.value+'&txt_cas='+document.form1.palabra.value+'&sz_f_s='+document.form1.size_font_sup.value+'&sz_f_i='+document.form1.size_font_inf.value+'&inf_may='+
document.form1.inf_may.value+'&sup_may='+document.form1.sup_may.value+'&id_traduccion='+document.form1.id_traduccion.value+'&color_sup='+document.form1.color_sup.value+"&color_inf="+document.form1.color_inf.value+"&archivo="+document.img_subida.imagen_subida.value+"&pixels_borde="+document.form1.grosor.value+"&color_borde="+document.form1.color_borde.value+"&sup_idioma="+document.form1.sup_idioma.value+"&inf_idioma="+document.form1.inf_idioma.value,'simbolo');
}

/* FUNCION QUE CARGA LAS TRADUCCIONES DE CADA PALABRA */
/* *************************************************** */
function palabra_actual(param, page)
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

		//d�finition de l'endroit d'affichage:
		var content = document.getElementById("palabra");
		
		XhrObj.open("POST", page);

		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param);
	}//fin fonction SendData


function addProduct(element, dropon, event) {
	sendData(element.id);
}
function sendData (prod) {
	var url    = 'inc/cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'product_id=' + prod + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=cargar_div('inc/contar_cesto.php','accion=numero_simbolos','n_cesto');
	var n_simbolos2=cargar_div('inc/contar_cesto.php','accion=numero_simbolos','n_cesto2');
//	var content = document.getElementById("palabra");
//	content.innerHTML = n_simbolos;
}	
		
function clearCart () {
	
		Dialog.confirm("&iquest;Est&aacute; seguro que desea vaciar su cesto?", 
			{windowParameters: {className: 'alphacube', width: 300, height: 100}, okLabel: "Si", cancelLabel: "No",
			ok:function(win) { 
			
				var url    = 'inc/cesto.php';
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

function borrar_mi_seleccion () {
	var url    = 'cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clear_mi_seleccion=true&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
}

function clearProduct (id) {
	var url    = 'inc/cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clearProduct=true&id=' + id + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=cargar_div('inc/contar_cesto.php','accion=numero_simbolos','n_cesto');
//	var content = document.getElementById("palabra");
//	content.innerHTML = n_simbolos;
}	

function clearProduct_herramientas (id) {
	var url    = 'cesto.php';
	var rand   = Math.random(9999);
	var pars   = 'clearProduct=true&id=' + id + '&rand=' + rand;
	var myAjax = new Ajax.Request( url, {method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );
	var n_simbolos=cargar_div('../contar_cesto.php','accion=numero_simbolos','n_cesto');
//	var content = document.getElementById("palabra");
//	content.innerHTML = n_simbolos;
}

function showResponse (originalRequest) {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
	$('cart').innerHTML = originalRequest.responseText;
//	var n_simbolos=cargar_div2('inc/contar_cesto.php','accion=numero_simbolos','n_cesto');
//	var content = document.getElementById("palabra");
//	content.innerHTML = n_simbolos;
}

function showLoad () {
	$('clearCart').style.display = "none";
	$('loading').style.display = "block";
}

function HideLoad () {
	$('loading').style.display = "none";
	$('clearCart').style.display = "block";
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
* Editor In Place
***********************************************/
function cambia(span_id,id_palabra) {
		
		var spans = document.getElementById(""+span_id+"");
		
		width = widthEl(span_id) + 20;
		height =heightEl(span_id) + 10;
		
		if(width < 100)
			width = 150;
		if(height < 40)
		
		spans.innerHTML = "<input id=\""+ spans +"_field\" style=\"width: "+width+"px; height: "+height+"px;\" maxlength=\"254\" type=\"text\" value=\"" + spans.innerHTML + "\" onkeypress=\"return fieldEnter(this,event,'" + span_id + "','" + id_palabra + "')\" onfocus=\"highLight(this);\" onblur=\"noLight(this); return fieldBlur(this,'" + span_id + "','" + id_palabra + "');\" />";
		
		else
		
		spans.innerHTML = "<textarea name=\"textarea\" id=\""+ spans +"_field\" style=\"width: "+width+"px; height: "+height+"px;\" onfocus=\"highLight(this);\" onblur=\"noLight(this); return fieldBlur(this,'" + span_id + "','" + id_palabra + "');\">" + spans.innerHTML + "</textarea>";
	

}

function highLight(span){
            span.parentNode.style.border = "2px solid #D1FDCD";
            span.parentNode.style.padding = "0";
            span.style.border = "1px solid #54CE43";          
}

function noLight(span){
        span.parentNode.style.border = "0px";
        span.parentNode.style.padding = "2px";
        span.style.border = "0px";       

}

function fieldBlur(campo,idfld,id_palabra) {
	if (campo.value!="") {
		elem = document.getElementById( idfld );
		cargar_div('inc/gestion_palabras/modificar_definicion.php','id_palabra='+id_palabra+'&definicion='+campo.value+'',idfld);
	}
}


function fieldEnter(campo,evt,idfld,id_palabra) {
	evt = (evt) ? evt : window.event;
	if (evt.keyCode == 13 && campo.value!="") {
		
		elem = document.getElementById( idfld );
		cargar_div('inc/gestion_palabras/modificar_definicion.php','id_palabra='+id_palabra+'&definicion='+campo.value+'',idfld);
		//remove glow
		noLight(elem);
		return false;
	} else {
		return true;
	}


}

//get width of text element
function widthEl(span){

	if (document.layers){
	  w=document.layers[span].clip.width;
	} else if (document.all && !document.getElementById){
	  w=document.all[span].offsetWidth;
	} else if(document.getElementById){
	  w=document.getElementById(span).offsetWidth;
	}
return w;
}

//get height of text element
function heightEl(span){

	if (document.layers){
	  h=document.layers[span].clip.height;
	} else if (document.all && !document.getElementById){
	  h=document.all[span].offsetHeight;
	} else if(document.getElementById){
	  h=document.getElementById(span).offsetHeight;
	}
return h;
}



function showMenu(){
	hideMenu_avanzado();
	statusMenu = document.getElementById('hiddenStatusMenu');
	if(statusMenu.value==0){
		statusMenu.value=1;
		Effect.toggle('searchmenu','appear'); return false;
	}
}
function hideMenu(){
	statusMenu = document.getElementById('hiddenStatusMenu');
	if(statusMenu.value==1){
		statusMenu.value=0;
		Effect.toggle('searchmenu','appear'); return false;
	}
}

function showMenu_avanzado(){
	hideMenu();
	statusMenu = document.getElementById('hiddenStatusMenu_avanzado');
	if(statusMenu.value==0){
		statusMenu.value=1;
		Effect.toggle('searchmenu_avanzado','appear'); return false;
	}
}
function hideMenu_avanzado(){
	statusMenu = document.getElementById('hiddenStatusMenu_avanzado');
	if(statusMenu.value==1){
		statusMenu.value=0;
		Effect.toggle('searchmenu_avanzado','appear'); return false;
	}
}

function recogercheckbox() {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("search_materiales");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
//alert (cadenaFormulario);
cargar_div('inc/public/buscar_materiales.php','texto_buscar='+document.getElementById("textfield").value+'&licencia='+document.getElementById("licencia").value+'&checkboxes='+cadenaFormulario+'','materiales');
}

function recogercheckbox_buscador_simbolos() {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("busqueda_avanzada");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
//alert (cadenaFormulario);
cargar_div('inc/public/ultimos_simbolos_arasaac.php','id_tipo='+document.getElementById("tipo_palabra").value+'&letra='+document.getElementById("letra").value+'&marco='+document.getElementById("marco").value+'&contraste='+document.getElementById("contraste").value+'&tipo_letra='+document.getElementById("tipo_letra").value+'&tipo_simbolo='+document.getElementById("tipo_simbolo").value+'&checkboxes='+cadenaFormulario+'&avanzada=1','principal');
}

function recogercheckbox_administrador_simbolos() {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("catalogo_simbolos");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
//alert (cadenaFormulario);
cargar_div('inc/gestion_simbolos/listar_simbolos.php','id_tipo='+document.getElementById("tipo_palabra").value+'&letra='+document.getElementById("letra").value+'&marco='+document.getElementById("marco").value+'&contraste='+document.getElementById("contraste").value+'&tipo_letra='+document.getElementById("tipo_letra").value+'&tipo_simbolo='+document.getElementById("tipo_simbolo").value+'&checkboxes='+cadenaFormulario+'&avanzada=1','tabla_simbolos');
}

function recogercheckbox_opciones_busqueda_simbolos() {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("opciones_busqueda_simbolos");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
//alert (cadenaFormulario);
cargar_div('inc/public/almacenar_opciones_busqueda_simbolos.php','marco='+document.getElementById("marco").value+'&contraste='+document.getElementById("contraste").value+'&tipo_letra='+document.getElementById("tipo_letra").value+'&tipo_simbolo='+document.getElementById("tipo_simbolo").value+'&checkboxes='+cadenaFormulario+'','mensaje');
}

function recogercheckbox_buscador_principal_para_tags(tag) {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("autossugest");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
	
cargar_div2('inc/public/buscar_por_tags.php','palabra='+tag+'&checkboxes='+cadenaFormulario+'','principal');
}


function recogercheckbox_buscador_principal(buscar,buscar_por) {

		var cadenaFormulario = "";
        var Formulario = document.getElementById("autossugest");
        var longitudFormulario = Formulario.elements.length;
		
 for (var i = 0; i < longitudFormulario; i++) {
				
		if (Formulario.elements[i].type=='checkbox') {
                   if (Formulario.elements[i].checked == true) {                                           
              
                          cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
                   }

			}

	}
	
cargar_div2('inc/public/buscar_por_palabra.php','palabra='+buscar+'&buscar_por='+buscar_por+'&checkboxes='+cadenaFormulario+'','principal');
}

function ChequearTodos(chequear,form)
{

   var Formulario = document.getElementById(''+form+'');
   var longitudFormulario = Formulario.elements.length;
		
   for (var i = 0; i < longitudFormulario; i++) 
      
	  	if (Formulario.elements[i].type=='checkbox') {
			
			if (chequear==true){
			Formulario.elements[i].checked=true;
			}else{
			Formulario.elements[i].checked=false;
			} 
		
	  } 
}


/*      FUNCION QUE CAMBIA OPACIDAD DE UNA CAPA          */
/* *************************************************** */

function changeOpacity(id){
	$opacityStatus = $(id);
	if($opacityStatus.value==0){
		 new Effect.Opacity(id, {duration:0.5, from:1.0, to:0.3});
		$opacityStatus.value=1; 
	} else {
		new Effect.Opacity(id, {duration:0.5, from:0.3, to:1});
		$opacityStatus.value=0; 
	}
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
		var Formulario = document.getElementById("autossugest");
		var longitudFormulario = Formulario.elements.length;
			
		 	for (var i = 0; i < longitudFormulario; i++) {
					
				if (Formulario.elements[i].type=='checkbox') {
						   
						   if (Formulario.elements[i].checked == true) {                                           
					  
								  cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
						   }
		
				}
	
			}
			
			var myAjax = new Ajax.Request("rpc.php", {method: 'post', parameters: "queryString="+inputString+"&language="+language+"&checkboxes="+cadenaFormulario+"", onComplete: mostrar_sugerencias} );
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
		var elem=document.getElementsByName('buscar_por'); 
		if (elem[0].checked) { var buscar_por=1; } else { var buscar_por=2; } 

		
		
		var cadenaFormulario = "";
		var Formulario = document.getElementById("autossugest");
		var longitudFormulario = Formulario.elements.length;
			
		 for (var i = 0; i < longitudFormulario; i++) {
					
			if (Formulario.elements[i].type=='checkbox') {
					   if (Formulario.elements[i].checked == true) {                                           
				  
							  cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "||";
					   }
	
				}
	
			}

		cargar_div2('inc/public/buscar_por_palabra.php','id_palabra='+thisValue+'&buscar_por='+buscar_por+'&checkboxes='+cadenaFormulario+'','principal'); 		
		
	}

