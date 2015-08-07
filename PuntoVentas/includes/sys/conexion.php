<?php

class conexion {

    private $conexion;
    private $total_consultas;

    public function conexion() {
        if (!isset($this->conexion)) {
            $this->conexion = (mysql_connect("127.0.0.1", "root", "")) ;// Host, user, password
            mysql_select_db("punto_ventas", $this->conexion);// Utilizar base de datos Pundo de Ventas, conexion
        }
        $this->getParamentros();
    }

    public function consulta($consulta) {
        $this->total_consultas++;  //Aumentar el conteo de consultas realizadas
        $resultado = mysql_query($consulta, $this->conexion); //Ejecutar la consulta, conexion
        return $resultado;
    }

    public function fetch_array($consulta) {
        return mysql_fetch_array($consulta);
    }

    public function num_rows($consulta) {
        return mysql_num_rows($consulta);
    }

    public function getTotalConsultas() {
        return $this->total_consultas;
    }

    public function getParamentros() {
        $query_tmp = "SELECT * FROM parametros WHERE indice=1";
        $rs_tmp = mysql_query($query_tmp, $this->conexion);

// Variables para la numeracion de facturas
        $GLOBALS['numeracionfactura'] = @mysql_result($rs_tmp, 0, "numeracionfactura");
        $GLOBALS['setnumfac'] = @mysql_result($rs_tmp, 0, "setnumfac");


//boeltas
        $bbquery_tmp = "SELECT * FROM parametros WHERE indice=1";
        $bbrs_tmp = mysql_query($bbquery_tmp, $this->conexion);

// Variables para la numeracion de boletas
        $GLOBALS['numeracionboleta'] = @mysql_result($bbrs_tmp, 0, "numeracionboleta");
        $GLOBALS['setnumbol'] = @mysql_result($bbrs_tmp, 0, "setnumbol");

// Variables para impresion de Facturas y Guias de Despacho
        $GLOBALS['imagenfac'] = @mysql_result($rs_tmp, 0, "imagenfac");
        $GLOBALS['fondofac'] = @mysql_result($rs_tmp, 0, "fondofac");
        $GLOBALS['imagenguia'] = @mysql_result($rs_tmp, 0, "imagenguia");
        $GLOBALS['fondoguia'] = @mysql_result($rs_tmp, 0, "fondoguia");
        $GLOBALS['FilasDetalleFactura'] = @mysql_result($rs_tmp, 0, "filasdetallefactura");

// Variables de Impuesto y Moneda
        $GLOBALS['ivaimp'] = @mysql_result($rs_tmp, 0, "ivaimp");
        $GLOBALS['nombremoneda'] = @mysql_result($rs_tmp, 0, "nombremoneda");
        $GLOBALS['simbolomoneda'] = @mysql_result($rs_tmp, 0, "simbolomoneda");
        $GLOBALS['codigomonedate'] = @mysql_result($rs_tmp, 0, "codigomoneda");

// Personalizaci�n Empresa
        $GLOBALS['nomempresa'] = @mysql_result($rs_tmp, 0, "nomempresa");
        $GLOBALS['giro'] = @mysql_result($rs_tmp, 0, "giro");
        $GLOBALS['giro2'] = @mysql_result($rs_tmp, 0, "giro2");
        $GLOBALS['fonos'] = @mysql_result($rs_tmp, 0, "fonos");
        $GLOBALS['direccion'] = @mysql_result($rs_tmp, 0, "direccion");
        $GLOBALS['comuna'] = @mysql_result($rs_tmp, 0, "comuna");
        $GLOBALS['CiudadActual'] = @mysql_result($rs_tmp, 0, "ciudadactual");
        $GLOBALS['numerofiscal'] = @mysql_result($rs_tmp, 0, "numerofiscal");
        $GLOBALS['resolucionsii'] = @mysql_result($rs_tmp, 0, "resolucionsii");
        $GLOBALS['rutempresa'] = @mysql_result($rs_tmp, 0, "rutempresa");
    }

    public function close() {

        mysql_close($this->conexion);
    }

}
