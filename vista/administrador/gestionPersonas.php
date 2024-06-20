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

require_once '../../modelo/administrador/personas/modeloPersonas.php';

$modeloPersonas = new modeloPersonas();

function consultarYActualizarPersonas() {
    global $modeloPersonas;

    $resultados = $modeloPersonas->consultarPersonas();
    $roles = $modeloPersonas->consultarRoles();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['eliminarPersona'])) {
            $documento = $_POST['eliminarPersona'];
            $contrasena = $_POST['contrasenaEliminar'];

            // Aquí deberías validar la contraseña antes de proceder con la eliminación
            if ($contrasena === '123456789') { // Cambia 'tu_contraseña_secreta' por la lógica real de validación de contraseña
                $mensaje = $modeloPersonas->eliminarPersona($documento);

                if (strpos($mensaje, "Persona eliminada correctamente") !== false) {
                    $_SESSION['mensaje'] = $mensaje;
                } else {
                    $_SESSION['error'] = $mensaje;
                }
            } else {
                $_SESSION['error'] = "Contraseña incorrecta.";
            }

            header('Location: gestionPersonas.php');
            exit();
        }

        if (isset($_POST['guardarEdicion'])) {
            $documento = $_POST['editarDocumento'];
            $tipoDocumento = $_POST['editarTipoDocumento'];
            $nombre = $_POST['editarNombre'];
            $apellido = $_POST['editarApellido'];
            $fechaNacimiento = $_POST['editarFechaNacimiento'];
            $telefono = $_POST['editarTelefono'];
            $correo = $_POST['editarCorreo'];
            $direccion = $_POST['editarDireccion'];
            $idRol = $_POST['editarRol'];

            if ($tipoDocumento !== "" && $idRol !== "") {
                if ($modeloPersonas->actualizarPersona($documento, $tipoDocumento, $nombre, $apellido, $fechaNacimiento, $telefono, $correo, $direccion, $idRol)) {
                    $_SESSION['mensaje'] = "Persona editada correctamente";
                } else {
                    $_SESSION['mensaje'] = "Error al editar persona";
                }
            } else {
                $_SESSION['error'] = "Debe seleccionar un tipo de documento y un rol válidos";
            }

            header('Location: gestionPersonas.php');
            exit();
        }
    }

    return ['personas' => $resultados, 'roles' => $roles];
}

$tiposDocumento = $modeloPersonas->consultarTiposDocumento();
$roles = $modeloPersonas->consultarRoles();
$data = consultarYActualizarPersonas();
$personas = $data['personas'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personas</title>
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
            max-width: 90%; /* Ajuste el ancho máximo */
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
        .form-nueva-persona {
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
            <h1 class="text-center mb-4">Gestión de Personas</h1>

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

            <!-- Formulario para buscar personas -->
            <div class="mb-4">
                <input type="text" id="buscarPersona" class="form-control" placeholder="Buscar persona...">
            </div>

            <!-- Tabla de personas existentes -->
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Documento</th>
                        <th>Tipo Documento</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha Nacimiento</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaPersonas">
                    <?php foreach ($personas as $persona): ?>
                        <tr>
                            <td><?php echo $persona['DOCUMENTO']; ?></td>
                            <td><?php echo $persona['TIPO_DOCUMENTO']; ?></td>
                            <td><?php echo $persona['NOMBRE']; ?></td>
                            <td><?php echo $persona['APELLIDO']; ?></td>
                            <td><?php echo $persona['FECHA_NACIMIENTO']; ?></td>
                            <td><?php echo $persona['TELEFONO']; ?></td>
                            <td><?php echo $persona['CORREO']; ?></td>
                            <td><?php echo $persona['DIRECCION']; ?></td>
                            <td><?php echo $persona['ID_ROL']; ?></td>
                            <td class="action-buttons">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editarPersonaModal" onclick="cargarDatosEdicion('<?php echo $persona['DOCUMENTO']; ?>', '<?php echo $persona['TIPO_DOCUMENTO']; ?>', '<?php echo $persona['NOMBRE']; ?>', '<?php echo $persona['APELLIDO']; ?>', '<?php echo $persona['FECHA_NACIMIENTO']; ?>', '<?php echo $persona['TELEFONO']; ?>', '<?php echo $persona['CORREO']; ?>', '<?php echo $persona['DIRECCION']; ?>', '<?php echo $persona['ID_ROL']; ?>')">Editar</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal" onclick="setDocumentoEliminar('<?php echo $persona['DOCUMENTO']; ?>')">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar Persona -->
    <div class="modal fade" id="editarPersonaModal" tabindex="-1" aria-labelledby="editarPersonaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPersonaModalLabel">Editar Persona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarPersona" action="gestionPersonas.php" method="POST" onsubmit="return validarSelects()">
                        <input type="hidden" name="editarDocumento" id="editarDocumento">
                        <div class="mb-3">
                            <label for="editarTipoDocumento" class="form-label">Tipo Documento:</label>
                            <select class="form-control" id="editarTipoDocumento" name="editarTipoDocumento" required>
                                <option value="">Seleccione un tipo de documento</option>
                                <?php foreach ($tiposDocumento as $tipoDocumento): ?>
                                    <option value="<?php echo $tipoDocumento['ID_DOCUMENTO']; ?>"><?php echo $tipoDocumento['NOMBRE_DOCUMENTO']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editarNombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="editarNombre" name="editarNombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarApellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="editarApellido" name="editarApellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarFechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarTelefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="editarTelefono" name="editarTelefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarCorreo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="editarCorreo" name="editarCorreo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDireccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="editarDireccion" name="editarDireccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarRol" class="form-label">Rol:</label>
                            <select class="form-control" id="editarRol" name="editarRol" required>
                                <option value="">Seleccione un rol</option>
                                <?php foreach ($roles as $rol): ?>
                                    <?php if ($rol['ID_ROL'] != 3): // Excluir rol con ID 3 ?>
                                        <option value="<?php echo $rol['ID_ROL']; ?>"><?php echo $rol['NOMBRE_ROL']; ?></option>
                                    <?php endif; ?>
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
                    <form id="formEliminarPersona" action="gestionPersonas.php" method="POST">
                        <p>¿Estás seguro de que deseas eliminar esta persona? Esta acción no se puede deshacer.</p>
                        <input type="hidden" name="eliminarPersona" id="eliminarPersona">
                        <div class="mb-3">
                            <label for="contrasenaEliminar" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasenaEliminar" name="contrasenaEliminar" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cargarDatosEdicion(documento, tipoDocumento, nombre, apellido, fechaNacimiento, telefono, correo, direccion, idRol) {
            document.getElementById('editarDocumento').value = documento;
            document.getElementById('editarTipoDocumento').value = tipoDocumento;
            document.getElementById('editarNombre').value = nombre;
            document.getElementById('editarApellido').value = apellido;
            document.getElementById('editarFechaNacimiento').value = fechaNacimiento;
            document.getElementById('editarTelefono').value = telefono;
            document.getElementById('editarCorreo').value = correo;
            document.getElementById('editarDireccion').value = direccion;
            document.getElementById('editarRol').value = idRol;
        }

        function setDocumentoEliminar(documento) {
            document.getElementById('eliminarPersona').value = documento;
        }

        function validarSelects() {
            var tipoDocumento = document.getElementById('editarTipoDocumento').value;
            var rol = document.getElementById('editarRol').value;

            if (tipoDocumento === "" || rol === "") {
                alert("Debe seleccionar un tipo de documento y un rol válidos.");
                return false;
            }
            return true;
        }

        $(document).ready(function() {
            $('#buscarPersona').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#tablaPersonas tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
