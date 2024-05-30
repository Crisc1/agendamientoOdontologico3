<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/odontologo/styleOdongramaConsulta.css"/>
    <title>Historial Odontológico</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Centro Odontológico</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="volver-container">
                        <a class="nav-link volver-link" href="#" onclick="goBack()">Volver</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="titulo mt-3">Odontograma</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card my-3">
                    <div class="card-body">
                        <form id="pacienteForm">
                            <div class="form-group">
                                <label for="fechaSelect">Seleccione una fecha de odontograma:</label>
                                <select id="fechaSelect" name="fecha" class="form-control">
                                    <?php
                                    // Crear una instancia del modelo para consultar odontogramas
                                    $modeloOdontograma = new modeloOdontograma();

                                    // Consultar los odontogramas y obtener las fechas únicas
                                    $fechasUnicas = $modeloOdontograma->consultarOdontograma($documentoPaciente);

                                    // Generar las opciones del select con las fechas únicas
                                    foreach ($fechasUnicas as $fecha) {
                                        echo '<option value="' . $fecha . '">' . $fecha . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="button" onclick="buscarComentarios()" class="btn btn-primary btn-block">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="listaAgregados" class="form-container">
            <h2 class="mt-4">Lista de Odontogramas</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <!-- Aquí se mostrarán los resultados de la búsqueda -->
                </table>
            </div>
        </div>
    </div>

    <script>
        function buscarComentarios() {
            // Obtener el valor seleccionado del select
            var fechaSeleccionada = document.getElementById("fechaSelect").value;

            // Enviar una solicitud AJAX para obtener los comentarios correspondientes a la fecha seleccionada
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Actualizar el contenido de la tabla con los comentarios recibidos
                    document.getElementById("listaAgregados").innerHTML = xhr.responseText;
                }
            };
            xhr.open("POST", "../../modelo/odontologo/logicaOdontogramaFecha.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("fecha=" + fechaSeleccionada);
        }
    </script>
</body>

</html>
