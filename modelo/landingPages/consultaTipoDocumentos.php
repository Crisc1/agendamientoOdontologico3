<?php
require_once '../../controladores/conexionBD.php';

$conexion = new conexionBD();

if ($conexion->abrir()) {
    $sql = "SELECT ID_DOCUMENTO, NOMBRE_DOCUMENTO FROM tipo_documento";
    $conexion->consultar($sql);
    
    if ($conexion->obtenerFilasAfectadas() > 0) {
        $resultado = $conexion->obtenerResult();
        
        $tiposDocumento = array(); // Crear un array para almacenar los tipos de documento
        
        while($fila = $resultado->fetch_assoc()) {
            $tiposDocumento[] = array(
                'id' => $fila["ID_DOCUMENTO"],
                'nombre' => $fila["NOMBRE_DOCUMENTO"]
            );
        }

        // Devolver los datos como JSON
        header('Content-Type: application/json');
        echo json_encode($tiposDocumento);
    } else {
        echo json_encode(array('error' => 'No hay tipos de documento disponibles'));
    }
    
    $conexion->cerrar();
} else {
    echo json_encode(array('error' => 'Error al conectar con la base de datos'));
}
?>
