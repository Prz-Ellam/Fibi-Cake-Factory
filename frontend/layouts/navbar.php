<?php

use CakeFactory\Repositories\UserRepository;
use Fibi\Session\PhpSession;

$session = new PhpSession();
$userId = $session->get("userId");
if (!$userId) return;

$userRepository = new UserRepository();
$user = $userRepository->getOne($userId);

//var_dump($user);

?>
<header class="fixed-top sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark scrolling-navbar">
        <a class="navbar-brand ms-2" href="/"><img src="assets/img/Brand-Logo.svg" id="brand-logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse me-auto" id="navbar-collapse">
            <form class="form-inline ms-xl-5 me-lg-auto w-50" id="search-box" action="/search">
                <div class="input-group w-100">
                    <input type="search" class="form-control search shadow-none" name="search" id="search" placeholder="Buscar productos">
                    <div class="input-group-append">
                        <button class="btn bg-white search-btn shadow-none" type="submit" id="search-btn"><i class="fas fa-search text-secondary"></i></button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav align-items-md-center" id="orange-navbar">
                <li class="nav-item">
                    <a href="/chat" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/wishlists" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                        <i class="fa fa-heart"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/shopping-cart" class="me-3 position-relative primary-nav-item nav-link text-white fw-bold rounded-3">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/img/default.jpg" alt="logo" class=" img-fluid rounded-circle" style="width:32px; height:32px">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-white rounded-1 shadow-sm">
                        <a href="/profile" class="dropdown-item">Mi perfil</a>
                        <div class="dropdown-divider"></div>
                        <?php if ($user["visible"] && $user["userRole"] == "Vendedor"): ?>
                        <a href="/products" class="dropdown-item">Mis productos</a>
                        <div class="dropdown-divider"></div>
                        <a href="/quotes" class="dropdown-item">Cotizaciones</a>
                        <div class="dropdown-divider"></div>
                        <?php endif ?>
                        <a href="/logout" class="dropdown-item" id="close-session">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar navbar-expand-md bg-white navbar-dark shadow-sm">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#subnavbar-collapse">
            <i class="fa fa-bars text-brown"></i>
        </button>
        <div class="collapse navbar-collapse" id="subnavbar-collapse">
            <ul class="navbar-nav ms-2">
                <li class="nav-item">
                    <a class="nav-link ms-1 me-4 p-1 text-brown" href="/home">Inicio</a>
                </li>
                <?php if ($user["visible"]): ?>
                <li class="nav-item">
                    <a class="nav-link me-4 p-1 text-brown" href="/create-product">Vender</a>
                </li>
                <?php endif ?>
                <?php if ($user["visible"] && $user["userRole"] == "Vendedor"): ?>
                <li class="nav-item">
                    <a class="nav-link me-4 p-1 text-brown" href="/sales-report">Reporte de ventas</a>
                </li>
                <?php endif ?>
                <li class="nav-item">
                    <a class="nav-link me-4 p-1 text-brown" href="/orders-report">Reporte de compras</a>
                </li>
            </ul>
        </div>
    </nav>
</header>