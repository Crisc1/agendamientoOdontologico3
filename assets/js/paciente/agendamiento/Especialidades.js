$(document).ready(function () {
    // Llamamos a la función para cargar dinámicamente las opciones de servicio al cargar la página
    cargarEspecialidades();

    // Función para cargar dinámicamente las opciones de especialidad
    function cargarEspecialidades() {
        // Realiza una solicitud AJAX al servidor para obtener las especialidades disponibles
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerEspecialidades.php',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                // Limpia y actualiza las opciones del selector de especialidades
                $('#especialidad').empty().append('<option value="">Selecciona una especialidad</option>');

                if (response.length > 0) {
                    // Si hay especialidades disponibles, agrega las opciones
                    $.each(response, function (index, especialidad) {
                        $('#especialidad').append('<option value="' + especialidad.id + '">' + especialidad.nombre + '</option>');
                    });

                    // También puedes llamar a la función de cargar tratamientos aquí si deseas precargar las opciones
                    // cargarTratamientos($('#especialidad').val());
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
