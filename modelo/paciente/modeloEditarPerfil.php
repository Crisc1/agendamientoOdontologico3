<?php
include '../../controladores/conexionBD.php';

class modeloEditarPerfil {
    public function consultarInfoPerfil($documentoPersona) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();
            $sql = "SELECT 
                        p.DOCUMENTO, 
                        td.NOMBRE_DOCUMENTO AS TIPO_DOCUMENTO,
                        p.NOMBRE, 
                        p.APELLIDO, 
                        p.FECHA_NACIMIENTO, 
                        p.TELEFONO, 
                        p.CORREO, 
                        p.DIRECCION, 
                        p.CONTRASENA, 
                    FROM 
                        persona p
                    INNER JOIN 
                        tipo_documento td ON p.TIPO_DOCUMENTO = td.ID_DOCUMENTO
                    WHERE 
                        p.DOCUMENTO = '$documentoPersona';";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
        public function guardarInfoPerfil($documentoPersona) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();
            $sql = "SELECT 
                        p.DOCUMENTO, 
                        td.NOMBRE_DOCUMENTO AS TIPO_DOCUMENTO,
                        p.NOMBRE, 
                        p.APELLIDO, 
                        p.FECHA_NACIMIENTO, 
                        p.TELEFONO, 
                        p.CORREO, 
                        p.DIRECCION, 
                        p.CONTRASENA, 
                        r.ID_ROL,
                        r.NOMBRE_ROL
                    FROM 
                        persona p
                    INNER JOIN 
                        tipo_documento td ON p.TIPO_DOCUMENTO = td.ID_DOCUMENTO
                    INNER JOIN 
                        rol r ON p.ID_ROL = r.ID_ROL
                    WHERE 
                        p.DOCUMENTO = '$documentoPersona';";
            $conexion->consultar($sql);
            $result = $conexion->obtenerResult();
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
