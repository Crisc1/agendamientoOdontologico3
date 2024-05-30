<?php
// Incluir las clases y archivos necesarios
include '../../clases/odontologo/claseHistorialOdontologo.php';
include '../../modelo/odontologo/modeloOdontograma.php';

// Obtener el contenido JSON del cuerpo de la solicitud
$json_data = file_get_contents("php://input");

// Decodificar el JSON en un array asociativo
$data = json_decode($json_data, true);

// Inicializar el array para la respuesta
$response = [];

// Verificar si se proporcionaron los datos de odontograma, documentoPaciente y id_diente
if (isset($data['odontograma']) && isset($data['documentoPaciente'])) {
    try {
        // Obtener los datos de odontograma y documentoPaciente
        $odontograma = $data['odontograma'];
        $documentoPaciente = $data['documentoPaciente'];

        // Iterar sobre los elementos del odontograma
        foreach ($odontograma as $item) {
            // Verificar si el elemento tiene el campo 'comentario' y 'idDiente'
            if (isset($item['comentario']) && isset($item['idDiente'])) {
                // Obtener el comentario y el idDiente
                $comentario = $item['comentario'];
                $idDiente = $item['idDiente'];

                // Obtener la fecha si está presente, de lo contrario, usar la fecha actual
                $fecha = isset($item['fecha']) ? $item['fecha'] : date('Y-m-d');

                // Aquí puedes agregar el código para guardar los datos en la base de datos
                // Crear instancia de la claseHistorial y llamar al método odontograma
                $odontogramaAdulto = new claseHistorialOdontologo();
                $odontogramaAdulto->odontograma($documentoPaciente, $fecha, $idDiente, $comentario); // Ajustar para pasar el id_diente

                // Si es necesario, registrar el odontograma en el modelo
                $regOdontograma = new modeloOdontograma();
                $regOdontograma->regOdontogramaAdulto($documentoPaciente, $fecha, $idDiente, $comentario); // Ajustar para pasar el id_diente
            } else {
                // Si falta el campo 'comentario' o 'idDiente', no hacer nada
            }
        }

        // Establecer la respuesta de éxito
        $response['success'] = true;
        $response['message'] = 'Odontograma(s) guardado(s) con éxito';
    } catch (Exception $exc) {
        // Establecer la respuesta de error
        $response['success'] = false;
        $response['message'] = $exc->getMessage();
    }
    
echo json_encode($response);  
}

if(isset($_POST['consultaOdontograma'])){
        try {
            $documentoPaciente = $_POST['documentoOdontograma'];
            $odontograma = new claseHistorialOdontologo();
            $odontograma->consultarOdontograma($documentoPaciente);
            $consultar=new modeloConsultarOdontograma();
            $result=$consultar->consultarOdontograma($documentoPaciente);
            require '../../vista/odontologo/odontogramaConsulta.php';
        } catch (Exception $exc) {
        echo 'Error:'. $exc;
        }
    }

else{
    $alerta="Llenar todos los campos";
    echo "alert('".$alerta."');";
}
?>
