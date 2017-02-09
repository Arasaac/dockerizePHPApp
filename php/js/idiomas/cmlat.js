function alpha(unicode) 
{ txt = document.conversion.saisie.value;   txt = txt + String.fromCharCode(unicode);   document.conversion.saisie.value = txt; document.conversion.saisie.focus();
} 
function copy()
{ textRange=document.conversion.saisie.createTextRange();   textRange.execCommand("Copy");   textRange="";
}