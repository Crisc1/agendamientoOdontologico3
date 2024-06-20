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
    
require_once '../../modelo/administrador/insumo/modeloInsumos.php';

$modeloInsumos = new ModeloInsumos();

function consultarYActualizarInsumos() {
    global $modeloInsumos;

    // Consultar insumos
    $resultados = $modeloInsumos->consultarInsumos();

    // Procesar formulario de actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar actualización de insumos
        if (isset($_POST['actualizar'])) {
            $actualizaciones = [];

            foreach ($resultados as $insumo) {
                $id = $insumo['ID_INSUMO'];

                if (isset($_POST['CANTIDAD'][$id]) && isset($_POST['OPERACIONES'][$id])) {
                    $cantidad_ingresada = intval($_POST['CANTIDAD'][$id]);
                    $operacion = $_POST['OPERACIONES'][$id];

                    // Validar y procesar operaciones
                    if ($operacion === 'restar') {
                        if ($cantidad_ingresada <= $insumo['CANTIDAD']) {
                            $actualizaciones[$id] = -$cantidad_ingresada;
                        } else {
                            $_SESSION['mensaje'] = "No puedes restar más de la cantidad actual.";
                        }
                    } else {
                        $actualizaciones[$id] = $cantidad_ingresada;
                    }
                }
            }

            // Actualizar insumos si hay actualizaciones válidas
            if (!empty($actualizaciones)) {
                if ($modeloInsumos->actualizarInsumos($actualizaciones)) {
                    $_SESSION['mensaje'] = "Actualización exitosa";
                } else {
                    $_SESSION['mensaje'] = "Error al actualizar";
                }

                // Redirigir para evitar reenvío de formulario
                header('Location: gestionInsumos.php');
                exit;
            }
        }

        // Procesar eliminación de insumos
        if (isset($_POST['eliminarInsumo'])) {
            $idInsumo = $_POST['eliminarInsumo'];
            if ($modeloInsumos->eliminarInsumo($idInsumo)) {
                $_SESSION['mensaje'] = "Insumo eliminado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar insumo";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionInsumos.php');
            exit;
        }

        // Procesar adición de insumos
        if (isset($_POST['agregarInsumo'])) {
            $nombreNuevo = $_POST['nombreNuevo'];
            $cantidadNuevo = intval($_POST['cantidadNuevo']);
            $unidadNuevo = $_POST['unidadNuevo'];

            if ($modeloInsumos->agregarInsumo($nombreNuevo, $cantidadNuevo, $unidadNuevo)) {
                $_SESSION['mensaje'] = "Insumo agregado exitosamente";
            } else {
                $_SESSION['mensaje'] = "Error al agregar insumo";
            }

            // Redirigir para evitar reenvío de formulario
            header('Location: gestionInsumos.php');
            exit;
        }
    }

    // Consultar nuevamente los insumos después de la operación
    $resultados = $modeloInsumos->consultarInsumos();

    return $resultados;
}

$resultados = consultarYActualizarInsumos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Insumos</title>
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

        .editar-btn {
            background-color: #007bff;
            color: #fff;
        }

        .editar-btn:hover {
            background-color: #0056b3;
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

        .bth-volver {
            background-color: #CD1A1A;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .bth-volver:hover {
            background-color: #A41515;
        }

        .hidden {
            display: none;
        }

        .form-nuevo-insumo {
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
            <h1 class="text-center mb-4">Control de Insumos</h1>

            <!-- Mostrar mensaje de sesión -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo ($_SESSION['mensaje'] == 'Actualización exitosa' || $_SESSION['mensaje'] == 'Insumo agregado exitosamente' || $_SESSION['mensaje'] == 'Insumo eliminado correctamente') ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <!-- Botón para desplegar campos de nuevo insumo -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-toggle" id="btnNuevoInsumo">Agregar Nuevo Insumo</button>
            </div>

            <!-- Formulario para agregar nuevo insumo (inicialmente oculto) -->
            <div id="formularioNuevoInsumo" class="form-nuevo-insumo hidden">
                <h4 class="mb-3">Agregar Nuevo Insumo</h4>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nombreNuevo" class="form-label">Nombre del Insumo</label>
                        <input type="text" class="form-control" id="nombreNuevo" name="nombreNuevo" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidadNuevo" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="cantidadNuevo" name="cantidadNuevo" required>
                    </div>
                    <div class="mb-3">
                        <label for="unidadNuevo" class="form-label">Unidad</label>
                        <select class="form-select" id="unidadNuevo" name="unidadNuevo" required>
                            <option value="paquete">Paquete</option>
                            <option value="cajas">Cajas</option>
                            <option value="frascos">Frascos</option>
                            <option value="jeringas">Jeringas</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="agregarInsumo">Agregar Insumo</button>
                    </div>
                </form>
            </div>

            <!-- Formulario de búsqueda -->
            <div class="mb-4">
                <input type="text" id="buscar" class="form-control" placeholder="Buscar insumos">
            </div>

            <!-- Formulario de actualización de insumos -->
            <form action="" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cantidad Actual</th>
                                <th scope="col">Modificar Cantidad</th>
                                <th scope="col">Unidad</th>
                                <th scope="col">Operación</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaInsumos">
                            <?php foreach ($resultados as $insumo): ?>
                                <tr>
                                    <td><?php echo $insumo['ID_INSUMO']; ?></td>
                                    <td class="nombre-insumo"><?php echo $insumo['NOMBRE']; ?></td>
                                    <td><?php echo $insumo['CANTIDAD']; ?></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control text-center" name="CANTIDAD[<?php echo $insumo['ID_INSUMO']; ?>]" value="0" min="0">
                                        </div>
                                    </td>
                                    <td><?php echo $insumo['UNIDAD']; ?></td>
                                    <td>
                                        <select class="form-select" name="OPERACIONES[<?php echo $insumo['ID_INSUMO']; ?>]">
                                            <option value="sumar">Sumar</option>
                                            <option value="restar">Restar</option>
                                        </select>
                                    </td>
                                    <td>
                                        <!-- Formulario para eliminar un insumo -->
                                        <form action="" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este insumo?')">
                                            <input type="hidden" name="eliminarInsumo" value="<?php echo $insumo['ID_INSUMO']; ?>">
                                            <button type="submit" class="btn eliminar-btn">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Script para filtrar la tabla de insumos por nombre
        document.getElementById('buscar').addEventListener('keyup', function() {
            var value = this.value.toLowerCase();
            var rows = document.querySelectorAll('#tablaInsumos tr');

            rows.forEach(function(row) {
                var nombre = row.querySelector('.nombre-insumo').textContent.toLowerCase();
                if (nombre.indexOf(value) > -1) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });

        // Script para mostrar/ocultar el formulario de nuevo insumo
        document.getElementById('btnNuevoInsumo').addEventListener('click', function() {
            var formulario = document.getElementById('formularioNuevoInsumo');
            if (formulario.classList.contains('hidden')) {
                formulario.classList.remove('hidden');
            } else {
                formulario.classList.add('hidden');
            }
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>



