var serie = "A";
var tra = new Array(6,29,60,94,117,146,166,175,186,194,200,204,208,210,211,213);
var cle = new Array(19968,20008,20022,20031,20057,20101,20108,20128,20154,20799,20837,20843,20866,20886,20907,20960,20981,20992,21147,21241,21269,21274,21304,21313,21340,21353,21378,21430,21448,21475,22231,22303,22763,22786,22794,22805,22823,22899,23376,23424,23544,23567,23586,23608,23662,23665,24027,24037,24049,24062,24178,24186,24191,24308,24318,24331,24339,24400,24417,24435,24515,25096,25142,25163,25903,25908,25991,26007,26020,26041,26080,26085,26352,26376,26408,27424,27490,27513,27571,27595,27604,
27611,27663,27668,27700,28779,29226,29238,29243,29247,29255,29273,29275,29356,29572,29577,29916,29926,29976,29983,29992,30000,30091,30098,30326,30333,30382,30399,30446,30683,30690,30707,31034,31160,31166,31348,31435,31481,31859,31992,32566,32593,32650,32701,32769,32780,32786,32819,32895,32905,33251,33258,33267,33276,33292,33307,33311,33390,33394,33400,34381,34411,34880,34892,34915,35198,35211,35282,35328,35895,35910,35925,35960,35997,36196,36208,36275,36523,36554,36763,36784,36789,37009,37193,37318,
37324,37329,38263,38272,38428,38582,38585,38632,38737,38750,38754,38761,38859,38893,38899,38913,39080,39131,39135,39318,39321,39340,39592,39640,39647,39717,39727,39730,39740,39770,40165,40565,40575,40613,40635,40643,40653,40657,40697,40701,40718,40723,40736,40763,40778,40786,40845,40860,40864,40870);
var py = new Array("1 - yī : un","2 - gǔn : ligne","3 - zhǔ : point","4 - piē : oblique","5 - yì : second","6 - jué : crochet","7 - èr : deux","8 - tóu : couvercle","9 - rén : homme","10 - rù : entrer","11 - rén : jambes","12 - bā : huit","13 - jiǒng : boîte","14 - mì : sur","15 - bīng : glace","16 -  jī : table","17 - qǔ : boîte ouverte à droite","18 - dāo : couteau","19 - lì : force","20 - bāo : envelopper","21 - bǐ : cuillère","22 - fāng : boîte ouverte (sur la droite)","23 - xǐ : enceinte cachée",
"24 - shí : dix","25 - bǔ : divination","26 - jié : sceau","27 - hàn : falaise","28 - sī : privé","29 - yòu : encore","30 - kǒu : bouche","31 - wéi : enclos","32 - tǔ : terre","33 - shì : érudit","34 - suī : aller","35 - zhi : aller lentement","36 - xì : soir","37 - dà : grand","38 - nǚ : femme","39 - zǐ : enfant","40 - mián : toit","41 - cùn : pouce (unité de longueur)","42 - xiǎo : petit","43 - wāng : estropier","44 - shī : corps","45 - chè : germer","46 - shān : montagne","47 - chuān : rivière",
"48 - gōng : travail","49 - jǐ : soi:même","50 - jīn : turban","51 - gān : sec","52 - yāo : fil court","53 - yǎn : falaise avec un point","54 - yǐn : grande enjambée","55 - gǒng : deux mains","56 - yì : tirer","57 - gōng : arc","58 - jì : museau","59 - shān : hérisser","60 - chì : pas","61 - xīn : cœur","62 - gē : hallebarde","63 - hù : porte","64 - shǒu : main","65 - zhī : branche","66 - pū : frapper","67 - wén : écriture","68 - dǒu : louche","69 - jīn : épée","70 - fāng : carré","71 - wú : sans",
"72 - rì : soleil","73 - yuē : dire","74 - yuè : lune","75 - mù : arbre","76 - qiàn : manquer de","77 - zhǐ : arrêter","78 - dǎi : mort","79 - shū : arme","80 - mú : ne pas","81 - bǐ : comparer","82 - máo : fourrure","83 - shì : clan","84 - qì : vapeur","85 - shuì : eau","86 - huǒ : feu","87 - zhǎo : griffe","88 - fù : père","89 - yáo : double","90 - qiáng : moitié de tronc d'arbre","91 - piàn : tranche","92 - yá : dent","93 - niú : vache","94 - quǎn : chien","95 - xuán : profond","96 - yù : jade",
"97 - guā : melon","98 - wǎ : tuile","99 - gān : doux","100 - shēng : vie","101 - yòng : utiliser","102 - tián : champs","103 - pǐ : fermeture d'un habit","104 - chuáng : maladie","105 - bò : tente à pointe","106 - bái : blanc","107 - pí : peau","108 - mǐn : récipient","109 - mù : œil","110 - máo : lance","111 - shǐ : arc","112 - shí : pierre","113 - shì : esprit","114 - rǒu : piste","115 - hé : grain","116 - xuè : cavité","117 - lì : debout","118 - zhú : bambou","119 - mǐ : riz","120 - mì : soie",
"121 - fǒu : jarre","122 - wǎng : fillet","123 - yáng : mouton","124 - yǔ : plume","125 - lǎo : vieux","126 - ér : et","127 - lěi : labourer","128 - ěr : oreille","129 - yù : pinceau","130 - ròu : viande","131 - chén : ministre","132 - zì : soi:même","133 - zhì : atteindre","134 - jiù : mortier","135 - shé : langue","136 - chuǎn : s'opposer","137 - zhōu : bâteau","138 - gèn : arrêt","139 - sè : couleur","140 - cǎo : herbe","141 - hū : tigre","142 - chóng : bestiole","143 - xuě : sang",
"144 - xíng : marcher, enclôt","145 - yī : habit","146 - yà : ouest","147 - jiàn : voir","148 - jué : corne","149 - yán : discours","150 - gǔ : vallée","151 - dòu : pois","152 - shǐ : cochon","153 - zhì : blaireau","154 - beì : coquillage","155 - chì : rouge","156 - zǒu : marcher","157 - zú : pied","158 - shēn : corps","159 - chē : carriole","160 - xīn : amer","161 - chén : matin","162 - chuò : marche","163 - yì : ville","164 - yǒu : vin","165 - biàn : distinguer","166 - lǐ : village","167 - jīn : or",
"168 - cháng : long","169 - mén : porte","170 - fù : butte","171 - dài : esclave","172 - zhuī : oiseau à la queue courte","173 - yǔ : pluie","174 - qīng : bleu","175 - fēi : faute","176 - miàn : face","177 - gé : cuir","178 - wéi : cuir tanné","179 - jiǔ : poireau","180 - yīn : son","181 - yè : feuille","182 - fēng : vent","183 - fēi : voler","184 - shí : manger","185 - shǒu : tête","186 - xiāng : parfum","187 - mǎ : cheval","188 - gǔ : os","189 - gāo : haut","190 - biāo : cheveux","191 - dòu : combat",
"192 - chàng : vin de sacrifice","193 - lì : chaudron","194 - guǐ : fantôme","195 - yú : poisson","196 - niǎo : oiseau","197 - lǔ : sel","198 - lù : daim","199 - mài : blé","200 - má : chanvre","201 - huáng : jaune","202 - shǔ : millet","203 - hēi : noir","204 - zhǐ : broderie","205 - mǐn : grenouille","206 - dǐng : tripode","207 - gǔ : tambour","208 - shǔ : rat","209 - bí : nez","210 - qǐ : régulier","211 - chǐ : dent","212 - lóng : dragon","213 - guī : tortue","214 - yuè : flûte");

function alpha(car) {
document.unicode.saisie.value+=car.name.substring(0,1);
document.all[serie].style.display = 'none';
document.all["B"].style.display = ''; 
var s=car.name.substring(0,1);
 code="";
 for(m=0;s.charAt(m);++m)if((c=s.charCodeAt(m))<128&&c!=38) code+=s.charAt(m); else if(c==38) code+="&amp;"; else code+="&#"+c+";";
 document.unicode.resultat.value+=code;
};

function beta(car) {
var txt ="";
serie="A"+car;
document.all["B"].style.display = 'none';
document.all["A"+car].style.display = '';
if (cle[car]>0) {
for (i=(cle[car]>0)?cle[car]:-cle[car],j=(cle[car+1]>0)?cle[car+1]:-cle[car+1];i<j;i++) 
txt+='<input type=button class=bt value="&#'+i+';"  name="&#'+i+';'+i+'*" onclick="alpha(this);document.unicode.saisie.focus();"> ';
cle[car]=-cle[car];
document.all["A"+car].innerHTML = txt; };
}

function copy()
{ textRange=document.unicode.saisie.createTextRange();   textRange.execCommand("Copy");   textRange="";
}
