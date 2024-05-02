<?php
include '../../clases/odontologo/claseCitasOdontologo.php';  
include '../../modelo/odontologo/modeloOdontologo.php';


        //Condicional para la consulta de agenda para el profesional
if(isset($_POST['idProfesionalAgenda'])){
        try {
            $idProfesional = $_POST['idProfesionalAgenda'];
            $cita = new claseCitasOdontologo();
            $cita->consultarAgendas($idProfesional);
            $consultarAgenda=new modeloOdontologo();
            $result=$consultarAgenda->consultarAgenda($cita->getIdProfesional());
            require '../../vista/odontologo/agendaOdontologicaDia.php';
        } catch (Exception $exc) {
        echo 'Error:'. $exc;
        }
    }
