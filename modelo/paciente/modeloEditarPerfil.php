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
                        p.CONTRASENA
                    FROM 
                        PERSONA p
                    INNER JOIN 
                        TIPO_DOCUMENTO td ON p.TIPO_DOCUMENTO = td.ID_DOCUMENTO
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
    
    public function guardarInfoPerfil($documento, $nombre, $apellido, $fecha_nacimiento, $telefono, $correo, $direccion) {
        try {
            $conexion = new conexionBD();
            $conexion->abrir();
            $sql = "UPDATE PERSONA
                        SET NOMBRE = '$nombre', 
                            APELLIDO = '$apellido', 
                            FECHA_NACIMIENTO = '$fecha_nacimiento', 
                            TELEFONO = '$telefono', 
                            CORREO = '$correo', 
                            DIRECCION = '$direccion'
                        WHERE DOCUMENTO = '$documento';";
            echo$sql;
            $conexion->consultar($sql);
            $res = $conexion->obtenerFilasAfectadas();
            if ($res == 1) {
                echo 'SI';
                exit();    
            }else{
                echo 'No'; 
                exit();  
            } 
            $conexion->cerrar();
            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
