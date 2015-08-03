<?php
require "../sys/conexion.php";
$conn = new conexion();

$codfamilia = @$_GET["codfamilia"];
$cadena_busqueda = @$_GET["cadena_busqueda"];

$query = "SELECT * FROM familias WHERE codfamilia='$codfamilia'";
$rs_query = $conn->consulta($query);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Eliminar Categoria</title>
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

            function aceptar(codfamilia) {
                location.href = "guardar_familia.php?codfamilia=" + codfamilia + "&accion=baja" + "&cadena_busqueda=<?php echo $cadena_busqueda ?>";
            }

            function cancelar() {
                window.close();
            }

        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">ELIMINAR FAMILIA </div>
                    <div id="frmBusqueda">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width="15%">C&oacute;digo</td>
                                <td width="85%" colspan="2"><?php echo $codfamilia ?></td>
                            </tr>
                            <tr>
                                <td width="15%">Nombre</td>
                                <td width="85%" colspan="2"><?php echo mysql_result($rs_query, 0, "nombre") ?></td>
                            </tr>
                        </table>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $codfamilia ?>)" border="1" onMouseOver="style.cursor = cursor">
                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor = cursor">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
