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

require_once '../../modelo/administrador/sedes/modeloSedes.php';

$modeloSedes = new modeloSedes();

function consultarYActualizarSedes() {
    global $modeloSedes;

    // Consultar sedes
    $resultados = $modeloSedes->consultarSedes();

        // Procesar formulario de actualización
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar eliminación de sedes
            if (isset($_POST['eliminarSede'])) {
                $idSede = $_POST['eliminarSede'];
                $mensaje = $modeloSedes->eliminarSede($idSede);

                if (strpos($mensaje, "Sede eliminada correctamente") !== false) {
                    $_SESSION['mensaje'] = $mensaje;
                } else {
                    $_SESSION['error'] = $mensaje;
                }

                // Redirigir para evitar reenvío de formulario
                header('Location: gestionSedes.php');
                exit();
            }

        // Procesar adición de sedes
        if (isset($_POST['agregarSede'])) {
            $nombreNuevo = $_POST['nombreNuevo'];
            $direccionNuevo = $_POST['direccionNuevo'];

            if ($modeloSedes->agregarSede($nombreNuevo, $direccionNuevo)) {
                $_SESSION['mensaje'] = "Sede agregada exitosamente";
            } else {
                $_SESSION['mensaje'] = "Error al agregar sede";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionSedes.php');
            exit();
        }

        // Procesar edición de sedes
        if (isset($_POST['guardarEdicion'])) {
            $idSede = $_POST['editarIdSede'];
            $nombreSede = $_POST['editarNombreSede'];
            $direccionSede = $_POST['editarDireccionSede'];

            if ($modeloSedes->editarSede($idSede, $nombreSede, $direccionSede)) {
                $_SESSION['mensaje'] = "Sede editada correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al editar sede";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionSedes.php');
            exit();
        }
    }

    // Consultar nuevamente las sedes después de la operación
    $resultados = $modeloSedes->consultarSedes();

    return $resultados;
}

$resultados = consultarYActualizarSedes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sedes</title>
    <link rel="icon" href="../../assets/img/logo.ico">
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
        .form-nuevo-sede {
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
                        <a href="menuAdministrador.php" class="bth-volver">Volver</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="container form-container">
        <div class="content">
            <h1 class="text-center mb-4">Gestión de Sedes</h1>

            <!-- Mostrar mensaje de sesión -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Botón para desplegar campos de nueva sede -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-toggle" id="btnNuevaSede">Agregar Nueva Sede</button>
            </div>

            <!-- Formulario para agregar nueva sede (inicialmente oculto) -->
            <div id="formularioNuevaSede" class="form-nuevo-sede hidden">
                <h4 class="mb-3">Agregar Nueva Sede</h4>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nombreNuevo" class="form-label">Nombre de la Sede</label>
                        <input type="text" class="form-control" id="nombreNuevo" name="nombreNuevo" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionNuevo" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionNuevo" name="direccionNuevo" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="agregarSede">Agregar Sede</button>
                </form>
            </div>

            <!-- Tabla de sedes existentes -->
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ID Sede</th>
                        <th>Sede</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $fila): ?>
                        <tr>
                            <td><?php echo $fila['ID_SEDE']; ?></td>
                            <td><?php echo $fila['NOMBRE_SEDE']; ?></td>
                            <td><?php echo $fila['DIRECCION']; ?></td>
                            <td>
                                <!-- Botón para editar sede -->
                                <button class="btn btn-sm btn-primary" onclick="editarSede(<?php echo $fila['ID_SEDE']; ?>, '<?php echo $fila['NOMBRE_SEDE']; ?>', '<?php echo $fila['DIRECCION']; ?>')">Editar</button>

                                <!-- Formulario para eliminar sede -->
                                <form action="" method="post" class="d-inline" id="formEliminarSede_<?php echo $fila['ID_SEDE']; ?>">
                                    <input type="hidden" name="eliminarSede" value="<?php echo $fila['ID_SEDE']; ?>">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmarEliminar(<?php echo $fila['ID_SEDE']; ?>)">Eliminar</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Formulario para editar sede (inicialmente oculto y específico por cada fila) -->
                        <tr id="filaEditar_<?php echo $fila['ID_SEDE']; ?>" class="form-nuevo-sede hidden">
                            <td colspan="4">
                                <h4 class="mb-3">Editar Sede</h4>
                                <form action="" method="post">
                                    <input type="hidden" name="editarIdSede" value="<?php echo $fila['ID_SEDE']; ?>">
                                    <div class="mb-3">
                                        <label for="editarNombreSede_<?php echo $fila['ID_SEDE']; ?>" class="form-label">Nombre de la Sede</label>
                                        <input type="text" class="form-control" id="editarNombreSede_<?php echo $fila['ID_SEDE']; ?>" name="editarNombreSede" value="<?php echo $fila['NOMBRE_SEDE']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editarDireccionSede_<?php echo $fila['ID_SEDE']; ?>" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="editarDireccionSede_<?php echo $fila['ID_SEDE']; ?>" name="editarDireccionSede" value="<?php echo $fila['DIRECCION']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="guardarEdicion">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary" onclick="cancelarEdicion(<?php echo $fila['ID_SEDE']; ?>)">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('btnNuevaSede').addEventListener('click', function() {
            document.getElementById('formularioNuevaSede').classList.toggle('hidden');
        });

        function volverPaginaAnterior() {
            window.history.back();
        }
        
        function confirmarEliminar(idSede) {
            if (confirm('¿Estás seguro de eliminar esta sede?')) {
                document.getElementById('formEliminarSede_' + idSede).submit();
            }
        }

        function editarSede(idSede, nombreSede, direccionSede) {
            // Ocultar todos los formularios de edición antes de mostrar el deseado
            var formulariosEditar = document.querySelectorAll('.form-nuevo-sede');
            formulariosEditar.forEach(function(form) {
                form.classList.add('hidden');
            });

            // Mostrar el formulario de editar sede y llenar los campos
            var formularioEditar = document.getElementById('filaEditar_' + idSede);
            formularioEditar.classList.remove('hidden');
            document.getElementById('editarNombreSede_' + idSede).value = nombreSede;
            document.getElementById('editarDireccionSede_' + idSede).value = direccionSede;

            // Ocultar el formulario de nueva sede si está visible
            document.getElementById('formularioNuevaSede').classList.add('hidden');
        }

        function cancelarEdicion(idSede) {
            // Ocultar el formulario de editar sede
            var formularioEditar = document.getElementById('filaEditar_' + idSede);
            formularioEditar.classList.add('hidden');
        }
    </script>
</body>
</html>

