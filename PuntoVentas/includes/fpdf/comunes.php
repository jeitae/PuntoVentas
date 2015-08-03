<?php 

require_once ('fpdf.php') ; 

class PDF extends FPDF
{
//Cabecera de pagina
function Header()
{
    //Logo
    $this->Image('./logo/logo.jpg',5,3,25,15);
    $this->Ln(5);	
}

//Pie de pgina
function Footer()
{
    $this->SetFont('Arial','',6);
	$this->SetY(-21);
	$this->Cell(0,10,'Sistema de Ventas 2015 ',0,0,'C');
	$this->SetY(-12);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'',0,0,'C');	
}

}
?>