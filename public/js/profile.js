const id = new URLSearchParams(window.location.search).get('id') || '0';

$.ajax({
    url: 'api/v1/session',
    method: 'GET',
    async: false,
    success: function (response) {
        $.ajax({
            url: `api/v1/users/${response.id}`,
            method: "GET",
            async: false,
            timeout: 0,
            success: function (response) {
                const url = `api/v1/images/${response.profilePicture}`;
                $('.nav-link img').attr('src', url);
            }
        });
    }
});

$.ajax({
    url: `/api/v1/users/${id}`,
    method: 'GET',
    async: false,
    success: function (response) {
        $('#picture-box').attr('src', `/api/v1/images/${response.profilePicture}`);
        //$('#email').val(response.email);
        //$('#username').val(response.username);
        //$('#birth-date').val(response.birthDate);
        //$('#first-name').val(response.firstName);
        //$('#last-name').val(response.lastName);
        /*
        switch (response.gender) {
            case 0:
                $('#other').attr('checked', '');
                break;
            case 1:
                $('#male').attr('checked', '');
                break;
            case 2:
                $('#female').attr('checked', '');
                break;
            default:
                break;
        }
        */
        $.ajax({
            url: `/api/v1/images/${response.profilePicture}`,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: (response, status, headers) => {
                const contentDisposition = headers.getResponseHeader('content-disposition');

                const filenameRegex = new RegExp(/\"(.+)\"/);
                const filename = filenameRegex.exec(contentDisposition)[1];
                const mime = headers.getResponseHeader('content-type');
                const lastModified = headers.getResponseHeader('last-modified');

                const file = new File([response], filename, {
                    type: mime,
                    lastModified: new Date(lastModified)
                });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                const fileInput = document.getElementById('profile-picture');
                fileInput.files = dataTransfer.files;
            }
        });
    }
});

$(document).ready(function () {

    var date = new Date();
    var dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
    
    // RFC
    $.validator.addMethod('email5322', function (value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    // Date Range
    $.validator.addMethod("dateRange", function (value, element, parameter) {
        return this.optional(element) ||
            !(Date.parse(value) > Date.parse(parameter[1]) || Date.parse(value) < Date.parse(parameter[0]));
    }, 'Please enter a valid date');

    $.validator.addMethod("username", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}$/.test(value);
    }, 'Please enter a valid username');

    // Data size (no puede pesar mas de 8MB)
    $.validator.addMethod('filesize', function (value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result;
        }

        const size = (element.files[0].size / 1024 / 1024).toFixed(2);
        result = (parseFloat(size) > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    // Regex
    $.validator.addMethod('lower', function (value, element) {
        var regexp = new RegExp(/[a-z]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('upper', function (value, element) {
        var regexp = new RegExp(/[A-Z]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('numbers', function (value, element) {
        var regexp = new RegExp(/[0-9]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('regex', function (value, element, parameter) {
        var regexp = new RegExp(parameter);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $('#profile-form').validate({
        rules: {
            'profilePicture': {
                required: true,
                filesize: 8
            },
            'email': {
                required: true,
                email: false,
                email5322: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/users/email/available',
                    data: {
                        'email': function () { return $('#email').val() }
                    },
                    dataType: 'json'
                }
            },
            'username': {
                required: true,
                username: true,
                minlength: 3,
                remote: {
                    type: 'POST',
                    url: 'api/v1/users/username/available',
                    data: {
                        'username': function () { return $('#username').val() }
                    },
                    dataType: 'json'
                }
            },
            'firstName': {
                required: true
            },
            'lastName': {
                required: true
            },
            'gender': {
                required: true
            },
            'birthDate': {
                required: true,
                date: true,
                dateRange: ['1900-01-01', dateFormat]
            }
        },
        messages: {
            'profilePicture': {
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
                minlength: 'El nombre de usuario debe contener más de 3 caracteres',
                remote: 'El nombre de usuario está siendo usado por alguien más.'
            },
            'firstName': {
                required: 'El nombre no puede estar vacío.'
            },
            'lastName': {
                required: 'El apellido no puede estar vacío.'
            },
            'birthDate': {
                required: 'La fecha de nacimiento no puede estar vacía.',
                date: 'La fecha de nacimiento debe tener formato de fecha.',
                dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
            },
            'gender': {
                required: 'El género no puede estar vacío.'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {

            if ($(element)[0].name === 'gender') {
                error.insertAfter(element.parent().parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            if ($(element)[0].name === 'profilePicture') {
                error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#password-form').validate({
        rules: {
            'oldPassword': {
                required: true
            },
            'newPassword': {
                required: true,
                minlength: 8,
                lower: true,
                upper: true,
                numbers: true,
                regex: /[¡”"#$%&;/=’?!¿:;,.\-_+*{}\[\]]/g
            },
            'confirmNewPassword': {
                required: true,
                equalTo: '#new-password'
            }
        },
        messages: {
            'oldPassword': {
                required: 'La contraseña no puede estar vacía.'
            },
            'newPassword': {
                required: 'La nueva contraseña no puede estar vacía.',
                minlength: 'Faltan requerimentos de la nueva contraseña',
                lower: 'Faltan requerimentos de la nueva contraseña',
                upper: 'Faltan requerimentos de la nueva contraseña',
                numbers: 'Faltan requerimentos de la nueva contraseña',
                regex: 'Faltan requerimentos de la nueva contraseña'
            },
            'confirmNewPassword': {
                required: 'Confirmar nueva contraseña no puede estar vacío.',
                equalTo: 'Confirmar nueva contraseña no coincide con nueva contraseña'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#new-password').on('input', () => {

        var value = $('#new-password').val();

        if (value === '') {
            $('.pwd-lowercase').removeClass('text-danger text-success');
            $('.pwd-uppercase').removeClass('text-danger text-success');
            $('.pwd-number').removeClass('text-danger text-success');
            $('.pwd-specialchars').removeClass('text-danger text-success');
            $('.pwd-length').removeClass('text-danger text-success');
            return;
        }

        if (/[a-z]/g.test(value)) {
            $('.pwd-lowercase').addClass('text-success').removeClass('text-danger');
        }
        else {
            $('.pwd-lowercase').addClass('text-danger').removeClass('text-success')
        }

        if (/[A-Z]/g.test(value)) {
            $('.pwd-uppercase').addClass('text-success').removeClass('text-danger');
        }
        else {
            $('.pwd-uppercase').addClass('text-danger').removeClass('text-success')
        }

        if (/[0-9]/g.test(value)) {
            $('.pwd-number').addClass('text-success').removeClass('text-danger');
        }
        else {
            $('.pwd-number').addClass('text-danger').removeClass('text-success')
        }

        if (/[¡”"#$%&;/=’¿?!:;,.\-_+*{}\[\]]/g.test(value)) {
            $('.pwd-specialchars').addClass('text-success').removeClass('text-danger');
        }
        else {
            $('.pwd-specialchars').addClass('text-danger').removeClass('text-success')
        }

        if (value.length >= 8) {
            $('.pwd-length').addClass('text-success').removeClass('text-danger');
        }
        else {
            $('.pwd-length').addClass('text-danger').removeClass('text-success');
        }

    });

    $('#btn-old-password').click(function () {
        let mode = $('#old-password').attr('type');

        if (mode === 'password') {
            $('#old-password').attr('type', 'text');
            $('#old-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#old-password').attr('type', 'password');
            $('#old-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-new-password').click(function () {
        let mode = $('#new-password').attr('type');

        if (mode === 'password') {
            $('#new-password').attr('type', 'text');
            $('#new-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#new-password').attr('type', 'password');
            $('#new-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-confirm-new-password').click(function () {
        let mode = $('#confirm-new-password').attr('type');

        if (mode === 'password') {
            $('#confirm-new-password').attr('type', 'text');
            $('#confirm-new-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#confirm-new-password').attr('type', 'password');
            $('#confirm-new-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#profile-form').submit(function (event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        $.ajax({
            url: `/api/v1/users/${id}`,
            method: 'POST',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Completado!',
                        text: response.message,
                        confirmButtonColor: "#FF5E1F",
                    });
                }
            },
            error: function (response, status, error) {
                const responseText = response.responseJSON;
                if (!responseText.status) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: responseText.message,
                        confirmButtonColor: "#FF5E1F",
                    });
                }
            }
        });

    });


    $('#password-form').submit(function (event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        $.ajax({
            url: `/api/v1/users/${id}/password`,
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Completado!',
                        text: response.message,
                        confirmButtonColor: "#FF5E1F",
                    });
                    $('#old-password').val('');
                    $('#new-password').val('');
                    $('#confirm-new-password').val('');
                }
            },
            error: function (response, status, error) {
                const responseText = response.responseJSON;

                if (!responseText.status) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: responseText.message,
                        confirmButtonColor: "#FF5E1F",
                    });
                }
            }
        });

    });

    $('#profile-picture').on('change', function (e) {

        if ($(this)[0].files.length === 0) {
            $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
            $('#profile-picture').val('');
            return;
        }

        const fileReader = new FileReader();
        fileReader.readAsDataURL($(this)[0].files[0]);

        const file = $(this)[0].files[0];

        // Allowing file type as image/*
        var regexpImages = /^(image\/.*)/i;
        if (!regexpImages.exec(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La imagen que ingresaste no es permitida',
                confirmButtonColor: "#FF5E1F",
            });
            $(this).val('');
            fileReader.onloadend = function (e) {
                $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
                $('#profile-picture').val('');
            };
            return;
        }

        fileReader.onloadend = function (e) {
            $('#picture-box').attr('src', e.target.result);
        };
    });

});