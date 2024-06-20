<?php
require_once'../../../controladores/conexionBD.php';

if (isset($_GET['idEspecialidad'])) {
    $conexion = new conexionBD();
    $conexion->abrir();
    $idEspecialidad = $_GET['idEspecialidad'];

    // Consultar tratamientos por especialidad
    $sqlTratamientos = "SELECT ID_TRATAMIENTO, NOMBRE_TRATAMIENTO FROM TRATAMIENTO WHERE ID_ESPECIALIDAD = '$idEspecialidad'";
    $conexion->consultar($sqlTratamientos);
    $resultTratamientos = $conexion->obtenerResult();
    $tratamientos = array();
    while ($row = mysqli_fetch_assoc($resultTratamientos)) {
        $tratamientos[] = $row;
    }

    // Consultar profesionales por especialidad
    $sqlProfesionales = "
        SELECT P.ID_PROFESIONAL, CONCAT(PR.NOMBRE, ' ', PR.APELLIDO) AS NOMBRE_COMPLETO
        FROM PROFESIONAL P
        JOIN PERSONA PR ON P.DOCUMENTO = PR.DOCUMENTO
        WHERE P.ID_ESPECIALIDAD = '$idEspecialidad'
    ";
    $conexion->consultar($sqlProfesionales);
    $resultProfesionales = $conexion->obtenerResult();
    $profesionales = array();
    while ($row = mysqli_fetch_assoc($resultProfesionales)) {
        $profesionales[] = $row;
    }

    $conexion->cerrar();

    echo json_encode(['tratamientos' => $tratamientos, 'profesionales' => $profesionales]);
}
?>