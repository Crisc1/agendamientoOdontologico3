<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../../index.php">
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
</head>
<body>
    <h1>Por favor, inicie sesión para acceder a esta página.</h1>
    <p class="loader"></p>
    <p>Redireccionando en 5 segundos...</p>
</body>
</html>
