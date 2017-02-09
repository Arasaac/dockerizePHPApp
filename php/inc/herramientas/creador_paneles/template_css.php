	<style type="text/css">
	
    #dhtmlgoodies_dragDropContainer{	/* Main container for this script */
		width:100%;
		height:1320px;
		border:1px solid #CCCCCC;
		background-color:#FFF;
		-moz-user-select:none;
	}
	#dhtmlgoodies_dragDropContainer ul{	/* General rules for all <ul> */
		margin-top:0px;
		margin-left:0px;
		margin-bottom:0px;
		padding:2px;
	}
	
	#dhtmlgoodies_dragDropContainer li,#dragContent li,li#indicateDestination{	/* Movable items, i.e. <LI> */
		list-style-type:none;
		background-color:#FFF;
		padding:2px;
		margin-bottom:2px;
		cursor:pointer;
		font-size:0.9em;
		float:left;
	}

	li#indicateDestination{	/* Box indicating where content will be dropped - i.e. the one you use if you don't use arrow */
		border:1px solid #317082;	
		background-color:#FFF;
	}
		
	/* LEFT COLUMN CSS */
	div#dhtmlgoodies_listOfItems{	/* Left column "Available students" */
		
		float:left;
		padding-left:10px;
		padding-right:10px;
		
		/* CSS HACK */
		width: 220px;	/* IE 5.x */
		width/* */:/**/220px;	/* Other browsers */
		width: /**/220px;
		
		overflow:auto;
				
	}
	#dhtmlgoodies_listOfItems ul{	/* Left(Sources) column <ul> */
		max-height:560px;
		height: 350px;
		
			

	}
		
	div#dhtmlgoodies_listOfItems div{
		border:1px solid #999;		
	}
	div#dhtmlgoodies_listOfItems div ul{	/* Left column <ul> */
		margin-left:10px;	/* Space at the left of list - the arrow will be positioned there */
	}
	#dhtmlgoodies_listOfItems div p{	/* Heading above left column */
		margin:0px;	
		font-weight:bold;
		padding-left:12px;
		background-color:#317082;	
		color:#FFF;
		margin-bottom:5px;
	}
	/* END LEFT COLUMN CSS */
	
	#dhtmlgoodies_dragDropContainer .mouseover{	/* Mouse over effect DIV box in right column */
		background-color:#E2EBED;
		border:1px solid #317082;
	}
	
	/* Start main container CSS */
	
	div#dhtmlgoodies_mainContainer{	/* Right column DIV */
		width:<?php echo $panel_width; ?>px;
		<?php if ($borde_panel ==1) { echo 'border: '.$grosor_borde_panel.'px solid '.$color_borde_panel.';'; }?>
		float:left;	
		background-color:<?php echo $panel_color_fondo; ?>;
		
	}
	#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
		float:left;
		margin:<?php echo $espacio_entre_simbolos; ?>px;
		<?php if ($borde_simbolos ==1) { echo 'border: '.$grosor_borde_simbolos.'px solid '.$color_borde_simbolos.';'; } 
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>

		/* CSS HACK */
		width: <?php echo $simbolos_width+22; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $simbolos_width+20; ?>px;	/* Other browsers */
		width: /**/<?php echo $simbolos_width+20; ?>px;
		
		height: <?php echo $simbolos_width+20; ?>px;
		background-color:#FFFFFF;
				
	}
	
	#dhtmlgoodies_mainContainer #big{
		/* CSS HACK */
		width: <?php echo $principal_width+2; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $principal_width; ?>px;	/* Other browsers */
		width: /**/<?php echo $principal_width; ?>px;
		<?php if ($borde_simbolo_principal ==1) { echo 'border: '.$grosor_borde_simbolo_principal.'px solid '.$color_borde_simbolo_principal.';'; }
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>
		height: <?php echo $principal_width; ?>px;px;
		background-color:#FFFFFF;
	}
	
	
	#dhtmlgoodies_mainContainer div ul{
	margin-left:2px;
	margin-top: 2px;
	}
	
	#dhtmlgoodies_mainContainer div p{	/* Heading above small boxes */
		margin:0px;
		padding:0px;
		padding-left:12px;
		font-weight:bold;
		background-color:#317082;	
		color:#FFF;	
		margin-bottom:5px;
	}
	
	#dhtmlgoodies_mainContainer ul{	/* Small box in right column ,i.e <ul> */
/*		width:<?php //echo $simbolos_width; ?>px;
		height:<?php //echo $simbolos_width; ?>px;	
		border:0px;	
		margin-bottom:0px;
		overflow:hidden;*/
		
	}
	
	#dragContent{	/* Drag container */
		position:absolute;
		width:<?php echo $simbolos_width; ?>px;
		height:<?php echo $simbolos_width; ?>px;
		display:none;
		margin:0px;
		padding:0px;
		z-index:2000;
	}

	#dragDropIndicator{	/* DIV for the small arrow */
		position:absolute;
		width:7px;
		height:10px;
		display:none;
		z-index:1000;
		margin:0px;
		padding:0px;
	}

	</style>