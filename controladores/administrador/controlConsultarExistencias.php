<?php
session_start(); // Iniciar la sesión

include_once '../../modelo/administrador/modeloConsultarInsumos.php';

// Función para consultar los insumos desde la base de datos
function consultarYActualizarInsumos() {
    // Consulta los insumos desde la base de datos
    $resultados = consultarInsumos();

    // Actualiza las cantidades de los insumos en la base de datos al presionar el botón "Actualizar"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
        foreach ($resultados as $insumo) {
            $id = $insumo['ID_INSUMO'];
            
            // Verifica si se ha enviado una cantidad para actualizar para este insumo
            if (isset($_POST['cantidad'][$id])) {
                $cantidad_ingresada = intval($_POST['cantidad'][$id]);
                $cantidad_actual = $insumo['Cantidad'];
                
                // Verifica si la cantidad ingresada es diferente de la cantidad actual
                if ($cantidad_ingresada != $cantidad_actual) {
                    // Calcula la diferencia entre la cantidad ingresada y la cantidad actual
                    $diferencia = $cantidad_ingresada - $cantidad_actual;
                    
                    // Actualiza la cantidad en la base de datos sumando la diferencia
                    if (actualizarInsumos([$id => $diferencia])) {
                        $_SESSION['cambios_exitosos'] = true; // Cambios exitosos
                    } else {
                        $_SESSION['cambios_exitosos'] = false; // Error al realizar cambios
                    }
                }
            }
        }
        
        // Después de actualizar, llamamos nuevamente a la función para obtener los datos actualizados
        $resultados = consultarInsumos();
    }

    return $resultados;
}

// Obtener los insumos
$resultados = consultarYActualizarInsumos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROL DE INSUMOS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../..//assets/imagenes/backGroundLogin.jpg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            position: relative;
        }
        
        .navbar {
            background-color: #007bff;
            display: flex; /* Add display property only to the navbar */
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: #ffffff;
        }
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(0, 0, 0, 0.5); /* Borde del contenedor */
        }
        h1 {
            text-align: center;
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 60px;
        }
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.5); /* Borde de la tabla */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 10px; /* Redondea la tabla */
            border: 1px solid rgba(0, 0, 0, 0.5); /* Bordes de la tabla */
        }
        th, td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid rgba(0, 0, 0, 0.5); /* Borde de las celdas */
        }
        th {
            background-color: #f2f2f2;
        }
        .quantity-control {
            display: flex;
            flex-direction: column;
        }
        .quantity-control button {
            padding: 0.375rem 0.75rem;
            margin: 0;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0;
        }
        .quantity-control button:hover {
            background-color: #0056b3;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .update-button {
            text-align: center;
            margin-top: 20px;
        }
        .update-message {
            color: green;
            font-weight: bold;
            font-size: 1.2em;
            text-align: center;
        }
        
        .btn-volver {
            background-color: #e63946; /* Cambio de color a un tono de rojo más fuerte */
            color: #fff;
            border-color: #e63946; /* Cambio de color del borde */
            border-radius: 10px;
            padding: 8px 16px;
            margin-left: 10px;
        }

        .btn-volver:hover {
            background-color: #cf303e; /* Cambio de color al pasar el ratón */
            border-color: #cf303e; /* Cambio de color del borde al pasar el ratón */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="../administrador/menuAdministrador.php">Centro Odontológico</a>
        <div class="navbar-collapse justify-content-end">
            <button class="btn rounded mr-2 btn-volver" type="button" onclick="window.history.back()">Volver</button>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Control de Insumos</h1>
        <form action="" method="post">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cantidad Actual</th>
                            <th>Modificar Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $insumo): ?>
                        <tr>
                            <td><?php echo $insumo['ID_INSUMO']; ?></td>
                            <td><?php echo $insumo['NOMBRE']; ?></td>
                            <td><?php echo $insumo['CANTIDAD']; ?></td>
                            <td class="quantity-control">
                                <div class="input-group">
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="incrementarCantidad(<?php echo $insumo['ID_INSUMO']; ?>)">+</button>
                                    <input id="cantidad_<?php echo $insumo['ID_INSUMO']; ?>" type="number"
                                        class="form-control text-center" name="cantidad[<?php echo $insumo['ID_INSUMO']; ?>]"
                                        value="<?php echo $insumo['CANTIDAD']; ?>" min="0">
                                    <button class="btn btn-outline-primary" type="button"
                                            onclick="decrementarCantidad(<?php echo $insumo['ID_INSUMO']; ?>)">-</button>                                       
                                </div>
                            </td>
                            <td><?php echo $insumo['UNIDAD']; ?></td>
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

    <!-- Añade los scripts de Bootstrap al final del cuerpo del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Agrega tu script personalizado aquí -->
    <script>
        // Funciones de incrementar y decrementar cantidad
        function incrementarCantidad(id) {
            var input = document.getElementById('cantidad_' + id);
            input.stepUp();
        }

        function decrementarCantidad(id) {
            var input = document.getElementById('cantidad_' + id);
            input.stepDown();
        }

        // Mostrar mensaje de éxito o error después de actualizar
        <?php if (isset($_SESSION['cambios_exitosos'])): ?>
            <?php if ($_SESSION['cambios_exitosos']): ?>
                alert("Los cambios se realizaron con éxito.");
            <?php else: ?>
                alert("Hubo un error al realizar los cambios.");
            <?php endif; ?>
            <?php unset($_SESSION['cambios_exitosos']); ?> // Limpiar la variable de sesión después de mostrar el mensaje
            // Redireccionar a otra página al hacer clic en "Aceptar" en el mensaje
            window.location.href = "../../vista/administrador/menuAdministrador.php"; // Cambia "nueva_pagina.php" por la URL de la página a la que deseas redirigir
        <?php endif; ?>
    </script>
</body>
</html>
