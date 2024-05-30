<?php
include '../../controladores/conexionBD.php';

class modeloOdontograma{
       public function regOdontogramaAdulto($documentoPaciente, $fechaOdontograma, $idDiente, $comentarios){
        try {
            $conexion = new conexionBD();
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
    
    public function consultarOdontograma($documentoPaciente) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();
            $sql = "SELECT * FROM odontograma where DOCUMENTO_PACIENTE = $documentoPaciente";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();

            // Array auxiliar para almacenar las fechas únicas
            $fechasUnicas = array();

            // Iterar sobre los odontogramas para obtener las fechas únicas
            foreach ($result as $odontograma) {
                // Obtener la fecha del odontograma
                $fecha = $odontograma['FECHA_ODONTOGRAMA'];

                // Verificar si la fecha ya está en el array de fechas únicas
                if (!in_array($fecha, $fechasUnicas)) {
                    // Si no está, agregarla al array de fechas únicas
                    $fechasUnicas[] = $fecha;
                }
            }

            // Retornar el array de fechas únicas
            return $fechasUnicas;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    // Método para consultar odontogramas por fecha
    public function consultarOdontogramaPorFecha($fecha) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();
            $sql = "SELECT * FROM odontograma WHERE FECHA_ODONTOGRAMA = '$fecha'";
            $conexion->consultar($sql, array(':fecha' => $fecha));
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    
}
?>