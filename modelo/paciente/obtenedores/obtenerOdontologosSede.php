<?php
require '../../../controladores/conexionBD.php';

// Obtener el ID de la sede enviado desde JavaScript
$idSede = $_GET['sede_id'];

// Crear una instancia de la clase conexionBD
$conexionBD = new conexionBD();

// Abrir la conexión a la base de datos
if ($conexionBD->abrir()) {
    // Realizar la consulta a la base de datos
    $consulta = "SELECT PROFESIONAL.ID_PROFESIONAL, PROFESIONAL.ID_CONSULTORIO, CONCAT(PERSONA.NOMBRE, ' ', PERSONA.APELLIDO) AS NOMBRE_ODONTOLOGO
            FROM PROFESIONAL
            JOIN PERSONA ON PROFESIONAL.DOCUMENTO = PERSONA.DOCUMENTO
            WHERE PROFESIONAL.ID_SEDE = $idSede";
    $conexionBD->consultar($consulta);

    // Obtener el resultado de la consulta
    $resultado = $conexionBD->obtenerResult();

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        $odontologos = array();

        // Recorrer los resultados y almacenar en un array asociativo
        while ($fila = $resultado->fetch_assoc()) {
            $odontologos[] = array(
                'id' => $fila['ID_PROFESIONAL'],
                'nombre' => $fila['NOMBRE_ODONTOLOGO'],
                'id_consultorio' => $fila['ID_CONSULTORIO']
            );
        }

        // Devolver los resultados en formato JSON
        echo json_encode($odontologos);
    } else {
        // No se encontraron resultados
        echo json_encode(array('mensaje' => 'No hay odontólogos disponibles para esta sede.'));
    }

    // Cerrar la conexión a la base de datos
    $conexionBD->cerrar();
} else {
    // No se pudo abrir la conexión a la base de datos
    echo json_encode(array('error' => 'No se pudo abrir la conexión a la base de datos.'));
}
?>
