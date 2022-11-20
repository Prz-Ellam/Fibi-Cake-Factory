
import { getSession } from './utils/session.js';
const id = getSession();

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
    url: `api/v1/shopping-cart`,
    method: 'GET',
    async: false,
    success: function(response) {

        var fmt = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        if (response.length !== 0) {
            $('#finish-order').removeAttr('disabled');
        }

        response.forEach(function(shoppingCartItem, i) 
        {
            $('#table-body').append(/*html*/`
            <tr class="mainRow" role="button" id="${shoppingCartItem.id}">
                <td></td>
                <td><img src="api/v1/images/${shoppingCartItem.image}" class="me-3" height="100"></td>
                <td scope="row">${shoppingCartItem.name}</td>
                <td scope="row"><span>${fmt.format(shoppingCartItem.price)} M.N</span></td>
                <td scope="row"><input type="number" value="${shoppingCartItem.quantity}" min="1" max="100" id="quantity-${i + 1}" class="form-control shadow-none w-50 quantity rounded-1"></td>
                <td scope="row">${fmt.format(shoppingCartItem.price * shoppingCartItem.quantity)} M.N</td>
                <td scope="row"><button class="btn btn-red shadow-none rounded-1"><i class="fa fa-trash"></i></button></td>
            </tr>
            `);
        });
    }
});

$(document).ready(function()
{
    const table = $('#shopping-cart-id').DataTable({
        responsive: true,
        bAutoWidth: false,
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontró información",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrados _MAX_ registros en total)",
            paginate: {
                first:      "Primero",
                last:       "Último",
                next:       "Siguiente",
                previous:   "Anterior"
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

    $(document).on('click', '.btn-red', function() {

        const row = $(this).closest('.mainRow');
        const id = $(row).attr('id');

        // TODO: Bug con la responsividad
        $.ajax({
            url: `/api/v1/shopping-cart-items/${id}`,
            method: 'DELETE',
            success: function(response) {

                console.log(response);
                row.remove();
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido eliminado de la lista de deseos'
                });

            }
        });

    });

    $('#finish-order').click(function() {
        window.location.href = '/checkout';
    });

    $('#back').click(function() {
        window.location.href = '/home';
    });

    $(document).on('change', '.quantity', function(event) {

        table.rows().invalidate();
        table.cells().invalidate();

        const count = $(this).val();

        const row = $(this).closest('tr');
        const price = table.cell({row: $(row).index(), column: 3}).data();
        const quantity = table.$(`#quantity-${$(row).index() + 1}`).val();

        var regexp = new RegExp(/[+-]?[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{2}/);
        const numberPrice = price.match(regexp);
        
        const value = (parseFloat(numberPrice[0]) * parseFloat(count)).toFixed(2);
        table.cell({
            row: $(row).index(), 
            column: 5
        }).data(`$${value} M.N`);


        $.ajax({
            url: `/api/v1/shopping-carts/${$(row).attr('id')}`,
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            data: { "quantity": quantity },
            success: function(response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                console.log(response);

                $.ajax({
                    url: `api/v1/shopping-cart`,
                    method: 'GET',
                    async: false,
                    success: function(response) {
                        window.location.href = '/shopping-cart';
                    }
                });
            }
        })

    })
});