<?php
include '../../clases/landingPages/claseRegistroPersona.php';
include '../../modelo/landingPages/modeloRegistroPersona.php';

if (isset($_POST['documento']) && isset($_POST['tipo_documento']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['fecha_nacimiento']) && isset($_POST['telefono']) && isset($_POST['correo']) && isset($_POST['direccion']) && isset($_POST['contrasena'])) {
    try {
        $documento = $_POST['documento'];
        $tipo_documento = $_POST['tipo_documento'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $contrasena = $_POST['contrasena'];
        $persona = new claseRegistroPersona();
        $persona->persona($documento, $tipo_documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion, $contrasena);
        $regPersona = new modeloRegistroPersona();
        $regPersona->regPersona($persona);
    } catch (Exception $exc) {
        echo json_encode(array('status' => 'error', 'message' => $exc->getMessage()));
    }
} else {
    echo'Datos incompletos';
}
?>

