const userRow = /*html*/`
    <tr role="button">
        <td scope="row">1</td>
        <td>
        <!--<img class="img-fluid rounded-circle" width="40" height="40" src="https://cdn.pixabay.com/user/2014/05/07/00-10-34-2_250x250.jpg"> -->
        Eliam</td>
        <td>eliam@correo.com</td>
        <td>
            <button class="btn btn-blue shadow-none rounded-1 edit-user" data-bs-toggle="modal" data-bs-target="#edit-user"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-red shadow-none rounded-1 btn-delete" data-bs-toggle="modal" data-bs-target="#delete-user"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    `;

    for (let i = 0; i < 8; i++) $('#table-users tbody').append(userRow);

$(document).ready(function() {

    var table = $('#table-users').DataTable({
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

    var row;
    $(document).on('click', '.btn-delete', function() {

        row = $(this).closest('tr');

    });

    $('#btn-delete-user').click(function() {

        table.row(row).remove().draw();

        modal = document.getElementById('delete-user');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

    });



    // Actual date
    var date = new Date();
    var dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
    document.getElementById('add-birth-date').value = dateFormat;

    // RFC
    $.validator.addMethod('email5322', function(value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    // Date Range
    $.validator.addMethod("dateRange", function(value, element, parameter) {
        return this.optional(element) ||
        !(Date.parse(value) > Date.parse(parameter[1]) || Date.parse(value) < Date.parse(parameter[0]));
    }, 'Please enter a valid date');

    // Username
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/.test(value);
    }, 'Please enter a valid username');

    // Data size (no puede pesar mas de 8MB)
    $.validator.addMethod('filesize', function(value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result; 
        }

        const size = parseFloat((element.files[0].size / 1024.0 / 1024.0).toFixed(2));
        result = (size > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    // Regex for password
    $.validator.addMethod('lower', function(value, element) {
          var regexp = new RegExp(/[a-z]/g);
          return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('upper', function(value, element) {
        var regexp = new RegExp(/[A-Z]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('numbers', function(value, element) {
        var regexp = new RegExp(/[0-9]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('specialchars', function(value, element) {
        var regexp = new RegExp(/[¡”"#$%&;/=’?!¿:;,.\-_+*{}\[\]]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('regex', function(value, element, parameter) {
        var regexp = new RegExp(parameter);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $('#admin-form').validate({
        rules: {
            'profile-picture': {
                required: true,
                filesize: 8
            },
            'email': {
                required: true,
                email: false,
                email5322: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/isEmailAvailable',
                    data: {
                        'email': function() { return $('#email').val() }
                    },
                    dataType: 'json'
                }
            },
            'username': {
                required: true,
                username: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/isUsernameAvailable',
                    data: {
                        'username': function() { return $('#username').val() }
                    },
                    dataType: 'json'
                }
            },
            'first-name': {
                required: true
            },
            'last-name': {
                required: true
            },
            'visibility': {
                required: true
            },
            'gender': {
                required: true
            },
            'birth-date': {
                required: true,
                date: true,
                dateRange: [ '1900-01-01', dateFormat ]
            },
            'password': {
                required: true,
                minlength: 8,
                lower: true,
                upper: true,
                numbers: true,
                specialchars: true
            },
            'confirm-password': {
                required: true,
                equalTo: '#add-password' // Igual que la contraseña
            }
        },
        messages: {
            'profile-picture': {
                required: 'La foto de perfil no puede estar vacía.',
                filesize: 'El archivo es demasiado pesado (máximo de 8MB)'
            },
            'email': {
                required: 'El correo electrónico no puede estar vacío.',
                email5322: 'El correo electrónico que ingresó no es válido.',
                remote: 'El correo electrónico está siendo usado por alguien más.'
            },
            'username': {
                required: 'El nombre de usuario no puede estar vacío.',
                username: 'El nombre de usuario debe contener más de 3 caracteres',
                remote: 'El nombre de usuario está siendo usado por alguien más.'
            },
            'first-name': {
                required: 'El nombre no puede estar vacío.'
            },
            'last-name': {
                required: 'El apellido no puede estar vacío.'
            },
            'visibility': {
                required: 'La visibilidad de usuario es requerida'
            },
            'birth-date': {
                required: 'La fecha de nacimiento no puede estar vacía.',
                date: 'La fecha de nacimiento debe tener formato de fecha.',
                dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
            },
            'gender': {
                required: 'El género no puede estar vacío.'
            },
            'password': {
                required: 'La contraseña no puede estar vacía.',
                minlength: 'Faltan requerimentos de la contraseña',
                lower: 'Faltan requerimentos de la contraseña',
                upper: 'Faltan requerimentos de la contraseña',
                numbers: 'Faltan requerimentos de la contraseña',
                specialchars: 'Faltan requerimentos de la contraseña'
            },
            'confirm-password': {
                required: 'Confirmar contraseña no puede estar vacío.',
                equalTo: 'Confirmar contraseña no coincide con contraseña'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {

            if ($(element)[0].name === 'gender')
            {
                error.insertAfter(element.parent().parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            if ($(element)[0].name === 'profile-picture')
            {
                error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        },
        highlight: function(element, errorClass, validClass) {
            //$(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            //$(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    $('#edit-user-form').validate({
        rules: {
            'profile-picture': {
                required: true,
                filesize: 8
            },
            'email': {
                required: true,
                email: false,
                email5322: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/isEmailAvailable',
                    data: {
                        'email': function() { return $('#email').val() }
                    },
                    dataType: 'json'
                }
            },
            'username': {
                required: true,
                username: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/isUsernameAvailable',
                    data: {
                        'username': function() { return $('#username').val() }
                    },
                    dataType: 'json'
                }
            },
            'first-name': {
                required: true
            },
            'last-name': {
                required: true
            },
            'visibility': {
                required: true
            },
            'gender': {
                required: true
            },
            'birth-date': {
                required: true,
                date: true,
                dateRange: [ '1900-01-01', dateFormat ]
            },
            'password': {
                required: true,
                minlength: 8,
                lower: true,
                upper: true,
                numbers: true,
                specialchars: true
            },
            'confirm-password': {
                required: true,
                equalTo: '#edit-password' // Igual que la contraseña
            }
        },
        messages: {
            'profile-picture': {
                required: 'La foto de perfil no puede estar vacía.',
                filesize: 'El archivo es demasiado pesado (máximo de 8MB)'
            },
            'email': {
                required: 'El correo electrónico no puede estar vacío.',
                email5322: 'El correo electrónico que ingresó no es válido.',
                remote: 'El correo electrónico está siendo usado por alguien más.'
            },
            'username': {
                required: 'El nombre de usuario no puede estar vacío.',
                username: 'El nombre de usuario debe contener más de 3 caracteres',
                remote: 'El nombre de usuario está siendo usado por alguien más.'
            },
            'first-name': {
                required: 'El nombre no puede estar vacío.'
            },
            'last-name': {
                required: 'El apellido no puede estar vacío.'
            },
            'visibility': {
                required: 'La visibilidad de usuario es requerida'
            },
            'birth-date': {
                required: 'La fecha de nacimiento no puede estar vacía.',
                date: 'La fecha de nacimiento debe tener formato de fecha.',
                dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
            },
            'gender': {
                required: 'El género no puede estar vacío.'
            },
            'password': {
                required: 'La contraseña no puede estar vacía.',
                minlength: 'Faltan requerimentos de la contraseña',
                lower: 'Faltan requerimentos de la contraseña',
                upper: 'Faltan requerimentos de la contraseña',
                numbers: 'Faltan requerimentos de la contraseña',
                specialchars: 'Faltan requerimentos de la contraseña'
            },
            'confirm-password': {
                required: 'Confirmar contraseña no puede estar vacío.',
                equalTo: 'Confirmar contraseña no coincide con contraseña'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {

            if ($(element)[0].name === 'gender')
            {
                error.insertAfter(element.parent().parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            if ($(element)[0].name === 'profile-picture')
            {
                error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        },
        highlight: function(element, errorClass, validClass) {
            //$(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            //$(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    $('#btn-password').click(function() {
        let mode = $('#add-password').attr('type');

        if (mode === 'password') {
            $('#add-password').attr('type', 'text');
            $('#add-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#add-password').attr('type', 'password');
            $('#add-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-confirm-password').click(function() {
        let mode = $('#add-confirm-password').attr('type');

        if (mode === 'password') {
            $('#add-confirm-password').attr('type', 'text');
            $('#add-confirm-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#add-confirm-password').attr('type', 'password');
            $('#add-confirm-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-edit-password').click(function() {
        let mode = $('#edit-password').attr('type');

        if (mode === 'password') {
            $('#edit-password').attr('type', 'text');
            $('#edit-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#edit-password').attr('type', 'password');
            $('#edit-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-edit-confirm-password').click(function() {
        let mode = $('#edit-confirm-password').attr('type');

        if (mode === 'password') {
            $('#edit-confirm-password').attr('type', 'text');
            $('#edit-confirm-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#edit-confirm-password').attr('type', 'password');
            $('#edit-confirm-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // TODO: Hacer jalar esto
    $('#profile-picture').on('change', function(e) {
        
        // Si se le da Cancelar, se pone la imagen por defecto y el path vacio
        if($(this)[0].files.length === 0)
        {
            $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
            $('#profile-picture').val('');
            return;
        }
        
        const reader = new FileReader();
        reader.readAsDataURL($(this)[0].files[0]);
        
        // A PARTIR DE AQUI ES TEST PARA VALIDAR QUE SOLO SE INGRESEN IMAGENES
        const file = $(this)[0].files[0];
             
        // Allowing file type as image/*
        var regexpImages = /^(image\/.*)/i;
        if (!regexpImages.exec(file.type))
        {
            $(this).val('');
            reader.onloadend = function(e) {
                $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
                $('#profile-picture').val('');
            };
            return;
        }

        // AQUI TERMINA LA VALIDACION PARA EL TIPO DE IMAGEN
        reader.onloadend = function(e) {
            $('#picture-box').attr('src', e.target.result);
        };
    });

    // TODO: Generalizar esto
    $.fn.password = function(options) {

        $(this).on('input', () => {

            var value = $(this).val();

            if (value === '') 
            {
                $('.pwd-lowercase').removeClass('text-danger text-success');
                $('.pwd-uppercase').removeClass('text-danger text-success');
                $('.pwd-number').removeClass('text-danger text-success');
                $('.pwd-specialchars').removeClass('text-danger text-success');
                $('.pwd-length').removeClass('text-danger text-success');
                return;
            }
    
            var lowercase = new RegExp(/[a-z]/g);
            var uppercase = new RegExp(/[A-Z]/g);
            var number = new RegExp(/[0-9]/g);
            var specialchars = new RegExp(/[¡”"#$%&;/=’¿?!:;,.\-_+*{}\[\]]/g);

            if (lowercase.test(value))
            {
                $('.pwd-lowercase').addClass('text-success').removeClass('text-danger');
            }
            else
            {
                $('.pwd-lowercase').addClass('text-danger').removeClass('text-success')
            }

            if (uppercase.test(value))
            {
                $('.pwd-uppercase').addClass('text-success').removeClass('text-danger');
            }
            else
            {
                $('.pwd-uppercase').addClass('text-danger').removeClass('text-success')
            }

            if (number.test(value))
            {
                $('.pwd-number').addClass('text-success').removeClass('text-danger');
            }
            else
            {
                $('.pwd-number').addClass('text-danger').removeClass('text-success')
            }

            if (specialchars.test(value))
            {
                $('.pwd-specialchars').addClass('text-success').removeClass('text-danger');
            }
            else
            {
                $('.pwd-specialchars').addClass('text-danger').removeClass('text-success')
            }

            if (value.length >= 8)
            {
                $('.pwd-length').addClass('text-success').removeClass('text-danger');
            }
            else
            {
                $('.pwd-length').addClass('text-danger').removeClass('text-success')
            }

        });
        
    }

    $('#add-password').password();

    $('#admin-form').submit(function(event) {

        event.preventDefault();

        if($(this).valid() === false) {
            return;
        }

        modal = document.getElementById('add-user');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        const requestBody = new FormData(this);
        console.log([...requestBody]);

        table.row.add([
            '1', 
            requestBody.get('first-name'), 
            requestBody.get('email'), 
            `<button class="btn btn-blue shadow-none rounded-1 edit-user" data-bs-toggle="modal" data-bs-target="#edit-user"><i class="fa fa-pencil"></i></button>
             <button class="btn btn-red shadow-none rounded-1 btn-delete" data-bs-toggle="modal" data-bs-target="#delete-user"><i class="fa fa-trash"></i></button>`
        ]).draw();
        // Send Sign Up Request
        $.ajax({
            method: 'POST',
            url: 'api/v1/users',
            data: requestBody,
            //dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // Debe devolver un token con el inicio de sesion
                console.log(response);
                //window.location.href = "http://localhost:8080/home";
            },
            error: function(response, status, error) {
                console.log(status);
            },
            complete: function() {

            }
        });

    });


    $(document).on('click', '.edit-user', function() {

        row = $(this).closest('tr');

        const data = table.row(row).data();

    });

    $('#edit-user-form').submit(function(event) {

        event.preventDefault();

    });

});