import '../vendor/node_modules/jquery/dist/jquery.min.js';
import '../vendor/node_modules/jquery-validation/dist/jquery.validate.min.js';
import '../vendor/node_modules/bootstrap/dist/js/bootstrap.min.js';
import 'https://kit.fontawesome.com/48ce36e499.js';

import { signupValidator } from './validators/signup-validator.js';

$(document).ready(function () {

    signupValidator('#sign-up-form');

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
        var allowedExtensions  = /(jpg|jpeg|png|gif)$/i;
        if (!allowedExtensions.exec(file.type)) {
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

    $('#password').on('input', () => {

        var value = $('#password').val();

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

    $('#sign-up-form').submit(function (event) {

        event.preventDefault();

        if (!$(this).valid()) {
            return;
        }

        $.ajax({
            method: 'POST',
            url: '/api/v1/users',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
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
            }
        });
    });

});