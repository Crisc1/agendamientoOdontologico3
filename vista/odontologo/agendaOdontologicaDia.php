<?php
session_start();

// Comprobar si hay una sesión activa
if (isset($_SESSION['DOCUMENTO'])) {
    // Obtener el ID_ROL de la sesión
    $idRol = $_SESSION['ID_ROL'];

    // Definir el ID_ROL permitido
    $idRolPermitido = 3; // Puedes cambiar esto al número que desees permitir

    // Verificar si el ID_ROL es diferente al permitido
    if ($idRol != $idRolPermitido) {
        // Redirigir a la página de error de acceso
        header('Location: ../salidas/errorAccesoSinPermisos.php');
        exit();
    }

    // Resto del código para usuarios autenticados
    $documento = $_SESSION['DOCUMENTO'];
    $nombre = $_SESSION['NOMBRE'];
    $apellido = $_SESSION['APELLIDO'];
    $idProfesional = $_SESSION['ID_PROFESIONAL'];
} else {
    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('Location: ../salidas/errorAccesoSinLogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agenda Odontologica</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/odontologo/styleAgedamientoOdontologicaDia.css">
    <script src="../../assets/js/odontologo/agendaOdontologicaDia.js"></script>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand titulo-agendamiento" href="../../vista/odontologo/menuOdontologo.php" name="name">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="vista/landingPages/iniciarSesion.php">Iniciar de Sesion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vista/landingPages/registroPersona.php">Resgistrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    
    <div class="content-container">
        <h1>Lista de Citas</h1>
        <?php

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar la tabla con los detalles de las citas
            echo "<table>
                    <tr>
                        <th>Paciente</th>
                        <th>Tipo de Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Consultorio</th>
                        <th>Acciones</th>
                    </tr>";

            while ($fila = $result->fetch_object()) {
echo "<tr>
        <td>{$fila->NOMBRE_PACIENTE}</td>
        <td>{$fila->NOMBRE_TRATAMIENTO}</td>
        <td>{$fila->FECHA}</td>
        <td>{$fila->HORA}</td>
        <td>{$fila->NUMERO_CONSULTORIO}</td>
        <td>
            <form method='post' action='../../vista/odontologo/menuHistorial.php'>
                <input type='hidden' name='documentoPaciente' value='{$fila->DOCUMENTO_PACIENTE}'>
                <button type='submit' class='btn editar-btn'>Asistió</button>
            </form>
            <button class='btn eliminar-btn' onclick='inasistencia({$fila->DOCUMENTO_PACIENTE})'>No Asistió</button>
        </td>
    </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay citas disponibles.";
        }
        ?>
    </div>
</body>
</html>
