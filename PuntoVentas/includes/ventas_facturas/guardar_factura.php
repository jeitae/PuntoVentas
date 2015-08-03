<?php
session_start();

if (!isset($_SESSION['idSession'])) {

    header("Location:../../index.php");
} else {

    if (!isset($_SESSION['user'])) {
        die("Access Denied");
    }
    $tmpvendedor = $_SESSION['user'];
//finsesion
    require "../sys/conexion.php";
    $conn = new conexion();
    include ("../funciones/fechas.php");

    $accion = $_POST["accion"];
    if (!isset($accion)) {
        $accion = $_GET["accion"];
    }

    $codfacturatmp = $_POST["codfacturatmp"];
    $nombreCliente = $_POST["nombre"];
    $fecha = explota($_POST["fecha"]);
    $iva = $_POST["iva"];
    $remito = $_POST["remito"];
    $numfactura = $_POST["numfactura"];
    $minimo = 0;

    if ($accion == "alta") {

        $query_operacion = "INSERT INTO facturas (codfactura, numfactura, fecha, iva, nombreCliente, estado, borrado, remito, fvendedor) VALUES ('', '$numfactura', '$fecha', '$iva', '$nombreCliente', '1', '0', '$remito', '$tmpvendedor')";
        $rs_operacion = $conn->consulta($query_operacion);
        $codfactura = mysql_insert_id();

        // Se guarda la nueva numeracion de factura
        if ($GLOBALS['setnumfac'] == 1) {
            $GLOBALS['setnumfac'] = 0;
            $sel_articulos = "UPDATE facturas SET codfactura='" . $GLOBALS['numeracionfactura'] . "' WHERE codfactura='$codfactura'";
            $rs_articulos = $conn->consulta($sel_articulos);

            $sel_articulos = "UPDATE parametros SET setnumfac=0 WHERE indice=1";
            $rs_articulos = $conn->consulta($sel_articulos);
            $codfactura = $GLOBALS['numeracionfactura'];
        }

        if ($rs_operacion) {
            $mensaje = "La factura ha sido dada de alta correctamente";
        }
        $query_tmp = "SELECT * FROM factulineatmp WHERE codfactura='$codfacturatmp' ORDER BY numlinea ASC";
        $rs_tmp = $conn->consulta($query_tmp);
        $contador = 0;
        $baseimponible = 0;
        while ($contador < $conn->num_rows($rs_tmp)) {
            $codfamilia = mysql_result($rs_tmp, $contador, "codfamilia");
            $numlinea = mysql_result($rs_tmp, $contador, "numlinea");
            $codigo = mysql_result($rs_tmp, $contador, "codigo");
            $cantidad = mysql_result($rs_tmp, $contador, "cantidad");
            $precio = mysql_result($rs_tmp, $contador, "precio");
            $importe = mysql_result($rs_tmp, $contador, "importe");
            $baseimponible = $baseimponible + $importe;
            $dcto = mysql_result($rs_tmp, $contador, "dcto");
            $sel_insertar = "INSERT INTO factulinea (codfactura,numlinea,codfamilia,codigo,cantidad,precio,importe,dcto,fvendedor) VALUES 
		('$codfactura','$numlinea','$codfamilia','$codigo','$cantidad','$precio','$importe','$dcto','$tmpvendedor')";
            $rs_insertar = $conn->consulta($sel_insertar);
            $sel_articulos = "UPDATE articulos SET stock=(stock-'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
            $rs_articulos = $conn->consulta($sel_articulos);
            $sel_minimos = "SELECT stock,stock_minimo,descripcion FROM articulos where codarticulo='$codigo' AND codfamilia='$codfamilia'";
            $rs_minimos = $conn->consulta($sel_minimos);
            if ((mysql_result($rs_minimos, 0, "stock") < mysql_result($rs_minimos, 0, "stock_minimo")) or ( mysql_result($rs_minimos, 0, "stock") <= 0)) {
                @$mensaje_minimo = $mensaje_minimo . " " . mysql_result($rs_minimos, 0, "descripcion") . "<br>";
                $minimo = 1;
            }
            $contador++;
        }
        $baseimpuestos = $baseimponible * ($iva / 100);
        $preciototal = $baseimponible + $baseimpuestos;
        //$preciototal=number_format($preciototal,2);	
        $sel_act = "UPDATE facturas SET totalfactura='$preciototal' WHERE codfactura='$codfactura'";
        $rs_act = $conn->consulta($sel_act);
        $baseimpuestos = 0;
        $baseimponible = 0;
        $preciototal = 0;
        $cabecera1 = "Inicio >> Ventas &gt;&gt; Venta Mostrador ";
        $cabecera2 = "NUEVA VENTA ";
    }
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Guardar Factura</title>
        <script type="text/javascript" src="../../js/alertify.min.js"></script>
        <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../js/operaciones.js"></script>
        <link rel="shortcut icon" type="image/png" href="../../css/puntoVentasImg/icon.png" />
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>

        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>

        <script type="text/javascript" src="../funciones/validar.js"></script>
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

        <script language="javascript">
            var cursor;
            if (document.all) {
                // Est� utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Est� utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function aceptar() {
                window.location = "index.php"
            }

            function imprimir(codfactura) {
                window.open("../fpdf/imprimir_facturamx.php?codfactura=" + codfactura);
            }

            function efectuarpago(codfactura, nombreCliente, importe) {
                miPopup = window.open("efectuarpago.php?codfactura=" + codfactura + "&nombreCliente=" + nombreCliente + "&importe=" + importe, "miwin", "width = 1200, height = 650, scrollbars = yes");
            }

        </script>
    </head>
    <body>
        <div id="menu">
            <div id="panelSuperior" style="width: 70%;margin-left: 20%;">


                <a href="../../facturacion.php"><input id="bMenu" type="button" value="Menu Facturación"/></a>
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <button id="bEditarInfo">Detalles/Cuenta</button>
                <?php } ?>
                <a href="../sys/validaciones/cerrarSession.php"><button id="bCerrarSesion">Cerrar Sesion</button></a>

            </div>
        </div>
        <div id="contenidoPrincipal" >
            <div style="width: 98%;margin-top: 4%; margin-bottom: 4%;">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $cabecera2; ?></div>
                    <div id="frmBusqueda">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="15%"></td>
                                <td width="85%" colspan="2" class="mensaje"><?php echo $mensaje; ?></td>
                            </tr>
                            <?php if ($minimo == 1) { ?>
                                <tr>
                                    <td width="15%"></td>
                                    <td width="85%" colspan="2" class="mensajeminimo">Los siguientes art&iacute;culos est&aacute;n bajo m&iacute;nimo:<br><?php echo $mensaje_minimo; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td width="15%">Cliente</td>
                                <td width="85%" colspan="2"><?php echo $nombreCliente; ?></td>
                            </tr>
                            <tr>
                                <td>C&oacute;digo de factura</td>
                                <td colspan="2"><?php echo $codfactura; ?></td>
                            </tr>
                            <tr>
                                <td>Fecha</td>
                                <td colspan="2"><?php echo implota($fecha); ?></td>
                            </tr>
                            <tr>
                                <td>IV</td>
                                <td colspan="2"><?php echo $iva ?> %</td>
                            </tr>
                            <tr>
                                <td>N&deg; Factura</td>
                                <td colspan="2"><?php echo $numfactura ?> </td>
                            </tr>
                            <tr>
                                <td>N&deg; Remito</td>
                                <td colspan="2"><?php echo $remito ?> </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="5%">ITEM</td>
                                <td width="20%">FAMILIA</td>
                                <td width="15%">REFERENCIA</td>
                                <td width="30%">DESCRIPCION</td>
                                <td width="7%">CANTIDAD</td>
                                <td width="8%">PRECIO</td>
                                <td width="7%">DCTO %</td>
                                <td width="8%">IMPORTE</td>
                            </tr>
                        </table>
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                            <?php
                            $sel_lineas = "SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
                            $rs_lineas = $conn->consulta($sel_lineas);
                            for ($i = 0; $i < $conn->num_rows($rs_lineas); $i++) {
                                $numlinea = mysql_result($rs_lineas, $i, "numlinea");
                                $codfamilia = mysql_result($rs_lineas, $i, "codfamilia");
                                $nombrefamilia = mysql_result($rs_lineas, $i, "nombrefamilia");
                                $codarticulo = mysql_result($rs_lineas, $i, "codarticulo");
                                $referencia = mysql_result($rs_lineas, $i, "referencia");
                                $descripcion = mysql_result($rs_lineas, $i, "descripcion");
                                $cantidad = mysql_result($rs_lineas, $i, "cantidad");
                                $precio = mysql_result($rs_lineas, $i, "precio");
                                $importe = mysql_result($rs_lineas, $i, "importe");
                                $baseimponible = $baseimponible + $importe;
                                $descuento = mysql_result($rs_lineas, $i, "dcto");
                                if ($i % 2) {
                                    $fondolinea = "itemParTabla";
                                } else {
                                    $fondolinea = "itemImparTabla";
                                }
                                ?>
                                <tr class="<?php echo $fondolinea ?>">
                                    <td width="5%" class="aCentro"><?php echo $i + 1 ?></td>
                                    <td width="20%"><?php echo $nombrefamilia ?></td>
                                    <td width="15%"><?php echo $referencia ?></td>
                                    <td width="30%"><?php echo $descripcion ?></td>
                                    <td width="7%" class="aCentro"><?php echo $cantidad ?></td>
                                    <td width="8%" class="aCentro"><?php echo $precio ?></td>
                                    <td width="7%" class="aCentro"><?php echo $descuento ?></td>
                                    <td width="8%" class="aCentro"><?php echo $importe ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php
                    $baseimpuestos = $baseimponible * ($iva / 100);
                    $preciototal = $baseimponible + $baseimpuestos;
                    $preciototal = $preciototal;
                    ?>
                    <div id="frmBusqueda">
                        <table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                            <tr>
                                <td width="35%"><b>Sub-Total</b></td>
                                <td width="25%" align="right"><?php echo $simbolomoneda ?> <?php echo number_format($baseimponible, 2, ".", ","); ?>&nbsp&nbsp&nbsp</td>
                            </tr>    
                            <tr>
                                <td width="35%"><b>IV</b></td>
                                <td width="25%" align="right"><?php echo $simbolomoneda ?> <?php echo number_format($baseimpuestos, 2, ".", ","); ?>&nbsp&nbsp&nbsp</td>
                            </tr>
                            <tr>
                                <td width="35%"><b>Total</b></td>
                                <td width="25%" align="right"><?php echo $simbolomoneda ?> <?php echo number_format($preciototal, 2, ".", ","); ?>&nbsp&nbsp&nbsp</td>
                            </tr>
                        </table>
                    </div>
                    <div id="botonBusqueda">
                        <div align="center">
                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" style="cursor:pointer;">
                            <!--<img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php echo $codfactura ?>)" style="cursor:pointer;">-->
                        </div>
                        <br>
                        <div align="center" id="cajareg">
                            <img src="../img/caja.png" width="80" height="77" border="1" onClick="efectuarpago('<?php echo $codfactura; ?>', '<?php echo $nombreCliente; ?>', '<?php echo $preciototal; ?>');" style="cursor:pointer;" title="Efectuar pago">
                        </div>
                    </div>
                </div>
            </div>			

        </div>
        <a href="#" class="scrollup">Scroll</a>
    </body>
</html>

