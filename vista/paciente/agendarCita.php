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
    <link rel="icon" href="../../assets/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/js/landingPages/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/paciente/styleAgendamientoCitas.css"/>
    <script src="../../assets/js/volver.js"></script>
    <title>Agendamiento de citas</title>
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
        .bth-volver {
            background-color: #CD1A1A;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .bth-volver:hover {
            background-color: #A41515;
        }

        .content {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #3498db;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
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
                        <button class="bth-volver" onclick="volverPaginaAnterior()">Volver</button>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="content form-container">
        <h1>AGENDAMIENTO DE CITAS</h1>
        <form id="agendamientoForm" action="../../controladores/paciente/controlCitasPaciente.php" method="post">
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
                <label for="sede">Sedes:</label>
                <select name="sede" id="sede" required>
                    <option value="">Selecciona una sede</option>
                    <!-- Aquí se cargarán dinámicamente las opciones de odontólogo mediante JavaScript -->
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

            <input type="hidden" name="consultorio" id="consultorio">
            <button type="submit">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/paciente/agendamiento/Especialidades.js"></script>
    <script src="../../assets/js/paciente/agendamiento/HorasDisponibles.js"></script>
<!--    <script src="../../assets/js/paciente/agendamiento/Profesional.js"></script>-->
    <script src="../../assets/js/paciente/agendamiento/Tratamientos.js"></script>
    <script src="../../assets/js/paciente/agendamiento/Sede.js"></script>
    <script>
        document.getElementById('agendamientoForm').addEventListener('submit', function(event) {
            event.preventDefault();

        var especialidad = $('#especialidad option:selected').text();
        var tratamiento = $('#tratamiento option:selected').text();
        var profesional = $('#profesional option:selected').text();
        var sede = $('#sede option:selected').text();
            var fecha = document.getElementById('fecha').value;
            var hora = document.getElementById('hora').value;

            var mensaje = 'Por favor confirma la siguiente información antes de enviar:\n\n' +
                'Servicio: ' + especialidad + '\n' +
                'Tratamiento: ' + tratamiento + '\n' +
                'Sede: ' + sede + '\n' +
                'Odontólogo: ' + profesional + '\n' +
                'Fecha: ' + fecha + '\n' +
                'Hora: ' + hora;

            if (confirm(mensaje)) {
                this.submit();
            }
        });
    </script>
</body>

</html>
