document.addEventListener('DOMContentLoaded', function() {
    const documentoInput = document.getElementById('documento');
    const correoInput = document.getElementById('correo');
    const telefonoInput = document.getElementById('telefono');
    const form = document.getElementById('registroForm');

    documentoInput.addEventListener('input', function() {
        const documento = documentoInput.value;
        fetch('../../modelo/landingPages/registro/modeloDocumento.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'documento=' + encodeURIComponent(documento)
        })
        .then(response => response.json())
        .then(data => {
            const errorDiv = document.getElementById('documento-error');
            if (data.exists) {
                errorDiv.textContent = 'El número de documento ya se encuentra registrado.';
                errorDiv.style.display = 'block';
            } else {
                errorDiv.style.display = 'none';
            }
        });
    });

    correoInput.addEventListener('input', function() {
        const correo = correoInput.value;
        fetch('../../modelo/landingPages/registro/modeloDocumento.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'correo=' + encodeURIComponent(correo)
        })
        .then(response => response.json())
        .then(data => {
            const errorDiv = document.getElementById('correo-error');
            if (data.exists) {
                errorDiv.textContent = 'El correo electrónico ya se encuentra registrado.';
                errorDiv.style.display = 'block';
            } else {
                errorDiv.style.display = 'none';
            }
        });
    });

    telefonoInput.addEventListener('input', function() {
        const telefono = telefonoInput.value;
        const errorDiv = document.getElementById('tel-error');
        if (/\D/.test(telefono)) {
            errorDiv.textContent = 'El teléfono no puede contener letras, solo puede contener números.';
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    form.addEventListener('submit', function(event) {
        const documentoError = document.getElementById('documento-error');
        const correoError = document.getElementById('correo-error');
        const telError = document.getElementById('tel-error');
        
        if (documentoError.style.display === 'block' || correoError.style.display === 'block' || telError.style.display === 'block') {
            event.preventDefault();
            alert('Por favor, corrija los errores antes de enviar el formulario.');
        }
    });


    // Validar teléfono
    $('#telefono').on('input', function() {
        var telefono = $(this).val();
        if (/[^0-9]/.test(telefono)) {
            $('#tel-error').text('El teléfono no puede contener letras, solo puede contener números.').show();
        } else {
            $('#tel-error').hide();
        }
    });

    // Validar número de documento
    $('#documento').on('input', function() {
        var documento = $(this).val();
        if (documento) {
            $.ajax({
                url: '../../modelo/landingPages/registro/modeloDocumento.php',
                method: 'POST',
                data: { documento: documento },
                dataType: 'json',
                success: function(response) {
                    if (response.exists) {
                        $('#documento-error').text('El número de documento ya se encuentra registrado.').show();
                    } else {
                        $('#documento-error').hide();
                    }
                },
                error: function(error) {
                    console.error('Error al verificar el documento:', error);
                }
            });
        } else {
            $('#documento-error').hide();
        }
    });

    // Validar correo
    $('#correo').on('input', function() {
        var correo = $(this).val();
        if (correo) {
            $.ajax({
                url: '../../modelo/landingPages/registro/modeloCorreo.php',
                method: 'POST',
                data: { correo: correo },
                dataType: 'json',
                success: function(response) {
                    if (response.exists) {
                        $('#correo-error').text('El correo electrónico ya se encuentra registrado.').show();
                    } else {
                        $('#correo-error').hide();
                    }
                },
                error: function(error) {
                    console.error('Error al verificar el correo:', error);
                }
            });
        } else {
            $('#correo-error').hide();
        }
    });

    // Validar formulario antes de enviar
    $('#registroForm').on('submit', function(event) {
        if ($('#tel-error').is(':visible') || $('#documento-error').is(':visible') || $('#correo-error').is(':visible')) {
            event.preventDefault();
            alert('Por favor, corrija los errores antes de enviar el formulario.');
        }
    });
});
