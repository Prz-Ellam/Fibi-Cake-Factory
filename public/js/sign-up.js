import '../vendor/node_modules/jquery/dist/jquery.min.js';
import '../vendor/node_modules/jquery-validation/dist/jquery.validate.min.js';
import '../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js';
import 'https://kit.fontawesome.com/48ce36e499.js';

$(document).ready(function () {

    // Actual date
    var date = new Date();
    var dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
    document.getElementById('birth-date').value = dateFormat;

    // RFC
    $.validator.addMethod('email5322', function (value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    // Date Range
    $.validator.addMethod("dateRange", function (value, element, parameter) {
        return this.optional(element) ||
            !(Date.parse(value) > Date.parse(parameter[1]) || Date.parse(value) < Date.parse(parameter[0]));
    }, 'Please enter a valid date');

    // Username
    $.validator.addMethod("username", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}$/.test(value);
    }, 'Please enter a valid username');

    // Data size (no puede pesar mas de 8MB)
    $.validator.addMethod('filesize', function (value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result;
        }

        const size = parseFloat((element.files[0].size / 1024.0 / 1024.0).toFixed(2));
        result = (size > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    // Regex for password
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

    $.validator.addMethod('specialchars', function (value, element) {
        var regexp = new RegExp(/[¡”"#$%&;/=’?!¿:;,.\-_+*{}\[\]]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('regex', function (value, element, parameter) {
        var regexp = new RegExp(parameter);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $('#sign-up-form').validate({
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
                required: true,
                regex: /^[a-zA-Z \u00C0-\u00FF]+$/
            },
            'lastName': {
                required: true,
                regex: /^[a-zA-Z \u00C0-\u00FF]+$/
            },
            'visible': {
                required: true
            },
            'gender': {
                required: true
            },
            'birthDate': {
                required: true,
                date: true,
                dateRange: ['1900-01-01', dateFormat]
            },
            'password': {
                required: true,
                minlength: 8,
                lower: true,
                upper: true,
                numbers: true,
                specialchars: true
            },
            'confirmPassword': {
                required: true,
                equalTo: '#password' // Igual que la contraseña
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
                remote: 'El nombre de usuario está siendo usado por alguien más.'
            },
            'firstName': {
                required: 'El nombre no puede estar vacío.',
                regex: 'El nombre solo puede contener letras.'
            },
            'lastName': {
                required: 'El apellido no puede estar vacío.',
                regex: 'El apellido solo puede contener letras'
            },
            'visible': {
                required: 'La visibilidad de usuario es requerida'
            },
            'birthDate': {
                required: 'La fecha de nacimiento no puede estar vacía.',
                date: 'La fecha de nacimiento debe tener formato de fecha.',
                dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
            },
            'gender': {
                required: 'El sexo no puede estar vacío.'
            },
            'password': {
                required: 'La contraseña no puede estar vacía.',
                minlength: 'Faltan requerimentos de la contraseña',
                lower: 'Faltan requerimentos de la contraseña',
                upper: 'Faltan requerimentos de la contraseña',
                numbers: 'Faltan requerimentos de la contraseña',
                specialchars: 'Faltan requerimentos de la contraseña'
            },
            'confirmPassword': {
                required: 'Confirmar contraseña no puede estar vacío.',
                equalTo: 'Confirmar contraseña no coincide con contraseña'
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
        },
        highlight: function (element, errorClass, validClass) {
            //$(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            //$(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    $('#btn-password').click(function () {
        let mode = $('#password').attr('type');

        if (mode === 'password') {
            $('#password').attr('type', 'text');
            $('#password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#password').attr('type', 'password');
            $('#password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#btn-confirm-password').click(function () {
        let mode = $('#confirm-password').attr('type');

        if (mode === 'password') {
            $('#confirm-password').attr('type', 'text');
            $('#confirm-password-icon').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#confirm-password').attr('type', 'password');
            $('#confirm-password-icon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Validar que solo se inserten imagenes
    $('#profile-picture').on('change', function (e) {

        // Si se le da Cancelar, se pone la imagen por defecto y el path vacio
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

    // TODO: Generalizar esto
    $.fn.password = function (options) {

        $(this).on('input', () => {

            var value = $(this).val();

            if (value === '') {
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

            if (lowercase.test(value)) {
                $('.pwd-lowercase').addClass('text-success').removeClass('text-danger');
            }
            else {
                $('.pwd-lowercase').addClass('text-danger').removeClass('text-success')
            }

            if (uppercase.test(value)) {
                $('.pwd-uppercase').addClass('text-success').removeClass('text-danger');
            }
            else {
                $('.pwd-uppercase').addClass('text-danger').removeClass('text-success')
            }

            if (number.test(value)) {
                $('.pwd-number').addClass('text-success').removeClass('text-danger');
            }
            else {
                $('.pwd-number').addClass('text-danger').removeClass('text-success')
            }

            if (specialchars.test(value)) {
                $('.pwd-specialchars').addClass('text-success').removeClass('text-danger');
            }
            else {
                $('.pwd-specialchars').addClass('text-danger').removeClass('text-success')
            }

            if (value.length >= 8) {
                $('.pwd-length').addClass('text-success').removeClass('text-danger');
            }
            else {
                $('.pwd-length').addClass('text-danger').removeClass('text-success')
            }

        });

    }

    $('#password').password();

    $('#sign-up-form').submit(function (event) {

        event.preventDefault();

        if ($(this).valid() === false) {
            return;
        }

        // Send Sign Up Request
        $.ajax({
            method: 'POST',
            url: 'api/v1/users',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                // Debe devolver un token con el inicio de sesion
                console.log(response);
                if (response.status) {
                    window.location.href = "/home";
                }
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                console.log(response);

                const responseText = xhr.responseJSON;
                let htmlText = '<ul>';
                for (const [key, value] of Object.entries(responseText.message)) {
                   
                    for (const [key2, value2] of Object.entries(value)) {
                        console.log(value2);
                        htmlText += `<li>${value2}</li>`;
                    }
                }
                htmlText += '</ul>';

                if (!responseText.status) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: htmlText,
                        confirmButtonColor: "#FF5E1F",
                    });
                }
            },
            complete: function () {
                //console.log('Complete');
            }
        });

    });

});