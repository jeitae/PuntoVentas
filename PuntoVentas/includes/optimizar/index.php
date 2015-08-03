<?php
session_start();
if (!isset($_SESSION['idSession']) || $_SESSION['rol'] == 2) {
    header("Location:../../index.php");
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Optimizar Sistema</title>
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
        <script>
            $(document).ready(function () {
                alertify.notify('Optimizar Sistema de Punto de Ventas', 'success', 6, null).dismissOthers();
            });
        </script>
        <style>
            /* ESTILO DE LA TABLA */
            .tabla_optimizar {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 10px;
                font-weight: normal;
                color: #666666;
                background-color: #e1e1e1; 
                border: 1px dotted #999999; 
            }
            /* ESTILO DEL BOTON: MOUSE OUT */
            .boton_optimizar_off {
                border: solid 1px #999999;
                color: #999999;
                background:#e1e1e1 ;
                padding:5px; 

            }
            /* ESTILO DEL BOTON: MOUSE OVER */
            .boton_optimizar_on {
                border: solid 1px #999999;
                background: #CCCCFF;
                color: #333333;
                padding:5px; 

            }
        </style>

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
                    <div id="tituloForm" class="header">Optimizar el sistema </div>
                    <div id="frmBusqueda">
                        <table width="100%" border="0" cellpadding="5" cellspacing="10" class="tabla_optimizar">
                            <tr>
                                <td><img src="../img/restaurar.png" width="16" height="16"> Esta herramienta permite eliminar los residuos que se han generado con la continua utilizacion del sistema. Esta depuraci&oacute;n otorga grandes beneficios entre los que se encuentran un aumento de la velocidad de procesamiento, asi como una mayor estabilidad de trabajo. La depuraci&oacute;n de la base da datos es uno de los procesos que deben ser tomados en cuenta para aprovechar al maximo la potencialidad del sistema. Para proceder, haga click en el boton &quot;optimizar ahora&quot;.</td>
                            </tr>
                            <tr>
                                <td><div align="center">
                                        <?php
                                        $mensaje = @$_GET['mensaje'];
                                        if ($mensaje == "confirmar") {
                                            ?>
                                            <img src="../img/error3.png" width="16" height="16"><strong>La base de datos se ha optimizada correctamente. </strong><a href="index.php" style="text-decoration:none; color:#990000"><strong>[X]</strong></a>
                                        <?php }if ($mensaje == "error") { ?>
                                            <img src="../img/error2.png" width="16" height="16"> <strong>Se ha producido un error en la optimizaci&oacute;n. </strong> <a href="index.php" style="text-decoration:none; color:#990000"><strong>[X]</strong></a>
                                        <?php }if ($mensaje == "") { ?>
                                        </div>
                                        <form action="optmizar.php">
                                            <div align="center">
                                                <input type="submit" 
                                                       value="Optimizar ahora &raquo;" 
                                                       class="boton_optimizar_off" 
                                                       onmouseover="this.className = 'boton_optimizar_on'" 
                                                       onmouseout="this.className = 'boton_optimizar_off'">
                                            </div>
                                        </form>
                                    <?php } ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="scrollup">Scroll</a>

    </body>
</html>