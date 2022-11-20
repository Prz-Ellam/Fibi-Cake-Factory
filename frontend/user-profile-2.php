<?php

use CakeFactory\Repositories\UserRepository;

    $var = $_GET["id"];

    $userRepository = new UserRepository();
    $user = $userRepository->getOne($var);

?>

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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/footer.css">

    <link rel="stylesheet" href="./styles/colors.css">
</head>
<body>
    @navbar

    <section class="container my-4">
        <div class="row d-flex justify-content-center">
            <div class="bg-white rounded-1 p-sm-5 p-4 shadow-sm col-lg-12" id="profile-body">
                
                <!-- Media object -->
                <section class="w-100 px-3">
                    <div class="row d-flex justify-content-center justify-content-md-start">
                        <img
                            src=""
                            alt="Profile picture"
                            class="me-3 rounded-circle p-0 col-md-6 col-sm-12"
                            style="width: 128px; height: 128px;"
                            id="profile-picture"
                        >
                        <!-- Body -->
                        <div class="col-md-6 col-sm-12 p-0 text-center text-md-start">
                            <h1 class="h1" id="username"></h1>
                            <p class="h5" id="email"></p>
                            <p class="h5" id="name"></p>
                        </div>
                    </div>
                </section>
                <!-- Media object -->
                <!-- https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/bootstrap-media-objects.php#:~:text=Bootstrap%20media%20object%20has%20been,flex%20and%20spacing%20utility%20classes. -->
                    
                <hr class="mb-5">

                <?php
                    if ($user["visible"] === 0) {
                ?>                   
                    <div id="test-2" class="wishlist-container">
                        <h2 class="text-brown text-center"><i class="fas fa-lock"></i> Esta cuenta es privada</h2>
                    </div>
                <?php 
                    }
                    else {
                ?>

                <?php
                    switch($user["userRole"]) { 
                        case "Super Administrador":
                        case "Administrador":
                ?>

                <div>
                    <h1 class="text-brown text-center mb-4"> Productos autorizados</h1>

                    <div class="row" class="product-container" id="admin-products-container">
                    </div>
                    
                    <nav aria-label="Page navigation example">
                        <ul class="mt-4 pagination justify-content-center"></ul>
                    </nav>
                </div>

                <?php
                            break;
                        case "Vendedor":
                ?>

                <div id="test-3" class="wishlist-container">
                    
                    <ul class="nav nav-tabs mb-4" id="main-tab">
                        <li class="nav-item">
                            <a class="nav-link text-brown active" href="#">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-brown" href="#">Listas de deseos</a>
                        </li>
                    </ul>

                    <div class="row" id="seller-product-container">
                        <h1 class="text-brown text-center mb-4">Productos</h1>
                    </div>
                    <div class="row d-none" class="product-container" id="seller-wishlist-container">
                        <h1 class="text-brown text-center mb-4"><i class="fa fa-heart"></i> Listas de deseos</h1>
                    </div>
                    
                    <nav aria-label="Page navigation example">
                        <ul class="mt-4 pagination justify-content-center"></ul>
                    </nav>
                    
                </div>

                <?php
                            break;
                        case "Comprador":
                ?>
            
                <div id="test-4" class="wishlist-container">                    
                    <div class="row" class="product-container" id="customer-wishlist-container">
                        <h1 class="text-brown text-center mb-4"><i class="fa fa-heart"></i> Listas de deseos</h1>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="mt-4 pagination justify-content-center"></ul>
                    </nav>
                </div>

                <?php
                            break;
                    };
                }
                ?>
            </div>
        </div>
    </section>

    <div class="modal fade" id="select-wishlist" tabindex="-1" aria-labelledby="select-wishlist-label" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="add-wishlists">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="select-wishlist-label">¿A qué listas de deseos quieres añadir?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="wishlists-list">
                    </ul>
                    <nav aria-label="Page navigation" class="mt-4 text-center d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Anterior</a></li>
                            <li class="page-item"><a class="page-link text-brown shadow-none" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-brown shadow-none" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-brown shadow-none" href="#">3</a></li>
                            <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Siguiente</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-1 shadow-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-orange rounded-1 shadow-none">Aceptar</button>
                </div>
            </form>
        </div>
    </div>

    @footer
    
    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>

    <script type="module" src="js/others-user-profile.js"></script>
</body>
</html>
<!-- 600! -->