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
    
    <!-- Data Tables Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <link rel="stylesheet" href="./styles/admin.css">
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/profile-picture.css">

    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <div class="main-container d-flex">
        @sidebar
        <div class="content">
            <div class="container m-0 card">
                <div class="row d-flex justify-content-center">
                    <div class="bg-white p-4 col-12">

                        <button class="btn d-inline d-sm-none position-relative btn-side-bar"><i class="fas fa-bars"></i></button>

                        <div class="text-center text-brown">
                            <h1><i class="fa fa-user"></i> Usuarios</h1>
                        </div>
                        
                        <hr>
                        
                        <div class="table-responsive p-1">
                            <div class="d-flex justify-content-end">
                        
                            <button class="btn btn-success shadow-none mb-2 rounded-1" data-bs-toggle="modal" data-bs-target="#add-user"><i class="fa fa-user-plus"></i> Agregar usuario</button>
                            </div>
                            <table class="table table-hover" id="table-users">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Correo electrónico</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-user" tabindex="-1" aria-labelledby="add-user-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-sm">
                <form id="admin-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="add-user-label">Agregar administrador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group text-center mb-4">
                            <div class="position-relative">
                                <label for="profile-picture" role="button" class="profile-picture-label text-white position-absolute rounded-circle"></label>
                                <img class="img img-fluid rounded-circle" id="picture-box" src="assets/img/blank-profile-picture.svg">
                            </div>
                            <input type="file" accept="image/*" class="form-control shadow-none rounded-1 position-absolute" name="profilePicture" id="profile-picture" >
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label" for="email" role="button">Correo electrónico</label>
                            <div class="input-group">
                                <input type="email" class="form-control shadow-none rounded-1" name="email" id="add-email" placeholder="ejemplo@correo.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="username" role="button">Nombre de usuario</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="username" id="add-username" autocomplete="off" placeholder="Debe contener mínimo 3 caracteres">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="birth-date" role="button">Fecha de nacimiento</label>
                            <div class="input-group">
                                <input type="date" class="form-control shadow-none rounded-1" name="birthDate" id="add-birth-date">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="first-name" role="button">Nombre</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="firstName" id="add-first-name">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="last-name" role="button">Apellido(s)</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="lastName" id="add-last-name">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="visibility" role="button">Visibilidad</label>
                            <div class="input-group">
                                <select class="form-select shadow-none rounded-1" name="visible" id="add-visibility" role="button">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Público</option>
                                    <option value="2">Privado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" role="button">Sexo</label>
                            <div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="gender" id="add-male" value="1">
                                    <label class="form-check-label" for="add-male" role="button">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="gender" id="add-female" value="2">
                                    <label class="form-check-label" for="add-female" role="button">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="gender" id="add-other" value="0">
                                    <label class="form-check-label" for="add-other" role="button">Otro</label>
                                </div>  
                            </div>  
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="password" role="button">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none" name="password" id="password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end" id="btn-password">
                                        <i id="add-password-icon" class="fas fa-solid fa-eye"></i></button>
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
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="confirm-password" role="button">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="confirmPassword" id="add-confirm-password" class="form-control shadow-none">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end" id="btn-confirm-password">
                                        <i id="add-confirm-password-icon" class="fas fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group mb-4 mt-5">
                            <button type="input" class="btn btn-orange w-100 shadow-none rounded-1" id="btn-create">Crear una cuenta</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-sm">
                <form id="edit-user-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Editar administrador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group text-center mb-4">
                            <div class="position-relative">
                                <label for="profile-picture" role="button" class="profile-picture-label text-white position-absolute rounded-circle"></label>
                                <img class="img img-fluid rounded-circle" id="edit-picture-box" src="assets/img/blank-profile-picture.svg">
                            </div>
                            <input type="file" accept="image/*" class="form-control shadow-none rounded-1 position-absolute" name="profile-picture" id="edit-profile-picture" >
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label" for="email" role="button">Correo electrónico</label>
                            <div class="input-group">
                                <input type="email" class="form-control shadow-none rounded-1" name="email" id="edit-user-email" placeholder="ejemplo@correo.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="username" role="button">Nombre de usuario</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="username" id="edit-user-username" autocomplete="off" placeholder="Debe contener mínimo 3 caracteres">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="birth-date" role="button">Fecha de nacimiento</label>
                            <div class="input-group">
                                <input type="date" class="form-control shadow-none rounded-1" name="birth-date" id="edit-user-birth-date">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="first-name" role="button">Nombre</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="first-name" id="edit-user-first-name">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="last-name" role="button">Apellido(s)</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="last-name" id="edit-user-last-name">
                            </div>
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="visibility" role="button">Visibilidad</label>
                            <div class="input-group">
                                <select class="form-select shadow-none rounded-1" name="visibility" id="visibility" role="button">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Público</option>
                                    <option value="2">Privado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" role="button">Sexo</label>
                            <div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="edit-user-gender" id="edit-male" value="1">
                                    <label class="form-check-label" for="edit-male" role="button">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="edit-user-gender" id="edit-female" value="2">
                                    <label class="form-check-label" for="edit-female" role="button">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="custom-control-input custom-control-input form-check-input shadow-none" type="radio" name="edit-user-gender" id="edit-other" value="0">
                                    <label class="form-check-label" for="edit-other" role="button">Otro</label>
                                </div>  
                            </div>  
                        </div>
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="password" role="button">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none" name="password" id="edit-password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end" id="btn-edit-password">
                                        <i id="edit-password-icon" class="fas fa-solid fa-eye"></i>
                                    </button>
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
        
                        <div class="form-group mb-4">
                            <label class="form-label" for="confirm-password" role="button">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" name="confirm-password" id="edit-confirm-password" class="form-control shadow-none">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-orange btn-password input-group-text shadow-none rounded-0 rounded-end" id="btn-edit-confirm-password">
                                        <i id="edit-confirm-password-icon" class="fas fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-group mb-4 mt-5">
                            <button type="input" class="btn btn-orange w-100 shadow-none rounded-1" id="btn-signup">Crear una cuenta</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Eliminar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-user" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery Validation 1.19.5 -->
    <script src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    
    <!-- jQuery DataTable -->
    <script src="http://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
   
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="./js/users.js"></script>
</body>
</html>