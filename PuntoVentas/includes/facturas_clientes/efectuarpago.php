
<?php
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");
?>

<html>
    <head>
        <title>Pago Mostrador Venta</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>

        <script>

            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function actualizarimporte() {
                var importe = document.getElementById("importe").value;
                var importevale = document.getElementById("importevale").value;
                if (importevale.search('[^0-9.]') == -1)
                {
                    var resta = parseFloat(importe - importevale);
                    var valor = Math.round(resta * 100) / 100;
                    document.getElementById("apagar").value = valor;
                } else {
                    alert("El importe del vale no es correcto.");
                }
            }

            function actualizarimportedevolver() {
                var importe = document.getElementById("importe").value;
                var pagado = document.getElementById("pagado").value;
                if (pagado.search('[^0-9.]') == -1)
                {
                    var resta = parseFloat(pagado - importe);
                    var valor = Math.round(resta * 100) / 100;

                    // En ventas de mostrador solo se permiten pagos totales.
                    if (valor < 0)
                    {
                        alert("En ventas de mostrador solo se permite pagar toda la cuenta.")

                    } else {
                        document.getElementById("adevolver").value = valor;
                    }

                } else {
                    alert("El importe pagado no es correcto.");
                }
            }

            function imprimir(codfactura) {

                var pagado = document.getElementById("pagado").value;
                var adevolver = document.getElementById("adevolver").value;
                location.href = "../fpdf/imprimir_ticket_html.php?codfactura=" + codfactura + "&pagado=" + pagado + "&adevolver=" + adevolver;
                ventanaX = 500;
                ventanaY = 530;
                self.resizeTo(ventanaX, ventanaY);
               
            }

            function mostrar_img()
            {
                document.getElementById("img").style.visibility = "visible";
            }


            function enviar() {
                document.getElementById("formulario").submit();
                
            }
        </script>
    </head>
    <?php
    $codfactura = @$_GET["codfactura"];
    $nombreCliente = @$_GET["nombreCliente"];
    $importe = @$_GET["importe"];
    ?>
    <!-- aquiii pruebaaa valor totaalll -->


    <?php
    $baseimponible = 0;
    $sel_lineas = "SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
    $rs_lineas = @$conn->consulta($sel_lineas);
    for ($i = 0; $i < @$conn->num_rows($rs_lineas); $i++) {
        $numlinea = @mysql_result($rs_lineas, $i, "numlinea");
        $codfamilia = @mysql_result($rs_lineas, $i, "codfamilia");
        $nombrefamilia = @mysql_result($rs_lineas, $i, "nombrefamilia");
        $codarticulo = @mysql_result($rs_lineas, $i, "codarticulo");
        $referencia = @mysql_result($rs_lineas, $i, "referencia");
        $descripcion = @mysql_result($rs_lineas, $i, "descripcion");
        $cantidad = @mysql_result($rs_lineas, $i, "cantidad");
        $precio = @mysql_result($rs_lineas, $i, "precio");
        $importe = @mysql_result($rs_lineas, $i, "importe");
        $descuento = @mysql_result($rs_lineas, $i, "dcto");
        ?>


        <?php $baseimponible = $baseimponible + $importe; ?>

    <?php } ?>
</table>
</div>
<?php
$query = "SELECT * FROM facturas WHERE codfactura='$codfactura'";
$rs_query = @$conn->consulta($query);
$nombreCliente = @mysql_result($rs_query, 0, "nombreCliente");
$fecha = @mysql_result($rs_query, 0, "fecha");
$iva = @mysql_result($rs_query, 0, "iva");

$baseimpuestos = $baseimponible * ($iva / 100);
$preciototal = $baseimponible + $baseimpuestos;
$preciototal = number_format($preciototal, 2);
?>



<!-- aquiii pruebaaa valor totaalll -->


<body>
    <div id="pagina">
        <div id="zonaContenido">
            <div id="tituloForm2" class="header">COBRO POR CAJA</div>
            <div id="frmBusqueda2">
                <div align="center">
                    <form id="formulario" name="formulario" method="post" action="guardar_cobro.php" target="frame_datos">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=2 border=0>
                            <tr>
                                <td width="25%">C&oacute;digo Factura </td>
                                <td width="75%"><input NAME="codfactura" type="text" class="cajaPequena" id="codfactura" size="15" maxlength="15" value="<?php echo $codfactura ?>" readonly="yes">						</tr>
                            <tr>
                                <td>Cliente</td>
                                <td><input NAME="nombre_cliente" type="text" class="cajaGrande" id="nombre_cliente" size="45" maxlength="45" value="<?php echo $nombreCliente ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Importe</td>
                                <td><?php echo $codigomonedate ?> <input NAME="importe" type="text" class="cajaPequena" id="importe" size="10" maxlength="10" value="<?php echo $preciototal ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Importe vale</td>
                                <td><?php echo $codigomonedate ?> <input NAME="importevale" type="text" class="cajaPequena" id="importevale" size="10" maxlength="10" value="0"> <img src="../img/disco.png" name="Image2" width="16" height="16" border="0" id="Image2" onMouseOver="this.style.cursor = 'pointer'" title="Aplicar Vale" onClick="actualizarimporte()"></td>
                            </tr>
                            <tr>
                                <td>A pagar</td>
                                <td><?php echo $codigomonedate ?> <input NAME="apagar" type="text" class="cajaPequena" id="apagar" size="10" maxlength="10" value="<?php echo $preciototal ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Pagado</td>
                                <td><?php echo $codigomonedate ?> <input NAME="pagado" type="text" value="<?php echo $preciototal ?>" class="cajaPequena" id="pagado" size="10" maxlength="10"> <img src="../img/dinero.jpg" name="Image2" id="Image2" width="16" height="16" border="0" onMouseOver="this.style.cursor = 'pointer'" title="Pagado" onClick="actualizarimportedevolver()"></td>
                            </tr>
                            <tr>
                                <td>A devolver</td>
                                <td><?php echo $codigomonedate ?> <input NAME="adevolver" type="text" value="0" class="cajaPequena" id="adevolver" size="10" maxlength="10" readonly></td>
                            </tr>
                            <?php
                            $query_fp = "SELECT * FROM formapago WHERE borrado=0 ORDER BY nombrefp ASC";
                            $res_fp = @$conn->consulta($query_fp);
                            $contador = 0;
                            ?>
                            <tr>
                                <td>Forma de pago</td>
                                <td><select id="formapago" name="formapago" class="comboGrande">
                                        <?php
                                        while ($contador < @$conn->num_rows($res_fp)) {
                                            if (@mysql_result($res_fp, $contador, "codformapago") == 3) {
                                                ?>
                                                <option value="<?php echo @mysql_result($res_fp, $contador, "codformapago") ?>" selected="selected"><?php echo @mysql_result($res_fp, $contador, "nombrefp") ?></option> 
                                            <?php } else { ?>
                                                <option value="<?php echo @mysql_result($res_fp, $contador, "codformapago") ?>"><?php echo @mysql_result($res_fp, $contador, "nombrefp") ?></option>
                                                <?php
                                            }
                                            $contador++;
                                        }
                                        ?>				
                                    </select></td>
                            </tr>
                            <tr>
                                <td>N&uacute;mero de documento</td>
                                <td><input NAME="numdocumento" type="text" class="cajaGrande" id="numdocumento" size="40" maxlength="40"></td>
                            </tr>
                            <?php $hoy = date("d/m/Y"); ?>
                            <tr>
                                <td>Fecha de cobro</td>
                                <td><input NAME="fechacobro" type="text" class="cajaPequena" id="fechacobro" size="10" maxlength="10" value="<?php echo $hoy ?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" onMouseOver="this.style.cursor = 'pointer'">
                                    <script type="text/javascript">
                                        Calendar.setup(
                                                {
                                                    inputField: "fechacobro",
                                                    ifFormat: "%d/%m/%Y",
                                                    button: "Image1"
                                                }
                                        );
                                    </script></td>
                            </tr>
                        </table>										
                </div>
                <br><br>
                <div align="center">
                    <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="javascript:enviar();
                            mostrar_img()"  border="1" onMouseOver="style.cursor = cursor">
                    <img src="../img/botonimprimirticket.jpg" width="122" height="22" onClick="imprimir(<?php echo $codfactura; ?>)" border="1" onMouseOver="style.cursor = cursor" id="img" style = "visibility:hidden">
                    <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor = cursor">
                </div>
                <input id="codfactura" name="codfactura" value="<?php echo $codfactura ?>" type="hidden">
                <input id="codcliente" name="codcliente" value="<?php echo $nombreCliente ?>" type="hidden">
                <input id="importe" name="importe" value="<?php echo $importe ?>" type="hidden">
                <br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</body>
</html>
