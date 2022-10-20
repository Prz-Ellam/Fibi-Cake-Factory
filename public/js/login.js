import '../vendor/node_modules/jquery/dist/jquery.min.js';
import '../vendor/node_modules/jquery-validation/dist/jquery.validate.min.js';
import '../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js';
import 'https://kit.fontawesome.com/48ce36e499.js';

$(document).ready(function () {

    // Reglas del formulario de login
    $('#login-form').validate({
        rules: {
            'loginOrEmail': {
                required: true,
                email: false
            },
            'password': {
                required: true
            }
        },
        messages: {
            'loginOrEmail': {
                required: 'El usuario o correo electrónico no puede estar vacío.'
            },
            'password': {
                required: 'La contraseña no puede estar vacía.'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $.validator.addMethod('email5322', function (value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    $('#send-mail').validate({
        rules: {
            'email': {
                required: true,
                email: false,
                email5322: true
            }
        },
        messages: {
            'email': {
                required: 'El correo electrónico no puede estar vacío.',
                email5322: 'El correo electrónico que ingresó no es válido'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#btn-password').click(function () {
        let mode = $('#password').attr('type');

        if (mode === 'password') {
            $('#password').attr('type', 'text');
            $('.fas').removeClass('fa-eye').addClass('fa-eye-slash');
        }
        else {
            $('#password').attr('type', 'password');
            $('.fas').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#login-form').submit(function (event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        $.ajax({
            url: '/api/v1/session',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                // TODO: console for debug
                console.log(response);
                if (response.status) {
                    window.location.href = '/home';
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
            },
            complete: function () {

            }
        });

    });

    $('#send-mail').submit(function (event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        const requestBody = new FormData(this);
        console.log([...requestBody]);

        const modal = document.getElementById('restore-password');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        return;
        $.ajax({
            method: 'POST',
            url: 'api/v1/email',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            dataType: 'json',
            data: JSON.stringify(requestBody),
            success: function (response) {
                // Debe devolver el token
                console.log(response);
            },
            error: function (response, status, error) {
                // Puede fallar en caso de que no exista un usuario con ese correo
                console.log(status);
            },
            complete: function () {

            }
        });

    });

})