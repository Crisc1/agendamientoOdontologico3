<?php
include '../../controladores/conexionBD.php';
class modeloAgendaOdontologica{
    public function consultarAgenda($idProfesional) {
         
        try{
            $conexion = new conexionBD();
            $conexion->abrir();      
            $sql= "SELECT 
                        cita.ID_CITA, 
                        cita.FECHA, 
                        cita.HORA, 
                        PACIENTE.DOCUMENTO AS DOCUMENTO_PACIENTE,
                        profesional.ID_PROFESIONAL,  
                        CONCAT(PACIENTE.NOMBRE, ' ', PACIENTE.APELLIDO) AS NOMBRE_PACIENTE,
                        tratamiento.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                        consultorio.NUMERO_CONSULTORIO
                        FROM cita
                        JOIN profesional ON cita.ID_PROFESIONAL = profesional.ID_PROFESIONAL
                        JOIN persona AS PACIENTE ON cita.DOCUMENTO_PACIENTE = PACIENTE.DOCUMENTO
                        LEFT JOIN tratamiento ON cita.ID_TRATAMIENTO = tratamiento.ID_TRATAMIENTO
                        LEFT JOIN consultorio ON cita.ID_CONSULTORIO = consultorio.ID_CONSULTORIO
                        WHERE cita.ID_PROFESIONAL = $idProfesional
                        AND cita.FECHA >= CURDATE() -- Solo fechas mayores o iguales a la actual
                        ORDER BY cita.FECHA;";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
     
}

