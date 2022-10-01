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
    
    <!-- Data Tables Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="vendor/node_modules/sweetalert2/dist/sweetalert2.min.css">
    
    <link rel="stylesheet" href="styles/admin.css">
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

                        <h1 class="text-center text-brown">Aprobar productos agregados</h1>
                        
                        <div class="table-responsive p-1">
                            <table class="table table-hover" id="table-products">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Acciones</th>
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

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <script type="text/javascript" src="js/approve-products.js"></script>
</body>
</html>