// Dynamic Image Resize
// Copyright 2004 Ash Young (ash@evoluted.net)
// Website: http://evoluted.net/

var doResize = false;
var dragType = 0; //which way are we dragging? 0=not, 1=diag, 2=horz,3=vert
var imageX,imageY;  //current dimensions of image
var prevX,prevY;//previous x and y coords
var curY,curX;//current x and y coords
var origX,origY;//starting image width and height
var highX,highY;//high def x and y coords - to enable resize to maintain aspect
var newX,newY;//use for calcing new image size
var constrain=true;//keep width and height proportional
var xyRatio, yxRatio; //used to keep proportions
//this resizes the image dynamically
function resize() {
	if(doResize) {
	//need to make it stop at 1px by 1px
		curX = window.event.x;
		curY = window.event.y;
		newX = imageX + (curX-prevX);
		newY = imageY + (curY-prevY);

		if(dragType==1) {
			if(constrain) {newY = newX * yxRatio;}
		}
		else if(dragType==2) {			
			if(constrain) {newY = newX * yxRatio;}
			else { newY = imageY; }
		}
		else if(dragType==3) {
			if(constrain) {newX = newY * xyRatio;}
			else {newX = highX; }
		}
		if(newX<1) { newX=1;}
		if(newY<1) { newY=1;}
		document.getElementById('p').width = newX;
		document.getElementById('p').height = newY;
		update();
	}
	else {
		doPointer(window.event);
	}
	prevX = window.event.x;
	prevY = window.event.y;
}

//this tells the script to listen to the movement
function start() {
	document.getElementById('holder').style.padding="0px 150px 150px 0px";
	doResize = true;
}

//this stops the script listening to mousemovement
function end() {
	document.getElementById('holder').style.padding="0px 5px 5px 0px";
	doResize = false;
}

//sets the pointer based on the current state
function doPointer(e) {
  //IF WE NEED A NEW CURSOR WORK OUT WHAT IT IS
  if(!doResize) { 
	  var x = e.x;
	  var y = e.y;
	  if(x>(imageX-5)&&y>(imageY-5)) {dragType = 1;}
	  else if(x>(imageX-5)) {dragType = 2;}  
	  else if(y>(imageY-5)) {dragType = 3;}
	  else {dragType = 0;}
  }
  
  //SET THE CURSOR
  if(dragType==1) {document.getElementById('holder').style.cursor='nw-resize';}
  else if(dragType==2) {document.getElementById('holder').style.cursor='w-resize';}  
  else if(dragType==3) {document.getElementById('holder').style.cursor='n-resize';}
  else {document.getElementById('holder').style.cursor='default'; }
}

//set up the program
function init() {
	document.getElementById('holder').onmousedown=start;
	document.getElementById('holder').onmouseup=end;
	document.getElementById('holder').onmousemove=resize;
	update();
	origX = imageX;
	origY = imageY;
	highX = imageX;
	highY = imageY;
	xyRatio = imageX/imageY;
	yxRatio = imageY/imageX;
	
}

//sets internal numbers
function update() {
	highX=newX;
	highY=newY;
	imageX=document.getElementById('p').width;
	imageY=document.getElementById('p').height;
	document.details.frm_width.value=imageX;
	document.details.frm_height.value=imageY;
	document.getElementById('holder').style.width=imageX;
	document.getElementById('holder').style.height=imageY;
}

//set the image details from what is contained in teh form
function updateFF(x) {

	if(constrain) {
		if(x == "w") {
			imageX=document.details.frm_width.value.replace(/\D+/gi, "");
			imageY = imageX * yxRatio;
		}
		else {
			imageY=document.details.frm_height.value.replace(/\D+/gi, "");
			imageX = imageY * xyRatio;
		}
	}
	else {
		imageX=document.details.frm_width.value.replace(/\D+/gi, "");
		imageY=document.details.frm_height.value.replace(/\D+/gi, "");
	}
	if(imageY<1) { imageY=1; }
	if(imageX<1) { imageX=1; }
	document.getElementById('p').width=imageX;
	document.getElementById('p').height=imageY;
	document.details.frm_width.value=Math.round(imageX);
	document.details.frm_height.value=Math.round(imageY);
	highX = imageX;
	highY = imageY;
	document.getElementById('holder').style.width=imageX;
	document.getElementById('holder').style.height=imageY;
}

//resets to original values
function origvals()  {
	imageX=origX;
	imageY=origY;
	document.getElementById('p').width=imageX;
	document.getElementById('p').height=imageY;
	document.details.frm_width.value=imageX;
	document.details.frm_height.value=imageY;	
	document.getElementById('holder').style.width=imageX;
	document.getElementById('holder').style.height=imageY;
}

//set constrain true/false
function toggleConstrain() {
	if(constrain) {
		constrain = false;
	}
	else {
		xyRatio = imageX/imageY;
		yxRatio = imageY/imageX;
		constrain = true;
	}
}