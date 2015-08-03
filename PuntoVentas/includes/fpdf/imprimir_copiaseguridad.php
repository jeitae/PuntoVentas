<?php 
require_once('fpdf.php');

define('FPDF_FONTPATH','font/');

include("comunes.php");
require "../sys/conexion.php";
$conn = new conexion();  
include ("../funciones/fechas.php"); 
include ("Numbers/Words.php");

//class PDF extends FPDF
//{
//Cabecera de página
//function Header()
//{
    //Logo
//    $this->Image('http://http://www.arayapereira.cl/Codekamxv16/fpdf/logo/codekamxlogo.jpeg',10,10,40,50,'jpeg');
    //Arial bold 15
 //   $this->SetFont('Arial','B',15);
    //Movernos a la derecha
 //   $this->Cell(80);
    //Título
 //   $this->Cell(30,10,'Copias de Seguridad',1,0,'C');
    //Salto de línea
 //  $this->Ln(20);
//}

//Pie de página
//function Footer()
//{
   
   //Posición: a 2,0 cm del final
 //   $this->SetY(-20);
 //   $this->SetFont('Arial','I',8);
//	$this->Cell(0,10,'Gestion ventas entorno Web CodeKa Mx version 1.6 - 2010',0,0,'C');
    
   
    //Posición: a 1,5 cm del final
 //  $this->SetY(-15);
    //Arial italic 8
 //   $this->SetFont('Arial','I',8);
	//Número de página
 //   $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
//}
//}

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

// Cabecera

$pdf->Header('./logo/logo.jpg',10,8,33,33);

//Nombre del Listado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',16);
$pdf->SetY(20);
$pdf->SetX(0);
$pdf->MultiCell(290,6,"Copias Archivos de Seguridad",0,C,0);

$pdf->Ln();    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


//Buscamos y listamos las familias

//$sel_articulos="select articulos.*,familias.nombre from articulos,familias where articulos.codfamilia=familias.codfamilia and articulos.borrado=0 order by familias.codfamilia asc, articulos.codarticulo asc";

//$sel_articulos="SELECT *
//FROM articulos LEFT JOIN familias ON
//articulos.codfamilia = familias.codfamilia WHERE articulos.borrado =0
//ORDER  BY familias.codfamilia ASC , articulos.codarticulo ASC ";
//$rs_articulos=$conn->consulta($sel_articulos);

$sel_articulos="SELECT * FROM tabbackup " ;
$rs_articulos=$conn->consulta($sel_articulos);






$contador=0;
$item=1;
$valortotal=0;
$numero_articulos=$conn->num_rows($rs_articulos);
		if ($numero_articulos>0) {		
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(220,6,$row["nombre"],0,L,0);
			
			//Ttulos de las columnas
//			$header=array('Item','Familia','Referencia','Descripcion','P. Almacen','Stock','Total');
            $header=array('ID','Numero Archivo Copia', 'Nombre Archivo ','Fecha','Hora','Archivo Base de Datos');			
			//Colores, ancho de lnea y fuente en negrita
			$pdf->SetFillColor(200,200,200);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetLineWidth(.2);
			$pdf->SetFont('Arial','B',8);
				
			//Cabecera
			$w=array(10,40,30,30,30,40);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			while ($contador < $conn->num_rows($rs_articulos)) {
				$pdf->Cell($w[0],5,$item,'LRTB',0,'C');
				$pdf->Cell($w[1],5,mysql_result($rs_articulos,$contador,"id"),'LRTB',0,'C');
				$pdf->Cell($w[2],5,mysql_result($rs_articulos,$contador,"denominacion"),'LRTB',0,'C');
				$pdf->Cell($w[3],5,mysql_result($rs_articulos,$contador,"fecha"),'LRTB',0,'C');
				$pdf->Cell($w[4],5,mysql_result($rs_articulos,$contador,"hora"),'LRTB',0,'C');
				$pdf->Cell($w[5],5,mysql_result($rs_articulos,$contador,"archivo"),'LRTB',0,'C');
//				$total=mysql_result($rs_articulos,$contador,"precio_almacen") * mysql_result($rs_articulos,$contador,"stock");
//				$pdf->Cell($w[6],5,number_format($total,2,",","."),'LRTB',0,'C');
//				$valortotal=$valortotal+$total;
				$pdf->Ln();
				$item++;
				$contador++;
			}
		};

	//$pdf->Ln(4);
 	//$pdf->Cell(160);
	//$pdf->Cell(30,4,"Total Almacen",1,0,'C',1);
	//$pdf->Ln(4);
	
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','',8);
	
//	$pdf->Cell(160);
 //   $valortotal=number_format($valortotal,2,",",".");	
  //  $pdf->Cell(30,4,$valortotal." Euros",1,0,'R',1);
	
	$pdf->Ln(4);
 
 
	
$pdf->Output($name=("ArchivosSeguridad.pdf"),'D');			
//$pdf->Output();
?> 