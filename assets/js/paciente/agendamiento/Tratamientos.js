$(document).ready(function () {
    // Agregamos un listener para el evento de cambio en el selector de especialidades
    $('#especialidad').on('change', function () {
        // Cuando cambia la especialidad seleccionada, llamamos a la función para cargar los tratamientos
        cargarTratamientos($(this).val());
    });

    // Resto del código...

    // Función para cargar dinámicamente las opciones de especialidades al cargar la página
    function cargarEspecialidades() {
        // Realiza una solicitud AJAX al servidor para obtener las especialidades
        $.ajax({
            url: '../../../modelo/paciente/obtenedores/obtenerEspecialidades',  // Reemplaza con la ruta correcta
            type: 'get',
            dataType: 'json',
            success: function (response) {
                // Limpia y actualiza las opciones del selector de especialidades
                $('#especialidad').empty().append('<option value="">Seleccione una especialidad</option>');

                if (response.length > 0) {
                    // Si hay especialidades disponibles, agrega las opciones
                    $.each(response, function (index, especialidad) {
                        $('#especialidad').append('<option value="' + especialidad.id + '">' + especialidad.nombre + '</option>');
                    });
                } else {
                    // Si no hay especialidades disponibles, muestra un mensaje
                    $('#especialidad').append('<option value="" disabled>No hay especialidades disponibles</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX de especialidades:', status, error);
            }
        });
    }

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

    // Resto del código...
});
