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
    
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/footer.css">

    <!-- jQuery 3.6.0 -->
    <script defer src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery Validation 1.19.5 -->
    <script defer src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script defer src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Sweet Alert -->
    <script defer src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <!-- Font Awesome -->
    <script defer src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <script defer type="module" src="./js/products.js"></script>
</head>
<body class="d-none">
    @navbar

    <div class="container my-4">
        <div class="row d-flex justify-content-center">
            <div class="bg-white rounded-1 shadow-sm p-sm-5 p-4 col-12">

                <h1 class="h1 text-center text-brown mb-4"><i class="fas fa-box"></i> Mis productos</h1>
                
                <ul class="nav nav-tabs mb-4" id="main-tab">
                    <li class="nav-item">
                        <a class="nav-link text-brown active" value="approved" aria-current="page" href="#">Publicados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-brown" value="pending" href="#">Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-brown" value="denied" href="#">Rechazados</a>
                    </li>
                </ul>
                
                <div class="row" id="products-container">
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Eliminar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas eliminar este producto?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-gray shadow-none rounded-1" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-red shadow-none rounded-1" id="btn-delete-product" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    @footer

</body>
</html>