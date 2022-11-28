import { getSession } from "./utils/session.js";
import { WishlistItem } from "./views/wishlist-list.js";

function CarouselCard(product) {
    var fmt = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    return /*html*/`
    <div class="item">
        <form class="text-center car-prueba p-4 m-4 rounded" id="add-cart">
            <input type="hidden" name="product-id" value="${product.id}">
            <input type="hidden" name="quantity" value="1">
            <a href="/product?search=${product.id}"><img src="/api/v1/images/${product.images[0]}" class="p-3"></a>
            <h5 class="fw-bold price mb-0">${ (product.price === 'Cotizable') ? product.price : fmt.format(product.price)}</h5>
            <p>${product.name}</p>
            ${ (product.userId === id) ?
            `<div class="d-flex justify-content-center">
                <a href="/update-product?search=${product.id}" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
                <button class="btn btn-red btn-delete shadow-none rounded-1" value="${product.id}">Eliminar</button>
            </div>`
            :
            `<div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-orange shadow-none rounded-1 me-1 add-cart">${ (product.price === 'Cotizable') ? 'Solicitar cotizacion' : 'Agregar al carrito' }</button>
                <button type="button" class="btn btn-danger shadow-none rounded-1 add-wishlist" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
            </div>`
            }
        </form>
    </div>
    `;
}


var id = getSession();
$.ajax({
    url: `api/v1/products?filter=rates&order=desc`,
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(product => {
            $('#rates').append(CarouselCard(product));
        });
    }
});

$.ajax({
    url: `api/v1/products?filter=recents`,
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(product => {
            $('#recents').append(CarouselCard(product));
        });
    }
});

$.ajax({
    url: `api/v1/products?filter=favorites`,
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(product => {
            $('#favorites').append(CarouselCard(product));
        });
    }
});

$.ajax({
    url: `api/v1/products?filter=sells`,
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(product => {
            $('#sellers').append(CarouselCard(product));
        });
    }
});

$.ajax({
    url: `api/v1/users/${id}/wishlists`,
    method: 'GET',
    success: function(response) {
        response.wishlists.forEach(wishlist => {
            $('#wishlists-list').append(WishlistItem(wishlist));
        });
    }
});

$(document).ready(function() {

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

    $(document).on('click', '.btn-delete', function(event) {
        event.preventDefault();
        const id = $(this).val();
        fetch(`/api/v1/products/${id}`, {
            method: 'DELETE'
        })
        .then(res => res.json())
        .then(res => window.location.href = '/');
    })

    $(document).on('submit', '#add-cart', function(event) {

        event.preventDefault();

        $.ajax({
            url: 'api/v1/shopping-cart-item',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                }
            },
            error: function (response, status, error) {
                const responseText = response.responseJSON;
                if (!responseText.status) {
                    Toast.fire({
                        icon: 'error',
                        title: responseText.message
                    });
                }
            }
        });

    });

    $(document).on('click', '.add-wishlist', function() {
        $('#wishlist-product-id').val($(this).parent().parent().find('[name="product-id"]').val());
    });

    $('#add-wishlists').submit(function(event) {
        event.preventDefault();

        const modal = document.getElementById('select-wishlist');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        $.ajax({
            url: `api/v1/wishlist-objects`,
            method: 'POST',
            data: $(this).serialize(),
            success: response => {
                $(this)[0].reset();
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido a las listas de deseos'
                });
            }
        });
    
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