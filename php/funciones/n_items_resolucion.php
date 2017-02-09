<?php 
switch ($_SESSION['width']) {
				
		case 800:
		$cantidad=12;
		$cantidad_videos=10;
		break;
					
		case 1024:
		$cantidad=24;
		$cantidad_videos=10;
		break;
					
		case 1152:
		$cantidad=27;
		$cantidad_videos=11;
		break;
					
		case 1280:
		$cantidad=33;
		$cantidad_videos=11;
		break;
		
		case 1366:
		$cantidad=34;
		$cantidad_videos=12;
		break;	
		
		case 1440:
		$cantidad=36;
		$cantidad_videos=12;
		break;
					
		case 1600:
		$cantidad=39;
		$cantidad_videos=13;
		break;
					
		case 1680:
		$cantidad=42;
		$cantidad_videos=14;  
		break;
				
		default:
		$cantidad=25; 
		$cantidad_videos=12;
		break;
				
} 

?>