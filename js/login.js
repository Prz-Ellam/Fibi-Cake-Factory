import '../vendor/node_modules/jquery/dist/jquery.min.js';
import '../vendor/node_modules/jquery-validation/dist/jquery.validate.min.js';
import '../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js';
import 'https://kit.fontawesome.com/48ce36e499.js';

import { loginValidator } from './validators/login-validator.js';

$(document).ready(function() {

    loginValidator('#login-form');

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
            }
        });

    });

});