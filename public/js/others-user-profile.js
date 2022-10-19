import { getSession } from './utils/session.js';

const id = getSession();

$.ajax({
    url: `api/v1/users/${id}`,
    method: "GET",
    async: false,
    timeout: 0,
    success: function(response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});


const wishlistCard = /*html*/`
{{#each this}}
<div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch">
    <div class="card mx-auto" style="width: 18rem;">
        <div class="ratio ratio-4x3">
            <img src="api/v1/images/{{images.[0]}}" class="card-img-top w-100 h-100">
        </div>
        <div class="card-body">
            <h5 class="card-title">{{name}}</h5>
            <p class="card-text">{{description}}</p>
            <a href="/wishlist?search={{id}}" class="btn btn-orange shadow-none rounded-1">Ver más</a>
        </div>
    </div>
</div>
{{/each}}
`;

const productCard = /*html*/`
{{#each this}}
<div class="col-lg-4 col-md-6 col-sm-12 car-prueba bg-white text-center car-prueba p-5">
    <a href="/product?search={{id}}"><img src="api/v1/images/{{images.[0]}}" class="img-fluid p-3"></a>
    <h5 class="fw-bold price mb-0">{{price}}</h5>
    <p>{{name}}</p>
    <div class="d-flex justify-content-center">
        <button class="btn btn-orange shadow-none rounded-1 me-1 add-cart">Agregar al carrito</button>
        <button class="btn btn-red shadow-none rounded-1 add-wishlists" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
    </div>
</div>
{{/each}}
`;

const userId = new URLSearchParams(location.search).get('id') || '0';


$.ajax({
    url: `/api/v1/users/${new URLSearchParams(location.search).get('id') || '0'}`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        $('#username').text(response.username);
        $('#email').text(response.email);
        $('#name').text(response.firstName + ' ' + response.lastName);
        $('#profile-picture').attr('src', `api/v1/images/${response.profilePicture}`)

        console.log(response);
    }
});

$.ajax({
    url: `/api/v1/users/${userId}/products/approved`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        const template = Handlebars.compile(productCard);
        $('#seller-product-container').append(template(response));
    }
});

$.ajax({
    url: `/api/v1/users/${userId}/products/approves`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        const template = Handlebars.compile(productCard);
        $('#admin-products-container').append(template(response));
    }
});

$.ajax({
    url: `api/v1/users/${userId}/wishlists/public`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        const template = Handlebars.compile(wishlistCard);
        $('#customer-wishlist-container').append(template(response));
        $('#seller-wishlist-container').append(template(response));
        /*
        response.forEach(function(element) {

            const template = Handlebars.compile(wishlistCard);


            //$('#seller-wishlist-container').append(wishlistCard);
            $('#customer-wishlist-container').append(template(element));
            //var carouselDOM = $(wishlist).find('.card .carousel')[0];
            //var carousel = new bootstrap.Carousel(carouselDOM);
            //carousel.cycle();
        });
        */
     }
});



$(document).ready(function() {

    //$(`#test-${userId}`).removeClass('d-none');

    $("#main-tab li a").click(function(e) {
        e.preventDefault();
        $(this).tab("show");

        if ($(this).text() === 'Productos')
        {
            $('#seller-wishlist-container').addClass('d-none');
            $('#seller-product-container').removeClass('d-none');
        }
        else if ($(this).text() === 'Listas de deseos')
        {
            $('#seller-product-container').addClass('d-none');
            $('#seller-wishlist-container').removeClass('d-none');
        }
    });

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

});