<?php 
session_start();

if (!isset($_SESSION['user']))
{
 die ("Access Denied");
}
?>

<?php 

/*  
  
    Francisco Terrones Ramos		 
	
	*/

define('FPDF_FONTPATH','font/');
require_once ('fpdf.php') ; 
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
	
	// El mes sale como numero 
	$mes1=substr($fecha,3,2);
	
	// si se activa este comando el mes sale con letras
	//$mes1=mes($mes1);
	

	$ano1=substr($fecha,6,4);
	
	$pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('courier','B',7);	
	
	$pdf->Ln(38); //el primer bloque empieza en la linea 18
	$pdf->Cell(20); //izq derch 
    $pdf->Cell(70,4,$lafila["nombre"],0,0,'L',1);
	$fecha = implota($lafila["fecha"]);
	$pdf->Cell(10); //izquierda y derecha de fecha
	//Definiendo el ancho de 12 para cada celda en mi caso 4 y que esten sobre la liena 4
	$pdf->Cell(4,4,$dia1,0,0,'L',1);
	$pdf->Cell(4,4,$mes1,0,0,'L',1);
	$pdf->Cell(4,4,$ano1,0,0,'L',1);
	
	
	$pdf->Ln(3); //es el salto para la siguiente linea a mas cantidad mas ancho la division
	$pdf->Cell(20);
    $pdf->Cell(20,4,$lafila["nif"],0,0,'L',1);    
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
	$pdf->Ln(2);
	$pdf->Cell(20);
	//$pdf->Cell(80,4,$lafila["codpostal"] . " - " . $lafila["direccion"] . " - " . $row["nombreprovincia"],0,0,'L',0);
	$pdf->Cell(80,4,$lafila["direccion"] . " - " . $row["nombreprovincia"],0,0,'L',0);
	
	$pdf->Cell(10);
	$pdf->Cell(10,4,$codfactura,0,0,'L',0);
	//$pdf->Ln(14);	
	
	$pdf->Ln(2);
	$pdf->Cell(20);
    $pdf->Cell(40,4,$lafila["localidad"],0,0,'L',0);
			
    //ahora mostramos las lneas de la factura  aqui esta el bloque de articulos
	$pdf->SetY(70);			
	$consulta2 = "Select * from factulinea where codfactura='$codfactura' order by numlinea";
    $resultado2 = $conn->consulta($consulta2, $conexion);
    
	$contador=1;
	while ($row=mysql_fetch_array($resultado2))
	{
	  $pdf->Cell(15);
	  $contador++;
	  
	  $codarticulo=mysql_result($resultado2,$lineas,"codigo");
	  $codfamilia=mysql_result($resultado2,$lineas,"codfamilia");
	  
	  $cantidad1= number_format(mysql_result($resultado2,$lineas,"cantidad"),1,".",",");	  
	  $pdf->Cell(1,4,$cantidad1,0,0,'C');
	  $pdf->Cell(19,4,$codarticulo,0,0,'C');
	 
	  
	  
	 // $pdf->Cell(4,4,mysql_result($resultado2,$lineas,"cantidad"),0,0,'C');	
	  	  
	  $sel_articulos="SELECT * FROM articulos WHERE codarticulo='$codarticulo' AND codfamilia='$codfamilia'";
	  $rs_articulos=$conn->consulta($sel_articulos);
	  	  
	  $acotado = substr(mysql_result($rs_articulos,0,"descripcion"), 0, 45);
	  $pdf->Cell(2);
	  $pdf->Cell(24,4,$acotado,0,0,'L');
	 
	  if (mysql_result($resultado2,$lineas,"dcto")==0) 
	  {
	  $pdf->Cell(5);	
	  //PRECIO UNITARIO
	  $pdf->Cell(37,4,"",0,0,'C',1);
	   } 
	  else 
	   { 
	  $pdf->Cell(5);
	  $pdf->Cell(57,4,mysql_result($resultado2,$lineas,"dcto") . " %",0,0,'C');
	   }
	   
	   
	  $precio2= number_format(mysql_result($resultado2,$lineas,"precio"),2,".",",");	  
	  $pdf->Cell(1,4,$precio2,0,0,'R');
	  
	  $importe2= number_format(mysql_result($resultado2,$lineas,"importe"),2,".",",");	  
	 //VALOR DE VENTA 
	  $pdf->Cell(18,4,$importe2,0,0,'R',1);
	  $pdf->Ln(4);	//DISTANCIA ENTRE FILAS DE ARTICULOS

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

	$pdf->SetY(100);	//ARRIBA Y ABAJO BLOQUE DE SUB TOTAL, IV, TOTAL
	$pdf->Cell(90);  //POSICION IZQUIERDA DERECHA 
    $pdf->Cell(32,4,$importe4,0,0,'R',1); //POSICION DE COLUMNA SUBTOTAL SIN IV
	$pdf->Ln(3); //distancia hacia abajo

	$pdf->Cell(90); //POSICION IZQUIERDA DERECHA 
	$pdf->Cell(1,4,$lafila["iva"] ." %",0,0,'R',1); //Cell (10,4) POSICION IZQUIERDA DERECHA DE BLOQUE PORCENTAJE
	$pdf->Cell(31,4,$impo,0,0,'R',0,1);	 //POSICION DE IMPROTE IZ Y DER
	$pdf->Ln(3); //distancia hacia abajo
		
	$pdf->Cell(90); //POSICION IZQUIERDA DERECHA 
	$pdf->Cell(32,4,$total2,0,0,'R',0);
	$pdf->Ln(3); //distancia hacia abajo
	
	//Calculamos de numero a palabras
	$nw = new Numbers_Words();
		
	$pdf->SetY(98);  //distancia arriba abajo de palabras de total
	$pdf->Cell(30);  //Posicion de columna de inicio de palabras derecha e izquierda 
	
	//Modificamos esta parte para que también muestra la parte fraccionaria y M.N.
	$decimales = explode(".",$total);	
	//$pdf->Cell(35,4,strtoupper($nw->toWords(round($total,0), "es") ." pesos ".$decimales[1]."/100 M.N."),0,0,'L',0);
	$pdf->Cell(40,4,strtoupper($nw->toWords($decimales[0], "es") ." Y ".$decimales[1]."/100 Nuevos Soles"),0,0,'L',0);
	
		
      @mysql_free_result($resultado); 
      @mysql_free_result($query);
	  @mysql_free_result($resultado2); 
	  @mysql_free_result($query3);
	  
      $pdf->Output($name=("Factura Peru pequeña.pdf"),'I');


?>