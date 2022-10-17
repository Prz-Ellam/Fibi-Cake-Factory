<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Factory</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto:ital,wght@0,400;1,500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.0.0 -->
    <link rel="stylesheet" href="vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="styles/colors.css">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./styles/signup.css">
    <link rel="stylesheet" href="./styles/profile-picture.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body>
    <header class="text-center pt-4">
        <a class="navbar-brand" href="/">
            <img src="assets/img/Brand-Logo.svg" id="brand-logo-auth" alt="Brand Logo">
        </a>
        <nav class="navbar fixed-top"></nav>
    </header>

    <section class="container my-4">
        <div class="row d-flex justify-content-center">
            <form class="bg-white shadow-sm rounded-1 p-5 col-lg-6 col-md-8" id="sign-up-form" novalidate action="#">
                
                <div class="text-center">
                    <h1 class="h2">Regístrate</h1>
                    <p class="mb-4">para encontrar tu pastel favorito</p>
                </div>
                
                <hr class="mb-4">

                <div class="form-group text-center mb-4">
                    <div class="position-relative">
                        <label for="profile-picture" role="button" class="profile-picture-label text-white position-absolute rounded-circle"></label>
                        <img class="img img-fluid rounded-circle" id="picture-box" src="assets/img/blank-profile-picture.svg" alt="Profile picture">
                    </div>
                    <input type="file" accept="image/*" class="form-control shadow-none rounded-1 position-absolute" name="profilePicture" id="profile-picture" >
                </div>
                
                <div class="mb-4">
                    <label for="email" class="form-label" role="button">Correo electrónico</label>
                    <div class="input-group">
                        <input type="email" class="form-control shadow-none rounded-1" id="email" name="email" placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="username" class="form-label" role="button">Nombre de usuario</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" id="username" name="username" autocomplete="off" placeholder="Debe contener mínimo 3 caracteres">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="birth-date" class="form-label" role="button">Fecha de nacimiento</label>
                    <div class="input-group">
                        <input type="date" class="form-control shadow-none rounded-1" id="birth-date" name="birthDate">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="first-name" class="form-label" role="button">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" id="first-name" name="firstName">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="last-name" class="form-label" role="button">Apellido(s)</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" id="last-name" name="lastName">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="visibility" class="form-label" role="button">Visibilidad</label>
                    <div class="input-group">
                        <select class="form-select shadow-none rounded-1" name="visible" id="visibility" role="button">
                            <option value="">Seleccionar</option>
                            <option value="1">Público</option>
                            <option value="2">Privado</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" role="button">Sexo</label>
                    <div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="male" value="1">
                            <label class="form-check-label" for="male" role="button">Masculino</label>
                        </div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="female" value="2">
                            <label class="form-check-label" for="female" role="button">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="other" value="0">
                            <label class="form-check-label" for="other" role="button">Otro</label>
                        </div>  
                    </div>  
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label" role="button">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control shadow-none" name="password" id="password">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end shadow-none" id="btn-password"><i id="password-icon" class="fas fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <div>
                        <small>La contraseña debe contener:</small>
                        <ul>
                            <li class="pwd-length"><small>Al menos 8 caracteres</small></li>
                            <li class="pwd-uppercase"><small>Al menos una mayúscula</small></li>
                            <li class="pwd-lowercase"><small>Al menos una minuscula</small></li>
                            <li class="pwd-number"><small>Al menos un número</small></li>
                            <li class="pwd-specialchars"><small>Al menos un carácter especial</small></li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="confirm-password" class="form-label" role="button">Confirmar Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="confirmPassword" id="confirm-password" class="form-control shadow-none">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end shadow-none" id="btn-confirm-password"><i id="confirm-password-icon" class="fas fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-5">
                    <button type="input" class="btn btn-orange w-100 shadow-none rounded-1" id="btn-signup">Crear una cuenta</button>
                </div>

                <div class="text-center">
                    <p class="mb-0">¿Ya tienes cuenta?</p>
                    <a href="/login" class="d-block text-orange text-decoration-none">Inicia sesión ahora</a>
                </div>
            </form>
        </div>
    </section>

    @footer

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script type="module" src="./js/sign-up.js"></script>
</body>
</html>