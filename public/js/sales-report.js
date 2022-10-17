import { getSession } from './utils/session.js';

const id = getSession();

$.ajax({
    url: `api/v1/users/${id}`,
    method: "GET",
    async: false,
    timeout: 0,
    success: function(response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

$.ajax({
    url: 'api/v1/categories',
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response)
    {
        response.forEach((category) =>
        {
            $('#categories').append(`<option value="${category.id}">${category.name}</option>`)
        });
    }
});

$.ajax({
    url: '/api/v1/reports/sales-report',
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.forEach((element) => 
        {
            $('#table-body').append(/*html*/`
                <tr>
                    <td>${element.date}</td>
                    <td>${element.categories}</td>
                    <td>${element.productName}</td>
                    <td>${element.rate}</td>
                    <td>${element.price}</td>
                    <td>${element.stock}</td>
                </tr>
            `);
        });
    }
});

$.ajax({
    url: '/api/v1/reports/sales-report2',
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response)
    {
        response.forEach((element) => 
        {
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

});

const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
];

const data = {
    labels: labels,
    datasets: [{
        label: 'My First dataset',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [ 0, 10, 5, 2, 20, 30, 45 ],
    }]
};

const config = {
    type: 'line',
    data: data,
    options: {}
};

const myChart = new Chart(
    document.getElementById('myChart'),
    config
);