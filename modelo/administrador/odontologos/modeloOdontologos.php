<?php
class modeloOdontologos {
    private $conexion;

    public function __construct() {
        require_once '../../controladores/conexionBD.php';
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    // Función para consultar todos los odontólogos
    public function consultarOdontologos() {
        $query = "SELECT PROFESIONAL.DOCUMENTO, PROFESIONAL.TARJETA_PROFESIONAL, PROFESIONAL.EXPERIENCIA_ANTERIOR, 
                  ESPECIALIDAD.NOMBRE_ESPECIALIDAD, PROFESIONAL.FECHA_INICIO, CONSULTORIO.NUMERO_CONSULTORIO, 
                  SEDE.NOMBRE_SEDE 
                  FROM PROFESIONAL 
                  JOIN ESPECIALIDAD ON PROFESIONAL.ID_ESPECIALIDAD = ESPECIALIDAD.ID_ESPECIALIDAD 
                  JOIN CONSULTORIO ON PROFESIONAL.ID_CONSULTORIO = CONSULTORIO.ID_CONSULTORIO 
                  JOIN SEDE ON PROFESIONAL.ID_SEDE = SEDE.ID_SEDE";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todas las especialidades
    public function consultarEspecialidades() {
        $query = "SELECT ID_ESPECIALIDAD, NOMBRE_ESPECIALIDAD FROM ESPECIALIDAD";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todos los consultorios disponibles
    public function consultarConsultoriosDisponibles() {
        $query = "SELECT ID_CONSULTORIO, NUMERO_CONSULTORIO 
                  FROM CONSULTORIO 
                  WHERE ID_CONSULTORIO NOT IN (SELECT ID_CONSULTORIO FROM PROFESIONAL)";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todas las sedes
    public function consultarSedes() {
        $query = "SELECT ID_SEDE, NOMBRE_SEDE FROM SEDE";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todas las personas que no son profesionales
    public function consultarPersonasNoProfesionales() {
        $query = "SELECT DOCUMENTO, NOMBRE, APELLIDO 
                  FROM PERSONA 
                  WHERE DOCUMENTO NOT IN (SELECT DOCUMENTO FROM PROFESIONAL)";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para agregar un odontólogo
    public function agregarOdontologo($documento, $tarjetaProfesional, $experienciaAnterior, $idEspecialidad, $fechaInicio, $idConsultorio, $idSede) {
        $query = "INSERT INTO PROFESIONAL (DOCUMENTO, TARJETA_PROFESIONAL, EXPERIENCIA_ANTERIOR, ID_ESPECIALIDAD, FECHA_INICIO, ID_CONSULTORIO, ID_SEDE) 
                  VALUES ('$documento', '$tarjetaProfesional', '$experienciaAnterior', '$idEspecialidad', '$fechaInicio', '$idConsultorio', '$idSede')";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para eliminar un odontólogo por su documento
    public function eliminarOdontologo($documento) {
        $query = "DELETE FROM PROFESIONAL WHERE DOCUMENTO = '$documento'";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para actualizar un odontólogo
    public function actualizarOdontologo($documento, $tarjetaProfesional, $experienciaAnterior, $idEspecialidad, $fechaInicio, $idConsultorio, $idSede) {
        $query = "UPDATE PROFESIONAL 
                  SET TARJETA_PROFESIONAL = '$tarjetaProfesional', 
                      EXPERIENCIA_ANTERIOR = '$experienciaAnterior', 
                      ID_ESPECIALIDAD = '$idEspecialidad', 
                      FECHA_INICIO = '$fechaInicio', 
                      ID_CONSULTORIO = '$idConsultorio', 
                      ID_SEDE = '$idSede' 
                  WHERE DOCUMENTO = '$documento'";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}
?>
