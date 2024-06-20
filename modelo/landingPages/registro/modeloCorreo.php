<?php
require_once '../../../controladores/conexionBD.php';

class modeloCorreo {
    private $conexion;

    public function __construct() {
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    public function verificarCorreo($correo) {
        $query = "SELECT CORREO FROM PERSONA WHERE CORREO = ?";
        $stmt = $this->conexion->preparar($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}

if (isset($_POST['correo'])) {
    $modelo = new modeloCorreo();
    $exists = $modelo->verificarCorreo($_POST['correo']);
    echo json_encode(['exists' => $exists]);
}
?>
