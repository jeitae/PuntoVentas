<?php
session_start();

if (!isset($_SESSION['idSession'])||$_SESSION['rol']==2) {

    header("Location:../../index.php");
} else {

    require "../sys/conexion.php";
    $conn = new conexion();
    $codfamilia = @$_GET["codfamilia"];
    $nombre = @$_GET["nombre"];
    $cadena_busqueda = @$_GET["cadena_busqueda"];
    $where = "1=1";
    if ($codfamilia != "") {
        $where.=" AND codfamilia='$codfamilia'";
    }
    if ($nombre != "") {
        $where.=" AND nombre like '%" . $nombre . "%'";
    }

    $where.=" ORDER BY nombre ASC";
    $query_busqueda = "SELECT count(*) as filas FROM familias WHERE borrado=0 AND " . $where;
    $rs_busqueda = $conn->consulta($query_busqueda);
    $filas = mysql_result($rs_busqueda, 0, "filas");
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Categoria de Articulos</title>
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

                alertify.notify('Estas en la seccion de familias de articulos', 'success', 6, null).dismissOthers();

            });

            function nueva_familia() {
                miPopup = window.open("nueva_familia.php", "miwin", "width=1200,height=200,scrollbars=yes");
                miPopup.focus();

            }

            function ver_familia(codfamilia) {
                miPopup = window.open("ver_familia.php?codfamilia=" + codfamilia, "miwin", "width=1200,height=500,scrollbars=yes");
                miPopup.focus();


            }

            function modificar_familia(codfamilia) {
                miPopup = window.open("modificar_familia.php?codfamilia=" + codfamilia, "miwin", "width=1200,height=500,scrollbars=yes");
                miPopup.focus();

            }

            function eliminar_familia(codfamilia) {
                miPopup = window.open("eliminar_familia.php?codfamilia=" + codfamilia, "miwin", "width=1200,height=500,scrollbars=yes");
                miPopup.focus();
            }
            function buscar() {
                var codfamilia = document.getElementById("codfamilia").value;
                var nombre = document.getElementById("nombre").value;
                if (codfamilia.trim() == "") {

                    alertify.notify('Debes introducir el código y el nombre de la familia a buscar', 'error', 6, null).dismissOthers();

                } else {

                    alertify.confirm('Se procede a realizar la busqueda la misma Se cancelara en 5 segundos si no continua').autoCancel(5).set('onok', function () {
                        window.location = "familias.php?codfamilia=" + codfamilia + "&nombre=" + nombre;
                    }, 'oncancel', function () {
                        alertify.notify('Se ha cancelado la busqueda', 'error', 6, null).dismissOthers();
                    });
                }
            }
            function imprimir() {
                var codfamilia = document.getElementById("codfamilia").value;
                var nombre = document.getElementById("nombre").value;
//                if (codfamilia.trim() == "" ) {
//
//                    alertify.notify('Debes introducir el código y el nombre de la familia a imprimir', 'error', 6, null).dismissOthers();
//
//                } else {
                    window.open("../fpdf/familias.php?codfamilia=" + codfamilia + "&nombre=" + nombre);
//                }
            }
            function limpiar() {
                document.getElementById("form_busqueda").reset();
            }
            function refrescar() {
                window.location = "familias.php";
            }


        </script>

    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">


                <a href="../../inventario.php"><input id="bMenu" type="button" value="Menu Inventario"/></a>
                <button id="bEditarInfo">Detalles/Cuenta</button>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>

            </div>
        </div>
        <div id="contenidoPrincipal" >
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;">
                <div align="center">
                    <div id="tituloForm" class="header">BUSCAR FAMILIA </div>
                    <div id="frmBusqueda">
                        <form id="form_busqueda" name="form_busqueda" action="" onsubmit="return false;">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
                                <tr>
                                    <td width="16%">Codigo de familia </td>
                                    <td width="68%"><input id="codfamilia" type="text" class="cajaPequena" NAME="codfamilia" maxlength="3"></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="6%" align="right"></td>
                                </tr>
                                <tr>
                                    <td>Nombre</td>
                                    <td><input id="nombre" name="nombre" type="text" class="cajaGrande" maxlength="20" title="Palabra contenida en el nombre"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" style="cursor:pointer;" title="Realizar Busqueda">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" style="cursor:pointer;" title="Limpiar Campos de Busqueda">
                        <img src="../img/botonnuevafamilia.jpg" width="106" height="22" border="1" onClick="nueva_familia()" style="cursor:pointer;" title="Ingresar una nueva familia">
                        <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir()" style="cursor:pointer;" title="Imprimir la familia">			
                        <img src="../img/restaurar.png" width="30" height="22" border="1" onClick="refrescar()" style="cursor:pointer;" title="Refrescar">			
                    </div>
                    <div id="cabeceraResultado" class="header">
                        RELACION DEFAMILIAS </div>
                    <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="12%">ITEM</td>
                                <td width="20%">CODIGO</td>
                                <td width="50%">NOMBRE </td>
                                <td width="6%">&nbsp;</td>
                                <td width="6%">&nbsp;</td>
                                <td width="6%">&nbsp;</td>
                            </tr>

                            <input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas ?>">
                            <?php
                            if ($filas > 0) {
                                ?>
                                <?php
                                $sel_resultado = "SELECT * FROM familias WHERE borrado=0 AND " . $where;
                                $res_resultado = $conn->consulta($sel_resultado);
                                $contador = 0;
                                while ($contador < @$conn->num_rows($res_resultado)) {
                                    if ($contador % 2) {
                                        $fondolinea = "itemParTabla";
                                    } else {
                                        $fondolinea = "itemImparTabla";
                                    }
                                    ?>
                                    <tr class="<?php echo $fondolinea ?>">
                                        <td class="aCentro" width="12%"><?php echo $contador + 1; ?></td>
                                        <td width="20%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "codfamilia") ?></div></td>
                                        <td width="50%"><div align="left"><?php echo mysql_result($res_resultado, $contador, "nombre") ?></div></td>
                                        <td width="6%"><div align="center"><a href="#"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_familia(<?php echo mysql_result($res_resultado, $contador, "codfamilia") ?>)" title="Modificar"></a></div></td>
                                        <td width="6%"><div align="center"><a href="#"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_familia(<?php echo mysql_result($res_resultado, $contador, "codfamilia") ?>)" title="Visualizar"></a></div></td>
                                        <td width="6%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_familia(<?php echo mysql_result($res_resultado, $contador, "codfamilia") ?>)" title="Eliminar"></a></div></td>
                                    </tr>
                                    <?php
                                    $contador++;
                                }
                                ?>			

                            <?php } else { ?>

                                <tr>
                                    <td colspan="6" width="100%" class="mensaje"><?php echo "No hay ninguna familia que cumpla con los criterios de b&uacute;squeda"; ?></td>
                                </tr>

                            <?php } ?>					
                    </div>                            
                    </table>
                </div>
            </div>         
        </div>
        <a href="#" class="scrollup">Scroll</a>

    </body>
</html>

