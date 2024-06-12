<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/administrador/GesConsultorio.css">
    <title>Gestión de Consultorios</title>
</head>
<body>
    <h1>Gestión de Consultorios</h1>
    <table>
        <thead>
            <tr>
                <th>ID Consultorio</th>
                <th>Número Consultorio</th>
                <th>Ubicación</th> <!-- Nuevo campo para la ubicación -->
            </tr>
        </thead>
        <tbody>
            <?php
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

            // Consulta SQL para obtener los datos de los consultorios
            $sql = "SELECT ID_CONSULTORIO, NUMERO_CONSULTORIO, UBICACION_CONSULTORIO FROM consultorio";
            $result = $conn->query($sql);

            // Mostrar los datos en la tabla
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_CONSULTORIO"] . "</td>";
                    echo "<td>" . $row["NUMERO_CONSULTORIO"] . "</td>";
                    echo "<td>" . $row["UBICACION_CONSULTORIO"] . "</td>"; // Mostrar la ubicación del consultorio
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay consultorios disponibles.</td></tr>";
            }
           
            // Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
