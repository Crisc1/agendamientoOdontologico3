<?php
session_start();

// Comprobar si hay una sesión activa
if (isset($_SESSION['DOCUMENTO'])) {
    // Obtener el ID_ROL de la sesión
    $idRol = $_SESSION['ID_ROL'];

    // Definir el ID_ROL permitido
    $idRolPermitido = 3; // Puedes cambiar esto al número que desees permitir

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
    $idProfesional = $_SESSION['ID_PROFESIONAL'];
    
    if (isset($_POST['documentoPaciente'])) {
        $documentoPaciente = $_POST['documentoPaciente'];
        // Aquí puedes realizar las operaciones que necesites con el documento del paciente
    } else {
        echo "No se recibió el documento del paciente.";
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/js/landingPages/bootstrap.min.js"></script>
    <script src="../../assets/js/odontologo/odontograma/odontogramaAdulto.js"></script>
    <link rel="stylesheet" href="../../assets/css/odontologo/styleOdontogramaAdulto.css">
    <title>Historial Odontológico</title>
</head>

    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand titulo-agendamiento" href="index.php" name="name">Agendamiento Odontológico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="vista/landingPages/iniciarSesion.php">Editar Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cerrarSesion.php">Cerrar Sesion</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <h1 class="titulo">Odontograma</h1>

    <div class="odontograma">
        <!-- Sección 1 -->
        <div class="seccion" id="seccion1"></div>

        <!-- Sección 2 -->
        <div class="seccion" id="seccion2"></div>
    </div>

    <div id="infoSeleccion" class="form-container">
        <form id="comentarioForm">
            <input type="hidden" id="documentoPacienteInput" name="documentoPaciente" value="<?php echo htmlspecialchars($documentoPaciente); ?>">
            <label for="imagenSeleccionada">Imagen Seleccionada:</label>
            <input type="text" id="imagenSeleccionada" readonly>
            <label for="comentario">Comentario:</label>
            <textarea id="comentario" rows="4"></textarea>
            <button type="button" onclick="agregarALista()">Añadir</button>
        </form>
    </div>

    <div id="listaAgregados" class="form-container">
        <h2>Lista de Agregados</h2>
        <ul id="listaAgregadosUl"></ul>
    </div>
    
    <div class="form-container">
        <button id="enviarOdontogramaBtn" onclick="enviarOdontograma()">Enviar Odontograma</button>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</body>
</html>