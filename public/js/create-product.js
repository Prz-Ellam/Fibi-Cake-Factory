$.ajax({
    url: "api/v1/session",
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        $.ajax({
            url: `api/v1/users/${response.id}`,
            method: "GET",
            async: false,
            timeout: 0,
            success: function(response) {
                const url = `api/v1/images/${response.profilePicture}`;
                $('.nav-link img').attr('src', url);
            }
        });
    }
});

$.ajax({
    url: 'api/v1/categories',
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response) {
        response.forEach(function(element) {
            $('#categories').append(`<option value="${element.id}">${element.name}</option>`);
        });
    }
});

$(document).ready(function() {

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

    const videos = [];
    var videoCounter = 0;
    $('#videos-transfer').on('change', function(e) {

        const files = $(this)[0].files;
        $.each(files, function(i, file) {

            let reader = new FileReader();
            reader.onload = function(e) {
                $('#video-list').append(`
                <span class="position-relative" id="video-${videoCounter}">
                    <video class="product-mul" controls>
                        <source src="${e.target.result}">
                    </video>
                </span>
                <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                `);
                videos.push({
                    'id': videoCounter,
                    'file': file
                });
                videoCounter++;

                const dataTransfer = new DataTransfer();
                videos.forEach((element) => {
                    dataTransfer.items.add(element.file);
                });
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

    $.validator.addMethod('fileCount', function(value, element, parameter) {
        return (element.files.length >= Number(parameter));
    }, 'Please complete the input file');

    $('#create-product-form').validate({
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


    optionsCount = 5;
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

        const requestBody = new FormData(this);
        $.ajax({
            method: 'POST',
            url: 'api/v1/products',
            data: requestBody,
            //dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);

                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido añadido al carrito'
                }).then((result) => {
                    //window.location.href = '/home';
                });
            },
            error: function(response, status, error) {
                console.log(status);
            }
        });

    });

});