<?php

require "../sys/conexion.php";
$conn = new conexion();

// Tablas que seran afectadas por la depuracion.
$sql_opt = "OPTIMIZE TABLE `albalinea` , `albalineap` , `albalineaptmp` , `albalineatmp` , `albaranes` , `albaranesp` , `albaranesptmp` , `albaranestmp` , `articulos` , `artpro` , `clientes` , `cobros` , `embalajes` , `entidades` , `factulinea` , `factulineap` , `factulineaptmp` , `factulineatmp` , `facturas` , `facturasp` , `facturasptmp` , `facturastmp` , `familias` , `formapago` , `impuestos` , `librodiario` , `pagos` , `proveedores` , `provincias` , `tabbackup` , `ubicaciones`";

// Chequeo de la realizacion del proceso.
if ($conn->consulta($sql_opt, $conexion)) {

// Redirecion en caso de confirmacion de proceso.
    header("Location: index.php?mensaje=confirmar");
} else {

// Redirecion en caso de error.
    header("Location: index.php?mensaje=error");
}