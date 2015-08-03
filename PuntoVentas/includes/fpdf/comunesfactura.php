<?php 

require_once ('fpdf.php') ; 

class PDF extends FPDF
{
//Cabecera de pagina
function Header()
{
    //Logo
    $this->Image('./logo/Factura v3.jpg',20,8,150);
    $this->Ln(5);	
}

//Pie de pgina
function Footer()
{
    $this->SetFont('Arial','',6);
	$this->SetY(-21);
	$this->Cell(0,10,'Sistemas ventas 2015 ',0,0,'C');
	$this->SetY(-12);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'',0,0,'C');	
}

}
?>