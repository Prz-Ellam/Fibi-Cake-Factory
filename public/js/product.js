function CarouselCard(product)
{
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
            <h5 class="fw-bold price mb-0">${ (product.is_quotable) ? 'Cotizable' : fmt.format(product.price)}</h5>
            <p>${product.name}</p>
            ${ (product.userId === id) ?
            `<div class="d-flex justify-content-center">
                <a href="/update-product?search=${product.id}" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
                <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-product">Eliminar</a>
            </div>`
            :
            `<div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-orange shadow-none rounded-1 me-1 add-cart">Agregar al carrito</button>
                <button type="button" class="btn btn-danger shadow-none rounded-1 add-wishlist" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
            </div>`
            }
        </form>
    </div>
    `;
}

function CommentComponent(comment) {
    return /*html*/`
    <div class="d-flex comment-component" id="${comment.id}">
        <img src="api/v1/images/${comment.profilePicture}" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
        <div class="row">
            <div class="col-12">
                <a href="/profile?id=${comment.userId}" class="mt-0 me-1">${comment.username}</a>
                <span class="rating">
                    <i class="rating-star ${(comment.rate >= 1) ? 'fas' : 'far'} fa-star" value="1"></i>
                    <i class="rating-star ${(comment.rate >= 2) ? 'fas' : 'far'} fa-star" value="2"></i>
                    <i class="rating-star ${(comment.rate >= 3) ? 'fas' : 'far'} fa-star" value="3"></i>
                    <i class="rating-star ${(comment.rate >= 4) ? 'fas' : 'far'} fa-star" value="4"></i>
                    <i class="rating-star ${(comment.rate >= 5) ? 'fas' : 'far'} fa-star" value="5"></i>
                </span>
                <p class="mb-0">${comment.message}</p>
                <small>${comment.createdAt}</small><br>
                <div class="badge bg-danger btn-delete-review" role="button">Eliminar</div>
            </div>
        </div>
    </div>
    <hr>
    `;
}

import { getSession } from './utils/session.js';
const id = getSession();

const productId = new URLSearchParams(window.location.search).get("search");

function setRates(index) {

    const stars = $('.rating').children();

    for (let i = 0; i < 5; i++) {
        stars[i].className = 'rating-star far fa-star';
    }

    for (let i = index; i > 0; i--) {
        stars[i - 1].className = 'rating-star fas fa-star';
    }
}

var productOwnerId = null;
$.ajax({
    url: `/api/v1/products/${productId || '0'}`,
    method: 'GET',
    async: false,
    success: function (response) {
        productOwnerId = response.user;
        console.log(response);
        const product = response;

        var fmt = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        $('#name').text(product.name);

        let data = ' ';
        product.categories_name.forEach(category => {
            data += category;
        });
        $('#category').text(data);

        $('#price').text((product.is_quotable) ? 'Cotizable' : fmt.format(product.price));
        $('#rate-number').text(product.rate);
        $('#description').text(product.description);
        $('#zoom').attr('src', 'api/v1/images/' + product.images[0]);

        $('#image1').attr('src', 'api/v1/images/' + product.images[0]);
        $('#image2').attr('src', 'api/v1/images/' + product.images[1]);
        $('#image3').attr('src', 'api/v1/images/' + product.images[2]);

        var video = document.getElementById('video-play');
        video.addEventListener('loadeddata', function() {
            const video = document.getElementById('video-play');
            var w = video.videoWidth;
            var h = video.videoHeight;
            var canvas = document.createElement('canvas');
            canvas.width  = w;
            canvas.height = h;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, w, h);

            $('#video').attr('src', canvas.toDataURL());
        }, false);
        video.src = `api/v1/videos/${product.video}`;
        
        $('.mini-zoom').attr('src', 'api/v1/images/' + product.video);
        if (product.rate !== 'No reviews') {
            setRates(Number(product.rate));
        }
        $('.add-wishlists').val(product.id);

        $.ajax({
            url: `api/v1/users/${response.user}/products`,
            method: 'GET',
            async: false,
            success: function(response) {
                response.forEach(function(product) 
                {
                    $('#users').append(CarouselCard(product));
                });
            }
        });

    }
});

$.ajax({
    url: `/api/v1/products/${productId}/comments`,
    method: 'GET',
    success: function (response) {
        response.forEach((comment) => {
            $('#comment-section').append(CommentComponent(comment));
        })
    }
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
    success: function(response) {
        response.wishlists.forEach(function(wishlist) {
            $('#wishlists-list').append(WishlistItem(wishlist));
        });
    }
});

$(document).ready(function () {

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

    $('.rate-star').click(function () {

        const stars = $(this).parent().children();

        let starIndex = parseInt($(this).attr('value'));
        document.getElementById('rate').value = starIndex;

        for (let i = 0; i < 5; i++) {
            stars[i].className = 'rating-star far fa-star';
        }

        for (let i = starIndex; i > 0; i--) {
            stars[i - 1].className = 'rating-star fas fa-star';
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

    $(document).on('click', '.btn-delete-review', function(event) {

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro que deseas eliminar el comentario?, esta acción es irreversible',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#DD3333',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(result => {

            if (result.isConfirmed) {

                const id = this.closest('.comment-component').id;

                fetch(`/api/v1/products/${productId}/reviews/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(response => {
                    
                    $('#comment-section').empty();

                    fetch(`/api/v1/products/${productId}/comments`)
                    .then(response => response.json())
                    .then(response => {
                        $('#message-box').val('');
                        $('.rating-star').removeClass('fas').addClass('far');
                        response.forEach(comment => {
                            $('#comment-section').append(CommentComponent(comment));
                        });
                    })

                });

            }

        });
        
    });

    $('.add-cart').click(function () {

        event.preventDefault();

        const quantity = document.getElementById('quantity').value;

        var urlencoded = new URLSearchParams();
        urlencoded.append('product-id', productId);
        urlencoded.append('quantity', quantity);

        var headers = new Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');

        fetch('/api/v1/shopping-cart-item', {
            headers: headers,
            method: 'POST',
            body: urlencoded
        })
        .then(response => response.json())
        .then(response => {

            console.log(response);
            Toast.fire({
                icon: 'success',
                title: 'Tu producto ha sido añadido al carrito'
            });

        });

    });

    $(document).on('click', '.add-wishlists', function() {
        console.log(this.value);
        $('#wishlist-product-id').val(this.value);
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

    $('#create-review-form').submit(function (event) {

        event.preventDefault();

        const text = $('#message-box').val();
        const rate = $('#rate').val();

        if (!text || !rate) return;

        $.ajax({
            url: `/api/v1/products/${productId}/reviews`,
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#comment-section').empty();

                fetch(`/api/v1/products/${productId}/comments`)
                .then(response => response.json())
                .then(response => {
                    $('#message-box').val('');
                    $('.rating-star').removeClass('fas').addClass('far');
                    response.forEach(comment => {
                        $('#comment-section').append(CommentComponent(comment));
                    });
                })

            },
            error: function (response, status, error) {
                const responseText = response.responseJSON;
                if (!responseText.status) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: responseText.message,
                        confirmButtonColor: "#FF5E1F",
                    });
                }
            }
        });

    });

})