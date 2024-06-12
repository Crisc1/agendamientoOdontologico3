<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/administrador/gestion_pacientes.css">
    <title>Gestión de Pacientes</title>
</head>
<body>
    <h1>Gestión de Pacientes</h1>
    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Tipo de Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Dirección</th>
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

            // Consulta SQL para obtener los datos de los pacientes
            $sql = "SELECT * FROM persona WHERE ID_ROL = 4"; // Selecciona solo los pacientes (rol 4)
            $result = $conn->query($sql);

            // Mostrar los datos en la tabla
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["DOCUMENTO"] . "</td>";
                    echo "<td>" . $row["TIPO_DOCUMENTO"] . "</td>";
                    echo "<td>" . $row["NOMBRE"] . "</td>";
                    echo "<td>" . $row["APELLIDO"] . "</td>";
                    echo "<td>" . $row["FECHA_NACIMIENTO"] . "</td>";
                    echo "<td>" . $row["TELEFONO"] . "</td>";
                    echo "<td>" . $row["CORREO"] . "</td>";
                    echo "<td>" . $row["DIRECCION"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay pacientes disponibles.</td></tr>";
            }
           
            // Cerrar conexión a la base de datos
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
