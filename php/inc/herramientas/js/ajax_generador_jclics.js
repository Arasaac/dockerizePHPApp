function checkAll()
{
	var contador = document.getElementById('contador').value;
		for (i=0;i<contador;i++) {
			document.getElementById('U'+i+'').checked=true;			
		}
}

function uncheckAll()
{
	var contador = document.getElementById('contador').value;
		for (i=0;i<contador;i++) {
			document.getElementById('U'+i+'').checked=false;			
		}
}

function showDIV (id) {
	var div = document.getElementById(""+id+"");
	div.style.display = "block";
}

function hideDIV (id) {
	var div = document.getElementById(""+id+"");
	div.style.display = "none";
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
 
	function createNewSection(theSel) {
		var name = $F('sectionName');
		var tipo_actividad = $F('tipo_actividad');
		var contenido='';
		var select_form=formSelectGroup(theSel);
		var myAjax = new Ajax.Request('mostrar_formulario_actividad.php', {method: 'post', parameters: 'id_tipo_actividad='+tipo_actividad+'&id='+(sections.length + 1)+'&nombre_actividad='+name+'&group_select='+select_form+'', onComplete: function(originalRequest){  		
		
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
  var contador = document.getElementById('contador').value;
	for (f=0;f<contador;f++) {
		document.getElementById('thelist2_'+f+'').style.backgroundColor="#FFF";
	}
		
  var selIndex = theSel.selectedIndex;
  if (selIndex != -1) {
    for(i=theSel.length-1; i>=0; i--)
    {
      if(theSel.options[i].selected)
      {
        var img=theSel.options[i].value;
		var img_splitted=img.split("||");
			for(g=img_splitted.length-1; g>0; g--) {
				
				document.getElementById('thelist2_'+img_splitted[g]+'').style.backgroundColor="#FFC";
				
			}
      }
    }

  }
	
}

function formSelectGroup(theSel)
{
  var selIndex = theSel.selectedIndex;
  var html='';
  if (selIndex != -1) {
    for(i=theSel.length-1; i>=0; i--)
    {
       html=html+'<option value="'+theSel.options[i].value+'">'+theSel.options[i].text+'</option>';
    }
    if (theSel.length > 0) {
      theSel.selectedIndex = selIndex == 0 ? 0 : selIndex - 1;
    }
	return html;
  }
	
}
//-->