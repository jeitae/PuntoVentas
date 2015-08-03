<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');

require "../sys/conexion.php";
$conn = new conexion();

$codfactura = @$_GET["codfacturatmp"];
$numlinea = @$_GET["numlinea"];

$consulta = "DELETE FROM factulineatmp WHERE codfactura ='" . $codfactura . "' AND numlinea='" . $numlinea . "'";
$rs_consulta = $conn->consulta($consulta);
echo "<script>parent.location.href='frame_lineas.php?codfacturatmp=" . $codfactura . "';</script>";
?>
<script>parent.document.getElementById("codbarras").focus();</script>