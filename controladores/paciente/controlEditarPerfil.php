<?php
include '../../clases/paciente/claseEditarPerfil.php';
include '../../modelo/paciente/modeloEditarPerfil.php';       

if(isset($_POST['documentoPersona'])){
    try {
        $documentoPersona = $_POST['documentoPersona'];
        $persona=new claseEditarPerfil();
        $persona->consultarInfoPerfil($documentoPersona);
        $consultarPersonas= new modeloEditarPerfil();
        $result=$consultarPersonas->consultarPersona($persona->getDocumentoPersona());
        require '../../vista/paciente/editarPerfil.php';
    } catch (Exception $exc) {
        // Manejo de errores
        echo 'Error: ' . $exc->getMessage();
    }
}

    else if(isset($_POST['nombre'])&&isset($_POST['apellido'])&&isset($_POST['fecha_nacimiento'])&&isset($_POST['correo'])&&isset($_POST['telefono'])&&isset($_POST['direccion'])){
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
    } else {
        $alerta = "Llenar todos los campos";
        echo "alert('" . $alerta . "');";
    }

