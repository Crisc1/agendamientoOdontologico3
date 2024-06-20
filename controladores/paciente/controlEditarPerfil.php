<?php
include '../../clases/paciente/claseEditarPerfil.php';
include '../../modelo/paciente/modeloEditarPerfil.php';       

if(isset($_POST['documentoPersona'])){
    try {
        $documentoPersona = $_POST['documentoPersona'];
        $persona=new claseEditarPerfil();
        $persona->consultarInfoPerfil($documentoPersona);
        $consultarPersonas= new modeloEditarPerfil();
        $result=$consultarPersonas->consultarInfoPerfil($persona->getDocumentoPersona());
        require '../../vista/paciente/editarPerfil.php';
    } catch (Exception $exc) {
        // Manejo de errores
        echo 'Error: ' . $exc->getMessage();
    }
}

    else if(isset($_POST['documento']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['fecha_nacimiento']) && isset($_POST['telefono']) && isset($_POST['correo']) && isset($_POST['direccion'])) {
        try {
            $documento = $_POST['documento'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $persona = new claseEditarPerfil();
            $persona->editarPersona($documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion);
            $editarPersona = new modeloEditarPerfil();
            $editarPersona->guardarInfoPerfil($documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion);
            echo'Insernot'.$nombre.$documento;
        } catch (Exception $exc) {
            echo 'Error', $exc();
        }
    } else {
        $alerta = "Llenar todos los campos";
        echo "alert('" . $alerta . "');";
    }