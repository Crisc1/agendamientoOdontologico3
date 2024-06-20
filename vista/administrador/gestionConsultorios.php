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

require_once '../../modelo/administrador/modeloConsultorios.php';

$modeloConsultorios = new modeloConsultorios();

function consultarYActualizarConsultorios() {
    global $modeloConsultorios;

    // Consultar consultorios
    $resultados = $modeloConsultorios->consultarConsultorios();

    // Procesar formulario de actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar eliminación de consultorios
        if (isset($_POST['eliminarConsultorio'])) {
            $idConsultorio = $_POST['eliminarConsultorio'];
            $mensaje = $modeloConsultorios->eliminarConsultorio($idConsultorio);

            if (strpos($mensaje, "Consultorio eliminado correctamente") !== false) {
                $_SESSION['mensaje'] = $mensaje;
            } else {
                $_SESSION['error'] = $mensaje;
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionConsultorios.php');
            exit();
        }
        

        // Procesar adición de consultorios
        if (isset($_POST['agregarConsultorio'])) {
            $numeroNuevo = $_POST['numeroNuevo'];
            $sedeNuevo = $_POST['sedeNuevo'];

            if ($modeloConsultorios->agregarConsultorio($numeroNuevo, $sedeNuevo)) {
                $_SESSION['mensaje'] = "Consultorio agregado exitosamente";
            } else {
                $_SESSION['mensaje'] = "Error al agregar consultorio";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionConsultorios.php');
            exit();
        }

        // Procesar edición de consultorios
        if (isset($_POST['guardarEdicion'])) {
            $idConsultorio = $_POST['editarIdConsultorio'];
            $numeroConsultorio = $_POST['editarNumeroConsultorio'];
            $sedeConsultorio = $_POST['editarSedeConsultorio'];

            if ($modeloConsultorios->editarConsultorio($idConsultorio, $numeroConsultorio, $sedeConsultorio)) {
                $_SESSION['mensaje'] = "Consultorio editado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al editar consultorio";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionConsultorios.php');
            exit();
        }
    }

    // Consultar nuevamente los consultorios después de la operación
    $resultados = $modeloConsultorios->consultarConsultorios();

    return $resultados;
}

$resultados = consultarYActualizarConsultorios();
$sedes = $modeloConsultorios->consultarTodasSedes(); // Cambio aquí para obtener todas las sedes

//$resultados = consultarYActualizarConsultorios();
//$sedes = $modeloConsultorios->consultarConsultorios(); // Cambio aquí para obtener todas las sedes

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Consultorios</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: url('../../assets/img/backgroundGlobal.jpg') no-repeat center center fixed;
            background-size: cover;
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        .navbar-brand {
            font-weight: bold;
            padding: 0.5rem 1rem;
        }
        .nav-link {
            padding: 0.5rem 1rem;
        }
        .bth-volver {
            background-color: #CD1A1A;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-decoration: none; /* Quitar subrayado */
            display: inline-block; /* Hacer que se comporte como un bloque en línea */
            text-align: center; /* Centrar el texto */
            line-height: 1; /* Ajustar la altura de línea para centrar verticalmente */
        }

        .bth-volver:hover {
            background-color: #A41515;
            text-decoration: none; /* Mantener el subrayado quitado en el hover */
        }
        .form-container {
            margin-top: 60px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .content {
            margin-left: auto;
            margin-right: auto;
            max-width: 800px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        h1 {
            color: #3498db;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
        }
        .eliminar-btn {
            background-color: #dc3545;
            color: #fff;
        }
        .eliminar-btn:hover {
            background-color: #bd2130;
        }
        .btn-toggle {
            background-color: #007bff;
            color: white;
        }
        .btn-toggle:hover {
            background-color: #0056b3;
            color: white;
        }
        .hidden {
            display: none;
        }
        .form-nuevo-consultorio {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }
        .table-primary th {
            background-color: #007bff;
            color: white;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="menuAdministrador.php">Centro Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="menuAdministrador.php" class="bth-volver">Volver</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="container form-container">
        <div class="content">
            <h1 class="text-center mb-4">Gestión de Consultorios</h1>
            
            <!-- Mensajes de éxito o error -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <!-- Botón para agregar nuevo consultorio -->
            <div class="text-center mb-3"> <!-- Contenedor centrado -->
                <button id="btnNuevoConsultorio" class="btn btn-primary">Nuevo Consultorio</button>
            </div>

            <!-- Formulario para agregar nuevo consultorio -->
            <div id="formularioNuevoConsultorio" class="form-nuevo-consultorio hidden">
                <h3>Agregar Nuevo Consultorio</h3>
                <form action="gestionConsultorios.php" method="POST">
                    <div class="mb-3">
                        <label for="numeroNuevo" class="form-label">Número de Consultorio:</label>
                        <input type="text" class="form-control" id="numeroNuevo" name="numeroNuevo" required>
                    </div>
                    <div class="mb-3">
                        <label for="sedeNuevo" class="form-label">Sede:</label>
                        <select class="form-control" id="sedeNuevo" name="sedeNuevo" required>
                            <?php foreach ($sedes as $sede): ?>
                                <option value="<?php echo $sede['ID_SEDE']; ?>"><?php echo $sede['NOMBRE_SEDE']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="agregarConsultorio" class="btn btn-success">Agregar Consultorio</button>
                </form>
            </div>

            <!-- Tabla de consultorios existentes -->
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Número de Consultorio</th>
                        <th>Sede</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $consultorio): ?>
                        <tr>
                            <td><?php echo $consultorio['NUMERO_CONSULTORIO']; ?></td>
                            <td><?php echo $consultorio['NOMBRE_SEDE']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="editarConsultorio('<?php echo $consultorio['ID_CONSULTORIO']; ?>', '<?php echo $consultorio['NUMERO_CONSULTORIO']; ?>', '<?php echo $consultorio['ID_SEDE']; ?>')">Editar</button>
                                <button class="btn btn-danger" onclick="confirmarEliminar('<?php echo $consultorio['ID_CONSULTORIO']; ?>')">Eliminar</button>
                                <form id="formEliminarConsultorio_<?php echo $consultorio['ID_CONSULTORIO']; ?>" action="gestionConsultorios.php" method="POST" style="display: none;">
                                    <input type="hidden" name="eliminarConsultorio" value="<?php echo $consultorio['ID_CONSULTORIO']; ?>">
                                </form>
                            </td>
                        </tr>
                        <tr id="filaEditar_<?php echo $consultorio['ID_CONSULTORIO']; ?>" class="form-nuevo-consultorio hidden">
                            <td colspan="3">
                                <h3>Editar Consultorio</h3>
                                <form action="gestionConsultorios.php" method="POST">
                                    <input type="hidden" name="editarIdConsultorio" value="<?php echo $consultorio['ID_CONSULTORIO']; ?>">
                                    <div class="mb-3">
                                        <label for="editarNumeroConsultorio" class="form-label">Número de Consultorio:</label>
                                        <input type="text" class="form-control" id="editarNumeroConsultorio"<?php echo $consultorio['ID_CONSULTORIO']; ?>" name="editarNumeroConsultorio" value="<?php echo $consultorio['NUMERO_CONSULTORIO']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editarSedeConsultorio" class="form-label">Sede:</label>
                                        <select class="form-control" id="editarSedeConsultorio_<?php echo $consultorio['ID_CONSULTORIO']; ?>" name="editarSedeConsultorio" required>
                                            <?php foreach ($sedes as $sede): ?>
                                                <option value="<?php echo $sede['ID_SEDE']; ?>" <?php if ($sede['ID_SEDE'] == $consultorio['ID_SEDE']) echo 'selected'; ?>><?php echo $sede['NOMBRE_SEDE']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="guardarEdicion" class="btn btn-success">Guardar Edición</button>
                                    <button type="button" class="btn btn-secondary" onclick="cancelarEdicion('<?php echo $consultorio['ID_CONSULTORIO']; ?>')">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleFormulario(id = null, numero = '', sede = '') {
            const form = document.getElementById('formularioEdicion');
            form.classList.toggle('hidden');
            
            if (id) {
                document.getElementById('editarIdConsultorio').value = id;
                document.getElementById('editarNumeroConsultorio').value = numero;
                document.getElementById('editarSedeConsultorio').value = sede;
            } else {
                document.getElementById('editarIdConsultorio').value = '';
                document.getElementById('editarNumeroConsultorio').value = '';
                document.getElementById('editarSedeConsultorio').value = '';
            }
        }
        
        document.getElementById('btnNuevoConsultorio').addEventListener('click', function() {
            document.getElementById('formularioNuevoConsultorio').classList.toggle('hidden');
        });

        function confirmarEliminar(idConsultorio) {
            if (confirm('¿Estás seguro de eliminar este consultorio?')) {
                document.getElementById('formEliminarConsultorio_' + idConsultorio).submit();
            }
        }

        function editarConsultorio(idConsultorio, numeroConsultorio, idSede) {
            // Ocultar todos los formularios de edición antes de mostrar el deseado
            var formulariosEditar = document.querySelectorAll('.form-nuevo-consultorio');
            formulariosEditar.forEach(function(form) {
                form.classList.add('hidden');
            });

            // Mostrar el formulario de editar consultorio y llenar los campos
            var formularioEditar = document.getElementById('filaEditar_' + idConsultorio);
            formularioEditar.classList.remove('hidden');
            document.getElementById('editarNumeroConsultorio_' + idConsultorio).value = numeroConsultorio;
            document.getElementById('editarSedeConsultorio_' + idConsultorio).value = idSede;

            // Ocultar el formulario de nueva sede si está visible
            document.getElementById('formularioNuevoConsultorio').classList.add('hidden');
        }

        function cancelarEdicion(idConsultorio) {
            // Ocultar el formulario de editar consultorio
            var formularioEditar = document.getElementById('filaEditar_' + idConsultorio);
            formularioEditar.classList.add('hidden');
        }
    </script>
</body>
</html>

