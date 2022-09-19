const productCard = /*html*/`
    <div class="col-lg-4 col-md-6 col-sm-12 text-center p-5">
        <a href="/product"><img src="assets/img/E001S000032.jpg" class="img-fluid p-3"></a>
        <h5 class="fw-bold text-brown mb-0">$298.00</h5>
        <p class="text-brown">Tentación de frutas</p>
        <div class="d-flex justify-content-center">
            <a href="/edit-product" class="btn btn-blue shadow-none rounded-1 me-1">Editar</a>
            <a href="#" class="btn btn-red shadow-none rounded-1" data-bs-toggle="modal" data-bs-target="#delete-product">Eliminar</a>
        </div>
    </div>
`;

for (let i = 0; i < 12; i++) $('#products-container').append(productCard);

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

        element.parent().parent().remove();

        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido eliminado'
        });

    });

    $('.btn-red').click(function() {
        element = $(this);
    })

});