// written by Dean Edwards, 2005
// with input from Tino Zijdel, Matthias Miller, Diego Perini

// http://dean.edwards.name/weblog/2005/10/add-event/

function addEvent(element, type, handler) {
	if (element.addEventListener) {
		element.addEventListener(type, handler, false);
	} else {
		// assign each event handler a unique ID
		if (!handler.$$guid) handler.$$guid = addEvent.guid++;
		// create a hash table of event types for the element
		if (!element.events) element.events = {};
		// create a hash table of event handlers for each element/event pair
		var handlers = element.events[type];
		if (!handlers) {
			handlers = element.events[type] = {};
			// store the existing event handler (if there is one)
			if (element["on" + type]) {
				handlers[0] = element["on" + type];
			}
		}
		// store the event handler in the hash table
		handlers[handler.$$guid] = handler;
		// assign a global event handler to do all the work
		element["on" + type] = handleEvent;
	}
};
// a counter used to create unique IDs
addEvent.guid = 1;

function removeEvent(element, type, handler) {
	if (element.removeEventListener) {
		element.removeEventListener(type, handler, false);
	} else {
		// delete the event handler from the hash table
		if (element.events && element.events[type]) {
			delete element.events[type][handler.$$guid];
		}
	}
};

function handleEvent(event) {
	var returnValue = true;
	// grab the event object (IE uses a global event object)
	event = event || fixEvent(((this.ownerDocument || this.document || this).parentWindow || window).event);
	// get a reference to the hash table of event handlers
	var handlers = this.events[event.type];
	// execute each event handler
	for (var i in handlers) {
		this.$$handleEvent = handlers[i];
		if (this.$$handleEvent(event) === false) {
			returnValue = false;
		}
	}
	return returnValue;
};

function fixEvent(event) {
	// add W3C standard event methods
	event.preventDefault = fixEvent.preventDefault;
	event.stopPropagation = fixEvent.stopPropagation;
	return event;
};
fixEvent.preventDefault = function() {
	this.returnValue = false;
};
fixEvent.stopPropagation = function() {
	this.cancelBubble = true;
};

/*************************************************************************************************************/

onload = function() {
  
  var a_buscar=document.getElementById("s");
  addEvent(a_buscar,"click", function() { $('suggestions').hide(); document.getElementById('s').value=''; } );
  addEvent(a_buscar,"focus", function() { $('suggestions').hide(); document.getElementById('s').value=''; } );
  addEvent(a_buscar,"keyup", function() { lookup(this.value,document.getElementById('idiomasearch').value); } );
  addEvent(a_buscar,"keypress", function() { $('suggestions').hide(); } );
  addEvent(a_buscar,"mouseup", function() { $('suggestions').hide(); } );
  
}; 
 

/*************************************************************************************************************/

function cargar_div2(page,param,div){

var myAjax = new Ajax.Request( page, {method: 'post', parameters: param, onComplete: showResponse4 } );

	function showResponse4 (originalRequest) {
		var animacion = document.getElementById(""+div+"");
		animacion.innerHTML = originalRequest.responseText;
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
			
			var myAjax = new Ajax.Request("rpc2.php", {method: 'post', parameters: "queryString="+inputString+"&language="+language+"&checkboxes="+cadenaFormulario+"", onComplete: mostrar_sugerencias} );
		}
	} // lookup
	
	function mostrar_sugerencias (originalRequest) {
		
		$('suggestions').show();
		var cuadro_sugerencias = document.getElementById("autoSuggestionsList");
		cuadro_sugerencias.innerHTML = originalRequest.responseText;	
		
	}
	
	function fill(thisValue,id_idioma) {
		$('s').value='';
		setTimeout("$('suggestions').hide();", 200);	
		
		var cadenaFormulario = "";
		var Formulario = document.getElementById("autossugest");
		var longitudFormulario = Formulario.elements.length;
			
		 for (var i = 0; i < longitudFormulario; i++) {
					
			if (Formulario.elements[i].type=='checkbox') {
					   if (Formulario.elements[i].checked == true) {                                           
				  
							  cadenaFormulario += Formulario.elements[i].name + "=" + escape(Formulario.elements[i].value) + "&";
					   }
	
				}
	
			}
		location.replace("buscar.php?id_palabra="+thisValue+"&idiomasearch="+id_idioma+"&buscar_por=1&"+cadenaFormulario+"");				 
		
	}

function sintetiza(frase,locutor)
 {
     var tmp=' ';
     frase=frase.replace('#', ' ', 'g');
     frase=frase.replace('%', ' ', 'g');
     frase=frase.replace('&', ' ', 'g');
     frase=frase.replace('-', ' - ', 'g');
     frase=frase.replace('\n', ' ', 'g');
     frase=frase.replace('\r', ' ', 'g');
     frase=frase.replace('\t', ' ', 'g');
 
     for(i=0;i<frase.length;i++)
     {
          if((frase.charCodeAt(i)==8230)||(frase.charCodeAt(i)==34)||(frase.charCodeAt(i)==187))        
           {
                  continue;
          }
          tmp=tmp+frase.charAt(i);
     }
    frase=tmp;
 
    document.vivoreco.UZSinte(frase, locutor);
 }
 
function selydestodos(form,activa)
{
for(i=0;i<form.elements.length;i++)
if(form.elements[i].type=="checkbox")
form.elements[i].checked=activa;
}