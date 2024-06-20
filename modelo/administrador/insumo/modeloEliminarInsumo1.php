<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idInsumo'])) {
    require_once 'modeloInsumos.php';
    $modeloInsumos = new ModeloInsumos();
    
    // Llamar al método para eliminar insumo
    $eliminado = $modeloInsumos->eliminarInsumo($data['idInsumo']);
    
    if ($eliminado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al eliminar el insumo']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'ID de insumo no proporcionado']);
}
?>