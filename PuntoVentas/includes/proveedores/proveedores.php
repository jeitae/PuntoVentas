<?php
session_start();

if (!isset($_SESSION['idSession'])||$_SESSION['rol']==2) {

    header("Location:../../index.php");
} else {

    require "../sys/conexion.php";
    $conn = new conexion();


    $codproveedor = @$_GET["codproveedor"];
    $nombre = @$_GET["nombre"];
    $nif = @$_GET["nif"];
    $codprovincia = @$_GET["cboProvincias"];
    $localidad = @$_GET["localidad"];
    $telefono = @$_GET["telefono"];
    $cadena_busqueda = @$_GET["cadena_busqueda"];

    $where = "1=1";
    if ($codproveedor <> "") {
        $where.=" AND codproveedor='$codproveedor'";
    }
    if ($nombre <> "") {
        $where.=" AND nombre like '%" . $nombre . "%'";
    }
    if ($nif <> "") {
        $where.=" AND nif like '%" . $nif . "%'";
    }
    if ($codprovincia > "0") {
        $where.=" AND codprovincia='$codprovincia'";
    }
    if ($localidad <> "") {
        $where.=" AND localidad like '%" . $localidad . "%'";
    }
    if ($telefono <> "") {
        $where.=" AND telefono like '%" . $telefono . "%'";
    }

    $where.=" ORDER BY nombre ASC";
    $query_busqueda = "SELECT count(*) as filas FROM proveedores WHERE borrado=0 AND " . $where;
    $rs_busqueda = $conn->consulta($query_busqueda);
    $filas = mysql_result($rs_busqueda, 0, "filas");
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Proveedores</title>
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
                alertify.notify('Estas en la seccion de control de proveedores', 'success', 6, null).dismissOthers();

            });
            function nuevo_proveedor() {
                miPopup = window.open("nuevo_proveedor.php", "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus();

            }

            function imprimir() {

                var codproveedor = document.getElementById("codproveedor").value;

                var nombre = document.getElementById("nombre").value;

                var nif = document.getElementById("nif").value;

                var provincia = document.getElementById("cboProvincias").value;

                var localidad = document.getElementById("localidad").value;

                var telefono = document.getElementById("telefono").value;
                if (codproveedor.trim() == "" || nif.trim() == "") {

                    alertify.notify('Debes introducir Código y NIF del proveedor para realizar la impresion', 'error', 6, null).dismissOthers();

                } else {
                    window.open("../fpdf/proveedores.php?codproveedor=" + codproveedor + "&nombre=" + nombre + "&nif=" + nif + "&provincia=" + provincia + "&localidad=" + localidad + "&telefono=" + telefono);
                }


            }



            function buscar() {

                var codproveedor = document.getElementById("codproveedor").value;

                var nombre = document.getElementById("nombre").value;

                var nif = document.getElementById("nif").value;

                var provincia = document.getElementById("cboProvincias").value;

                var localidad = document.getElementById("localidad").value;

                var telefono = document.getElementById("telefono").value;

//                if (codproveedor.trim() == "" || nif.trim() == "") {
//
//                    alertify.notify('Debes introducir Código y NIF del proveedor para realizar la busqueda', 'error', 6, null).dismissOthers();
//
//                } else {

                    alertify.confirm('Se procede a realizar la busqueda la misma Se cancelara en 5 segundos si no continua').autoCancel(5).set('onok', function () {
                        window.location = "proveedores.php?codproveedor=" + codproveedor + "&nombre=" + nombre + "&nif=" + nif + "&provincia=" + provincia + "&localidad=" + localidad + "&telefono=" + telefono;
                    }, 'oncancel', function () {
                        alertify.notify('Se ha cancelado la busqueda', 'error', 6, null).dismissOthers();
                    });
//                }
                
            }

            function limpiar() {

                document.getElementById("form_busqueda").reset();
                
            }



            var miPopup

            function abreVentana() {

                miPopup = window.open("ventana_proveedores.php", "miwin", "width=700,height=380,scrollbars=yes");

                miPopup.focus();

            }

            function ver_proveedor(codproveedor) {

                miPopup = window.open("ver_proveedor.php?codproveedor=" + codproveedor, "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus();

            }

            function modificar_proveedor(codproveedor) {

                miPopup = window.open("modificar_proveedor.php?codproveedor=" + codproveedor, "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus();

            }

            function eliminar_proveedor(codproveedor) {

                miPopup = window.open("eliminar_proveedor.php?codproveedor=" + codproveedor, "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus();

            }

            function refrescar() {
                window.location = "proveedores.php";
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
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;">
                <div align="center">
                    <div id="tituloForm" class="header">BUSCAR PROVEEDOR </div>

                    <div id="frmBusqueda">

                        <form id="form_busqueda" name="form_busqueda" action="" onsubmit="return false;">

                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					

                                <tr>

                                    <td width="16%">Codigo de proveedor </td>

                                    <td width="68%"><input id="codproveedor" type="text" class="cajaPequena" NAME="codproveedor" maxlength="10">  <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar proveedor" style="cursor:pointer;"></td>

                                    <td width="5%">&nbsp;</td>

                                    <td width="5%">&nbsp;</td>

                                    <td width="6%" align="right"></td>

                                </tr>

                                <tr>

                                    <td>Nombre</td>

                                    <td><input id="nombre" name="nombre" type="text" class="cajaGrande" maxlength="45"></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                </tr> 
                                <tr>

                                    <td>NIF</td>

                                    <td><input id="nif" type="text" class="cajaPequena" NAME="nif" maxlength="15" value="<?php echo $nif ?>"></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                </tr>
                                <tr>

                                    <td>Provincia</td>

                                    <td><select id="cboProvincias" name="cboProvincias" class="comboMedio">

                                            <option value="0" selected>Todas las provincias</option>
                                            <option value="1">San José</option>
                                            <option value="2">Alajuela</option>
                                            <option value="3">Cartago</option>
                                            <option value="4">Heredia</option>
                                            <option value="5">Guanacaste</option>
                                            <option value="6">Puntarenas</option>
                                            <option value="7">Limón</option>


                                        </select>	
                                    </td>

                                </tr>

                                <tr>

                                    <td>Localidad</td>

                                    <td><input id="localidad" type="text" class="cajaGrande" NAME="localidad" maxlength="30"></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                </tr>

                                <tr>

                                    <td>Tel&eacute;fono</td>

                                    <td><input id="telefono" type="text" class="cajaPequena" NAME="telefono" maxlength="15"></td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                </tr>

                            </table>
                        </form>
                    </div>
                    <div id="botonBusqueda" >
                        <img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" style="cursor:pointer;">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" style="cursor:pointer;">
                        <img src="../img/botonnuevoproveedor.jpg" width="130" height="22" border="1" onClick="nuevo_proveedor()" style="cursor:pointer;">
                        <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir()" style="cursor:pointer;">				
                        <img src="../img/restaurar.png" width="30" height="22" border="1" onClick="refrescar()" style="cursor:pointer;" title="Refrescar">			
                    </div>

                    <div id="cabeceraResultado" class="header">

                        RELACI&Oacute;N DE PROVEEDORES </div>

                    <div id="frmResultado">

                        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1" align="center">

                            <tr class="cabeceraTabla">

                                <td width="7%">COD. ART.</td>

                                <td width="7%">COD. REF.</td>

                                <td width="30%">NOMBRE </td>

                                <td width="13%">NIF</td>

                                <td width="19%">TELEFONO</td>

                                <td width="5%">&nbsp;</td>

                                <td width="5%">&nbsp;</td>

                                <td width="6%">&nbsp;</td>

                            </tr>


                            <input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas ?>">
                            <?php
                            if ($filas > 0) {
                                $sel_resultado = "SELECT * FROM proveedores WHERE borrado=0 AND " . $where;
                                $res_resultado = $conn->consulta($sel_resultado);
                                $contador = 0;
                                while ($contador < $conn->num_rows($res_resultado)) {
                                    if ($contador % 2) {
                                        $fondolinea = "itemParTabla";
                                    } else {
                                        $fondolinea = "itemImparTabla";
                                    }
                                    ?>
                                    <tr class="<?php echo $fondolinea ?>">
                                        <td class="aCentro" width="8%"><?php echo $contador + 1; ?></td>
                                        <td width="6%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "codproveedor") ?></div></td>
                                        <td width="38%"><div align="left"><?php echo mysql_result($res_resultado, $contador, "nombre") ?></div></td>
                                        <td class="aDerecha" width="13%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "nif") ?></div></td>
                                        <td class="aDerecha" width="19%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "telefono") ?></div></td>
                                        <td width="5%"><div align="center"><a href="#"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_proveedor(<?php echo mysql_result($res_resultado, $contador, "codproveedor") ?>)" title="Modificar"></a></div></td>
                                        <td width="5%"><div align="center"><a href="#"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_proveedor(<?php echo mysql_result($res_resultado, $contador, "codproveedor") ?>)" title="Visualizar"></a></div></td>
                                        <td width="6%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_proveedor(<?php echo mysql_result($res_resultado, $contador, "codproveedor") ?>)" title="Eliminar"></a></div></td>
                                    </tr>
                                    <?php
                                    $contador++;
                                }
                                ?>			
                            </table>
                        <?php } else { ?>
                            <table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n proveedor que cumpla con los criterios de b&uacute;squeda"; ?></td>
                                </tr>
                            </table>					
                        <?php } ?>
                    </div>
                </div>
            </div>			
            <a href="#" class="scrollup">Scroll</a>
        </div>
    </body>
</html>


