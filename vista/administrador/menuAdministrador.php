<?php
session_start();

// Comprobar si hay una sesión activa
if (!isset($_SESSION['DOCUMENTO'])) {
    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('Location: ../landingPages/errorAccesoSinLogin.php');
    exit();
}

// Obtener el ID_ROL de la sesión
$idRol = $_SESSION['ID_ROL'];

// Definir el ID_ROL permitido
$idRolPermitido = 1; // Puedes cambiar esto al número que desees permitir

// Verificar si el ID_ROL es diferente al permitido
if ($idRol != $idRolPermitido) {
    // Redirigir a la página de error de acceso
    header('Location: ../landingPages/errorAccesoSinPermisos.php');
    exit();
}

// Resto del código para usuarios autenticados
    $documento = $_SESSION['DOCUMENTO'];
    $nombre = $_SESSION['NOMBRE'];
    $apellido = $_SESSION['APELLIDO'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bienvenido</title>
    <link rel="icon" href="../../assets/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: url('../../assets/img/backgroundGlobal.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
            padding-top: 0.25rem; /* Ajusta el padding superior del navbar */
            padding-bottom: 0.25rem; /* Ajusta el padding inferior del navbar */
        }
        .navbar-brand {
            font-weight: bold;
            padding: 0.5rem 1rem; /* Ajusta el padding del brand para reducir la altura */
        }
        .nav-link {
            padding: 0.5rem 1rem; /* Ajusta el padding de los links para reducir la altura */
        }
        .jumbotron {
            margin-top: 5em;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .card {
            border: 1px solid #B9B4B3;
            border-radius: 10px;
        }
        .card-title {
            color: #007bff;
        }
        .btn-primary, .btn-success {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            border: none;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            margin-top: 0.5rem;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Centro Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cerrarSesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">¡Bienvenid@, Administrad@r!</h1>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Control de Insumos</h5>
                            <p class="card-text">Administra los insumos de la clínica.</p>
                            <a href="gestionInsumos.php" class="btn btn-primary">Ir a Gestión de Existencias</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Sedes</h5>
                            <p class="card-text">Gestiona las sedes disponibles.</p>
                            <a href="gestionSedes.php" class="btn btn-primary">Ir a Gestión de Consultorios</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Consultorios</h5>
                            <p class="card-text">Gestiona los consultorios disponibles.</p>
                            <a href="gestionConsultorios.php" class="btn btn-primary">Ir a Gestión de Consultorios</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Gestión de Citas</h5>
                            <p class="card-text">Gestiona las citas programadas.</p>
                            <a href="gestionCitas.php" class="btn btn-primary">Ir a Gestión de Citas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Gestion de Personas</h5>
                            <p class="card-text">Gestiona las personas registradas.</p>
                            <a href="gestionPersonas.php" class="btn btn-primary">Ir a Gestión de Personas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Gestion de Profesionales</h5>
                            <p class="card-text">Gestiona la lista de profesionales.</p>
                            <a href="gestionOdontologos.php" class="btn btn-primary">Ir a Gestión de Profesionales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
