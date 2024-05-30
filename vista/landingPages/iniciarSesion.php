<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/js/landingPages/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/landingPages/styleiniciarSesion.css"/>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand titulo-agendamiento" href="../../index.php" name="name">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Pagina Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../landingPages/registroPersona.php">Registro</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container form-container">
        <form action="../../modelo/landingPages/modeloIniciarSesion.php" method="post">
            <h2>Iniciar sesión</h2>
            <!-- Mostrar mensaje de error si está presente -->
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                // Limpiar la variable de sesión después de mostrar el mensaje
                unset($_SESSION['error_message']);
            }
            ?>
            <div class="form-group">
                <label for="documento">Documento:</label>
                <input type="text" class="form-control" id="documento" name="documento" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            <button id="btnRegistro" type="button" class="btn btn-success" onclick="window.location.href='../vista/registro.php';">Registrarse</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
