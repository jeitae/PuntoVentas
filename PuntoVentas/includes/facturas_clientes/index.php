<?php
session_start();

if (!isset($_SESSION['idSession']) || $_SESSION['rol'] == 2) {

    header("Location:../../index.php");
} else {


    require "../sys/conexion.php";
    $conn = new conexion();

    $cadena_busqueda = @$_GET["cadena_busqueda"];

    if (!isset($cadena_busqueda)) {
        $cadena_busqueda = "";
    } else {
        $cadena_busqueda = str_replace("", ",", $cadena_busqueda);
    }

    if ($cadena_busqueda <> "") {
        @$array_cadena_busqueda = split("~", $cadena_busqueda);
        @$nombre = $array_cadena_busqueda[1];
        @$numfactura = $array_cadena_busqueda[2];
        @$cboEstados = $array_cadena_busqueda[3];
        @$fechainicio = $array_cadena_busqueda[4];
        @$fechafin = $array_cadena_busqueda[5];
    } else {
        $nombre = "";
        $numfactura = "";
        $cboEstados = "";
        $fechainicio = "";
        $fechafin = "";
    }
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturas</title>
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

            $(document).ready(function () {

                document.getElementById("form_busqueda").submit();
                alertify.notify('Lista de facturas', 'success', 6, null).dismissOthers();


            });
            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function nueva_factura() {
                window.location = "../ventas_facturas/index.php";
            }

            function buscar() {
                var cadena;
                cadena = hacer_cadena_busqueda();
                document.getElementById("cadena_busqueda").value = cadena;
                if (document.getElementById("iniciopagina").value == "") {
                    document.getElementById("iniciopagina").value = 1;
                } else {
                    document.getElementById("iniciopagina").value = document.getElementById("paginas").value;
                }
                document.getElementById("form_busqueda").submit();

                document.getElementById("frame_rejilla").style.visibility = "visible";
            }

            function paginar() {
                document.getElementById("iniciopagina").value = document.getElementById("paginas").value;
                document.getElementById("form_busqueda").submit();
            }

            function hacer_cadena_busqueda() {
                var nombre = document.getElementById("nombre").value;
                var numfactura = document.getElementById("numfactura").value;
                var cboEstados = document.getElementById("cboEstados").value;
                var fechainicio = document.getElementById("fechainicio").value;
                var fechafin = document.getElementById("fechafin").value;
                var cadena = "";
                cadena = "~" + nombre + "~" + numfactura + "~" + cboEstados + "~" + fechainicio + "~" + fechafin + "~";
                return cadena;
            }

            function limpiar() {
                document.getElementById("form_busqueda").reset();
            }

            function abreVentana() {
                miPopup = window.open("ventana_clientes.php", "miwin", "width=700,height=380,scrollbars=yes");
                miPopup.focus();
            }

            function refrescar() {
                window.location = "index.php";
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
                    <div id="tituloForm" class="header">BUSCAR FACTURA </div>
                    <div id="frmBusqueda">
                        <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">
                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
                                <tr>
                                    <td>Nombre</td>
                                    <td><input id="nombre" name="nombre" type="text" class="cajaGrande" maxlength="45" value="<?php echo $nombre ?>"></td>
                                    <td><div style="margin:0 10px 6px 0; float:right;">N&deg; de Remito
                                            <input style="margin:0 0 0 5px;" name="remito" id="remito" type="text">
                                        </div></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Num. Factura</td>
                                    <td><input id="numfactura" type="text" class="cajaPequena" NAME="numfactura" maxlength="15" value="<?php echo $numfactura ?>"></td>
                                    <td><div style="margin:0 10px 6px 0; float:right;">N&deg; de Factura
                                            <input name="numfactura2" id="numfactura2" type="text">
                                        </div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Estado</td>
                                    <td><select id="cboEstados" name="cboEstados" class="comboMedio">
                                            <option value="0" selected>Todos los estados</option>
                                            <option value="1">Sin Pagar</option>
                                            <option value="2">Pagada</option>			
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Fecha de inicio</td>
                                    <td><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" value="<?php echo $fechainicio ?>" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" onMouseOver="this.style.cursor = 'pointer'" title="Calendario">
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                    {
                                                        inputField: "fechainicio",
                                                        ifFormat: "%d/%m/%Y",
                                                        button: "Image1"
                                                    }
                                            );
                                        </script>	</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Fecha de fin</td>
                                    <td><input id="fechafin" type="text" class="cajaPequena" NAME="fechafin" maxlength="10" value="<?php echo $fechafin ?>" readonly><img src="../img/calendario.png" name="Image2" id="Image2" width="16" height="16" border="0" onMouseOver="this.style.cursor = 'pointer'" title="Calendario">
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                    {
                                                        inputField: "fechafin",
                                                        ifFormat: "%d/%m/%Y",
                                                        button: "Image2"
                                                    }
                                            );
                                        </script></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor = cursor">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" onMouseOver="style.cursor = cursor">
                        <img src="../img/botonnuevafactura.jpg" width="106" height="22" border="1" onClick="nueva_factura()" onMouseOver="style.cursor = cursor">					
                        <img src="../img/restaurar.png" width="30" height="22" border="1" onClick="refrescar()" style="cursor:pointer;" title="Refrescar">			
                    </div>
                    <div id="lineaResultado">
                        <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="34%" align="left">N de facturas encontradas 
                                    <input id="filas" type="text" class="cajaPequena" NAME="filas" maxlength="5" readonly>
                                </td>
                                <td width="48%">
                                    Monto adeudado de las facturas actuales
                                    <input id="totalfacturas" type="text" class="cajaPequena" name="totalfacturas" maxlength="5" readonly>

                                </td>
                                <td width="18%" align="right">Mostrados 
                                    <select name="paginas" id="paginas" onChange="paginar()">
                                    </select></td>
                        </table>
                    </div>
                    <div id="cabeceraResultado" class="header">
                        RELACI&Oacute;N DE FACTURAS </div>
                    <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="8%">N. FACTURA</td>
                                <td width="20%">CLIENTE </td>							
                                <td width="8%">IMPORTE</td>
                                <td width="10%">FECHA</td>
                                <td width="10%">ESTADO</td>
                                <td width="10%">&nbsp;</td>
                                <td width="10%">&nbsp;</td>
                                <td width="10%">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" id="iniciopagina" name="iniciopagina">
                    <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
                    </form>
                    <div id="lineaResultado_pagos">
                        <iframe width="100%" height="250" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                        <ilayer width="100%" height="250" id="frame_rejilla" name="frame_rejilla"></ilayer>
                        </iframe>
                        <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
                        <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
                        </iframe>
                    </div>
                </div>
            </div>			

        </div>
        <a href="#" class="scrollup">Scroll</a>
    </body>
</html>
