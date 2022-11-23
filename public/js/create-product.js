import { createProductValidator } from './validators/create-product-validator.js';
import { getSession } from './utils/session.js';
import { createCategoryValidator } from './validators/create-category-validator.js';
const id = getSession();

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

const imageDataTransfer = new DataTransfer();
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
                <span class="position-relative">
                    <video class="product-mul" controls>
                        <source src="${e.target.result}">
                    </video>
                </span>
                <button type="button" class="btn bg-dark btn-outline-info video-close border-0 rounded-0 shadow-sm text-light">&times;</button>
                `);
        };

    });

    $(document).on('click', '.video-close', function(event) {

        $('#video-place').html('');
        document.getElementById('video').value = '';

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
            url: '/api/v1/categories',
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
            url: '/api/v1/products',
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);

                if (response.status) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
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
});