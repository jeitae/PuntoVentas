<?php

require "conexion.php";

/**
 * Description of modelo
 *
 * @author Jeison
 */
class modelo {

    function validarUsuarioBD($user, $pass) {

        $conn = new conexion();

        $consulta = "call pVerificar_user('" . $user . "','" . $pass . "')";

        $resultado = $conn->consulta($consulta);

        if ($conn->num_rows($resultado) != 0) {
           
            return true;
        } else {
            return false;
        }
    }

}
