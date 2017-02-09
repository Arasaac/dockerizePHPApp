function alpha(item) { 
		var input = document.forms['conversion'].elements['saisie'] ;
		input.focus() ;
		if (typeof input.selectionStart != 'undefined') {
			cursor = input.selectionStart ;
			size = input.value.length ;
			firstPart = input.value.substring(0, cursor) ;
			lastPart = input.value.substring(cursor, size) ;
			input.value = firstPart + item + lastPart ; 
			input.selectionStart += item.length ; 
		}
		else { // pour IE  
			var range = document.selection.createRange() ;
			range.text = item ;
		}
		input.focus() ;
		input.scrollTop = input.scrollHeight ;
	}
function copy()
{ textRange=document.conversion.saisie.createTextRange();   textRange.execCommand("Copy");   textRange="";
}