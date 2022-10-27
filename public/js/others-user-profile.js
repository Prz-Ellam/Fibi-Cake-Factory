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
<div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch wishlist-card" id="{{id}}">
    <div class="card mx-auto" style="width: 18rem;">
        <div class="carousel slide" data-bs-ride="carousel" role="button">
            <div class="carousel-inner">
            {{#if images.length}}
                {{#each images}}
                <div class="carousel-item {{#if @first}}active{{/if}}" data-bs-interval="5000">
                    <div class="ratio ratio-4x3">
                        <img src="/api/v1/images/{{this}}" class="card-img-top w-100 h-100">
                    </div>
                </div>
                {{/each}}
            {{else}}
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="ratio ratio-4x3">
                        <img src="assets/img/wishlist-default.jpg" class="card-img-top w-100 h-100">
                    </div>
                </div>
            {{/if}}
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{name}}</h5>
            <p class="card-text text-truncate">{{description}}</p>
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
        <button class="btn btn-orange shadow-none rounded-1 me-1 add-cart" value="{{id}}">Agregar al carrito</button>
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

fetch(`api/v1/users/${userId}/wishlists`)
    .then(response => response.json())
    .then(response => {
        const template = Handlebars.compile(wishlistCard);
        const html = template(response);
        $('#customer-wishlist-container').append(html);
        $('#seller-wishlist-container').append(html);
        var carouselsDOM = document.querySelectorAll('.carousel');
        carouselsDOM.forEach(carouselDOM => {
            var carousel = new bootstrap.Carousel(carouselDOM);
            carousel.cycle();
        });
    });

function WishlistItem(wishlist)
{
    return /*html*/`
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
            <img src="api/v1/images/${wishlist.images[0]}" class="img-fluid" alt="lay" style="max-width: 128px">
            ${wishlist.name}
            </span>
        <input class="custom-control-input form-check-input shadow-none me-1" name="wishlists[]" type="checkbox" value="${wishlist.id}" aria-label="...">
    </li>
    `;
}

$.ajax({
    url: `api/v1/users/${id}/wishlists`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        response.forEach(function(wishlist) {
            $('#wishlists-list').append(WishlistItem(wishlist));
        });
    }
});





$(document).ready(function() {

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

    $(document).on('click', '.ratio', function () {

        const card = this.closest('.wishlist-card');
        const id = card.id;
        window.location.href = `/wishlist?search=${id}`;

    });

    $(document).on('click', '.add-cart', function(event) {
        
        event.preventDefault();

        $.ajax({
            url: 'api/v1/shopping-cart-item',
            method: 'POST',
            data: `product-id=${this.value}&quantity=1`,
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido al carrito'
                });      
            }
        });

    });

    $('#add-wishlists').submit(function(event) {

        event.preventDefault();

        const modal = document.getElementById('select-wishlist');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        console.log($(this).serialize());

        $.ajax({
            url: `api/v1/wishlist-objects`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
            }
        });
        
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido a las listas de deseos'
        })
    });

});