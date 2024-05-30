$(document).ready(function () {
    var lastSelectedEspecialidad = null;

    $('#especialidad').on('change', function () {
        var selectedEspecialidad = $(this).val();
        if (selectedEspecialidad !== lastSelectedEspecialidad) {
            lastSelectedEspecialidad = selectedEspecialidad;
            cargarProfesionales(selectedEspecialidad);
        }
    });

    function cargarProfesionales(idEspecialidad) {
        $.ajax({
            url: '../../modelo/paciente/obtenedores/obtenerProfesionales.php',
            type: 'get',
            dataType: 'json',
            data: { idEspecialidad: idEspecialidad },
            success: function (response) {
                $('#profesional').empty().append('<option value="">Seleccione un odontólogo</option>');

                if (response.length > 0) {
                    $.each(response, function (index, profesional) {
                        $('#profesional').append('<option value="' + profesional.id_profesional + '" data-consultorio="' + profesional.id_consultorio + '">' + profesional.nombre_completo + '</option>');
                    });
                } else {
                    $('#profesional').append('<option value="" disabled>No hay odontólogos disponibles</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX de profesionales:', status, error);
            }
        });
    }

    $('#profesional').on('change', function () {
        var selectedProfesional = $(this).val();
        var selectedConsultorio = $(this).find(':selected').data('consultorio');
        
        if (selectedProfesional) {
            $('#consultorio').val(selectedConsultorio);
        } else {
            $('#consultorio').val('');
        }
    });
});
