<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lista de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../assets/js/landingPages/bootstrap.min.js"></script>
    <script src="../../assets/js/volver.js"></script>
    <link rel="stylesheet" href="../../assets/css/paciente/styleGestionarCitas.css">
</head>
<body>
    <header class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand titulo-agendamiento" href="../../vista/paciente/menuPaciente.php" name="name">Agendamiento Odontológico</a>
            <div id="navbarNav">
                <button class="bth-volver" onclick="volverPaginaAnterior()">Volver</button>
            </div>
        </div>
    </header>

    <div class="content form-container">
        <h1>Lista de Citas</h1>
        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'calificar') {
            if (isset($_GET['idCita'])) {
                $idCitaCalificar = $_GET['idCita'];

                // Aquí deberías llamar a la función para calificar la cita, no para eliminarla
                // $resultado = $modeloCitas->calificarCita($idCitaCalificar);

                // Enviar una respuesta al cliente para indicar el estado de la calificación
                // echo $resultado ? 'success' : 'error';
                // exit();
            }
        }

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar la tabla con los detalles de las citas
            echo "<table>
                    <tr>
                        <th>Odontologo</th>
                        <th>Tipo de Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Consultorio</th>
                        <th>Acciones</th>
                    </tr>";

            while ($fila = $result->fetch_object()) {
                echo "<tr>
                        <td>{$fila->NOMBRE_profesional}</td>
                        <td>{$fila->NOMBRE_TRATAMIENTO}</td>
                        <td>{$fila->FECHA}</td>
                        <td>{$fila->HORA}</td>
                        <td>{$fila->NUMERO_CONSULTORIO}</td>
                        <td>
                            <button class='btn calificar-btn' onclick='redireccionarACalificar({$fila->ID_CITA})'>Calificar</button>
                        </td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "No hay citas disponibles.";
        }
        ?>
    </div>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script>
        function redireccionarACalificar(idCita) {
            // Redirige a calificacion.php con el ID de la cita como parámetro en la URL
            window.location.href = `../../vista/paciente/calificacion.php?idCita=${idCita}`;
        }
    </script>

</body>
</html>
