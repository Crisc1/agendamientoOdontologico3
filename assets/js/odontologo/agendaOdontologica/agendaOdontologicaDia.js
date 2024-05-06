function confirmAsistencia(documentoPaciente) {
    // Mostrar ventana de confirmación
    var confirmacion = confirm('¿Deseas crear un odontograma para este paciente?');

    // Redirigir según la respuesta
    if (confirmacion) {
        window.location.href = '../vista/odontologo/menuHistorial.php/?documento_paciente=' + documentoPaciente;
    } else {
        window.location.href = '../vista/odontologo/menuHistorial.php';
    }
}

function inasistencia(documentoPaciente) {
    // Redirect to menuOdontograma.php with the documento_paciente parameter
    window.location.href = 'menuOdontograma.php?documento_paciente=' + documentoPaciente;
}