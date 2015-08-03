<?php
session_start();

if (!isset($_SESSION['idSession'])||$_SESSION['rol']==2) {

    header("Location:../../index.php");
} else {
    require "../sys/conexion.php";
    $conn = new conexion();

    if (@$_POST['Submit'] == 'Cambiar') {
        $rsPwd = $conn->consulta("select user_pwd from users where user_name='".$_SESSION['user']."'") or die(mysql_error());
        list ($oldpwd) = mysql_fetch_row($rsPwd);

        if ($oldpwd == md5($_POST['oldpwd'])) {
            $newpasswd = md5($_POST['newpwd']);

            $conn->consulta("Update users
  				SET user_pwd = '".$newpasswd."'
				WHERE user_name = '".$_SESSION['user']."'
				") or die(mysql_error());
            $valor = "success";
        } else {
            $valor = "error";
        }
    }
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cambiar Clave</title>
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <script type="text/javascript" src="../../js/stickUp.min.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />
        <link href="styles.css" rel="stylesheet" type="text/css">
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
                if ($('#mensajeUserValidar').val() == "success") {

                    alertify.notify('Se actualizo la contraseña correctamente', 'success', 6, null).dismissOthers();
                }

                if ($('#mensajeUserValidar').val() == "error") {
                    alertify.notify('Ha ocurrido un error al cambiar la contraseña', 'error', 6, null).dismissOthers();
                }
            });

        </script>


    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">
                <a href="../registro/index.php"><input id="bMenu" type="button" value="Menu Usuarios" style="margin-left: 8%;"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>


            </div>
        </div>
        <div id="contenidoPrincipal" >
            <div style="width: 50%;margin-top: 4%; margin-bottom: 4%; margin-left: 35%;">
                <input type="hidden" id="mensajeUserValidar" value="<?php echo $valor; ?>"/>
                <h2>Cambiar la Clave</h2>
                <form action="cambiaclave.php" method="post" name="form3" id="form3">
                    <p>Clave Antigua: 
                        <input name="oldpwd" type="password" id="oldpwd">
                    </p>
                    <p>Nueva Clave: 
                        <input name="newpwd" type="password" id="newpwd">
                    </p>
                    <p> 
                        <input name="Submit" type="submit" id="Submit" value="Cambiar">
                    </p>
                </form>
            </div>
        </div>
        <a href="#" class="scrollup">Scroll</a>
    </body>
</html>
