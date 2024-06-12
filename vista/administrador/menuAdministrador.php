<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Reemplaza la ruta al archivo CSS con la ruta correcta -->
    <link rel="stylesheet" href="../../assets/css/administrador/styleMenuAdministrador.css"/>
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand titulo-agendamiento" href="menuPaciente.php" name="name">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- Añadí el cierre de la etiqueta ul -->
                <li class="nav-item">
                    <a class="nav-link" href="cerrarSesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="container">
    <div class="jumbotron">
        <!-- Añadí un valor predeterminado para $nombre y $apellido -->
        <?php
            $nombre = "Nombre";
            $apellido = "Apellido";
        ?>
        <h1 class="display-4">¡Bienvenido Administrador, <?php echo $nombre . ' ' . $apellido; ?>!</h1>
        <hr class="my-4">
        <div class="row servicios-citas">
            <div class="col-md-4">
                <h2>Control de Insumos</h2>
                <p>Administra los insumos de la clínica.</p>
                <!-- Cambia el enlace a donde corresponda -->
                <a href="insumos.php" class="btn btn-primary">Ir a Control de Insumos</a>
            </div>

            <div class="col-md-4">
                <h2>Consultorios</h2>
                <p>Gestiona los consultorios disponibles.</p>
                <!-- Cambia el enlace a donde corresponda -->
                <a href="gesConsultorio.php" class="btn btn-primary">Ir a Gestión de Consultorios</a>
            </div>

            <div class="col-md-4">
                <h2>Gestión de Citas</h2>
                <p>Gestiona las citas programadas.</p>
                <!-- Cambia el enlace a donde corresponda -->
                <a href="gestion_citas.php" class="btn btn-primary">Ir a Gestión de Citas</a>
            </div>
        </div>
        <div class="row servicios-citas mt-4">
            <div class="col-md-4">
                <h2>Gestión de Pacientes</h2>
                <p>Gestiona los registros de los pacientes.</p>
                <!-- Cambia el enlace a donde corresponda -->
                <a href="gestionPersonasRegistradas.php" class="btn btn-primary">Ir a Gestión de Pacientes</a>
            </div>
        </div>
    </div>
</div>
<!-- Agregar los scripts necesarios de Bootstrap y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

