<?php
session_start();

if (!isset($_SESSION['idSession'])) {

    header("Location:../../index.php");
} else {

    require "../sys/conexion.php";
    $conn = new conexion();


    $base = @$_GET["baseimponible"];


    $fechahoy = date("Y-m-d");
    $sel_fact = "call pConsulta_codFactura()";
    $rs_fact = $conn->consulta($sel_fact);
    $resultadoFact = @$conn->fetch_array($rs_fact);
    $codfacturatmp = $resultadoFact['codfactura'];

// Se actualiza a la nueva numeracion de factura

    if ($GLOBALS['setnumfac'] == 1) {

        $sel_articulos = "UPDATE facturastmp SET codfactura='" . $GLOBALS['numeracionfactura'] . "' WHERE codfactura='" . $codfacturatmp . "'";

        $rs_articulos = $conn->consulta($sel_articulos);

        $codfacturatmp = $GLOBALS['numeracionfactura'];
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Ventas</title>
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

        <script language="javascript">
            var contadorFilas = 1;

            $(document).ready(function () {

                if ($('#nombre').val().trim() == "") {
                    document.getElementById("nombre").value = "Venta Mostrador";
                    document.getElementById("codbarras").focus();
                }
                alertify.notify('Realizar una nueva factura', 'success', 6, null).dismissOthers();

            });

            var miPopup

            function abreVentana() {

                miPopup = window.open("ver_clientes.php", "miwin", "width=700,height=380,scrollbars=yes");

                miPopup.focus();

            }

            function cancelar() {

                window.location = "index.php";

            }



            function limpiarcaja() {

                document.getElementById("nombre").value = "";

            }

            function validarArticulo() {

                var codigo = document.getElementById("codbarras").value;

                miPopup = window.open("comprobararticulo.php?codbarras=" + codigo, "frame_datos", "width=700,height=80,scrollbars=yes");

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

                if (document.getElementById("remito").value == "")
                    mensaje += "  - N° de Remito\n";

                if (document.getElementById("numfactura").value == "")
                    mensaje += "  - N° de Factura\n";

                if (document.getElementById("contadorFilas").value == 0)
                    mensaje += "  - No se han agregado articulos\n";

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

                    $('#contadorFilas').attr('value', contadorFilas++);

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
            function ventanaArticulos() {


                miPopup = window.open("ver_articulos.php", "miwin", "width=700,height=500,scrollbars=yes");

                miPopup.focus();



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
        </script>

    </head>

    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">


                <a href="../../facturacion.php"><input id="bMenu" type="button" value="Menu Facturación"/></a>
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <button id="bEditarInfo">Detalles/Cuenta</button>
                <?php } ?>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>

            </div>
        </div>
        <div id="contenidoPrincipal">
            <input type="hidden" id="contadorFilas" value="0">
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;height: auto;">
                <div align="center">

                    <div id="tituloForm" class="header">NUEVA FACTURA </div>

                    <div id="frmBusqueda">

                        <form id="formulario" name="formulario" method="post" action="guardar_factura.php">

                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>

                                <tr>

                                    <td width="6%">Nombre</td>

                                    <td width="27%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45"></td>

                                    <td width="3%"></td>

                                    <td width="64%">
                                        <div style="margin:0 10px 6px 0; float:right;">N&deg; de Remito  <input style="margin:0 0 0 5px;" name="remito" id="remito" type="text"></div>						
                                    </td>

                                </tr>

                                <?php $hoy = date("d/m/Y"); ?>

                                <tr>

                                    <td width="6%">Fecha</td>

                                    <td width="27%"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<?php echo $hoy ?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0"  style="cursor:pointer;">

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

                                    <td width="64%"><input NAME="iva" type="text" class="cajaMinima" id="iva" size="5" maxlength="5" value="<?php echo $GLOBALS['ivaimp']; ?>" onChange="cambio_iva()"> % <div style="margin:0 10px 6px 0; float:right;">N&deg; de Factura <input name="numfactura" id="numfactura" type="text"></div>
                                    </td>

                                </tr>

                            </table>										

                    </div><div id="botonBusqueda">

                        <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">

                        <input id="baseimpuestos2" name="baseimpuestos" value="<?php echo $baseimpuestos ?>" type="hidden">

                        <input id="baseimponible2" name="baseimponible" value="<?php echo $baseimponible ?>" type="hidden">

                        <input id="preciototal2" name="preciototal" value="<?php echo $preciototal ?>" type="hidden">

                        <input id="accion" name="accion" value="alta" type="hidden"></div>

                    </form>

                    <br>

                    <div id="frmBusquedaVTASM">

                        <form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">

                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>

                                <tr>

                                    <td width="11%">Codigo barras </td>

                                    <td colspan="10" valign="middle"><input NAME="codbarras" type="text" class="cajaMedia" id="codbarras" size="15" maxlength="15"> <img src="../img/calculadora.jpg" border="1" align="absmiddle" onClick="validarArticulo()" style="cursor: pointer;" title="Validar codigo de barras"> <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" style="cursor:pointer;" title="Buscar articulo"></td>

                                </tr>

                                <tr>

                                    <td>Descripcion</td>

                                    <td width="19%"><input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" size="30" maxlength="30" readonly></td>

                                    <td width="5%">Precio<td><?php echo $GLOBALS['simbolomoneda']; ?></td></td>

                                    <td width="11%"><input NAME="precio" type="text" class="cajaPequena2" id="precio" size="10" maxlength="10" onChange="actualizar_importe()"></td>

                                    <td width="5%">Cantidad</td>

                                    <td width="5%"><input NAME="cantidad" type="text" class="cajaMinima" id="cantidad" size="10" maxlength="10" value="1" onChange="actualizar_importe()"></td>

                                    <td width="4%">Dcto.</td>

                                    <td width="9%"><input NAME="descuento" type="text" class="cajaMinima" id="descuento" size="10" maxlength="10" onChange="actualizar_importe()"><td>%</td></td>

                                    <td width="5%">Importe<td><?php echo $GLOBALS['simbolomoneda']; ?></td></td>

                                    <td width="11%"><input NAME="importe" type="text" class="cajaPequena2" id="importe" size="10" maxlength="10" value="0" readonly></td>

                                    <td width="15%"><img src="../img/botonagregar.jpg" border="1" onClick="validar()" style="cursor:pointer;"></td>

                                </tr>

                            </table>

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

                                <td width="73%" align="right"><div align="center"><?php echo $base ?> <?php echo $GLOBALS['simbolomoneda']; ?>

                                        <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12" value="<?php echo $baseimp ?>" align="right" readonly> 

                                    </div></td>

                            </tr>

                            <tr>

                                <td class="busqueda">IV</td>

                                <td align="right"><div align="center"><?php echo $GLOBALS['simbolomoneda']; ?>

                                        <input class="cajaTotales" name="baseimpuestos" type="text" id="baseimpuestos" size="12" align="right" value="<?php echo $baseiva ?>" readonly> 

                                    </div></td>

                            </tr>

                            <tr>

                                <td class="busqueda">Precio Total</td>

                                <td align="right"><div align="center"><?php echo $GLOBALS['simbolomoneda']; ?>

                                        <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" value="<?php echo $preciotot ?>" readonly> 

                                    </div></td>

                            </tr>

                        </table>

                    </div>

                    <br>

                    <br>

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

                    <div id="lineaResultadoVTASM">



                        <iframe width="100%" height="365" id="frame_lineas" name="frame_lineas" frameborder="0">

                        <ilayer width="100%" height="250" id="frame_lineas" name="frame_lineas"></ilayer>

                        </iframe>

                        <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">

                        <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>

                        </iframe>

                    </div>

                </div>

            </div>

        </div>			

    </div>
    <a href="#" class="scrollup">Scroll</a>
</body>
</html>
