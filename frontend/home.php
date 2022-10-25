<div id="banner">
    <div class="cte">
        <h1 class="text-center text-white text-uppercase font-weight-bold mb-4" id="hero-title">¡Conquistando el sabor supremo!</h1>
        <hr class="bg-white">
        <p class="text-white h4 mb-4">Pasteles únicos y variados todos los días</p>            <button class="btn btn-md btn-secondary shadow-none p-3 bg-orange h5 start-shop rounded-1" id="start-shop">Empezar a comprar <i class="fa fa-angle-right" aria-hidden="true"></i></button>
    </div>
</div>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="container-recomendations">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Basado en tus gustos</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="recomendations">
        </div>
    </div>
</section>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los mejor calificados</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="rates">
        </div>
    </div>
</section>

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los favoritos de nuestros visitantes</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="sellers">
        </div>
    </div>
</section>

<!--
<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Los mejor calificados</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="stars"></div>
    </div>
</section>
-->

<section class="my-5">
    <div class="container-fluid bg-white carousel-card" style="width: 90%" id="">
        <div class="pt-4">
            <h2 class="text-center h2 font-weight-bold text-brown">Nuevos lanzamientos</h2>
        </div>
        <hr>
        <div class="owl-carousel owl-theme sellers" id="recents"></div>
    </div>
</section>

<div class="modal fade" id="select-wishlist" tabindex="-1" aria-labelledby="select-wishlist-label" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="add-wishlists">
            <input type="hidden" name="product-id" id="wishlist-product-id" value="">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="select-wishlist-label">¿A qué listas de deseos quieres añadir?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="wishlists-list">
                </ul>
                <nav aria-label="Page navigation" class="mt-4 text-center d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Anterior</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-brown shadow-none" href="#">Siguiente</a></li>
                    </ul>
                </nav>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-1 shadow-none" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-orange rounded-1 shadow-none">Aceptar</button>
            </div>
        </form>
    </div>
</div>