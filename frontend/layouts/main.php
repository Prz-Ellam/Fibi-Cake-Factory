<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Factory</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Nunito&family=Roboto:ital,wght@0,400;1,500&display=swap" rel="stylesheet">
     
    <!-- Bootstrap 5.0.0 -->
    <link rel="stylesheet" href="vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Intro JS -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body>
    <header class="fixed-top sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar px-3">
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
                <ul class="navbar-nav" id="orange-navbar">
                    <li class="nav-item">
                        <a href="/chat" class="me-3 primary-nav-item nav-link text-white fw-bold">
                            <i class="fa fa-bell"></i>
                            <!--<span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger">1</span>-->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/wishlists" class="me-3 primary-nav-item nav-link text-white fw-bold">
                            <i class="fa fa-heart"></i>
                            <!--<span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger">1</span>-->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/shopping-cart" class="me-3 primary-nav-item nav-link text-white fw-bold">
                            <i class="fas fa-shopping-cart"></i>
                            <!--<span class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger">3</span>-->
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="" alt="logo" class="img-fluid rounded-circle" style="width:32px; height:32px">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-white rounded-1 shadow-sm">
                            <a href="/profile" class="dropdown-item">Mi perfil</a>
                            <div class="dropdown-divider"></div>
                            <a href="/products" class="dropdown-item">Mis productos</a>
                            <div class="dropdown-divider"></div>
                            <a href="/logout" class="dropdown-item" id="close-session">Cerrar sesión</a>
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
        </nav>
    </header>

    @content

    <!-- Footer -->
    <footer class="page-footer p-5">
        <div class="container-fluid">
            <div class="row text-md-start text-center">
                <div class="col-md-3 mx-auto mb-3">
                    <ul class="list-unstyled">
                        <li class="my-2">
                            <a href="/home"><img src="assets/img/logo.svg" class="img-fluid" id="logo-banner" alt="Logo Banner"></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 mx-auto mb-3">
                    <h5 class="text-uppercase mb-4 text-cream fw-bold">Recursos</h5>
                    <ul class="list-unstyled">
                        <li class="my-2"><a href="#" class="text-cream text-decoration-none">Acerca de nosotros</a><br></li>
                        <li class="my-2"><a href="#" class="text-cream text-decoration-none">Contáctanos</a><br></li>
                        <li class="my-2"><a href="#" class="text-cream text-decoration-none">Preguntas frecuentes</a><br></li>
                    </ul>
                </div>
                <div class="col-md-3 mx-auto mb-3">
                    <h5 class="text-uppercase mb-4 text-cream fw-bold">Políticas</h5>
                    <ul class="list-unstyled">
                        <li class="my-2"><a href="#" class="text-cream text-decoration-none">Política de reembolsos</a><br></li>
                        <li class="my-2"><a href="#" class="text-cream text-decoration-none">Política de privacidad</a><br></li>
                    </ul>
                </div>
                <div class="col-md-3 mx-auto mb-3">
                    <h5 class="text-uppercase mb-4 text-cream fw-bold">Contacto</h5>
                    <ul class="list-unstyled">
                        <li class="my-2">
                            <a href="https://www.facebook.com" target="_blank" class="text-cream text-decoration-none">
                                <i class="fab fa-facebook-f text-cream me-3 h4"></i>Facebook
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="https://www.instagram.com" target="_blank" class="text-cream text-decoration-none">
                                <i class="fa fa-instagram text-cream me-3 h4" aria-hidden="true"></i>Instagram
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="tel:(00)00000000" class="text-cream text-decoration-none">
                                <i class="fa fa-phone text-cream me-3 h4"></i>(00)-0000-0000
                            </a>
                        </li>
                        <li class="my-2">
                            <a href="mailto:cakefactory@gmail.com.mx" class="text-cream text-decoration-none">
                                <i class="fa fa-envelope text-cream me-3 h4"></i>Correo electrónico
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="row pt-5 pb-3 d-flex align-items-center">
                    <div class="col-md-12  text-center">
                        <svg class="payment-icon" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="38" height="24" aria-labelledby="pi-american_express"><title id="pi-american_express">American Express</title><g fill="none"><path fill="#000" d="M35,0 L3,0 C1.3,0 0,1.3 0,3 L0,21 C0,22.7 1.4,24 3,24 L35,24 C36.7,24 38,22.7 38,21 L38,3 C38,1.3 36.6,0 35,0 Z" opacity=".07"/><path fill="#006FCF" d="M35,1 C36.1,1 37,1.9 37,3 L37,21 C37,22.1 36.1,23 35,23 L3,23 C1.9,23 1,22.1 1,21 L1,3 C1,1.9 1.9,1 3,1 L35,1"/><path fill="#FFF" d="M8.971,10.268 L9.745,12.144 L8.203,12.144 L8.971,10.268 Z M25.046,10.346 L22.069,10.346 L22.069,11.173 L24.998,11.173 L24.998,12.412 L22.075,12.412 L22.075,13.334 L25.052,13.334 L25.052,14.073 L27.129,11.828 L25.052,9.488 L25.046,10.346 L25.046,10.346 Z M10.983,8.006 L14.978,8.006 L15.865,9.941 L16.687,8 L27.057,8 L28.135,9.19 L29.25,8 L34.013,8 L30.494,11.852 L33.977,15.68 L29.143,15.68 L28.065,14.49 L26.94,15.68 L10.03,15.68 L9.536,14.49 L8.406,14.49 L7.911,15.68 L4,15.68 L7.286,8 L10.716,8 L10.983,8.006 Z M19.646,9.084 L17.407,9.084 L15.907,12.62 L14.282,9.084 L12.06,9.084 L12.06,13.894 L10,9.084 L8.007,9.084 L5.625,14.596 L7.18,14.596 L7.674,13.406 L10.27,13.406 L10.764,14.596 L13.484,14.596 L13.484,10.661 L15.235,14.602 L16.425,14.602 L18.165,10.673 L18.165,14.603 L19.623,14.603 L19.647,9.083 L19.646,9.084 Z M28.986,11.852 L31.517,9.084 L29.695,9.084 L28.094,10.81 L26.546,9.084 L20.652,9.084 L20.652,14.602 L26.462,14.602 L28.076,12.864 L29.624,14.602 L31.499,14.602 L28.987,11.852 L28.986,11.852 Z"/></g></svg>
                        <svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-master"><title id="pi-master">Mastercard</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><circle fill="#EB001B" cx="15" cy="12" r="7"/><circle fill="#F79E1B" cx="23" cy="12" r="7"/><path fill="#FF5F00" d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z"/></svg>
                        <svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal"><title id="pi-paypal">PayPal</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z"/><path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z"/><path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z"/></svg>
                        <svg class="payment-icon" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-visa"><title id="pi-visa">Visa</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path d="M28.3 10.1H28c-.4 1-.7 1.5-1 3h1.9c-.3-1.5-.3-2.2-.6-3zm2.9 5.9h-1.7c-.1 0-.1 0-.2-.1l-.2-.9-.1-.2h-2.4c-.1 0-.2 0-.2.2l-.3.9c0 .1-.1.1-.1.1h-2.1l.2-.5L27 8.7c0-.5.3-.7.8-.7h1.5c.1 0 .2 0 .2.2l1.4 6.5c.1.4.2.7.2 1.1.1.1.1.1.1.2zm-13.4-.3l.4-1.8c.1 0 .2.1.2.1.7.3 1.4.5 2.1.4.2 0 .5-.1.7-.2.5-.2.5-.7.1-1.1-.2-.2-.5-.3-.8-.5-.4-.2-.8-.4-1.1-.7-1.2-1-.8-2.4-.1-3.1.6-.4.9-.8 1.7-.8 1.2 0 2.5 0 3.1.2h.1c-.1.6-.2 1.1-.4 1.7-.5-.2-1-.4-1.5-.4-.3 0-.6 0-.9.1-.2 0-.3.1-.4.2-.2.2-.2.5 0 .7l.5.4c.4.2.8.4 1.1.6.5.3 1 .8 1.1 1.4.2.9-.1 1.7-.9 2.3-.5.4-.7.6-1.4.6-1.4 0-2.5.1-3.4-.2-.1.2-.1.2-.2.1zm-3.5.3c.1-.7.1-.7.2-1 .5-2.2 1-4.5 1.4-6.7.1-.2.1-.3.3-.3H18c-.2 1.2-.4 2.1-.7 3.2-.3 1.5-.6 3-1 4.5 0 .2-.1.2-.3.2M5 8.2c0-.1.2-.2.3-.2h3.4c.5 0 .9.3 1 .8l.9 4.4c0 .1 0 .1.1.2 0-.1.1-.1.1-.1l2.1-5.1c-.1-.1 0-.2.1-.2h2.1c0 .1 0 .1-.1.2l-3.1 7.3c-.1.2-.1.3-.2.4-.1.1-.3 0-.5 0H9.7c-.1 0-.2 0-.2-.2L7.9 9.5c-.2-.2-.5-.5-.9-.6-.6-.3-1.7-.5-1.9-.5L5 8.2z" fill="#142688"/></svg> 
                    </div>
                </div>
            </div>
            <div class="container text-center img-responsive">
                <p class="text-cream mb-0">© 2022 Pastelería Cake Factory. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>

    <!-- jQuery Validation 1.19.5 -->
    <script src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>

    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Intro JS -->
    <script src="https://unpkg.com/intro.js/minified/intro.min.js" type="text/javascript"></script>

    <!-- Owl Carousel -->
    <script src="vendor/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- JavaScript -->
    <script type="text/javascript" src="./js/home.js"></script>
</body>
</html>