<?php
include '../../controladores/conexionBD.php';
class modeloCitasPaciente{
        public function regCita(claseCitasPaciente $regCita) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();  
            $idProfesional= $regCita->getIdProfesional();
            $documento = $regCita->getDocumento();
            $idTratamiento = $regCita->getIdTratamiento();
            $fecha = $regCita->getFecha();
            $hora = $regCita->getHora();
            $consultorio = $regCita->getIdConsultorio();
            $sql = "INSERT INTO cita VALUES('null','$idProfesional','$documento','$idTratamiento','$fecha','$hora','$consultorio')";
            $conexion->consultar($sql);
            $res = $conexion->obtenerFilasAfectadas();
            if ($res == 1) {
                header("Location: ../../vista/paciente/paginaExito.php"); 
                exit();    
            }else{
                header("Location: ../vista/salidas/paginaError.php"); 
                exit();  
            }  
            $conexion->cerrar();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarCitaPaciente($documento) {
         
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
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function eliminarCita($idCita) {
        try{
            $conexion = new conexionBD();
            $conexion->abrir();      
            $sql= "DELETE FROM cita WHERE ID_CITA = $idCita";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    } 
}