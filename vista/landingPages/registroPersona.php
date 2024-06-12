<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/landingPages/styleRegistro.css"/>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand titulo-navbar" href="#">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto boton botones-navegacion">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Pagina Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="iniciarSesion.php">Iniciar de Sesion</a>
                </li>
            </ul>
        </div>
    </header>
    
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="registroForm">
                    <h1>REGISTRO</h1>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="10" required>
                        <div class="error-message" id="tel-error" style="display: none;">El teléfono no puede contener letras, solo puede contener números.</div>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_documento" class="form-label">Tipo de documento:</label>
                        <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                            <!-- Opciones cargadas dinámicamente mediante JavaScript -->
                        </select>
                        <br>
                        <div id="doc-error" class="error-message" style="display: none;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Número de documento:</label>
                        <input type="tel" class="form-control" id="documento" name="documento" maxlength="10" required>
                        <div class="error-message" id="documento-error" style="display: none;">El número de cédula ya se encuentra registrado.</div>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                        <div class="error-message" id="correo-error" style="display: none;">El correo electrónico ya se encuentra registrado.</div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="8" required>
                    </div>
                    <button type="submit" class="register-button">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../assets/js/landingPages/registroPersona.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.min.js"></script>
</body>
</html>
