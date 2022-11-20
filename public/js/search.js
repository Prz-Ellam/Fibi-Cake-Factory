import { getSession } from './utils/session.js';
const id = getSession();

const search = new URLSearchParams(window.location.search).get("search");
$('#search').val(search);
$('#product-search').val(search);

$.ajax({
    url: `/api/v1/users/filter/search?search=${search}`,
    method: 'GET',
    success: function(response)
    {
        response.forEach((user) =>
        {
            $('#users-section').append(/*html*/`
                <a href="/profile?id=${user.id}" class="col-lg-4 col-md-6 col-sm-12  text-decoration-none text-brown">
                    <div class="bg-white text-center p-5">
                        <img src="api/v1/images/${user.profilePicture}" class="img-fluid p-3 rounded-circle" style="width: 256px; height: 256px; object-fit: cover" alt="A">
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
    success: function(response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

$.ajax({
    url: 'api/v1/categories',
    method: 'GET',
    async: false,
    success: function(response)
    {
        response.forEach(category =>
        {
            $('#categories').append(`<option value="${category.id}">${category.name}</option>`)
        });
    }
});



Handlebars.registerHelper('currency', function(number) {
    var fmt = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });
    
    return fmt.format(number);
});

const productCard = /*html*/`
{{#each this}}
<div class="bg-white col-lg-4 col-md-6 col-sm-12 text-center p-5">
    <a href="/product?search={{id}}"><img src="api/v1/images/{{images.[0]}}" class="img-fluid p-3"></a>
    <h5 class="fw-bold mb-0">{{currency price}}</h5>
    <p>{{name}}</p>
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary shadow-none bg-orange rounded-1 me-1 add-cart" value="{{id}}">Agregar al carrito</button>
        <button class="btn btn-danger shadow-none rounded-1 add-wishlists" data-bs-toggle="modal" data-bs-target="#select-wishlist" value="{{id}}"><i class="fa fa-heart"></i></button>
    </div>
</div>
{{/each}}
`;


$.ajax({
    url: `api/v1/products?search=${search}`,
    method: 'GET',
    async: false,
    success: function(response) {
        const template = Handlebars.compile(productCard);
        $('#product-search-container').append(template(response));
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
        response.forEach(function(wishlist) {
            $('#wishlists-list').append(WishlistItem(wishlist));
        });
    }
});

$(document).ready(function() {

    $('body').removeClass('d-none');

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

    $('#sortings').change(function() {
        const querys = this.value.split(' ');

        fetch(`api/v1/products?filter=${querys[0]}&order=${querys[1]}&search=${search}`)
        .then(response => response.json())
        .then(response => {
            $('#product-search-container').empty();
            const template = Handlebars.compile(productCard);
            $('#product-search-container').append(template(response));
        });
    });

});