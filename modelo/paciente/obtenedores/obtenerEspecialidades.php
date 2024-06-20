<?php
include_once "../../../controladores/conexionBD.php";

// Crear una instancia de la clase conexionBD
$conexionBD = new conexionBD();

// Abrir la conexión a la base de datos
if ($conexionBD->abrir()) {
    // Realizar la consulta a la base de datos
    $consulta = "SELECT ID_ESPECIALIDAD, NOMBRE_ESPECIALIDAD FROM ESPECIALIDAD";
    $conexionBD->consultar($consulta);

    // Obtener el resultado de la consulta
    $resultado = $conexionBD->obtenerResult();

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        $especialidades = array();

        // Recorrer los resultados y almacenar en un array asociativo
        while ($fila = $resultado->fetch_assoc()) {
            $especialidades[] = array(
                'id' => $fila['ID_ESPECIALIDAD'],
                'nombre' => $fila['NOMBRE_ESPECIALIDAD']
            );
        }

        // Devolver los resultados en formato JSON
        echo json_encode($especialidades);
    } else {
        // No se encontraron resultados
        echo json_encode(array('mensaje' => 'No hay especialidades disponibles.'));
    }

    // Cerrar la conexión a la base de datos
    $conexionBD->cerrar();
} else {
    // No se pudo abrir la conexión a la base de datos
    echo json_encode(array('error' => 'No se pudo abrir la conexión a la base de datos.'));
}
?>
