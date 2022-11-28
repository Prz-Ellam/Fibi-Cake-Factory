import { getSession } from './utils/session.js';
import { updateProductValidator } from './validators/update-product-validator.js';
const id = getSession();

$.ajax({
    url: '/api/v1/categories',
    method: 'GET',
    async: false,
    success: function(response) {
        response.forEach(element => {
            $('#categories').append(`<option value="${element.id}">${element.name}</option>`);
        });
    }
});

const imageDataTransfer = new DataTransfer();

$.ajax({
    url: `/api/v1/products/${new URLSearchParams(window.location.search).get("search") || '0'}`,
    method: 'GET',
    async: false,
    success: function(response) {
        console.log(response);

        $('#name').val(response.name);
        $('#description').val(response.description);
        $('#price').val(response.price);
        $('#stock').val(response.stock);
        if (response.is_quotable) {
            $('#cotizar').attr('checked', '');
        }
        else {
            $('#vender').attr('checked', '');
        }

        response.images.forEach(async function (image) {

            $.ajax({
                url: `/api/v1/images/${image}`,
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
                    const id = headers.getResponseHeader('x-image-id');

                    $('#image-list').append(/*html*/`
                    <span class="position-relative" style="display: inline-block" id="image-${id}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute">&times;</button>
                        <img class="product-mul" src="/api/v1/images/${image}">
                    </span>
                    `);

                    const file = new File([response], filename, {
                        type: mime,
                        lastModified: new Date(lastModified)
                    });
                    imageDataTransfer.items.add(file);

                    document.getElementById('images').files = imageDataTransfer.files;
                    console.log(document.getElementById('images').files);
                }
            });
        });

        let video = response.video;

            $.ajax({
                url: `/api/v1/videos/${response.video}`,
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
                    const id = headers.getResponseHeader('x-image-id');

                    $('#video-place').html(`
                    <span class="position-relative">
                        <video class="product-mul" controls>
                            <source src="/api/v1/videos/${video}">
                        </video>
                    </span>
                    <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                    `);

                    const file = new File([response], filename, {
                        type: mime,
                        lastModified: new Date(lastModified)
                    });
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    document.getElementById('video').files = dataTransfer.files;
                }
            });

        response.categories.forEach(element => {
            $(`[value="${element}"`).attr('selected', '');
        });
    }
});

$(document).ready(function() {

    updateProductValidator('#update-product-form');

    $('#sell').click(function() {
        $('#price').removeAttr('disabled');
    });

    $('#cotizar').click(function() {
        $('#price').attr('disabled', 'true');
    });

    $('#categories').multipleSelect({
        selectAll: false,
        width: '100%',
        filter: true
    });

    $('#create-category-form').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 20
            },
            'description': {
                maxlength: 50
            }
        },
        messages: {
            'name': {
                required: 'El nombre no puede estar vacío.',
                maxlength: 'El nombre de la categoría es muy largo'
            },
            'description': {
                maxlength: 'La descripción de la categoría es muy largo'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    var imageCounter = 0;
    $('#images-transfer').on('change', function(e) {

        const files = this.files;
        const filesArray = Array.from(files);

        filesArray.forEach(file => {

            let fileReader = new FileReader();
            fileReader.onload = function(e) {
                $('#image-list').append(/*html*/`
                    <span class="position-relative d-inline-block" id="image-${imageCounter}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute">&times;</button>
                        <img class="product-mul" src="${e.target.result}">
                    </span>
                `);
            }

            fileReader.readAsDataURL(file);
            imageDataTransfer.items.add(file);

        });
        
        document.getElementById('images').files = imageDataTransfer.files;
        this.value = '';
        console.log(document.getElementById('images').files);
    });

    $(document).on('click', '.image-close', function(event) {

        event.preventDefault();

        const imageList = document.getElementById('image-list');
        // Devuelve el indice de un elemento con respecto a su nodo padre
        const index = Array.from(imageList.children).indexOf(this.parentNode);

        imageDataTransfer.items.remove(index);
        this.parentNode.remove();

        document.getElementById('images').files = imageDataTransfer.files;
        console.log(document.getElementById('images').files);

    });

    $('#video').on('change', function(e) {

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
                <span class="position-relative">
                    <video class="product-mul" controls>
                        <source src="${e.target.result}">
                    </video>
                </span>
                <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                `);
        };

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

    $(document).on('click', '.video-close', function(event) {

        $('#video-place').html('');
        document.getElementById('video').value = '';

    });

    $('#product-edition-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        const requestBody = new FormData(this);
        $.ajax({
            url: `api/v1/products/${new URLSearchParams(window.location.search).get("search") || '0'}`,
            method: 'PUT',
            data: requestBody,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Completado!',
                        text: response.message,
                        confirmButtonColor: "#FF5E1F",
                    }).then(result => {
                        window.location.href = '/home';
                    });
                }
            },
            error: function(response, status, error) {
                console.log(status);
            }
        });

    });

    $('#create-category-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        const modal = document.getElementById('create-category');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        $.ajax({
            url: 'api/v1/categories',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                
                fetch('/api/v1/categories')
                .then(response => response.json())
                .then(response => {
                    $('#categories').html('');
                    response.forEach(category => {
                        $('#categories').append(`<option value="${category.id}">${category.name}</option>`);
                    });
                    $('#categories').multipleSelect('refresh');
                });

            },
            error: function(response, status, error) {
                console.log(status);
            }
        });

    });

});