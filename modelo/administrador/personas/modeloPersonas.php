<?php
class modeloPersonas {
    private $conexion;

    public function __construct() {
        require_once '../../controladores/conexionBD.php';
        $this->conexion = new conexionBD();
        $this->conexion->abrir();
    }

    // Función para consultar todas las personas
    public function consultarPersonas() {
        $query = "SELECT 
                    PERSONA.DOCUMENTO, 
                    TIPO_DOCUMENTO.NOMBRE_DOCUMENTO AS TIPO_DOCUMENTO, 
                    PERSONA.NOMBRE, 
                    PERSONA.APELLIDO, 
                    PERSONA.FECHA_NACIMIENTO, 
                    PERSONA.TELEFONO, 
                    PERSONA.CORREO, 
                    PERSONA.DIRECCION, 
                    ROL.NOMBRE_ROL AS ID_ROL 
                  FROM PERSONA
                  JOIN TIPO_DOCUMENTO ON PERSONA.TIPO_DOCUMENTO = TIPO_DOCUMENTO.ID_DOCUMENTO
                  JOIN ROL ON PERSONA.ID_ROL = ROL.ID_ROL";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para actualizar una persona existente
    public function actualizarPersona($documento, $tipoDocumento, $nombre, $apellido, $fechaNacimiento, $telefono, $correo, $direccion, $idRol) {
        $query = "UPDATE PERSONA 
                  SET TIPO_DOCUMENTO = '$tipoDocumento', 
                      NOMBRE = '$nombre', 
                      APELLIDO = '$apellido', 
                      FECHA_NACIMIENTO = '$fechaNacimiento', 
                      TELEFONO = '$telefono', 
                      CORREO = '$correo', 
                      DIRECCION = '$direccion', 
                      ID_ROL = '$idRol' 
                  WHERE DOCUMENTO = '$documento'";
        $this->conexion->consultar($query);
        return $this->conexion->obtenerFilasAfectadas() > 0;
    }
    
    public function consultarTiposDocumento() {
        $query = "SELECT ID_DOCUMENTO, NOMBRE_DOCUMENTO FROM TIPO_DOCUMENTO";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Actualizar el método para consultar roles excluyendo el rol con ID 3
    public function consultarRoles() {
        $query = "SELECT ID_ROL, NOMBRE_ROL FROM ROL WHERE ID_ROL != 3";
        $this->conexion->consultar($query);
        $result = $this->conexion->obtenerResult();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para eliminar una persona por su documento
    public function eliminarPersona($documento) {
        try {
            $query = "DELETE FROM PERSONA WHERE DOCUMENTO = '$documento'";
            $this->conexion->consultar($query);
            if ($this->conexion->obtenerFilasAfectadas() > 0) {
                return "Persona eliminada correctamente";
            } else {
                return "No se pudo eliminar la persona. Verifique si existe la persona.";
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function __destruct() {
        $this->conexion->cerrar();
    }
}
?>
