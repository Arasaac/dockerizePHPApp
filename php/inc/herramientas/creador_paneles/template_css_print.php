	<style type="text/css">
	
    #dhtmlgoodies_dragDropContainer{	/* Main container for this script */
		width:100%;
		height:700px;
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
	
	/* Start main container CSS */
	
	div#dhtmlgoodies_mainContainer{	/* Right column DIV */
		width:<?php echo $panel_width; ?>px;
		<?php if ($borde_panel ==1) { echo 'border: '.$grosor_borde_panel.'px solid '.$color_borde_panel.';'; }?>
		float:left;	
	}
	#dhtmlgoodies_mainContainer div{	/* Parent <div> of small boxes */
		float:left;
		margin:2px;
		<?php if ($borde_simbolos ==1) { echo 'border: '.$grosor_borde_simbolos.'px solid '.$color_borde_simbolos.';'; } 
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>

		/* CSS HACK */
		width: <?php echo $simbolos_width+22; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $simbolos_width+20; ?>px;	/* Other browsers */
		width: /**/<?php echo $simbolos_width+20; ?>px;
		
		height: <?php echo $simbolos_width+20; ?>px;
				
	}
	
	#dhtmlgoodies_mainContainer div li{
	float:left;
	margin-left:-30px;
	margin-top: -5px;
	
	}
	
	#dhtmlgoodies_mainContainer #big{
		/* CSS HACK */
		width: <?php echo $principal_width+2; ?>px;	/* IE 5.x */
		width/* */:/**/<?php echo $principal_width; ?>px;	/* Other browsers */
		width: /**/<?php echo $principal_width; ?>px;
		<?php if ($borde_simbolo_principal ==1) { echo 'border: '.$grosor_borde_simbolo_principal.'px solid '.$color_borde_simbolo_principal.';'; }
		else {  echo 'border: 1px dashed #CCCCCC;'; } ?>
		height: <?php echo $principal_width; ?>px;px;
	}
	
	#dhtmlgoodies_mainContainer #big li{
	
	float:left;
	margin-left:-42px;
	margin-top: -16px;
	
	}
	
	#dhtmlgoodies_mainContainer div ul{
		margin-left:2px;
		list-style:none;
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
	
	
	</style>