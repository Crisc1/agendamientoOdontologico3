$(document).ready(function () {
    // Variable global para almacenar las horas ocupadas
    var horasOcupadas = [];

    // Deshabilitar campos de fecha y hora al cargar la página
    $('#fecha').prop('disabled', true);
    $('#hora').prop('disabled', true);

    // Al cargar la página, llamamos a la función para cargar las horas y deshabilitar las ocupadas
    cargarHoras();

    // Agregamos un listener para el evento de cambio en el selector de fechas
    $('#fecha').on('change', function () {
        // Cuando cambia la fecha seleccionada, llamamos a la función para cargar las horas y deshabilitar las ocupadas
        cargarHoras();
    });

    // Agregamos un listener para el evento de cambio en el selector de especialidades
    $('#especialidad').on('change', function () {
        // Restablecer el campo de fecha y hora al valor por defecto o limpiarlos
        $('#fecha').val('');
        $('#hora').val('');
        // Deshabilitar campos de fecha y hora cuando cambia la especialidad
        $('#fecha').prop('disabled', true);
        $('#hora').prop('disabled', true);
        // Luego, llamamos a la función para cargar las horas y deshabilitar las ocupadas
        cargarHoras();
    });

    // Agregamos un listener para el evento de cambio en el selector de profesionales
    $('#profesional').on('change', function () {
        // Verificar si se ha seleccionado un profesional
        if ($('#profesional').val()) {
            // Habilitar campos de fecha y hora cuando se selecciona un profesional
            $('#fecha').prop('disabled', false);
            $('#hora').prop('disabled', false);
            // Luego, llamamos a la función para cargar las horas y deshabilitar las ocupadas
            cargarHoras();
        } else {
            // Si no se selecciona un profesional, deshabilitar campos de fecha y hora
            $('#fecha').prop('disabled', true);
            $('#hora').prop('disabled', true);
        }
    });

    // Función para cargar dinámicamente las opciones de horas y deshabilitar las ocupadas
    function cargarHoras() {
        // Obtén la fecha y el ID del profesional seleccionados
        var fecha = $('#fecha').val();
        var idProfesional = $('#profesional').val();

        // Evitar la consulta si falta información
        if (!fecha || !idProfesional) {
            return;
        }

        // Realiza una solicitud AJAX al servidor para obtener las horas ocupadas
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerHorasOcupadas.php',
            type: 'get',
            dataType: 'json',
            data: { fecha: fecha, idProfesional: idProfesional },
            success: function (data) {
                // Almacena las horas ocupadas globalmente
                horasOcupadas = data.map(function (hora) {
                    // Elimina los últimos 2 dígitos de la hora y agrégales a un array
                    return hora.substring(0, hora.length - 3);
                });

                // Limpia y actualiza las opciones del selector de horas
                actualizarHorasDisponibles();
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX de horas ocupadas:', status, error);
            }
        });
    }

    // Función para actualizar dinámicamente las opciones de horas y deshabilitar las ocupadas
    function actualizarHorasDisponibles() {
        // Limpia y actualiza las opciones del selector de horas
        $('#hora').empty();

        // Define un rango de horas (ajústalo según tus necesidades)
        var horasDisponibles = generarHorasDisponibles();

        // Agrega las opciones de horas al selector y deshabilita las ocupadas
        horasDisponibles.forEach(function (hora) {
            var option = $('<option>', { value: hora, text: hora });

            // Verifica si la hora está ocupada y la deshabilita
            if (horasOcupadas.includes(hora)) {
                option.prop('disabled', true);
                option.text('(' + hora + ' - Ocupado)');
            }

            $('#hora').append(option);
        });
    }

    // Función para generar un rango de horas (puedes ajustar según tus necesidades)
    function generarHorasDisponibles() {
        var horas = [];
        for (var hora = 9; hora <= 18; hora++) {
            for (var minuto = 0; minuto < 60; minuto += 30) {
                var horaFormato = ('0' + hora).slice(-2) + ':' + ('0' + minuto).slice(-2);
                horas.push(horaFormato);
            }
        }
        return horas;
    }

    // Resto del código...
});
