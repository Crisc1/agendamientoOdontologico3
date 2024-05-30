$(document).ready(function () {
    // Agregamos un listener para el evento de cambio en el selector de especialidades
    $('#especialidad').on('change', function () {
        // Cuando cambia la especialidad seleccionada, llamamos a la función para cargar los tratamientos
        cargarTratamientos($(this).val());
    });


    // Obtener la fecha actual en formato ISO (YYYY-MM-DD)
    var today = new Date().toISOString().split('T')[0];

    // Establecer la fecha mínima del campo de entrada 'fecha' al día de hoy
    document.getElementById('fecha').setAttribute('min', today);
    
    // Función para cargar dinámicamente las opciones de tratamiento según la especialidad seleccionada
    function cargarTratamientos(idEspecialidad) {
        // Realiza una solicitud AJAX al servidor para obtener los tratamientos según la especialidad seleccionada
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerTratamientos.php',
            type: 'get',
            dataType: 'json',
            data: { idEspecialidad: idEspecialidad },
            success: function (response) {
                // Limpia y actualiza las opciones del selector de tratamientos
                $('#tratamiento').empty().append('<option value="">Seleccione un tratamiento</option>');

                if (response.length > 0) {
                    // Si hay tratamientos disponibles, agrega las opciones
                    $.each(response, function (index, tratamiento) {
                        $('#tratamiento').append('<option value="' + tratamiento.id + '">' + tratamiento.nombre + '</option>');
                    });
                } else {
                    // Si no hay tratamientos disponibles, muestra un mensaje
                    $('#tratamiento').append('<option value="" disabled>No hay tratamientos disponibles</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX de tratamientos:', status, error);
            }
        });
    }
});
