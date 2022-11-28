$.ajax({
    url: '/api/v1/products/find/pending',
    method: 'GET',
    async: false,
    success: function(response)
    {
        response.forEach((product) =>
        {
            $('#table-body').append(/*html*/`
                <tr role="button">
                    <td scope="row">1</td>
                    <td>${product.name}</td>
                    <td>
                        <img class="img-fluid rounded-circle" width="40" height="40" src="/api/v1/images/${product.profilePicture}">
                        <span>${product.username}</span>
                    </td>
                    <td>${product.createdAt}</td>
                    <td>
                        <button class="btn btn-success shadow-none rounded-1 btn-approve" value="${product.id}"><i class="fa fa-check"></i></button>
                        <button class="btn btn-danger shadow-none rounded-1 btn-denied" value="${product.id}"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `);
        })
    }
})

$(document).ready(function() {

    $('#table-products').DataTable({
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

    $('.btn-side-bar').click(function() {
        $('.side-bar').toggleClass('active');
    });

    $(document).on('click', '.btn-approve', function() {
        $(this).closest('tr').remove();

        const id = $(this).val();

        $.ajax({
            url: `/api/v1/products/${id}/approve`,
            method: 'POST',
            success: function(response) {
                console.log(response);
                Toast.fire({
                    icon: 'success',
                    title: 'El producto ha sido aprobado'
                });
            } 
        });

        
    });

    $(document).on('click', '.btn-denied', function() {
        $(this).closest('tr').remove();

        const id = $(this).val();

        $.ajax({
            url: `/api/v1/products/${id}/denied`,
            method: 'POST',
            success: function(response) {
                console.log(response);
                Toast.fire({
                    icon: 'error',
                    title: 'El producto ha sido rechazado'
                });
            } 
        });
        
    });

});