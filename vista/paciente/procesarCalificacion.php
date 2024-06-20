<?php
session_start();

// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Deja la contraseña en blanco si estás usando una configuración predeterminada en tu entorno local
$dbname = "bd_odontologia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se recibió una calificación y una sugerencia
if (isset($_POST['calificacion']) && isset($_POST['sugerencia'])) {
    // Escapar los datos para prevenir inyecciones SQL
    $calificacion = $conn->real_escape_string($_POST['calificacion']);
    $sugerencia = $conn->real_escape_string($_POST['sugerencia']);

    // Insertar la calificación y la sugerencia en la base de datos
    $sql = "INSERT INTO Calificacion (calificacion, sugerencia) VALUES ('$id_calificacion','$id_cita', '$sugerencia','$calificacion')";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción se realizó correctamente, redirigir a la página de calificación con un mensaje de éxito
        header('Location: calificacion.php?success=true');
        exit();
    } else {
        // Si hubo un error en la inserción, mostrar un mensaje de error
        echo "Hubo un error al procesar la calificación: " . $conn->error;
        exit();
    }
} else {
    // Si no se recibieron los parámetros esperados, mostrar un mensaje de error
    echo "Error: Parámetros incompletos.";
    exit();
}

// Cerrar la conexión
$conn->close();
?>