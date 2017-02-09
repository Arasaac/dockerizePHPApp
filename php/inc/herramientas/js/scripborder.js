/**
 * @author arepamax (anthraxlegendXD javascript power)
 * 
 * parameters(spanglish XD) paramametrs 
 * id osea el id del css sin #
 * ancho osea ejmp 100px 
 * alto osea ejmp 100px 
 * opcion =dos-abajo | dos-arriba | todo | dos-arriba-derecho-abajo | dos-arriba-isquierdo-abajo|
 * 			derecho-arriba-derecho-abajo| isquierdo-arriba-derecho-abajo | isquierdo-arriba|
 * 			isquierdo-abajo | derecho-abajo
 * bueno haora si a disfrutar del script XD espero que le sea de ayuda 
 * proxima version bordes transparantes
 */
function crearbore1(id,amcho,altox,opcion,fondoc)
{
	var ks=document.getElementById(id);
	
	switch (opcion)
	{
		
		case "dos-abajo":
		{DosB(id,fondo,ancho,alto)};break;
		case "dos-arriba":
		{dosA(id,fondoc,amcho,altox)};break;
		case "todo":
		todos(id,fondoc,amcho,altox);
		break;
		case "dos-arriba-derecho-abajo":
		{dosAyIbajo(id,fondoc,amcho,altox);
		};break;
		case "dos-arriba-isquierdo-abajo":
		{dosAyIbajo(id,fondoc,amcho,altox);
		};break;
		case "derecho-arriba-isquierdo-abajo":
		{DAyIdown(id,fondoc,amcho,altox);
		};break;
		case "derecho-arriba-derecho-abajo":
		{dAyddown(id,fondoc,amcho,altox);
		};break;
		case "isquierdo-arriba-derecho-abajo":
		{IAyDdown(id,fondoc,amcho,altox);
		};break;
		case "isquierdo-arriba-isquierdo-abajo":
		{IAyIdown(id,fondoc,amcho,altox)
		};break;
		case "isquierdo-arriba":
		{isquierdoa(id,fondoc,amcho,altox);
		};break;
		case "isquierdo-abajo":
		{isquierdodown(id,fondoc,amcho,altox)
		};break;
		case "derecho-arriba":
		{
			derechoa(id, fondoc, amcho, altox);
		}
		;break;
		case "derecho-abajo":
		{derechodown(id,fondo,ancho,alto);
		};break;
	}
}

function todos(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="3px";
nodouno.style.margin="0 1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.margin="0 2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.margin="0 3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.margin="0 5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="3px";
nodouno2.style.margin="0 1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.margin="0 2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.margin="0 3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.margin="0 5px";	
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}

dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;


document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
	
}

function isquierdoa(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginLeft="1px";
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginLeft="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginLeft="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginLeft="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}

var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;
var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro);
elemtf.appendChild(nodotres);
elemtf.appendChild(nododos);
elemtf.appendChild(nodouno);
elemtf.appendChild(dentro);
elemtf.style.width=ancho;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);

	
}

function derechoa(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";
try{
nodouno.style.background=fondo;
}
catch(erra0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(erra21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(erra2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";
try{
nodocuatro.style.background=fondo;
}
catch(erra3)
{
	nodocuatro.style.backgroundColor=fondo;
}

var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(erra)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;
var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="10px";
dentro.appendChild(texto);


var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro);
elemtf.appendChild(nodotres);
elemtf.appendChild(nododos);
elemtf.appendChild(nodouno);
elemtf.appendChild(dentro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;

	elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function dosAydbajo(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.margin="0 1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.margin="0 2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.margin="0 3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.margin="0 5px";	
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);


var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;

	elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function dosAyIbajo(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginLeft="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginLeft="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginLeft="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginLeft="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.margin="0 1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.margin="0 2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.margin="0 3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.margin="0 5px";	
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;

	elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function isquierdodown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginLeft="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginLeft="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginLeft="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginLeft="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}




var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="10px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");

elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function derechodown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}






var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");

elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
	
}

function dAyddown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.marginRight="1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.marginRight="2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.marginRight="3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.marginRight="5px";
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function IAyIdown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginLeft="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginLeft="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginLeft="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginLeft="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.marginLeft="1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.marginLeft="2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.marginLeft="3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.marginLeft="5px";
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
	
}

function DAyIdown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.marginLeft="1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.marginLeft="2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{

	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.marginLeft="3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.marginLeft="5px";
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}

function IAyDdown(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.marginRight="1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.marginRight="2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.marginRight="3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.marginRight="5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}



var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.marginLeft="1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.marginLeft="2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{

	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.marginLeft="3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.marginLeft="5px";
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;

var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro);
elemtf.appendChild(nodotres);
elemtf.appendChild(nododos);
elemtf.appendChild(nodouno);
elemtf.appendChild(dentro);
elemtf.appendChild(nodouno2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nodocuatro2);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
	
}

function dosA(id,fondo,ancho,alto){

var nodouno2=document.createElement("div");
nodouno2.style.height="2px";
nodouno2.style.margin="0 1px";	
try{
nodouno2.style.background=fondo;
}
catch(err01)
{
	nodouno2.style.backgroundColor=fondo;
}

var nododos2=document.createElement("div");
nododos2.style.height="1px";
nododos2.style.margin="0 2px";
try{
nododos2.style.background=fondo;
}
catch(err22)
{
	nododos2.style.backgroundColor=fondo;
}
var nodotres2=document.createElement("div");
nodotres2.style.height="1px";
nodotres2.style.margin="0 3px";
try{
nodotres2.style.background=fondo;
}
catch(err23)
{
	nodotres2.style.backgroundColor=fondo;
}

var nodocuatro2=document.createElement("div");
nodocuatro2.style.height="1px";
nodocuatro2.style.margin="0 5px";	
try{
nodocuatro2.style.background=fondo;
}
catch(err34)
{
	nodocuatro2.style.backgroundColor=fondo;
}







var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;
var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);
var elemtf=document.createElement("div");
elemtf.appendChild(nodocuatro2);
elemtf.appendChild(nodotres2);
elemtf.appendChild(nododos2);
elemtf.appendChild(nodouno2);
elemtf.appendChild(dentro);

elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}



function DosB(id,fondo,ancho,alto){
var nodouno=document.createElement("div");
nodouno.style.height="2px";
nodouno.style.margin="0 1px";	
try{
nodouno.style.background=fondo;
}
catch(err0)
{
	nodouno.style.backgroundColor=fondo;
}

var nododos=document.createElement("div");
nododos.style.height="1px";
nododos.style.margin="0 2px";
try{
nododos.style.background=fondo;
}
catch(err21)
{
	nododos.style.backgroundColor=fondo;
}
var nodotres=document.createElement("div");
nodotres.style.height="1px";
nodotres.style.margin="0 3px";
try{
nodotres.style.background=fondo;
}
catch(err2)
{
	nodotres.style.backgroundColor=fondo;
}

var nodocuatro=document.createElement("div");
nodocuatro.style.height="1px";
nodocuatro.style.margin="0 5px";	
try{
nodocuatro.style.background=fondo;
}
catch(err3)
{
	nodocuatro.style.backgroundColor=fondo;
}









var dentro=document.createElement("div");
try{
dentro.style.background=fondo;
}
catch(err2)
{
	dentro.style.backgroundColor=fondo;
}
dentro.style.height=alto;
var elemtno=document.getElementById(id);
var texto=document.createElement("div");
texto.innerHTML=elemtno.innerHTML;
texto.style.padding="2px";
dentro.appendChild(texto);

var elemtf=document.createElement("div");

elemtf.appendChild(dentro);
elemtf.appendChild(nodouno);
elemtf.appendChild(nododos);
elemtf.appendChild(nodotres);
elemtf.appendChild(nodocuatro);
elemtf.style.width=ancho;
//elemtf.style.background=fondo;
elemtf.setAttribute("id",id);
//elemtf.style.background=fondo;
document.body.removeChild(elemtno);
document.body.appendChild(elemtf);
}
















