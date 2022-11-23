import { profileValidator } from "./validators/profile-validator.js";

const id = new URLSearchParams(window.location.search).get('id') || '0';

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

    profileValidator();

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

        const files = Array.from(this.files);

        // Si se le da Cancelar, se pone la imagen por defecto y el path vacio
        if (files.length === 0) {
            $('#picture-box').attr('src', './assets/img/blank-profile-picture.svg');
            $('#profile-picture').val('');
            return;
        }

        const file = files[0];

        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

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

});