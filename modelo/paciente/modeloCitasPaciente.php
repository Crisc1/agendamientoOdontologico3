<?php
include '../../controladores/conexionBD.php';
class modeloCitasPaciente{
    public function regCita(claseCitasPaciente $regCita) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();  
            $idProfesional = $regCita->getIdProfesional();
            $documento = $regCita->getDocumento();
            $idTratamiento = $regCita->getIdTratamiento();
            $fecha = $regCita->getFecha();
            $hora = $regCita->getHora();
            $consultorio = $regCita->getIdConsultorio();
            $sede = $regCita->getIdSede();
            $sql = "INSERT INTO CITA VALUES(NULL, '$idProfesional', '$documento', '$idTratamiento', '$fecha', '$hora', '$consultorio', '$sede', NULL)";
            echo$sql;
            $conexion->consultar($sql);
            $res = $conexion->obtenerFilasAfectadas();
            $conexion->cerrar();

            if ($res == 1) {
                // Mostrar ventana emergente con JavaScript
                echo '<script>';
                echo 'alert("La cita ha sido agendada correctamente.");';
                echo 'window.location.href = "../../vista/paciente/menuPaciente.php";'; // Redirige luego de cerrar el alert
                echo '</script>';
                exit();
            } else {
                header("Location: ../vista/salidas/paginaError.php");
                exit();
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function consultarCitaPaciente($documento) {
         
        try{
            $conexion = new conexionBD();
            $conexion->abrir();      
            $sql= "SELECT 
                    CITA.ID_CITA, 
                    CITA.FECHA, 
                    CITA.HORA, 
                    PROFESIONAL.ID_PROFESIONAL,  
                    CONCAT(PERSONA.NOMBRE, ' ', PERSONA.APELLIDO) AS NOMBRE_profesional,
                    TRATAMIENTO.NOMBRE_TRATAMIENTO AS NOMBRE_TRATAMIENTO, 
                    CONSULTORIO.NUMERO_CONSULTORIO
                FROM CITA
                JOIN PROFESIONAL ON CITA.ID_PROFESIONAL = PROFESIONAL.ID_PROFESIONAL
                JOIN PERSONA ON PROFESIONAL.DOCUMENTO = PERSONA.DOCUMENTO
                LEFT JOIN TRATAMIENTO ON CITA.ID_TRATAMIENTO = TRATAMIENTO.ID_TRATAMIENTO
                LEFT JOIN CONSULTORIO ON CITA.ID_CONSULTORIO = CONSULTORIO.ID_CONSULTORIO
                WHERE CITA.DOCUMENTO_PACIENTE = $documento
                    AND CITA.FECHA >= CURDATE() -- Solo fechas mayores o iguales a la actual
                ORDER BY CITA.FECHA";
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
            $sql= "DELETE FROM CITA WHERE ID_CITA = $idCita";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    } 
}