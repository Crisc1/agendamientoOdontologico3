<?php
include '../../controladores/conexionBD.php';

class modeloHistorialOdontologo{
    public function regOdontogramaAdulto($documentoPaciente, $fechaOdontograma, $idDiente, $comentarios){
        try {
            $conexion = new conexionDB();
            $conexion->abrir();

            // Ahora, puedes utilizar estos valores en tu consulta SQL
            $sql = "INSERT INTO ODONTOGRAMA (DOCUMENTO_PACIENTE, FECHA_ODONTOGRAMA, ID_DIENTE, COMENTARIO) VALUES ('$documentoPaciente', '$fechaOdontograma', '$idDiente', '$comentarios')";
            $conexion->consultar($sql);

            $result = $conexion->obtenerResult();
            $conexion->cerrar();

            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
?>