<?php 
include ("../../../classes/query_class.php");

$query=new query();
$canales=$query->listar_canales_podcast($_GET['id_blog']);


?>
<html>

<head>
  <title>Insertar Podcast</title>

<script type="text/javascript" src="popup.js"></script>

<script type="text/javascript">

window.resizeTo(400, 100);

function Init() {
  __dlg_init();
  document.getElementById("f_rows").focus();
};

function onOK() {
  var required = {
    "f_rows": "You must enter a number of rows"
  };
  for (var i in required) {
    var el = document.getElementById(i);
    if (!el.value) {
      alert(required[i]);
      el.focus();
      return false;
    }
  }
  var fields = ["f_rows"];
  var param = new Object();
  for (var i in fields) {
    var id = fields[i];
    var el = document.getElementById(id);
    param[id] = el.value;
  }
  __dlg_close(param);
  return false;
};

function onCancel() {
  __dlg_close(null);
  return false;
};

</script>
    <script type="text/javascript">
	/**
	 * Permet d'envoyer des données en GET ou POST en utilisant les XmlHttpRequest
	 */
	function sendData(param, page)
	{
		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		//définition de l'endroit d'affichage:
		var content = document.getElementById("contenu");
		
		XhrObj.open("POST", page);

		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param);
	}//fin fonction SendData

	function sendDataitem(param, page)
	{
		if(document.all)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}//fin if
		else
		{
		    //Mozilla
			var XhrObj = new XMLHttpRequest();
		}//fin else

		//définition de l'endroit d'affichage:
		var content = document.getElementById("reproductor");
		
		XhrObj.open("POST", page);

		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText ;
		}

		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(param);
	}//fin fonction SendData
    </script>
<style type="text/css">
html, body {
  background: ButtonFace;
  color: ButtonText;
  font: 11px Tahoma,Verdana,sans-serif;
  margin: 0px;
  padding: 0px;
}
body { padding: 5px; }
table {
  font: 11px Tahoma,Verdana,sans-serif;
}
form p {
  margin-top: 5px;
  margin-bottom: 5px;
}
.fl { width: 9em; float: left; padding: 2px 5px; text-align: right; }
.fr { width: 7em; float: left; padding: 2px 5px; text-align: right; }
fieldset { padding: 0px 10px 5px 5px; }
select, input, button { font: 11px Tahoma,Verdana,sans-serif; }
button { width: 70px; }
.space { padding: 2px; }

.title { background: #ddf; color: #000; font-weight: bold; font-size: 120%; padding: 3px 10px; margin-bottom: 10px;
border-bottom: 1px solid black; letter-spacing: 2px;
}
form { padding: 0px; margin: 0px; }
</style>

</head>

<body onLoad="Init()">

<div class="title">Insertar Podcast </div>
<form action="" method="get">
 <fieldset style="float:center; margin-right: 5px; height:150px; width:380px;"><legend>Seleccionar Podcast</legend>

<div class="space"></div>
 <p align="center"><select size="1" name="cat" OnChange="sendData('id='+this.value,'items_canales.php?id_blog=<?php echo $_GET['id_blog'] ?>&')" onKeyUp="sendData('id='+this.value,'items_canales.php?id_blog=<?php echo $_GET['id_blog'] ?>&')">
      <option value="0" selected>Seleccione un canal</option>
	
      <?php     
   while ($dt=mysql_fetch_array($canales))
   {
    // Remplir la liste d&eacute;roulante des cat&eacute;gorie	
	echo "<option value=".$dt['id_channel'].">".$dt['title']."</option>";
   }
    
   ?>
  </select>
</p>
<div id="contenu" align="center">
 <?php  
  // affichage des sous-catégorie appartenant à la première catégorie.
   echo "<select size='1' name='souscat'>";   
    while ($dt=mysql_fetch_row($result))
    { 
	 echo "<option value=".utf8_encode($dt[0]).">".utf8_encode($dt[2])."</option><br>";
    }    
	echo "</select>";
   ?>   
  </div>
<div id="reproductor"></div>
<p />
 </fieldset>

<div style="margin-top: 5px; border-top: 1px solid #999; padding: 2px; text-align: right;">
<button type="button" name="ok" onClick="return onOK();">OK</button>
<button type="button" name="cancel" onClick="return onCancel();">Cancelar</button>
</div>

</form>

</body>
</html>
