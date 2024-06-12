<?php
include '../../controladores/conexionBD.php';

if (isset($_POST['documento'])) {
    $documento = $_POST['documento'];
    
    try {
        $conexion = new conexionBD;
        $conexion->abrir();
        $sql = "SELECT * FROM persona WHERE documento = '$documento'";
        $result = $conexion->consultar($sql);

        $response = array();

        // Utiliza obtenerFilasAfectadas() en lugar de obtenerNumeroFilas()
        if ($conexion->obtenerFilasAfectadas() > 0) {
            $response['status'] = 'error';
            $response['message'] = 'El número de cédula ya se encuentra registrado.';
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
?>
