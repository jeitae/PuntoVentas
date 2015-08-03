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

        $fechainicio = $array_cadena_busqueda[1];
    } else {

        $fechainicio = "";
    }



    $hoy = date("d/m/Y");
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Caja Diaria</title>
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
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
        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
        <script>
            $(document).ready(function () {
                document.getElementById("formulario").submit();
                alertify.notify('Cierre de Caja', 'success', 6, null).dismissOthers();
            });
            //	setTimeout("location.href='index.php'",4000);

            var cursor;

            if (document.all) {

                // Est� utilizando EXPLORER

                cursor = 'hand';

            } else {

                // Est� utilizando MOZILLA/NETSCAPE

                cursor = 'pointer';

            }

            function buscar() {

                var cadena;

                cadena = hacer_cadena_busqueda();

                document.getElementById("cadena_busqueda").value = cadena;

                document.getElementById("formulario").submit();
                document.getElementById("frame_rejilla").style.visibility = "visible";

            }



            function hacer_cadena_busqueda() {

                var fechainicio = document.getElementById("fechainicio").value;

                var cadena = "";

                cadena = "~" + fechainicio + "~";

                return cadena;

            }

        </script>

    </head>

    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">
                <a href="../../menu.php"><input id="bMenu" type="button" value="Menu Principal"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>
            </div>
        </div>
        <div id="contenidoPrincipal" >
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;height: auto;">
                <div align="center" style="margin-left:2%;">

                    <div id="tituloForm" class="header">BUSCAR FECHA</div>

                    <div id="frmBusquedaCC">

                        <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">

                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					

                                <tr>

                                    <td width="12%" height="60" align="left" valign="middle">Fecha de cierre</td>

                                    <td width="21%" align="center" valign="middle"><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" value="<?php echo $hoy ?>" readonly>&nbsp&nbsp&nbsp<img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor = 'pointer'" title="Calendario">

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

                            </table>

                    </div>

                    <div id="botonBusquedaBC"><img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor = cursor"></div>

                    <div id="lineaResultado">

                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                            <tr>

                                <td width="50%" align="left"></td>

                                <td width="50%" align="right"></td>

                        </table>

                    </div>

                    <div id="cabeceraResultadoCC" class="header">DETALLES CIERRE CAJA</div>

                    <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">

                    </form>

                    <br>

                    <div id="lineaResultadoCC">

                        <iframe width="99%" height="430" id="frame_rejilla" name="frame_rejilla" frameborder="0">

                        <ilayer width="80%" height="430" id="frame_rejilla" name="frame_rejilla"></ilayer>

                        </iframe>

                    </div>

                    <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">

                    <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>

                    </iframe>

                </div>			

            </div>

        </div>

        <a href="#" class="scrollup">Scroll</a>

    </body>
</html>