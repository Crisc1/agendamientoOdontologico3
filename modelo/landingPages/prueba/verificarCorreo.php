<?php
include '../../controladores/conexionBD.php';

if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    try {
        $conexion = new conexionBD;
        $conexion->abrir();
        $sql = "SELECT * FROM persona WHERE correo = '$correo'";
        $result = $conexion->consultar($sql);

        $response = array();

        if ($conexion->obtenerFilasAfectadas() > 0) {
            $response['status'] = 'error';
            $response['message'] = 'El correo electrónico ya se encuentra registrado.';
        }

        echo json_encode($response); // Devolver la respuesta como JSON
        $conexion->cerrar();
    } catch (Exception $exc) {
        $response['status'] = 'error';
        $response['message'] = $exc->getMessage();
        echo json_encode($response); // Devolver la respuesta como JSON
    }
}
