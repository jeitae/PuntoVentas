<?php
require "../sys/conexion.php";
$conn = new conexion();

$codproveedor = @$_GET["codproveedor"];

$query = "SELECT * FROM proveedores WHERE codproveedor='$codproveedor'";
$rs_query = $conn->consulta($query);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Modificar Provedor</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="../funciones/validar.js"></script>
        <script language="javascript">

            function cancelar() {
                window.close();
            }

            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }

            function limpiar() {
                document.getElementById("formulario").reset();
            }

        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">MODIFICAR PROVEEDOR </div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="guardar_proveedor.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td>C&oacute;digo</td>
                                    <td><?php echo $codproveedor ?></td>
                                    <td width="42%" rowspan="13" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>
                                <tr>
                                    <td width="15%">Nombre</td>
                                    <td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45" value="<?php echo mysql_result($rs_query, 0, "nombre") ?>"></td>
                                </tr>
                                <tr>
                                    <td>NIF</td>
                                    <td><input id="nif" type="text" class="cajaGrande" NAME="anif" maxlength="13" value="<?php echo mysql_result($rs_query, 0, "nif") ?>"></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n</td>
                                    <td><input NAME="adireccion" type="text" class="cajaGrande" id="direccion" size="45" maxlength="45" value="<?php echo mysql_result($rs_query, 0, "direccion") ?>"></td>
                                </tr>
                                <tr>
                                    <td>Ciudad</td>
                                    <td><input NAME="alocalidad" type="text" class="cajaGrande" id="localidad" size="35" maxlength="35" value="<?php echo mysql_result($rs_query, 0, "localidad") ?>"></td>
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
                                    <td>C&oacute;digo postal </td>
                                    <td><input id="codpostal" type="text" class="cajaPequena" NAME="acodpostal" maxlength="5" value="<?php echo mysql_result($rs_query, 0, "codpostal") ?>"></td>
                                </tr>					  

                                <tr>
                                    <td>Cuenta bancaria</td>
                                    <td><input id="cuentabanco" type="text" class="cajaGrande" NAME="acuentabanco" maxlength="20" value="<?php echo mysql_result($rs_query, 0, "cuentabancaria") ?>"></td>
                                </tr>
                                <tr>
                                    <td>Tel&eacute;fono </td>
                                    <td><input id="telefono" name="atelefono" type="text" class="cajaPequena" maxlength="14" value="<?php echo mysql_result($rs_query, 0, "telefono") ?>"></td>
                                </tr>
                                <tr>
                                    <td>M&oacute;vil</td>
                                    <td><input id="movil" name="amovil" type="text" class="cajaPequena" maxlength="14" value="<?php echo mysql_result($rs_query, 0, "movil") ?>"></td>
                                </tr>
                                <tr>
                                    <td>Correo electr&oacute;nico  </td>
                                    <td><input NAME="aemail" type="text" class="cajaGrande" id="email" size="35" maxlength="35" value="<?php echo mysql_result($rs_query, 0, "email") ?>"></td>
                                </tr>
                                <tr>
                                    <td>Direcci&oacute;n web </td>
                                    <td><input NAME="aweb" type="text" class="cajaGrande" id="web" size="45" maxlength="45" value="<?php echo mysql_result($rs_query, 0, "web") ?>"></td>
                                </tr>
                            </table>
                    </div>
                    <div id="botonBusqueda">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario, true)" border="1" onMouseOver="style.cursor = cursor">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor = cursor">
                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor = cursor">
                        <input id="accion" name="accion" value="modificar" type="hidden">
                        <input id="id" name="id" value="<?php echo $codproveedor ?>" type="hidden">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
