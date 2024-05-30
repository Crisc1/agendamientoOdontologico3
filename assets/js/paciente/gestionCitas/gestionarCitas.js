// Utilizar AJAX para cargar los datos de la consulta al cargar la página
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Insertar los resultados en el div 'lista-citas'
                document.getElementById('lista-citas').innerHTML = xhr.responseText;
            } else {
                alert('Error en la solicitud al servidor.');
            }
        }
    };

    // Enviar la solicitud POST al script que realiza la consulta
    xhr.open('POST', 'controlCitasPaciente.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('documento=<?php echo $documento; ?>'); // Puedes pasar otros parámetros según tu lógica


    function editarCita(idCita) {
        window.location.href = 'editar_cita.php?id=' + idCita;
    }

    function confirmarEliminar(idCita) {
        var confirmacion = confirm('¿Estás seguro de que deseas eliminar esta cita?');

        if (confirmacion) {
            // Llamar a la función de eliminación
            eliminarCita(idCita);
        }
    }

    function eliminarCita(idCita) {
        // Utilizar AJAX para enviar la solicitud de eliminación al servidor
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var respuesta = xhr.responseText;
                    if (respuesta === 'success') {
                        alert('Cita eliminada con éxito.');
                        location.reload();
                    } else {
                        alert('Error al eliminar la cita.');
                    }
                } else {
                    alert('Error en la solicitud al servidor.');
                }
            }
        };

        // Enviar la solicitud POST al script de eliminación
        xhr.open('POST', 'controlCitasPaciente.php?action=eliminar&idCita=' + idCita, true);
        xhr.send();
    }