﻿var ca;
function camb() {
ca = document.conversion.saisie.value;
ca = ca.replace(/é/g, "%E9");
ca = ca.replace(/è/g, "%E8");
ca = ca.replace(/ê/g, "%EA");
ca = ca.replace(/ë/g, "%EB");
ca = ca.replace(/ç/g, "%E7");
ca = ca.replace(/à/g, "%E0");
ca = ca.replace(/â/g, "%E2");
ca = ca.replace(/ô/g, "%F4");
ca = ca.replace(/î/g, "%EE");
ca = ca.replace(/ï/g, "%EF");
ca = ca.replace(/ù/g, "%F9");
ca = ca.replace(/û/g, "%FB");
ca = ca.replace(/ü/g, "%FC");
ca = ca.replace(/É/g, "%C9");
ca = ca.replace(/È/g, "%C8");
ca = ca.replace(/Ê/g, "%CA");
ca = ca.replace(/Ë/g, "%CB");
ca = ca.replace(/Ç/g, "%C7");
ca = ca.replace(/À/g, "%C0");
ca = ca.replace(/Â/g, "%C2");
ca = ca.replace(/Ô/g, "%D4");
ca = ca.replace(/Î/g, "%CE");
ca = ca.replace(/Ï/g, "%CF");
ca = ca.replace(/Ù/g, "%D9");
ca = ca.replace(/Û/g, "%DB");
ca = ca.replace(/Ü/g, "%DC");
ca = ca.replace(/œ/g, "%9C");
ca = ca.replace(/Œ/g, "%8C");
ca = ca.replace(/«/g, "%AB");
ca = ca.replace(/»/g, "%BB");
ca = ca.replace(/’/g, "%92");
document.g.p.value=ca;
}