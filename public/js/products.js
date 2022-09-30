$.ajax({
    url: 'api/v1/session',
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

const productCard = /*html*/`
    <div class="col-lg-4 col-md-6 col-sm-12 text-center p-5">
        <a href="/product"><img src="assets/img/E001S000032.jpg" class="img-fluid p-3"></a>
        <h5 class="fw-bold text-brown mb-0">$298.00</h5>
        <p class="text-brown">Tentación de frutas</p>
        <div class="d-flex justify-content-center">
            <a href="/update-product" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
            <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-product">Eliminar</a>
        </div>
    </div>
`;

function ProductCard(product)
{
    var fmt = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });

    return /*html*/`
    <div class="col-lg-4 col-md-6 col-sm-12 text-center p-5" id="${product.id}">
        <a href="/product?search=${product.id}"><img src="api/v1/images/${product.images[2]}" class="img-fluid p-3"></a>
        <h5 class="fw-bold text-brown mb-0">${fmt.format(product.price)}</h5>
        <p class="text-brown">${product.name}</p>
        <div class="d-flex justify-content-center">
            <a href="/update-product?search=${product.id}" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
            <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-product">Eliminar</a>
        </div>
    </div>
    `;
}

$.ajax({
    url: "api/v1/session",
    method: "GET",
    timeout: 0,
    success: function(response) {
        console.log(response.id);

        $.ajax({
            url: `/api/v1/users/${response.id}/products`,
            method: 'GET',
            timeout: 0,
            success: function(response)
            {
                response.forEach(function(product) {
                    $('#products-container').append(ProductCard(product));
                });
            }
        });

    }
});


$(document).ready(function() {

    $("#main-tab li a").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
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
            timeout: 0,
            success: function(response)
            {
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