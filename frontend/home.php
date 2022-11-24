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

@navbar

<div id="banner">
    <div class="cte">
        <h1 class="text-center text-white text-uppercase font-weight-bold mb-4" id="hero-title">¡Conquistando el sabor supremo!</h1>
        <hr class="bg-white">
        <p class="text-white h4 mb-4">Pasteles únicos y variados todos los días</p>
        <a href="/search" class="btn btn-md btn-secondary shadow-none p-3 btn-orange h5 start-shop rounded-1" id="start-shop">Empezar a comprar <i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </div>
</div>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="container-recomendations">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Basado en tus gustos</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="favorites">
        </div>
    </div>
</section>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los mejor calificados</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="rates">
        </div>
    </div>
</section>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los favoritos de nuestros visitantes</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="sellers">
        </div>
    </div>
</section>

<!--
<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los mejor calificados</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="stars"></div>
    </div>
</section>
-->

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Nuevos lanzamientos</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="recents"></div>
    </div>
</section>

<div class="modal fade" id="select-wishlist" tabindex="-1" aria-labelledby="select-wishlist-label" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="add-wishlists">
            <input type="hidden" name="product-id" id="wishlist-product-id" value="">
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