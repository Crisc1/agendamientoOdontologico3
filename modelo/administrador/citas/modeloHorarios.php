<?php
require_once'../../../controladores/conexionBD.php';

if (isset($_GET['idSede']) && isset($_GET['fecha'])) {
    $conexion = new conexionBD();
    $conexion->abrir();
    $idSede = $_GET['idSede'];
    $fecha = $_GET['fecha'];

    // Consultar horarios ocupados para la sede y fecha seleccionada
    $sql = "SELECT HORA FROM CITA WHERE ID_SEDE = '$idSede' AND FECHA = '$fecha'";
    $conexion->consultar($sql);
    $result = $conexion->obtenerResult();
    $horariosOcupados = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $horariosOcupados[] = $row['HORA'];
    }

    $conexion->cerrar();

    echo json_encode(['ocupados' => $horariosOcupados]);
}
?>

