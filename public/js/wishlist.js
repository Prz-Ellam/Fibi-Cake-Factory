$.ajax({
    url: `/api/v1/wishlist-objects/${new URLSearchParams(window.location.search).get("search") || '0'}`,
    method: 'GET',
    timeout: 0,
    success: function(response)
    {
        response.forEach((wishlistObject) => {
            console.log(wishlistObject);
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

    $(document).on('click', '.add-cart', function() {
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido al carrito'
        });
    });

    $(document).on('click', '.btn-red', function() {

        $(this).closest('tr').remove();

        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido eliminado de la lista de deseos'
        });

    });

    $('td img').click(function() {
        window.location.href = '/product';
    })

});