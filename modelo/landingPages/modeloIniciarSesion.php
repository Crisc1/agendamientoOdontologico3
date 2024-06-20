<?php
session_start();
include '../../controladores/conexionBD.php';

// Conectar a la base de datos
$conexion = new conexionBD();
$conexion->abrir();

$documento = $_POST['documento'];
$contrasena = $_POST['contrasena'];

$query = "SELECT ID_ROL, DOCUMENTO, NOMBRE, APELLIDO FROM PERSONA WHERE DOCUMENTO = '$documento' AND CONTRASENA = '$contrasena'";
$conexion->consultar($query);
$resultado = $conexion->obtenerResult();

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $_SESSION['ID_ROL'] = $row['ID_ROL'];
    $_SESSION['DOCUMENTO'] = $row['DOCUMENTO'];
    $_SESSION['NOMBRE'] = $row['NOMBRE'];
    $_SESSION['APELLIDO'] = $row['APELLIDO'];
    
    if ($_SESSION['ID_ROL'] === '3') {
        $query = "SELECT ID_PROFESIONAL FROM profesional WHERE DOCUMENTO = '$documento'";
        $conexion->consultar($query);
        $resultado = $conexion->obtenerResult();
        
        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $_SESSION['ID_PROFESIONAL'] = $row['ID_PROFESIONAL'];
        }
    }

    switch ($_SESSION['ID_ROL']) {
        case '0':
            header("Location: ../../vista/usuario/menuUsuario.php");
            break;
        case '1':
            header("Location: ../../vista/administrador/menuAdministrador.php");
            break;
        case '2':
            header("Location: ../../vista/recepcion/menuRecepcion.php");
            break;
        case '3':
            header("Location: ../../vista/odontologo/menuOdontologo.php");
            break;
        case '4':
            header("Location: ../../vista/paciente/menuPaciente.php");
            break;
    }
} else {
    // Autenticación incorrecta
    header("Location: ../../vista/landingPages/iniciarSesion.php?error=1");
    exit();
}

// Cerrar la conexión
$conexion->cerrar();
?>
