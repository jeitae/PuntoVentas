<?php 

/*  
  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

  
	Autores version mexicana : 
	                           Matias Fertilio
	                           Ernesto Perez
				   
	Fecha Liberación del código: 20/04/2010
	CodeKa Mx 2010			 
	
	*/

define('FPDF_FONTPATH','font/');
require_once('fpdf.php') ; 
include("comunesfactura.php");
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php"); 
include ("Numbers/Words.php");


$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

// Cabecera

if ($fondofac=="SI")$pdf->Header('./logo/Factura v3.jpg',0,0,205,295);


$codfactura=$_GET["codfactura"];
  
$consulta = "Select * from facturas,clientes where facturas.codfactura='$codfactura' and facturas.codcliente=clientes.codcliente";
$resultado = $conn->consulta($consulta, $conexion);
$lafila=mysql_fetch_array($resultado);

    $fecha = implota($lafila["fecha"]);
	$dia1=substr($fecha,0,2);
	$mes1=substr($fecha,3,2);
	
	
	$mes1=mes($mes1);
	$ano1=substr($fecha,6,4);
	
	$pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(18,18,239);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','B',11);	
	
	$pdf->Ln(18);
	$pdf->Cell(20);
    $pdf->Cell(70,4,$lafila["nombre"],0,0,'L',0);
	$fecha = implota($lafila["fecha"]);
	$pdf->Cell(5);
	$pdf->Cell(12,4,$dia1,0,0,'L',0);
	$pdf->Cell(12,4,$mes1,0,0,'L',0);
	$pdf->Cell(10,4,$ano1,0,0,'L',0);
	
	
	$pdf->Ln(7);
	$pdf->Cell(20);
    $pdf->Cell(35,4,$lafila["nif"],0,0,'L',0);    
  //  $fecha = implota($lafila["fecha"]);
//	$pdf->Cell(60);
	//$pdf->Cell(10,4,$dia1,0,0,'L',0);
	//$pdf->Cell(10,4,$mes1,0,0,'L',0);
//	$pdf->Cell(15,4,$ano1,0,0,'L',0);
	
	
	//Calculamos la provincia
	$codigoprovincia=$lafila["codprovincia"];
	$consulta="select * from provincias where codprovincia='$codigoprovincia'";
	$query=$conn->consulta($consulta);
	$row=mysql_fetch_array($query);
	$pdf->Ln(7);
	$pdf->Cell(20);
	$pdf->Cell(80,4,$lafila["codpostal"] . " - " . $lafila["direccion"] . " - " . $row["nombreprovincia"],0,0,'L',0);
	
	$pdf->Cell(10);
	$pdf->Cell(10,4,$codfactura,0,0,'L',0);
	$pdf->Ln(14);	
	
	$pdf->Ln(7);
	$pdf->Cell(20);
    $pdf->Cell(40,4,$lafila["localidad"],0,0,'L',0);
			
    //ahora mostramos las lneas de la factura
	$pdf->SetY(60);			
	$consulta2 = "Select * from factulinea where codfactura='$codfactura' order by numlinea";
    $resultado2 = $conn->consulta($consulta2, $conexion);
    
	$contador=1;
	while ($row=mysql_fetch_array($resultado2))
	{
	  $pdf->Cell(20);
	  $contador++;
	  
	  $codarticulo=mysql_result($resultado2,$lineas,"codigo");
	  $codfamilia=mysql_result($resultado2,$lineas,"codfamilia");
	  
	  $cantidad1= number_format(mysql_result($resultado2,$lineas,"cantidad"),1,".",",");	  
	  $pdf->Cell(4,4,$cantidad1,0,0,'C');
	  
	  
	 // $pdf->Cell(4,4,mysql_result($resultado2,$lineas,"cantidad"),0,0,'C');	
	  	  
	  $sel_articulos="SELECT * FROM articulos WHERE codarticulo='$codarticulo' AND codfamilia='$codfamilia'";
	  $rs_articulos=$conn->consulta($sel_articulos);
	  	  
	  $acotado = substr(mysql_result($rs_articulos,0,"descripcion"), 0, 45);
	  $pdf->Cell(22,4,$acotado,0,0,'L');
	  	  
	  $precio2= number_format(mysql_result($resultado2,$lineas,"precio"),2,".",",");	  
	  $pdf->Cell(50,4,$precio2,0,0,'R');
	  
	  if (mysql_result($resultado2,$lineas,"dcto")==0) 
	  {
	  $pdf->Cell(18,4,"",0,0,'C');
	  } 
	  else 
	   { 
		$pdf->Cell(18,4,mysql_result($resultado2,$lineas,"dcto") . " %",0,0,'C');
	   }
	  
	  $importe2= number_format(mysql_result($resultado2,$lineas,"importe"),2,".",",");	  
	  
	  $pdf->Cell(15,4,$importe2,0,0,'R');
	  $pdf->Ln(7);	

	  //vamos acumulando el importe
	  $importe=$importe + mysql_result($resultado2,$lineas,"importe");
	  $contador=$contador + 1;
	  $lineas=$lineas + 1;	  
	};
	
	// Parametro global Cantidad de filas en el detalle
	while ($contador<$$GLOBALS['FilasDetalleFactura'])
	{
	  $pdf->Cell(1);
      $pdf->Cell(25,4,"",0,0,'C');
      $pdf->Ln(5);	
	  $contador=$contador +1;
	}
		  
	//Calculamos los valores del final de la factura
    $importe4=number_format($importe,2,".",",");	

	$ivai=$lafila["iva"];
	$impo=$importe*($ivai/100);
	$impo=sprintf("%01.2f", $impo); 
	$total=$importe+$impo; 
	$total=sprintf("%01.2f", $total);
	$impo=number_format($impo,2,".",",");	

    $total=sprintf("%01.2f", $total);
	$total2= number_format($total,2,".",",");	

	$pdf->SetY(125);	
	$pdf->Cell(98);
    $pdf->Cell(32,4,$importe4,0,0,'R',0);
	$pdf->Ln(5);

	$pdf->Cell(98);
	$pdf->Cell(1,4,$lafila["iva"] ." %",0,0,'R',0);
	$pdf->Cell(30,4,$impo,0,0,'R',0);	
	$pdf->Ln(5);
		
	$pdf->Cell(98);
	$pdf->Cell(32,4,$total2,0,0,'R',0);
	$pdf->Ln(5);
	
	//Calculamos de numero a palabras
	$nw = new Numbers_Words();
		
	$pdf->SetY(148);
	$pdf->Cell(15);
	
	//Modificamos esta parte para que también muestra la parte fraccionaria y Nuevos Soles.
	$decimales = explode(".",$total);	
	//$pdf->Cell(35,4,strtoupper($nw->toWords(round($total,0), "es") ." con ".$decimales[1]."/100 Nuevos Soles."),0,0,'L',0);
	$pdf->Cell(40,4,strtoupper($nw->toWords($decimales[0], "es") ." con ".$decimales[1]."/100 Nuevos Soles."),0,0,'L',0);
	
		
      @mysql_free_result($resultado); 
      @mysql_free_result($query);
	  @mysql_free_result($resultado2); 
	  @mysql_free_result($query3);
	  
      $pdf->Output($name=("Factura mexico pequeña.pdf"),'I');


?>