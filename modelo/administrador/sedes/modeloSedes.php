<?php
class modeloSedes {
    private $conexion;

    public function __construct() {
        require_once '../../controladores/conexionBD.php';
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    public function consultarSedes() {
        $query = "SELECT * FROM SEDE";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarSede($nombre, $direccion) {
        $query = "INSERT INTO SEDE (ID_SEDE, NOMBRE_SEDE, DIRECCION) VALUES (NULL ,'$nombre', '$direccion')";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }
    
    public function editarSede($idSede, $nombre, $direccion) {
        $query = "UPDATE SEDE SET 
            NOMBRE_SEDE = '$nombre', 
            DIRECCION = '$direccion' 
            WHERE ID_SEDE = '$idSede';";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }
    
    public function eliminarSede($idSede) {
        // Verificar si la sede tiene consultorios asociados
        $query = "SELECT COUNT(*) AS numConsultorios FROM CONSULTORIO WHERE ID_SEDE = $idSede";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult()->fetch_assoc();
        $numConsultorios = $result['numConsultorios'];

        if ($numConsultorios > 0) {
            // Si hay consultorios asociados, no se puede eliminar la sede
            return "La sede no se puede eliminar porque tiene consultorios asociados.";
        }

        // Si no hay consultorios asociados, proceder con la eliminación de la sede
        $queryEliminar = "DELETE FROM SEDE WHERE ID_SEDE = $idSede";
        $this->conexion->consultar($queryEliminar);
        return $this->conexion->obtenerFilasAfectadas() > 0 ? "Sede eliminada correctamente." : "Error al eliminar la sede.";
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}
?>
