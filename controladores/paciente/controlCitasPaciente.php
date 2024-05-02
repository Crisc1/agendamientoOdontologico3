<?php
include '../../clases/paciente/claseCitasPaciente.php';
include '../../modelo/paciente/modeloCitasPaciente.php';


if(isset($_POST['profesional'])&&isset($_POST['documento'])&&isset($_POST['tratamiento'])&&isset($_POST['fecha'])&&isset($_POST['hora'])&&isset($_POST['consultorio'])){
    try {
        $idProfesional=$_POST['profesional'];
        $documento=$_POST['documento'];
        $idTratamiento=$_POST['tratamiento'];
        $fecha=$_POST['fecha'];
        $hora = $_POST['hora'];
        $consultorio = $_POST['consultorio'];
        $cita=new claseCitasPaciente();
        $cita->agendarCita($idProfesional, $documento, $idTratamiento, $fecha, $hora, $consultorio);
        $regCita=new modeloCitasPaciente();
        $regCita->regCita($cita);
    } catch (Exception $exc) {
        echo 'Error', $exc();
    }
    
}
    
    else if(isset($_POST['documentoConsultarCitas'])){
        try {
            $documento = $_POST['documentoConsultarCitas'];
            $cita = new claseCitasPaciente();
            $cita->consultarCitasPaciente($documento);
            $consultarCita=new modeloCitasPaciente();
            $result=$consultarCita->consultarCitaPaciente($cita->getDocumento());
            require '../../vista/paciente/gestionarCitas.php';
        } catch (Exception $exc) {
        echo 'Error:'. $exc;
        }
    }