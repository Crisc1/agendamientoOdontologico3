<?php
class modeloConsultorios {
    private $conexion;

    public function __construct() {
        require_once '../../controladores/conexionBD.php';
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    // Función para consultar todos los consultorios
    public function consultarConsultorios() {
        $query = "SELECT CONSULTORIO.ID_CONSULTORIO, CONSULTORIO.NUMERO_CONSULTORIO, SEDE.NOMBRE_SEDE, SEDE.ID_SEDE
                  FROM SEDE
                  INNER JOIN CONSULTORIO ON SEDE.ID_SEDE = CONSULTORIO.ID_SEDE";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function consultarTodasSedes() {
            $query = "SELECT ID_SEDE, NOMBRE_SEDE FROM SEDE";
            $this->conexion->consultar($query);
            $result = $this->conexion->obtenerResult();
            return $result->fetch_all(MYSQLI_ASSOC);
    }


    // Función para agregar un nuevo consultorio
    public function agregarConsultorio($numeroConsultorio, $idSede) {
        $query = "INSERT INTO CONSULTORIO (ID_CONSULTORIO, NUMERO_CONSULTORIO, ID_SEDE) 
                  VALUES (NULL, '$numeroConsultorio', $idSede)";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para editar un consultorio
    public function editarConsultorio($idConsultorio, $numeroConsultorio, $idSede) {
        $query = "UPDATE CONSULTORIO SET 
                  NUMERO_CONSULTORIO = '$numeroConsultorio', 
                  ID_SEDE = $idSede 
                  WHERE ID_CONSULTORIO = $idConsultorio";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para eliminar un consultorio por su ID
    public function eliminarConsultorio($idConsultorio) {
        try {
            $query = "DELETE FROM CONSULTORIO WHERE ID_CONSULTORIO = $idConsultorio";
            $this->conexion->consultar($query);
            if ($this->conexion->obtenerFilasAfectadas() > 0) {
                return "Consultorio eliminado correctamente";
            } else {
                return "No se pudo eliminar el consultorio. Verifique si hay odontólogos asociados.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                return "No se puede eliminar el consultorio porque tiene odontólogos asociados.";
            } else {
                throw $e;
            }
        }
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}
?>
