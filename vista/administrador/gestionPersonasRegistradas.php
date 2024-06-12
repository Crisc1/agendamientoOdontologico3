<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lista de Personas Registradas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/administrador/styleGestionPersonasRegistradas.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="../administrador/menuAdministrador.php">Centro Odontológico</a>
        <div class="navbar-collapse justify-content-end">
            <button class="btn rounded mr-2 btn-volver" type="button" onclick="window.history.back()">Volver</button>
        </div>
    </nav>
    <div class="content-container">
        <h1>Usuario Registrados</h1>
        <form class="form-inline mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="form-control" id="columna">
                        <option value="0">Nombres y Apellidos</option>
                        <option value="1">Tipo Documento</option>
                        <option value="2">Correo</option>
                        <option value="3">Telefono</option>
                        <option value="4">Rol</option>
                    </select>
                </div>            
                <input class="form-control mr-sm-2" type="search" placeholder="Parametro de busqueda..." aria-label="Buscar" id="busqueda">
                <div class="input-group-append">
                    <button class="btn btn-success rounded" type="button" onclick="buscar()">Buscar</button>
                </div>
                
            </div>
        </form>
        <div id="lista-personas" class="table-container">
            <!-- Aquí se generará la tabla de personas -->
            <table class='table' id="tabla-personas">
                <thead>
                    <tr>
                        <th>Nombres y Apellidos</th>
                        <th>Tipo Documento</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas de la tabla se generarán dinámicamente aquí -->
                    <?php foreach ($personas as $persona): ?>
                        <tr>
                            <td><?= $persona['NOMBRE'] . " " . $persona['APELLIDO']; ?></td>
                            <td><?= $persona['TIPO_DOCUMENTO']; ?></td>
                            <td><?= $persona['CORREO']; ?></td>
                            <td><?= $persona['TELEFONO']; ?></td>
                            <td><?= $persona['ROL']; ?></td>
                            <td>
                                <form action="../../controladores/administrador/controlEditarDatosPersona.php" method="POST">
                                    <input type="hidden" name="documentoPersona" value="<?= $persona['DOCUMENTO']; ?>">
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </form>
                                <button class="btn btn-danger" onclick="eliminarUsuario(<?= $persona['DOCUMENTO']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../assets/js/administrador/personasRegistradas.js"></script>
</body>
</html>
