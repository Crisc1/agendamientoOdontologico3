<?php
require_once '../../../controladores/conexionBD.php';

class modeloDocumento {
    private $conexion;

    public function __construct() {
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    public function verificarDocumento($documento) {
        $query = "SELECT COUNT(*) as count FROM PERSONA WHERE DOCUMENTO = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param('s', $documento);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    public function verificarCorreo($correo) {
        $query = "SELECT COUNT(*) as count FROM PERSONA WHERE CORREO = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}

if (isset($_POST['documento'])) {
    $modelo = new modeloDocumento();
    echo json_encode(['exists' => $modelo->verificarDocumento($_POST['documento'])]);
}

if (isset($_POST['correo'])) {
    $modelo = new modeloDocumento();
    echo json_encode(['exists' => $modelo->verificarCorreo($_POST['correo'])]);
}
?>
