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
    header('Location: ../landingPages/errorAccesoSinLogin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/js/landingPages/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/paciente/styleMenuPaciente.css"/>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand titulo-agendamiento" href="menuPaciente.php" name="name">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="../../controladores/paciente/controlEditarPerfil.php" method="POST" style="display: inline;">
                            <input type="hidden" name="documentoPersona" value="<?php echo $documento; ?>">
                            <button type="submit" class="nav-link btn btn-link">Editar Perfil</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cerrarSesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container1">
        <div class="jumbotron">
            <h1 class="display-4">¡Bienvenido, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
            <hr class="my-4">
            <div class="row servicios-citas">
                <div class="col-md-6">
                    <h2>Agendamiento</h2>
                    <p>Agenda tu cita con nosotros.</p>
                    <a href="agendarCita.php" class="btn btn-primary">Agendar Cita</a>
                </div>
                <div class="col-md-6">
                    <h2>Edición de citas</h2>
                    <p>Gestiona tus citas odontológicas.</p>
                    <form action="../../controladores/paciente/controlCitasPaciente.php" method="post">
                        <input type="hidden" name="documentoConsultarCitas" id="documentoConsultarCitas" value="<?php echo $documento; ?>">
                        <button type="submit" class="btn btn-primary">Modificar Citas</button>
                    </form>
                </div>
                <div>
                    <h2>Calificar Citas</h2>
                    <p>Califica tus citas odontologicas</p>
                    <form action="../../controladores/paciente/controlCalificacion.php" method="post">
                        <input type="hidden" name="documentoCalificar" id="documentoCalificar" value="<?php echo $documento; ?>">
                        <button type="submit" class="btn btn-primary">Consultar Agenda</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

