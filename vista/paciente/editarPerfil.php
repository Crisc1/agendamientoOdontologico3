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
    <title>Editar Datos de Persona</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/paciente/styleEditarPerfil.css"/>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="../administrador/menuAdministrador.php">Centro Odontológico</a>
        <div class="navbar-collapse justify-content-end">
            <button class="btn rounded mr-2 btn-volver" type="button" onclick="window.history.back()">Volver</button>
        </div>
    </nav>

    <div class="container">
        <h1>Editar Perfil</h1>
        <div class="row">
            <div class="col-md-12">
                <form action="guardarCambios.php" method="POST">
                    <?php
                    // Verificar si hay resultados de la consulta
                    if (!empty($result)) {
                        // Iterar sobre los resultados
                        foreach ($result as $persona) {
                            ?>
                            <!-- Campo oculto para el documento de la persona -->
                            <input type="hidden" name="documentoPersona" value="<?= $persona['DOCUMENTO']; ?>">
                            
                            <!-- Campo de nombre -->
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $persona['NOMBRE']; ?>">
                            </div>
                            
                            <!-- Campo de apellido -->
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $persona['APELLIDO']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="tipoDocumento">Tipo de Documento:</label>
                                <input type="text" class="form-control" id="tipoDocumentoAnterior" name="tipoDocumentoAnterior" value="<?= $persona['TIPO_DOCUMENTO']; ?>" readonly>
                            </div>
                            
                            <!-- Campo de correo -->
                            <div class="form-group">
                                <label for="correo">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="correo" name="correo" value="<?= $persona['FECHA_NACIMIENTO']; ?>">
                            </div>
                            
                            <!-- Campo de correo -->
                            <div class="form-group">
                                <label for="correo">Correo:</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?= $persona['CORREO']; ?>">
                            </div>
                            
                            <!-- Campo de teléfono -->
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $persona['TELEFONO']; ?>">
                            </div>
                            
                            <!-- Campo de direccion -->
                            <div class="form-group">
                                <label for="telefono">Dirección:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $persona['DIRECCION']; ?>">
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>No se encontraron resultados.</p>";
                    }
                    ?>
                    <!-- Botón para guardar cambios -->
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
