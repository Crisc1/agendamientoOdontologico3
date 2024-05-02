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
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/odontologo/styleMenuOdontologo.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand titulo-navbar" href="menuOdontologo.php">Agendamiento Odontológico</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto boton botones-navegacion">
                <li class="nav-item">
                    <a class="nav-link" href="#">Editar Perfil</a>
                </li>
                <li class="nav-item">
                    <hr class="vertical-line">
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cerrarSesion.php">Cerrar Sesion</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">¡Bienvenido Odontólogo, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
            <hr class="my-4">
            <div class="row servicios-citas">
                <div class="col-md-6">
                    <h2>Agenda Odontológica</h2>
                    <p>Aca podras ver tu agenda de citas.</p>
                    <form action="../../controladores/odontologo/controlCitasOdontologo.php" method="post">
                        <input type="hidden" name="idProfesionalAgenda" id="idProfesionalAgenda" value="<?php echo $idProfesional; ?>">
                        <button type="submit" class="btn btn-primary">Consultar Agenda</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h2>Historial Odontólogico</h2>
                    <p>Consuta y/o añade novedades al historial de un paciente.</p>
                    <a href="../odontologo/historialMenu.php" class="btn btn-primary">Consultar - Generar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>