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
        <title>Menu Usuarios</title>
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <script type="text/javascript" src="../../js/stickUp.min.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />

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
                alertify.notify('Estas en el control de usuarios', 'success', 6, null).dismissOthers();

            });
        </script>

    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">
                <a href="../../menu.php"><input id="bMenu" type="button" value="Menu Principal" style="margin-left: 8%;"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>


            </div>
        </div>
        <div id="contenidoPrincipal" >

            <header>
                <div>
                    <nav>
                        <img id="mensajePrincipal" src="../../css/mensaje.png" />
                    </nav>
                </div>
            </header>
            <section>
                <div id="MenuOpciones" style="height: 300px; margin-left: 20%;width: 50%;">
                    <ul style="margin-left: 8%;">
                        <li>
                            <a href="usuarios.php">
                                <img src="../../css/puntoVentasImg/shopper2.png" title="Usuarios" /></a>Usuarios</li>
                        <li>
                            <a href="register.php">
                                <img src="../../css/puntoVentasImg/onlinestore.png" title="Agregar Usuarios" /></a>Agregar Usuarios</li>
                    </ul>
                </div>
            </section>
        </div>
    </body>
</html>

