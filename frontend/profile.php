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
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/profile-picture.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body>
    @navbar

    <!-- Main container -->
    <div class="container my-4">
        <div class="row d-flex justify-content-center">
            <form class="form bg-white rounded p-5 col-xl-6 col-lg-6 col-md-7" id="profile-form" novalidate>
                <h1 class="form-title text-center h2 mb-4">Perfil</h1>

                <hr class="mb-4">

                <div class="form-group text-center mb-4">
                    <div class="position-relative">
                        <label for="profile-picture" role="button" class="profile-picture-label text-white position-absolute rounded-circle"></label>
                        <img style="width: 156px; height: 156px; object-fit:cover;" class="img-fluid rounded-circle" id="picture-box" src="assets/img/blank-profile-picture.svg">
                    </div>
                    <input type="file" class="form-control shadow-none rounded-1 position-absolute" style="scale: 0.01" name="profile-picture" id="profile-picture" accept="image/*">
                </div>

                <div class="mb-4">
                    <label class="form-linputabel" for="email">Correo electrónico</label>
                    <div class="input-group">
                        <input type="email" class="form-control shadow-none rounded-1" name="email" id="email" placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="name">Nombre de usuario</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" name="username" id="username" autocomplete="off">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="birth-date">Fecha de nacimiento</label>
                    <div class="input-group">
                        <input type="date" class="form-control shadow-none rounded-1" name="birth-date" id="birth-date">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="first-name">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" name="first-name" id="first-name">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="last-name">Apellido(s)</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" name="last-name" id="last-name">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" role="button">Sexo</label>
                    <div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="male">
                            <label class="form-check-label" for="male" role="button">Masculino</label>
                        </div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="female">
                            <label class="form-check-label" for="female" role="button">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input class="custom-control-input form-check-input shadow-none" type="radio" name="gender" id="other">
                            <label class="form-check-label" for="other" role="button">Otro</label>
                        </div>  
                    </div>  
                </div>

                <div class="form-group mb-4">
                    <label style="visibility:hidden">A</label>
                    <input type="submit" value="Editar" class="btn btn-primary bg-orange w-100 shadow-none" id="btn-login">
                </div>

            </form>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-white">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">¿Olvidaste tu contraseña?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¡No te preocupes!</p><p>Ingresa tu correo electrónico y te mandaremos un enlace para que puedas reestablecer tu contraseña</p>
                            
                            <form>
                                <div class="form-group mb-4">
                                    <label class="form-label" for="email">Correo electrónico</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control rounded shadow-none" name="email" id="resetEmail" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>
                            </form>
                            
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Main container -->
        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <form class="form bg-white shadow-sm rounded p-5 col-xl-6 col-lg-6 col-md-7" id="password-form" method="get" action="#" novalidate>                        <!-- Inputs -->
                    <div class="mb-4">
                        <h1 class="form-title text-center h2">Cambiar contraseña</h1>
                    </div>

                    <hr class="mb-4">

                    <div class="form-group mb-4">
                        <label class="form-label" for="old-password" role="button">Antigua contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none" name="old-password" id="old-password">
                            <div class="input-group-append">
                                <button type="button" style="width: 48px !important" class="btn bg-orange text-white input-group-text shadow-none rounded-0 rounded-end shadow-none btn-password" id="btn-old-password"><i id="password-icon" class="fas fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="new-password" role="button">Nueva contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none" name="new-password" id="new-password">
                            <div class="input-group-append">
                                <button type="button" style="width: 48px !important" class="btn bg-orange text-white input-group-text shadow-none rounded-0 rounded-end shadow-none btn-password" id="btn-new-password"><i id="password-icon" class="fas fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                        <div>
                            <small>La contraseña debe contener al menos:</small>
                            <ul>
                                <li class="pwd-length"><small>Al menos 8 caracteres</small></li>
                                <li class="pwd-uppercase"><small>Al menos una mayúscula</small></li>
                                <li class="pwd-lowercase"><small>Al menos una minuscula</small></li>
                                <li class="pwd-number"><small>Al menos un número</small></li>
                                <li class="pwd-specialchars"><small>Al menos un carácter especial</small></li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="confirm-new-password" role="button">Confirmar nueva contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control shadow-none" name="confirm-new-password" id="confirm-new-password">
                            <div class="input-group-append">
                                <button type="button" style="width: 48px !important" class="btn bg-orange text-white input-group-text shadow-none rounded-0 rounded-end shadow-none btn-password" id="btn-confirm-new-password"><i id="password-icon" class="fas fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label style="visibility:hidden">A</label>
                        <input type="submit" value="Editar" class="btn btn-primary bg-orange w-100 shadow-none" id="btn-change-password">
                    </div>
                </form>
        </div>
    </div>

    @footer

    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery Validation 1.19.5 -->
    <script src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <!-- JavaScript -->
    <script type="module" src="./js/profile.js"></script>
</body>
</html>