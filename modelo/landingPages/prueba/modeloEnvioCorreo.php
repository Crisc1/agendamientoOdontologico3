// send_recovery_email.php
<?php
include 'conexionBD.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $conexion = new conexionBD();
    if ($conexion->abrir()) {
        // Verificar si el correo electrónico existe en la base de datos
        $sql = "SELECT * FROM PERSONA WHERE CORREO = '$email'";
        $conexion->consultar($sql);
        $user = $conexion->obtenerResult()->fetch_assoc();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $sql = "INSERT INTO RESTABLECER_CONTRASEÑA (email, token) VALUES ('$email', '$token')";
            $conexion->consultar($sql);

            $reset_link = 'https://tu-dominio.com/reset_password.php?token=' . $token;
            $subject = 'Recuperar Contraseña';
            $message = 'Haz clic en el siguiente enlace para restablecer tu contraseña: ' . $reset_link;
            $headers = 'From: no-reply@tu-dominio.com' . "\r\n" .
                       'Reply-To: no-reply@tu-dominio.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            mail($email, $subject, $message, $headers);
            echo 'Se ha enviado un enlace de recuperación a tu correo electrónico.';
        } else {
            echo 'El correo electrónico no está registrado.';
        }

        $conexion->cerrar();
    } else {
        echo 'Error al conectar con la base de datos.';
    }
}
?>
