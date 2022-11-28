import { getSession } from './utils/session.js';
const id = getSession();

var fmt = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

$.ajax({
    url: 'api/v1/categories',
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(category => {
            $('#sales-report-categories').append(`<option value="${category.id}">${category.name}</option>`)
        });
    }
});

$.ajax({
    url: '/api/v1/reports/sales-report',
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach((element) => {
            $('#table-body').append(/*html*/`
                <tr>
                    <td>${element.date}</td>
                    <td>${element.categories}</td>
                    <td>${element.productName}</td>
                    <td>${(element.rate === 'No reviews') ? element.rate : parseFloat(element.rate).toFixed(2)}</td>
                    <td>${fmt.format(element.price)}</td>
                    <td>${element.stock}</td>
                </tr>
            `);
        });
    }
});

$.ajax({
    url: '/api/v1/reports/sales-report2',
    method: 'GET',
    async: false,
    success: function(response)
    {
        response.forEach(element => {
            $('#table-body-2').append(/*html*/`
                <tr>
                    <td>${element.date}</td>
                    <td>${element.category}</td>
                    <td>${element.quantity}</td>
                </tr>
            `);
        });
    }
});

$(document).ready(function() {

    var detailedSalesReport = $('#detailed-sales-report').DataTable({
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
    var groupSalesReport = $('#group-sales-report').DataTable({
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

    $('#btn-sales-report').click(event => {
        
        const from = $('#date-sales-report-from').val();
        const to =  $('#date-sales-report-to').val();
        const category = $('#sales-report-categories').val();

        const query = new URLSearchParams();
        if (from !== '') query.set('from', from);
        if (to !== '') query.set('to', to);
        if (category !== '') query.set('category', category);

        $.ajax({
            url: `/api/v1/reports/sales-report?${query.toString()}`,
            method: 'GET',
            success: function(response) {
                detailedSalesReport.clear();
                response.forEach(element => {
                    detailedSalesReport.row.add([
                        element.date,
                        element.categories,
                        element.productName,
                        (element.rate === 'No reviews') ? element.rate : parseFloat(element.rate).toFixed(2),
                        fmt.format(element.price),
                        element.stock
                    ]);
                
                });
                detailedSalesReport.draw(false);
            }
        });

        $.ajax({
            url: `/api/v1/reports/sales-report2?${query.toString()}`,
            method: 'GET',
            success: function(response) {
                groupSalesReport.clear();
                response.forEach(element => {
                    groupSalesReport.row.add([
                        element.date,
                        element.category,
                        element.quantity
                    ]);
                
                });
                groupSalesReport.draw(false);
            }
        });

    });

});
