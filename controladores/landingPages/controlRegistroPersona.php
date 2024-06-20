<?php
include '../../clases/landingPages/claseRegistroPersona.php';
include '../../modelo/landingPages/registro/modeloRegistroPersona.php';

header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Datos incompletos');

if (
    isset($_POST['documento']) && isset($_POST['tipo_documento']) && isset($_POST['nombre']) &&
    isset($_POST['apellido']) && isset($_POST['fecha_nacimiento']) && isset($_POST['telefono']) &&
    isset($_POST['correo']) && isset($_POST['direccion']) && isset($_POST['contrasena'])
) {
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
        
        // Crear la instancia de claseRegistroPersona
        $persona = new claseRegistroPersona();
        $persona->persona($documento, $tipo_documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion, $contrasena);
        
        // Crear la instancia de modeloRegistroPersona
        $regPersona = new modeloRegistroPersona();
        $regPersona->regPersona($persona);
        
        // Si todo va bien, establecemos el mensaje de éxito
        $response = array('status' => 'success', 'message' => 'Registro exitoso');
    } catch (Exception $exc) {
        // Si ocurre algún error, verificamos si es debido a duplicidad de clave primaria
        if (strpos($exc->getMessage(), 'Duplicate entry') !== false) {
            $response = array('status' => 'error', 'message' => 'El número de documento ya se encuentra registrado.');
        } else {
            $response = array('status' => 'error', 'message' => $exc->getMessage());
        }
    }
}

echo json_encode($response);
?>
