<?php
require_once '../../../controladores/conexionBD.php';

if (isset($_GET['idSede']) && isset($_GET['idEspecialidad'])) {
    $conexion = new conexionBD();
    $conexion->abrir();
    $idSede = $_GET['idSede'];
    $idEspecialidad = $_GET['idEspecialidad'];

    // Consultar odontólogos por sede y especialidad
    $sql = "
        SELECT P.ID_PROFESIONAL, CONCAT(PR.NOMBRE, ' ', PR.APELLIDO) AS NOMBRE_COMPLETO, P.ID_CONSULTORIO
        FROM PROFESIONAL P
        JOIN PERSONA PR ON P.DOCUMENTO = PR.DOCUMENTO
        WHERE P.ID_SEDE = '$idSede';
    ";

    $conexion->consultar($sql);
    $result = $conexion->obtenerResult();
    $odontologos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $odontologos[] = $row;
    }

    $conexion->cerrar();

    header('Content-Type: application/json');
    echo json_encode($odontologos);
}
?>
