<?php

require "../sys/conexion.php";
$conn = new conexion();
include ("../funciones/fechas.php");

@$codfactura = $_POST["codfactura"];
@$nombre_cliente = $_POST["nombre_cliente"];
@$importe = $_POST["importe"];
@$importevale = $_POST["importevale"];
@$importe = $importe - $importevale;
@$numdocumento = $_POST["numdocumento"];
@$fechacobro = $_POST["fechacobro"];
@$fechacobro = explota($_POST["fechacobro"]);
@$formapago = $_POST["formapago"];

$sel_comprueba = "SELECT * FROM cobros WHERE codfactura='$codfactura'";
$rs_comprueba = $conn->consulta($sel_comprueba);

if ($conn->num_rows($rs_comprueba) > 0) {
    ?>
    <script>
        alert("Esta factura ya se cobro con anterioridad");
        parent.document.getElementById("botticket").disabled = false;
        parent.document.getElementById("botaceptar").disabled = true;
        //parent.window.close()
    </script>; <?php

} else {

    $sel_insert = "INSERT INTO cobros (id,codfactura,nombreCliente,importe,codformapago,numdocumento,fechacobro,observaciones) VALUES ('','$codfactura','$nombre_cliente','$importe','$formapago','$numdocumento','$fechacobro','')";
    $rs_insert = $conn->consulta($sel_insert);

    $sel_insert2 = "INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,total) VALUES ('','$fechacobro','2','$codfactura','$nombre_cliente','$formapago','$numdocumento','$importe')";
    $rs_insert2 = $conn->consulta($sel_insert2);

    $sel_insert3 = "UPDATE facturas SET estado=2 WHERE codfactura='$codfactura'";
    $rs_insert3 = $conn->consulta($sel_insert3);
    ?>
    <script>
        alert("El cobro se ha efectuado correctamente");
        parent.document.getElementById("botticket").disabled = false;
        parent.document.getElementById("botaceptar").disabled = true;
        //parent.window.close()
    </script>;

<?php } ?>
