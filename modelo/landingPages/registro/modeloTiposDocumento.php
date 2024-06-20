<?php
require_once '../../../controladores/conexionBD.php';

class modeloTiposDocumento {
    private $conexion;

    public function __construct() {
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    public function consultarTiposDocumento() {
        $query = "SELECT ID_DOCUMENTO, NOMBRE_DOCUMENTO FROM TIPO_DOCUMENTO";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}

$modelo = new modeloTiposDocumento();
$tiposDocumento = $modelo->consultarTiposDocumento();
echo json_encode($tiposDocumento);
?>
