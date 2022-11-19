import { getSession } from './utils/session.js';
const id = getSession();

$.ajax({
    url: `api/v1/users/${id}`,
    method: 'GET',
    async: false,
    success: function (response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

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
                    <span class="position-relative" style="display: inline-block" id="${id}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute">&times;</button>
                        <img class="product-mul" src="/api/v1/images/${image}">
                    </span>
                    `);

                    const file = new File([response], filename, {
                        type: mime,
                        lastModified: new Date(lastModified)
                    });
                    dataTransfer.items.add(file);

                    document.getElementById('images').files = dataTransfer.files;
                    console.log(document.getElementById('images').files);
                }
            });
        });

        response.videos.forEach(async function (video) {

            $.ajax({
                url: `/api/v1/videos/${video}`,
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
                    <span class="position-relative" id="video-${id}">
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
                    dataTransfer.items.add(file);

                    document.getElementById('videos').files = dataTransfer.files;
                }
            });
        });

        response.categories.forEach(element => {
            $(`[value="${element.id}"`).attr('selected', '');
        });
    }
});
const dataTransfer = new DataTransfer();

$(document).ready(function() {

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

    $.validator.addMethod('fileCount', function(value, element, parameter) {
        return (element.files.length >= Number(parameter));
    }, 'Please complete the input file');

    $('#product-edition-form').validate({
        rules: {
            'name': {
                required: true
            },
            'description': {
                required: true
            },
            'price': {
                required: true,
                min: 0.01
            },
            'stock': {
                required: true,
                number: true,
                min: 1
            },
            'images': {
                fileCount: 3
            },
            'videos': {
                fileCount: 1
            },
            'categories': {
                required: true
            }
        },
        messages: {
            'name': {
                required: 'El nombre del producto no puede estar vacío.'
            },
            'description': {
                required: 'La descripción del producto no puede estar vacía.'
            },
            'price': {
                required: 'Si el producto es para vender, el precio no puede estar vacío',
                min: 'El precio del producto no puede ser $0.00 M.N'
            },
            'stock': {
                required: 'La cantidad de producto no puede estar vacía',
                number: 'La cantidad debe ser un número',
                min: 'Debe haber al menos un producto en existencia'
            },
            'images': {
                fileCount: 'La cantidad de imágenes debe ser mínimo 3'
            },
            'videos': {
                fileCount: 'La cantidad de videos debe ser mínimo 1'
            },
            'categories': {
                required: 'Las categorías no pueden estar vacías'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
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
        images.forEach((element) => {
            dataTransfer.items.add(element.file);
        });
        document.getElementById('images').files = dataTransfer.files;

    });

    $('#videos').on('change', function(e) {

        const files = $(this)[0].files;
        $.each(files, function(i, file) {

            let reader = new FileReader();
            reader.onload = function(e) {
                $('#video-place').html(`
                <span class="position-relative">
                    <video class="product-mul" controls>
                        <source src="${e.target.result}">
                    </video>
                </span>
                <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                `);
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('videos').files = dataTransfer.files;
            };
            reader.readAsDataURL(file);

        });

        $(this).val('');

    });

    $(document).on('click', '.video-close', function(event) {

        const videoHTML = $(this).prev();
        const id = Number(videoHTML.attr('id').split('-')[1]);

        const deletedVideo = videos.filter((video) => {
            return video.id === id;
        })[0];

        videos.forEach((element, i) => {
            if (element.id === deletedVideo.id)
            {
                videos.splice(i, 1);
            }
        });

        videoHTML.remove();
        $(this).remove();

        const dataTransfer = new DataTransfer();
        videos.forEach((element) => {
            dataTransfer.items.add(element.file);
        });
        document.getElementById('videos').files = dataTransfer.files;

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