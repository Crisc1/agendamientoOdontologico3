<?php
session_start();

// Comprobar si hay una sesión activa
if (isset($_SESSION['DOCUMENTO'])) {
    // Obtener el ID_ROL de la sesión
    $idRol = $_SESSION['ID_ROL'];
    
        // Comprobar si hay un mensaje de éxito
    $successMessage = isset($_GET['success']) && $_GET['success'] === 'true';

    // Definir el ID_ROL permitido
    $idRolPermitido = 4; // Puedes cambiar esto al número que desees permitir

    // Verificar si el ID_ROL es diferente al permitido
    if ($idRol != $idRolPermitido) {
        // Redirigir a la página de error de acceso
        header('Location: ../salidas/errorAccesoSinPermisos.php');
        exit();
    }

    // Resto del código para usuarios autenticados
    $documento = $_SESSION['DOCUMENTO'];
    $nombre = $_SESSION['NOMBRE'];
    $apellido = $_SESSION['APELLIDO'];
} else {
    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('Location: ../salidas/errorAccesoSinLogin.php');
    exit();
}
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
}// Establecer conexión a la base de datos
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

//Verificar si se ha enviado la fecha
if (isset($_POST['calificacion'])) {
    // Escapar la fecha para prevenir inyecciones SQL
    $calificacion = $conn->real_escape_string($_POST['calificacion']);

    // Consultar los procedimientos para la fecha especificada
    $sql = "SELECT * FROM Calificacion WHERE CALIFICACION = '$calificacion'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generar la tabla HTML con los resultados
        echo "<tr><th>ID_Calificacion</th><th>Sugerencia</th><th>calificacion</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["ID_Calificacion"]."</td><td>".$row["sugerencia"]."</td><td>".$row["calificacion"]."</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Calificacion.</td></tr>";
    }
    exit(); // Salir del script después de manejar la solicitud AJAX
}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/paciente/stylecalificarCitas.css">
    <title>Calificación de Servicio</title>
    <!-- Agregar otros enlaces a hojas de estilo si es necesario -->
</head>
<body>
    <body>
    <?php if ($successMessage) : ?>
        <p>¡Calificación realizada exitosamente!</p>
    <?php endif; ?>
    <!-- Resto del formulario y código HTML omitido por brevedad -->
</body>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(../..//assets/img/backgroundGlobal.jpg) no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 60px;
            margin-top: 60px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            margin-top: 0;
        }
        form {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stars {
            display: flex;
            justify-content: center;
            direction: rtl;
        }
        label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        input[type="radio"] {
            display: none;
        }
        label:hover,
        label:hover ~ label {
            color: orange;
        }
        input[type="radio"]:checked ~ label {
            color: orange;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: blue;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            padding: 5px;
            resize: vertical;
            color: blue;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Calificación de Servicio</h1>
    <form id="calificacionForm" action="procesarCalificacion.php" method="post">
        <div class="stars">
            <input type="radio" name="calificacion" id="star5" value="5">
            <label for="star5">★</label>
            <input type="radio" name="calificacion" id="star4" value="4">
            <label for="star4">★</label>
            <input type="radio" name="calificacion" id="star3" value="3">
            <label for="star3">★</label>
            <input type="radio" name="calificacion" id="star2" value="2">
            <label for="star2">★</label>
            <input type="radio" name="calificacion" id="star1" value="1">
            <label for="star1">★</label>
        </div>
        
        <h2 for="SUGERENCIA">Sugerencia:</h2>
        <textarea name="SUGERENCIA" id="SUGERENCIA" placeholder="Escribe tu sugerencia..."></textarea>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
<?php
$conn->close();
?>
