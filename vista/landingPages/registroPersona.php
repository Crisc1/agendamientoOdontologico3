<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="icon" href="../assets/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .form-container {
            margin-top: 50px;
        }
        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 2px solid #007bff;
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        label {
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type='number'],
        input[type='tel'],
        input[type='email'] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
        button.btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 12px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            display: block;
            margin: 0 auto;
        }
        button.btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Centro Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse botones-navegacion" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Pagina Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="iniciarSesion.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="registroForm" action="../../controladores/landingPages/controlRegistroPersona.php" method="post">
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
                        <select class="form-select" id="tipo_documento" name="tipo_documento" required></select>
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
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../assets/js/landingPages/registroPersona.js"></script>
</body>
</html>
