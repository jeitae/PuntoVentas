<?php
require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");

$nombre = @$_POST["nombre"];
$numfactura = @$_POST["numfactura"];
$estado = @$_POST["cboEstados"];
$fechainicio = @$_POST["fechainicio"];
if ($fechainicio <> "") {
    @$fechainicio = explota($fechainicio);
}
$fechafin = @$_POST["fechafin"];
if ($fechafin <> "") {
    @$fechafin = explota($fechafin);
}
$remito = @$_POST["remito"];
$numfactura2 = @$_POST["numfactura2"];

$cadena_busqueda = @$_POST["cadena_busqueda"];

$where = "1=1";
if ($remito <> "") {
    $where.=" AND remito='$remito'";
}
if ($numfactura2 <> "") {
    $where.=" AND numfactura='$numfactura2'";
}
if ($nombre <> "") {
    $where.=" AND nombreCliente like '%" . $nombre . "%'";
}
if ($numfactura <> "") {
    $where.=" AND codfactura='$numfactura'";
}
if ($estado > "0") {
    $where.=" AND estado='$estado'";
}
if (($fechainicio <> "") and ( $fechafin <> "")) {
    $where.=" AND fecha between '" . $fechainicio . "' AND '" . $fechafin . "'";
} else {
    if ($fechainicio <> "") {
        $where.=" and fecha>='" . $fechainicio . "'";
    } else {
        if ($fechafin <> "") {
            $where.=" and fecha<='" . $fechafin . "'";
        }
    }
}

$where.=" ORDER BY codfactura DESC";
$query_busqueda = "SELECT count(*) as filas FROM facturas WHERE borrado=0 AND " . $where;
$rs_busqueda = @$conn->consulta($query_busqueda);
$filas = @mysql_result($rs_busqueda, 0, "filas");

$query_busqueda = "SELECT * FROM facturas WHERE borrado=0 AND estado=1 AND " . $where;
$rs_busqueda = @$conn->consulta($query_busqueda);

$totalfacturas = 0;
while ($row = @$conn->fetch_array($rs_busqueda, MYSQL_ASSOC)) {
    $totalfacturas+=$row["totalfactura"];
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Facturas Clientes</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <script language="javascript">

            function ver_factura(codfactura) {
                miPopup = window.open("ver_factura.php?codfactura=" + codfactura + "&cadena_busqueda=<?php echo $cadena_busqueda ?>", "miwin", "width=1200,height=650,scrollbars=yes");
                miPopup.focus();

            }

            function modificar_factura(codfactura, marcaestado) {

                if (marcaestado == 1) {
                    miPopup = window.open("modificar_factura.php?codfactura=" + codfactura + "&cadena_busqueda=<?php echo $cadena_busqueda ?>", "miwin", "width=1200,height=650,scrollbars=yes");
                    miPopup.focus();
                } else {
                    alert("No puede modificar una factura ya pagada.");
                }
            }

            function eliminar_factura(codfactura) {
                if (confirm("Atencion va a proceder a la eliminacion de una factura. Desea continuar?")) {
                    miPopup = window.open("eliminar_factura.php?codfactura=" + codfactura + "&cadena_busqueda=<?php echo $cadena_busqueda ?>", "miwin", "width=1200,height=650,scrollbars=yes");
                    miPopup.focus();
                }
            }

            function inicio() {
                var numfilas = document.getElementById("numfilas").value;
                var indi = parent.document.getElementById("iniciopagina").value;
                var contador = 1;
                var indice = 0;
                if (indi > numfilas) {
                    indi = 1;
                }
                parent.document.form_busqueda.filas.value = numfilas;
                parent.document.form_busqueda.totalfacturas.value = document.getElementById("totalfacturas").value;
                parent.document.form_busqueda.paginas.innerHTML = "";
                while (contador <= numfilas) {
                    texto = contador + "-" + parseInt(contador + 9);
                    if (indi == contador) {
                        parent.document.form_busqueda.paginas.options[indice] = new Option(texto, contador);
                        parent.document.form_busqueda.paginas.options[indice].selected = true;
                    } else {
                        parent.document.form_busqueda.paginas.options[indice] = new Option(texto, contador);
                    }
                    indice++;
                    contador = contador + 10;
                }
            }

            function CambiaColor(esto, fondo, texto)
            {
                colorfondo = esto.style.background;
                esto.style.background = fondo;
                esto.style.color = texto;
                return colorfondo;
            }

            function CambiaColor2(esto, texto)
            {
                esto.style.background = colorfondo;
                esto.style.color = texto;
            }

        </script>
    </head>

    <body onload=inicio()>	
        <div id="pagina">
            <div id="zonaContenidoPP">
                <div align="center">
                    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                        <input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas ?>">
                        <input type="hidden" name="totalfacturas" id="totalfacturas" value="<?php echo $totalfacturas ?>">
                        <?php
                        $iniciopagina = @$_POST["iniciopagina"];
                        if (empty($iniciopagina)) {
                            $iniciopagina = @$_GET["iniciopagina"];
                        } else {
                            $iniciopagina = $iniciopagina - 1;
                        }
                        if (empty($iniciopagina)) {
                            $iniciopagina = 0;
                        }
                        if ($iniciopagina > $filas) {
                            $iniciopagina = 0;
                        }
                        if ($filas > 0) {
                            ?>
                            <?php
                            $sel_resultado = "SELECT codfactura,fecha,totalfactura,estado,nombreCliente FROM facturas WHERE borrado=0 AND " . $where;
                            $sel_resultado = $sel_resultado . "  limit " . $iniciopagina . ",10";
                            $res_resultado = @$conn->consulta($sel_resultado);
                            $contador = 0;
                            $marcaestado = 0;
                            while ($contador < @$conn->num_rows($res_resultado)) {

                                $marcaestado = @mysql_result($res_resultado, $contador, "estado");
                                if (@mysql_result($res_resultado, $contador, "estado") == 1) {
                                    $estado = "Sin pagar";
                                } else {
                                    $estado = "Pagada";
                                }
                                if ($contador % 2) {
                                    $fondolinea = "itemParTabla";
                                } else {
                                    $fondolinea = "itemImparTabla";
                                }
                                ?>

                                <tr class="<?php echo $fondolinea ?>" onMouseOver="CambiaColor(this, '#000000', '#ffffff')" onMouseOut="CambiaColor2(this, '#000000')" >

                                    <td class="aCentro" width="5%"><?php echo $contador + 1; ?></td>
                                    <td width="5%"><div align="right"><?php echo @mysql_result($res_resultado, $contador, "codfactura") ?></div></td>
                                    <td width="42%"><div align="center"><?php echo @mysql_result($res_resultado, $contador, "nombreCliente") ?></div></td>							
                                    <td width="12%"><div align="left"><?php echo number_format(@mysql_result($res_resultado, $contador, "totalfactura"), 2, ".", ",") ?></div></td>
                                    <td class="aDerecha" width="15%"><div align="left"><?php echo implota(@mysql_result($res_resultado, $contador, "fecha")) ?></div></td>
                                    <td class="aDerecha" width="15%"><div align="left"><?php echo $estado ?></div></td>
                                    <!--<td width="10%"><div align="center"><a href="#"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_factura(<?php echo @mysql_result($res_resultado, $contador, "codfactura") ?>,<?php echo $marcaestado ?>)" title="Modificar"></a></div></td>-->
                                    <td width="10%"><div align="center"><a href="#"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_factura(<?php echo @mysql_result($res_resultado, $contador, "codfactura") ?>)" title="Visualizar"></a></div></td>
                                    <td width="10%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_factura(<?php echo @mysql_result($res_resultado, $contador, "codfactura") ?>)" title="Eliminar"></a></div></td>
                                </tr>
                                </tr>
                                <?php
                                $contador++;
                            }
                            ?>			
                        </table>
                    <?php } else { ?>
                        <table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="100%" class="mensaje"><?php echo "No hay ninguna factura que cumpla con los criterios de b&uacute;squeda"; ?></td>
                            </tr>
                        </table>					
                    <?php } ?>					
                </div>
            </div>
        </div>			
    </div>
</body>
</html>
