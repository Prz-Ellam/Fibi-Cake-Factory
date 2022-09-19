require('bootstrap/dist/css/bootstrap.min.css');

require('../styles/navbar.css');
require('../styles/layout.css');
require('../styles/colors.css');
require('../styles/login.css');
require('../styles/signup.css');
require('../styles/profile-picture.css');
require('../styles/footer.css');

$(document).ready(function() {

    // Actual date
    var date = new Date();
    var dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
    document.getElementById('birth-date').value = dateFormat;

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
        return this.optional(element) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){2,18}$/.test(value);
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

    $('#sign-up-form').validate({
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
                required: true,
                regex: /^[a-zA-Z \u00C0-\u00FF]+$/
            },
            'last-name': {
                required: true,
                regex: /^[a-zA-Z \u00C0-\u00FF]+$/
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
                equalTo: '#password' // Igual que la contraseña
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
                required: 'El nombre no puede estar vacío.',
                regex: 'El nombre solo puede contener letras.'
            },
            'last-name': {
                required: 'El apellido no puede estar vacío.',
                regex: 'El apellido solo puede contener letras'
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

    $('#btn-confirm-password').click(function() {
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
    $('#profile-picture').on('change', function(e) {
        
        // Si se le da Cancelar, se pone la imagen por defecto y el path vacio
        if($(this)[0].files.length === 0)
        {
            $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
            $('#profile-picture').val('');
            return;
        }
        
        const fileReader = new FileReader();
        fileReader.readAsDataURL($(this)[0].files[0]);

        const file = $(this)[0].files[0];
             
        // Allowing file type as image/*
        var regexpImages = /^(image\/.*)/i;
        if (!regexpImages.exec(file.type))
        {
            $(this).val('');
            fileReader.onloadend = function(e) {
                $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
                $('#profile-picture').val('');
            };
            return;
        }

        fileReader.onloadend = function(e) {
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

    $('#password').password();

    $('#sign-up-form').submit(function(event) {

        event.preventDefault();

        if ($(this).valid() === false) {
            return;
        }

        const requestBody = new FormData(this);
        console.log([...requestBody]);

        $.ajax({
            url: 'api/v1/users',
            method: 'POST',
            timeout: 0,
            processData: false,
            mimeType: 'multipart/form-data',
            contentType: false,
            data: requestBody,
            success: function(response) {
                // Debe devolver un token con el inicio de sesion
                console.log(response);
                //window.location.href = '/home';
            },
            error: function(response, status, error) {
                console.log(status);
            },
            complete: function() {
                
            }
        });

    });

});