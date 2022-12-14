<?php

use CakeFactory\Repositories\UserRepository;
use Fibi\Session\PhpSession;

$session = new PhpSession();
$userId = $session->get("userId");
if (!$userId) return;

$userRepository = new UserRepository();
$user = $userRepository->getOne($userId);

?>
<div class="side-bar bg-orange p-2 active" id="side-nav">
    <div class="header-box mb-4 mt-2 d-flex justify-content-between align-items-center">
        <h1 class="fs-4 fw-bold"><a href="/admin" class="text-white text-decoration-none">Cake Factory</a></h1>
        <button class="btn d-inline d-sm-none btn-side-bar"><i class="fas fa-bars"></i></button>
    </div>
    <ul class="list-unstyled">
        <?php if ($user["userRole"] === "Super Administrador"): ?>
        <li class="list-item rounded-1">
            <a href="/users" class="fs-6 text-white text-decoration-none d-flex justify-content-between px-2 py-2 mb-1">
                <span><i class="fas fa-user me-2"></i>Usuarios</span>
                <span></span>
            </a>
        </li>
        <?php endif ?>
        <li class="list-item rounded-1">
            <a href="/products" class="fs-6 text-white text-decoration-none d-flex justify-content-between px-2 py-2 mb-1">
                <span><i class="fas fa-box me-2"></i>Productos</span>
                <span></span>
            </a>
        </li>
        <li class="list-item rounded-1">
            <a href="/profile" class="fs-6 text-white text-decoration-none d-flex justify-content-between px-2 py-2 mb-1">
                <span><i class="fas fa-border-all me-2"></i>Perfil</span>
                <span></span>
            </a>
        </li>
    </ul>
    <hr class="bg-white">
    <ul class="list-unstyled">
        <li class="list-item rounded-1">
            <a href="/logout" class="fs-6 text-white text-decoration-none d-flex justify-content-between px-2 py-2 mb-1">
                <span>
                    <i class="fas fa-door-open me-2"></i>Salir
                </span>
            </a>
        </li>
    </ul>
</div>