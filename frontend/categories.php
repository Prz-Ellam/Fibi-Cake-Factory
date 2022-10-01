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
    
    <!-- Data Tables Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <link rel="stylesheet" href="./styles/admin.css">
    <link rel="stylesheet" href="styles/colors.css">
</head>
<body>
    <div class="main-container d-flex">
        @sidebar
        <div class="content">
            <div class="container m-0 card">
                <div class="row d-flex justify-content-center">
                    <div class="bg-white p-4 col-12">
                        <button class="btn d-inline d-sm-none position-relative btn-side-bar"><i class="fas fa-bars"></i></button>

                        <h1 class="text-brown text-center">
                            <span class="h2 material-symbols-rounded">category</span>
                            <span>Categorias</span>
                        </h1>
                        <hr>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success shadow-none mb-2 rounded-1" data-bs-toggle="modal" data-bs-target="#create-category">Agregar categorias</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="categories">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
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

    <!-- Crear categoria -->
    <div class="modal fade" id="create-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-1 bg-white border-0">
                <form id="create-category-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar categoría</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-4">
                            <label class="form-label" for="create-category-name" role="button">Nombre</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="name" id="create-category-name" autocomplete="off">
                            </div>
                        </div>
    
                        <div class="mb-4">
                            <label class="form-label" for="create-category-description" role="button">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control shadow-none rounded-1" name="description" id="create-category-description" rows="5" placeholder="¿Qué productos contendrá?"></textarea>
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-gray shadow-none rounded-1" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-orange shadow-none rounded-1">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Editar categoria -->
    <div class="modal fade" id="edit-category" tabindex="-1" aria-labelledby="edit-category-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-1 bg-white border-0">
                <form id="edit-category-form">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="edit-category-label">Editar categoría</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-4">
                            <label class="form-label" for="category-name" role="button">Nombre</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-1" name="category-name" id="edit-category-name" autocomplete="off">
                            </div>
                        </div>
    
                        <div class="mb-4">
                            <label class="form-label" for="category-description" role="button">Descripción</label>
                            <div class="input-group">
                                <textarea class="form-control shadow-none rounded-1" name="category-description" id="edit-category-description" rows="5" placeholder="¿Qué productos contendrá?"></textarea>
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-gray shadow-none rounded-1" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-orange shadow-none rounded-1">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Eliminar producto</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar este producto?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-gray rounded-1 shadow-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-red rounded-1 shadow-none delete-category" id="btn-delete-product">Aceptar</button>
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
    
    <!-- jQuery DataTable -->
    <script src="http://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
   
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/categories.js"></script>
</body>
</html>