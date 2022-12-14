<?php

use Fibi\Http\Request\PhpCookie;

$cookies = new PhpCookie();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Factory</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="./assets/css2.css">

    <!-- Bootstrap 5.0.0 -->
    <link rel="stylesheet" href="vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/signup.css">
</head>
<body>
    <!-- Title -->
    <header class="text-center pt-4">
        <a class="navbar-brand" href="/">
            <img id="brand-logo-auth" src="assets/img/brand-logo.svg" alt="Brand Logo">
        </a>
        <nav class="navbar fixed-top bg-orange"></nav>
    </header>

    <section class="container my-4" id="main-container">
        <div class="row d-flex justify-content-center">
            <form class="bg-white rounded-1 shadow-sm p-5 col-lg-5 col-md-7" id="login-form" novalidate method="POST" action="/api/v1/login">

                <h1 class="h2 text-center mb-4">Iniciar sesión</h1>
                <hr class="mb-4">

                <div class="mb-4">
                    <label class="form-label" for="login-or-email" role="button">Correo electrónico o nombre de usuario</label>
                    <div class="input-group">
                        <input type="email" class="form-control shadow-none rounded-1" name="loginOrEmail" id="login-or-email" placeholder=""
                        value=<?= $cookies->get('loginOrEmail') ?? "" ?>>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password" role="button">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control shadow-none rounded-start" aria-describedby="basic-addon2" name="password" id="password"
                        value=<?= $cookies->get('password') ?? "" ?>>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end" id="btn-password"><i class="fas fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                </div>
    
                <div class="mb-4">
                    <input type="checkbox" class="form-check-input shadow-none rounded-1" name="remember" id="remember" value="1" role="button"
                    <?php if ($cookies->get('remember')) print("checked") ?>>
                    <label class="form-label" for="remember" role="button">Recuérdame</label>
                </div>
    
                <button type="submit" class="btn btn-orange w-100 mb-4 shadow-none rounded-1" id="btn-login">Iniciar sesión</button>

                <div class="text-center">
                    <p class="mb-0">¿Aún no tienes cuenta?</p>
                    <a href="/signup" class="d-block text-orange text-decoration-none">¡Regístrate ahora!</a>        
                </div>
            </form>
        </div>
    </section>

    @footer

    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script type="module" src="./js/login.js"></script>
</body>
</html>