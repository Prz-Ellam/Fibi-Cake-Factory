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
        Toast.fire({
            icon: 'success',
            title: 'El producto ha sido aprobado'
        });
    });

    $(document).on('click', '.btn-denied', function() {
        $(this).closest('tr').remove();
        Toast.fire({
            icon: 'error',
            title: 'El producto ha sido rechazado'
        });
    });

});