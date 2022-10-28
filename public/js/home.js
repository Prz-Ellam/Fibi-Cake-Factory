

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
            <h5 class="fw-bold price mb-0">${fmt.format(product.price)}</h5>
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


var id;
$.ajax({
    url: 'api/v1/session',
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        id = response.id;
        $.ajax({
            url: `api/v1/users/${response.id}`,
            method: "GET",
            async: false,
            timeout: 0,
            success: function(response) {
                const url = `api/v1/images/${response.profilePicture}`;
                $('.nav-link img').attr('src', url);
            }
        });
    }
});

$.ajax({
    url: `api/v1/products/action/recents`,
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        response.forEach(function(product) 
        {
            $('#recents').append(CarouselCard(product));
        });
    }
});

$.ajax({
    url: `api/v1/products/order/ships`,
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        response.forEach(function(product) 
        {
            $('#sellers').append(CarouselCard(product));
        });
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
    url: 'api/v1/session',
    method: 'GET',
    async: false,
    success: function(response) {
        console.log(response.id);

        $.ajax({
            url: `api/v1/users/${response.id}/wishlists`,
            method: 'GET',
            timeout: 0,
            success: function(response) {
                response.forEach(function(wishlist) {
                    $('#wishlists-list').append(WishlistItem(wishlist));
                });
            }
        });
    }
});

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

    $(document).on('submit', '#add-cart', function(event) {

        event.preventDefault();

        $.ajax({
            url: 'api/v1/shopping-cart-item',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {

                console.log(response);

                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido al carrito'
                });
                
            }
        });

    });

    $('#start-shop').click(function() {

        window.location.href = '/search';

    });

    $(document).on('click', '.add-wishlist', function() {
        console.log($(this).parent().parent().find('[name="product-id"]').val());
        $('#wishlist-product-id').val($(this).parent().parent().find('[name="product-id"]').val());
    });

    $('#add-wishlists').submit(function(event) {

        event.preventDefault();

        modal = document.getElementById('select-wishlist');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        console.log($(this).serialize());

        $.ajax({
            url: `api/v1/wishlist-objects`,
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido a las listas de deseos'
                })
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

    $("#search").autocomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                data: {term : request.term},
                method: "GET",
                dataType: "json",
                url: '../Controllers/SearchBox.php',
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        open: function(){
            setTimeout(function () {
                $('.ui-autocomplete').css('z-index', 99999999999999);
            }, 0);
        },
        select: function(event, ui) {
            alert("Selecciono: " + ui.item.label);
        }
    });

});