<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar si hay una sesión activa
if (!isset($_SESSION['DOCUMENTO'])) {
    header('Location: ../landingPages/errorAccesoSinLogin.php');
    exit();
}

$idRol = $_SESSION['ID_ROL'];
$idRolPermitido = 1;

if ($idRol != $idRolPermitido) {
    header('Location: ../landingPages/errorAccesoSinPermisos.php');
    exit();
}

$documento = $_SESSION['DOCUMENTO'];
$nombre = $_SESSION['NOMBRE'];
$apellido = $_SESSION['APELLIDO'];

require_once '../../modelo/administrador/odontologos/modeloOdontologos.php';

$modeloOdontologos = new modeloOdontologos();

function consultarYActualizarOdontologos() {
    global $modeloOdontologos;

    $resultados = $modeloOdontologos->consultarOdontologos();
    $especialidades = $modeloOdontologos->consultarEspecialidades();
    $consultorios = $modeloOdontologos->consultarConsultoriosDisponibles();
    $sedes = $modeloOdontologos->consultarSedes();
    $personas = $modeloOdontologos->consultarPersonasNoProfesionales();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['eliminarOdontologo'])) {
            $documento = $_POST['eliminarOdontologo'];
            $mensaje = $modeloOdontologos->eliminarOdontologo($documento);

            if ($mensaje) {
                $_SESSION['mensaje'] = "Odontólogo eliminado correctamente";
            } else {
                $_SESSION['error'] = "Error al eliminar odontólogo";
            }

            header('Location: gestionOdontologos.php');
            exit();
        }

        if (isset($_POST['agregarOdontologo'])) {
            $documento = $_POST['documento'];
            $tarjetaProfesional = $_POST['tarjetaProfesional'];
            $experienciaAnterior = $_POST['experienciaAnterior'];
            $idEspecialidad = $_POST['idEspecialidad'];
            $fechaInicio = $_POST['fechaInicio'];
            $idConsultorio = $_POST['idConsultorio'];
            $idSede = $_POST['idSede'];

            if ($documento !== "" && $idConsultorio !== "" && $idSede !== "") {
                if ($modeloOdontologos->agregarOdontologo($documento, $tarjetaProfesional, $experienciaAnterior, $idEspecialidad, $fechaInicio, $idConsultorio, $idSede)) {
                    $_SESSION['mensaje'] = "Odontólogo agregado correctamente";
                } else {
                    $_SESSION['error'] = "Error al agregar odontólogo";
                }
            } else {
                $_SESSION['error'] = "Debe seleccionar un documento, consultorio y sede válidos";
            }

            header('Location: gestionOdontologos.php');
            exit();
        }
    }

    return ['odontologos' => $resultados, 'especialidades' => $especialidades, 'consultorios' => $consultorios, 'sedes' => $sedes, 'personas' => $personas];
}

$data = consultarYActualizarOdontologos();
$odontologos = $data['odontologos'];
$especialidades = $data['especialidades'];
$consultorios = $data['consultorios'];
$sedes = $data['sedes'];
$personas = $data['personas'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Odontólogos</title>
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
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: 1;
        }

        .bth-volver:hover {
            background-color: #A41515;
            text-decoration: none;
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
            max-width: 90%;
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
        .form-nuevo-odontologo {
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
        .action-buttons {
            display: flex;
            gap: 5px;
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
            <h1 class="text-center mb-4">Gestión de Odontólogos</h1>

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

            <!-- Botón para abrir el formulario de añadir odontólogo -->
            <div class="text-center mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarOdontologoModal">Añadir Odontólogo</button>
            </div>

            <!-- Tabla de odontólogos existentes -->
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Documento</th>
                        <th>Tarjeta Profesional</th>
                        <th>Experiencia</th>
                        <th>Especialidad</th>
                        <th>Fecha de Inicio</th>
                        <th>Consultorio</th>
                        <th>Sede</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaOdontologos">
                    <?php foreach ($odontologos as $odontologo): ?>
                        <tr>
                            <td><?php echo $odontologo['DOCUMENTO']; ?></td>
                            <td><?php echo $odontologo['TARJETA_PROFESIONAL']; ?></td>
                            <td><?php echo $odontologo['EXPERIENCIA_ANTERIOR']; ?></td>
                            <td><?php echo $odontologo['NOMBRE_ESPECIALIDAD']; ?></td>
                            <td><?php echo $odontologo['FECHA_INICIO']; ?></td>
                            <td><?php echo $odontologo['NUMERO_CONSULTORIO']; ?></td>
                            <td><?php echo $odontologo['NOMBRE_SEDE']; ?></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarOdontologoModal" onclick="cargarDatosEdicion('<?php echo $odontologo['DOCUMENTO']; ?>', '<?php echo $odontologo['TARJETA_PROFESIONAL']; ?>', '<?php echo $odontologo['EXPERIENCIA_ANTERIOR']; ?>', '<?php echo $odontologo['ID_ESPECIALIDAD']; ?>', '<?php echo $odontologo['FECHA_INICIO']; ?>', '<?php echo $odontologo['ID_CONSULTORIO']; ?>', '<?php echo $odontologo['ID_SEDE']; ?>')">Editar</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal" onclick="confirmarEliminar('<?php echo $odontologo['DOCUMENTO']; ?>')">Eliminar</button>
                                <form id="formEliminarOdontologo_<?php echo $odontologo['DOCUMENTO']; ?>" action="gestionOdontologos.php" method="POST" style="display: none;">
                                    <input type="hidden" name="eliminarOdontologo" value="<?php echo $odontologo['DOCUMENTO']; ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Agregar Odontólogo -->
    <div class="modal fade" id="agregarOdontologoModal" tabindex="-1" aria-labelledby="agregarOdontologoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarOdontologoModalLabel">Añadir Odontólogo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarOdontologo" action="gestionOdontologos.php" method="POST" onsubmit="return validarSelectsAgregar()">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento:</label>
                            <select class="form-control" id="documento" name="documento" required>
                                <option value="">Seleccione un documento</option>
                                <?php foreach ($personas as $persona): ?>
                                    <option value="<?php echo $persona['DOCUMENTO']; ?>"><?php echo $persona['DOCUMENTO'] . " - " . $persona['NOMBRE'] . " " . $persona['APELLIDO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tarjetaProfesional" class="form-label">Tarjeta Profesional:</label>
                            <input type="text" class="form-control" id="tarjetaProfesional" name="tarjetaProfesional" required>
                        </div>
                        <div class="mb-3">
                            <label for="experienciaAnterior" class="form-label">Experiencia Anterior (en años):</label>
                            <input type="number" class="form-control" id="experienciaAnterior" name="experienciaAnterior" required>
                        </div>
                        <div class="mb-3">
                            <label for="idEspecialidad" class="form-label">Especialidad:</label>
                            <select class="form-control" id="idEspecialidad" name="idEspecialidad" required>
                                <option value="">Seleccione una especialidad</option>
                                <?php foreach ($especialidades as $especialidad): ?>
                                    <option value="<?php echo $especialidad['ID_ESPECIALIDAD']; ?>"><?php echo $especialidad['NOMBRE_ESPECIALIDAD']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="idConsultorio" class="form-label">Consultorio:</label>
                            <select class="form-control" id="idConsultorio" name="idConsultorio" required>
                                <option value="">Seleccione un consultorio</option>
                                <?php foreach ($consultorios as $consultorio): ?>
                                    <option value="<?php echo $consultorio['ID_CONSULTORIO']; ?>"><?php echo $consultorio['NUMERO_CONSULTORIO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="idSede" class="form-label">Sede:</label>
                            <select class="form-control" id="idSede" name="idSede" required>
                                <option value="">Seleccione una sede</option>
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?php echo $sede['ID_SEDE']; ?>"><?php echo $sede['NOMBRE_SEDE']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="agregarOdontologo" class="btn btn-success">Añadir Odontólogo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Odontólogo -->
    <div class="modal fade" id="editarOdontologoModal" tabindex="-1" aria-labelledby="editarOdontologoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarOdontologoModalLabel">Editar Odontólogo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarOdontologo" action="gestionOdontologos.php" method="POST" onsubmit="return validarSelectsEditar()">
                        <input type="hidden" name="editarDocumento" id="editarDocumento">
                        <div class="mb-3">
                            <label for="editarTarjetaProfesional" class="form-label">Tarjeta Profesional:</label>
                            <input type="text" class="form-control" id="editarTarjetaProfesional" name="editarTarjetaProfesional" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarExperienciaAnterior" class="form-label">Experiencia Anterior (en años):</label>
                            <input type="number" class="form-control" id="editarExperienciaAnterior" name="editarExperienciaAnterior" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarIdEspecialidad" class="form-label">Especialidad:</label>
                            <select class="form-control" id="editarIdEspecialidad" name="editarIdEspecialidad" required>
                                <option value="">Seleccione una especialidad</option>
                                <?php foreach ($especialidades as $especialidad): ?>
                                    <option value="<?php echo $especialidad['ID_ESPECIALIDAD']; ?>"><?php echo $especialidad['NOMBRE_ESPECIALIDAD']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarFechaInicio" class="form-label">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="editarFechaInicio" name="editarFechaInicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarIdConsultorio" class="form-label">Consultorio:</label>
                            <select class="form-control" id="editarIdConsultorio" name="editarIdConsultorio" required>
                                <option value="">Seleccione un consultorio</option>
                                <?php foreach ($consultorios as $consultorio): ?>
                                    <option value="<?php echo $consultorio['ID_CONSULTORIO']; ?>"><?php echo $consultorio['NUMERO_CONSULTORIO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarIdSede" class="form-label">Sede:</label>
                            <select class="form-control" id="editarIdSede" name="editarIdSede" required>
                                <option value="">Seleccione una sede</option>
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?php echo $sede['ID_SEDE']; ?>"><?php echo $sede['NOMBRE_SEDE']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="guardarEdicion" class="btn btn-success">Guardar Edición</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminar -->
    <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este odontólogo? Esta acción no se puede deshacer.</p>
                    <button type="button" class="btn btn-danger" onclick="eliminarOdontologo()">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cargarDatosEdicion(documento, tarjetaProfesional, experienciaAnterior, idEspecialidad, fechaInicio, idConsultorio, idSede) {
            document.getElementById('editarDocumento').value = documento;
            document.getElementById('editarTarjetaProfesional').value = tarjetaProfesional;
            document.getElementById('editarExperienciaAnterior').value = experienciaAnterior;
            document.getElementById('editarIdEspecialidad').value = idEspecialidad;
            document.getElementById('editarFechaInicio').value = fechaInicio;
            document.getElementById('editarIdConsultorio').value = idConsultorio;
            document.getElementById('editarIdSede').value = idSede;
        }

        function confirmarEliminar(documento) {
            document.getElementById('formEliminarOdontologo_' + documento).submit();
        }

        function validarSelectsAgregar() {
            var documento = document.getElementById('documento').value;
            var consultorio = document.getElementById('idConsultorio').value;
            var sede = document.getElementById('idSede').value;

            if (documento === "" || consultorio === "" || sede === "") {
                alert("Debe seleccionar un documento, consultorio y sede válidos.");
                return false;
            }
            return true;
        }

        function validarSelectsEditar() {
            var especialidad = document.getElementById('editarIdEspecialidad').value;
            var consultorio = document.getElementById('editarIdConsultorio').value;
            var sede = document.getElementById('editarIdSede').value;

            if (especialidad === "" || consultorio === "" || sede === "") {
                alert("Debe seleccionar una especialidad, consultorio y sede válidos.");
                return false;
            }
            return true;
        }

        $(document).ready(function() {
            $('#buscarOdontologo').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#tablaOdontologos tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
