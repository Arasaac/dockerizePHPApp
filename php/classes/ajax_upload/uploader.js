var http = createRequestObject();
var uploader = '';

function createRequestObject() {
    var obj;
    var browser = navigator.appName;
    
    if(browser == "Microsoft Internet Explorer"){
        obj = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else{
        obj = new XMLHttpRequest();
    }
    return obj;    
}

function traceUpload(uploadDir) {
 		
   http.onreadystatechange = handleResponse;

   http.open("GET", 'inc/imageupload.php?uploadDir='+uploadDir+'&uploader='+uploader); 
   http.send(null);   
}

function handleResponse() {

	if(http.readyState == 4){
        document.getElementById(uploaderId).innerHTML = http.responseText;
		document.getElementById("nuevo_simbolo").innerHTML = '<img src="tmp/'+http.responseText+'" width="18" height="18" border="0" />';
		document.creador_simbolos.imagen.value = http.responseText;
        //window.location.reload(true);
    }
    else {
    	document.getElementById(uploaderId).innerHTML = "Subiendo el archivo. Espere por favor...";
    }
}

function uploadFile(obj) {
	var uploadDir = obj.value;
	uploaderId = 'uploader'+obj.name;
	uploader = obj.name;
	
	document.getElementById('formName'+obj.name).submit();
	traceUpload(uploadDir, obj.name);	
}