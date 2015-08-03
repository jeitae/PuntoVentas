<?php
require 'functions.php';
require '../modelo.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_POST['user'])) {
    session_start();

    $funciones = new functions();
    $modelo = new modelo();

    if ($modelo->validarUsuarioBD($funciones->evitarInjection($_POST['user']), $funciones->evitarInjection($_POST['pass']))) {
        $_SESSION['idSession'] = $funciones->crearSession($_POST['user']);
        $_SESSION['user'] = $_POST['user'];

        echo "menu";
        
    } else {

        echo "fallo";
    }
} else {

    echo "fallo";
}