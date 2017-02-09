<?php

include("dhtmlgoodies_tree.class.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
	<title>dhtmlgoodies tree</title>
	<style type="text/css">
	a{
		text-decoration:none;
		font-family:arial;
		font-size:0.8em;
	}
	</style>
</head>
<body>
<a href="#" onclick="expandAll();return false">Expand all nodes</a><br>
<a href="#" onclick="collapseAll();return false">Collapse all nodes</a><br>
<?

$tree = new dhtmlgoodies_tree();	// Creating new tree object

// Adding example nodes
$tree->addToArray(1,"America",0,"");
$tree->addToArray(2,"USA",1,"");
$tree->addToArray(3,"Alabama",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(4,"Alaska",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(5,"Arizona",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(6,"Arkansas",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(7,"California",2,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(8,"Colorado",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(9,"Connecticut",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(10,"Delaware",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(11,"Florida",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(12,"Georgia",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(13,"Illinois",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(14,"Indiana",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(15,"Iowa",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(16,"Kansas",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(17,"Kentucky",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(18,"Lousiana",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(19,"Main",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(20,"Maryland",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(21,"Massachusets",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(22,"Michigan",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(23,"Minneapolis",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(24,"Minesota",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(25,"Mississippi",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(26,"Missouri",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(27,"Montana",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(28,"Nebraska",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(29,"Nevada",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(30,"New Hampshire",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(31,"New Jersey",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(32,"New Mexico",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(33,"New York",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(34,"North Carolina",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(35,"North Dakota",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(36,"Ohio",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(37,"Oklahoma",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(38,"Oregon",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(39,"Pennsylvania",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(40,"Rhode Island",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(41,"South Carolina",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(42,"Tenessee",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(43,"Texas",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(44,"Utah",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(45,"Vermont",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(46,"Virginia",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(47,"Washington",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(48,"West Virginia",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(49,"Wiscounsin",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(50,"Wyoming",2,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(51,"Europe",0,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(52,"Norway",51,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(53,"Stavanger",52,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(54,"Oslo",52,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(55,"Bergen",52,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(56,"Trondheim",52,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(57,"Haugesund",52,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(58,"Sweeden",51,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(59,"Stockholm",58,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(60,"Denmark",51,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(61,"Copenhagen",60,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(62,"Aalborg",60,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(63,"France",51,"http://www.dhtmlgoodies.com","frmMain");
$tree->addToArray(64,"Paris",63,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(65,"Rennes",63,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(66,"Charlerois",63,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(67,"Bordeaux",63,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(68,"Toulouse",63,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(69,"Los Angeles",7,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");
$tree->addToArray(70,"San Fransisco",7,"http://www.dhtmlgoodies.com","frmMain","images/dhtmlgoodies_sheet.gif");







$tree->writeCSS();
$tree->writeJavascript();
$tree->drawTree();

?>
</body>
</html>
	
	