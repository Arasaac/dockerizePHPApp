/*  Funciones Javascript del Arablogs
 *
/*--------------------------------------------------------------------------*/

<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->


<!--
function ChequearTodos(form)
{

   for (i=0;i<eval("document."+form+".elements.length");i++) 
      if(eval("document."+form+".elements["+i+"].type == 'checkbox'")) {
	  
			if (eval("document."+form+".elements["+i+"].checked==0")) {
			 eval("document."+form+".elements["+i+"].checked=1");
			 eval("document."+form+".check.checked=1");
			} else {
			 eval("document."+form+".elements["+i+"].checked=0");
			 eval("document."+form+".check.checked=0");
			}
		
	  } 
}
//-->



// PickList II script (aka Menu Swapper)- By Phil Webb (http://www.philwebb.com)
// Visit JavaScript Kit (http://www.javascriptkit.com) for this JavaScript and 100s more
// Please keep this notice intact

function move(fbox, tbox) {
     var arrFbox = new Array();
     var arrTbox = new Array();
     var arrLookup = new Array();
     var i;
     for(i=0; i<tbox.options.length; i++) {
          arrLookup[tbox.options[i].text] = tbox.options[i].value;
          arrTbox[i] = tbox.options[i].text;
     }
     var fLength = 0;
     var tLength = arrTbox.length
     for(i=0; i<fbox.options.length; i++) {
          arrLookup[fbox.options[i].text] = fbox.options[i].value;
          if(fbox.options[i].selected && fbox.options[i].value != "") {
               arrTbox[tLength] = fbox.options[i].text;
               tLength++;
          } else {
               arrFbox[fLength] = fbox.options[i].text;
               fLength++;
          }
     }
     arrFbox.sort();
     arrTbox.sort();
     fbox.length = 0;
     tbox.length = 0;
     var c;
     for(c=0; c<arrFbox.length; c++) {
          var no = new Option();
          no.value = arrLookup[arrFbox[c]];
          no.text = arrFbox[c];
          fbox[c] = no;
     }
     for(c=0; c<arrTbox.length; c++) {
     	var no = new Option();
     	no.value = arrLookup[arrTbox[c]];
     	no.text = arrTbox[c];
     	tbox[c] = no;
     }
}

function selectAll(box) {
     for(var i=0; i<box.length; i++) {
     box[i].selected = true;
     }
}
