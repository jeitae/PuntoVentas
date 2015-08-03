<?php
session_start();

if (!isset($_SESSION['idSession']) || $_SESSION['rol'] == 2) {

    header("Location:index.php");
}
?>

<!DOCTYPE html>

<html>
    <head>

        <meta charset="UTF-8">
        <title>Reportes</title>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/operaciones.js"></script>
        <link rel="shortcut icon" type="image/png" href="css/puntoVentasImg/icon.png" />

        <!-- CSS -->
        <link rel="stylesheet" href="css/alertify.min.css"/>
        <link rel="stylesheet" href="css/jquery-ui.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="css/themes/bootstrap.min.css"/>

        <link rel="stylesheet" href="css/style.css" type="text/css">

        <script>
            $(document).ready(function () {

                alertify.notify('Descargue un reporte del menu', 'custom', 6, null).dismissOthers();

            });
        </script>

    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">


                <a href="menu.php"><input id="bMenu" type="button" value="Menu Principal" style="margin-left: 8%;"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="includes/sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>

            </div>
        </div>
        <div id="contenidoPrincipal" >

            <header>
                <div>
                    <nav>
                        <img id="mensajePrincipal" src="css/mensaje.png" />
                    </nav>
                </div>
            </header>
            <section>
                <div id="MenuOpciones" style="margin-left: -5%; height: 300px; margin-top: 3%;">
                    <ul>
                        <li style="padding: 0%;">
                            <a href="includes/fpdf/imprimir_articulos_costo.php">
                                <img src="css/puntoVentasImg/coins15.png" title="Costo Articulos en Stock" /></a>Costo Articulos en Stock</li>
                        <li style="padding: 0%;">
                            <a href="includes/fpdf/imprimir_stocks_negativo.php">
                                <img src="css/puntoVentasImg/van18.png" title="Productos Stock negativo" /></a>Productos Stock negativo</li>

                        <li style="padding: 0%;">
                            <a href="includes/fpdf/imprimir_articulos_venta.php">
                                <img src="css/puntoVentasImg/price11.png" title="Precios Netos Tienda" /></a>Precios Netos Tienda</li>
                        <li style="padding: 0%;">
                            <a href="includes/fpdf/imprimir_articulos_proveedor.php">
                                <img src="css/puntoVentasImg/signing2.png" title="Articulos Proveedor" /></a>Articulos Proveedor</li>
                    </ul>
                </div>
            </section>
        </div>

    </body>
</html>
