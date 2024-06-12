<?php
include '../../controladores/conexionBD.php';
class modeloRegistroPersona {
    public function regPersona(claseRegistroPersona $regPersona) {
        try {
            $conexion = new conexionBD;
            $conexion->abrir();
            $documento = $regPersona->getDocumento();
            $nombre = $regPersona->getNombre();
            $apellido = $regPersona->getApellido();
            $telefono = $regPersona->getTelefono();
            $tipo_documento = $regPersona->getTipo_documento();
            $fecha_nacimiento = $regPersona->getFecha_nacimiento();
            $correo = $regPersona->getCorreo();
            $direccion = $regPersona->getDireccion();
            $contrasena = $regPersona->getContrasena();
            $sql = "INSERT INTO persona VALUES ('$documento','$tipo_documento','$nombre','$apellido','$fecha_nacimiento','$telefono','$correo','$direccion','$contrasena', 5)";
            $conexion->consultar($sql);

            $res = $conexion->obtenerFilasAfectadas();

            $response = array();

            if ($res == 1) {
                $response['status'] = 'success';
                $response['message'] = 'Persona registrada exitosamente.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al registrar la persona.';
            }

            echo json_encode($response);
            $conexion->cerrar();
        } catch (Exception $exc) {
            $response = array('status' => 'error');
            if ($exc->getCode() == 23000) { // 23000 is the SQL state code for integrity constraint violation
                $response['message'] = 'El número de cédula ya se encuentra registrado.';
            } else {
                $response['message'] = $exc->getMessage();
            }
            echo json_encode($response);
        }
    }
}
?>
