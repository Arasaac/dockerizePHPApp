// JavaScript Document
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
var hide  = true;
function showhide(obj,lyr)
{
	var x = new getObj(lyr);
	hide = !hide;
	x.style.visibility = (hide) ? 'hidden' : 'visible';
	setLyr(obj,lyr);
}

function setLyr(obj,lyr)
{
	var newX = findPosX(obj);
	var newY = findPosY(obj)+30; // should be same as the height of links2 in CSS file..default 30px;
	if (lyr == 'testP') newY -= 50;
	var x = new getObj(lyr);
	x.style.top = newY + 'px';
	x.style.left = newX + 'px';
}

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}


function getObj(name)
{
 if (document.getElementById)
 {
	   this.obj = document.getElementById(name);
	   this.style = document.getElementById(name).style;
 }
 else if (document.all)
 {
	   this.obj = document.all[name];
	   this.style = document.all[name].style;
 }
 else if (document.layers)
 {
	   if (document.layers[name])
	   {
	   	this.obj = document.layers[name];
	   	this.style = document.layers[name];
	   }
	   else
	   {
	    this.obj = document.layers.testP.layers[name];
	    this.style = document.layers.testP.layers[name];
	   }
 }
}