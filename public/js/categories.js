class Category {
    constructor(name, description)
    {
        this.name = name;
        this.description = description;
    }
}

$(document).ready(function() {

    var table = $('#categories').DataTable({
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

    $('.btn-side-bar').click(function() {
        $('.side-bar').toggleClass('active');
    });

    $('#create-category-form').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 20
            },
            'description': {
                maxlength: 50
            }
        },
        messages: {
            'name': {
                required: 'El nombre no puede estar vacío.',
                maxlength: 'El nombre de la categoría es muy largo'
            },
            'description': {
                maxlength: 'La descripción de la categoría es muy largo'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#edit-category-form').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 20
            },
            'description': {
                maxlength: 50
            }
        },
        messages: {
            'name': {
                required: 'El nombre no puede estar vacío.',
                maxlength: 'El nombre de la categoría es muy largo'
            },
            'description': {
                maxlength: 'La descripción de la categoría es muy largo'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    function jsonEncode(formData, multiFields = null) {
        let object = Object.fromEntries(formData.entries());

        // If the data has multi-select values
        if (multiFields && Array.isArray(multiFields)) {
            multiFields.forEach((field) => {
                object[field] = formData.getAll(field);
            });
        }

        return object;
    }

    var row;
    var count = 4;
    
    $('#create-category-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (validations === false) {
            return;
        }

        modal = document.getElementById('create-category');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        const requestBody = new FormData(this);
        console.log([...requestBody]);

        table.row.add([
            count++,
            requestBody.get('name'),
            requestBody.get('description'),
            `<button class="btn btn-primary shadow-none rounded-1 btn-edit" data-bs-toggle="modal" data-bs-target="#edit-category">
                <i class="fa fa-pencil"></i>
            </button>
            <button class="btn btn-danger shadow-none rounded-1 btn-delete" data-bs-toggle="modal" data-bs-target="#delete-category">
                <i class="fa fa-trash"></i>
            </button>`
        ]).draw();

        $('#create-category-name').val('');
        $('#create-category-description').val('');

        return;
        $.ajax({
            method: 'POST',
            url: 'api/v1/categories',
            headers: {
                'Accept' : 'application/json',
                'Content-Type' : 'application/json'
            },
            data: JSON.stringify(requestBody),
            //dataType: 'json',
            success: function(response) {
                console.log(response);
            },
            error: function(response, status, error) {
                console.log(status);
            },
            complete: function() {
                console.log('Complete');
            }
        });

    });

    $(document).on('click', '.btn-edit', function() {

        row = $(this).closest('tr');

        const dataTable = $('#categories').DataTable();
        const data = dataTable.row(row).data();

        const category = new Category(data[1], data[2]);

        $('#edit-category-name').val(category.name);
        $('#edit-category-description').val(category.description);

    });

    $('#edit-category-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (validations === false) {
            return;
        }

        const data = table.row(row).data();
        data[1] = $('#edit-category-name').val();
        data[2] = $('#edit-category-description').val();
        table.row(row).data(data).draw();

        modal = document.getElementById('edit-category');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

    });

    $(document).on('click', '.btn-delete', function() {

        row = $(this).closest('tr');

    });

    $('.delete-category').click(function() {

        table.row(row).remove().draw();

        modal = document.getElementById('delete-category');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

    });

});