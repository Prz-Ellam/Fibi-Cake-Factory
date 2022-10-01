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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/footer.css">
    <link rel="stylesheet" href="./styles/colors.css">
</head>
<body>
    @navbar

    <div class="container-fluid my-4 bg-white p-4">

        <h1 class="h2 text-center">Reporte de ventas</h1>
        <hr>

        <div class="row gy-2 gx-3 align-items-center">
            <div class="col-auto">
                <label for="from" class="">Categorías:</label>
                <select class="form-select shadow-none rounded-1">
                    <option>Categoria</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="from" class="">Desde:</label>
                <input type="date" class="form-control shadow-none rounded-1" name="from" id="from">
            </div>
            <div class="col-auto">
                <label for="to">Hasta:</label>
                <input type="date" class="form-control shadow-none rounded-1" name="to" id="to">
            </div>
        </div>

        <br>

        <div class="table-responsive">
            <table class="table table-hover" style="width: 100%" id="detailed-sales-report">
                <thead class="bg-orange text-light">
                    <tr>
                        <th>Fecha y hora de la venta</th>
                        <th>Categoría</th>
                        <th>Producto</th>
                        <th>Calificación</th>
                        <th>Precio</th>
                        <th>Existencia actual</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                </tbody>
            </table>
        </div>

        <br>
        <br>

        <div class="">
            <table class="table table-hover nowrap" style="width:100%" id="group-sales-report">
                <thead class="bg-orange text-light">
                    <tr>
                        <th>Mes y año de la venta</th>
                        <th>Categoría</th>
                        <th>Ventas</th>
                    </tr>
                </thead>
                <tbody id="table-body-2">
                </tbody>
            </table>
        </div>

        <br>
        <br>

        <button class="btn btn-orange shadow-none rounded-1"><i class="fa fa-file-csv"></i> CSV</button>
        <button class="btn btn-orange shadow-none rounded-1"><i class="fa fa-file-pdf"></i> PDF</button>

        <canvas id="myChart"></canvas>

    </div>

    @footer

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

    <!-- Chart.js -->
    <script src="vendor/node_modules/chart.js/dist/chart.min.js"></script>

    <!-- JavaScript -->
    <script src="./js/sales-report.js"></script>
</body>
</html>