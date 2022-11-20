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
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body class="d-none">
    @navbar

    <section class="container my-4">
        <div class="row d-flex justify-content-center">
            <div class="bg-white rounded-1 p-sm-5 p-4 col-12" id="search-container">
                    
                <h1 class="h2 text-brown text-center mb-4">Resultados de la búsqueda</h2>

                <ul class="nav nav-tabs mb-4" id="main-tab">
                    <li class="nav-item">
                        <a class="nav-link text-brown active" aria-current="page" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-brown" href="#">Usuarios</a>
                    </li>
                </ul>
                
                <div id="products-section">
                    <div class="row d-flex justify-content-between">
                        <div class="col-12 col-md-6">
                            <div class="input-group mb-3">
                                <select class="form-select shadow-none" name="categories" id="categories">
                                    <option value="1">Categorías</option>
                                </select>
                                <input type="text" class="form-control shadow-none" placeholder="Producto" aria-label="Username" aria-describedby="basic-addon1" id="product-search">
                                <button class="btn btn-primary bg-orange shadow-none"><i class="fas fa-search text-white"></i></button>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group mb-3">
                                <select class="form-select shadow-none" id="sortings">
                                    <option>Filtros</option>
                                    <option value="sells asc">Los más vendidos</option>
                                    <option value="sells desc">Los menos vendidos</option>
                                    <option value="price asc">Precio: de más bajo a más alto</option>
                                    <option value="price desc">Precio: de más alto a más bajo</option>
                                    <option value="rates desc">Los mejor calificados</option>
                                    <option value="alpha asc">Alfabeticamente de la A a la Z</option>
                                    <option value="alpha desc">Alfabeticamente de la Z a la A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" id="product-search-container">
                    </div>
                        
                </div>

                <div class="row d-none" id="users-section">
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="mt-4 pagination justify-content-center">
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Anterior</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Siguiente</a></li>
                    </ul>
                </nav>

            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <!-- JavaScript -->
    <script type="module" src="./js/search.js"></script>
</body>
</html>