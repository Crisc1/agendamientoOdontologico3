<?php
class modeloCitas {
    private $conexion;

    public function __construct() {
        require_once '../../controladores/conexionBD.php';
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    // Función para consultar todas las citas
    public function consultarCitas() {
        $query = "SELECT 
                    CITA.ID_CITA, 
                    CITA.FECHA, 
                    CITA.HORA, 
                    PROFESIONAL.ID_PROFESIONAL,
                    PROFESIONAL.ID_ESPECIALIDAD, 
                    CONCAT(PERSONA_PROF.NOMBRE, ' ', PERSONA_PROF.APELLIDO) AS NOMBRE_PROFESIONAL,
                    TRATAMIENTO.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                    CONSULTORIO.NUMERO_CONSULTORIO AS NUMERO_CITA,
                    SEDE.NOMBRE_SEDE,
                    SEDE.ID_SEDE,
                    CONSULTORIO.ID_CONSULTORIO,
                    CONCAT(PERSONA_PAC.NOMBRE, ' ', PERSONA_PAC.APELLIDO) AS NOMBRE_PACIENTE
                  FROM CITA
                  JOIN PROFESIONAL ON CITA.ID_PROFESIONAL = PROFESIONAL.ID_PROFESIONAL
                  JOIN PERSONA AS PERSONA_PROF ON PROFESIONAL.DOCUMENTO = PERSONA_PROF.DOCUMENTO
                  LEFT JOIN TRATAMIENTO ON CITA.ID_TRATAMIENTO = TRATAMIENTO.ID_TRATAMIENTO
                  LEFT JOIN CONSULTORIO ON CITA.ID_CONSULTORIO = CONSULTORIO.ID_CONSULTORIO
                  INNER JOIN SEDE ON CONSULTORIO.ID_SEDE = SEDE.ID_SEDE
                  JOIN PERSONA AS PERSONA_PAC ON CITA.DOCUMENTO_PACIENTE = PERSONA_PAC.DOCUMENTO
                  ORDER BY CITA.FECHA;";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para agregar una nueva cita
    public function agregarCita($idTratamiento, $idOdontologo, $fecha, $hora, $idConsultorio) {
        $query = "INSERT INTO CITA (ID_CITA, ID_TRATAMIENTO, ID_PROFESIONAL, FECHA, HORA, ID_CONSULTORIO) 
                  VALUES (NULL, $idTratamiento, $idOdontologo, '$fecha', '$hora', $idConsultorio)";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para actualizar una cita existente
    public function actualizarCita($idCita, $idTratamiento, $idOdontologo, $fecha, $hora, $idConsultorio) {
        $query = "UPDATE CITA 
                  SET ID_TRATAMIENTO = $idTratamiento, 
                      ID_PROFESIONAL = $idOdontologo, 
                      FECHA = '$fecha', 
                      HORA = '$hora', 
                      ID_CONSULTORIO = $idConsultorio 
                  WHERE ID_CITA = $idCita";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }

    // Función para eliminar una cita por su ID
    public function eliminarCita($idCita) {
        try {
            $query = "DELETE FROM CITA WHERE ID_CITA = $idCita";
            $this->conexion->consultar($query);
            if ($this->conexion->obtenerFilasAfectadas() > 0) {
                return "Cita eliminada correctamente";
            } else {
                return "No se pudo eliminar la cita. Verifique si existe la cita.";
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    // Función para consultar todas las sedes
    public function consultarTodasSedes() {
        $query = "SELECT ID_SEDE, NOMBRE_SEDE FROM SEDE";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todos los odontólogos
    public function consultarTodosOdontologos() {
        $query = "SELECT ID_PROFESIONAL, CONCAT(PERSONA.NOMBRE, ' ', PERSONA.APELLIDO) AS NOMBRE_ODONTOLOGO
                  FROM PROFESIONAL
                  JOIN PERSONA ON PROFESIONAL.DOCUMENTO = PERSONA.DOCUMENTO
                  WHERE PROFESIONAL.ID_ESPECIALIDAD = 1"; // Aquí asumimos que 1 es el ID de la especialidad de odontólogo
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para consultar todos los tratamientos
    public function consultarTodosTratamientos() {
        $query = "SELECT ID_TRATAMIENTO, NOMBRE_TRATAMIENTO FROM TRATAMIENTO";
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

    public function __destruct() {
        $this->conexion->cerrar();
    }
}
?>
