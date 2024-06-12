// Obtén el formulario
var formulario = document.querySelector('form');

// Agrega un event listener para el evento submit
formulario.addEventListener('submit', function(event) {
    // Verifica la validación de los campos antes de enviar el formulario
    if (!validarCampos()) {
        // Si hay errores, cancela el envío del formulario
        event.preventDefault();
    }
});

// Función para validar todos los campos del formulario
function validarCampos() {
    // Verifica cada campo y retorna true si todos son válidos, false si hay errores
    var telefonoValido = validarTelefono();
    var documentoValido = validarDocumento();
    var correoValido = validarCorreo();
    
    // Retorna true si todos los campos son válidos, false si hay al menos un error
    return telefonoValido && documentoValido && correoValido;
}

// Función para validar el campo de teléfono
function validarTelefono() {
    var telInput = document.getElementById('telefono');
    var telError = document.getElementById('tel-error');
    if (/[a-zA-Z]/.test(telInput.value)) {
        telError.style.display = 'block';
        return false;
    } else {
        telError.style.display = 'none';
        return true;
    }
}

// Función para validar el campo de número de documento
function validarDocumento() {
    var docInput = document.getElementById('documento');
    var docError = document.getElementById('doc-error');
    if (/[a-zA-Z]/.test(docInput.value)) {
        docError.style.display = 'block';
        return false;
    } else {
        docError.style.display = 'none';
        return true;
    }
}

// Función para validar el campo de correo electrónico
function validarCorreo() {
    var emailInput = document.getElementById('correo');
    var emailError = document.getElementById('email-error');
    if (!isValidEmail(emailInput.value)) {
        emailError.style.display = 'block';
        return false;
    } else {
        emailError.style.display = 'none';
        return true;
    }
}

// Función para validar si hay caracteres alfabéticos en tiempo real en el campo de teléfono
document.getElementById('telefono').addEventListener('input', function () {
    var telInput = document.getElementById('telefono');
    var telError = document.getElementById('tel-error');
    if (/[a-zA-Z]/.test(telInput.value)) {
        telError.style.display = 'block';
    } else {
        telError.style.display = 'none';
    }
});

// Función para validar si hay caracteres alfabéticos en tiempo real en el campo de número de documento
document.getElementById('documento').addEventListener('input', function () {
    var docInput = document.getElementById('documento');
    var docError = document.getElementById('doc-error');
    if (/[a-zA-Z]/.test(docInput.value)) {
        docError.style.display = 'block';
    } else {
        docError.style.display = 'none';
    }
});

// Función para validar el formato del correo electrónico y los dominios conocidos
document.getElementById('correo').addEventListener('blur', function () {
    var emailInput = document.getElementById('correo');
    var emailError = document.getElementById('email-error');
    if (!isValidEmail(emailInput.value)) {
        emailError.style.display = 'block';
    } else {
        emailError.style.display = 'none';
    }
});

// Función para validar el formato del correo electrónico y los dominios conocidos
function isValidEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var knownDomains = ['gmail.com', 'hotmail.com', 'yahoo.com', 'outlook.com', 'aol.com', 'icloud.com', 'protonmail.com', 'yandex.com', 'mail.com', 'gmx.com']; // Agrega aquí los dominios que deseas permitir
    var domain = email.split('@')[1];
    return emailPattern.test(email) && knownDomains.includes(domain);
}

// Función para validar si la fecha de nacimiento permite seleccionar el tipo de documento
document.getElementById('fecha_nacimiento').addEventListener('blur', function () {
    var fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);
    var tipoDocumentoSelect = document.getElementById('tipo_documento');
    var docError = document.getElementById('doc-error');

    // Calcula la diferencia de tiempo en milisegundos
    var diferenciaTiempo = Date.now() - fechaNacimiento.getTime();

    // Calcula la diferencia de años
    var edad = Math.abs(new Date(diferenciaTiempo).getUTCFullYear() - 1970);

    // Verifica si la edad es menor a 18 años y muestra el mensaje correspondiente
    if (edad < 18) {
        docError.innerText = 'No puede seleccionar cédula siendo menor de edad. Si cree que es un error, corrija la fecha de nacimiento.';
        docError.style.display = 'block'; // Mostrar el mensaje de error
        tipoDocumentoSelect.classList.add('is-invalid'); // Agregar la clase para resaltar el campo de tipo de documento
    } else {
        docError.innerText = ''; // Limpia el mensaje de error si la edad es mayor o igual a 18 años
        docError.style.display = 'none'; // Ocultar el mensaje de error
        tipoDocumentoSelect.classList.remove('is-invalid'); // Eliminar la clase de resaltado del campo de tipo de documento
    }
});

// Espera a que el documento HTML esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    // Obtén el elemento select de tipo de documento
    var tipoDocumentoSelect = document.getElementById("tipo_documento");

    // Realiza una solicitud AJAX para obtener los tipos de documento
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../../modelo/landingPages/consultaTipoDocumentos.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Convierte la respuesta JSON en un objeto JavaScript
            var response = JSON.parse(xhr.responseText);

            // Itera sobre los tipos de documento y agrega las opciones al select
            response.forEach(function (tipoDocumento) {
                var option = document.createElement("option");
                option.value = tipoDocumento.id;
                option.text = tipoDocumento.nombre;
                tipoDocumentoSelect.appendChild(option);
            });
        }
    };
    xhr.send();
});

//Muestra los mensajes del modelo en forma de alert
$(document).ready(function() {
    $('#registroForm').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../../controladores/landingPages/controlRegistroPersona.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
});

$(document).ready(function() {
    $('#documento').on('input', function() {
        var documento = $(this).val();
        verificarDocumento(documento);
    });

    $('#correo').on('input', function() {
        var correo = $(this).val();
        verificarCorreo(correo);
    });

    function verificarDocumento(documento) {
        $.ajax({
            type: 'POST',
            url: '../../modelo/landingPages/verificarDocumento.php',
            data: { documento: documento },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#documento-error').text(response.message).show();
                } else {
                    $('#documento-error').hide();
                }
            }
        });
    }

    function verificarCorreo(correo) {
        $.ajax({
            type: 'POST',
            url: '../../modelo/landingPages/verificarCorreo.php',
            data: { correo: correo },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    $('#correo-error').text(response.message).show();
                } else {
                    $('#correo-error').hide();
                }
            }
        });
    }

    $('#registroForm').submit(function(event) {
        event.preventDefault();
        if ($('#documento-error').is(':visible') || $('#correo-error').is(':visible')) {
            alert('Por favor, corrija los errores antes de enviar el formulario.');
        } else {
            // Puedes agregar aquí la lógica para enviar el formulario si no hay errores
        }
    });
});
