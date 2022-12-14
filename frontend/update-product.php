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
    
    <!-- Multiple Select -->
    <link rel="stylesheet" href="vendor/node_modules/multiple-select/dist/multiple-select.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/product.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/create-product.css">
</head>
<body>
    @navbar

    <div class="container my-4">
        <div class="row d-flex justify-content-center">
            <form class="bg-white rounded-1 shadow-sm p-5 col-lg-8 col-md-6" action="#" id="product-edition-form">
                
                <h1 class="h2 text-center">Editar producto</h1>
                <hr class="mb-4">

                <div class="mb-4">
                    <label class="form-label" for="name" role="button">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control shadow-none rounded-1" name="name" id="name">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="description" role="button">Descripción</label>
                    <div class="input-group">
                        <textarea class="form-control shadow-none rounded-1" name="description" id="description" rows="5"></textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" role="button">Tipo de venta</label>
                    <div class="form-check">
                        <input class="custom-control-input form-check-input shadow-none" type="radio" name="type-of-sell" id="vender" value="0">
                        <label class="form-check-label" for="sell" role="button">Es para vender</label>
                    </div>
                    <div class="form-check">
                        <input class="custom-control-input form-check-input shadow-none" type="radio" name="type-of-sell" id="cotizar" value="1">
                        <label class="form-check-label" for="cotizar" role="button">Es para cotizar</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="price" role="button">Precio</label>
                    <div class="input-group">
                        <input type="number" min="0.00" max="10000.00" step="0.01" value="0.00" class="form-control shadow-none rounded-1" name="price" id="price">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="stock" role="button">Cantidad disponible</label>
                    <div class="input-group">
                        <input type="number" class="form-control shadow-none rounded-1" value="0" name="stock" id="stock">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="images-transfer" label="form-label" role="button">Imágenes (mínimo 3)</label>
                    <div class="input-group">
                        <label for="images-transfer" role="button" class="btn btn-primary rounded-1 w-100"><i class="fa fa-upload" aria-hidden="true"></i> Añadir imágenes</label>
                        <input type="file" class="form-control shadow-none position-absolute" style="scale: 0.01" name="images[]" id="images" multiple accept="image/*">
                        <input type="file" id="images-transfer" class="d-none" multiple accept="image/*">
                    </div>
                    <div class="my-4" style="overflow-x: scroll; width: 100%; white-space: nowrap;" id="image-list">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="video" class="form-label" role="button">Video</label>
                    <div class="input-group">
                        <label for="video" role="button" class="btn btn-success rounded-1 w-100"><i class="fa fa-upload" aria-hidden="true"></i> Añadir video</label>
                        <input type="file" class="form-control shadow-none position-absolute" style="scale: 0.01" name="video" id="video" multiple accept="video/*">
                    </div>
                    <div id="video-place" class="mt-3"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label tags-label" for="categories">Categorías</label>
                    <button type="button" class="btn btn-orange badge shadow-none ms-2" data-bs-toggle="modal" data-bs-target="#create-category">Crear categoría</button>
                    <div>
                        <select id="categories" name="categories[]" multiple="multiple" placeholder="Seleccionar" width="100%">
                        </select>
                    </div>
                </div>

                <input class="btn btn-orange text-light shadow-none rounded-1 w-100 mt-3" type="submit" value="Editar" id="submit">
                
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="create-category" tabindex="-1" aria-labelledby="create-category-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white rounded-1 border-0 shadow-sm">
                <form id="create-category-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-4">
                            <label for="category-name" class="form-label" role="button">Nombre</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" id="category-name" name="name" autocomplete="off">
                            </div>
                        </div>
    
                        <div class="mb-4">
                            <label for="category-description" class="form-label" role="button">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control shadow-none rounded-1" id="category-description" name="description" rows="5" placeholder="¿Qué productos contendrá?"></textarea>
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-gray rounded-1" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-orange rounded-1">Guardar</button>
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
    
    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <!-- Multiple Select -->
    <script src="vendor/node_modules/multiple-select/dist/multiple-select.min.js"></script>

    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>
    
    <script type="module" src="./js/update-product.js"></script>
</body>
</html>