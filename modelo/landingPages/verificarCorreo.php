<?php
include '../../controladores/conexionBD.php';

if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];
    
    try {
        $conexion = new conexionBD;
        $conexion->abrir();
        $sql = "SELECT * FROM persona WHERE correo = '$correo'";
        echo$correo;
        $result = $conexion->consultar($sql);

        $response = array();

        if ($conexion->obtenerFilasAfectadas() > 0) {
            $response['status'] = 'error';
            $response['message'] = 'El correo electrónico ya se encuentra registrado.';
        } else {
            $response['status'] = 'success';
        }

        echo json_encode($response);
        $conexion->cerrar();
    } catch (Exception $exc) {
        $response['status'] = 'error';
        $response['message'] = $exc->getMessage();
        echo json_encode($response);
    }
}