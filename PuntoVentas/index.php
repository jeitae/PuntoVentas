<?php
session_start();

if (isset($_SESSION['idSession'])) {

    header("Location:menu.php");
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
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

        <title>Iniciar Sesion</title>
    </head>
    <body>
        <div id="menu">
            <div id="Div1">
                <input type="hidden" id="mensajeAccion"/>
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
                <form id="formLogin" action="" onsubmit="return false;">

                    <div id="contenidoLogin">
                        <h1>Ingrese los Datos Correspondientes</h1>
                        <table>
                            <tr>
                                <td>Usario:</td>
                                <td>
                                    <input type="text" id="tUsuario" class="inputs" MaxLength="20" title="Nombre de Usuario" Width="137px"/>
                                </td>

                            </tr>
                            <tr>
                                <td>Contraseña:</td>
                                <td>
                                    <input type="password" id="tPass" class="inputs" title="Contraseña" MaxLength="20" Width="136px"></asp:TextBox>
                                </td>
                                <!--<td><a id="recupContra" href="#">¿Olvido la Contraseña?</a></td>-->
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" id="bEntrar" class="botonAccion" value="Entrar" Width="82px"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </section>
        </div>
    </body>
</html>
