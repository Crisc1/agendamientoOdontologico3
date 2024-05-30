<?php
// Incluir el archivo con la lógica para consultar los odontogramas
include_once '../../modelo/odontologo/modeloOdontograma.php';

// Verificar si se recibió la fecha seleccionada
if (isset($_POST['fecha'])) {
    // Obtener la fecha seleccionada
    $fechaSeleccionada = $_POST['fecha'];

    // Crear una instancia del modelo para consultar odontogramas
    $modeloOdontograma = new modeloOdontograma();

    // Consultar los odontogramas para la fecha seleccionada
    $odontogramas = $modeloOdontograma->consultarOdontogramaPorFecha($fechaSeleccionada);

    // Verificar si se obtuvieron resultados
    if ($odontogramas) {
        // Construir la tabla con los resultados de la búsqueda
        $tabla = '<div class="table-responsive">';
        $tabla .= '<table class="table table-striped">';
        $tabla .= '<thead>';
        $tabla .= '<tr>';
        $tabla .= '<th>ID Diente</th>';
        $tabla .= '<th>Comentario</th>';
        // Puedes agregar más columnas según sea necesario
        $tabla .= '</tr>';
        $tabla .= '</thead>';
        $tabla .= '<tbody>';

        // Iterar sobre los odontogramas y agregar cada uno a la tabla
        foreach ($odontogramas as $odontograma) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $odontograma['ID_DIENTE'] . '</td>';
            $tabla .= '<td>' . $odontograma['COMENTARIO'] . '</td>';
            // Puedes mostrar más columnas si es necesario
            $tabla .= '</tr>';
        }

        $tabla .= '</tbody>';
        $tabla .= '</table>';
        $tabla .= '</div>';

        // Devolver la tabla como respuesta a la solicitud AJAX
        echo $tabla;
    } else {
        // Manejar el caso donde no se encontraron odontogramas para la fecha seleccionada
        echo '<p class="text-danger">No se encontraron odontogramas para la fecha seleccionada.</p>';
    }
}
?>
