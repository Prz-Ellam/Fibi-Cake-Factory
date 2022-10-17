<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto:ital,wght@0,400;1,500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.0.0 -->
    <link rel="stylesheet" href="vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link type="text/css" href="./styles/layout.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/landing-page.css">
    <link type="text/css" href="./styles/footer.css" rel="stylesheet">

    <link rel="stylesheet" href="styles/colors.css">
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row">
            <nav class="col-12 navbar navbar-expand-lg navbar-dark scrolling-navbar py-3 px-sm-3">
                <a class="navbar-brand ms-2" href="/"><img src="assets/img/Brand-Logo.svg" id="brand-logo"></a>    
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-collapse">
                    <ul class="navbar-nav" id="orange-navbar">
                        <li class="nav-item me-1">
                            <a href="/signup" class="primary-nav-item nav-link text-white fw-bold rounded-3 ms-sm-0 ms-2">
                                <i class="fa fa-solid fa-sign-in me-2"></i>Registrarse
                            </a>
                        </li>
                        <li class="nav-item me-1">
                            <a href="/login" class="primary-nav-item me-3 nav-link text-white fw-bold rounded-3 ms-sm-0 ms-2">
                                <i class="fas fa-solid fa-user me-2"></i>Iniciar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="info">
                            <h1>¡CONQUISTANDO EL SABOR SUPREMO!</h1>
                            <p>¡Encuentra los mejores pasteles del mundo, hechos por los expertos!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="info">
                            <div class="container">
                                <p>
                                Cake Factory es un punto de venta donde cualquier persona que tenga conocimientos de
                                reposteria puede ingresar y publicitar sus productos y su negocio, recibimos gente de
                                todas partes del mundo a diario.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="info">
                            <div class="container">
                                <h1>¡UNETE A NOSOTROS!</h1>
                                <a href="/signup" class="btn btn-orange mb-4 shadow-none rounded-1" style="font-size: 24px" id="btn-login">Iniciar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

  
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="./js/landing-page.js"></script>
</body>

</html>