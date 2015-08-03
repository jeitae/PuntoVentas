<?php
session_start();

if (!isset($_SESSION['idSession']) || $_SESSION['rol'] == 1) {

    header("Location:../../index.php");
} else {

    require "../sys/conexion.php";
    $conn = new conexion();


    $base = @$_GET["baseimponible"];
    $codfacturatmp = "";


    $fechahoy = date("Y-m-d");

    $sel_fact = "INSERT INTO facturastmp (codfactura,fecha) VALUE ('','$fechahoy')";

    $rs_fact = $conn->consulta($sel_fact);
    $codfacturatmp .= mysql_insert_id();

// Se actualiza a la nueva numeracion de factura

    if ($GLOBALS['setnumfac'] == 1) {

        $sel_articulos = "UPDATE facturastmp SET codfactura='" . $GLOBALS['numeracionfactura'] . "' WHERE codfactura='" . $codfacturatmp . "'";

        $rs_articulos = $conn->consulta($sel_articulos);

        $codfacturatmp = $GLOBALS['numeracionfactura'];
    }


    $codfacturatmp = @$_POST["codfacturatmp"];
    $retorno = 0;
    if (@$modif <> 1) {
        if (!isset($codfacturatmp)) {
            $codfacturatmp = @$_GET["codfacturatmp"];
            $retorno = 1;
        }
        if ($retorno == 0) {
            $codbarras = @$_POST["codbarras"];
            @$sel_articulos = "SELECT * FROM articulos WHERE codigobarras='$codbarras'";
            @$rs_articulos = $conn->consulta($sel_articulos);
            @$codfamilia = @mysql_result($rs_articulos, 0, "codfamilia");
            @$codarticulo = @mysql_result($rs_articulos, 0, "codarticulo");
            @$cantidad = $_POST["cantidad"];
            @$precio = $_POST["precio"];
            @$importe = $_POST["importe"];
            @$descuento = $_POST["descuento"];
            @$nombreCliente = $_POST["nombreCliente"];
            @$numRemito = $_POST["numRemito"];
            @$numFactura = $_POST["numFactura"];

            $sel_insert = "INSERT INTO factulineatmp (codfactura,numlinea,codigo,codfamilia,cantidad,precio,importe,dcto) VALUES ('$codfacturatmp','','$codarticulo','$codfamilia','$cantidad','$precio','$importe','$descuento')";
            $rs_insert = $conn->consulta($sel_insert);
        }
    }
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>

        <script type="text/javascript" src="../funciones/validar.js"></script>
        <!-- CSS -->
        <link rel="stylesheet" href="../../css/alertify.min.css"/>
        <link rel="stylesheet" href="../../css/jquery-ui.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="../../css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="../../css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="../../css/themes/bootstrap.min.css"/>

        <link rel="stylesheet" href="../../css/style.css" type="text/css">

        <script>
            $(document).ready(function () {

                if ($('#nombre').val().trim() == "") {
                    document.getElementById("nombre").value = "Venta Mostrador";
                    document.getElementById("codbarras").focus();
                }
                alertify.notify('Realizar una nueva factura', 'success', 6, null).dismissOthers();
                $('#nombreCliente').attr('value', document.getElementById("nombre").value);

            });

            var miPopup

            function abreVentana() {

                miPopup = window.open("ver_clientes.php", "miwin", "width=700,height=380,scrollbars=yes");

                miPopup.focus();

            }


            function validarcliente() {

                var codigo = document.getElementById("codcliente").value;

                miPopup = window.open("comprobarcliente.php?codcliente=" + codigo, "frame_datos", "width=700,height=80,scrollbars=yes");

            }


            function cancelar() {

                window.location = "ventas.php";

            }



            function limpiarcaja() {

                document.getElementById("nombre").value = "";

            }



            function actualizar_importe()

            {

                var precio = document.getElementById("precio").value;

                var cantidad = document.getElementById("cantidad").value;

                var descuento = document.getElementById("descuento").value;

                descuento = descuento / 100;

                total = precio * cantidad;

                descuento = total * descuento;

                total = total - descuento;

                var original = parseFloat(total);

                var result = Math.round(original * 100) / 100;

                document.getElementById("importe").value = result;

            }



            function validar_cabecera()

            {

                var mensaje = "";

                if (document.getElementById("nombre").value == "")
                    mensaje += "  - Nombre\n";

                if (document.getElementById("fecha").value == "")
                    mensaje += "  - Fecha\n";

                if (mensaje != "") {

                    alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);

                } else {

                    document.getElementById("formulario").submit();

                }

            }



            function validar()

            {

                var mensaje = "";

                var entero = 0;

                var enteroo = 0;



                if (document.getElementById("codbarras").value == "")
                    mensaje = "  - Codigo de barras\n";

                if (document.getElementById("descripcion").value == "")
                    mensaje += "  - Descripcion\n";

                if (document.getElementById("precio").value == "") {

                    mensaje += "  - Falta el precio\n";

                } else {

                    if (isNaN(document.getElementById("precio").value) == true) {

                        mensaje += "  - El precio debe ser numerico\n";

                    }

                }

                if (document.getElementById("cantidad").value == "")

                {

                    mensaje += "  - Falta la cantidad\n";

                } else {

                    enteroo = parseInt(document.getElementById("cantidad").value);

                    if (isNaN(enteroo) == true) {

                        mensaje += "  - La cantidad debe ser numerica\n";

                    } else {

                        document.getElementById("cantidad").value = enteroo;

                    }

                }

                if (document.getElementById("descuento").value == "")

                {

                    document.getElementById("descuento").value = 0

                } else {

                    entero = parseInt(document.getElementById("descuento").value);

                    if (isNaN(entero) == true) {

                        mensaje += "  - El descuento debe ser numerico\n";

                    } else {

                        document.getElementById("descuento").value = entero;

                    }

                }

                if (document.getElementById("importe").value == "")
                    mensaje += "  - Falta el importe\n";



                if (mensaje != "") {

                    alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);

                } else {

                    document.getElementById("baseimponible").value = parseFloat(document.getElementById("baseimponible").value) + parseFloat(document.getElementById("importe").value);
                    $('#nombreCliente').attr('value', document.getElementById("nombre").value);
                    $('#numRemito').attr('value', document.getElementById("remito").value);
                    $('#numFactura').attr('value', document.getElementById("numfactura").value);
                    document.getElementById("formulario_lineas").submit();

                    cambio_iva();



                    document.getElementById("codbarras").value = "";

                    document.getElementById("descripcion").value = "";

                    document.getElementById("precio").value = "";

                    document.getElementById("cantidad").value = 1.0;

                    document.getElementById("importe").value = "";

                    document.getElementById("descuento").value = 0;

                }

            }


            function cambio_iva() {

                var original = parseFloat(document.getElementById("baseimponible").value);

                var result = Math.round(original * 100) / 100;

                document.getElementById("baseimponible").value = result;



                document.getElementById("baseimpuestos").value = parseFloat(result * parseFloat(document.getElementById("iva").value / 100));

                var original1 = parseFloat(document.getElementById("baseimpuestos").value);

                var result1 = Math.round(original1 * 100) / 100;

                document.getElementById("baseimpuestos").value = result1;

                var original2 = parseFloat(result + result1);

                var result2 = Math.round(original2 * 100) / 100;

                document.getElementById("preciototal").value = result2;

            }

            function ventanaArticulos() {


                miPopup = window.open("ver_articulos.php", "miwin", "width=700,height=500,scrollbars=yes");

                miPopup.focus();



            }

            function refrescar() {
                window.location = "articulos.php";
            }

            function eliminar_linea(codfacturatmp, numlinea, importe)
            {
                if (confirm(" Desea eliminar esta linea ? "))
                    parent.document.formulario_lineas.baseimponible.value = parseFloat(parent.document.formulario_lineas.baseimponible.value) - parseFloat(importe);
                var original = parseFloat(parent.document.formulario_lineas.baseimponible.value);
                var result = Math.round(original * 100) / 100;
                parent.document.formulario_lineas.baseimponible.value = result;

                parent.document.formulario_lineas.baseimpuestos.value = parseFloat(result * parseFloat(parent.document.formulario.iva.value / 100));
                var original1 = parseFloat(parent.document.formulario_lineas.baseimpuestos.value);
                var result1 = Math.round(original1 * 100) / 100;
                parent.document.formulario_lineas.baseimpuestos.value = result1;
                var original2 = parseFloat(result + result1);
                var result2 = Math.round(original2 * 100) / 100;
                parent.document.formulario_lineas.preciototal.value = result2;

                document.getElementById("frame_datos").src = "eliminar_linea.php?codfacturatmp=" + codfacturatmp + "&numlinea=" + numlinea;
            }

        </script>

    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">


                <a href="../../facturacion.php"><input id="bMenu" type="button" value="Menu Facturación"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>

            </div>
        </div>
        <div id="contenidoPrincipal">
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;height: auto;">
                <div align="center">
                    <div id="tituloForm" class="header">NUEVA FACTURA </div>

                    <div id="frmBusqueda">

                        <form id="formulario" name="formulario" method="post" action="guardar_factura.php">

                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>

                                <tr>

                                    <td width="6%">Nombre Cliente:</td>

                                    <td width="27%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="4" maxlength="40" value="<?php echo @$nombreCliente; ?>"></td>

                                    <td width="3%"></td>

                                    <td width="64%">
                                        <div style="margin:0 10px 6px 0; float:right;">N&deg; de Remito  <input style="margin:0 0 0 5px;" name="remito" id="remito" type="text" value="<?php echo @$numRemito; ?>"></div>						
                                    </td>

                                </tr>

                                <?php $hoy = date("d/m/Y"); ?>

                                <tr>

                                    <td width="6%">Fecha</td>

                                    <td width="27%"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php echo $hoy ?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0"  onMouseOver="this.style.cursor = 'pointer'">

                                        <script type="text/javascript">

                                            Calendar.setup(
                                                    {
                                                        inputField: "fecha",
                                                        ifFormat: "%d/%m/%Y",
                                                        button: "Image1"

                                                    }

                                            );

                                        </script></td>

                                    <td width="3%">IV</td>

                                    <td width="64%"><input NAME="iva" type="text" class="cajaMinima" id="iva" size="5" maxlength="5" value="<?php echo $ivaimp; ?>" onChange="cambio_iva();"> % <div style="margin:0 10px 6px 0; float:right;">N&deg; de Factura <input name="numfactura" id="numfactura" type="text" value="<?php echo @$numFactura; ?>"></div>
                                    </td>

                                </tr>


                            </table>										

                            <div id="botonBusqueda">

                                <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">

                                <input id="baseimpuestos2" name="baseimpuestos" value="<?php echo $baseimpuestos ?>" type="hidden">

                                <input id="baseimponible2" name="baseimponible" value="<?php echo $baseimponible ?>" type="hidden">

                                <input id="preciototal2" name="preciototal" value="<?php echo $preciototal ?>" type="hidden">

                                <input id="accion" name="accion" value="alta" type="hidden">
                            </div>
                        </form>
                    </div>
                    <div id="frmBusquedaVTASM">

                        <form id="formulario_lineas" name="formulario_lineas" method="post" action="ventas.php">
                            <input type="hidden" name="nombreCliente" id="nombreCliente">
                            <input type="hidden" name="numRemito" id="numRemito">
                            <input type="hidden" name="numFactura" id="numFactura">
                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>

                                <tr>

                                    <td width="11%">Codigo barras </td>

                                    <td colspan="10" valign="middle"><input NAME="codbarras" type="text" class="cajaMedia" id="codbarras" size="15" maxlength="15"> <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" style="cursor:pointer;" title="Buscar articulo"></td>

                                </tr>

                                <tr>

                                    <td>Descripcion</td>

                                    <td width="19%"><input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" size="30" maxlength="30" readonly></td>

                                    <td width="5%">Precio<td><?php echo $simbolomoneda ?></td></td>

                                    <td width="11%"><input NAME="precio" type="text" class="cajaPequena2" id="precio" size="10" maxlength="10" onChange="actualizar_importe()"></td>

                                    <td width="5%">Cantidad</td>

                                    <td width="5%"><input NAME="cantidad" type="text" class="cajaMinima" id="cantidad" size="10" maxlength="10" value="1" onChange="actualizar_importe()"></td>

                                    <td width="4%">Dcto.</td>

                                    <td width="9%"><input NAME="descuento" type="text" class="cajaMinima" id="descuento" size="10" maxlength="10" onChange="actualizar_importe()"><td>%</td></td>

                                    <td width="5%">Importe<td><?php echo $simbolomoneda ?></td></td>

                                    <td width="11%"><input NAME="importe" type="text" class="cajaPequena2" id="importe" size="10" maxlength="10" value="0" readonly></td>

                                    <td width="15%"><img src="../img/botonagregar.jpg" border="1" onClick="validar()" style="cursor:pointer;"></td>

                                </tr>

                            </table>

                            <div id="botonBusqueda3_nf">					

                                <div>
                                    <div style="margin:14px 0 6px 0; float:right;">
                                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_cabecera()" border="1" style="cursor:pointer;">

                                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" style="cursor:pointer;">

                                        <input id="codfamilia" name="codfamilia" value="<?php echo $codfamilia ?>" type="hidden">

                                        <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">	

                                        <input id="preciototal2" name="preciototal" value="<?php echo $preciototal ?>" type="hidden">			    
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>

                    <br>

                    <div id="frmResultadoVTASM">

                        <table class="fuente8" width="100%" cellspacing=1 cellpadding=3 border=0 ID="Table1">

                            <tr class="cabeceraTabla">

                                <td width="5%">ITEM</td>

                                <td width="20%">FAMILIA</td>

                                <td width="16%">REFERENCIA</td>

                                <td width="27%">DESCRIPCION</td>

                                <td width="5%">CANTIDAD</td>

                                <td width="8%">PRECIO</td>

                                <td width="8%">DCTO %</td>

                                <td width="5%">IMPORTE</td>

                                <td width="6%">&nbsp;</td>

                            </tr>

                        </table>





                    </div>



                    <div id="frmBusqueda" style="display:none">

                        <table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">

                            <tr>

                                <td width="27%" class="busqueda">Sub-total</td>

                                <td width="73%" align="right"><div align="center"><?php echo $base ?> <?php echo $simbolomoneda ?>

                                        <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" value="<?php echo $baseimp ?>" align="right" readonly> 

                                    </div></td>

                            </tr>

                            <tr>

                                <td class="busqueda">IV</td>

                                <td align="right"><div align="center"><?php echo $simbolomoneda ?>

                                        <input class="cajaTotales" name="baseimpuestos" type="text" id="baseimpuestos" size="12" align="right" value="<?php echo $baseiva ?>" readonly> 

                                    </div></td>

                            </tr>

                            <tr>

                                <td class="busqueda">Precio Total</td>

                                <td align="right"><div align="center"><?php echo $simbolomoneda ?>

                                        <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" value="<?php echo $preciotot ?>" readonly> 

                                    </div></td>

                            </tr>

                        </table>

                    </div>

                    <br>

                    <br>

                    <div id="lineaResultadoVTASM">

                        <table class="fuente8" width="100%" cellspacing=1 cellpadding=3 border=0 ID="Table1">
                            <?php
                            $baseimp=0;
                            $sel_lineas = "SELECT factulineatmp.*,articulos.*,familias.nombre as nombrefamilia FROM factulineatmp,articulos,familias WHERE factulineatmp.codfactura='$codfacturatmp' AND factulineatmp.codigo=articulos.codarticulo AND factulineatmp.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulineatmp.numlinea ASC";
                            $rs_lineas = mysql_query($sel_lineas);
                            for ($i = 0; $i < @$conn->num_rows($rs_lineas); $i++) {
                                @$numlinea = @mysql_result($rs_lineas, $i, "numlinea");
                                @$codfamilia = @mysql_result($rs_lineas, $i, "codfamilia");
                                @$nombrefamilia = @mysql_result($rs_lineas, $i, "nombrefamilia");
                                @$codarticulo = @mysql_result($rs_lineas, $i, "codarticulo");
                                @$referencia = @mysql_result($rs_lineas, $i, "referencia");
                                @$descripcion = @mysql_result($rs_lineas, $i, "descripcion");
                                @$cantidad = @mysql_result($rs_lineas, $i, "cantidad");
                                @$precio = @mysql_result($rs_lineas, $i, "precio");
                                @$importe = @mysql_result($rs_lineas, $i, "importe");
                                $baseimp = $importe + $baseimp;

                                $descuento = @mysql_result($rs_lineas, $i, "dcto");
                                if ($i % 2) {
                                    $fondolinea = "itemParTabla";
                                } else {
                                    $fondolinea = "itemImparTabla";
                                }
                                ?>

                                <tr class="<?php echo $fondolinea ?>">
                                    <td width="4%"><?php echo $i + 1 ?></td>
                                    <td width="20%"><?php echo $nombrefamilia ?></td>
                                    <td width="16%"><?php echo $referencia ?></td>
                                    <td width="29%"><?php echo $descripcion ?></td>
                                    <td width="9%" class="aCentro"><?php echo $cantidad ?></td>
                                    <td width="8%" class="aCentro"><?php echo $precio ?></td>
                                    <td width="7%" class="aCentro"><?php echo $descuento ?></td>
                                    <td width="6%" class="aCentro"><?php echo number_format($importe, 2, ".", ","); ?></td>
                                    <td width="2%"><a href="javascript:eliminar_linea(<?php echo $codfacturatmp; ?>,<?php echo $numlinea ?>,<?php echo $importe ?>)"><img src="../img/eliminar.png" border="0"></a></td>
                                </tr>
                                <?php
                            }

                            $baseiva = $baseimp * (number_format($ivaimp, 2, ".", ",") / 100);
                            $preciotot = $baseimp + $baseiva;
                            ?>
                        </table>

                        <table width="100%" border=0 align="center" cellpadding=3 cellspacing=0 class="fuente8">
                            <tr>
                                <td width="70%" class="busqueda"><b>Sub-total</b></td>
                                <td width="30%" align="right"><div align="right"><?php echo $simbolomoneda ?>
                                        <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" value="<?php echo number_format($baseimp, 2, ".", ","); ?>" align="right" readonly> 
                                    </div></td>																					 


                            </tr>
                            <tr>
                                <td class="busqueda"><b>IV</b></td>
                                <td align="right"><div align="right"><?php echo $simbolomoneda ?>
                                        <input class="cajaTotales" name="baseimpuestos" type="text" id="baseimpuestos" size="12" align="right" value="<?php echo number_format($baseiva, 2, ".", ","); ?>" readonly> 
                                    </div></td>
                            </tr>
                            <tr>
                                <td class="busqueda"><b>Precio Total</b></td>
                                <td align="right"><div align="right"><?php echo $simbolomoneda ?>
                                        <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" value="<?php echo number_format($preciotot, 2, ".", ","); ?>" readonly> 
                                    </div></td>
                            </tr>
                        </table>

                        <script>parent.document.getElementById("codbarras").focus();</script>
                    </div>

                </div>			

            </div>
            <a href="#" class="scrollup">Scroll</a>
    </body>
</html>


