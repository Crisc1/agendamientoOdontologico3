<?php
require_once '../../controladores/conexionBD.php';

if (isset($_GET['idEspecialidad'])) {
    $idEspecialidad = $_GET['idEspecialidad'];

    // Consultar tratamientos asociados a la especialidad
    $query = "SELECT ID_TRATAMIENTO, NOMBRE_TRATAMIENTO FROM TRATAMIENTO WHERE ID_ESPECIALIDAD = $idEspecialidad";
    $conexion = new conexionBD();
    $conexion->abrir();
    $conexion->consultar($query);
    $result = $conexion->obtenerResult();
    $tratamientos = $result->fetch_all(MYSQLI_ASSOC);

    // Devolver los resultados como JSON
    echo json_encode($tratamientos);

    $conexion->cerrar();
}
?>
