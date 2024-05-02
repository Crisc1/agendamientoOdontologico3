<?php
include_once "../../../controladores/conexionBD.php";

// Crear una instancia de la clase ConexionDB
$conexionBD = new conexionBD();

// Abrir la conexión a la base de datos
if ($conexionBD->abrir()) {
    if (isset($_GET['idEspecialidad'])) {
        $idEspecialidad = $_GET['idEspecialidad'];

        // Realizar la consulta a la base de datos para obtener tratamientos según la especialidad seleccionada
        $consulta = "SELECT ID_TRATAMIENTO, NOMBRE_TRATAMIENTO FROM tratamiento WHERE ID_ESPECIALIDAD = $idEspecialidad";
        $conexionBD->consultar($consulta);

        // Obtener el resultado de la consulta
        $resultado = $conexionBD->obtenerResult();

        // Verificar si se obtuvieron resultados
        if ($resultado->num_rows > 0) {
            $tratamientos = array();

            // Recorrer los resultados y almacenar en un array asociativo
            while ($fila = $resultado->fetch_assoc()) {
                $tratamientos[] = array(
                    'id' => $fila['ID_TRATAMIENTO'],
                    'nombre' => $fila['NOMBRE_TRATAMIENTO']
                );
            }

            // Devolver los resultados en formato JSON
            echo json_encode($tratamientos);
        } else {
            // No se encontraron resultados
            echo json_encode(array('mensaje' => 'No hay tratamientos disponibles para la especialidad seleccionada.'));
        }
    } else {
        // El parámetro idEspecialidad no está presente en la solicitud
        echo json_encode(array('error' => 'Parámetro idEspecialidad no proporcionado.'));
    }

    // Cerrar la conexión a la base de datos
    $conexionBD->cerrar();
} else {
    // No se pudo abrir la conexión a la base de datos
    echo json_encode(array('error' => 'No se pudo abrir la conexión a la base de datos.'));
}
?>
