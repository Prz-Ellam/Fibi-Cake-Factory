var fmt = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

$.ajax({
    url: `/api/v1/wishlists/${new URLSearchParams(window.location.search).get("search") || '0'}`,
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.images.forEach((image, i) => {
            $('#wishlist-images').append(/*html*/`
                <div class="carousel-item${ (i == 0) ? " active" : "" }">
                    <img src="api/v1/images/${image}" class="d-block w-100" style="max-width: 256px;" alt="...">
                </div>
            `);
            $('#wishlist-name').text(response.name);
            $('#wishlist-description').text(response.description);
        });
    }
});

$.ajax({
    url: `/api/v1/wishlist-objects/${new URLSearchParams(window.location.search).get("search") || '0'}`,
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.forEach((wishlistObject) => {
            $('#table-body').append(/*html*/`
            <tr class="mainRow" id=${wishlistObject.id}>
                <td></td>
                <td><img src="assets/img/IMG001.jpg" width="100" role="button"></td>
                <td>${wishlistObject.name}</td>
                <td>${wishlistObject.description}</td>
                <td>${fmt.format(wishlistObject.price)}</td>
                <td>${wishlistObject.stock}</td>
                <td><button class="btn btn-orange shadow-none rounded-1 add-cart"><i class="fa fa-shopping-cart"></i> Agregar al carrito</button></td>
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

    $(document).on('click', '.add-cart', function() {
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido al carrito'
        });
    });

    $(document).on('click', '.btn-red', function() {

        const row = $(this).closest('.mainRow');
        const id = $(row).attr('id');

        $.ajax({
            url: `/api/v1/wishlist-objects/${id}`,
            method: 'DELETE',
            timeout: 0,
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

    $('td img').click(function() {
        window.location.href = '/product';
    })

});