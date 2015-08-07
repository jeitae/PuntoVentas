<?php
session_start();

if (!isset($_SESSION['idSession']) || $_SESSION['rol'] == 2) {

    header("Location:../../index.php");
} else {

    require "../sys/conexion.php";
    $conn = new conexion();

    /*
     * Se optiene el codigo de articulo y la referencia mediante get (url)
     * para realizar la consulta del articulo deseado
     */
    $codarticulo = @$_GET["codarticulo"];
    $referencia = @$_GET["referencia"];
    $cadena_busqueda = @$_GET["cadena_busqueda"];


    /*
     * Se realiza la cadena de consulta dependiendo del codigo y referencia
     * reciba.
     */

    $where = "1=1";
    if ($codarticulo != "") {
        $where.=" AND codarticulo='$codarticulo'";
    }
    if ($referencia != "") {
        $where.=" AND referencia like '%" . $referencia . "%'";
    }

    $where.=" ORDER BY codarticulo ASC";
    $query_busqueda = "SELECT count(*) as filas FROM articulos WHERE borrado=0 AND " . $where;
    $rs_busqueda = $conn->consulta($query_busqueda);
    $filas = mysql_result($rs_busqueda, 0, "filas"); //Posicion 0 de los resultados optenidos
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario</title>
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
                alertify.notify('Estas en la seccion de control de articulos', 'success', 6, null).dismissOthers();

            });

            function nuevo_articulo() {
                /*
                 * Se abre una ventana emergente para realizar la busqueda de los articulos
                 * Parametros: Ventana para abrir, nombreUnicoIdentificador del popup, dimenciones y caracteristicas
                 */

                miPopup = window.open("nuevo_articulo.php", "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus(); //
            }

            function imprimir() {
                
                var codarticulo = document.getElementById("codarticulo").value;
                var referencia = document.getElementById("referencia").value;
                if (referencia.trim() == "") { //Se requiere la referencia o parte de esta como campo obligatorio

                    alertify.notify('Debes introducir la referencia y el código del articulo a imprimir', 'error', 6, null).dismissOthers();

                } else {
                    window.open("../fpdf/articulos.php?codarticulo=" + codarticulo + "&referencia=" + referencia);
                }


            }

            function limpiar_busqueda() {
                document.getElementById("codarticulo").value = "";
                document.getElementById("referencia").value = "";

            }

            function buscar() {
                var codarticulo = document.getElementById("codarticulo").value;
                var referencia = document.getElementById("referencia").value;
                if (codarticulo.trim() == "" || referencia.trim() == "") {

                    alertify.notify('Debes introducir la referencia y el código del articulo a buscar', 'error', 6, null).dismissOthers();

                } else {

                    alertify.confirm('Se procede a realizar la busqueda la misma Se cancelara en 5 segundos si no continua').autoCancel(5).set('onok', function () {
                        window.location = "articulos.php?codarticulo=" + codarticulo + "&referencia=" + referencia;
                    }, 'oncancel', function () {
                        alertify.notify('Se ha cancelado la busqueda', 'error', 6, null).dismissOthers();
                    });
                }
            }

            function ventanaArticulos() {
                miPopup = window.open("ventana_articulos.php", "miwin", "width=700,height=500,scrollbars=yes");
                miPopup.focus();
            }

            function ver_articulo(codarticulo) {
                miPopup = window.open("ver_articulo.php?codarticulo=" + codarticulo, "miwin", "width = 1200, height = 650, scrollbars = yes");
                miPopup.focus();

            }

            function modificar_articulo(codarticulo) {

                miPopup = window.open("modificar_articulo.php?codarticulo=" + codarticulo, "miwin", "width = 1200, height = 650, scrollbars = yes");
                miPopup.focus();
            }

            function cambiar_imagen(codarticulo) {
                miPopup = window.open("cambiar_imagen.php?codarticulo=" + codarticulo, "miwin", "width = 1000, height = 400, scrollbars = yes");
                miPopup.focus();

            }

            function eliminar_articulo(codarticulo) {
                miPopup = window.open("eliminar_articulo.php?codarticulo=" + codarticulo, "miwin", "width = 1200, height = 650, scrollbars = yes");
                miPopup.focus();

            }
            function refrescar() {
                window.location = "articulos.php";
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
                    <div id="tituloForm" class="header">BUSCAR ARTICULO </div>
                    <div id="frmBusqueda">
                        <form id="form_busqueda" name="form_busqueda" action="" onsubmit="return false;" >
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
                                <tr>
                                    <td width="16%">C&oacute;digo de art&iacute;culo </td>
                                    <td width="68%"><input id="codarticulo" type="text" class="cajaPequena" NAME="codarticulo" maxlength="15" readonly="yes"> <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" style="cursor:pointer;" title="Buscar articulos"></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="6%" align="right"></td>
                                </tr>
                                <tr>
                                    <td>Referencia</td>
                                    <td><input id="referencia" name="referencia" type="text" class="cajaGrande" maxlength="20"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </form>
                    </div>

                    <div id="botonBusqueda">
                        <img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" style="cursor:pointer;">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar_busqueda()" style="cursor:pointer;">
                        <img src="../img/botonnuevoarticulo.jpg" width="111" height="22" border="1" onClick="nuevo_articulo()" style="cursor:pointer;">
                        <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir()" style="cursor:pointer;">
                        <img src="../img/restaurar.png" width="30" height="22" border="1" onClick="refrescar()" style="cursor:pointer;" title="Refrescar">			
                    </div>				
                    <div id="cabeceraResultado" class="header">
                        Relaci&oacute;n de ARTICULOS </div>
                    <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="4%">ITEM</td>
                                <td width="5%">COD</td>
                                <td width="19%">REFERENCIA</td>
                                <td width="27%">DESCRIPCION </td>
                                <td width="9%">FAMILIA</td>
                                <td width="11%">PRECIO T.</td>
                                <td width="5%">STOCK</td>
                                <td width="5%">&nbsp;</td>
                                <td width="5%">&nbsp;</td>
                                <td width="5%">&nbsp;</td>
                                <td width="5%">&nbsp;</td>
                            </tr>
                            <input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas ?>">
                            <?php
                            if ($filas > 0) {

                                $sel_resultado = "SELECT * FROM articulos WHERE borrado=0 AND " . $where;
                                @$res_resultado = $conn->consulta($sel_resultado);
                                $contador = 0;
                                while ($contador < $conn->num_rows($res_resultado)) {
                                    /*
                                     * Se imprimin los resultados de los articulos de acuerdo al resultado de la consulta
                                     * segun el codigo del articulo
                                     */
                                    if ($contador % 2) { //Se establece la clase de la linea
                                        $fondolinea = "itemParTabla";
                                    } else {
                                        $fondolinea = "itemImparTabla";
                                    }
                                    ?>
                                    <tr class="<?php echo $fondolinea; ?>">
                                        <td class="aCentro" width="4%"><?php echo $contador + 1; ?></td>
                                        <td width="5%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "codarticulo") ?></div></td>
                                        <td width="19%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "referencia") ?></div></td>
                                        <td width="27%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "descripcion") ?></div></td>
                                        <td width="9%"><div align="center">
                                                <?php
                                                $codfamilia = mysql_result($res_resultado, $contador, "codfamilia");
                                                $query_familia = "SELECT nombre FROM familias WHERE codfamilia='$codfamilia'";
                                                $rs_familia = $conn->consulta($query_familia);
                                                $nombre_familia = mysql_result($rs_familia, 0, "nombre");
                                                echo $nombre_familia;
                                                ?>
                                            </div></td>
                                        <td class="aCentro" width="11%"><div align="center"><?php echo mysql_result($res_resultado, $contador, "precio_tienda") ?></div></td>
                                        <td class="aCentro" width="5%"><?php echo mysql_result($res_resultado, $contador, "stock") ?></td>
                                        <td width="5%"><div align="center"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_articulo(<?php echo mysql_result($res_resultado, $contador, "codarticulo") ?>)" title="Modificar"></div></td>
                                        <td width="5%"><div align="center"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_articulo(<?php echo mysql_result($res_resultado, $contador, "codarticulo"); ?>)" title="Visualizar"></div></td>
                                        <td width="5%"><div align="center"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_articulo(<?php echo mysql_result($res_resultado, $contador, "codarticulo") ?>)" title="Eliminar"></div></td>
                                        <td width="5%"><div align="center"><img src="../img/img_change.gif" width="16" height="16" border="0" onClick="cambiar_imagen(<?php echo mysql_result($res_resultado, $contador, "codarticulo") ?>)" title="Modificar imagen"></div></td>
                                    </tr>
                                    <?php
                                    $contador++;
                                }
                                ?>			
                            </table>
                        <?php } else { ?>
                            <table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td colspan="7" width="100%" class="mensaje"><?php echo "No hay ning&uacute;n art&iacute;culo que cumpla con los criterios de b&uacute;squeda"; ?></td>
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


