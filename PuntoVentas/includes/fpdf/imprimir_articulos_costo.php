<?php 


define('FPDF_FONTPATH','font/');
require_once('mysql_table.php');

include("comunes.php");

require "../sys/conexion.php";
$conn = new conexion();  

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

//Nombre del Listado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',16);
$pdf->SetY(20);
$pdf->SetX(0);
@$pdf->MultiCell(290,6,"Total Mercaderia en Stock a Precio Compra",0,C,0);

$pdf->Ln();    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


//Buscamos y listamos las familias

$sel_articulos="SELECT *
FROM articulos LEFT JOIN familias ON
articulos.codfamilia = familias.codfamilia WHERE articulos.borrado =0
ORDER  BY familias.codfamilia ASC , articulos.codarticulo ASC ";
$rs_articulos=$conn->consulta($sel_articulos);

$contador=0;
$item=1;
$valortotal=0;
$numero_articulos=$conn->num_rows($rs_articulos);
		if ($numero_articulos>0) {		
			$pdf->SetFont('Arial','',8);
			@$pdf->MultiCell(220,6,$row["nombre"],0,L,0);
			
			//Ttulos de las columnas
			$header=array('Item','Familia','Referencia','Descripcion','P. Costo','Stock','Total');
			
			//Colores, ancho de lnea y fuente en negrita
			$pdf->SetFillColor(200,200,200);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetLineWidth(.2);
			$pdf->SetFont('Arial','B',8);
				
			//Cabecera
			$w=array(10,40,30,65,15,15,20);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			while ($contador < $conn->num_rows($rs_articulos)) {
				$pdf->Cell($w[0],5,$item,'LRTB',0,'C');
				$pdf->Cell($w[1],5,mysql_result($rs_articulos,$contador,"nombre"),'LRTB',0,'C');
				$pdf->Cell($w[2],5,mysql_result($rs_articulos,$contador,"referencia"),'LRTB',0,'C');
				$pdf->Cell($w[3],5,mysql_result($rs_articulos,$contador,"descripcion_corta"),'LRTB',0,'L');
				$pdf->Cell($w[4],5,mysql_result($rs_articulos,$contador,"precio_compra"),'LRTB',0,'C');
				$pdf->Cell($w[5],5,mysql_result($rs_articulos,$contador,"stock"),'LRTB',0,'C');
				$stock1 = mysql_result($rs_articulos,$contador,"stock") ;
				if ( $stock1 > 0 ) { 
				$total=mysql_result($rs_articulos,$contador,"precio_compra") * mysql_result($rs_articulos,$contador,"stock");
				$pdf->Cell($w[6],5,number_format($total,2,",","."),'LRTB',0,'C');
				$valortotal=$valortotal+$total ;}
				$pdf->Ln();
				$item++;
				$contador++;
			}
		};

	$pdf->Ln(4);
 	$pdf->Cell(40);
	$pdf->Cell(80,4,"Total Mercaderia Almacen Contabilizada a Precio de Compra ",1,0,'C',1);
	$pdf->Ln(4);
	
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','',8);
	
	$pdf->Cell(160);
    $valortotal=number_format($valortotal,2,",",".");	
    $pdf->Cell(30,4,$valortotal." ",1,0,'R',1);
	$pdf->Ln(4);
			
$pdf->Output($name=("Listado Stock Almacen a Precio Costo.pdf"),'D');
?> 
