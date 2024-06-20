<?php

require_once '../../controladores/conexionBD.php';

class ModeloInsumos {

    // Función para consultar todos los insumos
    public function consultarInsumos() {
        $conexion = new conexionBD();
        if ($conexion->abrir()) {
            $sql = "SELECT ID_INSUMO, NOMBRE, CANTIDAD, UNIDAD FROM insumos";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();

            // Convertir el resultado en un array
            $insumos = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $insumos[] = $row;
                }
            }

            return $insumos;
        } else {
            return false;
        }
    }

    // Función para actualizar los insumos
    public function actualizarInsumos($actualizaciones) {
        $conexion = new conexionBD();
        if ($conexion->abrir()) {
            foreach ($actualizaciones as $id => $cantidad) {
                // Prevenir inyección SQL usando prepared statements
                $sql = "UPDATE insumos SET CANTIDAD = CANTIDAD + $cantidad WHERE ID_INSUMO = $id";
                $conexion->consultar($sql);
            }
            $conexion->cerrar();
            return true;
        } else {
            return false;
        }
    }
    
    public function agregarInsumo($nombre, $cantidad, $unidad) {
        $conexion = new conexionBD();
        if ($conexion->abrir()) {
            $sql = "INSERT INTO INSUMOS (NOMBRE, CANTIDAD, UNIDAD) VALUES ('$nombre', $cantidad, '$unidad')";
            $conexion->consultar($sql);
            $conexion->cerrar();
            return true;
        } else {
            return false;
        }
    }
    
    // Función para eliminar un insumo por su ID
    public function eliminarInsumo($idInsumo) {
        $conexion = new ConexionBD();
        if ($conexion->abrir()) {
            // Prevenir inyección SQL usando prepared statements
            $sql = "DELETE FROM insumos WHERE ID_INSUMO = $idInsumo";
            $conexion->consultar($sql);
            $conexion->cerrar();
            return true;
        } else {
            return false;
        }
    }
}
