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
	
    <!-- CSS -->
    <link type="text/css" href="./styles/layout.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/landing-page.css">
    <link type="text/css" href="./styles/footer.css" rel="stylesheet">

	<link rel="stylesheet" href="styles/colors.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar fixed-top py-3 px-sm-3">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
			<i class="fa fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbar-collapse">
			<ul class="navbar-nav" id="orange-navbar">
				<li class="nav-item me-1">
					<a href="/signup" class="primary-nav-item nav-link text-white fw-bold rounded-3 ms-sm-0 ms-2">
						<i class="fa fa-solid fa-sign-in me-2 me-2"></i>Registrarse
					</a>
				</li>
				<li class="nav-item me-1">
					<a href="/login" class="primary-nav-item me-3 nav-link text-white fw-bold rounded-3 ms-sm-0 ms-2">
						<i class="fas fa-solid fa-user me-2"></i>Iniciar sesión
					</a>
				</li>
			</ul>
		</div>
	</nav>

	<section class="p-sm-5 text-center text-lg-start vh-100" id="main-section">
		<div class="container py-sm-5">
			<div class="d-sm-flex align-items-center justify-content-between py-5">
				<div>
					<h1 class="text-brown fw-bolder"><img src="assets/img/Brand-Logo.svg" id="brand-logo"></h1>
					<h3 class="text-brown my-4">¡Encuentra los mejores pasteles del mundo hechos por los expertos!</h3>
					<p class="text-brown fw-bold">
						Cake Factory es un punto de venta donde cualquier persona que tenga conocimientos de
						reposteria puede ingresar y publicitar sus productos y su negocio, recibimos gente de
						todas partes del mundo a diario.
					</p>
				</div>
				<a href="#">
					<img class="img-fluid" width="1500" src="assets/img/Cake-PNG-HD-Quality.png" alt="">
				</a>
			</div>
		</div>
	</section>

	<!-- Bootstrap 5.0.0 -->
    <script src="vendor/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/48ce36e499.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="./js/landing-page.js"></script>
</body>
</html>