<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agendamiento Odontológico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0d6efd;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .carousel-item {
            height: 75vh;
            min-height: 300px;
            background: no-repeat center center scroll;
            background-size: cover;
        }
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 1rem;
            border-radius: 10px;
        }
        .content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: -100px;
            position: relative;
            z-index: 10;
        }
        footer {
            background-color: #0d6efd;
            color: white;
            padding: 1rem 0;
        }
        .contact-buttons .btn {
            margin: 0 0.5rem;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Centro Odontológico</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="vista/landingPages/iniciarSesion.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vista/landingPages/registroPersona.php">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('assets/img/landingPages/Centro.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Bienvenido a nuestro Centro Odontológico</h5>
                    <p>Ofrecemos servicios de odontología de alta calidad.</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('assets/img/landingPages/Atencion.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Atención Personalizada</h5>
                    <p>Nos dedicamos a proporcionar atención personalizada y compasiva.</p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('assets/img/landingPages/Tecnologia.jpg');">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Tecnología Innovadora</h5>
                    <p>Utilizamos la última tecnología y técnicas innovadoras.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <section class="container content mt-5">
        <h2>Nuestro Servicio Único</h2>
        <p>
            Bienvenido a nuestro Centro Odontológico, donde nos dedicamos a proporcionar servicios de 
            odontología de alta calidad en un entorno cálido y acogedor. En nuestro compromiso con la 
            salud bucal integral, ofrecemos una amplia gama de servicios odontológicos diseñados para 
            satisfacer las necesidades individuales de cada paciente.
        </p>
        <p>
            Nuestro equipo de profesionales altamente calificados está aquí para brindarle atención 
            personalizada y compasiva. Nos esforzamos por crear experiencias positivas para nuestros 
            pacientes, asegurando que se sientan cómodos y bien atendidos en cada visita. Trabajamos 
            con la última tecnología y técnicas innovadoras para garantizar tratamientos efectivos y 
            resultados duraderos.
        </p>
        <p>
            En nuestro Centro Odontológico, nos especializamos en servicios que abarcan desde la 
            prevención y limpieza dental hasta procedimientos más complejos, como tratamientos de 
            conducto, implantes dentales, ortodoncia y estética dental. Creemos en educar a nuestros 
            pacientes sobre la importancia de la salud bucal y proporcionarles las herramientas 
            necesarias para mantener sonrisas radiantes y saludables a lo largo del tiempo.
        </p>
        <p>
            Nos enorgullece ser un lugar donde la excelencia clínica se combina con un enfoque 
            centrado en el paciente. Su bienestar es nuestra prioridad, y nos esforzamos por construir 
            relaciones a largo plazo basadas en la confianza y la atención personalizada. En cada paso
            del camino, desde su primera consulta hasta su tratamiento continuo, estamos comprometidos 
            con su sonrisa y su salud bucal integral.
            ¡Esperamos darle la bienvenida a nuestro Centro Odontológico y brindarle la atención que 
            su sonrisa merece! Contáctenos hoy para programar su cita y comenzar su viaje hacia una 
            salud bucal óptima.
        </p>
    </section>
    <br><br>
    <footer class="text-center">
        <div class="container">
            <div class="contact-buttons mt-3">
                <a href="https://www.facebook.com/" target="_blank" class="btn btn-outline-light btn-sm">Facebook</a>
                <a href="https://www.instagram.com/" target="_blank" class="btn btn-outline-light btn-sm">Instagram</a>
                <a href="mailto:info@tuempresa.com" class="btn btn-outline-light btn-sm">Contacto por Email</a>
            </div>
        </div>
    </footer>
</body>
</html>
