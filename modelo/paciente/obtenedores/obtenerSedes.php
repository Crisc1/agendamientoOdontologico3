<?php
require '../../../controladores/conexionBD.php';
// Crear una instancia de la clase conexionBD
$conexionBD = new conexionBD();

// Abrir la conexión a la base de datos
if ($conexionBD->abrir()) {
    // Realizar la consulta a la base de datos
    $consulta = "SELECT ID_SEDE, NOMBRE_SEDE FROM SEDE";
    $conexionBD->consultar($consulta);

    // Obtener el resultado de la consulta
    $resultado = $conexionBD->obtenerResult();

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        $sedes = array();

        // Recorrer los resultados y almacenar en un array asociativo
        while ($fila = $resultado->fetch_assoc()) {
            $sedes[] = array(
                'id' => $fila['ID_SEDE'],
                'nombre' => $fila['NOMBRE_SEDE']
            );
        }

        // Devolver los resultados en formato JSON
        echo json_encode($sedes);
    } else {
        // No se encontraron resultados
        echo json_encode(array('mensaje' => 'No hay sedes disponibles.'));
    }

    // Cerrar la conexión a la base de datos
    $conexionBD->cerrar();
} else {
    // No se pudo abrir la conexión a la base de datos
    echo json_encode(array('error' => 'No se pudo abrir la conexión a la base de datos.'));
}
?>