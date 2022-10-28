import '../vendor/node_modules/jquery/dist/jquery.min.js';
import '../vendor/node_modules/jquery-validation/dist/jquery.validate.min.js';
import '../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js';
import 'https://kit.fontawesome.com/48ce36e499.js';

import { loginValidator } from './validators/login-validator.js';

$(document).ready(function () {

    loginValidator('#login-form');

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

        const modal = document.getElementById('restore-password');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

    });

})