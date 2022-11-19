<?php

    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Factory</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto:ital,wght@0,400;1,500&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,700,1,0">

    <!-- Bootstrap 5.0.0 -->
    <link rel="stylesheet" href="vendor/node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Material+Icons&display=swap">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/profile-picture.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/create-product.css">
</head>
<body>
    @navbar

    <div class="container my-4">
        <div class="row d-flex justify-content-center">
            <div class="bg-white shadow-sm p-sm-5 p-4 rounded-1 col-12">

                <h1 class="text-center text-brown mb-4"><i class="fa fa-heart"></i> Listas de deseos</h1>
                <hr class="mb-4">

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-success shadow-none mb-4 rounded-1 create-wishlist"><i class="fa fa-heart"></i> Agregar lista</button>
                </div>

                <div class="row" id="wishlist-container">
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="mt-4 pagination justify-content-center">
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="/wishlists">Anterior</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="/wishlists?page=1">1</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="/wishlists?page=2">2</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="/wishlists">3</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="/wishlists">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="wishlist-modal" role="dialog" tabindex="-1" aria-labelledby="create-wishlist-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-1 bg-white border-0">
                <form id="wishlist-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title h4" id="wishlist-modal-label">Agregar lista de deseos</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-4">
                            <label for="images-transfer" label="form-label" role="button">Imágenes</label>
                            <div class="input-group">
                                <label for="images-transfer" role="button" class="btn btn-blue rounded-1 w-100"><i class="fa fa-upload" aria-hidden="true"></i> Añadir imágenes</label>
                                <input type="file" class="position-absolute" style="scale: 0.01" name="images[]" id="images" accept="image/*" multiple>
                                <input type="file" class="d-none" id="images-transfer" accept="image/*" multiple>
                            </div>
                            <div class="my-4" style="overflow-x: scroll; width: 100%; white-space: nowrap;" id="image-list">
                        </div>
                        </div>
                         
                        <div class="mb-4">
                            <label class="form-label" for="wishlist-name" role="button">Nombre</label>
                            <div class="input-group">
                                <input class="form-control shadow-none rounded-1" type="text" name="name" id="wishlist-name">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="wishlist-description" role="button">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control shadow-none rounded-1" type="text" name="description" id="wishlist-description" rows="5"></textarea>    
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="wishlist-visibility" role="button">Visibilidad</label>
                            <div class="input-group">
                                <select class="form-select shadow-none rounded-1" name="visible" id="wishlist-visible">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Pública</option>
                                    <option value="0">Privada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gray shadow-none rounded-1" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-orange shadow-none rounded-1" id="submit-wishlist">Guardar</button>
                    </div>
                </form>
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
    
    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <!-- Handlebars -->
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Script -->
    <script type="module" src="./js/wishlists.js"></script>
</body>
</html>