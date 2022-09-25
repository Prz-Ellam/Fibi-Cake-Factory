

class Wishlist
{
    constructor(name, description, visibility, images)
    {
        this.name = name;
        this.description = description;
        this.visibility = visibility;
        this.images = images;
    }
}

function getImages() {

    let imagesHTML;
    $('#add-image-list').children('span').each(function(i, element) {

        const dataURL = $(element).find('.product-mul').attr('src');
        imagesHTML += /*html*/`
        <div class="carousel-item${(i == 0 ? " active" : "")}" data-bs-interval="10000">
            <div class="ratio ratio-4x3">
                <img src="${dataURL}" class="card-img-top w-100 h-100">
            </div>
        </div>
        `;
    });

    return imagesHTML;

}

function WishlistCard(wishlist) {

    const visibility = (Number(wishlist.visibility) === 1) ? 
    `<p class="text-brown wishlist-visibility" value="1"><i class="fas fa-users" aria-hidden="true"></i> Pública</p>`
    :
    `<p class="text-brown wishlist-visibility" value="2"><i class="fas fa-lock"></i> Privada</p>`;

    const card = $($.parseHTML(/*html*/`
    <div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch">
        <div class="card mx-auto" style="width: 18rem;">
            <div class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    ${getImages()}
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title text-brown wishlist-name">${wishlist.name}</h5>
                <p class="card-text text-brown mb-2 wishlist-description">${wishlist.description}</p>
                ${visibility}
                <div class="d-flex justify-content-start">
                    <a href="#" class="btn btn-blue shadow-none rounded-1 me-1 edit-wishlist" data-bs-toggle="modal" data-bs-target="#edit-wishlist">Editar</a>
                    <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-wishlist">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    `));

    $('#wishlist-container').append(card);
    //console.log(jqCard)
    var carouselDOM = $(card).find('.card .carousel')[0];
    console.log(carouselDOM);
    var carousel = new bootstrap.Carousel(carouselDOM);
    carousel.cycle();

}

function getImageHTML(images)
{
    var html = '';

    if (images.length < 1)
    {
        return /*html*/`
            <div class="carousel-item active" data-bs-interval="10000">
                <div class="ratio ratio-4x3">
                    <img src="assets/img/wishlist-default.jpg" class="card-img-top w-100 h-100">
                </div>
            </div>
        `;
    }

    images.forEach((image, i) => {
        html += /*html*/`
            <div class="carousel-item${(i == 0 ? " active" : "")}" data-bs-interval="10000">
                <div class="ratio ratio-4x3">
                    <img src="/api/v1/images/${image}" class="card-img-top w-100 h-100">
                </div>
            </div>
        `;
    });

    return html;
}

function createWishlistCard(wishlist)
{
    return $($.parseHTML(/*html*/`
    <div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch" id="${wishlist.id}">
        <div class="card mx-auto" style="width: 18rem;">
            <div class="carousel slide" data-bs-ride="carousel" role="button">
                <div class="carousel-inner">
                    ${ getImageHTML(wishlist.images) }
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title text-brown wishlist-name">${wishlist.name}</h5>
                <p class="card-text text-brown wishlist-description mb-2">${wishlist.description}</p>
                ${ (wishlist.visibility === 1) ? 
                    /*html*/`<p class="text-brown wishlist-visibility" value="1"><i class="fas fa-users" aria-hidden="true"></i> Pública</p>` : 
                    /*html*/`<p class="text-brown wishlist-visibility" value="2"><i class="fas fa-lock"></i> Privada</p>`
                }
                <div class="d-flex justify-content-start">
                    <a href="#" class="btn btn-blue shadow-none rounded-1 me-1 edit-wishlist" data-bs-toggle="modal" data-bs-target="#edit-wishlist">Editar</a>
                    <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-wishlist">Eliminar</a>
                </div>
            </div>
        </div>
    </div>
    `));
}


const wishlistCard = /*html*/`
<div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch">
    <div class="card mx-auto" style="width: 18rem;">
        <div class="carousel slide" data-bs-ride="carousel" role="button">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <div class="ratio ratio-4x3">
                        <img src="assets/img/wishlist.png" class="card-img-top w-100 h-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title text-brown wishlist-name">Nombre de la lista</h5>
            <p class="card-text text-brown wishlist-description mb-2">Descripción de la lista</p>
            <p class="text-brown wishlist-visibility" value="1">
                <i class="fas fa-users" aria-hidden="true"></i> Pública
            </p>
            <div class="d-flex justify-content-start">
                <a href="/edit-product" class="btn btn-blue shadow-none rounded-1 me-1 edit-wishlist" data-bs-toggle="modal" data-bs-target="#edit-wishlist">Editar</a>
                <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-wishlist">Eliminar</a>
            </div>
        </div>
    </div>
</div>
`;

$.ajax({
    url: "api/v1/session",
    method: "GET",
    timeout: 0,
    success: function(response) {
        console.log(response.id);

        $.ajax({
            url: `api/v1/users/${response.id}/wishlists`,
            method: 'GET',
            timeout: 0,
            success: function(response) {
                response.forEach(function(element) {
                    const wishlist = createWishlistCard(element);
                    $('#wishlist-container').append(wishlist);
                    var carouselDOM = $(wishlist).find('.card .carousel')[0];
                    var carousel = new bootstrap.Carousel(carouselDOM);
                    carousel.cycle();
                });
            }
        });
    }
});

$(document).ready(function() {

    // Data size (no puede pesar mas de 8MB)
    $.validator.addMethod('filesize', function(value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result; 
        }

        const size = (element.files[0].size / 1024 / 1024).toFixed(2);
        result = (parseFloat(size) > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    $('#add-wishlist-form').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 20
            },
            'description': {
                required: true,
                maxlength: 50
            },
            'visibility': {
                required: true
            }
        },
        messages: {
            'name': {
                required: 'El nombre de la lista de deseos no puede estar vacío.',
                maxlength: 'El nombre de la lista es demasiado largo'
            },
            'description': {
                required: 'La descripción de la lista de deseos no puede estar vacía.',
                maxlength: 'La descripción de la lista es demasiado larga'
            },
            'visibility': {
                required: 'La visibilidad no puede estar vacía.'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#edit-wishlist-form').validate({
        rules: {
            'name': {
                required: true,
                maxlength: 20
            },
            'description': {
                required: true,
                maxlength: 50
            },
            'visibility': {
                required: true
            }
        },
        messages: {
            'name': {
                required: 'El nombre de la lista de deseos no puede estar vacío.',
                maxlength: 'El nombre de la lista es demasiado largo'
            },
            'description': {
                required: 'La descripción de la lista de deseos no puede estar vacía.',
                maxlength: 'La descripción de la lista es demasiado larga'
            },
            'visibility': {
                required: 'La visibilidad no puede estar vacía.'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
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

    $(document).on('click', '.ratio', function() {

        const id = $(this).parent().parent().parent().parent().parent().attr('id');
        console.log(id);

        window.location.href = `/wishlist?search=${id}`;

    });



    

    var element;

    $('#btn-delete-wishlist').click(function() {

        const card = element.parent().parent().parent().parent();
        const wishlistId = $(card).attr('id');
        card.remove();

        $.ajax({
            url: `api/v1/wishlists/${wishlistId}`,
            method: 'DELETE',
            success: function(response) {
                console.log(response);
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Tu lista de deseos ha sido eliminada'
        });

    });

    $(document).on('click', '.btn-red', function() {
        element = $(this);
    });

    async function imageToDataURL(imageUrl) {
        let img = await fetch(imageUrl);
        img = await img.blob();
        let bitmap = await createImageBitmap(img);
        let canvas = document.createElement("canvas");
        let ctx = canvas.getContext("2d");
        canvas.width = bitmap.width;
        canvas.height = bitmap.height;
        ctx.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height);
        return canvas.toDataURL("image/png");
        // image compression? 
        // return canvas.toDataURL("image/png", 0.9);
    };

    var editImages = [];
    var editImageCounter = 0;
    var editCard;
    var wishlistId;
    $(document).on('click', '.edit-wishlist' ,function(){
        
        editImages = [];
        editImageCounter = 0;

        editCard = $(this).parent().parent();
        const card = $(editCard).parent().parent();
        wishlistId = $(card).attr('id');

        let a = $(editCard).parent().find('.carousel .carousel-inner');

        $('#edit-image-list').html('');
        let i = 0;

        const fileInput = document.getElementById('edit-images');

        const dataTransfer = new DataTransfer();
        $(a).children('.carousel-item').each(async function() {
            
            $.ajax({
                url: this.children[0].children[0].src,
                method: 'GET',
                timeout: 0,
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

                    $('#edit-image-list').append(`
                    <span class="position-relative" id="${id}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute" onclick="$(this).parent().remove()">&times;</button>
                        <img class="product-mul" src="${this.children[0].children[0].src}">
                    </span>
                    `);
                    i++;
            
                    const file = new File([response], filename, {
                        type: mime,
                        lastModified: new Date(lastModified)
                    });

                    editImages.push({
                        'id': imageCounter,
                        'file': file
                    });
                    imageCounter++;
    
                    const dataTransfer = new DataTransfer();
                    editImages.forEach((element) => {
                        dataTransfer.items.add(element.file);
                    });
                    fileInput.files = dataTransfer.files;
                }
            });
        })


        $('#edit-wishlist-name').val($(editCard).find('.wishlist-name').text());
        $('#edit-wishlist-description').val($(editCard).find('.wishlist-description').text());
        $('#edit-wishlist-visibility').val($(editCard).find('.wishlist-visibility').attr('value'));

    });

    // Agregar Listas de deseos
    const images = [];
    var imageCounter = 0;
    $('#add-images-transfer').on('change', function(e) {

        const files = $(this)[0].files;
        $.each(files, function(i, file) {

            let fileReader = new FileReader();
            fileReader.onload = function(e) {
                $('#add-image-list').append(/*html*/`
                    <span class="position-relative" id="image-${imageCounter}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute" onclick="$(this).parent().remove()">&times;</button>
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

    // Eliminar una imagen
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

        console.log(images);
        console.log(images.length);

    });

    $('#edit-images-transfer').on('change', function(e) {

        const files = $(this)[0].files;
        $.each(files, function(i, file) {

            let reader = new FileReader();
            reader.onload = function(e) {
                $('#edit-image-list').append(`
                    <span class="position-relative" id="image-${editImageCounter}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute" onclick="$(this).parent().remove()">&times;</button>
                        <img class="product-mul" src="${e.target.result}">
                    </span>
                `);
                editImages.push({
                    'id': editImageCounter,
                    'file': file
                });
                editImageCounter++;

                const dataTransfer = new DataTransfer();
                editImages.forEach((element) => {
                    dataTransfer.items.add(element.file);
                });
                document.getElementById('edit-images').files = dataTransfer.files;
            };
            reader.readAsDataURL(file);

        });

        $(this).val('');

    });


    $('#wishlist-image').on('change', function(e) {
            
        // Si se le da Cancelar, se pone la imagen por defecto y el path vacio
        //if($(this)[0].files[0].size === 0){
        //    let img = document.getElementById('picture-box');
        //    img.setAttribute('src', 'Assets/blank-profile-picture.svg');
            
        //    var fileInputPhoto = document.getElementById('photo');
        //    fileInputPhoto.value = '';
        //    return;
        //}
        
        let reader = new FileReader();
        reader.readAsDataURL($(this)[0].files[0]);
        
        // A PARTIR DE AQUI ES TEST PARA VALIDAR QUE SOLO SE INGRESEN IMAGENES
        var filePath = $('#wishlist-image').val();
            
        // Allowing file type
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                
        if (!allowedExtensions.exec(filePath)) {
                //alert('Invalid file type' + fileInput.value);
                fileInput.value = '';
                
                reader.onloadend = function(e) {
                    let img = document.getElementById('picture-box');
                    img.setAttribute('src', 'Assets/blank-profile-picture.svg');
                    img.style.opacity = '1';
                    photo.style.opacity = '1';
                };
                
                return;
        }     
        // AQUI TERMINA LA VALIDACION PARA EL TIPO DE IMAGEN
        
        reader.onloadend = function(e) {
            let img = $('#picture-box');
            img.attr('src', e.target.result);
        };
    });

    function jsonEncode(formData, multiFields = null) {
        let object = Object.fromEntries(formData.entries());

        // If the data has multi-select values
        if (multiFields && Array.isArray(multiFields)) {
            multiFields.forEach((field) => {
                object[field] = formData.getAll(field);
            });
        }

        return object;
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    $('#add-wishlist-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (validations === false) {
            return;
        }

        const requestBody = new FormData(this);

        modal = document.getElementById('create-wishlist');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
        
        $.ajax({
            method: 'POST',
            url: `/api/v1/wishlists`,
            data: requestBody,
            //dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response, status, headers) {
                console.log(response);

                const wishlistCard = createWishlistCard(response.data);
                $('#wishlist-container').append(wishlistCard);
                var carouselDOM = $(wishlistCard).find('.card .carousel')[0];
                var carousel = new bootstrap.Carousel(carouselDOM);
                carousel.cycle();

                $('#add-wishlist-name').val('');
                $('#add-wishlist-description').val('');
                $('#add-wishlist-visibility').val('');

                Toast.fire({
                    icon: 'success',
                    title: 'Tu lista de deseos se ha guardado'
                });
            },
            error: function(jqXHR, status, error) {
                Toast.fire({
                    icon: 'success',
                    title: 'Hubo un error...'
                });
            },
            complete: function() {

                
                
            }
        });
        
    })

    $('#edit-wishlist-form').submit(function(event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (validations === false) {
            return;
        }

        const requestBody = new FormData(this);
        const wishlist = new Wishlist(
            requestBody.get('name'),
            requestBody.get('description'),
            requestBody.get('visibility'),
            requestBody.getAll('images[]')
        );

        modal = document.getElementById('edit-wishlist');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        $.ajax({
            method: 'POST',
            url: `/api/v1/wishlists/${wishlistId}`,
            data: requestBody,
            //dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response, status, headers) {
                console.log(response);
            }
        });

        editCard.find('.wishlist-name').text(requestBody.get('name'));
        editCard.find('.wishlist-description').text(requestBody.get('description'));
        editCard.find('.wishlist-visibility').html(
            (Number(requestBody.get('visibility')) === 1) ?
            /*html*/`<i class="fas fa-users" aria-hidden="true"></i> Pública</p>`
            :
            /*html*/`<i class="fas fa-lock"></i> Privada</p>`
        );
        editCard.find('.wishlist-visibility').attr('value', requestBody.get('visibility'));

        let cardBody = $(editCard).parent().find('.carousel .carousel-inner');
        $(cardBody).html('');
        $('#edit-image-list').children('span').each(function(i, element) {

            const dataURL = $(element).find('.product-mul').attr('src');
            const imagesHTML = /*html*/`
            <div class="carousel-item${(i == 0 ? " active" : "")}" data-bs-interval="10000">
                <div class="ratio ratio-4x3">
                    <img src="${dataURL}" class="card-img-top w-100 h-100">
                </div>
            </div>
            `;
            $(cardBody).append(imagesHTML);


        });

        Toast.fire({
            icon: 'success',
            title: 'Tu lista de deseos se ha actualizado'
        });

    });
    
});
