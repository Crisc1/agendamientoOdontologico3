<?php
session_start();

// Comprobar si hay una sesión activa
if (isset($_SESSION['DOCUMENTO'])) {
    // Obtener el ID_ROL de la sesión
    $idRol = $_SESSION['ID_ROL'];

    // Definir el ID_ROL permitido
    $idRolPermitido = 4; // Puedes cambiar esto al número que desees permitir

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
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/paciente/styleAgendamientoCitas.css"/>
    <title>Agendamiento</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Centro Odontológico</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../paciente/editarDatos.php">Editar Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../salidas/cerraSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>AGENDAMIENTO DE CITAS</h1>
        <form action="../../controladores/paciente/controlCitasPaciente.php" method="post">
            <div id="resultadoConsulta"></div>
            <input type="hidden" name="documento" value="<?php echo $documento; ?>">

            <div class="form-group">
                <label for="especialidad">Servicio:</label>
                <select name="especialidad" id="especialidad" required>
                    <option value="">Selecciona un servicio</option>
                    <!-- Aquí se cargarán dinámicamente las opciones de servicio mediante JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <label for="tratamiento">Tratamiento:</label>
                <select name="tratamiento" id="tratamiento" required>
                    <option value="" selected>Seleccione un tratamiento</option>
                    <!-- Las opciones se cargarán dinámicamente mediante JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <label for="profesional">Odontólogo:</label>
                <select name="profesional" id="profesional" required>
                    <option value="">Selecciona un odontólogo</option>
                    <!-- Aquí se cargarán dinámicamente las opciones de odontólogo mediante JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" required>
            </div>

            <div class="form-group">
                <label for="hora">Hora:</label>
                <select name="hora" id="hora" required>
                    <!-- Las opciones se cargarán dinámicamente mediante JavaScript -->
                </select>
            </div>

            <input type="hidden" name="consultorio" id="consultorio" value="1">
            <button type="submit">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/paciente/agendamiento/Especialidades.js"></script>
    <script src="../../assets/js/paciente/agendamiento/HorasDisponibles.js"></script>
    <script src="../../assets/js/paciente/agendamiento/Profesional.js"></script>
    <script src="../../assets/js/paciente/agendamiento/Tratamientos.js"></script>
</body>

</html>
