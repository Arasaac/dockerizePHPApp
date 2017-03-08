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