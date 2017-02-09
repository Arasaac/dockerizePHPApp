 function conversion(){
 var s=document.unicode.saisie.value;
 code="";
 for(m=0;s.charAt(m);++m)if((c=s.charCodeAt(m))<128&&c!=38) code+=s.charAt(m); else if(c==38) code+="&amp;"; else code+="&#"+c+";";
 document.unicode.resultat.value=code;
 }
 function copy()
{textRange=document.unicode.resultat.createTextRange();  textRange.execCommand("Copy");  textRange="";
}

 function del()
{textRange=document.unicode.resultat.createTextRange();  textRange.execCommand("Delete");  textRange="";
textRange1=document.unicode.saisie.createTextRange();  textRange1.execCommand("Delete");  textRange1="";
}