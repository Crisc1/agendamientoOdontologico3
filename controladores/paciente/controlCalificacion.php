<?php
include '../../clases/paciente/claseCitasPaciente.php';
include '../../modelo/paciente/modeloCitasCalificar.php';

if(isset($_POST['documentoCalificar'])){
        try {
            $documento = $_POST['documentoCalificar'];
            $cita = new claseCitasPaciente();
            $cita->consultarCitasCalificar($documento);
            $consultarCita=new modeloCitasCalificar();
            $result=$consultarCita->consultarCitasCalificar($cita->getDocumento());
            require '../../vista/paciente/calificarCitas.php';
        } catch (Exception $exc) {
        echo 'Error:'. $exc;
        }
    }