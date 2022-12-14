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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="./styles/colors.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/layout.css">
    <link rel="stylesheet" href="./styles/checkout.css">
    <link rel="stylesheet" href="./styles/footer.css">
</head>
<body>
    @navbar

    <section class="row">
        <div class="col-lg-8 col-md-8 p-0">
            
            <div class="container my-4">
                <div class="row d-flex justify-content-center">
                    <form class="bg-white rounded-1 shadow-sm p-5 col-12" id="msform">
                        <h1 class="h2 text-brown text-center mb-4"><i class="fas fa-credit-card"></i> Finalizar compra</h1>
                        <hr class="mb-4">

                        <ul id="progressbar" class="px-0 mb-5">
                            <li class="active" id="account"><strong>Dirección de envío</strong></li>
                            <li id="personal"><strong>Pago</strong></li>
                            <li id="payment"><strong>Finalizar</strong></li>
                        </ul> 

                        <fieldset>
                            <div class="text-start row">
                                <div class="text-center col-12 mb-4">
                                    <h2 class="form-title text-center h2 mb-4">Dirección de envío</h2>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label" for="names">Nombre(s)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control shadow-none rounded-1" name="names" id="names">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label" for="last-name">Apellido(s)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control shadow-none rounded-1" name="last-name" id="last-name">
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="street-address" class="form-label">Calle y número exterior</label>
                                    <div class="input-group">
                                        <input class="form-control shadow-none rounded-1" type="text" name="street-address" id="street-address">
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <div class="input-group">
                                        <input class="form-control shadow-none rounded-1" type="text" name="city" id="city">
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <label for="state" class="form-label">Estado</label>
                                    <div class="input-group">
                                        <input class="form-control shadow-none rounded-1" type="text" name="state" id="state">
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-4">
                                    <label for="postal-code" class="form-label">Código postal</label>
                                    <div class="input-group">
                                        <input class="form-control shadow-none rounded-1" type="text" name="postal-code" id="postal-code">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="email" class="form-label">Correo electrónico</label>  
                                    <div class="input-group">
                                        <input class="form-control shadow-none rounded-1" type="email" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <input class="form-control shadow-none" type="tel" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>

                            <input type="button" name="next" class="next btn btn-orange mb-4 w-100 mt-3 shadow-none rounded-1" value="Continuar">
                        </fieldset>

                        <fieldset>
                            <div class="form-card">

                                <div class="text-center col-12 mb-4">
                                    <h2 class="form-title text-center h2 mb-4">Método de pago</h2>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="form-check">
                                        <input class="custom-control-input form-check-input shadow-none" type="radio" name="flexRadioDefault" id="radio-card">
                                        <label class="form-check-label" for="radio-card">Tarjeta de crédito</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="custom-control-input form-check-input shadow-none" type="radio" name="flexRadioDefault" id="radio-paypal">
                                        <label class="form-check-label" for="radio-paypal">Paypal</label>
                                    </div>
                                </div>

                                <span id="card-section" class="d-none row">
                                    <div class="col-12 mb-4">
                                        <label>Número de tarjeta</label>
                                        <div class="input-group">
                                            <input class="form-control shadow-none" type="text" name="card-number" id="card-number">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-4">
                                        <label>Fecha de vencimiento</label>
                                        <div class="input-group col-12 px-0">
                                            <select class="form-select shadow-none" name="exp-month" id="exp-month">
                                                <option value="">Mes</option>
                                                <option value="1">01</option>
                                                <option value="2">02</option>
                                                <option value="3">03</option>
                                                <option value="4">04</option>
                                                <option value="5">05</option>
                                                <option value="6">06</option>
                                                <option value="7">07</option>
                                                <option value="8">08</option>
                                                <option value="9">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <select class="form-select shadow-none" name="exp-year" id="exp-year">
                                                <option value="">Año</option>
                                                <option value="2022">2022</option>
                                                <option value="2022">2023</option>
                                                <option value="2022">2024</option>
                                                <option value="2022">2025</option>
                                                <option value="2022">2026</option>
                                                <option value="2022">2027</option>
                                                <option value="2022">2028</option>
                                                <option value="2022">2029</option>
                                                <option value="2022">2030</option>
                                            </select>
                                        </div>
                                        <div id="errors-exp">

                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-lg-12 mb-4">
                                        <label>Código de seguridad</label>
                                        <div class="input-group">
                                            <input class="form-control shadow-none" type="text" name="cvv" id="cvv">
                                        </div>
                                    </div>
                                </span>

                                <div id="paypal-section" class="d-none">
                                    <!--<button class="btn btn-warning w-100 rounded-1 shadow-none d-none">Paypal</button>-->
                                </div>

                            </div> 
                            <input type="button" name="previous" class="previous btn btn-orange shadow-none rounded-1" value="Regresar">
                            <input type="submit" id="finish" name="next" class="next btn btn-orange shadow-none rounded-1" value="Finalizar">
                    
                        </fieldset>

                        <fieldset>
                            <div class="form-card">
                                <h2 class="fs-title text-center">Success !</h2> <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-3"> 
                                        <img src="./assets/icons/check-circle-solid.svg" class="fit-image">
                                    </div>
                                </div> 
                                <br>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5>Proceso de compra finalizado</h5>
                                    </div>
                                </div>
                            </div>
                        </fieldset>  
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 p-0">

            <div class="bg-white container my-4">
                <div class="row d-flex justify-content-center">
                    <div class=" p-5 shadow-sm rounded-1">
                        <h2>Tu pedido</h2>
                        <hr>
                        
                        <div id="shipping">
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Subtotal</strong>
                            <p id="subtotal"></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <p id="total"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery 3.6.0 -->
    <script src="vendor/node_modules/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery Validation 1.19.5 -->
    <script src="vendor/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/node_modules/jquery-validation/dist/additional-methods.min.js"></script>
    
    <!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="vendor/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=AYRWL7VDLGBBSSSutwgu3nPO8ZDZKNGCiON9pO_X-dGx3lgkWMLL2xlQjDycSG5qA3bh4IRsjMMgHunl"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <!-- JavaScript -->
    <script type="module" src="./js/checkout.js"></script>
</body>
</html>