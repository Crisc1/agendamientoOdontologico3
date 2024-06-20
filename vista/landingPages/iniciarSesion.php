<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar sesión</title>
    <link rel="icon" href="../assets/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: url('../../assets/img/backgroundGlobal.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: #333;
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            margin-top: 0.5rem;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .alert {
            margin-top: 1rem;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #007bff;
        }

        .forgot-password:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .navbar .navbar-brand {
                font-size: 1.5rem;
            }

            .form-content {
                padding: 1rem;
            }

            .form-group label,
            .form-group input {
                font-size: 0.9rem;
            }

            .btn-primary,
            .btn-success {
                padding: 0.5rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Centro Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Página Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registroPersona.php">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container form-container">
        <div class="form-content">
            <div id="error-message" class="alert alert-danger d-none">
                Usuario o contraseña incorrectos.
            </div>
            <form action="../../modelo/landingPages/modeloIniciarSesion.php" method="post">
                <h2>Iniciar sesión</h2>
                <div class="form-group">
                    <label for="documento">Documento:</label>
                    <input type="text" class="form-control" id="documento" name="documento" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                <button id="btnRegistro" type="button" class="btn btn-success"
                    onclick="window.location.href='registroPersona.php';">Registrarse</button>
            </form>
            <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#recoverPasswordModal">¿Olvidaste tu contraseña?</a>
        </div>
    </div>

    <!-- Modal para recuperación de contraseña -->
    <div class="modal fade" id="recoverPasswordModal" tabindex="-1" aria-labelledby="recoverPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recoverPasswordModalLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../modelo/landingPages/modeloRecuperarContraseña.php" method="post">
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Enviar Enlace de Recuperación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Verificar si hay un error al cargar la página
        var urlParams = new URLSearchParams(window.location.search);
        var isErrorPresent = urlParams.has('error');

        // Mostrar el mensaje de error solo si isErrorPresent es verdadero
        if (isErrorPresent) {
            document.getElementById('error-message').classList.remove('d-none');
        }
    </script>
</body>

</html>
