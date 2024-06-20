<?php
include '../../clases/paciente/claseCitasPaciente.php';
include '../../modelo/paciente/modeloCitasPaciente.php';


if(isset($_POST['profesional'])&&isset($_POST['documento'])&&isset($_POST['tratamiento'])&&isset($_POST['fecha'])&&isset($_POST['hora'])&&isset($_POST['consultorio'])&&isset($_POST['sede'])){
    try {
        $idProfesional=$_POST['profesional'];
        $documento=$_POST['documento'];
        $idTratamiento=$_POST['tratamiento'];
        $fecha=$_POST['fecha'];
        $hora = $_POST['hora'];
        $idSede = $_POST['sede'];
        $consultorio = $_POST['consultorio'];
        $cita=new claseCitasPaciente();
        $cita->agendarCita($idProfesional, $documento, $idTratamiento, $fecha, $hora, $idSede, $consultorio);
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
    
    if (isset($_GET['action']) && $_GET['action'] === 'eliminar') {
        if (isset($_GET['idCita'])) {
            $idCitaEliminar = $_GET['idCita'];

            // Crear una instancia del modelo de citas
            $modeloCitas = new modeloCitasPaciente();

            // Llamar al método eliminarCita
            $resultado = $modeloCitas->eliminarCita($idCitaEliminar);

            // Enviar una respuesta al cliente para indicar el estado de la eliminación
            echo $resultado ? 'success' : 'error';
            exit();
        }
    }