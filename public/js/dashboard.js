const carouselCard = /*html*/`
<div class="item">
    <div class="text-center car-prueba p-4 m-4 rounded">
        <a href="/product"><img src="assets/img/IMG001.jpg" class="p-3"></a>
        <h5 class="fw-bold mb-0">$297.00</h5>
        <p>Fresas con crema</p>
        <div class="d-flex justify-content-center">
            <button class="btn btn-orange shadow-none rounded-1 me-1 add-cart">Agregar al carrito</button>
            <button class="btn btn-danger shadow-none rounded-1 add-wishlist" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
        </div>
    </div>
</div>
`;

const carouselCard2 = /*html*/`
<div class="item">
    <div class="bg-white text-center car-prueba p-4 m-4 rounded">
        <a href="/product"><img src="assets/img/E001S000032.jpg" class="p-3"></a>
        <h5 class="fw-bold price mb-0">$297.00</h5>
        <p>Tres leches combinado</p>
        <div class="d-flex justify-content-center">
            <button class="btn btn-orange shadow-none rounded-1 me-1 add-cart">Agregar al carrito</button>
            <button class="btn btn-danger shadow-none rounded-1 add-wishlist" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
        </div>
    </div>
</div>
`;

const carouselCard3 = /*html*/`
<div class="item">
    <div class="bg-white text-center car-prueba m-4 p-3">
        <a href="/product"><img src="assets/img/E001S007866.jpg" class="p-3"></a>
        <h5 class="fw-bold price h6 mb-0">$297.00</h5>
        <p>Bambino tentación de fresa</p>
        <div class="d-flex justify-content-center">
            <button class="btn btn-orange shadow-none rounded-1 me-1 add-cart">Agregar al carrito</button>
            <button class="btn btn-danger shadow-none rounded-1 add-wishlist" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
        </div>
    </div>
</div>
`;

const carouselCategoryCard = /*html*/`
<div class="item">
    <div class="text-center car-prueba p-4 m-4 rounded">
        <a href="/search"><img src="assets/img/IMG001.jpg" class="p-3"></a>
        <p class="h4 brown">Categoría</p>
    </div>
</div>
`;

const carouselCategoryCard2 = /*html*/`
<div class="item">
    <div class="text-center car-prueba p-4 m-4 rounded">
        <a href="/search"><img src="assets/img/E001S000032.jpg" class="p-3"></a>
        <p class="h4 brown">Categoría</p>
    </div>
</div>
`;

const carouselCategoryCard3 = /*html*/`
<div class="item">
    <div class="text-center car-prueba p-4 m-4 rounded">
        <a href="/search"><img src="assets/img/E001S007866.jpg" class="p-3"></a>
        <p class="h4 brown">Categoría</p>
    </div>
</div>
`;


$('#recomendations').append(carouselCard);
$('#sellers').append(carouselCard);
$('#stars').append(carouselCard);
$('#recents').append(carouselCard);

$('#recomendations').append(carouselCard2);
$('#sellers').append(carouselCard2);
$('#stars').append(carouselCard2);
$('#recents').append(carouselCard2);

$('#recomendations').append(carouselCard3);
$('#sellers').append(carouselCard3);
$('#stars').append(carouselCard3);
$('#recents').append(carouselCard3);

$('#categories-carousel').append(carouselCategoryCard);
$('#categories-carousel').append(carouselCategoryCard2);
$('#categories-carousel').append(carouselCategoryCard3);

$(document).ready(function()
{
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $('.add-cart').click(function() {
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido al carrito'
        });
    });

    $('#start-shop').click(function() {

        window.location.href = '/search';

    });

    $('#add-wishlists').submit(function(event) {
        event.preventDefault();

        modal = document.getElementById('select-wishlist');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido a las listas de deseos'
        })
    });
    
    $('.sellers').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplayHoverPause: true, // Es molesto ver un producto y que el carousel se mueva
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 3
            },
            1400: {
                items: 3
            },
            2000: {
                items: 6
            },
            3000: {
                items: 7
            },
            4000: {
                items: 8
            }
        }
    });

});