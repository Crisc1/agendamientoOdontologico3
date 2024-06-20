<?php
// Inicia la sesión
session_start();

// Destruye la sesión
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Genera un token único
$token = bin2hex(random_bytes(32));

// Redirige a la página de inicio con el token
header("Location: ../../index.php?logout=1&token=" . $token);
exit();
?>