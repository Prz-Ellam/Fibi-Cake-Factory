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
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/product.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body>
    @navbar

    <!-- Main Container -->
    <section class="container my-4">
        <div class="row d-flex justify-content-center">
            <div class="p-5 bg-white rounded shadow-sm form-card">
                <div class="text-center mb-4">
                    <h1 class="text-brown">Detalles de producto</h1>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-lg-6 p-5 align-self-center">
                        <img class="img-fluid zoom" id="zoom" src="./assets/img/E001S000026.jpg">
                        <div class="row">
                            <img class="img-fluid col-6 col-md-3" role="button" id="" src="./assets/img/E001S000026.jpg">
                            <img class="img-fluid col-6 col-md-3" role="button" id="" src="./assets/img/E001S000026.jpg">
                            <img class="img-fluid col-6 col-md-3" role="button" id="" src="./assets/img/E001S000026.jpg">
                            <img class="img-fluid col-6 col-md-3" role="button" id="" src="./assets/img/E001S000026.jpg">
                        </div>
                    </div>

                    <div class="col-lg-6 p-5">
                        <h2 class="fw-bold text-brown" id="name"></h2>
                        <h4 class="text-brown"><strong>Categoría:</strong><span id="category"></span></h4>
                        <p class="h4 text-brown" id="price"></p>

                        <div class="rating">
                            <i class="rating-star far fa-star" value="1"></i>
                            <i class="rating-star far fa-star" value="2"></i>
                            <i class="rating-star far fa-star" value="3"></i>
                            <i class="rating-star far fa-star" value="4"></i>
                            <i class="rating-star far fa-star" value="5"></i>
                        </div>

                        <hr>

                        <p class="fw-bold text-brown">Descripción:</p>
                        <p class="text-brown text-justify" id="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                        
                        <hr>

                        <div class="form-group">
                            <label class="text-brown">Cantidad</label>
                            <input type="number" value="1" min="1" max="100" class="quantity form-control shadow-none w-50 mb-4" id="quantity">
                        </div>

                        <div class="w-100 d-md-flex" >
                            <button class="ms-auto btn btn-md btn-orange shadow-none p-3 h5 me-3 w-100" id="add-cart"><i class="fas fa-shopping-cart me-1"></i> Agregar al carrito</button>
                            <button class="ms-auto btn btn-md btn-orange shadow-none p-3 h5 w-100" data-bs-toggle="modal" data-bs-target="#select-wishlist" id="add-wishlist"><i class="fa fa-heart"></i> Lista de deseos</button>
                        </div>     
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container bg-white my-5">
        <div class="p-3" id="section1">

            <div class="pt-4">
                <h2 class="text-center h2 text-brown">Comentarios</h2>
            </div>

            <hr>

            <textarea class="form-control rounded-1 shadow-none mb-3" id="message-box" placeholder="Escribe un comentario"></textarea>
            <button class="btn btn-orange rounded-1 shadow-none mb-4" id="send-message">Enviar</button>

            <div id="comment-section">
                <div class="d-flex">
                    <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
                    <div class="row">
                        <div class="col-9">
                            <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                            <span class="rating">
                                <i class="rating-star far fa-star" value="1"></i>
                                <i class="rating-star far fa-star" value="2"></i>
                                <i class="rating-star far fa-star" value="3"></i>
                                <i class="rating-star far fa-star" value="4"></i>
                                <i class="rating-star far fa-star" value="5"></i>
                            </span>
                            <p class="mb-0">Hola me gusta mucho este producto creo que es muy bueno</p>
                            <small>15 de enero de 2022 a las 03:46</small><br>
                            <span class="badge bg-primary" role="button">Editar</span>
                            <span class="badge bg-danger" role="button">Eliminar</span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex">
                    <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
                    <div class="row">
                        <div class="col-9">
                            <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                            <span class="rating">
                                <i class="rating-star far fa-star" value="1"></i>
                                <i class="rating-star far fa-star" value="2"></i>
                                <i class="rating-star far fa-star" value="3"></i>
                                <i class="rating-star far fa-star" value="4"></i>
                                <i class="rating-star far fa-star" value="5"></i>
                            </span>
                            <p class="mb-0">Hola me gusta mucho este producto creo que es muy bueno</p>
                            <small>15 de enero de 2022 a las 03:46</small><br>
                            <span class="badge bg-primary" role="button">Editar</span>
                            <span class="badge bg-danger" role="button">Eliminar</span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex">
                    <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
                    <div class="row">
                        <div class="col-9">
                            <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                            <span class="rating">
                                <i class="rating-star far fa-star" value="1"></i>
                                <i class="rating-star far fa-star" value="2"></i>
                                <i class="rating-star far fa-star" value="3"></i>
                                <i class="rating-star far fa-star" value="4"></i>
                                <i class="rating-star far fa-star" value="5"></i>
                            </span>
                            <p class="mb-0">Hola me gusta mucho este producto creo que es muy bueno</p>
                            <small>15 de enero de 2022 a las 03:46</small><br>
                            <span class="badge bg-primary" role="button">Editar</span>
                            <span class="badge bg-danger" role="button">Eliminar</span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex">
                    <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
                    <div class="row">
                        <div class="col-9">
                            <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                            <span class="rating">
                                <i class="rating-star far fa-star" value="1"></i>
                                <i class="rating-star far fa-star" value="2"></i>
                                <i class="rating-star far fa-star" value="3"></i>
                                <i class="rating-star far fa-star" value="4"></i>
                                <i class="rating-star far fa-star" value="5"></i>
                            </span>
                            <p class="mb-0">Hola me gusta mucho este producto creo que es muy bueno</p>
                            <small>15 de enero de 2022 a las 03:46</small><br>
                            <span class="badge bg-primary" role="button">Editar</span>
                            <span class="badge bg-danger" role="button">Eliminar</span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-flex">
                    <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
                    <div class="row">
                        <div class="col-9">
                            <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                            <span class="rating">
                                <i class="rating-star far fa-star" value="1"></i>
                                <i class="rating-star far fa-star" value="2"></i>
                                <i class="rating-star far fa-star" value="3"></i>
                                <i class="rating-star far fa-star" value="4"></i>
                                <i class="rating-star far fa-star" value="5"></i>
                            </span>
                            <p class="mb-0">Hola me gusta mucho este producto creo que es muy bueno</p>
                            <small>15 de enero de 2022 a las 03:46</small><br>
                            <span class="badge bg-primary" role="button">Editar</span>
                            <span class="badge bg-danger" role="button">Eliminar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-5">
        <div class="container bg-white" id="section1">
            <div class="pt-4">
                <h2 class="text-center h2 text-brown">También te podrían interesar</h2>
            </div>

            <hr>

            <div class="owl-carousel owl-theme sellers">
                <div class="item">
                    <div class="text-center car-prueba p-4 m-4 rounded">
                        <a href="/product"><img src="assets/img/IMG001.jpg" class="p-3"></a>
                        <h5 class="fw-bold price mb-0">$297.00</h5>
                        <p>Fresas con crema</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary shadow-none bg-orange rounded-1 me-1 add-cart">Agregar al carrito</button>
                            <button class="btn btn-danger shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="item">
                    <div class="bg-white text-center car-prueba m-4 p-3">
                        <a href="/product"><img src="assets/img/E001S007866.jpg" class="p-3"></a>
                        <h5 class="fw-bold price h6 mb-0">$297.00</h5>
                        <p>Bambino tentación de fresa</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary shadow-none bg-orange rounded-1 me-1 add-cart">Agregar al carrito</button>
                            <button class="btn btn-danger shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
                        </div>
                    </div>
                </div>
                    
                <div class="item">
                    <div class="bg-white text-center car-prueba m-4 p-3">
                        <a href="/product"><img src="assets/img/E001S011649.jpg" class="p-3"></a>
                        <h5 class="fw-bold price mb-0">$297.00</h5>
                        <p>Tentación de frutas</p>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary shadow-none bg-orange rounded-1 me-1 add-cart">Agregar al carrito</button>
                            <button class="btn btn-danger shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
                        </div>
                    </div>
                </div>  
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
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="./assets/img/E001S000031.jpg" class="img-fluid" alt="lay" style="max-width: 128px">
                                Navideños
                            </span>
                            <input class="custom-control-input form-check-input shadow-none me-1" type="checkbox" value="" aria-label="...">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="./assets/img/E001S000031.jpg" class="img-fluid" alt="lay" style="max-width: 128px">
                                Cumpleaños
                            </span>
                            <input class="custom-control-input form-check-input shadow-none me-1" type="checkbox" value="" aria-label="...">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="./assets/img/E001S000031.jpg" class="img-fluid" alt="lay" style="max-width: 128px">
                                Baby shower
                            </span>
                            <input class="custom-control-input form-check-input shadow-none me-1" type="checkbox" value="" aria-label="...">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="./assets/img/E001S000031.jpg" class="img-fluid" alt="lay" style="max-width: 128px">
                                Para año nuevo
                            </span>
                            <input class="custom-control-input form-check-input me-1" type="checkbox" value="" aria-label="...">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <img src="./assets/img/E001S000031.jpg" class="img-fluid" alt="lay" style="max-width: 128px">
                                Para Rex
                            </span>
                            <input class="custom-control-input form-check-input shadow-none me-1" type="checkbox" value="" aria-label="...">
                        </li>

                        <nav aria-label="Page navigation" class="mt-4 text-center d-flex justify-content-center">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Anterior</a></li>
                                <li class="page-item"><a class="page-link text-brown shadow-none" href="#">1</a></li>
                                <li class="page-item"><a class="page-link text-brown shadow-none" href="#">2</a></li>
                                <li class="page-item"><a class="page-link text-brown shadow-none" href="#">3</a></li>
                                <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Siguiente</a></li>
                            </ul>
                        </nav>
                    </ul>
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
    
    <!-- Elevate Zoom -->
    <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>
    
    <!-- Owl Carousel -->
    <script src="vendor/node_modules/owl.carousel/dist/owl.carousel.min.js"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <!-- JavaScript -->
    <script type="text/javascript" src="./js/product.js"></script>
</body>
</html>