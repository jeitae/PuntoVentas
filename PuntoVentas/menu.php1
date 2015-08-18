<?php
session_start();

if (!isset($_SESSION['idSession'])) {

    header("Location:index.php");
} else {
    
    /**
     * 
     * Se importa la clase de conexion para utilizar sus metodos,
     * se lleva a cabo una consulta para validar el rol de usuario
     * logueado en el Sistema cada vez que se ingresa al menu del
     * punto de ventas.
     * 
     */
    require "includes/sys/conexion.php";
    $conn = new conexion();

    $consulta = "select rol from users where user_name = '" . $_SESSION['user'] . "'";
    $resultado = $conn->consulta($consulta);
    $row = $conn->fetch_array($resultado);
    $_SESSION['rol'] = $row['rol'];
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Menu Principal</title>
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/operaciones.js"></script>
        <script type="text/javascript" src="js/stickUp.min.js"></script>
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
                jQuery(function ($) {
                    $(document).ready(function () {

                        $('#menu').stickUp(); //Para visualizar el menu superior lateral derecho a la vista del usuario. Menu es el div donde se debe mantener el contenido
                    });
                });
                alertify.notify('Bienvenido al Sistema de Punto de Ventas: <?php echo $_SESSION['user']; ?>', 'success', 6, null).dismissOthers();

            });
        </script>

    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior">

                <label id="lBienvenida">Bienvenido al Sistema de Punto de Ventas: <?php echo $_SESSION['user']; ?></label>
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <button id="bEditarInfo">Detalles/Cuenta</button>
                <?php } ?>
                <a href="includes/sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>


            </div>
        </div>
        <div id="contenidoPrincipal">

            <header>
                <div>
                    <nav>
                        <img id="mensajePrincipal" src="css/mensaje.png" />
                    </nav>
                </div>
            </header>
            <section>
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <div id="MenuOpciones">
                        <ul>
                            <li>
                                <a href="inventario.php">
                                    <img src="css/puntoVentasImg/clipboard52.png" title="Inventario" /></a>Inventario</li>
                            <li>
                                <a href="facturacion.php">
                                    <img src="css/puntoVentasImg/shop3.png" title="Facturacion" /></a>Facturacion</li>
                            <li>
                                <a href="includes/proveedores/proveedores.php">
                                    <img src="css/puntoVentasImg/man251.png" title="Proveedores"/></a>Proveedores</li>
                            <li>
                                <a href="includes/parametros/parametros.php">
                                    <img src="css/puntoVentasImg/graduate33.png" title="Paramentros de la Empresa"/></a>Paramentros de la Empresa</li>

                            <li>
                                <a href="includes/registro/index.php">
                                    <img src="css/puntoVentasImg/shopping159.png" title="Administrar Usuarios"/></a>Administrar Usuarios</li>

                            <li>
                                <a href="includes/cerrarcaja/index.php">
                                    <img src="css/puntoVentasImg/closed66.png" title="Caja Diaria"/></a>Cierre de Caja</li>

                            <li>
                                <a href="reportes.php">
                                    <img src="css/puntoVentasImg/briefcase51.png" title="Reportes del Sistema"/></a>Reportes</li>

                            <li>
                                <a href="includes/optimizar/index.php">
                                    <img src="css/puntoVentasImg/coin3.png" title="Optimizar Sistema"/></a>Optimizar Sistema</li>

                        </ul>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['rol'] == 2) { ?>
                    <div id="MenuOpciones" style="height: 300px; margin-left: 20%;width: 50%;">
                        <ul style="margin-left: 35%;">
                            <!--                            <li>
                                                            <a href="inventario.php">
                                                                <img src="css/puntoVentasImg/clipboard52.png" title="Inventario" /></a>Inventario</li>-->
                            <li>
                                <a href="facturacion.php">
                                    <img src="css/puntoVentasImg/shop3.png" title="Facturacion" /></a>Facturacion</li>
                            <!--                            <li>
                                                                <a href="proveedores.php">
                                                                    <img src="css/puntoVentasImg/man251.png" title="Proveedores"/></a>Proveedores</li>
                                                            <li>
                                                                <a href="includes/parametros/index.php">
                                                                    <img src="css/puntoVentasImg/graduate33.png" title="Paramentros de la Empresa"/></a>Paramentros de la Empresa</li>
                                
                                                            <li>
                                                                <a href="includes/registro/index.php">
                                                                    <img src="css/puntoVentasImg/shopping159.png" title="Administrar Usuarios"/></a>Administrar Usuarios</li>-->

                        </ul>
                    </div>
                <?php } ?>
            </section>
        </div>

    </body>
</html>
