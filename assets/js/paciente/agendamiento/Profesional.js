$(document).ready(function () {
    // Variable para almacenar la última especialidad seleccionada
    var lastSelectedEspecialidad = null;

    // Agregamos un listener para el evento de cambio en el selector de especialidades
    $('#especialidad').on('change', function () {
        // Obtener el valor actual del select
        var selectedEspecialidad = $(this).val();

        // Verificar si la especialidad seleccionada ha cambiado desde la última vez
        if (selectedEspecialidad !== lastSelectedEspecialidad) {
            // Almacena la nueva especialidad seleccionada
            lastSelectedEspecialidad = selectedEspecialidad;

            // Llamamos a la función para cargar los profesionales solo si la especialidad ha cambiado
            cargarProfesionales(selectedEspecialidad);
        }
    });

    // Función para cargar dinámicamente las opciones de profesionales según la especialidad seleccionada
    function cargarProfesionales(idEspecialidad) {
        // Realiza una solicitud AJAX al servidor para obtener los profesionales según la especialidad seleccionada
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerProfesionales.php',
            type: 'get',
            dataType: 'json',
            data: { idEspecialidad: idEspecialidad },
            success: function (response) {
                // Limpia y actualiza las opciones del selector de profesionales
                $('#profesional').empty().append('<option value="">Seleccione un odontólogo</option>');

                if (response.length > 0) {
                    // Si hay profesionales disponibles, agrega las opciones
                    $.each(response, function (index, profesional) {
                        $('#profesional').append('<option value="' + profesional.id_profesional + '">' + profesional.nombre_completo + '</option>');
                    });
                } else {
                    // Si no hay profesionales disponibles, muestra un mensaje
                    $('#profesional').append('<option value="" disabled>No hay odontólogos disponibles</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX de profesionales:', status, error);
            }
        });
    }

    // Llamamos a la función para cargar las especialidades al cargar la página
    cargarEspecialidades();

    // Función para cargar dinámicamente las opciones de especialidades al cargar la página
    function cargarEspecialidades() {
        // Realiza una solicitud AJAX al servidor para obtener las especialidades
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerEspecialidades.php',
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
});
