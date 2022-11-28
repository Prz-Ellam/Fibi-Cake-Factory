import { getSession } from './utils/session.js';
const userId = getSession();

$(document).ready(() => {

    const table = $('#quotes-table').DataTable({
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


    fetch(`/api/v1/quotes/pending?userId=${userId}`)
    .then(response => response.json())
    .then(response => {

        response.forEach(quote => {
            table.row.add([
                '',
                quote.username,
                quote.name,
                `<input class="form-control" type="number" min="0" step=0.01" id="input-${quote.quote_id}">`,
                `<button class="btn btn-success shadow-none rounded-1 btn-approve" id="${quote.quote_id}"><i class="fa fa-check"></i></button>`
            ]);

        });
        table.draw(false);

    });


    $(document).on('click', '.btn-approve', function(event) {

        const quoteId = $(this).attr('id');
        const price = $(`#input-${quoteId}`).val();
        if (price <= 0) {
            return;
        }

        var urlencoded = new URLSearchParams();
        urlencoded.append("price", price);

        fetch(`/api/v1/quotes/${quoteId}`, {
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            method: 'POST',
            body: urlencoded
        })
        .then(res => res.json())
        .then(res => {
            
            fetch(`/api/v1/quotes/pending?userId=${userId}`)
            .then(response => response.json())
            .then(response => {
                table.clear();
                response.forEach(quote => {
                    console.log(quote);
        
                    table.row.add([
                        '',
                        quote.username,
                        quote.name,
                        `<input class="form-control" type="number" min="0" step=0.01" id="input-${quote.quote_id}">`,
                        `<button class="btn btn-success shadow-none rounded-1 btn-approve" id="${quote.quote_id}"><i class="fa fa-check"></i></button>`
                    ]);
        
                });
                table.draw(false);
        
            });


        });

    });


})