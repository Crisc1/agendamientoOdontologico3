<?php
include_once "../../../controladores/conexionBD.php";

$conexionBD = new conexionBD();

if ($conexionBD->abrir()) {
    if (isset($_GET['idEspecialidad'])) {
        $idEspecialidad = $_GET['idEspecialidad'];

        // Realizar la consulta a la base de datos para obtener profesionales según la especialidad seleccionada
        $consulta = "SELECT P.DOCUMENTO, P.NOMBRE, P.APELLIDO, PR.ID_PROFESIONAL
                    FROM persona P
                    INNER JOIN profesional PR ON P.DOCUMENTO = PR.DOCUMENTO
                    INNER JOIN profesional_especialidad PE ON PR.ID_PROFESIONAL = PE.ID_PROFESIONAL
                    WHERE PE.ID_ESPECIALIDAD = $idEspecialidad";
        $conexionBD->consultar($consulta);

        // Obtener el resultado de la consulta
        $resultado = $conexionBD->obtenerResult();

        // Verificar si se obtuvieron resultados
        if ($resultado->num_rows > 0) {
            $profesionales = array();

            // Recorrer los resultados y almacenar en un array asociativo
            while ($fila = $resultado->fetch_assoc()) {
                $profesionales[] = array(
                    'id_profesional' => $fila['ID_PROFESIONAL'],
                    'nombre_completo' => $fila['NOMBRE'] . ' ' . $fila['APELLIDO']
                );
            }

            // Devolver los resultados en formato JSON
            echo json_encode($profesionales);
        } else {
            // No se encontraron resultados
            echo json_encode(array('mensaje' => 'No hay odontólogos disponibles para la especialidad seleccionada.'));
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
