<?php

use CakeFactory\Repositories\UserRepository;
use Fibi\Session\PhpSession;

$session = new PhpSession();
$userId = $session->get("userId");
if (!$userId) return;

$userRepository = new UserRepository();
$user = $userRepository->getOne($userId);

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
    
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/chat.css">
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="d-flex flex-column h-100">

            <header class="row fixed-top sticky-top">
                <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar">
                    <a class="navbar-brand ms-2" href="/"><img src="assets/img/Brand-Logo.svg" id="brand-logo"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse me-auto" id="navbar-collapse">
                        <form class="form-inline ms-xl-5 me-lg-auto w-50" id="search-box" action="/search">
                            <div class="input-group w-100">
                                <input type="search" class="form-control search shadow-none" name="search" id="search" placeholder="Buscar en Cake Factory">
                                <div class="input-group-append">
                                    <button class="btn bg-white search-btn shadow-none" type="submit" id="search-btn"><i class="fas fa-search text-secondary"></i></button>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav align-items-center" id="orange-navbar">
                            <li class="nav-item">
                                <a href="/chat" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                                    <i class="fa fa-bell"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/wishlists" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                                    <i class="fa fa-heart"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/shopping-cart" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/api/v1/images/<?= $user["profilePicture"] ?>" alt="logo" class=" img-fluid rounded-circle" style="width:32px; height:32px">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end bg-white rounded-1 shadow-sm">
                                    <a href="/profile" class="dropdown-item">Mi perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <?php if ($user["visible"] && $user["userRole"] == "Vendedor"): ?>
                                    <a href="/products" class="dropdown-item">Mis productos</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="/quotes" class="dropdown-item">Cotizaciones</a>
                                    <div class="dropdown-divider"></div>
                                    <?php endif ?>
                                    <a href="/logout" class="dropdown-item" id="close-session">Cerrar sesi??n</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <nav class="navbar navbar-expand-md bg-white navbar-dark shadow-sm">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#subnavbar-collapse">
                        <i class="fa fa-bars text-brown"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="subnavbar-collapse">
                        <ul class="navbar-nav ms-2">
                            <li class="nav-item">
                                <a class="nav-link ms-1 me-4 p-1 text-brown" href="/home">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 p-1 text-brown" href="/create-product">Vender</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 p-1 text-brown" href="/sales-report">Reporte de ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link me-4 p-1 text-brown" href="/orders-report">Reporte de compras</a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-block d-md-none form-check form-switch shadow-none mx-2">
                        <input class="form-check-input shadow-none" type="checkbox" id="chat-messages" checked>
                        <label class="form-check-label" for="chat-messages">Chats/Mensajes</label>
                    </div>
                </nav>
            </header>
                    
            <div class="row h-100 overflow-auto">   
      
                <div class="d-md-block d-none col-12 col-md-3 card rounded-0 bg-white overflow-auto h-100 py-3" id="chats-container">
                    <input type="search" name="" class="form-control rounded-1 shadow-none mb-3" id="search-users" placeholder="Buscar personas">
                </div>

                <div class="bg-white card col-12 col-md-9 rounded-0 overflow-auto h-100" id="messages-container">
                
                    <div class="d-flex justify-content-between mt-3">
                        <div class="d-block text-decoration-none text-brown" id="user-label">
                            <span class="ms-2 text-black"><b id="chat-name"></b></span>
                        </div>
                    </div>
    
                    <hr>
    
                    <div class="overflow-auto p-2 h-100" id="comment-box"></div>
                            
                    <hr class="text-light">

                    <div class="input-group mb-3">
                        <input id="message" type="text" class="form-control shadow-none" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <button class="btn btn-orange shadow-none" id="send-message">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                            
    @footer

    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery Validation 1.19.5 -->
    <script src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>

    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>
 
    <!-- JavaScript -->
    <script type="text/javascript" src="js/chat.js"></script>
</body>
</html>