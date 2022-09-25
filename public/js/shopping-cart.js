$.ajax({
    url: `api/v1/shopping-cart`,
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        response.forEach(function(shoppingCartItem) 
        {
            $('#table-body').append(/*html*/`
            <tr role="button">
                <td></td>
                <td><img src="assets/img/IMG001.jpg" class="me-3" height="100"></td>
                <td scope="row">${shoppingCartItem.name}</td>
                <td scope="row">$<span>${shoppingCartItem.price}</span> M.N</td>
                <td scope="row"><input type="number" value="${shoppingCartItem.quantity}" min="1" max="100" class="form-control shadow-none w-50 quantity rounded-1"></td>
                <td scope="row">$${shoppingCartItem.price * shoppingCartItem.quantity}</td>
                <td scope="row"><button class="btn btn-red shadow-none rounded-1"><i class="fa fa-trash"></i></button></td>
            </tr>
            `);
            console.log(shoppingCartItem);
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

        $(this).closest('tr').remove();

        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido eliminado de la lista de deseos'
        });

    });

    $('#finish-order').click(function() {
        window.location.href = '/checkout';
    });

    $('#back').click(function() {
        window.location.href = '/home';
    });

    $(document).on('change', '.quantity', function() {

        const count = $(this).val();

        const row = $(this).closest('tr');
        const price = table.cell({row: $(row).index(), column: 3}).data();

        var regexp = new RegExp(/[+-]?[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{2}/);
        const numberPrice = price.match(regexp);
        
        const value = (parseFloat(numberPrice[0]) * parseFloat(count)).toFixed(2);
        table.cell({
            row: $(row).index(), 
            column: 5
        })
        .data(`$${value} M.N`);

    })
});