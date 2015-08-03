<?php

require '../conexion.php';
$conn = new conexion();

session_start();
session_destroy();

$conn->close();
header("Location:../../../index.php");
