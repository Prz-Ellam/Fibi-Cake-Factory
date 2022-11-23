import { getSession } from './utils/session.js';
const id = getSession();

import { wishlistCard } from './views/wishlist-card.js';
import { wishlistValidator } from './validators/wishlist-validator.js';

const template = Handlebars.compile(wishlistCard);

const page = new URLSearchParams(window.location.search).get("page") || '';
//const count = new URLSearchParams(window.location.search).get("count") || '';
fetch(`api/v1/users/${id}/wishlists?page=${page}`)
    .then(response => response.json())
    .then(response => {
        console.log(response);
        const html = template(response.wishlists);
        $('#wishlist-container').append(html);
        var carouselsDOM = document.querySelectorAll('.carousel');
        carouselsDOM.forEach(carouselDOM => {
            var carousel = new bootstrap.Carousel(carouselDOM);
            carousel.cycle();
        });

        const pagination = response.pagination;
        if (pagination.page > 1) {
            $("ul.pagination").append(`
                <li class="page-item">
                    <a class="page-link text-brown" href="?page=${pagination.page - 1}">Anterior</a>
                </li>
            `);
        }
        else {
            $("ul.pagination").append(`
                <li class="page-item disabled">
                    <a class="page-link">Anterior</a>
                </li>
            `);
        }

        let numberOfButtons = (pagination.pages > 5) ? 5 : pagination.pages;

        for (let i = 0; i < numberOfButtons; i++) {
            $("ul.pagination").append(`
                <li class="page-item ${ i + 1 === pagination.page ? "disabled" : "" }">
                    <a class="page-link ${ i + 1 === pagination.page ? "" : "text-brown" } shadow-none" href="?page=${i + 1}">${i + 1}</a>
                </li>
            `);
        }

        if (pagination.pages > numberOfButtons) {

            $("ul.pagination").append(`
                <li class="page-item disabled">
                    <span class="page-link shadow-none">...</span>
                </li>
            `);

            $("ul.pagination").append(`
                <li class="page-item">
                    <a class="page-link text-brown shadow-none" href="?page=${pagination.pages}">${pagination.pages}</a>
                </li>
            `);

        }

        if (pagination.page + 1 > pagination.pages) {
            $("ul.pagination").append(`
                <li class="page-item disabled">
                    <a class="page-link shadow-none">Siguiente</a>
                </li>
            `);
        }
        else {
            $("ul.pagination").append(`
                <li class="page-item">
                    <a class="page-link text-brown shadow-none" href="?page=${parseInt(pagination.page) + 1}">Siguiente</a>
                </li>
            `);
        }

    });

const dataTransfer = new DataTransfer();

$(document).ready(function () {

    wishlistValidator('#wishlist-form');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500,
        didOpen: toast => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $(document).on('click', '.ratio', function () {

        const card = this.closest('.wishlist-card');
        const id = card.id;
        window.location.href = `/wishlist?search=${id}`;

    });

    $(document).on('click', '.create-wishlist', function () {

        dataTransfer.clearData();

        const modal = document.getElementById('wishlist-modal');
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        document.getElementById('wishlist-form').setAttribute('operation', 'create');
        document.getElementById('wishlist-modal-label').innerHTML = 'Agregar lista de deseos';
        document.getElementById('image-list').innerHTML = '';
        document.getElementById('images').value = '';
        document.getElementById('wishlist-name').value = '';
        document.getElementById('wishlist-description').value = '';
        document.getElementById('wishlist-visible').value = '';

    });

    $(document).on('click', '.update-wishlist', function () {

        dataTransfer.clearData();
        document.getElementById('images').value = '';

        const card = this.closest('.wishlist-card');
        const id = card.id;

        fetch(`/api/v1/wishlists/${id}`)
            .then(response => response.json())
            .then(result => {
                const modal = document.getElementById('wishlist-modal');
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();

                document.getElementById('wishlist-form').setAttribute('operation', 'update');
                document.getElementById('wishlist-modal-label').innerHTML = 'Actualizar lista de deseos';
                document.getElementById('wishlist-name').value = result.name;
                document.getElementById('wishlist-description').value = result.description;
                document.getElementById('wishlist-visible').value = result.visible;

                wishlistId = id;

                $('#image-list').html('');
                result.images.forEach(async function (image) {

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
                })
            });
    });

    $(document).on('click', '.delete-wishlist', function () {

        const card = this.closest('.wishlist-card');
        const wishlistId = card.id;

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro que deseas eliminar esta lista de deseos?, esta acción es irreversible',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#DD3333',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) {

                $.ajax({
                    url: `api/v1/wishlists/${wishlistId}`,
                    method: 'DELETE',
                    success: function (response) {

                        fetch(`api/v1/users/${id}/wishlists`)
                            .then(response => response.json())
                            .then(response => {
                                $('#wishlist-container').empty();
                                const html = template(response);
                                $('#wishlist-container').append(html);
                                var carouselsDOM = document.querySelectorAll('.carousel');
                                carouselsDOM.forEach(carouselDOM => {
                                    var carousel = new bootstrap.Carousel(carouselDOM);
                                    carousel.cycle();
                                });
                            });

                        Toast.fire({
                            icon: 'success',
                            title: 'Tu lista de deseos ha sido eliminada'
                        });
                    }
                });
            }
        });
    });


    var wishlistId;

    // Agregar Listas de deseos
    var imageCounter = 0;

    $('#images-transfer').on('change', function (e) {

        const files = this.files;
        const filesArray = Array.from(files);

        filesArray.forEach(file => {

            let fileReader = new FileReader();
            fileReader.onload = e => {
                $('#image-list').append(/*html*/`
                    <span class="position-relative d-inline-block" id="image-${imageCounter}">
                        <button type="button" class="btn btn-outline-info bg-dark image-close border-0 rounded-0 shadow-sm text-light position-absolute">&times;</button>
                        <img class="product-mul" src="${e.target.result}">
                    </span>
                `);
            }

            fileReader.readAsDataURL(file);
            dataTransfer.items.add(file);

        });
        
        document.getElementById('images').files = dataTransfer.files;
        this.value = '';
    });

    // Eliminar una imagen
    $(document).on('click', '.image-close', function (event) {

        event.preventDefault();

        const imageList = document.getElementById('image-list');
        // Devuelve el indice de un elemento con respecto a su nodo padre
        const index = Array.from(imageList.children).indexOf(this.parentNode);

        dataTransfer.items.remove(index);
        this.parentNode.remove();

        document.getElementById('images').files = dataTransfer.files;

    });

    $('#wishlist-image').on('change', function (e) {

        let reader = new FileReader();
        reader.readAsDataURL($(this)[0].files[0]);

        // A PARTIR DE AQUI ES TEST PARA VALIDAR QUE SOLO SE INGRESEN IMAGENES
        var filePath = $('#wishlist-image').val();

        // Allowing file type
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

        if (!allowedExtensions.exec(filePath)) {
            //alert('Invalid file type' + fileInput.value);
            fileInput.value = '';

            reader.onloadend = function (e) {
                let img = document.getElementById('picture-box');
                img.setAttribute('src', 'Assets/blank-profile-picture.svg');
                img.style.opacity = '1';
                photo.style.opacity = '1';
            };

            return;
        }
        // AQUI TERMINA LA VALIDACION PARA EL TIPO DE IMAGEN

        reader.onloadend = function (e) {
            let img = $('#picture-box');
            img.attr('src', e.target.result);
        };
    });

    $('#wishlist-form').submit(function (event) {

        event.preventDefault();

        let validations = $(this).valid();
        if (!validations) {
            return;
        }

        const modal = document.getElementById('wishlist-modal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        if (this.getAttribute('operation') === 'create') {

            $.ajax({
                method: 'POST',
                url: `/api/v1/wishlists`,
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (response, status, headers) {
                    fetch(`api/v1/users/${id}/wishlists?page=${page}`)
                        .then(response => response.json())
                        .then(response => {
                            $('#wishlist-container').empty();
                            const html = template(response.wishlists);
                            $('#wishlist-container').append(html);
                            var carouselsDOM = document.querySelectorAll('.carousel');
                            carouselsDOM.forEach(carouselDOM => {
                                var carousel = new bootstrap.Carousel(carouselDOM);
                                carousel.cycle();
                            });
                        });

                    Toast.fire({
                        icon: 'success',
                        title: 'Tu lista de deseos se ha guardado'
                    });
                },
                error: function (jqXHR, status, error) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Hubo un error...'
                    });
                },
                complete: function () {
                }
            });
        }
        else if (this.getAttribute('operation') === 'update') {

            $.ajax({
                method: 'PUT',
                url: `/api/v1/wishlists/${wishlistId}`,
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function (response, status, headers) {

                    fetch(`api/v1/users/${id}/wishlists?page=${page}&count=${count}`)
                        .then(response => response.json())
                        .then(response => {
                            $('#wishlist-container').empty();
                            const html = template(response.wishlists);
                            $('#wishlist-container').append(html);
                            var carouselsDOM = document.querySelectorAll('.carousel');
                            carouselsDOM.forEach(carouselDOM => {
                                var carousel = new bootstrap.Carousel(carouselDOM);
                                carousel.cycle();
                            });
                        });

                    Toast.fire({
                        icon: 'success',
                        title: 'Tu lista de deseos se ha actualizado'
                    });
                },
                error: function (jqXHR, status, error) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Hubo un error...'
                    });
                }
            });
        }
    })
});
