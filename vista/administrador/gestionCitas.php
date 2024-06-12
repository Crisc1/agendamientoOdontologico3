<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/administrador/gestion_citas.css">
    <title>Gestión de Citas</title>
</head>
<body>
    <h1>Gestión de Citas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Cita</th>
                <th>ID Profesional</th>
                <th>Documento Paciente</th>
                <th>ID Tratamiento</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>ID Consultorio</th>
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

            // Consulta SQL para obtener los datos de las citas
            $sql = "SELECT * FROM cita";
            $result = $conn->query($sql);

            // Mostrar los datos en la tabla
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_CITA"] . "</td>";
                    echo "<td>" . $row["ID_PROFESIONAL"] . "</td>";
                    echo "<td>" . $row["DOCUMENTO_PACIENTE"] . "</td>";
                    echo "<td>" . $row["ID_TRATAMIENTO"] . "</td>";
                    echo "<td>" . $row["FECHA"] . "</td>";
                    echo "<td>" . $row["HORA"] . "</td>";
                    echo "<td>" . $row["ID_CONSULTORIO"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay citas disponibles.</td></tr>";
            }
           
            // Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
