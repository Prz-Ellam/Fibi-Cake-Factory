$.ajax({
    url: '/api/v1/reports/order-report',
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.forEach((element) => 
        {
            $('#table-body').append(/*html*/`
                <tr role="button">
                    <td>${element.date}</td>
                    <td>${element.categories}</td>
                    <td>${element.productName}</td>
                    <td>${element.rate}</td>
                    <td>${element.price}</td>
                </tr>
            `);
        });

    }
});

$(document).ready(function() {

    var table = $('#orders-report').DataTable({
        bAutoWidth: false,
        responsive: true,
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


});