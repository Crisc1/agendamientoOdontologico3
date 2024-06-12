<?php
include '../../controladores/conexionBD.php';

class modeloCitasCalificar{
    public function consultarCitasCalificar($documento) {
         
        try{
            $conexion = new conexionBD();
            $conexion->abrir();      
            $sql= "SELECT 
                    cita.ID_CITA, 
                    cita.FECHA, 
                    cita.HORA, 
                    profesional.ID_PROFESIONAL,  
                    CONCAT(persona.NOMBRE, ' ', persona.APELLIDO) AS NOMBRE_profesional,
                    tratamiento.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                    consultorio.NUMERO_CONSULTORIO
                FROM cita
                JOIN profesional ON cita.ID_PROFESIONAL = profesional.ID_PROFESIONAL
                JOIN persona ON profesional.DOCUMENTO = persona.DOCUMENTO
                LEFT JOIN tratamiento ON cita.ID_TRATAMIENTO = tratamiento.ID_TRATAMIENTO
                LEFT JOIN consultorio ON cita.ID_CONSULTORIO = consultorio.ID_CONSULTORIO
                WHERE cita.DOCUMENTO_PACIENTE = $documento
                    AND cita.FECHA >= CURDATE() -- Solo fechas mayores o iguales a la actual
                ORDER BY cita.FECHA";
            echo $sql;
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}