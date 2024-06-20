<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

require_once '../../modelo/administrador/citas/modeloCitas.php';

$modeloCitas = new modeloCitas();

function consultarYActualizarCitas() {
    global $modeloCitas;

    $resultados = $modeloCitas->consultarCitas();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['eliminarCita'])) {
            $idCita = $_POST['eliminarCita'];
            $mensaje = $modeloCitas->eliminarCita($idCita);

            if (strpos($mensaje, "Cita eliminada correctamente") !== false) {
                $_SESSION['mensaje'] = $mensaje;
            } else {
                $_SESSION['error'] = $mensaje;
            }

            header('Location: gestionCitas.php');
            exit();
        }

        if (isset($_POST['agregarCita'])) {
            $idTratamiento = $_POST['idTratamientoNuevo'];
            $idOdontologo = $_POST['idOdontologoNuevo'];
            $fecha = $_POST['fechaNueva'];
            $hora = $_POST['horaNueva'];
            $idConsultorio = $_POST['idConsultorioNuevo'];

            if ($modeloCitas->agregarCita($idTratamiento, $idOdontologo, $fecha, $hora, $idConsultorio)) {
                $_SESSION['mensaje'] = "Cita agregada exitosamente";
            } else {
                $_SESSION['mensaje'] = "Error al agregar cita";
            }

            header('Location: gestionCitas.php');
            exit();
        }

        if (isset($_POST['guardarEdicion'])) {
            $idCita = $_POST['editarIdCita'];
            $idTratamiento = $_POST['editarTratamiento'];
            $idOdontologo = $_POST['editarOdontologo'];
            $fecha = $_POST['editarFecha'];
            $hora = $_POST['editarHora'];
            $idConsultorio = $_POST['editarConsultorio'];

            if ($modeloCitas->actualizarCita($idCita, $idTratamiento, $idOdontologo, $fecha, $hora, $idConsultorio)) {
                $_SESSION['mensaje'] = "Cita editada correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al editar cita";
            }

            header('Location: gestionCitas.php');
            exit();
        }
    }

    return $resultados;
}

$resultados = consultarYActualizarCitas();
$sedes = $modeloCitas->consultarTodasSedes();
$especialidades = $modeloCitas->consultarEspecialidades();
$tratamientos = $modeloCitas->consultarTodosTratamientos(); // Obtener todos los tratamientos
$odontologos = $modeloCitas->consultarTodosOdontologos(); // Obtener todos los odontólogos

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
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
            max-width: 1000px; /* Ajuste el ancho máximo */
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
        .form-nueva-cita {
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
            <h1 class="text-center mb-4">Gestión de Citas</h1>

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

            <!-- Formulario para agregar nueva cita -->
            <div id="formularioNuevaCita" class="form-nueva-cita hidden">
                <h3>Agregar Nueva Cita</h3>
                <form action="gestionCitas.php" method="POST">
                    <div class="mb-3">
                        <label for="idTratamientoNuevo" class="form-label">Tratamiento:</label>
                        <select class="form-control" id="idTratamientoNuevo" name="idTratamientoNuevo" required>
                            <option value="">Seleccione un tratamiento</option>
                            <?php foreach ($tratamientos as $tratamiento): ?>
                                <option value="<?php echo $tratamiento['ID_TRATAMIENTO']; ?>"><?php echo $tratamiento['NOMBRE_TRATAMIENTO']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idOdontologoNuevo" class="form-label">Odontólogo:</label>
                        <select class="form-control" id="idOdontologoNuevo" name="idOdontologoNuevo" required onchange="cargarConsultorio(this)">
                            <option value="">Seleccione un odontólogo</option>
                            <?php foreach ($odontologos as $odontologo): ?>
                                <option value="<?php echo $odontologo['ID_PROFESIONAL']; ?>" data-id-consultorio="<?php echo $odontologo['ID_CONSULTORIO']; ?>"><?php echo $odontologo['NOMBRE_COMPLETO']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fechaNueva" class="form-label">Fecha:</label>
                        <input type="date" class="form-control" id="fechaNueva" name="fechaNueva" required>
                    </div>
                    <div class="mb-3">
                        <label for="horaNueva" class="form-label">Hora:</label>
                        <select class="form-control" id="horaNueva" name="horaNueva" required>
                            <?php
                            $start = strtotime('09:00');
                            $end = strtotime('18:00');
                            for ($time = $start; $time <= $end; $time = strtotime('+30 minutes', $time)) {
                                $timeValue = date('H:i', $time);
                                echo "<option value='$timeValue'>$timeValue</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idConsultorioNuevo" class="form-label">Consultorio:</label>
                        <input type="text" class="form-control" id="idConsultorioNuevo" name="idConsultorioNuevo" required>
                    </div>
                    <button type="submit" name="agregarCita" class="btn btn-success">Agregar Cita</button>
                </form>
            </div>

            <!-- Barra de búsqueda -->
            <input class="form-control mb-3" id="buscarCita" type="text" placeholder="Buscar cita...">

            <!-- Tabla de citas existentes -->
            <table class="table table-striped table-bordered" id="tablaCitas">
                <thead class="table-primary">
                    <tr>
                        <th>Id Cita</th>
                        <th>Servicio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Sede</th>
                        <th>Consultorio</th>
                        <th>Profesional</th>
                        <th>Paciente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $cita): ?>
                        <tr>
                            <td><?php echo $cita['ID_CITA']; ?></td>
                            <td><?php echo $cita['NOMBRE_TRATAMIENTO']; ?></td>
                            <td><?php echo $cita['FECHA']; ?></td>
                            <td><?php echo $cita['HORA']; ?></td>
                            <td><?php echo $cita['NOMBRE_SEDE']; ?></td>
                            <td><?php echo $cita['NUMERO_CITA']; ?></td>
                            <td><?php echo $cita['NOMBRE_PROFESIONAL']; ?></td>
                            <td><?php echo $cita['NOMBRE_PACIENTE']; ?></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarCitaModal" onclick="cargarDatosEdicion('<?php echo $cita['ID_CITA']; ?>', '<?php echo $cita['NOMBRE_TRATAMIENTO']; ?>', '<?php echo $cita['FECHA']; ?>', '<?php echo $cita['HORA']; ?>', '<?php echo $cita['ID_SEDE']; ?>', '<?php echo $cita['ID_CITA']; ?>', '<?php echo $cita['ID_PROFESIONAL']; ?>')">Editar</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal" onclick="setIdCitaEliminar('<?php echo $cita['ID_CITA']; ?>')">Eliminar</button>
                                <form id="formEliminarCita_<?php echo $cita['ID_CITA']; ?>" action="gestionCitas.php" method="POST" style="display: none;">
                                    <input type="hidden" name="eliminarCita" value="<?php echo $cita['ID_CITA']; ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar Cita -->
    <div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCitaModalLabel">Editar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCita" action="gestionCitas.php" method="POST">
                        <input type="hidden" name="editarIdCita" id="editarIdCita">
                        <div class="mb-3">
                            <label for="editarEspecialidad" class="form-label">Especialidad:</label>
                            <select class="form-control" id="editarEspecialidad" name="editarEspecialidad" onchange="cargarTratamientos()">
                                <option value="">Seleccione una especialidad</option>
                                <?php foreach ($especialidades as $especialidad): ?>
                                    <option value="<?php echo $especialidad['ID_ESPECIALIDAD']; ?>"><?php echo $especialidad['NOMBRE_ESPECIALIDAD']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarTratamiento" class="form-label">Tratamiento:</label>
                            <select class="form-control" id="editarTratamiento" name="editarTratamiento" required>
                                <option value="">Seleccione un tratamiento</option>
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarSede" class="form-label">Sede:</label>
                            <select class="form-control" id="editarSede" name="editarSede" onchange="cargarOdontologos()">
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?php echo $sede['ID_SEDE']; ?>"><?php echo $sede['NOMBRE_SEDE']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarOdontologo" class="form-label">Odontólogo:</label>
                            <select class="form-control" id="editarOdontologo" name="editarOdontologo" required>
                                <option value="">Seleccione un odontólogo</option>
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarFecha" class="form-label">Fecha:</label>
                            <input type="date" class="form-control" id="editarFecha" name="editarFecha" onchange="cargarHorarios()" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarHora" class="form-label">Hora:</label>
                            <select class="form-control" id="editarHora" name="editarHora" required>
                                <?php
                                $start = strtotime('09:00');
                                $end = strtotime('18:00');
                                for ($time = $start; $time <= $end; $time = strtotime('+30 minutes', $time)) {
                                    $timeValue = date('H:i', $time);
                                    echo "<option value='$timeValue'>$timeValue</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarConsultorio" class="form-label">Consultorio:</label>
                            <input type="hidden" class="form-control" id="editarConsultorio" name="editarConsultorio" required>
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
                    <p>¿Estás seguro de que deseas eliminar esta cita? Esta acción no se puede deshacer.</p>
                    <button type="button" class="btn btn-danger" onclick="eliminarCita()">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cargarDatosEdicion(idCita, idTratamiento, idProfesional, fecha, hora, idSede, idConsultorio) {
            document.getElementById('editarIdCita').value = idCita;
            document.getElementById('editarTratamiento').value = idTratamiento;
            document.getElementById('editarOdontologo').value = idProfesional;
            document.getElementById('editarFecha').value = fecha;
            document.getElementById('editarHora').value = hora;
            document.getElementById('editarSede').value = idSede;
            document.getElementById('editarConsultorio').value = idConsultorio;
        }

        function confirmarEliminar(idCita) {
            document.getElementById('formEliminarCita_' + idCita).submit();
        }

        function cargarHorarios() {
            var idSede = document.getElementById('editarSede').value;
            var fecha = document.getElementById('editarFecha').value;

            if (idSede && fecha) {
                fetch('../../modelo/administrador/citas/modeloHorarios.php?idSede=' + idSede + '&fecha=' + fecha)
                .then(response => response.json())
                .then(data => {
                    var selectHora = document.getElementById('editarHora');
                    var opcionesHora = selectHora.options;

                    Array.from(opcionesHora).forEach(option => {
                        var horaSelect = option.value;
                        var ocupada = data.ocupados.some(horaOcupada => horaOcupada.substring(0, 5) === horaSelect);

                        if (ocupada) {
                            option.textContent = horaSelect + ' (Ocupada)';
                            option.disabled = true;
                        } else {
                            option.textContent = horaSelect;
                            option.disabled = false;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        function cargarTratamientos() {
            var idEspecialidad = document.getElementById('editarEspecialidad').value;
            if (idEspecialidad) {
                fetch('../../modelo/administrador/citas/modeloEspecialidad.php?idEspecialidad=' + idEspecialidad)
                .then(response => response.json())
                .then(data => {
                    if (data.tratamientos && Array.isArray(data.tratamientos)) {
                        var selectTratamiento = document.getElementById('editarTratamiento');
                        selectTratamiento.innerHTML = '<option value="">Seleccione un tratamiento</option>';
                        data.tratamientos.forEach(function(tratamiento) {
                            var option = document.createElement('option');
                            option.value = tratamiento.ID_TRATAMIENTO;
                            option.text = tratamiento.NOMBRE_TRATAMIENTO;
                            selectTratamiento.appendChild(option);
                        });
                        selectTratamiento.disabled = false;
                    } else {
                        console.error('No se encontraron tratamientos válidos en la respuesta:', data);
                    }
                })
                .catch(error => {
                    console.error('Error al cargar tratamientos:', error);
                });
            } else {
                var selectTratamiento = document.getElementById('editarTratamiento');
                selectTratamiento.innerHTML = '<option value="">Seleccione un tratamiento</option>';
                selectTratamiento.disabled = true;
            }
        }

        function cargarOdontologos() {
            var idSede = document.getElementById('editarSede').value;
            var idEspecialidad = document.getElementById('editarEspecialidad').value;
            if (idSede && idEspecialidad) {
                fetch('../../modelo/administrador/citas/modeloOdontologos.php?idSede=' + idSede + '&idEspecialidad=' + idEspecialidad)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar odontólogos');
                    }
                    return response.json();
                })
                .then(data => {
                    var selectOdontologo = document.getElementById('editarOdontologo');
                    selectOdontologo.innerHTML = '<option value="">Seleccione un odontólogo</option>';
                    data.forEach(function(odontologo) {
                        var option = document.createElement('option');
                        option.value = odontologo.ID_PROFESIONAL;
                        option.textContent = odontologo.NOMBRE_COMPLETO;
                        option.setAttribute('data-id-consultorio', odontologo.ID_CONSULTORIO);
                        selectOdontologo.appendChild(option);
                    });
                    selectOdontologo.disabled = false;

                    selectOdontologo.addEventListener('change', function () {
                        var selectedOption = selectOdontologo.options[selectOdontologo.selectedIndex];
                        var idConsultorio = selectedOption.getAttribute('data-id-consultorio');
                        document.getElementById('editarConsultorio').value = idConsultorio;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    var selectOdontologo = document.getElementById('editarOdontologo');
                    selectOdontologo.innerHTML = '<option value="">Error al cargar odontólogos</option>';
                    selectOdontologo.disabled = true;
                });
            } else {
                var selectOdontologo = document.getElementById('editarOdontologo');
                selectOdontologo.innerHTML = '<option value="">Seleccione un odontólogo</option>';
                selectOdontologo.disabled = true;
            }
        }

        function cargarConsultorio(selectElement) {
            var idConsultorio = selectElement.options[selectElement.selectedIndex].getAttribute('data-id-consultorio');
            document.getElementById('idConsultorioNuevo').value = idConsultorio;
        }

        // Filtro de búsqueda
        $(document).ready(function(){
            $("#buscarCita").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tablaCitas tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>

