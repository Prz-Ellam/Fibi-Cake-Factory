import { getSession } from './utils/session.js';
const id = getSession();

var fmt = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

const wishlistId = new URLSearchParams(window.location.search).get("search") || '0';

$.ajax({
    url: `/api/v1/wishlists/${wishlistId}`,
    method: 'GET',
    async: false,
    success: function(response)
    {
        $('#wishlist-name').text(response.name);
        $('#wishlist-description').text(response.description);
        response.images.forEach((image, i) => {
            $('#wishlist-images').append(/*html*/`
                <div class="carousel-item${ (i == 0) ? " active" : "" }">
                    <img src="api/v1/images/${image}" class="d-block w-100" style="max-width: 256px;" alt="...">
                </div>
            `);
        });
    }
});

$.ajax({
    url: `/api/v1/wishlist-objects/${wishlistId}`,
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.forEach(wishlistObject => {
            $('#table-body').append(/*html*/`
            <tr class="mainRow" id=${wishlistObject.id}>
                <td></td>
                <td><img src="api/v1/images/${wishlistObject.images[0]}" width="100" role="button"></td>
                <td>${wishlistObject.name}</td>
                <td>${wishlistObject.description}</td>
                <td>${(wishlistObject.price === 'Cotizable') ? wishlistObject.price : fmt.format(wishlistObject.price)}</td>
                <td>${wishlistObject.stock}</td>
                <td><button class="btn btn-orange shadow-none rounded-1 add-cart" value="${wishlistObject.product_id}"><i class="fa fa-shopping-cart"></i> ${(wishlistObject.price === 'Cotizable' ? 'Solicitar cotización' : 'Agregar al carrito') }</button></td>
                <td><button class="btn btn-red shadow-none rounded-1"><i class="fa fa-trash"></i></button></td>
            </tr>
            `);
        });
    }
});

$(document).ready(function() {

    $('#wishlist-table').DataTable({
        responsive: true,
        bAutoWidth: false,
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontró información",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrados _MAX_ registros en total)",
            paginate: {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            search:         "Buscar:"
        }
    });

    $('.form-control').addClass('shadow-none');
    $('.form-select').addClass('shadow-none');
    $('.page-link').addClass('shadow-none');

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
                if (response.status) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                }
                
            }
        });
    });

    $(document).on('click', '.btn-red', function() {

        const row = $(this).closest('.mainRow');
        const id = $(row).attr('id');

        $.ajax({
            url: `/api/v1/wishlist-objects/${id}`,
            method: 'DELETE',
            success: function(response) {
                row.remove();
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido eliminado de la lista de deseos'
                });
            }
        });

    });

    $('td img').click(function() {
        window.location.href = '/product';
    })

});