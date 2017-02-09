<?php 
include ("../classes/graficas/jpgraph/jpgraph.php");
include ("../classes/graficas/jpgraph/jpgraph_pie.php");
include ("../classes/graficas/jpgraph/jpgraph_bar.php");
include ("../classes/graficas/jpgraph/jpgraph_line.php");
include ("../classes/graficas/jpgraph/jpgraph_log.php");
include ("../classes/graficas/jpgraph/jpgraph_pie3d.php");

function accumulated_bar_plots($data1y, $data2y, $f_graph, $f_graph_p, $titulo, $X_titulo, $Y_titulo, $ancho, $alto) 
{
	// Create the graph. These two calls are always required
	$graph = new Graph($ancho,$alto,$f_graph, 60); 
	$graph->SetScale("textlin");
	
	$graph->SetShadow();
	$graph->img->SetMargin(40,30,20,40);
	
	// Create the bar plots
	$b1plot = new BarPlot($data1y);
	$b1plot->SetFillColor("orange");
	$b1plot->value->Show();
	$b2plot = new BarPlot($data2y);
	$b2plot->SetFillColor("blue");
	$b2plot->value->Show();
	
	// Create the grouped bar plot
	$gbplot = new AccBarPlot(array($b1plot,$b2plot));
	
	// ...and add it to the graPH
	$graph->Add($gbplot);
	
	$graph->title->Set($titulo);
	$graph->xaxis->title->Set($X_titulo);
	$graph->yaxis->title->Set($Y_titulo);
	
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	
	// Display the graph
	$graph->Stroke($f_graph_p);
}

function tarta_separada($data, $f_graph, $f_graph_p, $titulo, $ancho, $alto, $leyenda) 
{
	// A new pie graph
	$graph = new PieGraph($ancho,$alto,$f_graph, 60);
	$graph->SetShadow();
	
	// Title setup
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	
	// Setup the pie plot
	$p1 = new PiePlot($data);
	
	// Adjust size and position of plot
	$p1->SetSize(0.35);
	$p1->SetCenter(0.5,0.52);
	
	// Setup slice labels and move them into the plot
	$p1->value->SetFont(FF_FONT1,FS_BOLD);
	$p1->value->SetColor("darkred");
	$p1->SetLabelPos(0.65);
	
	// Explode all slices
	$p1->ExplodeAll(10);
	
	// Add drop shadow
	$p1->SetShadow();
	$p1->SetLegends($leyenda);
	
	// Finally add the plot
	$graph->Add($p1);
	
	// ... and stroke it
	$graph->Stroke($f_graph_p);
}

function barras_dos_escalas($datazero, $datay, $datay2, $f_graph, $f_graph_p, $titulo, $ancho, $alto, $leyenda1, $leyenda2) 
{
	// Create the graph. 
	$graph = new Graph($ancho,$alto);
	$graph->title->Set($titulo);
	
	// Setup Y and Y2 scales with some "grace"	
	$graph->SetScale("textlin");
	$graph->SetY2Scale("lin");
	$graph->yaxis->scale->SetGrace(30);
	$graph->y2axis->scale->SetGrace(30);
	
	//$graph->ygrid->Show(true,true);
	$graph->ygrid->SetColor('gray','lightgray@0.5');
	
	// Setup graph colors
	$graph->SetMarginColor('white');
	$graph->y2axis->SetColor('darkred');
	
	
	// Create the "dummy" 0 bplot
	$bplotzero = new BarPlot($datazero);
	
	// Create the "Y" axis group
	$ybplot1 = new BarPlot($datay);
	$ybplot1->SetLegend($leyenda1);
	$ybplot1->value->Show();
	$ybplot = new GroupBarPlot(array($ybplot1,$bplotzero));
	
	// Create the "Y2" axis group
	$ybplot2 = new BarPlot($datay2);
	$ybplot2->SetLegend($leyenda2);
	$ybplot2->value->Show();
	$ybplot2->value->SetColor('darkred');
	$ybplot2->SetFillColor('darkred');
	$y2bplot = new GroupBarPlot(array($bplotzero,$ybplot2));
	
	// Add the grouped bar plots to the graph
	$graph->Add($ybplot);
	$graph->AddY2($y2bplot);
	
	// .. and finally stroke the image back to browser
	$graph->Stroke($f_graph_p);
}

// LINEA DE PUNTOS UNIDOS POR LINEA PARA VALORES NUMERICO Y TEXTO
function linea_puntos1($f_graph_p, $labels, $datay, $titulo, $ancho, $alto, $fuente1, $fuente2, $Y_titulo) 
{
		$graph = new Graph($ancho,$alto,"auto");
		$graph->img->SetMargin(40,40,40,80);	
		$graph->img->SetAntiAliasing();
		$graph->SetScale("textlin");
		$graph->SetShadow();
		$graph->title->Set($titulo);
		$graph->title->SetFont(FF_VERDANA,FS_NORMAL,$fuente1);
		
		$graph->yaxis->title->Set($Y_titulo);
		
		$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,$fuente2);
		$graph->xaxis->SetTickLabels($labels);
		$graph->xaxis->SetLabelAngle(45);
		
		
		$p1 = new LinePlot($datay);
		$p1->mark->SetType(MARK_FILLEDCIRCLE);
		$p1->mark->SetFillColor("red");
		$p1->mark->SetWidth(4);
		$p1->SetColor("blue");
		$p1->SetCenter();
		$p1->value->Show();
		$graph->Add($p1);
		
		$graph->Stroke($f_graph_p);
}

// LINEA DE PUNTOS RELLENA SOLO PARA VALORES NUMERICOS EN LA ESCALA X E Y
function linea_puntos2($f_graph_p, $datax, $datay, $titulo, $ancho, $alto, $fuente1, $fuente2, $escalax, $X_titulo, $Y_titulo) 
{
	// Setup the basic graph
	$graph = new Graph($ancho,$alto);
	$graph->SetMargin(40,40,30,70);	
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_VERDANA,FS_NORMAL,$fuente1);
	$graph->SetAlphaBlending();
	
	$graph->SetScale("intlin",0,$escalax);
	//$graph->SetScale("textlin");
	
	$graph->yaxis->title->Set($Y_titulo);
	
	$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,$fuente2);
	$graph->xaxis->title->Set($X_titulo);
	$graph->xaxis->SetLabelAngle(45);
	
	// Create the line
	$p1 = new LinePlot($datay,$datax);
	$p1->SetColor("blue");
	
	// Set the fill color partly transparent
	$p1->SetFillColor("blue@0.4");
	
	// Add lineplot to the graph
	$graph->Add($p1);
	
	// Output line
	$graph->Stroke($f_graph_p);
}

function plot_dos_lineas($f_graph_p, $titulo, $ancho, $alto, $X_titulo, $Y_titulo, $ydata, $y2data, $datax, $titulo_plot1, $titulo_plot2, $escala_Y) 
{
		$graph = new Graph($ancho,$alto,"auto");	
		$graph->img->SetMargin(40,110,20,40);
		$graph->SetScale("lin",0,$escala_Y);
		$graph->SetY2Scale("lin",0,$escala_Y);
		$graph->SetShadow();
		
		$graph->ygrid->Show(true,true);
		$graph->xgrid->Show(true,false);
		
		// Create the linear plot
		$lineplot=new LinePlot($ydata);
		$lineplot2=new LinePlot($y2data);
		
		$graph->yaxis->scale->ticks->SupressFirst();
		$graph->y2axis->scale->ticks->SupressFirst();
		// Add the plot to the graph
		$graph->Add($lineplot);
		$graph->AddY2($lineplot2);
		$lineplot2->SetColor("orange");
		$lineplot2->SetWeight(2);
		$graph->y2axis->SetColor("orange");
		
		$graph->title->Set($titulo);
		$graph->xaxis->title->Set($X_titulo);
		$graph->yaxis->title->Set($Y_titulo);
		
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		
		$lineplot->SetColor("blue");
		$lineplot->SetWeight(2);
		
		$lineplot2->SetColor("orange");
		$lineplot2->SetWeight(2);
		
		$graph->yaxis->SetColor("blue");
		
		$lineplot->SetLegend($titulo_plot1);
		$lineplot2->SetLegend($titulo_plot2);
		
		$graph->legend->Pos(0.05,0.5,"right","center");
		
		$graph->xaxis->SetTickLabels($datax);
		//$graph->xaxis->SetTextTickInterval(2);
		
		// Display the graph
		$graph->Stroke($f_graph_p);
}

function barras_tridimensionales($f_graph_p, $titulo, $ancho, $alto, $X_titulo, $Y_titulo, $ydata, $color_barras) 
{
// Create the graph. These two calls are always required
$graph = new Graph($ancho,$alto,"auto");	
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(20);

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($ydata);

// Adjust fill color
$bplot->SetFillColor($color_barras);
$bplot->SetShadow();
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_BOLD,10);
$bplot->value->SetAngle(45);
$bplot->value->SetFormat('%0.1f');
$graph->Add($bplot);

// Setup the titles
$graph->title->Set($titulo);
$graph->xaxis->title->Set($X_titulo);
$graph->yaxis->title->Set($Y_titulo);

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke($f_graph_p);
}

function tarta_tridimensional($f_graph_p, $titulo, $ancho, $alto, $data, $leyenda) 
{
	$graph = new PieGraph($ancho,$alto,"auto");
	$graph->SetShadow();
	
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	
	$p1 = new PiePlot3D($data);
	//$p1->ExplodeSlice(1); // PARA EXPLOTAR UN PEDAZO DE LA TARTA
	$p1->ExplodeAll(15); // EXPLOTA TODOS LOS PEDAZOS CON UNA SEPARACION DE 15
	$p1->SetCenter(0.45);
	$p1->SetShadow();
	$p1->SetLegends($leyenda);
	
	$graph->Add($p1);
	$graph->Stroke($f_graph_p);
}

function barras_horizontales($f_graph_p, $titulo, $subtitulo, $fuente_titulo, $fuente_subtitulo, $fuente_Y, $fuente_barras, $ancho, $color_barras, $alto, $datax, $datay) 
{
	// Set the basic parameters of the graph 
	$graph = new Graph($ancho,$alto,'auto');
	$graph->SetScale("textlin");

	$graph->Set90AndMargin(50,20,50,30);
	
	// Nice shadow
	$graph->SetShadow();
	
	// Setup title
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_VERDANA,FS_BOLD,$fuente_titulo);
	$graph->subtitle->Set($subtitulo);
	
	// Setup X-axis
	$graph->xaxis->SetTickLabels($datax);
	$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,$fuente_subtitulo);
	
	// Some extra margin looks nicer
	$graph->xaxis->SetLabelMargin(5);
	
	// Label align for X-axis
	$graph->xaxis->SetLabelAlign('right','center');
	
	// Add some grace to y-axis so the bars doesn't go
	// all the way to the end of the plot area
	$graph->yaxis->scale->SetGrace(20);
	$graph->yaxis->SetLabelAlign('center','bottom');
	$graph->yaxis->SetLabelAngle(45);
	$graph->yaxis->SetLabelFormat('%d');
	$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,$fuente_Y);
	
	// We don't want to display Y-axis
	//$graph->yaxis->Hide();
	
	// Now create a bar pot
	$bplot = new BarPlot($datay);
	$bplot->SetFillColor($color_barras);
	$bplot->SetShadow();
	
	//You can change the width of the bars if you like
	//$bplot->SetWidth(0.5);
	
	// We want to display the value of each bar at the top
	$bplot->value->Show();
	$bplot->value->SetFont(FF_ARIAL,FS_BOLD,$fuente_barras);
	$bplot->value->SetAlign('left','center');
	$bplot->value->SetColor("black","darkred");
	//$bplot->value->SetFormat('%.1f mkr');
	
	// Add the bar to the graph
	$graph->Add($bplot);
	
	
	$graph->Stroke($f_graph_p);
}

function tarta_desglosada($f_graph_p, $titulo, $subtitulo, $fuente_titulo, $fuente_subtitulo, $fuente_barras, $ancho, $alto, $data, $lbl) 
{
	// A new pie graph
	$graph = new PieGraph($ancho,$alto,'auto');
	
	// Don't display the border
	$graph->SetFrame(false);
	
	// Uncomment this line to add a drop shadow to the border
	// $graph->SetShadow();
	
	// Setup title
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_COMIC,FS_BOLD,$fuente_titulo);
	$graph->title->SetMargin(8); // Add a little bit more margin from the top
	
	// Create the pie plot
	$p1 = new PiePlotC($data);
	
	// Set size of pie
	$p1->SetSize(0.35);
	
	// Label font and color setup
	$p1->value->SetFont(FF_ARIAL,FS_BOLD,$fuente_barras);
	$p1->value->SetColor('white');
	
	$p1->value->Show();
	
	// Setup the title on the center circle
	$p1->midtitle->Set($subtitulo);
	$p1->midtitle->SetFont(FF_COMIC,FS_NORMAL,$fuente_subtitulo);
	
	// Set color for mid circle
	$p1->SetMidColor('yellow');
	
	// Use percentage values in the legends values (This is also the default)
	$p1->SetLabelType(PIE_VALUE_PER);
	
	$p1->SetLabels($lbl);
	
	// Uncomment this line to remove the borders around the slices
	// $p1->ShowBorder(false);
	
	// Add drop shadow to slices
	$p1->SetShadow();
	
	// Explode all slices 15 pixels
	$p1->ExplodeAll(15);
	
	// Add plot to pie graph
	$graph->Add($p1);
	
	// .. and send the image on it's marry way to the browser
	$graph->Stroke($f_graph_p);
}

function barras_3D($f_graph_p, $ancho, $alto, $titulo_pestana, $fuente_pestana, $x_etiqueta, $x_fuente, $ydata, $ydata2, $leyenda_plot1, $leyenda_plot2) 
{
	// Create the graph. 
	$graph = new Graph($ancho, $alto);	
	$graph->SetScale("textlin");
	$graph->SetMarginColor('white');
	
	// Adjust the margin slightly so that we use the 
	// entire area (since we don't use a frame)
	$graph->SetMargin(30,1,20,5);
	
	// Box around plotarea
	$graph->SetBox(); 
	
	// No frame around the image
	$graph->SetFrame(false);
	
	// Setup the tab title
	$graph->tabtitle->Set($titulo_pestana);
	$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,$fuente_pestana);
	
	// Setup the X and Y grid
	$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
	$graph->ygrid->SetLineStyle('dashed');
	$graph->ygrid->SetColor('gray');
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle('dashed');
	$graph->xgrid->SetColor('gray');
	
	// Setup month as labels on the X-axis
	$graph->xaxis->SetTickLabels($x_etiqueta);
	$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,$x_fuente);
	$graph->xaxis->SetLabelAngle(45);
	
	// Create a bar pot
	$bplot = new BarPlot($ydata);
	$bplot->SetWidth(0.6);
	$bplot->SetLegend($leyenda_plot1);
	$fcol='#440000';
	$tcol='#FF9090';
	
	$bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);
	
	// Set line weigth to 0 so that there are no border
	// around each bar
	$bplot->SetWeight(0);
	
	$graph->Add($bplot);
	
	// Create filled line plot
	$lplot = new LinePlot($ydata2);
	$lplot->SetLegend($leyenda_plot2);
	$lplot->SetFillColor('skyblue@0.5');
	$lplot->SetColor('navy@0.7');
	$lplot->SetBarCenter();
	
	$lplot->mark->SetType(MARK_SQUARE);
	$lplot->mark->SetColor('blue@0.5');
	$lplot->mark->SetFillColor('lightblue');
	$lplot->mark->SetSize(6);
	
	$graph->Add($lplot);
	
	// .. and finally send it back to the browser
	$graph->Stroke($f_graph_p);
}

function barra_3d_simples($f_graph_p,$ydata,$ancho,$alto,$leyenda) {

// Get a list of month using the current locale
$months = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

// Create the graph. 
$graph = new Graph($ancho,$alto);	
$graph->SetScale("textlin");
$graph->SetMarginColor('white');

// Adjust the margin slightly so that we use the 
// entire area (since we don't use a frame)
$graph->SetMargin(30,1,20,5);

// Box around plotarea
$graph->SetBox(); 

// No frame around the image
$graph->SetFrame(false);

// Setup the tab title
$graph->tabtitle->Set($leyenda);
$graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,10);

// Setup the X and Y grid
$graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
$graph->ygrid->SetLineStyle('dashed');
$graph->ygrid->SetColor('gray');
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle('dashed');
$graph->xgrid->SetColor('gray');

// Setup month as labels on the X-axis
$graph->xaxis->SetTickLabels($months);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->xaxis->SetLabelAngle(45);

// Create a bar pot
$bplot = new BarPlot($ydata);
$bplot->SetWidth(0.6);
$fcol='#440000';
$tcol='#FF9090';

$bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);

// Set line weigth to 0 so that there are no border
// around each bar
$bplot->SetWeight(0);
$bplot->value->Show();

$graph->Add($bplot);


// .. and finally send it back to the browser
$graph->Stroke($f_graph_p);

}
?>