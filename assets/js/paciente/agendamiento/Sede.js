     $(document).ready(function () {
            cargarSedes(); // Cargar las sedes al cargar la página

            $('#sede').change(function () {
                var sedeId = $(this).val();
                if (sedeId) {
                    // Cargar odontólogos al seleccionar una sede
                    cargarOdontologosPorSede(sedeId);
                    // Asignar el ID de la sede seleccionada a un campo oculto
                    $('#idSede').val(sedeId);
                } else {
                    $('#profesional').empty().append('<option value="">Selecciona una sede primero</option>').prop('disabled', true);
                    $('#idSede').val('');
                }
            });

            $('#profesional').change(function () {
                var profesionalId = $(this).val();
                if (profesionalId) {
                    // Asignar el ID del odontólogo seleccionado al campo "consultorio"
                    $('#consultorio').val(profesionalId);
                } else {
                    $('#consultorio').val('');
                }
            });

            $('#fecha').change(function () {
                cargarEspecialidades(); // Lógica adicional si es necesario
            });
        });

        function cargarSedes() {
            $.ajax({
                url: '../../modelo/paciente/obtenedores/obtenerSedes.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#sede').empty().append('<option value="">Selecciona una sede</option>');
                    $.each(data, function (index, value) {
                        $('#sede').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                },
                error: function (error) {
                    console.error('Error al obtener las sedes: ' + JSON.stringify(error));
                }
            });
        }

        function cargarOdontologosPorSede(sedeId) {
            $.ajax({
                url: '../../modelo/paciente/obtenedores/obtenerOdontologosSede.php',
                type: 'GET',
                data: { sede_id: sedeId },
                dataType: 'json',
                success: function (data) {
                    $('#profesional').empty().append('<option value="">Selecciona un odontólogo</option>');
                    $.each(data, function (index, value) {
                        $('#profesional').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                    $('#profesional').prop('disabled', false);
                },
                error: function (error) {
                    console.error('Error al obtener los odontólogos: ' + JSON.stringify(error));
                }
            });
        }