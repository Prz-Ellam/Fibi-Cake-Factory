import { createProductValidator } from './validators/create-product-validator.js';
import { getSession } from './utils/session.js';
import { createCategoryValidator } from './validators/create-category-validator.js';
const id = getSession();

$.ajax({
    url: `api/v1/users/${id}`,
    method: 'GET',
    async: false,
    success: function(response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

$.ajax({
    url: 'api/v1/categories',
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(function(element) {
            $('#categories').append(`<option value="${element.id}">${element.name}</option>`);
        });
    }
});

$(document).ready(function() {

    createProductValidator('#create-product-form');
    createCategoryValidator('#create-category-form');

    $('#sell').click(function() {
        $('#price').removeAttr('disabled');
    });

    $('#cotizar').click(function() {
        $('#price').attr('disabled', 'true');
        $('#price').val('0.00');
    });
    
    $('#categories').multipleSelect({
        selectAll: false,
        width: '100%',
        filter: true
    });

    const imageDataTransfer = new DataTransfer();
    const images = [];
    var imageCounter = 0;
    $('#images-transfer').on('change', function(e) {

        const files = $(this)[0].files;
        $.each(files, function(i, file) {

            let fileReader = new FileReader();
            fileReader.onload = function(e) {
                $('#image-list').append(/*html*/`
                    <span class="position-relative" id="image-${imageCounter}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute">&times;</button>
                        <img class="product-mul" src="${e.target.result}">
                    </span>
                `);
                images.push({
                    'id': imageCounter,
                    'file': file
                });
                imageCounter++;

                const dataTransfer = new DataTransfer();
                images.forEach((element) => {
                    dataTransfer.items.add(element.file);
                });
                document.getElementById('images').files = dataTransfer.files;
            };
            fileReader.readAsDataURL(file);

        });

        $(this).val('');

    });

    $(document).on('click', '.image-close', function(event) {

        const imageHTML = $(this).parent();
        const id = Number(imageHTML.attr('id').split('-')[1]);

        const deletedImage = images.filter((image) => {
            return image.id === id;
        })[0];

        images.forEach((element, i) => {
            if (element.id === deletedImage.id)
            {
                images.splice(i, 1);
            }
        });

        imageHTML.remove();

        const dataTransfer = new DataTransfer();
        images.forEach(element => {
            dataTransfer.items.add(element.file);
        });
        document.getElementById('images').files = dataTransfer.files;

    });

    $('#video').on('change', function(event) {

        const files = $(this)[0].files;
        if (files.length === 0) return;

        const file = $(this)[0].files[0];
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        var regexpImages = /^(video\/.*)/i;
        if (!regexpImages.exec(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La video que ingresaste no es permitida',
                confirmButtonColor: "#FF5E1F",
            });
            $(this).val('');
            return;
        }

        fileReader.onloadend = function(e) {
            $('#video-place').html(`
                <span class="position-relative" id="video-${1}">
                    <video class="product-mul" controls>
                        <source src="${e.target.result}">
                    </video>
                </span>
                <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                `);
        };

    });

    $('#create-category-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        modal = document.getElementById('create-category');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        $.ajax({
            url: 'api/v1/categories',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                $('#categories').append(`<option value="${response.data.id}">${response.data.name}</option>`);
                $('#categories').multipleSelect('refresh');
            },
            error: function(response, status, error) {
                console.log(status);
            },
            complete: function() {
            }
        });

    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    $('#create-product-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        $.ajax({
            method: 'POST',
            url: 'api/v1/products',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);

                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido al carrito'
                }).then(result => {
                    //window.location.href = '/home';
                });
            },
            error: function(response, status, error) {
                console.log(status);
            }
        });
    });
});