<?php
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");
include("../barcode/barcode.php");

header('Cache-Control: no-cache');
header('Pragma: no-cache');



$accion = @$_POST["accion"];
if (!isset($accion)) {
    $accion = @$_GET["accion"];
}

$referencia = @$_POST["Areferencia"];
$codfamilia = @$_POST["AcboFamilias"];
$descripcion = @$_POST["Adescripcion"];
$codimpuesto = @$_POST["AcboImpuestos"];
$codproveedor1 = @$_POST["acboProveedores1"];
$codproveedor2 = @$_POST["acboProveedores2"];
$descripcion_corta = @$_POST["Adescripcion_corta"];
$codubicacion = @$_POST["AcboUbicacion"];
$stock_minimo = @$_POST["nstock_minimo"];
$stock = @$_POST["nstock"];
$aviso_minimo = @$_POST["aaviso_minimo"];
$datos = @$_POST["adatos"];
$fecha = @$_POST["fecha"];
$modificar_ticket = @$_POST["modificar_ticket"];
$fechalis = $fecha;
if ($fecha <> "") {
    $fecha = explota($fecha);
} else {
    $fecha = "0000-00-00";
}
$codembalaje = @$_POST["AcboEmbalaje"];
$unidades_caja = @$_POST["nunidades_caja"];
$precio_ticket = @$_POST["aprecio_ticket"];
$modif_descrip = @$_POST["amodif_descrip"];
$observaciones = @$_POST["aobservaciones"];
$precio_compra = @$_POST["qprecio_compra"];
$precio_almacen = @$_POST["qprecio_almacen"];
$precio_tienda = @$_POST["qprecio_tienda"];
//$pvp=$_POST["qpvp"];
$precio_iva = @$_POST["qprecio_iva"];
$codigobarras = @$_POST["barras"];
$foto = @$_POST["foto"];



if ($accion == "alta") {
    $sel_comp = "SELECT * FROM articulos WHERE referencia='$referencia' AND borrado=0";
    $rs_comp = $conn->consulta($sel_comp);
    if ($conn->num_rows($rs_comp) > 0) {
        ?><script>
            alert("No se puede dar de alta a este articulo, ya existe uno con esta referencia.");
            window.close();
        </script><?php
    } else {

        $foto_name = "";

        $query_operacion = "INSERT INTO articulos (codarticulo, codfamilia, referencia, descripcion, impuesto, codproveedor1, codproveedor2, descripcion_corta, codubicacion, stock, stock_minimo, aviso_minimo, datos_producto, fecha_alta, codembalaje, unidades_caja, precio_ticket, modificar_ticket, observaciones, precio_compra, precio_almacen, precio_tienda, precio_iva, codigobarras, imagen, borrado) 
        VALUES ('', '$codfamilia', '$referencia', '$descripcion', '$codimpuesto', '$codproveedor1', '$codproveedor2', '$descripcion_corta', '$codubicacion', '$stock', '$stock_minimo', '$aviso_minimo', '$datos', '$fecha', '$codembalaje', '$unidades_caja', '$precio_ticket', '$modificar_ticket', '$observaciones', '$precio_compra', '$precio_almacen', '$precio_tienda', '$precio_iva','$codigobarras', '$foto_name','0')";

        $rs_operacion = $conn->consulta($query_operacion);
        $codarticulo = mysql_insert_id();


        if (isset($_POST['accion'])) {
            if (is_uploaded_file($_FILES['foto']['tmp_name'])) { // verifica haya sido cargado el archivo 
                if (move_uploaded_file($_FILES['foto']['tmp_name'], "../fotos/fotosubida.jpg")) { // se coloca en su lugar final 
                }
            }

            //		$codarticulo=$_POST['codigo'];
            $foto_name = "foto" . $codarticulo . ".jpg";
            $foto_namea = "fotosubida.jpg";
            $query_operacion = "UPDATE articulos SET imagen='$foto_name' WHERE codarticulo='$codarticulo'";
            $rs_operacion = $conn->consulta($query_operacion);
            //		$foto_nameb="no_img.jpg";
            if (file_exists("../fotos/$foto_namea")) {
                copy("../fotos/$foto_namea", "../fotos/$foto_name");
                unlink("../fotos/$foto_namea");
            }
        } else {
            $codarticulo = $_POST['codigo'];
        }







        //	    $foto_name="foto".$codarticulo.".jpg";
        //	    $foto_namea="fotosubida.jpg";
        //		$query_operacion="UPDATE articulos SET imagen='$foto_name' WHERE codarticulo='$codarticulo'";				
        //		$rs_operacion=$conn->consulta($query_operacion);
        //        if (! copy ("../fotos/$foto_namea", "../fotos/$foto_name")) 
        //		{
        // echo "<h2>No se ha podido copiar el archivo  111</h2>\n";
        //		};

        $codaux = $codarticulo;
        while (strlen($codaux) < 6) {
            $codaux = "0" . $codaux;
        }
        // el 84 lo he puesto por lo de españa el 0000 representa el código de la empresa

        if ($codigobarras == 'Automatico') {
            $codigobarras = "560000" . $codaux;
            $pares = $codigobarras[0] + $codigobarras[2] + $codigobarras[4] + $codigobarras[6] + $codigobarras[8] + $codigobarras[10];
            $impares = $codigobarras[1] + $codigobarras[3] + $codigobarras[5] + $codigobarras[7] + $codigobarras[9] + $codigobarras[11];
            $impares = $impares * 3;
            $total = $impares + $pares;
            $resto = $total % 10;
            if ($resto == 0) {
                $valor = 0;
            } else {
                $valor = 10 - $resto;
            }
            $codigobarras = $codigobarras . "" . $valor;
        }

        $sel_actualizar = "UPDATE articulos SET codigobarras='$codigobarras' WHERE codarticulo='$codarticulo'";
        $rs_actualizar = $conn->consulta($sel_actualizar);

        if ($rs_operacion) {
            $mensaje = "El articulo ha sido dado de alta correctamente";
        }
        $cabecera1 = "Inicio >> Articulos &gt;&gt; Nuevo Articulo ";
        $cabecera2 = "INSERTAR ARTICULO ";
    }
}

if ($accion == "modificar") {
    $codarticulo = $_POST["id"];
    $cadena = "";
    ?>

    <?php
    if (@$foto_name <> "") {
        @$foto_name = "foto" . $codarticulo . ".jpg";
        unlink("../fotos/$foto_name");
        $cadena = "imagen=" . $foto_name;
        if (!copy($foto, "../fotos/$foto_name")) {
            echo "<h2>No se ha podido copiar el archivo</h2>\n";
        };
    };
    $query = "UPDATE articulos SET codfamilia='$codfamilia', referencia='$referencia', descripcion='$descripcion', impuesto='$codimpuesto', codproveedor1='$codproveedor1', codproveedor2='$codproveedor2', descripcion_corta='$descripcion_corta', codubicacion='$codubicacion', stock='$stock', stock_minimo='$stock_minimo', aviso_minimo='$aviso_minimo', datos_producto='$datos', fecha_alta='$fecha', codembalaje='$codembalaje', unidades_caja='$unidades_caja', precio_ticket='$precio_ticket', modificar_ticket='$modif_descrip', observaciones='$observaciones', precio_compra='$precio_compra', precio_almacen='$precio_almacen', precio_tienda='$precio_tienda', precio_iva='$precio_iva', codigobarras='$codigobarras', " . $cadena . " borrado=0 WHERE codarticulo='$codarticulo'";
    $rs_query = $conn->consulta($query);
    if ($rs_query) {
        $mensaje = "Los datos del articulo han sido modificados correctamente";
    }
    $cabecera1 = "Inicio >> Articulos &gt;&gt; Modificar Articulo ";
    $cabecera2 = "MODIFICAR ARTICULO ";
    $sel_img = "SELECT imagen,codigobarras FROM articulos WHERE codarticulo='$codarticulo'";
    $rs_img = $conn->consulta($sel_img);
    $foto_name = mysql_result($rs_img, 0, "imagen");
    $codigobarras = mysql_result($rs_img, 0, "codigobarras");
}

if ($accion == "baja") {
    $codarticulo = $_GET["codarticulo"];
    $query = "UPDATE articulos SET borrado=1 WHERE codarticulo='$codarticulo'";
    $rs_query = $conn->consulta($query);
    if ($rs_query) {
        $mensaje = "El articulo ha sido eliminado correctamente";
    }
    $cabecera1 = "Inicio >> Articulos &gt;&gt; Eliminar Articulo ";
    $cabecera2 = "ELIMINAR ARTICULO ";
    $query_mostrar = "SELECT * FROM articulos WHERE codarticulo='$codarticulo'";
    $rs_mostrar = $conn->consulta($query_mostrar);
    $codarticulo = mysql_result($rs_mostrar, 0, "codarticulo");
    $referencia = mysql_result($rs_mostrar, 0, "referencia");
    $codfamilia = mysql_result($rs_mostrar, 0, "codfamilia");
    $descripcion = mysql_result($rs_mostrar, 0, "descripcion");
    $codimpuesto = mysql_result($rs_mostrar, 0, "impuesto");
    $codproveedor1 = mysql_result($rs_mostrar, 0, "codproveedor1");
    $codproveedor2 = mysql_result($rs_mostrar, 0, "codproveedor2");
    $descripcion_corta = mysql_result($rs_mostrar, 0, "descripcion_corta");
    $codubicacion = mysql_result($rs_mostrar, 0, "codubicacion");
    $stock_minimo = mysql_result($rs_mostrar, 0, "stock_minimo");
    $stock = mysql_result($rs_mostrar, 0, "stock");
    $aviso_minimo = mysql_result($rs_mostrar, 0, "aviso_minimo");
    $datos = mysql_result($rs_mostrar, 0, "datos_producto");
    $fecha = mysql_result($rs_mostrar, 0, "fecha_alta");
    if ($fecha <> "0000-00-00") {
        $fechalis = implota($fecha);
    }
    $codembalaje = mysql_result($rs_mostrar, 0, "codembalaje");
    $unidades_caja = mysql_result($rs_mostrar, 0, "unidades_caja");
    $precio_ticket = mysql_result($rs_mostrar, 0, "precio_ticket");
    $modif_descrip = mysql_result($rs_mostrar, 0, "modificar_ticket");
    $observaciones = mysql_result($rs_mostrar, 0, "observaciones");
    $precio_compra = mysql_result($rs_mostrar, 0, "precio_compra");
    $precio_almacen = mysql_result($rs_mostrar, 0, "precio_almacen");
    $precio_tienda = mysql_result($rs_mostrar, 0, "precio_tienda");
    //$pvp=mysql_result($rs_mostrar,0,"precio_pvp");
    $precio_iva = mysql_result($rs_mostrar, 0, "precio_iva");
    $foto_name = mysql_result($rs_mostrar, 0, "imagen");
    $codigobarras = mysql_result($rs_mostrar, 0, "codigobarras");
}
?>

<html>
    <head>
        <title>Principal</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <script language="javascript">
            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function aceptar() {
                window.close();
                window.opener.location.reload();
            }

        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $cabecera2 ?></div>
                    <div id="frmBusqueda">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="15%"></td>
                                <td colspan="2" class="mensaje"><?php echo $mensaje; ?></td>
                            </tr>
                            <tr>
                                <td width="15%">C&oacute;digo</td>
                                <td width="58%"><?php echo $codarticulo ?></td>
                                <td width="27%" rowspan="11" align="center" valign="top"><img src="../fotos/<?php echo $foto_name ?>" width="160px" height="140px" border="1"></td>
                            </tr>
                            <tr>
                                <td width="15%">Referencia</td>
                                <td width="58%"><?php echo $referencia ?></td>
                            </tr>
                            <?php
                            $query_familia = "SELECT * FROM familias WHERE codfamilia='$codfamilia'";
                            $res_familia = $conn->consulta($query_familia);
                            $nombrefamilia = mysql_result($res_familia, 0, "nombre");
                            ?>
                            <tr>
                                <td width="15%">Familia</td>
                                <td width="58%"><?php echo $nombrefamilia ?></td>
                            </tr>
                            <tr>
                                <td width="15%">Descripci&oacute;n</td>
                                <td width="58%"><?php echo $descripcion; ?></td>
                            </tr>
                            <tr>
                                <td>Impuesto</td>
                                <td><?php echo $codimpuesto; ?> %</td>
                            </tr>
                            <?php
                            if ($codproveedor1 <> 0) {
                                $query_proveedor = "SELECT * FROM proveedores WHERE codproveedor='$codproveedor1'";
                                $res_proveedor = $conn->consulta($query_proveedor);
                                @$nombreproveedor = mysql_result($res_proveedor, 0, "nombre");
                            } else {
                                $nombreproveedor = "Sin determinar";
                            }
                            ?>
                            <tr>
                                <td width="15%">Proveedor1</td>
                                <td width="58%"><?php echo $nombreproveedor; ?></td>
                            </tr>
                            <?php
                            if ($codproveedor2 <> 0) {
                                $query_proveedor = "SELECT * FROM proveedores WHERE codproveedor='$codproveedor2'";
                                $res_proveedor = $conn->consulta($query_proveedor);
                                @$nombreproveedor = mysql_result($res_proveedor, 0, "nombre");
                            } else {
                                $nombreproveedor = "Sin determinar";
                            }
                            ?>
                            <tr>
                                <td width="15%">Proveedor2</td>
                                <td width="58%"><?php echo $nombreproveedor; ?></td>
                            </tr>
                            <tr>
                                <td width="15%">Descripci&oacute;n corta</td>
                                <td width="58%"><?php echo $descripcion_corta; ?></td>
                            </tr>
                            <?php
                            if ($codubicacion <> 0) {
                                $query_ubicacion = "SELECT * FROM ubicaciones WHERE codubicacion='$codubicacion'";
                                $res_ubicacion = $conn->consulta($query_ubicacion);
                                @$nombreubicacion = mysql_result($res_ubicacion, 0, "nombre");
                            } else {
                                $nombreubicacion = "Sin determinar";
                            }
                            ?>
                            <tr>
                                <td width="15%">Ubicaci&oacute;n</td>
                                <td width="58%"><?php echo $nombreubicacion; ?></td>
                            </tr>
                            <tr>
                                <td>Stock</td>
                                <td><?php
                                    echo $stock;
                                    ;
                                    ?> unidades</td>
                            </tr>
                            <tr>
                                <td>Stock minimo</td>
                                <td><?php echo $stock_minimo ?> unidades</td>
                            </tr>
                            <tr>
                                <td>Aviso M&iacute;nimo</td>
                                <td colspan="2">
                                    <?php
                                    if ($aviso_minimo == 0) {
                                        echo "No";
                                    } else {
                                        echo "Si";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%">Datos del producto</td>
                                <td colspan="2"><?php echo $datos ?></td>
                            </tr>
                            <tr>
                                <td width="15%">Fecha de alta</td>
                                <td colspan="2"><?php echo $fechalis ?></td>
                            </tr>
                            <?php
                            if ($codembalaje <> 0) {
                                $query_embalaje = "SELECT * FROM embalajes WHERE codembalaje='$codembalaje'";
                                $res_embalaje = $conn->consulta($query_embalaje);
                                @$nombreembalaje = mysql_result($res_embalaje, 0, "nombre");
                            } else {
                                $nombreembalaje = "Sin determinar";
                            }
                            ?>
                            <tr>
                                <td width="15%">Embalaje</td>
                                <td colspan="2"><?php echo $nombreembalaje; ?></td>
                            </tr>
                            <tr>
                                <td>Unidades por caja</td>
                                <td colspan="2"><?php echo $unidades_caja; ?> unidades</td>
                            </tr>
                            <tr>
                                <td>Preguntar precio ticket</td>
                                <td colspan="2">
                                    <?php
                                    if ($precio_ticket == 0) {
                                        echo "No";
                                    } else {
                                        echo "Si";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Modificar descrip. ticket</td>
                                <td colspan="2">
                                    <?php
                                    if ($modif_descrip == 0) {
                                        echo "No";
                                    } else {
                                        echo "Si";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td colspan="2"><?php echo $observaciones; ?></td>
                            </tr>
                            <tr>
                                <td>Precio de compra</td>
                                <td colspan="2"><?php echo @$GLOBALS['simbolomoneda']; ?><?php echo $precio_compra; ?>  </td></td>
                            </tr>
                            <tr>
                                <td>Precio almac&eacute;n</td>
                                <td colspan="2"><?php echo @$GLOBALS['simbolomoneda']; ?><?php echo $precio_almacen; ?>  </td></td>
                            </tr>												
                            <tr>
                                <td>Precio en tienda</td>
                                <td colspan="2"><?php echo @$GLOBALS['simbolomoneda']; ?><?php echo $precio_tienda; ?>  </td></td>
                            </tr>
                            <!--<tr>
                                    <td>Pvp</td>
                                    <td colspan="2"><?php echo $pvp ?> &#36;</td>
                            </tr>-->
                            <tr>
                                <td>Precio con IV</td>
                                <td colspan="2"><?php echo @$GLOBALS['simbolomoneda']; ?><?php echo $precio_iva; ?>  </td></td>
                            </tr>
                            <tr>
                                <td>Codigo de barras</td>
                                <td colspan="2"><?php echo "<img src='../barcode/barcode.php?encode=EAN-13&bdata=" . $codigobarras . "&height=50&scale=2&bgcolor=%23FFFFEC&color=%23333366&type=jpg'>"; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor = cursor">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
