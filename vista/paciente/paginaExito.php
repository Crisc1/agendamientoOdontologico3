<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redireccionando...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 100px;
            margin: 0;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .loader {
            border: 4px solid #fff;
            border-radius: 50%;
            border-top: 4px solid transparent;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        // Función para redirigir después de 5 segundos
        setTimeout(function () {
            window.location.href = 'menuPaciente.php';
        }, 5000);
    </script>
</head>
<body>
    <h1>Operación completada con éxito.</h1>
    <div class="loader"></div>
    <p>Redireccionando en 5 segundos...</p>
</body>
</html>
