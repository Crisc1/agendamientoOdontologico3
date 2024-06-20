<?php
include '../../clases/paciente/claseCitasPaciente.php';
include '../../modelo/paciente/modeloCitasCalificar.php';

if(isset($_POST['documentoConsultarCitas'])){
        try {
            $documento = $_POST['documentoConsultarCitas'];
            $cita = new claseCitasPaciente();
            $cita->consultarCitasPaciente($documento);
            $consultarCita=new modeloCitasCalificar();
            $result=$consultarCita->consultarCitasCalificar($cita->getDocumento());
            require '../../vista/paciente/consultaCitasCalificar.php';
        } catch (Exception $exc) {
        echo 'Error:'. $exc;
        }
    }