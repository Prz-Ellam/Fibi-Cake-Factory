import { getSession } from './utils/session.js';
const id = getSession();

function ProductCard(product)
{
    var fmt = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    return /*html*/`
    <div class="col-lg-4 col-md-6 col-sm-12 text-center p-5" id="${product.id}">
        <a href="/product?search=${product.id}"><img src="api/v1/images/${product.images[2]}" class="img-fluid p-3"></a>
        <h5 class="fw-bold text-brown mb-0">${(product.is_quotable === 0) ? fmt.format(product.price) : 'Cotizable'}</h5>
        <p class="text-brown">${product.name}</p>
        <div class="d-flex justify-content-center">
            <a href="/update-product?search=${product.id}" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
            <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-product">Eliminar</a>
        </div>
    </div>
    `;
}

$.ajax({
    url: `/api/v1/users/${id}/products/approved`,
    method: 'GET',
    timeout: 0,
    async: false,
    success: function(response) {
        response.forEach(product => {
            $('#products-container').append(ProductCard(product));
        });
    }
});

$('body').removeClass('d-none');

$(document).ready(function() {

    $("#main-tab li a").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
        const type = $(this).attr('value');

        var url;
        switch(type)
        {
            case 'approved':
                url = `/api/v1/users/${id}/products/approved`
                break;
            case 'pending':
                url = `/api/v1/users/${id}/products/pending`
                break;
            case 'denied':
                url = `/api/v1/users/${id}/products/denied`
                break;
        }

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#products-container').empty();
                response.forEach(product => {
                    $('#products-container').append(ProductCard(product));
                });
            }
        });

    });

    var element;

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

    $('#btn-delete-product').click(function(e) {

        const obj = element.parent().parent();
        const id = $(obj).attr('id');
        obj.remove();

        $.ajax({
            url: `/api/v1/products/${id}`,
            method: 'DELETE',
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Tu producto ha sido eliminado'
                });
            }
        });

    });

    $(document).on('click', '.btn-red', function() {
        element = $(this);
    })

});