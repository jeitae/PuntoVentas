<?php
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");

$codfactura = @$_GET["codfactura"];
$cadena_busqueda = @$_GET["cadena_busqueda"];

$query = "SELECT * FROM facturas WHERE codfactura='$codfactura'";
$rs_query = @$conn->consulta($query);
$nombreCliente = @mysql_result($rs_query, 0, "nombreCliente");
$fecha = @mysql_result($rs_query, 0, "fecha");
$iva = @mysql_result($rs_query, 0, "iva");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Ver Factura</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <script language="javascript">
            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function aceptar() {
                window.close();
            }

            function imprimir(codfactura) {
                window.open("../fpdf/imprimir_facturamx.php?codfactura=" + codfactura);

            }
            //agregando funcion para loguito de caja
            function efectuarpago(codfactura, nombreCliente, importe) {
                miPopup = window.open("efectuarpago.php?codfactura=" + codfactura + "&nombreCliente=" + nombreCliente + "&importe=" + importe, "miwin", "width=500,height=370,scrollbars=yes");

            }
        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">VER FACTURA </div>
                    <div id="frmBusqueda">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="15%">Cliente</td>
                                <td width="85%" colspan="2"><?php echo $nombreCliente ?></td>
                            </tr>
                            <tr>
                                <td>C&oacute;digo de factura</td>
                                <td colspan="2"><?php echo $codfactura ?></td>
                            </tr>
                            <tr>
                                <td>Fecha</td>
                                <td colspan="2"><?php echo implota($fecha) ?></td>
                            </tr>
                            <tr>
                                <td>IV</td>
                                <td colspan="2"><?php echo $iva ?> %</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="5%">ITEM</td>
                                <td width="25%">REFERENCIA</td>
                                <td width="30%">DESCRIPCION</td>
                                <td width="10%">CANTIDAD</td>
                                <td width="10%">PRECIO</td>
                                <td width="10%">DCTO %</td>
                                <td width="10%">IMPORTE</td>
                            </tr>
                        </table>
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <?php
                            $baseimponible = 0;
                            $sel_lineas = "SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
                            $rs_lineas = @$conn->consulta($sel_lineas);
                            for ($i = 0; $i < @ @$conn->num_rows($rs_lineas); $i++) {
                                @$numlinea = @mysql_result($rs_lineas, $i, "numlinea");
                                @$codfamilia = @mysql_result($rs_lineas, $i, "codfamilia");
                                @$nombrefamilia = @mysql_result($rs_lineas, $i, "nombrefamilia");
                                @$codarticulo = @mysql_result($rs_lineas, $i, "codarticulo");
                                @$referencia = @mysql_result($rs_lineas, $i, "referencia");
                                @$descripcion = @mysql_result($rs_lineas, $i, "descripcion");
                                @$cantidad = @mysql_result($rs_lineas, $i, "cantidad");
                                @$precio = @mysql_result($rs_lineas, $i, "precio");
                                @$importe = @mysql_result($rs_lineas, $i, "importe");
                                @$descuento = @mysql_result($rs_lineas, $i, "dcto");
                                if ($i % 2) {
                                    $fondolinea = "itemParTabla";
                                } else {
                                    $fondolinea = "itemImparTabla";
                                }
                                ?>
                                <tr class="<?php echo $fondolinea ?>">
                                    <td width="5%" class="aCentro"><?php echo $i + 1 ?></td>
                                    <td width="25%"><?php echo $referencia ?></td>
                                    <td width="30%"><?php echo $descripcion ?></td>
                                    <td width="10%" class="aCentro"><?php echo $cantidad ?></td>
                                    <td width="10%" class="aCentro"><?php echo $precio ?></td>
                                    <td width="10%" class="aCentro"><?php echo $descuento ?></td>
                                    <td width="10%" class="aCentro"><?php echo $importe ?></td>
                                </tr>
                                <?php $baseimponible = $baseimponible + $importe; ?>
                            <?php } ?>
                        </table>
                    </div>
                    <?php
                    $baseimpuestos = $baseimponible * ($iva / 100);
                    $preciototal = $baseimponible + $baseimpuestos;
                    $preciototal = number_format($preciototal, 2);
                    ?>
                    <div id="frmBusqueda">
                        <table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                            <tr>
                                <td width="15%">Base imponible</td>
                                <td width="15%"><?php echo $GLOBALS['simbolomoneda']; ?><?php echo number_format($baseimponible, 2); ?> </td>
                            </tr>
                            <tr>
                                <td width="15%">IV</td>
                                <td width="15%"><?php echo $GLOBALS['simbolomoneda']; ?><?php echo number_format($baseimpuestos, 2); ?> </td>
                            </tr>
                            <tr>
                                <td width="15%">Total</td>
                                <td width="15%"><?php echo $GLOBALS['simbolomoneda']; ?><?php echo $preciototal ?> </td>
                            </tr>
                        </table>
                    </div>
                    <div id="botonBusqueda">
                        <div align="center">
                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor = cursor"><br><br>
                            <!--<img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php echo $codfactura ?>)" onMouseOver="style.cursor = cursor">-->
                        </div>


                        <div align="center" id="cajareg">
                            <img src="../img/caja.png" width="80" height="77" border="1" onClick="efectuarpago('<?php echo $codfactura ?>', '<?php echo $nombreCliente ?>', '<?php echo $preciototal ?>')" onMouseOver="style.cursor = cursor" title="Efectuar pago">
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </body>







</html>
