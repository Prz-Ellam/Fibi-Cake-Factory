import { getSession } from './utils/session.js';

const id = getSession();

const search = new URLSearchParams(window.location.search).get("search");
$('#search').val(search);

$.ajax({
    url: `/api/v1/users/filter/search?search=${search}`,
    method: 'GET',
    timeout: 0,
    success: function(response)
    {
        response.forEach((user) =>
        {
            $('#users-section').append(/*html*/`
                <a href="/profile?id=${user.id}" class="col-lg-4 col-md-6 col-sm-12  text-decoration-none text-brown">
                    <div class="bg-white text-center p-5">
                        <img src="api/v1/images/${user.profilePicture}" class="img-fluid p-3 rounded-circle" alt="A">
                        <h5 class="fw-bold mb-0">${user.username}</h5>
                        <p>${user.firstName + ' ' + user.lastName}</p>
                    </div>
                </a>
            `)
        })
    }
});


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


const productSearchCard = /*html*/`
<div class="bg-white col-lg-4 col-md-6 col-sm-12  text-center p-5">
    <a href="/product"><img src="assets/img/E001S011649.jpg" class="img-fluid p-3"></a>
    <h5 class="fw-bold mb-0">$299.00</h5>
    <p>Tentación de frutas</p>
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary shadow-none bg-orange rounded-1 me-1 add-cart">Agregar al carrito</button>
        <button class="btn btn-danger shadow-none rounded-1 add-wishlists" data-bs-toggle="modal" data-bs-target="#select-wishlist"><i class="fa fa-heart"></i></button>
    </div>
</div>
`;

// $('#product-search-container').append(productSearchCard);

function WishlistItem(wishlist)
{
    return /*html*/`
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
            <img src="api/v1/images/${wishlist.images[0]}" class="img-fluid" alt="lay" style="max-width: 128px">
            ${wishlist.name}
            </span>
        <input class="custom-control-input form-check-input shadow-none me-1" type="checkbox" value="" aria-label="...">
    </li>
    `;
}

$.ajax({
    url: "api/v1/session",
    method: 'GET',
    timeout: 0,
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

$(document).ready(function() {

    // Con esto cambiamos entre los tabs
    $("#main-tab li a").click(function(e) {
        e.preventDefault();
        $(this).tab("show");

        if ($(this).text() === 'Productos')
        {
            $('#users-section').addClass('d-none');
            $('#products-section').removeClass('d-none');
        }
        else if ($(this).text() === 'Usuarios')
        {
            $('#products-section').addClass('d-none');
            $('#users-section').removeClass('d-none');
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
            title: 'El producto ha sido añadido a las listas de deseos'
        })
    });

});