<?php 
require('fpdf.php');

class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;
//Columna actual
var $col=0;
//Ordenada de comienzo de la columna
var $y0;

function PDF($orientation='P',$unit='mm',$format='A4')
{
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}

function WriteHTML($html)
{
    //Intérprete de HTML
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Etiqueta
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extraer atributos
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{
    //Etiqueta de apertura
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    //Etiqueta de cierre
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}

function SetStyle($tag,$enable)
{
    //Modificar estilo y escoger la fuente correspondiente
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
    //Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

//Cargar los datos
function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
} 

//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

/* //Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(20,70,20);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'C');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'C');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
} */

//Una tabla más completa modificadas para ajustar la tabla al numero de columnas y aplicar estilo
function ImprovedTable($header,$data, $w, $e)
{
	 $this->SetFont('Arial','B',10);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
	 $this->SetFont('Arial','',9);
    //Datos
    foreach($data as $row)
    {
		$n=0;
		$nn=0;
        foreach($row as $col)
            $this->Cell($w[$n++],6,$col,1,0,$e[$nn++] );
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

function FancyTable($header,$data, $titulo)
{
	//Título
    $this->SetFont('Arial','B',9);
    $this->SetFillColor(203,200,208);
    $this->Cell(0,6,$titulo,0,1,'L',1);
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
	//Colores, ancho de línea y fuente en negrita
	$this->SetFillColor(124,117,138);
	$this->SetTextColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('Arial','B',9);
	//Cabecera
	$w=array(60,50,50);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauración de colores y fuentes
	$this->SetFillColor(203,200,208);
	$this->SetTextColor(0);
	$this->SetFont('Arial','',9);
	//Datos
	$fill=0;
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[2],'LR',0,'L',$fill);
		$this->Cell($w[2],6,$row[3],'LR',0,'L',$fill);
		$this->Ln();
		$fill=!$fill;
	}
	$this->Cell(array_sum($w),0,'','T');
}

function FancyTable2col($header,$data, $w, $titulo)
{
	//Título
    $this->SetFont('Arial','B',9);
    $this->SetFillColor(203,200,208);
    $this->Cell(0,6,$titulo,0,1,'L',1);
    $this->Ln(4);
    //Guardar ordenada
    $this->y0=$this->GetY();
	//Colores, ancho de línea y fuente en negrita
	$this->SetFillColor(124,117,138);
	$this->SetTextColor(255,255,255);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('Arial','B',8);
	//Cabecera
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	$this->Ln();
	//Restauración de colores y fuentes
	$this->SetFillColor(203,200,208);
	$this->SetTextColor(0);
	$this->SetFont('Arial','',9);
	//Datos
	$fill=0;
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[2],'LR',0,'L',$fill);
		$this->Ln();
		$fill=!$fill;
	}
	$this->Cell(array_sum($w),0,'','T');
}

function Header()
{
    //Cabacera
    global $title;
	
	//Logo
    $this->Image('admin/images/ryc.jpg',10,8,33);
	$this->Image('admin/images/dto_educacion.jpg',165,8,33);
	$this->Image('admin/images/catedu.jpg',50,8,10);
	//Arial bold 15
    $this->SetFont('Arial','B',15);
	$this->Ln(20);
  //Calculamos ancho y posición del título.
    $w=$this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    //Colores de los bordes, fondo y texto
    $this->SetDrawColor(176,172,185);
    $this->SetFillColor(203,200,208);
    $this->SetTextColor(0,0,0);

    $this->Cell($w,9,$title,1,1,'C',1);
	$this->Ln(10);
}

function Footer()
{
    //Pie de página
	//Posición: a 1,5 cm del final
    $this->SetY(-15);
	//Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
	//Número de página
    $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
}

function SetCol($col)
{
    //Establecer la posición de una columna dada
    $this->col=$col;
    $x=10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    //Método que acepta o no el salto automático de página
    if($this->col<2)
    {
        //Ir a la siguiente columna
        $this->SetCol($this->col+1);
        //Establecer la ordenada al principio
        $this->SetY($this->y0);
        //Seguir en esta página
        return false;
    }
    else
    {
        //Volver a la primera columna
        $this->SetCol(0);
        //Salto de página
        return true;
    }
}

function ChapterTitle($num,$label)
{
    //Título
    $this->SetFont('Arial','B',9);
    $this->SetFillColor(203,200,208);
    $this->Cell(0,6,"$num  $label",0,1,'L',1);
    $this->Ln(3);
    //Guardar ordenada
    $this->y0=$this->GetY();
}

function ChapterBody($file)
{
    $this->SetFont('Arial','',8);
    //Imprimimos el texto justificado
    $this->MultiCell(0,5,$file,'','J','');
    //Salto de línea
    $this->Ln();
}

function PrintChapter($num,$title,$file)
{
    //Añadir capítulo
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}
}
?>