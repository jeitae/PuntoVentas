<?php
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");

$fechainicio = @$_POST["fechainicio"];
if ($fechainicio <> "") {
    $fechainicio = explota($fechainicio);
}

$cadena_busqueda = @$_POST["cadena_busqueda"];

$sel_facturas = "SELECT Max(facturas.codfactura) AS maximo, Min(facturas.codfactura) AS minimo, Sum(facturas.totalfactura) AS totalfac, Sum(facturas.totalfactura - facturas.totalfactura / (1+(facturas.iva /100))) AS totaliva FROM facturas WHERE facturas.borrado =  '0' AND facturas.fecha =  '$fechainicio'";
$rs_facturas = $conn->consulta($sel_facturas);

if (@$conn->num_rows($rs_facturas) > 0) {
    $minimo = @mysql_result($rs_facturas, 0, "minimo");
    $maximo = @mysql_result($rs_facturas, 0, "maximo");
    $total = @mysql_result($rs_facturas, 0, "totalfac");
    $total_iva = @mysql_result($rs_facturas, 0, "totaliva");
} else {
    $minimo = 0;
    $maximo = 0;
    $total = 0;
}
$neto = $total - $total_iva;
$iva = $total_iva;
// Relaci�n de cobros.
$sel_cobros = "SELECT Sum(cobros.importe) AS total_forma_pago, formapago.nombrefp FROM cobros Inner Join formapago ON cobros.codformapago = formapago.codformapago WHERE cobros.fechacobro =  '$fechainicio' AND cobros.codfactura<>0 GROUP BY formapago.nombrefp ORDER BY formapago.codformapago ASC";
$rs_cobros = $conn->consulta($sel_cobros);
$contador = 0;
$total_cobros = 0;
?>
<html>
    <head>
        <title>Cierre Caja</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">	
        <script>

            var cursor;
            if (document.all) {
                // Est� utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Est� utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function imprimir(fechainicio, minimo, maximo, neto, iva, total, contado, tarjeta) {
                location.href = "../fpdf/cerrarcaja_html.php?fechainicio=" + fechainicio + "&minimo=" + minimo + "&maximo=" + maximo + "&neto=" + neto + "&iva=" + iva + "&total=" + total + "&contado=" + contado + "&tarjeta=" + tarjeta;
            }
            function imprimir1(fechainicio, minimo, maximo, neto, iva, total, contado, tarjeta) {
                location.href = "../fpdf/bbcerrarcaja_html.php?fechainicio=" + fechainicio + "&minimo=" + minimo + "&maximo=" + maximo + "&neto=" + neto + "&iva=" + iva + "&total=" + total + "&contado=" + contado + "&tarjeta=" + tarjeta;
            }
        </script>
    </head>
    <body>	
        <div id="pagina">
            <div id="zonaContenidoCC">
                <div align="center">
                    <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                        <table class="fuente8" width="40%" cellspacing=0 cellpadding=3 border=0>
                            <tr><strong>Totales de facturaci&oacute;n</strong></tr>
                            <tr>
                                <td>Cierre de Caja al:</td>
                                <td><?php echo implota($fechainicio) ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong>Totales de facturaci&oacute;n</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>				  
                            <tr>
                                <td>De la factura n&deg;</td>
                                <td><?php echo $minimo ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>A la factura n&deg;</td>
                                <td><?php echo $maximo ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>                    
                                <td><?php echo $simbolomoneda ?></td>
                                <td align="right"><?php echo number_format($neto, 2, ".", ",") ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $ivaimp ?> % IV</td>
                                <td><?php echo $simbolomoneda ?></td>
                                <td align="right"><?php echo number_format($iva, 2, ".", ",") ?> </td>                    
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><?php echo $simbolomoneda ?></td>
                                <td align="right"><strong><?php echo number_format($total, 2, ".", ",") ?></strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong>Relaci&oacute;n de Cobros</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr> 
                            <?php
                            if (@$conn->num_rows($rs_cobros) <= 0) {
                                echo "<tr><td>No hay cobros en este d&iacute;a.</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
                            } else {
                                while ($contador < @$conn->num_rows($rs_cobros)) {
                                    ?>
                                    <tr>
                                        <td>Total <?php echo @mysql_result($rs_cobros, $contador, "nombrefp"); ?></td>
                                        <td><?php echo $simbolomoneda; ?></td>
                                        <td align="right"><?php echo number_format(@mysql_result($rs_cobros, $contador, "total_forma_pago"), 2, ".", ","); ?></td>
                                    </tr>
                                    <?php
                                    $total_cobros = $total_cobros + @mysql_result($rs_cobros, $contador, "total_forma_pago");
                                    $contador++;
                                }
                            }
                            ?>				                    
                            <tr>
                                <td><strong>Total Facturas</strong></td>
                                <td><?php echo $simbolomoneda ?></td>
                                <td align="right"><strong><?php echo number_format($total_cobros, 2, ".", ","); ?></strong></td>
                            </tr>
                            <tr>
                                <td align="center">

                                    -----------------------------------------------------------------


                                </td>
                            </tr>
                            <tr>
                                <td align="center">

                                    <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir('<?php echo @$fechainicio ?>', '<?php echo @$minimo ?>', '<?php echo @$maximo ?>', '<?php echo @$neto ?>', '<?php echo @$iva ?>', '<?php echo @$total ?>', '<?php echo @$contado ?>', '<?php echo @$tarjeta ?>')" onMouseOver="style.cursor = cursor">		



                                </td>
                            </tr>
                        </table>
                </div>


                <!-- Boletassssssssssssssssss-->	
                <?php
//BOLETAS------------------------------------------------------------------------------------------------------------------------
                $bbsel_facturas = "SELECT Max(eefacturas.bbcodfactura) AS maximo, Min(eefacturas.bbcodfactura) AS minimo, Sum(eefacturas.totalfactura) AS totalbol, Sum(eefacturas.totalfactura - eefacturas.totalfactura / (1+(eefacturas.iva /100))) AS totaliva FROM eefacturas WHERE eefacturas.borrado =  '0' AND eefacturas.fecha =  '$fechainicio'";
                $bbrs_facturas = $conn->consulta($bbsel_facturas);

                if (@$conn->num_rows($bbrs_facturas) > 0) {
                    $bbminimo = @mysql_result($bbrs_facturas, 0, "minimo");
                    $bbmaximo = @mysql_result($bbrs_facturas, 0, "maximo");
                    $bbtotal = @mysql_result($bbrs_facturas, 0, "totalbol");
                    $bbtotal_iva = @mysql_result($bbrs_facturas, 0, "totaliva");
                } else {
                    $bbminimo = 0;
                    $bbmaximo = 0;
                    $bbtotal = 0;
                }
                $bbneto = $bbtotal - $bbtotal_iva;
                $bbiva = $bbtotal_iva;
// Relaci�n de cobros.
                $bbsel_cobros = "SELECT Sum(cobros.importe) AS total_forma_pago, formapago.nombrefp FROM cobros Inner Join formapago ON cobros.codformapago = formapago.codformapago WHERE cobros.fechacobro =  '$fechainicio' AND cobros.codfactura=0 GROUP BY formapago.nombrefp ORDER BY formapago.codformapago ASC";
                $bbrs_cobros = $conn->consulta($bbsel_cobros);
                $bbcontador = 0;
                $bbtotal_cobros = 0;
                ?>
            </div>
        </div>








    </body>
</html>