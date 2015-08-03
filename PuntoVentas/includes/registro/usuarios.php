<?php
session_start();

if (!isset($_SESSION['idSession'])||$_SESSION['rol']==2) {

    header("Location:../../index.php");
} else {
    require "../sys/conexion.php";
    $conn = new conexion();


    if (isset($_POST['id']) || isset($_GET['id'])) {

        if (isset($_POST['id'])) {

            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $user_name = $_POST['user_name'];
            $user_email = $_POST['user_email'];
            $activation_code = $_POST['activation_code'];
            $joined = $_POST['joined'];
            $rol = $_POST['rol'];
            $user_activated = $_POST['user_activated'];

            $consulta = "update users set id='" . $id . "',full_name='" . $full_name . "',user_name='" . $user_name . "',user_email='" . $user_email . "',activation_code='" . $activation_code . "',joined='" . $joined . "',rol='" . $rol . "',user_activated='" . $user_activated . "' where id = '" . $id . "'";
            $resultado = $conn->consulta($consulta);

            if ($resultado != null) {

                $valor = "actualizar";
            } else {

                $valor = "actualizar_error";
            }

            header('Refresh: 3; URL=usuarios.php');
        }

        if (isset($_GET['id'])) {

            $id = $_GET['id'];
            $user_name = $_GET['user_name'];


            $consulta = "delete from users where id = '" . $id . "' and user_name = '" . $user_name . "'";
            $resultado = $conn->consulta($consulta);

            if ($resultado != null) {

                $valor = "eliminar";
            } else {

                $valor = "eliminar_error";
            }

            header('Refresh: 3; URL=usuarios.php');
        }
    } else {


        $query = "Select * from users order by id asc";

        $resultado = $conn->consulta($query);
    }
}
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset = "UTF-8">
        <title>Control Usuarios</title>
        <script type = "text/javascript" src = "../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />
        <link href="styles.css" rel="stylesheet" type="text/css">
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

                alertify.confirm('Cualquier cambio que se realize en este espacio no es reversible').autoCancel(10).set('onok', function () {
                    alertify.notify('Actua con cautela!', 'warning', 6, null).dismissOthers();
                }, 'oncancel', function () {
                    alertify.notify('Actua con cautela!', 'warning', 6, null).dismissOthers();
                });

                if ($('#mensajeUserValidar').val() == "actualizar") {

                    alertify.notify('Se actualizo el usuario correctamente', 'success', 6, null).dismissOthers();
                } else if ($('#mensajeUserValidar').val() == "actualizar_error") {
                    alertify.notify('Ocurrio un error al intentar actualizar el usuario', 'error', 6, null).dismissOthers();
                }

                if ($('#mensajeUserValidar').val() == "eliminar") {
                    alertify.notify('Se elimino el usuario correctamente', 'success', 6, null).dismissOthers();
                } else if ($('#mensajeUserValidar').val() == "eliminar_error") {
                    alertify.notify('Ocurrio un error al intentar actualizar el usuario', 'error', 6, null).dismissOthers();
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
                <input type="hidden" id="mensajeUserValidar" value="<?php echo $valor; ?>"/>

            </div>
        </div>
        <div id="contenidoPrincipal" >
            <div style="width: 98%;margin-top: 2%; margin-bottom: 4%;">
                <div id="notaUser" style="width: 35%; margin-top: 2%; margin-left: 5%;">
                    <table class="CSSTableGenerator">
                        <tr>
                            <th>Dato</th>
                            <th colspan="2">Valor</th>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td>1=Administrador</td>
                            <td>2=Vendedor</td>
                        </tr>
                        <tr>
                            <td>Estado</td>
                            <td>1=Activo</td>
                            <td>0=Suspendido</td>
                        </tr>                        
                    </table>
                </div>
                <table class="fuente8" style="width: 55%; margin-top: 5%; margin-left: 5%;">
                    <tr class="cabeceraTabla">
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Nombre Usuario</th>
                        
                        <th>Correo Electronico</th>
                        <th>Código de Activación</th>
                        <th>Agregado</th>
                        <th>Rol</th>
                        <th>Estado</th>

                    </tr>
                    <?php
                    while ($row = @$conn->fetch_array($resultado)) {
                        echo '<form action="usuarios.php" id="formularioUsers" method="post">';
                        echo '<tr class="itemImparTabla"><td class="aCentro"><input style="width:26px;" readonly="yes" title="No se puede editar" type="text" maxlength="20" name = "id" value = "' . $row['id'] . '"/></td>
                               <td><input type="text" maxlength="200" name = "full_name" value = "' . $row['full_name'] . '"/></td>
					<td><input style="width:100px;" type="text" maxlength="25" name = "user_name" value = "' . $row['user_name'] . '"/></td>
					
                                           <td><input type="text" maxlength="200" name = "user_email" value = "' . $row['user_email'] . '"/></td>
                                               <td><input style="width:80px;" type="text" maxlength="10" readonly="yes" title="No se puede editar" name = "activation_code" value = "' . $row['activation_code'] . '"/></td>
                                                   <td><input style="width:80px;" type="text" maxlength="20" readonly="yes" title="No se puede editar" name = "joined" value = "' . $row['joined'] . '"/></td>
                                                       <td><input style="width:26px;" type="text" maxlength="2" name = "rol" value = "' . $row['rol'] . '"/></td>
                                                           <td><input style="width:26px;" type="text" maxlength="2" name = "user_activated" value = "' . $row['user_activated'] . '"/></td>
                                                    
					<td><input type="submit" id="bActualizarUser" value="" title="Actualizar Usuario"></td>';
                        echo "</form>";
                        echo '<td><a href="usuarios.php?id=' . $row['id'] . '&user_name=' . $row['user_name'] . '"><button id="bEliminarUser" title="Eliminar Usuario"></button></a></td></tr>';
                    }
                    ?>

                </table>

            </div>
        </div>
        <a href="#" class="scrollup">Scroll</a>
    </body>
</html>

