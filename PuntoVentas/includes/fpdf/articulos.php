<?php

define('FPDF_FONTPATH', 'font/');
//require('mysql_table.php');
require_once ('fpdf.php');
include("comunes.php");

require "../sys/conexion.php";
$conn = new conexion();


$pdf = new PDF();
$pdf->Open();
$pdf->AddPage();

// Cabecera

$pdf->Header('./logo/logo.jpg', 10, 8, 33, 33);

//Nombre del Listado

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetY(40);
$pdf->SetX(0);

$pdf->MultiCell(290, 6, "Listado de Articulos", 0, 'C', 0);

$pdf->Ln();

//Restauracin de colores y fuentes

$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', 'B', 7);


$codarticulo = $_GET["codarticulo"];
$referencia = $_GET["referencia"];


$where = "1=1";
if ($codarticulo != "") {
    $where.=" AND codarticulo='" . $codarticulo . "'";
}
if ($referencia != "") {
    $where.=" AND referencia like '%" . $referencia . "%'";
}


$header = array('Familia', 'Referencia', 'Descripcion', 'P. Tienda', 'Stock');

//Colores, ancho de lnea y fuente en negrita
$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(.2);
$pdf->SetFont('Arial', 'B', 8);

//Cabecera
$w = array(40, 30, 80, 20, 20);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
}

$pdf->Ln();
$pdf->SetFont('Arial', '', 8);
$sel_resultado = 'SELECT * FROM articulos LEFT JOIN familias ON articulos.codfamilia=familias.codfamilia WHERE articulos.borrado=0 AND ' . $where;
$res_resultado = $conn->consulta($sel_resultado);

$contador = 0;

while ($contador < $conn->num_rows($res_resultado)) {
    $pdf->Cell($w[0], 5, mysql_result($res_resultado, $contador, "familias.nombre"), 'LRTB', 0, 'L');
    $pdf->Cell($w[1], 5, mysql_result($res_resultado, $contador, "referencia"), 'LRTB', 0, 'C');
    $pdf->Cell($w[2], 5, mysql_result($res_resultado, $contador, "descripcion_corta"), 'LRTB', 0, 'L');
    $pdf->Cell($w[3], 5, mysql_result($res_resultado, $contador, "precio_tienda"), 'LRTB', 0, 'R');
    $pdf->Cell($w[4], 5, mysql_result($res_resultado, $contador, "stock"), 'LRTB', 0, 'R');
    $pdf->Ln();
    $contador++;
}

$pdf->Output();

